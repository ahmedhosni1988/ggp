<?php

// include ("driver.php");
// include ("notification.php");
// include ("orders.php");
// include ("services.php");
// include ("company.php");
// include ("contact.php");

class work
{
    public $db;

    public function work($db)
    {
        $this->db = $db;
    }


    public function delete_order($order_id)
    {
        $q = mysql_query("delete from orders_package_work where order_id = '" . $order_id . "' ");
        $q = mysql_query("delete from orders_package where order_id = '" . $order_id . "' ");
        $q = mysql_query("delete from orders where order_id = '" . $order_id . "'");
    }


    public function add_operation_package($pack_id, $p_type = "1", $status = "1", $scratch = "0")
    {
        $qp = mysql_query("select * from orders_package where id = '" . $pack_id . "'  ");
        $row = mysql_fetch_array($qp);

        $case = explode(',', $row['order_status']);

        if (count($case) == "1") {
            if ($case[0] == "1") {
                $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche,start_time) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','2','2','" . $p_type . "','" . $scratch . "','" . date('Y-m-d H:i:s') . "')");

                $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','3','" . $status . "','" . $p_type . "','" . $scratch . "')");

                $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','4','" . $status . "','" . $p_type . "','" . $scratch . "')");

                $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','7','" . $status . "','" . $p_type . "','" . $scratch . "')");
            }

            if ($case[0] == "2") {
                $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche,start_time) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','3','2','" . $p_type . "','" . $scratch . "','" . date('Y-m-d H:i:s') . "')");

                $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','4','" . $status . "','" . $p_type . "','" . $scratch . "')");
               
                $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','7','" . $status . "','" . $p_type . "','" . $scratch . "')");
            }

