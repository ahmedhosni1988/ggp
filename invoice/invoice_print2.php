<?php
//******************************************************************************
//  Invoice Print             :                             invoice_print.php  *
//                                                                             *
//  This module is included in:  invoice.php                                   *
//  This module is linked from:                                                *
//  This module links to      :                                                *
//                                                                             *
//  This module includes      :  none                                          *
//                                                                             *
//******************************************************************************
//* The rules: this module is for fomatting and displaying the form ONLY.      *
//*            invoice.php deals with obtaining and preparing the data.        *
//                                                                             *
//******************************************************************************
//ModLog:                                                                      *
//*******                                                                      *
//2005-09-06: Checkbox(option 7) with the usual override in cust record.  To   *
//            have invoice print sort & sub-total by reference. (sub-total only*
//             if > lineitem with same ref)                                    *
//2005-09-08: new function (fieldwrap) used on ref & waybill column,  to       *
//            insert <br> at the specified width.                              *
//2005-09-21: Separate customer "Bill-to" address if different                 *
//2005-10-04: lose co_summarize_waybills.                                      *
//            new fields co_invoiceoption_rb1...5 (rb=radiobutton)             *
//            1-> summarize                                                    *
//            2-> show servicetype                                             *
//            3-> from/to detail amount                                        *
//            4-> wait&extra                                                   *
//2005-10-11: New function for reference break subtotalling - used for print   *
//             format no 1 & 2.                                                *
//            Take that block of code, which was duplicated, out of here &     *
//             place in the functions module.                                  *
//            Also included for final break before totals.                     *
//2005-10-13: Totals section; Statement Info.                                  *
//2006-10-06: Terminology "Waybill" changed to "Order".                        *
//2007-07-04: Show billing period (if not "summarized"                         *
//******************************************************************************




/*
*/


$inputfmnd_prt =    array("align=right   bgcolor=f4f4f4","align=right bgcolor=ffffff","align=right bgcolor=ffffff");



if($invoicedtl['prepaid'] == "1") $maxlines = 30;


//*Add some unneccessary variables for the sake of clarity
if ($option_spacing  > 2) $doublespace_orders  = "Y";        //doublespace orders
if ($option_spacing == 4) $doublespace_details = "Y";        //doublespace from/to



//* Turn OFF other relevant options, if "Summarized" picked.
if ($option_linedetail == 3)  {
 $option_reference = "N";
 $option_fs_on_lines = "N";
 $option_tax_on_lines = "N";
 }

//* if option 1 is off, then option 7 must also be off.
if ($option_reference == "N")  $option_sortby_ref = "N";

// Setup ....                                                                  *
$inputfm_invoiceline_prt =  array("valign=top bgcolor=ffffff align=right",
                                  "valign=top bgcolor=ffffff align=right",
                                  "valign=top bgcolor=ffffff align=right",
                                  "valign=top bgcolor=ffffff align=right",
                                  "valign=top bgcolor=ffffff align=right",
                                  "valign=top bgcolor=ffffff align=right",
                                  "valign=top bgcolor=ffffff align=right",
                                  "valign=top bgcolor=ffffff align=right",
                                  "valign=top bgcolor=ffffff align=right",
                                  "valign=top bgcolor=ffffff align=right",
                                  "valign=top bgcolor=ffffff align=right",
                                  "valign=top bgcolor=ffffff align=right",
                                  "valign=top bgcolor=ffffff align=right");
//********************
//* Lineitem headers.*
//********************
$lineitem_hdr = array();
$lineitem_hdr[0] = "رقم القطعة";
$lineitem_hdr[1] = "الطول";
$lineitem_hdr[2] = "العرض";
$lineitem_hdr[3] = "سمك";
$lineitem_hdr[4] = "الكمية";
$lineitem_hdr[5] = "اللون";
$lineitem_hdr[6] = "طباعة";
$lineitem_hdr[7] = "مسطح";
$lineitem_hdr[8] = "سنفرة";
$lineitem_hdr[9] = "تخليع";
$lineitem_hdr[10] = "التفاصيل";
$lineitem_hdr[11] = "سعر";
$lineitem_hdr[12] = "الاجمالي";

//* Invoicing Option: Print Reference
//if ($option_reference == "N") $lineitem_hdr[0] = ""; // kill it because it get printed regardless
                                                    // & we want a zero width column.
//**************************
//* Calc the column widths.*
//**************************
$ppc = array (); // pixels per character... for now these numbers are as accurate as I can estimate
$ppc[1] = 6.25;  // Small               ... if need be adjusted...
$ppc[2] = 7.5;   // Medium              ... adjust up, to be conservative.
$ppc[3] = 9.2;    // Large
$cw           = array ();    //* these work if total = 30 < $otw.
$otw          = 770;
//* Special case; if they want 5 cols of #'s & reference - in LARGE print,
//* just doesn't work, leaves next to nothing left for details...
//* just set it back to medium.
// if (($option_reference == "Y") and ($option_fs_on_lines == "Y") and ($option_tax_on_lines == "Y")){
//  if ($option_line_fontsize == 3)  $option_line_fontsize = 2;
//  }

//* DEFINE Required Number of Digits per Column
$ref_width_char = 8;                                         //Large
if ($option_line_fontsize == 2) $ref_width_char = 9;         //Med
if ($option_line_fontsize == 1) $ref_width_char = 10;        //Small
//No fs column, give a bit more to WB & Ref
if ($option_fs_on_lines != "Y")  $ref_width_char = $ref_width_char+2;
//No fs column, give a bit more to WB & Ref
if ($option_tax_on_lines != "Y")  $ref_width_char = $ref_width_char+2;

