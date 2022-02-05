<?php
//******************************************************************************
//  Labels Display Control                                                     *
//                                                                             *
//  This module is included in:                                                *
//  This module is linked from:  update_orderstatus.php                        *
//  This module links to      :                                                *
//                                                                             *
//  This module includes      :  mysql.php                                     *
//                                                                             *
//                               label_print.php                               *
//                                                                             *
//******************************************************************************
//ModLog:                                                                      *
//*******                                                                      *
//2009-04-21: New                                                              *
//******************************************************************************
include 'setting.php';
include('includes/php-barcode-generator-master/src/BarcodeGenerator.php');
include('includes/php-barcode-generator-master/src/BarcodeGeneratorPNG.php');
include('includes/php-barcode-generator-master/src/BarcodeGeneratorSVG.php');
include('includes/php-barcode-generator-master/src/BarcodeGeneratorJPG.php');
include('includes/php-barcode-generator-master/src/BarcodeGeneratorHTML.php');
//include('classes/logger.php');

?>
<head>
    <meta charset="utf-8">
    <title>Shipping Label</title>
    <link rel="stylesheet" type="text/css" href="<?php echo SITEURL . '/' . STYLE . '/'; ?>css/hideprint.css"
          media="print">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


    <?php

    echo '<link rel="stylesheet" type="text/css"  href="' . SITEURL . '/' . STYLE . '/css/thermal_printer.css" media="print">';


    // if (!isset($_SESSION['logged_in'] ) ){
    // 	header ("Location: ".SITEURL."");
    // }
    $qu = mysql_query("select * from status");
    while ($rs = mysql_fetch_array($qu)) {
        $package_status[$rs['disporder']] = $rs['statusname'];
    }

    if (isset($_GET['id'])) $ordernum = $_GET['id'];
    else header("Location: " . SITEURL . "");

    // $ordernum = 9615;  //++++++++++++++++++++++++++++++++
    //******************************************************************************
    // Read the order record                                                       *
    //******************************************************************************


    echo " </head>

<div class=\"no-print\" >
<center>

<form name=labelform
      method=post
     >
<input type=hidden name=button>
";

    echo "
       <input type=button
       value=\"طباعة\"
       onClick=\"print()\"
       style=\"font-weight:bold;
               font-size:14;
               color:white;
               font-family:Comic Sans Ms;
               background:#A0A0A0\"   >
		
        &nbsp;&nbsp;&nbsp;
		
       <input type=submit
              value=\"&nbsp; اغلاق\n &nbsp;\"
              onClick=\"window.close()\"
              style=\"font-weight:bold;
                      font-size:14;
                      color:white;
                      font-family:Comic Sans Ms;
                      background:#A0A0A0\">
     ";

    if ($returnto == "adminorder") {
        echo "
  <input type=button
       value=\"Print\nShipping Labels\"
       onClick=\"print()\"
       style=\"font-weight:bold;
               font-size:14;
               color:white;
               font-family:Comic Sans Ms;
               background:#A0A0A0\"   >
  &nbsp;&nbsp;
  <input type=submit
         value=\"Enter another order\nfor this client\"
         onClick=\"Javascript:document.labelform.button.value = 'another'\"
         style=\"font-weight:bold;
                 font-size:14;
                 color:white;
                 font-family:Comic Sans Ms;
                 background:#A0A0A0\"  >
  &nbsp;&nbsp;
 <input type=submit
              value=\"&nbsp;Print\nWaybill&nbsp;\"
              onClick=\"Javascript:document.labelform.button.value = 'waybill'\"
              style=\"font-weight:bold;
                      font-size:14;
                      color:white;
                      font-family:Comic Sans Ms;
                      background:#A0A0A0\">
  &nbsp;&nbsp;
  <input type=submit
         value=\"&nbsp; Done\n &nbsp;\"
         onClick=\"Javascript:document.labelform.button.value = 'done'\"
         style=\"font-weight:bold;
                 font-size:14;
                 color:white;
                 font-family:Comic Sans Ms;
                 background:#A0A0A0\">";
    }

    echo "</form>";


    echo "
</center>
</div>";


    $pac = explode(',', $ordernum);

    for ($i = 0; $i < count($pac); $i++) {

        $ri = mysql_query("select *,orders_package.order_status as mainstatus from orders_package 
        inner join orders on (orders_package.order_id = orders.order_id)
        inner join package_type on  (package_type.package_id = orders_package.package_type )
        inner join account on  (account.account_id = orders.account_id )
        where id=" . $pac[$i] . "    ");

        $order = mysql_fetch_array($ri);

        include "label_print.php";
        mysql_free_result($ri);


    }


    // if ($copies > 1)  {
    //  for ($n = 1; $n < $copies; $n++) {
    //   $copy++;

    //   }
    //  }else{
    //  	$copies = 1;
    //  }


    echo " </html>  ";

    ?>