            if ($case[0] == "3") {
                $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche,start_time) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','" . ($case[0] - 1) . "','2','" . $p_type . "','" . $scratch . "','" . date('Y-m-d H:i:s') . "')");
            }

            if ($case[0] == "4") {
                $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche,start_time) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','" . ($case[0] - 1) . "','2','" . $p_type . "','" . $scratch . "','" . date('Y-m-d H:i:s') . "')");
            }

            if ($case[0] == "5") {
                $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche,start_time) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','7','2','" . $p_type . "','" . $scratch . "','" . date('Y-m-d H:i:s') . "')");
            }

            if ($case[0] == "6") {
                $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche,start_time) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','4','2','" . $p_type . "','" . $scratch . "','" . date('Y-m-d H:i:s') . "')");
            }



            $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche) 
			value ('" . $row['order_id'] . "','" . $row['id'] . "','5','" . $status . "','" . $p_type . "','" . $scratch . "')");

            $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche) 
			value ('" . $row['order_id'] . "','" . $row['id'] . "','6','" . $status . "','" . $p_type . "','" . $scratch . "')");
       
       
        ////////////////////////////////////////
        } elseif (count($case) > "1" || ($case[0] != "2" && $case[0] != "1")) {
            for ($i = 0; $i < count($case); $i++) {
                if ($i == 0) {
                    $status = "2";
                    $date = date('Y-m-d H:i:s');
                } else {
                    $status = "1";
                    $date = date('Y-m-d H:i:s');
                    ;
                }

                $mycase = '';
                if ($case[$i] == '3') {
                    $mycase = '2';
                }

                if ($case[$i] == '4') {
                    $mycase = '3';
                }
                if ($case[$i] == '5') {
                    $mycase = '7';
                }
                if ($case[$i] == '6') {
                    $mycase = '4';
                }
                
                $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche,start_time) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','" . $mycase. "','" . $status . "','" . $p_type . "','" . $scratch . "','" . $date . "')");
            }


            $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','5','" . $status . "','1','" . $scratch . "')");

            $q = mysql_query("insert into orders_package_work (order_id,package_id,operation,status,p_type,scratche) 
				value ('" . $row['order_id'] . "','" . $row['id'] . "','6','" . $status . "','1','" . $scratch . "')");
        }
    }


    public function start_work($order_id)
    {
        $q = mysql_query("select * from orders where order_id = '" . $order_id . "' ");
        $r = mysql_fetch_array($q);

        if ($r['order_status'] != "0") {
            return;
        }

        $qp = mysql_query("select id from orders_package where order_id = '" . $order_id . "'  ");

        if ($r['service_id'] == "2") {
            while ($pack = mysql_fetch_array($qp)) {
                $this->add_operation_package($pack['id'], $r['work_status']);
            }
        } else {
        }


        mysql_query("update orders set order_status = '1',start_work_date = '" . date("Y-m-d H:i:s") . "' where order_id = '" . $order_id . "' ");
    }


    public function stop_play_work($order_id, $type)
    {
        if ($type == "stop") {
            mysql_query("update orders set order_status = '4' where order_id = '" . $order_id . "' ");
        }

        if ($type == "play") {
            mysql_query("update orders set order_status = '1' where order_id = '" . $order_id . "' ");
        }
    }


    public function check_finish($order_id)
    {
        $query = mysql_query("select * from orders_package where order_id = '" . $order_id . "' and package_status != '2' ");

        if (mysql_num_rows($query) > 0) {
            return false;
        } else {
            mysql_query("update orders set order_status = '2' , finish_work_date = '" . date("Y-m-d H:i:s") . "' where order_id = '" . $order_id . "' ");
            return true;
        }
    }


    public function deliver_order($order_id)
    {
        $o = mysql_query("select * from orders where order_id = '" . $order_id . "'  ");
        $oDetails = mysql_fetch_assoc($o);
        
        $q = mysql_query("SELECT GROUP_CONCAT(id) as items  FROM orders_package where order_id = '".$order_id."' and package_status = '1' ");
        $qDetails = mysql_fetch_assoc($q);
        $outOrder = array();
        $outOrder['account_id'] = $oDetails['account_id'];
        $outOrder['status'] = 1;
        $outOrder['items'] = $qDetails['items'];
        $outOrder['create_date'] = date('Y-m-d H:i:s');
        $outOrder['finishe_date'] = date('Y-m-d H:i:s');
        $outOrder['added_by'] = $_SESSION['user_id'];
        $outOrder['added_name'] = $_SESSION['name'];
        $osql =  $this->db->make_insert('out_orders', $outOrder);

        mysql_query($osql) or die(mysql_error());


        mysql_query("update orders_package_work set status = 3 , end_time = '" . date('Y-m-d H:i:s') . "' " . $sql . " where status != 3 and  operation in (6,5) and order_id = '" . $order_id . "'  ") or die(mysql_error());
        mysql_query("update orders_package set package_status = '2' where order_id = '" . $order_id . "' and package_status != '2'  ") or die(mysql_error());
        $query = mysql_query("update orders set order_status = '3' , actual_delivery_date = '" . date("Y-m-d H:i:s") . "'  where order_status != '3' and order_id = '" . $order_id . "' ");

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function cancel_package($package_id, $operation)
    {

        //this code for cancel pckage from mottabe user only
        if ($operation == "manger") {
            $q = mysql_query("select * from orders_package_work where package_id= '$package_id' and status = '2'") or die(mysql_error());
            $r = mysql_fetch_assoc($q);
            $operation = $r['operation'];
        }


        $pak_id = explode(',', $package_id);

        for ($i = 0; $i < count($pak_id); $i++) {
            if ($pak_id[$i] != '') {
                $order_id = $this->get_package_orderid($pak_id[$i]);

                $query = mysql_query("insert into orders_scratch (
				package_id,
				order_id,
				operation_id,
				user_name,
				user_id,
				date_scrache) values (
					'" . $pak_id[$i] . "',
					'" . $order_id . "',
					'" . $operation . "',
					'" . $_SESSION['name'] . "',
					'" . $_SESSION['user_id'] . "',
					'" . date('Y-m-d H:i:s') . "'
				);") or die(mysql_error());

                $query = mysql_query("update orders_package_work set status = 5 where package_id = '" . $pak_id[$i] . "' ") or die(mysql_error());
                $query = mysql_query("update orders_package set scratche = scratche + 1 where id = '" . $pak_id[$i] . "' ") or die(mysql_error());

                //	$this->add_operation_package($pak_id[$i],"1","1","1");
            }
        }
    }


    public function package_next_operation($package_id)
    {
        $q = mysql_query("select * from orders_package_work where package_id = '" . $package_id . "' and status = '1' order by field(operation,2,3,7,4,5,6) ");

        $i = 0;
        while ($r = mysql_fetch_array($q)) {
            if ($i == 0) {
                mysql_query("update orders_package_work set status = 2 , start_time = '" . date('Y-m-d H:i:s') . "'  where operation = '" . $r['operation'] . "'  and package_id = '" . $r['package_id'] . "'  ");
            }

            $i++;
        }
    }

    public function Search_with_Barcode($barcode, $user_type)
    {

        //	echo "select * from orders_package inner join orders_package_work on (orders_package_work.package_id == orders_package.id) where orders_package_work.operation= '".$user_type."'  and  orders_package.barcode = '".$barcode."' ";

        $query = mysql_query("select orders_package.*,
		 orders.glass_type,
		 orders.office_name,
		 orders.operation_name,
		 orders.account_id,
		 package_type.package_name,
		inventory_items_company.company_name from orders_package 
		inner join package_type on (package_type.package_id = orders_package.package_type )
		inner join orders_package_work on (orders_package_work.package_id = orders_package.id) 
		inner join orders on (orders_package.order_id = orders.order_id) 
		inner join inventory_items_company on (orders.glass_type = inventory_items_company.id)
		where orders_package_work.operation= '" . $user_type . "' and orders_package_work.status = '2'  and  orders_package.barcode = '" . $barcode . "' and orders.order_status = '1'  ") or die(mysql_error());


        if (mysql_num_rows($query) > 0) {
            return mysql_fetch_assoc($query);
        } else {
            return "0";
        }
    }


    public function Search_with_Text($order_id, $part_no, $user_type, $all = null)
    {

        //	echo "select * from orders_package inner join orders_package_work on (orders_package_work.package_id == orders_package.id) where orders_package_work.operation= '".$user_type."'  and  orders_package.barcode = '".$barcode."' ";

        if ($all == "1" || $user_type == 'manger') {
            $sql = "  1 = 1 ";
        } else {
            $sql = " orders_package_work.operation= '" . $user_type . "' and orders_package_work.status = '2' ";
        }

        if ($user_type == "5") {
            $sql = "  orders_package_work.operation= '" . $user_type . "' and orders_package_work.status in (1,2) " ;
        }

        $query = mysql_query("select orders_package.*,
			orders.glass_type,
			orders.office_name,
			orders.operation_name,
			package_type.package_name,
			orders.account_id,
		   inventory_items_company.company_name from orders_package 
		   inner join package_type on (package_type.package_id = orders_package.package_type )
		   inner join orders_package_work on (orders_package_work.package_id = orders_package.id) 
		   inner join orders on (orders_package.order_id = orders.order_id) 
		   inner join inventory_items_company on (orders.glass_type = inventory_items_company.id)
			where $sql  and  orders_package.easy_order_id = '" . $order_id . "' and orders_package.part_order = '" . $part_no . "' and orders.order_status = '1'  order by orders_package.id desc limit 1  ") or die(mysql_error());


        if (mysql_num_rows($query) > 0) {
            return mysql_fetch_assoc($query);
        } else {
            return "0";
        }
    }

    public function get_package($order_id, $part_no)
    {
        $query = mysql_query("select orders_package.*,
			orders.glass_type,
			orders.office_name,
			orders.operation_name,
			package_type.package_name,
			orders.account_id,
            status.statusname as myoperation

           from orders_package 
		   inner join package_type on (package_type.package_id = orders_package.package_type )
		   inner join orders_package_work on (orders_package_work.package_id = orders_package.id) 
           inner join status on (orders_package_work.operation = status.id) 

		   inner join orders on (orders_package.order_id = orders.order_id) 
			where  orders_package.easy_order_id = '" . $order_id . "' and orders_package.part_order = '" . $part_no . "' and orders_package_work.status = 2  order by orders_package.id desc limit 1  ") or die(mysql_error());


        if (mysql_num_rows($query) > 0) {
            return mysql_fetch_assoc($query);
        } else {
            return "0";
        }
    }


    public function get_outorder_package($package_id)
    {

        //	orders_package_work.operation= '5' and
        //	orders_package_work.status = '2'  and

        $query = mysql_query("select 
	    	orders_package.*,
		 orders.glass_type,
		 account.account_company,
		 inventory_items_company.company_name,
		 orders.office_name,
		 orders.operation_name,
		 package_type.package_name,
		 account.account_id from orders_package 
		 inner join package_type on (package_type.package_id = orders_package.package_type )
		inner join orders on (orders_package.order_id = orders.order_id) 
		inner join account on (account.account_id = orders.account_id)
		inner join inventory_items_company on (orders.glass_type = inventory_items_company.id)
		where 
	
		orders_package.id in (" . $package_id . ") 
		order by account.account_id  ") or die(mysql_error());


        while ($row = mysql_fetch_assoc($query)) {
            $res[] = $row;
        }

        return $res;
    }


    public function get_image($order_id)
    {
        $query = mysql_query("select * from orders_image where order_id = '" . $order_id . "' and image_status = '0'  ") or die(mysql_error());

        if (mysql_num_rows($query) < 1) {
            return false;
        } else {
            while ($row = mysql_fetch_assoc($query)) {
                $re[] = $row;
            }

            return $re;
        }
    }

    public function get_package_orderid($package_id)
    {
        $q = mysql_query("select order_id from orders_package where id = '" . $package_id . "' ");

        $row = mysql_fetch_array($q);

        return $row['order_id'];
    }


    public function get_out_orders($finished, $status, $billing_code)
    {
        if ($billing_code > '1') {
            $msql = ' and account.billing_code = \''.$billing_code.'\' ';
        }

        $query = mysql_query("select out_orders.*, account.account_company from  out_orders inner join account on (account.account_id = out_orders.account_id) where out_orders.status = '" . $status . "' and out_orders.finished = '" . $finished . "' $msql order by id desc limit 50");

        while ($row = mysql_fetch_assoc($query)) {
            $res[] = $row;
        }

        return $res;
    }

    public function search_out_orders($out_order_id, $order_id, $billing_code)
    {
        if ($billing_code > '1') {
            $msql = ' and account.billing_code = \''.$billing_code.'\' ';
        }

        $sql = "select out_orders.*, account.account_company from  out_orders 
        inner join account on (account.account_id = out_orders.account_id) where 
        1=1 ";

        if ($out_order_id != '') {
            $sql .= " and out_orders.id = '".$out_order_id."'  $msql ";
        }

        if ($order_id != '') {
            $sql = "select out_orders.*, account.account_company from  out_orders  
            inner join account on (account.account_id = out_orders.account_id)
            join orders_package on find_in_set(orders_package.id, out_orders.items) > 0 
            where orders_package.easy_order_id = '".$order_id."' $msql group by out_orders.id,account.account_company";
        }


        $query = mysql_query($sql) or die(mysql_error());

        while ($row = mysql_fetch_assoc($query)) {
            $res[] = $row;
        }

        return $res;
    }


    public function scratche_report($data)
    {
        $sql = "select status.statusname, 
		((orders_package.length * orders_package.width)/10000) as Quantity ,
		orders_package.length,
		orders_package.width,
		orders_scratch.reason,
		orders_scratch.perosn,
		s.statusname as sta,
        orders_scratch.user_name,
        package_type.package_name,
        concat(orders_package.easy_order_id,'-',orders_package.part_order)
		from orders_scratch 
		left join status on (status.id = orders_scratch.applied_operation) 
		inner join status as s on (s.id = orders_scratch.operation_id) 
        inner join orders_package on (orders_package.id = orders_scratch.package_id)
        inner join package_type on (package_type.package_id = orders_package.package_type )";

        if (count($data) > 0) {
            $sql .= " where 1=1 and";
            if (isset($data['operation']) && $data['operation'] != '') {
                $sql .= " orders_scratch.operation_id =  '" . $data['operation'] . "' and";
            }
            if (isset($data['from_date']) && $data['from_date'] != '') {
                $sql .= " orders_scratch.date_scrache >=  '" .date("Y-m-d H:i:s", strtotime($data['from_date'])) . "' and";
            }
            if (isset($data['to_date']) && $data['to_date'] != '') {
                $sql .= " orders_scratch.date_scrache <  '" . date("Y-m-d H:i:s", strtotime($data['to_date']))  . "' and";
            }


            if (isset($data['package_type']) && $data['package_type'] != '') {
                $sql .= " orders_package.package_type =  '" . $data['package_type'] . "' and";
            }
        }


        $sql = substr($sql, 0, strlen($sql) - 3);

        $query = mysql_query($sql) or die(mysql_error());

        while ($row = mysql_fetch_assoc($query)) {
            $res[] = $row;
        }

        return $res;
    }

    
    public function salesReportDetails($data)
    {
        global $option_type_lang;
        $sql = "select  account.account_company, 
		concat(orders.office_name,'-',orders.operation_name) as operation_name,
		orders.easy_order_id,
		orders.pieces,
		orders_package.length,
		orders_package.width,
		((orders_package.length * orders_package.width) /10000) as package_size,
        package_type.package_name,
        orders_package.glasscolour,
        orders_package.glassType,
		orders.order_comment,
		orders_package.details_2,
        orders.option_type,
        orders.order_date,
        orders_package.glassPointing
        FROM orders_package
        inner join orders on (orders.order_id = orders_package.order_id)
        inner join account on (account.account_id = orders.account_id)
        inner join package_type on (package_type.package_id = orders_package.package_type )";


        if (count($data) > 0) {
            $sql .= " where orders.order_status in (1,2,3) and";
  
            if (isset($data['from_date']) && $data['from_date'] != '') {
                $sql .= " orders.order_date >=  '" .date("Y-m-d H:i:s", strtotime($data['from_date'])) . "' and";
            }
            if (isset($data['to_date']) && $data['to_date'] != '') {
                $sql .= " orders.order_date <  '" . date("Y-m-d H:i:s", strtotime($data['to_date']))  . "' and";
            }
        }


        $sql = substr($sql, 0, strlen($sql) - 3);

        $query = mysql_query($sql) or die(mysql_error());

        while ($row = mysql_fetch_assoc($query)) {
            $row['option_type'] = $option_type_lang[$row['option_type']];
            $res[] = $row;
        }

        return $res;
    }


    public function salesReport($data)
    {
        global $option_type_lang;

        $sql = "select 
        account.account_company, 
         concat(orders.office_name,'-',orders.operation_name) as operation_name,
		orders.easy_order_id,
		orders.pieces,
		(orders.order_size / 10000) as order_size,
        package_type.package_name,
        orders_package.glasscolour,
        orders_package.glassType,
        orders.order_date,
        orders.option_type
		from orders  
        inner join account on (account.account_id = orders.account_id)
        inner join orders_package on (orders_package.order_id = orders.order_id and part_order = 1)
        inner join package_type on (package_type.package_id = orders_package.package_type )";

        if (count($data) > 0) {
            $sql .= " where orders.order_status in (1,2,3)  and";
 
            if (isset($data['from_date']) && $data['from_date'] != '') {
                $sql .= " orders.order_date >=  '" .date("Y-m-d H:i:s", strtotime($data['from_date'])) . "' and";
            }
            if (isset($data['to_date']) && $data['to_date'] != '') {
                $sql .= " orders.order_date <  '" . date("Y-m-d H:i:s", strtotime($data['to_date']))  . "' and";
            }
        }


        $sql = substr($sql, 0, strlen($sql) - 3);

        $query = mysql_query($sql) or die(mysql_error());

        while ($row = mysql_fetch_assoc($query)) {
            $row['option_type'] = $option_type_lang[$row['option_type']];
            $res[] = $row;
        }

        return $res;
    }


    public function production_report($data)
    {
        $sql = "select 
		status.statusname,
		concat(orders_package.easy_order_id,'-',orders_package.part_order),
		account.account_company,
		package_type.package_name,
		orders_package.length,
		orders_package.width,
		((orders_package.length * orders_package.width)/10000) as Quantity,
		orders_package.scratche,
        (((orders_package.length * orders_package.width)/10000) * orders_package.scratche) as allscratche,
        case when orders.order_type = 1 then 'شامل' else 'اجرة' end,
        orders.easy_order_id,
        orders_package.glasscolour,
        orders_package_work.start_time,
        orders_package_work.end_time,        
        DATEDIFF(orders_package_work.end_time,orders_package_work.start_time) AS 'productiontime',
        users.name,
        orders_package.details
		from orders_package_work
		inner join orders on (orders.order_id = orders_package_work.order_id) 
		inner join account on (account.account_id = orders.account_id) 
		inner join status  on (status.id = orders_package_work.operation) 
		inner join orders_package on (orders_package.id = orders_package_work.package_id)
        inner join package_type on (package_type.package_id = orders_package.package_type )
        left join users on (users.user_id = orders_package_work.user_id)";

        if (count($data) > 0) {
            $sql .= " where 1=1 and";
            if (isset($data['operation']) && $data['operation'] != '') {
                $sql .= " orders_package_work.operation =  '" . $data['operation'] . "' and";
            }

            if (isset($data['option_type']) && $data['option_type'] != '') {
                $sql .= " orders.order_type =  '" . $data['option_type'] . "' and";
            }

            if (isset($data['status']) && $data['status'] != '') {


                ////unde work
                if ($data['status'] == "2") {
                    $sql .= " orders_package_work.status =  '" . $data['status'] . "' and";

                    if (isset($data['from_date']) && $data['from_date'] != '') {
                        $sql .= " orders_package_work.start_time >=  '" . date("Y-m-d H:i:s", strtotime($data['from_date'])) . "' and";
                    }
                    if (isset($data['to_date']) && $data['to_date'] != '') {
                        $sql .= " orders_package_work.start_time <  '" . date("Y-m-d H:i:s", strtotime($data['to_date'])) . "' and";
                    }
                } elseif ($data['status'] == "3") {
                    $sql .= " orders_package_work.status =  '" . $data['status'] . "' and";

                    if (isset($data['from_date']) && $data['from_date'] != '') {
                        $sql .= " orders_package_work.end_time >=  '" .date("Y-m-d H:i:s", strtotime($data['from_date'])) . "' and";
                    }
                    if (isset($data['to_date']) && $data['to_date'] != '') {
                        $sql .= " orders_package_work.end_time <  '" . date("Y-m-d H:i:s", strtotime($data['to_date'])) . "' and";
                    }
                } else {
                    if (isset($data['from_date']) && $data['from_date'] != '') {
                        $sql .= " orders_package_work.end_time >=  '" .date("Y-m-d H:i:s", strtotime($data['from_date'])) . "' and";
                    }
                    if (isset($data['to_date']) && $data['to_date'] != '') {
                        $sql .= " orders_package_work.end_time <  '" . date("Y-m-d H:i:s", strtotime($data['to_date'])) . "' and";
                    }
                }
            }

            if (isset($data['package_type']) && $data['package_type'] != '') {
                $sql .= " orders_package.package_type =  '" . $data['package_type'] . "' and";
            }
        }


        $sql = substr($sql, 0, strlen($sql) - 3);

        $sql .= " and orders.order_status in  (1,2,3)  order by status.id,orders.order_id,account.account_id";
        echo $sql;
        $query = mysql_query($sql) or die(mysql_error());

        while ($row = mysql_fetch_assoc($query)) {
            $res[] = $row;
        }

        return $res;
    }





    //for un complete report


    public function get_uncompleted_order_package_details($date, $to_date, $service_id = "", $package_type="", $data = array())
    {
        $account_id="";

        $sql="";
        $acc = "";
        if ($service_id != "") {
            foreach ($service_id as $key) {
                $acc .= $key.',';
            }
            $acc = substr($acc, 0, strlen($acc)-1);
            $sql.=" orders.account_id in (".$acc.")" ;
        }

//            echo $sql;
        // $sql=substr($sql,0,strlen($sql)-2);
//            echo $sql;
        //  $sql .= ")";
            
        if ($service_id!="" && $package_type !="") {
            $account_id="and ".$sql." and orders_package.package_type='".$package_type."'";
        } elseif ($service_id!="") {
            $account_id="and ".$sql." ";
        } elseif ($package_type !="") {
            $account_id="and orders_package.package_type='".$package_type."'";
        }
            
        $sql2 = "";
        if (isset($data['glassType']) && $data['glassType'] != '') {
            $sql2 .= " and orders_package.glassType = '".$data['glassType']."' ";
        }
            
        if (isset($data['glasscolour']) && $data['glasscolour'] != '') {
            $sql2 .= " and orders_package.glasscolour = '".$data['glasscolour']."' ";
        }

        //,account.account_company  inner join account on ( account.account_id = orders.account_id )
        $sql = "  account.account_company,concat(orders.easy_order_id,'-',orders_package.part_order),orders.delivery_date,orders_package.id,length,width,package_type.package_name,glasscolour,glassPrint,glassType,glassScarch,glassPointing,details";
            
        $innerJoin = "inner join orders on (orders.order_id = orders_package_work.order_id  )
            inner join account on ( account.account_id = orders.account_id )
            inner join orders_package on (orders_package.id = orders_package_work.package_id )
            inner join package_type on (package_type.package_id = orders_package.package_type ) ";


        // echo "select $sql  from orders_package_work $innerJoin where
        // orders_package_work.order_id in (select orders.order_id from orders where orders.order_status = '1' and delivery_date >=' $date ' and delivery_date <= ' $to_date '  $account_id )
        // and orders_package_work.status in (1,2)
        // and orders_package_work.operation not in (5,6) group by orders_package.id order by orders_package_work.order_id  ";
            
        $query = mysql_query("select $sql  from orders_package_work $innerJoin where 
        orders_package_work.order_id in (select orders.order_id from orders where orders.order_status = '1' and delivery_date >=' $date ' and delivery_date <= ' $to_date '  $account_id ) 
        and orders_package_work.status in (1,2) 
        and orders_package_work.operation not in (5,6) $sql2 group by orders_package.id order by orders_package_work.order_id  ") or die(mysql_error());

        $order_package = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $q = mysql_query("select * from orders_package_work where package_id = '" . $row['id'] . "' ") or die(mysql_error());

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

            $del = 0 ;
            while ($r = mysql_fetch_array($q)) {

                //this option to remove pieces from elnoqes report if delviverd and dirty code
                if (($r['operation'] == '5' ||  $r['operation'] == '6') && $r['in_work'] == "1") {
                    $del = 1;
                }

                $arr[$r['operation']]['on'] = "1";
                $arr[$r['operation']]['p_type'] = $r['p_type'];
                $arr[$r['operation']]['scratche'] = $r['scratche'];
                $arr[$r['operation']]['in_work'] = $r['in_work'];
                $arr[$r['operation']]['out_work'] = $r['out_work'];

                if ($r['status'] == "3") {
                    $arr[$r['operation']]['done'] = "1";
                }
            }


            if ($del == 0) {
                $order_package[] = $arr;
            }
        }
        //$order_details = mysql_fetch_object($query);
        return $order_package;
    }


    public function stop_package($package_id)
    {
        $o = mysql_query("SELECT * FROM  `orders_package` where id = '".$package_id."'  ") or die(mysql_error());
        $ro = mysql_fetch_assoc($o);
        $order_id = $ro['order_id'];

        $q = mysql_query("update orders_package set package_status = '4' where id = '".$package_id."' ") or die(mysql_error());
        $s = mysql_query("update orders_package_work set status = '4' where status = '2' and package_id = '".$package_id."'  ") or die(mysql_error());

        /////////////// recalc invoice////////////
        $pac = mysql_query("SELECT * FROM  `invoicedtl` where waybill = '".$package_id."' ") or die(mysql_error());
        
        while ($row = mysql_fetch_array($pac)) {
            $amount= (double)$row['amount'];
            $invoiceno=$row['invoiceno'];
        }

        mysql_query("delete  FROM  `invoicedtl` where waybill = '".$package_id."' ") or die(mysql_error());

        $pac = mysql_query("SELECT * FROM  `invoicehdr` where id = '".$invoiceno."' ") or die(mysql_error());

        while ($row = mysql_fetch_array($pac)) {
            $subtotal= (double)$row['subtotal'];
        }
        $new_total=$subtotal-$amount;
        $q = mysql_query("update invoicehdr set reviewed = 0 ,  subtotal = '".$new_total."'  where id = '".$invoiceno."' ") or die(mysql_error());

        $this->calc_order_package($order_id);
        /////////////// end recalc invoice////////////
    }

    public function calc_order_package($order_id)
    {
        $size = 0;
        $pac = mysql_query("SELECT * FROM  `orders_package` where order_id = '".$order_id."' and package_status != '4' ") or die(mysql_error());

        while ($r = mysql_fetch_assoc($pac)) {
            $size += ($r['length'] * $r['width']);
        }

        mysql_query("update orders set order_size  = '".$size."'  where order_id = '".$order_id."' ") or die(mysql_error());
    }

    public function get_Pack_options($account_id=0)
    {
        $query = mysql_query("select * from addtional_services  where account_id=$account_id") or die(mysql_error());
        $arr = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($query)) {
            $arr[$row['id']] = $row['name'];
        }

        return $arr;
    }

    public function get_package_type()
    {
        $query = mysql_query("select * from package_type") or die(mysql_error());
        $arr = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($query)) {
            $arr[$row['package_id']] = $row['package_name'];
        }

        return $arr;
    }


    public function play_package($package_id)
    {
        $q = mysql_query("update orders_package set package_status = '1' where id = '".$package_id."' ") or die(mysql_error());
        $s = mysql_query("update orders_package_work set status = '2' where status = '4' and package_id = '".$package_id."'  ") or die(mysql_error());

        /////////////// recalc invoice////////////
        $query = mysql_query("select orders_package.*,account.account_id,account.account_name from orders_package
        inner join orders on (orders.order_id = orders_package.order_id) 
        inner join account on (account.account_id = orders.account_id) 
        where  orders_package.id = '".$package_id."' ") or die(mysql_error());
        
        $Pack_options=$this->get_Pack_options();
        $pack_type=$this->get_package_type();

        $lineno = 0;
        while ($nrow = mysql_fetch_array($query)) {
            $order_inv_prices = $this->get_inv_order_prices($nrow["id"]);
         
            $services_charges = setup_serviceprices($order_inv_prices, $add_ser, $nrow, $pack_type, $Pack_options);
        
            $detailrec = array();
            $detailrec["clid"]          = $nrow["account_id"];
            $detailrec["acctno"]        = $nrow["account_name"];
            $detailrec["invoiceno"]     = $nrow["invoice_no"];
            $detailrec["waybill"]       = $nrow["id"];
            $detailrec["waybill_ref"]   = $nrow["chargecode"];
            $detailrec["item"]          = $nrow["order_id"].'-'.$nrow['part_order'];
           
         
           
            for ($sc = 0; $sc < count($services_charges); $sc++) {
                $detailrec["lineno"]        = $lineno;
                
                //  $txcalcs = tax_fs_calc($customer["account_taxgroup"],$fsrate,$services_charges[$sc]["chg"],$services_charges[$sc]["typ"]);
                $detailrec["amount"]        = sprintf("%01.2f", round($services_charges[$sc]["chg"], 2));
                
        
                $detailrec["chgtype"]       = $services_charges[$sc]["typ"];
                
          
                $detailrec["descn"] = $services_charges[$sc]["des"];
        
                //* SQL - Save the Invoice Detail Record.
                $invoicedet = $this->insert_invoicedetails($detailrec);
                
                ////////////end  invoi_detil /////////////////
                $lineno = $lineno + 1;
                $amount = $amount + $detailrec["amount"];
                $invoiceno =$detailrec["invoiceno"];
            }
            $wbcount++;
        
            // var_dump($services_charges);
        }


        $pac = mysql_query("SELECT * FROM  `invoicehdr` where id = '".$invoiceno."' ") or die(mysql_error());

        while ($row = mysql_fetch_array($pac)) {
            $subtotal= (double)$row['subtotal'];
        }
        $new_total=$subtotal+$amount;
        $q = mysql_query("update invoicehdr set subtotal = '".$new_total."' where id = '".$invoiceno."' ") or die(mysql_error());

        /////////////// end recalc invoice////////////
    }
    public function get_inv_order_prices($order_id)
    {
        $query = mysql_query("select * from orders_price where package_id = " . $this->db->qstr($order_id) . " ") or die(mysql_error());
        $order_details = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($query)) {
            $order_details[$i][$row["type"]] = $row;
            $i++;
        }
        return $order_details;
    }


    public function insert_invoicedetails($array)
    {
        $sql = $this->db->make_insert("invoicedtl", $array);


        $query = mysql_query($sql) or die(mysql_error());

        if ($query) {
            return mysql_insert_id();
        } else {
            return false;
        }
    }

    public function delete_package($package_id)
    {
        $q = mysql_query("delete from orders_package_work where package_id = '".$package_id."' ") or die(mysql_error());

        $s = mysql_query("select * from  orders_package where id = '".$package_id."' ") or die(mysql_error());

        $r = mysql_fetch_array($s);

        mysql_query("update orders set pieces = pieces -1 , order_size = order_size - (".$r['length']." * ".$r['width'].")  where order_id = '".$r['order_id']."' ") or die(mysql_error());

        mysql_query("delete from orders_package where id = '".$package_id."' ") or die(mysql_error());
    }
    public function get_combo_box($name)
    {
        $query = mysql_query("select * from lookup_addtional where type = '$name' ") or die(mysql_error());
        $result = array();
        while ($row = mysql_fetch_assoc($query)) {
            $result[] = $row;
        }
        return $result;
    }

    public function get_invoice_order($invoice_id)
    {
        $query = mysql_query("select * from orders where invoice_no = '$invoice_id'  ") or die(mysql_error());

        $result = array();

        while ($row = mysql_fetch_assoc($query)) {
            $result[] = $row;
        }

        return $result;
    }


    public function check_accountinvoice($account_id, $invoice_id)
    {
        $num = 0;
        $query = mysql_query("select * from invoicehdr where clid = '$account_id' and  id = '$invoice_id'  ") or die(mysql_error());
        $num = mysql_num_rows($query);

        if ($num) {
            return true;
        } else {
            return false;
        }
    }
    public function get_Credit($data)
    {
        $query = mysql_query("select credit_note.*,users.user_name,account.account_name,account.account_company from credit_note
		inner join account on (account.account_id = credit_note.account_id ) 
		inner join users on (users.user_id = credit_note.user_id ) order by credit_note.id desc ") or die(mysql_error($this->db));
    
        $result = array();
        while ($row = mysql_fetch_assoc($query)) {
            $result[] = $row;
        }
        return $result;
    }

    public function get_credit_id($id)
    {
        $query = mysql_query("select credit_note.*,users.user_name,account.account_name,account.account_company from credit_note
		inner join account on (account.account_id = credit_note.account_id ) 
		inner join users on (users.user_id = credit_note.user_id )  where  id = '$id' ") or die(mysql_error());

        $result = mysql_fetch_object($query);

        return $result;
    }
}
