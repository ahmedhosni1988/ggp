<?php
session_start();
include("setting.php");

include("classes/account.php");
include("classes/contact.php");
include("classes/company.php");
include("classes/orders.php");
include("classes/services.php");
include("classes/price.php");



if (!empty($_GET["action"])) {
    $action = $_GET["action"];
    $newtemp = new template();
    $account = new account($db);
    $contacts = new contacts($db);
    $notify = new notify($db);
    $company = new company($db);
    $order = new orders($db);
    $user = new users($db);
    $serClass = new services($db);
    $price = new price($db);

    $me = "0";

    if (!empty($_GET["button"])) {
        $button = $_GET["button"];
    } else {
        $button = "";
    }


//Start koko
    if (isset($_GET['admin']) && $_GET['admin'] == true) {
        $showicon_admin = true;
    } else {
        $showicon_admin = false;
    }

    if (isset($_GET['client']) && $_GET['client'] == true) {
        $showicon_client = true;
    } else {
        $showicon_client = false;
    }

    if (isset($_GET['register']) && $_GET['register'] == true) {
        $showicon_register = true;
    } else {
        $showicon_register = false;
    }

    if (isset($_GET['pricing']) && $_GET['pricing'] == true) {
        $showicon_pricing = true;
    } else {
        $showicon_pricing = false;
    }

    if (isset($_GET['tracking']) && $_GET['tracking'] == true) {
        $showicon_tracking = true;
    } else {
        $showicon_tracking = false;
    }

//End koko


    switch ($action) {

        case 'aboutus':

            $page = $company->get_page_status('aboutus')->page_body;

            $breadarray[0]['url'] = "index.php?action=aboutus";
            $breadarray[0]['name'] = "About Us";

            $page_title = $lang[2];
            $newtemp->load_template('index', 1, 1);
            break;

        case 'contactus':
            $page = $company->get_page_status('contactus')->page_body;

            $breadarray[0]['url'] = "index.php?action=contactus";
            $breadarray[0]['name'] = "Contact us";

            $page_title = $lang[3];
            $newtemp->load_template('index', 1, 1);
            break;

        case 'get_distance':
            if (isset($_POST['from_add']) && $_POST['from_add'] != '' && $_POST['to_add'] != '') {

                $service_details = $company->get_service($_POST['service_id']);

                $avoidtoll = ($service_details->service_avoidtolls == 'N' ? '' : 'tolls');
                $avoidhightways = ($service_details->service_avoidhightways == 'N' ? '' : 'highways');

                echo getDistance($_POST['from_add'], $_POST['to_add'], 'K', $avoidtoll, $avoidhightways);
            }
            break;

        case 'pricing':
            $res = "";
            $response = "";
            if (isset($_POST['g-recaptcha-response'])) {
                $captcha = $_POST['g-recaptcha-response'];

                if (!$captcha) {
                    $arr['service_name'] = "Error";
                    $arr['message_html'] = 'Please check the the captcha form.';
                    $res[] = $arr;
                }

                $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcnTSkTAAAAAG5iG2NcMhWaH01z2DlajMfIrLSr&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);
                if ($response['success'] == false) {
                    if (!isset($res[0])) {
                        $arr['service_name'] = "Error";
                        $arr['message_html'] = 'You are spammer ! Get the @$%K out';
                        $res[] = $arr;
                    }

                }

            }


            if (isset($_POST['from_pcode']) && isset($_POST['to_pcode']) && $response['success'] == true) {

                $services = $serClass->get_services();
                //$services[0]['service_id'] = 2;
                for ($o = 0; $o < count($services); $o++) {

                    $arr = "";


                    $meters = getDistance($_POST['from_address'] . "," . $_POST['from_pcode'], $_POST['to_address'] . ',' . $_POST['to_pcode'], "", $services[$o]['service_avoidtolls'], $services[$o]['service_avoidhightways']);
                    $service = $services[$o]['service_id'];
                    $from_pc = $_POST['from_pcode'];
                    $to_pc = $_POST['to_pcode'];
                    $returnto = "adminorder";
                    $calc_distance = $meters;
                    $req_vehicle = "Any";
                    $quotes_control = 2;
                    //echo $meters;
                    include "includes/pricecalc.php";


                    $arr['service_name'] = $services[$o]['service_name'];
                    if ($errormsg == "") {
                        //	$result;

                        $arr['message_html'] = template_price_list();
                        $arr['message_title'] = "Estimate Price";
                        $arr['message_type'] = "Price";
                        $arr['message'] = $result;
                    } else {
                        $arr['message_html'] = template_price_list();
                        $arr['message_type'] = "PriceError";
                        $arr['message_title'] = "Error in Estimate Price";
                        $arr['message'] = $errormsg;
                        $arr['warning'] = $rowwarnings;
                    }

                    $res[] = $arr;


                }


            } else {

                $services = $serClass->get_services();


            }

            $page_title = $lang[966];
            $newtemp->load_template('price_order', 7);

            break;


        case 'register':
            if (isset($_POST["companyname"]) && $_POST["companyname"] == "") {
                echo $lang[203];
                return;
            }

            if (isset($_POST["email"]) && !valid_email($_POST["email"])) {
                echo "Please enter Email";
                return;
            }

            // Start koko
            if (isset($_POST["terms_checkbox"]) && $_POST["terms_checkbox"] != "check") {
                echo "Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy";
                return;
            }
            // End koko

            if (isset($_POST['g-recaptcha-response'])) {
                $captcha = $_POST['g-recaptcha-response'];

                if (!$captcha) {
                    echo 'Please check the the captcha form.';
                    return;
                }

                $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcnTSkTAAAAAG5iG2NcMhWaH01z2DlajMfIrLSr&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);
                if ($response['success'] == false) {
                    echo 'You are spammer ! Get the @$%K out';
                    return;
                }

            }


            if (isset($_POST["companyname"]) && $_POST["companyname"] != "" && $response['success'] != false) {

                $name = date("y") . $c_setting["co_next_tempacctno"];

                $array["co_next_tempacctno"] = $c_setting["co_next_tempacctno"] + 1;
                $company->update_company_details($array);

                $added = $account->add_account($name, $_POST['companyname'], $_POST['address'], $_POST['city'], $_POST['pcode'], $_POST['phone'], $_POST['fax'], 6, 0, 0, 0);

                if (is_numeric($added)) {
                    mysql_query("update account set billing_code='1', account_billingfreq = '1',  account_method = '1', account_taxgroup = '1' , online_invoicing_email = '" . $_POST['email'] . "' , market_way = '" . $_POST['market_way'] . "' where account_id = '" . $added . "'  ") or die (mysql_error());


                    $password = generateRandomCode(4);
                    $user->add_user($added, "admin", $password, $_POST['companyname'], $_POST['address'], $_POST['phone'], $_POST['fax'], $_POST['email'], "administrator", '1');

                    $con_name[0] = $_POST['contact'];
                    $con_phone[0] = $_POST['phone'];
                    $con_email[0] = $_POST['email'];
                    $con_emailnotify[0] = "1";

                    $account->insert_contact_account($con_name, $con_phone, $con_email, $con_emailnotify, $added);

                }

                if ($added) {
                    $notify->add_notify("new_user", $added, 0);
                    $emails_to_send = $company->get_email_to_send($c_setting, "1");


                    if ($emails_to_send != "") {
                        $m_d['@Name'] = $_POST['companyname'];
                        $m_d['@contact'] = $_POST['contact'];
                        $m_d['@phone'] = $_POST['phone'];
                        $m_d['@address'] = $_POST['address'];
                        $m_d['@pcode'] = $_POST['pcode'];
                        $m_d['@city'] = $_POST['city'];
                        $m_d['@email'] = $_POST['email'];
                        $m_d['@user_id'] = "admin";
                        $m_d['@password'] = $password;
                        $m_d['@account_id'] = $name;
                        $m_d['@site_name'] = SITENAME;

                        if (valid_email($_POST['email'])) {
                            $message = $company->get_message_details("user_login", $m_d);

                            mymail($_POST['email'], $c_setting['co_main_email'], $message['subject'], $message['body'], $smtp);

                            $mes['event'] = "New customer username";
                            $mes['sentfrom'] = "Client Register";
                            $mes['acctno'] = $name;
                            $mes["mailto"] = $_POST['email'];
                            $mes["mailfrom"] = $c_setting['co_main_email'];
                            $mes["subject"] = $message['subject'];
                            $mes["body"] = $message['body'];
//$mes["sentfrom"]  = $emails_to_send[$n]['type'];
                            log_email($mes);

                        }

                        $message_details = $company->get_message_details("new_customer", $m_d);

                        for ($n = 0; $n < count($emails_to_send); $n++) {

                            if ($emails_to_send[$n]['email'] != "") {

                                mymail($emails_to_send[$n]['email'], $c_setting['co_main_email'], $message_details['subject'], $message_details['body'], $smtp);

                                $mes['event'] = "New customer signup";
                                $mes['sentfrom'] = "Client Login";
                                $mes['acctno'] = $name;
                                $mes["mailto"] = $emails_to_send[$n]['email'];
                                $mes["mailfrom"] = $c_setting['co_main_email'];
                                $mes["subject"] = $message_details['subject'];
                                $mes["body"] = $message_details['body'];
                                $mes["sentfrom"] = $emails_to_send[$n]['type'];
                                log_email($mes);
                            }

                        }


                    }

                    echo $lang[202];

                } else echo $lang[203];
            } else {

                $breadarray[0]['url'] = "index.php?action=register";
                $breadarray[0]['name'] = "Register";

                $page_title = $lang[4];
                $newtemp->load_template('register', 7, 0);
            }
            break;

