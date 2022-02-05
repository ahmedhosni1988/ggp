<?php
session_start();
include("setting.php");
include("classes/orders.php");


$newtemp = new template();


if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}


switch ($action) {

    default :

        if (!empty($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
            $order = new orders($db);

            $order_details = $order->get_order_waybill($order_id);
            $order_package_details = $order->get_order_package_details($order_id);
            $order_waybill = TRUE;
            $newtemp->load_template('waybill', 6);


        }


        break;
}


?>