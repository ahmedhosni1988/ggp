<?php

class users
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }



    public function set_login_with_cookies()
    {
    }

    public function Check_login($username, $password, $account_name)
    {
        $result = mysqli_query($this->db, "select users.* , account.* from users as users 
left join account as account 
on (users.account_id = account.account_id) 
where 
users.user_name = " . check_mysql_string($this->db, $username) . " and
(users.status ='1' || users.status ='2' ) and
(account.status = '1' || account.status = '6' ) and 
users.user_pass = '" . md5($password) . "' and 
account.account_name = " . check_mysql_string($this->db, $account_name) . " ") or die(mysqli_error($this->db));
        $num = mysqli_num_rows($result);

        $login_attribute = mysqli_fetch_array($result);


        if ($num == 1) {
            $login_attribute['login'] = true;
        } else {
            $login_attribute['login'] = false;
        }


        return $login_attribute;
    }


    public function Check_admin_login($username, $password)
    {
        $result = mysqli_query($this->db, "select users.*  from users as users 
                    where 
                    users.user_name = " . check_mysql_string($this->db, $username) . " and
                    users.user_pass = '" . md5($password) . "' and
                    users.account_id = '0' and 
                    users.status = '2'
    ") or die(mysqli_error($this->db));
        $num = mysqli_num_rows($result);

        $login_attribute = mysqli_fetch_array($result);


        if ($num == 1) {
            $login_attribute['login'] = true;
        } else {
            $login_attribute['login'] = false;
        }


        return $login_attribute;
    }


    public function set_login_sessions($Login_attribute)
    {
        //start the session
        $login = array_keys($Login_attribute);
        //print_r($Login_attribute);

        foreach ($Login_attribute as $key => $var) {
            if (!is_numeric($key)) {
                $_SESSION[$key] = $var;
            }
        }
    }


    public function get_user_details($user_id)
    {
        $sql = "select u.* , a.account_name from users as u inner join account as a on (u.account_id = a.account_id) where u.user_id = '$user_id'";
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        $row = mysqli_fetch_object($query);

        return $row;
    }

    public function get_admin_details($user_id)
    {
        $sql = "select *  from users where user_id = '$user_id' ";
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        $row = mysqli_fetch_object($query);

        return $row;
    }


    public function add_user($account_id, $user_name, $user_pass, $name, $address, $phone, $fax, $email, $user_type, $status)
    {
        $sql = "insert into users (account_id,user_name,user_pass,name,address,phone,fax,email,user_type,status) values (" . check_mysql_string($this->db, $account_id) . "," . check_mysql_string($this->db, $user_name) . ",'" . md5($user_pass) . "'," . check_mysql_string($this->db, $name) . "," . check_mysql_string($this->db, $address) . "," . check_mysql_string($this->db, $phone) . "," . check_mysql_string($this->db, $fax) . "," . check_mysql_string($this->db, $email) . "," . check_mysql_string($this->db, $user_type) . "," . check_mysql_string($this->db, $status) . ");";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }

    public function edit_user($user_id, $account_id, $name, $password, $phone, $fax, $email, $address, $user_type)
    {
        $sql = "";
        if (empty($password) && $password == "") {
            $sql = "update users set name=" . check_mysql_string($this->db, $name) . " , phone = " . check_mysql_string($this->db, $phone) . " , fax =" . check_mysql_string($this->db, $fax) . " , email =" . check_mysql_string($this->db, $email) . " ,address=" . check_mysql_string($this->db, $address) . ", user_type = " . check_mysql_string($this->db, $user_type) . " where user_id= " . check_mysql_string($this->db, $user_id) . " and account_id =" . check_mysql_string($this->db, $account_id) . "   ";
        } else {
            $sql = "update users set name=" . check_mysql_string($this->db, $name) . " , user_pass = '" . md5($password) . "' ,phone = " . check_mysql_string($this->db, $phone) . " , fax =" . check_mysql_string($this->db, $fax) . " , email =" . check_mysql_string($this->db, $email) . " ,address=" . check_mysql_string($this->db, $address) . ", user_type = " . check_mysql_string($this->db, $user_type) . " where user_id= " . check_mysql_string($this->db, $user_id) . " and account_id =" . check_mysql_string($this->db, $account_id) . "   ";
        }

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_user($user_id)
    {
        $query = mysqli_query($this->db, "delete from  users  where user_id = " . check_mysql_string($this->db, $user_id) . " ") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function edit_user_admin($user_id, $account_id, $name, $password, $phone, $fax, $email, $address, $user_type)
    {
        $sql = "";
        if (empty($password) && $password == "") {
            $sql = "update users set name=" . check_mysql_string($this->db, $name) . " , phone = " . check_mysql_string($this->db, $phone) . " , fax =" . check_mysql_string($this->db, $fax) . " , email =" . check_mysql_string($this->db, $email) . " ,address=" . check_mysql_string($this->db, $address) . ",user_type=" . check_mysql_string($this->db, $user_type) . " where user_id= " . check_mysql_string($this->db, $user_id) . " and account_id =" . check_mysql_string($this->db, $account_id) . "   ";
        } else {
            $sql = "update users set name=" . check_mysql_string($this->db, $name) . " , user_pass = '" . md5($password) . "' ,phone = " . check_mysql_string($this->db, $phone) . " , fax =" . check_mysql_string($this->db, $fax) . " , email =" . check_mysql_string($this->db, $email) . " ,address=" . check_mysql_string($this->db, $address) . " where user_id = " . check_mysql_string($this->db, $user_id) . " and account_id =" . check_mysql_string($this->db, $account_id) . "   ";
        }

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function logout()
    {
        unset($_SESSION);
        session_destroy();
    }


    public function get_users($status)
    {
        $query = mysqli_query($this->db, "select * from  users where status = '$status' ") or die(mysqli_error($this->db));

        $payment = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $payment[] = $arr;
        }

        return $payment;
    }

    public function get_admin_user($user_id)
    {
        $sql = "select *  from users  where user_id = '$user_id'";
        $query = mysqli_query($this->db, $sql);

        $row = mysqli_fetch_object($query);

        return $row;
    }


    public function forget_password($email, $type)
    {
        if ($type == "admin") {
            $sql = " and account_id = '0' ";
        } elseif ($type = "client") {
            $sql = " and status = '1' ";
        }
        $query = mysqli_query($this->db, "select * from users where email = " . check_mysql_string($this->db, $email) . " " . $sql) or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) == "1") {

            //generate link code
            $code = $this->gen_uuid();

            mysqli_query($this->db, "update users set ran_code = '" . $code . "'  where email = " . check_mysql_string($this->db, $email) . " " . $sql) or die(mysqli_error($this->db));

            $userData = mysqli_fetch_array($query);

            $userData['code'] = $code;

            return $userData;
        } elseif (mysqli_num_rows($query) == "0") {
            return 1;
        } else {
            return false;
        }
    }

    public function check_code($code)
    {
        $query = mysqli_query($this->db, "select * from users where ran_code = " . check_mysql_string($this->db, $code) . " ") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) == "1") {
            return mysqli_fetch_array($query);
        } else {
            return false;
        }
    }


    public function update_password($pass, $code)
    {
        $query = mysqli_query($this->db, "update users set user_pass = '" . md5($pass) . "' , ran_code = '' , pass_update_time = '" . date("Y-m-d H:i:s") . "'  where ran_code  = " . check_mysql_string($this->db, $code) . " ") or die(mysqli_error($this->db));


        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function gen_uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),

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
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
