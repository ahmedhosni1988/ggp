<?php

function template_Mange_setting()
{
    global $lang;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
  <script>
  $(document).ready(function() {
    $("#tabs").tabs(
	
	
	);
	
	  var $tabs = $("#tabs").tabs({
        add: function(event, ui) {
        $tabs.tabs("select", "#" + ui.panel.id);
    }
});


});
</script>
<div id="tabs" >
<ul >
   <li><a href="admin_index.php?action=option" class="active">' . $lang[192] . '<div class="help" onclick="open_page(\'21\');" onmouseover="show_title(\'21\',this);"></div></a></li>
   <li><a href="admin_index.php?action=manage_category">' . $lang[193] . '<div class="help" onclick="open_page(\'21\');" onmouseover="show_title(\'1\',this);"></div></a></li>
 
</ul>

<div id="tab1" class="tabset_content">
</div>

<div id="tab2" class="tabset_content">
</div>

<div id="tab3" class="tabset_content">
</div>

<div id="tab4" class="tabset_content">
</div>

<div id="tab5" class="tabset_content">
</div>

<div id="tab6" class="tabset_content">
</div>

<div id="tab7" class="tabset_content">
</div>


</div>

';
}

function template_admin_option_setting()
{
    global $lang, $sett_compnay;

    echo '
<form id="option_form" name="option" method="post" action="' . SITEURL . '/administrator/admin_index.php?action=option" class="form-horizontal" role="form">


<div class="col-sm-6 col-xs-12"   >';
    echo '
<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[117] . '</label>
<div class="col-xs-7"><input type="text" name="co_name" value="' . $sett_compnay["co_name"]["option_value"] . '"  /></div>
</div>

<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[118] . '</label>
<div class="col-xs-7"><input type="text" name="co_name_short" value="' . $sett_compnay["co_name_short"]["option_value"] . '"  /></div>
</div>

<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[7] . '</label>
<div class="col-xs-7"><input type="text" name="co_address" value="' . $sett_compnay["co_address"]["option_value"] . '"  /></div>
</div>

<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[145] . '</label>
<div class="col-xs-7"><input type="text" name="co_city" value="' . $sett_compnay["co_city"]["option_value"] . '"  /></div>
</div>

<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[144] . '</label>
<div class="col-xs-7"><input type="text" name="co_provstate" value="' . $sett_compnay["co_provstate"]["option_value"] . '" /></div>
</div>

<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[592] . '</label>
<div class="col-xs-7"><textarea name="co_terms" style="width: 200px; height: 88px;" >' . $sett_compnay["co_terms"]["option_value"] . ' </textarea></div>
</div>


<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[593] . '</label>
<div class="col-xs-7"><input type="text" name="company_default_waybill_no" value="' . $sett_compnay["company_default_waybill_no"]["option_value"] . '" /></div>
</div>

<div class="form-group">
<label class="col-xs-5 control-label">رقم بداية الطلبية</label>
<div class="col-xs-7"><input type="text" name="easy_order" value="' . $sett_compnay["easy_order"]["option_value"] . '" /></div>
</div>

		
</div>

<div class="col-sm-6 col-xs-12" >

<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[9] . '</label>
<div class="col-xs-7"><input type="text" name="co_pcode" value="' . $sett_compnay["co_pcode"]["option_value"] . '" /></div>
</div>


<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[11] . '</label>
<div class="col-xs-7"><input type="text" name="co_phone" value="' . $sett_compnay["co_phone"]["option_value"] . '"  /></div>
</div>

<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[120] . ' (1)</label>
<div class="col-xs-7"><input type="text" name="co_phone_alt1" value="' . $sett_compnay["co_phone_alt1"]["option_value"] . '"  /></div>
</div>

<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[610] . '</label>
<div class="col-xs-7"><input type="text" name="co_phone_alt1_type" value="' . $sett_compnay["co_phone_alt1_type"]["option_value"] . '"  /></div>
</div>

<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[120] . ' (2)</label>
<div class="col-xs-7"><input type="text" name="co_phone_alt2" value="' . $sett_compnay["co_phone_alt2"]["option_value"] . '"  /></div>
</div>

<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[610] . '</label>
<div class="col-xs-7"><input type="text" name="co_phone_alt2_type" value="' . $sett_compnay["co_phone_alt2_type"]["option_value"] . '"  /></div>
</div>


<div class="form-group">
<label class="col-xs-5 control-label">' . $lang[12] . '</label>
<div class="col-xs-7"><input type="text" name="co_fax" value="' . $sett_compnay["co_fax"]["option_value"] . '"  /></div>
</div>
		
		


		
		
</div>

		
		
<div class="col-sm-6 col-xs-12">
		
		<div class="form-group">
<label class="col-xs-6 control-label">' . $lang[594] . '</label>
<div class="col-xs-6">
<input type="hidden" name="co_view_terms" value="0"   />
<input type="checkbox" name="co_view_terms" value="1" ' . ($sett_compnay["co_view_terms"]["option_value"] == 1 ? 'checked' : '') . '  /></div>
</div>
		
		
		


		
<div class="form-group">
<label class="col-xs-6 control-label">طباعة البار كود</label>
<div class="col-xs-6">
<input type="hidden" name="barcode_option" value="N"   />
<input type="checkbox" name="barcode_option" value="Y"  ' . ($sett_compnay["barcode_option"]["option_value"] == 'Y' ? 'checked' : '') . ' />
</div>
</div>



<div class="form-group">
<label class="col-xs-6 control-label">تاريخ المنطقة</label>
<div class="col-xs-6">
	    		';
    $timezoneList = timezoneList();
    echo '<select name="time_zone" class="form-control">';
    foreach ($timezoneList as $value => $label) {
        echo '<option value="' . $value . '" ' . ($sett_compnay["time_zone"]["option_value"] == $value ? 'selected' : '') . ' >' . $label . '</option>';
    }
    echo '</select>';
    echo '</div>
</div>

<div class="form-group">
<label class="col-xs-6 control-label">شكل التاريخ</label>
<div class="col-xs-6">
<select name="date_format">
		<option value="d-m-y" ' . ($sett_compnay["date_format"]["option_value"] == "d-m-y" ? 'selected' : '') . '>' . date("d-m-y") . ' - (d-m-y)</option>
		<option value="m-d-y" ' . ($sett_compnay["date_format"]["option_value"] == "m-d-y" ? 'selected' : '') . '>' . date("m-d-y") . ' - (m-d-y)</option>						
</select>	
</div>
</div>
				
				<div class="form-group">
<label class="col-xs-6 control-label">شكل الوقت</label>
<div class="col-xs-6">
<select name="time_format">
		<option value="g:i A" ' . ($sett_compnay["time_format"]["option_value"] == "g:i A" ? 'selected' : '') . '>' . date("g:i A") . ' - (g:i A)</option>
		<option value="H:i:s" ' . ($sett_compnay["time_format"]["option_value"] == "H:i:s" ? 'selected' : '') . '>' . date("H:i:s") . ' - (H:i:s)</option>						
</select>	
</div>
</div>

	    			    		<div class="form-group">
<label class="col-xs-6 control-label">شكل الوقت والتاريخ</label>
<div class="col-xs-6">
<select name="date_time_format" class="form-control">
		<option value="F j, Y, g:i a" ' . ($sett_compnay["date_time_format"]["option_value"] == "F j, Y, g:i a" ? 'selected' : '') . '>' . date("F j, Y, g:i a") . ' - (F j, Y, g:i a)</option>
		<option value="Y-m-d H:i:s" ' . ($sett_compnay["date_time_format"]["option_value"] == "Y-m-d H:i:s" ? 'selected' : '') . '>' . date("Y-m-d H:i:s") . ' - (Y-m-d H:i:s)</option>				
</select>	
</div>
</div>
	    		
	    		
	    		
</div>

<div style="clear:both;"></div>

<input  type="button" onclick="add_form_php(\'option_form\',\'1\',\'tabs\');" name="edit_company" class="btn btn-info" value="' . $lang[295] . '">

</form>
			
<div style="clear:both;"></div>	

';
}

