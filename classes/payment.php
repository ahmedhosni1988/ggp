<?php

class payment
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }


    public function get_payment()
    {
        $query = mysqli_query($this->db, "select * from  payment_type  order by payment_order ASC ") or die(mysqli_error($this->db));

        $payment = array();
        $i = 0;
        while ($row = mysqli_fetch_array($query)) {
            $payment[$i] = array('payment_id' => $row['payment_id'], 'payment_name' => $row['payment_name'], 'payment_order' => $row['payment_order']);
            $i++;
        }

        return $payment;
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


    public function get_payment_method($id)
    {
        $query = mysqli_query($this->db, "select * from  payment_type where payment_id = " . check_mysql_string($this->db,$id) . " ") or die(mysqli_error($this->db));

        $payment = mysqli_fetch_object($query);

        return $payment;
    }


    //////payment term section//////////////

    public function get_payment_term()
    {
        $query = mysqli_query($this->db, "select * from  payment_terms ") or die(mysqli_error($this->db));

        $payment = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $payment[] = $arr;
        }

        return $payment;
    }


    public function update_payment_term($pt_id, $pt_name, $pt_des, $pt_due)
    {
        $sql = "update payment_terms set pt_name = " . check_mysql_string($this->db,$pt_name) . ",	pt_des  = " . check_mysql_string($this->db,$pt_des) . " ,pt_due = " . check_mysql_string($this->db,$pt_due) . "  where pt_id = " . check_mysql_string($this->db,$pt_id) . "";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function add_payment_term($pt_name, $pt_des, $pt_due)
    {
        $sql = "insert into payment_terms (pt_name,pt_des,pt_due) values(" . check_mysql_string($this->db,$pt_name) . "," . check_mysql_string($this->db,$pt_des) . "," . check_mysql_string($this->db,$pt_due) . ") ";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function get_payment_term_list()
    {
        $query = mysqli_query($this->db, "select * from  payment_terms ") or die(mysqli_error($this->db));

        $payment = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $payment[$row['pt_id']] = $arr;
        }

        return $payment;
    }
}
