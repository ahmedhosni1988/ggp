<?php
session_start();
include("../setting.php");
include("../" . STYLE . "/pricetemp.php");

include("../classes/account.php");
include("../classes/console.php");
include("../classes/price.php");
include("../classes/services.php");
include("../classes/package.php");
include("../classes/company.php");

$account = new account($db);
$newtemp = new template();
$price = new price($db);
$services = new services($db);
$package = new package($db);
$company = new company($db);

if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}
$sett_compnay = $company->get_company_details();


if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == 1 && $_SESSION['status'] == 2 && $_SESSION['user_type'] == "accounting") {

    $open = "setup";

    switch ($action) {


        case 'options_manage':
            $newtemp->load_template('price_option_mange', 5);
            break;

        case 'price_checkbox':
            $what = "";
            if (isset($_GET['what'])) $what = $_GET['what'];

            if (isset($_POST['add_check'])) {

                $add = $price->add_addservice($_POST['pack_id'], $_POST['ch_name'], $_POST['ch_shortname'], $_POST['ch_fee'], $_POST['length'], $_POST['width']);
                if ($add) {
                    echo $lang[313];
                } else {
                    echo $lang[314];
                }

            } elseif (isset($_POST['edit_check'])) {
                $edit = $price->edit_addservice($_POST['pack_id'], $_POST['ch_name'], $_POST['ch_shortname'], $_POST['ch_fee'], $_POST['edit_check_id'], $_POST['length'], $_POST['width']);
                if ($edit) {
                    echo $lang[313];
                } else {
                    echo $lang[314];
                }
            } elseif ($what == "add") {
                $pack = $package->get_package();
                $newtemp->load_template('price_checkbox_add', 5);

            } elseif ($what == "edit") {

                if (isset($_GET['id'])) {
                    $edit = $price->get_addservice($_GET['id']);
                    $pack = $package->get_package();
                    $newtemp->load_template('price_checkbox_edit', 5);
                }


            } elseif ($what == "mange") {
                $newtemp->load_template('price_checkbox_mange', 5);
            } elseif ($what == "setting") {
                
                $check = $price->get_add_check_price();
                $pack = $package->get_package_id();

                $newtemp->load_template('price_checkbox', 5);
            } elseif ($what == "delete") {
                $del = $price->delete_addservices($_GET['id']);
                if ($del) {
                    echo $lang[319];
                } else {
                    echo $lang[320];
                }
            }
            break;

        case 'price_addtional':
            $what = "";
            if (isset($_GET['what'])) $what = $_GET['what'];

            if (isset($_POST['add_add'])) {

                $add = $services->add_add_vec_service($_POST['ch_name']);
                if ($add) {
                    echo $lang[313];
                } else {
                    echo $lang[314];
                }

            } elseif (isset($_POST['edit_add'])) {
                $edit = $services->edit_add_vec_service($_POST['ch_name'], $_POST['edit_add_id']);
                if ($edit) {
                    echo $lang[313];
                } else {
                    echo $lang[314];
                }
            } elseif ($what == "add") {
                $newtemp->load_template('price_additional_add', 5);
            } elseif ($what == "edit") {

                if (isset($_GET['id'])) {
                    $edit = $services->get_add_vec_service($_GET['id']);
                    $newtemp->load_template('price_additional_edit', 5);
                }


            } elseif ($what == "mange") {
                $newtemp->load_template('price_additional_mange', 5);
            } elseif ($what == "setting") {
                $add_ser = $services->get_addtional_services();
                $newtemp->load_template('price_additional', 5);
            } elseif ($what == "delete") {
                $del = $services->delete_add_vec_services($_GET['id']);
                if ($del) {
                    echo $lang[319];
                } else {
                    echo $lang[320];
                }
            }
            break;

        case 'price_pac':
            $what = "";
            if (isset($_GET['what'])) $what = $_GET['what'];

            if (isset($_POST['add_pac'])) {

                $add = $package->add_pack_type($_POST['pac_name'], $_POST['pac_name_short']);
                if ($add) {
                    echo $lang[313];
                } else {
                    echo $lang[314];
                }

            } elseif (isset($_POST['edit_pac'])) {
                $edit = $package->edit_package($_POST['edit_pac_id'], $_POST['pac_name'], $_POST['pac_name_short']);
                if ($edit) {
                    echo $lang[313];
                } else {
                    echo $lang[314];
                }
            } elseif ($what == "add") {
                $newtemp->load_template('price_pac_add', 5);
            } elseif ($what == "edit") {

                if (isset($_GET['id'])) {
                    $edit = $package->get_packages($_GET['id']);
                    $newtemp->load_template('price_pac_edit', 5);
                }


            } elseif ($what == "mange") {
                $newtemp->load_template('price_pac_mange', 5);
            } elseif ($what == "setting") {
                $pac = $package->get_package();
                $newtemp->load_template('price_pac', 5);
            } elseif ($what == "delete") {
                $del = $package->delete_package($_GET['id']);
                if ($del) {
                    echo $lang[319];
                } else {
                    echo $lang[320];
                }
            }
            break;

        case 'price_setting':
            if (isset($_POST['is_submited'])) {
                $kv = array();
                foreach ($_POST as $key => $value) {
                    $kv[$key] = $value;
                }
//print_r($kv);
                $company->update_company_details($_POST);
                $price->edit_price_option($kv);

            } else {
                $sett_compnay = $company->get_company_details();
                $price_option = $company->get_option("price_");
                $return = $price->get_return_trip_setting();
                $add_ser = $services->get_addtional_services();
                $check = $price->get_add_check_price();
                $newtemp->load_template('price_option', 5);
            }
            break;


        default:
            $page_title = $lang[214];
            $newtemp->load_template('price_manage', 4);
            break;

    }
} else {
    $page_title = $lang[102];
    $newtemp->load_template('login_admin', 5);
}


?>