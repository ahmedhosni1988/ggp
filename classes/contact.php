<?php

class contacts
{

    var $db;

    function contacts($db)
    {
        $this->db = $db;
    }


    function get_contact($contact_name, $contact_type, $contact_objectid)
    {

        $query = mysql_query("select * from contacts where contact_type = " . $this->db->qstr($contact_type) . "  or  contact_name = " . $this->db->qstr($contact_name) . " or contact_objectid = " . $this->db->qstr($contact_objectid) . "  and account_id = " . $this->db->qstr($contact_objectid) . " ") or die (mysql_error());

        $contacts = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $contacts[] = $arr;

        }

        return $contacts;
    }


    function get_account_contact($contact_objectid)
    {

        $query = mysql_query("select * from contacts where contact_type = 'account' and account_id = " . $this->db->qstr($contact_objectid) . " ") or die (mysql_error());

        $i = 0;
        $contacts = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $contacts[] = $arr;

        }


        return $contacts;
    }


    function get_account_contactemails($contact_objectid)
    {

        $query = mysql_query("select email from contacts where email_notify = '1' and contact_type = 'account' and account_id = " . $this->db->qstr($contact_objectid) . " ") or die (mysql_error());

        $i = 0;
        $contacts = "";
        while ($row = mysql_fetch_array($query)) {
            $contacts .= $row['email'] . ",";
        }


        $contacts = substr($contacts, 0, strlen($contacts) - 1);
        return $contacts;
    }

    function edit_contact()
    {

    }


    function get_contact_address($account_id, $start, $perpage)
    {

        $query = mysql_query("select * from contacts where account_id = " . $this->db->qstr($account_id) . "  limit $start,$perpage ") or die (mysql_error());

        $i = 0;
        $contacts = array();
        while ($row = mysql_fetch_array($query)) {
            $contacts[$i] = array('contact_id' => $row['contact_id'], 'contact_type' => $row['contact_type'], 'contact_objectid' => $row['contact_objectid'], 'phone' => $row['phone'], 'email' => $row['email'], 'fax' => $row['fax'], 'address' => $row['address'], 'pcode' => $row['pcode'], 'contact_name' => $row['contact_name']);
            $i++;
        }

        return $contacts;
    }


}


?>