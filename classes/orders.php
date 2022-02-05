<?php

class orders
{
    public $db;

    public function orders($db)
    {
        $this->db = $db;
    }

    ///////////////////////////////////////////////////////////
    public function add_orders($account_id, $user_id, $order_status, $from_name, $from_address, $from_pcode, $from_phone, $to_name, $to_address, $to_pcode, $to_phone, $pickup_time, $pickup_date, $delivery_time, $delivery_date, $driver_id, $service_id, $order_comment, $order_des, $refrence, $price, $has_package, $confirmation_mail, $transport_id, $from_zone, $to_zone, $contact, $att, $declared_value, $orderedby, $COD, $collect, $paymentterm, $packagetype, $weight, $volume, $pieces, $return, $pickup_by, $deliver_by, $order_date)
    {
        $query = mysql_query("INSERT INTO orders(account_id, user_id, order_status, from_name, from_address, from_pcode, from_phone, to_name, to_address, to_pcode, to_phone, pickup_time,pickup_date, delivery_time,delivery_date, driver_id, service_id, order_comment,order_des, refrence, price, has_package,confirmation_mail,transport_id,order_date,from_zone,to_zone,from_contact,to_att,declared_value,orderedby,COD,collect,paymentterm,packagetype,weight,volume,pieces,ret,pickup_by,deliver_by) 
VALUES 
(" . $this->db->qstr($account_id) . "," . $this->db->qstr($user_id) . "," . $this->db->qstr($order_status) . "," . $this->db->qstr($from_name) . "," . $this->db->qstr($from_address) . "," . $this->db->qstr($from_pcode) . "," . $this->db->qstr($from_phone) . "," . $this->db->qstr($to_name) . "," . $this->db->qstr($to_address) . "," . $this->db->qstr($to_pcode) . "," . $this->db->qstr($to_phone) . "," . $this->db->qstr($pickup_time) . "," . $this->db->qstr($pickup_date) . "," . $this->db->qstr($delivery_time) . "," . $this->db->qstr($delivery_date) . "," . $this->db->qstr($driver_id) . "," . $this->db->qstr($service_id) . "," . $this->db->qstr($order_comment) . "," . $this->db->qstr($order_des) . "," . $this->db->qstr($refrence) . "," . $this->db->qstr($price) . "," . $this->db->qstr($has_package) . "," . $this->db->qstr($confirmation_mail) . "," . $this->db->qstr($transport_id) . "," . $this->db->qstr($order_date) . "," . $this->db->qstr($from_zone) . "," . $this->db->qstr($to_zone) . "," . $this->db->qstr($contact) . "," . $this->db->qstr($att) . "," . $this->db->qstr($declared_value) . "," . $this->db->qstr($orderedby) . "," . $this->db->qstr($COD) . "," . $this->db->qstr($collect) . "," . $this->db->qstr($paymentterm) . "," . $this->db->qstr($packagetype) . "," . $this->db->qstr($weight) . "," . $this->db->qstr($volume) . ", " . $this->db->qstr($pieces) . " ," . $this->db->qstr($return) . " ," . $this->db->qstr($pickup_by) . "," . $this->db->qstr($deliver_by) . " );") or die(mysql_error());

        if ($query) {
            return mysql_insert_id();
        } else {
            return 0;
        }
    }

    ///////////////////////get order/

    public function get_order_sdetails($order_id, $details)
    {
        $sql = "select ";
        foreach ($details as $item) {
            $sql .= $item . ",";
        }
        $sql .= "order_id from orders where order_id = '" . $order_id . "' ";

        $q = mysql_query($sql) or die(mysql_error());

        return mysql_fetch_object($q);
    }


    ////////////////////////////Edit Order///////////////////////////////////
    public function edit_orders($order_id, $from_name, $from_address, $from_pcode, $from_phone, $to_name, $to_address, $to_pcode, $to_phone, $pickup_time, $pickup_date, $delivery_time, $delivery_date, $driver_id, $service_id, $order_comment, $order_des, $refrence, $price, $has_package, $confirmation_mail, $transport_id, $from_zone, $to_zone, $contact, $att, $declared_value, $orderedby, $COD, $collect, $paymentterm, $packagetype, $weight, $volume, $pieces, $return, $overide_distance, $order_status, $pickup_by, $deliver_by)
    {
        $sql = "update orders set 

from_name = " . $this->db->qstr($from_name) . ", 
from_address = " . $this->db->qstr($from_address) . ", 
from_pcode = " . $this->db->qstr($from_pcode) . ", 
from_phone = " . $this->db->qstr($from_phone) . ", 
to_name = " . $this->db->qstr($to_name) . ", 
to_address = " . $this->db->qstr($to_address) . ", 
to_pcode = " . $this->db->qstr($to_pcode) . ", 
to_phone = " . $this->db->qstr($to_phone) . ", 
pickup_time = " . $this->db->qstr($pickup_time) . ",
pickup_date = " . $this->db->qstr($pickup_date) . ", 
delivery_time = " . $this->db->qstr($delivery_time) . ",
delivery_date = " . $this->db->qstr($delivery_date) . ", 
driver_id = " . $this->db->qstr($driver_id) . ", 
service_id = " . $this->db->qstr($service_id) . ", 
order_comment = " . $this->db->qstr($order_comment) . ",
order_des = " . $this->db->qstr($order_des) . ", 
chargecode = " . $this->db->qstr($refrence) . ", 
price = " . $this->db->qstr($price) . ", 
has_package = " . $this->db->qstr($has_package) . ",
confirmation_mail = " . $this->db->qstr($confirmation_mail) . ",
transport_id = " . $this->db->qstr($transport_id) . ",
from_zone = " . $this->db->qstr($from_zone) . ",
to_zone = " . $this->db->qstr($to_zone) . ",
from_contact = " . $this->db->qstr($contact) . ",
to_att = " . $this->db->qstr($att) . " ,
declared_value = " . $this->db->qstr($declared_value) . ",
orderedby= " . $this->db->qstr($orderedby) . ",
COD = " . $this->db->qstr($COD) . ",
collect = " . $this->db->qstr($collect) . ",
paymentterm = " . $this->db->qstr($paymentterm) . ",
packagetype = " . $this->db->qstr($packagetype) . " ,
weight = " . $this->db->qstr($weight) . ",
volume = " . $this->db->qstr($volume) . ",
pieces =" . $this->db->qstr($pieces) . " ,
ret = " . $this->db->qstr($return) . ",
override_distance = " . $this->db->qstr($overide_distance) . ",
order_status = " . $this->db->qstr($order_status) . ",
pickup_by = " . $this->db->qstr($pickup_by) . ",
deliver_by = " . $this->db->qstr($deliver_by) . "
where order_id = " . $this->db->qstr($order_id) . " ";

        //	echo $sql;
        $query = mysql_query($sql) or die(mysql_error());

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    ///function to get order group details

    public function get_orders_group($id)
    {
        $sql = "select 
	o.id,
	o.group_type,
	o.file_name,
	o.created_file_name,
	o.imported,
	o.service_id,
	o.status_id,
	o.driver_id,
	o.date_status,
	ds.name,
	ds.driverno,
	st.statusname,
	a.account_id,
	a.account_name,
	a.account_company,
	s.service_name,
	u.user_name 
	from orders_group as o 
	inner join status as st on (o.status_id=st.id) 	
	inner join account as a on (o.account_id=a.account_id) 
	inner join services as s on (o.service_id = s.service_id) 
	inner join users as u on (u.user_id = o.user_id) 
	left join drivers as ds on (o.driver_id = ds.id)
   where o.id = " . $this->db->qstr($id) . " ";

        //echo $sql;

        $query = mysql_query($sql) or die(mysql_error());

        $order_details = array();

        $order_details = mysql_fetch_object($query);
        return $order_details;
    }

    public function update_order_group($array, $key)
    {
        $sql = $this->db->make_update("orders_group", $array, "id", $key);
        mysql_query($sql) or die(mysql_error());
    }

    //////////////////////////////////////////////////////////////

    public function get_order_waybill($order_id)
    {
        $sql = "select 
o.order_id,
o.easy_order_id,
o.order_date,
o.office_name,
o.operation_name,
o.service_id,
o.pickup_date,
o.delivery_date,
o.pieces,
o.order_date,
o.order_size,
o.orderedby,
o.order_comment,
o.order_status,
o.billing_code,
o.option_type,
a.account_id,
a.account_name,
a.account_company,
s.service_name,
u.name
from orders as o 
left join account as a on (o.account_id=a.account_id) 
left join services as s on (o.service_id = s.service_id) 
left join users as u on (u.user_id = o.user_id) 
 where o.order_id = " . $this->db->qstr($order_id) . " ";

        //echo $sql;

        $query = mysql_query($sql) or die(mysql_error());

        $order_details = array();

        $order_details = mysql_fetch_object($query);
        return $order_details;
    }


    public function get_order_details($order_id)
    {
        $sql = "select 
o.*,
ds.*,
a.*,
s.*,
u.*,
os.*
from orders as o 
inner join account as a on (o.account_id=a.account_id) 
inner join services as s on (o.service_id = s.service_id) 
left join users as u on (u.user_id = o.user_id) 
inner join status as os on ( os.id = o.order_status )
left join drivers as ds on (o.driver_id = ds.id) 
where order_id = '$order_id'";

        $query = mysql_query($sql) or die(mysql_error());

        $order_details = array();

        $order_details = mysql_fetch_object($query);
        return $order_details;
    }


    public function order_add_skid($order_id, $weight, $length, $width, $height, $quantiy, $total)
    {
        mysql_query("delete from order_skid where order_id = " . $this->db->qstr($order_id) . " ") or die(mysql_error());
        for ($i = 0; $i < count($length); $i++) {
            if ($total[$i] != '' && $total[$i] != '0') {
                $query = mysql_query("insert into order_skid (order_id,weight,width,length,height,quantity,total) values (" . $this->db->qstr($order_id) . "," . $this->db->qstr($weight[$i]) . "," . $this->db->qstr($width[$i]) . "," . $this->db->qstr($length[$i]) . "," . $this->db->qstr($height[$i]) . "," . $this->db->qstr($quantiy[$i]) . "," . $this->db->qstr($total[$i]) . ");") or die(mysql_error());
            }
        }
    }


    public function get_order_skid($order_id)
    {
        $query = mysql_query("select * from order_skid where order_id = " . $this->db->qstr($order_id) . " ") or die(mysql_error());


        $order_details = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $order_details[] = $arr;
        }

        return $order_details;
    }

    public function update_orders($array, $order_id)
    {
        $sql = $this->db->make_update("orders", $array, "order_id", $order_id);
        //echo $sql;

        $query = mysql_query($sql) or die(mysql_error());

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function add_new_orders($array)
    {
        $sql = $this->db->make_insert("orders", $array);


        $query = mysql_query($sql) or die(mysql_error());

        if ($query) {
            return mysql_insert_id();
        } else {
            return false;
        }
    }

    public function get_search($data, $count = null)
    {
        $order_details = array();
        $sql = "select 
        o.order_id,
        o.easy_order_id,
        a.account_company,
		o.office_name,
		o.operation_name,
		o.pieces,
		(o.order_size / 10000) as Quantity,
		s.service_name,
        o.order_status,
		pickup_Date,
        delivery_date
        		from orders as o 
		inner join account as a on (o.account_id=a.account_id) 
		inner join services as s on (o.service_id = s.service_id)   
		inner join status  on (status.id = o.order_status)
where ";
        $sql1 = "";
        if (!empty($data['account_id']) && $data['account_id'] != "") {
            $sql1 .= " o.account_id = '" . $data['account_id'] . "' and";
        }

        if (!empty($data['billing_code']) && $data['billing_code'] != "") {
            $sql1 .= " o.billing_code = '" . $data['billing_code'] . "' and";
        }


        if (!empty($data['order_id'])) {
            $sql1 .= " o.order_id = '" . $data['order_id'] . "' and";
        } elseif (!empty($data['easy_order_id'])) {
            $sql1 .= " o.easy_order_id = '" . $data['easy_order_id'] . "' and";
        } else {
            if (!empty($data['account_id']) && $data['account_id'] != "") {
                $sql1 .= " o.account_id = '" . $data['account_id'] . "' and";
            }

            if (!empty($data['office_name'])) {
                $sql1 .= " o.office_name LIKE '%" . $data['office_name'] . "%'   and";
            }

            if (!empty($data['operation_name'])) {
                $sql1 .= " o.operation_name LIKE '%" . $data['operation_name'] . "%'   and";
            }

            if (!empty($data['service_id']) && $data['service_id'] != "") {
                $sql1 .= " o.service_id = '" . $data['service_id'] . "'  and";
            }

            if (!empty($data['priced_dollar']) && $data['priced_dollar'] != "") {
                $sql1 .= " orders_price.price = '" . $data['priced_dollar'] . "'  and";
            }

            if (!empty($data['refrence']) && $data['refrence'] != "") {
                $sql1 .= " o.chargecode LIKE '%" . $data['refrence'] . "%'  and";
            }

            if (!empty($data['transport_type'])) {
                $sql1 .= " o.transport_id = '" . $data['transport_type'] . "'  and";
            }

            if (!empty($data['type'])) {
                if ($data['type'] == '3') {
                    $sql1 .= " o.order_status in ( '" . $data['type'] . "')  and";
                } elseif ($data['type'] == '1') {
                    $sql1 .= " o.order_status not in ( '3')  and";
                }
            }

            if (!empty($data['order_status'])) {
                $sql1 .= " o.order_status in( " . substr($data['order_status'], 0, strlen($data['order_status']) - 1) . " )  and";
            }

            if (isset($data['commdesc']) && !empty($data['commdesc'])) {
                $sql1 .= " CONCAT(o.order_comment,o.order_des) like '%" . mysql_real_escape_string($data['commdesc']) . "%' and";
            }

            if (isset($data['delpts']) && !empty($data['delpts'])) {
                $sql1 .= " CONCAT(o.from_name,o.from_address,o.from_pcode,o.from_contact,o.to_name,o.to_address,o.to_pcode,o.to_att) like '%" . mysql_real_escape_string($data['delpts']) . "%'  and";
            }


            if (isset($data['from_zone']) && !empty($data['from_zone'])) {
                $sql1 .= " o.from_zone = '" . $data['from_zone'] . "'  and";
            }

            if (isset($data['to_zone']) && !empty($data['to_zone'])) {
                $sql1 .= " o.to_zone <= '" . $data['to_zone'] . "'  and";
            }

            if (isset($data['driver_id']) && !empty($data['driver_id']) && $data['driver_id'] != '*') {
                $sql1 .= " o.driver_id = '" . $data['driver_id'] . "'  and";
            }


            // if (isset($data['driver_id']) && !empty($data['driver_id']) && $data['driver_id'] != '*' ){
            // 	$sql1 .= " o.driver_id2 = '".$data['driver_id']."'  and";
            // }


            if (isset($data['pricing']) && !empty($data['pricing']) && $data['pricing'] != "All") {
                if ($data['pricing'] == "priced") {
                    $sql1 .= " o.price > '0'  and";
                }
                if ($data['pricing'] == "Notpriced") {
                    $sql1 .= " (o.price = '0' or o.price = '' ) and";
                }
            }


            if (isset($data['searchdate']) && empty($data['order_id'])) {
                if ($data['searchdate'] == "order_date" || $data['searchdate'] == "actual_delivery_time") {
                    $x = " 00:00:00";
                } else {
                    $x = "";
                }

                if ($data['searchdate'] == "order_date" || $data['searchdate'] == "actual_delivery_time") {
                    $y = " 23:00:00";
                } else {
                    $y = "";
                }

                if (!empty($data['date_from']) && $data['date_from'] != '') {
                    $sql1 .= " o." . $data['searchdate'] . "   >= '" . $data['date_from'] . $x . "'  and";
                }

                if (!empty($data['date_to']) && $data['date_to'] != '') {
                    $sql1 .= " o." . $data['searchdate'] . " <= '" . $data['date_to'] . $y . "'  and";
                }
            }

            ////end search option without order_id
        }

        if (!empty($data['invoice'])) {
            if ($data['invoice'] == "All") {
                $sql1 .= "";
            }
            if ($data['invoice'] == "Invoiced") {
                $sql1 .= " o.invoiceno != '0' and";
            }
            if ($data['invoice'] == "Not Invoiced") {
                $sql1 .= " o.invoiceno = '0' and";
            }
        }


        if ($sql1 == "") {
            $arr['no_result'] = "Please Select one Crietria";

            return $arr;
        }

        $sql1 = substr($sql1, 0, strlen($sql1) - 3);
        $sql = $sql . $sql1 . " order by o.order_id DESC";

        //echo $sql;

        $query = mysql_query($sql) or die(mysql_error());


        if (mysql_num_rows($query) < 1) {
            $arr['no_result'] = "لا توجد بيانات";

            return $arr;
        } else {
            $i = 0;
            while ($row = mysql_fetch_assoc($query)) {
                foreach ($row as $key => $value) {
                    $arr[$key] = $value;
                }

                $order_details[] = $arr;
            }
        }

        return $order_details;
    }


    public function update_order_distance($order_id, $from, $to, $distance)
    {
        $query = mysql_query("update orders set quoted_distance = " . $this->db->qstr($distance) . " , from_address = " . $this->db->qstr($from) . " , to_address = " . $this->db->qstr($to) . " , from_pcode = '' , to_pcode = '' where order_id = " . $this->db->qstr($order_id) . "") or die(mysql_error());
    }

    public function update_order_driver($order_id, $driver_id, $driver_id2 = null)
    {
    }

    public function search_items($account_name, $width, $length)
    {
        $sql = "select orders_package.*,
        orders.glass_type,
        orders.office_name,
        orders.operation_name,
        orders.account_id,
        orders.order_id,
        package_type.package_name,
        account.account_name,
        account.account_company,
       inventory_items_company.company_name 
       from orders_package 
       inner join package_type on (package_type.package_id = orders_package.package_type )
       inner join orders on (orders_package.order_id = orders.order_id) 
       inner join inventory_items_company on (orders.glass_type = inventory_items_company.id)
       inner join account on (account.account_id = orders.account_id) 
        WHERE 
        orders_package.length = '$length'
        AND orders_package.width ='$width'
         ";

        if ($account_name != '') {
            $sql .= "AND account.account_id = '$account_name'";
        }

        //  echo $sql;
        $query = mysql_query($sql) or die(mysql_error());

        while ($row = mysql_fetch_assoc($query)) {
            $res[] = $row;
        }


        return $res;
    }





    public function update_order_status($id, $status)
    {
        $query = mysql_query("update orders set order_status=" . $this->db->qstr($status) . " where order_id = '" . $id . "'") or die(mysql_error());
        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function get_order($order_id)
    {
        $query = mysql_query("select *,orders.account_id as account_id,orders.easy_order_id as easy_order_id,account.account_name ,account.account_company,orders.billing_code from orders 
inner join account on (orders.account_id = account.account_id) 
left  join users on (orders.user_id = users.user_id) 
inner join services on (orders.service_id = services.service_id)  where order_id = '$order_id'") or die(mysql_error());

        $order_details = array();

        $order_details = mysql_fetch_object($query);
        return $order_details;
    }


    public function order_total($order_id)
    {
        $q = mysql_query("select * from orders_price where order_id = '" . $order_id . "' ") or die(mysql_error());


        $total = 0;
        while ($row = mysql_fetch_array($q)) {
            if ($row['type'] != "total") {
                if ($row['price'] != '' && $row['price'] != '0.00') {
                    $total += $row['price'];
                }

                if ($row['override'] != '' && $row['override'] != '0.00') {
                    $total += $row['override'];
                }
            }
        }

        mysql_query("update orders_price set price = '" . $total . "'  where order_id = '" . $order_id . "' && type = 'total' ") or die(mysql_error());
        mysql_query("update orders set price = '" . $total . "' where order_id = '" . $order_id . "'  ") or die(mysql_error());
    }

    public function add_order_price($orderid, $name, $ratio, $price, $type, $ser_id = null, $override = null)
    {
        if ($ser_id == null) {
            if ($override == null) {
                $query = mysql_query("insert into orders_price(order_id,name,ratio,price,type) values (" . $this->db->qstr($orderid) . "," . $this->db->qstr($name) . "," . $this->db->qstr($ratio) . "," . $this->db->qstr($price) . "," . $this->db->qstr($type) . ");") or die(mysql_error());
            } else {
                $query = mysql_query("insert into orders_price(order_id,name,ratio,price,type,override) values (" . $this->db->qstr($orderid) . "," . $this->db->qstr($name) . "," . $this->db->qstr($ratio) . "," . $this->db->qstr($price) . "," . $this->db->qstr($type) . "," . $this->db->qstr($override) . ");") or die(mysql_error());
            }
        } else {
            if ($override == null) {
                $query = mysql_query("insert into orders_price(order_id,ser_id,name,ratio,price,type) values (" . $this->db->qstr($orderid) . "," . $this->db->qstr($ser_id) . "," . $this->db->qstr($name) . "," . $this->db->qstr($ratio) . "," . $this->db->qstr($price) . "," . $this->db->qstr($type) . ");") or die(mysql_error());
            } else {
                $query = mysql_query("insert into orders_price(order_id,ser_id,name,ratio,price,type,override) values (" . $this->db->qstr($orderid) . "," . $this->db->qstr($ser_id) . "," . $this->db->qstr($name) . "," . $this->db->qstr($ratio) . "," . $this->db->qstr($price) . "," . $this->db->qstr($type) . "," . $this->db->qstr($override) . ");") or die(mysql_error());
            }
        }

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function update_order_price($orderid, $name, $type, $ser_id, $override)
    {
        $query = mysql_query("update orders_price set override = " . $this->db->qstr($override) . " where order_id = " . $this->db->qstr($orderid) . " and ser_id = " . $this->db->qstr($ser_id) . " and type = " . $this->db->qstr($type) . " and name = " . $this->db->qstr($name) . " ") or die(mysql_error());
    }

    public function del_order_price($order_id)
    {
        //$q = mysql_query("select invoiceno from orders where order_id = ".$this->db->qstr($order_id)." ");
        //$r = mysql_fetch_array($q);

        //if($r['invoiceno'] == "0"){
        $query = mysql_query("delete from orders_price where order_id = " . $this->db->qstr($order_id) . "") or die(mysql_error());

        //	}else{
        //	return false;
        //	}


        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    
    public function del_order_item($item_id)
    {
        //DELETE FROM orders_package WHERE id =  " 753 "
        $query = mysql_query("delete from orders_package where id = " . $item_id . "") or die(mysql_error());

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function get_order_package($order_id)
    {
        $query = mysql_query("select * from   orders_package where order_id = " . $this->db->qstr($order_id) . " order by part_order ASC ") or die(mysql_error());

        $order_package = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $order_package[] = $arr;
        }
        //$order_details = mysql_fetch_object($query);
        return $order_package;
    }

    public function get_order_package_group($order_id)
    {
        $query = mysql_query("select orders_package.* ,  (select count(*) from orders_package as op where op.parent_id = orders_package.id) as parts   from   orders_package where order_id = " . $this->db->qstr($order_id) . "  and parent_id = 0 order by part_order") or die(mysql_error());

        $order_package = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($query)) {
            $row['parts'] = $row['parts']+1;

            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $order_package[] = $arr;
        }
        //$order_details = mysql_fetch_object($query);
        return $order_package;
    }


    public function get_order_package_details($order_id, $service_id = "2")
    {
        if ($service_id == "2") {
            $sql = "id,part_order,length,width,package_type.package_name,glasscolour,glassType,glassPointing,details_2";
            $innerJoin = " inner join package_type on (package_type.package_id = orders_package.package_type ) ";
        } else {
            $sql = "id,part_order,length,width,package_type,glasscolour,glassPrint,glassType,glassScarch,glassPointing,glassFixedPointing,noofprinting,colorofprinting";
        }

        $query = mysql_query("select $sql  from orders_package $innerJoin where orders_package.order_id = " . $this->db->qstr($order_id) . " order by part_order ASC ") or die(mysql_error());

        $order_package = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $q = mysql_query("select orders_package_work.* , `users`.`name` from orders_package_work left join users on(orders_package_work.user_id = `users`.`user_id`) where package_id = '" . $row['id'] . "' ") or die(mysql_error());

            $arr['2']['on'] = "";
            $arr['2']['done'] = "";
            $arr['2']['p_type'] = "";
            $arr['2']['scratche'] = "";
            $arr['2']['in_work'] = "";
            $arr['2']['out_work'] = "";

            $arr['3']['on'] = "";
            $arr['3']['done'] = "";
            $arr['3']['p_type'] = "";
            $arr['3']['scratche'] = "";
            $arr['3']['in_work'] = "";
            $arr['3']['out_work'] = "";
            
            $arr['7']['on'] = "";
            $arr['7']['done'] = "";
            $arr['7']['p_type'] = "";
            $arr['7']['scratche'] = "";
            $arr['7']['in_work'] = "";
            $arr['7']['out_work'] = "";

            $arr['4']['on'] = "";
            $arr['4']['done'] = "";
            $arr['4']['p_type'] = "";
            $arr['4']['scratche'] = "";
            $arr['4']['in_work'] = "";
            $arr['4']['out_work'] = "";


            $arr['5']['on'] = "";
            $arr['5']['done'] = "";
            $arr['5']['p_type'] = "";
            $arr['5']['scratche'] = "";
            $arr['5']['in_work'] = "";
            $arr['5']['out_work'] = "";

            $arr['6']['on'] = "";
            $arr['6']['done'] = "";
            $arr['6']['p_type'] = "";
            $arr['6']['scratche'] = "";
            $arr['6']['in_work'] = "";
            $arr['6']['out_work'] = "";



            while ($r = mysql_fetch_array($q)) {
                $arr[$r['operation']]['on'] = "1";
                $arr[$r['operation']]['p_type'] = $r['p_type'];
                $arr[$r['operation']]['scratche'] = $r['scratche'];
                $arr[$r['operation']]['in_work'] = $r['in_work'];
                $arr[$r['operation']]['out_work'] = $r['out_work'];
                $arr[$r['operation']]['name'] = $r['name'];

                if ($r['status'] == "3") {
                    $arr[$r['operation']]['done'] = "1";
                }
            }


            $order_package[] = $arr;
        }
        //$order_details = mysql_fetch_object($query);
        return $order_package;
    }


    public function get_addtional_services($order_id)
    {
        $query = mysql_query("select * from orders_price where order_id = " . $this->db->qstr($order_id) . " and type='addtional_services'") or die(mysql_error());

        $order_package = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $order_package[] = $arr;
        }
        //$order_details = mysql_fetch_object($query);
        return $order_package;
    }


    public function delete_order($order_id)
    {
        mysql_query("delete from order_skid where order_id = '" . $order_id . "' ") or die(mysql_error());
        mysql_query("delete from orders_price where order_id = '" . $order_id . "' ") or die(mysql_error());
        mysql_query("delete from orders_package where order_id = '" . $order_id . "' ") or die(mysql_error());
        mysql_query("delete from orders where order_id = '" . $order_id . "' ") or die(mysql_error());
        return true;
    }


    public function set_sort_order($order_id, $driver_id1, $driver_id2)
    {
        $query2 = mysql_query("select order_id,driver_id,driver_id2,sort_driver1,max(sort_driver2) from 
	orders where (driver_id2 = '" . $driver_id2 . "') 
	and orders.order_status not in (2,5)  order by sort_driver2 desc  ");

        if ($driver_id1 != "" && ($driver_id2 == "" || $driver_id2 == "0")) {
            $query = mysql_query("select order_id,driver_id,driver_id2,max(sort_driver1) as sort_driver1,sort_driver2 from 
		orders where (driver_id = '" . $driver_id1 . "') 
		and orders.order_status not in (2,5)  order by sort_driver1,sort_driver2 desc  ");

            $r = mysql_fetch_array($query);
            mysql_query("update orders set sort_driver1 = '" . ($r['sort_driver1'] + 1) . "' where order_id = '" . $order_id . "' ") or die(mysql_error());
        }

        if ($driver_id2 != "" && ($driver_id1 == "" || $driver_id1 == "0")) {
        }

        if ($driver_id2 != "" && $driver_id1 != "" && ($driver_id1 != "0" || $driver_id2 != "0")) {
        }
    }
}