$ref_width_px = $ref_width_char * $ppc[$option_line_fontsize];  //Now - adjust for print size
$number_width_char = 6;
$wb_width_char     = $ref_width_char;
$wb_width_px       = $ref_width_px;

//* Reference
if ($option_reference == "Y") $cw[0] = $ref_width_px;

//* Waybill
$cw[0] = $wb_width_px;

//* Numbers Columns
$cw[3] = $number_width_char * $ppc[$option_line_fontsize];
if (($option_fs_on_lines == "Y") or ($option_tax_on_lines == "Y")){
$cw[4] = $cw[3];
$cw[5] = $cw[3];
}
if (($option_fs_on_lines == "Y") and ($option_tax_on_lines == "Y")){
$cw[6] = $cw[3];
$cw[7] = $cw[3];
}
//* make sure F.S. col is at least 60 pixels, or titles won't align with columns
if (($option_fs_on_lines == "Y") and ($cw[4] < 60))  $cw[4]=60;
//* same for Reference
if (($option_reference == "Y") and ($cw[0] < 60))  $cw[0]=60;

$cw[0] = $otw / 13;
$cw[1] = $otw / 13;
$cw[2] = $otw / 13;
$cw[3] = $otw / 13;
$cw[4] = $otw / 13;
$cw[5] = $otw / 13;
$cw[6] = $otw / 13;
$cw[7] = $otw / 13;
$cw[8] = $otw / 13;
$cw[9] = $otw / 13;
$cw[10] = $otw / 13;
$cw[11] = $otw / 13;
$cw[12] = $otw / 13;
$cw[13] = $otw / 13;

//* Gather up whats left over for the Details Column
//$cw[2] = $otw - $cw[0]- $cw[1] - $cw[3] - $cw[4] - $cw[5] - $cw[6] - $cw[7];
//                   NOTE: ***  $cw[]  is in Pixels.....  $xxx_width is in Chars  !
//$dtl_width    = round($cw[2] / $ppc[$option_line_fontsize],0);


//+++++++++++++++++++++++++++++  echo "0:$cw[0] , 1:$cw[1] , 2:$cw[2] , 3:$cw[3] , 4:$cw[4] , 5:$cw[5] , 6:$cw[6] , 7:$cw[7]";

//* Format data in totals section
$subtotal_fmt   = sprintf("%01.2f",$invhdr["subtotal"]);
$fsamount_fmt   = sprintf("%01.2f",$invhdr["fsamount"]);
$tax1amount_fmt = sprintf("%01.2f",$invhdr["tax1amount"]);
$tax2amount_fmt = sprintf("%01.2f",$invhdr["tax2amount"]);
$tax3amount_fmt = sprintf("%01.2f",$invhdr["tax3amount"]);
$tax4amount_fmt = sprintf("%01.2f",$invhdr["tax4amount"]);
$tax5amount_fmt = sprintf("%01.2f",$invhdr["tax5amount"]);
$total_fmt      = sprintf("%01.2f",$total);
if ($invhdr["ppd_amount"] == 0)
 $ppd_amount_fmt = null;
else
  $ppd_amount_fmt     = sprintf("%01.2f",$invhdr["ppd_amount"]);
$inv_balance_fmt    = sprintf("%01.2f",$inv_balance);

//******************************************************************************
// Start the Page                                                              *
//******************************************************************************
echo "<body>";

$pageno         = 1;
//$otw            = 670;... moved... need to define this berfore calc col widths to fit.
$otborder       = 2;
$htborder       = 0;
$mtborder       = 0;
$itborder       = 0;
$ospacing       = 0;
$htrspacing     = 3;
$hbspacing      = 1;
$padding        = 10;
$htlwidth       = 375;  //* the extra 5 compensates for the multiple tables, to align the hdr-top&bottom-right tables
$htmwidth       = 11;   //* not used right now, so lets give lots of room for the image.
$htrwidth       = 260;
$hblwidth       = 390;
$hbrwidth       = 260;
$tlwidth        = 390;
$trwidth        = 245;  //* same here
$extra_hdrlines = 0;
$showrow        = array ();
//header is printed in mediumsize font (fontsize choice is only for lineitem body)
//header setting is what is ADDED to $maxlines for pg2+ NOT the size of the header.
// this should be the no.of lines Difference inthe header size between pg1 & cont.pages.
if ($option_line_fontsize == 1) $hdrlines = 12;
if ($option_line_fontsize == 2) $hdrlines = 10;
if ($option_line_fontsize == 3) $hdrlines = 8;

//* Setup Bill-to  &  Sold-to,  if different bill-to address.   $bill_or_sold
$left_name  = $name;
$left_addr  = $addr;
$left_city  = $city;
$left_pcode = $pcode;
$bill_or_sold = "Sold";
if ($billto_name.$billto_addr != "")  {
 $bill_or_sold = "Bill";
 $left_name   = $billto_name;
 $left_addr   = $billto_addr;
 $left_city   = $billto_city;
 $left_pcode  = $billto_pcode;
 $right_name  = $name;
 $right_addr  = $addr;
 $right_city  = $city;
 $right_pcode = $pcode;
 }

$data = array();



echo "<table  border=$otborder cellspacing=$ospacing width=$otw  dir=\"rtl\" style=\"margin:auto;\">";       //*outer

