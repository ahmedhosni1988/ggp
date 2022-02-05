<?php

function template_price_manage()
{
    global $lang, $c_setting;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
  <script>
  $(document).ready(function() {
    $("#tabs").tabs();
	
	  var $tabs = $("#tabs").tabs({
        add: function(event, ui) {
        $tabs.tabs("select", "#" + ui.panel.id);
    }
});



  

    });
  </script>
  
<div id="right_side">
<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>';

    echo '  
    <li><a href="pricing.php?action=price_checkbox&what=mange" >التسعير</a></li>
     <li><a href="pricing.php?action=options_manage" >' . $lang[213] . '</a></li>

';

    echo '</ul>

<div id="tabs-0" style="padding:0px;" >
</div>

</div>
</div>

';
}


function template_price_option_mange()
{
    global $lang;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
  <script>
  $(document).ready(function() {
    $("#price_option").tabs();
  });
  </script>
  
<div id="price_option" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
<li><a href="pricing.php?action=price_pac&what=mange" >' . $lang[261] . '</a></li>
   <li><a href="pricing.php?action=price_checkbox&what=mange" >' . $lang[252] . '</a></li>
   
   
</ul>

<div id="pricetabs-0" style="padding:0px;" >
</div>

<div id="pricetabs-1" >
</div>

<div id="pricetabs-2" >
</div>

<div id="pricetabs-3" >
</div>


</div>

';
}

function template_price_setting()
{
    global $lang;
    echo '';
}

//////////////////addtional services and checkbox in old system
function template_price_checkbox_mange()
{
    global $lang;

    echo ' <script>
  $(document).ready(function() {
    $("#check_option").tabs();
	

  });
  </script>
  
<div id="check_option" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   <li><a href="pricing.php?action=price_checkbox&what=setting" >' . $lang[252] . '</a></li>
   <li><a href="pricing.php?action=price_checkbox&what=add" >' . $lang[659] . '</a></li>
   
</ul>

<div id="pricetabscheck-0" style="padding:0px;" >
</div>

<div id="pricetabscheck-1" >
</div>




</div>
';
}

function template_price_checkbox_add()
{
    global $lang, $pack;

    echo '


<form id="add_check" method="post" action="' . SITEURL . '/administrator/pricing.php?action=price_checkbox" style="width:100%;" >
<input type="hidden" name="add_check" value="1" />

<div class="form-group">

<label class="col-sm-3 control-label">الثمك</label>
<div class="col-sm-9">
<select  name="pack_id">
<option value="" >' . $lang[362] . ' </option>';
    for ($i = 0; $i < count($pack); $i++) {
        echo '<option value="' . $pack[$i]['package_id'] . '">' . $pack[$i]['package_name'] . '</option>';
    }
    echo '
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">رقم الفاتورة</label>
<div class="col-sm-9"><input type="text" name="ch_name" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[254] . '</label>
<div class="col-sm-9"><input type="text" name="ch_shortname" value="" /></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">طول</label>
<div class="col-sm-9"><input type="text" name="length" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">عرض</label>
<div class="col-sm-9"><input type="text" name="width" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[286] . '</label>
<div class="col-sm-9"><input type="text" name="ch_fee" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9"><input type="button" onclick="add_addservices();" class="btn btn-info"  value="اضافة فاتورة" name="update"/>
</div>
</div>

</form>
<div style="clear:both;"></div>
';
}

function template_price_checkbox_edit()
{
    global $lang, $edit, $pack;

    echo '


<form id="edit_check" method="post" action="' . SITEURL . '/administrator/pricing.php?action=price_checkbox" style="width:100%;" >
<input type="hidden" name="edit_check" value="1" />
<input type="hidden" name="edit_check_id" value="' . $edit->id . '" />


<div class="form-group">

<label class="col-sm-3 control-label">الثمك</label>
<div class="col-sm-9">
<select  name="pack_id">
<option value="" >' . $lang[362] . ' </option>';
    for ($i = 0; $i < count($pack); $i++) {
        echo '<option value="' . $pack[$i]['package_id'] . '" ' . ($pack[$i]['package_id'] == $edit->pack_id ? "selected" : "") . '>' . $pack[$i]['package_name'] . '</option>';
    }
    echo '
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">رقم الفاتورة</label>
<div class="col-sm-9"><input type="text" name="ch_name" value="' . $edit->bill_id . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[254] . '</label>
<div class="col-sm-9"><input type="text" name="ch_shortname" value="' . $edit->quantity . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">طول</label>
<div class="col-sm-9"><input type="text" name="length" value="' . $edit->length . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">عرض</label>
<div class="col-sm-9"><input type="text" name="width" value="' . $edit->width . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[286] . '</label>
<div class="col-sm-9"><input type="text" name="ch_fee" value="' . $edit->price . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9"><input type="button" onclick="edit_addservices();" class="btn btn-info" style="margin:0 auto;" value="تعديل الفاتورة" name="update"/>
</div>
</div>

</form>
<div style="clear:both;"></div>
';
}

