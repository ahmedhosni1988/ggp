<?php

class contract
{

    var $db;

    function contract($db)
    {
        $this->db = $db;
    }

    function get_contract()
    {
        $sql = "select contracts.id,contracts.active,contracts.contractno,contracts.title,account.account_company,account.account_id,contracts.acctno from contracts,account
                where
               account_company != '***Deleted***'  and  account.account_id=contracts.clid and account.status != 3
                order by contracts.acctno";

        $query = mysql_query($sql) or die (mysql_error());

        return $this->db->build_array($query);
    }

    function get_contract_id($id)
    {
        $query = mysql_query("select * from contracts where id = '" . $id . "' ") or die (mysql_error());

        return mysql_fetch_array($query);
    }

    function get_contract_contractno($id)
    {
        $query = mysql_query("select * from contracts where contractno = '" . $id . "' ") or die (mysql_error());

        return mysql_fetch_array($query);
    }

    function get_contract_deliveriers()
    {
        $sql = "select * from contractdeliveries";

        $query = mysql_query($sql);

        $result = array();
        while ($row = mysql_fetch_array($query)) {
            $result[$row['contractno']][] = $row;
        }

        return $result;
    }

    function get_delievry($id)
    {
        $query = mysql_query("select * from contractdeliveries where id = '" . $id . "' ") or die (mysql_error());

        return mysql_fetch_array($query);

    }

}

?>
