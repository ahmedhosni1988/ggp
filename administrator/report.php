<?php
session_start();
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');
ini_set('max_input_vars', 10000);
ini_set('post_max_size', '-1');

include("../setting.php");
include("../" . STYLE . "/reporttemp.php");

include("../classes/driver.php");
include("../classes/account.php");
include("../classes/company.php");
include("../classes/console.php");
include("../classes/inventory.php");
include("../classes/Excel.php");
include("../classes/work.php");

include("../classes/package.php");


include '../packages/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';


$companyClass = new company($db);
$driverClass = new driver($db);
$accountClass = new account($db);
$newtemp = new template();
$invClass = new inventory($db);

$workClass = new work($db);
$package = new package($db);


if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}

if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == 1) {
    $open = "accounting";

    switch ($action) {


        case 'stock':

            if (isset($_POST['report'])) {
                $result = $invClass->get_inventory_stock(array());
                ///////////////////////////////////////////////////

                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);
                $rowCount = 2;

                $excel = new Excel($objPHPExcel);
                $excel->set_stock_header();

                for ($i = 0; $i < count($result); $i++) {
                    $column = 'A';
                    foreach ($result[$i] as $key => $value) {

                        //echo $column;

                        if ($value != "") {
                            $value = strip_tags($value);
                        } else {
                            $value = "";
                        }

                        //$value = iconv('UTF-8', 'ASCII', $value);
                        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $value);
                        $column++;
                    }

                    $rowCount++;
                }

                header("Content-Type: application/vnd.ms-excel; ");
                header("Content-Disposition: attachment; filename=\"Stock_" . date('Y-m-d H:i:s') . ".xls\"");
                header("Cache-Control: max-age=0");
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_clean();
                $objWriter->save("php://output");
            } else {
                $breadarray[0]['url'] = "";
                $breadarray[0]['name'] = 'تقرير الخام';
                $pack = $package->get_package();
                $page_title = $lang[934];
                $newtemp->load_template('stock_report', 4);
            }

            break;


        case 'operation':
            if (isset($_POST['report'])) {
                $result = $workClass->production_report($_POST);
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);
                $rowCount = 2;
                $excel = new Excel($objPHPExcel);
                $excel->set_operation_header();
                for ($i = 0; $i < count($result); $i++) {
                    $column = 'A';
                    foreach ($result[$i] as $key => $value) {

                        //echo $column;

                        if ($value != "") {
                            $value = strip_tags($value);
                        } else {
                            $value = "";
                        }

                        //$value = iconv('UTF-8', 'ASCII', $value);
                        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $value);
                        $column++;
                    }

                    $rowCount++;
                }

                header("Content-Type: application/vnd.ms-excel; ");
                header("Content-Disposition: attachment; filename=\"Stock_" . date('Y-m-d H:i:s') . ".xls\"");
                header("Cache-Control: max-age=0");
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_clean();
                $objWriter->save("php://output");
            } else {
                $pack = $package->get_package();

                $breadarray[0]['url'] = "";
                $breadarray[0]['name'] = 'تقرير الانتاج';
                $page_title = $lang[934];
                $newtemp->load_template('operation_report', 4);
            }

            break;


            case 'accounts_accounting':
            if ($_SESSION["billing_code"]==2) {
                // echo'test1';
                $acc = $accountClass->get_all_accounts(1, $_SESSION["billing_code"]);
            } else {
                // echo'test2';
                $acc = $accountClass->get_all_accounts(1);
            }

            if (isset($_POST['account_id'])) {
                // var_dump($_POST);
               

                $breadarray[0]['url'] = "report.php?action=accounts_accounting";
                $breadarray[0]['name'] = 'تقرير حساب عميل';
                $breadarray[1]['url'] = "";
                $page_title = $lang[934];
                $data= array();
                if ($_POST['account_id']==0) {
                    // echo'all';
                    $breadarray[1]['name'] = 'كل العملاء';
                    foreach ($acc as $key => $value) {
                        $allinvoises='SELECT sum(subtotal) AS total FROM `invoicehdr` WHERE `clid` = "'.$value['account_id'].'"';
                        $allCash='SELECT  sum(`pymt_amount`) AS total FROM `cashreceipts` WHERE `clid` = "'.$value['account_id'].'"';
                        $valallinvoises= $db->get_col($allinvoises);
                        $valallCash= $db->get_col($allCash);
                        if ($valallinvoises[0] || $valallCash[0]) {
                            $data[]=array("name"=>$value['account_company'] , 'allinvoises'=>$valallinvoises[0] ,'allCash'=>$valallCash[0] , 'sub'=>$valallinvoises[0]-$valallCash[0]);
                        }
                    }
                } else {
                    // echo'account';
                    $account_details = $accountClass->get_account($_POST['account_id']);
                    $account_details=object_to_array($account_details);
                    $breadarray[1]['name'] = $account_details['account_company'];
                    // echo $account_details['account_id'];
                    $allinvoises='SELECT sum(subtotal) AS total FROM `invoicehdr` WHERE `clid` = "'.$account_details['account_id'].'"';
                    $allCash='SELECT  sum(`pymt_amount`) AS total FROM `cashreceipts` WHERE `clid` = "'.$account_details['account_id'].'"';
                    $valallinvoises= $db->get_col($allinvoises);
                    $valallCash= $db->get_col($allCash);
                    $data[]=array("name"=>$account_details['account_company'] , 'allinvoises'=>$valallinvoises[0] ,'allCash'=>$valallCash[0] , 'sub'=>$valallinvoises[0]-$valallCash[0]);
                }
                //  echo '<pre>';
                //     var_dump($data);
                //     echo '</pre>';
                $newtemp->load_template('view_accounts_accounting', 4);
            // $_SESSION['account_accounting_id']=$_GET['account_id'];
                // $_SESSION['where']="paid='N' and clid=".$_GET['account_id'];
                // $_SESSION['where2']="paid='Y' and clid=".$_GET['account_id'];
                // $newtemp->load_template('view_account_accounting', 4);
            } else {
                $pack = $package->get_package();
                $breadarray[0]['url'] = "";
                $breadarray[0]['name'] = 'تقرير حساب عميل';
                $page_title = $lang[934];
              
                $newtemp->load_template('accounts_accounting', 4);
            }

            break;



            case 'account_accounting':

            if (isset($_GET['account_id'])) {
                $account_details = $accountClass->get_account($_GET['account_id']);
                $account_details=object_to_array($account_details);
 

                $breadarray[0]['url'] = "report.php?action=account_accounting";
                $breadarray[0]['name'] = 'تقرير فواتير و تحصيل عميل';
                $breadarray[1]['url'] = "";
                $breadarray[1]['name'] = $account_details['account_company'];
                $page_title = $lang[934];

                // $_SESSION['account_accounting_id']=$_GET['account_id'];
                // $_SESSION['where']="paid='N' and clid=".$_GET['account_id'];
                // $_SESSION['where2']="paid='Y' and clid=".$_GET['account_id'];
                $where=' 1=1 ';
                
                $where .= " and clid =".$_GET['account_id'].' ';
                
                $sql="cashreceiptslist where ".$where;
                // echo $sql;
                $cashreceiptsList=$db->get_table($sql);
                $invoicehdr_paid=$db->get_table(" invoicehdr where paid='Y' and clid=".$_GET['account_id']);
                $invoicehdr_Not_paid=$db->get_table(" invoicehdr where paid='N' and clid=".$_GET['account_id']);

                $newtemp->load_template('view_account_accounting', 4);
            } else {
                $pack = $package->get_package();
                $breadarray[0]['url'] = "";
                $breadarray[0]['name'] = 'تقرير حساب عميل';
                $page_title = $lang[934];

                if ($_SESSION["billing_code"]==2) {
                    // echo'test1';
                    $acc = $accountClass->get_all_accounts(1, $_SESSION["billing_code"]);
                } else {
                    // echo'test2';
                    $acc = $accountClass->get_all_accounts(1);
                }
                $newtemp->load_template('account_accounting', 4);
            }

            break;



        case 'scratch':

            if (isset($_POST['report'])) {
                $result = $workClass->scratche_report($_POST);
                //$newtemp->load_template('scratch_results',4);

                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);
                $rowCount = 2;

                $excel = new Excel($objPHPExcel);
                $excel->set_scratch_header();


                for ($i = 0; $i < count($result); $i++) {
                    $column = 'A';
                    foreach ($result[$i] as $key => $value) {

                        //echo $column;

                        if ($value != "") {
                            $value = strip_tags($value);
                        } else {
                            $value = "";
                        }

                        //$value = iconv('UTF-8', 'ASCII', $value);
                        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $value);
                        $column++;
                    }

                    $rowCount++;
                }

                header("Content-Type: application/vnd.ms-excel; ");
                header("Content-Disposition: attachment; filename=\"Scratch_" . date('Y-m-d H:i:s') . ".xls\"");
                header("Cache-Control: max-age=0");
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_clean();
                $objWriter->save("php://output");
            } else {
                $pack = $package->get_package();
                $breadarray[0]['url'] = "";
                $breadarray[0]['name'] = 'تقرير الهالك';
                $page_title = $lang[934];
                $newtemp->load_template('scratch_report', 4);
            }

            break;

            
        case 'salesReport':

            if (isset($_POST['report'])) {
                $result = $workClass->salesReport($_POST);
                //$newtemp->load_template('scratch_results',4);

                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);
                $rowCount = 2;

                $excel = new Excel($objPHPExcel);
                $excel->set_salesreport_header();


                for ($i = 0; $i < count($result); $i++) {
                    $column = 'A';
                    foreach ($result[$i] as $key => $value) {

                        //echo $column;

                        if ($value != "") {
                            $value = strip_tags($value);
                        } else {
                            $value = "";
                        }

                        //$value = iconv('UTF-8', 'ASCII', $value);
                        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $value);
                        $column++;
                    }

                    $rowCount++;
                }

                header("Content-Type: application/vnd.ms-excel; ");
                header("Content-Disposition: attachment; filename=\"salesReport_" . date('Y-m-d H:i:s') . ".xls\"");
                header("Cache-Control: max-age=0");
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_clean();
                $objWriter->save("php://output");
            } else {
                $pack = $package->get_package();
                $breadarray[0]['url'] = "";
                $breadarray[0]['name'] = 'تقرير المبيعات';
                $page_title = $lang[934];
                $newtemp->load_template('salesReport', 4);
            }

            break;



            
            case 'salesReportDetails':

                if (isset($_POST['report'])) {
                    $result = $workClass->salesReportDetails($_POST);
                    //$newtemp->load_template('scratch_results',4);
    
                    $objPHPExcel = new PHPExcel();
                    $objPHPExcel->setActiveSheetIndex(0);
                    $rowCount = 2;
    
                    $excel = new Excel($objPHPExcel);
                    $excel->set_salesreportdetails_header();
    
    
                    for ($i = 0; $i < count($result); $i++) {
                        $column = 'A';
                        foreach ($result[$i] as $key => $value) {
    
                            //echo $column;
    
                            if ($value != "") {
                                $value = strip_tags($value);
                            } else {
                                $value = "";
                            }
    
                            //$value = iconv('UTF-8', 'ASCII', $value);
                            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $value);
                            $column++;
                        }
    
                        $rowCount++;
                    }
    
                    header("Content-Type: application/vnd.ms-excel; ");
                    header("Content-Disposition: attachment; filename=\"salesReportDetails_" . date('Y-m-d H:i:s') . ".xls\"");
                    header("Cache-Control: max-age=0");
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    ob_clean();
                    $objWriter->save("php://output");
                } else {
                    $pack = $package->get_package();
                    $breadarray[0]['url'] = "";
                    $breadarray[0]['name'] = 'تقرير المبيعات';
                    $page_title = $lang[934];
                    $newtemp->load_template('salesReportDetails', 4);
                }
    
                break;

        case 'accounting':

            if (isset($_POST['report'])) {
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);
                $rowCount = 2;

                $excel = new Excel($objPHPExcel);
                $excel->set_operation_header();


                header("Content-Type: application/vnd.ms-excel; ");
                header("Content-Disposition: attachment; filename=\"Stock_" . date('Y-m-d H:i:s') . ".xls\"");
                header("Cache-Control: max-age=0");
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_clean();
                $objWriter->save("php://output");
            } else {
                $breadarray[0]['url'] = "";
                $breadarray[0]['name'] = 'تقرير الحسابات';
                $page_title = $lang[934];
                $newtemp->load_template('accounting_report', 4);
            }

            break;


    }
}


//******************************************************************************
// If we are comimg back with a completed search form,                         *
// (i)  check the form for mandatory criteria                                  *
// (ii) if ok, put the criteria variables in the URL, & go to adminstatus.php  *
//******************************************************************************
// ****************************************
// Display error message                  *
// ****************************************
function valerr($msg)
{
    global $subflag;
    global $errmsg;
    $subflag = "";               // Fool form into thinking it was never submitted
    //echo "<font color=green><b>$msg</b></font><br>\r\n";
    $errmsg = $msg;
}

function cleanData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) {
        $str = '"' . str_replace('"', '""', $str) . '"';
    }
}
