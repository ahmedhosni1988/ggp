<?php

class company
{

    var $db;

    function company($db)
    {
        $this->db = $db;
    }


    function get_company_details()
    {

        $query = mysql_query("select * from options  ") or die (mysql_error());


        $company_details = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($query)) {
            $x = "";
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $company_details[$row['option_name']] = $arr;
        }

        return $company_details;
    }

    function get_options()
    {

        $query = mysql_query("select * from options") or die (mysql_error());


        $company_details = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($query)) {
            $x = "";
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $company_details[$row['option_name']] = $arr;
        }

        return $company_details;
    }


    function get_company_details_price()
    {

        $query = mysql_query("select * from options where option_name like '%price_%'  ") or die (mysql_error());


        $company_details = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($query)) {
            $x = "";
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $company_details[$row['option_name']] = $arr;
        }

        return $company_details;
    }


    function get_option($option_type)
    {
        $query = mysql_query("select * from options  ") or die (mysql_error());

        $option = array();
        while ($row = mysql_fetch_array($query)) {
            $option[$row['option_name']] = $row['option_value'];
        }

        return $option;
    }

    function update_company_details($array)
    {


        foreach ($array as $key => $value) {
            $query = mysql_query("select * from options where option_name = " . $this->db->qstr($key) . " ") or die (mysql_error());

            if (mysql_num_rows($query) > 0) {
                $q = mysql_query("update options set option_value=" . $this->db->qstr($value) . " where option_name = " . $this->db->qstr($key) . "") or die(mysql_error());
            } else {
                $q = mysql_query("insert into  options (option_value,option_name) values (" . $this->db->qstr($value) . "," . $this->db->qstr($key) . "); ") or die(mysql_error());

            }
        }

        if ($q) return true;
        else return false;

    }


    function get_billing_frequency()
    {

        $query = mysql_query("select * from options where option_name like '%Billing_Frequency%'  ") or die (mysql_error());


        $company_details = array();


        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $company_details[] = $arr;
        }


        return $company_details;
    }


    function update_billing_frequency($option_id, $option_value)
    {


        $q = mysql_query("update options set option_value = " . $this->db->qstr($option_value) . " where option_id = " . $this->db->qstr($option_id) . "") or die(mysql_error());


        if ($q) return true;
        else return false;

    }

    function insert_billing_frequency($option_name, $option_value)
    {


        $q = mysql_query("insert into options (option_name,option_value) values (" . $this->db->qstr($option_name) . "," . $this->db->qstr($option_value) . ") ") or die(mysql_error());


        if ($q) return true;
        else return false;

    }


    function get_email_to_send($c_setting, $notifyevent)
    {
        $emails = "";
        for ($i = 1; $i < 4; $i++) {

            if ($c_setting['co_notify_email' . $i] != "" && $c_setting['co_notifyevent' . $notifyevent . '_email' . $i] == "Y") {
                $emails[] = array('type' => 'co_notifyevent' . $notifyevent . '_email' . $i, 'email' => $c_setting['co_notify_email' . $i]);
            }

        }

        return $emails;

    }

    function get_message_details($message_type, $array)
    {

        $query = mysql_query("select * from email_template where email_name = '" . $message_type . "'") or die (mysql_error());

        $me = mysql_fetch_object($query);
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

    function get_service($id)
    {
        $query = mysql_query("select * from services where service_id = '" . $id . "' ") or die (mysql_error());

        $services = array();
        $services = array();
        $services = mysql_fetch_object($query);
        return $services;


    }


    function get_services()
    {
        $query = mysql_query("select * from services ") or die (mysql_error());

        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $services[] = $arr;
        }

        return $services;
    }

    function update_services($ser_id, $ser_name, $ser_des, $ser_short, $ser_color, $ser_timecut, $ser_order)
    {

        $sql = "update services set service_name = " . $this->db->qstr($ser_name) . ",	service_order  = " . $this->db->qstr($ser_order) . ",	sevices_description  = " . $this->db->qstr($ser_des) . ",	service_color  = " . $this->db->qstr($ser_color) . ",	service_short  = " . $this->db->qstr($ser_short) . ",	service_cutoff  = " . $this->db->qstr($ser_timecut) . " where service_id = " . $this->db->qstr($ser_id) . "";

        $query = mysql_query($sql) or die(mysql_error());

        if ($query) return true;
        else return false;

    }

    function add_services($ser_name, $ser_des, $ser_short, $ser_color, $ser_timecut, $ser_order)
    {

        $sql = "insert into services ( service_name ,	service_order ,	sevices_description ,	service_color ,	service_short ,	service_cutoff ) values(" . $this->db->qstr($ser_name) . "," . $this->db->qstr($ser_order) . "," . $this->db->qstr($ser_des) . "," . $this->db->qstr($ser_color) . "," . $this->db->qstr($ser_short) . "," . $this->db->qstr($ser_timecut) . ") ";

        $query = mysql_query($sql) or die(mysql_error());

        if ($query) return true;
        else return false;

    }

