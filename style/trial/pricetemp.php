<?php

function template_price_manage(){
global $lang,$c_setting;
echo '
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/admin.js"></script>
  <script>
  $(document).ready(function() {
    $("#tabs").tabs();
	
	  var $tabs = $("#tabs").tabs({
        add: function(event, ui) {
        $tabs.tabs("select", "#" + ui.panel.id);
    }
});



  
  ';
  
// if($c_setting['company_skid'] == "1"){
// echo '

// $("#tabs").tabs({ disabled: [1,2,3,5] });
	
// ';
// }else{
// echo '$("#tabs").tabs({ disabled: [4] });

// ';
// }


  echo '
    });
  </script>
  
<div id="right_side">
<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>';
  if($c_setting['company_skid'] == "1"){
  	echo '<li><a href="pricing.php?action=vechiles" >'.$lang[209].'</a></li>
  			 <li><a href="pricing.php?action=distance_increment" >'.($c_setting['company_skid'] == 1 ? $lang[938] : $lang[577]).'</a></li>
 <li><a href="pricing.php?action=options_manage" >'.$lang[213].'</a></li>
  			 		';
  }else{
  echo ' <li><a href="pricing.php?action=vechiles" >'.$lang[209].'</a></li>
   <li><a href="pricing.php?action=zones" >'.$lang[208].'</a></li>
   <li><a href="pricing.php?action=pickupfees" >'.$lang[210].'</a></li>
   <li><a href="pricing.php?action=deliveryfees_normal" >'.$lang[211].'</a></li>
   <li><a href="pricing.php?action=distance_increment" >'.($c_setting['company_skid'] == 1 ? $lang[938] : $lang[577]).'</a></li>
   <li><a href="pricing.php?action=timeofday" >'.$lang[212].'<div class="help" onclick="open_page(\'40\');" onmouseover="show_title(\'40\',this);"></div></a></li>
   <li><a href="pricing.php?action=options_manage" >'.$lang[213].'</a></li>
';
  }
echo '</ul>

<div id="tabs-0" style="padding:0px;" >
</div>

<div id="tabs-1" >
</div>

<div id="tabs-2" >
</div>

<div id="tabs-3" >
</div>

<div id="tabs-4" >
</div>

<div id="tabs-5" >
</div>

<div id="tabs-6" >
</div>

</div>
</div>

';
}


function template_distance_increment_fees(){
global $lang,$ser,$vec,$dfees,$c_setting;



echo '
<form id="vec_distance_inc" method="post" action="'.formurl.'/pricing.php?action=distance_increment" style="width:100%;" >
<input type="hidden" name="edit_distance_inc" value="1" />
<table border="1" class="table table-striped table-bordered table-hover">
<tr>
<th>+</th>
';
//var_dump($dfees);
for ($s=0;$s<count($ser);$s++){
echo '<th>'.$ser[$s]['service_name'].'</th>';
}
echo '</tr>';

for ($v=0;$v<count($vec);$v++){
echo '<tr><td>'.$vec[$v]['vehicle'].'</td>';


for ($s=0;$s<count($ser);$s++){
echo '<td>
<table>
<tr>
<td></td>
<td>'.$lang[285].'</td>
<td>Price</td>
</tr>';
for ($l=0;$l<6;$l++){
$va = $dfees[$vec[$v]['id']][$ser[$s]['service_id']][($l+1)];
//rint_r($va);
echo '<tr>
<td>
<input type="hidden" name="order[]" value="'.($l+1).'" />

'.($l+1).'</td>
<td>

<input type="text" name="distance__'.$vec[$v]['id'].'__'.$ser[$s]['service_id'].'[]" value="'.(isset($va['distance']) ? $va['distance'] : '').'" size="5" />

</td>

<td>

<input type="text" name="price__'.$vec[$v]['id'].'__'.$ser[$s]['service_id'].'[]" value="'.(isset($va['fees']) ? $va['fees'] : '').'" size="5" />

</td>
</tr>';
}
echo '
<tr>
<td>Per '.($c_setting['company_skid'] == "1" ? 'Extra Skid' : $c_setting['co_uom_distance']).'</td>
<input type="hidden" name="order[]" value="0" />
<td><input type="text" name="distance__'.$vec[$v]['id'].'__'.$ser[$s]['service_id'].'[]" value="'.(isset($dfees[$vec[$v]['id']][$ser[$s]['service_id']][0]) ? $dfees[$vec[$v]['id']][$ser[$s]['service_id']][0]['distance'] : '').'" size="5" /></td>
<td><input type="text" name="price__'.$vec[$v]['id'].'__'.$ser[$s]['service_id'].'[]" value="'.(isset($dfees[$vec[$v]['id']][$ser[$s]['service_id']][0]['fees']) ? $dfees[$vec[$v]['id']][$ser[$s]['service_id']][0]['fees'] : '').'" size="5" /></td>
</tr>
		
<tr>
		<td colspan="2">
		<input type="hidden" name="check_'.$vec[$v]['id'].'__'.$ser[$s]['service_id'].'" value="0" />
		
<input type="checkbox" value="1" name="check_'.$vec[$v]['id'].'__'.$ser[$s]['service_id'].'" '.(isset($dfees[$vec[$v]['id']][$ser[$s]['service_id']][0]['rate']) && $dfees[$vec[$v]['id']][$ser[$s]['service_id']][0]['rate'] == "1"  ? 'checked' : '').' /></td>
		</tr>
</table>

</td>';
}

echo '</tr>';
}


echo '</table>
<div style="clear:both;"></div>

<div class="form-group">

<input type="button" onclick="save_distance_inc();" class="btn btn-info" style="margin-bottom:10px;" value="'.$lang[219].'">
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
</form>
<div style="clear:both;"></div>
';
}


function template_distance_fees(){
global $lang,$ser,$vec,$dfees,$c_setting;



echo '
 <script>
  $(document).ready(function() {
    $("#distance_tab").tabs(
	
	
	);
		
	});
	</script>
<div id="prdia"></div>

<div id="distance_tab" >

<ul>
<li><a href="#dtab-1">'.$lang[578].' - '.$c_setting['co_uom_distance'].' </a></li>

<li><a href="pricing.php?action=distance_increase_rate">'.$lang[579].'</a></li>
</ul>

<div id="dtab-1">

<form id="vec_distance" method="post" action="'.formurl.'/pricing.php?action=distancefees" style="width:100%;" >
<input type="hidden" name="edit_distance_fees" value="1" />
<table border="1" class="table table-striped table-bordered table-hover">
<tr>
<th>+</th>
';
for ($s=0;$s<count($ser);$s++){
echo '<th>'.$ser[$s]['service_name'].'</th>';
}
echo '</tr>';

for ($v=0;$v<count($vec);$v++){
echo '<tr>
<td>'.$vec[$v]['vehicle'].'</td>';


for ($s=0;$s<count($ser);$s++){
echo '<td><input type="text" name="distance__'.$vec[$v]['id'].'__'.$ser[$s]['service_id'].'" onblur="check_numeric(this,\'distance__'.$vec[$v]['id'].'__'.$ser[$s]['service_id'].'\');" value="'.(isset($dfees[$vec[$v]['id']][$ser[$s]['service_id']]) ? $dfees[$vec[$v]['id']][$ser[$s]['service_id']] : '').'" size="5" /></td>';
}

echo '</tr>';
}


echo '</table>
<div style="clear:both;"></div>

<div class="form-group">

<input type="button" onclick="save_distance_fees();" class="btn btn-info"  value="'.$lang[583].'">
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
</form>
<div style="clear:both;"></div>

</div>

<div id="dtab-2">
</div>

</div>



';
}

