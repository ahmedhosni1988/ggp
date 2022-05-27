<?php

class company
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }


    public function get_company_details()
    {
        $query = mysqli_query($this->db, "select * from options  ") or die(mysqli_error($this->db));


        $company_details = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $x = "";
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $company_details[$row['option_name']] = $arr;
        }

        return $company_details;
    }

    public function get_options()
    {
        $query = mysqli_query($this->db, "select * from options") or die(mysqli_error($this->db));


        $company_details = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $x = "";
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $company_details[$row['option_name']] = $arr;
        }

        return $company_details;
    }


    public function get_company_details_price()
    {
        $query = mysqli_query($this->db, "select * from options where option_name like '%price_%'  ") or die(mysqli_error($this->db));


        $company_details = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $x = "";
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $company_details[$row['option_name']] = $arr;
        }

        return $company_details;
    }


    public function get_option($option_type)
    {
        $query = mysqli_query($this->db, "select * from options  ") or die(mysqli_error($this->db));

        $option = array();
        while ($row = mysqli_fetch_array($query)) {
            $option[$row['option_name']] = $row['option_value'];
        }

        return $option;
    }

    public function update_company_details($array)
    {
        foreach ($array as $key => $value) {
            $query = mysqli_query($this->db, "select * from options where option_name = " . check_mysql_string($this->db, $key) . " ") or die(mysqli_error($this->db));

            if (mysqli_num_rows($query) > 0) {
                $q = mysqli_query($this->db, "update options set option_value=" . check_mysql_string($this->db, $value) . " where option_name = " . check_mysql_string($this->db, $key) . "") or die(mysqli_error($this->db));
            } else {
                $q = mysqli_query($this->db, "insert into  options (option_value,option_name) values (" . check_mysql_string($this->db, $value) . "," . check_mysql_string($this->db, $key) . "); ") or die(mysqli_error($this->db));
            }
        }

        if ($q) {
            return true;
        } else {
            return false;
        }
    }


    public function get_billing_frequency()
    {
        $query = mysqli_query($this->db, "select * from options where option_name like '%Billing_Frequency%'  ") or die(mysqli_error($this->db));


        $company_details = array();


        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $company_details[] = $arr;
        }


        return $company_details;
    }


    public function update_billing_frequency($option_id, $option_value)
    {
        $q = mysqli_query($this->db, "update options set option_value = " . check_mysql_string($this->db, $option_value) . " where option_id = " . check_mysql_string($this->db, $option_id) . "") or die(mysqli_error($this->db));


        if ($q) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_billing_frequency($option_name, $option_value)
    {
        $q = mysqli_query($this->db, "insert into options (option_name,option_value) values (" . check_mysql_string($this->db, $option_name) . "," . check_mysql_string($this->db, $option_value) . ") ") or die(mysqli_error($this->db));


        if ($q) {
            return true;
        } else {
            return false;
        }
    }


    public function get_email_to_send($c_setting, $notifyevent)
    {
        $emails = "";
        for ($i = 1; $i < 4; $i++) {
            if ($c_setting['co_notify_email' . $i] != "" && $c_setting['co_notifyevent' . $notifyevent . '_email' . $i] == "Y") {
                $emails[] = array('type' => 'co_notifyevent' . $notifyevent . '_email' . $i, 'email' => $c_setting['co_notify_email' . $i]);
            }
        }

        return $emails;
    }

    public function get_message_details($message_type, $array)
    {
        $query = mysqli_query($this->db, "select * from email_template where email_name = '" . $message_type . "'") or die(mysqli_error($this->db));

        $me = mysqli_fetch_object($query);
        $matches = array();
        preg_match_all('/(?!\b)(@\w+\b)/', $me->email_subject, $matches);
        //print_r($array);
        //print_r($matches);

        $subject = $me->email_subject;
        for ($m = 0; $m < count($matches); $m++) {
            for ($i = 0; $i < count($matches[$m]); $i++) {
                $subject = str_replace(str_replace(' ', '', $matches[$m][$i]), $array[$matches[$m][$i]], $subject);
            }
        }


        $matches = array();
        preg_match_all('/(?!\b)(@\w+\b)/', $me->email_textbody, $matches);
        $body = $me->email_textbody;


        for ($m = 0; $m < count($matches); $m++) {
            for ($i = 0; $i < count($matches[$m]); $i++) {
                $body = str_replace(str_replace(' ', '', $matches[$m][$i]), $array[$matches[$m][$i]], $body);
            }
        }


        $r['subject'] = $subject;
        $r['body'] = $body;

        return $r;
    }

    public function get_service($id)
    {
        $query = mysqli_query($this->db, "select * from services where service_id = '" . $id . "' ") or die(mysqli_error($this->db));

        $services = array();
        $services = array();
        $services = mysqli_fetch_object($query);
        return $services;
    }


    public function get_services()
    {
        $query = mysqli_query($this->db, "select * from services ") or die(mysqli_error($this->db));

        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $services[] = $arr;
        }

        return $services;
    }

    public function update_services($ser_id, $ser_name, $ser_des, $ser_short, $ser_color, $ser_timecut, $ser_order)
    {
        $sql = "update services set service_name = " . check_mysql_string($this->db, $ser_name) . ",	service_order  = " . check_mysql_string($this->db, $ser_order) . ",	sevices_description  = " . check_mysql_string($this->db, $ser_des) . ",	service_color  = " . check_mysql_string($this->db, $ser_color) . ",	service_short  = " . check_mysql_string($this->db, $ser_short) . ",	service_cutoff  = " . check_mysql_string($this->db, $ser_timecut) . " where service_id = " . check_mysql_string($this->db, $ser_id) . "";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function add_services($ser_name, $ser_des, $ser_short, $ser_color, $ser_timecut, $ser_order)
    {
        $sql = "insert into services ( service_name ,	service_order ,	sevices_description ,	service_color ,	service_short ,	service_cutoff ) values(" . check_mysql_string($this->db, $ser_name) . "," . check_mysql_string($this->db, $ser_order) . "," . check_mysql_string($this->db, $ser_des) . "," . check_mysql_string($this->db, $ser_color) . "," . check_mysql_string($this->db, $ser_short) . "," . check_mysql_string($this->db, $ser_timecut) . ") ";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    //get tax type
    public function get_tax()
    {
        $query = mysqli_query($this->db, "select * from tax ") or die(mysqli_error($this->db));

        $tax = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $tax[] = $arr;
        }

        return $tax;
    }


    public function get_tax_name()
    {
        $query = mysqli_query($this->db, "select * from tax ") or die(mysqli_error($this->db));

        $tax = array();
        while ($row = mysqli_fetch_array($query)) {
            $tax[$row['tax_id']] = $row['tax_name'];
        }

        return $tax;
    }


    public function get_tax_rate()
    {
        $query = mysqli_query($this->db, "select * from tax ") or die(mysqli_error($this->db));

        $tax = array();
        while ($row = mysqli_fetch_array($query)) {
            $tax[$row['tax_id']] = $row['tax_rate'] / 100;
        }

        return $tax;
    }


    public function get_tax_id($id)
    {
        $query = mysqli_query($this->db, "select * from tax where tax_id = '$id' ") or die(mysqli_error($this->db));

        return mysqli_fetch_object($query);
    }

    public function update_tax($tax_id, $tax_name, $tax_ratio)
    {
        $sql = "update tax set tax_name = " . check_mysql_string($this->db, $tax_name) . ",	tax_rate  = " . check_mysql_string($this->db, $tax_ratio) . "  where tax_id = " . check_mysql_string($this->db, $tax_id) . "";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function add_tax($tax_name, $tax_ratio)
    {
        $sql = "insert into tax (tax_name,tax_rate) values(" . check_mysql_string($this->db, $tax_name) . "," . check_mysql_string($this->db, $tax_ratio) . ") ";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function get_tax_group()
    {
        $query = mysqli_query($this->db, "select * from tax_group ") or die(mysqli_error($this->db));

        $tax = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $tax[] = $arr;
        }

        return $tax;
    }


    public function get_tax_group_list()
    {
        $query = mysqli_query($this->db, "select * from tax_group ") or die(mysqli_error($this->db));

        $tax = array();
        while ($row = mysqli_fetch_array($query)) {
            $tax[$row['taxgroup_id']] = $row;
        }

        return $tax;
    }


    public function get_tax_group_id($id)
    {
        $query = mysqli_query($this->db, "select * from tax_group where taxgroup_id = '$id' ") or die(mysqli_error($this->db));

        return mysqli_fetch_object($query);
    }

    public function update_taxgroup($group_id, $group_name, $tax1, $tax2, $tax2_on_tax1, $fs, $fs_rate_1, $fs_rate_2, $taxgroup_on)
    {
        $sql = "update tax_group set taxgroup_name = " . check_mysql_string($this->db, $group_name) . ",	taxgroup_tax1= " . check_mysql_string($this->db, $tax1) . ",	taxgroup_tax2 = " . check_mysql_string($this->db, $tax2) . ",	taxgroup_tax2_on_tax1= " . check_mysql_string($this->db, $tax2_on_tax1) . ",	taxgroup_fs_rate= " . check_mysql_string($this->db, $fs) . ",	taxgroup_tax1_on_fs	= " . check_mysql_string($this->db, $fs_rate_1) . ",taxgroup_tax2_on_fs = " . check_mysql_string($this->db, $fs_rate_2) . " , taxgroup_on = " . check_mysql_string($this->db, $taxgroup_on) . " where taxgroup_id = " . check_mysql_string($this->db, $group_id) . "";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_taxgroup($group_name, $tax1, $tax2, $tax2_on_tax1, $fs, $fs_rate_1, $fs_rate_2, $taxgroup_on)
    {
        $sql = "insert into tax_group  (taxgroup_name ,taxgroup_tax1,taxgroup_tax2 ,taxgroup_tax2_on_tax1,taxgroup_fs_rate,taxgroup_tax1_on_fs,taxgroup_tax2_on_fs , taxgroup_on) values(" . check_mysql_string($this->db, $group_name) . "," . check_mysql_string($this->db, $tax1) . "," . check_mysql_string($this->db, $tax2) . "," . check_mysql_string($this->db, $tax2_on_tax1) . "," . check_mysql_string($this->db, $fs) . "," . check_mysql_string($this->db, $fs_rate_1) . "," . check_mysql_string($this->db, $fs_rate_2) . ", " . check_mysql_string($this->db, $taxgroup_on) . ") ";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    ////////////billing code
    public function get_billing_code()
    {
        $query = mysqli_query($this->db, "select * from billing_code") or die(mysqli_error($this->db));

        $billing_array = array();
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                foreach ($row as $key => $value) {
                    $arr[$key] = $value;
                }

                $billing_array[] = $arr;
            }

            return $billing_array;
        } else {
            return false;
        }
    }


    public function get_term_details($term_id)
    {
        $query = mysqli_query($this->db, "select * from payment_terms where pt_id = " . check_mysql_string($this->db, $term_id) . "") or die(mysqli_error($this->db));
        if (mysqli_num_rows($query) == 0) {
            $query = mysqli_query($this->db, "select * from payment_terms where pt_default = '1' ") or die(mysqli_error($this->db));
        }

        return mysqli_fetch_object($query);
    }

    public function get_page($page_id)
    {
        $query = mysqli_query($this->db, "select * from pages where page_id = " . check_mysql_string($this->db, $page_id) . "  ") or die(mysqli_error($this->db));

        return mysqli_fetch_object($query);
    }

    public function get_page_status($page_id)
    {
        $query = mysqli_query($this->db, "select * from pages where page_type = " . check_mysql_string($this->db, $page_id) . "  ") or die(mysqli_error($this->db));

        return mysqli_fetch_object($query);
    }


    public function get_all_page()
    {
        $query = mysqli_query($this->db, "select * from pages  ") or die(mysqli_error($this->db));
        $data = build_array($query);
        return $data;
    }

    public function edit_page($array)
    {
        $sql = make_update("pages", $array, "page_id", $array['page_id']);

        $q = mysqli_query($this->db, "update pages set page_name= '" . mysqli_real_escape_string($this->db, $array['page_name']) . "' , page_body = '" . (str_replace(" ", " ", $array['page_body'])) . "' where page_id = '" . $array['page_id'] . "'   ") or die(mysqli_error($this->db));

        if ($q) {
            return true;
        } else {
            return false;
        }
    }


    public function get_login_message($account_id, $control)
    {
        $view_message = "";

        $today = $this->db->adjusteddate();
        $co_subject = trim($control["co_loginmessage_subject"]);
        $co_body = trim($control["co_loginmessage_body"]);
        $cos = $control["co_startmessage"];
        $coe = $control["co_endmessage"];
        if ($coe == "0000-00-00") {
            $coe = "9999-99-99";
        }
        if ($today >= $cos and $today <= $coe and $co_subject . $co_body != "") {
            $view_message[] = array('subject' => $co_subject, 'body' => $co_body);
        }

        if ($account_id > 0) {
            $query = mysqli_query($this->db, "select billing_code,loginmessage_subject,loginmessage_body, startmessage,endmessage  from account where account_id = '$account_id'") or die(mysqli_error($this->db));

            $client = mysqli_fetch_array($query);
            // mysqli_free_result($ri);
            $cu_bc = $client["billing_code"];
            $cu_subject = trim($client["loginmessage_subject"]);
            $cu_body = trim($client["loginmessage_body"]);
            $cus = $client["startmessage"];
            $cue = $client["endmessage"];
            if ($cue == "0000-00-00") {
                $cue = "9999-99-99";
            }
            if ($today >= $cus and $today <= $cue and $cu_subject . $cu_body != "") {
                $view_message[] = array('subject' => $cu_subject, 'body' => $cu_body);
            }
        }


        $bc = build_array(mysqli_query($this->db, "select * from billing_code"));
        if (count($bc) > 0 && $cu_bc > 0) {
            for ($i = 0; $i < count($bc); $i++) {
                if (isset($control['co_loginmessage_body_bc' . $bc[$i]['id']])) {
                    $co_subject_bc1 = trim($control["co_loginmessage_subject_bc" . $bc[$i]['id']]);
                    $co_body_bc1 = trim($control["co_loginmessage_body_bc" . $bc[$i]['id']]);
                    $cos_bc1 = $control["co_startmessage_bc" . $bc[$i]['id']];
                    $coe_bc1 = $control["co_endmessage_bc" . $bc[$i]['id']];
                    if ($coe_bc1 == "0000-00-00") {
                        $coe_bc1 = "9999-99-99";
                    }

                    if ($today >= $cos_bc1 and $today <= $coe_bc1 and $co_subject_bc1 . $co_body_bc1 != "" and $cu_bc == $bc[$i]['id']) {
                        $view_message[] = array('subject' => $co_subject_bc1, 'body' => $co_body_bc1);
                    }
                }
            }
        }

        return $view_message;
    }

    public function get_taxgrouponfs_list()
    {
        $q = mysqli_query($this->db, "select * from tax_group") or die(mysqli_error($this->db));
        while ($row = mysqli_fetch_array($q)) {
            $v = "";
            $v = explode(",", $row['taxgroup_on']);

            for ($i = 0; $i < count($v); $i++) {
                if ($v[$i] == '1') {
                    $v[$i] = 'Y';
                } else {
                    $v[$i] = 'N';
                }
            }

            $list[$row['taxgroup_id']] = array('taxfsonwb' => $v[0], 'taxfsonwt' => $v[1], 'taxfsonot' => $v[2]);
        }
    }


    public function get_stat()
    {
        $sql = mysqli_query($this->db, "select count(*) as num from orders where order_status in (1,3) ") or die(mysqli_error($this->db));
        $num = mysqli_fetch_array($sql);
        $new_order_num = $num['num'];
        $array['new_order'] = $new_order_num;

        $sql = mysqli_query($this->db, "select count(*) as num from account where status = '0' ") or die(mysqli_error($this->db));
        $num = mysqli_fetch_array($sql);
        $new_account_num = $num['num'];
        $array['new_accounts'] = $new_account_num;


        $sql = mysqli_query($this->db, "select count(*) as num from orders where order_status in (1,3) and driver_id != 0 group by driver_id ") or die(mysqli_error($this->db));
        //$num = mysqli_fetch_array($sql);
        $working_drivers = mysqli_num_rows($sql);
        $array['working_drivers'] = $working_drivers;


        $sql = mysqli_query($this->db, "select count(*) as num from orders where order_status in (1,2,3) and order_date >= '" . date("Y-m-d 00:00:00") . "' and order_date <= '" . date("Y-m-d 23:59:59") . "'  ") or die(mysqli_error($this->db));
        $num = mysqli_fetch_array($sql);
        $today_new_orders = $num['num'];
        $array['today_new_orders'] = $today_new_orders;

        $sql = mysqli_query($this->db, "select count(*) as num from orders where order_status in (2)   ") or die(mysqli_error($this->db));
        $num = mysqli_fetch_array($sql);
        $today_completed_orders = $num['num'];
        $array['today_completed_orders'] = $today_completed_orders;


        $sql = mysqli_query($this->db, "select count(*) as num from orders where order_status in (3)   ") or die(mysqli_error($this->db));
        $num = mysqli_fetch_array($sql);
        $today_working_orders = $num['num'];
        $array['today_working_orders'] = $today_working_orders;


        return $array;
    }


    public function get_driver_stat()
    {
        $sql = mysqli_query($this->db, "select count(*) as num,drivers.name,drivers.driverno from orders inner join drivers on (orders.driver_id = drivers.id) where orders.order_status in (1,3) and driver_id != 0 group by orders.driver_id ") or die(mysqli_error($this->db));

        $sql2 = mysqli_query($this->db, "select count(*) as num from orders  where orders.order_status in (1,3)  and driver_id != 0 ") or die(mysqli_error($this->db));

        $num = mysqli_fetch_array($sql2);
        $total = $num['num'];


        $result = array();
        $i = 0;
        while ($row = mysqli_fetch_array($sql)) {
            $per = ($row['num'] / $total) * 100;
            $result[] = array("label" => $row['driverno'] . '|' . $row['name'], "data" => $per, "color" => $color[$i]);
            $i++;
        }

        return $result;
    }
}
