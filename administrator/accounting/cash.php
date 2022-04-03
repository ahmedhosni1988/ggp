<?php
session_start();
include("../../setting.php");
include("naccountingtemp.php");

include("../../classes/account.php");

$accountClass = new account($db);



if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}



if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == 1 && $_SESSION['status'] == 2) {
    switch ($action) {


        case 'view_cashreceipts':
            $where = " 1 = 1 ";
            
            if (isset($_SESSION["billing_code"]) && $_SESSION["billing_code"] > "0") {
                $where .= " and billing_code = '".$_SESSION["billing_code"] ."'  ";
            }
            
            if ($_SESSION["account_accounting_id"]) {
                $where .= " and clid =".$_SESSION["account_accounting_id"].' ';
            }
            $sql="cashreceiptslist where ".$where;
            // echo $sql;
            $acc =$db->get_table($sql);
                 
                // if($_SESSION["billing_code"] == 2 ){
                // 	// echo'test1';
                // 	$acc = $account->get_all_accounts(1,$_SESSION["billing_code"]);
            
                // }else{
                // 	// echo'test2';
                // 	$acc = $account->get_all_accounts(1);
                // }
                $payment_type = $account->payment_type();
                $newtemp->load_template('view_cashreceipts', 5);
            
            break;
            
            case 'cash':
            
                $acc = $account->get_all_accounts(1, $_SESSION["billing_code"]);
            
                    $payment_type = $account->payment_type();
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $data=$_POST;
                    if (isset($_POST['cash_id']) && $_POST['cash_id']!='') {
                        $sql='`cashreceipts`  WHERE `id` ='.$_POST['cash_id'];
                        $oldCash= $db->get_table($sql);
                            
                        if ($oldCash[0]['pymt_amount'] > $_POST['pymt_amount']) {
                            mysqli_query($mycon,'UPDATE `account` SET `credit_hold` = credit_hold-'.($oldCash[0]['pymt_amount']-$_POST['pymt_amount']).' WHERE `account_id` ='.$_POST['clid']);
                        // echo 'الجديد اصغر';
                        } elseif ($oldCash[0]['pymt_amount'] < $_POST['pymt_amount']) {
                            mysqli_query($mycon,'UPDATE `account` SET `credit_hold` = credit_hold+'.($_POST['pymt_amount']-$oldCash[0]['pymt_amount']).' WHERE `account_id` ='.$_POST['clid']);
                            // echo 'الجديد اكبر';
                        }
                        unset($data['cash_id']);
            
                        $data['system_date'] = date('Y-m-d H:i:s');
                        // var_dump($data);
                        $s=$db->make_update("cashreceipts", $data, 'id', $_POST['cash_id']);
                        //  echo$s;
                        mysqli_query($mycon,$s);
                        echo 'تمت التعديل بنجاح';
                    } else {
                        $newtemp->load_template('cash', 5);
                    }
                } else {
                    $newtemp->load_template('cash', 5);
                }
            break;
            

            
            
            case 'cashreceipts_print':
            
                if (isset($_POST['id'])) {
                    $re = mysqli_query($mycon,'select cashreceipts.*,account.account_company,payment_type.payment_name from `cashreceipts`  
                    inner join account on (cashreceipts.clid = account.account_id)
                    inner join payment_type on (payment_type.payment_id = cashreceipts.paymethod)
                    WHERE  cashreceipts.id ='.$_POST['id'].' ORDER BY id DESC LIMIT 1 ')  or die(mysqli_error($mycon));
                    
                    $data =  mysqli_fetch_array($re);
                    
            
                    $temp = template_cashrecipt_print();
                    echo $temp;
                //echo json_encode($res);
                } else {
                    echo 'Error';
                }
            break;

            default:
            
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['clid'] =='' ||  $_POST['pymt_amount'] =='')) {
                    echo 'ادخل كل البيانات';
                } elseif (isset($_POST['clid']) && $_POST['clid'] !=='') {
                    if (is_numeric($_POST['pymt_amount'])) {
                        $_POST['system_date']=date("Y-m-d H:i:s");
                        $_POST['user_id']=$_SESSION['user_id'];
                        $_POST['ppd']='N';
                        //$_POST['serialno'] =
            
                        $_POST['date'] = date('Y-m-d H:i:s');
                        $sql = $db->make_insert("cashreceipts", $_POST);
                        // echo $sql;
                        mysqli_query($mycon,$sql);
                        mysqli_query($mycon,'UPDATE `account` SET `credit_hold` = credit_hold+'.$_POST['pymt_amount'].' WHERE `account_id` ='.$_POST['clid'].' ');
                
                        $re = mysqli_query($mycon,'select cashreceipts.*,account.account_company,payment_type.payment_name from `cashreceipts`  
                    inner join account on (cashreceipts.clid = account.account_id)
                    inner join payment_type on (payment_type.payment_id = cashreceipts.paymethod)
                    WHERE account.account_id = '.$_POST['clid'].' and cashreceipts.`clid` ='.$_POST['clid'].' ORDER BY id DESC LIMIT 1 ')  or die(mysqli_error($mycon));
                        $data =  mysqli_fetch_array($re);
                    
            
                        $temp = template_cashrecipt_print();
                        echo $temp;
                    //echo json_encode($res);
                    } else {
                        echo 'مبلغ الوصل غير صحيح';
                    }
                } else {
                    //   $acc = $accountClass->get_all_accounts(1, $_SESSION["billing_code"]);
            
                 
                    $payment_type = $accountClass->payment_type();
                    $newtempAll->load_template('cashreceipts', 1, 'accounting_menu');
                }
            break;

            
    }
}
