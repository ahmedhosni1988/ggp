<?php

class account
{

    var $db;

    function account($db)
    {
        $this->db = $db;
    }

function payment_type(){
    $sql = "select * from payment_type ";

        $query = mysql_query($sql) or die (mysql_error());


        $payment_type = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $payment_type[] = $arr;
        }


        return $payment_type;

}
    function get_all_accounts($status,$billing_code=false)
    {
        $sql = "select account.* , `billing_code`.`billingcode_name` from account 
        inner join billing_code on (account.billing_code = billing_code.id)
        where status = '$status' ";

        if($billing_code && $billing_code > '0'){
            $sql .=" and  account.billing_code = '$billing_code' ";
        }
        $sql .="order by account_company";

        $query = mysql_query($sql) or die (mysql_error());


        $category = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;

    }


    function check_exist($key, $value)
    {
        $q = mysql_query("select * from account where $key = '$value' ") or die (mysql_error());

        if (mysql_num_rows($q) > 0) return true;
        else return false;
    }

    function get_accounts_id($status)
    {
        $sql = "select account_id from account where status = '$status'";

        $query = mysql_query($sql) or die (mysql_error());


        $id = "";
        while ($row = mysql_fetch_array($query)) {
            $id .= $row['account_id'] . ",";
        }

        $id = substr($id, 0, strlen($id) - 1);

        return $id;

    }

    function get_accounts_where($data, $type)
    {

        $sql = "select * from account ";
        if (count($data) > 0) {
            $sql .= " where ";
            foreach ($data as $key => $value) {
                $sql .= " " . $key . " = '" . $value . "' " . $type . " ";
            }

            $sql = substr($sql, 0, strlen($sql) - 4);
        }

        $query = mysql_query($sql) or die (mysql_error());


        $category = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;


    }

    function get_account_users($account_id)
    {
        $sql = "select * from users where account_id = " . $this->db->qstr($account_id);

        $query = mysql_query($sql) or die (mysql_error());


        $category = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;
    }

    function get_account($account_id)
    {

        $query = mysql_query("select * from account where account_id = " . $this->db->qstr($account_id) . " ") or die (mysql_error());

        $account = array();
        $row = mysql_fetch_object($query);
        $account = $row;
        return $account;
    }

    function get_supplier($account_id)
    {

        $query = mysql_query("select * from suppliers where account_id = " . $this->db->qstr($account_id) . " ") or die (mysql_error());

        $account = array();
        $row = mysql_fetch_object($query);
        $account = $row;
        return $account;
    }




    function get_account_id_byname($acctno)
    {
        $query = mysql_query("select account_id from account where account_name = " . $this->db->qstr($acctno) . " ") or die (mysql_error());

        $account = array();
        $row = mysql_fetch_object($query);

        return $row->account_id;
    }

    function get_account_byname($account_id)
    {

        $query = mysql_query("select * from account where account_name = " . $this->db->qstr($account_id) . " ") or die (mysql_error());

        $account = array();
        $row = mysql_fetch_object($query);
        $account = $row;
        return $account;
    }


    function add_account($account_name, $account_company, $account_address, $city, $pcode, $phone, $fax, $status, $account_catid, $account_location, $account_taxgroup)
    {

        $sql = "insert into account ( account_name, account_company,account_address,city,pcode,phone,fax,status,account_catid,account_location,account_taxgroup,date_added) values (" . $this->db->qstr($account_name) . "," . $this->db->qstr($account_company) . "," . $this->db->qstr($account_address) . ", " . $this->db->qstr($city) . " ," . $this->db->qstr($pcode) . "," . $this->db->qstr($phone) . "," . $this->db->qstr($fax) . "," . $this->db->qstr($status) . "," . $this->db->qstr($account_catid) . "," . $this->db->qstr($account_location) . "," . $this->db->qstr($account_taxgroup) . ",NOW())  ;";

        $query = mysql_query($sql) or die (mysql_error());

        if ($query) return mysql_insert_id();
        else return false;

    }


    function add_account_array($post)
    {
        $sql = "insert into  account";

//        echo $post['account_name'];
        foreach ($post as $key => $value) {
            $ka = explode('__', $key);
            if ($ka[0] != 'nc') {
                $sqlk .= $key . ',';
                $sqlval .= $this->db->qstr($value) . ',';
            }

        }

        $s = $sql . '(' . substr($sqlk, 0, strlen($sqlk) - 1) . ') values (' . substr($sqlval, 0, strlen($sqlval) - 1) . ');';

        $query = mysql_query($s) or die (mysql_error());
        if ($query) return mysql_insert_id();
        else return false;
//        return false;
    }


    
    function add_supplier_array($post)
    {
        $sql = "insert into  suppliers";

//        echo $post['account_name'];
        foreach ($post as $key => $value) {
            $ka = explode('__', $key);
            if ($ka[0] != 'nc') {
                $sqlk .= $key . ',';
                $sqlval .= $this->db->qstr($value) . ',';
            }

        }

        $s = $sql . '(' . substr($sqlk, 0, strlen($sqlk) - 1) . ') values (' . substr($sqlval, 0, strlen($sqlval) - 1) . ');';

        $query = mysql_query($s) or die (mysql_error());
        if ($query) return mysql_insert_id();
        else return false;
//        return false;
    }


    
    function edit_supplier_array($post, $account_id)
    {
        $sql = "update  suppliers set ";
        $sqlk = "";


        foreach ($post as $key => $value) {

            $ka = explode('__', $key);
//print_r($ka);
            if ($ka[0] != 'nc' && $ka[0] != "pattern" && $ka[0] != "distance" && $ka[0] != "price") {
                $sqlk .= $key . '=' . $this->db->qstr($value) . ' ,';
            }


        }
        $s = $sql . ' ' . substr($sqlk, 0, strlen($sqlk) - 1) . ' where account_id = ' . $this->db->qstr($account_id);

//echo $s;

        $query = mysql_query($s) or die (mysql_error());
        if ($query) return true;
        else return false;
    }


    function edit_account_array($post, $account_id)
    {
        $sql = "update  account set ";
        $sqlk = "";


        foreach ($post as $key => $value) {

            $ka = explode('__', $key);
//print_r($ka);
            if ($ka[0] != 'nc' && $ka[0] != "pattern" && $ka[0] != "distance" && $ka[0] != "price") {
                $sqlk .= $key . '=' . $this->db->qstr($value) . ' ,';
            }


        }
        $s = $sql . ' ' . substr($sqlk, 0, strlen($sqlk) - 1) . ' where account_id = ' . $this->db->qstr($account_id);

//echo $s;

        $query = mysql_query($s) or die (mysql_error());
        if ($query) return true;
        else return false;
    }

    function add_price_over($post, $account_id)
    {

        $query = mysql_query("delete from account_override where account_id = " . $this->db->qstr($account_id) . " ") or die(mysql_error());
        $query = mysql_query("delete from account_vec_ser where account_id = " . $this->db->qstr($account_id) . " ") or die(mysql_error());
        $query = mysql_query("delete from pickupfees where client_acctno = " . $this->db->qstr($account_id) . " ") or die(mysql_error());
        $query = mysql_query("delete from deliveryfees where client_acctno = " . $this->db->qstr($account_id) . " ") or die(mysql_error());


        $saved_zone = "";
        $from_zone = "";
        $to_zone = "";
        foreach ($post as $key => $value) {
            $ka = explode('__', $key);
            if ($ka[0] != "pattern" && $ka[0] != "distance") {
                if ($ka[0] == 'nc' && $ka[1] == "price_ovrd_extra_pieces") {
                    if ($value != "") $q = mysql_query("insert into account_override (account_id,package_id,override,type) values (" . $this->db->qstr($account_id) . "," . $this->db->qstr($ka[2]) . "," . $this->db->qstr($value) . ",'extra'); ") or die (mysql_error());
                }

                if ($ka[0] == 'nc' && $ka[1] == "price_ovrd_nocharge_pieces") {
                    if ($value != "") $q = mysql_query("insert into account_override (account_id,package_id,override,type) values (" . $this->db->qstr($account_id) . "," . $this->db->qstr($ka[2]) . "," . $this->db->qstr($value) . ",'nocharge'); ") or die (mysql_error());
                }

                if ($ka[0] == 'nc' && $ka[1] == "t_package_type") {
                    if ($value != "") $q = mysql_query("insert into account_override (account_id,package_id,override,type) values (" . $this->db->qstr($account_id) . "," . $this->db->qstr($ka[2]) . "," . $this->db->qstr($value) . ",'addservices'); ") or die (mysql_error());
                }

                if ($ka[0] == 'nc' && $ka[1] == "vechile_services") {
                    if ($value != "") $q = mysql_query("insert into account_override (account_id,package_id,override,type) values (" . $this->db->qstr($account_id) . "," . $this->db->qstr($ka[2]) . "," . $this->db->qstr($value) . ",'vechile_services'); ") or die (mysql_error());
                }


                if ($ka[0] == 'nc' && $ka[1] == "min_service") {
                    if ($value != "") $q = mysql_query("insert into account_override (account_id,package_id,override,type) values (" . $this->db->qstr($account_id) . "," . $this->db->qstr($ka[2]) . "," . $this->db->qstr($value) . ",'min_service'); ") or die (mysql_error());
                }


                if ($ka[0] == 'nc' && $ka[1] == "ser_vec") {
                    if ($value != "") $q = mysql_query("insert into account_vec_ser (account_id,services_id,vechile_id,override,type) values (" . $this->db->qstr($account_id) . "," . $this->db->qstr($ka[2]) . "," . $this->db->qstr($ka[3]) . "," . $this->db->qstr($value) . ",'flat_rate'); ") or die (mysql_error());
                }


                if ($ka[0] == 'nc' && $ka[1] == "distance_fee") {
                    if ($value != "") $q = mysql_query("insert into account_vec_ser (account_id,services_id,vechile_id,override,type) values (" . $this->db->qstr($account_id) . "," . $this->db->qstr($ka[2]) . "," . $this->db->qstr($ka[3]) . "," . $this->db->qstr($value) . ",'distance_fee'); ") or die (mysql_error());
                }

///pickup addds
                if ($ka[0] == 'nc' && $ka[1] == "pickup") {

                    if (isset($ka[2]) && $ka[2] == "zone") {
                        $saved_zone = $value;
                    } else {

                        if ($value != "") $q = mysql_query("insert into pickupfees (client_acctno,vehicle_id,zone,fee) values (" . $this->db->qstr($account_id) . "," . $this->db->qstr($ka[2]) . "," . strtoupper($this->db->qstr($saved_zone)) . "," . $this->db->qstr($value) . "); ") or die (mysql_error());

                    }


                }

////delivery addd
                if ($ka[0] == 'nc' && $ka[1] == "delivery") {

                    if (isset($ka[2]) && $ka[2] == "zonefrom") {
                        $from_zone = $value;
                    } else if (isset($ka[2]) && $ka[2] == "zoneto") {
                        $to_zone = $value;
                    } else {

                        if ($value != "") $q = mysql_query("insert into deliveryfees (client_acctno,svc,zonefrom,zoneto,price) values (" . $this->db->qstr($account_id) . "," . $this->db->qstr($ka[2]) . "," . strtoupper($this->db->qstr($from_zone)) . "," . strtoupper($this->db->qstr($to_zone)) . "," . $this->db->qstr($value) . "); ") or die (mysql_error());

                    }


                }

            }


        }

    }


    function get_price_over($account_id)
    {
        $query = mysql_query("select * from account_override where account_id= " . $this->db->qstr($account_id) . "") or die (mysql_error());
        $prive_over = array();
        while ($row = mysql_fetch_array($query)) {

            $prive_over[$row['package_id']][$row['type']] = $row['override'];
        }


        return $prive_over;
    }


    function get_account_addservice($account_id, $type)
    {
        $query = mysql_query("select * from account_override where account_id= " . $this->db->qstr($account_id) . " and type='" . $type . "'") or die (mysql_error());


        return $this->db->build_array($query);
    }

    function get_account_vechileservices($account_id)
    {
        $query = mysql_query("select * from account_override where account_id= " . $this->db->qstr($account_id) . "") or die (mysql_error());
        $prive_over = array();
        while ($row = mysql_fetch_array($query)) {

            $prive_over[$row['package_id']][$row['type']] = $row['override'];
        }


        return $prive_over;
    }


    function get_vec_ser($account_id)
    {
        $query = mysql_query("select * from account_vec_ser where account_id= " . $this->db->qstr($account_id) . "") or die (mysql_error());
        $prive_over = array();
        while ($row = mysql_fetch_array($query)) {

            $prive_over[$row['services_id']][$row['vechile_id']][$row['type']] = $row['override'];
        }


        return $prive_over;
    }


    function get_account_pickup($account_id)
    {
        $query = mysql_query("select * from pickupfees where client_acctno = " . $this->db->qstr($account_id) . " group by zone") or die (mysql_error());

        $account_pikup = array();
        while ($row = mysql_fetch_array($query)) {
            $q2 = mysql_query("select * from pickupfees where client_acctno = " . $this->db->qstr($account_id) . " and zone='" . $row['zone'] . "'") or die (mysql_error());
            $zones = array();
            while ($r = mysql_fetch_array($q2)) {

                $zones[$r['zone']][$r['vehicle_id']] = $r['fee'];
            }
            $account_pikup[] = array('zone' => $row['zone'], 'vec_fee' => $zones);
        }

        return $account_pikup;
    }

    function get_account_delivery($account_id, $chart = "0")
    {


        $query = mysql_query("select * from deliveryfees where client_acctno = " . $this->db->qstr($account_id) . " and chart = '" . $chart . "'  group by zonefrom,zoneto ") or die (mysql_error());

        $account_pikup = array();
        while ($row = mysql_fetch_array($query)) {

            $q2 = mysql_query("select * from deliveryfees where client_acctno = " . $this->db->qstr($account_id) . " and zonefrom='" . $row['zonefrom'] . "' and chart = '" . $chart . "' ") or die (mysql_error());
            $zones = array();
            while ($r = mysql_fetch_array($q2)) {

                $zones[$r['zonefrom']][$r['zoneto']][$r['svc']] = $r['price'];
            }

            $account_pikup[] = array('zonefrom' => $row['zonefrom'], 'zoneto' => $row['zoneto'], 'srv_fee' => $zones);
        }

        return $account_pikup;
    }


    function update_account_name($account_id, $account_name)
    {
        $sql = "update account set account_name = " . $this->db->qstr($account_name) . "  where account_id = " . $this->db->qstr($account_id) . " ";
        $query = mysql_query($sql) or die (mysql_error());

    }

    function edit_account_admin($account_company, $account_address, $city, $pcode, $phone, $fax, $status, $account_catid, $account_location, $account_taxgroup, $account_id)
    {

        $sql = "update account set  account_company = " . $this->db->qstr($account_company) . ", account_address = " . $this->db->qstr($account_address) . ", city = " . $this->db->qstr($city) . " , pcode = " . $this->db->qstr($pcode) . " , phone =  " . $this->db->qstr($phone) . ", fax = " . $this->db->qstr($fax) . " ,status = " . $this->db->qstr($status) . ", account_catid=" . $this->db->qstr($account_catid) . ",account_location=" . $this->db->qstr($account_location) . ",account_taxgroup=" . $this->db->qstr($account_taxgroup) . " where account_id = " . $this->db->qstr($account_id) . "";

        $query = mysql_query($sql) or die (mysql_error());
        if ($query) return true;
        else return false;
    }

    function edit_account($account_company, $account_address, $city, $pcode, $phone, $fax, $account_id)
    {

        $sql = "update account set  account_company = " . $this->db->qstr($account_company) . ", account_address = " . $this->db->qstr($account_address) . ", city = " . $this->db->qstr($city) . " , pcode = " . $this->db->qstr($pcode) . " , phone =  " . $this->db->qstr($phone) . ", fax = " . $this->db->qstr($fax) . "  where account_id = " . $this->db->qstr($account_id) . "";

        $query = mysql_query($sql) or die (mysql_error());

        if ($query) return true;
        else return false;

    }


    function update_contact_account($contact_name, $contact_phone, $contact_email, $contact_delivery, $contact_id)
    {

        $sql = "update contacts set phone = " . $this->db->qstr($contact_phone) . "	,email = " . $this->db->qstr($contact_email) . ",contact_name = " . $this->db->qstr($contact_name) . " , email_notify = " . $this->db->qstr($contact_delivery) . " where 	contact_id = " . $this->db->qstr($contact_id) . "";
        $query = mysql_query($sql) or die(mysql_error());
    }


    function insert_contact_account($contact_name, $contact_phone, $contact_email, $contact_delivery, $account_id)
    {

//	echo "delete from contacts where account_id = ".$account_id." and contact_type = 'account'";
        mysql_query("delete from contacts where account_id = " . $account_id . " and contact_type = 'account'") or die(mysql_error());

        for ($i = 0; $i < 3; $i++) {
            if (!empty($contact_name[$i]) || !empty($contact_phone[$i]) || !empty($contact_email[$i])) {

                $sql = "insert into contacts (phone,email,contact_name,contact_type,contact_objectid,email_notify,account_id) values (" . $this->db->qstr($contact_phone[$i]) . "," . $this->db->qstr($contact_email[$i]) . "," . $this->db->qstr($contact_name[$i]) . " , 'account', " . $this->db->qstr($account_id) . " ," . $this->db->qstr($contact_delivery[$i]) . " , " . $this->db->qstr($account_id) . " ) ";
                $query = mysql_query($sql) or die(mysql_error());

            }
        }

    }


    function update_delivery_waybill($ids, $account_id, $type)
    {

        $sql = "update account set $type = " . $this->db->qstr($ids) . " where account_id = '$account_id'";

        mysql_query($sql) or die (mysql_error());
    }

    function get_delivery_waybill($account_id, $type)
    {

        $sql = "select $type from account where account_id = '$account_id'";

        $query = mysql_query($sql) or die (mysql_error());
        $row = mysql_fetch_array($query);
        return $row[$type];
    }


    function add_account_category($cat_name, $cat_type)
    {

        $sql = "insert into client_category (cat_name,cat_type) values (" . $this->db->qstr($cat_name) . "," . $this->db->qstr($cat_type) . ")";

        $query = mysql_query($sql) or die (mysql_error());
        if ($query) return true;
        else return false;

    }

    function get_account_category()
    {

        $sql = "select * from client_category";

        $query = mysql_query($sql) or die (mysql_error());


        $category = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;

    }

    function get_categorys_type($type)
    {

        $sql = "select * from client_category where cat_type = '$type'";

        $query = mysql_query($sql) or die (mysql_error());


        $category = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;

    }

    function get_category($id)
    {

        $sql = "select * from client_category where cat_id=" . $this->db->qstr($id) . "";

        $query = mysql_query($sql) or die (mysql_error());
        $cat_details = array();

        $cat_details = mysql_fetch_object($query);
        return $cat_details;
    }

    function update_category($id, $cat_name, $cat_type)
    {

        $sql = "update client_category set cat_name=" . $this->db->qstr($cat_name) . ", cat_type=" . $this->db->qstr($cat_type) . " where cat_id=" . $this->db->qstr($id) . "";

        $query = mysql_query($sql) or die (mysql_error());

        if ($query) {
            return true;
        } else {
            return false;
        }

    }


    function del_account_category($cat_id)
    {

        $sql = "delete from client_category where cat_id=" . $this->db->qstr($cat_id) . "";
        $query = mysql_query($sql) or die (mysql_error());

        if ($query) {
            $sql2 = "update account set status = '0' where account_catid = " . $this->db->qstr($cat_id) . "";

            $query2 = mysql_query($sql2) or die (mysql_error());
            if ($query2) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }


    function get_accounts($status,$billing_code)
    {

        $sql = "";
        if($billing_code > "0") $sql = " and account.billing_code = '$billing_code' " ;

        $query = mysql_query("select account_id,account_name,account_company,billing_code.billingcode_name,account_address,city,phone from account 
        LEFT OUTER JOIN client_category on (client_category.cat_id = account.account_catid )  
        inner JOIN billing_code on (billing_code.id = account.billing_code ) 
        where status = " . $this->db->qstr($status) . "  $sql ") or die (mysql_error());


        $account = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $account[] = $arr;
        }


        return $account;
    }



    function get_suppliers()
    {

        $sql = "";
   
        $query = mysql_query("select account_id,account_name,account_company,account_address,city,phone from suppliers ") or die (mysql_error());


        $account = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $account[] = $arr;
        }


        return $account;
    }


    function search_accounts($search_txt,$billing_code)
    {
        $sql = "";
        if($billing_code > "0") $sql = " and account.billing_code = '$billing_code' " ;


        $query = mysql_query("select account_id,account_name,account_company,billing_code.billingcode_name,account_address,city,phone
         from account 
         LEFT OUTER JOIN client_category on (client_category.cat_id = account.account_catid ) 
         inner JOIN billing_code on (billing_code.id = account.billing_code ) 
         where CONCAT(account.account_name,account.account_company) Like '%" . mysql_real_escape_string($search_txt) . "%' $sql ") or die (mysql_error());


        $account = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $account[] = $arr;
        }


        return $account;
    }

    function get_unassigned_accounts()
    {
        $query = mysql_query("select account_id,account_name,account_company,account_address,city,pcode,phone,fax,market_way from account  where status = '6' ") or die (mysql_error());
        $account = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $account[] = $arr;
        }


        return $account;
    }


    function del_account($acc_id)
    {
        $query = mysql_query("delete from account  where status = '6' and account_id = '$acc_id' ") or die (mysql_error());

        if ($query) return true;
        else return false;
    }

    function get_account_taxgroup($account_id)
    {

        $query = mysql_query("select account_taxgroup from account where account_id = " . $this->db->qstr($account_id) . " ") or die (mysql_error());

        $account = array();
        $row = mysql_fetch_object($query);
//$account = $row->account_taxgroup;
        return $row->account_taxgroup;
    }


    function search_account($text, $type)
    {
        if ($type == "name") $query = mysql_query("select account_name from account where ( account_name like '%" . mysql_real_escape_string($text) . "%') and status= '1' Limit 0,10") or die (mysql_error());
        if ($type == "number") $query = mysql_query("select * from account where  and status= '1' Limit 0,10") or die (mysql_error());

        $i = 0;
        $addr = array();
        while ($row = mysql_fetch_array($query)) {


            $addr[$i] = $row['account_name'];
            $i++;
        }

        return $addr;
    }


}


?>