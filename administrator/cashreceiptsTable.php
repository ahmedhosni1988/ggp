<?php 
session_start(); 
include ("../setting.php");


$table ="cashreceiptslist";
$where = " 1 = 1 ";

if($_SESSION["billing_code"]==2){
    $where .= " and billing_code = 2  ";
}

if($_SESSION["account_accounting_id"]){
    $where .= " and clid =".$_SESSION["account_accounting_id"].' ';
} 


$primaryKey = 'id';
 
$columns = array(
    array( 'db' => 'account_company'      , 'dt' => '0'),
    array( 'db' => 'pymt_amount'          , 'dt' => '1' ),
    array( 'db' => 'payment_name'         , 'dt' => '2' ),
    array( 'db' => 'user_name'            , 'dt' => '3' ),
    array( 'db' => 'date'                 , 'dt' => '4' ),
    array( 'db' => 'invoiceno'            , 'dt' => '5' ),
    array( 'db' => 'id'                   , 'dt' => 'id' ),
    array( 'db' => 'clid'                 , 'dt' => 'clid' ), 
    array( 'db' => 'date'                 , 'dt' => 'date' ),
    array( 'db' => 'paymethod'            , 'dt' => 'paymethod' ), 
    array( 'db' => 'pymt_amount'          , 'dt' => 'pymt_amount' ),
    array( 'db' => 'invoiceno'            , 'dt' => 'invoiceno' ), 
);
 
$sql_details = array(
    'user' => DBUSER,
    'pass' => DBPASS,
    'db'   => DBNAME,
    'host' => HOSTNAME
);
 
 

require( 'ssp.php' ); 
 
$data = SSP::complex( $_POST, $sql_details, $table, $primaryKey, $columns ,$where) ;
echo json_encode($data);