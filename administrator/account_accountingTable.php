<?php 
session_start();
include ("../setting.php"); 


$table ="invoicehdr";
$where = " 1 = 1";

if($_SESSION["where"]){
    $where = $_SESSION["where"];
}


$primaryKey = 'id';
 
$columns = array(
    array( 'db'  => 'id'         , 'dt' => '0' ),
    array( 'db'  => 'date'        , 'dt' => '1' ),
    array( 'db'  => 'subtotal'         , 'dt' => '2' )
);
 
$sql_details = array(
    'user' => DBUSER,
    'pass' => DBPASS,
    'db'   => DBNAME,
    'host' => HOSTNAME
);
 
 

require( 'ssp.php' );
 
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns ,$where) 
);