function template_distance_increase_rate(){
global $lang,$ser,$sett,$val;
echo '
<form id="distance_increase_ratio" method="post" action="'.formurl.'/pricing.php?action=distance_increase_rate" style="width:100%;">
<input type="hidden" name="edit_distance_rate" value="1" />
<table border="1" class="table table-striped table-bordered table-hover">
<tr>
<th>'.$lang[580].'</th>
';
for ($s=0;$s<count($ser);$s++){
echo '<th>'.$ser[$s]['service_name'].'</th>';
}
echo '</tr>

<tr>
<td>
<input type="text" name="pattern" value="'.$val['pattern'][$ser[0]['service_id']]['every'].'" size="10"  />'.($c_setting['company_skid'] == "1" ? 'Extra Skid' : $c_setting['co_uom_distance']).'
</td>
';
for ($s=0;$s<count($ser);$s++){
echo '<td><input type="text" name="pattern__'.$ser[$s]['service_id'].'" value="'.$val['pattern'][$ser[$s]['service_id']]['ratio'].'" size="5" /> </td>';
}


echo '</tr>

</table>

<div style="clear:both;"></div>
<div class="form-group">

<input type="button" onclick="save_distance_ratio();" class="btn btn-info" style="margin-bottom:10px;" value="'.$lang[584].'">
<div style="clear:both;"></div>
</div>

</form>
<div style="clear:both;"></div>

';
}

function template_zone_manage(){
global $lang,$zones;
echo '
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>

<form style="width:100%;" id="edit_zone" method="post" action="'.SITEURL.'/administrator/pricing.php?action=edit_zone" >
<table  class="table table-striped table-bordered table-hover" id="zones_table">

<thead>
<th>'.$lang[216].'</th>
<th>'.$lang[217].'</th>
<th>'.$lang[218].'</th>
</thead>';

if (is_array($zones) && count($zones) > 0){
for ($i=0;$i<count($zones);$i++){
echo '<tr>
<td><input type="text" value="'.$zones[$i]['zone'].'"  name="zone[]" size="10" /></td>
<td><input type="text" value="'.$zones[$i]['prefix'].'"  name="prefix[]" size="10" /></td>
<td><input type="text" value="'.$zones[$i]['pcodes'].'"  name="pcodes[]" size="150" /></td>
</tr>';
}
}else{
echo '<tr>
<td colspan="100%">'.$lang[472].'</td>
</tr>';
}

echo '
</table>

<div class="form-group">
<div class="col-sm-9" style="margin:auto; " align="center">

		<input type="button"  name="check" onclick="save_zone(\'check\');"  class="btn btn-info" value="Check Error"/>
		
		<input type="button"   name="save" onclick="save_zone(\'add\');"  class="btn btn-info" value="'.$lang[219].'"/>
				
						
		<input type="button"  name="add_row" onclick="add_row_zone();" class="btn btn-info" value="'.$lang[221].'"/>
</div>
<div style="clear:both;"></div>
</div>

</form>
<div id="result"></div>
<div style="clear:both;"></div>
';
}

function template_vechiles_manage(){
global $lang;
echo '
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>
  <script>
  $(document).ready(function() {
    $("#tabs").tabs(
	
	
	);
	
	  var $tabs = $("#vtabs").tabs({
        add: function(event, ui) {
        $tabs.tabs("select", "#" + ui.panel.id);
    }
});


$("#vtabs").tabs( "load" , 0 );
  });
  
  



  </script>
  
<div id="right_side">
<div id="vtabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   <li><a href="pricing.php?action=vechiles&type=vprop" >'.$lang[222].'</a></li>
   <li><a href="pricing.php?action=add_v" >'.$lang[247].'</a></li>
   
</ul>

<div id="vtabs-0" style="padding:0px;" >
</div>

<div id="vtabs-1" style="padding:0px;">
</div>





</div>
</div>
<div style="clear:both;"></div>
';
}

function template_vprop(){
global $lang,$vech;

echo '
<form style="width:100%;">
<table border="1" class="table table-striped table-bordered table-hover">

<thead>
<th>'.$lang[239].'</th>
<th>'.$lang[227].'</th>
<th>'.$lang['default_vechile'].'</th>
<th>'.$lang[240].'</th>
</thead>';
if (count($vech) > 0){
for ($i=0;$i<count($vech);$i++){
echo '<tr>
<td>'.$vech[$i]['id'].'</td>
<td>'.$vech[$i]['vehicle'].'</td>
<td><input type="radio" name="default_vechile" onclick="update_default_vec(this);" value="'.$vech[$i]['id'].'" '.($vech[$i]['default_vechile'] == 'Y' ? 'checked' : '' ).' ></td>
<td><a href="#" onclick="edit_vechile(\''.$vech[$i]['id'].'\',\''.$vech[$i]['vehicle'].'\');">'.$lang[240].'</a></td>
</tr>';
}
}else{

echo '<tr><td colspan="100%">'.$lang[472].'</td></tr>';
}

echo '
</table>
</form>
<div style="clear:both;"></div>
';
}