function template_mange_category()
{
    global $lang;
    echo '
  <script>
  $(document).ready(function() {
    $("#cat").tabs(
	
	
	);
	
	  var $tt = $("#cat").tabs({
        add: function(event, ui) {
        $tt.tabs("select", "#" + ui.panel.id);
    }
});
	
});
</script>
<div id="cat" >
<ul >
   <li><a href="admin_index.php?action=category_setting" class="active">' . $lang[135] . '</a></li>
   <li><a href="admin_index.php?action=add_category">' . $lang[132] . '</a></li>

</ul>

<div id="cat1" class="tabset_content">
</div>

<div id="cat2" class="tabset_content">
</div>


</div>

';
}

function template_category_setting()
{
    global $data, $lang;

    if (is_array($data) && count($data) > 0) {
//var_dump($data);
        echo '<table  width="100%"  class="table table-striped table-bordered table-hover">';
        $x = $data[0];
        echo '<tr>';
        foreach ($x as $val) {

            echo '<th> ' . key($val) . '</th>';
        }
        echo '<th>' . $lang[312] . '</th>';
        echo '<th>' . $lang[259] . '</th>';
        echo '</tr>';

        for ($i = 0; $i < count($data); $i++) {
            echo '<tr>';
            $x = $data[$i];

            foreach ($x as $val) {

                echo '<td>' . $val[key($val)] . '</td>';
            }

            echo '<td><a onclick="show_edit_cat(\'' . $data[$i][0]['ID'] . '\',\'' . $data[$i][1]['Category Name'] . '\');" href="#" >' . $lang[312] . '</a></td>';
            echo '<td><a onclick="cat_del(' . $data[$i][0]['ID'] . ');"  href="#"  >' . $lang[259] . '</a></td>';

            echo '</tr>';
        }
        echo '</table>
<div id="cat_del"></div>
';
    } else {
        echo '<div style="text-align:center;">' . $lang[472] . '</div>';
    }


}