//get tax type
    function get_tax()
    {
        $query = mysql_query("select * from tax ") or die (mysql_error());

        $tax = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $tax[] = $arr;
        }

        return $tax;
    }


    function get_tax_name()
    {
        $query = mysql_query("select * from tax ") or die (mysql_error());

        $tax = array();
        while ($row = mysql_fetch_array($query)) {
            $tax[$row['tax_id']] = $row['tax_name'];
        }

        return $tax;
    }


    function get_tax_rate()
    {
        $query = mysql_query("select * from tax ") or die (mysql_error());

        $tax = array();
        while ($row = mysql_fetch_array($query)) {
            $tax[$row['tax_id']] = $row['tax_rate'] / 100;
        }

        return $tax;
    }


    function get_tax_id($id)
    {
        $query = mysql_query("select * from tax where tax_id = '$id' ") or die (mysql_error());

        return mysql_fetch_object($query);
    }

    function update_tax($tax_id, $tax_name, $tax_ratio)
    {

        $sql = "update tax set tax_name = " . $this->db->qstr($tax_name) . ",	tax_rate  = " . $this->db->qstr($tax_ratio) . "  where tax_id = " . $this->db->qstr($tax_id) . "";

        $query = mysql_query($sql) or die(mysql_error());

        if ($query) return true;
        else return false;

    }

    function add_tax($tax_name, $tax_ratio)
    {

        $sql = "insert into tax (tax_name,tax_rate) values(" . $this->db->qstr($tax_name) . "," . $this->db->qstr($tax_ratio) . ") ";

        $query = mysql_query($sql) or die(mysql_error());

        if ($query) return true;
        else return false;

    }

    function get_tax_group()
    {
        $query = mysql_query("select * from tax_group ") or die (mysql_error());

        $tax = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $tax[] = $arr;
        }

        return $tax;

    }


    function get_tax_group_list()
    {
        $query = mysql_query("select * from tax_group ") or die (mysql_error());

        $tax = array();
        while ($row = mysql_fetch_array($query)) {


            $tax[$row['taxgroup_id']] = $row;
        }

        return $tax;

    }


    function get_tax_group_id($id)
    {
        $query = mysql_query("select * from tax_group where taxgroup_id = '$id' ") or die (mysql_error());

        return mysql_fetch_object($query);
    }

    function update_taxgroup($group_id, $group_name, $tax1, $tax2, $tax2_on_tax1, $fs, $fs_rate_1, $fs_rate_2, $taxgroup_on)
    {

        $sql = "update tax_group set taxgroup_name = " . $this->db->qstr($group_name) . ",	taxgroup_tax1= " . $this->db->qstr($tax1) . ",	taxgroup_tax2 = " . $this->db->qstr($tax2) . ",	taxgroup_tax2_on_tax1= " . $this->db->qstr($tax2_on_tax1) . ",	taxgroup_fs_rate= " . $this->db->qstr($fs) . ",	taxgroup_tax1_on_fs	= " . $this->db->qstr($fs_rate_1) . ",taxgroup_tax2_on_fs = " . $this->db->qstr($fs_rate_2) . " , taxgroup_on = " . $this->db->qstr($taxgroup_on) . " where taxgroup_id = " . $this->db->qstr($group_id) . "";

        $query = mysql_query($sql) or die(mysql_error());

        if ($query) return true;
        else return false;

    }

    function insert_taxgroup($group_name, $tax1, $tax2, $tax2_on_tax1, $fs, $fs_rate_1, $fs_rate_2, $taxgroup_on)
    {

        $sql = "insert into tax_group  (taxgroup_name ,taxgroup_tax1,taxgroup_tax2 ,taxgroup_tax2_on_tax1,taxgroup_fs_rate,taxgroup_tax1_on_fs,taxgroup_tax2_on_fs , taxgroup_on) values(" . $this->db->qstr($group_name) . "," . $this->db->qstr($tax1) . "," . $this->db->qstr($tax2) . "," . $this->db->qstr($tax2_on_tax1) . "," . $this->db->qstr($fs) . "," . $this->db->qstr($fs_rate_1) . "," . $this->db->qstr($fs_rate_2) . ", " . $this->db->qstr($taxgroup_on) . ") ";

        $query = mysql_query($sql) or die(mysql_error());

        if ($query) return true;
        else return false;

    }


