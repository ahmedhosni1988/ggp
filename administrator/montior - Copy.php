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


if (isset($_POST['table_name'])) $table_name = $_POST['table_name'];
else $table_name = "orders";

if (isset($_POST['field_name'])) $field_name = $_POST['field_name'];
else $field_name = "order_id";

if (isset($_POST['dir'])) {
    if ($_POST['dir'] == "desc") $dir = "asc";
    if ($_POST['dir'] == "asc") $dir = "desc";
} else $dir = "desc";


if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == true && $_SESSION['status'] == 2 && ($_SESSION['user_type'] == "administrator" || $_SESSION['user_type'] == "addmanger" || $_SESSION['user_type'] == "manmanger")) {

    switch ($action) {

        case 'all' :
            $console = new console(8);
            $console->set_allowtotal("0");
            $console->set_ND("Y");

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
            $query = $grid_sql . " where order_status not in ( '3' , '5' )   " . $ti . "  order by orders.order_id desc, " . $table_name . "." . $field_name . " " . $dir . "   ";


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

            if ($_GET['ajax']) $newtemp->load_template('admin_montior_console', 5);
            else $newtemp->load_template('admin_montior_console', 4);
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

        case 'edit_detailsorder':

                        if (isset($_POST['is_edit_order']) && $_POST['is_edit_order'] == "1") {
                        // alert("goooooooooooooooo");

                  
                            mysql_query("update orders set last_update_time = '" . date("Y-m-d H:i:s") . "' where order_id = '" . $_POST['order_id'] . "'  ") or die (mysql_error());


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


                            $order->update_orders($o, $_POST['order_id']);
                            $logger->compareAndLogV2($_POST['order_id'],"تعديل طلبية", $_SESSION['user_id'],  $_SESSION['name'], "تعديل",array(), $o);


                            //Add Multi Package Details


                            $id = $_POST['id'];
                            $weight = $_POST['length'];
                            $volume = $_POST['width'];
                            $details = $_POST['details'];
                            $parts = $_POST['parts'];
                            $pac_type = $_POST['package_type'];
                            $pac_status = $_POST['order_status'];

                            $glasscolour = $_POST['glasscolour'];
                            $glassPrint = $_POST['glassPrint'];
                            $glassType = $_POST['glassType'];
                            $glassScarch = $_POST['glassScarch'];
                            $glassPointing = $_POST['glassPointing'];
                            $glassFixedPointing = $_POST['glassFixedPointing'];
                            $noofprinting = $_POST['noofprinting'];
                            $colorofprinting = $_POST['colorofprinting'];
                            $part_order = $_POST['part_order'];


                            $x = 0;
                            $size = 0;
                            if ($_POST['order_id'] != 0 && $_POST['service_id'] == "2") {


                              


                                $cpCount = 0;

                                $package->delete_order_package($_POST['order_id']);
                                
                                for ($h = 0; $h < count($weight); $h++) {
                                        //echo count($weight) ."<br>";

                                    if ($pac_type[$h] != '' && $weight[$h] != '' && $volume[$h] != '') {
                                        //echo $weight[$h] ."<br>";

                                        $size = $size + ($weight[$h] * $volume[$h] * $parts[$h]);

                                       
                                            //inser new one
                                            //	if($x==0) $cpCount++;
                                            $cpCount++;
                                            $res = $package->add_package(($h + 1), $_POST['service_id'], $_POST['order_id'], $weight[$h], $volume[$h], $details[$h], $parts[$h], $pac_type[$h], $pac_status[$h],
                                                $glasscolour[$h], $glassPrint[$h], $glassType[$h], $glassScarch[$h], $glassPointing[$h], $glassFixedPointing[$h], $noofprinting[$h],
                                                $colorofprinting[$h], $_POST['account_id']);
                                            //$x++;
                                            $cpCount--;


                                        


                                        // $res = $package->add_package(($h+1),$_POST['service_id'],$order_id,$weight[$h],$volume[$h],$details[$h],$parts[$h],$pac_type[$h],$pac_status[$h],
                                        // $glasscolour[$h],$glassPrint[$h],$glassType[$h],$glassScarch[$h],$glassPointing[$h],$glassFixedPointing[$h],$noofprinting[$h],
                                        // $colorofprinting[$h],$client['account_id']);

                                    }

                                }

                                $t['order_size'] = $size;
                                $t['pieces'] = $cpCount;
                                $order->update_orders($t, $_POST['order_id']);


                            }


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
                                        mysql_query("insert into orders_image (order_id,image_url,date_update) values ('" . $_POST['order_id'] . "','" . $uploadfile . "','" . date("Y-m-d H:i:s") . "') ;");
                                    } else {
                                        echo "Possible file upload attack!\n";
                                    }

                                }


                            }

                        header("Location: " . SITEURL . "/administrator/montior.php?action=edit_orders&id=" . $_POST['order_id']);

                        }

                        break;

        case 'delete_photo':
            if (isset($_POST['id'])) {
                mysql_query("update orders_image set image_status = '1' where id = '" . $_POST['id'] . "'   ");

            }
            break;

        case 'edit_orders':
            if (isset($_GET['id'])) {
                //$notify->remove_order_notify($_POST['order_id'],"new_order");

                $notify->remove_order_notify($_GET['id'], "new_order");

                $order_details = $order->get_order($_GET['id']);
                $_GET['ser'] = $order_details->service_id;

                $order_packages = $order->get_order_package($_GET['id']);

//echo count($order_packages);

                $comData = $db->get_table("inventory_items_company");
                $pack = $package->get_package();
                $order_status = $db->get_table("status  where iscancel = '0' order by disporder");
                $services = $_SESSION['services_table'];
                $glassColor = $db->get_table("inventory_items_color");
                $itemData = $invClass->get_all_items();

                $orders_image = $db->get_table("orders_image where order_id = '" . $_GET['id'] . "' and image_status = '0'  ");


                $breadarray[0]['url'] = "montior.php?action=all";
                $breadarray[0]['name'] = "متابعة الطلبيات";

                $breadarray[1]['url'] = "montior.php?action=edit_orders&id=" . $_GET['id'];
                $breadarray[1]['name'] = "تعديل الطلبية";

                $breadarray[2]['url'] = "";
                $breadarray[2]['name'] = $_GET['id'];

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


                $workClass->start_work($_POST['order_id']);

            }
            break;

        case 'stop_work':
            if (isset($_POST['order_id'])) {


                $workClass->stop_play_work($_POST['order_id'], "stop");

            }
            break;

        case 'close_order_all':
            if (isset($_POST['order_id'])) {


                mysql_query("update orders set order_status = '5' where order_id = '" . $_POST['order_id'] . "'  ");

            }
            break;


        case 'play_work':
            if (isset($_POST['order_id'])) {


                $workClass->stop_play_work($_POST['order_id'], "play");

            }
            break;


        case 'cancel_request':
            if (isset($_POST['order_id'])) {


                $logger->compareAndLogV2($_POST['order_id']," متابعة الطلبيات", $_SESSION['user_id'],  $_SESSION['name'], "حذف",$_POST,array());
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

                        $q = mysql_query($update_query) or die (mysql_error() . "---" . $update_query);

                    }

                    $all_query .= $update_query;
                }
                //echo $all_query;


            }

            break;


        case 'today':


            if (isset($_POST['table_name'])) $table_name = $_POST['table_name'];
            else $table_name = "orders";

            if (isset($_POST['field_name'])) $field_name = $_POST['field_name'];
            else $field_name = "order_id";

            if (isset($_POST['dir'])) {
                if ($_POST['dir'] == "desc") $dir = "asc";
                if ($_POST['dir'] == "asc") $dir = "desc";
            } else $dir = "desc";


            $console = new console(8);
            $console->set_allowtotal("0");
            $console->set_ND("Y");

            $coloums_array = array(array('headername' => '+', 'function' => 'show_row_option', 'pos' => 'last', 'width' => '100px', 'class' => 'nosort'));

            $coloums = $console->get_coloums_header($coloums_array, $dir, $field_name);

            if (isset($_GET['type']) && $_GET['type'] == "future") $ti = "orders.order_date > '" . date("Y-m-d 23:59:59") . "' ";
            else $ti = "orders.order_date <= '" . date("Y-m-d 23:59:59") . "' ";


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

            if ($_GET['ajax']) $newtemp->load_template('admin_montior_console', 4);
            else $newtemp->load_template('admin_montior_console', 4);

            break;


        default :
            $page_title = $lang[1];
            $newtemp->load_template('montoir', 4);
            break;
    }

} else {
    $page_title = $lang[102];
    $newtemp->load_template('login_admin', 5);
}


?>