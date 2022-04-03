<?php

class price
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }


    public function get_pac_status_pricelist($account_id, $version_id, $color_id, $glass_type)
    {
        $query = mysqli_query($this->db, "select * from package_status_price where 	account_id = '$account_id'  and version_id = '$version_id' and 
        item_colour = '$color_id' and Glass_type = '$glass_type'  ");

        // echo "select * from package_status_price where 	account_id = '$account_id'  and version_id = '$version_id' and
        // item_colour = '$color_id' and Glass_type = '$glass_type'  ";

        $price_list = array();
        while ($row = mysqli_fetch_array($query)) {
            $price_list[$row['package_id']][$row['status_id']] = $row['fee'];
        }
        return $price_list;
    }

    public function get_zones()
    {
        $sql = "";
        $query = mysqli_query($this->db, "select * from pricezones") or die(mysqli_error($this->db));

        $zone = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }
            $zone[] = $arr;
        }
        return $zone;
    }


    public function copy_service($data)
    {
        mysqli_query($this->db, "delete from deliveryfees where client_acctno = '' and svc = '" . $data['service_2'] . "' and chart = '" . $data['chart'] . "' ") or die(mysqli_error($this->db));

        $query = mysqli_query($this->db, "insert into deliveryfees (svc,zonefrom,zoneto,price,chart) 
			 (select " . $data['service_2'] . ",zonefrom,zoneto,price,chart from deliveryfees where svc = '" . $data['service_1'] . "' and chart = '" . $data['chart'] . "' and client_acctno = ''  ) ") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_zone($zone, $prefix, $postcode)
    {
        $query = mysqli_query($this->db, "delete from pricezones ") or die(mysqli_error($this->db));

        for ($i = 0; $i < count($zone); $i++) {
            if ($zone[$i] != "") {
                $query1 = mysqli_query($this->db, "insert into pricezones(zone,prefix,pcodes) values (" . check_mysql_string($this->db,strtoupper($zone[$i])) . "," . check_mysql_string($this->db,$prefix[$i]) . "," . check_mysql_string($this->db,strtoupper($postcode[$i])) . ")") or die(mysqli_error($this->db));
            }
        }

        $this->check_time_zone($zone);
        $this->check_pickup_zone($zone);
        $this->check_delivery_zone($zone);
        return true;
    }

    ///function to check if time zone is coorrect with new zones used in add zones
    public function check_time_zone($zone)
    {
        $zz = "";
        for ($i = 0; $i < count($zone); $i++) {
            if ($zone[$i] != "") {
                $query1 = mysqli_query($this->db, "select id from  todrates where zone = " . check_mysql_string($this->db,strtoupper($zone[$i])) . "") or die(mysqli_error($this->db));

                if (mysqli_num_rows($query1) == 0) {
                    $q = mysqli_query($this->db, "insert into todrates (zone) values(" . check_mysql_string($this->db,strtoupper($zone[$i])) . ")") or die(mysqli_error($this->db));
                    $id = mysqli_insert_id($this->db);
                    $zz .= $id . ',';
                } else {
                    $r = mysqli_fetch_array($query1);
                    $zz .= $r['id'] . ',';
                }
            }
        }
        if ($zz != "") {
            mysqli_query($this->db, "delete from todrates where id Not In (" . substr_replace($zz, " ", -1) . ")") or die(mysqli_error($this->db));
        }
    }


    /////check pickup fees

    public function check_pickup_zone($zone)
    {
        $zz = "";
        for ($i = 0; $i < count($zone); $i++) {
            $zz .= '\'' . $zone[$i] . '\',';
        }
        //echo $zz;
        if ($zz != "") {
            mysqli_query($this->db, "delete from pickupfees where zone Not In (" . substr_replace($zz, "", -1) . ")") or die(mysqli_error($this->db));
        }
    }


    ///function to check if time zone is coorrect with new zones used in add zones in deliver
    public function check_delivery_zone($zone)
    {
        $zz = "";
        for ($i = 0; $i < count($zone); $i++) {
            $zz .= '\'' . $zone[$i] . '\',';
        }
        //echo $zz;
        if ($zz != "") {
            mysqli_query($this->db, "delete from deliveryfees where zonefrom Not In (" . substr_replace($zz, "", -1) . "  )") or die("delete from deliver where zone Not In (" . substr_replace($zz, "", -1) . ")");

            mysqli_query($this->db, "delete from deliveryfees where zoneto Not In (" . substr_replace($zz, "", -1) . "  )") or die("delete from deliver where zone Not In (" . substr_replace($zz, "", -1) . ")");
        }
    }


    /*function edit_delivery_zone($zone,$kv,$service_id,$chart){

    foreach($kv as $key => $value){
    $k = $this->db->return_input_name($key);
    $ekv[$k] = $value;
    }
    $kv = $ekv;

    mysqli_query($this->db,"delete from deliveryfees where  svc = ".check_mysql_string($this->db,$service_id)." and chart = ".check_mysql_string($this->db,$chart)." ") or die (mysqli_error($this->db));

    for ($i=1;$i<count($zone)+1;$i++){
      for ($j=1;$j<count($zone)+1;$j++){

        $k = $zone[$i].'_'.$zone[$j];

        $kskid = "skid_".$zone[$i].'_'.$zone[$j];


        if (array_key_exists($k,$kv)){

        if ( $kv[$k] !=""  ||  $kv[$kskid] !=""  ){

        //mysqli_query($this->db,"insert into deliveryfees (svc,zonefrom,zoneto,price,skid_price,chart) values (".check_mysql_string($this->db,$service_id).",".check_mysql_string($this->db,$zone[$i]).",".check_mysql_string($this->db,$zone[$j]).",".check_mysql_string($this->db,$kv[$k]).",".check_mysql_string($this->db,$kv[$kskid]).",".check_mysql_string($this->db,$chart)." ); ") or die (mysqli_error($this->db));

            //mysqli_query($this->db,"insert into deliveryfees (svc,zonefrom,zoneto,price,chart) values (".check_mysql_string($this->db,$service_id).",".check_mysql_string($this->db,$zone[$i]).",".check_mysql_string($this->db,$zone[$j]).",".check_mysql_string($this->db,$kv[$k]).",".check_mysql_string($this->db,$chart)." ); ") or die (mysqli_error($this->db));

            mysqli_query($this->db,"insert into deliveryfees (svc,zonefrom,zoneto,price,skid_price,chart) values (".check_mysql_string($this->db,$service_id).",".check_mysql_string($this->db,$zone[$i]).",".check_mysql_string($this->db,$zone[$j]).",".check_mysql_string($this->db,$kv[$k]).",".check_mysql_string($this->db,$kv[$kskid]).",".check_mysql_string($this->db,$chart)." ); ") or die (mysqli_error($this->db));



        /*
        $query  =  mysqli_query($this->db,"select id from deliveryfees where zonefrom = ".check_mysql_string($this->db,$zone[$i])." and zoneto = ".check_mysql_string($this->db,$zone[$j])." and svc = ".check_mysql_string($this->db,$service_id)." and chart = ".check_mysql_string($this->db,$chart)." ") or die (mysqli_error($this->db));

            //echo "select id from deliveryfees where zonefrom = ".check_mysql_string($this->db,$zone[$i])." and zoneto = ".check_mysql_string($this->db,$zone[$j])." and svc = ".check_mysql_string($this->db,$service_id)." and chart = ".check_mysql_string($this->db,$chart)." ";



            if (mysqli_num_rows($query) == 0){
            mysqli_query($this->db,"insert into deliveryfees (svc,zonefrom,zoneto,price,chart) values (".check_mysql_string($this->db,$service_id).",".check_mysql_string($this->db,$zone[$i]).",".check_mysql_string($this->db,$zone[$j]).",".check_mysql_string($this->db,$kv[$k]).",".check_mysql_string($this->db,$chart)." ); ") or die (mysqli_error($this->db));
            }else{
            //echo 'ahmed';
            $r = mysqli_fetch_array($query);
            mysqli_query($this->db,"update deliveryfees set price = ".check_mysql_string($this->db,$kv[$k])." where id = '".$r['id']."' ") or die (mysqli_error($this->db));
            }

        }
        }

      }
    }

    return true;
    }
    */

    public function edit_delivery_zone($zone, $kv, $service_id, $chart)
    {
        foreach ($kv as $key => $value) {
            $k = $this->db->return_input_name($key);
            $ekv[$k] = $value;
        }
        $kv = $ekv;

        mysqli_query($this->db, "delete from deliveryfees where  svc = " . check_mysql_string($this->db,$service_id) . " and chart = " . check_mysql_string($this->db,$chart) . " ") or die(mysqli_error($this->db));

        for ($i = 1; $i < count($zone) + 1; $i++) {
            for ($j = 1; $j < count($zone) + 1; $j++) {
                $k = $zone[$i] . '_' . $zone[$j];

                $kskid = "skid_" . $zone[$i] . '_' . $zone[$j];


                if (array_key_exists($k, $kv)) {
                    if ($kv[$k] != "") {
                        mysqli_query($this->db, "insert into deliveryfees (svc,zonefrom,zoneto,price,chart,skid_price) values (" . check_mysql_string($this->db,$service_id) . "," . check_mysql_string($this->db,$zone[$i]) . "," . check_mysql_string($this->db,$zone[$j]) . "," . check_mysql_string($this->db,$kv[$k]) . "," . check_mysql_string($this->db,$chart) . "," . check_mysql_string($this->db,$kv[$kskid]) . " ); ") or die(mysqli_error($this->db));
                    }
                }
            }
        }

        return true;
    }

    public function edit_time_zones($zone, $times)
    {
        for ($i = 0; $i < count($zone); $i++) {
            $rates = $times[strtoupper($zone[$i]['zone'])];
            //  print_r($times);
            $ins = "";

            for ($j = 0; $j < count($rates); $j++) {
                if ($j < 10) {
                    $ins .= " rate0" . $j . " = " . check_mysql_string($this->db,$rates[$j]) . " ,";
                } else {
                    $ins .= " rate" . $j . " = " . check_mysql_string($this->db,$rates[$j]) . " ,";
                }
                //  echo "update todrates set ".substr_replace($ins,"",-1)." where zone = '".strtoupper($zone[$i]['zone'])."' ";
                if ($ins != "") {
                    mysqli_query($this->db, "update todrates set " . substr_replace($ins, "", -1) . " where zone = '" . strtoupper($zone[$i]['zone']) . "' ") or die("update todrates set " . substr_replace($ins, "", -1) . " where zone = '" . strtoupper($zone[$i]['zone']) . "' ");
                }
            }
        }
    }


    public function edit_pickup_vechils($values)
    {
        foreach ($values as $key => $value) {
            $k = $this->db->return_input_name($key);
            $ekv[$k] = $value;
        }
        $values = $ekv;


        foreach ($values as $key => $value) {
            $det = explode('_', $key);

            $query = mysqli_query($this->db, "select id from pickupfees where zone = '" . $det[0] . "' and vehicle_id = '" . $det[1] . "' ") or die(mysqli_error($this->db));

            if (mysqli_num_rows($query) == 0) {
                if ($value != "") {
                    mysqli_query($this->db, "insert into pickupfees (client_acctno,vehicle_id,zone,fee,skid_fee) values('','" . $det[1] . "','" . $det[0] . "','" . $value . "','" . $values['skid_' . $det[0] . '_' . $det[1]] . "');") or die(mysqli_error($this->db));
                }
            } else {
                $r = mysqli_fetch_array($query) or die(mysqli_error($this->db));
                mysqli_query($this->db, "update pickupfees set  fee = " . check_mysql_string($this->db,$value) . " , skid_fee= '" . $values['skid_' . $det[0] . '_' . $det[1]] . "' where id = '" . $r['id'] . "' ");
            }
        }
    }

    public function create_temp_zone_rate()
    {
        $query = mysqli_query($this->db, "") or die(mysqli_error($this->db));
    }


    public function get_zone_rate_services()
    {
        $query = mysqli_query($this->db, "select id,vehicle from vehicles") or die(mysqli_error($this->db));

        $zone = array();
        $all = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }
            $zone[] = $arr;
        }

        $x = count($zone);
        for ($i = 0; $i < $x; $i++) {
            $q = mysqli_query($this->db, "select services_id,zone_rate_mutlipler,mile_rate_multipler from  vehicles_services where vechicles_id = '" . $zone[$i]['id'] . "' order by services_id ASC") or die(mysqli_error($this->db));
            $ser = array();
            while ($row1 = mysqli_fetch_assoc($q)) {
                foreach ($row1 as $key1 => $value1) {
                    $arr1[$key1] = $value1;
                }
                $ser[] = $arr1;
            }
            array_push($zone[$i], $ser);
        }


        return $zone;
    }


    public function get_vechile_package_rate()
    {
        $query = mysqli_query($this->db, "select id,vehicle from vehicles") or die(mysqli_error($this->db));

        $zone = array();
        $all = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }
            $zone[] = $arr;
        }

        $x = count($zone);
        for ($i = 0; $i < $x; $i++) {
            $q = mysqli_query($this->db, "select package_id,no_charge_per_pack,extra_per_pack from  vehicles_package where vehicles_id = '" . $zone[$i]['id'] . "' order by package_id ASC") or die(mysqli_error($this->db));
            $ser = array();
            while ($row1 = mysqli_fetch_assoc($q)) {
                foreach ($row1 as $key1 => $value1) {
                    $arr1[$key1] = $value1;
                }
                $ser[] = $arr1;
            }
            array_push($zone[$i], $ser);
        }


        return $zone;
    }


    public function get_vechicle_prop()
    {
        $query = mysqli_query($this->db, "select id,vehicle from  vehicles") or die(mysqli_error($this->db));

        $zone = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $zone[] = $arr;
        }


        return $zone;
    }

    public function get_vechile($id)
    {
        $query = mysqli_query($this->db, "select * from  vehicles where id = " . check_mysql_string($this->db,$id) . "") or die(mysqli_error($this->db));
        $row = mysqli_fetch_object($query);
        return $row;
    }

    public function get_standart()
    {
        $query = mysqli_query($this->db, "select * from  vehicles order by id ASC limit 0,1") or die(mysqli_error($this->db));
        $row = mysqli_fetch_object($query);
        return $row;
    }

    public function get_vechile_zone($id)
    {
        $query = mysqli_query($this->db, "select * from  vehicles_services where vechicles_id = " . check_mysql_string($this->db,$id) . "") or die(mysqli_error($this->db));

        $zone = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $zone[] = $arr;
        }


        return $zone;
    }

    public function get_vechile_zonerate($vechileid, $services)
    {
        $query = mysqli_query($this->db, "select * from  vehicles_services where vechicles_id = " . check_mysql_string($this->db,$vechileid) . " and  services_id = " . check_mysql_string($this->db,$services) . " ") or die(mysqli_error($this->db));

        $row = mysqli_fetch_object($query);

        return $row->zone_rate_mutlipler;
    }


    public function get_vechile_package($id)
    {
        $query = mysqli_query($this->db, "select * from   vehicles_package where vehicles_id = " . check_mysql_string($this->db,$id) . "") or die(mysqli_error($this->db));

        $zone = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $zone[] = $arr;
        }


        return $zone;
    }


    public function get_vechiles()
    {
        $vehicle = array();
        $query = mysqli_query($this->db, "select id,vehicle from vehicles order by id") or die(mysqli_error($this->db));
        $vehicle = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $vehicle[] = $arr;
        }

        //$vehcount = mysqli_num_rows($query);
        ////load up the arrays
        //for ($i=1; $i<$vehcount+1; $i++)  {
        //  $vehrec = mysqli_fetch_assoc($query);
        //  $vehicle[$i] = array('id'=>$vehrec["id"],'vehicle'=>$vehrec["vehicle"]);
        //  }
        return $vehicle;
    }

    public function get_zone()
    {
        $zone = array();
        //read the table
        $rz = mysqli_query($this->db, "select zone from pricezones order by zone") or die(mysqli_error($this->db));
        $zonecount = mysqli_num_rows($rz);
        //load up the arrays
        for ($i = 1; $i < $zonecount + 1; $i++) {
            $zonerec = mysqli_fetch_assoc($rz);
            $zone[$i] = $zonerec["zone"];
        }
        return $zone;
    }


    public function get_vec_pickup()
    {
        $query = mysqli_query($this->db, "select * from pickupfees where client_acctno = ''") or die(mysqli_error($this->db));

        $vec = array();
        while ($row = mysqli_fetch_array($query)) {
            $vec[$row['zone']][$row['vehicle_id']] = array("fee" => $row['fee'], "skid_fee" => $row['skid_fee']);
        }


        return $vec;
    }

    public function get_pickup($vechile, $zone)
    {
        $vehicle = $vechile;

        $zone = $zone;


        $fees = array();
        //read the table
        $rf = mysqli_query($this->db, "select * from pickupfees where client_acctno='' ") or die(mysqli_error($this->db));
        $feecount = mysqli_num_rows($rf);

        //* zone & vehicle arrays do NOT use the zero index.
        //* in case a zone has been deleted the zoneindex function will return ZERO.
        //  this will have the effect of just dropping the price records for those zones.
        for ($i = 0; $i < $feecount; $i++) {
            $feerec = mysqli_fetch_assoc($rf);
            $z = $feerec["zone"];
            $v = $feerec["vehicle_id"];
            $fees[$z][$v] = $feerec["fee"];
        }

        $x = array();
        for ($v = 1; $v < count($vehicle) + 1; $v++) {
            for ($z = 1; $z < count($zone); $z++) {
                if (array_key_exists($zone[$z], $fees) && array_key_exists($vehicle[$v]['id'], $fees[$zone[$z]])) {
                    $x[$v][$z] = $fees[$zone[$z]][$vehicle[$v]['id']];
                } else {
                    $x[$v][$z] = "";
                }
            }
        }


        return $x;
    }


    public function get_delivery_zone($service_id, $client, $chart)
    {
        $delivery = array();

        $query2 = mysqli_query($this->db, "select * from deliveryfees where (svc='$service_id')   and (client_acctno='$client') and (chart='$chart')   order by zonefrom, zoneto") or die(mysqli_error($this->db));

        while ($r = mysqli_fetch_array($query2)) {
            $delivery[$r['zonefrom']][$r['zoneto']] = array("price" => $r['price'], "skid" => $r['skid_price']);
        }
        return $delivery;
    }

 
    public function get_add_check_price($account_id=0)
    {
        $query = mysqli_query($this->db, "select * from addtional_services  where account_id=$account_id") or die(mysqli_error($this->db));

        if ($account_id!=0) {
            $query = mysqli_query($this->db, "select `addtional_services`.id as pack_id,`addtional_services`.`per_meters`,`addtional_services`.`name`,`addtional_services`.`short_name` , `pack`.`id` as id,pack.price , pack.account_id from addtional_services inner join pack on( `pack`.`addtional_services_id` = `addtional_services`.`id`) where pack.account_id=$account_id") or die(mysqli_error($this->db));
        }
        $company_details = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $x = "";
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $company_details[] = $arr;
            $i++;
        }

        return $company_details;
    }

    public function set_account_services($account_id, $id, $value2)
    {
        $system_data=$this->get_add_check_price_id($id);
        // var_dump($system_data);
        // $name=$system_data[$id]['name'];
        // $shortname=$system_data[$id]['short_name'];
        // $per_meters=$system_data[$id]['per_meters'];
  
        $sql= 'INSERT INTO `pack` (`addtional_services_id`, `account_id`, `price`) VALUES (\''.$id.'\', \''.$account_id.'\', \''.$value2.'\')';
        // $sql="insert into addtional_services(name,short_name,price,per_meters,account_id)
        // values ('".$name."','".$shortname."','".$value2."','".$per_meters."','".$account_id."')";
        // echo $sql;
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
    
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    public function edit_account_services($id, $value)
    {
        $sql='UPDATE  pack SET  price = \''.$value.'\' WHERE id ='.$id;
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
    
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    public function get_add_check_price_id($id=0)
    {
        $sql="select * from addtional_services ";

        if ($id !=0) {
            $sql="select * from addtional_services  where id ='".$id."'";
        }

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
        $company_details = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $x = "";
            foreach ($row as $key => $value) {
                if ($key == 'id') {
                    $x = $value;
                }
                $arr[$key] = $value;
            }

            $company_details[$x] = $arr;
            $i++;
        }

        return $company_details;
    }

    
    public function add_addservice($name, $shortname, $fee, $per_meters)
    {
        $query = mysqli_query($this->db, "insert into addtional_services(name,short_name,price,per_meters) values (".check_mysql_string($this->db,$name).",".check_mysql_string($this->db,$shortname).",".check_mysql_string($this->db,$fee).",".check_mysql_string($this->db,$per_meters).");") or die(mysqli_error($this->db));
    
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    
    public function edit_addservice($name, $shortname, $fee, $per_meters, $id)
    {
        $query = mysqli_query($this->db, "update addtional_services set name = ".check_mysql_string($this->db,$name).",short_name = ".check_mysql_string($this->db,$shortname)." ,price = ".check_mysql_string($this->db,$fee)." , per_meters = ".check_mysql_string($this->db,$per_meters)."  where id = ".check_mysql_string($this->db,$id)."") or die(mysqli_error($this->db));
    
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    
    public function get_addservice($id)
    {
        $query = mysqli_query($this->db, "select * from  addtional_services where id = " . check_mysql_string($this->db,$id) . "") or die(mysqli_error($this->db));
        $row = mysqli_fetch_object($query);
        return $row;
    }

    public function delete_addservices($id)
    {
        $query = mysqli_query($this->db, "delete from addtional_services where id = " . check_mysql_string($this->db,$id) . "") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function get_return_trip_setting()
    {
        $sql = "";
        $query = mysqli_query($this->db, "select option_name,option_value from options where option_name like '%co_returntrip_%'") or die(mysqli_error($this->db));

        $zone = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $zone[] = $arr;
        }


        return $zone;
    }


    public function get_time_zones()
    {
        $sql = "";
        $query = mysqli_query($this->db, "select * from  todrates where client_acctno='' order by zone ") or die(mysqli_error($this->db));

        $zone = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $zone[] = $arr;
        }


        return $zone;
    }


    //////////////////////vechile managment is here because it's related to price////////////


    public function add_vechile($data)
    {
        $query = mysqli_query($this->db, "insert into vehicles (vehicle,nocharge_weight,max_weight,extra_weight_fee,nocharge_volume,max_volume,extra_volume_fee,return_multiplier,delfee_chart,fs_adj_pct,fs_adj_rb,selectable,disabled) values
(" . check_mysql_string($this->db,$data['v_type']) . "," . check_mysql_string($this->db,$data['no_charge_weight']) . "," . check_mysql_string($this->db,$data['max_weight']) . "," . check_mysql_string($this->db,$data['extra_weight_fee']) . "," . check_mysql_string($this->db,$data['no_cahrge_voloume']) . "," . check_mysql_string($this->db,$data['max_volume']) . "," . check_mysql_string($this->db,$data['extr_volume_fee']) . "," . check_mysql_string($this->db,$data['return_trip']) . "," . check_mysql_string($this->db,$data['v_chart']) . "," . check_mysql_string($this->db,$data['fuel_surcharge']) . "," . check_mysql_string($this->db,$data['group2']) . "," . check_mysql_string($this->db,$data['selectable']) . "," . check_mysql_string($this->db,$data['disable']) . ")") or die(mysqli_error($this->db));

        $vid = mysqli_insert_id($this->db);

        foreach ($data as $key => $value) {
            $m = explode('_', $key);

            if ($m[0] == "zonerate") {
                mysqli_query($this->db, "insert into vehicles_services (services_id,vechicles_id,zone_rate_mutlipler,mile_rate_multipler) values('" . $m[1] . "','" . $vid . "'," . check_mysql_string($this->db,$data['zonerate_' . $m[1]]) . ", " . check_mysql_string($this->db,$data['milerate_' . $m[1]]) . " );") or die(mysqli_error($this->db));
            }


            if ($m[0] == "packageno") {
                mysqli_query($this->db, "insert into vehicles_package (package_id,vehicles_id,no_charge_per_pack,extra_per_pack) values('" . $m[1] . "','" . $vid . "'," . check_mysql_string($this->db,$data['packageno_' . $m[1]]) . ", " . check_mysql_string($this->db,$data['packageextra_' . $m[1]]) . " );") or die(mysqli_error($this->db));
            }

            if ($m[0] == "additionaleservice") {
                mysqli_query($this->db, "insert into vehicles_additional (vechile_id,add_service_id,fees) values('" . $vid . "','" . $m[1] . "'," . check_mysql_string($this->db,$data['additionaleservice_' . $m[1]]) . ");") or die(mysqli_error($this->db));
            }
        }

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_vechile($data, $id)
    {

//print_r($data);

        /*if (array_key_exists($data['selectable'],$data) ) $selected = 'Y';
        else  $selected = 'N';

        if (  array_key_exists($data['disable'],$data)) $disable = 'Y';
        else  $disable = 'N';*/

        $query = mysqli_query($this->db, "update vehicles set vehicle = " . check_mysql_string($this->db,$data['v_type']) . " ,nocharge_weight = " . check_mysql_string($this->db,$data['no_charge_weight']) . " ,max_weight =  " . check_mysql_string($this->db,$data['max_weight']) . " ,extra_weight_fee = " . check_mysql_string($this->db,$data['extra_weight_fee']) . " ,nocharge_volume = " . check_mysql_string($this->db,$data['no_cahrge_voloume']) . " ,max_volume = " . check_mysql_string($this->db,$data['max_volume']) . "  ,extra_volume_fee= " . check_mysql_string($this->db,$data['extr_volume_fee']) . " ,return_multiplier = " . check_mysql_string($this->db,$data['return_trip']) . " ,delfee_chart = " . check_mysql_string($this->db,$data['v_chart']) . " ,fs_adj_pct = " . check_mysql_string($this->db,$data['fuel_surcharge']) . " ,fs_adj_rb = " . check_mysql_string($this->db,$data['group2']) . " ,selectable = " . check_mysql_string($this->db,$data['selectable']) . " ,disabled = " . check_mysql_string($this->db,$data['disable']) . "  where id = " . check_mysql_string($this->db,$id) . " ") or die(mysqli_error($this->db));


        foreach ($data as $key => $value) {
            $m = explode('_', $key);

            if ($m[0] == "zonerate") {
                mysqli_query($this->db, "update vehicles_services set  zone_rate_mutlipler = " . check_mysql_string($this->db,$data['zonerate_' . $m[1]]) . " ,mile_rate_multipler = " . check_mysql_string($this->db,$data['milerate_' . $m[1]]) . "  where  vechicles_id = '" . $id . "' and  services_id = '" . $m[1] . "' ") or die(mysqli_error($this->db));
            }


            if ($m[0] == "packageno") {
                mysqli_query($this->db, "update vehicles_package set  no_charge_per_pack= " . check_mysql_string($this->db,$data['packageno_' . $m[1]]) . " ,extra_per_pack =" . check_mysql_string($this->db,$data['packageextra_' . $m[1]]) . " where vehicles_id = '" . $id . "' and package_id = '" . $m[1] . "' ") or die(mysqli_error($this->db));
            }

            if ($m[0] == "additionaleservice") {
                $oo = mysqli_query($this->db, "select count(*) as num from vehicles_additional where add_service_id = '" . $m[1] . "'");
                $num = mysqli_fetch_array($oo);
                if ($num['num'] == 0) {
                    mysqli_query($this->db, "insert into  vehicles_additional ( vechile_id,add_service_id,fees) values ('" . $id . "','" . $m[1] . "'," . check_mysql_string($this->db,$data['additionaleservice_' . $m[1]]) . "); ") or die(mysqli_error($this->db));
                } else {
                    mysqli_query($this->db, "update  vehicles_additional set   fees = " . check_mysql_string($this->db,$data['additionaleservice_' . $m[1]]) . " where vechile_id = '" . $id . "' and add_service_id = '" . $m[1] . "' ") or die(mysqli_error($this->db));
                }
            }
        }

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    ////////////////////most important edit price option in all system//////
    public function edit_price_option($data)
    {

//$query =
        $vech_serv = "";

        foreach ($data as $key => $value) {
            $m = explode('_', $key);

            if (array_key_exists(1, $m) && $m[1] == "returntrip") {
                $query = mysqli_query($this->db, "update  options set option_value = " . check_mysql_string($this->db,$data[$key]) . " where option_name = '" . $key . "'  ") or die(mysqli_error($this->db));
            }

            if (array_key_exists(0, $m) && $m[0] == "add") {
                $query = mysqli_query($this->db, "update vehicle_addtional_services set return_cal = " . check_mysql_string($this->db,$data[$key]) . " where id = '" . $m[1] . "'  ") or die(mysqli_error($this->db));
                $vech_serv .= $m[1];
            }

            if (array_key_exists(0, $m) && $m[0] == "check") {
                $query = mysqli_query($this->db, "update addtional_services set return_cal = " . check_mysql_string($this->db,$data[$key]) . " where id = '" . $m[1] . "'  ") or die(mysqli_error($this->db));
                $vech_serv .= $m[1];
            }

            if (array_key_exists(0, $m) && $m[0] == "price") {
                $q = mysqli_query($this->db, "select * from options where option_name= '" . $key . "' ") or die(mysqli_error($this->db));
                if (mysqli_num_rows($q) == 1) {
                    $query = mysqli_query($this->db, "update options set option_value = " . check_mysql_string($this->db,$data[$key]) . " where option_name = '" . $key . "'  ") or die(mysqli_error($this->db));
                } else {
                    $query = mysqli_query($this->db, "insert into options (option_name,option_value) values ('" . $key . "'," . check_mysql_string($this->db,$data[$key]) . ")") or die(mysqli_error($this->db));
                }
                $vech_serv .= $m[1];
            }
        }
    }


    public function get_vechile_service_price($vechile_id, $services_id)
    {
        $query = mysqli_query($this->db, "select fees from vehicles_additional where vechile_id = " . check_mysql_string($this->db,$vechile_id) . " and 	add_service_id = " . check_mysql_string($this->db,$services_id) . " ") or die(mysqli_error($this->db));
        if (mysqli_num_rows($query)) {
            $row = mysqli_fetch_object($query);
            $fees = $row->fees;
        } else {
            $fees = "";
        }

        return $fees;
    }


    //function to get zone from pcode
    public function get_zone_pcode($pcode)
    {
        $zone = array();
        $prefix = array();
        $pcodes = array();
        $singles = array();
        $ranges = array();
        $singles_zone = array();
        $ranges_zone = array();
        //read the table
        $rz = mysqli_query($this->db, "select * from pricezones order by zone");
        $zrowcount = mysqli_num_rows($rz);


        for ($i = 0; $i < $zrowcount; $i++) {
            $zonerec = mysqli_fetch_assoc($rz);
            $zone[$i] = $zonerec["zone"];
            $prefix[$i] = $zonerec["prefix"];
            $pcodes[$i] = $zonerec["pcodes"];
            $pc = $this->break_pc_into_list($prefix[$i], $pcodes[$i]);
            foreach ($pc as $pcrow) {
                if (strpos($pcrow, "-")) {
                    $ranges[] = $pcrow;
                    $ranges_zone[] = $zone[$i];
                } else {
                    $singles[] = $pcrow;
                    $singles_zone[] = $zone[$i];
                }
            }
        }
        mysqli_free_result($rz);


        return $this->get_zone_from_postalcode($pcode, $ranges, $ranges_zone, $singles, $singles_zone);
    }



    //************************************************************************************
    // this function serves 2 purposes:                                                  *
    // (i)  break up $pcodes, attach prefix & assemble an array of elements in the zone. *
    // (ii) check for FORMAT errors in $pcodes.                                          *
//      Error checking consists of:                                                  *
//      - incomplete from-thru range  ie: A1B-  or   -A1B                            *
//      - more than one hyphen                                                       *
//      - from higher than thru                                                      *
    // ****** special characters 0-9 & A-Z ONLY  ******* NOT DONE YET *****************  *
//        duplicates...                                                              *
//        overlapping ranges...                                                      *
//     ...since this function only handles one row at a time, the error checks for,  *
//         duplicates & overlaps must be done in the main program.                   *
    //************************************************************************************
    public function break_pc_into_list($p, $c)
    {
        unset($err);
        $t = array();
        $c = str_replace(" ", "", $c);      //squish out all spaces
        if ($c == "") {
            $err = "is blank";
        }
        $c .= ",";                         //get the last one
        do {
            $c = str_replace(",,", ",", $c); //replace any double commas with singles
        } while (strpos($c, ",,"));
        do {
            $c = str_replace("--", "-", $c); //replace any double hyphens with singles
        } while (strpos($c, "--"));
        do {
            $pos = strpos($c, ",");         //dissect it into an array
            if ($pos > 0) {
                $t[] = substr($c, 0, $pos);            //$x= substr($c,0,$pos); echo "<br> >$c< &nbsp;&nbsp;&nbsp;&nbsp;*$pos* &nbsp;&nbsp; *$x*<br>";
                $c = trim(substr($c, $pos + 1));
            }
        } while ($pos > 0);
        foreach ($t as $pc) {
            //range:look for hyphen
            $dash = strpos($pc, "-");
            if ($dash === false) {
                //single postalcode
                $ret[] = $p . $pc;
            //echo ">$pc< *$dash* false<br><br>";
            } else {
                //postalcode range
                //echo ">$pc< *$dash* true<br><br>";
                if ($dash == 0) {
                    $err = "invalid range  " . $pc;
                }
                if ($dash == strlen($pc) - 1) {
                    $err = "invalid range  " . $pc;
                }
                if (!isset($err)) {
                    $pos = strpos($pc, "-");
                    $l = substr($pc, 0, $pos);
                    $r = substr($pc, $pos + 1);
                    if ($r <= $l) {
                        $err = "range from is equal or higher than thru";
                    }
                }
                if (!isset($err)) {
                    $ret[] = $p . $l . "-" . $p . $r;
                }
            }
            if (strpos($r, "-")) {
                $err = "invalid range, more than one hyphen";
            }
        }

        if (isset($err)) {
            $ret = array();
            $ret[] = "error";
            $ret[] = $err;
        }

        return $ret;
    }


    //************************************************************************
    //Locate the postalcode in the lists (singles or ranges).                *
//                                                                       *
    //we now have 2 array pairs,                                             *
    //(each row is an individual range or single code with associated Zone)  *
    // (i)Singles - Zone & postalcode.                                       *
    //(ii)Ranges  - Zone & range.                                            *
    //************************************************************************
    public function get_zone_from_postalcode($p, $ranges, $ranges_zone, $singles, $singles_zone)
    {
        //global $ranges, $ranges_zone, $singles, $singles_zone;
        // now that we are using this in status_quick-function, globalizing variables in a function that
        // calls another function is problematic beyon it's value.  -  Just pass them in the call. !
        $p = strtoupper($p);              //uppercase it
        $p = str_replace(" ", "", $p);      //squish out all spaces
        $rangecnt = count($ranges);
        if ($rangecnt > 0) {
            for ($i = 0; $i < $rangecnt; $i++) {
                $pos = strpos($ranges[$i], "-");
                $l = substr($ranges[$i], 0, $pos);
                $l_len = strlen($l);
                $r = substr($ranges[$i], $pos + 1);
                $r_len = strlen($r);
                $p_len = strlen($p);
                $longest = max($l_len, $r_len, $p_len);
                $l = $l . "00000000";
                $l = substr($l, 0, $longest);
                $r = $r . "}}}}}}}}";
                $r = substr($r, 0, $longest);

                if ($p >= $l and $p <= $r) {
                    $ret = $ranges_zone[$i];
                }
                //$xx = "$i * $l * $r * $pos *<br>";    //++++++++++++++++++++++++++++++++++++++
            }
        }
        $singlecnt = count($singles);
        if ($singlecnt > 0) {
            for ($i = 0; $i < $singlecnt; $i++) {
                $len = strlen($singles[$i]);
                $px = substr($p, 0, $len);
                if ($singles[$i] == $px) {
                    $ret = $singles_zone[$i];
                }
            }
        }           //$ret = "999* $ranges[0] * $ranges[1] * $rangecnt * $longest * 999 *".$xx; //+++++++++++++++++++++++++++++++++++++++++++++++++++
        return $ret;
    }


    //******************************************          No more need to do this....
    //  Validate Zone entered.                 *       ...they now come from the listbox.
    //******************************************       **EXCEPT** from XPEntry.
    public function zonevalidate($zone)
    {
        $zone = strtoupper($zone);
        $rz = runsql("select id from pricezones where zone='$zone'");
        $zonecount = mysqli_num_rows($rz);
        if ($zonecount == 0) {
            return "";
        } else {
            return $zone;
        }
    }


    //function get pickupup price for * from zone

    public function get_pickup_price($zone, $vech_id)
    {
        $query = mysqli_query($this->db, "select fee,skid_fee from pickupfees where client_acctno = '' and zone = " . check_mysql_string($this->db,$zone) . " and vehicle_id = " . check_mysql_string($this->db,$vech_id) . " ") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query)) {
            $row = mysqli_fetch_object($query);
            return $row;
        } else {
            return false;
        }
    }

    public function get_delivery_price($zone_from, $zone_to, $service_id, $vechileid)
    {
        //get chart for vechile
        $chart = 0;
        $q = mysqli_query($this->db, "select delfee_chart from	vehicles where id = " . check_mysql_string($this->db,$vechileid) . " ") or die(mysqli_error($this->db));
        if (mysqli_num_rows($q)) {
            $v = mysqli_fetch_object($q);
            $chart = $v->delfee_chart;
        }


        ///////////////////////
        $query = mysqli_query($this->db, "select price,skid_price from deliveryfees where client_acctno = '' and zonefrom = " . check_mysql_string($this->db,strtoupper($zone_from)) . " and zoneto = " . check_mysql_string($this->db,strtoupper($zone_to)) . " and svc = " . check_mysql_string($this->db,$service_id) . " and chart = '" . $chart . "' ") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_object($query);
            $fees = $row;
        } else {
            $q2 = mysqli_query($this->db, "select price,skid_price from deliveryfees where client_acctno = '' and zonefrom = " . check_mysql_string($this->db,strtoupper($zone_to)) . " and zoneto = " . check_mysql_string($this->db,strtoupper($zone_from)) . " and svc = " . check_mysql_string($this->db,$service_id) . " and chart = '" . $chart . "'") or die(mysqli_error($this->db));

            if (mysqli_num_rows($q2) > 0) {
                $row2 = mysqli_fetch_object($q2);
                $fees = $row2;
            } else {
                $fees = "";
            }
        }

        return $fees;
    }

    public function get_fsrate($taxgroup, $vid, $account_id)
    {
        $fsrate = 0;

        $tax = mysqli_query($this->db, "select * from tax_group  where taxgroup_id = " . check_mysql_string($this->db,$taxgroup) . " ") or die(mysqli_error($this->db));
        $taxgroup = mysqli_fetch_object($tax);
        $fsrate = $taxgroup->taxgroup_fs_rate;


        // - Priority-Layer 4-of-5. -  Get Vehicle Adjustment


        if ($vid > 0) {
            $sql = "select fs_adj_pct,fs_adj_rb from vehicles where id = '" . $vid . "'";

            $rv = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

            $vehicle = mysqli_fetch_array($rv);

            if (trim($vehicle["fs_adj_pct"]) != "") {
                if ($vehicle["fs_adj_rb"] == 1) {
                    $fsrate = $fsrate + $vehicle["fs_adj_pct"];
                }

                if ($vehicle["fs_adj_rb"] == 2) {
                    $fsrate = $fsrate - $vehicle["fs_adj_pct"];
                }

                if ($vehicle["fs_adj_rb"] == 3) {
                    $fsrate = $vehicle["fs_adj_pct"];
                }
            }
        }


        if ($account_id != '') {
            $query = mysqli_query($this->db, "select fs_ovrd from account where account_id = '" . $account_id . "'  ") or die(mysqli_error($this->db));

            $row = mysqli_fetch_array($query);
            //echo "-".$row['fs_ovrd']."-";
            if ($row['fs_ovrd'] != '') {
                $fsrate = $row['fs_ovrd'];
            }
        }

        //  echo $fsrate;
        return $fsrate;
    }


    public function get_tax_price_array($taxgroup, $array)
    {
        //$query = mysqli_query($this->db,"select * from orders_price where order_id = ".check_mysql_string($this->db,$order_id)." ") or die (mysqli_error($this->db));

        $tax = mysqli_query($this->db, "select * from tax_group where taxgroup_id = " . check_mysql_string($this->db,$taxgroup) . " ") or die(mysqli_error($this->db));
        $taxgroup = mysqli_fetch_object($tax);
        $group = $taxgroup->taxgroup_on;

        $get_type = explode(",", $group);

        //echo mysqli_num_rows($query);
        $total_price = 0;
        for ($i = 0; $i < count($array); $i++) {
            //echo $row['type'] ;
            //service
            if ($get_type[0] == "1" && is_array($array) && $array[$i]["type"] == "addtional_services") {
                $total_price += $array[$i]['price'];
            } //wait
            elseif ($get_type[1] == "1" && is_array($array) && $array[$i]['type'] == "wait_services") {
                $total_price += $array[$i]['price'];
            } //addtional
            elseif ($get_type[2] == "1" && is_array($array) && ($array[$i]['type'] == "delivery_price" || $array[$i]['type'] == "pickup_price")) {
                $total_price += $array[$i]['price'];
            } elseif (is_array($array)) {
                $total_price += $array[$i]['price'];
            }
        }

        return $total_price;
    }


    public function get_tax_price($taxgroup, $order_id)
    {
        $query = mysqli_query($this->db, "select * from orders_price where order_id = " . check_mysql_string($this->db,$order_id) . " ") or die(mysqli_error($this->db));

        $tax = mysqli_query($this->db, "select * from tax_group where taxgroup_id = " . check_mysql_string($this->db,$taxgroup) . " ") or die(mysqli_error($this->db));
        $taxgroup = mysqli_fetch_object($tax);
        $group = $taxgroup->taxgroup_on;

        $get_type = explode(",", $group);

        //echo mysqli_num_rows($query);
        $total_price = 0;
        while ($row = mysqli_fetch_array($query)) {
            //echo $row['type'] ;
            //service
            if ($get_type[0] == "1" && $row['type'] == "addtional_services") {
                $total_price += $row['price'];
            } //wait
            elseif ($get_type[1] == "1" && $row['type'] == "wait_services") {
                $total_price += $row['price'];
            } //addtional
            elseif ($get_type[2] == "1" && ($row['type'] == "delivery_price" || $row['type'] == "pickup_price")) {
                $total_price += $row['price'];
            } elseif ($row['type'] != "delivery_price" && $row['type'] == "pickup_price" && $row['type'] == "wait_services" && $row['type'] == "addtional_services" && $row['type'] == "total") {
                $total_price += $row['price'];
            }
        }

        return $total_price;
    }


    public function update_distance_vec_price_inc($array, $vec, $ser, $account_id = "0")
    {
        $query = mysqli_query($this->db, "delete  from service_vechicle_distance where account_id = '" . $account_id . "' ") or die(mysqli_error($this->db));

        for ($v = 0; $v < count($vec); $v++) {
            for ($s = 0; $s < count($ser); $s++) {
                $dis = $array['distance__' . $vec[$v]['id'] . '__' . $ser[$s]['service_id']];
                $fee = $array['price__' . $vec[$v]['id'] . '__' . $ser[$s]['service_id']];

                $ratio = $array['check_' . $vec[$v]['id'] . '__' . $ser[$s]['service_id']];
                //echo $ratio;

                for ($i = 0; $i < count($dis); $i++) {
                    if ($i == count($dis) - 1) {
                        $type = "last";
                    } else {
                        $type = "inc";
                    }

                    if ($fee[$i] != "" && $fee[$i] != "0" && $dis[$i] != "" && $dis[$i] != "0") {
                        mysqli_query($this->db, "insert into service_vechicle_distance (ser_id,vec_id,distance,fees,type,account_id,orders,rate) values (" . check_mysql_string($this->db,$ser[$s]['service_id']) . "," . check_mysql_string($this->db,$vec[$v]['id']) . "," . check_mysql_string($this->db,$dis[$i]) . "," . check_mysql_string($this->db,$fee[$i]) . ",'" . $type . "'," . check_mysql_string($this->db,$account_id) . ",'" . $array['order'][$i] . "','" . $ratio . "');") or die(mysqli_error($this->db));
                    }
                }
            }
        }
    }


    public function update_distance_vec_price($array, $account_id = "0")
    {
        $query = mysqli_query($this->db, "delete  from vehicles_distance_price where account_id = '" . $account_id . "' ") or die(mysqli_error($this->db));

        foreach ($array as $key => $value) {
            $ke = explode('__', $key);

            if ($value != "" && $value != 0 && is_numeric($value) && $ke[0] == "distance") {
                mysqli_query($this->db, "insert into vehicles_distance_price (ser_id,vec_id,fees,account_id) values (" . check_mysql_string($this->db,$ke[2]) . "," . check_mysql_string($this->db,$ke[1]) . "," . check_mysql_string($this->db,$value) . "," . check_mysql_string($this->db,$account_id) . ");") or die(mysqli_error($this->db));
            }
        }
    }

    public function update_distance_ratio($array, $account_id = "0")
    {
        $query = mysqli_query($this->db, "delete  from services_distance_ratio where account_id = '" . $account_id . "' ") or die(mysqli_error($this->db));

        foreach ($array as $key => $value) {
            $ke = explode('__', $key);
            if ($value != "" && $value != 0 && is_numeric($value) && $ke[1] != 0 && $ke[0] == "pattern") {
                $pattern = $array['pattern'];
                mysqli_query($this->db, "insert into services_distance_ratio (ser_id,name,ratio,every,account_id) values (" . check_mysql_string($this->db,$ke[1]) . ",'pattern'," . check_mysql_string($this->db,$value) . "," . check_mysql_string($this->db,$pattern) . "," . check_mysql_string($this->db,$account_id) . ");") or die(mysqli_error($this->db));
            }
        }
    }

    public function get_distance_ratio($account_id = "0")
    {
        $query = mysqli_query($this->db, "select * from services_distance_ratio where account_id = '" . $account_id . "'") or die(mysqli_error($this->db));

        $dfees = array();
        while ($row = mysqli_fetch_array($query)) {
            $dfees[$row['name']][$row['ser_id']] = array('every' => $row['every'], 'ratio' => $row['ratio']);
        }

        return $dfees;
    }

    public function get_dist_unitprice($serid, $vec_id, $account_id = "0")
    {
        $query = mysqli_query($this->db, "select * from vehicles_distance_price where ser_id = " . check_mysql_string($this->db,$serid) . " and vec_id = " . check_mysql_string($this->db,$vec_id) . " and account_id = '" . $account_id . "'  ") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);
        } else {
            $query = mysqli_query($this->db, "select * from vehicles_distance_price where ser_id = " . check_mysql_string($this->db,$serid) . " and vec_id = " . check_mysql_string($this->db,$vec_id) . " and account_id = '0'  ") or die(mysqli_error($this->db));
            $row = mysqli_fetch_array($query);
        }

        return $row['fees'];
    }

    public function get_every_ratio($ser_id, $distance, $account_id = "0")
    {
        $query = mysqli_query($this->db, "select * from services_distance_ratio where ser_id = " . check_mysql_string($this->db,$ser_id) . " and account_id = '" . $account_id . "' ") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);
        } else {
            $query = mysqli_query($this->db, "select * from services_distance_ratio where ser_id = " . check_mysql_string($this->db,$ser_id) . " and account_id = '0' ") or die(mysqli_error($this->db));
            $row = mysqli_fetch_array($query);
        }


        //$increase =  ceil(($distance/$row['every']) );
        $every = $row['every'];
        $fee = $row['ratio'];

        if ($distance < $row['every']) {
            $distance = $row['every'];
            $increase = $fee;
        } else {
            for ($i = 0; $i < $distance; $i += $row['every']) {
                if ($distance >= $i) {
                    $increase += $row['ratio'];
                } else {
                    $increase += $row['ratio'];
                    exit();
                }
            }
        }

        return $increase;
    }

    public function get_distance_vec_price_increment($account_id = "0")
    {
        $query = mysqli_query($this->db, "select * from service_vechicle_distance where account_id = '" . $account_id . "' ") or die(mysqli_error($this->db));

        $dfees = array();
        while ($row = mysqli_fetch_array($query)) {
            $dfees[$row['vec_id']][$row['ser_id']][$row['orders']] = array('fees' => $row['fees'], 'distance' => $row['distance'], 'type' => $row['type'], 'rate' => $row['rate']);
        }

        return $dfees;
    }


    public function get_distance_sheet($ser_id, $vec_id, $type, $account_id = "0", $price = "0")
    {
        $query = mysqli_query($this->db, "select * from service_vechicle_distance where account_id = '" . $account_id . "' and ser_id = '" . $ser_id . "' and vec_id = '" . $vec_id . "' and type = 'inc' and orders != '0' order by orders ASC") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) < 1) {
            $query = mysqli_query($this->db, "select * from service_vechicle_distance where account_id = '0' and ser_id = '" . $ser_id . "' and vec_id = '" . $vec_id . "' and type = 'inc' and orders != '0' order by orders ASC") or die(mysqli_error($this->db));
        }

        $dfees = array();


        while ($row = mysqli_fetch_array($query)) {

// 	if($type == "Km")
            // 		$row['distance'] = $row['distance'] * 1000;
            // 	else
            // 		$row['distance'] = $row['distance'] * 1609.34;

            $dfees[] = array('price' => $row['fees'], 'distance' => $row['distance'], 'rate' => $row['rate']);
        }
        return $dfees;
    }

    public function get_distance_lastunit($ser_id, $vec_id, $account_id = "0")
    {
        $query = mysqli_query($this->db, "select * from service_vechicle_distance where account_id = '" . $account_id . "' and ser_id = '" . $ser_id . "' and vec_id = '" . $vec_id . "' and type = 'last' and orders = '0' order by orders ASC") or die(mysqli_error($this->db));


        if (mysqli_num_rows($query) < 1) {
            $query = mysqli_query($this->db, "select * from service_vechicle_distance where account_id = '0' and ser_id = '" . $ser_id . "' and vec_id = '" . $vec_id . "' and type = 'last' and orders = '0' order by orders ASC") or die(mysqli_error($this->db));
        }

        $row = mysqli_fetch_array($query);
        return $row['fees'];
    }


    public function get_distance_vec_price($account_id = "0")
    {
        $query = mysqli_query($this->db, "select * from vehicles_distance_price where account_id = '" . $account_id . "' ") or die(mysqli_error($this->db));

        $dfees = array();
        while ($row = mysqli_fetch_array($query)) {
            $dfees[$row['vec_id']][$row['ser_id']] = $row['fees'];
        }

        return $dfees;
    }


    public function get_total_price($order_id)
    {
        $query = mysqli_query($this->db, "select * from orders_price where order_id = " . check_mysql_string($this->db,$order_id) . " ") or die(mysqli_error($this->db));

        $total_price = 0;
        while ($row = mysqli_fetch_array($query)) {
            if ($row['name'] != "total" && $row['name'] != "fsrate") {
                if ($row['override'] == "") {
                    $total_price += $row['price'];
                } else {
                    $total_price += $row['override'];
                }
            }
        }

        return $total_price;
    }

    public function get_order_prices($order_id)
    {
        $query = mysqli_query($this->db, "select * from orders_price where order_id = " . check_mysql_string($this->db,$order_id) . " ") or die(mysqli_error($this->db));
        $order_details = array();
        $i = 0;
        while ($row = mysqli_fetch_array($query)) {
            if ($row['override'] == "") {
                $order_details[$row['type']] = $row['price'];
            } else {
                $order_details[$row['type']] = $row['override'];
            }
        }
        //$order_details = mysqli_fetch_object($query);
        return $order_details;
    }

    public function get_inv_order_prices($order_id)
    {
        $query = mysqli_query($this->db, "select * from orders_price where package_id = " . check_mysql_string($this->db,$order_id) . " ") or die(mysqli_error($this->db));
        $order_details = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $order_details[$i][$row["type"]] = $row;
            $i++;
        }
        return $order_details;
    }


    public function get_inv_order_prices_array($result)
    {
        $order_details = array();
        //var_dump($result);
        for ($i = 0; $i < count($result); $i++) {
            $order_details[][$result[$i]["type"]] = array("name" => $result[$i]["name"], "price" => $result[$i]["price"], "override" => $result[$i]["override"]);
            //$i++;
        }
        //$order_details = mysqli_fetch_object($query);
        return $order_details;
    }


    public function get_fuelsurcharge($order_id)
    {
        $query = mysqli_query($this->db, "select * from orders_price where order_id = " . check_mysql_string($this->db,$order_id) . " and type =  'fsrate' ") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_object($query);
        } else {
            $row = "";
        }
        return $row;
    }

    public function get_price_type($type, $order_id)
    {
        $query = mysqli_query($this->db, "select * from orders_price where type = " . check_mysql_string($this->db,$type) . " and order_id=" . check_mysql_string($this->db,$order_id) . " ") or die(mysqli_error($this->db));

        $order_details = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $order_details[] = $arr;
        }
        //$order_details = mysqli_fetch_object($query);
        return $order_details;
    }

    public function get_mainprice_type($type, $order_id)
    {
        //echo "select * from orders_price where type = ".check_mysql_string($this->db,$type)." and order_id=".check_mysql_string($this->db,$order_id)." ";
        $order_details = array('price' => '');
        $query = mysqli_query($this->db, "select * from orders_price where type = " . check_mysql_string($this->db,$type) . " and order_id=" . check_mysql_string($this->db,$order_id) . " ") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) > 0) {
            $order_details = array();
            $order_details = mysqli_fetch_object($query);


            return $order_details;
        } else {
            return "";
        }
    }

    public function get_addprice_type($type, $order_id)
    {
        $query = mysqli_query($this->db, "select * from orders_price where type = " . check_mysql_string($this->db,$type) . " and order_id=" . check_mysql_string($this->db,$order_id) . " ") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) > 0) {
            $order_details = array();
            $i = 0;
            while ($row = mysqli_fetch_assoc($query)) {
                foreach ($row as $key => $value) {
                    $arr[$key] = $value;
                }

                $order_details[] = $arr;
            }

            return $order_details;
        } else {
            return "";
        }
    }

    public function get_todat_rate($zone, $rate)
    {
        $query = mysqli_query($this->db, "select $rate from todrates where zone	 =  " . check_mysql_string($this->db,strtoupper($zone)) . "  ");

        $row = mysqli_fetch_object($query);

        return $row->$rate;
    }


    public function get_vechile_package_rates($vechile_id, $pieces_id)
    {
        $query = mysqli_query($this->db, "select * from vehicles_package where vehicles_id	 =  " . check_mysql_string($this->db,$vechile_id) . "  and package_id = " . check_mysql_string($this->db,$pieces_id) . " ") or die(mysqli_error($this->db));
        $row = mysqli_fetch_object($query);
        return $row;
    }


    public function get_totals_list($order_id)
    {
        $q = mysqli_query($this->db, "select * from orders_price where order_id = '" . $order_id . "' ") or die(mysqli_error($this->db));

        $srv = 0;
        $add = 0;
        $wait = 0;
        $fs = 0;
        $tp = 0;

        $addprice = $this->get_addprice_type('addtional_services', $order_id);
        $vecprice = $this->get_addprice_type('vechile_services', $order_id);

        while ($row = mysqli_fetch_array($q)) {
            if ($row['type'] == 'pickup_price') {
                if ($row['override'] != '') {
                    $srv += $row['override'];
                } else {
                    $srv += $row['price'];
                }
            }

            if ($row['type'] == 'delivery_price') {
                if ($row['override'] != '') {
                    $srv += $row['override'];
                } else {
                    $srv += $row['price'];
                }
            }

            if ($row['type'] == 'weight') {
                if ($row['override'] != '') {
                    $srv += $row['override'];
                } else {
                    $srv += $row['price'];
                }
            }

            if ($row['type'] == 'volume') {
                if ($row['override'] != '') {
                    $srv += $row['override'];
                } else {
                    $srv += $row['price'];
                }
            }

            if ($row['type'] == 'pieces') {
                if ($row['override'] != '') {
                    $srv += $row['override'];
                } else {
                    $srv += $row['price'];
                }
            }

            if ($row['type'] == 'distance_price') {
                if ($row['override'] != '') {
                    $srv += $row['override'];
                } else {
                    $srv += $row['price'];
                }
            }

            if ($row['type'] == 'wait_price') {
                if ($row['override'] != '') {
                    $wait += $row['override'];
                } else {
                    $wait += $row['price'];
                }
            }

            if ($row['type'] == 'add1_charge') {
                if ($row['override'] != '') {
                    $add += $row['override'];
                } else {
                    $add += $row['price'];
                }
                echo $add;
            }

            if ($row['type'] == 'add2_charge') {
                if ($row['override'] != '') {
                    $add += $row['override'];
                } else {
                    $add += $row['price'];
                }
                echo $add;
            }

            if ($row['type'] == 'add3_charge') {
                if ($row['override'] != '') {
                    $add += $row['override'];
                } else {
                    $add += $row['price'];
                }
                echo $add;
            }

            if ($row['type'] == 'fsrate') {
                if ($row['override'] != '') {
                    $fs += $row['override'];
                } else {
                    $fs += $row['price'];
                }
            }

            if ($row['type'] == 'total') {
                if ($row['override'] != '') {
                    $tp += $row['override'];
                } else {
                    $tp += $row['price'];
                }
            }
        }

        if (is_array($addprice)) {
            for ($i = 0; $i < count($addprice); $i++) {
                $srv += $addprice[$i]['price'];
            }
        }

        if (is_array($vecprice)) {
            for ($i = 0; $i < count($vecprice); $i++) {
                $srv += $vecprice[$i]['price'];
            }
        }


        $total['srv'] = $srv;
        $total['add'] = $add;
        $total['wait'] = $wait;
        $total['fs'] = $fs;
        $total['total'] = $tp;

        return $total;
    }


    public function get_vechile_service_price_new($vechileid, $services, $name)
    {
        $query = mysqli_query($this->db, "select * from  vehicles_services where vechicles_id = " . check_mysql_string($this->db,$vechileid) . " and  services_id = " . check_mysql_string($this->db,$services) . " ") or die(mysqli_error($this->db));
        //	echo "select * from  vehicles_services where vechicles_id = ".check_mysql_string($this->db,$vechileid)." and  services_id = ".check_mysql_string($this->db,$services)." ";
        $row = mysqli_fetch_array($query);

        return $row[$name];
    }


    public function search_zone($data)
    {
        $sql1 = "";

        if (isset($data['account_id'])) {
            $account_id = $data['account_id'];
            $sql1 .= " and client_acctno = '" . $data['account_id'] . "' ";
        } else {
            $account_id = "";
            $sql1 .= " and client_acctno = '' ";
        }

        if (isset($data['chart'])) {
            $sql1 .= " and chart = '" . $data['chart'] . "' ";
        }

        if (isset($data['zonefrom']) && $data['zonefrom'] != '') {
            $sql1 .= " and (zonefrom = '" . $data['zonefrom'] . "' || zoneto = '" . $data['zonefrom'] . "'  ) ";
        }

        if (isset($data['zoneto']) && $data['zoneto'] != '') {
            $sql1 .= " and (zoneto = '" . $data['zoneto'] . "' || zonefrom = '" . $data['zoneto'] . "' ) ";
        }

        $sql = "select * from deliveryfees where 1=1 " . $sql1 . " group by zonefrom,zoneto";
        //echo $sql;
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        $account_pikup = array();
        while ($row = mysqli_fetch_array($query)) {
            $q2 = mysqli_query($this->db, "select * from deliveryfees where 1=1 " . $sql1 . " and zonefrom='" . $row['zonefrom'] . "'") or die(mysqli_error($this->db));
            $zones = array();
            while ($r = mysqli_fetch_array($q2)) {
                $zones[$r['zonefrom']][$r['zoneto']][$r['svc']] = $r['price'];
            }

            $account_pikup[] = array('zonefrom' => $row['zonefrom'], 'zoneto' => $row['zoneto'], 'srv_fee' => $zones);
        }

        return $account_pikup;
    }


    public function update_deliveryfees($post)
    {
        $saved_zone = "";
        $from_zone = "";
        $to_zone = "";
        foreach ($post as $key => $value) {
            $ka = explode('__', $key);
            if ($ka[0] != "pattern" && $ka[0] != "distance") {
                ////delivery addd
                if ($ka[0] == 'nc' && $ka[1] == "delivery") {
                    if (isset($ka[2]) && $ka[2] == "zonefrom") {
                        $from_zone = $value;
                    } elseif (isset($ka[2]) && $ka[2] == "zoneto") {
                        $to_zone = $value;
                    } else {
                        $query = mysqli_query($this->db, "delete from deliveryfees where svc = " . check_mysql_string($this->db,$ka[2]) . " and client_acctno = '' and zonefrom=" . strtoupper(check_mysql_string($this->db,$from_zone)) . " and zoneto= " . strtoupper(check_mysql_string($this->db,$to_zone)) . " and chart = '" . $post['chart'] . "' ") or die(mysqli_error($this->db));

                        if ($value != "") {
                            $q = mysqli_query($this->db, "insert into deliveryfees (client_acctno,svc,zonefrom,zoneto,price,chart) values (''," . check_mysql_string($this->db,$ka[2]) . "," . strtoupper(check_mysql_string($this->db,$from_zone)) . "," . strtoupper(check_mysql_string($this->db,$to_zone)) . "," . check_mysql_string($this->db,$value) . ",'" . $post['chart'] . "'); ") or die(mysqli_error($this->db));
                        }
                    }
                }
            }
        }
    }
}
