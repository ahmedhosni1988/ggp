<?php
session_start();

ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');

include("../setting.php");
include("../" . STYLE . "/consoletemp.php");
include("../" . STYLE . "/ordertemp.php");

include("../classes/console.php");
include("../classes/driver.php");
include("../classes/orders.php");
include("../classes/package.php");
include("../classes/company.php");
include("../classes/services.php");
include("../classes/price.php");
include("../classes/account.php");
include("../classes/payment.php");
include("../classes/work.php");
include("../classes/contact.php");
include("../classes/inventory.php");
include("../classes/class.upload.php");
include("../classes/invoices.php");

$invoices = new invoices($db);

$invClass = new inventory($db);
$workClass = new work($db);
$company = new company($db);
$driver = new driver($db);
$order = new orders($db);
$newtemp = new template();
$services = new services($db);
$servicesClass = new services($db);
$serv = new services($db);
$price = new price($db);
$account = new account($db);
$package = new package($db);
$payment = new payment($db);

$data = array();

$sett = $company->get_option("");


if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}

if (!empty($_GET["start"])) {
    $start = $_GET["start"];
} else {
    $start = 0;
}

//echo $action;


if (isset($_POST['table_name'])) {
    $table_name = $_POST['table_name'];
} else {
    $table_name = "orders";
}

if (isset($_POST['field_name'])) {
    $field_name = $_POST['field_name'];
} else {
    $field_name = "order_id";
}

if (isset($_POST['dir'])) {
    if ($_POST['dir'] == "desc") {
        $dir = "asc";
    }
    if ($_POST['dir'] == "asc") {
        $dir = "desc";
    }
} else {
    $dir = "desc";
}