function template_price_checkbox()
{
    global $lang, $check, $pack;
    echo '
<table border="1" class="table table-striped table-bordered table-hover" id="add_serv" >
<thead>
<tr>
<th>ثمك الزجاج</th>
<th>رقم الفاتورة</th>
<th>' . $lang[254] . '</th>
<th>' . $lang[255] . '</th>
<th>' . $lang[312] . '</th>
<th>' . $lang[259] . '</th>
</tr>
</thead>

<tbody>
';

    if (count($check) > 0) {
        for ($i = 0; $i < count($check); $i++) {
            echo '
<tr>
<td>' . $pack[$check[$i]['pack_id']]['package_name'] . '</td>
<td>' . $check[$i]['bill_id'] . '</td>
<td>' . $check[$i]['quantity'] . '</td>
<td>' . $check[$i]['price'] . '</td>
<td><a href="#" onclick="edit_add_service(\'' . $check[$i]['id'] . '\',\'' . $check[$i]['bill_id'] . '\');">' . $lang[312] . '</a></td>
<td><a href="#" onclick="delete_add_service(\'' . $check[$i]['id'] . '\');">' . $lang[259] . '</a></td>
</tr>
';
        }
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }

    echo '
</tbody>


</table>
<div style="clear:both;"></div>
';
}



/////////////////////////////////


//////////////////////vechile services /////////////////
function template_price_additional_mange()
{
    global $lang;

    echo ' <script>
  $(document).ready(function() {
    $("#add_option").tabs();
  });
  </script>
  
<div id="add_option" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   <li><a href="pricing.php?action=price_addtional&what=setting" >' . $lang[323] . '</a></li>
   <li><a href="pricing.php?action=price_addtional&what=add" >' . $lang[322] . '</a></li>
   
</ul>

<div id="pricetabsadd-0" style="padding:0px;" >
</div>

<div id="pricetabsadd-1" >
</div>




</div>
';
}

function template_price_additional_add()
{
    global $lang;

    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/price.js"></script>

<form id="add_addservice" method="post" action="' . SITEURL . '/administrator/pricing.php?action=price_addtional" class="form-horizontal" >
<input type="hidden" name="add_add" value="1" />
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[324] . '</label>
<div class="col-sm-9"><input type="text" name="ch_name" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9"><input type="button" onclick="add_vec_services();" class="btn btn-info"  value="' . $lang[322] . '" name="update"/>
</div>
</div>

</form>
<div style="clear:both;"></div>
';
}

function template_price_additional_edit()
{
    global $lang, $edit;

    echo '
		
<form id="edit_addservice" method="post" action="' . SITEURL . '/administrator/pricing.php?action=price_addtional" class="form-horizontal" >
<input type="hidden" name="edit_add" value="1" />
<input type="hidden" name="edit_add_id" value="' . $edit->id . '" />
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[324] . '</label>
<div class="col-sm-9"><input type="text" name="ch_name" value="' . $edit->name . '" /></div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9"><input type="button" onclick="edit_vecservices();" class="btn btn-info"  value="' . $lang[325] . '" name="update"/>
</div>
</div>

</form>
<div style="clear:both;"></div>
';
}

function template_price_additional()
{
    global $lang, $add_ser;
    echo '

<table border="1" class="table table-striped table-bordered table-hover" id="add_serv" >
<thead>
<tr>
<th>' . $lang[257] . '</th>
<th>' . $lang[36] . '</th>
<th>' . $lang[312] . '</th>
<th>' . $lang[259] . '</th>
</tr>
</thead>

<tbody>
';

    if (count($add_ser) > 0) {

        for ($i = 0; $i < count($add_ser); $i++) {
            echo '
<tr>
<td>' . $add_ser[$i]['id'] . '</td>
<td>' . $add_ser[$i]['name'] . '</td>
<td><a href="#" onclick="edit_vec_service(\'' . $add_ser[$i]['id'] . '\',\'' . $add_ser[$i]['name'] . '\');">' . $lang[312] . '</a></td>
<td><a href="#" onclick="delete_vec_service(\'' . $add_ser[$i]['id'] . '\');">' . $lang[259] . '</a></td>
</tr>
';
        }
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }

    echo '
</tbody>
</table>
<div style="clear:both;"></div>
';
}

