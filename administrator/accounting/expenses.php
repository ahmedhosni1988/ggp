<?php
session_start();
include("../../setting.php");

include("../../classes/account.php");
include("../../classes/work.php");
include("../../classes/console.php");

$accountClass = new account($db);
$workClass = new work($db);


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
            

            
            
            case 'add_edit_expenses':

                if (isset($_POST['action_time'])) {
                    $exp = array();

                    $exp['created_time'] = date('Y-m-d H:i:s');
                    $exp['created_by'] = $_SESSION['user_id'];
                    $exp['amount'] = $_POST['amount'];
                    $exp['expense_type'] = $_POST['expense_type'];
                    $exp['action_time'] = date('Y-m-d', strtotime($_POST['action_time']));
                    $exp['note'] = $_POST['note'];
                    $exp['received_person'] = $_POST['received_person'];



                    if (is_numeric($_POST['id']) && $_POST['id'] > 0) {
                        unset($exp['created_time']);
                        unset($exp['created_by']);
                        $sql = make_update('expenses', $exp, 'id', $_POST['id']);
                        $q = mysqli_query($mycon, $sql);
                        if ($q) {
                            echo 'تمت الاضافة بنجاح';
                        } else {
                            echo 'خطا فى لااضافة';
                        }
                    } else {
                        $sql = make_insert('expenses', $exp);
                        $q = mysqli_query($mycon, $sql);
                        if ($q) {
                            echo 'تمت الاضافة بنجاح';
                        } else {
                            echo 'خطا فى لااضافة';
                        }
                    }
                } else {
                    if (isset($_GET['id'])) {
                        $q = mysqli_query($mycon, "select * from expenses where id = '".$_GET['id']."' ");

                        $expDetails = mysqli_fetch_object($q);
                    }
                    $breadarray[0]['url'] = "expenses.php";
                    $breadarray[0]['name'] = "المصروفات";

                    $breadarray[1]['url'] = "#";
                    $breadarray[1]['name'] = "اضافة مصروف";
        
                    $exp_type = $workClass->get_combo_box('expense_type');
                    $newtempAll->load_template('add_expenses', 1, 'accounting_menu');
                }
            

            break;

            default:

            $console = new console(28, $db);
            $console->set_allowtotal("0");
            $console->set_ND("Y");
            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }
            $console->set_page($pageno, PERPAGE);
            
            $coloums_array = array(array('headername' => '+', 'function' => 'show_expensee_row_option', 'pos' => 'last', 'width' => '100px', 'class' => 'nosort'));

            $coloums = $console->get_coloums_header($coloums_array, $dir, $field_name);



//var_dump($coloums);


            $grid_sql = $console->get_grid_sql($coloums, "  expenses
inner join users on (users.user_id = expenses.created_by) 
inner join lookup_addtional on (lookup_addtional.id = expenses.expense_type && lookup_addtional.type = 'expense_type' ) 
   ");
            $query = $grid_sql . " where  ".(isset($_GET['search']) ? $console->build_grid_search($coloums, $_GET['search_txt']) : '')." 1=1     ".(isset($_POST['dir']) ? "order by  ".$table_name.".".$field_name." ".$dir."" : "order by expenses.created_time desc ");


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

            $breadarray[0]['url'] = "expenses.php";
            $breadarray[0]['name'] = "المصروفات";

            // $breadarray[1]['url'] = "";
            // $breadarray[1]['name'] = "كل الطلبيات";

            $page_title = "العملاء";

            if ($_GET['ajax']) {
                echo $html_grid;
            } else {
                $newtempAll->load_template('accounting_console', 1, 'accounting_menu');
            }

        

            break;

            
    }
}