echo "<tr><td><table border=$htborder cellspacing=$ospacing >";  //*outer-header


//* Header top                                                     //*header top
echo "<tr> <td ".$fmt_prt[0]."  > <table border=$mtborder cellspacing=$ospacing>";


//*header top left                                                             *
echo "  <td valign=top width=30%> <table border=$itborder cellspacing=$ospacing> ";
showrow(array("<IMG SRC=\"".$_GET['in'].SITEURL."/images/invoice_banner.jpg\">"),$inputfmw_prt);
echo "      </table> </td>";
//*header top left                                                             *


//*header bottom left                                                          *
echo "  <td align=right valign=top width=35%> <table border=$itborder cellspacing=$hbspacing> ";
$iw  = array();  $iw[0]  = 250;
$bar = array();  $bar[0] = "بيانات العميل";
$size= array();  $size[0] =3;
printrow_console_header_dark($bar,$iw,$size,$inputfmbcs2_prt);

showrow(array("رقم العميل",$acctno),$inputfmnd_prt);
showrow(array("اسم العميل",$left_name),$inputfmnd_prt);
showrow(array("رقم الطلبية",$easy_order_id),$inputfmnd_prt);
showrow(array("كود الطلبية",$order_id),$inputfmnd_prt);


// showrow(array("العنوان",$left_addr),$inputfmnd_prt);
// showrow(array("المدينة",$left_city),$inputfmnd_prt);

echo "      </table> </td>";
//*header bottom left                                                          *


//*header topmiddle    ******PROVISION FOR COMPANY ADDRESS-LIKE WAYBILL DOES ******
// echo " <td valign=center width=$htmwidth> <table border=$itborder cellspacing=$ospacing> ";
// echo "       </table> </td>";
//*header top middle    ******PROVISION FOR COMPANY ADDRESS-LIKE WAYBILL DOES ******


//*header top right                                                            *
echo "<td   align=right valign=top width=35%> <table border=$itborder cellspacing=$htrspacing> ";
$iw  = array();  $iw[0]  = 250;
$bar = array();  $bar[0] = " بيانات الفاتورة";
$size= array();  $size[0] =3;
$idate =  $invhdr["date"];
$iy =  substr($idate,0,4);
$im =  substr($idate,5,2);
$id =  substr($idate,8,2);
$invoicedate_formatted = date("d-m-Y", mktime(0, 0, 0, $im, $id, $iy));
$ddate =  $invhdr["duedate"];
$dy =  substr($ddate,0,4);
$dm =  substr($ddate,5,2);
$dd =  substr($ddate,8,2);
$duedate_formatted = date(DATE_FORMAT, mktime(0, 0, 0, $dm, $dd, $dy));

printrow_console_header_dark($bar,$iw,$size,$inputfmbcs2_prt);
showrow(array("رقم الفاتورة"  ,$invoiceno)                  ,$inputfmnd_prt);
showrow(array("التاريخ " ,$invoicedate_formatted)      ,$inputfmnd_prt);
//showrow(array("نظام الدفع ",$termsdesc)                  ,$inputfmnd_prt);
//showrow(array("تاريخ الاستحقاق "  ,$duedate_formatted)          ,$inputfmnd_prt);
showrow(array("عدد القطع" ,$ordernos)              ,$inputfmnd_prt );
if($invhdr['prepaid'] == "0") showrow(array("Page " ,"&nbsp;&nbsp;&nbsp;".$pageno),$inputfmw_prt );

echo "       </table> </td>";
//*header top right                                                            *


echo " </table> </td> </tr>";
//* Header top                                                     //*header top


//* Header bottom                                               //*header bottom
echo "<tr> <td ".$fmt_prt[0]."  > <table border=$mtborder cellspacing=$ospacing>";


//*header bottom left                                                          *
// echo "  <td align=right valign=top width=$hblwidth> <table border=$itborder cellspacing=$hbspacing> ";
// showrow(array("رقم العميل : &nbsp;$acctno"),$inputfmnd_prt);
// showrowbold(array("اسم العميل :".$left_name),$inputfmw_prt);
// showrowbold(array("العنوان : ".$left_addr),$inputfmw_prt);
// showrowbold(array("المدينة : ".$left_city),$inputfmw_prt);

// echo "      </table> </td>";
//*header bottom left                                                          *


//*header bottom right                                                         *
if (trim($billto_name.$billto_addr <> ""))  {
 echo "<td align=left valign=top width=$hbrwidth> <table border=$itborder cellspacing=$hbspacing> ";
 showrow(array("Sold to: &nbsp;$acctno"),$inputfmnd_prt);
 showrow(array($right_name),$inputfmw_prt);
 showrow(array($right_addr),$inputfmw_prt);
 showrow(array($right_city),$inputfmw_prt);
 showrow(array($right_pcode),$inputfmw_prt);
 echo "       </table> </td>";
 }
//*header bottom right                                                         *


echo " </table> </td> </tr>";
//* Header bootom                                               //*header bottom

echo "</table></td></tr> ";                                      //*outer-header



//* Line item header                                           //*lineitemheader
lineitem_header();
//* Line item header                                           //*lineitemheader



//* Lineitems                                                       //*lineitems
echo "  <tr>   <td ".$fmt_prt[0]."  > <table border=$mtborder>"; //*table:for the lines

