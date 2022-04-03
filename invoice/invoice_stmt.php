<?php
//******************************************************************************
//  Assemble Invoice Statement Info :                       invoice_stmt.php   *
//                                                                             *
//  This module is included in:  invoice.php                                   *
//                               invoiceall.php                                *
//  This module is linked from:                                                *
//  This module links to      :  none                                          *
//                                                                             *
//  This module includes      :  none                                          *
//                                                                             *
//******************************************************************************
//ModLog:                                                                      *
//*******                                                                      *
//2005-10-14: New module.                                                      *
//2008-09-13: Show amount on deposit                                           *
//******************************************************************************


//*The Statement Info.   ...(don't include "un-processed" invoices - they don't count just yet).
//*** THE SCHEME FOR BUILING AN ACCURATE PREVIOUS BALANCE WITHOUT RECORDING IT ***
//the TIMING rules:
//1. ALL Open invoices, regardless of date. Except This ONE!
//2. ALL payments to THOSE invoices, but NONE from TODAY.
//Payments: the TIMING Rules:
//1. ALL payments since(incl of) the date of the last invoice, up to yesterday.
//   same theory. Any payments received today -DIDN'T HAPPEN. (except ppd, in case there is
//   an open invoice from earlier today, where the ppd would have reduced the amount & balance).
//  this allows the case of the possibility of >1 invoice today even if ther were payments today
//  to accurately show payments since the last invoice/stmt without trying to sequence the events
//  of today with multiple invoices and payments posted.
//When the next invoice is produced, it will include the payments ON THE SAME DAY as this
//  previous inv/stmt, therefore none will be missed.
//  and the closing<->opening balances should link.

//per the TIMING Rules above...

//The Prior Balance = ...
//1. (+)All open invoices < this invoice no.
//2. (-)All receipts against these, if date < this invoicedate. (incl ppd of this day)
//3. (+)Receipts since last stmt, to PAID invoices, INCLUDING payments on prev stmt date.

//Current payments = ...
//1. All receipts since last stmt, including that day. (except ppd b/c they are shown on invoice)

//Credits = ...
//Step 1. Credit invoices, since last stmt.

$stmt_date = $invhdr["date"];
$where  = "(printed='Y' or posted='Y' or delivered='Y')
           and  acctno='$acctno'
           and  id<'$invoiceno'
           and  subtotal > 0";
//*find last stmt, disregard credit and cancelled invoices.


$sql            = "select max(id) as last_invoiceno from invoicehdr where ($where)";
//echo $sql;
$ri             = mysqli_query($mycon,$sql);
$maxid          = mysqli_fetch_array($ri);
$last_invoiceno = $maxid["last_invoiceno"];
//*we'll need the rest of it too.

$sql            = "select * from invoicehdr where id='$last_invoiceno'";
$ri             = mysqli_query($mycon,$sql);
$lastinvhdr     = mysqli_fetch_array($ri);

$last_invoice_date = $lastinvhdr["date"];
$lastinv_total  = round($lastinvhdr["subtotal"]
                      + $lastinvhdr["fsamount"]
                      + $lastinvhdr["tax1amount"]
                      + $lastinvhdr["tax2amount"]
                      + $lastinvhdr["tax3amount"]
                      + $lastinvhdr["tax4amount"]
                      + $lastinvhdr["tax5amount"],2);



//*we'll also need the ppd amount for this prev invoice if there was any.
if ($last_invoice_date != null){
$ppd_on_lastinvoice = 0;
$rc = mysqli_query($mycon,"select * from cashreceipts  where invoiceno='$last_invoiceno'  and  ppd='Y'");

while($cashrcpt = mysqli_fetch_array($rc)){
  $ppd_on_lastinvoice += $cashrcpt["applied"];
}

}

$lastinv_total = $lastinv_total - $ppd_on_lastinvoice;