////////////////////////////////////

///////////pacjage managment////////
function template_price_pac_mange()
{
    global $lang;

    echo ' <script>
  $(document).ready(function() {
    $("#price_pac").tabs();
  });
  </script>
  
<div id="price_pac" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   <li><a href="pricing.php?action=price_pac&what=setting" >' . $lang[326] . '</a></li>
   <li><a href="pricing.php?action=price_pac&what=add" >' . $lang[327] . '</a></li>
   
</ul>

<div id="price_pac-0" style="padding:0px;" >
</div>

<div id="price_pac-1" >
</div>

</div>
';
}

function template_price_pac_add()
{
    global $lang;
    echo '
<form id="add_pacervice" method="post" action="' . SITEURL . '/administrator/pricing.php?action=price_pac"  >

<input type="hidden" name="add_pac" value="1" />

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[328] . '</label>
<div class="col-sm-9"><input type="text" name="pac_name" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[329] . '</label>
<div class="col-sm-9"><input type="text" name="pac_name_short" value="" /></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9"><input type="button" onclick="add_pac_services();" class="btn btn-info" style="margin:0 auto;" value="' . $lang[327] . '" name="update"/>
</div>
</div>

</form>
<div style="clear:both;"></div>
';
}

function template_price_pac_edit()
{
    global $lang, $edit;

    echo '
<form id="edit_pacservice" method="post" action="' . SITEURL . '/administrator/pricing.php?action=price_pac" style="width:100%;" >
<input type="hidden" name="edit_pac" value="1" />
<input type="hidden" name="edit_pac_id" value="' . $edit->package_id . '" />

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[328] . '</label>
<div class="col-sm-9"><input type="text" name="pac_name" value="' . $edit->package_name . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[329] . '</label>
<div class="col-sm-9"><input type="text" name="pac_name_short" value="' . $edit->package_short . '" /></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9">
<input type="button" onclick="edit_pacservices();" class="btn btn-info" style="margin:0 auto;" value="' . $lang[330] . '" name="update"/>
</div>
</div>

</form>
<div id="prdia"></div>
<div style="clear:both;"></div>
';
}

function template_price_pac()
{
    global $lang, $pac;
    echo '
<table border="1" class="table table-striped table-bordered table-hover" id="add_serv" >
<thead>
<tr>
<th>' . $lang[257] . '</th>
<th>' . $lang[36] . '</th>
<th>' . $lang[118] . '</th>
<th>' . $lang[312] . '</th>
<th>' . $lang[259] . '</th>
</tr>
</thead>

<tbody>
';

    if (count($pac) > 0) {
        for ($i = 0; $i < count($pac); $i++) {
            echo '
<tr>
<td>' . $pac[$i]['package_id'] . '</td>
<td>' . $pac[$i]['package_name'] . '</td>
<td>' . $pac[$i]['package_short'] . '</td>
<td><a href="#" onclick="edit_pac_service(\'' . $pac[$i]['package_id'] . '\',\'' . $pac[$i]['package_name'] . '\');">' . $lang[312] . '</a></td>
<td><a href="#" onclick="delete_pac_service(\'' . $pac[$i]['package_id'] . '\');">' . $lang[259] . '</a></td>
</tr>
';
        }
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }

    echo '
</tbody>


</table>
<div style="clear:both;"></div>
';
}


