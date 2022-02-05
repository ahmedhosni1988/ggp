<?php
 include ("../setting.php");

$table = 'logs';
 
// Table's primary key
$primaryKey = 'ID';
 

$columns = array(
    array( 'db' => 'ID'         , 'dt' => '0' ),
    array( 'db' => 'OBJECT_ID'  , 'dt' => '1' ),
    array( 'db' => 'OBJECT_NAME', 'dt' => '2' ),
    array( 'db' => 'USER_NAME'  , 'dt' => '3' ),
    array('db'  => 'DATE'       , 'dt' => '4' ),
    array('db'  => 'OPERATION_NAME'  , 'dt' => '5' ),
    array( 'db' => 'ID'         , 'dt' => 'ID' ),
    array( 'db' => 'OBJECT_ID'  , 'dt' => 'OBJECT_ID' ),
    array( 'db' => 'OBJECT_NAME', 'dt' => 'OBJECT_NAME' ),
    array( 'db' => 'USER_NAME'  , 'dt' => 'USER_NAME' ), 
    array('db'  => 'DATE'       , 'dt' => 'DATE' ),
    array('db'  => 'OPERATION_NAME'  , 'dt' => 'OPERATION_NAME' ),
    array('db'  => 'BEFORE_CHANGE', 'dt'    => 'BEFORE_CHANGE'  ),
    array('db'  => 'AFTER_CHANGE' , 'dt'   => 'AFTER_CHANGE'  )
);
 
// SQL server connection information
$sql_details = array(
    'user' => DBUSER,
    'pass' => DBPASS,
    'db'   => DBNAME,
    'host' => HOSTNAME
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);