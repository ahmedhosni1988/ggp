<?php
//******************************************************************************
//  Invoice Print Control - Single Invoice                        invoice.php  *
//                                                                             *
//  This module is included in:                                                *
//  This module is linked from:  adminbilling_invoice.php                      *
//  This module links to      :                                                *
//                                                                             *
//  This module includes      :  mysql.php                                     *
//                               invoice_print_functions.php                   *
//                               invoice_stmt.php                              *
//                               invoice_print.php                             *
//******************************************************************************
//ModLog:                                                                      *
//*******                                                                      *
//2005-09-21: Seperate customer "Bill-to" address if different                 *
//2005-09-25: bugfix - unlikely but, validate $customer["invoice_lines"],      *
//                     if it was zero(not initialized-but this shouldn't be    *
//                     possible-just surfaced with old data before that field  *
//                     was introduce) but fix it anyway, since it is reduced   *
//                     by 1 to coincide with $control, it wound up as -1, which*
//                     really screwed up the lineitem detail logic.            *
//                                                                             *
//2005-10-18: invoiceoption_rb 6-9  new.                                       *
//              dropped control fields for copies & fontsize...                *
//              moved these to invoiceoption_rb5&6.                            *
//            Put invoiceoptions in understandable variable names.             *
//2006-07-22: Flag invheader record posted flaf to "V"iewed, if,               *
//            viewed online by customer                                        *
//2006-08-22: "Quick print" Icons.                                             *
//2008-06-05: Change doublespace ckbox to "Spacing"-rb7.                       *
//******************************************************************************
?>

<?php


include("setting.php");
include("classes/company.php");
$companyClass = new company($db);