function template_price_option()
{
    global $lang, $check, $add_ser, $pac, $return, $price_option, $sett_compnay, $ret;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/price.js"></script>




<form id="option_price" name="option_price" method="post" action="' . SITEURL . '/administrator/pricing.php?action=price_setting" class="form-horizontal" role="form">

<input type="hidden" name="is_submited" value="1" />

<div class="row">
		<div class="col-xs-12 col-sm-3 widget-container-col ui-sortable">
										<div class="widget-box ui-sortable-handle">
											<div class="widget-header">
												<h5 class="widget-title smaller">' . $lang[263] . '</h5>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-6">
													';

    for ($r = 0; $r < 5; $r++) {
        echo '<div class="form-group">
<label class="col-sm-3 control-label">' . $ret[$return[$r]['option_name']] . '</label>
<input type="hidden" name="' . $return[$r]['option_name'] . '" value="N" >
<div class="col-sm-9"><input type="checkbox" name="' . $return[$r]['option_name'] . '" value="Y" ' . ($return[$r]['option_value'] == 'Y' ? 'checked' : '') . ' ></div>
</div>
';
    }

    echo '
';
    for ($r = 0; $r < count($add_ser); $r++) {
        echo '<div class="form-group">
<label class="col-sm-3 control-label">' . $add_ser[$r]['name'] . '</label>
<input type="hidden" name="add_' . $add_ser[$r]['id'] . '" value="N">
<div class="col-sm-9"><input type="checkbox" name="add_' . $add_ser[$r]['id'] . '" value="Y" ' . ($add_ser[$r]['return_cal'] == 'Y' ? 'checked' : '') . '></div>
</div>
';
    }
    echo '';
    for ($zz = 0; $zz < count($check); $zz++) {
        echo '<div class="form-group">
<label class="col-sm-3 control-label">' . $check[$zz]['name'] . '</label>
<input type="hidden" name="check_' . $check[$zz]['id'] . '" value="N" >
<div class="col-sm-9"><input type="checkbox" name="check_' . $check[$zz]['id'] . '" value="Y"  ' . ($check[$zz]['return_cal'] == 'Y' ? 'checked' : '') . ' ></div>
</div>
';
    }
    echo '
		
		
		
												</div>
											</div>
										</div>
									</div>
		
		
		
			<div class="col-xs-12 col-sm-3 widget-container-col ui-sortable">
										<div class="widget-box ui-sortable-handle">
											<div class="widget-header">
												<h5 class="widget-title smaller">' . $lang[930] . '</h5>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-6">
														
												<legend>' . $lang[43] . '</legend>

<div class="form-group">
<div class="col-sm-9">
<input type="radio" name="over_nclimit_flag_weight" value="Y" ' . ($price_option['price_weightcharge'] == 'Y' ? 'checked' : '') . '  >&nbsp;&nbsp; ' . $lang[335] . '<br>
<div style="clear:both;"></div>
<input type="radio" name="over_nclimit_flag_weight" value="N" ' . ($price_option['price_weightcharge'] == 'N' ? 'checked' : '') . '  >&nbsp;&nbsp; ' . $lang[336] . '<br>
<div style="clear:both;"></div>
<br>

</div>
</div>
		
		
		<legend>' . $lang[47] . '</legend>

<div class="form-group">
<div class="col-sm-9">
<input type="radio" name="over_nclimit_flag_volume" value="Y" ' . ($price_option['over_nclimit_flag_volume'] == 'Y' ? 'checked' : '') . ' >&nbsp;&nbsp; ' . $lang[337] . '<br>
<div style="clear:both;"></div>
<input type="radio" name="over_nclimit_flag_volume" value="N" ' . ($price_option['over_nclimit_flag_volume'] == 'N' ? 'checked' : '') . ' >&nbsp;&nbsp; ' . $lang[338] . '<br>
<div style="clear:both;"></div>
<br>

</div>
</div>
		

		<legend>' . $lang[269] . '</legend>
<div class="form-group">
<div class="col-sm-9">
<input type="radio" name="over_nclimit_flag_pieces" value="Y" ' . ($price_option['over_nclimit_flag_pieces'] == 'Y' ? 'checked' : '') . ' >&nbsp;&nbsp; ' . $lang[339] . '<br>
<div style="clear:both;"></div>
<input type="radio" name="over_nclimit_flag_pieces" value="N" ' . ($price_option['over_nclimit_flag_pieces'] == 'N' ? 'checked' : '') . ' >&nbsp;&nbsp; ' . $lang[340] . '<br>
<div style="clear:both;"></div>
<br>

</div>
</div>
		
		<legend>' . $lang[341] . '</legend>

<div class="form-group">
<div class="col-sm-9">
<input type="radio" name="wpv_chargemethod" value="Y" ' . ($price_option['wpv_chargemethod'] == 'Y' ? 'checked' : '') . ' ><div class="text">' . $lang[342] . '</div>
<div style="clear:both;"></div>
<input type="radio" name="wpv_chargemethod" value="N" ' . ($price_option['wpv_chargemethod'] == 'N' ? 'checked' : '') . ' ><div class="text">' . $lang[343] . '</div>
<div style="clear:both;"></div>
<br>

</div>
</div>
		
			
											    </div>
											</div>
										</div>
									</div>
		
		
			<div class="col-xs-12 col-sm-3 widget-container-col ui-sortable">
										<div class="widget-box ui-sortable-handle">
											<div class="widget-header">
												<h5 class="widget-title smaller">' . $lang[931] . '</h5>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-6">
														
													<legend>' . $lang[331] . '</legend>
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[43] . '</label>
<div class="col-sm-9"><input type="text" value="' . $price_option['co_uom_weight'] . '" name="co_uom_weight" size="5" /></div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[47] . '</label>
<div class="col-sm-9"><input type="text" value="' . $price_option['co_uom_volume'] . '" name="co_uom_volume" size="5"/></div>
</div>
		<hr/>	
														
		
		<legend>' . $lang[332] . '</legend>
<div class="form-group">
<div class="col-sm-9">
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[582] . '</label>
<div class="col-sm-9"><input type="text" name="price_distance_min" value="' . $price_option['price_distance_min'] . '"  ></div>
</div>

<div style="clear:both;"></div>
<input type="radio" name="co_uom_distance" value="Km" ' . ($price_option['co_uom_distance'] == 'Km' ? 'checked' : '') . ' >&nbsp;&nbsp; KM<br>
<div style="clear:both;"></div>
<input type="radio" name="co_uom_distance" value="Miles" ' . ($price_option['co_uom_distance'] == 'Miles' ? 'checked' : '') . ' >&nbsp;&nbsp; Miles<br>
<div style="clear:both;"></div>

<input type="radio" name="co_uom_distance" value="N"  ' . ($price_option['co_uom_distance'] == 'N' ? 'checked' : '') . ' >&nbsp;&nbsp; Do not price by distances
<div style="clear:both;"></div>

<br>

</div>
</div>
		
		<legend>' . $lang[670] . '</legend>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[671] . '</label>
<div class="col-sm-9"><input type="text" name="co_waittime_mprice" value="' . $price_option['co_waittime_mprice'] . '"  ></div>
</div>

		
		<legend>' . $lang[344] . '</legend>

<div class="form-group">
<label class="col-sm-3 control-label" >' . $lang[345] . '</label>
<div class="col-sm-9"><input type="text" name="co_round_price" value="' . $price_option['co_round_price'] . '" /></div>
</div>
		
		
		
														
													
											    </div>
											</div>
										</div>
									</div>
														
														
								
								<div class="col-xs-12 col-sm-3 widget-container-col ui-sortable">
										<div class="widget-box ui-sortable-handle">
											<div class="widget-header">
												<h5 class="widget-title smaller">' . $lang[932] . '</h5>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-6">
														
													<legend>' . $lang[920] . '</legend>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[921] . '</label>
<div class="col-sm-9">
		<input type="hidden" name="co_package_details" value="N"   >
		<input type="checkbox" name="co_package_details" value="Y"  ' . ($price_option['co_package_details'] == 'Y' ? 'checked' : '') . '>
		</div>
</div>
					
														
		<legend>' . $lang[334] . '</legend>

<div class="form-group">
<div class="col-sm-9">
<input type="radio" name="allow_zones" value="Y" ' . ($price_option['allow_zones'] == 'Y' ? 'checked' : '') . ' >&nbsp;&nbsp; Yes<br>
<div style="clear:both;"></div>
<input type="radio" name="allow_zones" value="N" ' . ($price_option['allow_zones'] == 'N' ? 'checked' : '') . ' >&nbsp;&nbsp; No<br>
<div style="clear:both;"></div>
</div>
</div>
		
		
				<legend>' . $lang[941] . '</legend>

<div class="form-group">
<div class="col-sm-9">
<input type="radio" name="allow_payment_details" value="Y" ' . ($price_option['allow_payment_details'] == 'Y' ? 'checked' : '') . ' >&nbsp;&nbsp; Yes<br>
<div style="clear:both;"></div>
<input type="radio" name="allow_payment_details" value="N" ' . ($price_option['allow_payment_details'] == 'N' ? 'checked' : '') . ' >&nbsp;&nbsp; No<br>
<div style="clear:both;"></div>
</div>
</div>
		
		
				<legend>' . $lang[933] . '</legend>

<div class="form-group">
<div class="col-sm-9">
<input type="radio" name="show_addtional" value="Y" ' . ($price_option['show_addtional'] == 'Y' ? 'checked' : '') . ' >&nbsp;&nbsp; Yes<br>
<div style="clear:both;"></div>
<input type="radio" name="show_addtional" value="N" ' . ($price_option['show_addtional'] == 'N' ? 'checked' : '') . ' >&nbsp;&nbsp; No<br>
<div style="clear:both;"></div>
</div>
</div>
		
		
		<legend>' . $lang[346] . '</legend>

				<div class="control-group">
			
<div class="radio">
				<label>
<input type="radio" name="custflag" class="ace" value="1" ' . ($price_option['custflag'] == '1' ? 'checked' : '') . '  ><span class="lbl">' . $lang[347] . '</span>
</label>
		</div>
		
<div class="radio"><label>
<input type="radio" name="custflag" class="ace" value="2" ' . ($price_option['custflag'] == '2' ? 'checked' : '') . '  ><span class="lbl">' . $lang[349] . '</span>
</label>
		</div>

		<div class="radio"><label>
<input type="radio" name="custflag" class="ace" value="3" ' . ($price_option['custflag'] == '3' ? 'checked' : '') . '  ><span class="lbl">' . $lang[348] . '</span>
</label>
		</div>
		
<div class="radio"><label>
<input type="radio" name="custflag" class="ace" value="4" ' . ($price_option['custflag'] == '4' ? 'checked' : '') . '  ><span class="lbl">' . $lang[350] . '</span>
</label>
		</div>
		

</div>
		
		
														
													
											    </div>
											</div>
										</div>
									</div>
		
		
		
		<div class="form-group">
<input type="button" onclick="pricesetting_save();" class="btn btn-info"  value="Save" name="update"/>
</div>
		
</div>

';

    echo '</form>';
}


