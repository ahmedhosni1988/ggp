<?php
session_start();


include("../../setting.php");
include("../../" . STYLE . "/consoletemp.php");
include("../../" . STYLE . "/worktemp.php");
include("../../".STYLE."/accountingtemp.php");

include("../../classes/console.php");
include("../../classes/account.php");
include("../../classes/package.php");
include("../../classes/invoices.php");
include("../../classes/price.php");
include("../../classes/company.php");

include("../../classes/payment.php");

$newtemp = new template();
$account = new account($db);
$package = new package($db);
$invClass = new invoices($db);
$priceClass = new price($db);
$companyClass = new company($db);
$paymentClass = new payment($db);


if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}

if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == 1 && $_SESSION['status'] == 2) {
    $open = "accounting";
    switch ($action) {

case 'discount_req':

    {
        if (isset($_POST['invoiceid'])&&isset($_POST['amount'])) {
            $invoiceid=$_POST['invoiceid'];
            $amount=$_POST['amount'];
            $query=mysqli_query($mycon, "select * from invoicehdr  where id='".$invoiceid."'") or die(mysqli_error($mycon));

            if ($query) {
                $return = mysqli_fetch_array($query);
                if ($return['subtotal'] > $amount) {
                    $update = false;
                    if ($return['discount_value'] != 0) {
                        $update = true;
                    }
                    $query = mysqli_query($mycon, "Update invoicehdr Set discount_value='" . $amount . "' where id='" . $invoiceid . "'") or die(mysqli_error($mycon));
                    if ($query) {
                        $date_added = date("Y-m-d H:i:s");
                        if ($update) {
                            $query = mysqli_query($mycon, "Update  credit_note set user_id='" . $_SESSION['user_id'] . "', credit_value ='" . $amount . "'  ,date_edit='" . $date_added . "', edit_user='" . $_SESSION['user_id'] . "' where invoice_id ='" . $invoiceid . "'  ") or die(mysqli_error($mycon));
                            $date = date("Y-m-d");
                            $query = mysqli_query($mycon, "Update cashreceipts set pymt_amount='" . $amount . "' ,date='" . $date . "' where invoiceno='" . $invoiceid . "' ") or die(mysqli_error($mycon));
                            if ($query) {
                                echo "تم تعديل الخصم";
                            } else {
                                echo "حاول لاحقاً";
                            }
                        } else {
                            $query = mysqli_query($mycon, "select * from invoicehdr  where id='" . $invoiceid . "'") or die(mysqli_error($mycon));
                            $clid = mysqli_fetch_array($query)['clid'];
                            $query = mysqli_query($mycon, "insert into credit_note (user_id,credit_value,account_id,invoice_id,date_added,credit_type) values ('" . $_SESSION['user_id'] . "','" . $amount . "','" . $clid . "','" . $invoiceid . "','" . $date_added . "' , '2' )") or die(mysqli_error($mycon));
                            if (mysqli_insert_id($mycon)) {
                                $credit_note_id = mysqli_insert_id($mycon);
                                $date = date("Y-m-d");
                                $query = mysqli_query($mycon, "insert into cashreceipts  (clid,date,invoiceno,user_id,creditnote_id,pymt_amount,system_date) 
                                    values ('" . $clid . "','" . $date . "','" . $invoiceid . "','" . $_SESSION['user_id'] . "','" . $credit_note_id . "','" . $amount . "' , '".date('Y-m-d H:i:s')."' )") or die(mysqli_error($mycon));
                                if (mysqli_insert_id($mycon)) {
                                    echo "تم إضافة الخصم";
                                } else {
                                    echo "حاول لاحقاً";
                                }
                            }
                        }
                    }
                } else {
                    echo "الخصم أكبر من قيمة الفاتور ة";
                }
            }
        }
    }
break;
        

case 'revise_account':
    {
        if (!isset($_POST['client'])) {
            $acc = $account->get_all_accounts(1);
            $newtemp->load_template('revise_account', 1, 'accounting_menu');
        } else {
            $con =   mysqli_connect(HOSTNAME, DBUSER, DBPASS, DBNAME) or die("error in connection");
            mysqli_query($con, "SET NAMES utf8");
            mysqli_query($con, "SET CHARACTER SET utf8");
            $qq = mysqli_query($con, 'CALL cal_account('.$_POST['client'].',\''.$_POST['revise_date_form'].' 00:00:00\',\''.$_POST['revise_date_to'].' 23:59:59\');') or die("calc price2".mysqli_error($con));

            while ($row=mysqli_fetch_assoc($qq)) {
                $table[] = $row;
//                 $table[$index]['date']=$row['date'];
//                 $table[$index]['statement']=$row['paymethod'];
//                 $table[$index]['debit']=$row['pymt_amount'];
//                 $table[$index]['credit']=0;
//                 $table[$index]['payment_approval']=$row['id'];
//                 $sql="Select * from invoicehdr where clid='".$_POST['client']."' and `date` ='".$row['date']."'";
// //                echo $sql;
//                 $invoices=mysqli_query($mycon,$sql) or die (mysqli_error($mycon));
//                 $innerLoopindex=0;
//                 while($invoice=mysqli_fetch_assoc($invoices))
//                 {
//                     if($innerLoopindex>0)
//                     {
//                         $index++;
// //                        echo $innerLoopindex;
//                         $table[$index]['date']=$row['date'];
//                         $table[$index]['statement']=$row['paymethod'];
//                         $table[$index]['debit']=$row['pymt_amount'];
//                         $table[$index]['credit']=0;
//                         $table[$index]['payment_approval']=$row['id'];
//                     }

//                     $table[$index]['orderNo']=$invoice['easy_order_id'];
//                     $table[$index]['credit']+=$invoice['subtotal'];
//                     $sql = "select out_orders.*, account.account_company from  out_orders
//                     inner join account on (account.account_id = out_orders.account_id)
//                     join orders_package on find_in_set(orders_package.id, out_orders.items) > 0
//                     where orders_package.order_id = '".$invoice['easy_order_id']."'  group by out_orders.id,account.account_company";
// //                    echo $sql;
//                     $query=mysqli_query($mycon,$sql) or die (mysqli_error($mycon));
//                     $outOrder=mysqli_fetch_assoc($query);
//                     $table[$index]['outOrder']="".$outOrder['id'];
//                     while ($outOrder=mysqli_fetch_assoc($query))
//                     {
//                         $table[$index]['outOrder'].=",".$outOrder['id'];
//                     }
//                     $innerLoopindex++;
//                 }

//                 $index++;
            }


            mysqli_free_result($qq);
            mysqli_close($con);


//             $table=array();
//             $index=0;
//             $sql="Select * from cashreceipts where  clid='".$_POST['client']."' and `date` between '".$_POST['from']."'
//              and '".$_POST['to']."' order by date ASC ";
            // //            echo $sql;
//             $rows=mysqli_query($mycon,$sql) or die (mysqli_error($mycon));
//             while($row=mysqli_fetch_assoc($rows))
//             {
//                 $table[$index]['date']=$row['date'];
//                 $table[$index]['statement']=$row['paymethod'];
//                 $table[$index]['debit']=$row['pymt_amount'];
//                 $table[$index]['credit']=0;
//                 $table[$index]['payment_approval']=$row['id'];
//                 $sql="Select * from invoicehdr where clid='".$_POST['client']."' and `date` ='".$row['date']."'";
            // //                echo $sql;
//                 $invoices=mysqli_query($mycon,$sql) or die (mysqli_error($mycon));
//                 $innerLoopindex=0;
//                 while($invoice=mysqli_fetch_assoc($invoices))
//                 {
//                     if($innerLoopindex>0)
//                     {
//                         $index++;
            // //                        echo $innerLoopindex;
//                         $table[$index]['date']=$row['date'];
//                         $table[$index]['statement']=$row['paymethod'];
//                         $table[$index]['debit']=$row['pymt_amount'];
//                         $table[$index]['credit']=0;
//                         $table[$index]['payment_approval']=$row['id'];
//                     }

//                     $table[$index]['orderNo']=$invoice['easy_order_id'];
//                     $table[$index]['credit']+=$invoice['subtotal'];
//                     $sql = "select out_orders.*, account.account_company from  out_orders
//                     inner join account on (account.account_id = out_orders.account_id)
//                     join orders_package on find_in_set(orders_package.id, out_orders.items) > 0
//                     where orders_package.order_id = '".$invoice['easy_order_id']."'  group by out_orders.id,account.account_company";
            // //                    echo $sql;
//                     $query=mysqli_query($mycon,$sql) or die (mysqli_error($mycon));
//                     $outOrder=mysqli_fetch_assoc($query);
//                     $table[$index]['outOrder']="".$outOrder['id'];
//                     while ($outOrder=mysqli_fetch_assoc($query))
//                     {
//                         $table[$index]['outOrder'].=",".$outOrder['id'];
//                     }
//                     $innerLoopindex++;
//                 }

//                 $index++;

//             }
            $newtemp->load_template('show_revise_account', 5);
        }

    }
break;


case 'show_invoice':
    
    $ch = curl_init(SITEURL."/administrator/invoicing/index.php?id=".$_GET['invoiceid']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    $content = curl_exec($ch);
    curl_close($ch);
    echo $content;

break;

case 'reviewed_invoice':
echo'ahmed' ;
break;


case 'view_cashreceipts':
$where = " 1 = 1 ";

if (isset($_SESSION["billing_code"]) && $_SESSION["billing_code"] > "0") {
    $where .= " and billing_code = '".$_SESSION["billing_code"] ."'  ";
}

if ($_SESSION["account_accounting_id"]) {
    $where .= " and clid =".$_SESSION["account_accounting_id"].' ';
}
$sql="cashreceiptslist where ".$where;
// echo $sql;
$acc =$db->get_table($sql);
     
    // if($_SESSION["billing_code"] == 2 ){
    // 	// echo'test1';
    // 	$acc = $account->get_all_accounts(1,$_SESSION["billing_code"]);

    // }else{
    // 	// echo'test2';
    // 	$acc = $account->get_all_accounts(1);
    // }
    $payment_type = $account->payment_type();
    $newtemp->load_template('view_cashreceipts', 5);

break;

case 'cash':

    $acc = $account->get_all_accounts(1, $_SESSION["billing_code"]);

        $payment_type = $account->payment_type();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data=$_POST;
        if (isset($_POST['cash_id']) && $_POST['cash_id']!='') {
            $sql='`cashreceipts`  WHERE `id` ='.$_POST['cash_id'];
            $oldCash= $db->get_table($sql);
                
            if ($oldCash[0]['pymt_amount'] > $_POST['pymt_amount']) {
                mysqli_query($mycon, 'UPDATE `account` SET `credit_hold` = credit_hold-'.($oldCash[0]['pymt_amount']-$_POST['pymt_amount']).' WHERE `account_id` ='.$_POST['clid']);
            // echo 'الجديد اصغر';
            } elseif ($oldCash[0]['pymt_amount'] < $_POST['pymt_amount']) {
                mysqli_query($mycon, 'UPDATE `account` SET `credit_hold` = credit_hold+'.($_POST['pymt_amount']-$oldCash[0]['pymt_amount']).' WHERE `account_id` ='.$_POST['clid']);
                // echo 'الجديد اكبر';
            }
            unset($data['cash_id']);

            $data['system_date'] = date('Y-m-d H:i:s');
            // var_dump($data);
            $s=$db->make_update("cashreceipts", $data, 'id', $_POST['cash_id']);
            //  echo$s;
            mysqli_query($mycon, $s);
            echo 'تمت التعديل بنجاح';
        } else {
            $newtemp->load_template('cash', 5);
        }
    } else {
        $newtemp->load_template('cash', 5);
    }
break;

case 'cashreceipts':

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['clid'] =='' ||  $_POST['pymt_amount'] =='')) {
        echo 'ادخل كل البيانات';
    } elseif (isset($_POST['clid']) && $_POST['clid'] !=='') {
        if (is_numeric($_POST['pymt_amount'])) {
            $_POST['system_date']=date("Y-m-d H:i:s");
            $_POST['user_id']=$_SESSION['user_id'];
            $_POST['ppd']='N';
            //$_POST['serialno'] =

            $_POST['date'] = date('Y-m-d H:i:s');
            $sql = make_insert("cashreceipts", $_POST);
            // echo $sql;
            mysqli_query($mycon, $sql);
            mysqli_query($mycon, 'UPDATE `account` SET `credit_hold` = credit_hold+'.$_POST['pymt_amount'].' WHERE `account_id` ='.$_POST['clid'].' ');
    
            $re = mysqli_query($mycon, 'select cashreceipts.*,account.account_company,payment_type.payment_name from `cashreceipts`  
		inner join account on (cashreceipts.clid = account.account_id)
		inner join payment_type on (payment_type.payment_id = cashreceipts.paymethod)
		WHERE account.account_id = '.$_POST['clid'].' and cashreceipts.`clid` ='.$_POST['clid'].' ORDER BY id DESC LIMIT 1 ')  or die(mysqli_error($mycon));
            $data =  mysqli_fetch_array($re);
        

            $temp = template_cashrecipt_print();
            echo $temp;
        //echo json_encode($res);
        } else {
            echo 'مبلغ الوصل غير صحيح';
        }
    } else {
        $acc = $account->get_all_accounts(1, $_SESSION["billing_code"]);

     
        $payment_type = $account->payment_type();
        $newtemp->load_template('cashreceipts', 1, 'accounting_menu');
    }
break;


case 'cashreceipts_print':

    if (isset($_POST['id'])) {
        $re = mysqli_query($mycon, 'select cashreceipts.*,account.account_company,payment_type.payment_name from `cashreceipts`  
		inner join account on (cashreceipts.clid = account.account_id)
		inner join payment_type on (payment_type.payment_id = cashreceipts.paymethod)
		WHERE  cashreceipts.id ='.$_POST['id'].' ORDER BY id DESC LIMIT 1 ')  or die(mysqli_error($mycon));
        
        $data =  mysqli_fetch_array($re);
        

        $temp = template_cashrecipt_print();
        echo $temp;
    //echo json_encode($res);
    } else {
        echo 'Error';
    }
break;




case 'cash_receipts':
    
if (isset($_POST['account_id'])) {
    $inv = $invoices->get_unpaid_invoices($_POST['account_id']);
    $acc = $account->get_account($_POST['account_id']);
    
    
    
    
    if (isset($_GET['type']) && ($_GET['type'] == "viewpayment"  || $_GET['type'] == "commit")) {
        //echo "viewpayment";
        unset($errormsg);
        //***New rules*** Accept a payment of Zero.  May have adjusted an invoice to match a minor difference in the payment - or any other reason - need to clear it.
        if (trim($_POST['payment_amt']) == "0.00" ||  $_POST['payment_amt'] == '') {
            $anything_entered = 0;
            //prevent errors
            $applycb_elements = count($_POST['applycb']);
            $applied_elements = count($_POST['applied']);
            
            if ($applycb_elements > 0) {
                foreach ($_POST['applied'] as $cb) {
                    if (yesno($cb) == "Y") {
                        $anything_entered = 1;
                    }
                }
            }
            
            if ($applied_elements > 0) {
                foreach ($_POST['applied'] as $app) {
                    if ($app != 0) {
                        $anything_entered = 1;
                    }
                }
            }
            
            if (!$anything_entered) {
                $errormsg="Please enter a payment amount";
            }
        }
        
    
        if (trim($_POST['payment_date'] == "")) {
            $errormsg .= "<br>Please enter a payment date";
        }
        
        if ($_POST['payment_ref'] == "") {
            $errormsg .= "<br>Please enter a payment reference";
        }
    }
    
    if (isset($_GET['type']) && $_GET['type'] == "commit") {
        if ($errormsg != "") {
            $errormsg .= "<br>";
        }
        if ($_POST['payment_remaining'] != 0) {
            if ($_POST['total_applied'] == 0) {             //for those dumb enuf to just enter the chq & click apply.
                $errormsg.="Please apply the payment to one or more invoices.";
            } else {
                $errormsg.="You have an amount remaining.<br>Please adjust to fully apply the payment.";
            }
        }
        
        if (!isset($errormsg)) {
            //*** ALL OK ***  Put it AWAY ***
            //*link multiple cashreceipt records back to the first one
            $link = 0;
            //var_dump($inv);  //the +1 is to get cr's for invoice #0 - Deposits.
            for ($n=0; $n<count($inv); $n++) {
                //1. Run down the array of $applied[$n], pick the ones with an amount.
                //	echo $_POST['applied'][0];
                
                if ($_POST['applied'][$inv[$n]['id']] != "") {
                    //	echo $_POST['applied'][$inv[$n]['id']]."--".$apply;
                    //2.3.4. Create & write the CashReceipt record.
                    $invoiceno  = $inv[$n]['id'];
                    $apply      = round($_POST['applied'][$inv[$n]['id']], 2);
                    $balance    = round($inv[$n]['invoice_total'] - $inv[$n]['payments'], 2);
                    if ($invoiceno == "0") {
                        $invoiceno = 0;
                    }
        
                    $cashrec = array();
                    $cashrec["clid"]        = $acc->account_id;
                    $cashrec["acctno"]      = $acc->account_name;
                    $cashrec["ref"]         = mysqli_real_escape_string($mycon, $_POST['payment_ref']);
                    $cashrec["link"]        = $link;      //*fist record shows zero link
                    $cashrec["date"]        = $_POST['payment_date'];
                    $cashrec["paymethod"]   = $_POST['payment_method'];
                    $cashrec["pymt_amount"] = sprintf("%01.2f", $_POST['payment_amt']);
                    $cashrec["ppd"]         = "N";
                    $cashrec["invoiceno"]   = $invoiceno;
                    $cashrec["applied"]     = sprintf("%01.2f", $apply);
                    $crid = $invoices->insert_cash($cashrec);
                    
                    //* SQL - Save the CashReceipt Record.
                    if ($link == 0) {
                        $link = $crid;
                    } //*all records link back to the First record. (First record link is zero)
                    //3. NOT deposits: Set the "paid-in-full flag (if applied=balance ).  Update the record.
                    if ($invoiceno != 0) {
                        $ri = mysqli_query($mycon, "select id,payment_refs,payment_links from invoicehdr where id=$invoiceno") or die(mysqli_error($mycon));
                        $invhdr = mysqli_fetch_array($ri);
                        mysqli_free_result($ri);
                        if ($balance == $apply) {
                            $invhdr["paid"]     = "Y";
                        }
                        $invhdr["payment_refs"]  .= mysqli_real_escape_string($mycon, $payment_ref).",";
                        $invhdr["payment_links"] .= $crid.",";
                        //* SQL - Save the Invoice Header Record.
                        $invoices->update_invoice($invoiceno, $invhdr);
                    }
                } //($applied[$n] != 0)
            } //for ($n=0; $n<$rowcount; $n++)
            //5. Return to "open" console (pass all the parms back to get the same display)*
    
            
            if ($_POST['applied'][0] != "") {
                //1. Run down the array of $applied[$n], pick the ones with an amount.
                $link = 0;
            
                if ($_POST['applied'][0] != "") {
                    //	echo $_POST['applied'][$inv[$n]['id']]."--".$apply;
                    //2.3.4. Create & write the CashReceipt record.
                    $invoiceno  = "0";
                    $apply      = round($_POST['applied'][0], 2);
                    //$balance    = round($inv[$n]['invoice_total'] - $inv[$n]['payments'],2);
                    if ($invoiceno == "0") {
                        $invoiceno = 0;
                    }
            
                    $cashrec = array();
                    $cashrec["clid"]        = $acc->account_id;
                    $cashrec["acctno"]      = $acc->account_name;
                    $cashrec["ref"]         = mysqli_real_escape_string($mycon, $_POST['payment_ref']);
                    $cashrec["link"]        = $link;      //*fist record shows zero link
                    $cashrec["date"]        = $_POST['payment_date'];
                    $cashrec["paymethod"]   = $_POST['payment_method'];
                    $cashrec["pymt_amount"] = sprintf("%01.2f", $_POST['payment_amt']);
                    $cashrec["ppd"]         = "N";
                    $cashrec["invoiceno"]   = $invoiceno;
                    $cashrec["applied"]     = sprintf("%01.2f", $apply);
                    $crid = $invoices->insert_cash($cashrec);
                        
                    //* SQL - Save the CashReceipt Record.
                    if ($link == 0) {
                        $link = $crid;
                    } //*all records link back to the First record. (First record link is zero)
                    //3. NOT deposits: Set the "paid-in-full flag (if applied=balance ).  Update the record.
                } //($applied[$n] != 0)
            }
        }// NOT isset($errormsg)
    }
    
    $inv = $invoices->get_unpaid_invoices($_POST['account_id']);
    
    //$con = $contact->get_account_contact($_POST['account_id']);
    $pay = $payment->get_payment();
    
    echo $errormsg;
    $newtemp->load_template('cash_recepits_new', 5);
} else {
    $newtemp->load_template('cash_recepits', 1, 'accounting_menu');
}
break;



case 'cash_receipts_new':
    if (isset($_POST['account_id'])) {
        $acc = $account->get_account($_POST['account_id']);
        //$con = $contact->get_account_contact($_POST['account_id']);
        //$pay = $payment->get_payment();
        
        if (isset($_GET['type']) && ($_GET['type'] == "viewpayment"  || $_GET['type'] == "commit")) {
            //echo "viewpayment";
            unset($errormsg);
            //***New rules*** Accept a payment of Zero.  May have adjusted an invoice to match a minor difference in the payment - or any other reason - need to clear it.
            if (trim($_POST['payment_amt']) == "0.00" ||  $_POST['payment_amt'] == '') {
                $anything_entered = 0;
                //prevent errors
                $applycb_elements = count($_POST['applycb']);
                $applied_elements = count($_POST['applied']);
                    
                if ($applycb_elements > 0) {
                    foreach ($_POST['applycb'] as $cb) {
                        if (yesno($cb) == "Y") {
                            $anything_entered = 1;
                        }
                    }
                }
                    
                if ($applied_elements > 0) {
                    foreach ($_POST['applied'] as $app) {
                        if ($app != 0) {
                            $anything_entered = 1;
                        }
                    }
                }
                    
                if (!$anything_entered) {
                    $errormsg="Please enter a payment amount";
                }
            }
        
        
            if (trim($_POST['payment_date'] == "")) {
                $errormsg .= "<br>Please enter a payment date";
            }
        
            if ($_POST['payment_ref'] == "") {
                $errormsg .= "<br>Please enter a payment reference";
            }
        }
        
        
        
        
        
        
        $payment_ref       = "";
        $payment_amt       = 0;
        $total_applied     = 0;
        $payment_remaining = 0;
  
        $payment_ref = $_POST['payment_ref'];
        $payment_amt = $_POST['payment_amt'];
        $payment_method = $_POST['payment_method'];
        
        $where  = "(paid<>'Y' )
		and clid='".$_POST['account_id']."'";
        
        $sql = "select * from invoicehdr where ($where) order by id";
        
        //******************************************************************************
        //* Pull in the Records, one at a time in the loop                             *
        //******************************************************************************
        $ri = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));
        $rowcount = mysqli_num_rows($ri);
        $col0 = array();                  // invoice no
        $col1 = array();                  // invoice date
        $col2 = array();                  // due date
        $col3 = array();                  // invoice amount
        $col4 = array();                  // prior payments
        $col5 = array();                  // balance
        $col6 = array();                  // payit checkbox
        $col7 = array();                  // amount applied
        //the +1 is to get cr's for invoice #0 - Deposits.
        for ($n=0; $n<$rowcount+1; $n++) {
            if ($n < $rowcount) {
                $invhdr = mysqli_fetch_array($ri);
                $invoiceno = $invhdr["id"];
                $clid      = $invhdr["clid"];
            } else {
                //deposits
                $invoiceno         = 0;
                $invhdr            = array();
                $invhdr["id"]      = "Deposits";
                $invhdr["date"]    = "";
                $invhdr["duedate"] = "";
            }
            //* get all cash receipts against this invoice.
            // now need to specify acctno, b/c of invoice #0 - for deposits.
            $payments = 0;
            $rc = mysqli_query($mycon, "select * from cashreceipts where invoiceno=$invoiceno and clid='".$_POST['account_id']."'");
            for ($i = 0; $i < mysqli_num_rows($rc); $i++) {
                $cashrcpt = mysqli_fetch_array($rc);
                //if($cashrcpt['ppd'] == 'Y')
                $payments = $payments + $cashrcpt["applied"];
            }
            mysqli_free_result($rc); //cashreceipts
            //* tally for the invoice value.
            $invoice_total = round($invhdr["subtotal"]
                    + $invhdr["fsamount"]
                    + $invhdr["tax1amount"]
                    + $invhdr["tax2amount"]
                    + $invhdr["tax3amount"]
                    + $invhdr["tax4amount"]
                    + $invhdr["tax5amount"], 2);
            $balance    = $invoice_total - $payments;
            $invoice_total_fmt = sprintf("%01.2f", $invoice_total);
            $payments_fmt      = sprintf("%01.2f", $payments);
            $balance_fmt       = sprintf("%01.2f", $balance);
            if ($payments == 0) {
                $payments_fmt = "&nbsp;";
            }
            
            $col0[$n] = $invhdr["id"];
            $col1[$n] = $invhdr["date"];
            $col2[$n] = $invhdr["duedate"];
            $col3[$n] = $invoice_total_fmt;
            $col4[$n] = $payments_fmt;
            $col5[$n] = $balance_fmt;
            
            $_POST['applycb'][$n] = yesno($_POST['applycb'][$n]);
            
            if ($_POST['applycb'][$n] == "Y") {
                $_POST['applied'][$n]=$balance_fmt;
            }
            // if ($applied[$n] != 0)
            if ($_POST['applied'][$n] != "") {
                $appliedfmt = sprintf("%01.2f", $_POST['applied'][$n]);
            } else {
                $appliedfmt = "";
            }
            //if ($applied[$n] < 0  and $applycb[$n] == "Y")  $appliedfmt = "";
            
            $col7[$n] = '<input type="text" name="applied['.$n.']" value="'.(isset($_POST['applied'][$n]) ? $appliedfmt : '').'" size="10">';
            
            $_POST['applycb'][$n]="N";
            $col6[$n] = '<input type="checkbox" name="applycb['.$n.']" >';
        
            //deposits
            if ($invoiceno == 0) {
                $col3[$n] = "&nbsp;";
                $col5[$n] = "&nbsp;";
                $col6[$n] = "&nbsp;";
            }
        
            //Selecting customer for Deposit - don't show any input fields on grid.
            // (the Only one showing now, would be the Deposit row).
            if ($_POST['account_id'] == "") {
                $col6[$n] = "&nbsp;";
                $col7[$n] = "&nbsp;";
            }
        
            $total_applied = round($total_applied + $_POST['applied'][$n], 2);
        }//*for loop - build & display all the rows
        
        mysqli_free_result($ri); //invoicehdr
        
        //*accum totals
        $payment_remaining     = round($payment_amt - $total_applied, 2);
        
        $total_applied_fmt     = sprintf("%01.2f", $total_applied);
        $payment_remaining_fmt = sprintf("%01.2f", $payment_remaining);
        
        if (trim($payment_amt) != "") {
            $payment_amt_fmt = sprintf("%01.2f", $payment_amt);
        } else {
            $payment_amt_fmt="";
        }
        
        
        
        
        if (isset($_GET['type']) && $_GET['type'] == "commit") {
            if ($errormsg != "") {
                $errormsg .= "<br>";
            }
            if ($payment_remaining != 0) {
                if ($total_applied == 0) {             //for those dumb enuf to just enter the chq & click apply.
                    $errormsg.="Please apply the payment to one or more invoices.";
                } else {
                    $errormsg.="You have an amount remaining.<br>Please adjust to fully apply the payment.";
                }
            }
        
            if (!isset($errormsg)) {
                //echo "ahmed";
                //*** ALL OK ***  Put it AWAY ***
                //*link multiple cashreceipt records back to the first one
                $link = 0;             //the +1 is to get cr's for invoice #0 - Deposits.
                for ($n=0; $n<$rowcount+1; $n++) {
                    //1. Run down the array of $applied[$n], pick the ones with an amount.
                    if ($_POST['applied'][$n] != "") {
                        //2.3.4. Create & write the CashReceipt record.
                        $invoiceno  = $col0[$n];
                        $apply      = round($_POST['applied'][$n], 2);
                        $balance    = round($col5[$n], 2);
                        if ($invoiceno == "Deposits") {
                            $invoiceno = 0;
                        }
        
                        $cashrec = array();
                        $cashrec["clid"]        = $clid;
                        $cashrec["acctno"]      = $acctno;
                        $cashrec["ref"]         = mysqli_real_escape_string($mycon, $payment_ref);
                        $cashrec["link"]        = $link;      //*fist record shows zero link
                        $cashrec["date"]        = $_POST['payment_date'];
                        $cashrec["paymethod"]   = $payment_method;
                        $cashrec["pymt_amount"] = sprintf("%01.2f", $payment_amt);
                        $cashrec["ppd"]         = "N";
                        $cashrec["invoiceno"]   = $invoiceno;
                        $cashrec["applied"]     = sprintf("%01.2f", $apply);
                        //* SQL - Save the CashReceipt Record.
                        $crid = $invoices->insert_cash($cashrec);
                        if ($link == 0) {
                            $link = $crid;
                        } //*all records link back to the First record. (First record link is zero)
                        //3. NOT deposits: Set the "paid-in-full flag (if applied=balance ).  Update the record.
                        if ($invoiceno != 0) {
                            $ri = mysqli_query($mycon, "select id,payment_refs,payment_links from invoicehdr where id=$invoiceno");
                            $invhdr = mysqli_fetch_array($ri);
                            mysqli_free_result($ri);
                            if ($balance == $apply) {
                                $invhdr["paid"]     = "Y";
                            }
                            $invhdr["payment_refs"]  .= mysqli_real_escape_string($mycon, $payment_ref).",";
                            $invhdr["payment_links"] .= $crid.",";
                            //* SQL - Save the Invoice Header Record.
                            $invoices->update_invoice($invoiceno, $invhdr);
                        }
                    } //($applied[$n] != 0)
                } //for ($n=0; $n<$rowcount; $n++)
                //5. Return to "open" console (pass all the parms back to get the same display)*
            }// NOT isset($errormsg)
            
            
            $total_amount_fmt   = 0;
            $total_payments_fmt = 0;
            $total_balance_fmt  = 0;
            $total_applied_fmt  = 0;
            $total_applied = 0;
            $payment_remaining = 0;
            $payment_amt = 0;
            
            $where  = "paid<>'Y' and
		 clid='".$_POST['account_id']."'";
            
            $acc_id = $_POST['account_id'];
            $sql = "select * from invoicehdr where ($where) order by id";
            //unset($_POST);
            $_POST['account_id'] = $acc_id;
            //******************************************************************************
            //* Pull in the Records, one at a time in the loop                             *
            //******************************************************************************
            $ri = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));
            $rowcount = mysqli_num_rows($ri);
            $col0 = array();                  // invoice no
            $col1 = array();                  // invoice date
            $col2 = array();                  // due date
            $col3 = array();                  // invoice amount
            $col4 = array();                  // prior payments
            $col5 = array();                  // balance
            $col6 = array();                  // payit checkbox
            $col7 = array();                  // amount applied
            //the +1 is to get cr's for invoice #0 - Deposits.
            for ($n=0; $n<$rowcount+1; $n++) {
                if ($n < $rowcount) {
                    $invhdr = mysqli_fetch_array($ri);
                    $invoiceno = $invhdr["id"];
                    $clid      = $invhdr["clid"];
                } else {
                    //deposits
                    $invoiceno         = 0;
                    $invhdr            = array();
                    $invhdr["id"]      = "Deposits";
                    $invhdr["date"]    = "";
                    $invhdr["duedate"] = "";
                }
                //* get all cash receipts against this invoice.
                // now need to specify acctno, b/c of invoice #0 - for deposits.
                $payments = 0;
                $rc = mysqli_query($mycon, "select * from cashreceipts where invoiceno=$invoiceno and clid='".$_POST['account_id']."'");
                for ($i = 0; $i < mysqli_num_rows($rc); $i++) {
                    $cashrcpt = mysqli_fetch_array($rc);
                    $payments = $payments + $cashrcpt["applied"];
                }
                mysqli_free_result($rc); //cashreceipts
                //* tally for the invoice value.
                $invoice_total = round($invhdr["subtotal"]
                        + $invhdr["fsamount"]
                        + $invhdr["tax1amount"]
                        + $invhdr["tax2amount"]
                        + $invhdr["tax3amount"]
                        + $invhdr["tax4amount"]
                        + $invhdr["tax5amount"], 2);
                $balance    = $invoice_total - $payments;
                $invoice_total_fmt = sprintf("%01.2f", $invoice_total);
                $payments_fmt      = sprintf("%01.2f", $payments);
                $balance_fmt       = sprintf("%01.2f", $balance);
                if ($payments == 0) {
                    $payments_fmt = "&nbsp;";
                }
                    
                $col0[$n] = $invhdr["id"];
                $col1[$n] = $invhdr["date"];
                $col2[$n] = $invhdr["duedate"];
                $col3[$n] = $invoice_total_fmt;
                $col4[$n] = $payments_fmt;
                $col5[$n] = $balance_fmt;
                    
                $_POST['applycb'][$n] = yesno($_POST['applycb'][$n]);
                    
                if ($_POST['applycb'][$n] == "Y") {
                    $_POST['applied'][$n]=$balance_fmt;
                }
                // if ($applied[$n] != 0)
                if ($_POST['applied'][$n] != "") {
                    $appliedfmt = sprintf("%01.2f", $_POST['applied'][$n]);
                } else {
                    $appliedfmt = "";
                }
                //if ($applied[$n] < 0  and $applycb[$n] == "Y")  $appliedfmt = "";
                    
                $col7[$n] = '<input type="text" name="applied['.$n.']" value="'.(isset($_POST['applied'][$n]) ? $appliedfmt : '').'" size="10">';
                    
                $_POST['applycb'][$n]="N";
                $col6[$n] = '<input type="checkbox" name="applycb['.$n.']" >';
            
                //deposits
                if ($invoiceno == 0) {
                    $col3[$n] = "&nbsp;";
                    $col5[$n] = "&nbsp;";
                    $col6[$n] = "&nbsp;";
                }
            
                //Selecting customer for Deposit - don't show any input fields on grid.
                // (the Only one showing now, would be the Deposit row).
                if ($_POST['account_id'] == "") {
                    $col6[$n] = "&nbsp;";
                    $col7[$n] = "&nbsp;";
                }
                unset($_POST['applied']);
                $total_applied = round($total_applied + $_POST['applied'][$n], 2);
            }//*for loop - build & display all the rows
            
            mysqli_free_result($ri); //invoicehdr
            
            //*accum totals
            $payment_remaining     = round($payment_amt - $total_applied, 2);
            
            $total_applied_fmt     = sprintf("%01.2f", $total_applied);
            $payment_remaining_fmt = sprintf("%01.2f", $payment_remaining);
            
            if (trim($payment_amt) != "") {
                $payment_amt_fmt = sprintf("%01.2f", $payment_amt);
            } else {
                $payment_amt_fmt="";
            }
        }// isset($commit)
        
        
        $x = "";
        $total_amount   = 0;
        $total_payments = 0;
        $total_balance  = 0;
        
        for ($c=0;$c<count($col0);$c++) {
            $x .= '<tr>
				<td>'.$col0[$c].'</td>
			   <td>'.$col1[$c].'</td>
			   <td>'.$col2[$c].'</td>
			   <td>'.$col3[$c].'</td>
			   <td>'.$col4[$c].'</td>
			   <td>'.$col5[$c].'</td>
			   <td>'.$col6[$c].'</td>
			   <td>'.$col7[$c].'</td>
			   			</tr>			
				';
            $total_amount   = $total_amount   + $col3[$c];
            //echo $total_amount;
            $total_payments = $total_payments + $col4[$c];
            $total_balance  = $total_balance  + $col5[$c];
        }
    
        $total_amount_fmt   = sprintf("%01.2f", $total_amount);
        $total_payments_fmt = sprintf("%01.2f", $total_payments);
        $total_balance_fmt  = sprintf("%01.2f", $total_balance);
        $total_applied_fmt  = sprintf("%01.2f", $total_applied);
        
        $x .= '<tr>
				<td>'.$lang[1016].'</td>
			   <td></td>
			   <td></td>
			   <td>'.$total_amount_fmt.'</td>
			   <td>'.$total_payments_fmt.'</td>
			   <td>'.$total_balance_fmt.'</td>
			   <td></td>
			   <td>'.$total_applied_fmt.'</td>
			   			</tr>
				';
        
        //$inv = $invoices->get_unpaid_invoices($_POST['account_id']);
        
        
        echo $errormsg;
        
        $newtemp->load_template('cash_recepits_new', 5);
    } else {
        $newtemp->load_template('cash_recepits', 1, 'accounting_menu');
    }