function template_edit_v(){
global $lang,$ser,$pac,$vec,$zon,$pzon,$add_ser,$addser,$c_setting;
echo '
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>

<form  name="edit_v" id="edit_v" method="post" action="'.SITEURL.'/administrator/pricing.php?action=edit_v&id='.$vec->id.'" class="form-horizontal" role="form">
<input type="hidden" name="is_selected" value="1" />
		
<div class="col" style="width:30%; border-right:#000 1px solid;">
<div class="title">'.$lang[222].'</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[227].'</label>
<div class="col-sm-9"><input type="text" name="v_type" value="'.$vec->vehicle.'"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[299].'</label>
<div class="col-sm-9">
<select name="v_chart">
<option value="1" '.($vec->delfee_chart	 == 1 ? 'selected' : '').'>'.$lang[250].'</option>
<option value="2" '.($vec->delfee_chart	 == 2 ? 'selected' : '').'>'.$lang[251].'</option>
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[228].'  ('.$c_setting['co_uom_weight'].')</label>
<div class="col-sm-9"><input type="text" name="no_charge_weight" value="'.$vec->nocharge_weight.'"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[229].'  ('.$c_setting['co_uom_weight'].')</label>
<div class="col-sm-9"><input type="text" name="max_weight" value="'.$vec->max_weight.'"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[230].'  ('.$c_setting['co_uom_weight'].')</label>
<div class="col-sm-9"><input type="text" name="extra_weight_fee" value="'.$vec->extra_weight_fee.'"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[231].'  ('.$c_setting['co_uom_volume'].')</label>
<div class="col-sm-9"><input type="text" name="no_cahrge_voloume" value="'.$vec->nocharge_volume.'"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[232].'  ('.$c_setting['co_uom_volume'].')</label>
<div class="col-sm-9"><input type="text" name="max_volume" value="'.$vec->max_volume.'"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[233].'  ('.$c_setting['co_uom_volume'].')</label>
<div class="col-sm-9"><input type="text" name="extr_volume_fee" value="'.$vec->extra_volume_fee.'"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[226].'</label>
<div class="col-sm-9"><input type="text" name="return_trip" value="'.$vec->return_multiplier.'" /></div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[234].'</label>
<div class="col-sm-9">
<input type="text" name="fuel_surcharge" value="'.$vec->fs_adj_pct.'"><br>
%Inc./Dec./Fixed<br>
<input type="radio" name="group2" value="1" '.($vec->fs_adj_rb == 1 ? 'checked' : '').'>
<input type="radio" name="group2" value="2" '.($vec->fs_adj_rb == 2 ? 'checked' : '').'>
<input type="radio" name="group2" value="3" '.($vec->fs_adj_rb == 3 ? 'checked' : '').'> 
</div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[235].'</label>
<input type="hidden" name="disable"  value="N" />
<div class="col-sm-9"><input type="checkbox" name="disable"  value="Y" '.($vec->disabled == 'Y' ? 'checked' :  '').' /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[236].'</label>
<input type="hidden" name="selectable" value="N" />
<div class="col-sm-9"><input type="checkbox" name="selectable" value="Y" '.($vec->selectable == 'Y' ? 'checked' :  '').'/></div>
</div>


</div>


<div class="col" style="width:65%;">';

if (is_array($ser) && count($ser) > 0){

echo '<div class="col" style="width:45%;  border-right:#000 1px solid; float:left;">
<div class="title">'.$lang[243].'</div>
';

for ($i=0;$i<count($ser);$i++){
echo '<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[223].' - '.$ser[$i]['service_name'].'</label>
<div class="col-sm-9"><input type="text" name="zonerate_'.$ser[$i]['service_id'].'"  value="'.( ((array_key_exists($i,$zon)) && ($ser[$i]['service_id'] == $zon[$i]['services_id'])  ) ?  $zon[$i]['zone_rate_mutlipler'] : '').'"  > </div>
</div>';
}

echo '
</div>
<div class="col" style="width:45%; float:left;">
<div class="title">'.$lang[224].'</div>
';

for ($i=0;$i<count($ser);$i++){
echo '<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[224].' - '.$ser[$i]['service_name'].'</label>
<div class="col-sm-9"><input type="text" name="milerate_'.$ser[$i]['service_id'].'" value="'.((array_key_exists($i,$zon)) && $ser[$i]['service_id'] == $zon[$i]['services_id'] ?  $zon[$i]['mile_rate_multipler'] : '').'"> </div>
</div>';
}

echo '
</div>
<div style="clear:both;"></div>';
}

if (count($pac) > 0) {
echo '
<div class="col" style="width:45%; float:left;   ">
<div class="title">'.$lang[245].'</div>
<table class="table table-striped table-bordered table-hover" border="1">
<thead>
<th>'.$lang[246].'</th>
<th>'.$lang[237].'</th>
<th>'.$lang[238].'</th>
</thead>
';

for ($i=0;$i<count($pac);$i++){
echo '
<tr>
<td>'.$pac[$i]['package_name'].'</td>

<td><input type="text" name="packageno_'.$pac[$i]['package_id'].'"  value="'.(array_key_exists($i,$pzon) && $pac[$i]['package_id'] == $pzon[$i]['package_id'] ?  $pzon[$i]['no_charge_per_pack'] : '').'" size="7"> </td>

<td><input type="text" name="packageextra_'.$pac[$i]['package_id'].'"  value="'.(array_key_exists($i,$pzon) && $pac[$i]['package_id'] == $pzon[$i]['package_id'] ?  $pzon[$i]['extra_per_pack'] : '').'" size="7"> </td>
</tr>
';
}

echo '
</table>
</div>';
}

if (count($addser) > 0){
echo '<div class="col" style="width:45%; float:left;  ">
<div class="title">'.$lang[252].'</div>
<table class="table table-striped table-bordered table-hover" border="1">
<thead>
<th>'.$lang[44].'</th>
<th>'.$lang[286].'</th>

</thead>
';
for ($i=0;$i<count($addser);$i++){
echo '
<tr>
<td>'.$addser[$i]['name'].'</td>
<td><input type="text" name="additionaleservice_'.$addser[$i]['id'].'" value="'. (array_key_exists($addser[$i]['id'],$add_ser) ? $add_ser[$addser[$i]['id']] : ''  ).'" size="7"> </td>
</tr>
';
}

echo '
</table>
</div>';
}

echo '<div style="clear:both;"></div>

<div class="col">
<input type="button" onclick="edit_vechil();" class="btn btn-info" value="'.$lang[219].'"/>

<input type="button" onclick="close_my_tab(\'vtabs\',0);" class="btn btn-info" value="'.$lang[200].'"/>

</div>

</div>

</form>
<div style="clear:both;"></div>
';
}

function template_add_v(){
global $lang,$ser,$pac,$add_ser,$c_setting;
echo '
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>

<form  name="add_v" id="add_v" method="post" action="'.SITEURL.'/administrator/pricing.php?action=add_v" class="form-horizontal" role="form">

<div class="col" style="width:30%; border-right:#000 1px solid;">
<div class="title">'.$lang[222].'</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[227].'</label>
<div class="col-sm-9"><input type="text" name="v_type"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[299].'</label>
<div class="col-sm-9">
<select name="v_chart">
<option value="1">'.$lang[250].'</option>
<option value="2">'.$lang[251].'</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[228].'  ('.$c_setting['co_uom_weight'].')</label>
<div class="col-sm-9"><input type="text" name="no_charge_weight"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[229].'  ('.$c_setting['co_uom_weight'].')</label>
<div class="col-sm-9"><input type="text" name="max_weight"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[230].'  ('.$c_setting['co_uom_weight'].')</label>
<div class="col-sm-9"><input type="text" name="extra_weight_fee"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[231].'   ('.$c_setting['price_volume'].')</label>
<div class="col-sm-9"><input type="text" name="no_cahrge_voloume"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[232].'  ('.$c_setting['co_uom_volume'].')</label>
<div class="col-sm-9"><input type="text" name="max_volume"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[233].'  ('.$c_setting['co_uom_volume'].')</label>
<div class="col-sm-9"><input type="text" name="extr_volume_fee"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[226].'</label>
<div class="col-sm-9"><input type="text" name="return_trip" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[234].'</label>
<div class="col-sm-9">
<input type="text" name="fuel_surcharge"><br>
%Inc./Dec./Fixed<br>
<input type="radio" name="group2" value="1">
<input type="radio" name="group2" value="2">
<input type="radio" name="group2" value="3" > 
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[235].'</label>
<input type="hidden" name="disable"  value="N" />
<div class="col-sm-9"><input type="checkbox" name="disable"  value="Y" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[236].'</label>
<input type="hidden" name="selectable" value="N" />
<div class="col-sm-9"><input type="checkbox" name="selectable" value="Y" /></div>
</div>


</div>


<div class="col" style="width:65%;">
<div class="col" style="width:45%;  border-right:#000 1px solid; float:left;">
<div class="title">'.$lang[243].'</div>
';

for ($i=0;$i<count($ser);$i++){
echo '<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[223].' - '.$ser[$i]['service_name'].'</label>
<div class="col-sm-9"><input type="text" name="zonerate_'.$ser[$i]['service_id'].'"> </div>
</div>';
}

echo '
</div>
<div class="col" style="width:45%; float:left;">
<div class="title">'.$lang[224].'</div>
';

for ($i=0;$i<count($ser);$i++){
echo '<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[224].' - '.$ser[$i]['service_name'].'</label>
<div class="col-sm-9"><input type="text" name="milerate_'.$ser[$i]['service_id'].'"> </div>
</div>';
}

echo '
</div>
<div style="clear:both;"></div>



<div class="col" style="width:45%;   ">
<div class="title">'.$lang[245].'</div>
<table class="table table-striped table-bordered table-hover" border="1">
<thead>
<th>'.$lang[246].'</th>
<th>'.$lang[237].'</th>
<th>'.$lang[238].'</th>
</thead>
';

for ($i=0;$i<count($pac);$i++){
echo '
<tr>
<td>'.$pac[$i]['package_name'].'</td>
<td><input type="text" name="packageno_'.$pac[$i]['package_id'].'" size="5"> </td>
<td><input type="text" name="packageextra_'.$pac[$i]['package_id'].'" size="5"> </td>
</tr>
';
}

echo '
</table>
</div>

<div class="col" style="width:45%; float:left;  ">
<div class="title">'.$lang[252].'</div>
<table class="table table-striped table-bordered table-hover" border="1">
<thead>
<th>'.$lang[44].'</th>
<th>'.$lang[286].'</th>

</thead>
';

for ($i=0;$i<count($add_ser);$i++){
echo '
<tr>
<td>'.$add_ser[$i]['name'].'</td>
<td><input type="text" name="additionaleservice_'.$add_ser[$i]['id'].'"> </td>
</tr>
';
}

echo '
</table>
</div>

<div style="clear:both;"></div>



<div class="col">
<input type="button" onclick="add_vechile();" class="btn btn-info" value="'.$lang[219].'"/>
</div>

</div>

</form>
<div style="clear:both;"></div>
';
}

