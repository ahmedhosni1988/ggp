<?php

class address
{
    var $db;


    function address($db)
    {
        $this->db = $db;
    }

    function add_address($name, $addr, $postalcode, $attn, $phone, $client)
    {
        $query = mysql_query("insert into addrbook (name,client,addr,postalcode,attn,phone) values(" . $this->db->qstr($name) . "," . $this->db->qstr($client) . "," . $this->db->qstr($addr) . "," . $this->db->qstr($postalcode) . "," . $this->db->qstr($attn) . "," . $this->db->qstr($phone) . ");") or die (mysql_error());

        if ($query) return true;
        else return false;

    }


    function edit_full_address($post, $id)
    {

        $sql = $this->db->make_update("addrbook", $post, "id", $id);

        $query = mysql_query($sql) or die (mysql_error());

        if ($query) return true;
        else return false;
    }

    function add_full_address($post)
    {

        $sql = $this->db->make_insert("addrbook", $post);

        $query = mysql_query($sql) or die (mysql_error());

        if ($query) return mysql_insert_id();
        else return false;
    }


    function full_search_address($post)
    {

        $sql = "select * from addrbook where ";
        if ($post['name'] != "") $sql .= " name like '%" . $post['name'] . "%' and ";
        if ($post['client'] != "") $sql .= " client = " . $this->db->qstr($post['client']) . " and ";
        if ($post['addr'] != "") $sql .= " addr like  '%" . $post['addr'] . "% and ";
        if ($post['attn'] != "") $sql .= " attn = " . $this->db->qstr($post['attn']) . " and ";
        if ($post['phone'] != "") $sql .= " phone = " . $this->db->qstr($post['phone']) . " and ";
        if ($post['route'] != "") $sql .= " route = " . $this->db->qstr($post['route']) . " and ";
        if ($post['fax'] != "") $sql .= " fax = " . $this->db->qstr($post['fax']) . " and ";
        if ($post['email'] != "") $sql .= " email = " . $this->db->qstr($post['email']) . " and ";

        $sql = substr($sql, 0, strlen($sql) - 4);
        $sql .= " Limit 0,30";
        $query = mysql_query($sql) or die (mysql_error());


        $i = 0;
        $addr = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $addr[$i] = $arr;
            $i++;
        }

        return $addr;


    }

//Start koko
    function get_alladdress($account_id, $searchField, $searchString, $searchOper, $sidx, $sord, $start, $limit)
    {
        if ($account_id == '') {

            $sql = "select account.account_name ,account.account_id, addrbook . * from addrbook left JOIN account ON ( addrbook.client = account.account_id )";

        } else {

            $sql = "select account.account_name ,account.account_id, addrbook . * from addrbook INNER JOIN account ON ( addrbook.client = account.account_id ) where addrbook.client = " . $this->db->qstr($account_id) . " ";
        }

        switch ($searchOper) {
            case 'eq':

                if ($account_id == '') {
                    $sql .= " where " . $searchField . " = '" . $searchString . "' ";
                } else {
                    $sql .= " and " . $searchField . " = '" . $searchString . "' ";
                }

                break;
            case 'cn':

                if ($account_id == '') {
                    $sql .= " where " . $searchField . " Like '%" . $searchString . "%' ";
                } else {
                    $sql .= " and " . $searchField . " Like '%" . $searchString . "%' ";
                }

                break;

        }

        $sql .= "order by " . $sidx . " " . $sord . " limit " . $start . "," . $limit . "";

        $query = mysql_query($sql) or die (mysql_error());

        if (mysql_num_rows($query) > 0) {
            $addr = array();
            while ($row = mysql_fetch_assoc($query)) {

                foreach ($row as $key => $value) {

                    $arr[$key] = $value;
                }

                $addr[] = $arr;
            }

            return $addr;
        } else {
            return false;
        }

    }

    function admin_count_address()
    {
        $query = mysql_query("select count(*) c from addrbook  ") or die (mysql_error());
        $row = mysql_fetch_array($query);
        return $row['c'];
    }

    function get_account_details($account_id)
    {
        $query = mysql_query("select account.*, addrbook.id as id, addrbook.name FROM addrbook INNER JOIN account ON ( addrbook.client = account.account_id ) where addrbook.client = $account_id order by id ASC limit 0,1 ") or die(mysql_error());
        if (mysql_num_rows($query) == 1) {
            $row = mysql_fetch_array($query);
            return $row;
        } else {
            return false;
        }
    }

    function get_account_id($account_name)
    {
        $query = mysql_query("select distinct * from account where account_name = '" . $account_name . "'") or die (mysql_error());
        if (mysql_num_rows($query) == 1) {
            $row = mysql_fetch_array($query);
            return $row;
        } else {
            return false;
        }
    }

//End koko


    function delete_address($id)
    {
        $query = mysql_query("delete from addrbook where id =  " . $this->db->qstr($id) . "  ") or die (mysql_error());

        if ($query) return true;
        else return false;

    }

    function count_address($client, $userid)
    {
        $query = mysql_query("select count(*) c from addrbook where client = " . $this->db->qstr($client) . " ") or die (mysql_error());
        $row = mysql_fetch_array($query);
        return $row['c'];
    }

    function search_address($txt, $account)
    {
        $sql = "";

        $sql = "select * from addrbook where name Like '%" . mysql_real_escape_string($txt) . "%' and client= " . $this->db->qstr($account) . " LIMIT 0 , 10 ";


        $query = mysql_query($sql) or die ($sql);
        $i = 0;
        $addr = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $addr[$i] = $arr;
            $i++;
        }

        return $addr;

    }

    function get_client_address($client, $sort, $sort_type, $start, $perpage, $userid)
    {

        $sql = "select * from addrbook where client = " . $this->db->qstr($client) . "  order by " . $sort . " " . $sort_type . " limit " . $start . "," . $perpage . "";

        $query = mysql_query($sql) or die ($sql);

        $addr = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $addr[] = $arr;
        }

        return $addr;
    }

    function get_addr_search($search, $sort, $sort_type, $start, $perpage, $userid, $account_id)
    {

        if ($account_id != '') $x = " and client = '" . $account_id . "'";
        else $x = "";
        $sql = "select * from addrbook where name like '%" . mysql_real_escape_string($search) . "%'   " . $x . " order by " . $sort . " " . $sort_type . " limit " . $start . "," . $perpage . "";


        $query = mysql_query($sql) or die ($sql);

        $addr = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $addr[] = $arr;
        }

        return $addr;
    }

    function get_address($id)
    {

        $sql = "select * from addrbook where id = " . $this->db->qstr($id) . "";

        $query = mysql_query($sql) or die ($sql);

        $row = mysql_fetch_object($query);


        return $row;
    }


}

?>