break;

case 'cash_receipts_history':
    if (isset($_POST['account_id'])) {
        $result = $invoices->get_cash_receipt($_POST);
        $newtemp->load_template('cash_recepits_history', 5);
    } else {
        $newtemp->load_template('cash_recepits_history', 1, 'accounting_menu');
    }
    break;

case 'cr_view':
    if (isset($_POST['openinvoice'])) {
        if (isset($_POST['acct_name2'])  && $_POST['acct_name2'] != "") {
            $res = $account->check_exist("account_name", $_POST['acct_name2']);
            if (!$res) {
                echo "Error in Account No.";
                    
                return;
            }
        }
        
        if ($_POST['acct_name2'] != "") {
            $accno = $account->get_account_id_byname($_POST['acct_name2']);
        } elseif ($_POST['account_acctno'] != '') {
            $accno = $_POST['account_acctno'];
        } elseif ($_GET['account_acctname'] != '') {
            $accno = $_POST['account_acctname'];
        } else {
            $accno = "";
        }
        
        $account_id = $accno;
        $_POST['account_id'] = $account_id;
        
        if (isset($_POST['tax_col'])) {
            $show_tax = "1";
        } else {
            $show_tax = "0";
        }
        
        $result = $invoices->get_cash_receipt($_POST);
    
    
        $breadarray[0]['url'] = "accounting.php?action=open_invoice";
        $breadarray[0]['name'] = $lang[114];
    
        $breadarray[1]['url'] = "";
        $breadarray[1]['name'] = $lang[851];
    
        $page_title = $lang[851];
        $newtemp->load_template('cash_receipts_view', 1, 'accounting_menu');
    }