function template_pickupfees(){
global $pzon,$vec,$zone,$sett_compnay;

echo '<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/admin.js"></script>

<form  name="zone_pickup" id="zone_pickup" method="post" action="'.SITEURL.'/administrator/pricing.php?action=pickupfees" style="width:100%;  overflow:scroll;">
<input type="hidden" name="is_submited" value="1" />
<table class="table table-striped table-bordered table-hover" border="1">
<thead><tr><th></th>';
for ($v=0;$v<count($vec);$v++){
echo '<th>'.$vec[$v]['vehicle'].'</th>';
}
echo '</tr></thead>';


for ($z=1;$z<count($zone)+1;$z++){
echo '<tr><td>'.$zone[$z].'</td>';

for ($v=0;$v<count($vec);$v++){

if (array_key_exists($zone[$z],$pzon)  && array_key_exists($vec[$v]['id'],$pzon[$zone[$z]]) ) {

echo '<td><input type="text" value="'.$pzon[$zone[$z]][$vec[$v]['id']]['fee'].'" name="'.make_input_name($zone[$z]).'_'.$vec[$v]['id'].'" size="5" />';

if ($sett_compnay["company_skid"]["option_value"]  == "1"){
echo '<input type="text" value="'.$pzon[$zone[$z]][$vec[$v]['id']]['skid_fee'].'" name="skid_'.make_input_name($zone[$z]).'_'.$vec[$v]['id'].'" size="5" />';
}

echo '</td>';

}
else{
 echo '<td><input type="text" value="" name="'.make_input_name($zone[$z]).'_'.$vec[$v]['id'].'" size="5" />';

if ($sett_compnay["company_skid"]["option_value"]  == "1"){
echo '<input type="text" value="" name="skid_'.make_input_name($zone[$z]).'_'.$vec[$v]['id'].'" size="5" />';
}
echo '</td>';

}
}
echo '</tr>';
}

echo '</table>

<div class="form-group">
<input type="button" value="Save" onclick="pickup_vechile();" class="btn btn-info" name="update"/>
</div>


</form>
<div style="clear:both;"></div>
';
}