$size= array();
$size[0] = $option_line_fontsize;
$size[1] = $option_line_fontsize;
$size[2] = $option_line_fontsize;
$size[3] = $option_line_fontsize;
$size[4] = $option_line_fontsize;
$size[5] = $option_line_fontsize;
$size[6] = $option_line_fontsize;
$size[7] = $option_line_fontsize;
$size[8] = $option_line_fontsize;
$size[9] = $option_line_fontsize;
$size[10] = $option_line_fontsize;
$size[11] = $option_line_fontsize;
$size[12] = $option_line_fontsize;
$size[13] = $option_line_fontsize;


//******************************************************************************
//* Show billing period.... if....                                             *
//* we have it, and, if detail level != "Summarized"                           *
//******************************************************************************
if ($option_linedetail != 3  and  substr($invhdr["billingpd"],0,4) > 0)  {
 //$line[0] = "";
 $line[1] = "Charges";
 $line[2] = "for the period: ".date(DATE_FORMAT,strtotime(substr($invhdr["billingpd"],0,10)))." - ".date(DATE_FORMAT,strtotime(substr($invhdr["billingpd"],10,10)))   ;
 $line[3] = "";
 showrow_line($line,$cw,$size,$inputfm_invoiceline_prt);
 $data[] = $line;
 $lc = 1;
 }
 
 
                           // echo "<br><br>";
                           // echo "**** $showlines_count ****<br><br>";
                           // echo "**** $option_linedetail ****<br><br><br>";
                           //                                         exit;
