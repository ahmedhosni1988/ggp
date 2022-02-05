<?php

// include ("driver.php");
// include ("notification.php");
// include ("orders.php");
// include ("services.php");
// include ("company.php");
// include ("contact.php");

class work{

	var $db;
	var $dbClass;
	public function __construct($db){
		$this->dbClass = $db;
		$this->db = $db->get_conn();
	}


	
	function Dispatch_order($order_id,$driver_id,$driver_id2,$account_id,$type){
		
		
		
		
	}
	
	

	///This function is used to recal order when it all in datbase and update epieces 
	function recalc_order_database($order_id,$case){
		global $c_setting,$package,$orders,$price,$account,$services;

		$pieces = 0;
		$total_weight = 0;
		$total_volume = 0;
		$billable_weight =0;

		$pac = mysqli_query($this->db,"select * from orders_package where order_id = '$order_id' ") or die (mysqli_error($this->db));

		while($row = mysqli_fetch_assoc($pac)){
			$pieces++;
			$total_weight += $row['weight'];
			$total_volume += $row['volume'];
		}

		$weight_volume = $total_volume / $c_setting['weight_volume'];

		if($weight_volume > $total_weight) $billable_weight = $weight_volume;
		else $billable_weight = $total_weight;


		if($case == 'update'){

			$que = mysqli_query($this->db,"update orders set weight = '".$total_weight."' , 
			volume = '".$total_volume."', 
			pieces = '".$pieces."', 
			billable_weight = '".$billable_weight."' 
			where order_id = '$order_id' ") or die (mysqli_error($this->db));
		}

		////////
		$query =  mysqli_query($this->db,"select * from orders where order_id = '$order_id' ") or die (mysqli_error($this->db));
		$orderDetails = mysqli_fetch_assoc($query);
		$Cliquery =  mysqli_query($this->db,"select * from account where account_id = '".$orderDetails['account_id']."' ") or die (mysqli_error($this->db));
		$client = mysqli_fetch_assoc($Cliquery);

		$delivery_cal = $this->cal_delivery_price($orderDetails,$client,$pieces,$billable_weight);
		
		$client_discount = $this->cal_client_discount($client,$delivery_cal['price']);
		
		$declare_value = $this->cal_declare_value($orderDetails);

		$addtional_services = $this->cal_addtional_services($orderDetails,$client);
		$result[] = $delivery_cal;
	
		if($client_discount != false)	$result[] = $client_discount;
    	if($declare_value != false)	$result[] = $declare_value;
		
		if($addtional_services) {
		 	for($v=0;$v<count($addtional_services);$v++)
		 	$result[] = $addtional_services[$v];
		 }

		 $tax_result = $this->cal_fs_tax($orderDetails,$client,$result);
		 //$tax_result = false;
		 if(count($tax_result) > 0){

			for($i=0;$i<count($tax_result);$i++){
				$result[] = $tax_result[$i];
			}
		 }
		 

		return $result;


	}


	function cal_client_discount($client,$delivery_price){

		if($client['price_ovrd_del_fee'] > 0 ){
			return array("name"=>"client_discount","desc"=>"Client Discount (".((1 - $client['price_ovrd_del_fee'] ) * 100)." %) - ".$delivery_price,"ratio"=> (1 - $client['price_ovrd_del_fee'] ) ,"price"=>($delivery_price * (1-$client['price_ovrd_del_fee'])) * -1,"type"=>"client_discount","order_sort"=>2,"type_key"=>6);

		}else{
			return false;
		}
   
	}

	function cal_declare_value($orderDetails){

		if($orderDetails['declared_value'] > '99'){

		
		$first_value = "";
	
		$declared_value = $orderDetails['declared_value'];  
		$dec = $declared_value / 100;
		
		$dec_arr = explode('.',$dec);
		$first_value = $dec_arr[0] * 3;
	  
		if(count($dec_arr) == 0){
		  
		}else{
	  
		 if(substr($dec_arr[1],0,1) > "5") $first_value = $first_value + 1.5;
		  
		}
	  
		return array("name"=>"declared_value","desc"=>"Declared Insurance : ".$declared_value ,"ser_id"=>"","price"=>$first_value,"type"=>"declared_value","order_sort"=>4,"type_key"=>14);
	}else{
		return false;
	}
		
	}

	function cal_addtional_services($orderDetails,$client){
		global $c_setting,$package,$orders,$account,$price;

		//$price = new price($this->db);
		
		$add_services = explode(',',$orderDetails['addtional_services']);

		if(count($add_services) > 0 ){
		//	echo "ahmed";

		$addtional_services = $this->get_add_check_price_id();
	//	echo "ahmed";

$add_ser_client = $account->get_account_addservice($client['account_id'],"addservices");
//echo "ahmed";

if(is_array($add_ser_client) && count($add_ser_client) > 0){
	for($i=0;$i<count($add_ser_client);$i++){
		$addtional_services[$add_ser_client[$i]['package_id']]['price'] = $add_ser_client[$i]['override'];
	
	}
}


		$pc_cb_total = 0;
	
		//print_r($add_services);
		
		   if(is_array($addtional_services) && count($addtional_services) > 0){
			 $m =0 ;
			foreach($addtional_services as $add_ser){
				   
				   if(is_array($add_services) && $add_services[$m] == $add_ser['id'] && $add_ser['price'] > 0) {
						   
				   if($add_ser['price'] > 0) $pc_cb1 = $add_ser['price'];
				   if($add_ser["return_cal"] == "Y") $pc_cb1 = $pc_cb1 ;
				   
				   if($pc_cb1 > 0 ) $result[] = array("name"=>$add_ser['name'],"desc"=>$add_ser['name'],"ser_id"=>$add_ser['id'],"price"=>$pc_cb1,"type"=>"addtional_services","order_sort"=>4,"type_key"=>11);
				   if($pc_cb1 > 0 ) $pc_cb_total += $pc_cb1;
				   
				   }
				   
			   }
				   
		   }

		   return $result;

		}else {
			return false;
		}


	}

	function get_add_check_price_id(){
		$query = mysqli_query($this->db,"select * from addtional_services ") or die (mysqli_error($this->db));
		$company_details = array();
		$i=0;
		while ($row = mysqli_fetch_assoc($query)){
			
			$x="";
			foreach($row as $key => $value)
			{    
				if($key == 'id') $x=$value;
				$arr[$key] = $value;  
			}
	
			$company_details[$x] =$arr;
			$i++;
		}
	
		mysqli_free_result($row);
		
	
		return $company_details;
	}

	function cal_fs_tax($orderDetails,$client,$Presult){
		global $c_setting,$package,$orders,$account,$price,$services;

        	$taxgroup = $account->get_account_taxgroup($client['account_id']);
			$tp_tax =  $price->get_tax_price_array($taxgroup,$Presult);
			  
			//echo $tp_tax;
			if( $orderDetails['fs_rate'] != '' ){
			  $fsrate = $orderDetails['fs_rate'] ;
			}else{
			  $fsrate =  $price->get_fsrate($taxgroup,"1",$client['account_id'],$orderDetails['fs_order_date']);
			}
		  
			  //echo $fsrate;
			  $fuelsurcharge = sprintf("%01.2f",$tp_tax * $fsrate / 100);
		  
			   $vec_ser = $services->get_addtional_services();
			   $add_ser = $price->get_add_check_price();
			   
			   //print_r($result);
			   
			
			   $order_inv_prices = $price->get_inv_order_prices_array($Presult);
		  
			   $services_charges = setup_serviceprices($order_inv_prices,$add_ser,$vec_ser,"0");
			   
			   //print_r($services_charges);
			   
			   
			   $companyClass = new company($this->dbClass);
			   
			   $taxname = $companyClass->get_tax_name();
			   $taxrate = $companyClass->get_tax_rate();
		  
			   $taxgroup_details = $companyClass->get_tax_group_id($taxgroup);
			  
			   $fly_fsamount = 0;
			   $itotal =0;
			   $orderprice = 0;
			  for ($s=0;$s<count($services_charges);$s++){
				
				  $txcalcs = tax_fs_calc($taxgroup,$fsrate,$services_charges[$s]["chg"],$services_charges[$s]["typ"]);
				  
				  $itotal = $itotal + $orderprice +
				  $txcalcs[0] + $txcalcs[1] + $txcalcs[2] + $txcalcs[3] + $txcalcs[4]  + $txcalcs[5];
				  
				  //echo $itotal;
				  
				  $fly_fsamount     += floatval($txcalcs[0]);
				  $fly_fsrate       = floatval($txcalcs[6]);
				  $fly_tax1amount   += floatval($txcalcs[1]);
				  $fly_tax2amount   += floatval($txcalcs[2]);
				  $fly_tax3amount   += floatval($txcalcs[3]);
				  $fly_tax4amount   += floatval($txcalcs[4]);
			
					  
			  }
			  
			 // echo "<br>".$taxrate[$taxgroup_details->taxgroup_tax1]."<br>";
			  if( $txcalcs[1] > 0) $result[] =  array("name"=>"Tax 1","ratio"=> $taxrate[$taxgroup_details->taxgroup_tax1] ,"ser_id"=> $taxgroup_details->taxgroup_tax1 ,"desc"=>$taxname[$taxgroup_details->taxgroup_tax1],"price"=>$fly_tax1amount,"type"=>"Tax 1","order_sort"=>6,"type_key"=>3);                                                              //else  $pc_xwt = 111;
			  if( $txcalcs[2] > 0) $result[] =  array("name"=>"Tax 2","ratio"=> ($taxrate[$taxgroup_details->taxgroup_tax2] != "" ? $taxrate[$taxgroup_details->taxgroup_tax2] : $taxrate[$taxgroup_details->taxgroup_tax1]),"ser_id"=>  ($taxgroup_details->taxgroup_tax2 != "" ? $taxgroup_details->taxgroup_tax2 : $taxgroup_details->taxgroup_tax1 ) ,"desc"=>($taxname[$taxgroup_details->taxgroup_tax2] != "" ? $taxname[$taxgroup_details->taxgroup_tax2] : $taxname[$taxgroup_details->taxgroup_tax1]  ),"price"=>$fly_tax2amount,"type"=>"Tax 2","order_sort"=>7,"type_key"=>4);                                                              //else  $pc_xwt = 111;
			  if( $txcalcs[3] > 0) $result[] =  array("name"=>"Tax 1","ratio"=> $taxrate[$taxgroup_details->taxgroup_tax1] ,"ser_id"=> $taxgroup_details->taxgroup_tax1 ,"desc"=>$taxname[$taxgroup_details->taxgroup_tax1],"price"=>$fly_tax3amount,"type"=>"Tax 1","order_sort"=>8,"type_key"=>3);                                                              //else  $pc_xwt = 111;
			  if( $txcalcs[4] > 0) $result[] =  array("name"=>"Tax 2","ratio"=> $taxrate[$taxgroup_details->taxgroup_tax2]  ,"ser_id"=> $taxgroup_details->taxgroup_tax2 ,"desc"=>$taxname[$taxgroup_details->taxgroup_tax2],"price"=>$fly_tax4amount,"type"=>"Tax 2","order_sort"=>9,"type_key"=>4);                                                              //else  $pc_xwt = 111;
			  if( $txcalcs[0] > 0) $result[] =  array("name"=>"Fsc Rate","ratio"=> $fly_fsrate/100 ,"desc"=>"FSC (".$fly_fsrate.") %","price"=>$fly_fsamount,"type"=>"Fs Rate","order_sort"=> 10,"type_key"=>5);                                                              //else  $pc_xwt = 111;
			 
			  return $result;
			  

	}

	function cal_delivery_price($order,$client,$pieces,$billable_weight){
		global $c_setting,$package,$orders;

		$account_id = $client['account_id'];
		$order_id = $order['order_id'];
		$pieces_typeno = $order['packagetype'];
		$packtype = $package->get_packages($pieces_typeno);
		$base_weight = $c_setting["base_charge_weight"];
		if($client['base_charge_weight'] != '')	$base_weight = $client['base_charge_weight'];
		if($base_weight == '') $base_weight = 0;


		$s = mysqli_query($this->db,"select 
		case when
		 (select id FROM weight_price_base where service_type = '$pieces_typeno' and client_id = '$account_id' order by id asc limit 1 ) <> '' then 'C'
		 when
		 (select id FROM weight_price_base where service_type = '0' and client_id = '$account_id' order by id asc limit 1 )  <> '' then '0'
		  when
		 (select id FROM weight_price_base where service_type = '$pieces_typeno' and client_id = '0' order by id asc limit 1 )  <> '' then 'S'
		else
		 '0'
		end as res") or die(mysqli_error($this->db));
		$l = mysqli_fetch_assoc($s);
		if($l['res'] != '0') {
		 $ptn = $pieces_typeno;
		}else{
		 $ptn = '0';
		}
		mysqli_free_result($this->db);
	 


	$de = "";
	$de = $this->get_delivery_fees($order['from_zone'],$order['to_zone']);
	
	if($packtype->no_package_details == "0"  && isset($de->id) ){
	
	  $qq = mysqli_query($this->db,'CALL get_new_price('.$de->id.','.$billable_weight.','.$ptn.','.$base_weight.','.$account_id.',1); ') 
	  or die (mysqli_error($this->db).'CALL get_new_price('.$de->id.','.$billable_weight.','.$ptn.','.$base_weight.','.$account_id.',1);');
	  $r = mysqli_fetch_array($qq);
	  
	  if(isset($r['error'])) $errormsg = $r['error'].'CALL get_new_price('.$de->id.','.$billable_weight.','.$ptn.','.$base_weight.','.$account_id.',1); ';
	  else $dprice = $r[0];



	  while(mysqli_next_result($this->db));
	  mysqli_free_result($this->db);

	//  mysqli_free_result($this->db);
	  

	}else if(isset($de->id)){
	
	  $dprice = 0;
	  $noofpieces = $pieces;

	  $order_packages = $orders->get_order_package($order_id);
	
	
	  for ($h=0; $h <count($order_packages); $h++){
	
		$calc_weight = 0;
		$weight_volume = $order_packages[$h]['volume'] / $c_setting['weight_volume'];
		if($weight_volume > $order_packages[$h]['weight']) $calc_weight = $weight_volume;
		else $calc_weight = $order_packages[$h]['weight'];
	
		$qq = mysqli_query($this->db,'CALL get_new_price('.$de->id.','.$calc_weight.','.$ptn.','.$base_weight.','.$account_id.','.$order_packages[$h]['parts'].');') 
    		or die ('CALL get_new_price('.$de->id.','.$calc_weight.','.$ptn.','.$base_weight.','.$account_id.','.$order_packages[$h]['parts'].');by parts'.mysqli_error($this->db));
		  $rr = mysqli_fetch_array($qq);
		  if(isset($rr['error'])) $newerrormsg = $rr['error'];
		  else $dprice += $rr[0];
		  while(mysqli_next_result($this->db));

		  mysqli_free_result($this->db);

	   }
	}	
		
	$pc_del = round($dprice  ,2);
	$des = "Delivery Price ";

	//echo "ahmed";
	return array("name"=>"delivery_price","desc"=>$des,"price"=>$pc_del,"type"=>"delivery_price","order_sort"=>1,"type_key"=>2);                                                             
	}


	function get_delivery_fees($from_city,$to_City){
		$query = mysqli_query($this->db,"SELECT * FROM deliveryfees where 
		zonefrom = (select id from service_stops where zone = ".check_mysql_string($this->db,$from_city)." ) and 
		zoneto = (select id from service_stops where zone = ".check_mysql_string($this->db,$to_City)." );") or die(mysqli_error($this->db));
		if($query && mysqli_num_rows($query) == "1") return mysqli_fetch_object($query);
		else false;
	}


	function update_package($jsonObj){

		$pac = mysqli_query($this->db,"select * from orders_package where id = '".$jsonObj['package_id']."' ") or die (mysqli_error($this->db));
		$row = mysqli_fetch_assoc($pac);
		///check if their is change 
		if($jsonObj['weight'] != $row['weight'] || $jsonObj['height'] != $row['height'] || $jsonObj['width'] != $row['width']  || $jsonObj['length'] != $row['length']  ){

			$parent_id = $jsonObj['package_id'];
			$parts = 1;

		   $q = mysqli_query($this->db,"update orders_package set parts = parts - 1  where parent_id = '".$row['parent_id']."' ") or die (mysqli_error($this->db));

		}else{

			$parent_id = $row['parent_id'];
			$parts = $row['parts'];

		}

		mysqli_query($this->db,"update orders_package set weight = '".$jsonObj['weight']."' , volume = '".($jsonObj['height'] * $jsonObj['width'] * $jsonObj['length'])."'  , 
		height = '".$jsonObj['height']."'  , width = '".$jsonObj['width']."'  , 
		length = '".$jsonObj['length']."' , parent_id = '".$jsonObj['package_id']."'  , parts = '1' 
		where id = '".$jsonObj['package_id']."' ") or die (mysqli_error($this->db));


	}

	function check_has_hub($order_id){
		$num = 0;
		$q = mysqli_query($this->db,"select * from busses_loads where order_id = '".$order_id."' and hub_id != '0'  ") or die (mysqli_error($this->db));

		$num = mysqli_num_rows($q);

		if($num > 0) return true;
		else return false;


	}


	function order_status_change($order_id,$status,$driver_id){
		
		global $c_setting;

		$query = mysqli_query($this->db,"select orders.order_id,orders.driver_id,orders.account_id,orders.order_status,services.service_id,services.service_email from orders 
		inner join services on (services.service_id = orders.service_id)  where order_id = '".$order_id."' ") or die(mysqli_error($this->db));
	
	
		if(mysqli_num_rows($query) == "1"){
			
			$data = mysqli_fetch_array($query);
			
		
				
				mysqli_query($this->db,"insert into order_assign (order_id,driver_id,status,action_type,action_time) values('".$order_id."','".$driver_id."','".$status."','L','".date("Y-m-d H:i:s")."') ; ") 
				or die (mysqli_error($this->db));
				mysqli_query($this->db,"update orders set order_status = '".$status."'  where order_id = '".$order_id."' ") or die(mysqli_error($this->db)) ;
				
				switch ($status){
					case "1":
						
							
							if($data['service_email'] == "Y"){
							
								$this->send_email("Dispatced_email",$data,"account");
							//	echo "ahmed";
							}
							
						
					break;

					case "2":
					if($c_setting['allow_sms_cexpress'] == 'Y'){
						$con =   mysqli_connect(HOSTNAME,DBUSER,DBPASS,DBNAME) or die("error in connection");
						
						$qq = mysqli_query($con,'CALL completesms('.$order_id.')') or die (mysqli_error($con));
							mysqli_free_result($qq);
							mysqli_close($con);
						
					}

					break;
						
					case "3":
// 						if($data['service_email'] == "Y"){
						
// 						send_email("Dispatced_email",$data,"account");
// 						}
					break;
							
					case "4":
					break;
								
					case "5":
					break;
				}
				
			
			
		}
	}
	
	
	function send_email($email_name,$data,$send_to){
		global $c_setting;
		
		$serClass = new services($this->db);
		//$services = new services($this->db);
		$orderClass = new orders($this->db);
		$comClass = new company($this->db);
		$conClass = new contacts($this->db);
		
		$order_id = $data['order_id'];
		$m_details = $orderClass->get_order_waybill($order_id);
		$m_d['@order_id'] = $order_id;
		$m_d['@service_name'] = $m_details->service_name;
		$m_d['@pickup_name'] = $m_details->from_name;
		$m_d['@pickup_address'] = $m_details->from_address;
		$m_d['@pickup_zip'] = $m_details->from_pcode;
		$m_d['@pickup_phone'] = $m_details->from_phone;
		$m_d['@deliver_name'] = $m_details->to_name;
		$m_d['@deliver_address'] = $m_details->to_address;
		$m_d['@deliver_zip'] = $m_details->to_pcode;
		$m_d['@deliver_phone'] = $m_details->to_phone;
		$m_d['@order_des'] = $m_details->order_des;
		$m_d['@vechile'] = $m_details->vehicle;
		$m_d['@name'] = $m_details->user_name;
		$m_d['@skid'] = $m_details->pieces;
		$m_d['@pickup_by'] = time_req($m_details->pickup_by);
		$m_d['@deliver_by'] = time_req($m_details->deliver_by);
		$m_d['@company_name'] = SITENAME;
		$m_d['@account_company'] = $m_details->account_company;
		$m_d['@delivery_date'] = date("M.d.y",strtotime($m_details->delivery_date));
		$m_d['@delivery_time'] = date("h:iA",strtotime($m_details->delivery_time));
		$m_d['@pickup_date'] = date("M.d.y",strtotime($m_details->pickup_date));
		$m_d['@pickup_time'] = date("h:iA",strtotime($m_details->pickup_time));
		$m_d['@order_date']= date("l jS \of F Y h:i:s A",strtotime($m_details->order_date));
		$m_d['@driver_name'] = $m_details->name;
		
		$order_details = $m_details;
// 		$services = $serClass->get_services();
		
// 		$order_addtional = $orderClass->get_addtional_services($order_id);
		
// 		$m_d['@waybill'] = template_waybill_return();
		
		
		$message_details = $comClass->get_message_details($email_name,$m_d);
			
		if($send_to == "account"){
			
			$cont = $conClass->get_account_contact($data['account_id']);
				
			//var_dump($cont);
				
			for ($c=0;$c<count($cont);$c++){
					
				if ($cont[$c]['email_notify'] == 1 && $cont[$c]['email'] != '' ) {
					mymail($cont[$c]['email'], $c_setting['co_main_email'], $message_details['subject'],$message_details['body']  ,$smtp);
						
					$mes['event']     = "Dispatche";
					$mes['sentfrom']  = "clientorder-administrator";
					$mes['acctno']    = $clinet['account_name'];
					$mes["mailto"]    =  $cont[$c]['email'];
					$mes["mailfrom"]  = $c_setting['co_main_email'];
					$mes["subject"]   = $message_details['subject'];
					$mes["body"]      = $message_details['body'];
					$mes["sentfrom"]  = '';
					$mes["orderid"]   = $order_id;
					log_email($mes);
				}
					
			}
			
		}
		
		
	}



	//	This function is developed to add order in one shoot with all cases 

	function add_order($order,$type){
	
		global $c_setting;
		
		////include
		$transport = new transport($this->db);
		$package = new package($this->db);
		$orderClass = new orders($this->db);
		////Fix some varibale 
		
		if (!isset($order['weight']) || $order['weight'] == "" || $order['weight'] < 0)  $order['weight'] = 0;
		if (!isset($order['volume']) || $order['volume'] == "" || $order['volume'] < 0)  $order['volume'] = 0;
		if (!isset($order['pieces']) || $order['pieces'] == "" || $order['pieces'] < 0)  $order['pieces'] = 1;
		
		////check vec/////
		$vechile_id = '' ;

		if(isset($order['transport_type'])){
		///get Vechile details for this order
		$req_vehicle = $order['transport_type'];
		
		}else{
			$req_vehicle = 'Any';			
		}
		
		if  ($req_vehicle != 'Any' ){
			$vechile_id = $req_vehicle;
			$use_vehicle = $req_vehicle;
		}else{
			
			$vv = $transport->get_standard_vechile($order['service_id'],$order['weight'],$order['volume']);
			
			$vechile_id = $vv['transport_id'];
			$use_vehicle = $vv['transport_id'];
		}
		//echo $vechile_id;
		$vec_details = $transport->get_vechile_details($vechile_id);
		
		
		///check package///

		//check driver////

		///check price////
		$quotes_control = 1;

		$acctno        = $order['account_id'];
		$returnto      = "adminorder";
		$return        = yesno($order['return']);
		$service       = $order['service_id'];
		$from_pc       = $order['from_pcode'];
		$from_zone     = $order['from_zone'];
		$to_pc         = $order['to_pcode'];
		$to_zone       = $order['to_zone'];
		$req_vehicle   = $vechile_id;
		$weight        = $order['weight'];
		$volume        = $order['volume'];
		$pieces        = $order['pieces'];


		$pieces_typeno = $order['package_type_s'];

		if(isset($order['package_name'])){
			$piecestype = $order['package_name'];
		}else{

		$packtype = $package->get_packages($pieces_typeno);
		$piecestype = $packtype->package_name;
		}
		
		if(isset($order['add_services'])) $add_services  = array_flip($_POST['add_services']);
		if(isset($order['vec_services'])) $vec_services  = array_flip($_POST['vec_services']);
		$service = $order['service_id'];
		
		$calc_distance = trim($order['meters']);
		
		//Pickup & Deliver times, for tod adjustments.
		//Rule: price adjust does this on requested times, if entered, then actual P/D times.
		//     (we don't do requested times here.     for now, anyway.)
		//Note: we can pass the 24hr-time & keep the ampm var empty & it won't mess with it.
		$pic = explode(' ',$order['pickup_time']);
		$dev = explode(' ',$order['delivery_time']);
		$pickup_ampm   = $pic[1];
		$pickup_time   = $pic[0];
		$deliver_ampm  = $dev[1];
		$deliver_time  = $dev[0];
		//
		$pod           = $order['pod'];                       //***in case - ***trace***
		//
		//echo "ahmed";
		if ($quotes_control > 1)  {
			//echo "ahmed";
			$errormsg = "";
			//global $result;
		if($c_setting['company_skid'] == "1") include "../includes/pricecalcskid.php";
		else 	include "../includes/pricecalc.php";
		
		//var_dump($result);
			if ($errormsg == "")  {
	
			}
			else
			{
				$errormsg = str_replace("<br>",",",$errormsg);
				$rowwarnings .= " unable to calculate price:$errormsg,";
			}
		
		}


		//var_dump($result);

		/////add order////

		$o = array();
		$o['has_package'] = $has_package;
		$o['ret'] = $return;
		$o['COD'] = $cods;
		$o['pod'] = $order['pod'];
        $o['pop'] = $order['pop'];
		$o['collect'] = $order['collect'];
		
		if(isset($order['driver_id'])) $o['driver_id'] = $order['driver_id'];
		if(isset($order['driver_id2'])) $o['driver_id2'] = $order['driver_id2'];
		
        $o['account_id'] = $order['account_id'];
        $o['user_id'] = $order['user_id'];
        $o['order_status'] = 1;
        $o['from_name'] = $order['from_name'];
        $o['from_address'] = $order['from_address'];
        $o['from_pcode'] = $order['from_pcode'];
        $o['from_phone'] = $order['from_phone'];
        $o['from_altphone'] = $order['from_altphone'];
        $o['to_altphone'] = $order['to_altphone'];
        $o['to_name'] = $order['to_name'];
        $o['to_address'] = $order['to_address'];
        $o['to_pcode'] = $order['to_pcode'];
        $o['to_phone'] = $order['to_phone'];
        $o['pickup_time'] = date("H:i:s", strtotime($order["pickup_time"]));
        $o['pickup_date'] = $order['pickup_date'];
       if(isset($order["delivery_time"])) $o['delivery_time'] = date("H:i:s", strtotime($order["delivery_time"]));
        $o['delivery_date'] = $order['delivery_date'];
        $o['service_id'] = $order['service_id'];
        $o['order_comment'] = $order['comment'];
        $o['order_des'] = $order['description'];
        $o['chargecode'] = $order['refrence'];
        $o['price'] = 0;
        $o['confirmation_mail'] = $order['confirmation_email'];
        $o['transport_id'] = $vechile_id;
		$o['order_date'] = date("Y-m-d H:i:s");
		$o['from_zone'] = $puzone;
		$o['to_zone'] = $delzone;
		$o['from_contact'] = $order['from_contact'];
		$o['to_att'] = $order['to_contact'];
		$o['declared_value'] = $order['declared_value'];
		$o['orderedby'] = $order['orderby'];
		$o['paymentterm'] = $order['payment_type_s'];
		$o['packagetype'] = $order['package_type_s'];
		$o['weight'] = $order['weight'];
		$o['volume'] = $order['volume'];
		$o['pieces'] = $order['pieces'];
		$o['pickup_by'] = $order['pickup_by'];
		$o['deliver_by'] = $order['deliver_by'];
		$o['quoted_distance'] = $order['meters'];
		$o['from_partno'] = $_POST['from_partno'];
		$o['to_partno'] = $_POST['to_partno'];
	//	if(isset($order['group_id'])) $o['group_id'] = 
		$o['enteredby'] = "A|".$_SESSION['name']."|Imported File";
		
		if(isset($order['group_id'])) $o['group_id'] = $order['group_id'];
		
		////adding order
		$order_id = $orderClass->add_new_orders($o);
		//echo count($result);


		////add order price /////

		if(is_array($result) && count($result) > 0) {
			//echo "ahmed";
			for($i=0;$i<count($result);$i++){
				$orderClass->add_order_price($order_id,$result[$i]['name'],'',$result[$i]['price'],$result[$i]['type'],$result[$i]['ser_id'],$result[$i]['override']);
				$total += $result[$i]['price'];
			}
			//echo "ahmed".$client['account_id'];
			$taxgroup = $account->get_account_taxgroup($client['account_id']);
			$tp_tax =  $price->get_tax_price($taxgroup,$order_id);
		//	echo $taxgroup;
			$fsrate =  $price->get_fsrate($taxgroup,$vechile_id,$client['account_id']);
			//echo $fsrate;
			
			$fuelsurcharge = sprintf("%01.2f",$tp_tax * $fsrate / 100);
			
			if ($fsrate != "") $result[] = $orderClass->add_order_price($order_id,"fsrate",$fsrate,$fuelsurcharge,"fsrate");
			
				
				
				
			$orderClass->add_order_price($order_id,"Total",'',$total,'total','','');
			$p['price'] = $total;
			$orderClass->update_orders($p, $order_id);
				
		}


		//// add order package////


		////cal driver price 

		/// add driver pricing 

		//send email (tracking,admin,client,drivers)

		//send notification 



	}



	function change_order_driver($orders_id,$old_driver_id,$new_driver_id){

		global $c_setting,$smtp;
		///Class Declation
		$driverClass = new driver($this->db);
		$orderClass = new orders($this->db);
		$serClass = new services($this->db);
		$companyClass = new company($this->db);
		$priceClass = new price($this->db);
		$accountClass = new account($this->db);

		//$services = $serClass;

		$orders_id = substr($orders_id,0,strlen($orders_id)-1);

		$q = mysqli_query($this->db,"select * from orders where order_id in (".$orders_id.") ") or die (mysqli_error($this->db));

		while($row = mysqli_fetch_array($q)){

			if($row['driver_id'] == $old_driver_id ){

				$o['driver_id'] = $new_driver_id;
			}
			if($row['driver_id2'] == $old_driver_id ){
				
				$o['driver_id2'] = $new_driver_id;
			}

			$o['last_update_time'] = date("Y-m-d H:i:s");


			$orderClass->update_orders($o,$row['order_id']);

			$driv = $driverClass->get_driver_by_id($new_driver_id);
			
			$old_driver = $driverClass->get_driver_by_id($old_driver_id);
			
			$m_details = $orderClass->get_order_waybill($row['order_id']);
			$m_d['@order_id'] = $row['order_id'];
			$m_d['@service_name'] = $m_details->service_name;
			$m_d['@pickup_name'] = $m_details->from_name;
			$m_d['@pickup_address'] = $m_details->from_address;
			$m_d['@pickup_zip'] = $m_details->from_pcode;
			$m_d['@pickup_phone'] = $m_details->from_phone;
			$m_d['@pickup_date'] = $m_details->pickup_date;
			$m_d['@pickup_time'] = date('h:i A', strtotime($m_details->pickup_time));
			$m_d['@deliver_name'] = $m_details->to_name;
			$m_d['@deliver_address'] = $m_details->to_address;
			$m_d['@deliver_zip'] = $m_details->to_pcode;
			$m_d['@deliver_phone'] = $m_details->to_phone;
			$m_d['@delivery_date'] = $m_details->delivery_date;
			$m_d['@delivery_time'] = date('h:i A', strtotime($m_details->delivery_time));
			$m_d['@order_des'] = $m_details->order_des;
			$m_d['@vechile'] = $m_details->vehicle;
			$m_d['@name'] = $m_details->user_name;
			$m_d['@access_link'] = SITEURL.'/pord.php?id='.$row['order_id'].'&dr='.$new_driver_id;
			$m_d['@skid'] = $m_details->pieces;
			$m_d['@pickup_by'] = time_req($m_details->pickup_by);
			$m_d['@deliver_by'] = time_req($m_details->deliver_by);
			$m_d['@driver_name'] = $m_details->name;
			
			$order_details = $m_details;
			$order_addtional = $orderClass->get_addtional_services($row['order_id']);			
			$services = $serClass->get_services();

			//var_dump($services);

		//	$m_d['@waybill'] = template_waybill_return();

			
			$message_details = $companyClass->get_message_details("Driver_new_order",$m_d);
			
			mymail($driv->notify_email, $c_setting['co_main_email'], $message_details['subject'],$message_details['body']  ,$smtp);
			$mes['event']     = "Assign-to-driver";
			$mes['sentfrom']  = "dispatche";
			$mes['acctno']    = $m_details->account_name;
			$mes["mailto"]    = $driv->notify_email;
			$mes["mailfrom"]  = $c_setting['co_main_email'];
			$mes["subject"]   = $message_details['subject'];
			$mes["body"]      = $message_details['body'];
			$mes["sentto"]    = "driver-notify-email";
			$mes["orderid"]   = $row['order_id'];
			$mes["driver"]   = $driv->id;
			log_email($mes);
			
			$push_message = array( 'message' => '{"req": "new_order","orders": ["'.$row['order_id'].'"]}');
			$push_message = array( 'message' => '{"req": "reassign_order","orders": ["'.$_POST['order_id'].'"]}');
			
			if($driv->pushkey != '' && $driv->os == 'A') sendGoogleCloudMessage($push_message,array($driv->pushkey),$c_setting['google_api'],"Order Reassigned");
		
			if($driv->pushkey != '' && $driv->os == 'I'  ){
			$push_message['alert'] = "New order from courier connex app";
				sendIphoneCloudMessage($push_message,$driv->pushkey ,"");
			}
			
			if(isset($old_driver->id) && $old_driver->id != ''){
				
				$push_message = array( 'message' => '{"req": "cancel_order","orders": ["'.$row['order_id'].'"]}');
				if($old_driver->pushkey != '' && $old_driver->os == 'A') sendGoogleCloudMessage($push_message,array($driv->pushkey),$c_setting['google_api'],"Order no ".$row['order_id']."has been canceled");
				if($old_driver->pushkey != '' && $old_driver->os == 'I'  ){
					$push_message['alert'] = "Order No. ".$row['order_id']." have been removed";
					sendIphoneCloudMessage($push_message,$old_driver->pushkey ,"");
				}
				
			$message_details = $companyClass->get_message_details("order_redispatche",$m_d);
			mymail($old_driver->notify_email, $c_setting['co_main_email'], $message_details['subject'],$message_details['body']  ,$smtp);
			$mes['event']     = "redispatche_order";
			$mes['sentfrom']  = "dispatche";
			$mes['acctno']    = $m_details->account_name;
			$mes["mailto"]    = $old_driver->notify_email;
			$mes["mailfrom"]  = $c_setting['co_main_email'];
			$mes["subject"]   = $message_details['subject'];
			$mes["body"]      = $message_details['body'];
			$mes["sentto"]    = "driver-notify-email";
			$mes["orderid"]   = $row['order_id'];
			$mes["driver"]   = $old_driver->id;
			log_email($mes);
			}


			$new = mysqli_query($this->db,"select * from orders where order_id = '".$row['order_id']."' ");
			$newrow = mysqli_fetch_array($new);

			if( ($newrow['driver_id'] != '0'  || $newrow['driver_id2'] != '0'  )  && $newrow['price'] > "0"){
				
			
				if( $newrow['driver_id2'] != "0" ){
					$drcom[1] = $newrow['driver_id'];
					$drcom[2] = $newrow['driver_id2'];
				 }else{
					 $drcom = $newrow['driver_id'];
				 }
				 
			
				 $driverClass->cal_driver_commision($row['order_id'],$drcom,$newrow['service_id'],$newrow['transport_id'],$newrow,$priceClass,$accountClass);
			
				
			}else if($newrow['price'] == "0" or $newrow['price'] == ""){
				mysqli_query($this->db,"delete from orders_driver_commission where order_id = '".$newrow['order_id']."'  ") or die (mysqli_error($this->db));
			}

			
			$result = "Order ".$newrow['order_id']." driver updated";

		}

		return $result;
		
	}


	function bulid_mobile_notifcation($case,$data){

		global $c_setting;

		//check if pushkey and os found send notifcation directly else get this details;
		if(isset($data['pushkey']) && $data['pushkey'] != '' && isset($data['os']) &&  $data['os'] != '' ){

			$pushkey = $data['pushkey'];
			$os = $data['os'];

		}else{

			if(isset($data['driver_id']) && $data['driver_id'] != '' ){

				$driverQuery  = $this->db->get_query_assoc("select id,pushkey,os from drivers where id = '".$data['driver_id']."' ");
			    $pushkey = $driverQuery['pushkey'];
			    $os = $driverQuery['os'];


			}else{
				$arr['error'] = "1";
				$arr['msg'] = "No driver value cannot send notifcation";
				return json_encode($arr);
			}

		}


		switch($case){

			case 'request_image':

			$Notifydata = array( 'message' => '{"req": "signature","order_id":"'.$data['order_id'].'"}'   );
		
		
		//var_dump($data);
		if($pushkey != '' && $os == "A" ) {
			$ids = array($pushkey);
			 echo sendGoogleCloudMessage($Notifydata,$ids , $c_setting['google_api']);
		}
		if($pushkey != '' && $os == "I"){
			$data['alert'] = "Request Signature For order : ".$data['order_id'];
			//$data['silent'] = "1";
			echo sendIphoneCloudMessage($Notifydata,$pushkey,"");		
		}

			break;
		}


	}



	function build_route($order_id,$group_id = ""){


		$cond = "";
		if($group_id != ''){
			// $qu = mysqli_query($this->db,"select order_id from orders where group_id = '$group_id'  order by order_id desc limit 1 ");
			// $r = mysqli_fetch_assoc($qu);

			// $morder_id = $r['order_id'];

			$query = mysqli_query($this->db,"SELECT group_route.*,
			group_route.start as from_city_id,
			group_route.end as to_city_id, 
			inventory.name as hub_name, 
			group_route.date_loaded,
			drivers.name as loaded_by,
			(select zone from service_stops where service_stops.id = group_route.start ) as from_city,
			(select zone from service_stops where service_stops.id = group_route.end ) as to_city,
			busses.vehicle_name,
			busses.main_bus_id,busses.id as bid
			FROM group_route 
			left join busses on (busses.id = group_route.busses_id) 
			left join inventory on (inventory.id = group_route.hub_id) 
			left join drivers on (drivers.id = group_route.loaded_by)
			where
			(group_route.busses_id != 0 || group_route.hub_id != 0) and  
			 group_route.group_id = '$group_id' order by id ") or die (mysqli_error($this->db));


		}else{

			$order_id = $order_id;

			$query = mysqli_query($this->db,"SELECT busses_loads.*,
			busses_loads.start as from_city_id,
			busses_loads.end as to_city_id, 
			inventory.name as hub_name, 
			busses_loads.date_loaded,
			drivers.name as loaded_by,
			(select zone from service_stops where service_stops.id = busses_loads.start ) as from_city,
			(select zone from service_stops where service_stops.id = busses_loads.end ) as to_city,
			busses.vehicle_name,
			busses.main_bus_id,busses.id as bid
			FROM busses_loads 
			left join busses on (busses.id = busses_loads.busses_id) 
			left join inventory on (inventory.id = busses_loads.hub_id) 
			left join drivers on (drivers.id = busses_loads.loaded_by)
			where order_id = '$order_id' order by id ") or die (mysqli_error($this->db));
	
		}


		//$result = build_array($query);

		$result = array();
		while($row = mysqli_fetch_assoc($query)){

			if($order_id != '' ){

				if($row['hub_id'] == 0) {

					$scount = "select count(*) from orders_package_track where 
				(order_id = '$order_id'  ) and ( bus_id = '".$row["busses_id"]."' ) group by package_id ";	
			
				}else{

					$scount = "select count(*) from orders_package_track where 
				(order_id = '$order_id'  ) and (hub_id = '".$row['hub_id']."'  ) group by package_id ";	
			
				}

				}else{
				$scount = "select count(*) from orders_package_track where 
				(group_id = '$group_id'  ) and (hub_id = ".$row['hub_id']." or bus_id = ".$row["busses_id"]." ) group by package_id ";	

			}
		
			// if($group_id != ''){
			// 	$scount = "select count(*) from orders_package_track where 
			// 	(group_id = '$group_id'  ) and (hub_id = ".$row['hub_id']." or bus_id = ".$row["busses_id"]." ) group by package_id ";	
			// }else if($row['busses_id'] == '17'  || $row['busses_id'] == '16' ){
			// 	$scount = "select count(*) from orders_package_track where 
			// 	(order_id = '$order_id'  ) and ( bus_id = ".$row["busses_id"]." ) group by package_id ";	
			// }else{
			// 	$scount = "select count(*) from orders_package_track where 
			// 	(order_id = '$order_id'  ) and (hub_id = ".$row['hub_id']." or bus_id = ".$row["busses_id"]." ) group by package_id ";	
			// }

			$pcount = 0;
			$mm = mysqli_query($this->db,$scount) or die (mysqli_error($this->db));

			$pcount = mysqli_num_rows($mm);

			$row['pcount'] = $pcount;


			$sql = "select * from busses where (busses.start = '".$row['from_city_id']."' and busses.end = '".$row['to_city_id']."') or (busses.end = '".$row['from_city_id']."' and busses.start = '".$row['to_city_id']."')  ";
			$q = mysqli_query($this->db,$sql) or die(mysqli_error($this->db));

			if($row['hub_id'] == "0"){
				$row['transport'] =  build_array($q);
			}

			$result[] = $row ;
		}

		return $result;
	}


	function get_busses($data = array()){

		$query = mysqli_query($this->db,"select * from busses order by bus_name") or die (mysqli_error($this->db)); 
        $busses=array();
        
        while ($row = mysqli_fetch_assoc($query)) {
			$busses[]=$row;			
			
		};
		
		return $busses;
		
	}

	function get_cities($data = array()){

		$query = mysqli_query($this->db,"select * from service_stops order by zone") or die (mysqli_error($this->db));

		$result = build_array($query);

		return $result;
	}


	function get_price_report($data){

		$query = mysqli_query($this->db,"select 
		(select zone from service_stops where service_stops.id = deliveryfees.zonefrom) as from_city,
		(select zone from service_stops where service_stops.id = deliveryfees.zoneto) as to_city,
		(case when (select package_name from package_type where package_id = weight_price_base.service_type )  is null then 'Default' else (select package_name from package_type where package_id = weight_price_base.service_type )  end) as package_type ,
		weight_price_base.min_lb,
		weight_price_base.max_lb,
		weight_price_base.base_price,
		weight_price_base.increment 
		from weight_price_base 
		inner join deliveryfees on (deliveryfees.id = weight_price_base.zone ) where weight_price_base.Client_id = '0'
		order by deliveryfees.zonefrom,deliveryfees.zoneto,weight_price_base.id") or die ();

		$result = build_array($query);

		return $result;



	}

	function get_hub($hub_id){

		$q = mysqli_query($this->db,"select * from inventory where id = '$hub_id'  ") or die (mysqli_error($this->db));

		$row = mysqli_fetch_assoc($q);

		return $row;

	}


	function check_last_hub($group_id,$hub_id){
 
		$query = mysqli_query($this->db,"select * from busses_loads where group_id = '$group_id' and hub_id = '$hub_id' limit 1 ") or die (mysqli_error($this->db));
		$row = mysqli_fetch_array($query);

		$q = mysqli_query($this->db,"select * from busses_loads where id > '".$row['id']."' and order_id = '".$row['order_id']."' and hub_id > 0  and  group_id = '$group_id'  ") or die (mysqli_error($this->db));

		//return mysqli_num_rows($q);

		if(mysqli_num_rows($q) > 0 ){
			return false;
		}else{
			return true;
		}
	}


	function get_combo_box($name){
		$query = mysqli_query($this->db,"select * from lookup_addtional where type = '$name' ") or die (mysqli_error($this->db));
		$result = array();
		while($row = mysqli_fetch_assoc($query)){
			$result[] = $row;
		}
		return $result;
	}


	function get_addtional_list($byid = ""){
		$query = mysqli_query($this->db,"select * from third_party ") or die (mysqli_error($this->db));
		$result = array();
		while($row = mysqli_fetch_assoc($query)){
			if($byid == "" ) $result[] = $row;
			if($byid == "1") $result[$row['id']] = $row;

		}
		return $result;
	}

	function get_Credit($data){

		$query = mysqli_query($this->db,"select credit_note.*,users.user_name,account.account_name,account.account_company from credit_note
		inner join account on (account.account_id = credit_note.account_id ) 
		inner join users on (users.user_id = credit_note.user_id ) order by credit_note.id desc ") or die (mysqli_error($this->db));
	
		$result = array();
		while($row = mysqli_fetch_assoc($query)){
			$result[] = $row;
		}
		return $result;

	}

	function get_credit_id($id){
		$query = mysqli_query($this->db,"select credit_note.*,users.user_name,account.account_name,account.account_company from credit_note
		inner join account on (account.account_id = credit_note.account_id ) 
		inner join users on (users.user_id = credit_note.user_id )  where  id = '$id' ") or die (mysqli_error($this->db));

		$result = mysqli_fetch_object($query);

		return $result;

	}

	function check_accountinvoice($account_id,$invoice_id){

		$num = 0;
		$query = mysqli_query($this->db,"select * from invoicehdr where clid = '$account_id' and  id = '$invoice_id'  ") or die (mysqli_error($this->db));
		$num = mysqli_num_rows($query);

		if($num){
			return true;
		}else{
			return false;
		}

	}

	function get_invoice_order($invoice_id){
		$query = mysql_query("select * from orders where invoiceno = '$invoice_id'  ") or die (mysql_error());

		$result = array();

		while($row = mysql_fetch_assoc($query)){
			$result[] = $row;
		}

		return $result;

	}

	function get_order_files($order_id){

		$q = mysqli_query($this->db,"select * from orders_files where order_id = '$order_id' ") or die (mysqli_error($this->db));

		$result = array();

		while($row = mysqli_fetch_assoc($q)){
			$result[] = $row;
		}

		return $result;

	}


	function get_detail_driver($driver_id,$type){

		if($type == 'N'){
			$q = mysqli_query($this->db,"select name  from drivers where id = '$driver_id' ") or die (mysqli_error($this->db));
		}

		if($type == 'H'){
			$q = mysqli_query($this->db,"select inventory.name as name from drivers 
			inner join on (drivers.hub_id = inventory.id) where drivers.id = '$driver_id' ") or die (mysqli_error($this->db));
		}

		if($type == 'V'){
			$q = mysqli_query($this->db,"select busses.vehicle_name as name from drivers 
			inner join busses on (busses.id = drivers.vehicle_type) where drivers.id = '$driver_id' ") or die (mysqli_error($this->db));
		}

		$row = mysqli_fetch_assoc($q);
		return $row;

	}


	function get_driver_package_scan($order_id,$driver_id){
		$q = mysqli_query($this->db,"select * from orders_package_track  where app_id = '$driver_id' and order_id = '".$order_id."' order by action_time  ") or die (mysqli_error($this->db));
		$count = mysqli_num_rows($q);

		$r = mysqli_fetch_array($q);

		$arr['count'] = $count;
		$arr['date'] = $r['action_time'];

		return $arr;

	}
}