//*Calculating Opening Balance....
//step1: Get all the Open invoices for this customer, PRIOR TO THE LAST STMT.
$where  = "(printed='Y' or posted='Y' or delivered='Y')
           and acctno='$acctno'
           and  id<'$last_invoiceno'
           and paid<>'Y'";

$sql = "select * from invoicehdr where ($where) order by id";
$ri = mysqli_query($mycon,$sql);
$oi_tally          = 0;
$oi_pymts          = 0;
//$cr_tally_pre_last = 0;
                                                       //$coi=mysqli_num_rows($ri);
for ($n=0; $n<mysqli_num_rows($ri); $n++) {
 $xinvhdr = mysqli_fetch_array($ri);
 $xinvoiceno = $xinvhdr["id"];
 //* tally for the invoice value.
 $xinvoice_total = round($xinvhdr["subtotal"]
                       + $xinvhdr["fsamount"]
                       + $xinvhdr["tax1amount"]
                       + $xinvhdr["tax2amount"]
                       + $xinvhdr["tax3amount"]
                       + $xinvhdr["tax4amount"]
                       + $xinvhdr["tax5amount"],2);

  $oi_tally = $oi_tally + $xinvoice_total;


 //*Calculating Opening Balance....
 //*Step 2: get all cash receipts THAT PART-PAY each of these UnPaid invoices,
 //         provided they are dated < today.  (NOT = today)
 //         Tally ALL the payments (total against these invoices)
 $rc = mysqli_query($mycon,"select * from cashreceipts where invoiceno='$xinvoiceno'
                                           and  date<'$last_invoice_date'");

 for ($c = 0; $c < mysqli_num_rows($rc); $c++) {
  $cashrcpt = mysqli_fetch_array($rc);
  //minor exception: we'll take a ppd receipt ON the stmt date,
  //                 as this would have reduced the o/s amount on the last stmt,
  //                 so we need to include it to have the prev.bal link back.
   $oi_pymts = $oi_pymts + $cashrcpt["applied"];
                                                                   //$cra=$cashrcpt["applied"];
   }
 mysqli_free_result($rc); //cashreceipts
 }//*for loop thru invoices
mysqli_free_result($ri); //invoices


//*Calculating Opening Balance....
//*Step 3: Get the invoices that were o/s then BUT HAVE SINCE BEEN PAID.
//         Pickup all the payments since last invoice/stmt that caused
//         invoices that were o/s then to be Fully-Paid.
//Note: Exclude Ppd cashrcpts as they have already been shown with the original invoice.
//      Only show cashrcpts "Received Since".
$rc = mysqli_query($mycon,"select * from cashreceipts, invoicehdr where
                                               cashreceipts.invoiceno=invoicehdr.id
                                          and  cashreceipts.acctno='$acctno'
                                          and  invoicehdr.paid='Y'
                                          and  cashreceipts.date >='$last_invoice_date'
                                          and  cashreceipts.invoiceno<'$last_invoiceno'
                                          and  cashreceipts.ppd != 'Y'");
$paid_to_paidinv_since_lastinv = 0;
for ($c = 0; $c < mysqli_num_rows($rc); $c++) {
 $cashrcpt = mysqli_fetch_array($rc);
 $paid_to_paidinv_since_lastinv  = $paid_to_paidinv_since_lastinv  + $cashrcpt["applied"];
 }
mysqli_free_result($rc);

//*Calculating "Payments Received Since Last Stmt"
//Step 4: Get ALL payments since last stmt.
$rc = mysqli_query($mycon,"select * from cashreceipts where
                                               acctno='$acctno'
                                          and  date >='$last_invoice_date'
                                          and  date <'$stmt_date'
                                          and  cashreceipts.ppd != 'Y'");
$curr_pymts = 0;
for ($c = 0; $c < mysqli_num_rows($rc); $c++) {
 $cashrcpt = mysqli_fetch_array($rc);
 $curr_pymts  = $curr_pymts  + $cashrcpt["applied"];
 }
mysqli_free_result($rc);


//*Step 5: Credit Invoices for THIS Stmt, Since the last Invoice.
$where  = "(printed='Y' or posted='Y' or delivered='Y')
           and acctno='$acctno'
           and id>'$last_invoiceno'
           and  id<'$invoiceno'
           and subtotal < 0";
$sql = "select * from invoicehdr where ($where) ";
$rh2  = mysqli_query($mycon,$sql); //*** don't use $rh  -  it's already being used in the loop in invoiceall
$curr_credits = 0;                                    //$ccr=mysqli_num_rows($rh2);
for ($i = 0; $i < mysqli_num_rows($rh2); $i++) {
 $crinvhdr     = mysqli_fetch_array($rh2);
 $curr_cr_inv_total  = round($crinvhdr["subtotal"]
                          + $crinvhdr["fsamount"]
                          + $crinvhdr["tax1amount"]
                          + $crinvhdr["tax2amount"]
                          + $crinvhdr["tax3amount"]
                          + $crinvhdr["tax4amount"]
                          + $crinvhdr["tax5amount"],2);
 $curr_credits = $curr_credits + $curr_cr_inv_total;
 }
mysqli_free_result($rh2);


//Step 6: Tally the amount on Deposit
//Get only those paymts against invoice=0 BEFORE the last invoice...
//... so they're not included twice since they would be in current paymts.

$sql = "select * from cashreceipts where acctno='$acctno'
                                         and invoiceno=0
                                         and  date <'$last_invoice_date'";
$rc  = mysqli_query($mycon,$sql);
$deposits = 0;
for ($i = 0; $i < mysqli_num_rows($rc); $i++) {
 $cashrcpt = mysqli_fetch_array($rc);
 $deposits = $deposits + $cashrcpt["applied"];
}
mysqli_free_result($rc); //cashreceipts



//*FinalStep: The Values
//echo $oi_tally.'--'.$oi_pymts.'--'.$paid_to_paidinv_since_lastinv.'--'.$lastinv_total.'--'.$deposits;
$prev_bal   = $oi_tally - $oi_pymts + $paid_to_paidinv_since_lastinv + $lastinv_total -$deposits;

$pymts_curr = $curr_pymts*-1;
$amt_due    = $prev_bal + $pymts_curr + $inv_balance + $curr_credits;

$prev_bal_fmt   = sprintf("%01.2f",$prev_bal);
$pymts_curr_fmt = sprintf("%01.2f",$pymts_curr);
$credits_fmt    = sprintf("%01.2f",$curr_credits);
$amt_due_fmt    = sprintf("%01.2f",$amt_due);

// showrow(array("last_invoiceno                ",$last_invoiceno."<br>"),$inputfmd);                //++++++++++++++
// showrow(array("oi_tally                      ",$oi_tally."<br>"),$inputfmd);                      //++++++++++++++
// showrow(array("oi_pymts                      ",$oi_pymts."<br>"),$inputfmd);                      //++++++++++++++
// showrow(array("paid_to_paidinv_since_lastinv ",$paid_to_paidinv_since_lastinv."<br>"),$inputfmd); //++++++++++++++
// showrow(array("lastinv_total                 ",$lastinv_total."<br>"),$inputfmd);                 //++++++++++++++
// showrow(array("pymts_curr                    ",$pymts_curr."<br>"),$inputfmd);                    //++++++++++++++
// showrow(array("prev_bal                      ",$prev_bal."<br>"),$inputfmd);                      //++++++++++++++
// showrow(array("inv_balance                   ",$inv_balance."<br>"),$inputfmd);                   //++++++++++++++
// showrow(array("curr_credits                  ",$curr_credits."<br>"),$inputfmd);                  //++++++++++++++
// showrow(array("amt_due                       ",$amt_due."<br>"),$inputfmd);                       //++++++++++++++


?>