function template_copyprice()
{
    global $lang, $ser;
    echo '
			<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/price.js"></script>
		
					<h4>When coping pricing from first service to second service All second service price will be deleted</h4>
					
			<form name="copy_zone" id="copy_zone" action="pricing.php?action=copyprice" method="post" class="form-horizontal">
		
			<div class="form-group">
<label class="col-sm-3">Delivery Chart</label>
<div class="col-sm-9">
			<select name="chart">
			<option value="1">Delivery Chart 1</option>
			<option value="2">Delivery Chart 2</option>
			</select>
			</div>
</div>
		
<div class="form-group">
<label class="col-sm-3">Copy Price From</label>
<div class="col-sm-9">
					<select name="service_1">
					<option value="">Select Service</option>
';
    for ($i = 0; $i < count($ser); $i++) {
        echo '<option value="' . $ser[$i]['service_id'] . '">' . $ser[$i]['service_name'] . '</option>';
    }
    echo '</select>
		</div>
</div>

			<div class="form-group">
<label class="col-sm-3">Copy price To</label>
<div class="col-sm-9">
							<select name="service_2">
					<option value="">Select Service</option>
';
    for ($i = 0; $i < count($ser); $i++) {
        echo '<option value="' . $ser[$i]['service_id'] . '">' . $ser[$i]['service_name'] . '</option>';
    }
    echo '</select>
		</div>
</div>
		
			<div class="clearfix form-actions">
<div class="col-md-offset-3 col-md-9">
<input type="button" value="Copy" name="copyservice" class="btn btn-info" onclick="copy_serivces();">
		</div>
</div>
		
			<div style="clear:both;"></div>
</form>
			
			
				
		';
}

