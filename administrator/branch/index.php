<?php
session_start();
include("../../setting.php");
include("branchtemp.php");
include("../../classes/work.php");
include("../../classes/account.php");


$workClass = new work($db);
$accClass = new account($db);



if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}



switch ($action) {

    case 'receiver_items':

        $newtempAll->load_template('receiver_items',4);

    break;

    case 'deliver_items':

        $allacc = $accClass->get_all_accounts(1,$_SESSION['billing_code']);


        $newtempAll->load_template('deliver_items',4);


    break;

    case 'search':
        if (isset($_POST['barcode'])) {

            $data['barcode'] = $_POST['barcode'];

            $res = $workClass->Search_with_Barcode_branch($data);

            if ($res == "0") {

                $arr['error'] = "Not Found";
                echo "0";

            } else {

                echo json_encode($res);
            }

        } else {
            echo "0";
        }
        break;


default:
//echo "ahmed";


break;


}
