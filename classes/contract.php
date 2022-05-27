<?php

class contract
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }

    public function get_contract()
    {
        $sql = "select contracts.id,contracts.active,contracts.contractno,contracts.title,account.account_company,account.account_id,contracts.acctno from contracts,account
                where
               account_company != '***Deleted***'  and  account.account_id=contracts.clid and account.status != 3
                order by contracts.acctno";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        return build_array($query);
    }

    public function get_contract_id($id)
    {
        $query = mysqli_query($this->db, "select * from contracts where id = '" . $id . "' ") or die(mysqli_error($this->db));

        return mysqli_fetch_array($query);
    }

    public function get_contract_contractno($id)
    {
        $query = mysqli_query($this->db, "select * from contracts where contractno = '" . $id . "' ") or die(mysqli_error($this->db));

        return mysqli_fetch_array($query);
    }

    public function get_contract_deliveriers()
    {
        $sql = "select * from contractdeliveries";

        $query = mysqli_query($this->db, $sql);

        $result = array();
        while ($row = mysqli_fetch_array($query)) {
            $result[$row['contractno']][] = $row;
        }

        return $result;
    }

    public function get_delievry($id)
    {
        $query = mysqli_query($this->db, "select * from contractdeliveries where id = '" . $id . "' ") or die(mysqli_error($this->db));

        return mysqli_fetch_array($query);
    }
}