//******************************************************************************
//* Invoice format #1: Charge details.  Up to 3 lines / waybill.(svc,wait,xtra)*
//* do the same for format#3. Prepare rolled them all into one lineitem.       *
//******************************************************************************
if ($option_linedetail == 1)  {
 $prev_item = "{{{{{{{{{{";  //* used for doublespacing
 unset($prev_ref);           //* used for ref subtotals
 $prev2_ref = "";            //* used for ref subtotals
 //$lc        = 0;
 $subtotal  = array();

 for ($n = 1; $n < $showlines_count+1; $n++) {

  $line = array();

  //*estimate(rough) how many lines this record needs
  $estimate =1;
  if ($doublespace_orders == "Y")   $estimate =2;
  if ($option_fromto_detail == 1)   $estimate = $estimate +4;
  if ($option_fromto_detail == 2)   $estimate = $estimate +1;
  if ($doublespace_details == "Y")  $estimate = $estimate +2;

  //*New page
  if ($lc+$estimate >= $maxlines)  {
   $parms = array();        $prms = array();
   $parms[0]= $pageno;
   $parms[1]= $maxlines;
   $parms[2]= $hdrlines + $extra_hdrlines;
   $prms = newpage($parms);
   $pageno   = $prms[0];
   $maxlines = $prms[1];
   $lc = 0;
   //echo "+++++++++++++++++ $prms[0] ++++++++++++++++++++++<br><br>";
   //echo "+++++++++++++++++ $prms[1] ++++++++++++++++++++++<br><br>";
   }

  reference_break($n);

  //*Doublespace                   (watch previous line: no space between lines of same waybill.)
  if ($doublespace_orders == "Y")  {
   if ($li_items[$n] != $prev_item and $prev_item != "{{{{{{{{{{" and $lc > 0 ) {
    //$line[0] = "&nbsp;";
    showrow_line($line,$cw,$size,$inputfm_invoiceline_prt);
    $data[] = $line;
    $lc = $lc+1.1;
    }
   }

  
   //Setup The LINE.
  
  //$line[0] = "";
  $line[7] = sprintf("%01.2f",$li_amount[$n]);
  //Reference
  if ($li_chgtype[$n] == "S"  and  $option_reference == "Y")
   $line[0] = fieldwrap($li_waybill_refs[$n],$ref_width_char,$option_spacing);
  //*waybill
  //$line[1] = html_entity_decode($li_items[$n]);
  $bullet = strpos($line[1],"�");
  if ($bullet > 0  and  strlen($line[1])+2 > $wb_width_char)
   $line[1] = substr_replace($line[1]," ",$bullet+1,0);
  $line[1] = fieldwrap($line[1],$wb_width_char,2);   //Always "wrap" for the Item. (never Chop)
  //length
  if ($li_chgtype[$n] == "S") {
  	$line[2] = $li_length[$n];  //usually just the date(always unless they edited it) or wait/extra descn.
     
    
    



   //servicetype
   //if ($option_svctype == 1)  $line[2] .= " ".$li_svc[$n];
   //from&to - on 2 lines (or more)
   if ($option_fromto_detail == 1)  {
   // $from = fieldwrap("From:".$li_fromname[$n]." ".$li_fromaddr[$n],$dtl_width-2,$option_spacing); //*be conservative:  -2
    //$to   = fieldwrap("To:"  .$li_toname[$n]  ." ".$li_toaddr[$n]  ,$dtl_width-2,$option_spacing); //*be conservative:  -2
    if ($doublespace_details == "Y")  {
     $from = "<br>".$from;
     $to   = "<br>".$to;
     }
    $line[2] .= "<br>".$from."<br>".$to;
    }
   //from&to - on 1 line
  //  if ($option_fromto_detail == 2)  {
  //   $from = $li_fromaddr[$n];      $fromlen=strlen($from);
  //   $to   = $li_toaddr[$n];        $tolen  =strlen($to);
  //   if ($fromlen+$tolen+3+5 > $dtl_width)  {
  //    $tlen = round($dtl_width/2,0)-6;  //*be conservative:  -6
  //    $from = substr($from,0,$tlen);
  //    $to   = substr($to,0,$tlen);
  //    }
  //    $line[2] .= "<br>".$from." - ".$to;
  //   }
   } //if ($li_chgtype[$n] == "S")
  else
   {
   	$line[2] = $li_length[$n];  //usually just the date(always unless they edited it) or wait/extra descn.
   	
    
   if ($option_wait_extra_lines == 2)  {
    for ($i=1; $i<14; $i++)  {
     $pos = strpos(" wpvabcdefghWX", $li_chgtype[$n+1]);
     if ($li_waybills[$n+1] == $li_waybills[$n]  and  $pos > 0 ) {
      $line[2]          .= " ,".$li_length[$n+1];
      $li_amount[$n+1]   = $li_amount[$n]   + $li_amount[$n+1];
      $line[3]           = sprintf("%01.2f",$li_width[$n+1]);
      $li_fsamount[$n+1] = $li_fsamount[$n] + $li_fsamount[$n+1];
      $li_subtot[$n+1]   = $li_subtot[$n]   + $li_subtot[$n+1];
      $li_taxes[$n+1]    = $li_taxes[$n]    + $li_taxes[$n+1];
      $n = $n+1;
      }
     }
    }
   }


  //show F.S.
  // if ($option_fs_on_lines == "Y")  {
  //  $line[4] = sprintf("%01.2f",$li_fsamount[$n]);
  //  $line[5] = sprintf("%01.2f",$li_subtot[$n]);
  //  }
  //show Taxes
  // if ($option_tax_on_lines == "Y")  {
  //  $line[3] = sprintf("%01.2f",$li_amount[$n]+$li_fsamount[$n]);
  //  $line[4] = sprintf("%01.2f",$li_taxes[$n]);
  //  $line[5] = sprintf("%01.2f",$li_total[$n]);
  //  }
  //show both, f.s. & taxes
  // if ($option_fs_on_lines == "Y" and $option_tax_on_lines == "Y")  {
  //  $line[3] = sprintf("%01.2f",$li_amount[$n]);
  //  $line[4] = sprintf("%01.2f",$li_fsamount[$n]);
  //  $line[5] = sprintf("%01.2f",$li_subtot[$n]);
  //  $line[6] = sprintf("%01.2f",$li_taxes[$n]);
  //  $line[7] = sprintf("%01.2f",$li_total[$n]);
  //  }

  //* Bump linecounter
  $lu[0] = countlines($line[0]);
  $lu[1] = countlines($line[1]);
  $lu[2] = countlines($line[2]);
  $linesused = max($lu);
  $lc = $lc + $linesused;

//++++++++++++++++++++++++++++++++++++++++++++++++++++++
/*       $line[2] .= "<br>";
 $line[2] .= "<br> *from* "           .$li_fromaddr[$n];
 $line[2] .= "<br> *to* "             .$li_toaddr[$n];
 $line[2] .= "<br> *fromlen* "        .$fromlen;
 $line[2] .= "<br> *tolen* "          .$tolen;
 $line[2] .= "<br> *tlen  "           .$tlen;
 $line[2] .= "<br> *from* "           .$from;
 $line[2] .= "<br> *to* "             .$to;
 $line[2] .= "<br> *linesused* "      .$linesused." ".$lu[0]." ".$lu[1]." ".$lu[2];
 $line[2] .= "<br> *dtl_width* "      .$dtl_width;
 $line[2] .= "<br> *lc* "             .$lc;
 $line[2] .= "<br> *maxlines* "       .$maxlines;
 */
//++++++++++++++++++++++++++++++++++++++++++++++++++++++

$line[0] = html_entity_decode($li_items[$n]);
$line[1] = $li_length[$n];
$line[2] = $li_width[$n];
$line[3] = $li_package_type[$n];
$line[4] = $li_amount[$n];
$line[5] = $li_glasscolour[$n];
$line[6] = $li_glassprint[$n];
$line[7] = $li_glassType[$n];
$line[8] = $li_glassScarch[$n];
$line[9] = $li_glassPointing[$n];
$line[10] = $li_details[$n];
$line[11] = " ";
$line[12] = " ";

//echo"<pre>";
//print_r($line);

  showrow_line($line,$cw,$size,$inputfm_invoiceline_prt);
  $data[] = $line;
  
  $subtotal[amt] = $subtotal[amt] + $li_amount[$n];
  $subtotal[fs ] = $subtotal[fs ] + $li_fsamount[$n];
  $subtotal[tax] = $subtotal[tax] + $li_taxes[$n];

  //* this is used to decide when/if to doublespace
  $prev_item = $li_items[$n];
  //*shuffle the refs to watch for ref-break.
  /* if ($ref != "" and  $li_chgtype[$n] == "S")  {
   $prev2_ref = strtoupper($prev_ref);
   $prev_ref  = strtoupper($ref);
   } */

  } //for ($n = 1; $n < $showlines_count+1; $n++)
 } //if ($option_linedetail == 1)

