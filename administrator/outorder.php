<?php
session_start();
include("../setting.php");
include("../" . STYLE . "/searchtemp.php");
include("../" . STYLE . "/consoletemp.php");
include("../" . STYLE . "/worktemp.php");
include("../classes/work.php");

$newtemp = new template();
$workClass = new work($db);

if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}


switch ($action) {


    case 'show_outorder':
        $res = $workClass->get_out_orders('0', '1', $_SESSION['billing_code']);
        if ($_SESSION['user_type'] == '5') {
            $newtemp->load_template('out_order_view', 13);
        } else {
            $newtemp->load_template('out_order_view', 4);
        }
        break;


    case 'finish_out_order_all':
        if (isset($_POST['out_id'])) {
            $q = mysqli_query($mycon,"update out_orders set status= '2' , finished = '1'   where id='" . $_POST['out_id'] . "' ") or die(mysqli_error($mycon));


            echo "تم الانتهاء من امر التسليم";
        }

        break;

    default:

        break;
}
