<?php
session_start();
include("../setting.php");
include("../classes/account.php");
include("../classes/address.php");

include("../" . STYLE . "/managetemp.php");


$newtemp = new template();
$account = new account($db);
$address = new address($db);


if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}


if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == 1 && $_SESSION['status'] == 2 && $_SESSION['user_type'] == "administrator") {

    switch ($action) {

        case 'client_start_message':
            if (isset($_POST['add'])) {

            } else {
                $page_title = $lang[676];
                $newtemp->load_template('client_message', 4);
            }
            break;


        default:
            $page_title = $lang[1];
            $newtemp->load_template('admin_index', 4);
            break;

    }

} else {
    $page_title = $lang[102];
    $newtemp->load_template('login_admin', 5);
}