function template_add_category()
{
    global $lang;
    echo '

<form name="add_cat1" id="add_cat1" method="post" action="' . SITEURL . '/administrator/admin_index.php?action=add_category" class="form-horizontal" role="form">
<div class="col " style="width:35%;"  >

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[133] . '</label>
<div class="col-sm-9"><input type="text" name="cat_name" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[134] . '</label>
<div class="col-sm-9">
<select name="cat_type">
<option value="">' . $lang[136] . '</option>
<option value="usertype" >' . $lang[137] . '</option>
<option value="Location" >' . $lang[138] . '</option>
</select>

</div>
</div>

<div class="form-group">
<input style="margin-left:30px; margin-bottom:10px; margin-top:10px;" type="button" onclick="add_cat();" name="addcat" class="btn btn-info"" value="' . $lang[132] . '">
</div>

</div>
</form>
<div id="cat_dia"></div>
<div style="clear:both;"></div>	

';
}

function template_category_edit()
{
    global $lang, $res;
    echo '

<form name="edit_cat" id="edit_cat" method="post" action="' . SITEURL . '/administrator/admin_index.php?action=category_edit" class="form-horizontal" role="form">
<input type="hidden" name="cat_id" value="' . $res->cat_id . '" /> 

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[133] . '</label>
<div class="col-sm-9"><input type="text" name="cat_name_edit" id="cat_name_edit" value="' . $res->cat_name . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[134] . '</label>
<div class="col-sm-9">
<select name="cat_type_edit" id="cat_type_edit">
<option value="">' . $lang[136] . '</option>
<option value="usertype" ' . ($res->cat_type == "usertype" ? 'selected' : '') . ' >' . $lang[137] . '</option>
<option value="Location" ' . ($res->cat_type == "Location" ? 'selected' : '') . ' >' . $lang[138] . '</option>
</select>

</div>
</div>

<div class="form-group">
<input style="margin-left:30px; margin-bottom:10px; margin-top:10px;" type="button" onclick="edit_cata();" name="editcat"   class="btn btn-info" value="' . $lang[143] . '">
</div>


</div>

</form>
<div id="result"></div>
<div style="clear:both;"></div>
';
}

