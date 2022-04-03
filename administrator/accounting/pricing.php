<?php
session_start();
include ("../../setting.php");
include("../../".STYLE."/pricetemp.php");
include("naccountingtemp.php");

include ("../../classes/account.php");
include ("../../classes/console.php");
include ("../../classes/price.php");
include ("../../classes/services.php");
include ("../../classes/package.php");
include ("../../classes/company.php");

$account = new account($db);
$newtemp = new template();
$price = new price($db);
$services = new services($db);
$package = new package($db);
$company = new company($db);

if ( !empty($_GET["action"]) ){
$action = $_GET["action"];
}else{
$action = "";
}
$sett_compnay = $company->get_company_details();


if (!empty($_SESSION['logged_in'] ) && !empty($_SESSION['user_type'] ) && $_SESSION['logged_in'] == 1  &&  $_SESSION['status'] == 2 ){

	// &&  $_SESSION['user_type'] == "accounting" 

	$open = "setup";
	
	switch ($action){


case 'options_manage':
$newtemp->load_template('price_option_mange',5);
break;

case 'price_checkbox':
$what = "";
if (isset($_GET['what'])) $what = $_GET['what'];

// if(isset($_POST['per_meters'])) $_POST['per_meters'] = "1";
// else $_POST['per_meters'] = "0";

if (isset($_POST['add_check'])){

$add = $price->add_addservice($_POST['ch_name'],$_POST['ch_shortname'],$_POST['ch_fee'],$_POST['per_meters']);
if ($add){
echo $lang[313];
}else{
echo $lang[314];
}

}elseif(isset($_POST['edit_check'])){
$edit = $price->edit_addservice($_POST['ch_name'],$_POST['ch_shortname'],$_POST['ch_fee'],$_POST['per_meters'],$_POST['edit_check_id']);
if ($edit){
echo $lang[313];
}else{
echo $lang[314];
}
}elseif($what == "add"){
$newtemp->load_template('price_checkbox_add',5); 
}elseif($what == "edit"){

if (isset($_GET['id'])){
$edit = $price->get_addservice($_GET['id']);
$newtemp->load_template('price_checkbox_edit',5);
}


}elseif($what == "mange"){
$newtemp->load_template('price_checkbox_mange',5);
}elseif($what == "setting"){
$check = $price->get_add_check_price(); 
// var_dump($check); 
$newtemp->load_template('price_checkbox',5);
}elseif($what == "delete"){
$del = $price->delete_addservices($_GET['id']);
if ($del){
echo $lang[319];
}else{
echo $lang[320];
}
}
break;

case 'account_serves': 
$account_id=$_GET['account_id'];
if(isset($_POST['price']) && isset($_GET['account_id']) )
	{	$good=false;
		mysqli_query($mycon,"DELETE FROM `pack` WHERE `pack`.`account_id` = $account_id");
		foreach ($_POST['price'] as $id => $value) {
			foreach ($value as $id2 => $value2) { 
				// echo '['.$id.']['.$id2.'] val=>'.$value2.'<br>'; 
				// if($id2==0){
				
					$good=$price->set_account_services($account_id,$id,$value2);
				// }
 				// else {$good=$price->edit_account_services($id2,$value2);} 
			}
		}
		if($good)echo'تم التعديل';
			else echo'لم يتم التعديل'; 
	}
else {
	
	$check = $price->get_add_check_price(); 
	$check2 = $price->get_add_check_price($account_id);  
	
	$newtemp->load_template('price_checkbox_account',5);  
	// var_dump($check) ;
	// var_dump($check2);   
}
 

break;

case 'price_addtional':
$what = "";
if (isset($_GET['what'])) $what = $_GET['what'];

if (isset($_POST['add_add'])){

$add = $services->add_add_vec_service($_POST['ch_name']);
if ($add){
echo $lang[313];
}else{
echo $lang[314];
}

}elseif(isset($_POST['edit_add'])){
$edit = $services->edit_add_vec_service($_POST['ch_name'],$_POST['edit_add_id']);
if ($edit){
echo $lang[313];
}else{
echo $lang[314];
}
}elseif($what == "add"){
$newtemp->load_template('price_additional_add',5);
}elseif($what == "edit"){

if (isset($_GET['id'])){
$edit = $services->get_add_vec_service($_GET['id']);
$newtemp->load_template('price_additional_edit',5);
}


}elseif($what == "mange"){
$newtemp->load_template('price_additional_mange',5);
}elseif($what == "setting"){
$add_ser = $services->get_addtional_services();
$newtemp->load_template('price_additional',5);
}elseif($what == "delete"){
$del = $services->delete_add_vec_services($_GET['id']);
if ($del){
echo $lang[319];
}else{
echo $lang[320];
}
}
break;

case 'price_pac':
$what = "";
if (isset($_GET['what'])) $what = $_GET['what'];

if (isset($_POST['add_pac'])){

$add = $package->add_pack_type($_POST['pac_name'],$_POST['pac_name_short']);
if ($add){
echo $lang[313];
}else{
echo $lang[314];
}

}elseif(isset($_POST['edit_pac'])){
$edit = $package->edit_package($_POST['edit_pac_id'],$_POST['pac_name'],$_POST['pac_name_short']);
if ($edit){
echo $lang[313];
}else{
echo $lang[314];
}
}elseif($what == "add"){
$newtemp->load_template('price_pac_add',5);
}elseif($what == "edit"){

if (isset($_GET['id'])){
$edit = $package->get_packages($_GET['id']);
$newtemp->load_template('price_pac_edit',5);
}


}elseif($what == "mange"){
$newtemp->load_template('price_pac_mange',5);
}elseif($what == "setting"){
$pac = $package->get_package();
$newtemp->load_template('price_pac',5);
}elseif($what == "delete"){
$del = $package->delete_package($_GET['id']);
if ($del){
echo $lang[319];
}else{
echo $lang[320];
}
}
break;


case 'add_new_price':
	if(isset($_POST['new_price'])){
        echo "why";
		if(isset($_POST['account_id']) && $_POST['account_id'] > '0'){
			$account_id = $_POST['account_id'];
			echo "why";
		}else $account_id = '0';

		$parent_id = '0';
		$system_date = date("Y-m-d H:i:s");

		if(isset($_POST['billing_code']) && $_POST['billing_code'] > '0'){
			$billing_code = $_POST['billing_code'];
		}else $billing_code = '1';

        echo "why";
		$q = mysqli_query($mycon,"insert into price_version
		(parent_id,system_date,user_id,billing_id,account_id,item_colour) values (
			'".$parent_id."',
			'".$system_date."',
			'".$_SESSION['user_id']."',
			'".$billing_code."',
			'".$account_id."',
			'0'
		)") or die (mysqli_error($mycon));

		if($query) return true;
		else return false;

	}
break; 


case 'price_setting':

if (isset($_POST['is_submited'])){

	$prices = $_POST['price'];

$kv = array();
$itemColor = $_POST['itemColor'];
$Glass_type =$_POST['glassType'];
echo $Glass_type;
$price_version = $_POST['price_version'];
    if(isset($_POST['account_id'])){
        $account_id=$_POST['account_id'];
    }
    else $account_id='0';
if($itemColor > '0' && $price_version > '0'){
	mysqli_query($mycon,"DELETE FROM package_status_price WHERE account_id ='".$account_id."' 
	and item_colour = '$itemColor' and version_id = '$price_version' and Glass_type = '$Glass_type'  ");
}
// //check if price version and color found or not 

// $query = mysqli_query($mycon,"select * from price_version where price ");
// ////////////////////////////////////////////////
// mysqli_query($mycon,"insert into price_version (user_id,billing_id,item_colour) values ('".$_SESSION['user_id']."','".$_SESSION['billing_code']."','".$itColor."')");
// $version_id = mysqli_insert_id($mycon);

foreach ($prices as $package_id => $value) {

	foreach ($value as $status_id => $val){
	//	echo "value : ".$val;

	if($val != '') mysqli_query($mycon,"insert into package_status_price (	account_id,	package_id,status_id,	fee,version_id,item_colour,glass_type) 
	values ('".$account_id."','".$package_id."','".$status_id."','".$val."','".$price_version."','".$itemColor."','".$Glass_type."')");

}

	//$kv[$package_id] = $value;

	
}
//echo $lang['price_list_result'].'ss';

}else{

    if(isset($_GET['bill_code']))
        $bill_code=$_GET['bill_code'];
    else
        $bill_code = "1";
//    var_dump($_GET);

$pac = $package->get_package(); 
$glassColor = $db->get_table("inventory_items_color");
$glassType= $db->get_table("inventory_items_glass_type");

$billing_code = $db->get_table("billing_code");
$check = $price->get_add_check_price();
$order_status = $db->get_table("status  where iscancel = '0' order by disporder");
$last_version_id='';
// $last_date_list=$db->get_table("(SELECT SUBSTR(last_update,1,16) as x FROM `package_status_price` GROUP BY package_status_price.`last_update`) as y GROUP BY y.x");
$last_price_version = $db->get_table("`price_version`  WHERE `account_id` ='0' and billing_id='".$bill_code."'  and parent_id = '0' ORDER BY id DESC");

 //var_dump($last_price_version);

if(isset($_GET['item_color'])){
    $item_color=$_GET['item_color'];
}else $item_color = "شفاف";

    if(isset($_GET['glass_type'])){
        $glass_type=$_GET['glass_type'];
    }else $glass_type = "مسطح";

//if(isset($_GET['bill_code'])){
//    $bill_code=$_GET['bill_code'];
//}else $bill_code = "1";

if(isset($_GET['version_id']) && $_GET['version_id'] > '0'){
    $version_id=$_GET['version_id'];
    foreach($last_price_version as $last)
    {
//        echo $last['id'];
        if ($last['id'] == $_GET['version_id']) {
            $version_id = $_GET['version_id'];
//            echo $version_id;
            break;
        }
     else
        $version_id = $last_price_version[0]['id'];
    }
}else
    $version_id = $last_price_version[0]['id'];

//$bill_code = $db->get_table("`price_version`  WHERE `id` ='$version_id' ")[0]['billing_id'];
$price_values = $price->get_pac_status_pricelist('0',$version_id,$item_color,$glass_type);

//var_dump($price_values);
    $mylocation = "adminmanager";
$newtemp->load_template('price_option',5);  
}
break;

case 'query':
$table=$db->get_table($_POST['query']);
echo json_encode($table);
break;

default:
$last_date='';
if(isset($_GET['version_id'])){
$version_id=$_GET['version_id'];
}else{
	$last_price_version = $db->get_table("`price_version`  WHERE `account_id` ='0' and parent_id = '0' ORDER BY id DESC limit 1");

	$version_id = $last_price_version[0]['id'];

}
    if(isset($_GET['glass_type'])){
        $glass_type=$_GET['glass_type'];
    }else $glass_type = "مسطح";
if(isset($_GET['item_color'])){
 $item_color = $_GET['item_color'];
}else{
    $item_color = "شفاف";

}
    if(isset($_GET['bill_code'])){
        $bill_code=$_GET['bill_code'];
    }else $bill_code = "1";
//    echo $bill_code;

$page_title = $lang['pricing_department'];

//    $bill_code = $db->get_table("`price_version`  WHERE `id` ='$version_id' ")[0]['billing_id'];
$newtemp->load_template('price_option_mange', 1, 'accounting_menu');  
break;

}
}else{
$page_title = $lang[102];
$newtemp->load_template('login_admin',5);
}


?>