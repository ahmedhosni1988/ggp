<?php
session_start();
include("../../setting.php");
include("../../classes/inventory.php");
include("../../classes/package.php");
include("../../classes/account.php");
include("../../classes/console.php");


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
        $newtemp->load_template('purchase_main', 1, 'accounting_menu');
        break;

    case 'get_purchase':

        $console = new console(12, $db);
        $console->set_allowtotal("0");
        $console->set_ND("Y");
        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $console->set_page($pageno, PERPAGE);
        
        $coloums_array = array(array('headername' => '+', 'function' => 'show_supplier_row_option', 'pos' => 'last', 'width' => '100px', 'class' => 'nosort'));

        $coloums = $console->get_coloums_header($coloums_array, $dir, $field_name);




//var_dump($coloums);


        $grid_sql = $console->get_grid_sql($coloums, "  inventory_bill
        inner join suppliers on (suppliers.account_id = inventory_bill.account_id )
");
        $query = $grid_sql . " where  ".(isset($_GET['search']) ? $console->build_grid_search($coloums, $_GET['search_txt']) : '')." status = 5     ".(isset($_POST['dir']) ? "order by  ".$table_name.".".$field_name." ".$dir."" : "order by inventory_bill.added_date desc ");


// echo $query."<br>";

        $data = $console->get_coloums_data($coloums, $query);


        $coloum_attribute = array();


// $row_attribute = array(
// 'onclick' => 'focusrow(this,\'all_table\',\'all_table\');',
// 'ondblclick' => 'editrow(this,\'all_table\',\'all_table\');',
// 'id'=> 'orders__order_id'
// );

        $coloum_attribute = array();


        $html_grid = $console->build_grid($coloums, $coloum_attribute, $data, $row_attribute, 'all_table');

        $breadarray[0]['url'] = "suppliers.php";
        $breadarray[0]['name'] = "المشتريات";

        $breadarray[1]['url'] = "";
        $breadarray[1]['name'] = "كل الطلبيات";

        $page_title = "العملاء";

        if ($_GET['ajax']) {
            echo $html_grid;
        } else {
            $newtempAll->load_template('accounting_console', 5);
        }


        // $invData = $invClass->get_purchising_bill();
        // $newtemp->load_template('purchase_data', 5);


        break;

    case 'add_purchase':
        if ($_POST['bill_no']) {
            $bill = array();

            $bill['bill_no'] = $_POST['bill_no'];
            $bill['bill_date'] = date("Y-m-d", strtotime($_POST['bill_date']));
            $bill['action_date'] = date("Y-m-d H:i:s");
            $bill['account_id'] = $_POST['account_id'];
            $bill['added_by'] = $_SESSION['user_id'];
            $bill['added_by_name'] = $_SESSION['name'];
            $bill['added_date'] = date("Y-m-d H:i:s");

            $bill['tax_amount'] = $_POST['bill_tax_amount'];
            $bill['subtotal'] = $_POST['inv_total_price'];
            $bill['discount'] = $_POST['bill_discount'];
            $bill['total_price'] = $_POST['bill_total_amount'];

            $sql = make_insert("inventory_bill", $bill);
            
            // echo $sql;
            $res = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));

            $bill_id = mysqli_insert_id($mycon);
            $logger->compareAndLogV2((int)$bill_id, "purchase", $_SESSION['user_id'], $_SESSION['name'], "Add bill  ", array(), $bill);

            for ($j = 0; $j < count($_POST['item_id']); $j++) {
                if ($_POST['item_id'][$j] != '') {
                    $invetory_details['item_id'] = $_POST['item_id'][$j];
                    $invetory_details['quantity'] = $_POST['quantity'][$j];
                    $invetory_details['price'] = $_POST['price'][$j];

                    $invetory_details['account_id'] = $_POST['account_id'];
                    $invetory_details['bill_id'] = $bill_id;
                    $invetory_details['reason'] = "1";
                    $invetory_details['action_time'] = date("Y-m-d H:i:s");

                    $sql = make_insert("inventory_action", $invetory_details);
                    // echo $sql;
                    $res = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));

           
                    echo 'تمت اضافة الفاتورة بنجاح';
                    //  $invClass->update_inventory($_POST['item_id'][$j], $_POST['quantity'][$j], "1");

                    $logger->compareAndLogV2((int)$_POST['item_id'][$j], "purchase", $_SESSION['user_id'], $_SESSION['name'], "Add bill items ", array(), $invetory_details);
                }
            }
        } else {
            $accountsData = $account->get_suppliers();
            $itemData = $invClass->get_all_items();
            $newtemp->load_template('add_purchase', 5);
        }
        break;



        
    case 'edit_purchase':
        if ($_POST['bill_no']) {
            $bill = array();

            $bill['bill_no'] = $_POST['bill_no'];
            $bill['bill_date'] = date("Y-m-d", strtotime($_POST['bill_date']));
            $bill['action_date'] = date("Y-m-d H:i:s");
            $bill['account_id'] = $_POST['account_id'];
            $bill['added_by'] = $_SESSION['user_id'];
            $bill['added_by_name'] = $_SESSION['name'];
            $bill['added_date'] = date("Y-m-d H:i:s");

            $bill['tax_amount'] = $_POST['bill_tax_amount'];
            $bill['subtotal'] = $_POST['inv_total_price'];
            $bill['discount'] = $_POST['bill_discount'];
            $bill['total_price'] = $_POST['bill_total_amount'];

            $sql = make_insert("inventory_bill", $bill);
            
            // echo $sql;
            $res = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));

            $bill_id = mysqli_insert_id($mycon);
            $logger->compareAndLogV2((int)$bill_id, "purchase", $_SESSION['user_id'], $_SESSION['name'], "Add bill  ", array(), $bill);

            for ($j = 0; $j < count($_POST['item_id']); $j++) {
                if ($_POST['item_id'][$j] != '') {
                    $invetory_details['item_id'] = $_POST['item_id'][$j];
                    $invetory_details['quantity'] = $_POST['quantity'][$j];
                    $invetory_details['price'] = $_POST['price'][$j];

                    $invetory_details['account_id'] = $_POST['account_id'];
                    $invetory_details['bill_id'] = $bill_id;
                    $invetory_details['reason'] = "1";
                    $invetory_details['action_time'] = date("Y-m-d H:i:s");

                    $sql = make_insert("inventory_action", $invetory_details);
                    // echo $sql;
                    $res = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));

           
                    echo 'تمت اضافة الفاتورة بنجاح';
                    //  $invClass->update_inventory($_POST['item_id'][$j], $_POST['quantity'][$j], "1");

                    $logger->compareAndLogV2((int)$_POST['item_id'][$j], "purchase", $_SESSION['user_id'], $_SESSION['name'], "Add bill items ", array(), $invetory_details);
                }
            }
        } else {
            $bill_id = $_GET['bill_id'];
            $billDetails = $invClass->get_purchising_invoice($bill_id);
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
            $sql = make_insert("inventory_items", $_POST);
            // echo $sql;
            $res = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));


            if ($res) {
                $invData = $invClass->get_all_items();
                //var_dump($invData);
                $invData=object_to_array($invData);
                // echo $invData[(count($invData)-1)]['id'];
                $logger->compareAndLogV2($invData[(count($invData)-1)]['id'], "Inventory", $_SESSION['user_id'], $_SESSION['name'], "Add stock  ", array(), $_POST);

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
                $sql = make_insert("inventory_items_color", $_POST);
                //echo $sql;
                $res = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));
                // $res =  $company->add_services($service_name,$service_des,$service_short,$service_color,$service_cuttime,$service_order);
                

                if ($res) {
                    $color = $db->get_table("inventory_items_color");
                    $color=object_to_array($color);
                    //echo count($color);
                    //echo $color[(count($color)-1)]['id'];
                    // echo $lang[948].$_POST['color_name'];
                    $logger->compareAndLogV2($color[(count($color)-1)]['id'], "Items", $_SESSION['user_id'], $_SESSION['name'], "Add_color ", array(), $_POST);
                } else {
                    echo $lang[153];
                }
            }
        } elseif (isset($_GET['id'])) {

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
                $sql = make_insert("inventory_items_company", $_POST);
                //echo $sql;
                $res = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));
                // $res =  $company->add_services($service_name,$service_des,$service_short,$service_color,$service_cuttime,$service_order);


                if ($res) {
                    echo $lang[948];
                    $logger->compareAndLogV2((int)mysqli_insert_id($mycon), "Company", $_SESSION['user_id'], $_SESSION['name'], "Add ", array(), $_POST);
                } else {
                    echo $lang[153];
                }
            }
        } elseif (isset($_GET['id'])) {

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
                $sql = make_insert("inventory_items_size", $_POST);
                //echo $sql;
                $res = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));
                // $res =  $company->add_services($service_name,$service_des,$service_short,$service_color,$service_cuttime,$service_order);


                if ($res) {
                    echo $lang[948];
                    $logger->compareAndLogV2((int)mysqli_insert_id($mycon), "Items", $_SESSION['user_id'], $_SESSION['name'], "Add_size ", array(), $_POST);
                } else {
                    echo $lang[153];
                }
            }
        } elseif (isset($_GET['id'])) {

            ///for edit not now
        } else {
            $colData = $db->get_table("inventory_items_size");
            $newtemp->load_template('inventory_items_size', 5);
        }
        break;

    case 'price_pac':
        $what = "";
        if (isset($_GET['what'])) {
            $what = $_GET['what'];
        }

        if (isset($_POST['add_pac'])) {
            $add = $package->add_pack_type($_POST['pac_name'], $_POST['pac_name_short']);
            if ($add) {
                echo $lang[313];
                $logger->compareAndLogV2((int)$add, "Items", $_SESSION['user_id'], $_SESSION['name'], "Add_price ", array(), $_POST);
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


    case 'suppmain':

        $page_title = $lang[166];
        $newtemp->load_template('supplier_manage', 5);
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




    /////////////////////////////////////////////////////////////
    case 'inventory':
        $invData = $invClass->get_inventory();
        $newtemp->load_template('invenotry_data', 5);
        break;

    default:
        $newtemp->load_template('invenotry_main', 1, 'accounting_menu');
        break;
}