//***************************************************************************************
//* Invoice format #2: One waybill per line.                                            *
//* pick up all lineitems per waybill. could be 1, 2 or 3 lines. - Then Print the Line. *
//* Logic: chgtype"S" always comes first, then look to see if theres a "W" and/or a "X".*
//*                                                                                     *
//* Here's the plan on this                                                             *
//* Try squeeze it all onto 1 line, but we must include all the description, since there*
//  is no point in having it if we don't print it.  Measure & insert <br>'s as needed   *
//  & let it take as many lines as needed.                                              *
//***************************************************************************************
if ($option_linedetail == 2)   {
 unset($prev_ref);           //* used for ref subtotals
 $prev2_ref = "";            //* used for ref subtotals
 $lc        = 0;
 $subtotal  = array();

 for ($n = 1; $n < $showlines_count+1; $n++) {

  $line = array();

  //*estimate(rough) how many lines this record needs
  $estimate =2;
  if ($doublespace_orders == "Y")  $estimate =3; //doublespace

  //*New page
  if ($lc+$estimate >= $maxlines)  {
   $parms = array();        $prms = array();
   $parms[0]= $pageno;
   $parms[1]= $maxlines;
   $parms[2]= $hdrlines + $extra_hdrlines;
   $prms = newpage($parms);
   $pageno   = $prms[0];
   $maxlines = $prms[1];
   $lc = 0;
   }

  reference_break($n);

  //*Doublespace
  if (($doublespace_orders == "Y") and ($lc > 0))  {
   $line[0] = "&nbsp;";
   showrow_line($line,$cw,$size,$inputfm_invoiceline_prt);
   $data[] = $line;
   $lc = $lc+1.1;
   }

  //*reference
  if ($option_reference == "Y")                //* reference column
   $line[0] = fieldwrap($li_waybill_refs[$n],$ref_width_char,$option_spacing);
  else
   $line[0] = "";
  //*waybill
  $line[1] = html_entity_decode($li_items[$n]);
  $bullet = strpos($line[1],"�");
  if ($bullet > 0  and  strlen($line[1])+2 > $wb_width_char)
   $line[1] = substr_replace($line[1]," ",$bullet+1,0);
  $line[1] = fieldwrap($line[1],$wb_width_char,2);   //Always "wrap" for the Item. (never Chop)
  //*details
  $l2setup = $li_descn[$n]; //start with the date
  //*amount
  //$line[3] = sprintf("%01.2f",$li_amount[$n]);
  $xamount = $li_amount[$n];
  $xfs     = $li_fsamount[$n];
  $xsubtot = $li_subtot[$n];
  $xtax    = $li_taxes[$n];

  //* Additional charges
  for ($i=1; $i<14; $i++)  {
   $pos = strpos(" wpvabcdefghWX", $li_chgtype[$n+1]);
   if ($li_waybills[$n+1] == $li_waybills[$n]  and  $pos > 0 ) {
    $l2setup .= ", ".$li_descn[$n+1];
    //$line[3] = sprintf("%01.2f",$line[3] + $li_amount[$n+1]);
    $xamount = $xamount + $li_amount[$n+1];
    $xfs     = $xfs     + $li_fsamount[$n+1];
    $xsubtot = $xsubtot + $li_subtot[$n+1];
    $xtax    = $xtax    + $li_taxes[$n+1];
    $n = $n+1;
    }
   }

/*
   //* wait time charges
  if ($li_waybills[$n+1] == $li_waybills[$n]  and  $li_chgtype[$n+1] == "W") {
   $l2setup .= " ,".$li_descn[$n+1];
   $line[3] = sprintf("%01.2f",$line[3] + $li_amount[$n+1]);
   $xamount = $xamount + $li_amount[$n+1];
   $xfs     = $xfs     + $li_fsamount[$n+1];
   $xsubtot = $xsubtot + $li_subtot[$n+1];
   $xtax    = $xtax    + $li_taxes[$n+1];
   $n = $n+1; // <<<---
   }
  //* xtra charges
  if ($li_waybills[$n+1] == $li_waybills[$n]  and  $li_chgtype[$n+1] == "X") {
   $l2setup .= " ,".$li_descn[$n+1];
   $line[3] = sprintf("%01.2f",$line[3] + $li_amount[$n+1]);
   $xamount = $xamount + $li_amount[$n+1];
   $xfs     = $xfs     + $li_fsamount[$n+1];
   $xsubtot = $xsubtot + $li_subtot[$n+1];
   $xtax    = $xtax    + $li_taxes[$n+1];
   $n = $n+1; // <<<---
   }
 */

   //*finish-up setting up the line
   $line[2] = fieldwrap($l2setup,$dtl_width-6,$option_spacing);
   //$line[3] = sprintf("%01.2f",$xamount);

   //show F.S.
   if ($option_fs_on_lines == "Y")  {
    //$line[4] = sprintf("%01.2f",$xfs);
    $line[5] = sprintf("%01.2f",$xamount+$xfs);
    }
   //show Taxes
   if ($option_tax_on_lines == "Y")  {
    //$line[3] = sprintf("%01.2f",$xamount+$xfs);
    //$line[4] = sprintf("%01.2f",$xtax);
    $line[5] = sprintf("%01.2f",$xamount+$xfs+$xtax);
    }
   //show both, f.s. & taxes
   if (($option_fs_on_lines == "Y") and ($option_tax_on_lines == "Y"))  {
    //$line[3] = sprintf("%01.2f",$xamount);
    //$line[4] = sprintf("%01.2f",$xfs);
    $line[5] = sprintf("%01.2f",$xsubtot);
    $line[6] = sprintf("%01.2f",$xtax);
    $line[7] = sprintf("%01.2f",$xamount+$xfs+$xtax);
    }

    //* Bump linecounter
    $lu[0] = countlines($line[0]);
    $lu[1] = countlines($line[1]);
    $lu[2] = countlines($line[2]);
    $lu[3] = countlines($line[3]);
    $lu[4] = countlines($line[4]);
    $lu[5] = countlines($line[5]);
    $lu[6] = countlines($line[6]);
    $lu[7] = countlines($line[7]);
    $lu[8] = countlines($line[8]);
    $lu[9] = countlines($line[9]);
    $lu[10] = countlines($line[10]);
    $lu[11] = countlines($line[11]);
    $lu[12] = countlines($line[12]);
    $lu[13] = countlines($line[13]);
  $linesused = max($lu);                                      // $olc=$lc;  //+++++++++++++
  $lc = $lc + $linesused;
//++++++++++++++++++++++++++++++++++++++++++++++++++++++
/*       $line[2] .= "<br>";
 $line[2] .= "<br> *from* "           .$li_fromaddr[$n];
 $line[2] .= "<br> *to* "             .$li_toaddr[$n];
 $line[2] .= "<br> *fromlen* "        .$fromlen;
 $line[2] .= "<br> *tolen* "          .$tolen;
 $line[2] .= "<br> *tlen  "           .$tlen;
 $line[2] .= "<br> *from* "           .$from;
 $line[2] .= "<br> *to* "             .$to;
 $line[2] .= "<br> *linesused* "      .$linesused." ".$lu[0]." ".$lu[1]." ".$lu[2];
 $line[2] .= "<br> *dtl_width* "      .$dtl_width;
 $line[2] .= "<br> *lc* "             .$lc;
 $line[2] .= "<br> *maxlines* "       .$maxlines;
 */
//++++++++++++++++++++++++++++++++++++++++++++++++++++++
              // $line[0]=$olc." ".$linesused." ".$lc; //++++++++*********+++++++++
    showrow_line($line,$cw,$size,$inputfm_invoiceline_prt);
    $data[] = $line;
    $subtotal[amt] = $subtotal[amt] + $xamount;
    $subtotal[fs ] = $subtotal[fs ] + $xfs;
    $subtotal[tax] = $subtotal[tax] + $xtax;

    //* this is used to decide when/if to doublespace
    $prev_item = $li_items[$n];
    //*shuffle the refs to watch for ref-break.
    /* if ($ref != "")  {
     $prev2_ref = strtoupper($prev_ref);
     $prev_ref  = strtoupper($ref);
     } */

  } //for ($n = 1; $n < $showlines_count+1; $n++)
 } //if ($option_linedetail == 2)