////////////billing code 
    function get_billing_code()
    {
        $query = mysql_query("select * from billing_code") or die(mysql_error());

        $billing_array = array();
        if (mysql_num_rows($query) > 0) {
            while ($row = mysql_fetch_assoc($query)) {

                foreach ($row as $key => $value) {

                    $arr[$key] = $value;
                }

                $billing_array[] = $arr;
            }

            return $billing_array;

        } else return false;


    }


    function get_term_details($term_id)
    {
        $query = mysql_query("select * from payment_terms where pt_id = " . $this->db->qstr($term_id) . "") or die (mysql_error());
        if (mysql_num_rows($query) == 0) $query = mysql_query("select * from payment_terms where pt_default = '1' ") or die (mysql_error());

        return mysql_fetch_object($query);
    }

    function get_page($page_id)
    {
        $query = mysql_query("select * from pages where page_id = " . $this->db->qstr($page_id) . "  ") or die (mysql_error());

        return mysql_fetch_object($query);
    }

    function get_page_status($page_id)
    {
        $query = mysql_query("select * from pages where page_type = " . $this->db->qstr($page_id) . "  ") or die (mysql_error());

        return mysql_fetch_object($query);
    }


    function get_all_page()
    {
        $query = mysql_query("select * from pages  ") or die (mysql_error());
        $data = $this->db->build_array($query);
        return $data;
    }

    function edit_page($array)
    {
        $sql = $this->db->make_update("pages", $array, "page_id", $array['page_id']);

        $q = mysql_query("update pages set page_name= '" . mysql_real_escape_string($array['page_name']) . "' , page_body = '" . (str_replace(" ", " ", $array['page_body'])) . "' where page_id = '" . $array['page_id'] . "'   ") or die (mysql_error());

        if ($q) return true;
        else return false;

    }


    function get_login_message($account_id, $control)
    {

        $view_message = "";

        $today = $this->db->adjusteddate();
        $co_subject = trim($control["co_loginmessage_subject"]);
        $co_body = trim($control["co_loginmessage_body"]);
        $cos = $control["co_startmessage"];
        $coe = $control["co_endmessage"];
        if ($coe == "0000-00-00") $coe = "9999-99-99";
        if ($today >= $cos and $today <= $coe and $co_subject . $co_body != "") $view_message[] = array('subject' => $co_subject, 'body' => $co_body);

        if ($account_id > 0) {
            $query = mysql_query("select billing_code,loginmessage_subject,loginmessage_body, startmessage,endmessage  from account where account_id = '$account_id'") or die (mysql_error());

            $client = mysql_fetch_array($query);
// mysql_free_result($ri);
            $cu_bc = $client["billing_code"];
            $cu_subject = trim($client["loginmessage_subject"]);
            $cu_body = trim($client["loginmessage_body"]);
            $cus = $client["startmessage"];
            $cue = $client["endmessage"];
            if ($cue == "0000-00-00") $cue = "9999-99-99";
            if ($today >= $cus and $today <= $cue and $cu_subject . $cu_body != "") $view_message[] = array('subject' => $cu_subject, 'body' => $cu_body);


        }


        $bc = $this->db->build_array(mysql_query("select * from billing_code"));
        if (count($bc) > 0 && $cu_bc > 0) {

            for ($i = 0; $i < count($bc); $i++) {

                if (isset($control['co_loginmessage_body_bc' . $bc[$i]['id']])) {

                    $co_subject_bc1 = trim($control["co_loginmessage_subject_bc" . $bc[$i]['id']]);
                    $co_body_bc1 = trim($control["co_loginmessage_body_bc" . $bc[$i]['id']]);
                    $cos_bc1 = $control["co_startmessage_bc" . $bc[$i]['id']];
                    $coe_bc1 = $control["co_endmessage_bc" . $bc[$i]['id']];
                    if ($coe_bc1 == "0000-00-00") $coe_bc1 = "9999-99-99";

                    if ($today >= $cos_bc1 and $today <= $coe_bc1 and $co_subject_bc1 . $co_body_bc1 != "" and $cu_bc == $bc[$i]['id']) {
                        $view_message[] = array('subject' => $co_subject_bc1, 'body' => $co_body_bc1);

                    }

                }

            }

        }

        return $view_message;


    }

    function get_taxgrouponfs_list()
    {
        $q = mysql_query("select * from tax_group") or die(mysql_error());
        while ($row = mysql_fetch_array($q)) {
            $v = "";
            $v = explode(",", $row['taxgroup_on']);

            for ($i = 0; $i < count($v); $i++) {
                if ($v[$i] == '1') $v[$i] = 'Y';
                else $v[$i] = 'N';
            }

            $list[$row['taxgroup_id']] = array('taxfsonwb' => $v[0], 'taxfsonwt' => $v[1], 'taxfsonot' => $v[2]);
        }

    }


    function get_stat()
    {
        $sql = mysql_query("select count(*) as num from orders where order_status in (1,3) ") or die(mysql_error());
        $num = mysql_fetch_array($sql);
        $new_order_num = $num['num'];
        $array['new_order'] = $new_order_num;

        $sql = mysql_query("select count(*) as num from account where status = '0' ") or die(mysql_error());
        $num = mysql_fetch_array($sql);
        $new_account_num = $num['num'];
        $array['new_accounts'] = $new_account_num;


        $sql = mysql_query("select count(*) as num from orders where order_status in (1,3) and driver_id != 0 group by driver_id ") or die(mysql_error());
        //$num = mysql_fetch_array($sql);
        $working_drivers = mysql_num_rows($sql);
        $array['working_drivers'] = $working_drivers;


        $sql = mysql_query("select count(*) as num from orders where order_status in (1,2,3) and order_date >= '" . date("Y-m-d 00:00:00") . "' and order_date <= '" . date("Y-m-d 23:59:59") . "'  ") or die(mysql_error());
        $num = mysql_fetch_array($sql);
        $today_new_orders = $num['num'];
        $array['today_new_orders'] = $today_new_orders;

        $sql = mysql_query("select count(*) as num from orders where order_status in (2)   ") or die(mysql_error());
        $num = mysql_fetch_array($sql);
        $today_completed_orders = $num['num'];
        $array['today_completed_orders'] = $today_completed_orders;


        $sql = mysql_query("select count(*) as num from orders where order_status in (3)   ") or die(mysql_error());
        $num = mysql_fetch_array($sql);
        $today_working_orders = $num['num'];
        $array['today_working_orders'] = $today_working_orders;


        return $array;
    }


    function get_driver_stat()
    {
        $sql = mysql_query("select count(*) as num,drivers.name,drivers.driverno from orders inner join drivers on (orders.driver_id = drivers.id) where orders.order_status in (1,3) and driver_id != 0 group by orders.driver_id ") or die(mysql_error());

        $sql2 = mysql_query("select count(*) as num from orders  where orders.order_status in (1,3)  and driver_id != 0 ") or die(mysql_error());

        $num = mysql_fetch_array($sql2);
        $total = $num['num'];


        $result = array();
        $i = 0;
        while ($row = mysql_fetch_array($sql)) {
            $per = ($row['num'] / $total) * 100;
            $result[] = array("label" => $row['driverno'] . '|' . $row['name'], "data" => $per, "color" => $color[$i]);
            $i++;
        }

        return $result;

    }


}


?>