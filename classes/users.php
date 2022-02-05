<?php

class users
{

    var $db;

    function users($db)
    {
        $this->db = $db;
    }


    function set_login_with_cookies()
    {

    }

    function Check_login($username, $password, $account_name)
    {


        $result = mysql_query("select users.* , account.* from users as users 
left join account as account 
on (users.account_id = account.account_id) 
where 
users.user_name = " . $this->db->qstr($username) . " and
(users.status ='1' || users.status ='2' ) and
(account.status = '1' || account.status = '6' ) and 
users.user_pass = '" . md5($password) . "' and 
account.account_name = " . $this->db->qstr($account_name) . " ") or die (mysql_error());
        $num = mysql_num_rows($result);

        $login_attribute = mysql_fetch_array($result);


        if ($num == 1) {
            $login_attribute['login'] = true;
        } else {
            $login_attribute['login'] = false;
        }


        return $login_attribute;
    }


    function Check_admin_login($username, $password)
    {


        $result = mysql_query("select users.*  from users as users 
                    where 
                    users.user_name = " . $this->db->qstr($username) . " and
                    users.user_pass = '" . md5($password) . "' and
                    users.account_id = '0'
    ") or die (mysql_error());
        $num = mysql_num_rows($result);

        $login_attribute = mysql_fetch_array($result);


        if ($num == 1) {
            $login_attribute['login'] = true;
        } else {
            $login_attribute['login'] = false;
        }


        return $login_attribute;
    }


    function set_login_sessions($Login_attribute)
    {
        //start the session
        $login = array_keys($Login_attribute);
        //print_r($Login_attribute);

        foreach ($Login_attribute as $key => $var) {
            if (!is_numeric($key)) $_SESSION[$key] = $var;
        }


    }


    function get_user_details($user_id)
    {
        $sql = "select u.* , a.account_name from users as u inner join account as a on (u.account_id = a.account_id) where u.user_id = '$user_id'";
        $query = mysql_query($sql) or die (mysql_error());

        $row = mysql_fetch_object($query);

        return $row;
    }

    function get_admin_details($user_id)
    {
        $sql = "select *  from users where user_id = '$user_id' ";
        $query = mysql_query($sql) or die (mysql_error());

        $row = mysql_fetch_object($query);

        return $row;
    }


    function add_user($account_id, $user_name, $user_pass, $name, $address, $phone, $fax, $email, $user_type, $status)
    {

        $sql = "insert into users (account_id,user_name,user_pass,name,address,phone,fax,email,user_type,status) values (" . $this->db->qstr($account_id) . "," . $this->db->qstr($user_name) . ",'" . md5($user_pass) . "'," . $this->db->qstr($name) . "," . $this->db->qstr($address) . "," . $this->db->qstr($phone) . "," . $this->db->qstr($fax) . "," . $this->db->qstr($email) . "," . $this->db->qstr($user_type) . "," . $this->db->qstr($status) . ");";

        $query = mysql_query($sql) or die (mysql_error());

        if ($query) return mysql_insert_id();
        else return false;

    }

    function edit_user($user_id, $account_id, $name, $password, $phone, $fax, $email, $address, $user_type)
    {
        $sql = "";
        if (empty($password) && $password == "") {
            $sql = "update users set name=" . $this->db->qstr($name) . " , phone = " . $this->db->qstr($phone) . " , fax =" . $this->db->qstr($fax) . " , email =" . $this->db->qstr($email) . " ,address=" . $this->db->qstr($address) . ", user_type = " . $this->db->qstr($user_type) . " where user_id= " . $this->db->qstr($user_id) . " and account_id =" . $this->db->qstr($account_id) . "   ";
        } else {
            $sql = "update users set name=" . $this->db->qstr($name) . " , user_pass = '" . md5($password) . "' ,phone = " . $this->db->qstr($phone) . " , fax =" . $this->db->qstr($fax) . " , email =" . $this->db->qstr($email) . " ,address=" . $this->db->qstr($address) . ", user_type = " . $this->db->qstr($user_type) . " where user_id= " . $this->db->qstr($user_id) . " and account_id =" . $this->db->qstr($account_id) . "   ";
        }

        $query = mysql_query($sql) or die (mysql_error());

        if ($query) return true;
        else return false;

    }

    function delete_user($user_id)
    {
        $query = mysql_query("delete from  users  where user_id = " . $this->db->qstr($user_id) . " ") or die (mysql_error());

        if ($query) return true;
        else return false;
    }


    function edit_user_admin($user_id, $account_id, $name, $password, $phone, $fax, $email, $address, $user_type)
    {
        $sql = "";
        if (empty($password) && $password == "") {
            $sql = "update users set name=" . $this->db->qstr($name) . " , phone = " . $this->db->qstr($phone) . " , fax =" . $this->db->qstr($fax) . " , email =" . $this->db->qstr($email) . " ,address=" . $this->db->qstr($address) . ",user_type=" . $this->db->qstr($user_type) . " where user_id= " . $this->db->qstr($user_id) . " and account_id =" . $this->db->qstr($account_id) . "   ";
        } else {
            $sql = "update users set name=" . $this->db->qstr($name) . " , user_pass = '" . md5($password) . "' ,phone = " . $this->db->qstr($phone) . " , fax =" . $this->db->qstr($fax) . " , email =" . $this->db->qstr($email) . " ,address=" . $this->db->qstr($address) . " where user_id = " . $this->db->qstr($user_id) . " and account_id =" . $this->db->qstr($account_id) . "   ";
        }

        $query = mysql_query($sql) or die (mysql_error());

        if ($query) return true;
        else return false;

    }


    function logout()
    {


        unset ($_SESSION);
        session_destroy();

    }


    function get_users($status)
    {

        $query = mysql_query("select * from  users where status = '$status' ") or die (mysql_error());

        $payment = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $payment[] = $arr;
        }

        return $payment;
    }

    function get_admin_user($user_id)
    {
        $sql = "select *  from users  where user_id = '$user_id'";
        $query = mysql_query($sql);

        $row = mysql_fetch_object($query);

        return $row;
    }


    function forget_password($email, $type)
    {

        if ($type == "admin") $sql = " and account_id = '0' ";
        else if ($type = "client") $sql = " and status = '1' ";
        $query = mysql_query("select * from users where email = " . $this->db->qstr($email) . " " . $sql) or die (mysql_error());

        if (mysql_num_rows($query) == "1") {

            //generate link code
            $code = $this->gen_uuid();

            mysql_query("update users set ran_code = '" . $code . "'  where email = " . $this->db->qstr($email) . " " . $sql) or die (mysql_error());

            $userData = mysql_fetch_array($query);

            $userData['code'] = $code;

            return $userData;

        } elseif (mysql_num_rows($query) == "0") {

            return 1;
        } else {

            return false;

        }

    }

    function check_code($code)
    {

        $query = mysql_query("select * from users where ran_code = " . $this->db->qstr($code) . " ") or die (mysql_error());

        if (mysql_num_rows($query) == "1") {

            return mysql_fetch_array($query);

        } else {
            return false;
        }
    }


    function update_password($pass, $code)
    {

        $query = mysql_query("update users set user_pass = '" . md5($pass) . "' , ran_code = '' , pass_update_time = '" . date("Y-m-d H:i:s") . "'  where ran_code  = " . $this->db->qstr($code) . " ") or die (mysql_error());


        if ($query) {

            return true;
        } else {
            return false;
        }
    }

    function gen_uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

}


?>