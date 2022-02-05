<?php


function template_track_drivers()
{
    global $lang, $c_setting, $driversList, $driversDetails;
    echo '
	<script  src="https://maps.googleapis.com/maps/api/js?key=' . $c_setting['googlemap_api'] . '"  type="text/javascript"></script>

	<script src="' . SITEURL . '/' . STYLE . '/jscript/socket.js" type="text/javascript"></script>
			
			<script type="text/javascript">
			
			$(document).ready(function (){
			
			$("#map").height($( window ).height()-100);
			var driversList = ' . $driversList . ';
				var driversDetails = ' . $driversDetails . ';	
					//alert(driversList.length);
					

		 		init(\'' . system_id . '\',\'' . $_SESSION['user_id'] . '\',driversList);
		 		
		 		var intial_address = \'' . $c_setting['co_address'] . '\' + \',' . $c_setting['co_city'] . '\' + \',' . $c_setting['co_provstate'] . '\'
		    	initMap(intial_address);
		 				
		 				
		 		for(var i=0;i<driversList.length;i++){
		 				
		 				if(driversList[i].pushkey != \'\') {
		 			//	alert(driversList[i].id);
		 			//	track_driver(\'+ driversList[i].id +\',\'where\',\'\');
		 				track_driver( driversList[i].id ,1,driversList[i].name);
		 		}
		 						
                }
            });		
			</script>
			
		 					
		 				
		 				
		 				
		 								
		 				<div id="map" style="height: 600px;width: 88%; float:left;">

</div>
		 				
		 				

		 				
		 				<div id="driverdetails" style="width:12%; float:left;">
		 				
		 				</div>
		 				
		 				
		 				
<!--
		 				<div id="status" style="width:100%; height:400px;">
		 				
		 				</div>		

		 				-->
		 								
			';

}

function template_driver_main()
{
    global $data, $data1, $data2, $lang;
    echo '

<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
  <script>
  $(document).ready(function() {
    $("#tabs").tabs(
	
	);
	
});
</script>

<div id="tabs" >
<ul >
   <li><a href="driver.php?action=Y" class="active">' . $lang[183] . '</a></li>
   <li><a href="driver.php?action=N">' . $lang[184] . '</a></li>
   <li><a href="driver.php?action=D">' . $lang[185] . '</a></li>
   <li><a href="driver.php?action=add">' . $lang[186] . '</a></li>
</ul>

<div id="tab1" class="tabset_content">
</div>

<div id="tab2" class="tabset_content">
</div>

<div id="tab3" class="tabset_content">
</div>

<div id="tab4" class="tabset_content">
</div>

</div>

<div id="result_dialoge"></div>

';
}

function template_active_driver()
{
    global $data, $data1, $data2, $lang;
    echo '<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>

<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
  <script>
  $(document).ready(function() {
    $("#tabs1").tabs();	

});
</script>

<div id="tabs1" >
<ul>
<li><a href="driver.php?action=dri&type=Y&tab=tabs1" class="active">' . $lang[183] . '</a></li>
</ul>

<div id="tab11" class="tabset_content">
</div>

</div>
';
}

function template_drivers()
{
    global $data, $tab, $lang, $html_grid;
    echo '<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>';
    echo $html_grid;
// if (is_array($data) && count($data) > 0){

// echo '<table border="1" class="table table-striped table-bordered table-hover"  >';
// $x = $data[0];
// foreach ($x as  $val) {	
// 	echo '<th>'.key($val).'</th>';
// }
// if($tab == "tabs1") echo '<th>Is Admin</th>';
// echo '<th style="width:30px;">Edit</th>';

// for ($i=0 ; $i<count($data); $i++){
// echo '<tr>';
// $x = $data[$i];

// foreach ($x as  $val) {

//       $tex = $val[key($val)];

//    $tex = str_replace(",","<br>",$tex);

// 	echo '<td>'.$tex.'</td>';
// }
// var_dump($data[$i]);
// if($tab == "tabs1") echo '<td><input type="radio" name="allow_assign" value="'.$data[$i][0]['Driver'].'" /></td>';
// echo '<td><a onclick="show_edit_driver(\''.$data[$i][0]['Driver No'].'\' , \''.$data[$i][4]['Name'].'\',\''.$tab.'\' );" href="#" >Edit</a></td>';


// echo '</tr>';
// }
// echo '</table>';
// }else{
// echo '<div style="text-align:center;">'.$lang[472].'</div>';
// }

}

function driver_admin($row)
{
    global $tab;
    for ($i = 0; $i < count($row); $i++) {
        foreach ($row[$i] as $key => $value) {
            $rou[$key] = $value;
        }
    }
//	var_dump($rou);

    $x = '<input type="radio" name="allow_assign" onclick="update_driver_admin(this);" ' . ($tab == 'tabs1' ? '' : 'disabled') . ' value="' . $rou['id'] . '" ' . ($rou['allow_assign'] == 'Y' ? 'checked' : '') . ' />';
    return $x;
}

function show_driver_option($row)
{
    global $tab;
    for ($i = 0; $i < count($row); $i++) {
        foreach ($row[$i] as $key => $value) {
            $rou[$key] = $value;
        }
    }

    $x = '<a onclick="show_edit_driver(\'' . $rou['driverno'] . '\' , \'' . $rou['name'] . '\',\'' . $tab . '\' );" href="#" >Edit</a>';
    return $x;
}

function template_deleted_driver()
{
    global $lang;

    echo '
  <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
  <script>
  $(document).ready(function() {
    $("#tabs2").tabs();
});
</script>

<div id="tabs2" >
<ul >
   <li><a href="driver.php?action=dri&type=D&tab=tabs2" class="active">' . $lang[185] . '</a></li>

</ul>
<div id="tab21" class="tabset_content">
</div>
</div>';
}

function template_notactive_driver()
{
    global $data, $data1, $data2, $lang;


    echo '<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>

 <script>
  $(document).ready(function() {
    $("#tabs3").tabs();
});
</script>

<div id="tabs3" >
<ul >
   <li><a href="driver.php?action=dri&type=N&tab=tabs3" class="active">' . $lang[184] . '</a></li>

</ul>
<div id="tab31" class="tabset_content">
</div>
</div>';


}

function template_edit_driver()
{
    global $lang, $driver, $ser, $location, $category, $vec, $drive_category, $driver_service, $sett_compnay, $billing_code, $driver_billing;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/main.js"></script>

<form class="form-horizontal" name="edit_driver" id="edit_driver" method="post" action="' . SITEURL . '/administrator/driver.php?action=editdriver" style="width:100%;" >

<div class="col-xs-4" >
<input type="hidden" name="driver_id" id="driver_id" value="' . $driver->id . '" />
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[172] . '</label>
<div class="col-sm-9"><input type="text" name="driverno" value="' . $driver->driverno . '" ' . ($driver->id != '' ? ' disabled="disabled"' : ' validate="notempty" ') . '  />
</div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[36] . '</label>
<div class="col-sm-9">
<input type="text" name="name" value="' . $driver->name . '" size="50"  validate="notempty" />
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[19] . '</label>
<div class="col-sm-9">
<input type="password" name="pass" value="' . $driver->pass . '" size="50"  />
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="phone" value="' . $driver->phone . '" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[12] . '</label>
<div class="col-sm-9"><input type="text" name="fax" value="' . $driver->fax . '" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[434] . '</label>
<div class="col-sm-9"><input type="text" name="cell" value="' . $driver->cell . '" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[435] . '</label>
<div class="col-sm-9"><input type="text" name="pager" value="' . $driver->pager . '" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[436] . '</label>
<div class="col-sm-9"><input type="text" name="radio" value="' . $driver->radio . '" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . '</label>
<div class="col-sm-9"><input type="text" name="email" value="' . $driver->email . '" size="50"  validate="notempty" validate_type="email" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><textarea name="addr" cols="40" rows="5" >' . $driver->addr . '</textarea></div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[127] . '</label>
<div class="col-sm-9">
<input type="text" name="notify_email" value="' . $driver->notify_email . '"  validate="notempty" validate_type="email" size="50"/>
</div>
</div>

<div class="form-group">
		
<label class="col-sm-3 control-label">' . $lang[417] . '</label>

<div class="col-sm-9">
' . $lang[418] . '
<br>
' . $lang[419] . '
<input type="hidden" name="email_notifyevent1" value= "N" />
<input type="checkbox" name="email_notifyevent1" value= "Y" ' . ($driver->email_notifyevent1 == 'Y' ? 'checked' : '') . ' />
<br><br>
' . $lang[420] . '
<input type="hidden" name="email_notifyevent2" value= "N" />
<input type="checkbox" name="email_notifyevent2" value= "Y" ' . ($driver->email_notifyevent2 == 'Y' ? 'checked' : '') . ' />
<br><br>
' . $lang[421] . '
<input type="hidden" name="email_notifyevent3" value= "N" />
<input type="checkbox" name="email_notifyevent3" value= "Y" ' . ($driver->email_notifyevent3 == 'Y' ? 'checked' : '') . '/>
<br><br>
<div style="clear:both;"></div>
</div>
		
</div>

<hr>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[422] . '</label>

<div class="col-sm-9" style="width:70%;">' . $lang[423] . '<br>
<div class="col" style="float:left; width:45%;">';

    for ($l = 0; $l < count($location); $l++) {
        echo '<input type="checkbox" name="category[]" value="' . $location[$l]['cat_id'] . '"  
' . ($driver->id != "" && array_key_exists($location[$l]['cat_id'], $drive_category) ? 'checked' : '') . ' />' . $location[$l]['cat_name'] . '<br><br>';
    }
    echo '
<div style="clear:both;"></div>

</div>

<div class="col" style="float:left; width:45%;">';
    for ($c = 0; $c < count($category); $c++) {
        echo '<input type="checkbox" name="category[]" value="' . $category[$c]['cat_id'] . '" 
' . ($driver->id != "" && array_key_exists($category[$c]['cat_id'], $drive_category) ? 'checked' : '') . ' />' . $category[$c]['cat_name'] . '<br><br>';

    }
    echo '
<div style="clear:both;"></div>

</div>
<div style="clear:both;"></div>
</div>

</div>



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[424] . '</label>
<div class="col-sm-9" style="width:80%;">' . $lang[425] . '<br>
<input type="hidden" name="auto_assign"  value="N"/>
<input type="checkbox" name="auto_assign"  value="Y" ' . ($driver->auto_assign == 'Y' ? 'checked' : '') . ' />' . $lang[426] . '
</div>
</div>


</div>


<div class="col-xs-4" >

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[173] . '</label>
<div class="col-sm-9">
<select name="active" style="float:left;"  validate="notempty" >
<option value="">' . $lang[756] . '</option>
<option value="Y" ' . ($driver->active == 'Y' ? 'selected' : '') . '>' . $lang[183] . '</option>
<option value="N" ' . ($driver->active == 'N' ? 'selected' : '') . ' >' . $lang[184] . '</option>
<option value="D" ' . ($driver->active == 'D' ? 'selected' : '') . '>' . $lang[185] . '</option>
</select>
</div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[616] . '</label>
<div class="col-sm-9"><input type="text" name="start_date" class="datepick" value="' . $driver->start_date . '" size="15"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[617] . '</label>
<div class="col-sm-9"><input type="text" name="termination_date" class="datepick" value="' . $driver->termination_date . '" size="15"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[618] . '</label>
<div class="col-sm-9"><input type="text" name="deposit" value="' . $driver->deposit . '" size="10"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[619] . '</label>
<div class="col-sm-9"><input type="text" name="other_allowance" value="' . $driver->other_allowance . '" size="10"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[620] . '</label>
<div class="col-sm-9"><input type="text" name="other_allowance_desc" value="' . $driver->other_allowance_desc . '" size="30"/></div>
</div>



<hr>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[427] . '</label>

<div class="col-sm-9">
<select name="vehicle_type" style="float:left;">
<option value="">' . $lang[428] . '</option>
';
    for ($v = 0; $v < count($vec); $v++) {
        echo '<option value="' . $vec[$v]['transport_id'] . '" ' . ($driver->vehicle_type == $vec[$v]['transport_id'] ? 'selected' : '') . ' >' . $vec[$v]['trnasport_type'] . '</option>';
    }
    echo '
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[614] . '</label>
<div class="col-sm-9"><input type="text" name="mileage_allowance" value="' . $driver->mileage_allowance . '" size="10"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[615] . '</label>
<div class="col-sm-9"><input type="text" name="vehicle_allowance" value="' . $driver->vehicle_allowance . '" size="10"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[333] . '</label>
<div class="col-sm-9"><input type="text" name="allowance_per" value="' . $driver->allowance_per . '" size="10"/></div>
</div>


<hr>
' . $lang[794] . '

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[621] . '</label>
<div class="col-sm-9"><input type="text" name="deductions" value="' . $driver->deductions . '" size="10"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[333] . '</label>
<div class="col-sm-9"><input type="text" name="deductions_per" value="' . $driver->deductions_per . '" size="10"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[620] . '</label>
<div class="col-sm-9"><input type="text" name="deductions_desc" value="' . $driver->deductions_desc . '" size="30"/></div>
</div>
<hr>

		</div>
		<div class="col-xs-4" >

<table border="1" class="table table-striped table-bordered table-hover" >
<tr>
<th>' . $lang[44] . '</th>
<th>' . $lang[411] . '</th>
<th>' . $lang[412] . '</th>
<th>' . $lang[413] . '</th>
</tr>
';
    for ($i = 0; $i < count($ser); $i++) {

        echo '<tr>
<td>' . $ser[$i]['service_name'] . '</td>
<td><input type="text" name="complete[' . $ser[$i]['service_id'] . ']"  value="' . $driver_service[$ser[$i]['service_id']]['complete'] . '" size="5"/></td>
<td><input type="text" name="pickup_only[' . $ser[$i]['service_id'] . ']"  value="' . $driver_service[$ser[$i]['service_id']]['pickup_only'] . '" size="5"/></td>
<td><input type="text" name="delivery_only[' . $ser[$i]['service_id'] . ']"  value="' . $driver_service[$ser[$i]['service_id']]['delivery_only'] . '" size="5"/></td>
</tr>';

    }

    echo '

<tr>
<td>' . $lang[414] . '</td>
<td><input type="text" name="commission_pct_waittime" value="' . $driver->commission_pct_waittime . '" size="5"/></td>
<td><input type="text" name="pickup_commission_pct_waittime" value="' . $driver->pickup_commission_pct_waittime . '" size="5"/></td>
<td><input type="text" name="deliver_commission_pct_waittime" value="' . $driver->deliver_commission_pct_waittime . '" size="5"/></td>
</tr>

<tr>
<td>' . $lang[415] . '</td>
<td><input type="text" name="commission_pct_extra" value="' . $driver->commission_pct_extra . '" size="5"/></td>
<td><input type="text" name="pickup_commission_pct_extra" value="' . $driver->pickup_commission_pct_extra . '" size="5"/></td>
<td><input type="text" name="deliver_commission_pct_extra" value="' . $driver->deliver_commission_pct_extra . '" size="5"/></td>
</tr>

<tr>
<td>' . $lang[416] . '</td>
<td><input type="text" name="commission_pct_fs" value="' . $driver->commission_pct_fs . '" size="5"/></td>
<td><input type="text" name="pickup_commission_pct_fs" value="' . $driver->pickup_commission_pct_fs . '" size="5"/></td>
<td><input type="text" name="deliver_commission_pct_fs" value="' . $driver->deliver_commission_pct_fs . '" size="5"/></td>
</tr>

</table>

<hr>';


    if (is_array($billing_code) && count($billing_code) > 0) {

        echo $lang[795] . '

<table border="1" class="table table-striped table-bordered table-hover" >
<tr>
<th></th>
<th>' . $lang[622] . '</th>
<th>' . $lang[623] . '</th>
<th>' . $lang[624] . '</th>
<th>' . $lang[625] . '</th>
</tr>';

        for ($b = 0; $b < count($billing_code); $b++) {
            echo '
<tr>
<td>' . $billing_code[$b]['billingcode_name'] . '</td>
<td><input type="text" name="bill_rate[' . $billing_code[$b]['id'] . ']"  value="' . $driver_billing[$billing_code[$b]['id']]['rate'] . '" size="5" /></td>
<td><input type="radio" name="bill_type[' . $billing_code[$b]['id'] . ']" value="1" ' . ($driver_billing[$billing_code[$b]['id']]['type'] == "1" ? 'checked' : '') . ' ></td>
<td><input type="radio" name="bill_type[' . $billing_code[$b]['id'] . ']" value="2" ' . ($driver_billing[$billing_code[$b]['id']]['type'] == "2" ? 'checked' : '') . ' ></td>
<td><input type="radio" name="bill_type[' . $billing_code[$b]['id'] . ']" value="3" ' . ($driver_billing[$billing_code[$b]['id']]['type'] == "3" ? 'checked' : '') . ' ></td>
</tr>
';

        }

        echo '</table>';
    }


    echo '
</div>


<div style="clear:both;"></div>
<hr>
<div class="form-group">
<div class="col-sm-9" style="width: 200px; float: none;margin: auto; height:40px;">
';
    if (isset($driver->id) && $driver->id != '') {
        echo '
<input type="button" onclick="add_edit_driver();" class="btn btn-info"  style="margin:auto; float:none;" value="' . $lang[182] . '"  name="editdriver"/>

<input type="button"  onclick="close_my_tab(\'tabs1\',\'0\');" class="btn btn-info" style="margin:auto; float:none;" value="' . $lang[200] . '"  name="close"/>';
    } else {
        echo '<input type="button" onclick="add_edit_driver();" class="btn btn-info" style="margin:auto; float:none;" value="' . $lang[186] . '"  name="editdriver"/>';
    }
    echo '
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
</div>

</form>

<div style="clear:both;"></div>';
}

function template_add_driver()
{
    global $lang, $driver, $vec, $location, $category, $ser;
    echo '<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>


<form class="form-horizontal" name="add_driver" id="add_driver" method="post" action="' . SITEURL . '/administrator/driver.php?action=add" style=" width:100%;">

<div class="col" style="width:40%;">
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[172] . '</label>
<div class="col-sm-9"><input type="text" name="driverno" value="" /></div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[36] . '</label>
<div class="col-sm-9"><input type="text" name="name" value="" size="50"/></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="phone" value="" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[12] . '</label>
<div class="col-sm-9"><input type="text" name="fax" value="" size="50"/></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[434] . '</label>
<div class="col-sm-9"><input type="text" name="cell" value="" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[435] . '</label>
<div class="col-sm-9"><input type="text" name="pager" value="" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[436] . '</label>
<div class="col-sm-9"><input type="text" name="radio" value="" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . '</label>
<div class="col-sm-9"><input type="text" name="email" value="" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[127] . '</div>
<div class="col-sm-9"><input type="text" name="notifyemail" value="" size="50"/></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[422] . '</label>

<div class="col-sm-9" style="width:70%;">' . $lang[423] . '
<div style="clear:both;"></div>

<div class="col" style="float:left; width:43%;">';
    for ($l = 0; $l < count($location); $l++) {
        echo '<input type="checkbox"  name="category[]" value="' . $location[$l]['cat_id'] . '"  />' . $location[$l]['cat_name'] . '<br><br>';
    }
    echo '
<div style="clear:both;"></div>

</div>

<div class="col" style="float:left; width:43%;">';
    for ($c = 0; $c < count($category); $c++) {
        echo '<input type="checkbox" name="category[]" value="' . $category[$c]['cat_id'] . '" />' . $category[$c]['cat_name'] . '<br><br>';

    }
    echo '
<div style="clear:both;"></div>

</div>
<div style="clear:both;"></div>
</div>

</div>



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[424] . '</label>
<div class="col-sm-9" style="width:80%;">' . $lang[425] . '<br>
<input type="hidden" name="auto_assign"  value="0"/>
<input type="checkbox" name="auto_assign"  value="1"  />' . $lang[426] . '

</div>
</div>




</div>

<div class="col" style="width:40%;">
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><textarea name="address" cols="40" rows="5" ></textarea></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[173] . '</label>
<div class="col-sm-9">
<select name="user_type" style="float:left;">
<option value="">' . $lang[756] . '</option>
<option value="Y" >' . $lang[183] . '</option>
<option value="N"  >' . $lang[184] . '</option>
<option value="D" >' . $lang[185] . '</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[427] . '</label>

<div class="col-sm-9">
<select name="vechile_type" style="float:left;">
<option value="">' . $lang[428] . '</option>
';
    for ($v = 0; $v < count($vec); $v++) {
        echo '<option name="' . $vec[$v]['transport_id'] . '" >' . $vec[$v]['trnasport_type'] . '</option>';
    }
    echo '
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[417] . '</label>

<div class="col-sm-9">
' . $lang[418] . '
<br>
' . $lang[419] . '
<input type="hidden" name="email_notifyevent1" value= "0" />
<input type="checkbox" name="email_notifyevent1" value= "1"  />
<br><br>
' . $lang[420] . '
<input type="hidden" name="email_notifyevent2" value= "0" />
<input type="checkbox" name="email_notifyevent2" value= "1"  />
<br><br>
' . $lang[421] . '
<input type="hidden" name="email_notifyevent3" value= "0" />
<input type="checkbox" name="email_notifyevent3" value= "1" />
<br><br>
<div style="clear:both;"></div>
</div>

</div>








<div class="form-group">
<div class="col-sm-9"><input type="button" onclick ="add_driver_s();" class="btn btn-info" style="float:right;" value="' . $lang[186] . '"  name="editdriver"/></div>
</div>
</div>


<div style="clear:both;"></div>

<div class="col" style="width:40%;">
<table border="1" class="table table-striped table-bordered table-hover" >
<tr>
<th>' . $lang[44] . '</th>
<th>' . $lang[411] . '</th>
<th>' . $lang[412] . '</th>
<th>' . $lang[413] . '</th>
</tr>
';
    for ($i = 0; $i < count($ser); $i++) {

        echo '<tr>
<td>' . $ser[$i]['service_name'] . '</td>
<td><input type="text" name="complete[' . $ser[$i]['service_id'] . ']"  value="" /></td>
<td><input type="text" name="pickup_only[' . $ser[$i]['service_id'] . ']"  value="" /></td>
<td><input type="text" name="delivery_only[' . $ser[$i]['service_id'] . ']"  value="" /></td>
</tr>';

    }

    echo '

<tr>
<td>' . $lang[414] . '</td>
<td><input type="text" name="commission_pct_waittime" value="" /></td>
<td><input type="text" name="pickup_commission_pct_waittime" value="" /></td>
<td><input type="text" name="deliver_commission_pct_waittime" value="" /></td>
</tr>

<tr>
<td>' . $lang[415] . '</td>
<td><input type="text" name="commission_pct_extra" value="" /></td>
<td><input type="text" name="pickup_commission_pct_extra" value="" /></td>
<td><input type="text" name="deliver_commission_pct_extra" value="" /></td>
</tr>

<tr>
<td>' . $lang[416] . '</td>
<td><input type="text" name="commission_pct_fs" value="" /></td>
<td><input type="text" name="pickup_commission_pct_fs" value="" /></td>
<td><input type="text" name="deliver_commission_pct_fs" value="" /></td>
</tr>


</table>

</div>



</form>
<div id ="result"></div>
<div style="clear:both;"></div>';
}


/////////Driver payment report 


function template_driver_report()
{

    global $lang, $driverList;

    echo '
					
			<script  type="text/javascript">
			$(document).ready(function(){
       $("#tabs").tabs();
  var $tabs = $("#tabs").tabs({
		load: function (e, ui) {
     $(ui.panel).find(".tab-loading").remove();
   
         },add: function(event, ui) {
    
	    $tabs.tabs("select", "#" + ui.panel.id);
    
	   },select: function(event, ui) {
        var tabID = "#" + (ui.panel.id);
        $(tabID).html("<b>' . $lang[712] . '....</b>");
      }


});





	  

});
</script>


<div id="right_side">
<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   <li><a href="#tab0" >Driver Report</a></li>
   <li><a href="#tab1" >Driver All</a></li>
   <li><a href="driver.php?action=paydriver" >Pay Driver</a></li>
   		   		
</ul>

        		
<div id="tab0" style="padding:20px;" >

<form id="driver_payment" method="post" action="' . SITEURL . '/administrator/driver.php?action=driver_payment" onsubmit="return false;" autocomplete="off"  class="form-horizontal" >
		<input type="hidden" name="get_report" value="1" />
		';

    if (is_array($driverList) && count($driverList) > 0) {
        echo '
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[284] . '</label>
<div class="col-sm-9">
<select  class="form-control" name="driver_id" style="width:300px;">
<option value="">' . $lang[380] . '</option>
';

        for ($i = 0; $i < count($driverList); $i++) {
            echo '<option value="' . $driverList[$i]['id'] . '">' . $driverList[$i]['driverno'] . '|' . $driverList[$i]['name'] . '</option>';
        }

        echo '
</select>
</div>
	
</div>
';
    }


    echo '
		
		<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[56] . '</label>
<div class="col-sm-9" style="width:200px;">
<input class="form-control"  type="text" name="pickup_date" id="pickup_date" readonly="true"  validate="notempty"  value=""   /> 
<span id="pickup_day"></span>
<script type="text/javascript">
		$(document).ready(function (){

		$("#pickup_date" ).datepicker({
		dateFormat: \'yy-mm-dd\',
        changeMonth: true,  
		changeYear:true, 
		defaultDate: new Date(),
      onSelect: function( selectedDate ) {
        $( "#delivery_date" ).datepicker( "option", "minDate", selectedDate );
		 var eventDate = $("#pickup_date").val();
    var dateElement = eventDate.split("-");
    var dateFormat = dateElement[2]+\'-\'+dateElement[0]+\'-\'+dateElement[1];
		var date = new Date(eventDate+\'T10:00:00Z\'); //To avoid timezone issues
    var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var day = weekday[date.getDay()];		
      }
    });
    $( "#delivery_date" ).datepicker({   
		dateFormat: \'yy-mm-dd\',   
      changeMonth: true,   
		changeYear:true, 
	defaultDate: new Date(),
      onSelect: function( selectedDate ) {
        $( "#pickup_date" ).datepicker( "option", "maxDate", selectedDate );
		
		 var eventDate = $("#delivery_date").val();
    var dateElement = eventDate.split("-");
    var dateFormat = dateElement[2]+\'-\'+dateElement[0]+\'-\'+dateElement[1];
		var date = new Date(eventDate+\'T10:00:00Z\'); //To avoid timezone issues
    var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var day = weekday[date.getDay()];	
      }
			});
		
		$("#pickup_date").datepicker(\'setDate\', new Date());
		$("#delivery_date").datepicker(\'setDate\', new Date());
		});
		
		
		
</script>

</div>
</div>
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[57] . '</label>
<div class="col-sm-9" style="width:200px;">
<input class="form-control"  type="text" name="delivery_date"  readonly="true"  id="delivery_date"  ' . ($_SESSION['status'] == '2' ? '' : 'validate="notempty"') . '   value="" />
</div>
</div>


		<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right">Searching date</label>
			    <div class="col-sm-9">
						
						<div class="radio" style="width:50%; float:left;">
													<label>
														<input name="searchdate" type="radio" value="1" class="ace" >
														<span class="lbl"> Ordered</span>
													</label>
												</div>
																
						<div class="radio" style="width:50%; float:left;">
													<label>
														<input name="searchdate" type="radio" value="2" class="ace" checked>
														<span class="lbl"> Delivered</span>
													</label>
												</div>
																
						<div class="radio" style="width:50%; float:left;">
													<label>
														<input name="searchdate" type="radio" value="2" class="ace">
														<span class="lbl"> Pickup</span>
													</label>
												</div>
																
						<div class="radio" style="width:50%; float:left;">
													<label>
														<input name="searchdate" type="radio" value="4" class="ace" >
														<span class="lbl"> Deliver</span>
													</label>
												</div>
						
				</div>
				</div>
					
		
		<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
		
		<button class="btn btn-primary" onclick="driver_search_payment(\'0\');">
												<i class="ace-icon fa fa-search align-top bigger-125"></i>
												' . $lang[26] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</button>
		</div>
		</div>
		
		<div style="clear:both;"></div>
		</form>
        <div style="clear:both;"></div>				
        				
														
														

														
														<div id="searchresult" >
														
														
														</div>
														
</div>



														
														
														
														
														
<div id="tab1" style="padding:20px;" >

<form id="all_driver_payment" method="post" action="' . SITEURL . '/administrator/driver.php?action=driver_payment_all" onsubmit="return false;" autocomplete="off"  class="form-horizontal" >
		<input type="hidden" name="get_report" value="1" />
		';


    echo '
		
		<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[56] . '</label>
<div class="col-sm-9" style="width:200px;">
<input class="form-control"  type="text" name="pickup_date1" id="pickup_date1" readonly="true"  validate="notempty"  value=""   /> 
<span id="pickup_day"></span>
<script type="text/javascript">
		$(document).ready(function (){

		$("#pickup_date1" ).datepicker({
		dateFormat: \'yy-mm-dd\',
        changeMonth: true,  
		changeYear:true, 
		defaultDate: new Date(),
      onSelect: function( selectedDate ) {
        $( "#delivery_date" ).datepicker( "option", "minDate", selectedDate );
		 var eventDate = $("#pickup_date").val();
    var dateElement = eventDate.split("-");
    var dateFormat = dateElement[2]+\'-\'+dateElement[0]+\'-\'+dateElement[1];
		var date = new Date(eventDate+\'T10:00:00Z\'); //To avoid timezone issues
    var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var day = weekday[date.getDay()];		
      }
    });
    $( "#delivery_date1" ).datepicker({   
		dateFormat: \'yy-mm-dd\',   
      changeMonth: true,   
		changeYear:true, 
	defaultDate: new Date(),
      onSelect: function( selectedDate ) {
        $( "#pickup_dat1e" ).datepicker( "option", "maxDate", selectedDate );
		
		 var eventDate = $("#delivery_date1").val();
    var dateElement = eventDate.split("-");
    var dateFormat = dateElement[2]+\'-\'+dateElement[0]+\'-\'+dateElement[1];
		var date = new Date(eventDate+\'T10:00:00Z\'); //To avoid timezone issues
    var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var day = weekday[date.getDay()];	
      }
			});
		
		$("#pickup_date1").datepicker(\'setDate\', new Date());
		$("#delivery_date1").datepicker(\'setDate\', new Date());
		});
		
		
		
</script>

</div>
</div>
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[57] . '</label>
<div class="col-sm-9" style="width:200px;">
<input class="form-control"  type="text" name="delivery_date1"  readonly="true"  id="delivery_date1"  ' . ($_SESSION['status'] == '2' ? '' : 'validate="notempty"') . '   value="" />
</div>
</div>


		<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right">Searching date</label>
			    <div class="col-sm-9">
						
						<div class="radio" style="width:50%; float:left;">
													<label>
														<input name="searchdate" type="radio" value="1" class="ace" >
														<span class="lbl"> Ordered</span>
													</label>
												</div>
																
						<div class="radio" style="width:50%; float:left;">
													<label>
														<input name="searchdate" type="radio" value="2" class="ace" checked>
														<span class="lbl"> Delivered</span>
													</label>
												</div>
																
						<div class="radio" style="width:50%; float:left;">
													<label>
														<input name="searchdate" type="radio" value="2" class="ace">
														<span class="lbl"> Pickup</span>
													</label>
												</div>
																
						<div class="radio" style="width:50%; float:left;">
													<label>
														<input name="searchdate" type="radio" value="4" class="ace" >
														<span class="lbl"> Deliver</span>
													</label>
												</div>
						
				</div>
				</div>
					
		
		<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
		
		<button class="btn btn-primary" onclick="alldriver_search_payment(\'0\');">
												<i class="ace-icon fa fa-search align-top bigger-125"></i>
												' . $lang[26] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</button>
		</div>
		</div>
		
		<div style="clear:both;"></div>
		</form>
        <div style="clear:both;"></div>				
        				
														
														

														
														<div id="searchresultall" >
														
														
														</div>
														
</div>

</div>
</div>
														
			
			
			
			
			';

}


?>