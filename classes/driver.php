<?php

class driver
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }


    public function add_driver()
    {
    }

    public function get_driver_grid()
    {
        $query = mysqli_query($this->db, "select id,name,driverno,imei from  drivers where active = 'Y' and is_hub = 'N' order by name, driverno   ") or die(mysqli_error($this->db));

        $drivers = array();

        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $drivers[] = $arr;
        }

        return $drivers;
    }


    public function get_driver_grid_all()
    {
        $query = mysqli_query($this->db, "select id,name,driverno,imei from  drivers order by driverno   ") or die(mysqli_error($this->db));

        $drivers = array();

        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $drivers[] = $arr;
        }

        return $drivers;
    }

    public function update_payment($payment_id, $payment_name, $payment_order)
    {
        $sql = "update payment_type set payment_name = " . check_mysql_string($this->db,$payment_name) . ",	payment_order  = " . check_mysql_string($this->db,$payment_order) . "  where payment_id = " . check_mysql_string($this->db,$payment_id) . "";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function add_payment($payment_name, $payment_order)
    {
        $sql = "insert into payment_type (payment_name,payment_order) values(" . check_mysql_string($this->db,$payment_name) . "," . check_mysql_string($this->db,$payment_order) . ") ";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function get_driver($d_id)
    {
        $query = mysqli_query($this->db, "select * from  drivers where driverno = '$d_id' ") or die(mysqli_error($this->db));

        $row = mysqli_fetch_object($query);

        return $row;
    }

    public function get_driver_by_id($d_id)
    {
        $query = mysqli_query($this->db, "select * from  drivers where id = '$d_id' ") or die(mysqli_error($this->db));

        $row = mysqli_fetch_object($query);

        return $row;
    }


    public function get_driver_array_id($d_id)
    {
        $query = mysqli_query($this->db, "select * from  drivers where id = '$d_id' ") or die(mysqli_error($this->db));

        $row = mysqli_fetch_array($query);

        return $row;
    }


    public function get_driver_id($d_id)
    {
        $query = mysqli_query($this->db, "select * from  drivers where driverno = '$d_id' ") or die(mysqli_error($this->db));

        $row = mysqli_fetch_object($query);

        return $row->id;
    }

    public function get_driver_category_all($driver_id)
    {
        $driver_id = $this->get_driver_id($driver_id);

        $query = mysqli_query($this->db, "select * from drivers_category where driver_id = " . check_mysql_string($this->db,$driver_id) . "") or die(mysqli_error($this->db));

        $drivers = array();

        while ($row = mysqli_fetch_array($query)) {
            $drivers[$row['cat_id']] = $row['driver_id'];
        }

        return $drivers;
    }

    public function edit_driver_category($driver_id, $category)
    {
        $query = mysqli_query($this->db, "delete  from drivers_category where driver_id = " . check_mysql_string($this->db,$driver_id) . "") or die(mysqli_error($this->db));

        for ($i = 0; $i < count($category); $i++) {
            $query = mysqli_query($this->db, "insert into drivers_category (cat_id,driver_id) values (" . check_mysql_string($this->db,$category[$i]) . "," . check_mysql_string($this->db,$driver_id) . ") ;") or die(mysqli_error($this->db));
        }
    }


    public function get_driver_services($id)
    {
        $driver_id = $this->get_driver_id($id);

        $query = mysqli_query($this->db, "select * from  drivers_services where driver_id= " . check_mysql_string($this->db,$driver_id) . "   ") or die(mysqli_error($this->db));

        $drivers = array();

        while ($row = mysqli_fetch_assoc($query)) {
            $drivers[$row['service_id']] = array('complete' => $row['complete'], 'pickup_only' => $row['pickup_only'], 'delivery_only' => $row['delivery_only']);
        }

        return $drivers;
    }

    public function get_driver_billing($id)
    {
        $driver_id = $this->get_driver_id($id);

        $query = mysqli_query($this->db, "select * from  drivers_billingcode  where driver_id= " . check_mysql_string($this->db,$driver_id) . "   ") or die(mysqli_error($this->db));

        $drivers = array();

        while ($row = mysqli_fetch_assoc($query)) {
            $drivers[$row['bill_id']] = array('rate' => $row['rate'], 'type' => $row['type']);
        }

        return $drivers;
    }


    public function edit_driver_services($driver_id, $complete, $pickup_only, $delivery_only, $ser)
    {
        $query = mysqli_query($this->db, "delete  from drivers_services where driver_id = " . check_mysql_string($this->db,$driver_id) . "") or die(mysqli_error($this->db));

        for ($i = 0; $i < count($ser); $i++) {
            $query = mysqli_query($this->db, "insert into drivers_services (driver_id,service_id,complete,pickup_only,delivery_only) values (" . check_mysql_string($this->db,$driver_id) . "," . check_mysql_string($this->db,$ser[$i]['service_id']) . "," . check_mysql_string($this->db,$complete[$ser[$i]['service_id']]) . "," . check_mysql_string($this->db,$pickup_only[$ser[$i]['service_id']]) . "," . check_mysql_string($this->db,$delivery_only[$ser[$i]['service_id']]) . ") ;") or die(mysqli_error($this->db));
        }
    }


    public function edit_driver_billing($driver_id, $rate, $type, $billing)
    {
        $query = mysqli_query($this->db, "delete from drivers_billingcode where driver_id = " . check_mysql_string($this->db,$driver_id) . " ") or die(mysqli_error($this->db));

        for ($i = 0; $i < count($billing); $i++) {
            if ($rate[$billing[$i]['id']] != "" && $rate[$billing[$i]['id']] != "0") {
                mysqli_query($this->db, "insert into drivers_billingcode (driver_id,bill_id,rate,type) values (" . check_mysql_string($this->db,$driver_id) . "," . check_mysql_string($this->db,$billing[$i]['id']) . "," . check_mysql_string($this->db,$rate[$billing[$i]['id']]) . "," . check_mysql_string($this->db,$type[$billing[$i]['id']]) . "); ") or die(mysqli_error($this->db));
            }
        }
    }


    public function auto_dispatche_driver($account_location, $account_category, $order_id)
    {
        $sql = "select drivers.* from drivers inner join drivers_category on (drivers.id = drivers_category.driver_id ) where drivers.active='Y'  and (drivers_category.cat_id = " . check_mysql_string($this->db,$account_location) . " or drivers_category.cat_id = " . check_mysql_string($this->db,$account_category) . ") order by id ASC limit 1";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        if (mysqli_num_rows($query) > 0) {
            //$row = mysqli_fetch_object($query);
            $row = $this->db->build_array($query);
            /*
            $q = mysqli_query($this->db,"update orders set driver_id = ".check_mysql_string($this->db,$row->id)." where order_id = ".check_mysql_string($this->db,$order_id)." ") or die (mysqli_error($this->db));
            */
            return $row;
        } else {
            return false;
        }
    }


    public function get_admin_driver()
    {
        $sql = "select * from drivers where allow_assign = 'Y' ";
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        if (mysqli_num_rows($query) > 0) {
            //$row = mysqli_fetch_object($query);
            $row = $this->db->build_array($query);

            return $row[0];
        } else {
            return false;
        }
    }


    public function get_auto_assign_driver($account_location, $account_category)
    {
        $sql = "select drivers.* from drivers inner join drivers_category on (drivers.id = drivers_category.driver_id ) where drivers.active='Y' and drivers.auto_assign = 'Y' and (drivers_category.cat_id = " . check_mysql_string($this->db,$account_location) . " or drivers_category.cat_id = " . check_mysql_string($this->db,$account_category) . ") order by id ASC limit 1";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        if (mysqli_num_rows($query) > 0) {
            //$row = mysqli_fetch_object($query);
            $row = $this->db->build_array($query);

            return $row[0];
        } else {
            return false;
        }
    }


    public function get_driver_order_commission($driver_id, $order_id)
    {
        $sql = "select * from orders_driver_commission where driver_id = '" . $driver_id . "' and order_id = '" . $order_id . "' ";
        $q = mysqli_query($this->db, $sql);

        $result = array();
        while ($row = mysqli_fetch_assoc($q)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $result[$row['commission_name']] = $arr;
        }

        return $result;
    }


    public function get_services_commission($service_id, $driver_id, $type = "")
    {
        if ($type == "") {
            $get = "complete";
        } elseif ($type == "pickup_") {
            $get = "pickup_only";
        } elseif ($type == "deliver_") {
            $get = "delivery_only";
        }

        $query = mysqli_query($this->db, "select drivers_services.driver_id,
 			drivers_services.service_id,
 			drivers_services.$get as complete,
 			" . $type . "commission_pct_waittime as commission_pct_waittime,
 			" . $type . "commission_pct_extra as commission_pct_extra,
 			" . $type . "commission_pct_fs as commission_pct_fs 
 			from  drivers_services inner join drivers on (drivers.id=drivers_services.driver_id) where drivers_services.driver_id = '" . $driver_id . "' && drivers_services.service_id = '" . $service_id . "'  ") or die(mysqli_error($this->db));

        $row = mysqli_fetch_object($query);


        return $row;
    }


    public function update_driver_order_commission($driver_id, $order_id, $data)
    {
        $sql = $this->db->make_insert("orders_driver_commission", $data);
        //echo $sql;
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }


    //taxgroup
    //price_list
    //fsrate

    public function cal_driver_commision($order_id, $driver_id, $service_id, $vechile_id, $mdata, $price, $account)
    {
        $taxgroup = $account->get_account_taxgroup($mdata['account_id']);
        $tp_tax = $price->get_tax_price($taxgroup, $order_id);
        //echo $mdata['account_id'];
        $fsrate = $price->get_fsrate($taxgroup, $vechile_id, $mdata['account_id']);
        $fuelsurcharge = sprintf("%01.2f", $tp_tax * $fsrate / 100);
        //echo $fuelsurcharge;
        $all = $price->get_totals_list($order_id);
        $q = mysqli_query($this->db, "delete from orders_driver_commission where order_id = '" . $order_id . "'  ") or die(mysqli_errno($this->db));
        $svcprice = $all['srv'];

        if (is_array($driver_id)) {
            //echo "ahmed";
            $x[1] = "pickup_";
            $x[2] = "deliver_";
        } else {
            $x[1] = $driver_id;
            $driver_id = $x;
            $x[1] = "";
        }

        //	var_dump($driver_id);
        for ($i = 1; $i < count($driver_id) + 1; $i++) {
            //	echo $driver_id[$i];

            $ser_com = $this->get_services_commission($service_id, $driver_id[$i], $x[$i]);


            //* calc commissions with the percents in the order record.
            //r_pay_svc   = sprintf("%01.2f",$row["price"]        * $row["commission_svc_pct"]  / 100);
            $dr_pay_svc = sprintf("%01.2f", $svcprice * $ser_com->complete / 100);
            //echo $dr_pay_svc ;
            $data['driver_id'] = $driver_id[$i];
            $data['order_id'] = $order_id;
            $data['commission_name'] = "svc";

            if ($dr_pay_svc == 0) {
                $dr_pay_svc = '';
            }

            $data['commission_value'] = $dr_pay_svc;

            if (isset($mdata['data']['svc']['commission_override'][$i]) && $mdata['data']['svc']['commission_override'][$i] != '' && $mdata['data']['svc']['commission_override'][$i] >= 0) {
                $data['commission_override'] = $mdata['data']['svc']['commission_override'][$i];
                $data['commission_value'] = '';
            }

            $this->update_driver_order_commission($driver_id[$i], $order_id, $data);
            $data = array();

            $dr_pay_wait = sprintf("%01.2f", $all['wait'] * $ser_com->commission_pct_waittime / 100);
            $data['driver_id'] = $driver_id[$i];
            $data['order_id'] = $order_id;
            $data['commission_name'] = "wait";
            if ($dr_pay_wait == 0) {
                $dr_pay_wait = '';
            }
            $data['commission_value'] = $dr_pay_wait;

            if (isset($mdata['data']['wait']['commission_override'][$i]) && $mdata['data']['wait']['commission_override'][$i] != '' && $mdata['data']['wait']['commission_override'][$i] >= 0) {
                $data['commission_override'] = $mdata['data']['wait']['commission_override'][$i];
                $data['commission_value'] = '';
            }

            $this->update_driver_order_commission($driver_id[$i], $order_id, $data);
            $data = array();

            //echo $all['add'];
            $dr_pay_xtra = sprintf("%01.2f", $all['add'] * $ser_com->commission_pct_extra / 100);
            $data['driver_id'] = $driver_id[$i];
            $data['order_id'] = $order_id;
            $data['commission_name'] = "xtra";
            if ($dr_pay_xtra == 0) {
                $dr_pay_xtra = '';
            }

            $data['commission_value'] = $dr_pay_xtra;

            if (isset($mdata['data']['xtra']['commission_override'][$i]) && $mdata['data']['xtra']['commission_override'][$i] != '' && $mdata['data']['xtra']['commission_override'][$i] >= 0) {
                $data['commission_override'] = $mdata['data']['xtra']['commission_override'][$i];
                $data['commission_value'] = '';
            }
            $this->update_driver_order_commission($driver_id[$i], $order_id, $data);
            $data = array();


            $dr_pay_fs = sprintf("%01.2f", $fuelsurcharge * $ser_com->commission_pct_fs / 100);
            $data['driver_id'] = $driver_id[$i];
            $data['order_id'] = $order_id;
            $data['commission_name'] = "fs";
            if ($dr_pay_fs == 0) {
                $dr_pay_fs = '';
            }

            $data['commission_value'] = $dr_pay_fs;


            if (isset($mdata['data']['fs']['commission_override'][$i]) && $mdata['data']['fs']['commission_override'][$i] != '' && $mdata['data']['fs']['commission_override'][$i] >= 0) {
                $data['commission_override'] = $mdata['data']['fs']['commission_override'][$i];
                $data['commission_value'] = '';
            }


            $this->update_driver_order_commission($driver_id[$i], $order_id, $data);

            $data = array();

            if (isset($mdata['data']['adj']['commission_adj'][$i]) && $mdata['data']['adj']['commission_adj'][$i] != '') {
                $data['driver_id'] = $driver_id[$i];
                $data['order_id'] = $order_id;
                $data['commission_name'] = "adj";
                $data['commission_value'] = $mdata['data']['adj']['commission_adj'][$i];
                $data['commission_override'] = '';
                $data['commission_desc'] = $mdata['data']['adj']['commission_adj_desc'][$i];
                $this->update_driver_order_commission($driver_id[$i], $order_id, $data);
            }
        }
    }


    public function get_driver_order_id($driver_id)
    {

// 	echo "select  orders.driver_id,orders.driver_id2,account.account_id,account.account_name, services.service_short, status.statusname,
        // 			drivers.id,drivers.driverno,drivers.email,drivers.notify_email,drivers.phone,drivers.cell,drivers.name,orders.order_id,orders.from_address,
        // 			orders.to_address,pickup_date,pickup_time,pickup_by,deliver_by,delivery_date,delivery_time,CONCAT(delivery_date,' ',delivery_time)  as delivery,
        // 			sort_driver1,sort_driver2
        // 			from orders
        // 			inner join account on (account.account_id = orders.account_id)
        // 			inner join services on (services.service_id = orders.service_id)
        // 			inner join status on (status.id=orders.order_status)
        // 			inner join drivers  on ((drivers.id = orders.driver_id || drivers.id = orders.driver_id2  ) and drivers.id = '".$driver_id."' )
        // 			where (orders.driver_id = '".$driver_id."' || orders.driver_id2 = '".$driver_id."') and order_status not in (2,5) order by sort_driver1,sort_driver2 ,delivery ASC ";

        $query = mysqli_query($this->db, "select  orders.driver_id,orders.driver_id2,account.account_id,account.account_name, services.service_short, status.statusname, 
			drivers.id,drivers.driverno,drivers.email,drivers.notify_email,drivers.phone,drivers.cell,drivers.name,orders.order_id,orders.from_address,
			orders.to_address,pickup_date,pickup_time,pickup_by,deliver_by,delivery_date,delivery_time,CONCAT(delivery_date,' ',delivery_time)  as delivery,
			sort_driver1,sort_driver2
			from orders 
			inner join account on (account.account_id = orders.account_id) 
			inner join services on (services.service_id = orders.service_id) 
			inner join status on (status.id=orders.order_status) 
			inner join drivers  on ((drivers.id = orders.driver_id || drivers.id = orders.driver_id2  ) and drivers.id = '" . $driver_id . "' )
			where (orders.driver_id = '" . $driver_id . "' || orders.driver_id2 = '" . $driver_id . "') and order_status not in (2,5) order by  delivery ASC ") or die(mysqli_error($this->db));


        $result = array();
        while ($post = mysqli_fetch_array($query)) {

            /// order_type
            if ($post['driver_id2'] == "0" && $post['driver_id'] != "0") {
                $post['order_type'] = "3";
            } //All
            if ($post['driver_id2'] != "0" && $driver_id == $post['driver_id2']) {
                $post['order_type'] = "2";
            } //Delivery
            if ($post['driver_id'] != "0" && $post['driver_id2'] != "0" && $driver_id == $post['driver_id']) {
                $post['order_type'] = "1";
            } // Pickup

            //pickup
            if ($post['order_type'] == "1") {
                if ($post['driver_id'] == $driver_id) {
                    $post['sort'] = $post['sort_driver1'];
                }
                if ($post['driver_id2'] == $driver_id) {
                    $post['sort'] = $post['sort_driver2'];
                }

                $sd = mysqli_query($this->db, "select driverno,name from drivers where id = '" . $post['driver_id2'] . "' ") or die(stdout(mysqli_error($this->db)));
                $rs = mysqli_fetch_array($sd);
                $post['other_driver'] = "Delivery Driver : " . $rs['driverno'] . " | " . $rs['name'];
            } elseif ($post['order_type'] == "2") {
                if ($post['driver_id'] == $driver_id) {
                    $post['sort'] = $post['sort_driver1'];
                }
                if ($post['driver_id2'] == $driver_id) {
                    $post['sort'] = $post['sort_driver2'];
                }

                $sd = mysqli_query($this->db, "select driverno,name from drivers where id = '" . $post['driver_id'] . "' ") or die(stdout(mysqli_error($this->db)));
                $rs = mysqli_fetch_array($sd);
                $post['other_driver'] = "Pickup Driver : " . $rs['driverno'] . " | " . $rs['name'];
            } elseif ($post['order_type'] == "3") {
                $post['other_driver'] = "";

                if ($post['driver_id'] == $driver_id) {
                    $post['sort'] = $post['sort_driver1'];
                }
                if ($post['driver_id2'] == $driver_id) {
                    $post['sort'] = $post['sort_driver2'];
                }
            }

            $result[] = $post;
        }


        //$result = $this->sortBy("sort", $result);


        return $result;
    }


    public function sortBy($field, $array, $direction = 'asc')
    {
        for ($i = 0; $i < count($array); $i++) {
        }
    }
}