//******************************************************************************
//* Invoice format #3: Summarized waybills - One line for the whole invoice.   *
//******************************************************************************
if ($option_linedetail == 3)  {
 $line[0] = "";
 $line[1] = "Charges";
 $line[2] = "for the period: ".substr($invhdr["billingpd"],0,10)." - ".substr($invhdr["billingpd"],10,10)   ;
 //$line[3] = $invhdr["subtotal"];

 
 showrow_line($line,$cw,$size,$inputfm_invoiceline_prt);
 $data[] = $line;
 $lc = 2;
 }


//******************************************************************************
//* End of lineitems.                                                          *
//******************************************************************************
if ($option_linedetail != 3)  {
 $li_waybill_refs[$n] = "}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}";
 $li_chgtype[$n] = "S";
//echo "<tr><td>  $n                   </td></tr>";
//echo "<tr><td>  $showlines_count     </td></tr>";
//echo "<tr><td>  $li_waybill_refs[$n] </td></tr>";
//echo "<tr><td>  $prev_ref            </td></tr>";
//echo "<tr><td>  $prev2_ref           </td></tr>";

  reference_break($n);
 }

//******************************************************
//* Add padding after lineitems (to make a full page), *
//  and, ensure Totals Box will fit.                   *
//  Totalsbox is the messageline + the totals. 4 lines *
//   of totals + the msgline should fit ok in 7, but   *
//   let's call it 8 to be comfortable.                *
//******************************************************
                          $totalsboxsize = 1;
if ($option_stmt == "Y")  $totalsboxsize = 8 + 4;
if ($option_line_fontsize == 1)  $totalsboxsize = $totalsboxsize +4;
if ($option_line_fontsize == 2)  $totalsboxsize = $totalsboxsize +2;
//*New page, if the box won't fit.
                                                 //$line[0] .= $lc."*".$totalsboxsize."*".$maxlines;
                                                 //showrow_line($line,$cw,$size,$inputfm_invoiceline_prt);
if ($lc+$totalsboxsize >= $maxlines)  {
 $parms = array();        $prms = array();
 $parms[0]= $pageno;
 $parms[1]= $maxlines;
 $parms[2]= $hdrlines + $extra_hdrlines;
 $prms = newpage($parms);
 $maxlines = $prms[1];
 $lc = 0;
 }

$adj = $maxlines - $lc - $totalsboxsize;
if ($adj > 0)  {
  for ($n = 0; $n < $adj; $n++)  {
   $line = array();
   $line[0] = "&nbsp;";
   showrow_line($line,$cw,$size,$inputfm_invoiceline_prt);
   $data[] = $line;
   }
}


echo " </table> </td> </tr>";                                        //*table:for the lines
//* Lineitems                                                        //*lineitems


//* Messageline                                                                *

$message = SITENAME;
messageline($message);
/* echo "<tr><td>$option_line_fontsize &nbsp;
              $lc &nbsp;
              $maxlines &nbsp;
              $adj &nbsp;
              $totalsboxsize &nbsp;
              $hdrlines &nbsp;
              $extra_hdrlines &nbsp;
              </td></tr>"; */

//* Messageline                                                                *


//* Totals
echo "  <tr>";                                                         //*totals
echo "  <td ".$fmt_prt[0]."  > <table border=$mtborder>";

