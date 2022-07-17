<?php
session_start();
include("../setting.php");
include("../" . STYLE . "/worktemp.php");
include("../" . STYLE . "/inventorytemp.php");
include("../" . STYLE . "/consoletemp.php");

include("../classes/console.php");
include("../classes/work.php");
include("../classes/inventory.php");

include("../classes/reason.php");

$reason = new reason($db);
$newtemp = new template();
$workClass = new work($db);

$invClass = new inventory($db);


if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}


if ($login['user_type'] != 'administrator' && !empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == true && $_SESSION['status'] == 2) {
    // echo "ahmed";
    $allreason=$reason->get_all_reason();

    switch ($action) {

        default:


            $conClass = new console(3, $db);
            $conClass->set_page($pageno, PERPAGE);

            //  $coloums_array = array(  array('headername'=>'+','function'=>'show_report_option','pos'=>'last') );


            $coloums_array = array(array('headername' => '+', 'function' => 'show_row_option_manger', 'pos' => 'last', 'width' => '130px', 'class' => 'nosort'));


            //  $coloums = $conClass->get_coloums_header($coloums_array,$dir,$field_name);


            $coloums = $conClass->get_coloums_header($coloums_array);
            $grid_sql = $conClass->get_grid_sql($coloums, " orders_scratch
        inner join orders_package on (orders_scratch.package_id = orders_package.id) 
        inner join orders_package_work on (orders_package_work.package_id = orders_scratch.package_id && orders_scratch.operation_id = orders_package_work.operation )
        inner JOIN orders on (orders.order_id = orders_package_work.order_id )    ");

            $query = $grid_sql . " where orders_scratch.status = '0'  order by orders_package_work.p_type,orders_package_work.scratche DESC  ";
            //  echo $query;
            $data = $conClass->get_coloums_data($coloums, $query);

            // var_dump($data);
            $coloum_attribute = array();

            $row_attribute = array('id' => 'orders__id');


            $html_grid = $conClass->build_grid($coloums, $coloum_attribute, $data, $row_attribute, "search_result_" . $sear['res']);

            if ($_SESSION['user_type'] == 'manmanger') {
                if ($_GET['ajax']) {
                    $html_grid;
                } else {
                    $newtemp->load_template('work_index', 4);
                }
            } else {
                if ($_GET['ajax']) {
                    $html_grid;
                } else {
                    $newtemp->load_template('work_index', 13);
                }
            }


            break;


        case 'orders':


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
            $console->set_page($pageno, PERPAGE);

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
            $query = $grid_sql . " where  orders.order_status in (1,2)   order by orders.order_id desc ";


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
                echo $html_grid;
//                $newtemp->load_template('admin_montior_console', 5);
            } else {
                $newtemp->load_template('admin_montior_console', 13);
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
            $console->set_page($pageno, PERPAGE);

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

            $query = $grid_sql . " where  orders.order_status in (1) and orders.delivery_date <= '" . date("Y-m-d") . "'   order by orders.order_id desc ";


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
                echo $html_grid;
            // $newtemp->load_template('admin_montior_console', 5);
            } else {
                $newtemp->load_template('admin_montior_console', 13);
            }

            break;


        case 'view':


            $conClass = new console(2, $db);
            // $coloums_array = array(array('headername'=>'+','function'=>'show_row_option_manger','pos'=>'last','width'=>'130px','class'=>'nosort') );
            $conClass->set_page($pageno, PERPAGE);


            $coloums = $conClass->get_coloums_header($coloums_array);
            // $grid_sql = $conClass->get_grid_sql($coloums," orders_package_work
            // inner join orders_package on (orders_package_work.package_id = orders_package.id)
            // LEFT OUTER JOIN orders on (orders.order_id = orders_package_work.order_id )    ") ;


            $grid_sql = $conClass->get_grid_sql($coloums, " orders_package_work
        inner join orders_package on (orders_package_work.package_id = orders_package.id) 
        LEFT OUTER JOIN orders on (orders.order_id = orders_package_work.order_id )    ");


            $query = $grid_sql . "  where orders.order_status = '1'    group by orders_package.id  ";
            //  echo $query;
            $data = $conClass->get_coloums_data($coloums, $query);

            // var_dump($data);
            $coloum_attribute = array();

            $row_attribute = array('id' => 'orders__id');
            $html_grid = $conClass->build_grid($coloums, $coloum_attribute, $data, $row_attribute, "search_result_" . $sear['res']);

            if ($_GET['ajax']) {
                echo $html_grid;
            } else {
                $newtemp->load_template('work_index', 13);
            }
            break;

        case 'make_Scratche':
            if ($_POST['id']) {
                $q = mysqli_query($mycon, "select orders_scratch.*,status.statusname from orders_scratch inner join status on(status.id=orders_scratch.operation_id) where  orders_scratch.package_id = '" . $_POST['id'] . "' order by id desc  limit 1 ");

                $data = mysqli_fetch_assoc($q);

                $newtemp->load_template('scratche_form', 5);
            }
            break;

        case 'set_Scratche':
            if ($_POST['id']) {
                $q = mysqli_query($mycon, "update orders_scratch set perosn = '" . mysqli_real_escape_string($mycon, $_POST['perosn']) . "' ,
             reason	= '" . mysqli_real_escape_string($mycon, $_POST['reason']) . "' , date_work = '" . date("Y-m-d H:i:s") . "'	,applied_operation = '" . $_POST['applied_operation'] . "' ,status = '1' where id = '" . $_POST['id'] . "' and status = '0'  order by id desc  limit 1   ") or die(mysqli_error($mycon));


                $query = mysqli_query($mycon, "delete from orders_package_work where package_id = '" . $_POST['package_id'] . "' ");


                $workClass->add_operation_package($_POST['package_id'], "1", "1", "1");
                $logger->compareAndLogV2((int) $_POST['package_id'], "Order item", $_SESSION['user_id'], $_SESSION['name'], "Start Scratch ", array(), $_POST);

                // $workClass->package_next_operation($_POST['package_id']);
            }
            break;

        case 'inventory':
            if (isset($_POST['get_stock'])) {

                // var_dump($_SESSION);


                for ($j = 0; $j < count($_POST['item_id']); $j++) {
                    if ($_POST['item_id'][$j] != '' && $_POST['quantity'][$j] > 0) {

                        // echo count($_POST['item_id']);


                        $invetory_details['item_id'] = $_POST['item_id'][$j];
                        $invetory_details['quantity'] = $_POST['quantity'][$j];

                        $invetory_details['account_id'] = $_SESSION['user_id'];
                        $invetory_details['bill_id'] = "0";
                        $invetory_details['reason'] = "2";
                        $invetory_details['action_time'] = date("Y-m-d H:i:s");

                        $sql = make_insert("inventory_action", $invetory_details);
                        // echo $sql;
                        $res = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));


                        $invClass->update_inventory($_POST['item_id'][$j], (-1 * $_POST['quantity'][$j]), "1");
                    }
                }

                header("Location: " . SITEURL . "/administrator/work.php?action=inventory&m=1");
            } else {
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
                $workClass->cancel_package($_POST['id'], $_SESSION['user_type']);
                $query = mysqli_query($mycon, "select * orders_package_work  where package_id = '" .$_POST['id'] . "' ") or die(mysqli_error($mycon));
                $o=object_to_array($query);
                $logger->compareAndLogV2((int)$_POST['id'], "Order item", $_SESSION['user_id'], $_SESSION['name'], "scratch", array(), $o);
            }
            break;

        case 'get_image':
            if (isset($_POST['id'])) {
                $res = $workClass->get_image($_POST['id']);
                if ($res == false) {
                    return false;
                } else {
                    for ($i = 0; $i < count($res); $i++) {
                        $x .= '<a href="' . SITEURL . '/' . $res[$i]['image_url'] . '" data-fancybox="group" data-caption="طلبية رقم : ' . $res[$i]['order_id'] . '" >
                    <img src="' . SITEURL . '/' . $res[$i]['image_url'] . '" style="width:300px;" alt="" />
                </a>';
                    }

                    echo $x;
                };
            }
            break;

        case 'finish_operation':
            if (isset($_POST['operation']) && isset($_POST['id']) && isset($_POST['order_id'])) {

                //  echo "in";
                $package_id = explode(",", $_POST['id']);

                for ($i = 0; $i < count($package_id); $i++) {
                    $query = mysqli_query($mycon, "update orders_package_work set user_id = '".$_SESSION['user_id']."' , status = 3 , end_time = '" . date('Y-m-d H:i:s') . "' where operation = '" . $_POST['operation'] . "'  and package_id = '" . $package_id[$i] . "'  ") or die(mysqli_error($mycon));

                    if ($_POST['operation'] == '5') {
                        mysqli_query($mycon, "update orders_package set package_status = '2' where id = '" . $package_id[$i] . "'  ") or die(mysqli_error($mycon));

                        if (isset($_POST['order_id']) && $_POST['order_id'] != "") {
                            $workClass->check_finish($_POST['order_id']);
                        } else {
                            $order_id = $workClass->get_package_orderid($package_id[$i]);
                            $workClass->check_finish($order_id);
                        }
                    } else {

                        //   echo "in 2";
                        $workClass->package_next_operation($package_id[$i]);
                    }
                }
            }
            break;


        case 'delivery':

            $console = new console(8, $db);
            $console->set_page($pageno, PERPAGE);

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
                echo $html_grid;
            // $newtemp->load_template('admin_montior_console', 5);
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

    }
} else {
    header("Location: " . SITEURL . "/administrator/login.php");
}
