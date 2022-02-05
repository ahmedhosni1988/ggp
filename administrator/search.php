<?php
session_start();
include("../setting.php");
include("../" . STYLE . "/searchtemp.php");
include("../" . STYLE . "/consoletemp.php");
include("../" . STYLE . "/worktemp.php");

include("../classes/payment.php");
include("../classes/orders.php");
include("../classes/account.php");
include("../classes/services.php");
include("../classes/price.php");
include("../classes/driver.php");
include("../classes/company.php");
include("../classes/work.php");

include('../classes/Mobile_Detect.php');
$detect = new Mobile_Detect();

$newtemp = new template();
$account = new account($db);
$services = new services($db);
$payment = new payment($db);
$order = new orders($db);
$price = new price($db);
$driverClass = new driver($db);
$companyClass = new company($db);

$workClass = new work($db);


if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}

if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == 1 && $_SESSION['status'] == 2) {

    switch ($action) {

        case 'search_item':

if(!empty($_POST['length']) && !empty($_POST['width']) ){

   // echo "welcome to my page";

    $items_details = $order->search_items($_POST['account_acctname'],$_POST['width'],$_POST['length']);
    //var_dump($items_details);

    if (isset($_POST['style']) && $_POST['style'] == "operation")  $newtemp->load_template('search_item_result',13);
    else $newtemp->load_template('search_item_result',4);

}else{
	$allacc = $account->get_all_accounts(1);

    if (isset($_GET['style']) && $_GET['style'] == "operation")  $newtemp->load_template('search_item',13);
    else $newtemp->load_template('search_item',4);

}
break;

        case 'mangesearch':

            $breadarray[0]['url'] = "";
            $breadarray[0]['name'] = $lang[54];




//case 'search':
$services = $services->get_services();
$pay = $payment->get_payment();
$allacc = $account->get_all_accounts(1,$_SESSION['billing_code']);
$status = $_SESSION['status_table'];

            $page_title = $lang[54];
            if (isset($_GET['style']) && $_GET['style'] == "operation") $newtemp->load_template('mange_search', 13);
            else $newtemp->load_template('mange_search', 4);
            break;

            case 'searchDeliveries':
                if(!empty($_POST['numOfDeliver'] ) ||  !empty($_POST['numOfOrders']))
                    {

                        $res = $workClass->search_out_orders($_POST['numOfDeliver'],$_POST['numOfOrders'],$_SESSION['billing_code']);
                     //   var_dump($res);
                      if ($_SESSION['user_type'] == 'accounting' || $_SESSION['user_type'] == 'smallaccounting' )  $newtemp->load_template('out_order_view', 4);
                      else $newtemp->load_template('out_order_view', 4);
                   
                    }else{
                
                      if ($_SESSION['user_type'] == 'accounting' || $_SESSION['user_type'] == 'smallaccounting' )  $newtemp->load_template('searchDeliveries',4);
                      else $newtemp->load_template('searchDeliveries',4);
                    }
            break;

        case 'search':
            $billing_code = $companyClass->get_billing_code() ;
            $services = $services->get_services();
            $pay = $payment->get_payment();
            $allacc = $account->get_all_accounts(1,$_SESSION['billing_code']);
            $status = $_SESSION['status_table'];


            $page_title = $lang[54];
            $newtemp->load_template('admin_search', 5);
            break;


        case 'search_ajax':
            if (isset($_POST['x'])) {
                $sr = unserialize($_POST['search_query']);
                $data = $sr;
                $search_result = $order->get_search($data);
                $filename = "search_export_" . time() . ".xls";
                function xlsBOF()
                {
                    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
                }

                function xlsEOF()
                {
                    echo pack("ss", 0x0A, 0x00);
                }

                function xlsWriteNumber($Row, $Col, $Value)
                {
                    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
                    echo pack("d", $Value);
                }

                function xlsWriteLabel($Row, $Col, $Value)
                {
                    $L = strlen($Value);
                    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
                    echo $Value;
                }

// prepare headers information
                header("Content-Type: application/force-download");
                header("Content-Type: application/octet-stream");
                header("Content-Type: application/download");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                header("Content-Transfer-Encoding: binary");
                header("Pragma: no-cache");
                header("Expires: 0");
// start exporting
                xlsBOF();


                $c = 0;


                foreach ($search_result[0] as $key => $value) {
                    xlsWriteLabel($i, $c, $key);
                    $c++;
                }

                $r = 1;
                for ($i = 0; $i < count($search_result); $i++) {
                    $key_array = array();

                    $c = 0;
                    foreach ($search_result[$i] as $key => $value) {
                        xlsWriteLabel($r, $c, $value);
                        $c++;
                    }
                    $r++;
                }

                xlsEOF();


            } else {

                if (isset($_GET['acct_name2']) && $_GET['acct_name2'] != "") {
                    $res = $account->check_exist("account_name", $_GET['acct_name2']);
                    if (!$res) {
                        $arr['no_result'] = "Error in Account No.";
                        echo json_encode($arr);
                        return;

                    }
                }

                if ($_GET['acct_name2'] != "") {
                    $accno = $account->get_account_id_byname($_GET['acct_name2']);
                } else if ($_GET['account_acctno'] != '') {
                    $accno = $_GET['account_acctno'];
                } else if ($_GET['account_acctname'] != '') {
                    $accno = $_GET['account_acctname'];
                } else {
                    $accno = "";
                }

                $_GET['account_id'] = $accno;

//var_dump($_GET);
                $search_result = $order->get_search($_GET, "1");
//print_r($search_result);

                if (isset($search_result['no_result'])) {

                    echo json_encode($search_result);
                } else {
                    $search = "1";
                    $newtemp->load_template('admin_search_result', 5);

                }

            }


            break;


            case 'deficiencies': 

                                
                    if( !empty($_POST['from_date']) ){

                        // echo "welcome to my page";
                    
                       // $items_details = $order->search_items($_POST['account_acctname'],$_POST['width'],$_POST['length']);
                        //var_dump($items_details);

                    $order_package_details = $workClass->get_uncompleted_order_package_details($_POST['from_date'],$_POST['to_date'],$_POST['account_acctname'],$_POST['package_type'],$_POST);


                     //$newtemp->load_template('deficiencies_results',4);
                     

                     if($_SESSION['user_type'] == 'administrator'  || $_SESSION['user_type'] ==  'manmanger' || $_SESSION['user_type'] ==  'addmanger' ){

                        $newtemp->load_template('deficiencies_results',4);
                    }elseif ($_SESSION['user_type'] == 'administrator' && isset($_POST['excel']) ){

                        $result = $order_package_details;
                        
                        $objPHPExcel = new PHPExcel();
                        $objPHPExcel->setActiveSheetIndex(0);
                        $rowCount = 2;
                        $excel = new Excel($objPHPExcel);
                        $excel->set_operation_header();
                        for ($i = 0; $i < count($result); $i++) {
        
                            $column = 'A';
                            foreach ($result[$i] as $key => $value) {
        
                                //echo $column;
        
                                if ($value != "")
                                    $value = strip_tags($value);
                                else
                                    $value = "";
        
                                //$value = iconv('UTF-8', 'ASCII', $value);
                                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $value);
                                $column++;
                            }
        
                            $rowCount++;
                        }
        
                        header("Content-Type: application/vnd.ms-excel; ");
                        header("Content-Disposition: attachment; filename=\"Late_Delivery_" . date('Y-m-d H:i:s') . ".xls\"");
                        header("Cache-Control: max-age=0");
                        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                        ob_clean();
                        $objWriter->save("php://output");


                    }else{
                        $newtemp->load_template('deficiencies_results',13);

                    }
                


                    
                    }else{
                        $allacc = $account->get_all_accounts(1,$_SESSION['billing_code']);
                    
                        if($_SESSION['user_type'] == 'administrator'  || $_SESSION['user_type'] ==  'manmanger' || $_SESSION['user_type'] ==  'addmanger' ){
                            $newtemp->load_template('deficiencies',4);

                        }else{
                            $newtemp->load_template('deficiencies',13);

                        }
                    
                    }

            break;
    }

} else {
    $page_title = $lang[102];
    $newtemp->load_template('login_admin', 5);
}

?>