function template_price_option_mange(){  
global $lang,$version_id,$item_color,$bill_code,$bill,$glass_type;
echo '
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/admin.js"></script>
  <script>
  $(document).ready(function() {
    $("#price_option").tabs();
  });
  </script>
  
<div id="price_option" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
<ul>
  <!-- 
  <li><a href="pricing.php?action=price_addtional&what=mange" >'.$lang[658].'</a></li>
  <li><a href="pricing.php?action=price_pac&what=mange" >'.$lang[261].'</a></li>
  -->

<li><a href="pricing.php?action=price_setting&version_id='.$version_id.'&item_color='.$item_color.'&bill_code='.$bill_code.'&glass_type='.$glass_type.'" >'.$lang['pricing_department'].'</a></li>
<li><a href="pricing.php?action=price_checkbox&what=mange" >'.$lang[252].'</a></li>   
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

function template_price_setting(){
global $lang;
echo '';
}
//////////////////addtional services and checkbox in old system
function template_price_checkbox_mange(){
global $lang;

echo ' <script>
  $(document).ready(function() {
    $("#check_option").tabs();
	

  });
  </script>
  
<div id="check_option" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   <li><a href="pricing.php?action=price_checkbox&what=setting" >'.$lang['addtional_services'].'</a></li>
   <li><a href="pricing.php?action=price_checkbox&what=add" >'.$lang['addtional_services_add'].'</a></li>
   
</ul>

<div id="pricetabscheck-0" style="padding:0px;" >
</div>

<div id="pricetabscheck-1" >
</div>




</div>
';
}

function template_price_checkbox_add(){
global $lang;

echo '


<form id="add_check" method="post" action="'.SITEURL.'/administrator/pricing.php?action=price_checkbox" style="width:100%;" >
<input type="hidden" name="add_check" value="1" />
<div class="form-group">
<label class="col-sm-3 control-label">'.$lang['addtional_services_name'].'</label>
<div class="col-sm-9"><input type="text" name="ch_name" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang['addtional_services_shname'].'</label>
<div class="col-sm-9"><input type="text" name="ch_shortname" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang['addtional_services_price'].'</label>
<div class="col-sm-9"><input type="text" name="ch_fee" value="" />
<input type="radio" name="per_meters" value="1">--   متر طولى  
<input type="radio" name="per_meters" value="2">--   متر مربع  </div>
</div>
<br>
<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9"><input type="button" onclick="add_addservices();" class="btn btn-info"  value="'.$lang['addtional_services_add'].'" name="update"/>
</div>
</div>

</form>
<div style="clear:both;"></div>
';
}

function template_price_checkbox_edit(){
global $lang,$edit;
// var_dump($edit);
echo '


<form id="edit_check_'.$edit->id.'" method="post" action="'.SITEURL.'/administrator/pricing.php?action=price_checkbox" style="width:100%;" >
<input type="hidden" name="edit_check" value="1" />
<input type="hidden" name="edit_check_id" value="'.$edit->id.'" />
<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[253].'</label>
<div class="col-sm-9"><input type="text" name="ch_name" value="'.$edit->name.'" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[254].'</label>
<div class="col-sm-9"><input type="text" name="ch_shortname" value="'.$edit->short_name.'" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[286].'</label>
<div class="col-sm-9"><input type="text" name="ch_fee" value="'.$edit->price.'" /> - 
<input type="radio" name="per_meters" value="1" '.($edit->per_meters == "1" ? 'checked' : '').'>--   متر طولى  
<input type="radio" name="per_meters" value="2" '.($edit->per_meters == "2" ? 'checked' : '').'>--   متر مربع </div></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9"><input type="button" onclick="edit_addservices(\''.$edit->id.'\');" class="btn btn-info" style="margin:0 auto;" value="'.$lang['addtional_services_edit'].'" name="update"/>
</div>
</div>

</form>
<div style="clear:both;"></div>
';
}
function template_price_checkbox_account() 
{
    global $lang, $check, $account_id ,$check2;
    echo '<form id="price_checkbox_account_'.$account_id.'"  action="pricing.php?action=account_serves&account_id='.$account_id.'">
<table border="1" class="table table-striped table-bordered table-hover" id="add_serv" >
<thead>
<tr>
<th>ثمك الزجاج</th>

<th>' . $lang[254] . '</th>
<th>' . $lang[255] . '</th>
<th>سعر للوحدة للعميل</th>

</tr>
</thead>

<tbody>

';
// echo '<pre>';
// var_dump($check);
// echo '</pre>';
// echo '<pre>';
// var_dump($check2);
// echo '</pre>';
    
        for ($i = 0; $i < count($check); $i++) {
            echo '
<tr>
<td>' . $check[$i]['name']. '</td>

<td>' . $check[$i]['short_name'] . '</td>
<td>' . $check[$i]['price'] . '</td>

<td><input type="text" name="price['.$check[$i]['id'].'][';

if(count($check2) > 0){
   $index=0;
  for ($j = 0; $j < count($check2); $j++) { 
    
      if($check2[$j]['pack_id'] ==  $check[$i]['id'] ){
        $index=$check2[$j]['id'].']"'.'value="'.$check2[$j]['price'].'"';
      }
    }
     
if($index ==0)echo $index.']"';
   else echo $index;

}else {
  echo '0]"';
}
// $check[$i]['short_name']
echo '  ></td>

</tr>
';
        }
  

    echo '
    
</tbody>


</table>
<center> 
<button type="button" onclick="price_checkbox_account(\''.$account_id.'\')" class="btn btn-success" >'.$lang[50].'</buttom> 
</center>
</form>
<div id="result_dialoge"></div>
<div  style="clear:both;"></div>
';
}


function template_price_checkbox(){
global $lang,$check;
echo '
<table border="1" class="table table-striped table-bordered table-hover" id="add_serv" >
<thead>
<tr>
<th>'.$lang[253].'</th>
<th>'.$lang[254].'</th>
<th>'.$lang[255].'</th>
<th>'.$lang[312].'</th>
</tr>
</thead>

<tbody>
';

if (count($check) > 0 ){
for ($i=0;$i<count($check);$i++){
echo '
<tr>
<td>'.$check[$i]['name'].'</td>
<td>'.$check[$i]['short_name'].'</td>
<td>'.$check[$i]['price'].'</td>
<td><a href="#" onclick="edit_add_service(\''.$check[$i]['id'].'\',\''.$check[$i]['name'].'\');">'.$lang[312].'</a></td>
</tr>
';
}
}else{
echo '<tr><td colspan="100%">'.$lang[472].'</td></tr>';
}

echo '
</tbody>


</table>
<div style="clear:both;"></div>
';
}

//////////////////////vechile services /////////////////
function template_price_additional_mange(){
global $lang;

echo ' <script>
  $(document).ready(function() {
    $("#add_option").tabs();
  });
  </script>
  
<div id="add_option" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   <li><a href="pricing.php?action=price_addtional&what=setting" >'.$lang[323].'</a></li>
   <li><a href="pricing.php?action=price_addtional&what=add" >'.$lang[322].'</a></li>
   
</ul>

<div id="pricetabsadd-0" style="padding:0px;" >
</div>

<div id="pricetabsadd-1" >
</div>




</div>
';
}

function template_price_additional_add(){
global $lang;

echo '
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>

<form id="add_addservice" method="post" action="'.SITEURL.'/administrator/pricing.php?action=price_addtional" class="form-horizontal" >
<input type="hidden" name="add_add" value="1" />
<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[324].'</label>
<div class="col-sm-9"><input type="text" name="ch_name" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9"><input type="button" onclick="add_vec_services();" class="btn btn-info"  value="'.$lang[322].'" name="update"/>
</div>
</div>

</form>
<div style="clear:both;"></div>
';
}

function template_price_additional_edit(){
global $lang,$edit;

echo '
		
<form id="edit_addservice" method="post" action="'.SITEURL.'/administrator/pricing.php?action=price_addtional" class="form-horizontal" >
<input type="hidden" name="edit_add" value="1" />
<input type="hidden" name="edit_add_id" value="'.$edit->id.'" />
<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[324].'</label>
<div class="col-sm-9"><input type="text" name="ch_name" value="'.$edit->name.'" /></div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9"><input type="button" onclick="edit_vecservices();" class="btn btn-info"  value="'.$lang[325].'" name="update"/>
</div>
</div>

</form>
<div style="clear:both;"></div>
';
}

function template_price_additional(){
global $lang,$add_ser;
echo '

<table border="1" class="table table-striped table-bordered table-hover" id="add_serv" >
<thead>
<tr>
<th>'.$lang[257].'</th>
<th>'.$lang[36].'</th>
<th>'.$lang[312].'</th>
<th>'.$lang[259].'</th>
</tr>
</thead>

<tbody>
';

if (count($add_ser) > 0 ){

for ($i=0;$i<count($add_ser);$i++){
echo '
<tr>
<td>'.$add_ser[$i]['id'].'</td>
<td>'.$add_ser[$i]['name'].'</td>
<td><a href="#" onclick="edit_vec_service(\''.$add_ser[$i]['id'].'\',\''.$add_ser[$i]['name'].'\');">'.$lang[312].'</a></td>
<td><a href="#" onclick="delete_vec_service(\''.$add_ser[$i]['id'].'\');">'.$lang[259].'</a></td>
</tr>
';
}
}else{
echo '<tr><td colspan="100%">'.$lang[472].'</td></tr>';
}

echo '
</tbody>
</table>
<div style="clear:both;"></div>
';
}
////////////////////////////////////

///////////pacjage managment////////
function template_price_pac_mange(){
global $lang;

echo ' <script>
  $(document).ready(function() {
    $("#price_pac").tabs();
  });
  </script>
  
<div id="price_pac" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   <li><a href="pricing.php?action=price_pac&what=setting" >'.$lang[326].'</a></li>
   <li><a href="pricing.php?action=price_pac&what=add" >'.$lang[327].'</a></li>
   
</ul>

<div id="price_pac-0" style="padding:0px;" >
</div>

<div id="price_pac-1" >
</div>

</div>
';
}

function template_price_pac_add(){
global $lang;
echo '
<form id="add_pacervice" method="post" action="'.SITEURL.'/administrator/pricing.php?action=price_pac"  >

<input type="hidden" name="add_pac" value="1" />

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[328].'</label>
<div class="col-sm-9"><input type="text" name="pac_name" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[329].'</label>
<div class="col-sm-9"><input type="text" name="pac_name_short" value="" /></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9"><input type="button" onclick="add_pac_services();" class="btn btn-info" style="margin:0 auto;" value="'.$lang[327].'" name="update"/>
</div>
</div>

</form>
<div style="clear:both;"></div>
';
}

function template_price_pac_edit(){ 
global $lang,$edit;

echo '
<form id="edit_pacservice" method="post" action="'.SITEURL.'/administrator/pricing.php?action=price_pac" style="width:100%;" >
<input type="hidden" name="edit_pac" value="1" />
<input type="hidden" name="edit_pac_id" value="'.$edit->package_id.'" />

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[328].'</label>
<div class="col-sm-9"><input type="text" name="pac_name" value="'.$edit->package_name.'" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">'.$lang[329].'</label>
<div class="col-sm-9"><input type="text" name="pac_name_short" value="'.$edit->package_short.'" /></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9">
<input type="button" onclick="edit_pacservices();" class="btn btn-info" style="margin:0 auto;" value="'.$lang[330].'" name="update"/>
</div>
</div>

</form>
<div id="prdia"></div>
<div style="clear:both;"></div>
';
}

function template_price_pac(){
global $lang,$pac;
echo '
<table border="1" class="table table-striped table-bordered table-hover" id="add_serv" >
<thead>
<tr>
<th>'.$lang['addtional_services_name'].'</th>
<th>'.$lang['addtional_services_shname'].'</th>
<th>'.$lang[118].'</th>
<th>'.$lang[312].'</th>
<th>'.$lang[259].'</th>
</tr>
</thead>

<tbody>
';

if (count($pac) > 0 ){
for ($i=0;$i<count($pac);$i++){
echo '
<tr>
<td>'.$pac[$i]['package_id'].'</td>
<td>'.$pac[$i]['package_name'].'</td>
<td>'.$pac[$i]['package_short'].'</td>
<td><a href="#" onclick="edit_pac_service(\''.$pac[$i]['package_id'].'\',\''.$pac[$i]['package_name'].'\');">'.$lang[312].'</a></td>
<td><a href="#" onclick="delete_pac_service(\''.$pac[$i]['package_id'].'\');">'.$lang[259].'</a></td>
</tr>
';
}
}else{
echo '<tr><td colspan="100%">'.$lang[472].'</td></tr>';
}

echo '
</tbody>


</table>
<div style="clear:both;"></div>
';
}


function template_price_option(){
    global $lang,$check,$pac,$order_status,$price_values,$account_id,$version_id,$last_price_version,$item_color;
    global $glassColor,$mylocation,$billing_code,$bill_code,$bill,$glassType,$glass_type;
    global  $return;
//order_status is head
//pac is width

    if(!isset($account_id)) $account_id = '0';


    $x = "";

    $x .= '
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>

<div style="margin:auto">

<p style="float:left;">
<button class="btn btn-primary" onclick="add_new_price('.(isset($account_id)? $account_id : '\'0\'').',\''.$mylocation.'\');"
   >اضافة تسعير</button>
</p>';

//"open_price('.(isset($account_id)? $account_id : '\'0\'').',\''.$mylocation.'\','.$last_price_version[0]['id'].',`'.json_encode($order_status).'`,`'.json_encode($pac).'`)"
    if(isset($last_price_version[0]['id'])){

//

    if($account_id==0) {
        $x .= '<div class=\"form-group\">
<label class=\"col-sm-3 control-label\"> الفرع</label>';
        $x .= ' <select id="billing_code_' . $account_id . '" name="billCode"  onchange=\'open_price(' . (isset($account_id) ? $account_id : '\'0\'') . ',"' . $mylocation . '",' . $last_price_version[0]['id'] . ',`' . json_encode($order_status) . '`,`' . json_encode($pac) . '`)\'   style="margin-bottom: 10px;"> ';

        foreach ($billing_code as $value) {
//        $x.= '  <option value="'.$value['id'].'"   '.(($last_price_version[0]['id'] != $version_id && $version_id!='' )? ''.($last_price_version[0]['Item_colour'] == $value['id'] ? 'selected' : '' ).'' : ''.($item_color == $value['id'] ? 'selected' : '' ).'' ).'
//        >' .$value['color_name'].'</option>';
            $x .= '<option value="' . $value['id'] . '"
         ' . ($bill_code == $value['id'] ? 'selected' : '') . '>
        ' . $value['billingcode_name'] . '</option>';
        }


        $x .= ' 
</select> </div>';
    }
    $x.='<div class=\"form-group\">
<label class=\"col-sm-3 control-label\"> تاريخ التسعير</label>';
        $x .=  ' <select id="open_price_'.$account_id.'"  name="open_price" onchange=\'open_price('.(isset($account_id)? $account_id : '\'0\'').',"'.$mylocation.'",'.$last_price_version[0]['id'].',`'.json_encode($order_status).'`,`'.json_encode($pac).'`)\' style="margin-bottom: 10px;">
<option value="'.$last_price_version[0]['id'].'" > '.$last_price_version[0]['system_date'].' </option>';
        for($i=1;$i<count($last_price_version);$i++){
            $x.= '<option value="'.$last_price_version[$i]['id'].'" '.($version_id == $last_price_version[$i]['id'] ? 'selected' : '').'  >'.$last_price_version[$i]['system_date'].'</option>';
        }
        $x.= ' 
</select> ';

        $x.= '</div>

<hr/>


<form id="option_price" name="option_price" method="post"  
';
        if (isset($account_id)){
            $x.= 'action="'.SITEURL.'/administrator/accounts.php?action=price_details&account_id='.$account_id.'"';


        } else { $x.= 'action="'.SITEURL.'/administrator/pricing.php?action=price_setting"';}
        $x.= ' class="form-horizontal" role="form">

<input type="hidden" name="is_submited" value="1" />

';

        if (isset($account_id)){ $x.='<input type="hidden" id="account_id" name="account_id" value='.$account_id.' />';}

        $x.='

<input type="hidden" name="price_version" value="'.$version_id.'" />

<div class="row">

<div style="margin:auto">
<label class=\"col-sm-3 control-label\"> لون الزجاج</label>
<select id="item_color_'.$account_id.'" name="itemColor" onchange=\'open_price('.(isset($account_id)? $account_id : '\'0\'').',"'.$mylocation.'",'.$last_price_version[0]['id'].',`'.json_encode($order_status).'`,`'.json_encode($pac).'`)\'  style="margin-bottom: 10px;"> ';

        foreach ($glassColor as $value) {
//        $x.= '  <option value="'.$value['id'].'"   '.(($last_price_version[0]['id'] != $version_id && $version_id!='' )? ''.($last_price_version[0]['Item_colour'] == $value['id'] ? 'selected' : '' ).'' : ''.($item_color == $value['id'] ? 'selected' : '' ).'' ).'
//        >' .$value['color_name'].'</option>';
            $x.= '<option value="'.$value['color_name'].'"
         '.($item_color == $value['color_name'] ? 'selected' : '' ).'>
        '.$value['color_name'].'</option>';
        }


        $x.= ' 
</select>


<label class=\"col-sm-3 control-label\"> نوع الزجاج</label>
<select id="glass_type_'.$account_id.'" name="glassType" onchange=\'open_price('.(isset($account_id)? $account_id : '\'0\'').',"'.$mylocation.'",'.$last_price_version[0]['id'].',`'.json_encode($order_status).'`,`'.json_encode($pac).'`)\'  style = "margin-bottom: 10px;" > ';

        foreach ($glassType as $value) {

            $x.= '<option value="'.$value['glass_type'].'"
         '.($glass_type == $value['glass_type'] ? 'selected' : '' ).'>
        '.$value['glass_type'].'</option>';
        }


        $x.= ' 
</select>
</div>



                                          <div style="overflow-x: auto">
                                            <table style="width:auto;" border="1" id="prices" class="dataTable table  table-bordered" style="font-weight:bold; font-size:10px;">
                                            <thead>
                                            <tr>
                                            <th>السمك</th>';

        for ($i=0;$i<count($order_status);$i++){

            $x.= '<th>'.$order_status[$i]['statusname'].'</th>';
        }


        $x.= '</tr></thead>
                                            <tbody>
                                            ';
        for ($i=0;$i<count($pac);$i++){

            $x.= '<tr>
                                                <td>'.$pac[$i]['package_name'].'</td>
                                                
                                                ';
            for ($j=0;$j<count($order_status);$j++){

                $x.= '<td>
                                                    
                                                    <input type="text"  name="price['.$pac[$i]['package_id'].']['.$order_status[$j]['disporder'].']" 
                                                  
                                                    
                                                    value="'.(isset($price_values[$pac[$i]['package_id']][$order_status[$j]['disporder']]) ? $price_values[$pac[$i]['package_id']][$order_status[$j]['disporder']] : '').'"';


                // if($last_price_version[0]['id'] != $version_id && $version_id!='' ){
                //   $x.='disabled';
                // }
                $x.= ' size="5"  /></td>';


            }
            $x.= '</tr>';
        }



        $x.= '  
                                             </tbody>
                                             </table> 
                                             </div>
                                            
		
		
		
		

		
</div>
';

        if($last_price_version[0]['id'] == $version_id || $version_id =='' ){
            $x.='<div class="form-group">
  <input type="button" id="button_price" onclick="pricesetting_save();" class="btn btn-info"  value="'.$lang[50].'" name="update"/>
  </div>';
        }




        $x.= '</form>';

    }else{


        $x.= 'من فضلك اضف تسعير

  <div style="clear:both;"></div>
  </div>
  ';
        if($account_id==0) {
            $x .= '<div class=\"form-group\">
<label class=\"col-sm-3 control-label\"> الفرع</label>';
            $x .= ' <select id="billing_code_' . $account_id . '" name="billCode"  onchange=\'open_price(' . (isset($account_id) ? $account_id : '\'0\'') . ',"' . $mylocation . '",0,`' . json_encode($order_status) . '`,`' . json_encode($pac) . '`)\'   style="margin-bottom: 10px;"> ';

            foreach ($billing_code as $value) {
//        $x.= '  <option value="'.$value['id'].'"   '.(($last_price_version[0]['id'] != $version_id && $version_id!='' )? ''.($last_price_version[0]['Item_colour'] == $value['id'] ? 'selected' : '' ).'' : ''.($item_color == $value['id'] ? 'selected' : '' ).'' ).'
//        >' .$value['color_name'].'</option>';
                $x .= '<option value="' . $value['id'] . '"
         ' . ($bill_code == $value['id'] ? 'selected' : '') . '>
        ' . $value['billingcode_name'] . '</option>';
            }
        }
    }


    if(isset($return)) return $x;
    else echo $x;
}
function template_price_option_account(){ 
  global $lang,$check,$pac,$order_status,$price_values,$account_id,$version_id,$last_price_version,$view,$price_id,$item_color,$item_colors,$bill,$glass_type;
  //order_status is head 
  //pac is width
 
  echo '
  <script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>
  
  
  <select id="open_price" onchange=\'open_price_account('.$view.','.$account_id.','.$last_price_version[0]['id'].',`'.json_encode($order_status).'`,`'.json_encode($pac).'`)\' style="margin-bottom: 10px;"> 
  <option value="'.$last_price_version[0]['id'].'">التسعير الحالى-'.$last_price_version[0]['name'].'</option>';
  foreach ($last_price_version as $value) {
    if($last_price_version[0]['id'] == $value['id'] )continue;
    echo '<option value="'.$value['id'].'"  ';
    if($version_id==$value['id']){
      echo'  selected="selected" ';
    }
   
    echo '>
    '.$value['name'].'-'.$value['system_date'].'
    </option>';
  }
  
  echo ' 
  </select>
  
  <form id="option_price" name="option_price" method="post"  
  ';
  if (isset($account_id)){ 
    echo 'action="'.SITEURL.'/administrator/accounts.php?action=price_details&account_id='.$account_id.'"';
  
  } else { echo 'action="'.SITEURL.'/administrator/pricing.php?action=price_setting"';} 
  echo ' class="form-horizontal" role="form">
  
  <input type="hidden" name="is_submited" value="1" />';
  if (isset($account_id)){ echo'<input type="hidden" name="account_id" value='.$account_id.' />';}
  
  echo'
  <div class="row">
  
      
      
      
    
                                            
                                            
                                              <table border="1" id="price_account" class="dataTable table  table-bordered" style="font-weight:bold; font-size:10px;">
                                              <thead>
                                              <tr>
                                              <th>السمك</th>';
  
                                              for ($i=0;$i<count($order_status);$i++){
  
                                                  echo '<th>'.$order_status[$i]['statusname'].'</th>';
                                              }
  
                                              
                                              echo '</tr></thead>
                                              <tbody>
                                              ';
                                              for ($i=0;$i<count($pac);$i++){
  
                                                  echo '<tr>
                                                  <td>'.$pac[$i]['package_name'].'</td>
                                                  
                                                  ';
                                                  for ($j=0;$j<count($order_status);$j++){ 

                                                      echo '<td><input type="text"  name="price['.$pac[$i]['package_id'].']['.$order_status[$j]['disporder'].']" 
                                                      value="'.(isset($price_values[$pac[$i]['package_id']][$order_status[$j]['disporder']]) ? $price_values[$pac[$i]['package_id']][$order_status[$j]['disporder']] : '');
                                                 
                                                      echo'" ';
                                                      if($last_price_version[0]['id'] != $version_id && $version_id!='' ){
                                                        echo'disabled ';
                                                      }
                                                      if($view)echo'disabled ';
                                                      echo '/></td>';
                                                  }
                                                  echo '</tr>';
                                              }
          
                                         
        
                                               echo '  
                                               </tbody>
                                               </table> 
  
  </div>
  ';
  
  if($last_date =='' && !$view){
    echo'<div class="form-group">
    <input type="button" id="button_price_account" onclick="pricesetting_save();" class="btn btn-info"  value="'.$lang[50].'" name="update"/>
    </div>';
  }
  
  
  
  
  echo '</form>';
  }



function template_copyprice(){
	global $lang,$ser;
	echo '
			<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>
		
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
	for($i=0;$i<count($ser);$i++){
		echo '<option value="'.$ser[$i]['service_id'].'">'.$ser[$i]['service_name'].'</option>';
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
	for($i=0;$i<count($ser);$i++){
		echo '<option value="'.$ser[$i]['service_id'].'">'.$ser[$i]['service_name'].'</option>';
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

function template_add_deliveryfees(){
	global $lang;
	echo '
			<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>
			
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

function template_deliveryfees(){
global $lang,$normal;
echo '
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>
  <script>
  $(document).ready(function() {
    $("#dtabs_'.$normal.'").tabs(
	
	
	);
	

  });
  
  



  </script>
  

<div id="dtabs_'.$normal.'" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>';
if($normal == "1"){
   echo '
   		<li><a href="pricing.php?action=add_deliveryfees" >Add Delivery Fees</a></li>
   		<li><a href="pricing.php?action=deliveryfees_normal&chart=1" >'.$lang[250].'</a></li>
   <li><a href="pricing.php?action=deliveryfees_normal&chart=2" >'.$lang[251].'</a></li>
   		<li><a href="pricing.php?action=copyprice" >Copy Price</a></li>
   				';
   
}else{
	echo '<li><a href="pricing.php?action=deliveryfees&chart=1" >'.$lang[250].'</a></li>
   <li><a href="pricing.php?action=deliveryfees&chart=2" >'.$lang[251].'</a></li>';
}
echo '</ul>

<div id="vvtabs-0'.$normal.'" style="padding:0px;" >
</div>

<div id="vvtabs-1'.$normal.'" style="padding:0px;">
</div>





</div>

<div style="clear:both;"></div>

';
}

function template_deliveryfees_chart(){
global $ser,$chart,$normal ;

echo '<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>
  <script>
  $("#servicess_'.$chart.'").ready(function() {
    $("#servicess_'.$chart.'").tabs(
	
	
	);



 
  });
  </script>
  

<div id="servicess_'.$chart.'" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   ';
   for ($j=0; $j<count($ser);$j++){
   //	print_r($ser);
      echo '<li><a href="pricing.php?action=delivery_ser&serid='.$ser[$j]['service_id'].'&chart='.$chart.'" >'.$ser[$j]['service_name'].'</a></li>';
}
echo '</ul>';

for ($t=0; $t<count($ser);$t++){
   echo '<div id="sta-'.$t.'" style="padding:0px;" ></div>';
}

echo '</div>
<div style="clear:both;"></div>

';
}


function template_deliveryfees_chart_normal(){
	global $ser,$chart,$normal,$delivery_fee,$lang ;
	
//var_dump($delivery_fee);
	echo '
			<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>
 
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/account.js"></script>

		
	

<form onsubmit="return false;" name="edit_deliver_services_0_'.$chart.'" id="edit_deliver_services_0_'.$chart.'" method="post" action="'.SITEURL.'/administrator/pricing.php?action=deliveryfees_normal&chart='.$chart.'" >
<input type="hidden" name="chart" value="'.$chart.'" />
		
<table class="table table-striped table-bordered " style="font-size:8px;" id="delivery_table_'.$account_id.'">
<tr style="backgorund:green;">
<th>+</th>
<th >'.$lang[354].'</th>
<th>'.$lang[355].'</th>
';
for ($v=0;$v<count($ser);$v++){
echo '<th>'.$ser[$v]['service_name'].'</th>';
}

echo '</tr>';
$num=3;
//var_dump($delivery_fee);
if (is_array($delivery_fee) && count($delivery_fee) > 0) $num = (count($delivery_fee));

if(count($delivery_fee) > $num) $num =count($delivery_fee) ;
for ($i=0;$i<$num;$i++){
echo '
<tr id="zone_'.$i.'">
<td>
		<button onclick="delete_zone(\'#zone_'.$i.'\',\''.$delivery_fee[$i]['zonefrom'].'\',\''.$delivery_fee[$i]['zoneto'].'\',\''.$_POST['chart'].'\');" class="btn btn-danger btn-xs">
												<i class="ace-icon fa fa-trash-o  icon-only"></i>
		</button>
		
		</td>
<td><input type="text" name="nc__delivery__zonefrom__'.$i.'" size="8" value="'.(count($delivery_fee)>0 ? $delivery_fee[$i]['zonefrom'] :'').'"/></td>
<td><input type="text" name="nc__delivery__zoneto__'.$i.'" size="8" value="'.(count($delivery_fee)>0 ? $delivery_fee[$i]['zoneto'] :'').'"/></td>

';
for ($sv=0;$sv<count($ser);$sv++){
echo '<td><input type="text" name="nc__delivery__'.$ser[$sv]['service_id'].'__'.$i.'" size="5" value="'.(count($delivery_fee[$i]['srv_fee'])> 0 && isset($delivery_fee[$i]['srv_fee'][$delivery_fee[$i]['zonefrom']][$delivery_fee[$i]['zoneto']][$ser[$sv]['service_id']]) ? $delivery_fee[$i]['srv_fee'][$delivery_fee[$i]['zonefrom']][$delivery_fee[$i]['zoneto']][$ser[$sv]['service_id']] :'').'"/></td>';
}
echo '</tr>';
}

echo '
		<!--
<tr>
<td colspan="100%">
<input type="button" id="add_acc" onclick="add_delivery_rows(\'\');"  value="'.$lang[221].'" class="btn btn-info" style="margin:auto; float:none;"  name="edituser"/>
</td>
</tr>
-->
		
</table>
		
		<div class="form-group">
<input type="button" onclick="delivery_save(\'0\',\''.$chart.'\');" class="btn btn-info" style="margin:0 auto;" value="Save" name="update"/>
</div>
		
		
		</form>

';
}


function template_zone_deliver(){
global $delivery,$zone,$service_id,$chart_id,$sett_compnay;
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

		<form  name="edit_deliver_services_'.$se.'_'.$chart.'" id="edit_deliver_services_'.$se.'_'.$chart.'" method="post" action="'.SITEURL.'/administrator/pricing.php?action=edit_delivery_ser&ser='.$se.'&chart='.$chart.'" >

				
				
				<div class="py">
<table class="table  table-bordered " style="float:left;" border="1">
				<thead  >
<tr >
<th >Zone</th>
';
for ($i=1;$i<count($zone)+1 ;$i++){
echo '<th class="headrow">'.$zone[$i].'</th>';
}
echo '</tr>
		</thead>
		<tbody >';

for ($j=1;$j<count($zone)+1 ;$j++){
echo '<tr ><td class="headcol">'.$zone[$j].'</td>';

for ($z=1;$z<count($zone)+1 ;$z++){

if ($j >= $z){
if (array_key_exists($zone[$j],$delivery) && array_key_exists($zone[$z],$delivery[$zone[$j]]) ){
echo '<td><input type="text" name="'.make_input_name($zone[$j]).'_'.make_input_name($zone[$z]).'" value="'.$delivery[$zone[$j]][$zone[$z]]['price'].'" size="5"/>';


if ($sett_compnay["company_skid"]["option_value"]  == "1"){
echo '<input type="text" name="skid_'.make_input_name($zone[$j]).'_'.make_input_name($zone[$z]).'" value="'.$delivery[$zone[$j]][$zone[$z]]['skid'].'" size="5"/>';
}

echo '</td>';

}else{
echo '<td><input type="text" value="" name="'.make_input_name($zone[$j]).'_'.make_input_name($zone[$z]).'" size="5" /> ';

if ($sett_compnay["company_skid"]["option_value"]  == "1"){
echo '<input type="text" name="skid_'.make_input_name($zone[$j]).'_'.make_input_name($zone[$z]).'" value="" size="5"/>';
}

echo '</td>';

}

}else{
echo '<td><input type="text" value="" disabled="disabled" size="5" /> </td>';

}

}
echo '</tr>';
}



echo '</tbody></table>
</div>
<div class="form-group">
<input type="button" onclick="delivery_save(\''.$se.'\',\''.$chart.'\');" class="btn btn-info" style="margin:0 auto;" value="Save" name="update"/>
</div>


</form>
<div id="result"></div>
<div style="clear:both;"></div>';
}

function template_time_price(){
global $zone,$lang,$rate;

echo '
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/price.js"></script>
<form  name="edit_zone_time" id="edit_zone_time" method="post" action="'.SITEURL.'/administrator/pricing.php?action=timeofday" >
<input type="hidden" name="is_submit" value="1"/>
<table class="table table-striped table-bordered table-hover" border="1" >
<tr>';
for ($i=0;$i<1;$i++){
echo '<tr>';
foreach($zone[$i] as $key => $value){
if ($key == "id" || $key == "client_acctno"){
}else{
echo '<th>'.$rate[$key].'</th>';
}
}
echo '</tr>';
}


for ($i=0;$i<count($zone);$i++){
echo '<tr>';
$j=0;
foreach($zone[$i] as $key => $value){

if ($key == "id" || $key == "client_acctno"){

}else{

if ($j>0){
echo '<td><input type="text" value="'.$zone[$i][$key].'" name="'.strtoupper($zone[$i]['zone']).'[]" size="5" /></td>';
}else echo '<td>'.strtoupper($zone[$i][$key]).'</td>';
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