<?php


//******************************************************************************
//  Label Print               :                               label_print.php  *
//                                                                             *
//  This module is included in: label.php                                      *
//                                                                             *
//  This module is linked from:                                                *
//  This module links to      :                                                *
//                                                                             *
//  This module includes      :                                                *
//                                                                             *
//******************************************************************************
//ModLog:                                                                      *
//*******                                                                      *
//2009-04-21: New.                                                             *
//******************************************************************************


//***********************************************************************
// ***** TEMPORARY *****  TESTING *****                                 *
//***********************************************************************
/*
include "../unique/unique.php";
include("mysql.php");
$ri = runsql("select * from control where id=1");
    $control = mysql_fetch_array($ri);
    mysql_free_result($ri);

$ordernum=9652;

$ri = runsql("select * from orders where id=$ordernum");
$order = mysql_fetch_array($ri);
mysql_free_result($ri);
$acctno = "AAA001";

$ri = runsql("select * from client where acctno = '$acctno'");
$client = mysql_fetch_array($ri);

$copy = 2;  $copies = 3;
 */
//***********************************************************************
// ***** TEMPORARY *****  TESTING *****                                 *
//***********************************************************************


//******************************************************************************
// Setup the print variables.                                                  *
//******************************************************************************
//$piececount = 1;

//* 1st Row  -  Orderno, date, companyname  &  Logo
$print_type = "";
if ($order['mainstatus'] == "1") {
    $print_type = $package_status[$order['mainstatus']];
} elseif ($order['mainstatus'] == "2") {
    $print_type = $package_status[$order['mainstatus']];
} else {
    $is = explode(',', $order['mainstatus']);

    for ($m = 0; $m < count($is); $m++) {
        $print_type .= $package_status[$is[$m]];
    }
}


$print_order_date = date(DATETIME_FORMAT, strtotime($order["order_date"]));
//* 2nd Row  -  From address (+ package)
$from_addr = array();
$from_addr[] = "From: " . $order["from_name"];
//*split the address line onto 2 lines, if neccessary.  Limit to 2 rows of 30.
// build $from_addr with 4 or 5 lines, but print 5 lines - ensure it will always fit.
$addrline = substr($order["from_address"] . " " . $order["from_pcode"], 0, 60);
if (strlen($addrline) > 30) {
    $from_addr[] = substr($addrline, 0, 30);
    $from_addr[] = substr($addrline, 30);
} else {
    $from_addr[] = $addrline;
}
if ($order["from_contact"] != "") {
    $sp = " ";
}
if ($order["from_contact"] . $order["from_phone"] != "") {
    $from_addr[] = $order["from_contact"] . $sp . $order["from_phone"];
}
if ($order["orderedby"] != "") {
    $from_addr[] = "Ordered by " . $order["orderedby"];
}

$company = $client["account_company"];


$piecestype = $order['package_name'];
//copied from print_waybill.php..............
//*simple: skid/skids
if (substr($piecestype, strlen($piecestype) - 1, 1) == "s") {
    $pt = substr($piecestype, 0, strlen($piecestype) - 1);
}
//*"es":  box/boxes
if (substr($piecestype, strlen($piecestype) - 2, 2) == "es") {
    $pt = substr($piecestype, 0, strlen($piecestype) - 2);
}
//*plural after "e"; case/cases, packages, bundles, envelopes, purses, pieces
if (substr($piecestype, strlen($piecestype) - 3, 3) == "ces" or
    substr($piecestype, strlen($piecestype) - 3, 3) == "ses" or
    substr($piecestype, strlen($piecestype) - 3, 3) == "ges" or
    substr($piecestype, strlen($piecestype) - 3, 3) == "les" or
    substr($piecestype, strlen($piecestype) - 3, 3) == "pes" or
    substr($piecestype, strlen($piecestype) - 3, 3) == "res" or
    substr($piecestype, strlen($piecestype) - 3, 3) == "ses" or
    substr($piecestype, strlen($piecestype) - 3, 3) == "tes" or
    substr($piecestype, strlen($piecestype) - 3, 3) == "ves") {
    $pt = substr($piecestype, 0, strlen($piecestype) - 1);
}
//*the result
$piecestype = $pt;
//.........copied from print_waybill.php.
if ($copies < 1) {
    $copies = 1;
}
$print_pieces_count = $copy . " of " . $copies;


//* 3rd Row - to address
$to_name = $order["to_name"];
$to_addr = $order["to_address"] . " " . $order["to_pcode"];
$to_attn = $order["to_att"];
$to_phone = $order["to_phone"];


//* 4th Row  -  Comments & Description
$comments = $order["order_comment"];
$description = $order["order_des"];
if (trim($description) != "") {
    $comments .= "<br>" . $description;
}


//* 5th Row  -  Reference & Service
$chargeto = $order["chargecode"];
if (trim($chargeto) != "") {
    $reference = "Reference: " . $chargeto;
}


$service = $order["service_name"];
//$logger->compareAndLogV2("","Order item","", "", "Print ",array(), array());