if (isset($_POST['x'])) {
    //	var_dump($data);

    $filename = "invoice_" . $_GET['oi'] . "_" . $_GET['oa'] . "_" . time() . ".xls";
    $c = 0;
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Type: application/vnd.ms-excel");


    include 'excelinvoice.php';

    //ksort($data);
    //var_dump($data);

    $flag = false;
    for ($i = 0; $i < count($data); $i++) {
        $row = $data[$i];
        ksort($row);
// 		if(!$flag) {
// 			// display field/column names as first row
// 			echo implode("\t", array_keys($row)) . "\r\n";
// 			$flag = true;
// 		}
        array_walk($row, 'cleanData');
        echo implode("\t", array_values($row)) . "\r\n";
    }


} else {


    $q = mysql_query("select * from out_orders inner join account on (account.account_id = out_orders.account_id) where id  = '" . $_GET['id'] . "' ") or die (mysql_error());
    $on = mysql_fetch_array($q);
    $on['items'] = ltrim($on['items'], ',');
    $pac = explode(',', $on['items']);
    $ordernos = count($pac) - 1;

    for ($n = 0; $n < 120; $n++) $fmt1[] = "bgcolor = eeeeee";     // light grey
    for ($n = 0; $n < 120; $n++) $fmt2[] = "bgcolor = dddddd";     // silver grey (darker)
    $fmts = array($fmt1, $fmt2);

//for ($n = 0; $n<120; $n++) $fmt1h[] = "bgcolor = 99ccff";    // med blue
//for ($n = 0; $n<120; $n++) $fmt1h[] = "bgcolor = #6DABE8";   // blue from middle of ccc.topbar
    for ($n = 0; $n < 120; $n++) $fmt1h[] = "bgcolor = #649CD5";     // blue from bottom of ccc.topbar
//for ($n = 0; $n<120; $n++) $fmt1h[] = "bgcolor = navy";      // navy
    for ($n = 0; $n < 120; $n++) $fmt2h[] = "bgcolor = ffff00";      // yellow
    $fmtsh = array($fmt1h, $fmt2h);

    for ($n = 0; $n < 120; $n++) $redfmt1[] = "bgcolor = cc0000";  // dark red
    for ($n = 0; $n < 120; $n++) $redfmt2[] = "bgcolor = 990000";  // dark red (darker)
    $redfmt = array($redfmt1, $redfmt2);


    for ($n = 0; $n < 100; $n++) $fmt_prt[] = "bgcolor = ffffff";     // white

    for ($n = 0; $n < 120; $n++) if ($n % 2)
        $topfmt[] = "bgcolor = d0d0f0";
    else
        $topfmt[] = "bgcolor = ddddfd";

    $inputfmp = array("align=right ");
    $inputfmb = array("align=right  bgcolor=eeeeee", "bgcolor=eeeeee");
    $inputfmd = array("align=left   bgcolor=dddddd", "align=right bgcolor=dddddd", "align=right bgcolor=dddddd");
    $inputfmwr = array("align=right  bgcolor=eeeeee", "bgcolor=eeeeee");
    $inputfmwrd = array("align=right  bgcolor=eeeeee", "bgcolor=f4f4f4");
    $inputfmw = array("align=left   bgcolor=eeeeee", "bgcolor=eeeeee");
    $inputfmwlc = array("align=left   bgcolor=eeeeee", "align=center bgcolor=eeeeee");
    $inputfmwlcc = array("align=left   bgcolor=eeeeee", "align=center bgcolor=eeeeee", "align=center bgcolor=eeeeee");
    $inputfmwcs2 = array("align=left   bgcolor=eeeeee colspan=2", "bgcolor=eeeeee");
    $inputfmwcs3 = array("align=left   bgcolor=eeeeee colspan=3", "bgcolor=eeeeee");
    $inputfmwcs4 = array("align=left   bgcolor=eeeeee colspan=4", "bgcolor=eeeeee");
    $inputfmw2cs2 = array("align=left   bgcolor=eeeeee", "bgcolor=eeeeee colspan=2");
    $inputfmwd = array("align=left   bgcolor=eeeeee", "bgcolor=f4f4f4");
    $inputfmwwd = array("align=left   bgcolor=fafafa", "align=right bgcolor=f4f4f4");
    $inputfmn = array("align=left   bgcolor=eeeeee", "align=right bgcolor=eeeeee");
    $inputfmnd = array("align=left   bgcolor=eeeeee", "align=right bgcolor=f4f4f4");
    $inputfmc = array("align=center bgcolor=eeeeee", "bgcolor=eeeeee");
    $inputfmc2cs2 = array("align=center bgcolor=eeeeee", "bgcolor=eeeeee colspan=2");
    $inputfmt = array("width=100 align=left bgcolor=eeeeee", "bgcolor=eeeeee");
    $inputfmtw150 = array("width=150 align=left bgcolor=eeeeee", "bgcolor=eeeeee");
    $inputfmtw180 = array("width=180 align=left bgcolor=eeeeee", "bgcolor=eeeeee");
    $inputfmtw200 = array("width=200 align=left bgcolor=eeeeee", "bgcolor=eeeeee");


    $inputfmwd_prt = array("align=left   bgcolor=f4f4f4", "bgcolor=ffffff");
    $inputfmnd_prt = array("align=left   bgcolor=f4f4f4", "align=right bgcolor=ffffff", "align=right bgcolor=ffffff");
    $inputfmbcs2_prt = array("align=center colspan=2 bgcolor=444444", "bgcolor=000000");
    $inputfmw_prt = array("align=left   bgcolor=ffffff", "bgcolor=ffffff");
    $inputfmwcs2_prt = array("align=left  colspan=2  bgcolor=ffffff", "bgcolor=ffffff");
    $inputfmc_prt = array("align=center bgcolor=ffffff", "bgcolor=ffffff");


    echo '
<link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/css/hideprint.css" type="text/css" media="print">
<link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/css/hidescreen.css" type="text/css" media="screen">
<style>
H6 {page-break-after:always}
</style>
';


    include "invoice_print_functions.php";


//******************************************************************************
//* TEMPORARY JUNK THAT MUST BE REMOVED.                                       *
//******************************************************************************
//$oi        = 2442;
//$ac        = "CCC001";
//$invoiceno = 2442;
//$copies = 1;
//$task = "online";
//$online_badlink = "Y";
//******************************************************************************
//* TEMPORARY JUNK THAT MUST BE REMOVED.                                       *
//******************************************************************************

    $copies = $c_setting['co_invoiceoption_rb5'];

    if ($copies < 1) $copies = 1;

//******************************************************************************
// Get the CONTROL record: retrieve settings                                   *
//******************************************************************************

    $control = $c_setting;

    if ($billing_email_url_ovrd != "") $control["co_url"] = $billing_email_url_ovrd;   //from unique.php

    $co_name = $control["co_name"];


    $maxlines = $control["co_lines_perpage"];
    $save_maxlines = $maxlines;  //* this gets incremented for pg2 etc, so we need to
    //  restore it each loop if printing multiple copies.
    $invoiceoption_1 = $control["co_invoiceoption_1"];
    $invoiceoption_2 = $control["co_invoiceoption_2"];
    $invoiceoption_3 = $control["co_invoiceoption_3"];
    $invoiceoption_4 = $control["co_invoiceoption_4"];
    $invoiceoption_5 = $control["co_invoiceoption_5"];
    $invoiceoption_6 = $control["co_invoiceoption_6"];
    $invoiceoption_7 = $control["co_invoiceoption_7"];
    $invoiceoption_8 = $control["co_invoiceoption_8"];
    $invoiceoption_9 = $control["co_invoiceoption_9"];

    $invoiceoption_rb1 = $control["co_invoiceoption_rb1"];
    $invoiceoption_rb2 = $control["co_invoiceoption_rb2"];
    $invoiceoption_rb3 = $control["co_invoiceoption_rb3"];
    $invoiceoption_rb4 = $control["co_invoiceoption_rb4"];
    $invoiceoption_rb5 = $control["co_invoiceoption_rb5"];
    $invoiceoption_rb6 = $control["co_invoiceoption_rb6"];
    $invoiceoption_rb7 = $control["co_invoiceoption_rb7"];
    $invoiceoption_rb8 = $control["co_invoiceoption_rb8"];
    $invoiceoption_rb9 = $control["co_invoiceoption_rb9"];


//******************************************************************************
// Get the invoice header.                                                     *
//******************************************************************************
    $invoiceno = $_GET['id'];


//$invoiceno = $invhdr["id"];
    $acctno = $invhdr["acctno"];

    $total = round($invhdr["subtotal"]
        + $invhdr["tax1amount"]
        + $invhdr["tax2amount"]
        + $invhdr["tax3amount"]
        + $invhdr["tax4amount"]
        + $invhdr["tax5amount"], 2);

    if ($invhdr["fsapply"] == 'Y') $total += $invhdr["fsamount"];

    $inv_balance = $total - $invhdr["ppd_amount"];

//*Flag it as "Viewed"
    if ($task == "online" or $task == "co") {
        $upd_invhdr = array();
        $upd_invhdr["id"] = $invoiceno;
        $upd_invhdr["posted"] = "V";
        $sql = $db->make_update("invoicehdr", $upd_invhdr, "id", $invoiceno);
        mysql_query($sql);
        //update("invoicehdr",$upd_invhdr);
    }

//* Get TermsCode Description to Print.
    if ($invhdr["terms"] != '') $termsdesc = $companyClass->get_term_details($invhdr["terms"]);
    else $termsdesc = '';

//******************************************************************************
//* If coming from an email link, validate account and random number.          *
//******************************************************************************
    if ($_GET['task'] == "online") {
// if ($_GET['oa'] != $acctno)    $online_badlink = "Y";
        //if ($_GET['rn'] != $random)      $online_badlink = "Y";
    }

//* If bad link.... forget almost all of the rest,
//  we r just going to show the bad-link message & give them a Login button.
    if (!isset($online_badlink)) {


        //******************************************************************************
        // Get the customer record                                                     *
        //*                                                                            *
        //*******************   DUPLICATE CODE: INVOICEALL.PHP  ************************
        //******************************************************************************
        $rc = mysql_query("select * from account where account_name='$acctno'");
        $customer = mysql_fetch_array($rc);
        mysql_free_result($rc);
        //$clid  = $customer["id"];
        $name = $customer["account_company"];
        if ($name == "***Deleted***") $name .= "(" . $customer["account_shortname"] . ")";
        $addr = $customer["account_address"];
        $city = $customer["city"];
        $pcode = $customer["pcode"];
        $billto_name = $customer["billto_company"];
        $billto_addr = $customer["billto_addr"];
        $billto_city = $customer["billto_city"];
        $billto_pcode = $customer["billto_pcode"];
        $billto_apcontact = $customer["billto_apcontact"];
        //*just in case... if not set-> set to Standard.
        if ($customer["invoiceoption_1"] == 0) $customer["invoiceoption_1"] = 1;
        if ($customer["invoiceoption_2"] == 0) $customer["invoiceoption_2"] = 1;
        if ($customer["invoiceoption_3"] == 0) $customer["invoiceoption_3"] = 1;
        if ($customer["invoiceoption_4"] == 0) $customer["invoiceoption_4"] = 1;
        if ($customer["invoiceoption_5"] == 0) $customer["invoiceoption_5"] = 1;
        if ($customer["invoiceoption_6"] == 0) $customer["invoiceoption_6"] = 1;
        if ($customer["invoiceoption_7"] == 0) $customer["invoiceoption_7"] = 1;
        if ($customer["invoiceoption_8"] == 0) $customer["invoiceoption_8"] = 1;
        if ($customer["invoiceoption_9"] == 0) $customer["invoiceoption_9"] = 1;
        //* Set invoice print format overrides, but first be sure it's vaid.
        //if ($customer["invoice_lines"] < 1)  $customer["invoice_lines"] = 1;
        //detail format - this one in the customer table numerically matched the control table,
        //sort of - the customer indicator is 1 higher, as the first choice is 'Standard',
        //so, if we take the override, it must be -1 to co-incide with control.
        //if ($customer["invoice_lines"] != 1)  $invoiceoption_rb1 = $customer["invoice_lines"]-1;

        //*These are numericals(customer) that override checkboxes(control).
        //* 1=Standard(do not override), 2=Yes, 3=No".

        //Checkboxes
        //option 1 - reference
        if ($customer["invoiceoption_1"] != 1) {
            if ($customer["invoiceoption_1"] == 2) $invoiceoption_1 = "Y";
            else                                    $invoiceoption_1 = "N";
        }
        //option 2 - Unused - (was doublespace)
        if ($customer["invoiceoption_2"] != 1) {
            if ($customer["invoiceoption_2"] == 2) $invoiceoption_2 = "Y";
            else                                    $invoiceoption_2 = "N";
        }
        //option 3 - Unused
        if ($customer["invoiceoption_3"] != 1) {
            if ($customer["invoiceoption_3"] == 2) $invoiceoption_3 = "Y";
            else                                    $invoiceoption_3 = "N";
        }
        //option 4 - Print stmt info on invoice
        if ($customer["invoiceoption_4"] != 1) {
            if ($customer["invoiceoption_4"] == 2) $invoiceoption_4 = "Y";
            else                                    $invoiceoption_4 = "N";
        }
        //option 5 - Print F.S. on lineitems
        if ($customer["invoiceoption_5"] != 1) {
            if ($customer["invoiceoption_5"] == 2) $invoiceoption_5 = "Y";
            else                                    $invoiceoption_5 = "N";
        }
        //option 6 - Print Taxes on lineitems
        if ($customer["invoiceoption_6"] != 1) {
            if ($customer["invoiceoption_6"] == 2) $invoiceoption_6 = "Y";
            else                                    $invoiceoption_6 = "N";
        }
        //option 7 - Sort & subtotal by Reference code
        if ($customer["invoiceoption_7"] != 1) {
            if ($customer["invoiceoption_7"] == 2) $invoiceoption_7 = "Y";
            else                                    $invoiceoption_7 = "N";
        }

        //option 8  -  Unused
        if ($customer["invoiceoption_8"] != 1) {
            if ($customer["invoiceoption_8"] == 2) $invoiceoption_8 = "Y";
            else                                    $invoiceoption_8 = "N";
        }
        //option 9  -  Unused
        if ($customer["invoiceoption_9"] != 1) {
            if ($customer["invoiceoption_9"] == 2) $invoiceoption_9 = "Y";
            else                                    $invoiceoption_9 = "N";
        }

        //RadioButtons
        //option rb1 - Lineitem detail
        if ($customer["invoiceoption_rb1"] > 1)
            $invoiceoption_rb1 = $customer["invoiceoption_rb1"] - 1;
        //option rb2 - Service type
        if ($customer["invoiceoption_rb2"] > 1)
            $invoiceoption_rb2 = $customer["invoiceoption_rb2"] - 1;
        //option rb3 - unused
        if ($customer["invoiceoption_rb3"] > 1)
            $invoiceoption_rb3 = $customer["invoiceoption_rb3"] - 1;
        //option rb4 - Wait & Extra; same/separte lines
        if ($customer["invoiceoption_rb4"] > 1)
            $invoiceoption_rb4 = $customer["invoiceoption_rb4"] - 1;
        //option rb5 - unused
        if ($customer["invoiceoption_rb5"] > 1)
            $invoiceoption_rb5 = $customer["invoiceoption_rb5"] - 1;
        //option rb6 - Fontsize
        if ($customer["invoiceoption_rb6"] > 1)
            $invoiceoption_rb6 = $customer["invoiceoption_rb6"] - 1;
        //option rb7 - Print Detail (spacing/wrapping)
        if ($customer["invoiceoption_rb7"] > 1)
            $invoiceoption_rb7 = $customer["invoiceoption_rb7"] - 1;
        //option rb8 - unused
        if ($customer["invoiceoption_rb8"] > 1)
            $invoiceoption_rb8 = $customer["invoiceoption_rb8"] - 1;
        //option rb9 - unused
        if ($customer["invoiceoption_rb9"] > 1)
            $invoiceoption_rb9 = $customer["invoiceoption_rb9"] - 1;

        //Ensure valid RB options
        if ($invoiceoption_rb1 == 0) $invoiceoption_rb1 = 1;
        if ($invoiceoption_rb2 == 0) $invoiceoption_rb2 = 1;
        if ($invoiceoption_rb3 == 0) $invoiceoption_rb3 = 1;
        if ($invoiceoption_rb4 == 0) $invoiceoption_rb4 = 1;
        if ($invoiceoption_rb5 == 0) $invoiceoption_rb5 = 1;
        if ($invoiceoption_rb6 == 0) $invoiceoption_rb6 = 1;
        if ($invoiceoption_rb7 == 0) $invoiceoption_rb7 = 1;
        if ($invoiceoption_rb8 == 0) $invoiceoption_rb8 = 1;
        if ($invoiceoption_rb9 == 0) $invoiceoption_rb9 = 1;

        //*Adjust $maxsize IF they have a customer override for FontSize.
        //Here's the stats;  (per 6" of lineitem body)
        // 1.Small:  41 lines
        // 2.Medium: 33 lines
        // 3.Large:  28 liens

        //$xxx =$invoiceoption_rb6;
        //$yyy =$control["co_invoiceoption_rb6"];

        if ($invoiceoption_rb6 != $control["co_invoiceoption_rb6"]) {
            //1. Control is SMALL
            if ($control["co_invoiceoption_rb6"] == 1) {
                if ($invoiceoption_rb6 == 2) $maxlines = round($maxlines * 0.80);
                if ($invoiceoption_rb6 == 3) $maxlines = round($maxlines * 0.68);
            }
            //2. Control is MEDIUM
            if ($control["co_invoiceoption_rb6"] == 2) {
                if ($invoiceoption_rb6 == 1) $maxlines = round($maxlines * 1.24);
                if ($invoiceoption_rb6 == 3) $maxlines = round($maxlines * 0.85);
            }
            //3. Control is LARGE
            if ($control["co_invoiceoption_rb6"] == 3) {
                if ($invoiceoption_rb6 == 1) $maxlines = round($maxlines * 1.46);
                if ($invoiceoption_rb6 == 2) $maxlines = round($maxlines * 1.18);
            }
            $save_maxlines = $maxlines;  //* do this again, since we just changed it
        }

        //*Put these options in terms we can understand.
        //note: $copies set in adminbilling_invoice
        $option_reference = $invoiceoption_1;
        $option_unused_2 = $invoiceoption_2;  // was - doublespace
        $option_unused_3 = $invoiceoption_3;
        $option_stmt = $invoiceoption_4;
        $option_fs_on_lines = $invoiceoption_5;
        $option_tax_on_lines = $invoiceoption_6;
        $option_sortby_ref = $invoiceoption_7;
        $option_unused_8 = $invoiceoption_8;
        $option_unused_9 = $invoiceoption_9;

        $option_linedetail = $invoiceoption_rb1;
        $option_svctype = $invoiceoption_rb2;
        $option_fromto_detail = $invoiceoption_rb3;
        $option_wait_extra_lines = $invoiceoption_rb4;
        $option_copies = $invoiceoption_rb5;  //not used here, but is used in invoiceall.
        $option_line_fontsize = $invoiceoption_rb6;
        $option_spacing = $invoiceoption_rb7;
        $option_unused_rb8 = $invoiceoption_rb8;
        $option_unused_rb9 = $invoiceoption_rb9;


        //******************************************************************************
        // Get the invoice detail lines.                                               *
        //*                                                                            *
        //*******************   DUPLICATE CODE: INVOICEALL.PHP  ************************
        //*                       (except the array index $n)                          *
        //******************************************************************************
        if ($invoiceoption_1 == "N") $option_sortby_ref = "N";  //* if no ref, then no sortby ref.

        if ($option_sortby_ref == "Y")
            $orderby = "waybill_ref, lineno";
        else
            $orderby = "lineno";
        $rd = mysql_query("select invoicedtl.*,orders.order_date from invoicedtl left join orders on (invoicedtl.waybill = orders.order_id) where invoicedtl.invoiceno=$invoiceno order by $orderby") or die (mysql_error());

        for ($n = 0; $n < mysql_num_rows($rd); $n++) {
            $invoicedtl = mysql_fetch_array($rd);
            $li_order_date[$n + 1] = $invoicedtl["order_date"];
            $li_waybills[$n + 1] = $invoicedtl["waybill"];
            $li_waybill_refs[$n + 1] = $invoicedtl["waybill_ref"];
            $li_chgtype[$n + 1] = $invoicedtl["chgtype"];
            $li_items[$n + 1] = $invoicedtl["item"];
            $li_descn[$n + 1] = $invoicedtl["descn"];
            $li_amount[$n + 1] = $invoicedtl["amount"];
            $li_fsamount[$n + 1] = $invoicedtl["fsamount"];
            $li_subtot[$n + 1] = $li_amount[$n + 1] + $li_fsamount[$n + 1];
            $li_taxes[$n + 1] = $invoicedtl["tax1amount"]
                + $invoicedtl["tax2amount"]
                + $invoicedtl["tax3amount"]
                + $invoicedtl["tax4amount"]
                + $invoicedtl["tax5amount"];
            $li_total[$n + 1] = $li_amount[$n + 1]
                + $li_taxes[$n + 1]
                + $li_fsamount[$n + 1];


            //* From/To details  (1=on-2lines, 2=on-1line, 3=not)
            // if ($invoiceoption_rb3 < 3)  {
            if ($invoicedtl["chgtype"] == "S") {
                $orderid = $invoicedtl["waybill"];
                $ro = mysql_query("select o.*,s.service_name from orders as o left join services as s on (o.service_id = s.service_id) 
   		 where order_id=$orderid");
                $order = mysql_fetch_array($ro);
                mysql_free_result($ro);
                $servicetype = "";


                $servicetype = $order['service_name'];
                if ($order["return"] == "Y") $servicetype .= " &amp Return";

                if ($control["co_invoiceoption_2"] == "Y") {
//  $fpc = " ".str_replace(" ","&nbsp;",$order["from_pc"]);   don't need to do this...
//  $tpc = " ".str_replace(" ","&nbsp;",$order["to_pc"]);     invoice_print does "fieldwrap" - must count lines, so no browser wrapping.
                    $fpc = " " . $order["from_pcode"];
                    $tpc = " " . $order["to_pcode"];
                }
                $li_fromname[$n + 1] = $order["from_name"];
                $li_fromaddr[$n + 1] = $order["from_address"] . $fpc;
                $li_toname[$n + 1] = $order["to_name"];
                $li_toaddr[$n + 1] = $order["to_address"] . $tpc;
                $li_svc[$n + 1] = $servicetype;
                if ($c_setting['company_skid'] == "1") $li_svc[$n + 1] .= " - No. of Skids " . $order['pieces'];
            }
            // }

        } //for ($n = 0; $n < mysql_num_rows($rd); $n++)

        $showlines_count = mysql_num_rows($rd);
        mysql_free_result($rd);

        //******************************************************************************
        //* Assemble the Statement Info.                                               *
        //******************************************************************************

        if ($invoiceoption_4 == "Y") include "invoice_stmt.php";


    } //if (!isset($online_badlink))


//******************************************************************************
//* Put the buttons at the Top, and ....                                       *
//******************************************************************************
    echo "
<div class=\"hideprint\" STYLE=\"width:600;\">
<center>";
//<form>";


    if ($c_setting["co_online_payments"] == "Y")
        //***REAL***
        echo "	<form method=\"post\" action=\"\" >
	
		 &nbsp;&nbsp;&nbsp;&nbsp;
		<input  type=\"submit\" name=\"excel\"  style=\"font-weight:bold;
                 font-size:14;
                 color:white;
                 font-family:Comic Sans Ms;
                 background:#A0A0A0\"  value=\"Export To excel\" class=\"btn btn-danger\" />&nbsp;&nbsp;&nbsp;&nbsp;
		<input type=\"hidden\" name=\"x\" value=\"1\" />
  		</form>
  		
  		<FORM name=_xclick action=https://www.paypal.com/cgi-bin/webscr method=post>  ";
    //***SANDBOX***
    //ho "<FORM name=_xclick action=https://www.sandbox.paypal.com/cgi-bin/webscr method=post>  ";
    else
        echo "  		<form method=\"post\" action=\"\" >

                         		 ";

    echo "<input type=hidden name=invoiceno value=$invoiceno>\r\n";
    if (isset($online_badlink)) {
        showrowerrmsg(array("The link to invoice no.$oi is invalid.<br>
                       Please Login to your account to view invoices.<br><br>"), $fmts[0][0]);
    } else {
        echo "<input type=button
        value=\"&nbsp;&nbsp;Print&nbsp;&nbsp;\"
        onClick=\"print()\"
        style=\"font-weight:bold;
                font-size:14;
                color:white;
                font-family:Comic Sans Ms;
                background:#A0A0A0\"   >
        ";
        //}


        //********************
        // Paypal button.    *
        //********************
        //<INPUT type=hidden value=billing@courier-connex.com                      name=business>
        //<INPUT type=hidden value=\"1234\"                                        name=invoice>
        //<INPUT type=hidden value=\"July Invoice\"                                name=item_name>
        //<INPUT type=hidden value=CAD                                             name=currency_code>
        //<INPUT type=hidden value=100.00                                          name=amount>
        //<INPUT type=hidden value=http://www.courier-connex.com/beta/adminops.php name=return>
        $business = $c_setting["co_online_payments_email"];
        $item_name = "Invoice&nbsp;no.&nbsp;" . $invoiceno;


        if (($_GET['task'] == "online" or $_GET['task'] == "co") and $c_setting["co_online_payments"] == "Y")
            echo "
   <INPUT type=hidden name=cmd              value=_xclick        >
   <INPUT type=hidden name=business         value=$business      >
   <INPUT type=hidden name=invoice          value=$invoiceno     >
   <INPUT type=hidden name=item_name        value=$item_name     >
   <INPUT type=hidden name=currency_code    value=$currency      >
   <INPUT type=hidden name=amount           value=$inv_balance   >
   <INPUT type=hidden name=image_url        value=$logo_filename >
   <INPUT type=hidden name=cpp_header_image value=$logo_filename >
   <INPUT type=hidden name=return           value=$return_url    >

   <INPUT type=image alt=\"Make payments with PayPal - it's fast, free and secure!\"
      src=\"http://www.paypal.com/en_US/i/btn/x-click-but02.gif\" border=10 name=submit>

    &nbsp;&nbsp;
   ";

    }


//* if we came here from entering a single invoice, go back to prep page.
    if ($task == "single")
        echo "<tr><td align=center>   &nbsp;&nbsp;&nbsp;
       <input type=button value=\"&nbsp;&nbsp;Done&nbsp;&nbsp;\"
       onClick=\"document.location.href='adminbilling_prep.php'\"
       style=\"font-weight:bold;
               font-size:14;
               color:white;
               font-family:Comic Sans Ms;
               background:#A0A0A0\"  ></td></tr> ";
    else //* if we came here from Process/Open/History, go back & refresh.
    {
        if ($_GET['task'] == "online") {
            if ($online_badlink) $doneprompt = "Login";
            else                  $doneprompt = "Done";
            echo "<tr><td align=center>   &nbsp;&nbsp;&nbsp;
        <input type=button value=\"&nbsp;&nbsp;$doneprompt&nbsp;&nbsp;\"
        onClick=\"document.location.href='clientlogin.php'\"
        style=\"font-weight:bold;
                font-size:14;
                color:white;
                font-family:Comic Sans Ms;
                background:#A0A0A0\"  ></td></tr> ";
        } else {
            if ($task == "co" or $task == "qp")
                echo "<tr><td align=center>   &nbsp;&nbsp;&nbsp;
         <input type=button value=\"&nbsp;&nbsp;Done&nbsp;&nbsp;\"
         onclick='top.window.close()'
         style=\"font-weight:bold;
                 font-size:14;
                 color:white;
                 font-family:Comic Sans Ms;
                 background:#A0A0A0\"  ></td></tr> ";
            else
                echo "<tr><td align=center>    &nbsp;&nbsp;&nbsp;
         <input type=button value=\"&nbsp;&nbsp;Done&nbsp;&nbsp;\"
         onclick='top.window.close()'
         style=\"font-weight:bold;
                 font-size:14;
                 color:white;
                 font-family:Comic Sans Ms;
                 background:#A0A0A0\"  ></td></tr> ";
        }//*NOT online

        // onClick=\"document.location.href='".$return_to."'\"

    }//*NOT Single

    //echo "<br>*$business*<br>*$invoiceno*<br>*$item_name*<br>*$currency*<br>*$inv_balance*<br>*$logo_filename*<br>*$return_url*";

    echo "<br><br>";

    echo "
   		  	
</form>
</center>
</div> ";


//*****************************************************************
//* Dont show the invoice copy(ies), if this a bogus email link.  *
//*****************************************************************
    if (!isset($online_badlink)) {

//******************************************************************************
//* They need thier own Division.                                              *
//******************************************************************************
        if ($copies > 1) $pagebreak = "Y"; else $pagebreak = "N";

        for ($cp = 1; $cp < $copies + 1; $cp++) {
            if ($copies > $cp) $pagebreak = "Y"; else $pagebreak = "N";
            $maxlines = $save_maxlines; //refresh as it gets altered for pg2 etc.
            include "invoice_print.php";
            if ($pagebreak == "N") echo "<br>";

//******************************************************************************
//* ... Put the buttons after each                                             *
//******************************************************************************
            echo "
 <div class=\"hideprint\" STYLE=\"width:600;\">
 <center>

  		
  		<form method=\"post\" action=\"\" >
	
		 &nbsp;&nbsp;&nbsp;&nbsp;
		<input  type=\"submit\" name=\"excel\"  style=\"font-weight:bold;
                 font-size:14;
                 color:white;
                 font-family:Comic Sans Ms;
                 background:#A0A0A0\"  value=\"Export To excel\" class=\"btn btn-danger\" />&nbsp;&nbsp;&nbsp;&nbsp;
		<input type=\"hidden\" name=\"x\" value=\"1\" />
  		
  		";

            echo "<input type=hidden name=invoiceno value=$invoiceno>\r\n";

            echo "<input type=button
       value=\"&nbsp;&nbsp;Print&nbsp;&nbsp;\"
       onClick=\"print()\"
       style=\"font-weight:bold;
               font-size:14;
               color:white;
               font-family:Comic Sans Ms;
               background:#A0A0A0\"   >
       &nbsp;&nbsp;&nbsp;&nbsp;";

//* if we came here from entering a single invoice, go back to prep page.
            if ($task == "single")
                echo "<tr><td align=center>
       <input type=button value=\"&nbsp;&nbsp;Done&nbsp;&nbsp;\"
       onClick=\"document.location.href='adminbilling_prep.php'\"
       style=\"font-weight:bold;
               font-size:14;
               color:white;
               font-family:Comic Sans Ms;
               background:#A0A0A0\"  ></td></tr> ";
            else //* if we came here from Process/Open/History, go back & refresh.
            {
                if ($task == "online") {
                    if ($online_badlink) $doneprompt = "Login";
                    else                  $doneprompt = "Done";
                    echo "<tr><td align=center>
        <input type=button value=\"&nbsp;&nbsp;$doneprompt&nbsp;&nbsp;\"
        onClick=\"document.location.href='clientlogin.php'\"
        style=\"font-weight:bold;
                font-size:14;
                color:white;
                font-family:Comic Sans Ms;
                background:#A0A0A0\"  ></td></tr> ";
                } else {
                    if ($task == "co" or $task == "qp")
                        echo "<tr><td align=center>
         <input type=button value=\"&nbsp;&nbsp;Done&nbsp;&nbsp;\"
         onclick='top.window.close()'
         style=\"font-weight:bold;
                 font-size:14;
                 color:white;
                 font-family:Comic Sans Ms;
                 background:#A0A0A0\"  ></td></tr> ";
                    else
                        echo "<tr><td align=center>
         <input type=button value=\"&nbsp;&nbsp;Done&nbsp;&nbsp;\"
         onClick=\"document.location.href='adminbilling_proc.php?task=$task&pa=$pa&pb=$pb&pi=$pi&pd=$pd&ps=$ps&pe=$pe&pf=$pf&pt=$pt'\"
         style=\"font-weight:bold;
                 font-size:14;
                 color:white;
                 font-family:Comic Sans Ms;
                 background:#A0A0A0\"  ></td></tr> ";
                }//*NOT online
            }//*NOT Single

            echo "<br><br>";

            echo "
 </form>
 </center>
 </div> ";
            //******************************************************************************
            //* They need thier own Division.                                              *
            //******************************************************************************

        } //for ($cp = 1; $cp < $copies+1; $cp++)

    }


}

function cleanData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    $str = str_replace("<br>", "\"\r\n\"", $str);
    $str = str_replace("&nbsp;", " ", $str);

    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

function br2nl($input)
{
    return preg_replace('/<br(\s+)?\/?>/i', "\n", $input);
}

?>