break;

case 'open_invoice':
if (isset($_POST['get_open_invoice'])) {
    if (is_numeric($_POST['invoice_no']) &&  $_POST['invoice_no'] != '') {
        $invoice_no = $_POST['invoice_no'];
    } else {
        $invoice_no = 0;
        
        if (isset($_POST['acct_name2'])  && $_POST['acct_name2'] != "") {
            $res = $account->check_exist("account_name", $_POST['acct_name2']);
            if (!$res) {
                echo "Error in Account No.";
            
                return;
            }
        }
        
        if ($_POST['acct_name2'] != "") {
            $accno = $account->get_account_id_byname($_POST['acct_name2']);
        } elseif ($_POST['account_acctno'] != '') {
            $accno = $_POST['account_acctno'];
        } elseif ($_GET['account_acctname'] != '') {
            $accno = $_POST['account_acctname'];
        } else {
            $accno = "";
        }
        
        $account_id = $accno;
        
        


        if ($_POST['billingcode'] == "*") {
            $billingcode = "";
        } else {
            $billingcode = $_POST['billingcode'];
        }

        if ($_POST['due_invoice_date'] == "") {
            $due_date = "";
        } else {
            $due_date = $_POST['due_invoice_date'];
        }
    }
    


    $proce = $invoices->get_open_invoice($account_id, $invoice_no, $due_date, $billingcode);

    $data['invoiceno'] = $invoice_no;
    $data['account_id'] = $account_id;
    $data['billingcode'] = $billingcode;
    $data['to_invoice_date'] = $due_date;

    //$deposits = $invoices->get_cash_receipt_deposit($data);



    $tab = "open_invoice";

    $breadarray[0]['url'] = "accounting.php?action=open_invoice";
    $breadarray[0]['name'] = $lang[114];

    $breadarray[1]['url'] = "";
    $breadarray[1]['name'] = $lang[934];

    $page_title = $lang[114];
    $newtemp->load_template('process_invoice_data', 1, 'accounting_menu');
} else {
    $acc = $account->get_all_accounts(1);
    $breadarray[0]['url'] = "#";
    $breadarray[0]['name'] = $lang[114];
    $page_title = $lang[114];
    $newtemp->load_template('open_invoice', 1, 'accounting_menu');
}
break;


