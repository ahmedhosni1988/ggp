<?php
session_start();
include("../../setting.php");
include("../../" . STYLE . "/accountusertemp.php");
//include("../../" . STYLE . "/pricetemp.php");

include("../../classes/account.php");
include("../../classes/company.php");
include("../../classes/contact.php");
include("../../classes/console.php");
include("../../classes/payment.php");
include("../../classes/price.php");
include("../../classes/package.php");
include("../../classes/services.php");
include("../../classes/invoices.php");


$account = new account($db);
$company = new company($db);
$contacts = new contacts($db);
$user = new users($db);
$notify = new notify($db);
$payment = new payment($db);
$price = new price($db);
$package = new package($db);
$services = new services($db);
$invoices = new invoices($db);

$newtemp = new template();

if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}

if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == 1 && $_SESSION['status'] == 2) {
    $open = "account";

    switch ($action) {

        case 'edit':
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = $_GET['id'];

                if (isset($_POST['account_id']) && !empty($_POST['account_id'])) {
                    $account_edit = $account->edit_account_admin($_POST['company_name'], $_POST['company_address'], $_POST['city'], $_POST['pcode'], $_POST['phone'], $_POST['fax'], $_POST['status'], $_POST['user_category'], $_POST['client_location'], $_POST['tax_group'], $id);


                    if ($account_edit) {
                        $_POST["edit_account"] = "";

                        $valid = $_POST["valid"];
                        $contact_name = $_POST["contact_name"];
                        $contact_phone = $_POST["contact_phone"];
                        $contact_email = $_POST["contact_email"];

                        for ($i = 0; $i < count($valid); $i++) {
                            if (empty($valid[$i]) || $valid == "") {
                                if (!empty($contact_name[$i]) || !empty($contact_phone[$i]) || !empty($contact_email[$i])) {
                                    $account->insert_contact_account($contact_name[$i], $contact_phone[$i], $contact_email[$i], $_SESSION['account_id']);
                                }
                            } else {
                                $update = $account->update_contact_account($contact_name[$i], $contact_phone[$i], $contact_email[$i], $valid[$i]);
                            }
                        }

                        //print_r($contact_name[0]);
                        echo $lang[180];
                    } else {
                        echo $lang[181];
                    }
                } else {
                    $zone = $price->get_zones();
                    $account_details = $account->get_account($id);
                    $locations = $account->get_categorys_type("Location");
                    $usertype = $account->get_categorys_type("usertype");
                    $account_contacts = $contacts->get_account_contact($id, 'account', $id);
                    $tax_group = $company->get_tax_group();
                    $newtemp->load_template('account_edit', 5);
                }
            }
            break;

        case 'check_username':


            $num = check_duplication("users", "user_name", $_GET['user_name']);
            if ($num == 0) {
                echo true;
            } else {
                echo 0;
            }
            break;
//////////ahme reda///////////
            case 'change_price_version':
            if (isset($_POST['quary']) && $_POST['quary'] != '') {
                mysqli_query($mycon, $_POST['quary']) or die(mysqli_error($mycon));
                //   $x= $invoices->new_re_calc_order_invoice( $_POST['order_id'] , $_POST['account_id'] );
                // echo "select * from orders where order_id = '".$_POST['order_id']."' ";

                $q  = mysqli_query($mycon, "select * from orders where order_id = '".$_POST['order_id']."' ") or die(mysqli_error($mycon));
                $r = mysqli_fetch_array($q);
                // echo $r['order_id'].$r['account_id'];
                $x = $invoices->create_order_invoice($r['order_id'], $r['account_id']);
                //var_dump( $x);
            }
            break;
            case 'price_details':

                if (isset($_GET['bill_code'])) {
                    $bill_code=$_GET['bill_code'];
                } else {
                    $bill_code = "1";
                }


            if (isset($_POST['is_submited']) && isset($_POST['account_id'])) {
                $itemColor = $_POST['itemColor'];
                $price_version = $_POST['price_version'];
                $Glass_type =$_POST['glassType'];
                if (isset($_POST['account_id'])) {
                    $account_id=$_POST['account_id'];
                } else {
                    $account_id='0';
                }
                // mysqli_query($mycon,"DELETE FROM package_status_price WHERE account_id =".$_POST['account_id']);
                $prices = $_POST['price'];
                if ($itemColor > '0' && $price_version > '0') {
                    mysqli_query($mycon, "DELETE FROM package_status_price WHERE account_id ='".$account_id."' 
	and item_colour = '$itemColor' and version_id = '$price_version' and Glass_type = '$Glass_type'  ") ;
                }
                $kv = array();

                foreach ($prices as $package_id => $value) {
                    foreach ($value as $status_id => $val) {
                        //	echo "value : ".$val;

                        if ($val != '') {
                            mysqli_query($mycon, "insert into package_status_price (	account_id,	package_id,status_id,	fee,version_id,item_colour,glass_type) 
	values ('".$account_id."','".$package_id."','".$status_id."','".$val."','".$price_version."','".$itemColor."','".$Glass_type."')");
                        }
                    }
            
                    //$kv[$package_id] = $value;
                }
                echo $lang['price_list_result'];
            } else {
                $account_id=$_GET['account_id'];
                $view=0;
              
                if (isset($_GET['view'])) {
                    $view=$_GET['view'];
                }
                // echo $price_id;
                $pac = $package->get_package();
                $order_status = $db->get_table("status  where iscancel = '0' order by disporder");
                $glassType= $db->get_table("inventory_items_glass_type");

                // $price_values = $price->get_pac_status_pricelist($account_id);
                $last_price_version = $db->get_table("`price_version`  WHERE `account_id` ='$account_id' and parent_id = '0' ORDER BY id DESC");
                
                if (isset($_GET['item_color'])) {
                    $item_color=$_GET['item_color'];
                } else {
                    $item_color = "شفاف";
                }

                if (isset($_GET['glass_type'])) {
                    $glass_type=$_GET['glass_type'];
                } else {
                    $glass_type = "مسطح";
                }

                $glassColor = $db->get_table("inventory_items_color");

                if (isset($_GET['version_id']) && $_GET['version_id'] > '0') {
                    $version_id=$_GET['version_id'];
                } else {
                    $version_id = $last_price_version[0]['id'];
                }

                
                $price_values = $price->get_pac_status_pricelist($account_id, $version_id, $item_color, $glass_type);
                //var_dump($price_values);

                $mylocation = "client";
                $newtemp->load_template('price_option', 5);
            }
              break;
//////////end  ahme reda///////////
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
                    $account_details = $account->get_account($_GET['account_id']);
                    $account_details=object_to_array($account_details);
                    $added = $account->edit_account_array($_POST, $_GET['account_id']);

                    if ($added) {
                        echo $lang[502];
                        $logger->compareAndLogV2((int)$_GET['account_id'], "Customer", $_SESSION['user_id'], $_SESSION['name'], "Edit ", $account_details, $_POST);
                    } else {
                        echo $lang[503];
                    }
                } else {
                    $account_id = $_GET['account_id'];
                    $account_details = $account->get_account($_GET['account_id']);
                    $locations = $account->get_categorys_type("Location");
                    $usertype = $account->get_categorys_type("usertype");
                    $billing_code = $company->get_billing_code() ;
                    $tax_group = $company->get_tax_group();

                    $newtemp->load_template('account_details', 5);
                }
            } else {
                if (isset($_POST["account_company"])) {

//                    $num = check_duplication("account", "account_name", $_POST['account_name'], '1');

//                    if ($num == 0) {


                    $query=mysqli_query($mycon, "SELECT * FROM `account` where 1 order by account_id DESC limit 1") or die(mysqli_error($mycon));

                    $_POST['account_name']=mysqli_fetch_array($query)['account_name']+1;
                    $added = $account->add_account_array($_POST);
                    if ($added) {
                        echo $lang[178];
                        $logger->compareAndLogV2((int)mysqli_insert_id($mycon), "Customer", $_SESSION['user_id'], $_SESSION['name'], "Add ", array(), $_POST);
                    } else {
                        echo $lang[179];
                    }
//                    } else {
//                        echo "تم استخدام الرقم من قبل";
//                    }
                } else {
                    $billing_code = $company->get_billing_code() ;
                    $locations = $account->get_categorys_type("Location");
                    $usertype = $account->get_categorys_type("usertype");
                    $newtemp->load_template('account_details', 5);
                }
            }
            break;

/////////////////////////////////////////////////////
        case 'invoice_format':
            if (isset($_GET['account_id'])) {
                if ($_POST["invoiceoption_rb1"]) {
                    $added = $account->edit_account_array($_POST, $_GET['account_id']);

                    if ($added) {
                        echo $lang[502];
                    } else {
                        echo $lang[503];
                    }
                } else {
                    $account_id = $_GET['account_id'];
                    $account_details = $account->get_account($_GET['account_id']);
                    $newtemp->load_template('invoice_format', 5);
                }
            }
            break;


        case 'options':
            if (isset($_GET['account_id'])) {
                if (isset($_POST["extra_waybills"])) {
                    $added = $account->edit_account_array($_POST, $_GET['account_id']);

                    if ($added) {
                        echo $lang[502];
                    } else {
                        echo $lang[503];
                    }
                } else {
                    $account_users = $account->get_account_users($_GET['account_id']);
                    $account_id = $_GET['account_id'];
                    $account_details = $account->get_account($_GET['account_id']);
                    $newtemp->load_template('account_options', 5);
                }
            }
            break;


////////////////////////////////////////////
        case 'contact_details':
            if (isset($_GET['account_id'])) {
                if (isset($_POST["is_post"])) {
                    $contact_name = $_POST["nc__contact_name"];
                    $contact_phone = $_POST["nc__contact_phone"];
                    $contact_email = $_POST["nc__contact_email"];
                    $email_notify = $_POST["nc__email_notify"];


                    $account->insert_contact_account($contact_name, $contact_phone, $contact_email, $email_notify, $_GET['account_id']);

                    echo $lang[504];
                } else {
                    $account_id = $_GET['account_id'];
                    $account_contacts = $contacts->get_account_contact($_GET['account_id']);
                    $newtemp->load_template('contact_details', 5);
                }
            } else {
                $newtemp->load_template('contact_details', 5);
            }
            break;

        case 'finical_details':
            if (isset($_GET['account_id'])) {
                if (isset($_POST['billto_company'])) {
                    //print_r($_POST);
                    $added = $account->edit_account_array($_POST, $_GET['account_id']);

                    if ($added) {
                        echo $lang[502];
                    } else {
                        echo $lang[503];
                    }
                } else {
                    $account_id = $_GET['account_id'];
                    $account_details = $account->get_account($_GET['account_id']);
                    $tax_group = $company->get_tax_group();
                    $payment_term = $payment->get_payment_term();
                    $payment_type = $payment->get_payment();
                    $billing_freq = $company->get_billing_frequency();
                    $newtemp->load_template('finical_details', 5);
                }
            } else {
                $tax_group = $company->get_tax_group();
                $payment_term = $payment->get_payment_term();
                $payment_type = $payment->get_payment();
                $billing_freq = $company->get_billing_frequency();
                $newtemp->load_template('finical_details', 5);
            }
            break;

        case 'pricing_details':
            if (isset($_GET['account_id'])) {
                if (isset($_POST['price_ovrd_quotes'])) {
                    if ($c_setting['company_skid'] == "1") {
                        $ser = $services->get_services();
                        $vec = $price->get_vechiles();

                        $res = $price->update_distance_vec_price_inc($_POST, $vec, $ser, $_GET['account_id']);
                        unset($_POST['order']);
                    } else {
                        $vec = $price->update_distance_vec_price($_POST, $_GET['account_id']);
                        $vec1 = $price->update_distance_ratio($_POST, $_GET['account_id']);
                    }


                    $added = $account->edit_account_array($_POST, $_GET['account_id']);
                    $added_overide = $account->add_price_over($_POST, $_GET['account_id']);

                    //$vec =  $price->update_distance_vec_price($_POST);
                    //$vec1 =   $price->update_distance_ratio($_POST);


                    if ($added) {
                        echo $lang[505];
                    } else {
                        echo $lang[503];
                    }
                } else {
                    $account_id = $_GET['account_id'];
                    $price_over = $account->get_price_over($_GET['account_id']);
                    $ser_over = $account->get_vec_ser($_GET['account_id']);
                    $pickup_fee = $account->get_account_pickup($_GET['account_id']);
                    $delivery_fee = $account->get_account_delivery($_GET['account_id'], 0);
                    $account_details = $account->get_account($_GET['account_id']);
                    $company_setting = $company->get_company_details_price();

                    $package_details = $price->get_add_check_price();
                    $pieces_details = $package->get_package_vechile();
                    $vechile_services = $services->get_addtional_services();

                    $ser = $services->get_services();
                    $vec = $price->get_vechiles();

                    $sett_compnay = $company->get_company_details();

                    $dfees = $price->get_distance_vec_price($account_id);
                    $val = $price->get_distance_ratio($account_id);

                    if ($c_setting['company_skid'] == "1") {
                        //echo "ahmed";
                        $dfees = $price->get_distance_vec_price_increment($_GET['account_id']);

                        //$va = $price->get_distance_vec_price_increment($_GET['account_id']);
                    }

                    $newtemp->load_template('pricing_details', 5);
                }
            } else {
                $sett = $company->get_option("price_");


                $company_setting = $company->get_company_details_price();
                $package_details = $price->get_add_check_price();
                $pieces_details = $package->get_package_vechile();
                $ser = $services->get_services();
                $vec = $price->get_vechiles();
                $newtemp->load_template('pricing_details', 5);
            }
            break;

        case 'add':

            if (isset($_POST["account_name"])) {
                $num = check_duplication("account", "account_name", $_POST['account_name'], "1");

                if ($num == 0) {
                    //$added = $account->add_account($_POST['account_name'],$_POST['company_name'],$_POST['company_address'],$_POST['city'],$_POST['pcode'],$_POST['phone'],$_POST['fax'],$_POST['status'],$_POST['user_category'],$_POST['client_location'],$_POST['tax_group']);

                    $added = $account->add_account_array($_POST);
                    echo $added;

                    if (is_numeric($added)) {
                        echo $lang[178];
                    } else {
                        echo $lang[179];
                    }
                } else {
                    echo $lang[179];
                }
            } else {
                $newtemp->load_template('add_account', 5);
            }
            break;

        case 'unactive':
            $accounts = $account->get_accounts(2, $_SESSION['billing_code']);
            $newtemp->load_template('active_account', 5);
            break;

        case 'delaccount':
            $accounts = $account->get_accounts(3, $_SESSION['billing_code']);
            $newtemp->load_template('active_account', 5);
            break;

        case 'active':
            $console = new console(10, $db);
            $console->set_allowtotal("0");
            $console->set_ND("Y");
            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }
            $console->set_page($pageno, PERPAGE);
            
            $coloums_array = array(array('headername' => '+', 'function' => 'show_account_row_option', 'pos' => 'last', 'width' => '100px', 'class' => 'nosort'));

            $coloums = $console->get_coloums_header($coloums_array, $dir, $field_name);

            if (isset($_GET['type']) && $_GET['type'] == "future") {
                $ti = "orders.order_date > '" . date("Y-m-d 23:59:59") . "' ";
            } else {
                $ti = "orders.order_date <= '" . date("Y-m-d 23:59:59") . "' ";
            }


