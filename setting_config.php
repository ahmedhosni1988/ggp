<?php

$billing_codes = $db->get_table("billing_code");


if (isset($_SESSION['billing_code']) &&  $_SESSION['billing_code'] > '0') {
    $inputbillingsql = ' and orders.billing_code = \''.$_SESSION['billing_code'].'\' ';
}


$newtempAll = new template();



$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
//$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = $protocol.$_SERVER['HTTP_HOST'].(strpos($_SERVER['REQUEST_URI'], '.php') ? $_SERVER['REQUEST_URI'] : $_SERVER['REQUEST_URI'].'index.php?');



//echo $_SESSION['user_type'];


if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
if (!empty($_GET["start"])) {
    $start = $_GET["start"];
} else {
    $start = 0;
}