case 'history_invoice':
    
if (isset($_GET['account_id'])) {
    $_GET["client"] = $_GET['account_id'];
        
    if ($_GET["client"] != "") {
        $name = $invoices->get_account_company($_GET["client"]);
        $from =  $_GET['invoice_date_form'];
        $to =  $_GET['invoice_date_to'];
    }




 
    $proce = $invoices->get_invoice($_GET);
 
 
    $data['invoiceno'] = $_GET["invoice_no"];
    $data['client'] = $_GET["client"];
    $data['billingcode'] = $_GET["billingcode"];
    $data['reviewed'] = $_GET["reviewed"];
    $data['billing_code'] = $_GET["billing_code"];
    $client_name = $data;
    //$data['to_invoice_date'] = $due_date;
    //$tax = $companyClass->get_tax_name();
    $deposits = $invoices->get_cash_receipt_deposit($data);
    $print = "1";
    $tab = "search_invoice";
    $page_title = "Invoice History";
    $is_search = 1;
    if ($_GET['type'] == "report") {
        $newtemp->load_template('process_invoice_data', 6);
    } else {
        $newtemp->load_template('process_invoice_data', 5);
    }
 
    // $newtemp->load_template('search_invoices',5);
} else {
    $billing_codes = $companyClass->get_billing_code() ;
    $acc = $account->get_all_accounts(1, $_SESSION['billing_code']);
    $newtemp->load_template('history_invoice', 1, 'accounting_menu');
}
break;


