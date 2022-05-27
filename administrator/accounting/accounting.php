<?php
session_start();


include("../../setting.php");
include("../../" . STYLE . "/consoletemp.php");
include("../../" . STYLE . "/worktemp.php");
include("../../".STYLE."/accountingtemp.php");

include("../../classes/console.php");
include("../../classes/account.php");
include("../../classes/package.php");
include("../../classes/invoices.php");
include("../../classes/price.php");
include("../../classes/company.php");

include("../../classes/payment.php");

$newtemp = new template();
$account = new account($db);
$package = new package($db);
$invoices = new invoices($db);
$priceClass = new price($db);
$companyClass = new company($db);
$paymentClass = new payment($db);


if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}

if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == 1 && $_SESSION['status'] == 2) {
    $open = "accounting";
    switch ($action) {

case 'discount_req':

    {
        if (isset($_POST['invoiceid'])&&isset($_POST['amount'])) {
            $invoiceid=$_POST['invoiceid'];
            $amount=$_POST['amount'];
            $query=mysqli_query($mycon, "select * from invoicehdr  where id='".$invoiceid."'") or die(mysqli_error($mycon));

            if ($query) {
                $return = mysqli_fetch_array($query);
                if ($return['subtotal'] > $amount) {
                    $update = false;
                    if ($return['discount_value'] != 0) {
                        $update = true;
                    }
                    $query = mysqli_query($mycon, "Update invoicehdr Set discount_value='" . $amount . "' where id='" . $invoiceid . "'") or die(mysqli_error($mycon));
                    if ($query) {
                        $date_added = date("Y-m-d H:i:s");
                        if ($update) {
                            $query = mysqli_query($mycon, "Update  credit_note set user_id='" . $_SESSION['user_id'] . "', credit_value ='" . $amount . "'  ,date_edit='" . $date_added . "', edit_user='" . $_SESSION['user_id'] . "' where invoice_id ='" . $invoiceid . "'  ") or die(mysqli_error($mycon));
                            $date = date("Y-m-d");
                            $query = mysqli_query($mycon, "Update cashreceipts set pymt_amount='" . $amount . "' ,date='" . $date . "' where invoiceno='" . $invoiceid . "' ") or die(mysqli_error($mycon));
                            if ($query) {
                                echo "تم تعديل الخصم";
                            } else {
                                echo "حاول لاحقاً";
                            }
                        } else {
                            $query = mysqli_query($mycon, "select * from invoicehdr  where id='" . $invoiceid . "'") or die(mysqli_error($mycon));
                            $clid = mysqli_fetch_array($query)['clid'];
                            $query = mysqli_query($mycon, "insert into credit_note (user_id,credit_value,account_id,invoice_id,date_added,credit_type) values ('" . $_SESSION['user_id'] . "','" . $amount . "','" . $clid . "','" . $invoiceid . "','" . $date_added . "' , '2' )") or die(mysqli_error($mycon));
                            if (mysqli_insert_id($mycon)) {
                                $credit_note_id = mysqli_insert_id($mycon);
                                $date = date("Y-m-d");
                                $query = mysqli_query($mycon, "insert into cashreceipts  (clid,date,invoiceno,user_id,creditnote_id,pymt_amount,system_date) 
                                    values ('" . $clid . "','" . $date . "','" . $invoiceid . "','" . $_SESSION['user_id'] . "','" . $credit_note_id . "','" . $amount . "' , '".date('Y-m-d H:i:s')."' )") or die(mysqli_error($mycon));
                                if (mysqli_insert_id($mycon)) {
                                    echo "تم إضافة الخصم";
                                } else {
                                    echo "حاول لاحقاً";
                                }
                            }
                        }
                    }
                } else {
                    echo "الخصم أكبر من قيمة الفاتور ة";
                }
            }
        }
    }
break;
        

case 'revise_account':
    {
        if (!isset($_POST['client'])) {
            $acc = $account->get_all_accounts(1);
            $newtemp->load_template('revise_account', 4);
        } else {
            $con =   mysqli_connect(HOSTNAME, DBUSER, DBPASS, DBNAME) or die("error in connection");
            mysqli_query($con, "SET NAMES utf8");
            mysqli_query($con, "SET CHARACTER SET utf8");
            $qq = mysqli_query($con, 'CALL cal_account('.$_POST['client'].',\''.$_POST['revise_date_form'].' 00:00:00\',\''.$_POST['revise_date_to'].' 23:59:59\');') or die("calc price2".mysqli_error($con));

            while ($row=mysqli_fetch_assoc($qq)) {
                $table[] = $row;
//                 $table[$index]['date']=$row['date'];
//                 $table[$index]['statement']=$row['paymethod'];
//                 $table[$index]['debit']=$row['pymt_amount'];
//                 $table[$index]['credit']=0;
//                 $table[$index]['payment_approval']=$row['id'];
//                 $sql="Select * from invoicehdr where clid='".$_POST['client']."' and `date` ='".$row['date']."'";
// //                echo $sql;
//                 $invoices=mysqli_query($mycon,$sql) or die (mysqli_error($mycon));
//                 $innerLoopindex=0;
//                 while($invoice=mysqli_fetch_assoc($invoices))
//                 {
//                     if($innerLoopindex>0)
//                     {
//                         $index++;
// //                        echo $innerLoopindex;
//                         $table[$index]['date']=$row['date'];
//                         $table[$index]['statement']=$row['paymethod'];
//                         $table[$index]['debit']=$row['pymt_amount'];
//                         $table[$index]['credit']=0;
//                         $table[$index]['payment_approval']=$row['id'];
//                     }

//                     $table[$index]['orderNo']=$invoice['easy_order_id'];
//                     $table[$index]['credit']+=$invoice['subtotal'];
//                     $sql = "select out_orders.*, account.account_company from  out_orders
//                     inner join account on (account.account_id = out_orders.account_id)
//                     join orders_package on find_in_set(orders_package.id, out_orders.items) > 0
//                     where orders_package.order_id = '".$invoice['easy_order_id']."'  group by out_orders.id,account.account_company";
// //                    echo $sql;
//                     $query=mysqli_query($mycon,$sql) or die (mysqli_error($mycon));
//                     $outOrder=mysqli_fetch_assoc($query);
//                     $table[$index]['outOrder']="".$outOrder['id'];
//                     while ($outOrder=mysqli_fetch_assoc($query))
//                     {
//                         $table[$index]['outOrder'].=",".$outOrder['id'];
//                     }
//                     $innerLoopindex++;
//                 }

//                 $index++;
            }


            mysqli_free_result($qq);
            mysqli_close($con);


//             $table=array();
//             $index=0;
//             $sql="Select * from cashreceipts where  clid='".$_POST['client']."' and `date` between '".$_POST['from']."'
//              and '".$_POST['to']."' order by date ASC ";
            // //            echo $sql;
//             $rows=mysqli_query($mycon,$sql) or die (mysqli_error($mycon));
//             while($row=mysqli_fetch_assoc($rows))
//             {
//                 $table[$index]['date']=$row['date'];
//                 $table[$index]['statement']=$row['paymethod'];
//                 $table[$index]['debit']=$row['pymt_amount'];
//                 $table[$index]['credit']=0;
//                 $table[$index]['payment_approval']=$row['id'];
//                 $sql="Select * from invoicehdr where clid='".$_POST['client']."' and `date` ='".$row['date']."'";
            // //                echo $sql;
//                 $invoices=mysqli_query($mycon,$sql) or die (mysqli_error($mycon));
//                 $innerLoopindex=0;
//                 while($invoice=mysqli_fetch_assoc($invoices))
//                 {
//                     if($innerLoopindex>0)
//                     {
//                         $index++;
            // //                        echo $innerLoopindex;
//                         $table[$index]['date']=$row['date'];
//                         $table[$index]['statement']=$row['paymethod'];
//                         $table[$index]['debit']=$row['pymt_amount'];
//                         $table[$index]['credit']=0;
//                         $table[$index]['payment_approval']=$row['id'];
//                     }

//                     $table[$index]['orderNo']=$invoice['easy_order_id'];
//                     $table[$index]['credit']+=$invoice['subtotal'];
//                     $sql = "select out_orders.*, account.account_company from  out_orders
//                     inner join account on (account.account_id = out_orders.account_id)
//                     join orders_package on find_in_set(orders_package.id, out_orders.items) > 0
//                     where orders_package.order_id = '".$invoice['easy_order_id']."'  group by out_orders.id,account.account_company";
            // //                    echo $sql;
//                     $query=mysqli_query($mycon,$sql) or die (mysqli_error($mycon));
//                     $outOrder=mysqli_fetch_assoc($query);
//                     $table[$index]['outOrder']="".$outOrder['id'];
//                     while ($outOrder=mysqli_fetch_assoc($query))
//                     {
//                         $table[$index]['outOrder'].=",".$outOrder['id'];
//                     }
//                     $innerLoopindex++;
//                 }

//                 $index++;

//             }
            $newtemp->load_template('show_revise_account', 5);
        }

    }
break;


case 'show_invoice':
    
    $ch = curl_init(SITEURL."/invoice/invoice.php?task=qp&hideButtons=1&oi=".$_GET['invoiceid']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    $content = curl_exec($ch);
    curl_close($ch);
    echo $content;

break;

case 'reviewed_invoice':
echo'ahmed' ;
break;


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
                mysqli_query($mycon, 'UPDATE `account` SET `credit_hold` = credit_hold-'.($oldCash[0]['pymt_amount']-$_POST['pymt_amount']).' WHERE `account_id` ='.$_POST['clid']);
            // echo 'الجديد اصغر';
            } elseif ($oldCash[0]['pymt_amount'] < $_POST['pymt_amount']) {
                mysqli_query($mycon, 'UPDATE `account` SET `credit_hold` = credit_hold+'.($_POST['pymt_amount']-$oldCash[0]['pymt_amount']).' WHERE `account_id` ='.$_POST['clid']);
                // echo 'الجديد اكبر';
            }
            unset($data['cash_id']);

            $data['system_date'] = date('Y-m-d H:i:s');
            // var_dump($data);
            $s=$db->make_update("cashreceipts", $data, 'id', $_POST['cash_id']);
            //  echo$s;
            mysqli_query($mycon, $s);
            echo 'تمت التعديل بنجاح';
        } else {
            $newtemp->load_template('cash', 5);
        }
    } else {
        $newtemp->load_template('cash', 5);
    }
break;

case 'cashreceipts':

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['clid'] =='' ||  $_POST['pymt_amount'] =='')) {
        echo 'ادخل كل البيانات';
    } elseif (isset($_POST['clid']) && $_POST['clid'] !=='') {
        if (is_numeric($_POST['pymt_amount'])) {
            $_POST['system_date']=date("Y-m-d H:i:s");
            $_POST['user_id']=$_SESSION['user_id'];
            $_POST['ppd']='N';
            //$_POST['serialno'] =

            $_POST['date'] = date('Y-m-d H:i:s');
            $sql = make_insert("cashreceipts", $_POST);
            // echo $sql;
            mysqli_query($mycon, $sql);
            mysqli_query($mycon, 'UPDATE `account` SET `credit_hold` = credit_hold+'.$_POST['pymt_amount'].' WHERE `account_id` ='.$_POST['clid'].' ');
    
            $re = mysqli_query($mycon, 'select cashreceipts.*,account.account_company,payment_type.payment_name from `cashreceipts`  
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
        $acc = $account->get_all_accounts(1, $_SESSION["billing_code"]);

     
        $payment_type = $account->payment_type();
        $newtemp->load_template('cashreceipts', 4);
    }
break;


case 'cashreceipts_print':

    if (isset($_POST['id'])) {
        $re = mysqli_query($mycon, 'select cashreceipts.*,account.account_company,payment_type.payment_name from `cashreceipts`  
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


case 'edit_invoice':

    
    if (isset($_POST['view'])) {
        $type = "view";
    } elseif ($_POST['process']) {
        $type= "process";
    }
    
    //$taxname = $companyClass->get_tax_name();
    //$taxrate = $companyClass->get_tax_rate();
    $termlist = $paymentClass->get_payment_term_list();
    
    //$tax_group = $companyClass->get_tax_group();
    $payment_term = $paymentClass->get_payment_term();
    $payment_type = $paymentClass->get_payment();
    
    $grpnames = $companyClass->get_tax_group_list();
    
    $def_message = $c_setting["co_invoice_message"];
    $def_copies  = $c_setting["co_invoiceoption_rb5"];
    
    //**********************************
    //        Add More Rows            *
    //**********************************
    if (isset($_POST['addrows'])) {
        $showlines_count = $_POST['showlines_count'] + 10;
        $type == "view"  ;
    }
    
    
    $acctno ='';
    

    
    
    
    if (isset($_GET['invoice_id']) and !isset($_POST['view']) and !isset($_POST['process'])) {
        //	echo "aaa";
        $invoiceno = $_GET['invoice_id'];
        
        $type = "view";
        $copies = $def_copies;
        // this means we r coming in from "Process Console", not view or process button from this page.*
        // *** !!!  Only want to do this once, when coming in here the first time on an edit.
        //* pull up the invoice header, get acctno & date
        $ri = mysqli_query($mycon, "select * from invoicehdr where id=$invoiceno");
        $invhdr        =  mysqli_fetch_array($ri);
        $acctno        = $invhdr["acctno"];
        $clid        = $invhdr["clid"];
        $random        = $invhdr["random"];
        $invoicedate   = $invhdr["date"];
        $invoicedate_yr = substr($invoicedate, 0, 4);
        $invoicedate_mo = substr($invoicedate, 5, 2);
        $invoicedate_dy = substr($invoicedate, 8, 2);
        $duedate        = $invhdr["duedate"];
        if (trim(strlen($duedate)) == 10) {
            $duedate_yr     = substr($duedate, 0, 4);
            $duedate_mo     = substr($duedate, 5, 2);
            $duedate_dy     = substr($duedate, 8, 2);
        }
        $fsapply       = $invhdr["fsapply"];
        $ppd_amount    = $invhdr["ppd_amount"];
        $ppd_method    = $invhdr["ppd_method"];
        $ppd_ref       = $invhdr["ppd_ref"];
        $printed       = $invhdr["printed"];
        $posted        = $invhdr["posted"];
        $delivered     = $invhdr["delivered"];
        $paid          = $invhdr["paid"];
        $source        = $invhdr["source"];
        $message       = $invhdr["message"];
        $billingpd     = $invhdr["billingpd"];
        
        //We use the full terms description in the listbox, but store the TermsName.
        $termscode     = $invhdr["terms"];
        for ($n = 1; $n < 10; $n++) {
            if ($termscode == $termscodelist[$n]  and  trim($termscode) <> "") {
                $termscodedesc = $termscodedesclist[$n];
            }
        }
    
        mysqli_free_result($ri);
    
    
        //* first, for old invoices, calc what the rate was when first printed, unless...
        //  fsapply is NO.  Then we can pick up the currents rates.
        if ($invhdr["fsapply"]  == "Y") {
            if ($invhdr["fs_rate_txgrp1"] == ""  and  $invhdr["subtotal"] != 0) {
                $invhdr["fs_rate_txgrp1"] = round($invhdr["fsamount"] / $invhdr["subtotal"], 4);
                $invhdr["fs_rate_txgrp2"] = $invhdr["fs_rate_txgrp1"];
                $invhdr["fs_rate_txgrp3"] = $invhdr["fs_rate_txgrp1"];
                $invhdr["fs_rate_txgrp4"] = $invhdr["fs_rate_txgrp1"];
                $invhdr["fs_rate_txgrp5"] = $invhdr["fs_rate_txgrp1"];
            }
        } else {
            $invhdr["fs_rate_txgrp1"] = $grpnames[1]['taxgroup_fs_rate']/100;
            $invhdr["fs_rate_txgrp2"] = $grpnames[2]['taxgroup_fs_rate']/100;
            $invhdr["fs_rate_txgrp3"] = $grpnames[3]['taxgroup_fs_rate']/100;
            $invhdr["fs_rate_txgrp4"] = $grpnames[4]['taxgroup_fs_rate']/100;
            $invhdr["fs_rate_txgrp5"] = $grpnames[5]['taxgroup_fs_rate']/100;
        }
    
        $fs_rate_txgrp1  = $invhdr["fs_rate_txgrp1"]; //*these get passed back on veiw/process
        $fs_rate_txgrp2  = $invhdr["fs_rate_txgrp2"];
        $fs_rate_txgrp3  = $invhdr["fs_rate_txgrp3"];
        $fs_rate_txgrp4  = $invhdr["fs_rate_txgrp4"];
        $fs_rate_txgrp5  = $invhdr["fs_rate_txgrp5"];
        
        $grptaxfsrate[1] = $invhdr["fs_rate_txgrp1"]; //*these get used
        $grptaxfsrate[2] = $invhdr["fs_rate_txgrp2"];
        $grptaxfsrate[3] = $invhdr["fs_rate_txgrp3"];
        $grptaxfsrate[4] = $invhdr["fs_rate_txgrp4"];
        $grptaxfsrate[5] = $invhdr["fs_rate_txgrp5"];
    
    
        //* load up the $li_ arrays with the detail records coming in.
        $ri = mysqli_query($mycon, "select * from invoicedtl where invoiceno=$invoiceno order by lineno");
        for ($i = 1; $i <= mysqli_num_rows($ri); $i++) {
            $detailrec =  mysqli_fetch_array($ri);
            $li_lineno[$i]    = $i;
            $li_items[$i]     = $detailrec["item"];
            $li_descns[$i]    = $detailrec["descn"];
            $li_amounts[$i]   = sprintf("%01.2f", $detailrec["amount"]);
            $li_taxgroups[$i] = $detailrec["taxgroup"];
            $li_chgtypes[$i]  = $detailrec["chgtype"];
            $li_fs_rate[$i]   = $detailrec["fsrate"];
            $edit_li_fs_rate[$i] = $detailrec["fsrate"];       //Once set, fsrate does NOT change. need to know if it's a newly added line or existing.
            $edit_li_taxgroups[$i] = $detailrec["taxgroup"];  //...Unless.... they change the TxGroup, then, we'll refresh it.
        }
        //* get count of lineitems to set initial count of lines on lineitem grid.
        //* whatever the count, give 10 extra rows.
        $showlines_count = mysqli_num_rows($ri) + 10;
        mysqli_free_result($ri);
        //* simulate the return from mkcb, for fsapply. -- unset it if = "N";
        //* to prepare it for the yesno function ( a few lines down).
        if ($fsapply != "Y") {
            unset($fsapply);
        }
    }
    
    
    if (isset($_GET['invoice_id'])) {
        $edit = "Y";
    }
    
    
    
    if (isset($_POST['view']) or isset($_POST['process'])) {
        $clid = $_POST['clid'];
        $invoiceno = $_POST['invoiceno'];
        $random = $_POST['random'];
        $acctno = $_POST['acctno'];
        $task = $_POST['task'];
        $showlines_count = $_POST['showlines_count'];
        $invoicedate = $_POST['date'];
        $duedate = $_POST['duedate'];
        $billingpd = $_POST['date_from'].$_POST['date_to'];
        $printed       = $_POST["printed"];
        $posted        = $_POST["posted"];
        $delivered     = $_POST["delivered"];
        $copies = $_POST['copies'];
        
        $fsapply =      yesno($_POST['fsapply']);
        $tobedelivered     = yesno($_POST["tobedelivered"]);
        $tobeposted     = yesno($_POST["tobeposted"]);
        
        
        $ppd_amount = $_POST['ppd_amount'];
        $ppd_method = $_POST['ppd_method'];
        $ppd_ref = $_POST['ppd_ref'];
        //	echo $billingpd;
        
        $li_items = $_POST['li_items'];
        $li_descns = $_POST['li_descns'];
        $li_amounts = $_POST['li_amounts'];
        $li_taxgroups = $_POST['li_taxgroups'];
        
        $li_chgtypes = $_POST['li_chgtypes'];
        $li_fs_rate = $_POST['li_fs_rate'];
        $edit_li_fs_rate = $_POST['edit_li_fs_rate'];
        $edit_li_taxgroups = $_POST['edit_li_taxgroups'];
        
        
        $fs_rate_txgrp1 = $_POST['fs_rate_txgrp1'];  //these get passed back hidden, in case...
        $fs_rate_txgrp2 = $_POST['fs_rate_txgrp2'];  //this is an old invoice...
        $fs_rate_txgrp3 = $_POST['fs_rate_txgrp3'];  //and the rates may have changed.
        $fs_rate_txgrp4 = $_POST['fs_rate_txgrp4'];  // the rules are:
        $fs_rate_txgrp5 = $_POST['fs_rate_txgrp5'];  // once rates are applied to an invoice - they r Locked.
    }
    
    
    
    //******************************************************************************
    // Get the customer record                                                     *
    //******************************************************************************
    $ri = mysqli_query($mycon, "select * from account where account_id='".$clid."'");
    $customer = mysqli_fetch_array($ri);
    mysqli_free_result($ri);
    $clid = $customer["account_id"];
    
    //* just in case... should never be zero, but......
    if ($customer["account_taxgroup"] == 0) {
        $customer["account_taxgroup"] = 1;
    }
    if ($customer["account_terms"]    == 0) {
        $customer["account_terms"]    = 1;
    }
    //* note: invoicelines is ok.  0 means 'Standard'.
    
    //* display customer address info.
    $name  = $customer["account_company"];
    $addr  = $customer["account_address"];
    $city  = $customer["city"];
    $pcode = $customer["pcode"];
    
    if (trim($customer["online_invoicing_email"].
            $customer["online_invoicing_email2"].
            $customer["online_invoicing_email3"]) != "") {
        $show_tobedelivered = "Y";
    }
    
    //* To set "posted" flag.
    $notify_uid = trim(strtoupper($customer["online_invoicing_userid1"]));
    if ($notify_uid == "DO NOT NOTIF") {
        $notify_uid = "";
    } //12char field
    if ($notify_uid != "") {
        $show_tobeposted  = "Y";
    }
    if ($invhdr["posted"] == "Y") {
        $show_tobeposted  = "N";
    }  //if No or Viewed, allow to re-notify
    
    //*Override online-invoicing flag
    
    //if ($customer["invoiceoption_8"] == 2)  $c_setting["co_online_invoicing"] = "Y";
    //if ($customer["invoiceoption_8"] == 3)  $c_setting["co_online_invoicing"] = "N";
    
    //* If online invoicing not Active - turn them both off
    if ($c_setting["co_online_invoicing"] != "Y") {
        $show_tobedelivered = "N";
        $show_tobeposted    = "N";
    }
    
    //*If editing existing invoice - default the checkboxes depending on,
    // if they have/not already.
    if (isset($edit)) {
        if ($posted    == "N") {
            $tobeposted = "Y";
        }
        if ($delivered == "N") {
            $tobedelivered = "Y";
        }
    }
    
    //******************************************************************************
    // Validate the form if we are coming back -  "Process" -or- "View".           *
    // check for,                                                                  *
    // - lineitems not all blank. (allow a zero value invoice).                    *
    //                            (just see if it's ALL blank).                    *
    // * check for blank only on Process, ok if just View-ing.                     *
    // - valid taxgroup on each lineitem that has a value.                         *
    ////****************************************************************************
    unset($errormsg);
    //if (isset($process_print))  $process = "Y";    //*** this is deadcode until(IF) I can figure out how to control printing from here.
    if ($type == "process" or $type == "view" && isset($_POST['invoiceno'])) {
        $grptaxfsrate[1] = $fs_rate_txgrp1;  //these get passed back hidden, in case...
        $grptaxfsrate[2] = $fs_rate_txgrp2;  //this is an old invoice...
        $grptaxfsrate[3] = $fs_rate_txgrp3;  //and the rates may have changed.
        $grptaxfsrate[4] = $fs_rate_txgrp4;  // the rules are:
        $grptaxfsrate[5] = $fs_rate_txgrp5;  // once rates are applied to an invoice - they r Locked.
        
        $fsapply       = yesno($_POST['fsapply']);
        $tobedelivered = yesno($_POST['tobedelivered']);
        $tobeposted    = yesno($_POST['tobeposted']);
        unset($notblank);
        for ($n = 1; $n < $showlines_count+1; $n++) {
            if ($li_items[$n]     != "") {
                $notblank = "Y";
            }
            if ($li_descns[$n]    != "") {
                $notblank = "Y";
            }
            if ($li_amounts[$n]   != 0) {
                $notblank = "Y";
            }
            //if ($li_taxgroups[$n] != 0)   $notblank = "Y";
    
            //echo "-".$li_taxgroups[$n]."-";
            //echo $grpnames[$li_taxgroups[$n]];
            
            if ($li_amounts[$n]!=0) {
                if ($li_taxgroups[$n] < 1  or !isset($grpnames[$li_taxgroups[$n]]) or  $grpnames[$li_taxgroups[$n]]=="") {
                    $errormsg = "Invalid tax group on line &nbsp;".$n;
                }
            }
            //* while we r at it, lets format the amount field.
            if (trim($li_amounts[$i]) != "") {
                $li_amounts[$i] = sprintf("%01.2f", $li_amounts[$i]);
            } else {
                $li_amounts[$i] = "";
            }
        }
    
        if (!isset($notblank) and (!isset($_POST['view']))) {
            $errormsg = "Invoice body is empty. Please fill in before processing.";
        }
    

        if (!is_date($invoicedate)) {
            $errormsg = "Invalid Invoice Date";
        }
    
        
        if (!is_date($duedate)) {
            $errormsg = "Invalid Due Date";
        }
    }
    
    if (isset($errormsg)) {
        $type == "view" ;
        //unset($process);
    }
    
    
    
    //******************************************************************************
    // Coming back in  -  View.  (also on the first time thru)                     *
    //* - load lineitem data from form back into $li array for re-display.         *
    //* - calc taxes,                                                              *
    //*   in the lineitems array, setup a bucket on each line for all 5 taxes,     *
    //*   go thru each line,                                                       *
    //*   pick the taxgroup of the line,                                           *
    //*   determine the 2 possible tax types of the group for the line,            *
    //*   calc the tax for each of the 2 taxtypes & store them in the appropriate  *
    //*    2(of 5) buckets on the line.                                            *
    //* - then do the fuel surcharge...                                            *
    //*   calc the f.s. based on rate in tax group                                 *
    //*   (if customer f.s. rate override, the rates in all 5 taxgroups in the...  *
    //*    array have been replaced).                                              *
    //*   set the f.s. taxable1 & 2, to be included in the tax calc for the line.  *
    //******************************************************************************
    if ($type == "process" or $type == "view") {
    
        //*lineitem arrays:  column for each taxtype.
        $li_tax1    = array();   //ie.GST
        $li_tax2    = array();   //ie.PST
        $li_tax3    = array();   //ie.TVQ
        $li_tax4    = array();   //ie.HST
        $li_tax5    = array();   //ie.etc
        $subtotal   = 0;
        $fsamount   = 0;
        $tax1amount = 0;
        $tax2amount = 0;
        $tax3amount = 0;
        $tax4amount = 0;
        $tax5amount = 0;
    
        if (!isset($errormsg)) {
            for ($n = 1; $n <$showlines_count+1; $n++) {
                //* if error, then leave all the totals blank, as they would be meaningless.
                //* make the next block of code transportable.
    
                $lineamount = round($li_amounts[$n], 2);
                $chgtype    = $li_chgtypes[$n];
    

                // $fsrate = "";
    
                //$fsrate  here is really an override - blank will cause tax_fs_calc to get from the TaxGroup.
                $fsrate = $edit_li_fs_rate[$n];  //if editing, this will give the original setting, otherwise it will be blank.
                //echo $fsrate;
                //Edit
                //leave it alone, unless they changed the TaxGroup
                //if it's a Contract - Never change it.
                //Refresh it only if: 1.Editing, 2.Not a Contract, 3.They changed the TaxGroup.
                if (isset($edit)  and  $chgtype != "C"  and  $li_taxgroups[$n] != $edit_li_taxgroups[$n]) {
                    $fsrate = "";
                }
    
                //Manual invoice - new
                if (!isset($edit) and $customer["fs_ovrd"] != "") {
                    $fsrate = $customer["fs_ovrd"];
                }
    
                //if none-of-the-above...no override... let tax_fs_calc take the rate from control-TaxGroups.
    
                //******Special Case: CONTRACTS... WE WILL HAVE TO GET THE S/W/X MARKERS FROM THE ORDER & pass them to tax_fs_calc().
    
                //echo $fsrate;
                if ($fsapply != "Y") {
                    $fsrate = "0";
                }
                $txcalcs = tax_fs_calc($li_taxgroups[$n], $fsrate, $lineamount, $chgtype);
                $subtotal = $subtotal + round($lineamount, 2);   //round in case some clown typed fractions of a cent.
    
                //...need to do this BEFORE tax_fs_calc, so it won't calc taxes on FS.......if ($fsapply == "N")  $txcalcs[0] = 0;
    
                $li_fs_amt[$n]  = $txcalcs[0]; //* all these were rounded when calc'd
                $li_tax1[$n]    = $txcalcs[1];
                $li_tax2[$n]    = $txcalcs[2];
                $li_tax3[$n]    = $txcalcs[3];
                $li_tax4[$n]    = $txcalcs[4];
                $li_tax5[$n]    = $txcalcs[5];
                $li_fs_rate[$n] = $txcalcs[6];
    

    
                //*tally
                $fsamount   = $fsamount   + $li_fs_amt[$n];
                $tax1amount = $tax1amount + $li_tax1[$n];
                $tax2amount = $tax2amount + $li_tax2[$n];
                $tax3amount = $tax3amount + $li_tax3[$n];
                $tax4amount = $tax4amount + $li_tax4[$n];
                $tax5amount = $tax5amount + $li_tax5[$n];
            } //end of lineitem loop
        } //end of not errormsg
    
        //*
    
        //*add up total.... but first, lets round those tallied amounts.
        $fsamount   = round($fsamount, 2);
        $tax1amount = round($tax1amount, 2);
        $tax2amount = round($tax2amount, 2);
        $tax3amount = round($tax3amount, 2);
        $tax4amount = round($tax4amount, 2);
        $tax5amount = round($tax5amount, 2);
    
        $total = round($subtotal
                + $fsamount
                + $tax1amount
                + $tax2amount
                + $tax3amount
                + $tax4amount
                + $tax5amount, 2);
    
        //*balance is total less paid.
        $balance = $total - round($ppd_amount, 2);
    
        //$billingpd = $bp_fromyr."-".$bp_frommo."-".$bp_fromdy.$bp_thruyr."-".$bp_thrumo."-".$bp_thrudy;
    } //* end of VIEW tallys.
    
    
    
    
    //******************************************************************************
    //* Process: All OK to do the 4 steps.                                         *
    //******************************************************************************
    if ($type == "process") {
    
        //******************************************************************************
        //* Step1: write the invoice header, details & cashreceipt records.            *
        //******************************************************************************
        //* Write the invoice header.                                                  *
        $invhdr = array();
        
        // 		if (isset($edit))
        // 		$invhdr["id"]          = $invoiceno;
        
        $invhdr["clid"]          = $clid;
        $invhdr["acctno"]        = $acctno;
        $invhdr["date"]          = $invoicedate;
        $invhdr["terms"]         = $termscode;
        $invhdr["duedate"]       = $duedate;
        $invhdr["subtotal"]      = sprintf("%01.2f", $subtotal);
        $invhdr["fsamount"]      = sprintf("%01.2f", $fsamount);
        $invhdr["fsapply"]       = yesno($_POST['fsapply']);
    
        if (yesno($_POST['fsapply']) == "Y") {
            $invhdr["fs_rate_txgrp1"] = sprintf("%01.4f", $grptaxfsrate[1]);
            $invhdr["fs_rate_txgrp2"] = sprintf("%01.4f", $grptaxfsrate[2]);
            $invhdr["fs_rate_txgrp3"] = sprintf("%01.4f", $grptaxfsrate[3]);
            $invhdr["fs_rate_txgrp4"] = sprintf("%01.4f", $grptaxfsrate[4]);
            $invhdr["fs_rate_txgrp5"] = sprintf("%01.4f", $grptaxfsrate[5]);
        } else {
            $invhdr["fs_rate_txgrp1"] = "";
            $invhdr["fs_rate_txgrp2"] = "";
            $invhdr["fs_rate_txgrp3"] = "";
            $invhdr["fs_rate_txgrp4"] = "";
            $invhdr["fs_rate_txgrp5"] = "";
        }
    
        $invhdr["tax1type"]      = $taxname[1];
        $invhdr["tax2type"]      = $taxname[2];
        $invhdr["tax3type"]      = $taxname[3];
        $invhdr["tax4type"]      = $taxname[4];
        $invhdr["tax5type"]      = $taxname[5];
        $invhdr["tax1amount"]    = sprintf("%01.2f", $tax1amount);
        $invhdr["tax2amount"]    = sprintf("%01.2f", $tax2amount);
        $invhdr["tax3amount"]    = sprintf("%01.2f", $tax3amount);
        $invhdr["tax4amount"]    = sprintf("%01.2f", $tax4amount);
        $invhdr["tax5amount"]    = sprintf("%01.2f", $tax5amount);
        $invhdr["ppd_amount"]    = sprintf("%01.2f", $ppd_amount);
        $invhdr["ppd_method"]    = $ppd_method;
        $invhdr["ppd_ref"]       = filterin($ppd_ref);                         //$message = "*".$grptaxfsrate[1]."*";
        $invhdr["message"]       = filterin($message);
        //* new invoice, set them all off - to start, then...
        if (!isset($edit)) {
            $invhdr["printed"]       = "N";
            $invhdr["posted"]        = "N";
            $invhdr["delivered"]     = "N";
            $invhdr["paid"]          = "N";
            $invhdr["source"]        = "M";
        }
        if ($copies > 0) {
            $invhdr["printed"]   = "Y";
        }
        if ($tobedelivered == "Y") {
            $invhdr["delivered"] = "Y";
        }
        if ($tobeposted == "Y") {
            $invhdr["posted"]    = "Y";
        }
        if ($balance == 0) {
            $invhdr["paid"]      = "Y";
        }
    
        
        $invhdr["billingpd"] = $billingpd;
    
    
        if ($random < 999) {             //  don't change it if already set, in case re-printed...
            $random = rand(999, 32768);
        }    // ... then the link in the email sent before won't work any more.
        $invhdr["random"] = $random;   //  Random number to ensure legitimate online invoice access
    
        //* SQL - Save the Invoice Header Record.
        $invoices->update_invoice($invoiceno, $invhdr);
        
        //update("invoicehdr",$invhdr);
        
        if (!isset($edit)) {
            $invoiceno = $invoices->insert_invoice($invhdr);
            // mysqli_insert_id($mycon);
        }
    
        //* Create cash-receipt record, for PREpayment.                                    *
        //* ...delete it first.
        if (isset($edit)) {
            mysqli_query($mycon, "delete from cashreceipts where (invoiceno=$invoiceno)
					and   (ppd='Y') ");
        }
        if ($ppd_amount != 0) {
            $cashrec = array();
            $cashrec["clid"]        = $clid;
            $cashrec["acctno"]      = $acctno;
            $cashrec["ref"]         = filterin($ppd_ref);
            $cashrec["date"]        = $invoicedate;
            $cashrec["paymethod"]   = $ppd_method;
            $cashrec["pymt_amount"] = sprintf("%01.2f", $ppd_amount);
            $cashrec["ppd"]         = "Y";
            $cashrec["invoiceno"]   = $invoiceno;
            $cashrec["applied"]     = sprintf("%01.2f", $ppd_amount);
    
            //* SQL - Save the CashReceipt Record.
            $invoices->insert_cash($cashrec);

            //update("cashreceipts",$cashrec);
        }
        //* Write invoice detail records.                                              *
        //* ...delete them all first, if edit. (they may have deleted some lines).
        if (isset($edit)) {
            //* but before we trash it all...
            //* load up the $li_ arrays with the fields not going back & forth to the form.
            $ri = mysqli_query($mycon, "select * from invoicedtl where invoiceno=$invoiceno order by lineno");
            for ($i = 1; $i <= mysqli_num_rows($ri); $i++) {
                $detailrec =  mysqli_fetch_array($ri);
                $li_waybills[$i]      = $detailrec["waybill"];
                $li_waybill_refs[$i]  = $detailrec["waybill_ref"];
                $li_chgtypes[$i]      = $detailrec["chgtype"];
            }
            mysqli_free_result($ri);
    
            mysqli_query($mycon, "delete from invoicedtl where invoiceno=$invoiceno");
        }
    
        for ($n = 1; $n < $showlines_count+1; $n++) {
            unset($notblank);
            if ($li_items[$n]   != "") {
                $notblank = "y";
            }
            if ($li_descns[$n]  != "") {
                $notblank = "y";
            }
            if ($li_amounts[$n] != 0) {
                $notblank = "y";
            }
            if ($notblank) {
                $detailrec = array();
                $detailrec["clid"]          = $clid;
                $detailrec["acctno"]        = $acctno;
                $detailrec["invoiceno"]     = $invoiceno;
                $detailrec["lineno"]        = $n;
                $detailrec["waybill"]       = $li_waybills[$n];
                $detailrec["waybill_ref"]   = $li_waybill_refs[$n];
                //* be sure we r not editing a "prepared" invoice.
                if ($li_chgtypes[$n] == "") {
                    $detailrec["chgtype"]      = "M";
                } else {
                    $detailrec["chgtype"]      = $li_chgtypes[$n];
                }
                $detailrec["item"]          = filterin($li_items[$n]);
                $detailrec["descn"]         = filterin($li_descns[$n]);
                $detailrec["amount"]        = sprintf("%01.2f", $li_amounts[$n]);
                $detailrec["fsamount"]      = sprintf("%01.2f", $li_fs_amt[$n]);
                $detailrec["fsrate"]        = $li_fs_rate[$n];
                $detailrec["taxgroup"]      = $li_taxgroups[$n];
                $detailrec["tax1amount"]    = sprintf("%01.2f", $li_tax1[$n]);
                $detailrec["tax2amount"]    = sprintf("%01.2f", $li_tax2[$n]);
                $detailrec["tax3amount"]    = sprintf("%01.2f", $li_tax3[$n]);
                $detailrec["tax4amount"]    = sprintf("%01.2f", $li_tax4[$n]);
                $detailrec["tax5amount"]    = sprintf("%01.2f", $li_tax5[$n]);
    
                //* SQL - Save the Invoice Detail Record.
                $invoices->insert_invoicedetails($detailrec);
                //update("invoicedtl",$detailrec);
            } //if notblank
        } //*for
    
        //******************************************                                   *
        //* Step2: Send the invoice in an email.                                       *
        //******************************************                                   *
        if ($tobedelivered == "Y") {
            //.......... this is already in mysql.pgp ........  include "unique/unique.php";
            // *NOTE: This code is duplicated in invoiceall.php *****
                      
            $to = trim(strtolower($customer["online_invoicing_email"]));
            $addr     = str_replace("www.", "", $c_setting["co_url"]);
            $addr     = str_replace("http://", "", $addr);
  
            $custacct = $customer["account_name"];
            $custname = $customer["account_company"];
            //$frommonthname = monthname($mofrom);
            //$thrumonthname = monthname($mothru);
            
            if ($c_setting['co_online_payments_email'] != "") {
                $from     = $c_setting['co_online_payments_email'];
            } else {
                $from     = $c_setting['co_from_email'];
            }
            
            if ($c_setting['co_online_payments_email'] != "") {
                $salute   = $c_setting['co_online_payments_email'];
            } else {
                $salute   = $c_setting['co_from_email'];
            }
             
            
            

      
            $subject   = $c_setting["co_name"]." Invoice no.".$invoiceno;
    
            $salute = "info@samedayexpress.ca";
    
            //$frommonthname = monthname($bp_frommo);
            //  $thrumonthname = monthname($bp_thrumo);
            $url_to_invoice = SITEURL."/invoice.php?task=online&oa=$custacct&oi=$invoiceno&rn=".$random;
  
            // $url_to_invoice = "http://".SITEURL."/invoice.php?task=online&oa=$custacct&oi=$invoiceno&rn=$random";
            $body = "Dear Client : $custname <br><br>".
            "Your invoice, No.$invoiceno.  <br><br>";
            
            if ($_POST['date_from'] != "") {
                $body .= "For the period from ".date("F d, Y", strtotime($_POST['date_from']))." thru ".date("F d, Y", strtotime($_POST['date_to'])).".";
            }
            $body .= "<br><br>".
      "Click the link below to open and View, Print or Pay your invoice.<br><br>".
            $url_to_invoice.
                    "<br><br>".
                    "Thank you, <br><br>".
                            $salute."<br><br>".
              "Security note; if you have any concerns regarding the legitimacy of this message, you can protect yourself by opening your web-browser and copying & pasting the above link, or re-typing it into the address bar.".
          "<br><br>".
          "Some malicious messages may show an apparently legitimate web-link, but when selected take you to a different website.";
    
            $dat['acctno']  = $customer["account_name"];
            $dat['event']   = "Prepare Invoice";
            $dat['sentfrom']  = "Invoice Prep";
            $dat['mailto'] = $to;
            $dat['mailfrom'] = $from;
            $dat['subject'] = $subject;
            $dat['body'] = $body;
      
            $orderid = "";
            $logacctno  = $customer["account_name"];
            $logdriver  = "";
            $logevent   = "Prepare Invoice";
            $logsource  = "Invoice Prep";
            $logsentto  = $to;
    
            //Customer copy 1
            if ($to != "") {
                mymail($to, $from, $subject, $body, $smtp);
                $logsentto = "client: online_invoicing_userid1";
                logemail($to, $from, $subject, $body, $orderid, $logacctno, $logdriver, $logevent, $logsource, $logsentto);
                $dat['mailto'] = $to;
                $dat["sentto"] = $logsentto;
                log_email($dat);
            }
            //Customer copy 2
            $to = trim(strtolower($customer["online_invoicing_email2"]));
            if ($to != "") {
                mymail($to, $from, $subject, $body, $smtp);
                $logsentto = "client: online_invoicing_userid1";
                //  logemail($to,$from,$subject,$body,$orderid,$logacctno,$logdriver,$logevent,$logsource,$logsentto);
                $dat["sentto"] = $logsentto;
                log_email($dat);
            }
            //Customer copy 3
            $to = trim(strtolower($customer["online_invoicing_email3"]));
            if ($to != "") {
                mymail($to, $from, $subject, $body, $smtp);
                $logsentto = "client: online_invoicing_userid1";
                // logemail($to,$from,$subject,$body,$orderid,$logacctno,$logdriver,$logevent,$logsource,$logsentto);
                $dat['mailto'] = $to;
                $dat["sentto"] = $logsentto;
                log_email($dat);
            }
            //Control copy 1
            $to = trim(strtolower($control["co_online_invoice_email_copy1"]));
            //change the subject to identify the customer
            $subject = " Invoice no.".$invoiceno." to: (".$customer["acctno"].")".$customer["company"];
            if ($to != "") {
                mymail($to, $from, $subject, $body, $smtp);
                $logsentto = "client: online_invoicing_userid1";
                //  logemail($to,$from,$subject,$body,$orderid,$logacctno,$logdriver,$logevent,$logsource,$logsentto);
                $dat['mailto'] = $to;
                $dat["sentto"] = $logsentto;
                log_email($dat);
            }
            //Control copy 2
            $to = trim(strtolower($control["co_online_invoice_email_copy2"]));
            if ($to != "") {
                mymail($to, $from, $subject, $body, $smtp);
                $logsentto = "client: online_invoicing_userid1";
                //  logemail($to,$from,$subject,$body,$orderid,$logacctno,$logdriver,$logevent,$logsource,$logsentto);
                $dat['mailto'] = $to;
                $dat["sentto"] = $logsentto;
                log_email($dat);
            }
        }
    
        //******************************************                                   *
        //* Step3: Print the invoice.                                                  *
        //******************************************                                   *
    
        $urlstring = "oi=".$invoiceno;
        $urlstring.="&task=".$task;
        $urlstring.="&copies=".$copies;
        $urlstring.="&oa=".$customer["account_name"];
        
    
        if ($copies > 0) {
            //* header must be sent before ANY other output ! ! ! ! ! !                 *
            //............................ INCLUDING TRACES ! ! ! ! ! !                 *
            header("Location: ".SITEURL."/invoice.php?".$urlstring);
        } else {
            header("Location:".formurl."/accounting.php?action=edit_invoice&invoice_id=".$invoiceno."&from=open ");
        }
        echo "***** Didn't make it out via header ***** <br><br><br>";
        exit;  //++++++++++++++++++++++++++
    }
    
    //echo "ahmed";
    
    
    $subtotal_fmt   = sprintf("%01.2f", $subtotal);
    $fsamount_fmt   = sprintf("%01.2f", $fsamount);
    $tax1amount_fmt = sprintf("%01.2f", $tax1amount);
    $tax2amount_fmt = sprintf("%01.2f", $tax2amount);
    $tax3amount_fmt = sprintf("%01.2f", $tax3amount);
    $tax4amount_fmt = sprintf("%01.2f", $tax4amount);
    $tax5amount_fmt = sprintf("%01.2f", $tax5amount);
    $total_fmt      = sprintf("%01.2f", $total);
    $ppd_amount_fmt    = sprintf("%01.2f", $ppd_amount);
    $balance_fmt    = sprintf("%01.2f", $balance);
    if ($ppd_amount == 0) {
        $ppd_amount_fmt = null;
    }
    
    
    //echo $def_copies.'-'.$def_message;
    //var_dump($termlist);
    
    $breadarray[0]['url'] = "index.php?action=accounts";
    $breadarray[0]['name'] = "الفواتير";

     $breadarray[1]['url'] = "";
     $breadarray[1]['name'] = "تعديل فاتورة";

    if ($_GET['from'] == "open") {
        $newtemp->load_template('edit_invoice', 1,'accounting_menu');
    } else {
        $newtemp->load_template('edit_invoice', 1,'accounting_menu');
    }
    
break;

case 'cash_receipts':
    
if (isset($_POST['account_id'])) {
    $inv = $invoices->get_unpaid_invoices($_POST['account_id']);
    $acc = $account->get_account($_POST['account_id']);
    
    
    
    
    if (isset($_GET['type']) && ($_GET['type'] == "viewpayment"  || $_GET['type'] == "commit")) {
        //echo "viewpayment";
        unset($errormsg);
        //***New rules*** Accept a payment of Zero.  May have adjusted an invoice to match a minor difference in the payment - or any other reason - need to clear it.
        if (trim($_POST['payment_amt']) == "0.00" ||  $_POST['payment_amt'] == '') {
            $anything_entered = 0;
            //prevent errors
            $applycb_elements = count($_POST['applycb']);
            $applied_elements = count($_POST['applied']);
            
            if ($applycb_elements > 0) {
                foreach ($_POST['applied'] as $cb) {
                    if (yesno($cb) == "Y") {
                        $anything_entered = 1;
                    }
                }
            }
            
            if ($applied_elements > 0) {
                foreach ($_POST['applied'] as $app) {
                    if ($app != 0) {
                        $anything_entered = 1;
                    }
                }
            }
            
            if (!$anything_entered) {
                $errormsg="Please enter a payment amount";
            }
        }
        
    
        if (trim($_POST['payment_date'] == "")) {
            $errormsg .= "<br>Please enter a payment date";
        }
        
        if ($_POST['payment_ref'] == "") {
            $errormsg .= "<br>Please enter a payment reference";
        }
    }
    
    if (isset($_GET['type']) && $_GET['type'] == "commit") {
        if ($errormsg != "") {
            $errormsg .= "<br>";
        }
        if ($_POST['payment_remaining'] != 0) {
            if ($_POST['total_applied'] == 0) {             //for those dumb enuf to just enter the chq & click apply.
                $errormsg.="Please apply the payment to one or more invoices.";
            } else {
                $errormsg.="You have an amount remaining.<br>Please adjust to fully apply the payment.";
            }
        }
        
        if (!isset($errormsg)) {
            //*** ALL OK ***  Put it AWAY ***
            //*link multiple cashreceipt records back to the first one
            $link = 0;
            //var_dump($inv);  //the +1 is to get cr's for invoice #0 - Deposits.
            for ($n=0; $n<count($inv); $n++) {
                //1. Run down the array of $applied[$n], pick the ones with an amount.
                //	echo $_POST['applied'][0];
                
                if ($_POST['applied'][$inv[$n]['id']] != "") {
                    //	echo $_POST['applied'][$inv[$n]['id']]."--".$apply;
                    //2.3.4. Create & write the CashReceipt record.
                    $invoiceno  = $inv[$n]['id'];
                    $apply      = round($_POST['applied'][$inv[$n]['id']], 2);
                    $balance    = round($inv[$n]['invoice_total'] - $inv[$n]['payments'], 2);
                    if ($invoiceno == "0") {
                        $invoiceno = 0;
                    }
        
                    $cashrec = array();
                    $cashrec["clid"]        = $acc->account_id;
                    $cashrec["acctno"]      = $acc->account_name;
                    $cashrec["ref"]         = mysqli_real_escape_string($mycon, $_POST['payment_ref']);
                    $cashrec["link"]        = $link;      //*fist record shows zero link
                    $cashrec["date"]        = $_POST['payment_date'];
                    $cashrec["paymethod"]   = $_POST['payment_method'];
                    $cashrec["pymt_amount"] = sprintf("%01.2f", $_POST['payment_amt']);
                    $cashrec["ppd"]         = "N";
                    $cashrec["invoiceno"]   = $invoiceno;
                    $cashrec["applied"]     = sprintf("%01.2f", $apply);
                    $crid = $invoices->insert_cash($cashrec);
                    
                    //* SQL - Save the CashReceipt Record.
                    if ($link == 0) {
                        $link = $crid;
                    } //*all records link back to the First record. (First record link is zero)
                    //3. NOT deposits: Set the "paid-in-full flag (if applied=balance ).  Update the record.
                    if ($invoiceno != 0) {
                        $ri = mysqli_query($mycon, "select id,payment_refs,payment_links from invoicehdr where id=$invoiceno") or die(mysqli_error($mycon));
                        $invhdr = mysqli_fetch_array($ri);
                        mysqli_free_result($ri);
                        if ($balance == $apply) {
                            $invhdr["paid"]     = "Y";
                        }
                        $invhdr["payment_refs"]  .= mysqli_real_escape_string($mycon, $payment_ref).",";
                        $invhdr["payment_links"] .= $crid.",";
                        //* SQL - Save the Invoice Header Record.
                        $invoices->update_invoice($invoiceno, $invhdr);
                    }
                } //($applied[$n] != 0)
            } //for ($n=0; $n<$rowcount; $n++)
            //5. Return to "open" console (pass all the parms back to get the same display)*
    
            
            if ($_POST['applied'][0] != "") {
                //1. Run down the array of $applied[$n], pick the ones with an amount.
                $link = 0;
            
                if ($_POST['applied'][0] != "") {
                    //	echo $_POST['applied'][$inv[$n]['id']]."--".$apply;
                    //2.3.4. Create & write the CashReceipt record.
                    $invoiceno  = "0";
                    $apply      = round($_POST['applied'][0], 2);
                    //$balance    = round($inv[$n]['invoice_total'] - $inv[$n]['payments'],2);
                    if ($invoiceno == "0") {
                        $invoiceno = 0;
                    }
            
                    $cashrec = array();
                    $cashrec["clid"]        = $acc->account_id;
                    $cashrec["acctno"]      = $acc->account_name;
                    $cashrec["ref"]         = mysqli_real_escape_string($mycon, $_POST['payment_ref']);
                    $cashrec["link"]        = $link;      //*fist record shows zero link
                    $cashrec["date"]        = $_POST['payment_date'];
                    $cashrec["paymethod"]   = $_POST['payment_method'];
                    $cashrec["pymt_amount"] = sprintf("%01.2f", $_POST['payment_amt']);
                    $cashrec["ppd"]         = "N";
                    $cashrec["invoiceno"]   = $invoiceno;
                    $cashrec["applied"]     = sprintf("%01.2f", $apply);
                    $crid = $invoices->insert_cash($cashrec);
                        
                    //* SQL - Save the CashReceipt Record.
                    if ($link == 0) {
                        $link = $crid;
                    } //*all records link back to the First record. (First record link is zero)
                    //3. NOT deposits: Set the "paid-in-full flag (if applied=balance ).  Update the record.
                } //($applied[$n] != 0)
            }
        }// NOT isset($errormsg)
    }
    
    $inv = $invoices->get_unpaid_invoices($_POST['account_id']);
    
    //$con = $contact->get_account_contact($_POST['account_id']);
    $pay = $payment->get_payment();
    
    echo $errormsg;
    $newtemp->load_template('cash_recepits_new', 5);
} else {
    $newtemp->load_template('cash_recepits', 4);
}
break;

case 'cash_receipts_new':
    if (isset($_POST['account_id'])) {
        $acc = $account->get_account($_POST['account_id']);
        //$con = $contact->get_account_contact($_POST['account_id']);
        //$pay = $payment->get_payment();
        
        if (isset($_GET['type']) && ($_GET['type'] == "viewpayment"  || $_GET['type'] == "commit")) {
            //echo "viewpayment";
            unset($errormsg);
            //***New rules*** Accept a payment of Zero.  May have adjusted an invoice to match a minor difference in the payment - or any other reason - need to clear it.
            if (trim($_POST['payment_amt']) == "0.00" ||  $_POST['payment_amt'] == '') {
                $anything_entered = 0;
                //prevent errors
                $applycb_elements = count($_POST['applycb']);
                $applied_elements = count($_POST['applied']);
                    
                if ($applycb_elements > 0) {
                    foreach ($_POST['applycb'] as $cb) {
                        if (yesno($cb) == "Y") {
                            $anything_entered = 1;
                        }
                    }
                }
                    
                if ($applied_elements > 0) {
                    foreach ($_POST['applied'] as $app) {
                        if ($app != 0) {
                            $anything_entered = 1;
                        }
                    }
                }
                    
                if (!$anything_entered) {
                    $errormsg="Please enter a payment amount";
                }
            }
        
        
            if (trim($_POST['payment_date'] == "")) {
                $errormsg .= "<br>Please enter a payment date";
            }
        
            if ($_POST['payment_ref'] == "") {
                $errormsg .= "<br>Please enter a payment reference";
            }
        }
        
        
        
        
        
        
        $payment_ref       = "";
        $payment_amt       = 0;
        $total_applied     = 0;
        $payment_remaining = 0;
  
        $payment_ref = $_POST['payment_ref'];
        $payment_amt = $_POST['payment_amt'];
        $payment_method = $_POST['payment_method'];
        
        $where  = "(paid<>'Y' )
		and clid='".$_POST['account_id']."'";
        
        $sql = "select * from invoicehdr where ($where) order by id";
        
        //******************************************************************************
        //* Pull in the Records, one at a time in the loop                             *
        //******************************************************************************
        $ri = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));
        $rowcount = mysqli_num_rows($ri);
        $col0 = array();                  // invoice no
        $col1 = array();                  // invoice date
        $col2 = array();                  // due date
        $col3 = array();                  // invoice amount
        $col4 = array();                  // prior payments
        $col5 = array();                  // balance
        $col6 = array();                  // payit checkbox
        $col7 = array();                  // amount applied
        //the +1 is to get cr's for invoice #0 - Deposits.
        for ($n=0; $n<$rowcount+1; $n++) {
            if ($n < $rowcount) {
                $invhdr = mysqli_fetch_array($ri);
                $invoiceno = $invhdr["id"];
                $clid      = $invhdr["clid"];
            } else {
                //deposits
                $invoiceno         = 0;
                $invhdr            = array();
                $invhdr["id"]      = "Deposits";
                $invhdr["date"]    = "";
                $invhdr["duedate"] = "";
            }
            //* get all cash receipts against this invoice.
            // now need to specify acctno, b/c of invoice #0 - for deposits.
            $payments = 0;
            $rc = mysqli_query($mycon, "select * from cashreceipts where invoiceno=$invoiceno and clid='".$_POST['account_id']."'");
            for ($i = 0; $i < mysqli_num_rows($rc); $i++) {
                $cashrcpt = mysqli_fetch_array($rc);
                //if($cashrcpt['ppd'] == 'Y')
                $payments = $payments + $cashrcpt["applied"];
            }
            mysqli_free_result($rc); //cashreceipts
            //* tally for the invoice value.
            $invoice_total = round($invhdr["subtotal"]
                    + $invhdr["fsamount"]
                    + $invhdr["tax1amount"]
                    + $invhdr["tax2amount"]
                    + $invhdr["tax3amount"]
                    + $invhdr["tax4amount"]
                    + $invhdr["tax5amount"], 2);
            $balance    = $invoice_total - $payments;
            $invoice_total_fmt = sprintf("%01.2f", $invoice_total);
            $payments_fmt      = sprintf("%01.2f", $payments);
            $balance_fmt       = sprintf("%01.2f", $balance);
            if ($payments == 0) {
                $payments_fmt = "&nbsp;";
            }
            
            $col0[$n] = $invhdr["id"];
            $col1[$n] = $invhdr["date"];
            $col2[$n] = $invhdr["duedate"];
            $col3[$n] = $invoice_total_fmt;
            $col4[$n] = $payments_fmt;
            $col5[$n] = $balance_fmt;
            
            $_POST['applycb'][$n] = yesno($_POST['applycb'][$n]);
            
            if ($_POST['applycb'][$n] == "Y") {
                $_POST['applied'][$n]=$balance_fmt;
            }
            // if ($applied[$n] != 0)
            if ($_POST['applied'][$n] != "") {
                $appliedfmt = sprintf("%01.2f", $_POST['applied'][$n]);
            } else {
                $appliedfmt = "";
            }
            //if ($applied[$n] < 0  and $applycb[$n] == "Y")  $appliedfmt = "";
            
            $col7[$n] = '<input type="text" name="applied['.$n.']" value="'.(isset($_POST['applied'][$n]) ? $appliedfmt : '').'" size="10">';
            
            $_POST['applycb'][$n]="N";
            $col6[$n] = '<input type="checkbox" name="applycb['.$n.']" >';
        
            //deposits
            if ($invoiceno == 0) {
                $col3[$n] = "&nbsp;";
                $col5[$n] = "&nbsp;";
                $col6[$n] = "&nbsp;";
            }
        
            //Selecting customer for Deposit - don't show any input fields on grid.
            // (the Only one showing now, would be the Deposit row).
            if ($_POST['account_id'] == "") {
                $col6[$n] = "&nbsp;";
                $col7[$n] = "&nbsp;";
            }
        
            $total_applied = round($total_applied + $_POST['applied'][$n], 2);
        }//*for loop - build & display all the rows
        
        mysqli_free_result($ri); //invoicehdr
        
        //*accum totals
        $payment_remaining     = round($payment_amt - $total_applied, 2);
        
        $total_applied_fmt     = sprintf("%01.2f", $total_applied);
        $payment_remaining_fmt = sprintf("%01.2f", $payment_remaining);
        
        if (trim($payment_amt) != "") {
            $payment_amt_fmt = sprintf("%01.2f", $payment_amt);
        } else {
            $payment_amt_fmt="";
        }
        
        
        
        
        if (isset($_GET['type']) && $_GET['type'] == "commit") {
            if ($errormsg != "") {
                $errormsg .= "<br>";
            }
            if ($payment_remaining != 0) {
                if ($total_applied == 0) {             //for those dumb enuf to just enter the chq & click apply.
                    $errormsg.="Please apply the payment to one or more invoices.";
                } else {
                    $errormsg.="You have an amount remaining.<br>Please adjust to fully apply the payment.";
                }
            }
        
            if (!isset($errormsg)) {
                //echo "ahmed";
                //*** ALL OK ***  Put it AWAY ***
                //*link multiple cashreceipt records back to the first one
                $link = 0;             //the +1 is to get cr's for invoice #0 - Deposits.
                for ($n=0; $n<$rowcount+1; $n++) {
                    //1. Run down the array of $applied[$n], pick the ones with an amount.
                    if ($_POST['applied'][$n] != "") {
                        //2.3.4. Create & write the CashReceipt record.
                        $invoiceno  = $col0[$n];
                        $apply      = round($_POST['applied'][$n], 2);
                        $balance    = round($col5[$n], 2);
                        if ($invoiceno == "Deposits") {
                            $invoiceno = 0;
                        }
        
                        $cashrec = array();
                        $cashrec["clid"]        = $clid;
                        $cashrec["acctno"]      = $acctno;
                        $cashrec["ref"]         = mysqli_real_escape_string($mycon, $payment_ref);
                        $cashrec["link"]        = $link;      //*fist record shows zero link
                        $cashrec["date"]        = $_POST['payment_date'];
                        $cashrec["paymethod"]   = $payment_method;
                        $cashrec["pymt_amount"] = sprintf("%01.2f", $payment_amt);
                        $cashrec["ppd"]         = "N";
                        $cashrec["invoiceno"]   = $invoiceno;
                        $cashrec["applied"]     = sprintf("%01.2f", $apply);
                        //* SQL - Save the CashReceipt Record.
                        $crid = $invoices->insert_cash($cashrec);
                        if ($link == 0) {
                            $link = $crid;
                        } //*all records link back to the First record. (First record link is zero)
                        //3. NOT deposits: Set the "paid-in-full flag (if applied=balance ).  Update the record.
                        if ($invoiceno != 0) {
                            $ri = mysqli_query($mycon, "select id,payment_refs,payment_links from invoicehdr where id=$invoiceno");
                            $invhdr = mysqli_fetch_array($ri);
                            mysqli_free_result($ri);
                            if ($balance == $apply) {
                                $invhdr["paid"]     = "Y";
                            }
                            $invhdr["payment_refs"]  .= mysqli_real_escape_string($mycon, $payment_ref).",";
                            $invhdr["payment_links"] .= $crid.",";
                            //* SQL - Save the Invoice Header Record.
                            $invoices->update_invoice($invoiceno, $invhdr);
                        }
                    } //($applied[$n] != 0)
                } //for ($n=0; $n<$rowcount; $n++)
                //5. Return to "open" console (pass all the parms back to get the same display)*
            }// NOT isset($errormsg)
            
            
            $total_amount_fmt   = 0;
            $total_payments_fmt = 0;
            $total_balance_fmt  = 0;
            $total_applied_fmt  = 0;
            $total_applied = 0;
            $payment_remaining = 0;
            $payment_amt = 0;
            
            $where  = "paid<>'Y' and
		 clid='".$_POST['account_id']."'";
            
            $acc_id = $_POST['account_id'];
            $sql = "select * from invoicehdr where ($where) order by id";
            //unset($_POST);
            $_POST['account_id'] = $acc_id;
            //******************************************************************************
            //* Pull in the Records, one at a time in the loop                             *
            //******************************************************************************
            $ri = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));
            $rowcount = mysqli_num_rows($ri);
            $col0 = array();                  // invoice no
            $col1 = array();                  // invoice date
            $col2 = array();                  // due date
            $col3 = array();                  // invoice amount
            $col4 = array();                  // prior payments
            $col5 = array();                  // balance
            $col6 = array();                  // payit checkbox
            $col7 = array();                  // amount applied
            //the +1 is to get cr's for invoice #0 - Deposits.
            for ($n=0; $n<$rowcount+1; $n++) {
                if ($n < $rowcount) {
                    $invhdr = mysqli_fetch_array($ri);
                    $invoiceno = $invhdr["id"];
                    $clid      = $invhdr["clid"];
                } else {
                    //deposits
                    $invoiceno         = 0;
                    $invhdr            = array();
                    $invhdr["id"]      = "Deposits";
                    $invhdr["date"]    = "";
                    $invhdr["duedate"] = "";
                }
                //* get all cash receipts against this invoice.
                // now need to specify acctno, b/c of invoice #0 - for deposits.
                $payments = 0;
                $rc = mysqli_query($mycon, "select * from cashreceipts where invoiceno=$invoiceno and clid='".$_POST['account_id']."'");
                for ($i = 0; $i < mysqli_num_rows($rc); $i++) {
                    $cashrcpt = mysqli_fetch_array($rc);
                    $payments = $payments + $cashrcpt["applied"];
                }
                mysqli_free_result($rc); //cashreceipts
                //* tally for the invoice value.
                $invoice_total = round($invhdr["subtotal"]
                        + $invhdr["fsamount"]
                        + $invhdr["tax1amount"]
                        + $invhdr["tax2amount"]
                        + $invhdr["tax3amount"]
                        + $invhdr["tax4amount"]
                        + $invhdr["tax5amount"], 2);
                $balance    = $invoice_total - $payments;
                $invoice_total_fmt = sprintf("%01.2f", $invoice_total);
                $payments_fmt      = sprintf("%01.2f", $payments);
                $balance_fmt       = sprintf("%01.2f", $balance);
                if ($payments == 0) {
                    $payments_fmt = "&nbsp;";
                }
                    
                $col0[$n] = $invhdr["id"];
                $col1[$n] = $invhdr["date"];
                $col2[$n] = $invhdr["duedate"];
                $col3[$n] = $invoice_total_fmt;
                $col4[$n] = $payments_fmt;
                $col5[$n] = $balance_fmt;
                    
                $_POST['applycb'][$n] = yesno($_POST['applycb'][$n]);
                    
                if ($_POST['applycb'][$n] == "Y") {
                    $_POST['applied'][$n]=$balance_fmt;
                }
                // if ($applied[$n] != 0)
                if ($_POST['applied'][$n] != "") {
                    $appliedfmt = sprintf("%01.2f", $_POST['applied'][$n]);
                } else {
                    $appliedfmt = "";
                }
                //if ($applied[$n] < 0  and $applycb[$n] == "Y")  $appliedfmt = "";
                    
                $col7[$n] = '<input type="text" name="applied['.$n.']" value="'.(isset($_POST['applied'][$n]) ? $appliedfmt : '').'" size="10">';
                    
                $_POST['applycb'][$n]="N";
                $col6[$n] = '<input type="checkbox" name="applycb['.$n.']" >';
            
                //deposits
                if ($invoiceno == 0) {
                    $col3[$n] = "&nbsp;";
                    $col5[$n] = "&nbsp;";
                    $col6[$n] = "&nbsp;";
                }
            
                //Selecting customer for Deposit - don't show any input fields on grid.
                // (the Only one showing now, would be the Deposit row).
                if ($_POST['account_id'] == "") {
                    $col6[$n] = "&nbsp;";
                    $col7[$n] = "&nbsp;";
                }
                unset($_POST['applied']);
                $total_applied = round($total_applied + $_POST['applied'][$n], 2);
            }//*for loop - build & display all the rows
            
            mysqli_free_result($ri); //invoicehdr
            
            //*accum totals
            $payment_remaining     = round($payment_amt - $total_applied, 2);
            
            $total_applied_fmt     = sprintf("%01.2f", $total_applied);
            $payment_remaining_fmt = sprintf("%01.2f", $payment_remaining);
            
            if (trim($payment_amt) != "") {
                $payment_amt_fmt = sprintf("%01.2f", $payment_amt);
            } else {
                $payment_amt_fmt="";
            }
        }// isset($commit)
        
        
        $x = "";
        $total_amount   = 0;
        $total_payments = 0;
        $total_balance  = 0;
        
        for ($c=0;$c<count($col0);$c++) {
            $x .= '<tr>
				<td>'.$col0[$c].'</td>
			   <td>'.$col1[$c].'</td>
			   <td>'.$col2[$c].'</td>
			   <td>'.$col3[$c].'</td>
			   <td>'.$col4[$c].'</td>
			   <td>'.$col5[$c].'</td>
			   <td>'.$col6[$c].'</td>
			   <td>'.$col7[$c].'</td>
			   			</tr>			
				';
            $total_amount   = $total_amount   + $col3[$c];
            //echo $total_amount;
            $total_payments = $total_payments + $col4[$c];
            $total_balance  = $total_balance  + $col5[$c];
        }
    
        $total_amount_fmt   = sprintf("%01.2f", $total_amount);
        $total_payments_fmt = sprintf("%01.2f", $total_payments);
        $total_balance_fmt  = sprintf("%01.2f", $total_balance);
        $total_applied_fmt  = sprintf("%01.2f", $total_applied);
        
        $x .= '<tr>
				<td>'.$lang[1016].'</td>
			   <td></td>
			   <td></td>
			   <td>'.$total_amount_fmt.'</td>
			   <td>'.$total_payments_fmt.'</td>
			   <td>'.$total_balance_fmt.'</td>
			   <td></td>
			   <td>'.$total_applied_fmt.'</td>
			   			</tr>
				';
        
        //$inv = $invoices->get_unpaid_invoices($_POST['account_id']);
        
        
        echo $errormsg;
        
        $newtemp->load_template('cash_recepits_new', 5);
    } else {
        $newtemp->load_template('cash_recepits', 4);
    }
break;

case 'cash_receipts_history':
    if (isset($_POST['account_id'])) {
        $result = $invoices->get_cash_receipt($_POST);
        $newtemp->load_template('cash_recepits_history', 5);
    } else {
        $newtemp->load_template('cash_recepits_history', 4);
    }
    break;

case 'cr_view':
    if (isset($_POST['openinvoice'])) {
        if (isset($_POST['acct_name2'])  && $_POST['acct_name2'] != "") {
            $res = $account->check_exist("account_name", $_POST['acct_name2']);
            if (!$res) {
                echo "Error in Account No.";
                    
                return;
            }
        }
        
        if ($_POST['acct_name2'] != "") {
            $accno = $account->get_account_id_byname($_POST['acct_name2']);
        } elseif ($_POST['account_acctno'] != '') {
            $accno = $_POST['account_acctno'];
        } elseif ($_GET['account_acctname'] != '') {
            $accno = $_POST['account_acctname'];
        } else {
            $accno = "";
        }
        
        $account_id = $accno;
        $_POST['account_id'] = $account_id;
        
        if (isset($_POST['tax_col'])) {
            $show_tax = "1";
        } else {
            $show_tax = "0";
        }
        
        $result = $invoices->get_cash_receipt($_POST);
    
    
        $breadarray[0]['url'] = "accounting.php?action=open_invoice";
        $breadarray[0]['name'] = $lang[114];
    
        $breadarray[1]['url'] = "";
        $breadarray[1]['name'] = $lang[851];
    
        $page_title = $lang[851];
        $newtemp->load_template('cash_receipts_view', 4);
    }
break;

case 'open_invoice':
if (isset($_POST['get_open_invoice'])) {
    if (is_numeric($_POST['invoice_no']) &&  $_POST['invoice_no'] != '') {
        $invoice_no = $_POST['invoice_no'];
    } else {
        $invoice_no = 0;
        
        if (isset($_POST['acct_name2'])  && $_POST['acct_name2'] != "") {
            $res = $account->check_exist("account_name", $_POST['acct_name2']);
            if (!$res) {
                echo "Error in Account No.";
            
                return;
            }
        }
        
        if ($_POST['acct_name2'] != "") {
            $accno = $account->get_account_id_byname($_POST['acct_name2']);
        } elseif ($_POST['account_acctno'] != '') {
            $accno = $_POST['account_acctno'];
        } elseif ($_GET['account_acctname'] != '') {
            $accno = $_POST['account_acctname'];
        } else {
            $accno = "";
        }
        
        $account_id = $accno;
        
        


        if ($_POST['billingcode'] == "*") {
            $billingcode = "";
        } else {
            $billingcode = $_POST['billingcode'];
        }

        if ($_POST['due_invoice_date'] == "") {
            $due_date = "";
        } else {
            $due_date = $_POST['due_invoice_date'];
        }
    }
    


    $proce = $invoices->get_open_invoice($account_id, $invoice_no, $due_date, $billingcode);

    $data['invoiceno'] = $invoice_no;
    $data['account_id'] = $account_id;
    $data['billingcode'] = $billingcode;
    $data['to_invoice_date'] = $due_date;

    //$deposits = $invoices->get_cash_receipt_deposit($data);



    $tab = "open_invoice";

    $breadarray[0]['url'] = "accounting.php?action=open_invoice";
    $breadarray[0]['name'] = $lang[114];

    $breadarray[1]['url'] = "";
    $breadarray[1]['name'] = $lang[934];

    $page_title = $lang[114];
    $newtemp->load_template('process_invoice_data', 4);
} else {
    $acc = $account->get_all_accounts(1);
    $breadarray[0]['url'] = "#";
    $breadarray[0]['name'] = $lang[114];
    $page_title = $lang[114];
    $newtemp->load_template('open_invoice', 4);
}
break;


case 'history_invoice':
    
if (isset($_GET['account_id'])) {
    $_GET["client"] = $_GET['account_id'];
        
    if ($_GET["client"] != "") {
        $name = $invoices->get_account_company($_GET["client"]);
        $from =  $_GET['invoice_date_form'];
        $to =  $_GET['invoice_date_to'];
    }




 
    $proce = $invoices->get_invoice($_GET);
 
 
    $data['invoiceno'] = $_GET["invoice_no"];
    $data['client'] = $_GET["client"];
    $data['billingcode'] = $_GET["billingcode"];
    $data['reviewed'] = $_GET["reviewed"];
    $data['billing_code'] = $_GET["billing_code"];
    $client_name = $data;
    //$data['to_invoice_date'] = $due_date;
    //$tax = $companyClass->get_tax_name();
    $deposits = $invoices->get_cash_receipt_deposit($data);
    $print = "1";
    $tab = "search_invoice";
    $page_title = "Invoice History";
    $is_search = 1;
    if ($_GET['type'] == "report") {
        $newtemp->load_template('process_invoice_data', 6);
    } else {
        $newtemp->load_template('process_invoice_data', 5);
    }
 
    // $newtemp->load_template('search_invoices',5);
} else {
    $billing_codes = $companyClass->get_billing_code() ;
    $acc = $account->get_all_accounts(1, $_SESSION['billing_code']);
    $newtemp->load_template('history_invoice', 4);
}
break;


case 'payinvoice':
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $account_id = $invoices->get_account_byinvoice_id($_GET['id']);
    $invoiceno = $_GET['oi'];

    $acc_details = $account->get_account($account_id);

    $inv_details = $invoices->get_invoice_header($_GET['id']);
    $invhdr = get_object_vars($inv_details);



    $acctno      = $invhdr["acctno"];
    $random      = $invhdr["random"];
    $total       = sprintf("%01.2f", $invhdr["subtotal"])
             + sprintf("%01.2f", $invhdr["fsamount"])
             + sprintf("%01.2f", $invhdr["tax1amount"])
             + sprintf("%01.2f", $invhdr["tax2amount"])
             + sprintf("%01.2f", $invhdr["tax3amount"])
             + sprintf("%01.2f", $invhdr["tax4amount"])
             + sprintf("%01.2f", $invhdr["tax5amount"]);
             
             
    $inv_balance = $total - $invhdr["ppd_amount"];



    if ($inv_details !=false) {
        $inv_lines = $invoices->get_invoice_lines($_GET['id']);
        $page_title = $lang[518];
        $newtemp->load_template('print_invoice', 2);
    } else {
        echo $lang[517];
    }
} else {
    echo $lang[516];
}
break;

