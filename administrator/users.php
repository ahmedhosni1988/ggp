<?php
session_start();
include("../setting.php");
include("../" . STYLE . "/usertemp.php");
include("../classes/account.php");
include("../classes/services.php");
include("../classes/company.php");
include("../classes/console.php");


$user = new users($db);
$account = new account($db);
$services = new services($db);
$company = new company($db);

$newtemp = new template();

if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}

if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == 1 && $_SESSION['status'] == 2 && $_SESSION['user_type'] == "administrator") {
    $open = "setup";

    
    if ($_SESSION['user_type'] != 'administrator') {
        $newtemp->load_template('unauthorized', 4);

        return;
    }
    
    switch ($action) {


        case 'edit':
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = $_GET['id'];
                $user_data = $user->get_admin_user($id);
                $newtemp->load_template('user_edit', 5);
            }
            break;

        case 'check_username':

            $num = check_duplication("users", "user_name", $_GET['user_name']);
            if ($num == 0) {
                echo true;
            } else {
                echo 0;
            }

            break;

        case 'add':

            if (isset($_POST["user_name"])) {
                $num = check_duplication_users("users", "user_name", $_POST['user_name'], 0);

                $_POST['email'] = trim($_POST['email']);

                if ($num == 0) {
                    $error_msg = '';
                    if (isset($_POST['user_pass']) && $_POST['user_pass'] != '') {
                        if ($_POST['confirm_password'] != $_POST['user_pass']) {
                            $error_msg = $lang[862];
                        } else {
                            $_POST['user_pass'] = md5($_POST['user_pass']);
                        }
                    }
                    unset($_POST['confirm_password']);
                    unset($_POST['edituser']);


                    if ($error_msg == '') {
                        $sql = make_insert("users", $_POST);
                        //echo 'ahmed';

                        $ed = $db->make_query($sql);

                        if ($ed) {
                            echo $lang[169];
                            $logger->compareAndLogV2($_SESSION['user_id'], "User_action", $_SESSION['user_id'], $_SESSION['name'], "Add", array(), $_POST);
                        } else {
                            echo $lang[168];
                        }
                    } else {
                        echo $error_msg;
                    }


                    //$user_id = $user->add_user(0,$_POST['user_name'],$_POST['user_pass'],$_POST['name'],$_POST['address'],$_POST['phone'],$_POST['fax'],$_POST['email'],$_POST['user_type'],2);

//echo $lang[169];
                } else {
                    echo $lang[168];
                }
            } else {
                $newtemp->load_template('add_admin_user', 5);
            }
            break;

        case 'show':
            $console = new console(7, $db);

            $console->set_page($pageno, PERPAGE);

            $coloums_array = array(array('headername' => '+', 'function' => 'show_user_option', 'pos' => 'last', 'width' => '100px', 'class' => 'nosort'));

            $header = $console->get_coloums_header($coloums_array);
            $grid_sql = $console->get_grid_sql($header, "  users where ".(isset($_GET['search']) ? $console->build_grid_search($header, $_GET['search_txt']) : '')." status = '2'  ");


            $data = $console->get_coloums_data($header, $grid_sql);
            $html_grid = $console->build_grid($header, $coloum_attribute, $data, $row_attribute, 'all_table');


            if ($_GET['ajax']) {
                echo $html_grid;
            } else {
                $newtemp->load_template('main_console', 5);
            }

            break;


        case 'edituser':
            if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
                $user_data = $user->get_admin_user($_POST['user_id']);

                $error_msg = '';
                if (isset($_POST['user_pass']) && $_POST['user_pass'] != '') {
                    if ($_POST['confirm_password'] != $_POST['user_pass']) {
                        $error_msg = $lang[862];
                    } else {
                        $_POST['user_pass'] = md5($_POST['user_pass']);
                    }
                } else {
                    unset($_POST['user_pass']);
                }
                unset($_POST['confirm_password']);
                unset($_POST['edituser']);


                if ($error_msg == '') {
                    $sql = $db->make_update("users", $_POST, 'user_id', $_POST['user_id']);
                    //echo $sql;

                    $ed = $db->make_query($sql);

                    if ($ed) {
                        echo $lang[863];
                        $o=object_to_array($user_data);
                        $logger->compareAndLogV2($_SESSION['user_id'], "User_action", $_SESSION['user_id'], $_SESSION['name'], "Edit ", $o, $_POST);
                    } else {
                        echo $lang[864];
                    }
                } else {
                    echo $error_msg;
                }
            }
            break;


        case 'delete':
            if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
                $ed = $user->delete_user($_GET['user_id']);
                if ($ed) {
                    echo $lang[170];
                } else {
                    echo $lang[171];
                }
            }
            break;


        default:


            $page_title = $lang[461];
            $newtemp->load_template('user_main', 4);
            break;
    }
} else {
    $page_title = $lang[102];
    $newtemp->load_template('login_admin', 5);
}