case 'payinvoice':
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $account_id = $invoices->get_account_byinvoice_id($_GET['id']);
    $invoiceno = $_GET['oi'];

    $acc_details = $account->get_account($account_id);

    $inv_details = $invoices->get_invoice_header($_GET['id']);
    $invhdr = get_object_vars($inv_details);



    $acctno      = $invhdr["acctno"];
    $random      = $invhdr["random"];
    $total       = sprintf("%01.2f", $invhdr["subtotal"])
             + sprintf("%01.2f", $invhdr["fsamount"])
             + sprintf("%01.2f", $invhdr["tax1amount"])
             + sprintf("%01.2f", $invhdr["tax2amount"])
             + sprintf("%01.2f", $invhdr["tax3amount"])
             + sprintf("%01.2f", $invhdr["tax4amount"])
             + sprintf("%01.2f", $invhdr["tax5amount"]);
             
             
    $inv_balance = $total - $invhdr["ppd_amount"];



    if ($inv_details !=false) {
        $inv_lines = $invoices->get_invoice_lines($_GET['id']);
        $page_title = $lang[518];
        $newtemp->load_template('print_invoice', 2);
    } else {
        echo $lang[517];
    }
} else {
    echo $lang[516];
}
break;

case 'cancel_invoices':
if (isset($_POST["ids"]) && $_POST["ids"] != "") {
    $ids = explode(",", $_POST["ids"]);

    for ($i=0; $i < count($ids); $i++) {
        if ($ids[$i] != "") {
            $invoices->cancel_invoices($ids[$i]);
        }
    }
    echo "Selected Invoices has been Cancelled";
}
break;


        case 'payinvoice':
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $account_id = $invoices->get_account_byinvoice_id($_GET['id']);
                $invoiceno = $_GET['oi'];

                $acc_details = $account->get_account($account_id);

                $inv_details = $invoices->get_invoice_header($_GET['id']);
                $invhdr = get_object_vars($inv_details);


                $acctno = $invhdr["acctno"];
                $random = $invhdr["random"];
                $total = sprintf("%01.2f", $invhdr["subtotal"])
                    + sprintf("%01.2f", $invhdr["fsamount"])
                    + sprintf("%01.2f", $invhdr["tax1amount"])
                    + sprintf("%01.2f", $invhdr["tax2amount"])
                    + sprintf("%01.2f", $invhdr["tax3amount"])
                    + sprintf("%01.2f", $invhdr["tax4amount"])
                    + sprintf("%01.2f", $invhdr["tax5amount"]);


                $inv_balance = $total - $invhdr["ppd_amount"];


                if ($inv_details != false) {
                    $inv_lines = $invoices->get_invoice_lines($_GET['id']);
                    $page_title = $lang[518];
                    $newtemp->load_template('print_invoice', 2);
                } else {
                    echo $lang[517];
                }
            } else {
                echo $lang[516];
            }
            break;
         //   case 'searchDeliveries':
           // $newtemp->load_template('header_work', 1);


           // break;


        default:
            $console = new console(26, $db);
            $console->set_allowtotal("0");
            $console->set_ND("Y");
            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }
            $console->set_page($pageno, PERPAGE);
            


            $coloums_array = array(array('headername' => '+', 'function' => 'show_sales_invoice_option', 'pos' => 'last', 'width' => '130px', 'class' => 'nosort'));

            $coloums = $console->get_coloums_header($coloums_array, $dir, $field_name);

  