function template_add_deliveryfees()
{
    global $lang;
    echo '
			<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/price.js"></script>
			
			<form name="search_zone" id="search_zone" action="pricing.php?action=add_deliveryfees" method="post" class="form-horizontal">
			
			<div class="form-group">
<label class="col-sm-3">Delivery Chart</label>
<div class="col-sm-9">
			<select name="chart">
			<option value="1">Delivery Chart 1</option>
			<option value="2">Delivery Chart 2</option>
			</select>
			</div>
</div>
			
<div class="form-group">
<label class="col-sm-3">Zone From</label>
<div class="col-sm-9"><input type="text" name="zonefrom" value="" size="7"/>	</div>
</div>

			<div class="form-group">
<label class="col-sm-3">Zone To</label>
<div class="col-sm-9"><input type="text" name="zoneto" value="" size="7"/>	</div>
</div>
			
			<div class="clearfix form-actions">
<div class="col-md-offset-3 col-md-9">
<input type="button" value="Search" name="searchzone" class="btn btn-info" onclick="search_zones();">		
		</div>
</div>
			
			<div style="clear:both;"></div>
</form>
					
					
					<div id="search_result">
					</div>
		';
}

function template_deliveryfees()
{
    global $lang, $normal;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/price.js"></script>
  <script>
  $(document).ready(function() {
    $("#dtabs_' . $normal . '").tabs(
	
	
	);
	

  });
  
  



  </script>
  

<div id="dtabs_' . $normal . '" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>';
    if ($normal == "1") {
        echo '
   		<li><a href="pricing.php?action=add_deliveryfees" >Add Delivery Fees</a></li>
   		<li><a href="pricing.php?action=deliveryfees_normal&chart=1" >' . $lang[250] . '</a></li>
   <li><a href="pricing.php?action=deliveryfees_normal&chart=2" >' . $lang[251] . '</a></li>
   		<li><a href="pricing.php?action=copyprice" >Copy Price</a></li>
   				';

    } else {
        echo '<li><a href="pricing.php?action=deliveryfees&chart=1" >' . $lang[250] . '</a></li>
   <li><a href="pricing.php?action=deliveryfees&chart=2" >' . $lang[251] . '</a></li>';
    }
    echo '</ul>

<div id="vvtabs-0' . $normal . '" style="padding:0px;" >
</div>

<div id="vvtabs-1' . $normal . '" style="padding:0px;">
</div>





</div>

<div style="clear:both;"></div>

';
}

