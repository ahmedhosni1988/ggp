<?php
session_start();
include("../../setting.php");
include("../../classes/console.php");
include("../../classes/work.php");

include("naccountingtemp.php");


$workClass = new work($db);



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



if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == 1 && $_SESSION['status'] == 2) {
    switch ($action) {

        case 'orders':
            $console = new console(8);
            $console->set_allowtotal("0");
            $console->set_ND("Y");
            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }
            $console->set_page($pageno, PERPAGE);
            
           // $coloums_array = array(array('headername' => '+', 'function' => 'show_row_option', 'pos' => 'last', 'width' => '100px', 'class' => 'nosort'));

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
            $query = $grid_sql . " where  ".(isset($_GET['search']) ? $console->build_grid_search($coloums, $_GET['search_txt']) : '')."  orders.order_status in (0,1,2) $inputbillingsql  ".(isset($_POST['dir']) ? "order by  ".$table_name.".".$field_name." ".$dir."" : "order by orders.order_id desc ");


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

            $page_title = "الحسابات";

            if ($_GET['ajax']) {
                echo $html_grid;
            } else {
                $newtempAll->load_template('accounting_console', 1, 'accounting_menu');
            }


        break;


        
    case 'show_outorder':
        $res = $workClass->get_out_orders('0', '1',$_SESSION['billing_code']);
        $newtempAll->load_template('out_order_view',  1, 'accounting_menu');
        break;


    case 'finish_out_order_all':
        if (isset($_POST['out_id'])) {
            $q = mysql_query("update out_orders set status= '2' , finished = '1'   where id='" . $_POST['out_id'] . "' ") or die (mysql_error());


            echo "تم الانتهاء من امر التسليم";
        }

        break;


        case 'accounts':
            $console = new console(10);
            $console->set_allowtotal("0");
            $console->set_ND("Y");
            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }
            $console->set_page($pageno, PERPAGE);
            
           // $coloums_array = array(array('headername' => '+', 'function' => 'show_row_option', 'pos' => 'last', 'width' => '100px', 'class' => 'nosort'));

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
            $query = $grid_sql . " where  ".(isset($_GET['search']) ? $console->build_grid_search($coloums, $_GET['search_txt']) : '')." 1=1   $inputbillingsql  ".(isset($_POST['dir']) ? "order by  ".$table_name.".".$field_name." ".$dir."" : "order by account.account_id desc ");


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

            $breadarray[0]['url'] = "manger.php?action=orders";
            $breadarray[0]['name'] = $lang[24];

            $breadarray[1]['url'] = "";
            $breadarray[1]['name'] = "كل الطلبيات";

            $page_title = "الحسابات";

            if ($_GET['ajax']) {
                echo $html_grid;
            } else {
                $newtempAll->load_template('accounting_console', 1, 'accounting_menu');
            }


        break;

            
        default:


        $newtempAll->load_template('main_accounting', 1, 'accounting_menu');

        break;
    }
}