//var_dump($coloums);


            $grid_sql = $console->get_grid_sql($coloums, "  invoicehdr
inner join orders on (orders.order_id = invoicehdr.order_id) 
inner join account on (invoicehdr.clid = account.account_id) 
left join users on (users.user_id = orders.user_id) 
   ");
            $query = $grid_sql . " where  ".(isset($_GET['search']) ? $console->build_grid_search($coloums, $_GET['search_txt']) : '')." 1=1  order by invoicehdr.id desc ";


//	echo $query."<br>";

            $data = $console->get_coloums_data($coloums, $query);


            $coloum_attribute = array();


// $row_attribute = array(
// 'onclick' => 'focusrow(this,\'all_table\',\'all_table\');',
// 'ondblclick' => 'editrow(this,\'all_table\',\'all_table\');',
// 'id'=> 'orders__order_id'
// );

            $coloum_attribute = array();


            $html_grid = $console->build_grid($coloums, $coloum_attribute, $data, $row_attribute, 'all_table');


            $breadarray[0]['url'] = "";
            $breadarray[0]['name'] = "الفواتير";

            $page_title = "الحسابات";

            if ($_GET['ajax']) {
                echo $html_grid;

            } else {
                $newtemp->load_template('accounting_console', 1, 'accounting_menu');
            }


            break;


            case 'edit_invoice':
                if(isset($_POST['id'])){
            
                    $invoiceId = $_POST['id'];
                    $invDet = $invClass->get_invoice_header($invoiceId);
                    $invoicehdr = array();
                    $addService = $db->get_table_by_id_all("addtional_services","id");

                    $invoicehdr['bill_total_amount'] = $_POST['bill_total_amount'];
                    $invoicehdr['subtotal'] = $_POST['inv_total_price'];
                    $invoicehdr['discount_value'] = $_POST['bill_discount'];
                    $invoicehdr['taxgroup'] = $_POST['taxgroup'];
                    $invoicehdr['update_by'] = $_SESSION['user_id'];
                    $invoicehdr['update_at'] = date('Y-m-d H:i:s');


                    $itemid = $_POST['itemid'];
                    $itemPrice = $_POST['itemprice'];
                    $service_price = $_POST['service_price'];
                    $service_type = $_POST['service_type'];


                    $myline = 0;
                    for($i=0;$i<count($itemid);$i++){
                        $invoiceDet = array();                        
                        $invoiceDet['lineno'] = $myline;

                        $id = $itemid[$i];
                        $sql = make_update('invoicedtl',$invoiceDet,'id',$id);

                        mysqli_query($mycon,$sql) or die (mysqli_error());

                        if(isset($service_price[$id]) && isset($service_type[$id])  ){

                            for($j=0;$j<count($service_price[$id]);$j++){

                                if( is_numeric($service_price[$id][$j])  && $service_type[$id] != '0' ){

                                    $q = mysqli_query($mycon,"select * from invoicedtl where id = '".$id."'   ");
                                    $oinvDet = mysqli_fetch_assoc($q);

                                    $invoiceDet = array();                        
                                    $invoiceDet['invoiceno'] = $invoiceId;
                                    $invoiceDet['lineno'] = $myline++;
                                    $invoiceDet['chgtype'] = 'A';
                                    $invoiceDet['descn'] = $addService[$service_type[$id][$j]]['name'];
                                    $invoiceDet['amount'] = $service_price[$id][$j];

                                    $invoiceDet['waybill'] = $oinvDet['waybill'];
                                    $invoiceDet['item'] = $oinvDet['item'];
                                    $invoiceDet['clid'] = $oinvDet['clid'];
                                    $invoiceDet['acctno'] = $oinvDet['acctno'];


                                    $sql = make_insert('invoicedtl',$invoiceDet);

                                    mysqli_query($mycon,$sql) or die (mysqli_error());



                                }

                            }
                        }


                        $myline++;
                    }



                    $sql = make_update('invoicehdr',$invoicehdr,'id',$invoiceId);

                    mysqli_query($mycon,$sql) or die (mysqli_error());

                    echo '';




                }else{
                    $invoiceID = $_GET['id'];

                    if(is_numeric($invoiceID)){

                        $grpnames = $companyClass->get_tax_group();

                        $addService = $db->get_table("addtional_services");

    

                        $invDetails = $invClass->get_invoice_header($invoiceID);
                        $invLines = $invClass->get_invoice_lines($invoiceID);

                        $breadarray[0]['url'] = "accounting.php";
                        $breadarray[0]['name'] = "الفواتير";

                        $breadarray[1]['url'] = "#";
                        $breadarray[1]['name'] = "فاتورة رقم ".$invoiceID;
            

                        $newtemp->load_template('sales_edit_invoice', 1, 'accounting_menu');

                    }
                   

                }
                break;


                case 'delete_invoice_item':
                    if(isset($_POST['id'])){

                        $id = $_POST['id'];

                        $q = mysqli_query($mycon,"select * from invoicedtl where id = '".$id."'   ");
                        $oinvDet = mysqli_fetch_assoc($q);

                        mysqli_query($mycon,"update invoicehdr set bill_total_amount = bill_total_amount - ".$oinvDet['amount']." , 
                        subtotal = subtotal - ".$oinvDet['amount']."  where id = '".$oinvDet['invoiceno']."'    ") or die (mysqli_error($mycon));

                        mysqli_query($mycon,"delete from invoicedtl where id = '".$id."'   ");



                    }

                    break;


                    case 'approver_invoice':
                        if(isset($_POST['id'])){
    
                            $id = $_POST['id'];
    
                            $q = mysqli_query($mycon,"select * from invoicehdr where id = '".$id."'   ");
                            $invDet = mysqli_fetch_assoc($q);
    
                            if($invDet['reviewed'] == '1'){
                                mysqli_query($mycon,"update invoicehdr set reviewed = 0   where id = '".$invDet['id']."'    ") or die (mysqli_error($mycon));

                            }else{
                                mysqli_query($mycon,"update invoicehdr set reviewed = 1   where id = '".$invDet['id']."'    ") or die (mysqli_error($mycon));

                            }
    
    
    
    
                        }
    
                        break;




    }
} else {
    $page_title = $lang[102];
    $newtemp->load_template('login_admin', 5);
}