if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == true && $_SESSION['status'] == 2 && ($_SESSION['user_type'] == "administrator" || $_SESSION['user_type'] == "addmanger" || $_SESSION['user_type'] == "manmanger")) {
    switch ($action) {

        case 'all':
            $console = new console(8, $db);
            $console->set_allowtotal("0");
            $console->set_ND("Y");
            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }
            $console->set_page($pageno, PERPAGE);
            

            $coloums_array = array(array('headername' => '+', 'function' => 'show_row_option', 'pos' => 'last', 'width' => '100px', 'class' => 'nosort'));

            $coloums = $console->get_coloums_header($coloums_array, $dir, $field_name);

            //if(isset($_GET['type']) && $_GET['type'] == "future" ) $ti = "orders.order_date > '".date("Y-m-d 23:59:59")."' ";
            //else $ti = "orders.order_date <= '".date("Y-m-d 23:59:59")."' ";


            //var_dump($coloums);

            $grid_sql = $console->get_grid_sql($coloums, "  orders
		inner join services on (orders.service_id = services.service_id) 
		inner join account on (orders.account_id = account.account_id) 
		left join users on (users.user_id = orders.user_id) 
           ");
           
           if ($_SESSION['billing_code'] >  0) {
               $sql = " and orders.billing_code = '".$_SESSION['billing_code']."' ";
           }
            $query = $grid_sql . " where order_status not in ( '3' , '5' ) $sql  " . $ti . "  order by orders.order_id desc, " . $table_name . "." . $field_name . " " . $dir . "   ";


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

            $breadarray[0]['url'] = "montior.php?action=all";
            $breadarray[0]['name'] = $lang[24];

            $breadarray[1]['url'] = "";
            $breadarray[1]['name'] = "كل الطلبيات";

            $page_title = $lang[79];

            if ($_GET['ajax']) {
                $newtemp->load_template('admin_montior_console', 5);
            } else {
                $newtemp->load_template('admin_montior_console', 4);
            }
            break;


        case 'order_details':
            if (isset($_GET['id'])) {
                $notify->remove_order_notify($_GET['id'], "new_order");

                $dri = $driver->get_driver_grid();
                $sett_compnay = $company->get_company_details();

                $order_details = $order->get_order_waybill($_GET['id']);
                $type = $_GET['type'];
                $newtemp->load_template('order_quickdetails', 5);
            }
            break;
        case 'delete_item':
            if ($_GET['id']!="") {
                $res = $package->get_item($_GET['id']);
                $res=object_to_array($res);
                //var_dump($res);
                $package->delete_item($_GET['id']);

                $logger->compareAndLogV2($_GET['id'], "items", $_SESSION['user_id'], $_SESSION['name'], "Delete", array(), $res);
            }

        break;
        case 'edit_detailsorder':

                        if (isset($_POST['is_edit_order']) && $_POST['is_edit_order'] == "1") {
                            // alert("goooooooooooooooo");

                            $order_details = $order->get_order($_POST['order_id']);


                  
                            mysqli_query($mycon, "update orders set last_update_time = '" . date("Y-m-d H:i:s") . "' where order_id = '" . $_POST['order_id'] . "'  ") or die(mysqli_error($mycon));


                            $o['office_name'] = $_POST['office_name'];
                            $o['operation_name'] = $_POST['operation_name'];
                            $o['order_comment'] = $_POST['order_comment'];
                            $o['pickup_date'] = $_POST['pickup_date'];
                            $o['delivery_date'] = $_POST['delivery_date'];
                            $o['service_id'] = $_POST['service_id'];
                            // $o['order_date'] = date("Y-m-d H:i:s");
                            $o['pieces'] = count($_POST['length']);
                            $o['order_type'] = $_POST['order_type'];
                            $o['work_status'] = $_POST['work_status'];
                            $o['glass_type'] = $_POST['glass_type'];
                            $o['billing_code'] = $_POST['billing_code'];

                            if ($_SESSION['user_type'] == 'manmanger' && isset($_POST['new_account_id'])) {
                                if ($_POST['new_account_id'] != '') {
                                    $o['account_id'] = $_POST['new_account_id'];
                                    $_POST['account_id'] = $_POST['new_account_id'];

                                    $log = array();
                                    $log['OBJECT_ID'] = $_POST['order_id'];
                                    $log['OBJECT_NAME'] = 'Order';
                                    $log['USER_ID'] = $_SESSION['user_id'];
                                    $log['USER_NAME'] = $_SESSION['name'];
                                    $log['OPERATION_NAME'] = 'update_order_account';
                                    $log['DATE'] = date('Y-m-d H:i:s');
                                    $log['is_important'] = '1';
                                    $log['BEFORE_CHANGE'] = 'تم تعديل العميل بواسطه الادرة';
                                    $logger->add_new_log($log);
                                }
                            }

                            if ($_SESSION['user_type'] == 'manmanger' && isset($_POST['new_easy_number'])) {
                                if ($_POST['new_easy_number'] != ''  && is_numeric($_POST['new_easy_number'])) {
                                    $o['easy_order_id'] = $_POST['new_easy_number'];
                                    $_POST['easy_order'] = $_POST['new_easy_number'];
                                    mysqli_query($mycon, "update orders_package set easy_order_id = '".$_POST['new_easy_number']."'  where order_id = '".$_POST['order_id']."' ") or die(mysqli_error($mycon));
                                    $log = array();
                                    $log['OBJECT_ID'] = $_POST['order_id'];
                                    $log['OBJECT_NAME'] = 'Order';
                                    $log['USER_ID'] = $_SESSION['user_id'];
                                    $log['USER_NAME'] = $_SESSION['name'];
                                    $log['OPERATION_NAME'] = 'update_order_number';
                                    $log['DATE'] = date('Y-m-d H:i:s');
                                    $log['is_important'] = '1';
                                    $log['BEFORE_CHANGE'] = 'تم تعديل رقم الاوردر من '.$order_details->easy_order_id.' الى '.$_POST['new_easy_number'].' ';
                                    $logger->add_new_log($log);
                                }
                            }


                            $order->update_orders($o, $_POST['order_id']);

                            $pac_type = $_POST['package_type'];
                            $glasscolour = $_POST['glasscolour'];
                            $glassType = $_POST['glassType'];

                            mysqli_query($mycon, "update orders_package set glasscolour = '".$glasscolour."' , glassType ='".$glassType."' , package_type = '".$pac_type."'  where order_id = '".$_POST['order_id']."' ") or die(mysqli_error($mycon));

                            //Add Multi Package Details

                            // if ($order_details->order_status == "0") {
                            //     $id = $_POST['id'];
                            
                            //     $weight = $_POST['length'];
                            //     $volume = $_POST['width'];
                            //     $details = $_POST['details'];
                            //     $details_2 = $_POST['details_2'];

                            //     $parts = $_POST['parts'];
                            //     $pac_type = $_POST['package_type'];
                            //     $pac_status = $_POST['order_status'];
                            //     $pack_options = $_POST['pack_options'];
                            //     $pack_options_meters = $_POST['packoption_meters'];

                            //     $glasscolour = $_POST['glasscolour'];
                            //     $glassPrint = $_POST['glassPrint'];
                            //     $glassType = $_POST['glassType'];
                            //     $glassScarch = $_POST['glassScarch'];
                            //     $glassPointing = $_POST['glassPointing'];
                            //     $glassFixedPointing = $_POST['glassFixedPointing'];
                            //     $noofprinting = $_POST['noofprinting'];
                            //     $colorofprinting = $_POST['colorofprinting'];
                            //     $part_order = $_POST['part_order'];


                            //     $x = 0;
                            //     $size = 0;
                            //     if ($_POST['order_id'] != 0 && $_POST['service_id'] == "2") {
                            //         $cpCount = 0;

                            //         $package->delete_order_package($_POST['order_id']);
                                
                            //         for ($h = 0; $h < count($weight); $h++) {
                            //             // echo count($weight) ."<br>";

                            //             if ($pac_type != '' && $weight[$h] != '' && $volume[$h] != '') {
                            //                 // echo $weight[$h] ."<br>";

                            //                 $size = $size + ($weight[$h] * $volume[$h] * $parts[$h]);
                            //                 $cpCount++;
                            //                 $res = $package->add_package(
                            //                     ($h + 1),
                            //                     $_POST['service_id'],
                            //                     $_POST['order_id'],
                            //                     $_POST['easy_order'],
                            //                     $weight[$h],
                            //                     $volume[$h],
                            //                     $details[$h],
                            //                     $details_2[$h],
                            //                     $parts[$h],
                            //                     $pac_type,
                            //                     $pac_status,
                            //                     $glasscolour,
                            //                     $glassPrint[$h],
                            //                     $glassType,
                            //                     $glassScarch[$h],
                            //                     $glassPointing[$h],
                            //                     $glassFixedPointing[$h],
                            //                     $noofprinting[$h],
                            //                     $colorofprinting[$h],
                            //                     $pack_options[$h],
                            //                     $pack_options_meters[$h],
                            //                     $_POST['account_id']
                            //                 );

                            //                 $o=$package->get_item($res);
                            //                 $cpCount--;
                            //             }
                            //         }
                            //         $t['order_size'] = $size;
                            //         $t['pieces'] = $cpCount;
                            //         $order->update_orders($t, $_POST['order_id']);
                            //     }
                            // }

                            // $glasscolour = '';
                            // $glassType =  '';

                            if ($order_details->order_status == "0") {
                                $package->delete_order_package($_POST['order_id']);

                                    
                                $weight = $_POST['length'];
                                $volume = $_POST['width'];
                                $details = $_POST['order_comment'];
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

                                $order_id = $_POST['order_id'];
                                //var_dump($pac_status);
                                $cpCount = 1;
                                $size = 0;
                                for ($h = 0; $h < count($weight); $h++) {
                                    if ($pac_type != '') {
                                        $res = $package->add_package(
                                            ($h + 1),
                                            $_POST['service_id'],
                                            $_POST['order_id'],
                                            $_POST['easy_order'],
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


                                mysqli_query($mycon, "update orders set pieces = (select count(*) from orders_package where order_id = '".$order_id."') where order_id = '".$order_id."' ") or die(mysqli_error($mycon));

                                $glasscolour = $_POST['glasscolour'];
                                $glassType = $_POST['glassType'];
    
                                mysqli_query($mycon, "update orders_package set glasscolour = '".$glasscolour."' , glassType ='".$glassType."' , package_type = '".$pac_type."'  where order_id = '".$_POST['order_id']."' ") or die(mysqli_error($mycon));
                            } else {
                                if ($_SESSION['user_type'] == 'manmanger') {
                                    ///update working package every important and diffuclt process
                                    $pID = $_POST['id'];
                                    $weight = $_POST['length'];
                                    $volume = $_POST['width'];
                                    $details = $_POST['details'];
                                    $details_2 = $_POST['details_2'];
                                    $glassPointing = $_POST['glassPointing'];

                                    for ($i=0;$i<count($pID);$i++) {
                                        if ($pID[$i]  != '') {
                                            mysqli_query($mycon, "update orders_package set  
                                            length = '".$weight[$i]."' , 
                                            width = '".$volume[$i]."' , 
                                            details = '".$_POST['order_comment']."' , 
                                            details_2 = '".$details_2[$i]."' ,
                                            glassPointing = '".$glassPointing[$i]."' where id = '".$pID[$i]."'  or parent_id = '".$pID[$i]."'  ");
                                        } else {
                                            //  mysqli_query($mycon,"insert into orders_package (order_id,length,width,details,details_2,glassPointing) ");
                                        }
                                    }
                                }
                            }


                            // $glasscolour = $_POST['glasscolour'];
                            // $glassType = $_POST['glassType'];

                            // mysqli_query($mycon,"update orders_package set glasscolour = '".$glassColor."' , glassType ='".$glassType."' , package_type = '".$pac_type."'  where order_id = '".$_POST['order_id']."' ") or die(mysqli_error($mycon));


                            $workClass->calc_order_package($_POST['order_id']);

                            if (isset($_FILES['order_image']['name'][0]) && $_FILES['order_image']['name'][0] != '') {


                                //	$images = $_FILES['order_image'];
                                $dir_dest = "../workimage/";

                                for ($i = 0; $i < count($_FILES['order_image']['name']); $i++) {
                                    $uploaddir = '/var/www/uploads/';

                                    $name = $_FILES["order_image"]["name"][$i];
                                    $ext = end((explode(".", $name))); # extra () to prevent notice


                                    $uploadfile = $dir_dest . $_POST['order_id'] . '_' . date("YmdHis") . '_' . generateRandomCode() . '.' . $ext;

                                    //echo $uploadfile;

                                    if (move_uploaded_file($_FILES['order_image']['tmp_name'][$i], $uploadfile)) {
                                        echo "File is valid, and was successfully uploaded.\n";
                                        $uploadfile = str_replace("../", "", $uploadfile);
                                        mysqli_query($mycon, "insert into orders_image (order_id,image_url,date_update) values ('" . $_POST['order_id'] . "','" . $uploadfile . "','" . date("Y-m-d H:i:s") . "') ;");
                                    } else {
                                        echo "Possible file upload attack!\n";
                                    }
                                }
                            }

                            $ress = $invoices->create_order_invoice($_POST['order_id'], $_POST['account_id']);


                            header("Location: " . SITEURL . "/administrator/montior.php?action=edit_orders&id=" . $_POST['order_id']);
                        }

                        break;

        case 'delete_photo':
            if (isset($_POST['id'])) {
                mysqli_query($mycon, "update orders_image set image_status = '1' where id = '" . $_POST['id'] . "'   ");
            }
            break;

        case 'edit_orders':
            if (isset($_GET['id'])) {
                //$notify->remove_order_notify($_POST['order_id'],"new_order");

                $notify->remove_order_notify($_GET['id'], "new_order");

                $order_details = $order->get_order($_GET['id']);
                $_GET['ser'] = $order_details->service_id;

                if ($order_details->order_status == 0) {
                    $order_packages = $order->get_order_package_group($_GET['id']);
                // $order_packages = $order->get_order_package($_GET['id']);
                } else {
                    // $order_packages = $order->get_order_package($_GET['id']);
                    $order_packages = $order->get_order_package_group($_GET['id']);
                }

                //echo count($order_packages);

                $comData = $db->get_table("inventory_items_company");
                $pack = $package->get_package();
                $order_status = $db->get_table("status  where iscancel = '0' order by disporder");
                $services = $_SESSION['services_table'];
                $glassColor = $db->get_table("inventory_items_color");
                $itemData = $invClass->get_all_items();

                $pack_options = $price->get_add_check_price();
                // $db->get_table("addtional_services");

                $orders_image = $db->get_table("orders_image where order_id = '" . $_GET['id'] . "' and image_status = '0'  ");


                if ($_SESSION['user_type'] == 'manmanger') {
                    $allacc = $account->get_all_accounts(1, $_SESSION['billing_code']);
                }

                $breadarray[0]['url'] = "montior.php?action=all";
                $breadarray[0]['name'] = "متابعة الطلبيات";

                $breadarray[1]['url'] = "montior.php?action=edit_orders&id=" . $_GET['id'];
                $breadarray[1]['name'] = "تعديل الطلبية";

                $breadarray[2]['url'] = "";
                $breadarray[2]['name'] = $order_details->easy_order_id;

                $page_title = $lang[367] . '-' . $_GET['id'];
                $newtemp->load_template('admin_edit_order', 4);
            }
            break;

        case 'assign_driver':
            if (isset($_POST['order_id']) && isset($_POST['driver_id'])) {
                $drivers = $driver->get_driver_grid();
                $newtemp->load_template('assign_driver', 5);
            }
            break;


        case 'start_work':
            if (isset($_POST['order_id'])) {
                // $o=object_to_array( $order_details = $order->get_order($_POST['order_id']));
                //    var_dump($order_details);
                //    echo"ahmed dddddddddddddd";
                // $logger->compareAndLogV2($_POST['order_id'],"Order", $_SESSION['user_id'],  $_SESSION['name'], "Start",array(),$o);

                $workClass->start_work($_POST['order_id']);
            }
            break;

        case 'stop_work':
            if (isset($_POST['order_id'])) {
                //   $o=object_to_array( $order_details = $order->get_order($_POST['order_id']));
                //   $logger->compareAndLogV2($_POST['order_id'],"Order", $_SESSION['user_id'],  $_SESSION['name'], "stop",array(),$o);

                $workClass->stop_play_work($_POST['order_id'], "stop");
                $q = mysqli_query($mycon, "update invoicehdr set reviewed = 0  where order_id = '".$_POST['order_id']."'  ") or die(mysqli_error($mycon));
            }
            break;

        case 'close_order_all':
            if (isset($_POST['order_id'])) {
                //  $o=object_to_array( $order_details = $order->get_order($_POST['order_id']));

                //$logger->compareAndLogV2($_POST['order_id'],"Order", $_SESSION['user_id'],  $_SESSION['name'], "Cancel",array(),$o);

                mysqli_query($mycon, "update orders set order_status = '5',user_cancel='".$_SESSION['user_id']."' ,cancel_date='".date("Y-m-d H:i:s")."' where order_id = '" . $_POST['order_id'] . "'  ");
                $q = mysqli_query($mycon, "update invoicehdr set reviewed = 0 where order_id = '".$_POST['order_id']."'  ") or die(mysqli_error($mycon));
            }
            break;


        case 'play_work':
            if (isset($_POST['order_id'])) {
                //     $o=object_to_array( $order_details = $order->get_order($_POST['order_id']));

                // var_dump($_POST);
                //   $logger->compareAndLogV2($_POST['order_id'],"Order", $_SESSION['user_id'],  $_SESSION['name'], "play",array(),$o);
               
                $workClass->stop_play_work($_POST['order_id'], "play");
            }
            break;


        case 'cancel_request':
            if (isset($_POST['order_id'])) {
                //     $o=object_to_array( $order_details = $order->get_order($_POST['order_id']));

                // echo "ahmedddddd";
                //   $logger->compareAndLogV2($_POST['order_id'],"Order", $_SESSION['user_id'],  $_SESSION['name'], "Delete",array(),$o);
                $workClass->delete_order($_POST['order_id']);
            }
            break;


        case 'sort_driver_orders':

            if (isset($_POST['data'])) {
                $data = $_POST['data'];
                //var_dump($data);
                $all_query = "";
                for ($i = 0; $i < count($data); $i++) {
                    $update_query = "";


                    if (!empty($data[$i]['driver'])) {
                        $update_query .= "update orders set ";

                        $d1 = 0;
                        if ($data[$i]['driver'] == $data[$i]['driver_id1']) {
                            $update_query .= " sort_driver1 = '" . $data[$i]['index'] . "' ";
                            $d1 = 1;
                        }

                        if ($data[$i]['driver'] == $data[$i]['driver_id2'] && $d1 == 0) {
                            $update_query .= " sort_driver2 = '" . $data[$i]['index'] . "' ";
                        }

                        $update_query .= " where order_id = '" . $data[$i]['order_id'] . "'  ";

                        $q = mysqli_query($mycon, $update_query) or die(mysqli_error($mycon) . "---" . $update_query);
                    }

                    $all_query .= $update_query;
                }
                //echo $all_query;
            }

            break;


        case 'today':


            if (isset($_POST['table_name'])) {
                $table_name = $_POST['table_name'];
            } else {
                $table_name = "orders";
            }

            if (isset($_POST['field_name'])) {
                $field_name = $_POST['field_name'];
            } else {
                $field_name = "order_id";
            }

            if (isset($_POST['dir'])) {
                if ($_POST['dir'] == "desc") {
                    $dir = "asc";
                }
                if ($_POST['dir'] == "asc") {
                    $dir = "desc";
                }
            } else {
                $dir = "desc";
            }


            $console = new console(8, $db);
            $console->set_allowtotal("0");
            $console->set_ND("Y");

            $coloums_array = array(array('headername' => '+', 'function' => 'show_row_option', 'pos' => 'last', 'width' => '100px', 'class' => 'nosort'));

            $coloums = $console->get_coloums_header($coloums_array, $dir, $field_name);

            if (isset($_GET['type']) && $_GET['type'] == "future") {
                $ti = "orders.order_date > '" . date("Y-m-d 23:59:59") . "' ";
            } else {
                $ti = "orders.order_date <= '" . date("Y-m-d 23:59:59") . "' ";
            }


            //var_dump($coloums);

            $grid_sql = $console->get_grid_sql($coloums, "  orders
                inner join services on (orders.service_id = services.service_id) 
                inner join account on (orders.account_id = account.account_id) 
                left join users on (users.user_id = orders.user_id) 
                   ");

            $query = $grid_sql . " where  orders.order_status in (1,2) and orders.delivery_date <= '" . date("Y-m-d") . "'   order by orders.order_id desc ";


            //	echo $query."<br>";

            $data = $console->get_coloums_data($coloums, $query);


            $coloum_attribute = array();


            // $row_attribute = array(
            // 'onclick' => 'focusrow(this,\'all_table\',\'all_table\');',
            // 'ondblclick' => 'editrow(this,\'all_table\',\'all_table\');',
            // 'id'=> 'orders__order_id'
            // );

            $coloum_attribute = array();


            $html_grid = $console->build_grid($coloums, $coloum_attribute, $data, $row_attribute, 'all_table');

            $breadarray[0]['url'] = "manger.php?action=orders";
            $breadarray[0]['name'] = $lang[24];

            $breadarray[1]['url'] = "";
            $breadarray[1]['name'] = "كل الطلبيات";

            $page_title = $lang[79];

            if ($_GET['ajax']) {
                $newtemp->load_template('admin_montior_console', 4);
            } else {
                $newtemp->load_template('admin_montior_console', 4);
            }

            break;


        default:
            $page_title = $lang[1];
            $newtemp->load_template('montoir', 4);
            break;
    }
} else {
    $page_title = $lang[102];
    $newtemp->load_template('login_admin', 5);
}
