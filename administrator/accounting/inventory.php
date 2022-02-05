<?php
session_start();
include("../../setting.php");
include("../../classes/inventory.php");
include("../../classes/package.php");
include("../../classes/account.php");


include("../../" . STYLE . "/inventorytemp.php");
include("naccountingtemp.php");

$invClass = new inventory($db);
$package = new package($db);
$newtemp = new template();
$account = new account($db);


if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}


$open = "inventory";

switch ($action) {

    case 'purchase':
        $newtemp->load_template('purchase_main', 5);
        break;

    case 'get_purchase':

        $invData = $invClass->get_purchising_bill();
        $newtemp->load_template('purchase_data', 5);
        break;

    case 'add_purchase':
        if ($_POST['bill_no']) {


            $bill['bill_no'] = $_POST['bill_no'];
            $bill['bill_date'] = date("Y-m-d", strtotime($_POST['bill_date']));
            $bill['action_date'] = date("Y-m-d H:i:s");
            $bill['account_id'] = $_POST['account_id'];
            $bill['total_price'] = $_POST['total_price'];

            $sql = $db->make_insert("inventory_bill", $bill);
            
            // echo $sql;
            $res = mysql_query($sql) or die (mysql_error());

            $bill_id = mysql_insert_id();
            $logger->compareAndLogV2((int)$bill_id,"purchase", $_SESSION['user_id'],  $_SESSION['name'], "Add bill  ",array(),$bill);

            for ($j = 0; $j < count($_POST['item_id']); $j++) {

                if ($_POST['item_id'][$j] != '') {
                    $invetory_details['item_id'] = $_POST['item_id'][$j];
                    $invetory_details['quantity'] = $_POST['quantity'][$j];
                    $invetory_details['price'] = $_POST['price'][$j];

                    $invetory_details['account_id'] = $_POST['account_id'];
                    $invetory_details['bill_id'] = $bill_id;
                    $invetory_details['reason'] = "1";
                    $invetory_details['action_time'] = date("Y-m-d H:i:s");

                    $sql = $db->make_insert("inventory_action", $invetory_details);
                    // echo $sql;
                    $res = mysql_query($sql) or die (mysql_error());


                    $invClass->update_inventory($_POST['item_id'][$j], $_POST['quantity'][$j], "1");

                    $logger->compareAndLogV2((int)$_POST['item_id'][$j],"purchase", $_SESSION['user_id'],  $_SESSION['name'], "Add bill items ",array(),$invetory_details);

                }
            }

        } else {
            $accountsData = $account->get_suppliers();
            $itemData = $invClass->get_all_items();
            $newtemp->load_template('add_purchase', 5);
        }
        break;

    //////////////////ITem and item Details area//////////////////
    case 'items':
        $newtemp->load_template('item_main', 5);
        break;


    case 'get_item':

        $invData = $invClass->get_all_items();
        $newtemp->load_template('item_data', 5);
        break;

    case 'add_item':

        if (isset($_POST['item_name'])) {


            $sql = $db->make_insert("inventory_items", $_POST);
            // echo $sql;
            $res = mysql_query($sql) or die (mysql_error());


            if ($res) {
                $invData = $invClass->get_all_items();
               //var_dump($invData);
               $invData=object_to_array($invData);
               // echo $invData[(count($invData)-1)]['id'];
                $logger->compareAndLogV2($invData[(count($invData)-1)]['id'],"Inventory", $_SESSION['user_id'],  $_SESSION['name'], "Add stock  ",array(),$_POST);

                echo "تم اضافة المنتج بنجاح";
                
                

            } else {
                echo $lang[153];
            }


        } else {
            $color = $db->get_table("inventory_items_color");
            $company = $db->get_table("inventory_items_company");
            $size = $db->get_table("inventory_items_size");
            $thickness = $db->get_table("package_type");

            $newtemp->load_template('add_item', 5);
        }
        break;

    case 'color':
        if (isset($_POST['color_name'])) {

            if (isset($_POST['id'])) {

            } else {
                $sql = $db->make_insert("inventory_items_color", $_POST);
                //echo $sql;
                $res = mysql_query($sql) or die (mysql_error());
                // $res =  $company->add_services($service_name,$service_des,$service_short,$service_color,$service_cuttime,$service_order);
                

                if ($res) {
                    $color = $db->get_table("inventory_items_color");
                    $color=object_to_array($color);
                    //echo count($color);
                    //echo $color[(count($color)-1)]['id'];
                   // echo $lang[948].$_POST['color_name'];
                   $logger->compareAndLogV2($color[(count($color)-1)]['id'],"Items", $_SESSION['user_id'],  $_SESSION['name'], "Add_color ",array(),$_POST);

                } else {
                    echo $lang[153];
                }
            }
        } else if (isset($_GET['id'])) {

            ///for edit not now 

        } else {
            $colData = $db->get_table("inventory_items_color");
            $newtemp->load_template('invenotry_item_color', 5);
        }
        break;


    case 'company':
        if (isset($_POST['company_name'])) {

            if (isset($_POST['id'])) {

            } else {
                $sql = $db->make_insert("inventory_items_company", $_POST);
                //echo $sql;
                $res = mysql_query($sql) or die (mysql_error());
                // $res =  $company->add_services($service_name,$service_des,$service_short,$service_color,$service_cuttime,$service_order);


                if ($res) {
                    echo $lang[948];
                    $logger->compareAndLogV2((int)mysql_insert_id(),"Company", $_SESSION['user_id'],  $_SESSION['name'], "Add ",array(),$_POST);

                } else {
                    echo $lang[153];
                }
            }
        } else if (isset($_GET['id'])) {

            ///for edit not now 

        } else {
            $colData = $db->get_table("inventory_items_company");
            $newtemp->load_template('invenotry_item_company', 5);
        }
        break;


    case 'size':
        if (isset($_POST['item_width'])) {

            if (isset($_POST['id'])) {

            } else {
                $sql = $db->make_insert("inventory_items_size", $_POST);
                //echo $sql;
                $res = mysql_query($sql) or die (mysql_error());
                // $res =  $company->add_services($service_name,$service_des,$service_short,$service_color,$service_cuttime,$service_order);


                if ($res) {
                    echo $lang[948];
                    $logger->compareAndLogV2((int)mysql_insert_id(),"Items", $_SESSION['user_id'],  $_SESSION['name'], "Add_size ",array(),$_POST);

                } else {
                    echo $lang[153];
                }
            }
        } else if (isset($_GET['id'])) {

            ///for edit not now 

        } else {
            $colData = $db->get_table("inventory_items_size");
            $newtemp->load_template('inventory_items_size', 5);
        }
        break;

    case 'price_pac':
        $what = "";
        if (isset($_GET['what'])) $what = $_GET['what'];

        if (isset($_POST['add_pac'])) {

            $add = $package->add_pack_type($_POST['pac_name'], $_POST['pac_name_short']);
            if ($add) {
                echo $lang[313];
                $logger->compareAndLogV2((int)$add,"Items", $_SESSION['user_id'],  $_SESSION['name'], "Add_price ",array(),$_POST);


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


    case 'suppmain' :

        $page_title = $lang[166];
        $newtemp->load_template('account_manage', 5);
        break;

    case 'Suppliers':
        $accounts = $account->get_suppliers();
        $newtemp->load_template('active_suppliers', 5);
        break;

    case 'search':
        if (isset($_POST['search_account_value']) && strlen($_POST['search_account_value']) > 0) {

            $accounts = $account->search_accounts($_POST['search_account_value']);
            $newtemp->load_template('active_account', 5);


        } else {
            $newtemp->load_template('search_account', 5);
        }
        break;

    case 'mange_add_account':
        $account_id = "";
        if (!empty($_GET["account_id"])) {
            $account_id = $_GET["account_id"];
        }

        $newtemp->load_template('manage_add_account', 5);
        break;

    case 'account_details':
        if (isset($_GET['account_id']) && $_GET['account_id'] != '') {


            if (isset($_POST["account_company"])) {
                $account_details = $account->get_supplier($_GET['account_id']);
               $account_details = object_to_array($account_details);
                $added = $account->edit_supplier_array($_POST, $_GET['account_id']);

                if ($added){
                    echo $lang[502];
                    $logger->compareAndLogV2((int)$_GET['account_id'],"Supplier", $_SESSION['user_id'],  $_SESSION['name'], "Edit ", $account_details,$_POST);

                }
                else echo $lang[503];


            } else {

                $account_id = $_GET['account_id'];
                $account_details = $account->get_supplier($_GET['account_id']);
                $locations = $account->get_categorys_type("Location");
                $usertype = $account->get_categorys_type("usertype");
                $newtemp->load_template('account_details', 5);
            }


        } else {
            if (isset($_POST["account_name"])) {

                $num = check_duplication("suppliers", "account_name", $_POST['account_name'], "5");

                if ($num == 0) {
                    $added = $account->add_supplier_array($_POST);
                    if ($added){
                    echo $lang[178];
                   // $logger->compareAndLogV2((int)$added,"Supplier", $_SESSION['user_id'],  $_SESSION['name'], "Add ",array(),$_POST);



                    }
                    else echo $lang[179];
                } else {
                    echo "تم استخدام الرقم من قبل";
                }

            } else {
                $locations = $account->get_categorys_type("Location");
                $usertype = $account->get_categorys_type("usertype");
                $newtemp->load_template('account_details', 5);
            }
        }
        break;


    /////////////////////////////////////////////////////////////
    case 'inventory':
        $invData = $invClass->get_inventory();
        $newtemp->load_template('invenotry_data', 5);
        break;

    default:
        $newtemp->load_template('invenotry_main', 1 , 'accounting_menu');
        break;
}


?>