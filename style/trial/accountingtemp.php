<?php

function template_prepare_invoice()
{
    global $lang, $acc, $pay, $bill;
    echo '
		
		<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/invoice.js"></script>
		
		<div class="row">

		<div class="col-xs-12 col-sm-6 widget-container-col ui-sortable" style="Margin:auto; float:none;">
		
		<div class="widget-box widget-color-blue ui-sortable-handle">
		<div class="widget-header">
		<div class="widget-title">' . $lang[686] . '</div>
		</div>	
				
		<div class="widget-body">
		<div class="widget-main">
				
<form name="prepare_invoice" id= "prepare_invoice" action="' . SITEURL . '/administrator/accounting.php?action=prepare_invoice" method="post" class="form-horizontal" role="form" >
<!-- 
						<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[17] . '</label>
<div class="col-sm-9">
<input class="form-control ui-autocomplete-input"  type="text" name="auto_account_name" id="auto_account_name"   size="25" autocomplete="off" data="account_name" value="' . $_GET['acctno'] . '" />
</div>
</div>
		
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right"> ' . $lang[879] . '</label>
<div class="col-sm-5">
<select  class="col-xs-10 col-sm-5 chosen-select" name="account_acctname" >
<option value="">' . $lang[204] . '
 </option>
';
    for ($i = 0; $i < count($acc); $i++) {
        echo '<option value="' . $acc[$i]['account_id'] . '">' . $acc[$i]['account_company'] . ' | ' . $acc[$i]['account_name'] . '</option>';
    }
    echo '
</select>
</div>
</div>	
		
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang['406'] . '</label>	
<div class="col-sm-9">
<select name="client" style="width:300px; margin:auto auto 10px auto;">
<option value="*"  >' . $lang['399'] . '</option>
';

    if (is_array($acc)) {
        for ($i = 0; $i < count($acc); $i++) {
            echo '<option value="' . $acc[$i]['account_id'] . '"  >' . $acc[$i]['account_name'] . ' | ' . $acc[$i]['account_company'] . '</option>';
        }
    }
    echo '
</select>
</div>
</div>
-->

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang['55'] . '</label>
<div class="col-sm-9">
<input type="text" name="order_id" value="" / >
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang['outorder_no'] . '</label>
<div class="col-sm-9">
<input type="text" name="outorder_id" value="" / >
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[401] . '</label>
<div class="col-sm-9" >
<input type="text" name="invoice_date" id="invoice_date" value=""  /> 

<script type="text/javascript">
	$(\'#invoice_date\').datepicker({
		format: \'yyyy-mm-dd\'
});
	$(\'#invoice_date\').datepicker(\'setDate\', new Date());

</script>

</div>
</div>

<hr/>




<div class="form-group" style="text-align:center;">
<input type="button" id="prepwaybills" name="prepwaybills" onclick="prepare_invoices();"  value="' . $lang['prepare_invoice'] . '" class="btn btn-info"  name="edituser" style="margin:10px auto; float:none;"/>
</div>
<div style="clear:both;"></div>



</form>
				
		
				
				</div>
				</div>
				</div>
				</div>
			
				



		
			
				</div>

';
}

function template_process_invoice()
{
    global $lang ,$reviewed;


    echo '
  <script>
  $(document).ready(function () {
	  $("#process_invoice").tabs();
  });
</script>

<div id="process_invoice" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul> 
   <li><a href="accounting.php?action=process_invoice&type=get_data';
    if ($reviewed==1) {
        echo '&reviewed=1"';
    } else {
        echo '"';
    }
    echo' >' . $lang[113] . '</a></li>
</ul>

<div id="process_invoice-0" >
</div>
</div>


';
}

