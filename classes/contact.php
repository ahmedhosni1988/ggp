<?php

class contacts
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }


    public function get_contact($contact_name, $contact_type, $contact_objectid)
    {
        $query = mysqli_query($this->db, "select * from contacts where contact_type = " . check_mysql_string($this->db,$contact_type) . "  or  contact_name = " . check_mysql_string($this->db,$contact_name) . " or contact_objectid = " . check_mysql_string($this->db,$contact_objectid) . "  and account_id = " . check_mysql_string($this->db,$contact_objectid) . " ") or die(mysqli_error($this->db));

        $contacts = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $contacts[] = $arr;
        }

        return $contacts;
    }


    public function get_account_contact($contact_objectid)
    {
        $query = mysqli_query($this->db, "select * from contacts where contact_type = 'account' and account_id = " . check_mysql_string($this->db,$contact_objectid) . " ") or die(mysqli_error($this->db));

        $i = 0;
        $contacts = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $contacts[] = $arr;
        }


        return $contacts;
    }


    public function get_account_contactemails($contact_objectid)
    {
        $query = mysqli_query($this->db, "select email from contacts where email_notify = '1' and contact_type = 'account' and account_id = " . check_mysql_string($this->db,$contact_objectid) . " ") or die(mysqli_error($this->db));

        $i = 0;
        $contacts = "";
        while ($row = mysqli_fetch_array($query)) {
            $contacts .= $row['email'] . ",";
        }


        $contacts = substr($contacts, 0, strlen($contacts) - 1);
        return $contacts;
    }

    public function edit_contact()
    {
    }


    public function get_contact_address($account_id, $start, $perpage)
    {
        $query = mysqli_query($this->db, "select * from contacts where account_id = " . check_mysql_string($this->db,$account_id) . "  limit $start,$perpage ") or die(mysqli_error($this->db));

        $i = 0;
        $contacts = array();
        while ($row = mysqli_fetch_array($query)) {
            $contacts[$i] = array('contact_id' => $row['contact_id'], 'contact_type' => $row['contact_type'], 'contact_objectid' => $row['contact_objectid'], 'phone' => $row['phone'], 'email' => $row['email'], 'fax' => $row['fax'], 'address' => $row['address'], 'pcode' => $row['pcode'], 'contact_name' => $row['contact_name']);
            $i++;
        }

        return $contacts;
    }
}