function template_invoice_setting()
{
    global $lang, $payment_type, $payment_frequency, $payment_term, $setting, $c_setting, $currency, $curSign;
    $setting = $c_setting;
    echo '	
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>


<form id="invoice_setting" name="option"  method="post" action="' . SITEURL . '/administrator/admin_index.php?action=invoice_setting" class="form-horizontal" role="form" >

<div class="col" style="float:left; width:45%;">
<div class="title">' . $lang[158] . '</div>
<div style="clear:both;"></div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[660] . '</label>
<div class="col-sm-9"><input type="text" name="co_invoice_message" value="' . $setting['co_invoice_message'] . '" size="30"></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[69] . '</label>
<div class="col-sm-9">
<input type="hidden" name="co_online_invoicing" value="N" >
<input type="checkbox" name="co_online_invoicing" value="Y"  ' . ($setting['co_online_invoicing'] == 'Y' ? 'checked' : '') . ' ></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . ' (1)</label>
<div class="col-sm-9"><input type="text" name="co_online_invoice_email_copy1" value="' . $setting['co_online_invoice_email_copy1'] . '" size="35"></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . ' (2)</label>
<div class="col-sm-9"><input type="text" name="co_online_invoice_email_copy2" value="' . $setting['co_online_invoice_email_copy1'] . '" size="35"></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[661] . '</label>
<div class="col-sm-9">
<input type="hidden" name="co_online_payments" value="N"  >
<input type="checkbox" name="co_online_payments" value="Y" ' . ($setting['co_online_payments'] == 'Y' ? 'checked' : '') . ' ></div>
</div>

<div class="des">
' . $lang[805] . '
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[662] . '</label>
<div class="col-sm-9">
<table>
<tr><td>' . $currency[1] . '</td><td><input type="radio" name="co_online_payments_currency" value="1"  ' . ($setting['co_online_payments_currency'] == '1' ? 'checked' : '') . ' > (' . $curSign[$currency[1]] . ')</td></tr>
<tr><td>' . $currency[2] . '</td><td><input type="radio" name="co_online_payments_currency" value="2" ' . ($setting['co_online_payments_currency'] == '2' ? 'checked' : '') . ' > (' . $curSign[$currency[2]] . ')</td></tr>
<tr><td>' . $currency[3] . '</td><td><input type="radio" name="co_online_payments_currency" value="3" ' . ($setting['co_online_payments_currency'] == '3' ? 'checked' : '') . ' > (' . $curSign[$currency[3]] . ')</td></tr>
<tr><td>' . $currency[4] . '</td><td><input type="radio" name="co_online_payments_currency" value="4" ' . ($setting['co_online_payments_currency'] == '4' ? 'checked' : '') . ' > (' . $curSign[$currency[4]] . ')</td></tr>
		
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . '</label>
<div class="col-sm-9"><input type="text" name="co_online_payments_email" value="' . $setting['co_online_payments_email'] . '" size="35"></div>
</div>



<div class="des">
' . $lang[807] . '
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[663] . '</label>
<div class="col-sm-9"><input type="checkbox" name="co_invoicing_goodtogo" ' . ($setting['co_invoicing_goodtogo'] == 'Y' ? 'checked' : '') . '  ></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[642] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table >
<tr><td>' . $lang[808] . '</td>
</tr>

<tr><td>
<select name="co_invoiceoption_rb1">
<option value="1" ' . ($setting['co_invoiceoption_rb1'] == '1' ? 'selected' : '') . '>' . $lang[723] . '</option>
<option value="2" ' . ($setting['co_invoiceoption_rb1'] == '2' ? 'selected' : '') . '>' . $lang[724] . '</option>
<option value="3" ' . ($setting['co_invoiceoption_rb1'] == '3' ? 'selected' : '') . '>' . $lang[725] . '</option></select>
</td></tr>
</table>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[643] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>
' . $lang[726] . '
</td></tr>
<tr><td>
<select name="co_invoiceoption_rb2">
<option value="1" ' . ($setting['co_invoiceoption_rb2'] == "1" ? 'selected' : '') . '>' . $lang[451] . '</option>
<option value="2" ' . ($setting['co_invoiceoption_rb2'] == "2" ? 'selected' : '') . ' >' . $lang[452] . '</option>
</select>
</td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[644] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>
' . $lang[728] . '
</td></tr>
<tr><td>
<select name="co_invoiceoption_rb3">
<option value="1" ' . ($setting['co_invoiceoption_rb3'] == "1" ? 'selected' : '') . '>' . $lang[729] . '</option>
<option value="2" ' . ($setting['co_invoiceoption_rb3'] == "2" ? 'selected' : '') . ' >' . $lang[730] . '</option>
<option value="3" ' . ($setting['co_invoiceoption_rb3'] == "3" ? 'selected' : '') . ' >' . $lang[731] . '</option></select>
</td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[645] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>' . $lang[737] . '
</td></tr>
<tr>
<td>
<select name="co_invoiceoption_rb4">
<option value="1" ' . ($setting['co_invoiceoption_rb4'] == "1" ? 'selected' : '') . '>' . $lang[731] . '</option>
<option value="2" ' . ($setting['co_invoiceoption_rb4'] == "2" ? 'selected' : '') . ' >' . $lang[732] . '</option>
</select>
</td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[646] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>
' . $lang[738] . '
</td></tr>
<tr><td>
<select name="co_invoiceoption_rb7">
<option value="1" ' . ($setting['co_invoiceoption_rb7'] == "1" ? 'selected' : '') . '>' . $lang[733] . '</option>
<option value="2" ' . ($setting['co_invoiceoption_rb7'] == "2" ? 'selected' : '') . '>' . $lang[734] . '</option>
<option value="3" ' . ($setting['co_invoiceoption_rb7'] == "3" ? 'selected' : '') . '>' . $lang[735] . '</option>
<option value="4" ' . ($setting['co_invoiceoption_rb7'] == "4" ? 'selected' : '') . '>' . $lang[736] . '</option>
</select>
</td></tr>
</table>
</div>
</div>




<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[647] . '</label>
<div class="col-sm-9" style="width:60%;" >
<input type="hidden" name="co_invoiceoption_1"   value="N" >
<input type="checkbox" name="co_invoiceoption_1" value="Y" ' . ($setting['co_invoiceoption_1'] == 'Y' ? 'checked' : '') . '  >
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[648] . '</label>
<div class="col-sm-9" style="width:60%;" >
<input type="hidden" name="co_invoiceoption_7" value="N" >
<input type="checkbox" name="co_invoiceoption_7" value="Y" ' . ($setting['co_invoiceoption_7'] == 'Y' ? 'checked' : '') . '  >
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[649] . '</label>
<div class="col-sm-9" style="width:60%;" >
<input type="hidden" name="co_invoiceoption_5" value="N"  >
<input type="checkbox" name="co_invoiceoption_5" value="Y" ' . ($setting['co_invoiceoption_5'] == 'Y' ? 'checked' : '') . ' >
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[650] . '</label>
<div class="col-sm-9" style="width:60%;" >
<input type="hidden" name="co_invoiceoption_6"  value="N" >
<input type="checkbox" name="co_invoiceoption_6" value="Y" ' . ($setting['co_invoiceoption_6'] == 'Y' ? 'checked' : '') . '  >
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[651] . '</label>
<div class="col-sm-9" style="width:60%;" >
<input type="hidden" name="co_invoiceoption_4" value="N" >
<input type="checkbox" name="co_invoiceoption_4" value="Y" ' . ($setting['co_invoiceoption_4'] == 'Y' ? 'checked' : '') . '  >
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[666] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>' . $lang[809] . '</td></tr>
<tr><td>
<select name="co_invoiceoption_rb5">
<option value="1" ' . ($setting['co_invoiceoption_rb5'] == "1" ? 'selected' : '') . '>1 ' . $lang[810] . '</option>
<option value="2" ' . ($setting['co_invoiceoption_rb5'] == "2" ? 'selected' : '') . '>2 ' . $lang[810] . '</option>
<option value="3" ' . ($setting['co_invoiceoption_rb5'] == "3" ? 'selected' : '') . '>3 ' . $lang[810] . '</option>
</select></td></tr>
</table>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[652] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>' . $lang[811] . '</td></tr>
<tr><td>
<select name="co_invoiceoption_rb6">
<option value="1" ' . ($setting['co_invoiceoption_rb6'] == "1" ? 'selected' : '') . '>' . $lang[745] . '</option>
<option value="2" ' . ($setting['co_invoiceoption_rb6'] == "2" ? 'selected' : '') . '>' . $lang[746] . '</option>
<option value="3" ' . ($setting['co_invoiceoption_rb6'] == "3" ? 'selected' : '') . '>' . $lang[747] . '</option>
</select></td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[665] . '</label>
<div class="col-sm-9" style="width:60%;" >
<input type="text" name="co_lines_perpage" value="' . $setting['co_lines_perpage'] . '" size="4" >
</div>
</div>

</div>


<div class="col" style="float:left; width:45%;">';

    if (is_array($payment_type)) {
        echo '
<table  style="float:left; width:48%;" border="1" align="center" id="pay_table" class="table table-striped table-bordered table-hover" > 
<tr>
<th>' . $lang[159] . '</th>
</tr>
';
        for ($i = 0; $i < (count($payment_type)); $i++) {
            echo '<tr>
<td>' . $payment_type[$i]['payment_name'] . '</td>
</tr>';
        }
        echo '
</table>';
    }


    if (is_array($payment_frequency)) {
        echo '
<table  style="float:left; width:48%;" border="1" align="center" id="fre_table" class="table table-striped table-bordered table-hover" > 
<tr>
<th>Payment Frequency</th>
</tr>
';
        for ($i = 0; $i < (count($payment_frequency)); $i++) {

            echo '<tr>
<td>' . $payment_frequency[$i]['option_value'] . '</td>
</tr>';
        }
        echo '
</table>';
    }


    echo '
<div style="clear:both;"></div>
';

    if (is_array($payment_term)) {
        echo '
<table style="width:98%;" border="1" align="center" id="term_table" class="table table-striped table-bordered table-hover"> 
<tr>
<th>Name</th>
<th>Term Description</th>
<th>Days Due</th>
</tr>
';
        for ($i = 0; $i < (count($payment_term)); $i++) {
            echo '<tr>
<td>' . $payment_term[$i]['pt_name'] . '</td>
<td>' . $payment_term[$i]['pt_des'] . '</td>
<td>' . $payment_term[$i]['pt_due'] . '</td>
</tr>';
        }
        echo '


</table>';
    }


    echo '
</div>

<div style="clear:both;"></div>	
<hr/>
<div class="form-group">
<div class="col-sm-9" style="width: 200px; float: none;margin: auto; height:40px;">
<input type="button" name="save" class="btn btn-info" onclick="edit_invoice()" value="' . $lang[219] . '">
</div>
</div>

</form>
<div style="clear:both;"></div>	



';
}