function template_process_invoice_data()
{
    global $lang, $proce, $tab, $deposits, $print, $client1, $tax,$total_pages,$pageno,$reviewed,$type,$name,$from,$to,$is_search;
    
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . "&type=report";
    //echo $actual_link;

    global $status,$order_type;
    echo '
	<script src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>
        <script src="' . SITEURL . '/' . STYLE . '/jscript/scanner.js"></script>
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/invoice.js"></script> 

		<script>
			function opennewtab() {
				var win = window.open(\''.$actual_link. '\', \'_blank\');
	}
	function close_tab(tab_name, back_index) { 
		$("#"+tab_name).find(\'.ui-tabs-nav li:eq(\' + $("#"+tab_name).tabs("option", "active") + \')\').remove();
		$("#"+tab_name).tabs("refresh");
		if (back_index != \'\') $("#" + tab_name).tabs(\'option\', \'active\', back_index);
	}
		</script>		
<div class="waybill_but removeprint" >
<center>	';
    $print = 0;
    if ($print == "1") {
        echo '<input type="button" name="print" value="Print" onclick="printData(\'invoices\');"  class="btn btn-info">
';
    }

    if ($tab != "account_statment") {
        echo '
<input type="button" name="selectall" value="' . $lang['595'] . '" onclick="select_all(\'invoices\');"  class="btn btn-info removeprint">
&nbsp;&nbsp;
<input type="button" name="deselect" value="' . $lang['596'] . '" onclick="deselect(\'invoices\');" class="btn btn-info removeprint" >
&nbsp;&nbsp;
<input type="button" name="printlist"  value="' . $lang['1018'] . '" onclick="print(\'invoices\');" class="btn btn-info removeprint" >

&nbsp;&nbsp;
&nbsp;&nbsp;';
        if ($is_search == 1) {
            echo '<input  type="button" name="close" onclick="close_tab(\'tabs_history\',\'0\');" value="' . $lang[200] . '" class="btn btn-info" />';
        }

        echo' <!--
' . ($tab == "search_invoice" ? '' : '<input type="button" name="cancel_invoices" value="' . $lang['682'] . '" onclick="cancel_invoices();" class="btn btn-danger removeprint" >') . '
';
        echo '--></center>	'  ;
    }

    if ($tab == "open_invoice") {
        echo '<input type="hidden" name="get_open_invoice" value="1" />
<input type="hidden" name="client" value="' . $_POST['client'] . '" />
<input type="hidden" name="billingcode" value="' . $_POST['billingcode'] . '" />
<input type="hidden" name="invoice_no" value="' . $_POST['invoice_no'] . '" />
<input type="hidden" name="due_invoice_date" value="' . $_POST['due_invoice_date'] . '" />
<input type="hidden" name="billingcode" value="' . $_POST['billingcode'] . '" />
	';
    }

    echo '
	<br>
	
	<br>
		</div>
<div style="clear:both;"></div>
<script type="text/javascript">
$(document).ready(function (){
	//var all = $(\'#invoices\').dataTable({
		
	//});
	$(\'div.dataTables_filter input\').addClass(\'removeprint \');
	$(\'div.dataTables_length \').addClass(\'removeprint col-xs-6\');
	$(\'div.invoices_filter \').addClass(\'col-xs-6\');
	
});
</script>
<div class="row">
	<div class="col-xs-12 text-center">
		<input style="background-image: url('.'https://www.w3schools.com/css/searchicon.png'.');
		background-position: 99%;
		background-repeat: no-repeat;
		width: 100%;
		font-size: 16px;
		padding: 12px 40px 12px 40px;
		border: 1px solid #ddd;
		margin-bottom: 12px;" type="text" id="myInput" onkeyup="invoice_search()" placeholder="بحث عن اليوم, العميل, رقم الطلبيه ..." class="hideprint">
	
	<div style="overflow-x: auto">
<table  border="1" class="table table-striped table-bordered table-hover" id="invoices"  data-page-length=\'25\' style="width:100%;">';
    if (isset($name) && $name != '') {
        echo '<div class="col-xs-12 text-center"><h4>كشف حساب العميل ' . $name . '</h4>من '.$from.' إلي '.$to.'</div>';
    }
    echo '<link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/css/hideprint.css"  />
<thead>
<tr>
<th>'. $lang[74] . '</th>
<th>'. $lang['easy_order_id'] . ' </th> 
<th>رقم النظام </th> 
<th>'. $lang[693] . '</th>
<th>اسم العملية</th>
<th>'. $lang[401] . '</th>
<th>'. $lang[867] . '</th>
<th>'. $lang[1020] . '</th>
<th class="removeprint">'.$lang[177].'</th>
<th class="removeprint">'.$lang[610].'</th>
<th >المجموع</th>
<th class="removeprint"></th>
</tr>
</thead>
<tbody>

';

    // var_dump($proce);
    if (is_array($proce) && count($proce) > 0) {
        $total_sale = 0;
        $total_amount = 0;
        $total_payments = 0;
        $total_balance = 0;

        $subtotal = 0;
        $fsamount = 0;
        $tax1 = 0;
        $tax2 = 0;
        $tax3 = 0;
        $tax4 = 0;
        // 		echo'<pre>';
        // var_dump($proce[0]);
        // echo'</pre>';
        for ($i = 0; $i < count($proce); $i++) {
            if ($tab == "open_invoice") {
                $keycnt = count($deposits);
                for ($k = 0; $k < $keycnt; $k++) {   //in case there are > 1 cust after each other with deposits & no invoices
                    $firstamount = reset($deposits);
                    $firstkey = key($deposits);


                    $firstkey_comp = $firstkey . "            ";     //Force to
                    $acctno_comp = $proce[$i]['acctno'] . "            ";       //string
                    $firstkey_comp = substr($firstkey_comp, 0, 12);  //for a compatible
                    $acctno_comp = substr($acctno_comp, 0, 12);    //comparision

                    if ($firstkey_comp < $acctno_comp) {
                        $bcdesc = "&nbsp;";
                        if ($use_billingcodes) {
                            for ($ii = 1; $ii < 10; $ii++) {
                                if ($invhdr["billing_code"] == $bcno[$ii]) {
                                    $bcdesc = "(" . $bclist[$ii] . ")";
                                }
                            }
                            //$invhdr["acctno"] = $invhdr["acctno"]."(".$bcdesc.")";
                        }

                        echo '<tr>
						<td>Deposits</td>
					    <td>' . $firstkey . '</td>
                        <td>' . $bcdesc . '</td>
					    <td></td>
						<td></td>
					    <td></td>
						<td>' . sprintf("%01.2f", $firstamount) . '</td>
					    <td></td>
						<td class="removeprint"></td>
						</tr>';

                        $total_payments = $total_payments + $firstamount;
                        $total_balance = $total_balance - $firstamount;
                        $fmt = !$fmt;
                        $firstamount = 0;
                    }

                    if ($firstamount == 0) {
                        unset($deposits[$firstkey]);
                    }
                }
            }


            $total_amount += sprintf("%01.2f", $proce[$i]['invoice_total']);
            $total_payments += $proce[$i]['payments'];
            $total_balance += sprintf("%01.2f", ($proce[$i]['invoice_total'] - $proce[$i]['payments']));

            $subtotal += sprintf("%01.2f", $proce[$i]['subtotal']);
            $fsamount += sprintf("%01.2f", $proce[$i]['fsamount']);
            $tax1 += sprintf("%01.2f", $proce[$i]['tax1amount']);
            $tax2 += sprintf("%01.2f", $proce[$i]['tax2amount']);
            $tax3 += sprintf("%01.2f", $proce[$i]['tax3amount']);
            $tax4 += sprintf("%01.2f", $proce[$i]['tax4amount']);

        
            if ($proce[$i]['order_status'] == "1") {
                $class_status = "label label-sm label-warning";
            } elseif ($proce[$i]['order_status'] == "0") {
                $class_status = "label label-sm label-info";
            } elseif ($proce[$i]['order_status'] == "2") {
                $class_status = "label label-sm label-warning";
            } elseif ($proce[$i]['order_status'] == "3") {
                $class_status = "label label-sm label-success";
            } elseif ($proce[$i]['order_status'] == "4") {
                $class_status = "label label-sm label-inverse";
            } elseif ($proce[$i]['order_status'] == "5") {
                $class_status = "label label-sm label-danger";
            }

        
            if ($proce[$i]['order_type'] == "1") {
                $class_type = "label label-sm label-success";
            } elseif ($proce[$i]['order_type'] == "2") {
                $class_type = "label label-sm label-danger";
            } elseif ($proce[$i]['order_type'] == "5") {
                $class_type = "label label-sm label-info";
            }


            echo '
			
<tr id="'.$proce[$i]['id'].'">
<td> ';

//             if ($_SESSION['user_type'] == 'accounting') {
//                 echo '
            // <button class="removeprint btn btn-primary btn-xs" style="width:30px; height:30; margin:2px;" onclick="change_price_version(\''. $proce[$i]['clid'] .'\',\''.$proce[$i]['order_id'].'\',\''.($proce[$i]['price_version_account_id']?$proce[$i]['price_version_account_id']:'').'\')">
            // 		<i class="fa fa-external-link bigger-125 icon-only"></i>
            // </button>
            // <button class=" removeprint btn btn-success btn-xs" style="width:30px; height:30; margin:2px;" onclick="change_price_version(\''. 0 .'\',\''.$proce[$i]['order_id'].'\',\''.($proce[$i]['price_version_system_id']?$proce[$i]['price_version_system_id']:'').'\')">
            // 		<i class="fa fa-external-link bigger-125 icon-only"></i>
            // </button>';
//             }

            echo '
<button class=" removeprint btn btn-success btn-xs" style="width:30px; height:30; margin:2px;" 
		onclick="show_invoice(\''.$proce[$i]['id'].'\',\''.$reviewed.'\')">
	<i class="fa fa-file-text-o bigger-125 icon-only"></i>
</button>

<button type="button" class="removeprint btn  btn-info btn-xs"   type="button"   onclick="refreshwaybill(\'' .($proce[$i]['order_id'] == '' ?  : $proce[$i]['order_id']). '\');">
<i class="fa fa-print "  ></i>
</button>

<a href="' . SITEURL . '/administrator/invoicing/index.php?id=' . $proce[$i]['id'] .'" target="_blank" class="removeprint" ><img src="' . SITEURL . '/' . STYLE . '/css/images/printer.jpg" width="25" height="25"  /></a>&nbsp; &nbsp; &nbsp;' . $proce[$i]['id'] . ' 




</td>

<td> ' . $proce[$i]['easy_order_id'] . '</td>
<td> ' . $proce[$i]['order_id'] . '</td>

		<!-- <td>' . ($tab == "open_invoice" ? "<a href=\"#\" onclick = \"cashreceipts_history('" . $proce[$i]['clid'] . "','" . $proce[$i]['acctno'] . "','" . date("Y-m-01", strtotime("-3 Months")) . "')\" \" class=\"removeprint\">$</a>&nbsp; &nbsp; &nbsp; <a href=\"#\" onclick = \"cashreceipts_add('" . $proce[$i]['clid'] . "','" . $proce[$i]['acctno'] . "','" . date("Y-m-d") . "')\" \">" . $proce[$i]['acctno'] . "</a>" : $proce[$i]['acctno']) . '</td> -->
		
		<td class="smallprint">' . $proce[$i]['company'] . '</td>
		<td class="smallprint">' . $proce[$i]['operation_name'] . '</td>
<td class="smallprint">' . $proce[$i]['date'] . '</td>
<td>' . $proce[$i]['pieces'] . '</td>
<td>' . sprintf('%0.2f', $proce[$i]['order_size']/10000) . '</td>
<td class="removeprint" ><span class = "'.$class_status.'">' . $status[$proce[$i]['order_status']] .'</span></td>
<td class="removeprint"><span class = "'.$class_type.'">' . $order_type[$proce[$i]['order_type']] . '</span></td>

					
							
<td>' . sprintf("%01.2f", $proce[$i]['invoice_total']) . '</td>

<td class="removeprint"><input type="checkbox" name="invoice_id[]" value="' . $proce[$i]['id'] . '" ></td>

</tr>
';
        }

        echo '
		<tr>
						<td>المجموع</td>
						<td></td>
                        <td></td>
					    <td></td>
						<td></td>
						<td></td>
						<td class="removeprint"  ></td>
						<td class="removeprint" ></td>
			            <td class="removeprint" >' . $subtotal . '</td>

						<td class="removeprint"></td>
';
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }

    echo '
	</tbody>
</table></div>
</div>
</div>
';
    if ($type == "get_data") {
        echo'
<ul class="pagination removeprint">
<li><a href="'.SITEURL.'/administrator/accounting.php?action=process_invoice&type=get_data&reviewed='.$reviewed.'&pageno=1">First</a></li>
<li class="'.(($pageno <= 1) ?'disabled' : '').'">
	<a href="'.(($pageno <= 1) ? '#' : SITEURL.'/administrator/accounting.php?action=process_invoice&type=get_data&reviewed='.$reviewed.'&pageno='.($pageno - 1)).'">Prev</a>
</li>
<li class="'.(($pageno >= $total_pages) ?'disabled' : '').'">
	<a href="'.(($pageno >= $total_pages) ? '#' : SITEURL.'/administrator/accounting.php?action=process_invoice&type=get_data&reviewed='.$reviewed.'&pageno='.($pageno + 1)).'">Next</a>
</li>
<li><a href="'.SITEURL.'/administrator/accounting.php?action=process_invoice&type=get_data&reviewed='.$reviewed.'&pageno='.$total_pages.'">Last</a></li>
</ul>
';
    }
}


function template_edit_invoice()
{
    global $lang, $inv_hdr, $inv_dtls, $acc_dtl, $tax_group, $payment_term, $c_setting, $payment_type, $taxname;
    global $errormsg, $total, $showlines_count, $customer, $fsapply;


    global $li_lineno, $li_items, $li_descns, $li_amounts, $li_taxgroups, $li_fs_rate, $li_chgtypes, $edit_li_fs_rate, $edit_li_taxgroups;

    global $ppd_amount, $ppd_method, $ppd_ref, $fsapply, $copies, $name, $addr, $city, $pcode, $invoicedate, $invoiceno, $acctno, $clid, $duedate, $message, $printed, $posted, $delivered, $billingpd;
    global $tobeposted, $tobedelivered, $show_tobeposted, $show_tobedelivered;

    global $printed, $posted, $delivered;

    global $subtotal_fmt, $fsamount_fmt, $tax1amount_fmt, $tax2amount_fmt, $tax3amount_fmt, $tax4amount_fmt, $tax5amount_fmt, $total_fmt, $ppd_amount_fmt, $balance_fmt;

    global $fs_rate_txgrp1, $fs_rate_txgrp2, $fs_rate_txgrp3, $fs_rate_txgrp4, $fs_rate_txgrp5;
    //var_dump($taxname);
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/invoice.js"></script>

		<div class="row">
';

    if ($errormsg != '') {
        echo $errormsg;
    }
    echo '

				

<form id="edit_invoice" method="post" action="' . formurl . '/accounting.php?action=edit_invoice&invoice_id=' . $_GET['invoice_id'] . '&from=' . $_GET['from'] . '" class="form-horizontal" role="form" >
<input type="hidden" name="invoiceno" value="' . $invoiceno . '" />
<input type="hidden" name="random" value="' . $random . '" />
<input type="hidden" name="clid" value="' . $clid . '" />
<input type="hidden" name="acctno" value="' . $acctno . '" />
<input type="hidden" name="task" value="' . $_GET['from'] . '" />
<input type="hidden" id="showlines_count" name="showlines_count" value="' . $showlines_count . '" />
		
<input type="hidden" name="printed" value="' . $printed . '" />
<input type="hidden" name="posted" value="' . $posted . '" />
<input type="hidden" name="delivered" value="' . $delivered . '" />
		
		
<input type=hidden name=fs_rate_txgrp1 value="' . $fs_rate_txgrp1 . '">
<input type=hidden name=fs_rate_txgrp2 value="' . $fs_rate_txgrp2 . '">
<input type=hidden name=fs_rate_txgrp3 value="' . $fs_rate_txgrp3 . '">
<input type=hidden name=fs_rate_txgrp4 value="' . $fs_rate_txgrp4 . '">
<input type=hidden name=fs_rate_txgrp5 value="' . $fs_rate_txgrp5 . '">
		
		
		<div class="col-xs-12 col-sm-6 widget-container-col ui-sortable">
		
		<div class="widget-box widget-color-blue ui-sortable-handle">
		<div class="widget-header">
		<div class="widget-title">' . $lang[849] . '</div>
		</div>	
				
		<div class="widget-body">
		<div class="widget-main">
				
		
		<table  style="width:49%; float:left;">
<tr>
<td width="90">' . $lang[531] . ' : </td>
<td>' . $acctno . '</td>
</tr>

<tr>
<td colspan="2">
' . $name . '<br>
' . $addr . '<br>
' . $city . '<br>
' . $pcode . '<br>
</td>
</tr>
</table>

<table border="0" style="width:49%; float:right;">
<tr>
<td>' . $lang[532] . '</td>
<td>' . $invoiceno . '</td>
</tr>

<tr>
<td>' . $lang[280] . '</td>
<td><input type="text" name="date" value="' . $invoicedate . '" id="date" /></td>
<script type="text/javascript">
	$(\'#date\').datepicker({
		format: \'yyyy-mm-dd\'
});
</script>
</tr>

<tr>
<td>' . $lang[533] . '</td>
<td><select name="terms">
';
    $days = 0;
    for ($i = 0; $i < count($payment_term); $i++) {
        if ($payment_term[$i]['pt_id'] == $customer['account_terms']) {
            $days = $payment_term[$i]['pt_due'];
        }

        echo '<option value="' . $payment_term[$i]['pt_name'] . '" ' . ($payment_term[$i]['pt_name'] == $inv_hdr->terms ? 'selected' : '') . ' >' . $payment_term[$i]['pt_name'] . '</option>';
    }

    echo '</select></td>
</tr>

<tr>
<td>Due Days</td>
<td><input type="text" name="noofdue" value="' . $days . '" size="5" disabled/></td>
</tr>

<tr>
<td>' . $lang[548] . '</td>
<td><input type="text" name="duedate" value="' . $duedate . '" id="duedate" /></td>
<script type="text/javascript">
	$(\'#duedate\').datepicker({
		format: \'yyyy-mm-dd\'
});
</script>
</tr>

<tr>
<td>' . $lang[157] . '</td>
<td> 
<select name="tax_group">
';

    for ($i = 0; $i < count($tax_group); $i++) {
        echo '<option value="' . $tax_group[$i]['taxgroup_id'] . '" ' . ($tax_group[$i]['taxgroup_id'] == $customer['account_taxgroup'] ? 'selected' : '') . ' >' . $tax_group[$i]['taxgroup_id'] . '.' . $tax_group[$i]['taxgroup_name'] . '</option>';
    }

    echo '</select>
</td>
</tr>

</table>

<div style="clear:both;"></div>

<table class="table table-striped table-bordered table-hover" id="inv_dtls" border="1" width="100%">

<tr>
<th>' . $lang[534] . '</th>
<th>' . $lang[535] . '</th>
<th>' . $lang[59] . '</th>
<th>' . $lang[379] . '</th>
<th>' . $lang[157] . '</th>
</tr>
';

    $t = 0;
    global $li_lineno, $li_items, $li_descns, $li_amounts, $li_taxgroups, $li_fs_rate, $li_chgtypes, $edit_li_fs_rate, $edit_li_taxgroups;

    for ($n = 1; $n < $showlines_count + 1; $n++) {
        echo '
<tr>
<td>' . ($n) . '</td>
<td><input type="text" name="li_items[' . $n . ']" value="' . $li_items[$n] . '" /></td>
<td><input type="text" name="li_descns[' . $n . ']" value="' . $li_descns[$n] . '" /></td>
<td><input type="text" name="li_amounts[' . $n . ']" value="' . $li_amounts[$n] . '" size="5"/></td>
<td><input type="text" name="li_taxgroups[' . $n . ']" value="' . $li_taxgroups[$n] . '"  size="5"/></td>
		<input type="hidden" name="li_chgtypes[' . $n . ']" value= "' . $li_chgtypes[$n] . '" />
		<input type="hidden" name="li_fs_rate[' . $n . ']" value= "' . $li_fs_rate[$n] . '" />
		<input type="hidden" name="edit_li_fs_rate[' . $n . ']" value= "' . $edit_li_fs_rate[$n] . '" />
		<input type="hidden" name="edit_li_taxgroups[' . $n . ']" value= "' . $edit_li_taxgroups[$n] . '" />
				
</tr>
';
    }


    echo '

<tr>
<td colspan="5" style=" text-align:center;">
<input type="submit" name="addrows" value="' . $lang[221] . '"   style="margin:auto 10px; text-align:center;" class="btn btn-info"/>
</td>
</tr>
</table>

		</div>
		</div>
		</div>
		</div>


		<div class="col-xs-12 col-sm-6 widget-container-col ui-sortable">
		
		<div class="widget-box widget-color-blue ui-sortable-handle">
		<div class="widget-header">
		<div class="widget-title">' . $lang[850] . '</div>
		</div>	
				
		<div class="widget-body">
		<div class="widget-main">
				
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[89] . '</label>
<div class="col-sm-9"><textarea name="message" cols="50" rows="4" style="height:auto;">' . ($message == '' ? $c_setting['co_invoice_message'] : $message) . '</textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[536] . '</label>
<div class="col-sm-9">  ' . $lang[537] . '(' . $printed . ')&nbsp;-&nbsp;' . $lang[538] . '(' . $delivered . ')&nbsp;-&nbsp;' . $lang[539] . '(' . $posted . ')
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[540] . '</label>
<div class="col-sm-9">

<div style="width:50%; float:left; text-align:center;">
<div>From </div> <input type="text" name="date_from" id="date_from" value="' . substr($billingpd, 0, 10) . '" /> 
<script type="text/javascript">
	$(\'#date_from\').datepicker({
		format: \'yyyy-mm-dd\'
});

</script>
</div>

<div style="width:50%; float:left; text-align:center;">
<div>To </div><input type="text" name="date_to" id="date_to" value="' . substr($billingpd, 10, strlen($billingpd)) . '" />
<script type="text/javascript">
	$(\'#date_to\').datepicker({
		format: \'yyyy-mm-dd\'
});

</script>
</div>

</div>
</div>

<hr/>
<div style="clear:both;"></div>

<div class="col" style="float:left; width:40%;">

<div class="form-group">
<label class="col-sm-3 control-label">';
    for ($c = 0; $c < 5; $c++) {
        echo '<input type="radio" name="copies"  value="' . $c . '" ' . ($copies == $c ? 'checked' : '') . '> ' . $c . ' <br>
';
    }
    echo '
</label>
<div class="col-sm-9">' . $lang[541] . '</div>
</div>

<br>
	
		';
    global $show_tobedelivered, $show_tobeposted;

    if ($show_tobedelivered == 'Y') {
        echo '<div class="form-group" >
<label class="col-sm-3 control-label">' . $lang[542] . '</label>
<div class="col-sm-9" style="text-align:left;">';


        //echo $tobedelivered.$tobeposted;
        echo '
<input type="checkbox"  name="tobedelivered"  ' . ($tobedelivered == 'Y' ? 'checked' : '') . '/>
		&nbsp;' . $customer['online_invoicing_email'] . '
				<br>' . $customer['online_invoicing_email2'] . '
						<br>' . $customer['online_invoicing_email3'] . '<br>
								

';
    }

    if ($show_tobeposted == 'Y') {
        echo '
<input type="checkbox"  name="tobeposted"  ' . ($tobeposted == 'Y' ? 'checked' : '') . ' />
' . $lang[697] . '


';
    }

    echo '</div>
</div>

</div>

<div class="col" style="float:right; width:40%;">

		<table>
		
		<tr>
		<td>' . $lang[543] . '</td>
		<td>' . $subtotal_fmt . '</td>
		</tr>';
    if ($fsapply == 'Y') {
        echo '	<tr>
				<td>' . $lang[544] . '</td>
				<td>' . $fsamount_fmt . '</td>
		</tr>';
    }


    global $tax1amount, $tax2amount, $tax3amount, $tax4amount, $tax5amount, $taxname;
    if ($tax1amount > 0) {
        echo '
<tr><td>' . $taxname[1] . '</td>
<td>' . $tax1amount_fmt . '</td>
</tr>
';
    }


    if ($tax2amount > 0) {
        echo '
<tr>
<td>' . $taxname[2] . '</td>
<td>' . $tax2amount_fmt . '</td>
</tr>
';
    }

    if ($tax3amount > 0) {
        echo '
<tr>
<td>' . $taxname[3] . '</td>
<td>' . $tax3amount_fmt . '</td>
</tr>
';
    }

    if ($tax4amount > 0) {
        echo '
<tr>
<td>' . $taxname[4] . '</td>
<td>' . $tax4amount_fmt . '</td>
</tr>
';
    }

    if ($tax5amount > 0) {
        echo '
<tr>
<td>' . $taxname[5] . '</td>
<td>' . $tax5amount_fmt . '</td>
</tr>
';
    }

    echo '
		<tr>
		<td>' . $lang['376'] . '</td>
		<td>' . $total_fmt . '</td>		</tr>
				
		




<tr>
<td>' . $lang['551'] . '</td>
<td><input type="checkbox" name="fsapply"  ' . ($fsapply == 'Y' ? 'checked' : '') . ' value="Y" /></td>
</tr>


<tr>
<td>' . $lang['545'] . '</td>
<td><input type="text" name="ppd_amount" value="' . $ppd_amount . '"  size ="10"/></td>
</tr>



<tr>
<td>' . $lang['159'] . '</td>
<td>
<select name="ppd_method" style="width:100px;">
<option value=""></option>';
    for ($p = 0; $p < count($payment_type); $p++) {
        echo '<option value="' . $payment_type[$p]['payment_id'] . '" ' . ($payment_type[$p]['payment_id'] == $ppd_method ? 'selected' : '') . ' >' . $payment_type[$p]['payment_name'] . '</option>';
    }

    echo '
</select>
</td>
</tr>

<tr>
<td>' . $lang['546'] . '</td>
<td><input type="text" name="ppd_ref" value="' . $ppd_ref . '" size ="10" /></td>
</tr>

		<tr>
<td>Balance</td>
<td>' . $balance_fmt . '</td>
</tr>

</table>

</div> 


<div style="clear:both;"></div>

<div class="form-group">
<input type="submit" name="process" value="' . $lang[549] . '"  class="btn btn-info" />
<input type="submit" name="view" value="' . $lang[550] . '"  class="btn btn-info"/>
<input type="button" name="exit" value="' . $lang[547] . '" onclick="window.top.close();" class="btn btn-info"/>
</div>


		</div>
		</div>
		</div>
		</div>


</form>


		</div>
';
}
function template_show_revise_account()
{
    global $table;
    $total_Debit = 0;
    $total_credit = 0 ;
    $index =1;
    echo "

	<div style=\"margin-top : 10px;\">


	<table id=\"print\" style=\"width:80%; margin:20px;\" class=\"dataTable table  table-bordered   \">
  <tr>
    <th>م</th>
	<th>تاريخ</th>
	<th>رقم الفاتورة</th>
    <th>رقم الطلبية</th>
    <th>رقم اذن الدفع </th>
    <th>بيان</th>
    <th>رقم اذن التسليم</th>
    <th>مدين</th>
	<th>دائن</th>
	<th>الرصيد</th>
  </tr>";
    for ($i=0;$i<count($table);$i++) {
        $total_Debit += $table[$i]['debit'];
        $total_credit += $table[$i]['credit'];

        $out_order = fd($table[$i]['out_order']);
        $oo = explode(",", $out_order);
        for ($j=0;$j<count($oo);$j++) {
            $ooR = '<a href="work.php?action=create_out_order&print=1&id='.$oo[$j].'" target="_blank" >'.$oo[$j].'</a>';
        }
        echo "<tr>
    <td>".($i+1)."</td>
    <td>".$table[$i]['action_date']."</td>
    <td>".($table[$i]['invoiceno'] != '' && $table[$i]['invoiceno'] != '0' ? '<a onclick="show_invoice(\''.$table[$i]['invoiceno'].'\',0)">'.$table[$i]['invoiceno'].'</a>' : '')."</td>
	<td>".($table[$i]['easy_order_id'] != '' ? '<a onclick="refreshwaybill(\''.$table[$i]['order_id'].'\')">'.$table[$i]['easy_order_id'].'</a>' : '')."</td>
	<td>".$table[$i]['cashrecipt_id']."</td>
    <td>".$table[$i]['note']."</td>
    <td>".$ooR."</td>
    <td>".$table[$i]['credit']."</td>
	<td>".$table[$i]['debit']."</td>
	<td>".($total_credit - $total_Debit)."</td>
  </tr> ";
    }

    echo "<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td>".$total_credit."</td>
<td>".$total_Debit."</td>
<td></td>
</tr>

<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td>".($total_credit - $total_Debit)."</td>
</tr>
</table>

</div>

";
}
function template_revise_account()
{
    global $lang, $acc, $pay, $bill;

    $allacc = $acc;
    echo '
    <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/invoice.js"></script>
	<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>

     
            <div class="page-content-area">
            <div class="page-header"><h1>' . $lang[114] . '</h1></div>
                    
                    <div class="row">
                    <div class="col-xs-12">
				
				<div   class="form-horizontal"  >


						
		<div class="space-4"></div>

<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">' . $lang[407] . '</label>
<div class="col-sm-5">
<select  class="col-xs-10 col-sm-5 chosen-select" id="client" name="account_acctno"  >
<option value="">' . $lang[204] . '
 </option>
';
    for ($i = 0; $i < count($allacc); $i++) {
        echo '<option value="' . $allacc[$i]['account_id'] . '">' . $allacc[$i]['account_name'] . ' | ' . $allacc[$i]['account_company'] . '</option>';
    }
    echo '
</select>
</div>
</div>

<div class="space-4"></div>
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[56] . '</label>
<div class="col-sm-9">
<input type="text" id="revise_date_from" name="revise_date_form" class="dateinput" value=""  /> 
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[57] . '</label>
<div class="col-sm-9">
<input type="text" name="revise_date_to" id="revise_date_to"  class="dateinput" value=""  /> 

</div>
</div>
		<div class="col-md-offset-3 col-md-9">
<input  type="submit"   id="search_1"  value="بحث"  class="btn btn-info"   onclick="revise_search();"  />



</div>
</div >

<div style="clear:both;"></div>
		<div id="showResult"></div>
';
}
function template_open_invoice()
{
    global $lang, $acc, $pay, $bill;

    $allacc = $acc;

    echo '
    <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/invoice.js"></script>
    
     
            <div class="page-content-area">
            <div class="page-header"><h1>' . $lang[114] . '</h1></div>
                    
                    <div class="row">
                    <div class="col-xs-12">
				
				<form name="open_invoice_form" id="open_invoice_form" action="' . formurl . '/accounting.php?action=open_invoice" method="post" class="form-horizontal" role="form" >
<input type="hidden" name="get_open_invoice" value="1" />


						<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">' . $lang[878] . '</label>
<div class="col-sm-9">
<input type="text" name="acct_name2" id="acct_name2" class="col-xs-10 col-sm-5" value=""  />
</div>
</div>
		<div class="space-4"></div>

<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">' . $lang[407] . '</label>
<div class="col-sm-5">
<select  class="col-xs-10 col-sm-5 chosen-select" name="account_acctno"  >
<option value="">' . $lang[204] . '
 </option>
';
    for ($i = 0; $i < count($allacc); $i++) {
        echo '<option value="' . $allacc[$i]['account_id'] . '">' . $allacc[$i]['account_name'] . ' | ' . $allacc[$i]['account_company'] . '</option>';
    }
    echo '
</select>
</div>
</div>

<div class="space-4"></div>
		
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right"> ' . $lang[879] . '</label>
<div class="col-sm-5">
<select  class="col-xs-10 col-sm-5 chosen-select" name="account_acctname" >
<option value="">' . $lang[204] . '
 </option>
';
    for ($i = 0; $i < count($allacc); $i++) {
        echo '<option value="' . $allacc[$i]['account_id'] . '">' . $allacc[$i]['account_company'] . ' | ' . $allacc[$i]['account_name'] . '</option>';
    }
    echo '
</select>
</div>
</div>	
		
		
';

    if (is_array($bill)) {
        echo '
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">' . $lang['161'] . '</label>
<div class="col-sm-9">
<select name="billingcode" class="col-xs-10 col-sm-5" >
<option value="*"  >' . $lang['399'] . '</option>';

        if (is_array($bill)) {
            for ($i = 0; $i < count($bill); $i++) {
                echo '<option value="' . $bill[$i]['id'] . '"  >' . $bill[$i]['billingcode_name'] . '</option>';
            }
        }
        echo '
</select>
</div>
</div>';
    }

    echo '


		
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">' . $lang[74] . '</label>
<div class="col-sm-9"><input type="text" name="invoice_no" value="" class="col-xs-10 col-sm-5"></div>
</div>

		
		<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right">' . $lang[74] . '</label>
		<div class="col-sm-9">
		<div class="radio">
													<label>
														<input name="cash_res" type="radio" class="ace" value="1" checked >
														<span class="lbl">' . $lang[698] . '</span>
													</label>
												</div>
		<div class="radio">
													<label>
														<input name="cash_res" type="radio" value="2" class="ace">
														<span class="lbl">' . $lang[699] . '</span>
													</label>
												</div>
				
				</div>
																
			<script type="text/javascript">
				$(document).ready(function () {
					$("input[name$=\'cash_res\']").click(function () {
						$("#cash_res_1").hide();
						$("#cash_res_2").hide();
						var test = $(this).val();

						// $("").hide();
						$("#cash_res_" + test).show();

						if (test == "1") {
							$("#open_invoice_form").attr(\'action\',\''.formurl. '/accounting.php?action=open_invoice\');
} else {
							$("#open_invoice_form").attr(\'action\',\''.formurl. '/accounting.php?action=cr_view\');
}


					});
				});

			</script>
		</div>
		
	<div id="cash_res_1" style="">
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">' . $lang[548] . '</label>
<div class="col-sm-9">
<input type="text" name="due_invoice_date" id="due_invoice_date" value="" class="col-xs-10 col-sm-5" /> 

<script type="text/javascript">
	$(\'#due_invoice_date\').datepicker({
		format: \'yyyy-mm-dd\'
});
	$(\'#due_invoice_date\').datepicker(\'setDate\', new Date());

</script>

</div>
</div>
																
	</div>		
																													

			<div id="cash_res_2" style="display:none;">

			
			<div class="form-group">
			<label class="col-sm-3 control-label">'.$lang[1017].'</label>
			<div class="col-sm-9">
					<input type="checkbox" name="tax_col" value="1" checked  / >
					</div>
					</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[34] . '</label>
<div class="col-sm-9">
<input type="text" name="from_invoice_date" id="from_invoice_date" value=""  /> 

<script type="text/javascript">
		var date = new Date();
	date.setMonth(date.getMonth() - 1);

	$(\'#from_invoice_date\').datepicker({
		format: \'yyyy-mm-dd\'
});
	$(\'#from_invoice_date\').datepicker(\'setDate\', date);

</script>

</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[35] . '</label>
<div class="col-sm-9">
<input type="text" name="to_invoice_date" id="to_invoice_date" value=""  /> 

<script type="text/javascript">
$(\'#to_invoice_date\').datepicker({
		format: \'yyyy-mm-dd\'
});
	$(\'#to_invoice_date\').datepicker(\'setDate\', new Date());

</script>

</div>
</div>
	
																
	</div>	
		
<div class="clearfix form-actions" >
		<div class="col-md-offset-3 col-md-9">
<input type="submit" id="openinvoice" name="openinvoice"    value="' . $lang[26] . '..." class="btn btn-info"/>
		</div>
</div>


</form>
				
				
				</div>
				</div>
		</div>
';
}


function template_view_cashreceipts()
{
    global $lang, $bill, $acc, $tax,$payment_type,$c_setting;
    $allacc = $acc;
    $name=$c_setting['co_name'];
    $logo=SITEURL."/images/logo.jpg";
    // echo'<pre>';
    // var_dump($allacc);
    // echo'</pre>';

    echo'
	<link rel="stylesheet" type="text/css" href="'.SITEURL.'/'.STYLE.'/assets/DataTables/DataTables/css/dataTables.jqueryui.min.css">


	<style>
	#cashreceiptsList tr:nth-child(odd) {
		background-color: #e9e9e9;
	}
	
	#cashreceiptsList td {
		padding: 5px !important;
		font-size: 10px;
	}
	#cashreceiptsList tr:nth-child(even) {
		background-color: #f6f6f6;
	}
	#cashreceiptsList th{
	font-weight: 900;
		color: #ffffff;
		background:  #307ecc;
	
	}
	

	
	.DataTables_sort_wrapper{
        display: inline-block !important;

	}
	
	</style>';
    echo '<table   class="ui celled table table-striped table-bordered table-hover " style="width:100%">
    <thead>
      
		<tr>
		<th>رقم الوصل</th>

            <th>عميل</th>
            <th>المبلغ</th>
            <th>طريقه الدفع</th>
            <th>المستخدم</th>
            <th>التاريخ</th>
            <th>+</th>
		 </tr>
    </thead>
	<tbody>';

    foreach ($allacc as $key => $value) {
        $js_array = json_encode($value);
        echo'
		<tr>
		<td>'.$value['id'].'</td>
		<td>'.$value['account_company'].'</td>
		<td>'.$value['pymt_amount'].'</td>
		<td>'.$value['payment_name'].'</td>
		<td>'.$value['user_name'].'</td>
		<td>'.$value['date'].'</td>
		<td><button type="button" class="btn  btn-success btn-xs"
		onclick=\'show_edit_cashreceipts(`'.$js_array.'`)\'>
			<i class="fa fa-external-link "></i>
	   </button>
	   <button type="button" class="btn btn-info btn-xs"
		onclick=\'print_cash(`'.$value['id'].'`)\'>
			<i class="fa fa-print bigger-125 icon-only "></i>
	   </button></td>
	 </tr>';
    }
    
    echo'
	</tbody>
	
</table>
<script>
	';

    echo ' 
	var name="'.$c_setting['co_name'].'"
	var logo="'.SITEURL.'/images/logo.jpg";   
	var php="'.SITEURL.'/administrator/cashreceiptsTable.php";   
	</script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/jquery.dataTables.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/dataTables.jqueryui.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/dataTables.buttons.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/jszip.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/pdfmake.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/vfs_fonts.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/buttons.html5.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/cashreceiptsTable.js"></script> 
';
}

