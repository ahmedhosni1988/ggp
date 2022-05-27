<?php

class account
{
    public $db;
    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }

    public function payment_type()
    {
        $sql = "select * from payment_type ";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        $payment_type = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $payment_type[] = $arr;
        }


        return $payment_type;
    }
    public function get_all_accounts($status, $billing_code=false)
    {
        $sql = "select account.* , `billing_code`.`billingcode_name` from account 
        inner join billing_code on (account.billing_code = billing_code.id)
        where status = '$status' ";

        if ($billing_code && $billing_code > '0') {
            $sql .=" and  account.billing_code = '$billing_code' ";
        }
        $sql .="order by account_company";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        $category = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;
    }


    public function check_exist($key, $value)
    {
        $q = mysqli_query($this->db, "select * from account where $key = '$value' ") or die(mysqli_error($this->db));

        if (mysqli_num_rows($q) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_accounts_id($status)
    {
        $sql = "select account_id from account where status = '$status'";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        $id = "";
        while ($row = mysqli_fetch_array($query)) {
            $id .= $row['account_id'] . ",";
        }

        $id = substr($id, 0, strlen($id) - 1);

        return $id;
    }

    public function get_accounts_where($data, $type)
    {
        $sql = "select * from account ";
        if (count($data) > 0) {
            $sql .= " where ";
            foreach ($data as $key => $value) {
                $sql .= " " . $key . " = '" . $value . "' " . $type . " ";
            }

            $sql = substr($sql, 0, strlen($sql) - 4);
        }

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        $category = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;
    }

    public function get_account_users($account_id)
    {
        $sql = "select * from users where account_id = " . check_mysql_string($this->db,$account_id);

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        $category = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;
    }

    public function get_account($account_id)
    {
        $query = mysqli_query($this->db, "select * from account where account_id = " . check_mysql_string($this->db,$account_id) . " ") or die(mysqli_error($this->db));

        $account = array();
        $row = mysqli_fetch_object($query);
        $account = $row;
        return $account;
    }

    public function get_supplier($account_id)
    {
        $query = mysqli_query($this->db, "select * from suppliers where account_id = " . check_mysql_string($this->db,$account_id) . " ") or die(mysqli_error($this->db));

        $account = array();
        $row = mysqli_fetch_object($query);
        $account = $row;
        return $account;
    }




    public function get_account_id_byname($acctno)
    {
        $query = mysqli_query($this->db, "select account_id from account where account_name = " . check_mysql_string($this->db,$acctno) . " ") or die(mysqli_error($this->db));

        $account = array();
        $row = mysqli_fetch_object($query);

        return $row->account_id;
    }

    public function get_account_byname($account_id)
    {
        $query = mysqli_query($this->db, "select * from account where account_name = " . check_mysql_string($this->db,$account_id) . " ") or die(mysqli_error($this->db));

        $account = array();
        $row = mysqli_fetch_object($query);
        $account = $row;
        return $account;
    }


    public function add_account($account_name, $account_company, $account_address, $city, $pcode, $phone, $fax, $status, $account_catid, $account_location, $account_taxgroup)
    {
        $sql = "insert into account ( account_name, account_company,account_address,city,pcode,phone,fax,status,account_catid,account_location,account_taxgroup,date_added) values (" . check_mysql_string($this->db,$account_name) . "," . check_mysql_string($this->db,$account_company) . "," . check_mysql_string($this->db,$account_address) . ", " . check_mysql_string($this->db,$city) . " ," . check_mysql_string($this->db,$pcode) . "," . check_mysql_string($this->db,$phone) . "," . check_mysql_string($this->db,$fax) . "," . check_mysql_string($this->db,$status) . "," . check_mysql_string($this->db,$account_catid) . "," . check_mysql_string($this->db,$account_location) . "," . check_mysql_string($this->db,$account_taxgroup) . ",NOW())  ;";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }


    public function add_account_array($post)
    {
        $sql = "insert into  account";

//        echo $post['account_name'];
        foreach ($post as $key => $value) {
            $ka = explode('__', $key);
            if ($ka[0] != 'nc') {
                $sqlk .= $key . ',';
                $sqlval .= check_mysql_string($this->db,$value) . ',';
            }
        }

        $s = $sql . '(' . substr($sqlk, 0, strlen($sqlk) - 1) . ') values (' . substr($sqlval, 0, strlen($sqlval) - 1) . ');';

        $query = mysqli_query($this->db, $s) or die(mysqli_error($this->db));
        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
//        return false;
    }


    
    public function add_supplier_array($post)
    {
        $sql = "insert into  suppliers";

//        echo $post['account_name'];
        foreach ($post as $key => $value) {
            $ka = explode('__', $key);
            if ($ka[0] != 'nc') {
                $sqlk .= $key . ',';
                $sqlval .= check_mysql_string($this->db,$value) . ',';
            }
        }

        $s = $sql . '(' . substr($sqlk, 0, strlen($sqlk) - 1) . ') values (' . substr($sqlval, 0, strlen($sqlval) - 1) . ');';

        $query = mysqli_query($this->db, $s) or die(mysqli_error($this->db));
        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
//        return false;
    }


    
    public function edit_supplier_array($post, $account_id)
    {
        $sql = "update  suppliers set ";
        $sqlk = "";


        foreach ($post as $key => $value) {
            $ka = explode('__', $key);
            //print_r($ka);
            if ($ka[0] != 'nc' && $ka[0] != "pattern" && $ka[0] != "distance" && $ka[0] != "price") {
                $sqlk .= $key . '=' . check_mysql_string($this->db,$value) . ' ,';
            }
        }
        $s = $sql . ' ' . substr($sqlk, 0, strlen($sqlk) - 1) . ' where account_id = ' . check_mysql_string($this->db,$account_id);

        //echo $s;

        $query = mysqli_query($this->db, $s) or die(mysqli_error($this->db));
        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function edit_account_array($post, $account_id)
    {
        $sql = "update  account set ";
        $sqlk = "";


        foreach ($post as $key => $value) {
            $ka = explode('__', $key);
            //print_r($ka);
            if ($ka[0] != 'nc' && $ka[0] != "pattern" && $ka[0] != "distance" && $ka[0] != "price") {
                $sqlk .= $key . '=' . check_mysql_string($this->db,$value) . ' ,';
            }
        }
        $s = $sql . ' ' . substr($sqlk, 0, strlen($sqlk) - 1) . ' where account_id = ' . check_mysql_string($this->db,$account_id);

        //echo $s;

        $query = mysqli_query($this->db, $s) or die(mysqli_error($this->db));
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function add_price_over($post, $account_id)
    {
        $query = mysqli_query($this->db, "delete from account_override where account_id = " . check_mysql_string($this->db,$account_id) . " ") or die(mysqli_error($this->db));
        $query = mysqli_query($this->db, "delete from account_vec_ser where account_id = " . check_mysql_string($this->db,$account_id) . " ") or die(mysqli_error($this->db));
        $query = mysqli_query($this->db, "delete from pickupfees where client_acctno = " . check_mysql_string($this->db,$account_id) . " ") or die(mysqli_error($this->db));
        $query = mysqli_query($this->db, "delete from deliveryfees where client_acctno = " . check_mysql_string($this->db,$account_id) . " ") or die(mysqli_error($this->db));


        $saved_zone = "";
        $from_zone = "";
        $to_zone = "";
        foreach ($post as $key => $value) {
            $ka = explode('__', $key);
            if ($ka[0] != "pattern" && $ka[0] != "distance") {
                if ($ka[0] == 'nc' && $ka[1] == "price_ovrd_extra_pieces") {
                    if ($value != "") {
                        $q = mysqli_query($this->db, "insert into account_override (account_id,package_id,override,type) values (" . check_mysql_string($this->db,$account_id) . "," . check_mysql_string($this->db,$ka[2]) . "," . check_mysql_string($this->db,$value) . ",'extra'); ") or die(mysqli_error($this->db));
                    }
                }

                if ($ka[0] == 'nc' && $ka[1] == "price_ovrd_nocharge_pieces") {
                    if ($value != "") {
                        $q = mysqli_query($this->db, "insert into account_override (account_id,package_id,override,type) values (" . check_mysql_string($this->db,$account_id) . "," . check_mysql_string($this->db,$ka[2]) . "," . check_mysql_string($this->db,$value) . ",'nocharge'); ") or die(mysqli_error($this->db));
                    }
                }

                if ($ka[0] == 'nc' && $ka[1] == "t_package_type") {
                    if ($value != "") {
                        $q = mysqli_query($this->db, "insert into account_override (account_id,package_id,override,type) values (" . check_mysql_string($this->db,$account_id) . "," . check_mysql_string($this->db,$ka[2]) . "," . check_mysql_string($this->db,$value) . ",'addservices'); ") or die(mysqli_error($this->db));
                    }
                }

                if ($ka[0] == 'nc' && $ka[1] == "vechile_services") {
                    if ($value != "") {
                        $q = mysqli_query($this->db, "insert into account_override (account_id,package_id,override,type) values (" . check_mysql_string($this->db,$account_id) . "," . check_mysql_string($this->db,$ka[2]) . "," . check_mysql_string($this->db,$value) . ",'vechile_services'); ") or die(mysqli_error($this->db));
                    }
                }


                if ($ka[0] == 'nc' && $ka[1] == "min_service") {
                    if ($value != "") {
                        $q = mysqli_query($this->db, "insert into account_override (account_id,package_id,override,type) values (" . check_mysql_string($this->db,$account_id) . "," . check_mysql_string($this->db,$ka[2]) . "," . check_mysql_string($this->db,$value) . ",'min_service'); ") or die(mysqli_error($this->db));
                    }
                }


                if ($ka[0] == 'nc' && $ka[1] == "ser_vec") {
                    if ($value != "") {
                        $q = mysqli_query($this->db, "insert into account_vec_ser (account_id,services_id,vechile_id,override,type) values (" . check_mysql_string($this->db,$account_id) . "," . check_mysql_string($this->db,$ka[2]) . "," . check_mysql_string($this->db,$ka[3]) . "," . check_mysql_string($this->db,$value) . ",'flat_rate'); ") or die(mysqli_error($this->db));
                    }
                }


                if ($ka[0] == 'nc' && $ka[1] == "distance_fee") {
                    if ($value != "") {
                        $q = mysqli_query($this->db, "insert into account_vec_ser (account_id,services_id,vechile_id,override,type) values (" . check_mysql_string($this->db,$account_id) . "," . check_mysql_string($this->db,$ka[2]) . "," . check_mysql_string($this->db,$ka[3]) . "," . check_mysql_string($this->db,$value) . ",'distance_fee'); ") or die(mysqli_error($this->db));
                    }
                }

                ///pickup addds
                if ($ka[0] == 'nc' && $ka[1] == "pickup") {
                    if (isset($ka[2]) && $ka[2] == "zone") {
                        $saved_zone = $value;
                    } else {
                        if ($value != "") {
                            $q = mysqli_query($this->db, "insert into pickupfees (client_acctno,vehicle_id,zone,fee) values (" . check_mysql_string($this->db,$account_id) . "," . check_mysql_string($this->db,$ka[2]) . "," . strtoupper(check_mysql_string($this->db,$saved_zone)) . "," . check_mysql_string($this->db,$value) . "); ") or die(mysqli_error($this->db));
                        }
                    }
                }

                ////delivery addd
                if ($ka[0] == 'nc' && $ka[1] == "delivery") {
                    if (isset($ka[2]) && $ka[2] == "zonefrom") {
                        $from_zone = $value;
                    } elseif (isset($ka[2]) && $ka[2] == "zoneto") {
                        $to_zone = $value;
                    } else {
                        if ($value != "") {
                            $q = mysqli_query($this->db, "insert into deliveryfees (client_acctno,svc,zonefrom,zoneto,price) values (" . check_mysql_string($this->db,$account_id) . "," . check_mysql_string($this->db,$ka[2]) . "," . strtoupper(check_mysql_string($this->db,$from_zone)) . "," . strtoupper(check_mysql_string($this->db,$to_zone)) . "," . check_mysql_string($this->db,$value) . "); ") or die(mysqli_error($this->db));
                        }
                    }
                }
            }
        }
    }


    public function get_price_over($account_id)
    {
        $query = mysqli_query($this->db, "select * from account_override where account_id= " . check_mysql_string($this->db,$account_id) . "") or die(mysqli_error($this->db));
        $prive_over = array();
        while ($row = mysqli_fetch_array($query)) {
            $prive_over[$row['package_id']][$row['type']] = $row['override'];
        }


        return $prive_over;
    }


    public function get_account_addservice($account_id, $type)
    {
        $query = mysqli_query($this->db, "select * from account_override where account_id= " . check_mysql_string($this->db,$account_id) . " and type='" . $type . "'") or die(mysqli_error($this->db));


        return build_array($query);
    }

    public function get_account_vechileservices($account_id)
    {
        $query = mysqli_query($this->db, "select * from account_override where account_id= " . check_mysql_string($this->db,$account_id) . "") or die(mysqli_error($this->db));
        $prive_over = array();
        while ($row = mysqli_fetch_array($query)) {
            $prive_over[$row['package_id']][$row['type']] = $row['override'];
        }


        return $prive_over;
    }


    public function get_vec_ser($account_id)
    {
        $query = mysqli_query($this->db, "select * from account_vec_ser where account_id= " . check_mysql_string($this->db,$account_id) . "") or die(mysqli_error($this->db));
        $prive_over = array();
        while ($row = mysqli_fetch_array($query)) {
            $prive_over[$row['services_id']][$row['vechile_id']][$row['type']] = $row['override'];
        }


        return $prive_over;
    }


    public function get_account_pickup($account_id)
    {
        $query = mysqli_query($this->db, "select * from pickupfees where client_acctno = " . check_mysql_string($this->db,$account_id) . " group by zone") or die(mysqli_error($this->db));

        $account_pikup = array();
        while ($row = mysqli_fetch_array($query)) {
            $q2 = mysqli_query($this->db, "select * from pickupfees where client_acctno = " . check_mysql_string($this->db,$account_id) . " and zone='" . $row['zone'] . "'") or die(mysqli_error($this->db));
            $zones = array();
            while ($r = mysqli_fetch_array($q2)) {
                $zones[$r['zone']][$r['vehicle_id']] = $r['fee'];
            }
            $account_pikup[] = array('zone' => $row['zone'], 'vec_fee' => $zones);
        }

        return $account_pikup;
    }

    public function get_account_delivery($account_id, $chart = "0")
    {
        $query = mysqli_query($this->db, "select * from deliveryfees where client_acctno = " . check_mysql_string($this->db,$account_id) . " and chart = '" . $chart . "'  group by zonefrom,zoneto ") or die(mysqli_error($this->db));

        $account_pikup = array();
        while ($row = mysqli_fetch_array($query)) {
            $q2 = mysqli_query($this->db, "select * from deliveryfees where client_acctno = " . check_mysql_string($this->db,$account_id) . " and zonefrom='" . $row['zonefrom'] . "' and chart = '" . $chart . "' ") or die(mysqli_error($this->db));
            $zones = array();
            while ($r = mysqli_fetch_array($q2)) {
                $zones[$r['zonefrom']][$r['zoneto']][$r['svc']] = $r['price'];
            }

            $account_pikup[] = array('zonefrom' => $row['zonefrom'], 'zoneto' => $row['zoneto'], 'srv_fee' => $zones);
        }

        return $account_pikup;
    }


    public function update_account_name($account_id, $account_name)
    {
        $sql = "update account set account_name = " . check_mysql_string($this->db,$account_name) . "  where account_id = " . check_mysql_string($this->db,$account_id) . " ";
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
    }

    public function edit_account_admin($account_company, $account_address, $city, $pcode, $phone, $fax, $status, $account_catid, $account_location, $account_taxgroup, $account_id)
    {
        $sql = "update account set  account_company = " . check_mysql_string($this->db,$account_company) . ", account_address = " . check_mysql_string($this->db,$account_address) . ", city = " . check_mysql_string($this->db,$city) . " , pcode = " . check_mysql_string($this->db,$pcode) . " , phone =  " . check_mysql_string($this->db,$phone) . ", fax = " . check_mysql_string($this->db,$fax) . " ,status = " . check_mysql_string($this->db,$status) . ", account_catid=" . check_mysql_string($this->db,$account_catid) . ",account_location=" . check_mysql_string($this->db,$account_location) . ",account_taxgroup=" . check_mysql_string($this->db,$account_taxgroup) . " where account_id = " . check_mysql_string($this->db,$account_id) . "";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_account($account_company, $account_address, $city, $pcode, $phone, $fax, $account_id)
    {
        $sql = "update account set  account_company = " . check_mysql_string($this->db,$account_company) . ", account_address = " . check_mysql_string($this->db,$account_address) . ", city = " . check_mysql_string($this->db,$city) . " , pcode = " . check_mysql_string($this->db,$pcode) . " , phone =  " . check_mysql_string($this->db,$phone) . ", fax = " . check_mysql_string($this->db,$fax) . "  where account_id = " . check_mysql_string($this->db,$account_id) . "";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function update_contact_account($contact_name, $contact_phone, $contact_email, $contact_delivery, $contact_id)
    {
        $sql = "update contacts set phone = " . check_mysql_string($this->db,$contact_phone) . "	,email = " . check_mysql_string($this->db,$contact_email) . ",contact_name = " . check_mysql_string($this->db,$contact_name) . " , email_notify = " . check_mysql_string($this->db,$contact_delivery) . " where 	contact_id = " . check_mysql_string($this->db,$contact_id) . "";
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
    }


    public function insert_contact_account($contact_name, $contact_phone, $contact_email, $contact_delivery, $account_id)
    {

//	echo "delete from contacts where account_id = ".$account_id." and contact_type = 'account'";
        mysqli_query($this->db, "delete from contacts where account_id = " . $account_id . " and contact_type = 'account'") or die(mysqli_error($this->db));

        for ($i = 0; $i < 3; $i++) {
            if (!empty($contact_name[$i]) || !empty($contact_phone[$i]) || !empty($contact_email[$i])) {
                $sql = "insert into contacts (phone,email,contact_name,contact_type,contact_objectid,email_notify,account_id) values (" . check_mysql_string($this->db,$contact_phone[$i]) . "," . check_mysql_string($this->db,$contact_email[$i]) . "," . check_mysql_string($this->db,$contact_name[$i]) . " , 'account', " . check_mysql_string($this->db,$account_id) . " ," . check_mysql_string($this->db,$contact_delivery[$i]) . " , " . check_mysql_string($this->db,$account_id) . " ) ";
                $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
            }
        }
    }


    public function update_delivery_waybill($ids, $account_id, $type)
    {
        $sql = "update account set $type = " . check_mysql_string($this->db,$ids) . " where account_id = '$account_id'";

        mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
    }

    public function get_delivery_waybill($account_id, $type)
    {
        $sql = "select $type from account where account_id = '$account_id'";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
        $row = mysqli_fetch_array($query);
        return $row[$type];
    }


    public function add_account_category($cat_name, $cat_type)
    {
        $sql = "insert into client_category (cat_name,cat_type) values (" . check_mysql_string($this->db,$cat_name) . "," . check_mysql_string($this->db,$cat_type) . ")";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function get_account_category()
    {
        $sql = "select * from client_category";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        $category = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;
    }

    public function get_categorys_type($type)
    {
        $sql = "select * from client_category where cat_type = '$type'";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        $category = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;
    }

    public function get_category($id)
    {
        $sql = "select * from client_category where cat_id=" . check_mysql_string($this->db,$id) . "";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
        $cat_details = array();

        $cat_details = mysqli_fetch_object($query);
        return $cat_details;
    }

    public function update_category($id, $cat_name, $cat_type)
    {
        $sql = "update client_category set cat_name=" . check_mysql_string($this->db,$cat_name) . ", cat_type=" . check_mysql_string($this->db,$cat_type) . " where cat_id=" . check_mysql_string($this->db,$id) . "";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function del_account_category($cat_id)
    {
        $sql = "delete from client_category where cat_id=" . check_mysql_string($this->db,$cat_id) . "";
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            $sql2 = "update account set status = '0' where account_catid = " . check_mysql_string($this->db,$cat_id) . "";

            $query2 = mysqli_query($this->db, $sql2) or die(mysqli_error($this->db));
            if ($query2) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function get_accounts($status, $billing_code)
    {
        $sql = "";
        if ($billing_code > "0") {
            $sql = " and account.billing_code = '$billing_code' " ;
        }

        $query = mysqli_query($this->db, "select account_id,account_name,account_company,billing_code.billingcode_name,account_address,city,phone from account 
        LEFT OUTER JOIN client_category on (client_category.cat_id = account.account_catid )  
        inner JOIN billing_code on (billing_code.id = account.billing_code ) 
        where status = " . check_mysql_string($this->db,$status) . "  $sql ") or die(mysqli_error($this->db));


        $account = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $account[] = $arr;
        }


        return $account;
    }



    public function get_suppliers()
    {
        $sql = "";
   
        $query = mysqli_query($this->db, "select account_id,account_name,account_company,account_address,city,phone from suppliers ") or die(mysqli_error($this->db));


        $account = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $account[] = $arr;
        }


        return $account;
    }


    public function search_accounts($search_txt, $billing_code)
    {
        $sql = "";
        if ($billing_code > "0") {
            $sql = " and account.billing_code = '$billing_code' " ;
        }


        $query = mysqli_query($this->db, "select account_id,account_name,account_company,billing_code.billingcode_name,account_address,city,phone
         from account 
         LEFT OUTER JOIN client_category on (client_category.cat_id = account.account_catid ) 
         inner JOIN billing_code on (billing_code.id = account.billing_code ) 
         where CONCAT(account.account_name,account.account_company) Like '%" . mysqli_real_escape_string($this->db, $search_txt) . "%' $sql ") or die(mysqli_error($this->db));


        $account = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $account[] = $arr;
        }


        return $account;
    }

    public function get_unassigned_accounts()
    {
        $query = mysqli_query($this->db, "select account_id,account_name,account_company,account_address,city,pcode,phone,fax,market_way from account  where status = '6' ") or die(mysqli_error($this->db));
        $account = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $account[] = $arr;
        }


        return $account;
    }


    public function del_account($acc_id)
    {
        $query = mysqli_query($this->db, "delete from account  where status = '6' and account_id = '$acc_id' ") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function get_account_taxgroup($account_id)
    {
        $query = mysqli_query($this->db, "select account_taxgroup from account where account_id = " . check_mysql_string($this->db,$account_id) . " ") or die(mysqli_error($this->db));

        $account = array();
        $row = mysqli_fetch_object($query);
        //$account = $row->account_taxgroup;
        return $row->account_taxgroup;
    }


    public function search_account($text, $type)
    {
        if ($type == "name") {
            $query = mysqli_query($this->db, "select account_name from account where ( account_name like '%" . mysqli_real_escape_string($this->db, $text) . "%') and status= '1' Limit 0,10") or die(mysqli_error($this->db));
        }
        if ($type == "number") {
            $query = mysqli_query($this->db, "select * from account where  and status= '1' Limit 0,10") or die(mysqli_error($this->db));
        }

        $i = 0;
        $addr = array();
        while ($row = mysqli_fetch_array($query)) {
            $addr[$i] = $row['account_name'];
            $i++;
        }

        return $addr;
    }
}