// Start koko
        case 'terms_condition':
            $newtemp->load_template('terms_condition', 7);
            break;
// End koko


        case 'get_page':
            if (isset($_GET['page_id'])) {
                $page = $company->get_page($_GET['page_id']);
                echo nl2br($page->page_body);
            }
            break;


        case 'tracking':
            if ($c_setting['tracking'] == 'Y') {

                $trackno = '';

                if (isset($_GET['trackno'])) $trackno = $_GET['trackno'];

                if (isset($_POST['trackno'])) $trackno = $_POST['trackno'];

                if ($trackno != '') {
                    $order_id = substr($trackno, 14, strlen($trackno));
                    //echo $order_id;

                    $order_details = $order->get_order_details($order_id);

                }


                $breadarray[0]['url'] = "index.php?action=tracking";
                $breadarray[0]['name'] = $lang[937];

                $page_title = $lang[923];
                $newtemp->load_template('tracking', 7);
            }
            break;


        case 'get_time':
            echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $lang[972] . " : " . date(DATETIME_FORMAT);

            break;

        case 'get_page_title':
            if (isset($_GET['page_id'])) {
                $page = $company->get_page($_GET['page_id']);
                echo $page->page_name;
            }
            break;

        default :
            header("Location: " . SITEURL . "/administrator");
            break;
    }
    }
    else {
            /* i not have any action value in _GET['action'] os go to index.php from administrator direcroty */
        header("Location: " . SITEURL . "/administrator");
}



?>