//******************************************************************************
//                 Setup for the Form                                          *
//******************************************************************************
$form_height = 500;
$form_width = 320;
$inner_table_width = $form_width - 4;
$outer_border = 2;
$inner_border = 0;
$header_height = 120;

//******************************************************************************
// *               Draw the form                                               *
//******************************************************************************
echo "<body>

<style>
body {
  
      width: 10cm;
    
      margin: 0mm;
      padding: 0mm;
  }
  
  
  .ticket{
    
      width: 10cm;
      max-height: 10cm;
      margin: 0mm;
      padding: 0mm;
  }
</style>
";


// *** **************************
// *** Draw large outside border.
// *** **************************
echo "<table class=\"ticket\"   border=$outer_border  dir=\"rtl\">";

echo "<tr valign=top><td><table border=0  style=\"width:100%\">";  //another table, so outer border wont frame inner tables

// *** ***********************************************
// *** The FIRST Row. -  Order no, date & Logo       *
// ***                                               *
// *** ***********************************************
echo "
<tr valign=top>
 <td height=10 style=\"font-weight:bold; font-size:22px\" >
  <table border=$inner_border cellspacing=0 width=100%  style=\"font-weight:bold; font-size:20px\">
";
echo "
    <tr> 
    <td align=right valign=top style=\"font-weight:bold; font-size:20px\" > رقم الطلبية:  " . $order['easy_order_id'] . " - " . $order["part_order"] . " - " . $print_type . "
    <br>
  <div style=\"font-size:15px\">  الاستلام : " . date("d-m-Y", strtotime($order['pickup_date'])) . " -  التسليم : " . date("d-m-Y", strtotime($order['delivery_date'])) . " </div>
   العميل : " . $order['account_company'] . " <br>
   <div style=\"font-size:14px;\"> العملية :  " . $order['office_name'] . " - المكتب : " . $order['operation_name'] . "</div>
    </td>
         <td align=left> <img src=\"" . SITEURL . "/images/logo.jpg\" width=\"80\" height=\"80\"> </td> 
         </tr>     
 ";
echo "
  </table>
 </td>
</tr>";


// *** ***********************************************
// *** The 2nd Row. -  From address & Package count  *
// ***                                               *
// *** ***********************************************


// *** ***********************************************
// *** The 3rd Row. -  TO Address                    *
// ***                                               *
// *** ***********************************************


echo "
<tr valign=top>
 <td  align=center>
 <table border=\"1\" style=\"font-weight:bold; width:100%; font-size:20px;\" cellpadding=\"3\">
 <tr>
 <td style=\"text-align:center\" >" . $order['length'] . "</td>
 
 <td style=\"text-align:center\">" . $order['width'] . "</td>

 <td style=\"text-align:center\" >" . $order['package_short'] . "</td>
 
 <td style=\"text-align:center\">" . $order['glasscolour'] . "</td>
 </tr>
 <tr>
 <td colspan=\"4\" style=\"text-align:center; padding:0px; margin:0px;\" >
<table border=\"1\" style=\"font-weight:bold; padding:0px; margin:0px; width:100%;\" cellpadding=\"5\" >
<tr>
<td style=\"text-align:center\" >" . $order['glassPointing'] . "</td>
<td  style=\"text-align:center;\" >" . $order['glassScarch'] . "</td>
<td  style=\"text-align:center;\" >" . $order['glassType'] . "</td>
<td>سكرتة</td>
</tr>
</table>
</td>
 </tr>
 <tr>
 <td colspan=\"4\">-" . $order['details'] . "</td>
 </tr>
 </table>
 </td>
</tr>";


// *** ***********************************************
// *** The 4th Row. -  Comments & Reference          *
// ***                                               *
// *** ***********************************************


// *** ***********************************************
// *** The 5th Row. -  Service & Reference           *
// ***                                               *
// *** ***********************************************


// *** *************************************************************************
// *** The 6th Row. -  Blank area for drivers notes ---- *Future* ---- BarCode.*
// *** the 100% on this row pushes it all over to fit horizontally.            *
// *** *************************************************************************
echo "
<tr valign=bottom>
 <td height=10 valign=bottom >
  <table border=0 cellspacing=0 width=100% valign=bottom >
";

$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

//echo $generator->getBarcode($package['barcode'] , $generator::TYPE_CODE_128);

echo '
    <tr valign=bottom> <td align=left class=F02 valign=bottom style="text-align: center;">
     
    <img src="data:image/png;base64,' . base64_encode($generator->getBarcode($order['barcode'], $generator::TYPE_CODE_128)) . '" > 
 		</td> </tr>
 ';
echo "
  </table>
 </td>
</tr>";

echo '';


echo "</table></td></tr>

";

echo "</table>


";    // *** close the big table.


//if ($copy < $copies)
// echo "<h6> &nbsp; </h6>";   //  cause a page-break

echo "<div style=\"page-break-after: always;\"></div>
</body>";
