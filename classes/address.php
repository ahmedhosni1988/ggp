<?php

class address
{
    public $db;


    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }

    public function add_address($name, $addr, $postalcode, $attn, $phone, $client)
    {
        $query = mysqli_query($this->db, "insert into addrbook (name,client,addr,postalcode,attn,phone) values(" . check_mysql_string($this->db,$name) . "," . check_mysql_string($this->db,$client) . "," . check_mysql_string($this->db,$addr) . "," . check_mysql_string($this->db,$postalcode) . "," . check_mysql_string($this->db,$attn) . "," . check_mysql_string($this->db,$phone) . ");") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function edit_full_address($post, $id)
    {
        $sql = make_update("addrbook", $post, "id", $id);

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function add_full_address($post)
    {
        $sql = make_insert("addrbook", $post);

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }


    public function full_search_address($post)
    {
        $sql = "select * from addrbook where ";
        if ($post['name'] != "") {
            $sql .= " name like '%" . $post['name'] . "%' and ";
        }
        if ($post['client'] != "") {
            $sql .= " client = " . check_mysql_string($this->db,$post['client']) . " and ";
        }
        if ($post['addr'] != "") {
            $sql .= " addr like  '%" . $post['addr'] . "% and ";
        }
        if ($post['attn'] != "") {
            $sql .= " attn = " . check_mysql_string($this->db,$post['attn']) . " and ";
        }
        if ($post['phone'] != "") {
            $sql .= " phone = " . check_mysql_string($this->db,$post['phone']) . " and ";
        }
        if ($post['route'] != "") {
            $sql .= " route = " . check_mysql_string($this->db,$post['route']) . " and ";
        }
        if ($post['fax'] != "") {
            $sql .= " fax = " . check_mysql_string($this->db,$post['fax']) . " and ";
        }
        if ($post['email'] != "") {
            $sql .= " email = " . check_mysql_string($this->db,$post['email']) . " and ";
        }

        $sql = substr($sql, 0, strlen($sql) - 4);
        $sql .= " Limit 0,30";
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        $i = 0;
        $addr = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $addr[$i] = $arr;
            $i++;
        }

        return $addr;
    }

    //Start koko
    public function get_alladdress($account_id, $searchField, $searchString, $searchOper, $sidx, $sord, $start, $limit)
    {
        if ($account_id == '') {
            $sql = "select account.account_name ,account.account_id, addrbook . * from addrbook left JOIN account ON ( addrbook.client = account.account_id )";
        } else {
            $sql = "select account.account_name ,account.account_id, addrbook . * from addrbook INNER JOIN account ON ( addrbook.client = account.account_id ) where addrbook.client = " . check_mysql_string($this->db,$account_id) . " ";
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

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) > 0) {
            $addr = array();
            while ($row = mysqli_fetch_assoc($query)) {
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

    public function admin_count_address()
    {
        $query = mysqli_query($this->db, "select count(*) c from addrbook  ") or die(mysqli_error($this->db));
        $row = mysqli_fetch_array($query);
        return $row['c'];
    }

    public function get_account_details($account_id)
    {
        $query = mysqli_query($this->db, "select account.*, addrbook.id as id, addrbook.name FROM addrbook INNER JOIN account ON ( addrbook.client = account.account_id ) where addrbook.client = $account_id order by id ASC limit 0,1 ") or die(mysqli_error($this->db));
        if (mysqli_num_rows($query) == 1) {
            $row = mysqli_fetch_array($query);
            return $row;
        } else {
            return false;
        }
    }

    public function get_account_id($account_name)
    {
        $query = mysqli_query($this->db, "select distinct * from account where account_name = '" . $account_name . "'") or die(mysqli_error($this->db));
        if (mysqli_num_rows($query) == 1) {
            $row = mysqli_fetch_array($query);
            return $row;
        } else {
            return false;
        }
    }

    //End koko


    public function delete_address($id)
    {
        $query = mysqli_query($this->db, "delete from addrbook where id =  " . check_mysql_string($this->db,$id) . "  ") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function count_address($client, $userid)
    {
        $query = mysqli_query($this->db, "select count(*) c from addrbook where client = " . check_mysql_string($this->db,$client) . " ") or die(mysqli_error($this->db));
        $row = mysqli_fetch_array($query);
        return $row['c'];
    }

    public function search_address($txt, $account)
    {
        $sql = "";

        $sql = "select * from addrbook where name Like '%" . mysqli_real_escape_string($this->db, $txt) . "%' and client= " . check_mysql_string($this->db,$account) . " LIMIT 0 , 10 ";


        $query = mysqli_query($this->db, $sql) or die($sql);
        $i = 0;
        $addr = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $addr[$i] = $arr;
            $i++;
        }

        return $addr;
    }

    public function get_client_address($client, $sort, $sort_type, $start, $perpage, $userid)
    {
        $sql = "select * from addrbook where client = " . check_mysql_string($this->db,$client) . "  order by " . $sort . " " . $sort_type . " limit " . $start . "," . $perpage . "";

        $query = mysqli_query($this->db, $sql) or die($sql);

        $addr = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $addr[] = $arr;
        }

        return $addr;
    }

    public function get_addr_search($search, $sort, $sort_type, $start, $perpage, $userid, $account_id)
    {
        if ($account_id != '') {
            $x = " and client = '" . $account_id . "'";
        } else {
            $x = "";
        }
        $sql = "select * from addrbook where name like '%" . mysqli_real_escape_string($this->db, $search) . "%'   " . $x . " order by " . $sort . " " . $sort_type . " limit " . $start . "," . $perpage . "";


        $query = mysqli_query($this->db, $sql) or die($sql);

        $addr = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $addr[] = $arr;
        }

        return $addr;
    }

    public function get_address($id)
    {
        $sql = "select * from addrbook where id = " . check_mysql_string($this->db,$id) . "";

        $query = mysqli_query($this->db, $sql) or die($sql);

        $row = mysqli_fetch_object($query);


        return $row;
    }
}
