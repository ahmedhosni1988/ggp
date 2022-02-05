<?php
require 'Structures/DataGrid/DataSource.php';
require_once 'DB.php';

class MyDataSource extends Structures_DataGrid_DataSource
{

    var $db;
    var $orderBy = '';
    var $query;
    var $table_name;
    var $server;
    var $dbuser;
    var $dbpass;
    var $dbname;

    function MyDataSource($server, $dbuser, $dbpass, $dbname, $table_name, $query)
    {
        $this->server = $server;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
        $this->dbname = $dbname;
        $this->table_name = $table_name;
        $this->query = $query;

        $dsn = 'mysql://' . $this->dbuser . ':' . $this->dbpass . '@' . $this->server . '/' . $this->dbname . '';

        $this->db =& DB::connect($dsn);


        parent::Structures_DataGrid_DataSource();
    }

    function count()
    {
        $query = "SELECT COUNT(*) FROM " . $this->table_name;
        return $this->db->getOne($query);
    }

    function sort($sortSpec, $sortDir = 'ASC')
    {
        $this->orderBy = "ORDER BY $sortSpec $sortDir";
    }

    function fetch($offset = 0, $len = null)
    {

        $limit = is_null($len) ? "LIMIT $offset,18446744073709551615"
            : "LIMIT $offset,$len";

        $query = $this->query;
        $query .= $this->orderBy . " $limit";
        //echo $query;
        return $this->db->getAll($query, array(), DB_FETCHMODE_ASSOC);
    }


}

?>