//*Totals left                                                                 *
echo " <td align=left valign=bottom width=$tlwidth> <table border=$itborder> ";
showrow(array("",$control["co_taxmessage1"]),$inputfmc_prt);
showrow(array("",$control["co_taxmessage2"]),$inputfmc_prt);
showrow(array("",$control["co_taxmessage3"]),$inputfmc_prt);
showrow(array("",$control["co_taxmessage4"]),$inputfmc_prt);
echo "      </table> </td> ";
//*Totals left                                                                 *


//*Totals middle   -     keep it for now, just in case                         *
echo " <td width=$hmwidth> <table border=$itborder> ";
echo "  </table> </td>";
//*Totals middle                                                               *


//*Totals right                                                                *
echo "<td  align=right valign=bottom width=$trwidth> <table border=$itborder>";

showrow(array("المجموع&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       &nbsp;&nbsp;&nbsp;","&nbsp;&nbsp;",
               $subtotal_fmt),$inputfmnd_prt);

if ($invhdr["fsamount"] != 0 && $invhdr["fsapply"] == 'Y')
 showrow(array("Fuel surcharge","",$fsamount_fmt),$inputfmnd_prt);

if ($invhdr["tax1amount"] != 0)
 showrow(array($taxname[1],"",$tax1amount_fmt),$inputfmnd_prt);

if ($invhdr["tax2amount"] != 0)
 showrow(array($taxname[2],"",$tax2amount_fmt),$inputfmnd_prt);

if ($invhdr["tax3amount"] != 0)
 showrow(array($taxname[3],"",$tax3amount_fmt),$inputfmnd_prt);

if ($invhdr["tax4amount"] != 0)
 showrow(array($taxname[4],"",$tax4amount_fmt),$inputfmnd_prt);

if ($invhdr["tax5amount"] != 0)
 showrow(array($taxname[5],"",$tax5amount_fmt),$inputfmnd_prt);

 $ttl = "النهائى&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";                                     //$option_stmt = "n";
 $ppd = "Paid";
 $due = "Due";
if ($option_stmt == "Y")  {
 $ttl = "Current charges";
 $ppd = "PrePaid";
 $due = "Current balance";
 }
showrow(  array($ttl,"",$total_fmt),          $inputfmnd_prt);
if ($invhdr["ppd_amount"] != 0)  {
 showrow(array($ppd,"",$ppd_amount_fmt),      $inputfmnd_prt);
 showrow(array($due,"",$inv_balance_fmt),    $inputfmnd_prt);
 }

//*The Statement Info.   ...(don't include "un-processed" invoices - they don't count just yet).
//*** THE SCHEME FOR BUILING AN ACCURATE PREVIOUS BALANCE WITHOUT RECORDING IT ***
//the rules:
//1. ALL Open invoices, regardless of date. Except This ONE!
//2. ALL payments to THOSE invoices, but NONE from TODAY.
//Payments: the Rules:
//1. ALL payments since(incl of) the date of the last invoice, up to yesterday.
//same theory. Any payments received today -DIDN'T HAPPEN.
//  this allows the case of the possibility of >1 invoice today even if ther were payments today
//  to accurately show payments since the last invoice/stmt without trying to sequence the events
//  of today with multiple invoices and payments posted.
//When the next invoice is produced, it will include the payments ON THE SAME DAY as this
//  previous inv/stmt, therefore none will be missed.
//  and the closing<->opening balances should link.
if ($option_stmt == "Y")  {

/*

 showrow(array("Invoice no                ","",$invoiceno             ),$inputfmd);
 showrow(array("Last Invoice no           ","",$last_invoiceno        ),$inputfmd);
 showrow(array("Last Invoice total        ","",$lastinv_total         ),$inputfmd);
 showrow(array("no of openinvoice recs
                     before lastinvoice   ","",$coi                   ),$inputfmd);
 showrow(array("no of Credit  invoice recs
                     after  lastinvoice   ","",$ccr                   ),$inputfmd);
 showrow(array("oi tally                  ","",$oi_tally              ),$inputfmd);
 showrow(array("oi pymts                  ","",$oi_pymts              ),$inputfmd);
 showrow(array("paid to paidinv since lastinv ","",$paid_to_paidinv_since_lastinv),$inputfmd);
 showrow(array("current pymts             ","",$curr_pymts            ),$inputfmd);
 showrow(array("last invoice date         ","",$last_invoice_date     ),$inputfmd);
 showrow(array("stmt date                 ","",$stmt_date             ),$inputfmd);

 */


 showrow(array("Previous balance ","",$prev_bal_fmt),  $inputfmnd_prt);
 showrow(array("Payments received","",$pymts_curr_fmt),$inputfmnd_prt);
 if ($curr_credits != 0)
  showrow(array("Credits         ","",$credits_fmt),   $inputfmnd_prt);

//++++++++++++++++ TEMP ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// if ($deposits != 0)
//  showrow(array("Deposits        ","",$deposits_fmt),   $inputfmnd_prt);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


 showrow(array("Amount due       ","",$amt_due_fmt),  $inputfmnd_prt);
 }

echo " </table> </td>";
//*Totals right                                                                *


//* Totals inner datacells
echo " </table> </td>";
echo " </tr>";                                                         //*totals
//* Totals


echo "</table> ";                                                       //*outer

if ($pagebreak == "Y")
  echo "<h6> &nbsp; </h6>";   //  cause a page-break

 echo "</body>\r\n";


 

  ?>
