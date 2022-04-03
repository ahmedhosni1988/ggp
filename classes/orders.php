<?php

class orders
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }

    ///////////////////////////////////////////////////////////
    public function add_orders($account_id, $user_id, $order_status, $from_name, $from_address, $from_pcode, $from_phone, $to_name, $to_address, $to_pcode, $to_phone, $pickup_time, $pickup_date, $delivery_time, $delivery_date, $driver_id, $service_id, $order_comment, $order_des, $refrence, $price, $has_package, $confirmation_mail, $transport_id, $from_zone, $to_zone, $contact, $att, $declared_value, $orderedby, $COD, $collect, $paymentterm, $packagetype, $weight, $volume, $pieces, $return, $pickup_by, $deliver_by, $order_date)
    {
        $query = mysqli_query($this->db, "INSERT INTO orders(account_id, user_id, order_status, from_name, from_address, from_pcode, from_phone, to_name, to_address, to_pcode, to_phone, pickup_time,pickup_date, delivery_time,delivery_date, driver_id, service_id, order_comment,order_des, refrence, price, has_package,confirmation_mail,transport_id,order_date,from_zone,to_zone,from_contact,to_att,declared_value,orderedby,COD,collect,paymentterm,packagetype,weight,volume,pieces,ret,pickup_by,deliver_by) 
VALUES 
(" . check_mysql_string($this->db,$account_id) . "," . check_mysql_string($this->db,$user_id) . "," . check_mysql_string($this->db,$order_status) . "," . check_mysql_string($this->db,$from_name) . "," . check_mysql_string($this->db,$from_address) . "," . check_mysql_string($this->db,$from_pcode) . "," . check_mysql_string($this->db,$from_phone) . "," . check_mysql_string($this->db,$to_name) . "," . check_mysql_string($this->db,$to_address) . "," . check_mysql_string($this->db,$to_pcode) . "," . check_mysql_string($this->db,$to_phone) . "," . check_mysql_string($this->db,$pickup_time) . "," . check_mysql_string($this->db,$pickup_date) . "," . check_mysql_string($this->db,$delivery_time) . "," . check_mysql_string($this->db,$delivery_date) . "," . check_mysql_string($this->db,$driver_id) . "," . check_mysql_string($this->db,$service_id) . "," . check_mysql_string($this->db,$order_comment) . "," . check_mysql_string($this->db,$order_des) . "," . check_mysql_string($this->db,$refrence) . "," . check_mysql_string($this->db,$price) . "," . check_mysql_string($this->db,$has_package) . "," . check_mysql_string($this->db,$confirmation_mail) . "," . check_mysql_string($this->db,$transport_id) . "," . check_mysql_string($this->db,$order_date) . "," . check_mysql_string($this->db,$from_zone) . "," . check_mysql_string($this->db,$to_zone) . "," . check_mysql_string($this->db,$contact) . "," . check_mysql_string($this->db,$att) . "," . check_mysql_string($this->db,$declared_value) . "," . check_mysql_string($this->db,$orderedby) . "," . check_mysql_string($this->db,$COD) . "," . check_mysql_string($this->db,$collect) . "," . check_mysql_string($this->db,$paymentterm) . "," . check_mysql_string($this->db,$packagetype) . "," . check_mysql_string($this->db,$weight) . "," . check_mysql_string($this->db,$volume) . ", " . check_mysql_string($this->db,$pieces) . " ," . check_mysql_string($this->db,$return) . " ," . check_mysql_string($this->db,$pickup_by) . "," . check_mysql_string($this->db,$deliver_by) . " );") or die(mysqli_error($this->db));

        if ($query) {
            return mysqli_insert_id($this->db);
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

        $q = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        return mysqli_fetch_object($q);
    }


    ////////////////////////////Edit Order///////////////////////////////////
    public function edit_orders($order_id, $from_name, $from_address, $from_pcode, $from_phone, $to_name, $to_address, $to_pcode, $to_phone, $pickup_time, $pickup_date, $delivery_time, $delivery_date, $driver_id, $service_id, $order_comment, $order_des, $refrence, $price, $has_package, $confirmation_mail, $transport_id, $from_zone, $to_zone, $contact, $att, $declared_value, $orderedby, $COD, $collect, $paymentterm, $packagetype, $weight, $volume, $pieces, $return, $overide_distance, $order_status, $pickup_by, $deliver_by)
    {
        $sql = "update orders set 

from_name = " . check_mysql_string($this->db,$from_name) . ", 
from_address = " . check_mysql_string($this->db,$from_address) . ", 
from_pcode = " . check_mysql_string($this->db,$from_pcode) . ", 
from_phone = " . check_mysql_string($this->db,$from_phone) . ", 
to_name = " . check_mysql_string($this->db,$to_name) . ", 
to_address = " . check_mysql_string($this->db,$to_address) . ", 
to_pcode = " . check_mysql_string($this->db,$to_pcode) . ", 
to_phone = " . check_mysql_string($this->db,$to_phone) . ", 
pickup_time = " . check_mysql_string($this->db,$pickup_time) . ",
pickup_date = " . check_mysql_string($this->db,$pickup_date) . ", 
delivery_time = " . check_mysql_string($this->db,$delivery_time) . ",
delivery_date = " . check_mysql_string($this->db,$delivery_date) . ", 
driver_id = " . check_mysql_string($this->db,$driver_id) . ", 
service_id = " . check_mysql_string($this->db,$service_id) . ", 
order_comment = " . check_mysql_string($this->db,$order_comment) . ",
order_des = " . check_mysql_string($this->db,$order_des) . ", 
chargecode = " . check_mysql_string($this->db,$refrence) . ", 
price = " . check_mysql_string($this->db,$price) . ", 
has_package = " . check_mysql_string($this->db,$has_package) . ",
confirmation_mail = " . check_mysql_string($this->db,$confirmation_mail) . ",
transport_id = " . check_mysql_string($this->db,$transport_id) . ",
from_zone = " . check_mysql_string($this->db,$from_zone) . ",
to_zone = " . check_mysql_string($this->db,$to_zone) . ",
from_contact = " . check_mysql_string($this->db,$contact) . ",
to_att = " . check_mysql_string($this->db,$att) . " ,
declared_value = " . check_mysql_string($this->db,$declared_value) . ",
orderedby= " . check_mysql_string($this->db,$orderedby) . ",
COD = " . check_mysql_string($this->db,$COD) . ",
collect = " . check_mysql_string($this->db,$collect) . ",
paymentterm = " . check_mysql_string($this->db,$paymentterm) . ",
packagetype = " . check_mysql_string($this->db,$packagetype) . " ,
weight = " . check_mysql_string($this->db,$weight) . ",
volume = " . check_mysql_string($this->db,$volume) . ",
pieces =" . check_mysql_string($this->db,$pieces) . " ,
ret = " . check_mysql_string($this->db,$return) . ",
override_distance = " . check_mysql_string($this->db,$overide_distance) . ",
order_status = " . check_mysql_string($this->db,$order_status) . ",
pickup_by = " . check_mysql_string($this->db,$pickup_by) . ",
deliver_by = " . check_mysql_string($this->db,$deliver_by) . "
where order_id = " . check_mysql_string($this->db,$order_id) . " ";

        //	echo $sql;
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

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
   where o.id = " . check_mysql_string($this->db,$id) . " ";

        //echo $sql;

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        $order_details = array();

        $order_details = mysqli_fetch_object($query);
        return $order_details;
    }

    public function update_order_group($array, $key)
    {
        $sql = $this->db->make_update("orders_group", $array, "id", $key);
        mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
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
 where o.order_id = " . check_mysql_string($this->db,$order_id) . " ";

        //echo $sql;

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        $order_details = array();

        $order_details = mysqli_fetch_object($query);
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

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        $order_details = array();

        $order_details = mysqli_fetch_object($query);
        return $order_details;
    }


    public function order_add_skid($order_id, $weight, $length, $width, $height, $quantiy, $total)
    {
        mysqli_query($this->db, "delete from order_skid where order_id = " . check_mysql_string($this->db,$order_id) . " ") or die(mysqli_error($this->db));
        for ($i = 0; $i < count($length); $i++) {
            if ($total[$i] != '' && $total[$i] != '0') {
                $query = mysqli_query($this->db, "insert into order_skid (order_id,weight,width,length,height,quantity,total) values (" . check_mysql_string($this->db,$order_id) . "," . check_mysql_string($this->db,$weight[$i]) . "," . check_mysql_string($this->db,$width[$i]) . "," . check_mysql_string($this->db,$length[$i]) . "," . check_mysql_string($this->db,$height[$i]) . "," . check_mysql_string($this->db,$quantiy[$i]) . "," . check_mysql_string($this->db,$total[$i]) . ");") or die(mysqli_error($this->db));
            }
        }
    }


    public function get_order_skid($order_id)
    {
        $query = mysqli_query($this->db, "select * from order_skid where order_id = " . check_mysql_string($this->db,$order_id) . " ") or die(mysqli_error($this->db));


        $order_details = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
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

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function add_new_orders($array)
    {
        $sql = $this->db->make_insert("orders", $array);


        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return mysqli_insert_id($this->db);
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
                $sql1 .= " CONCAT(o.order_comment,o.order_des) like '%" . mysqli_real_escape_string($this->db, $data['commdesc']) . "%' and";
            }

            if (isset($data['delpts']) && !empty($data['delpts'])) {
                $sql1 .= " CONCAT(o.from_name,o.from_address,o.from_pcode,o.from_contact,o.to_name,o.to_address,o.to_pcode,o.to_att) like '%" . mysqli_real_escape_string($this->db, $data['delpts']) . "%'  and";
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

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        if (mysqli_num_rows($query) < 1) {
            $arr['no_result'] = "لا توجد بيانات";

            return $arr;
        } else {
            $i = 0;
            while ($row = mysqli_fetch_assoc($query)) {
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
        $query = mysqli_query($this->db, "update orders set quoted_distance = " . check_mysql_string($this->db,$distance) . " , from_address = " . check_mysql_string($this->db,$from) . " , to_address = " . check_mysql_string($this->db,$to) . " , from_pcode = '' , to_pcode = '' where order_id = " . check_mysql_string($this->db,$order_id) . "") or die(mysqli_error($this->db));
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
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        while ($row = mysqli_fetch_assoc($query)) {
            $res[] = $row;
        }


        return $res;
    }





    public function update_order_status($id, $status)
    {
        $query = mysqli_query($this->db, "update orders set order_status=" . check_mysql_string($this->db,$status) . " where order_id = '" . $id . "'") or die(mysqli_error($this->db));
        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function get_order($order_id)
    {
        $query = mysqli_query($this->db, "select *,orders.account_id as account_id,orders.easy_order_id as easy_order_id,account.account_name ,account.account_company,orders.billing_code from orders 
inner join account on (orders.account_id = account.account_id) 
left  join users on (orders.user_id = users.user_id) 
inner join services on (orders.service_id = services.service_id)  where order_id = '$order_id'") or die(mysqli_error($this->db));

        $order_details = array();

        $order_details = mysqli_fetch_object($query);
        return $order_details;
    }


    public function order_total($order_id)
    {
        $q = mysqli_query($this->db, "select * from orders_price where order_id = '" . $order_id . "' ") or die(mysqli_error($this->db));


        $total = 0;
        while ($row = mysqli_fetch_array($q)) {
            if ($row['type'] != "total") {
                if ($row['price'] != '' && $row['price'] != '0.00') {
                    $total += $row['price'];
                }

                if ($row['override'] != '' && $row['override'] != '0.00') {
                    $total += $row['override'];
                }
            }
        }

        mysqli_query($this->db, "update orders_price set price = '" . $total . "'  where order_id = '" . $order_id . "' && type = 'total' ") or die(mysqli_error($this->db));
        mysqli_query($this->db, "update orders set price = '" . $total . "' where order_id = '" . $order_id . "'  ") or die(mysqli_error($this->db));
    }

    public function add_order_price($orderid, $name, $ratio, $price, $type, $ser_id = null, $override = null)
    {
        if ($ser_id == null) {
            if ($override == null) {
                $query = mysqli_query($this->db, "insert into orders_price(order_id,name,ratio,price,type) values (" . check_mysql_string($this->db,$orderid) . "," . check_mysql_string($this->db,$name) . "," . check_mysql_string($this->db,$ratio) . "," . check_mysql_string($this->db,$price) . "," . check_mysql_string($this->db,$type) . ");") or die(mysqli_error($this->db));
            } else {
                $query = mysqli_query($this->db, "insert into orders_price(order_id,name,ratio,price,type,override) values (" . check_mysql_string($this->db,$orderid) . "," . check_mysql_string($this->db,$name) . "," . check_mysql_string($this->db,$ratio) . "," . check_mysql_string($this->db,$price) . "," . check_mysql_string($this->db,$type) . "," . check_mysql_string($this->db,$override) . ");") or die(mysqli_error($this->db));
            }
        } else {
            if ($override == null) {
                $query = mysqli_query($this->db, "insert into orders_price(order_id,ser_id,name,ratio,price,type) values (" . check_mysql_string($this->db,$orderid) . "," . check_mysql_string($this->db,$ser_id) . "," . check_mysql_string($this->db,$name) . "," . check_mysql_string($this->db,$ratio) . "," . check_mysql_string($this->db,$price) . "," . check_mysql_string($this->db,$type) . ");") or die(mysqli_error($this->db));
            } else {
                $query = mysqli_query($this->db, "insert into orders_price(order_id,ser_id,name,ratio,price,type,override) values (" . check_mysql_string($this->db,$orderid) . "," . check_mysql_string($this->db,$ser_id) . "," . check_mysql_string($this->db,$name) . "," . check_mysql_string($this->db,$ratio) . "," . check_mysql_string($this->db,$price) . "," . check_mysql_string($this->db,$type) . "," . check_mysql_string($this->db,$override) . ");") or die(mysqli_error($this->db));
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
        $query = mysqli_query($this->db, "update orders_price set override = " . check_mysql_string($this->db,$override) . " where order_id = " . check_mysql_string($this->db,$orderid) . " and ser_id = " . check_mysql_string($this->db,$ser_id) . " and type = " . check_mysql_string($this->db,$type) . " and name = " . check_mysql_string($this->db,$name) . " ") or die(mysqli_error($this->db));
    }

    public function del_order_price($order_id)
    {
        //$q = mysqli_query($this->db,"select invoiceno from orders where order_id = ".check_mysql_string($this->db,$order_id)." ");
        //$r = mysqli_fetch_array($q);

        //if($r['invoiceno'] == "0"){
        $query = mysqli_query($this->db, "delete from orders_price where order_id = " . check_mysql_string($this->db,$order_id) . "") or die(mysqli_error($this->db));

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
        $query = mysqli_query($this->db, "delete from orders_package where id = " . $item_id . "") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function get_order_package($order_id)
    {
        $query = mysqli_query($this->db, "select * from   orders_package where order_id = " . check_mysql_string($this->db,$order_id) . " order by part_order ASC ") or die(mysqli_error($this->db));

        $order_package = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $order_package[] = $arr;
        }
        //$order_details = mysqli_fetch_object($query);
        return $order_package;
    }

    public function get_order_package_group($order_id)
    {
        $query = mysqli_query($this->db, "select orders_package.* ,  (select count(*) from orders_package as op where op.parent_id = orders_package.id) as parts   from   orders_package where order_id = " . check_mysql_string($this->db,$order_id) . "  and parent_id = 0 order by part_order") or die(mysqli_error($this->db));

        $order_package = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $row['parts'] = $row['parts']+1;

            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $order_package[] = $arr;
        }
        //$order_details = mysqli_fetch_object($query);
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

        $query = mysqli_query($this->db, "select $sql  from orders_package $innerJoin where orders_package.order_id = " . check_mysql_string($this->db,$order_id) . " order by part_order ASC ") or die(mysqli_error($this->db));

        $order_package = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $q = mysqli_query($this->db, "select orders_package_work.* , `users`.`name` from orders_package_work left join users on(orders_package_work.user_id = `users`.`user_id`) where package_id = '" . $row['id'] . "' ") or die(mysqli_error($this->db));

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



            while ($r = mysqli_fetch_array($q)) {
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
        //$order_details = mysqli_fetch_object($query);
        return $order_package;
    }


    public function get_addtional_services($order_id)
    {
        $query = mysqli_query($this->db, "select * from orders_price where order_id = " . check_mysql_string($this->db,$order_id) . " and type='addtional_services'") or die(mysqli_error($this->db));

        $order_package = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $order_package[] = $arr;
        }
        //$order_details = mysqli_fetch_object($query);
        return $order_package;
    }


    public function delete_order($order_id)
    {
        mysqli_query($this->db, "delete from order_skid where order_id = '" . $order_id . "' ") or die(mysqli_error($this->db));
        mysqli_query($this->db, "delete from orders_price where order_id = '" . $order_id . "' ") or die(mysqli_error($this->db));
        mysqli_query($this->db, "delete from orders_package where order_id = '" . $order_id . "' ") or die(mysqli_error($this->db));
        mysqli_query($this->db, "delete from orders where order_id = '" . $order_id . "' ") or die(mysqli_error($this->db));
        return true;
    }


    public function set_sort_order($order_id, $driver_id1, $driver_id2)
    {
        $query2 = mysqli_query($this->db, "select order_id,driver_id,driver_id2,sort_driver1,max(sort_driver2) from 
	orders where (driver_id2 = '" . $driver_id2 . "') 
	and orders.order_status not in (2,5)  order by sort_driver2 desc  ");

        if ($driver_id1 != "" && ($driver_id2 == "" || $driver_id2 == "0")) {
            $query = mysqli_query($this->db, "select order_id,driver_id,driver_id2,max(sort_driver1) as sort_driver1,sort_driver2 from 
		orders where (driver_id = '" . $driver_id1 . "') 
		and orders.order_status not in (2,5)  order by sort_driver1,sort_driver2 desc  ");

            $r = mysqli_fetch_array($query);
            mysqli_query($this->db, "update orders set sort_driver1 = '" . ($r['sort_driver1'] + 1) . "' where order_id = '" . $order_id . "' ") or die(mysqli_error($this->db));
        }

        if ($driver_id2 != "" && ($driver_id1 == "" || $driver_id1 == "0")) {
        }

        if ($driver_id2 != "" && $driver_id1 != "" && ($driver_id1 != "0" || $driver_id2 != "0")) {
        }
    }
}
