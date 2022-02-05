<?php
session_start();

//var_dump($_SESSION);
include("../setting.php");
include("../" . STYLE . "/usertemp.php");
include("../classes/contact.php");
include("../classes/account.php");
include("../classes/services.php");
include("../classes/package.php");
include("../classes/payment.php");
include("../classes/orders.php");
include("../classes/price.php");
include("../classes/company.php");
include("../classes/address.php");
include("../classes/driver.php");
include("../classes/console.php");
include("../classes/work.php");
include("../classes/inventory.php");

include("../classes/invoices.php");
//var_dump($_SESSION);

require_once dirname(__FILE__) . '/../packages/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';


$user = new users($db);
$contacts = new contacts($db);
$account = new account($db);
$services = new services($db);
$serv = new services($db);
$company = new company($db);
$package = new package($db);
$payment = new payment($db);
$order = new orders($db);
$price = new price($db);
$address = new address($db);
$driver = new driver($db);
$newtemp = new template();
$workClass = new work($db);
$invClass = new inventory($db);

$invoices = new invoices($db);

if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}

//var_dump($_SESSION);

if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) &&
    $_SESSION['logged_in'] == true && $_SESSION['status'] == 2) {
    switch ($action) {

        case 'choose_client':

            //var_dump($_POST);
            if (isset($_POST['choosesingleorder'])) {
                if (isset($_POST['acct_name2']) && $_POST['acct_name2'] != "") {
                    $res = $account->check_exist("account_name", $_POST['acct_name2']);
                    if (!$res) {
                        header("Location: " . formurl . "/index.php?action=choose_client&e=2");
                    }
                }

                if ($_POST['acct_name2'] != "") {
                    $accno = $_POST['acct_name2'];
                } elseif ($_POST['account_acctno'] != '') {
                    $accno = $_POST['account_acctno'];
                } elseif ($_POST['account_acctname'] != '') {
                    $accno = $_POST['account_acctname'];
                } else {
                    $accno = "";
                }

                header("Location: " . formurl . "/index.php?action=addorder&acctno=" . $accno . "&ser=" . $_POST['service_id']); //echo "a";
            } else {
                $services = $services->get_services();
                $allacc = $account->get_all_accounts(1, $_SESSION['billing_code']);
                $breadarray[0]['url'] = "index.php?action=choose_client";
                $breadarray[0]['name'] = "اختار عميل";
                $page_title = $lang[406];
                $newtemp->load_template('choose_client', 4);
            }


            break;


        case 'search_add':
            if (isset($_GET['n']) && $_GET['n'] != "") {
                $accc = $account->search_account($_GET['n'], "name");
            } else {
                $accc = array();
            }
            header("Content-Type: application/json");

            echo $_GET['callback'] . "(" . json_encode($accc) . ")";
//echo json_encode($accc);
            break;


        case 'addorder':
            if (isset($_POST['type']) && ($_POST['type'] == 'addorder' || $_POST['type'] == 'estimate')) {

//	echo "ahmed";
                $result = "";
                $total = "";

                if ($_POST['type'] == 'addorder') {
                    $estimate_price = 0;
                } else {
                    $estimate_price = 1;
                }

                // Get Client Data
                $ri = mysql_query("select * from account where account_id = '" . $_POST['account_id'] . "' ") or die(mysql_error());
                $client = mysql_fetch_array($ri);

                ////Add Order


                $o = array();
                $o['has_package'] = 1;
                $o['account_id'] = $_POST['account_id'];
                
                $o['price_version_system_id'] = $_POST['price_version_system_id'];
                $o['price_version_account_id'] = $_POST['price_version_account_id'];

                $o['user_id'] = $_SESSION['user_id'];
                $o['orderedby'] = $_SESSION['name'];
                $o['office_name'] = $_POST['office_name'];
                $o['operation_name'] = $_POST['operation_name'];
                $o['order_comment'] = $_POST['order_comment'];
                $o['pickup_date'] = $_POST['pickup_date'];
                $o['delivery_date'] = $_POST['delivery_date'];
                $o['service_id'] = $_POST['service_id'];
                $o['order_date'] = date("Y-m-d H:i:s");
                $o['pieces'] = count($_POST['length']);
                $o['order_type'] = $_POST['order_type'];
                $o['work_status'] = $_POST['work_status'];
                $o['glass_type'] = $_POST['glass_type'];
                $o['option_type'] = $_POST['option_type'];
                $o['billing_code'] = $_POST['billing_code'];

                ///check day
                if ($c_setting['easy_order']  >= "3000") {
                    $easy_order = "1000";
                    mysql_query("update options set option_value = '1000' where option_name = 'easy_order' ");
                } else {
                    $easy_order = $c_setting['easy_order'] + 1;
                }

                if (isset($_POST['easy_order_id']) && $_POST['easy_order_id'] != '' && is_numeric($_POST['easy_order_id'])) {
                    $easy_order = $_POST['easy_order_id'];
                }


                $o['easy_order_id'] = $easy_order;

                

                ////adding order
                $order_id = $order->add_new_orders($o);
                mysql_query("update options set option_value = '".$easy_order."' where option_name = 'easy_order' ");
                //echo count($result);

                //  $logger->compareAndLogV2($order_id,"Order", $_SESSION['user_id'],  $_SESSION['name'], "Add",array(), $o);

                //Add Multi Package Details


                $x = 0;
                if ($order_id != 0) {
                    $weight = $_POST['length'];
                    $volume = $_POST['width'];
                    $details = $_POST['details'];
                    $details_2 = $_POST['details_2'];
                    $parts = $_POST['parts'];
                    $pac_type = $_POST['package_type'];
                    $pac_status = $_POST['order_status'];
                    $pack_options = $_POST['pack_options'];
                    $pack_options_meters = $_POST['packoption_meters'];

                    $glasscolour = $_POST['glasscolour'];
                    $glassPrint = $_POST['glassPrint'];
                    $glassType = $_POST['glassType'];
                    $glassScarch = $_POST['glassScarch'];
                    $glassPointing = $_POST['glassPointing'];
                    $glassFixedPointing = $_POST['glassFixedPointing'];
                    $noofprinting = $_POST['noofprinting'];
                    $colorofprinting = $_POST['colorofprinting'];


                    //var_dump($pac_status);
                    $cpCount = 1;
                    $size = 0;
                    for ($h = 0; $h < count($weight); $h++) {
                        if ($pac_type != '') {
                            $res = $package->add_package(
                                ($h + 1),
                                $_POST['service_id'],
                                $order_id,
                                $easy_order,
                                $weight[$h],
                                $volume[$h],
                                $details[$h],
                                $details_2[$h],
                                $parts[$h],
                                $pac_type,
                                $pac_status,
                                $glasscolour,
                                $glassPrint[$h],
                                $glassType,
                                $glassScarch[$h],
                                $glassPointing[$h],
                                $glassFixedPointing[$h],
                                $noofprinting[$h],
                                $colorofprinting[$h],
                                $pack_options[$h],
                                $pack_options_meters[$h],
                                $_POST['account_id']
                            );

                            $pac['parts'] = $parts[$h];
                            $pac['weight'] = $weight[$h];
                            $pac['volume'] = $volume[$h];
                            $pac['details'] = $details[$h];
                            $pac['pac_type'] = $pac_type;
                            $pac['pac_status'] = $pac_status[$h];
                            $pac['glasscolour'] = $glasscolour;
                            $pac['glassPrint'] = $glassPrint[$h];
                            $pac['glassType'] = $glassType;
                            $pac['glassScarch'] = $glassScarch[$h];
                            $pac['glassPointing'] = $glassPointing[$h];
                            $pac['glassFixedPointing'] = $glassFixedPointing[$h];
                            $pac['noofprinting'] = $noofprinting[$h];
                            $pac['colorofprinting'] = $colorofprinting[$h];
                            $pac['account_id'] = $_POST['account_id'];



                        

                            $size += ($weight[$h] * $volume[$h] * $parts[$h]);
                            //	$cpCount++;
                        }
                    }

                    $t['order_size'] = $size;
                    $t['pieces'] = $cpCount - 1;
                    $order->update_orders($t, $order_id);
                }

                


                //create invoice /////
                $ress = $invoices->create_order_invoice($order_id, $_POST['account_id']);

                ///check driver and send email ////


                $arr['message_type'] = "Order";
                $arr['message_html'] = "الطلبية : " . $order_id . " اضيفت بنجاح <br>   رقم تشغيل الطلبية : $easy_order";
                //$arr['message_html'] = $_POST['vec_services'][0];
                $arr['message_title'] = "طلبية رقم " . $order_id . " اضيفت بنجاح";
                $arr['message'] = $order_id;
                $arr['message'] = $order_id;
                $arr['account_id'] = $client['account_id'];
                $arr['account_name'] = $client['account_name'];


                echo json_encode($arr);
            } else {
                if (isset($_GET['acctno']) && $_GET['acctno'] != "") {
                    $allacc = $account->get_account_byname($_GET['acctno']);

                    if (!isset($allacc->account_id)) {
                        header("Location: index.php?action=choose_client&e=6");
                        return;
                    }

                    $comData = $db->get_table("inventory_items_company");
                    $pack_options = $price->get_add_check_price();
                    // $db->get_table("addtional_services");

                    $pack = $package->get_package();
                    $order_status = $db->get_table("status  where iscancel = '0' order by disporder");
                    $services = $_SESSION['services_table'];
                    $glassColor = $db->get_table("inventory_items_color");
                    $itemData = $invClass->get_all_items();
                    $last_price_version_system=$db->get_table("(SELECT id FROM `price_version`  WHERE `account_id` =0 ORDER BY id DESC) as y");
                    $last_price_version_account=$db->get_table("(SELECT id FROM `price_version`  WHERE `account_id` ='".$allacc->account_id."' ORDER BY id DESC) as y");
                    // var_dump($last_price_version_system[0]['id']);
                    // var_dump($last_price_version_account[0]['id']);
                    $last_price_version_system=$last_price_version_system[0]['id'];
                    $last_price_version_account=$last_price_version_account[0]['id'];
                    $breadarray[0]['url'] = "index.php?action=choose_client";
                    $breadarray[0]['name'] = "اختيار عميل";
                    $breadarray[1]['url'] = "";
                    $breadarray[1]['name'] = "اضافة عميل";

                    $page_title = $lang[23];
                    $newtemp->load_template('admin_add_order', 4);
                } else {
                    header("Location: index.php?action=choose_client");
                }
            }
            break;

           case 'is_printed':
           $order = new orders($db);
           $order_details = $order->get_order_waybill($_GET['order_id']);
          
           $o=object_to_array($order_details);
              $logger->compareAndLogV2((int)$_GET['order_id'], "Order", $_SESSION['user_id'], $_SESSION['name'], "Print", array(), $o);

           break;
        case 'get_waybill':
            if (!empty($_GET['order_id'])) {
                $order_id = $_GET['order_id'];
                $order = new orders($db);
                $order_details = $order->get_order_waybill($order_id);
                $order_package_details = $order->get_order_package_details($order_id);
                $o=object_to_array($order_details);

                $orderLog = $logger->get_order_log($order_id);
               
                //  echo'<pre>';
                //    var_dump($order_package_details);
                //    echo'</pre>';
                // $logger->compareAndLogV2($o['order_id'],"Order", $_SESSION['user_id'],  $_SESSION['name'], "Print",array(),$o);

                $newtemp->load_template('waybill', 5);
            }
            break;
            case 'get_waybill_report':
            if (!empty($_POST['easy_order_id'])) {
                $order= $db->get_table("`orders`  where easy_order_id =".$_POST['easy_order_id']."  ORDER BY `orders`.`order_id` DESC  limit 1");
                if (count($order)>0) {
                    $order_id = $order[0]['order_id'];
                    // echo $order_id;
                    $order = new orders($db);
                    $order_details = $order->get_order_waybill($order_id);
                    $order_package_details = $order->get_order_package_details($order_id);
                    $o=object_to_array($order_details);
                  
                    $newtemp->load_template('waybill_report', 5);
                } else {
                    echo'لا توجد طلبية بهذا الرقم';
                }
            } else {
                $breadarray[0]['url'] = "";
                $breadarray[0]['name'] = "تقرير";
                $breadarray[1]['url'] = "";
                $breadarray[1]['name'] = "تقرير حركة طلبية";

                $newtemp->load_template('report_order_state', 4);
            }
            break;


        case 'auto_complete_account':

            //echo $_GET['q'];
            if (isset($_GET['q'])) {
                $query = mysql_query("select account_name,account_id,account_company,account_address,pcode,phone from account where account_name like '%" . $_GET['q'] . "%' ") or die(mysql_error());

                if (mysql_num_rows($query) > 0) {
                    while ($row = mysql_fetch_array($query)) {
                        $add[] = array('label' => $row['account_name'], 'value' => $row['account_name'], $row);
                    }
                } else {
                    $add[] = array('label' => 'No Account', 'value' => '0');
                }

                echo json_encode($add);
            }

            break;


        case 'logout':
            $page_title = $lang[76];
            $o=$_SESSION;
            $logger->compareAndLogV2($_SESSION['user_id'], "User_action", $_SESSION['user_id'], $_SESSION['name'], "Logout", array(), array());

            $user->logout();

            header('Location: ' . SITEURL . '/administrator');
            break;

        case 'edit_my_setting':

            if (isset($_POST['name'])) {
                $user_data = $user->get_admin_details($_SESSION['user_id']);

                $error_msg = '';
                if (isset($_POST['user_pass']) && $_POST['user_pass'] != '') {
                    if ($_POST['confirm_password'] != $_POST['user_pass']) {
                        $error_msg = $lang[862];
                    } else {
                        $_POST['user_pass'] = md5($_POST['user_pass']);
                    }
                }
                unset($_POST['confirm_password']);
                unset($_POST['edituser']);


                if ($error_msg == '') {
                    $sql = $db->make_update("users", $_POST, 'user_id', $_SESSION['user_id']);
                    //echo 'ahmed';

                    $ed = $db->make_query($sql);

                    if ($ed) {
                        echo $lang[863];
                    
                        ////////////////////////////////////
                        $logger->compareAndLogV2($_SESSION['user_id'], " User_action", $_SESSION['user_id'], $_SESSION['name'], "Change Setting", object_to_array($user_data), $_POST);
                    } else {
                        echo $lang[864];
                    }
                } else {
                    echo $error_msg;
                }
                //$ed = $user->edit_user($_SESSION['user_id'],$_SESSION['account_id'],$_POST['name'],$_POST['password'],$_POST['phone'],$_POST['fax'],$_POST['email'],$_POST['address']);
            } else {
                //echo $_SESSION['user_id'];
                if ($_SESSION['user_type'] == 'administrator' && $_SESSION['status'] == '2') {
                    $user_data = $user->get_admin_details($_SESSION['user_id']);
                    //var_dump($user_data);
                    $page_title = $lang[82];
                    $newtemp->load_template('admin_edit_user', 4);
                } else {
                    $newtemp->load_template('unauthorized', 4);
                }
            }
            break;


        case 'get_services':

            header("Content-Type: application/json");
            echo $_GET['callback'] . "(" . json_encode($db->get_table("services")) . ")";
            break;


        default:

            if ($_SESSION['user_type'] != 'administrator') {
                if ($_SESSION['user_type'] == "accounting") {
                    header("Location: " . SITEURL . "/administrator/accounting.php");
                }
                if ($_SESSION['user_type'] == "manger") {
                    header("Location: " . SITEURL . "/administrator/manger.php");
                } elseif ($_SESSION['user_type'] != "addmanger" && $_SESSION['user_type'] != "manmanger") {
                    header("Location: " . SITEURL . "/administrator/work.php");
                }
            }


            $page = "بعض الخيارت السريعة ";
            $page_title = $lang[1];
            $newtemp->load_template('admin_index', 4);


            break;

//print waybills and barcodes


case 'stop_package':
if (isset($_POST['package_id'])) {
    $res = $workClass->stop_package($_POST['package_id']);
    echo "تم ايقاف القطعة";
}
break;

case 'play_package':
if (isset($_POST['package_id'])) {
    $res = $workClass->play_package($_POST['package_id']);

    echo "تم تشغيل القطعة";
}
break;

case 'delete_package':
if (isset($_POST['package_id'])) {
    $res = $workClass->delete_package($_POST['package_id']);
    echo "تم حذف القطعة";
}
break;

    }
} else {
    if (!isset($_SESSION['cookies']) && empty($_SESSION['login'])) {
        CheckCookieLogin();
    }

    $page_title = $lang[102];
    $newtemp->load_template('login_admin', 5);
}
