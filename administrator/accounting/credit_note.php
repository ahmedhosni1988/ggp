<?php
session_start();
include ("../../setting.php");
include ("../../classes/account.php");
include ("../../classes/address.php");
include ("../../classes/console.php");
include ("../../classes/invoices.php");

include("../../".STYLE."/credittemp.php");
include ("../../classes/work.php");

$workClass = new work($db);

$newtemp = new template();

$accountClass = new account($db);
$address = new address($db);


$invoices = new invoices($db);

if ( !empty($_GET["action"]) ){
$action = $_GET["action"];
}else{
$action = "";
}


if (!empty($_SESSION['logged_in'] ) && !empty($_SESSION['user_type'] ) && $_SESSION['logged_in'] == 1  &&  $_SESSION['status'] == 2  ){
	$open = "setup";
	
switch ($action){

    case 'manage':

        $breadarray[0]['url'] = "#";
        $breadarray[0]['name'] = "الاشعارات";
        $page_title = $lang[406];
        $newtemp->load_template('mange_credit',1, 'accounting_menu');

    break;


    case 'view':

        $credit_note = $workClass->get_Credit(array());
        $newtemp->load_template('show_credit',5);
    break;


    case 'add_edit':

        if(isset($_POST['id'])){

            $dbarray['account_id'] = $_POST['account_id'];
            $dbarray['invoice_id'] = $_POST['invoice_id'];
            $dbarray['order_id'] = $_POST['order_id'];
            $dbarray['credit_value'] = (int)$_POST['credit_value'];
            $dbarray['note'] = $_POST['note'];
            $dbarray['credit_type'] = $_POST['credit_type'];


            $check = $workClass->check_accountinvoice($_POST['account_id'],$_POST['invoice_id']);

            if(!$check  && $_POST['credit_type'] != '3'){

                echo 'This invoice not belong to this account';
                return;
            }

            if($_POST['id'] == ""){

                $dbarray['user_id'] = $_SESSION['user_id'];
                $dbarray['date_added'] = date("Y-m-d H:i:s");

            $sql = make_insert("credit_note",$dbarray);


            $query = mysqli_query($mycon,$sql) or die (mysqli_error($mycon));
            if($query){
                $credit_id = mysqli_insert_id($mycon);


                echo 'تمت اضافة الاشعار بنجاح';

                $dbarray['account_id'] = $_POST['account_id'];
                $dbarray['invoice_id'] = $_POST['invoice_id'];
                $dbarray['order_id'] = $_POST['order_id'];
                $dbarray['credit_value'] = (int)$_POST['credit_value'];
                $dbarray['note'] = $_POST['note'];


					$cashrec = array ();
					$cashrec["clid"]        = $_POST['account_id'];
				//	$cashrec["acctno"]      = $acctno;
                    $cashrec["ref"]         = filterin($ppd_ref);
									//may be changed to new invoice date
					$cashrec["date"]        = date("Y-m-d");
	                $cashrec["paymethod"]   = 'Credit Note';
                    $cashrec["pymt_amount"] = sprintf("%01.2f",$_POST['credit_value']);
                    $cashrec["ppd"]         = "N";
                    $cashrec["creditnote_id"]   = $credit_id;
                    $cashrec['system_date'] = date("Y-m-d H:i:s");

                    $cashrec["applied"] = sprintf("%01.2f",$_POST['credit_value']);
                    $cashrec['user_id'] = $_SESSION['user_id'];

	
                    //* SQL - Save the CashReceipt Record.
                    $invoices->insert_cash($cashrec);



            }else{
                echo 'Error in adding credit note ';
            }

            }else{
                $credit_id = $_POST['id'];
                $credit_note =  $workClass->get_credit_id($credit_id);
            

                $dbarray['edit_user'] = $_SESSION['user_id'];
                $dbarray['date_edit'] = date("Y-m-d H:i:s");

                

                $sql = $db->make_update("credit_note",$dbarray,"id",$credit_id);

                $query = mysqli_query($mycon,$sql) or die (mysqli_error($mycon));
                
                
                   $cashrec["clid"]        = $_POST['account_id'];
				//	$cashrec["acctno"]      = $acctno;
                    $cashrec["ref"]         = filterin($ppd_ref);
									//may be changed to new invoice date
					//$cashrec["date"]        = date("Y-m-d");
									
	                $cashrec["paymethod"]   = 'Credit Note';
                    $cashrec["pymt_amount"] = sprintf("%01.2f",$_POST['credit_value']);
                    $cashrec["ppd"]         = "N";
                  //  $cashrec["invoiceno"]   = $_POST['invoice_id'];
                    $cashrec['user_id'] = $_SESSION['user_id'];

                    $cashrec["applied"] = sprintf("%01.2f",$_POST['credit_value']);

                    $sql2 = $db->make_update("cashreceipts",$cashrec,"creditnote_id",$credit_id);

                    $query = mysqli_query($mycon,$sql2) or die (mysqli_error($mycon));


                if($query){
                    echo 'Credit note edited correctly';


                }else{
                    echo 'Error in edting credit note ';
                }


            }

        }else{

            if(isset($_GET['id'])){

                $id = $_GET['id'];

                $credit_note =  $workClass->get_credit_id($id);

                //get for this account
                $account_invoices = $invoices->get_invoice(array('client'=>$credit_note->account_id));

 //get for this account
                 $orders_invoices = $workClass->get_invoice_order($credit_note->invoice_id);


            }
            $credit_type = $workClass->get_combo_box("credit_type");

            $allacc = $accountClass->get_all_accounts(1);

            $newtemp->load_template('add_edit_credit',5);
        }
    break;

    case 'delete':
        // can be deleted if not applied

    break;


    case 'get_account_invoices':
        if(isset($_POST['account_id'])){
            $account_id = $_POST['account_id'];

            $account_invoices = $invoices->get_invoice(array('client'=>$account_id));
            echo json_encode($account_invoices);

        }
    break;

    case 'get_invoices_orders':
        if($_POST['invoice_id']){

            $res = $workClass->get_invoice_order($_POST['invoice_id']);
            echo json_encode($res);
        }
    break;
}

}

