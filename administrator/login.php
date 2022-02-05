<?php
session_start();
include("../setting.php");
include("../classes/company.php");

$newtemp = new template();

$user = new users($db);
$companyClass = new company($db);


if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}


switch ($action) {

    case 'login':


        if (isset($_POST)) {

            empty($_SESSION);
            $login = $user->Check_admin_login(trim($_POST['user_name']), $_POST['user_pass']);

            if ($login['login'] == true) {

                $cookiehash = md5(sha1($login['user_name'] . $login['user_id'])) . '_admin';


                setcookie("username", $cookiehash, time() + 3600 * 24 * 365, '/', SITEURL);

                mysql_query("update users set cookies = '" . $cookiehash . "' where user_id = '" . $login['user_id'] . "'  ");
                if (isset($_POST['language']) && $_POST['language'] != "") $_SESSION['language'] = $_POST['language'];

                $user->set_login_sessions($login);
                $_SESSION['logged_in'] = true;

//header("Location: ".SITEURL.'/administrator/montior.php?action=all');

$logger->compareAndLogV2($_SESSION['user_id'],"User_action", $_SESSION['user_id'],  $_SESSION['name'], "Login ",array(), $_SESSION);



                if ($login['user_type'] == 'administrator' || $login['user_type'] == 'addmanger' || $login['user_type'] == 'manmanger') {

                    header("Location: " . SITEURL . "/administrator/index.php");

                } elseif ($login['user_type'] == 'manger') {
                    header("Location: " . SITEURL . "/administrator/manger.php");

                } elseif ($login['user_type'] == 'accounting') {
                    header("Location: " . SITEURL . "/administrator/accounting.php");

                }elseif ($login['user_type'] == 'smallaccounting') {
                    header("Location: " . SITEURL . "/administrator/accounting.php");

                }else if ($login['user_type'] == '7'){
                    header("Location: " . SITEURL . "/administrator/work.php?action=pointing");

                } else {
                    header("Location: " . SITEURL . "/administrator/work.php");

                }


            } else {
                header("Location: " . SITEURL . '/administrator/login.php?e=1');
//$newtemp->redirect_page(SITEURL.'/administrator/index.php?e=1',$lang[77]);
            }


        } else {
            $newtemp->redirect_page(SITEURL . '/administrator', $lang[77]);

        }

        break;


    case 'forget_password':

        if (isset($_POST['email'])) {

            if (!valid_email($_POST['email'])) {
                $res['type'] = "error";
                $res['message'] = "Email is not valid";
                echo json_encode($res);
                return;

            }

            if (isset($_POST['g-recaptcha-response'])) {
                $captcha = $_POST['g-recaptcha-response'];

                if (!$captcha) {
                    $res['type'] = "error";
                    $res['message'] = 'Please check the the captcha form.';
                    echo json_encode($res);

                    return;
                }

                $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcnTSkTAAAAAG5iG2NcMhWaH01z2DlajMfIrLSr&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);
                if ($response['success'] == false) {
                    $res['type'] = "error";
                    $res['message'] = 'You are spammer ! Get the @$%K out';
                    echo json_encode($res);

                    return;
                }

            }


            /////check email

            $userData = $user->forget_password($_POST['email'], "admin");

            if ($userData == false) {
                $res['type'] = "error";
                $res['message'] = 'Error in email,Please contact administrator at ' . $c_setting['co_mail_replayto'];
                echo json_encode($res);

            } else if ($userData == 1) {

                $res['type'] = "error";
                $res['message'] = 'Email not found in our database';
                echo json_encode($res);

            } else {

                /////

                $m_d['@sitename'] = SITENAME;
                $m_d['@name'] = $userData['name'];
                $m_d['@username'] = $userData['user_name'];
                $m_d['@link'] = SITEURL . '/administrator/login.php?action=resetpassword&code=' . $userData['code'];
                $message_details = $companyClass->get_message_details("admin_forget_password", $m_d);
                mymail($userData['email'], $c_setting['co_main_email'], $message_details['subject'], $message_details['body'], $smtp);


                $mes['event'] = "forget-password";
                $mes['sentfrom'] = "login-admin";
                $mes["mailto"] = $userData['email'];
                $mes["mailfrom"] = $c_setting['co_main_email'];
                $mes["subject"] = $message_details['subject'];
                $mes["body"] = $message_details['body'];
                $mes["sentto"] = "admin";
                log_email($mes);


                $res['type'] = "true";
                $res['message'] = "Email sent, please follow instructions";
                echo json_encode($res);

            }


        } else {
            $page_title = "Forget Password";
            $newtemp->load_template('forget_password', 5);

        }

        break;


    case 'resetpassword':
        if (isset($_POST['code'])) {

            if (isset($_POST['g-recaptcha-response'])) {
                $captcha = $_POST['g-recaptcha-response'];

                if (!$captcha) {
                    $res['type'] = "error";
                    $res['message'] = 'Please check the the captcha form.';
                    echo json_encode($res);

                    return;
                }

                $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcnTSkTAAAAAG5iG2NcMhWaH01z2DlajMfIrLSr&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);
                if ($response['success'] == false) {
                    $res['type'] = "error";
                    $res['message'] = 'You are spammer ! Get the @$%K out';
                    echo json_encode($res);

                    return;
                }

            }

            if ($_POST['password'] != $_POST['confirm_passord']) {

                $res['type'] = "error";
                $res['message'] = 'Password not matched';
                echo json_encode($res);
                return;


            }

            if (strlen($_POST['password']) < 4) {

                $res['type'] = "error";
                $res['message'] = 'Password is too short';
                echo json_encode($res);
                return;

            }


            ////update password
            $res = $user->update_password($_POST['password'], $_POST['code']);

            $res['type'] = "true";
            $res['message'] = 'Password Changed';
            echo json_encode($res);

            //header("Location: ".SITEURL.'/administrator/login.php?e=11');


        } else {

            if (isset($_GET['code']) && $_GET['code'] != "") {

                $res = $user->check_code($_GET['code']);

                if ($res == false) {

                    header("Location: " . SITEURL . '/administrator/login.php?e=9');

                } else {

                    $page_title = "New Password";
                    $newtemp->load_template('new_password', 5);

                }
            } else {
                header("Location: " . SITEURL . '/administrator/login.php?e=9');


            }
        }
        break;

    default :


        $page_title = $lang[20];
        $newtemp->load_template('login_admin', 5);
        break;
}


?>