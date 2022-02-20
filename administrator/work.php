<?php
session_start();
include("../setting.php");
include("../" . STYLE . "/worktemp.php");
include("../" . STYLE . "/inventorytemp.php");
include("../" . STYLE . "/consoletemp.php");
include("../classes/account.php");

include("../classes/console.php");
include("../classes/work.php");
include("../classes/inventory.php");

$newtemp = new template();
$workClass = new work($db);
$account = new account($db);

$invClass = new inventory($db);


if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}


if ($login['user_type'] != 'administrator' && !empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == true && $_SESSION['status'] == 2) {
    // echo "ahmed";
    switch ($action) {

        default:

            if ($_SESSION['user_type'] == "4") {
                if ($_SESSION['user_action'] == "1") {
                    $con = " and orders_package_work.in_work = '0' ";
                }
                if ($_SESSION['user_action'] == "2") {
                    $con = " and orders_package_work.in_work = '1' ";
                }
            }


            $Ssql = "";
            // if ($_SESSION['user_type'] == "7") {
            //     if ($_SESSION['user_action'] == "1") {
            //         $Ssql = " and orders_package.glassPointing in ('ربع','حسب الفارمه','اخرام')  ";
            //     }
            //     if ($_SESSION['user_action'] == "2") {
            //         $Ssql = " and orders_package.glassPointing in ('ربع','حسب الفارمه','اخلاع') ";
            //     }
            // }

            $conClass = new console(2);
            $conClass->set_page($pageno, PERPAGE);
            $conClass->set_allowtotal("0");
            $conClass->set_ND("Y");
            //  $coloums_array = array(  array('headername'=>'+','function'=>'show_report_option','pos'=>'last') );

            if ($_SESSION['user_type'] == "3") {
                $coloums_array = array(array('headername' => '+', 'function' => 'show_row_option_work_image', 'pos' => 'last', 'width' => '130px', 'class' => 'nosort'));
            } else {
                $coloums_array = array(array('headername' => '+', 'function' => 'show_row_option_work', 'pos' => 'last', 'width' => '130px', 'class' => 'nosort'));
            }

            //  $coloums = $conClass->get_coloums_header($coloums_array,$dir,$field_name);



            $coloums = $conClass->get_coloums_header($coloums_array);
            $grid_sql = $conClass->get_grid_sql($coloums, "  orders_package_work   
        inner join orders_package on (orders_package_work.package_id = orders_package.id) 
        LEFT OUTER JOIN orders on (orders.order_id = orders_package_work.order_id )    ");

            $query = $grid_sql . " where   orders_package_work.operation = '" . $_SESSION['user_type'] . "' $Ssql and orders.service_id = '2' and orders.order_status = '1' and  orders_package_work.status = '2' $con  order by orders_package_work.p_type,orders_package_work.scratche DESC   ";
             // echo $query;
            $data = $conClass->get_coloums_data($coloums, $query);

            // var_dump($data);
            $coloum_attribute = array();

            $row_attribute = array('id' => 'orders__id');


            $html_grid = $conClass->build_grid($coloums, $coloum_attribute, $data, $row_attribute, "search_result_" . $sear['res']);

            $no_search = 1;
            if ($_SESSION['user_type'] == "accounting") {
                if (isset($_GET['ajax'])) {
                    echo $html_grid;
                } else {
                    $newtemp->load_template('work_index', 4);
                }
            } else {
                if (isset($_GET['ajax'])) {
                    echo $html_grid;
                } else {
                    $newtemp->load_template('work_index', 13);
                }
            }
    

            break;

         
        case 'inventory':
            if (isset($_POST['get_stock'])) {

                // var_dump($_SESSION);
                // $o=object_to_array($_SESSION);
                // var_dump($o);
                // var_dump($_POST);
                //$Inventory = $db->get_table("inventory_items_color");
                //var_dump($_POST['item_id']);
                $logger->compareAndLogV2((int)$_POST['item_id']['0'], "Inventory", $_SESSION['user_id'], $_SESSION['name'], "Get from stock ", array(), $_POST);

                for ($j = 0; $j < count($_POST['item_id']); $j++) {
                    if ($_POST['item_id'][$j] != '' && $_POST['quantity'][$j] > 0) {

                        // echo count($_POST['item_id']);


                        $invetory_details['item_id'] = $_POST['item_id'][$j];
                        $invetory_details['quantity'] = $_POST['quantity'][$j];

                        $invetory_details['account_id'] = $_SESSION['user_id'];
                        $invetory_details['bill_id'] = "0";
                        $invetory_details['reason'] = "2";
                        $invetory_details['action_time'] = date("Y-m-d H:i:s");

                        $sql = $db->make_insert("inventory_action", $invetory_details);
                        // echo $sql;
                        $res = mysql_query($sql) or die(mysql_error());


                        $invClass->update_inventory($_POST['item_id'][$j], (-1 * $_POST['quantity'][$j]), "1");
                    }
                }

                header("Location: " . SITEURL . "/administrator/work.php?action=inventory&m=1");
            } else {
                $inv = $invClass->get_inventory_transaction("2", $_SESSION['user_id']);

                $itemData = $invClass->get_all_items();
                $newtemp->load_template('out_inventory', 13);
            }
            break;

        case 'deliver_order':
            if (isset($_POST['order_id'])) {
                $workClass->deliver_order($_POST['order_id']);
            }
            break;


        case 'cancel_package':
            if (isset($_POST['id'])) {
                $part =$db->get_table("orders_package_work  where package_id = '".$_POST['id']."'");

                if ($part[0]['status'] == "5") {
                    break;
                }

                $workClass->cancel_package($_POST['id'], $_SESSION['user_type']);
                
                // $query = mysql_query("select * from orders_package_work  where package_id = '" .$_POST['id'] . "' ") or die (mysql_error());
                // $o=object_to_array($query);
                //   echo'<pre>';
                //   print_r($part);
                //   echo'</pre>';
                // $logger->compareAndLogV2($package_id[$i],"ادخال الفرن", $_SESSION['user_id'],  $_SESSION['name'],$op[0]['statusname'],array(),$part[0]);

                ////// end log
                $logger->compareAndLogV2((int)$_POST['id'], "Order item", $_SESSION['user_id'], $_SESSION['name'], "كسر", array(), $part[0]);
            }
            break;

        case 'get_image':
            if (isset($_POST['id'])) {
                $res = $workClass->get_image($_POST['id']);

                if ($res == false) {
                    return false;
                } else {
                    insert_images_into_scren();
                }
            }
            break;

        case 'start_operation':
            if (isset($_POST['operation']) && isset($_POST['id'])) {

                //  echo "in";
                $package_id = explode(",", $_POST['id']);

                for ($i = 0; $i < count($package_id); $i++) {
                    //location log
                    $op= $db->get_table("status where id = '".$_POST['operation']."'");
                    $part =$db->get_table("orders_package where id = '".$package_id[$i]."'");
                    //   echo'<pre>';
                    //   print_r($part);
                    //   echo'</pre>';
                    $logger->compareAndLogV2($package_id[$i], "ادخال الفرن", $_SESSION['user_id'], $_SESSION['name'], $op[0]['statusname'], array(), $part[0]);

                    ////// end log
                    $query = mysql_query("update orders_package_work set user_id = '".$_SESSION['user_id']."' , in_work = '1'  where operation = '" . $_POST['operation'] . "'  and package_id = '" . $package_id[$i] . "'  ") or die(mysql_error());
                }
            }

            break;

        case 'out_order':
            if (isset($_POST['id'])) {
                $str = substr($_POST['id'], -1);
                if ($str == ",") {
                    $_POST['id'] = substr($_POST['id'], 0, strlen($_POST['id'] - 1));
                }

                $data = $workClass->get_outorder_package($_POST['id']);
                //need work

                $newtemp->load_template("out_order", 5);
            }
            break;


        case 'create_order':
            if (isset($_POST['acct_name2'])) {
                if ($_POST['out_order_id'] != '') {
                    header("Location: " . SITEURL . "/administrator/work.php?action=create_out_order&id=" . $_POST['out_order_id']); //echo "a";
                } else {
                    if (isset($_POST['acct_name2']) && $_POST['acct_name2'] != "") {
                        $res = $account->check_exist("account_name", $_POST['acct_name2']);
                        if (!$res) {
                            header("Location: " . formurl . "/work.php?action=create_order&e=2");
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

                    $account_id = $account->get_account_id_byname($accno);

                    $a = mysql_query("insert into out_orders (account_id,create_date) values('" . $account_id . "','" . date("Y-m-d H:i:s") . "');") or die(mysql_error());

                    $id = mysql_insert_id();

                    //echo $id;

                    header("Location: " . SITEURL . "/administrator/work.php?action=create_out_order&id=" . $id); //echo "a";
                }
            } else {
                $out_order = $workClass->get_out_orders("0", "0", $_SESSION['billing_code']);
                $allacc = $account->get_all_accounts(1);
                $breadarray[0]['url'] = "work.php?action=create_order";
                $breadarray[0]['name'] = "انشاء امر تسليم";
                $page_title = $lang[406];

                $newtemp->load_template("create_order", 13);
            }
            break;

        case 'create_out_order':
            if (isset($_GET['id'])) {
                $q = mysql_query("select * from out_orders where id = '" . $_GET['id'] . "' ") or die(mysql_error());
                $r = mysql_fetch_array($q);

                $big_out_order = "1";

                $acc = $account->get_account($r['account_id']);


                $r['items'] = ltrim($r['items'], ',');
                $str = substr($r['items'], -1);

                if ($str == ",") {
                    $r['items'] = substr($r['items'], 0, strlen($r['items'] - 1));
                }

                //   echo $r['items'];

                if ($r['items'] != '') {
                    $data = $workClass->get_outorder_package($r['items']);
                }
                //need work

                if (isset($_GET['print'])) {
                    $newtemp->load_template("out_order", 6);
                } else {
                    $newtemp->load_template("out_order", 13);
                }
            }
            break;

        case 'Print_out_order':
            break;


        case 'append_out_order':
            if (isset($_POST['id']) && isset($_POST['pid']) && isset($_POST['type'])) {
                $query = mysql_query("select * from out_orders where id = '" . $_POST['id'] . "' ") or die(mysql_error());

                $r = mysql_fetch_array($query);

                $item = explode(',', $r['items']);

                if (isset($item[0])) {
                    if ($_POST['type'] == "add") {
                        array_push($item, $_POST['pid']);
                    }
                    if ($_POST['type'] == "remove") {
                        //  array_diff($item,array($_POST['pid']));
                        // if (($key = array_search($_POST['pid'], $item)) !== false) {
                        //     unset($item[$key]);
                        // }
                        echo $_POST['pid'];
                        for ($i = 0; $i < count($item); $i++) {
                            if ($item[$i] == $_POST['pid']) {
                                unset($item[$i]);
                            }
                        }
                    }
                }


                $result = implode(',', $item);
                mysql_query("update out_orders set items = '" . $result . "' where  id = '" . $_POST['id'] . "' ");
            }
            break;

        case 'finish_out_order':

            if (isset($_POST['out_id'])) {
                $q = mysql_query("select * from out_orders where id='" . $_POST['out_id'] . "' ") or die(mysql_error());

                if (mysql_num_rows($q) > 0) {
                    $r = mysql_fetch_array($q);

                    $r['items'] = ltrim($r['items'], ',');
                    $str = substr($r['items'], -1);

                    if ($str == ",") {
                        $r['items'] = substr($r['items'], 0, strlen($r['items'] - 1));
                    }


                    $query = mysql_query("update orders_package_work set status = 3 , end_time = '" . date('Y-m-d H:i:s') . "' , out_work = '1' where operation = '5'  and package_id in (" . $r['items'] . ")  ") or die(mysql_error());

                    $query = mysql_query("update orders_package_work set status = 3 , start_time = '" . date('Y-m-d H:i:s') . "' , end_time = '" . date('Y-m-d H:i:s') . "', in_work = '1' , out_work = '1' where operation = '6'  and package_id in (" . $r['items'] . ")  ") or die(mysql_error());


                    mysql_query("update orders_package set package_status = '2' where id in (" . $r['items'] . ")  ") or die(mysql_error());


                    $pid = explode(',', $r['items']);
                    for ($i = 0; $i < count($pid); $i++) {
                        $order_id = $workClass->get_package_orderid($pid[$i]);
                        $workClass->check_finish($order_id);
                    }

                    $q = mysql_query("update out_orders set status= '1' , added_by = '".$_SESSION['user_id']."' ,  added_name = '".$_SESSION['name']."' , finishe_date = '" . date("Y-m-d H:i:s") . "'  where id='" . $_POST['out_id'] . "' ") or die(mysql_error());
                    //location log
                  
                    $logger->compareAndLogV2($order_id, "طلبية", $_SESSION['user_id'], $_SESSION['name'], 'تسليم', array(), array());
 
                    ////// end log

                    echo "تم الانتهاء من امر التسليم";
                }
            }

            break;

        case 'finish_operation':
            if (isset($_POST['operation']) && isset($_POST['id']) && isset($_POST['order_id'])) {
                echo "in  ";
                $package_id = explode(",", $_POST['id']);
               
                if (isset($_POST['all'])) {
                    $result=mysql_query("select Distinct package_id from orders_package_work 
                    inner join (SELECT order_id FROM orders where easy_order_id ='".$_POST['all']."' and order_status = '1' order by 
                    orders.order_date DESC limit 1 ) as o on orders_package_work.order_id = o.order_id") or die(mysql_error());
                    while ($row=mysql_fetch_row($result)) {
//                        var_dump($row);
                        $package_ids.=$row['0'].',';
                    }
//                    echo $package_id;
                    $package_id = explode(",", $package_ids);
                }
//
//

                for ($i = 0; $i < count($package_id); $i++) {
                    if ($_POST['operation'] == "4" || $_POST['operation'] == "5") {
                        $sql = ", out_work = '1' ";
                    } else {
                        $sql = "";
                    }

                    $query = mysql_query("update orders_package_work set user_id = '".$_SESSION['user_id']."' , status = 3 , end_time = '" . date('Y-m-d H:i:s') . "'  " . $sql . " where operation = '" . $_POST['operation'] . "'  and package_id = '" . $package_id[$i] . "'  ") or die(mysql_error());


                    
                    //location log
                    $op= $db->get_table("status where id = '".$_POST['operation']."'");
                    $part =$db->get_table("orders_package where id = '".$package_id[$i]."'");
                    //   echo'<pre>';
                    //   print_r($part);
                    //   echo'</pre>';
                    $logger->compareAndLogV2($package_id[$i], "عملية ترحيل", $_SESSION['user_id'], $_SESSION['name'], $op[0]['statusname'], array(), $part[0]);

                    ////// end log
                    if ($_POST['operation'] == '5') {
                        mysql_query("update orders_package set package_status = '2' where id = '" . $package_id[$i] . "'  ") or die(mysql_error());

                        if (isset($_POST['order_id']) && $_POST['order_id'] != "") {
                            $workClass->check_finish($_POST['order_id']);
                        } else {
                            $order_id = $workClass->get_package_orderid($package_id[$i]);
                            $workClass->check_finish($order_id);
                        }
                    } else {
                        echo "in 2";
                        $workClass->package_next_operation($package_id[$i]);
                    }

                    if ($_POST['operation'] == '3') {
                        if ($part[0]['glassPointing'] == 'ربع') {
                            $query = mysql_query("update orders_package_work set user_id = '".$_SESSION['user_id']."' , status = 3 , end_time = '" . date('Y-m-d H:i:s') . "'  " . $sql . " where operation = '7'  and package_id = '" . $package_id[$i] . "'  ") or die(mysql_error());
                        }
                    }
                    echo '</br>package_id => '.$package_id[$i] . 'operation => '.$_POST['operation'] .'</br>';
                }


                if ($_POST['operation']=='2') {
                    ///////// check all item in order are finsh /////////////
                    $query =mysql_query("select order_id from orders_package  where id = '" . $package_id[0] . "'  ") or die(mysql_error());


                    while ($row = mysql_fetch_assoc($query)) {
                        $order_id= $row["order_id"];
                    }


                    $result =mysql_query("select * FROM  `orders_package_work` WHERE order_id = '".$order_id."'  AND STATUS = '2' and operation ='2' ") or die(mysql_error());


                    $num_rows = mysql_num_rows($result);

                    ///////// if all finsh  update  order_work_status ///////////
                    if ($num_rows < 1) {
                        mysql_query("update orders set order_work_status = '".$_POST['operation'] ."' where order_id = '" . $order_id . "'  ") or die(mysql_error());
                    }

                    ///////// end check all item in order are finsh /////////////
                }




                echo $lang['price_list_result'];
            }
            break;


        case 'delivery':

            $console = new console(8);
            $console->set_allowtotal("0");
            $console->set_ND("Y");

            $coloums_array = array(array('headername' => '+', 'function' => 'show_row_option', 'pos' => 'last', 'width' => '100px', 'class' => 'nosort'));

            $coloums = $console->get_coloums_header($coloums_array, $dir, $field_name);


            //var_dump($coloums);

            $grid_sql = $console->get_grid_sql($coloums, "  orders
		inner join services on (orders.service_id = services.service_id) 
		inner join account on (orders.account_id = account.account_id) 
		left join users on (users.user_id = orders.user_id) 
		   ");
            $query = $grid_sql . " where  (orders.order_status = '2' || (orders.order_status = '3' and DATE(orders.actual_delivery_date) = '" . date("Y-m-d") . "' ) ) order by orders.order_id desc  ";


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


            $page_title = $lang[79];

            if ($_GET['ajax']) {
                $newtemp->load_template('admin_montior_console', 5);
            } else {
                $newtemp->load_template('admin_montior_console', 13);
            }

            break;


        case 'search':
            if (isset($_POST['barcode'])) {
                $res = $workClass->Search_with_Barcode($_POST['barcode'], $_SESSION['user_type']);

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


        case 'search_text':
            if (isset($_POST['barcode'])) {
                $item = explode("-", $_POST['barcode']);

                if (count($item) != 2) {
                    $arr['error'] = "Not Found";
                    echo "0";
                    return;
                } else {
                    $order_id = $item[0];
                    $pack_order = $item[1];
                }

                if (isset($_POST['type']) && $_POST['type'] == 'all') {
                    $all = "1";
                } else {
                    $all = "";
                }

                if ($_SESSION['user_type'] == '5' || $_SESSION['user_type'] == '6') {
                    $all = "1";
                }


                $res = $workClass->Search_with_Text($item[0], $item[1], $_SESSION['user_type'], $all);

                if ($res == "0") {
                    $arr['error'] = "Not Found";
                    echo "0";
                } else {
                    if (isset($_POST['account_id']) && $res['account_id'] != $_POST['account_id']) {
                        $arr['error'] = "هذة القطعة لعميل اخر ";
                        echo json_encode($arr);
                    } else {
                        echo json_encode($res);
                    }
                }
            } else {
                echo "0";
            }
            break;

            case 'get_pieces_details':
                if (isset($_POST['barcode'])) {
                    $item = explode("-", $_POST['barcode']);
    
                    if (count($item) != 2) {
                        $arr['error'] = "Not Found";
                        echo "0";
                        return;
                    } else {
                        $order_id = $item[0];
                        $pack_order = $item[1];
                    }
    
             
                    $res = $workClass->get_package($item[0], $item[1]);
    
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


        case 'pointing':
            {


                $newtemp->load_template('pointing', 13);

            }
            break;





        case 'search_text1':
            if (isset($_POST['barcode'])) {
                $item = explode("-", $_POST['barcode']);

                if (count($item) != 2) {
                    $arr['error'] = "Not Found";
                    echo "0";
                    return;
                } else {
                    $order_id = $item[0];
                    $pack_order = $item[1];
                }

                if (isset($_POST['type']) && $_POST['type'] == 'all') {
                    $all = "1";
                } else {
                    $all = "";
                }


                ///this for new process but its not good because we need to sort item
                if ($_SESSION['user_type'] == '7') {
                    $all = "";
                }

                $res = $workClass->Search_with_Text($item[0], $item[1], $_SESSION['user_type'], $all);

                if ($res == "0") {
                    $arr['error'] = "Not Found";
                    echo "0";
                } else {
                    if (isset($_POST['account_id']) && $res['account_id'] != $_POST['account_id']) {
                        $arr['error'] = "هذة القطعة لعميل اخر ";
                        echo json_encode($arr);
                    } else {
//                        $newtemp->load_template('build_table_for_pointing', 5);
                        echo build_table_for_pointing();
                    }
                }
            } else {
                echo "0";
            }
            break;
        case 'printer_option':


            if (isset($_POST['text_barcode'])) {
            } else {
                $newtemp->load_template('outside_print', 5);
            }


            break;
        case 'finish_order':
            {
                $newtemp->load_template('finish_order', 4);
            }
            break;
            case 'printer_order':
            if (isset($_POST['easy_order_id'])) {
                $order= $db->get_table("orders where order_status=1 and easy_order_id =".$_POST['easy_order_id'].'  ORDER BY `orders`.`order_id` DESC limit 1');
                if (isset($order[0]['order_id'])) {
                    $order_id=$order[0]['order_id'];
                    $orders_package_work= $db->get_table("orders_package where order_id =".$order_id);
                    // var_dump($order);
                    // var_dump($orders_package_work);
                    $list='';
                    foreach ($orders_package_work as $key => $value) {
                        $list.=$value['id'].",";
                    }
                    echo $list;
                } else {
                    echo'error';
                }
            } else {
                $newtemp->load_template('printer_order', 4);
            }

            break;

    }
} else {
    header("Location: " . SITEURL . "/administrator/login.php");
}