case 'cancel_invoices':
if (isset($_POST["ids"]) && $_POST["ids"] != "") {
    $ids = explode(",", $_POST["ids"]);

    for ($i=0; $i < count($ids); $i++) {
        if ($ids[$i] != "") {
            $invoices->cancel_invoices($ids[$i]);
        }
    }
    echo "Selected Invoices has been Cancelled";
}
break;


        case 'payinvoice':
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $account_id = $invoices->get_account_byinvoice_id($_GET['id']);
                $invoiceno = $_GET['oi'];

                $acc_details = $account->get_account($account_id);

                $inv_details = $invoices->get_invoice_header($_GET['id']);
                $invhdr = get_object_vars($inv_details);


                $acctno = $invhdr["acctno"];
                $random = $invhdr["random"];
                $total = sprintf("%01.2f", $invhdr["subtotal"])
                    + sprintf("%01.2f", $invhdr["fsamount"])
                    + sprintf("%01.2f", $invhdr["tax1amount"])
                    + sprintf("%01.2f", $invhdr["tax2amount"])
                    + sprintf("%01.2f", $invhdr["tax3amount"])
                    + sprintf("%01.2f", $invhdr["tax4amount"])
                    + sprintf("%01.2f", $invhdr["tax5amount"]);


                $inv_balance = $total - $invhdr["ppd_amount"];


                if ($inv_details != false) {
                    $inv_lines = $invoices->get_invoice_lines($_GET['id']);
                    $page_title = $lang[518];
                    $newtemp->load_template('print_invoice', 2);
                } else {
                    echo $lang[517];
                }
            } else {
                echo $lang[516];
            }
            break;
         //   case 'searchDeliveries':
           // $newtemp->load_template('header_work', 1);


           // break;


        default:
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
            $query = $grid_sql . " where  orders.order_status in (0,1,2) $inputbillingsql  order by orders.order_id desc ";


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
                $newtemp->load_template('admin_montior_console', 5);
            } else {
                $newtemp->load_template('admin_montior_console', 4);
            }


            break;


    }
} else {
    $page_title = $lang[102];
    $newtemp->load_template('login_admin', 5);
}