function template_mlogo()
{
    global $lang, $invoice, $waybill, $logo;

    echo '<div class="row">

		<div class="col-xs-12 col-sm-6 widget-container-col ui-sortable">
		
		<div class="widget-box widget-color-blue ui-sortable-handle">
		<div class="widget-header">
		<div class="widget-title">' . $lang[868] . '</div>
		</div>	
				
		<div class="widget-body">
		<div class="widget-main">
				
				<form name="logo"  method="post" action="' . SITEURL . '/administrator/admin_index.php?action=mlogo" class="form-horizontal" role="form" enctype="multipart/form-data">
				
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[870] . '</label>
<div class="col-sm-9"  >
<input type="file" name="invoice_logo"   >
</div>
		
		<div id="invoice_logo" style="border:1px solid #000; float:left; margin:20px;">';
    if ($invoice) echo '<img src="' . SITEURL . '/images/invoice_banner.jpg" />';
    else echo '<img src="' . SITEURL . '/images/yourLogoHere.png" />';

    echo '</div>
</div>
				
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[871] . '</label>
<div class="col-sm-9" style="width:60%;" >
<input type="file" name="waybill_banner"   >
</div>
		
				<div id="waybill_logo" style="border:1px solid #000; float:left; margin:20px;">';
    if ($waybill) echo '<img src="' . SITEURL . '/images/waybill_banner.jpg" />';
    else echo '<img src="' . SITEURL . '/images/yourLogoHere.png" />';
    echo '</div>
				
</div>
				
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[872] . '</label>
<div class="col-sm-9" style="width:60%;" >
<input type="file" name="logo"   >
</div>
		
				<div id="waybill_logo" style="border:1px solid #000; float:left; margin:20px;">';
    if ($logo) echo '<img src="' . SITEURL . '/images/logo.jpg" />';
    else echo '<img src="' . SITEURL . '/images/yourLogoHere.png" />';
    echo '</div>
				
</div>
				
				<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" id="submit" name="upload">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Upload
											</button>

										</div>
									</div>
		
				</form>
				
				</div>
				</div>
				</div>
				</div>
				</div>';
}


