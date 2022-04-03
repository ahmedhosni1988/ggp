<?php

class notify
{
    public $db;
    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }

    public function get_notify()
    {
        $query = mysqli_query($this->db, "select count( * ) AS Number, types,object_id,userid from  notification GROUP BY types ") or die(mysqli_error($this->db));

        $pack = array();
        $i = 0;
        while ($row = mysqli_fetch_array($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $pack[] = $arr;
        }

        return $pack;
    }


    public function add_notify($type, $object_id, $userid)
    {
        $query = mysqli_query($this->db, "INSERT INTO notification(types, object_id, account_id,notify_times) VALUES (" . check_mysql_string($this->db,$type) . "," . check_mysql_string($this->db,$object_id) . "," . check_mysql_string($this->db,$userid) . ",NOW())") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function delete_notify_type($type, $account_id)
    {
        $query = mysqli_query($this->db, "delete from notification where types = " . check_mysql_string($this->db,$type) . " and account_id = " . check_mysql_string($this->db,$account_id) . " ") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_notify_type_object($type, $object_id)
    {
        $query = mysqli_query($this->db, "delete from notification where types = " . check_mysql_string($this->db,$type) . " and object_id = " . check_mysql_string($this->db,$object_id) . " ") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function delete_notify_type_admin($type)
    {
        $query = mysqli_query($this->db, "delete from notification where types = " . check_mysql_string($this->db,$type) . " and account_id = " . check_mysql_string($this->db,$account_id) . " ") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function get_admin_notify($level)
    {
        $query = mysqli_query($this->db, "select * from notification where notification.read = '0' and account_id = '0' order by notify_times desc  ") or die(mysqli_error($this->db));
        $pack = array();

        while ($row = mysqli_fetch_array($query)) {
            empty($arr);
            empty($q);
            empty($r);
            if ($row['types'] == "new_message") {
                $q = mysqli_query($this->db, "select * from messages where m_id = '" . $row['object_id'] . "' ") or die(mysqli_error($this->db));
                $r = mysqli_fetch_array($q);
                $arr['m_from'] = $r['m_from'];
                $arr['m_body'] = substr($r['m_body'], 0, 200);
                $arr['m_user_name'] = $r['m_account_name'];
                $arr['types'] = $row['types'];
            }

            if ($row['types'] == "new_user") {
                $q = mysqli_query($this->db, "select account_id,account_company,account_address,city,pcode,phone from account where account_id = '" . $row['object_id'] . "' ") or die(mysqli_error($this->db));
                $t = mysqli_fetch_array($q);
                //var_dump($t);
                $arr['account_idd'] = $t['account_id'];
                $arr['company'] = $t['account_company'];
                $arr['address'] = $t['account_address'] . ',' . $t['city'] . ',' . $t['pcode'];
                $arr['phone'] = $t['phone'];
                $arr['types'] = $row['types'];
                //var_dump($arr);
            }

            if ($row['types'] == "new_order" || $row['types'] == "update_order" || $row['types'] == "request_cancel_order") {
                $q = mysqli_query($this->db, "select order_id,order_date,account_name,account_company from orders inner join account on (account.account_id = orders.account_id) where order_id = '" . $row['object_id'] . "' ") or die(mysqli_error($this->db));
                $r = mysqli_fetch_array($q);
                $arr['order_id'] = $r['order_id'];
                $arr['order_date'] = $row['notify_times'];
                $arr['account_name'] = $r['account_name'];
                $arr['account_company'] = $r['account_company'];
                $arr['types'] = $row['types'];
                //$arr['phone'] = $r['phone'];
            }


            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $pack[] = $arr;
        }

        //var_dump($pack);

        return $pack;
    }


    public function read_update_notify($type, $id)
    {
        $query = mysqli_query($this->db, "update notification set notification.read = '1' where  ");
    }


    public function get_account_notify($account_id, $level)
    {
        if ($level == "administrator") {
            $query = mysqli_query($this->db, "select * from notification where account_id = " . check_mysql_string($this->db,$account_id) . " and (types = 'update_order' or types = 'new_message' or types = 'new_invoice' or types = 'cancel_order' )  order by notify_times desc ") or die(mysqli_error($this->db));
        }

        if ($level == "client") {
            $query = mysqli_query($this->db, "select * from notification where account_id = " . check_mysql_string($this->db,$account_id) . " and (types = 'update_order' or types = 'new_message' or types = 'cancel_order' ) order by notify_times desc  ") or die(mysqli_error($this->db));
        }


        $pack = array();

        while ($row = mysqli_fetch_array($query)) {
            if ($row['types'] == "new_message") {
                $q = mysqli_query($this->db, "select * from messages where m_id = '" . $row['object_id'] . "' ") or die(mysqli_error($this->db));
                $r = mysqli_fetch_array($q);
                $arr['m_from'] = $r['m_from'];
                $arr['m_body'] = substr($r['m_body'], 0, 200);
                $arr['m_user_name'] = $r['m_user_name'];
            }

            if ($row['types'] == "update_order" || $row['types'] == "cancel_order") {
                $q = mysqli_query($this->db, "select order_id,order_date,account_name,account_company from orders inner join account on (account.account_id = orders.account_id) where order_id = '" . $row['object_id'] . "' ") or die(mysqli_error($this->db));
                $r = mysqli_fetch_array($q);
                $arr['order_id'] = $r['order_id'];
                $arr['order_date'] = $r['order_date'];
                $arr['account_name'] = $r['account_name'];
                $arr['account_company'] = $r['account_company'];
                //$arr['phone'] = $r['phone'];
            }

            if ($row['types'] == "new_invoice") {
                $q = mysqli_query($this->db, "select id,date,duedate from invoicehdr where id = '" . $row['object_id'] . "' ") or die(mysqli_error($this->db));
                $r = mysqli_fetch_array($q);
                $arr['invoiceno'] = $r['id'];
                $arr['date'] = $r['date'];
                $arr['duedate'] = $r['duedate'];
                //	$arr['account_company'] = $r['account_company'];
                //$arr['phone'] = $r['phone'];
            }


            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $pack[] = $arr;
        }

        return $pack;
    }


    public function get_order_notify($account_id)
    {
        $query = mysqli_query($this->db, "select status.id as id ,count(*) as num from notification inner join orders on (orders.order_id = notification.object_id) inner join status on (orders.order_status = status.id)  where notification.account_id = " . check_mysql_string($this->db,$account_id) . " and types = 'updated_order'  group by status.id") or die(mysqli_error($this->db));
        $pack = array();

        while ($row = mysqli_fetch_array($query)) {
            $pack[$row['id']] = $row['num'];
        }

        return $pack;
    }


    public function get_order_notify_ids($account_id)
    {
        $query = mysqli_query($this->db, "select object_id as num from notification   where notification.account_id = " . check_mysql_string($this->db,$account_id) . " and types = 'updated_order' ") or die(mysqli_error($this->db));
        $pack = array();

        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $pack[] = $row["num"];
            }
        }
        return $pack;
    }


    public function remove_order_notify($object_id, $type)
    {
        $query = mysqli_query($this->db, "delete from notification where types=" . check_mysql_string($this->db,$type) . " and object_id=" . check_mysql_string($this->db,$object_id) . "") or die(mysqli_error($this->db));
    }
}
