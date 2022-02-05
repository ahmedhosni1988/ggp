<?php

class payment
{

    var $db;

    function payment($db)
    {
        $this->db = $db;
    }


    function get_payment()
    {

        $query = mysql_query("select * from  payment_type  order by payment_order ASC ") or die (mysql_error());

        $payment = array();
        $i = 0;
        while ($row = mysql_fetch_array($query)) {
            $payment[$i] = array('payment_id' => $row['payment_id'], 'payment_name' => $row['payment_name'], 'payment_order' => $row['payment_order']);
            $i++;
        }

        return $payment;
    }


    function update_payment($payment_id, $payment_name, $payment_order)
    {

        $sql = "update payment_type set payment_name = " . $this->db->qstr($payment_name) . ",	payment_order  = " . $this->db->qstr($payment_order) . "  where payment_id = " . $this->db->qstr($payment_id) . "";

        $query = mysql_query($sql) or die(mysql_error());

        if ($query) return true;
        else return false;

    }

    function add_payment($payment_name, $payment_order)
    {

        $sql = "insert into payment_type (payment_name,payment_order) values(" . $this->db->qstr($payment_name) . "," . $this->db->qstr($payment_order) . ") ";

        $query = mysql_query($sql) or die(mysql_error());

        if ($query) return true;
        else return false;

    }


    function get_payment_method($id)
    {

        $query = mysql_query("select * from  payment_type where payment_id = " . $this->db->qstr($id) . " ") or die (mysql_error());

        $payment = mysql_fetch_object($query);

        return $payment;
    }


//////payment term section//////////////

    function get_payment_term()
    {

        $query = mysql_query("select * from  payment_terms ") or die (mysql_error());

        $payment = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $payment[] = $arr;
        }

        return $payment;
    }


    function update_payment_term($pt_id, $pt_name, $pt_des, $pt_due)
    {

        $sql = "update payment_terms set pt_name = " . $this->db->qstr($pt_name) . ",	pt_des  = " . $this->db->qstr($pt_des) . " ,pt_due = " . $this->db->qstr($pt_due) . "  where pt_id = " . $this->db->qstr($pt_id) . "";

        $query = mysql_query($sql) or die(mysql_error());

        if ($query) return true;
        else return false;

    }

    function add_payment_term($pt_name, $pt_des, $pt_due)
    {

        $sql = "insert into payment_terms (pt_name,pt_des,pt_due) values(" . $this->db->qstr($pt_name) . "," . $this->db->qstr($pt_des) . "," . $this->db->qstr($pt_due) . ") ";

        $query = mysql_query($sql) or die(mysql_error());

        if ($query) return true;
        else return false;

    }


    function get_payment_term_list()
    {

        $query = mysql_query("select * from  payment_terms ") or die (mysql_error());

        $payment = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $payment[$row['pt_id']] = $arr;
        }

        return $payment;
    }


}


?>