function template_mconsole()
{
    global $lang, $console_list, $coloums, $report_list;

    echo '
					<link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/css/multiselectdrag.css" />
			        <script src="' . SITEURL . '/' . STYLE . '/jscript/jquery.cookie.js"></script>

				<script type="text/javascript">
		function moveto(x){
 window.location.href = "admin_index.php?action=mconsole&console_id="+x;
}
		</script>
			        		<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[874] . '</label>
<div class="col-sm-9">
		<select name="console" onchange="moveto(this.value);">
		<option value="0">' . $lang[874] . '</option>
		';
    if (is_array($console_list) && count($console_list) > 0) {
        for ($i = 0; $i < count($console_list); $i++) {
            echo '<option value="' . $console_list[$i]['id'] . '" ' . (isset($_GET['console_id']) && $_GET['console_id'] == $console_list[$i]['id'] ? 'selected' : '') . ' >' . $console_list[$i]['console_name'] . '</option>';
        }
    }
    echo '

				
		</select>
</div>
</div>
					
					
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[934] . '</label>
<div class="col-sm-9"><select name="console" onchange="moveto(this.value);">
		<option value="0">Select Report</option>
		';
    if (is_array($report_list) && count($report_list) > 0) {
        for ($i = 0; $i < count($report_list); $i++) {
            echo '<option value="' . $report_list[$i]['id'] . '" ' . (isset($_GET['console_id']) && $_GET['console_id'] == $report_list[$i]['id'] ? 'selected' : '') . ' >' . $report_list[$i]['console_name'] . '</option>';
        }
    }
    echo '

				
		</select>
</div>
</div>
					
					';

    if (is_array($coloums) && count($coloums) > 0) {
        echo '
					
					
							<h4 class="header green clearfix">
									' . $lang[875] . '
											<small>
											Drag fields you wish to display in the console/report from left column to right column  
											</small>
								</h4>
											
				<form name="console"  method="post" action="' . SITEURL . '/administrator/admin_index.php?action=mconsole&console_id=' . $_GET['console_id'] . '" class="form-horizontal" role="form" style="width: 50%;margin: auto;">
											
								<div id="example-2-1" style="margin:auto;">
														
			<div class="column left first" >
<p style="text-align:center; font-size:15px; font-weight:bold;">Available Fields </p>
	<p style="text-align:center; font-size:15px; font-weight:bold; margin:0px; color:green; ">Add &rarr;</p>
						
					<ul class="sortable-list">
											';
        for ($i = 0; $i < count($coloums); $i++) {
            if ($coloums[$i]['status'] == "1") echo '<li class="sortable-item" id="' . $coloums[$i]['id'] . '">' . $coloums[$i]['display'] . '</li>';
        }

        echo '
				
					</ul>

				</div>

				<div class="column left">
<p style="text-align:center; font-size:15px; font-weight:bold;">Selected Fields</p>
		<p style="text-align:center; font-size:15px; font-weight:bold; margin:0px; color:red; ">&larr; Remove</p>
					<ul class="sortable-list">
					';
        for ($i = 0; $i < count($coloums); $i++) {
            if ($coloums[$i]['status'] == "0") echo '<li class="sortable-item ' . ($coloums[$i]['is_default'] == "1" ? 'nondraggable' : '') . '" id="' . $coloums[$i]['id'] . '">' . $coloums[$i]['display'] . '</li>';
        }

        echo '
					</ul>

				</div>
						</div>					
	<div style="clear:both;"></div>
						<div style="margin:10px;" >
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="button"  name="console" onclick="edit_console(\'' . $_GET['console_id'] . '\')">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Save
											</button>

										</div>
									</div>
		
		</form>';

    }


}

?>