//var_dump($coloums);


            $grid_sql = $console->get_grid_sql($coloums, "  account
inner join billing_code on (billing_code.id = account.billing_code) 
   ");
            $query = $grid_sql . " where  ".(isset($_GET['search']) ? $console->build_grid_search($coloums, $_GET['search_txt']) : '')." status = 1     ".(isset($_POST['dir']) ? "order by  ".$table_name.".".$field_name." ".$dir."" : "order by account.account_id desc ");


    //echo $query."<br>";

            $data = $console->get_coloums_data($coloums, $query);


            $coloum_attribute = array();


// $row_attribute = array(
// 'onclick' => 'focusrow(this,\'all_table\',\'all_table\');',
// 'ondblclick' => 'editrow(this,\'all_table\',\'all_table\');',
// 'id'=> 'orders__order_id'
// );

            $coloum_attribute = array();


            $html_grid = $console->build_grid($coloums, $coloum_attribute, $data, $row_attribute, 'all_table');

            $breadarray[0]['url'] = "index.php?action=accounts";
            $breadarray[0]['name'] = "العملاء";

            // $breadarray[1]['url'] = "";
            // $breadarray[1]['name'] = "كل الطلبيات";

            $page_title = "العملاء";

            if ($_GET['ajax']) {
                echo $html_grid;
            } else {
                $newtempAll->load_template('accounting_console', 5);
            }

            break;


        case 'manage_account':
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = $_GET['id'];

                $newtemp->load_template('manage_account_main', 5);
            }
            break;

        case 'add_client_user':
            if (isset($_POST['account_id']) && isset($_POST['account_name'])) {
                $num = check_duplication_users("users", "user_name", $_POST['user_name'], $_POST['account_id']);


                if ($num == 0 && valid_email($_POST['email']) && $_POST['user_type'] != "") {
                    $user_id = $user->add_user($_POST['account_id'], $_POST['user_name'], $_POST['user_pass'], $_POST['name'], $_POST['address'], $_POST['phone'], $_POST['fax'], $_POST['email'], $_POST['user_type'], 1);


                    if (is_numeric($user_id)) {
                        $_POST['account_name'] = "";
                        echo $lang[100];
                    } else {
                        $_POST['account_name'] = "";
                        echo $lang[99];
                    }
                } else {
                    echo $lang[199];
                }
            } else {
                $account_id = $_GET['id'];
                $account_details = $account->get_account($account_id);
                $newtemp->load_template('add_client_user', 5);
            }
            break;


        case 'edit_client_user':
            if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
                $error_msg = '';
                if (isset($_POST['user_pass']) && $_POST['user_pass'] != '') {
                    if ($_POST['confirm_password'] != $_POST['user_pass']) {
                        $error_msg = $lang[862];
                    } else {
                        $_POST['user_pass'] = md5($_POST['user_pass']);
                    }
                } else {
                    unset($_POST['user_pass']);
                }
                unset($_POST['confirm_password']);
                unset($_POST['edituser']);


                if ($error_msg == '') {
                    $sql = $db->make_update("users", $_POST, 'user_id', $_POST['user_id']);
                    //echo $sql;

                    $ed = $db->make_query($sql);

                    if ($ed) {
                        echo $lang[863];
                    } else {
                        echo $lang[864];
                    }
                } else {
                    echo $error_msg;
                }
            } else {
                $user_id = $_GET['userid'];
                $user_data = $user->get_user_details($user_id);
                $newtemp->load_template('edit_client_user', 5);
            }
            break;

        case 'delete_client_user':
            if (isset($_GET['userid'])) {
                $user_id = $_GET['userid'];
                $del = $user->delete_user($user_id);
                if ($del) {
                    echo $lang[170];
                } else {
                    echo $lang[171];
                }
            }
            break;

        case 'mangeuser':

            if (isset($_GET['id'])) {
                $console = new console(1, $db);

                $coloums_array = array(
                    '0' => array('headername' => '+', 'pos' => 'first'),
                    '1' => array('headername' => 'Edit', 'pos' => 'last', 'coloum_fieldname' => 'Edit', 'function' => 'print_editlink_admin'),
                    '2' => array('headername' => 'Delete', 'pos' => 'last', 'coloum_fieldname' => 'Delete', 'function' => 'print_deletelink_admin')
                );

                $coloums = $console->get_coloums_header($coloums_array);
                $grid_sql = $console->get_grid_sql($coloums, " users where  users.account_id= " . $_GET['id'] . " ");

                $row_attribute = array();
                $data = $console->get_coloums_data($coloums, $grid_sql);
                $html_grid = $console->build_grid($coloums, $coloums_array, $data, $row_attribute, "user_table");
                $newtemp->load_template('show_users_admin', 5);
            } else {
                $page_title = $lang[30];
                $newtemp->load_template('manage_account_user', 3);
            }
            break;

        case 'search':
            if (isset($_POST['search_account_value']) && strlen($_POST['search_account_value']) > 0) {
                $accounts = $account->search_accounts($_POST['search_account_value'], $_SESSION['billing_code']);
                $newtemp->load_template('active_account', 5);
            } else {
                $newtemp->load_template('search_account', 5);
            }
            break;

        case 'del_unassign':
            if (isset($_GET['id'])) {
                $notify->delete_notify_type_object('new_user', $_GET['id']);
                $acc = $account->del_account($_GET['id']);
                if ($acc) {
                    echo $lang[206];
                } else {
                    echo $lang[207];
                }
            }
            break;


        case 'get_vec':
            $vec = $price->get_vechiles();
            echo json_encode($vec);
            break;

        case 'get_ser':
            $ser = $services->get_services();
            echo json_encode($ser);
            break;

        case 'copy_price':
            if (isset($_POST['account_id_from'])) {
                if ($_POST['account_id_from'] == $_POST['account_id_to']) {
                    echo "Cannot Copy Price to same accounts";
                    return;
                }
                if ($_POST['account_id_from'] == "" && $_POST['account_id_to'] == "") {
                    echo "Please select Both account";
                    return;
                }

                mysqli_query($mycon, "delete from account_vec_ser where account_id = '" . $_POST['account_id_to'] . "'") or die(mysqli_error($mycon));
                mysqli_query($mycon, "delete from account_override where account_id = '" . $_POST['account_id_to'] . "'") or die(mysqli_error($mycon));
                mysqli_query($mycon, "delete from vehicles_distance_price where account_id = '" . $_POST['account_id_to'] . "'") or die(mysqli_error($mycon));
                mysqli_query($mycon, "delete from deliveryfees where client_acctno = '" . $_POST['account_id_to'] . "'") or die(mysqli_error($mycon));
                mysqli_query($mycon, "delete from pickupfees where client_acctno = '" . $_POST['account_id_to'] . "'") or die(mysqli_error($mycon));
                mysqli_query($mycon, "delete from service_vechicle_distance where account_id = '" . $_POST['account_id_to'] . "'") or die(mysqli_error($mycon));
                mysqli_query($mycon, "delete from services_distance_ratio where account_id = '" . $_POST['account_id_to'] . "'") or die(mysqli_error($mycon));


                $query = mysqli_query($mycon, "insert into account_vec_ser (account_id,services_id,vechile_id,override,type) select  " . $_POST['account_id_to'] . ",services_id,vechile_id,override,type from account_vec_ser where account_id= '" . $_POST['account_id_from'] . "' ") or die(mysqli_error($mycon));

                $query = mysqli_query($mycon, "insert into account_override (account_id,package_id,override,type) select  " . $_POST['account_id_to'] . ",package_id,override,type from account_override where account_id= '" . $_POST['account_id_from'] . "' ") or die(mysqli_error($mycon));

                $query = mysqli_query($mycon, "insert into vehicles_distance_price (account_id,ser_id,vec_id,fees) select  " . $_POST['account_id_to'] . ",ser_id,vec_id,fees from vehicles_distance_price where account_id= '" . $_POST['account_id_from'] . "' ") or die(mysqli_error($mycon));

                $query = mysqli_query($mycon, "insert into deliveryfees (client_acctno,`svc`,`zonefrom`,`zoneto`,`price`,`skid_price`,`chart`,`client_vadjust`) select  " . $_POST['account_id_to'] . ",`svc`,`zonefrom`,`zoneto`,`price`,`skid_price`,`chart`,`client_vadjust` from deliveryfees where client_acctno= '" . $_POST['account_id_from'] . "' ") or die(mysqli_error($mycon));

                $query = mysqli_query($mycon, "insert into pickupfees (client_acctno,`vehicle_id`,`zone`,`fee`,`skid_fee`) select  " . $_POST['account_id_to'] . ",`vehicle_id`,`zone`,`fee`,`skid_fee` from pickupfees where client_acctno= '" . $_POST['account_id_from'] . "' ") or die(mysqli_error($mycon));

                $query = mysqli_query($mycon, "insert into service_vechicle_distance (account_id,`ser_id`,`vec_id`,`distance`,`fees`,`type`,`orders`,`rate`) select  " . $_POST['account_id_to'] . ",`ser_id`,`vec_id`,`distance`,`fees`,`type`,`orders`,`rate` from service_vechicle_distance where account_id= '" . $_POST['account_id_from'] . "' ") or die(mysqli_error($mycon));

                $query = mysqli_query($mycon, "insert into services_distance_ratio (account_id,`name`,`ser_id`,`ratio`,`every`) select  " . $_POST['account_id_to'] . ",`name`,`ser_id`,`ratio`,`every` from services_distance_ratio where account_id= '" . $_POST['account_id_from'] . "' ") or die(mysqli_error($mycon));

                $q = mysqli_query($mycon, "select * from account where account_id = '" . $_POST['account_id_from'] . "' ");
                $result = mysqli_fetch_array($q);

                $query = mysqli_query($mycon, "update account set price_ovrd_nocharge_weight = '" . $result['price_ovrd_nocharge_weight'] . "',price_ovrd_nocharge_volume = '" . $result['price_ovrd_nocharge_volume'] . "', price_ovrd_extra_weight = '" . $result['price_ovrd_extra_weight'] . "',price_ovrd_extra_volume = '" . $result['price_ovrd_extra_volume'] . "' where account_id = '" . $_POST['account_id_to'] . "'") or die(mysqli_error($mycon));

                echo "Price Copied successfully";
            } else {
                $accounts = $account->get_accounts_where($data, $type);
                $newtemp->load_template('account_copyprice', 5);
            }
            break;


        default:

            $page_title = $lang[166];
            $newtemp->load_template('account_manage', 1, 'accounting_menu');
            break;
    }
} else {
    $page_title = $lang[102];
    $newtemp->load_template('login_admin', 5);
}