function template_cashreceipts()
{
    global $lang, $bill, $acc, $tax,$payment_type;
    $allacc = $acc;
    echo '
	<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/invoice.js"></script> 
<script  type="text/javascript">


 $(document).ready(function () {
	 $("#tabs").tabs();

 });

</script>



<div id="tabs">
<ul >
<li><a href="accounting.php?action=view_cashreceipts" >الدفعات</a></li>   
<li><a href="accounting.php?action=cash" >' . $lang['cashreceipts'] . '</a></li>  

</ul>



<div id="tabs-0" class="tabset_content">


</div>
<div id="tabs-1" class="tabset_content">


</div>


</div>
';
}
function template_cash()
{
    global $lang, $bill, $acc, $tax,$payment_type,$data;
    $allacc = $acc;
    // var_dump($data);
    echo'
	<script>
    $(\'.chosen-select\').chosen({allow_single_deselect:true}); 
    
          
    $(window)
    .off(\'resize.chosen\')
    .on(\'resize.chosen\', function() {
          $(\'.chosen-select\').each(function() {
                 var $this = $(this);
                 $this.next().css({\'width\': $this.parent().width()});
          })
    }).trigger(\'resize.chosen\');
    
    
    </script>
	<form  method="post" ';
    if ($data) {
        echo 'id="edit"';
    } else {
        echo 'id="add_cashreceipts"';
    }
    
    //
    if ($data) {
        echo'action="' . formurl.'/accounting.php?action=cash"';
    } else {
        echo'action="' . formurl.'/accounting.php?action=cashreceipts"';
    }
    echo ' class="form-horizontal" role="form">
	  <div style="padding:10px;">
		';
    if ($data) {
        echo'<input type="hidden" name="cash_id"  value="'.$data['id'].'">';
    }
    echo'
	<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right"> ' . $lang[879] . '</label>
	<div class="col-sm-3">
	<select  name="clid"  class="chosen-select">
	<option value="">' . $lang[204] . ' </option>
	';
    for ($i = 0; $i < count($allacc); $i++) {
        echo '<option value="' . $allacc[$i]['account_id'].'"' ;
        if ($data['clid']==$allacc[$i]['account_id']) {
            echo' selected=\'selected\' ';
        }
        echo '>' . $allacc[$i]['account_company'] . ' | ' . $allacc[$i]['account_name'] . ' | '.$allacc[$i]['billingcode_name'].' </option>';
    }
    echo '
	</select>
	</div>
	
	</div>
	
		
	<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right"> ' . $lang[159] . '</label>
	<div class=" col-sm-3">
	<select  class=" " name="paymethod" value='.$data['paymethod'].' >
	';
    for ($i = 0; $i < count($payment_type); $i++) {
        echo '<option value="'. $payment_type[$i]['payment_id'].'"' ;
        if ($data['paymethod']==$payment_type[$i]['payment_id']) {
            echo' selected=\'selected\' ';
        }
        echo '>' . $payment_type[$i]['payment_name']."</option>";
    }
    echo '
	</select>
	</div>
	</div>
	
	';
    
    echo '
	<div class="form-group">
	<label class="col-sm-3 control-label">' . $lang['arrive_amount'] . '</label> 
	<div class="col-sm-9"><input type="text" name="pymt_amount" value='.$data['pymt_amount'].'></div>
	</div>
	
	<div class="form-group">
	<label class="col-sm-3 control-label">' . $lang[852] . '</label>
	<div class="col-sm-9">
	<input type="text" name="date"  id="date" value > 
	<script type="text/javascript">
	var date = new Date();
	date.setMonth(date.getMonth() - 1);

	$(\'#date\').datepicker({
		dateFormat: \'yy-mm-dd\'
    });
    $(\'#date\').datepicker(\'setDate\',';
    if ($data['date']) {
        echo "new Date('".$data['date']."')";
    } else {
        echo'date';
    }

    echo');
</script>';

    echo'
	</div>
	</div>
	
	
	
	<div class="clearfix form-actions">
			<div class="col-md-offset-3 col-md-9">
	<input type="button" name="order_by" class="addeditcash" value="' . $lang[260] . '" class="btn btn-info"  onclick="add_cashreceipts(\'';
    if ($data) {
        echo'edit';
    } else {
        echo'add_cashreceipts';
    }
    echo'\');">
	</div>
			
			</div>
	
	</div>
	</form>';
}

function template_cashrecipt_print()
{
    global $data,$c_setting;
    $x = '
	<div  style="padding-right: 15px;  margin: auto; padding-top: 5px;width:95%;border: 2px solid #00800078;">
                <table width="100%"  style="color: gray;font-size: 14px;" dir="rtl">
                <tr>
                <td  style="width: 85px;height: 70px;" >
                <img style="width: 85px; height: 70px;" src="'.SITEURL.'/images/logo.jpg"  alt="Graph Description" />
                </td>            
                <td><h1>'.$c_setting['co_name'].'</h1></td>        
                </tr>
                </table>        
				
				<div style="margin: auto; text-align: center;">
                <h2>ايصال استلام نقدى</h2>
                </div>
                <table width="100%"  style="color: gray;font-size: 14px;" dir="rtl">
                <tbody><tr>
				<td  colspan="4">
				<h2 style="display: inline-block;"> التاريخ &nbsp;&nbsp;&nbsp;&nbsp; : </h2>
				<h3 style="display: inline-block; padding: 2px 5px; min-width: 130px;">'.$data['date'].'</h3>
				</td>
				<td style="text-align: right;">   
				<h2 style="display: inline-block;"> رقم الوصل : </h2>
				<h3 style=" display: inline-block; padding: 2px 5px; ">'.$data['id'].'</h3>
				</td>
                </tr>                
                <tr>        
				<td  colspan="4"> <h2 style="display: inline-block;">  اسم العميل : </h2>
				<h3 style=" display: inline-block; padding: 2px 5px;  min-width: 130px; ">'.$data['account_company'].'</h3>
				</td>
				<td style="text-align: right;">   
				<h2 style="display: inline-block;">طريقة الدفع  : </h2>
				<h3 style=" display: inline-block; padding: 2px 5px; ">'.$data['payment_name'].'</h3>
				</td>           
                </tr>
                <tr>
				<td colspan="4"  >
				<h2 style="display: inline-block;">  المبلغ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </h2>
				<h3 style=" padding: 2px 5px;  min-width: 130px; display: inline-block;">'.$data['pymt_amount'].'</h3></td>
                <td></td>
                </tr>            
                <tr>
                <td colspan="100%" style="padding-left: 30px;">
                <div style="float:right;">امين الصندوق</div>
                <div style="float:left;">المراجعة</div>
                </td>
                </tr>                
                <tr>
                <td colspan="100%" style="padding-left: 30px;">
                <div style="float:right;">...........</div>
                <div style="float:left;">...........</div>
                </td>
                </tr>        
                </tbody></table></div>
	';
    return $x;
}
function template_history_invoice()
{
    global $lang, $billing_codes , $acc, $tax;
    $allacc = $acc;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/invoice.js"></script>

<script  type="text/javascript">

 $(document).ready(function () {
	 $("#tabs_history").tabs();

 });

</script>



<div id="tabs_history">
<ul>
   <li><a href="#tabs_history-0" >' . $lang[73] . '</a></li>  
</ul>


<div id="tabs_history-0" >

<form id="search_invoices" method="post" action="' . formurl . '/accounting.php?action=history_invoice" class="form-horizontal" role="form">
<div style="padding:10px;">


		<div class="space-4"></div>

<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">' . $lang[407] . '</label>
<div class="col-sm-5">
<select  class="col-xs-10 col-sm-5 chosen-select" name="account_id"  >
<option value="">' . $lang[204] . '
 </option>
';
    for ($i = 0; $i < count($allacc); $i++) {
        echo '<option value="' . $allacc[$i]['account_id'] . '">' . $allacc[$i]['account_name'] . ' | ' . $allacc[$i]['account_company'] . '</option>';
    }
    echo '
</select>
</div>
</div>


';

    echo '



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[74] . '</label>
<div class="col-sm-9"><input type="text" name="invoice_no" value=""></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[56] . '</label>
<div class="col-sm-9">
<input type="text" name="invoice_date_form" class="dateinput" value=""  /> 
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[57] . '</label>
<div class="col-sm-9">
<input type="text" name="invoice_date_to" id="invoice_date_to"  class="dateinput" value=""  /> 

</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">' . $lang[177] . '</label>
<div class="col-sm-5">
<select  class="col-xs-10 col-sm-5" name="reviewed"  >
	<option value="">' . $lang[595] . '</option>
	<option value="1">' . $lang['open_invoice2'] . '</option>
	<option value="0">' . $lang['open_invoice'] . '</option>
</select>
</div>
</div>';

    if ($_SESSION['billing_code'] > "0") {
        echo '<input type="hidden" name="billing_code" value="'.$_SESSION['billing_code'].'" />';
    } else {
        echo '
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">' . $lang['billing_code'] . '</label>
<div class="col-sm-5">
<select  class="col-xs-10 col-sm-5" name="billing_code"  >
	<option value="">' . $lang[595] . '</option>';
        for ($i=0;$i<count($billing_codes);$i++) {
            echo '<option value="'.$billing_codes[$i]['id'].'"  >'.$billing_codes[$i]['billingcode_name'].'</option>';
        }
        echo '</select>
</div>
</div>';
    }



    echo '<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
<input type="button" name="order_by" value="' . $lang[26] . '" class="btn btn-info"  onclick="invoice_history();">
</div>
		
		</div>

</div>
</form>
<div style="clear:both;"></div>


</div>

</div>
';
}

function template_search_invoices()
{
    global $lang, $invoices, $pro_col, $ful_col;

    echo '
<table border="1" class="table table-striped table-bordered table-hover">
<tr>
<th>' . $lang[74] . '</th>
<th>' . $lang[106] . '</th>
<th>' . $lang[693] . '</th>
<th>' . $lang[401] . '</th>
<th>' . $lang[548] . '</th>
';

    if ($ful_col == 1) {
        echo '
<th>' . $lang[708] . '</th>
<th>' . $lang[416] . '</th>
<th>' . $lang[710] . '</th>
<th>' . $lang[711] . '</th>

';
    }
    echo '
<th>' . $lang[694] . '</th>
<th>' . $lang[585] . '</th>
<th>' . $lang[695] . '</th>';

    if ($pro_col == 1) {
        echo '
<th>' . $lang[537] . '</th>
<th>' . $lang[538] . '</th>
<th>' . $lang[709] . '</th>
';
    }
    echo '</tr>';

    if (is_array($invoices) && count($invoices) > 0) {
        for ($i = 0; $i < count($invoices); $i++) {
            echo '
<tr>
<td><a href="' . SITEURL . '/administrator/invoicing/index.php?id='.$invoices[$i]['id']. '" target="_blank"  ><img src="' . SITEURL . '/' . STYLE . '/css/images/printer.jpg" width="25" height="25"  /></a>&nbsp; &nbsp; &nbsp;' . $invoices[$i]['id'] . '</td>
<td>' . $invoices[$i]['account_name'] . '</td>
<td>' . $invoices[$i]['account_company'] . '</td>
<td>' . $invoices[$i]['date'] . '</td>
<td>' . $invoices[$i]['duedate'] . '</td>
';

            if ($ful_col == 1) {
                echo '
<td>' . $invoices[$i]['subtotal'] . '</td>
<td>' . $invoices[$i]['fsamount'] . '</td>
<td>' . $invoices[$i]['tax1amount'] . '</td>
<td>' . $invoices[$i]['tax2amount'] . '</td>

';
            }
            echo '
<td>' . ($invoices[$i]['subtotal'] + $invoices[$i]['fsamount'] + $invoices[$i]['tax1amount'] + $invoices[$i]['tax2amount']) . '</td>
<td>0</td>
<td>0</td>';

            if ($pro_col == 1) {
                echo '
<td>' . $invoices[$i]['printed'] . '</td>
<td>' . $invoices[$i]['posted'] . '</td>
<td>' . $invoices[$i]['delivered'] . '</td>
';
            }

            echo '</tr>';
        }
    } else {
        echo '<tr>
<td colspan="100%">' . $lang['472'] . '</td>
</tr>';
    }

    echo '</table>

<div class="form-group">
<input type="button" name="exit" value="' . $lang[200] . '" onclick="close_my_tab(\'tabs_history\',0)" class="btn btn-info" style="margin:auto;">
</div>

';
}

function template_cash_receipts_view()
{
    global $lang, $result, $show_tax;
    echo '

			
			
<table  border="1" class="table table-striped table-bordered table-hover" >
<tr>
<th>' . $lang[74] . '</th>
<th>' . $lang[106] . '</th>
<th>' . $lang[693] . '</th>
		
<th>' . $lang[852] . '</th>
<th>' . $lang[159] . '</th>
<th>' . $lang[546] . '</th> 
<!--<th>SubTotal</th>
<th>Fs Amount</th>	-->
<th>' . $lang[771] . ' 1</th>
<th>' . $lang[771] . ' 2</th>	
<th>' . $lang[771] . ' 3</th>	
<th>' . $lang[771] . ' 4</th>			
<th>' . $lang[853] . '</th>
<th>' . $lang[854] . '</th>
<th>' . $lang[855] . '</th>
</tr>';

    if (is_array($result) && count($result) > 0) {
        $payment_amount = 0;
        $amount_applied = 0;
        $invoice_total = 0;

        for ($i = 0; $i < count($result); $i++) {
            $pay_am = sprintf("%01.2f", $result[$i]['pymt_amount']);
            $applied = sprintf("%01.2f", $result[$i]['applied']);

            $t_sub += $result[$i]['subtotal'];
            $t_fs += $result[$i]['fsamount'];
            $t_tax1 += $result[$i]['tax1amount'];
            $t_tax2 += $result[$i]['tax2amount'];
            $t_tax3 += $result[$i]['tax3amount'];
            $t_tax4 += $result[$i]['tax4amount'];

            if ($result[$i]['link'] == '0') {
                $payment_amount += $pay_am;
            }

            $amount_applied += $applied;

            $invoice_total += $result[$i]['invoice_total'];


            $reference = $result[$i]['ref'];

            if ($result[$i]["ppd"] == "Y") {
                $reference .= "(ppd)";
            } else {
                if ($prev_ref != $result[$i]['acctno'] . $reference . $pay_am) {
                    $reference = "<a href=\"\">" . $reference . "</a>";
                }
            }

            echo '<tr>
					<td>' . ($result[$i]['invoiceno'] > 0 ? $result[$i]['invoiceno'] : 'Deposits') . '</td>
					<td>' . $result[$i]['acctno'] . '</td>
					<td>' . $result[$i]['account_company'] . '</td>
					<td>' . $result[$i]['date'] . '</td>
					<td>' . $result[$i]['paymethod'] . '</td>
					<td>' . ($prev_ref == $result[$i]['acctno'] . $reference . $pay_am ? '' : $reference) . '</td>
					<!--<td>' . $result[$i]['subtotal'] . '</td>
					<td>' . $result[$i]['fsamount'] . '</td>-->
					<td>' . $result[$i]['tax1amount'] . '</td>
					<td>' . $result[$i]['tax2amount'] . '</td>
					<td>' . $result[$i]['tax3amount'] . '</td>
					<td>' . $result[$i]['tax4amount'] . '</td>		
					<td>' . ($result[$i]['link'] == '0' ? $pay_am : '') . '</td>
					<td>' . sprintf("%01.2f", $result[$i]['invoice_total']) . '</td>
					<td>' . $applied . '</td>				
				</tr>';

            $prev_ref = $result[$i]['acctno'] . $result[$i]['ref'] . $pay_am;
        }

        echo '
			<tr>
				<td>' . $lang[376] . '</td>
				<td colspan="5"></td>
					<td>' . $t_sub . '</td>
					<td>' . $t_fs . '</td>
					<td>' . $t_tax1 . '</td>
					<td>' . $t_tax2 . '</td>
					<td>' . $t_tax3 . '</td>	
					<td>' . $t_tax4 . '</td>	
				<td>' . $payment_amount . '</td>
				<td>' . $invoice_total . '</td>
				<td>' . $amount_applied . '</td>
				</tr>
				';
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }
    echo '
		</table>
			
			';
    //var_dump($result);
}


function template_cash_recepits()
{
    global $lang, $acc, $inv, $con, $pay, $total_applied_fmt, $payment_remaining_fmt;
    //var_dump($con);
    echo '
								

<form  class="form-horizontal" role="form" method="post" id="add_cash_' . $acc->account_id . '" name="add_cash_' . $acc->account_id . '">
			<input type="hidden" name="account_id" value="' . $acc->account_id . '" />
					
											<div class="widget-body">
												<div class="widget-main padding-24">
													<div class="row">
														<div class="col-sm-6">
															<div class="row">
																<div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
																	<b>' . $lang[856] . '</b>
																</div>
															</div>

															<div class="row">
																<ul class="list-unstyled spaced">
																	<li>
																		<i class="ace-icon fa fa-caret-right blue"></i>From :<b> ' . $acc->account_name . '</b>
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right blue"></i>' . $acc->account_company . '
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right blue"></i>' . $acc->account_address . '
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right blue"></i>' . $acc->city . ',' . $acc->pcode . '					
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right blue"></i><b>Contact</b>' . $con[0]['contact_name'] . '					
																	</li>
																				
																
																</ul>
															</div>
														</div><!-- /.col -->

														<div class="col-sm-6">
															<div class="row">
																<div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
																	<b>' . $lang[585] . '</b>
																</div>
															</div>

															<div>
																<ul class="list-unstyled  spaced">
																	<li>
																			<div class="form-group" style="margin-bottom:0px;">
<label class="col-sm-3 control-label" style="text-align:left;">' . $lang[280] . '</label>
<div class="col-sm-9">
<input type="text" name="payment_date" id="payment_date" value="' . (isset($_POST['payment_date']) ? $_POST['payment_date'] : date(DATE_FORMAT)) . '" size="13"> 



</div>
</div>
																	</li>
																			
																	<li>
		<div class="form-group" style="margin-bottom:0px;">
<label class="col-sm-3 control-label" style="text-align:left;">' . $lang[857] . '</label>
<div class="col-sm-9">
<select name="payment_method">';
    for ($i = 0; $i < count($pay); $i++) {
        echo '<option value="' . $pay[$i]['payment_id'] . '" ' . (isset($_POST['payment_method']) && $_POST['payment_method'] == $pay[$i]['payment_id'] ? 'selected' : '') . '>' . $pay[$i]['payment_name'] . '</option>';
    }
    echo '</select>

</div>
</div>
																	</li>

																	<li>
																		<div class="form-group" style="margin-bottom:0px;">
<label class="col-sm-3 control-label" style="text-align:left; width:30%;">' . $lang[546] . '</label>
<div class="col-sm-9" style="width:auto; float:left;"><input type="text" name="payment_ref" value="' . (isset($_POST['payment_ref']) ? $_POST['payment_ref'] : '') . '" size="13" /></div>
</div>
																	</li>

																	<li>
															<div class="form-group" style="margin-bottom:0px;">
<label class="col-sm-3 control-label" style="text-align:left;">' . $lang[856] . '</label>
<div class="col-sm-9"><input type="text" name="payment_amt" id="payment_amt" value="' . (isset($_POST['payment_amt']) ? $_POST['payment_amt'] : '') . '" size="13"/></div>
</div>
																	</li>
		
		<li>
		<div class="form-group" style="margin-bottom:0px;">
<label class="col-sm-3 control-label" style="text-align:left;">' . $lang[857] . '</label>
<div class="col-sm-9" id="applied" style="padding:5px 20px;">' . $total_applied_fmt . '</div>
		</li>
		<li>
		<div class="form-group" style="margin-bottom:0px;">
<label class="col-sm-3 control-label" style="text-align:left;">' . $lang[858] . '</label>
<div class="col-sm-9" id="remains" style="padding:5px 20px;">' . $payment_remaining_fmt . '</div>
		</li>
																</ul>
															</div>
														</div><!-- /.col -->
													</div><!-- /.row -->

													<div class="space"></div>

													<div>
														<table class="table table-striped table-bordered">
															<thead>
																<tr>
																	<th>' . $lang[74] . '</th>
																	<th >' . $lang[401] . '</th>
																	<th >' . $lang[548] . '</th>
																	<th>' . $lang[854] . '</th>
																	<th>' . $lang[859] . '</th>
																	<th>' . $lang[695] . '</th>
																	<th>' . $lang[860] . '</th>
																	<th>' . $lang[857] . '</th>
																</tr>
															</thead>

															<tbody>';
    if (is_array($inv) && count($inv) > 0) {
        //var_dump($inv);
        for ($i = 0; $i < count($inv); $i++) {
            if ($inv[$i]['invoiceno'] != "0") {
                $balance = $inv[$i]['invoice_total'] - $inv[$i]['payments'];
            }
            $invoice_total_fmt = sprintf("%01.2f", $inv[$i]['invoice_total']);
            $payments_fmt = sprintf("%01.2f", $inv[$i]['payments']);
            if ($inv[$i]['invoiceno'] != "0") {
                $balance_fmt = sprintf("%01.2f", $balance);
            }

            if ($inv[$i]['invoiceno'] != "0") {
                $total_balance += $balance_fmt;
            }
            $total_payments += $payments_fmt;
            $total_invoice += $invoice_total_fmt;

            if (isset($_POST['applied'][$inv[$i]['id']]) && $_POST['applied'][$inv[$i]['id']] != '') {
                $total_applied += $_POST['applied'][$inv[$i]['id']];
            } elseif (isset($_POST['applycb'][$inv[$i]['id']])) {
                $total_applied += $invoice_total_fmt;
            }


            if (!isset($inv[$i]['invoiceno'])) {
                echo '	<tr>

																	<td>' . $inv[$i]['id'] . '</td>
																	<td>' . $inv[$i]['date'] . '</td>
																	<td > ' . $inv[$i]['duedate'] . '</td>
																	<td>' . $invoice_total_fmt . '</td>
																				<td>' . $payments_fmt . '</td>
																				<td>' . $balance . '</td>
																				<td><input type="checkbox" name="applycb[' . $inv[$i]['id'] . ']" ' . (isset($_POST['applycb'][$inv[$i]['id']]) ? 'checked' : '') . '></td>
																				<td><input type="text" name="applied[' . $inv[$i]['id'] . ']" value="' . (isset($_POST['applied'][$inv[$i]['id']]) && $_POST['applied'][$inv[$i]['id']] != '' ? $_POST['applied'][$inv[$i]['id']] : (isset($_POST['applycb'][$inv[$i]['id']]) ? $invoice_total_fmt : '')) . '" size="10"></td>
																</tr>
	';
            }
        }

        if (isset($_POST['applied'][0])) {
            $total_applied += $_POST['applied'][0];
        }

        echo '
			
			<tr>

																	<td>' . $lang[861] . '</td>
																	<td></td>
																	<td > </td>
																	<td></td>
																				<td>' . (isset($inv[(count($inv) - 1)]['invoiceno']) && $inv[(count($inv) - 1)]['invoiceno'] == "0" ? $inv[(count($inv) - 1)]['payments'] : '') . '</td>
																				<td></td>
																				<td></td>
																				<td><input type="text" name="applied[0]" value="' . (isset($_POST['applied'][0]) ? $_POST['applied'][0] : '') . '" size="10" ></td>
																</tr>
																						
			<tr>

																	<td>' . $lang[376] . '</td>
																	<td></td>
																	<td > </td>
																	<td>' . $total_invoice . '</td>
																				<td>' . $total_payments . '</td>
																				<td>' . $total_balance . '</td>
																				<td></td>
																				<td>' . $total_applied . '</td>
																</tr>';

        $remain = $_POST['payment_amt'] - $total_applied;
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }
    echo '
<input type="hidden" name="payment_remaining" value="' . $remain . '" />			
<input type="hidden" name="total_applied" value="' . $total_applied . '" />													
		
		
<script>
		$(document).ready(function () {

			$("#remains").html(\''.$remain. '\');
$("#applied").html(\''.$total_applied. '\');
});
</script>														

													
															</tbody>
														</table>
													</div>

													<div class="hr hr8 hr-double hr-dotted"></div>

						

													<div class="space-6"></div>
													<div class="well">
														Thank you for choosing ' . SITENAME . '.
				We believe you will be satisfied by our services.
													</div>
												</div>
											</div>
										</div>
</form>
								
	';
}

function template_cash_recepits_new()
{
    global $lang, $acc, $inv, $con, $pay, $x, $total_applied_fmt, $payment_remaining_fmt;
    //var_dump($con);
    echo '
	
	
<form   class="form-horizontal" role="form" method="post" id="add_cash_' . $acc->account_id . '" name="add_cash_' . $acc->account_id . '">
			<input type="hidden" name="account_id" value="' . $acc->account_id . '" />
			
											<div class="widget-body">
												<div class="widget-main padding-24">
													<div class="row">
														<div class="col-sm-6"> 
															<div class="row">
																<div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
																	<b>' . $lang[856] . '</b>
																</div>
															</div>
	
															<div class="row">
																<ul class="list-unstyled spaced">
																	<li>
																		<i class="ace-icon fa fa-caret-left blue"></i> ' . $lang[34] . ':<b> ' . $acc->account_name . '</b>
																	</li>
	
																	<li>
																		<i class="ace-icon fa fa-caret-left blue"></i>' . $acc->account_company . '
																	</li>
	
																	<li>
																		<i class="ace-icon fa fa-caret-left blue"></i>' . $acc->account_address . '
																	</li>
	
																	<li>
																		<i class="ace-icon fa fa-caret-left blue"></i>' . $acc->city . ',' . $acc->pcode . '
																	</li>
	
																	<li>
																		<i class="ace-icon fa fa-caret-left blue"></i><b>' . $lang[1013] . '</b>' . $con[0]['contact_name'] . '
																	</li>
	
	
																</ul>
															</div>
														</div><!-- /.col -->
	
														<div class="col-sm-6">
															<div class="row">
																<div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
																	<b>' . $lang[585] . '</b>
																</div>
															</div>
	
															<div>
																<ul class="list-unstyled  spaced">
																	<li>
																			<div class="form-group" style="margin-bottom:0px;">
<label class="col-sm-3 control-label" style="text-align:left;">' . $lang[280] . '</label>
<div class="col-sm-9">
<input type="text" name="payment_date" id="payment_date" value="' . (isset($_POST['payment_date']) ? $_POST['payment_date'] : date(DATE_FORMAT)) . '" size="13">
	
	
	
</div>
</div>
																	</li>
										
																	<li>
		<div class="form-group" style="margin-bottom:0px;">
<label class="col-sm-3 control-label" style="text-align:left;">' . $lang[857] . '</label>
<div class="col-sm-9">
<select name="payment_method">';
    for ($i = 0; $i < count($pay); $i++) {
        echo '<option value="' . $pay[$i]['payment_id'] . '" ' . (isset($_POST['payment_method']) && $_POST['payment_method'] == $pay[$i]['payment_id'] ? 'selected' : '') . '>' . $pay[$i]['payment_name'] . '</option>';
    }
    echo '</select>
	
</div>
</div>
																	</li>
	
																	<li>
																		<div class="form-group" style="margin-bottom:0px;">
<label class="col-sm-3 control-label" style="text-align:left;">' . $lang[546] . '</label>
<div class="col-sm-9" style="width:auto; "><input type="text" name="payment_ref" value="' . (isset($_POST['payment_ref']) ? $_POST['payment_ref'] : '') . '" size="13" /></div>
</div>
																	</li>
	
																	<li>
															<div class="form-group" style="margin-bottom:0px;">
<label class="col-sm-3 control-label" style="text-align:left;">' . $lang[856] . '</label>
<div class="col-sm-9"><input type="text" name="payment_amt" id="payment_amt" value="' . (isset($_POST['payment_amt']) ? $_POST['payment_amt'] : '') . '" size="13"/></div>
</div>
																	</li>
	
		<li>
		<div class="form-group" style="margin-bottom:0px;">
<label class="col-sm-3 control-label" style="text-align:left;">' . $lang[857] . '</label>
<div class="col-sm-9" id="applied" style="padding:5px 20px;">' . $total_applied_fmt . '</div>
		</li>
		<li>
		<div class="form-group" style="margin-bottom:0px;">
<label class="col-sm-3 control-label" style="text-align:left;">' . $lang[858] . '</label>
<div class="col-sm-9" id="remains" style="padding:5px 20px;">' . $payment_remaining_fmt . '</div>
		</li>
																</ul>
															</div>
														</div><!-- /.col -->
													</div><!-- /.row -->
	
													<div class="space"></div>
	
													<div>
														<table class="table table-striped table-bordered">
															<thead>
																<tr>
																	<th>' . $lang[74] . '</th>
																	<th >' . $lang[401] . '</th>
																	<th >' . $lang[548] . '</th>
																	<th>' . $lang[854] . '</th>
																	<th>' . $lang[859] . '</th>
														 			<th>' . $lang[695] . '</th>
																	<th>' . $lang[860] . '</th>
																	<th>' . $lang[857] . '</th>
																</tr>
															</thead>
	
															<tbody>' . $x . '
<input type="hidden" name="payment_remaining" value="' . $remain . '" />
<input type="hidden" name="total_applied" value="' . $total_applied . '" />
	
	

	
							
															</tbody>
														</table>
													</div>
	
													<div class="hr hr8 hr-double hr-dotted"></div>
	
	
	
													<div class="space-6"></div>
													<div class="well">
														 '.$lang[1014] . SITENAME . $lang[1015]. '.
				.
													</div>
												</div>
											</div>
										</div>
</form>
	
	';
}

function template_cash_recepits_history()
{
    global $lang, $result;
    template_cash_receipts_view();
}



function template_sales_edit_invoice()
{
    global $lang,$invDetails,$invoiceID,$invLines,$addService,$grpnames ;

    

    echo '    
 <form id="salesinvoice_form_'.$invoiceID.'"  method="post"  action="accounting.php?action=edit_invoice"  class="form-horizontal" >
    
 <input type="hidden" name="id" value="'.$invoiceID.'">

 <div class="row">

 <div class="col-xs-4">

            <div class="form-group">
            <label class="col-sm-3 control-label">رقم الفاتورة</label>
            <div class="col-sm-9">'.$invDetails['id'].'
			</div></div>

            <div class="form-group">
            <label class="col-sm-3 control-label">تاريخ الفاتورة</label>
            <div class="col-sm-9">  '.$invDetails['date'].'
            </div>
            </div>

            <div class="form-group">
            <label class="col-sm-3 control-label">العميل</label>
            <div class="col-sm-9">
			'.$invDetails['acctno'].'
			</div>
            </div>

            </div>
            <div class="col-xs-4">

           
            <div class="form-group">
            <label class="col-sm-3 control-label">المجموع</label>
            <div class="col-sm-9" >
            
            <input type="text" readonly name="inv_total_price" class="inv_total_price" value="'.$invDetails['subtotal'].'">
            </div>
            </div>

			<div class="form-group">
            <label class="col-sm-3 control-label">الضريبة</label>
            <div class="col-sm-9" >
           <select name="taxgroup">
		   <option value="0"></option>';

    for ($i=0;$i<count($grpnames);$i++) {
        echo '<option value="'.$grpnames[$i]['taxgroup_id'].'" '.($grpnames[$i]['taxgroup_id'] == $invDetails['account_taxgroup'] ? 'selected' : '').'>'.$grpnames[$i]['taxgroup_name'].'</option>';
    }
    echo '	</select>

            </div>
            </div>

            <div class="form-group">
            <label class="col-sm-3 control-label">الخصم</label>
            <div class="col-sm-9" >
            <input type="text" onblur="recalac_sales_invoice(\'salesinvoice_form_'.$invoiceID.'\');"  name="bill_discount"  value="'.$invDetails['discount_value'].'">
            </div>
            </div>

            
    

            </div>

            <div class="col-xs-2">

            <div class="form-group">
            <label class="col-sm-3 control-label">الاجمالى</label>
            <div class="col-sm-9" >
            <input type="text"  name="bill_total_amount"  readonly value="'.$invDetails['bill_total_amount'].'">
            </div>
            </div>

            <div class="wizard-actions">
            <!-- #section:plugins/fuelux.wizard.buttons -->
          
    
            <button type="button"  style="text-align:center;" class="btn btn-success btn-block" onclick="save_sales_invoice(\'salesinvoice_form_'.$invoiceID.'\',\'0\')">' . ($invoiceID > 0 ? 'حفظ' :  $lang[260]) . '</button>
			<button type="button"  style="text-align:center;" class="btn btn-danger btn-block" onclick="approver_sales_invoice(\''.$invoiceID.'\')">' . ($invDetails['reviewed'] == 1 ? 'الغاء الاعتماد' :  'اعتماد') . '</button>
			<button type="button"  style="text-align:center;" class="btn btn-warning btn-block" onclick="add_form_php(\'salesinvoice_form_'.$invoiceID.'\',\'1\')">' . ($invoiceID > 0 ? 'ارسال فاتورة الكترونية' :  $lang[260]) . '</button>

            <!-- /section:plugins/fuelux.wizard.buttons -->
        </div>

            </div>

            <div style="clear:both;"></div>

</div>
            <hr/>
            <div class="row">

            <div class="col-xs-8" style="margin:auto; float:none;">

            <table class="table table-striped table-bordered table-hover myitems"  >
            <tr>
            <td>المنتج</td>
			<td>طول</td>
            <td>عرض</td>
            <td>سمك</td>
            <td>لون</td>
            <td>مسطح</td>
            <td>تخليع</td>
			<td>تفاصيل</td>
            <td>سعر </td>
			<td></td>
            </tr>';

    $rowNum = 5;
    if (count($invLines) > 5) {
        $rowNum = count($invLines);
    }

    for ($j = 0; $j < $rowNum; $j++) {
        if ($invLines[$j]['chgtype'] == 'A') {
            echo '
			<tr id="row_'.$invLines[$j]['invoicedtlid'].'" >
			<input type="hidden" name="itemid[]" value="'.$invLines[$j]['invoicedtlid'].'" />
	
			<td>
			'.$invLines[$j]['item'].'
			</td>
	
			<td colspan="7">
			'.$invLines[$j]['descn'].'
			</td>
	

	
			<td>
			<input type="text" name="itemprice[]" readonly  onblur="recalac_sales_invoice(\'salesinvoice_form_'.$invoiceID.'\');" value="'.$invLines[$j]['amount'].'" />
			</td>
		   
			<td>';
            if ($invDetails['reviewed'] != '1') {
                echo '			<a onclick="delete_row_details(\''.$invLines[$j]['invoicedtlid'].'\');" style="cursor:pointer;"><span class="ui-icon ace-icon  fa fa-trash-o center bigger-110 blue"></span></a>';
            }
            echo '			</td>
	
	
	
			  </tr>';
        } else {
            echo '
        <tr id="row_'.$invLines[$j]['invoicedtlid'].'" >
        <input type="hidden" name="itemid[]" value="'.$invLines[$j]['invoicedtlid'].'" />

        <td>
		'.$invLines[$j]['item'].'
        </td>

		<td>
		'.$invLines[$j]['length'].'
        </td>

		<td>
		'.$invLines[$j]['width'].'
        </td>

		<td>
		'.$invLines[$j]['glassType'].'
        </td>

		<td>
		'.$invLines[$j]['glasscolour'].'
        </td>

		<td>
		'.$invLines[$j]['glassType'].'
        </td>

		<td>
		'.$invLines[$j]['glassPointing'].'
        </td>

		<td>
		'.$invLines[$j]['details'].'-'.$invLines[$j]['details_2'].'
        </td>

		<td>
		<input type="text" name="itemprice[]" readonly value="'.$invLines[$j]['amount'].'" />
        </td>
       
		<td>';
            if ($invDetails['reviewed'] != '1') {
                echo '	<a onclick="add_row_details(\'row_'.$invLines[$j]['invoicedtlid'].'\',\''.$invLines[$j]['item'].'\',\''.$invLines[$j]['invoicedtlid'].'\','.htmlspecialchars(json_encode($addService)).',\''.$invoiceID.'\');" style="cursor:pointer;"><span class="ui-icon ace-icon fa fa-plus center bigger-110 blue"></span></a>';
            }
            echo '	</td>



          </tr>';
        }
    }
    echo '  </table>

      </div>
      </div>
    
<script type="text/javascript">
$(document).ready(function(){
    $(\'.datepick_'.$bill_id.'\').datepicker({
        dateFormat: \'yy-mm-dd\'	

    });
});
</script>


    
            </form>
    ';
}