function template_deliveryfees_chart()
{
    global $ser, $chart, $normal;

    echo '<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/price.js"></script>
  <script>
  $("#servicess_' . $chart . '").ready(function() {
    $("#servicess_' . $chart . '").tabs(
	
	
	);



 
  });
  </script>
  

<div id="servicess_' . $chart . '" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   ';
    for ($j = 0; $j < count($ser); $j++) {
        //	print_r($ser);
        echo '<li><a href="pricing.php?action=delivery_ser&serid=' . $ser[$j]['service_id'] . '&chart=' . $chart . '" >' . $ser[$j]['service_name'] . '</a></li>';
    }
    echo '</ul>';

    for ($t = 0; $t < count($ser); $t++) {
        echo '<div id="sta-' . $t . '" style="padding:0px;" ></div>';
    }

    echo '</div>
<div style="clear:both;"></div>

';
}


function template_deliveryfees_chart_normal()
{
    global $ser, $chart, $normal, $delivery_fee, $lang;

//var_dump($delivery_fee);
    echo '
			<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/price.js"></script>
 
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/account.js"></script>

		
	

<form onsubmit="return false;" name="edit_deliver_services_0_' . $chart . '" id="edit_deliver_services_0_' . $chart . '" method="post" action="' . SITEURL . '/administrator/pricing.php?action=deliveryfees_normal&chart=' . $chart . '" >
<input type="hidden" name="chart" value="' . $chart . '" />
		
<table class="table table-striped table-bordered " style="font-size:8px;" id="delivery_table_' . $account_id . '">
<tr style="backgorund:green;">
<th>+</th>
<th >' . $lang[354] . '</th>
<th>' . $lang[355] . '</th>
';
    for ($v = 0; $v < count($ser); $v++) {
        echo '<th>' . $ser[$v]['service_name'] . '</th>';
    }

    echo '</tr>';
    $num = 3;
//var_dump($delivery_fee);
    if (is_array($delivery_fee) && count($delivery_fee) > 0) $num = (count($delivery_fee));

    if (count($delivery_fee) > $num) $num = count($delivery_fee);
    for ($i = 0; $i < $num; $i++) {
        echo '
<tr id="zone_' . $i . '">
<td>
		<button onclick="delete_zone(\'#zone_' . $i . '\',\'' . $delivery_fee[$i]['zonefrom'] . '\',\'' . $delivery_fee[$i]['zoneto'] . '\',\'' . $_POST['chart'] . '\');" class="btn btn-danger btn-xs">
												<i class="ace-icon fa fa-trash-o  icon-only"></i>
		</button>
		
		</td>
<td><input type="text" name="nc__delivery__zonefrom__' . $i . '" size="8" value="' . (count($delivery_fee) > 0 ? $delivery_fee[$i]['zonefrom'] : '') . '"/></td>
<td><input type="text" name="nc__delivery__zoneto__' . $i . '" size="8" value="' . (count($delivery_fee) > 0 ? $delivery_fee[$i]['zoneto'] : '') . '"/></td>

';
        for ($sv = 0; $sv < count($ser); $sv++) {
            echo '<td><input type="text" name="nc__delivery__' . $ser[$sv]['service_id'] . '__' . $i . '" size="5" value="' . (count($delivery_fee[$i]['srv_fee']) > 0 && isset($delivery_fee[$i]['srv_fee'][$delivery_fee[$i]['zonefrom']][$delivery_fee[$i]['zoneto']][$ser[$sv]['service_id']]) ? $delivery_fee[$i]['srv_fee'][$delivery_fee[$i]['zonefrom']][$delivery_fee[$i]['zoneto']][$ser[$sv]['service_id']] : '') . '"/></td>';
        }
        echo '</tr>';
    }

    echo '
		<!--
<tr>
<td colspan="100%">
<input type="button" id="add_acc" onclick="add_delivery_rows(\'\');"  value="' . $lang[221] . '" class="btn btn-info" style="margin:auto; float:none;"  name="edituser"/>
</td>
</tr>
-->
		
</table>
		
		<div class="form-group">
<input type="button" onclick="delivery_save(\'0\',\'' . $chart . '\');" class="btn btn-info" style="margin:0 auto;" value="Save" name="update"/>
</div>
		
		
		</form>

';
}


function template_zone_deliver()
{
    global $delivery, $zone, $service_id, $chart_id, $sett_compnay;
    $se = $_GET['serid'];
    $chart = $_GET['chart'];
    echo '
	<style>
		
	table{

}
		


		   td.headcol {
	
		
          height:43px;
		background:green;
		width:66px;
   
		
		}
		
		th {
		
		 width:66px;
		 height:43px;
		background:green;
		color:#fff;

     
		
		}
		
.py{
width:100%;
		height:300px;
		  overflow-x:scroll;
          overflow-y:scroll;
		
		position: relative;
		
		
}

		</style>	

		<form  name="edit_deliver_services_' . $se . '_' . $chart . '" id="edit_deliver_services_' . $se . '_' . $chart . '" method="post" action="' . SITEURL . '/administrator/pricing.php?action=edit_delivery_ser&ser=' . $se . '&chart=' . $chart . '" >

				
				
				<div class="py">
<table class="table  table-bordered " style="float:left;" border="1">
				<thead  >
<tr >
<th >Zone</th>
';
    for ($i = 1; $i < count($zone) + 1; $i++) {
        echo '<th class="headrow">' . $zone[$i] . '</th>';
    }
    echo '</tr>
		</thead>
		<tbody >';

    for ($j = 1; $j < count($zone) + 1; $j++) {
        echo '<tr ><td class="headcol">' . $zone[$j] . '</td>';

        for ($z = 1; $z < count($zone) + 1; $z++) {

            if ($j >= $z) {
                if (array_key_exists($zone[$j], $delivery) && array_key_exists($zone[$z], $delivery[$zone[$j]])) {
                    echo '<td><input type="text" name="' . make_input_name($zone[$j]) . '_' . make_input_name($zone[$z]) . '" value="' . $delivery[$zone[$j]][$zone[$z]]['price'] . '" size="5"/>';


                    if ($sett_compnay["company_skid"]["option_value"] == "1") {
                        echo '<input type="text" name="skid_' . make_input_name($zone[$j]) . '_' . make_input_name($zone[$z]) . '" value="' . $delivery[$zone[$j]][$zone[$z]]['skid'] . '" size="5"/>';
                    }

                    echo '</td>';

                } else {
                    echo '<td><input type="text" value="" name="' . make_input_name($zone[$j]) . '_' . make_input_name($zone[$z]) . '" size="5" /> ';

                    if ($sett_compnay["company_skid"]["option_value"] == "1") {
                        echo '<input type="text" name="skid_' . make_input_name($zone[$j]) . '_' . make_input_name($zone[$z]) . '" value="" size="5"/>';
                    }

                    echo '</td>';

                }

            } else {
                echo '<td><input type="text" value="" disabled="disabled" size="5" /> </td>';

            }

        }
        echo '</tr>';
    }


    echo '</tbody></table>
</div>
<div class="form-group">
<input type="button" onclick="delivery_save(\'' . $se . '\',\'' . $chart . '\');" class="btn btn-info" style="margin:0 auto;" value="Save" name="update"/>
</div>


</form>
<div id="result"></div>
<div style="clear:both;"></div>';
}

function template_time_price()
{
    global $zone, $lang, $rate;

    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/price.js"></script>
<form  name="edit_zone_time" id="edit_zone_time" method="post" action="' . SITEURL . '/administrator/pricing.php?action=timeofday" >
<input type="hidden" name="is_submit" value="1"/>
<table class="table table-striped table-bordered table-hover" border="1" >
<tr>';
    for ($i = 0; $i < 1; $i++) {
        echo '<tr>';
        foreach ($zone[$i] as $key => $value) {
            if ($key == "id" || $key == "client_acctno") {
            } else {
                echo '<th>' . $rate[$key] . '</th>';
            }
        }
        echo '</tr>';
    }


    for ($i = 0; $i < count($zone); $i++) {
        echo '<tr>';
        $j = 0;
        foreach ($zone[$i] as $key => $value) {

            if ($key == "id" || $key == "client_acctno") {

            } else {

                if ($j > 0) {
                    echo '<td><input type="text" value="' . $zone[$i][$key] . '" name="' . strtoupper($zone[$i]['zone']) . '[]" size="5" /></td>';
                } else echo '<td>' . strtoupper($zone[$i][$key]) . '</td>';
                $j++;

            }
        }

        echo '</tr>';
    }
    echo '</table>

<div class="form-group">
<input type="button" onclick="save_zone_time();" class="btn btn-info"  value="Save" name="update"/>
</div>

</form>
<div style="clear:both;"></div>

';

}

?>