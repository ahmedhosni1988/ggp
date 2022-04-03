<?php
session_start();
include("../setting.php");
include("../" . STYLE . "/optiontemp.php");
include("../classes/contact.php");
include("../classes/account.php");
include("../classes/services.php");
include("../classes/package.php");
include("../classes/payment.php");
include("../classes/orders.php");
include("../classes/console.php");
include("../classes/company.php");


$user = new users($db);
$contacts = new contacts($db);
$account = new account($db);
$services = new services($db);
$package = new package($db);
$payment = new payment($db);
$order = new orders($db);
$company = new company($db);
$console = new console($db);

$newtemp = new template();

if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}


if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == 1 && $_SESSION['status'] == 2 && $_SESSION['user_type'] == "administrator") {
    $open = "setup";
    switch ($action) {

        case 'option':
            if (isset($_POST["co_name"])) {
                foreach ($_POST as $key => $value) {
                    $kv[$key] = $value;
                }
                $r = $company->update_company_details($kv);

                if ($r) {
                    echo $lang[146];
                //$newtemp->redirect_page(SITEURL.'/administrator/admin_index.php',$lang[146]);
                } else {
                    echo $lang[147];
                    //$newtemp->redirect_page(SITEURL.'/administrator/admin_index.php',$lang[147]);
                }
            } else {
                $sett_compnay = $company->get_company_details();
                $page_title = $lang[116];
                $newtemp->load_template('admin_option_setting', 5);
            }
            break;


        case 'email_manage':
            $newtemp->load_template('email_manage', 5);
            break;


        case 'email_setting':
            if (isset($_POST["co_main_email"])) {
                foreach ($_POST as $key => $value) {
                    $kv[$key] = $value;
                }
                $r = $company->update_company_details($kv);

                if ($r) {
                    $_POST['edit_company'] = "";
                    //$newtemp->redirect_page(SITEURL.'/administrator/admin_index.php',$lang[146]);
                    echo $lang[846];
                } else {
                    $_POST['edit_company'] = "";
                    echo $lang[847];
                    //$newtemp->redirect_page(SITEURL.'/administrator/admin_index.php',$lang[147]);
                }
            } else {
                $sett_compnay = $company->get_company_details();

                $page_title = $lang[121];
                $newtemp->load_template('email_setting', 5);
            }
            break;

        case 'manage_services':
            $newtemp->load_template('services_manage', 5);
            break;

        case 'services_setting':
            $ser = $company->get_services();
            $newtemp->load_template('services_setting', 5);
            break;

        case 'add_services':
            if (isset($_POST['service_name']) && $_POST['service_name'] != "") {
                $h = $_POST['hour'];
                $m = $_POST['minuit'];

                $_POST['service_deliverytime'] = $h . ':' . $m;
                unset($_POST['hour']);
                unset($_POST['minuit']);

                $_POST['service_color'] = str_replace("#", "", $_POST['service_color']);
                $sql = $db->make_insert("services", $_POST);
                //echo $sql;
                $res = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));
                // $res =  $company->add_services($service_name,$service_des,$service_short,$service_color,$service_cuttime,$service_order);


                if ($res) {
                    echo $lang[948];
                } else {
                    echo $lang[153];
                }
            } else {
                $newtemp->load_template('add_services', 5);
            }
            break;

        case 'edit_service':
            if (isset($_POST['service_name']) && $_POST['service_name'] != "") {
                $h = $_POST['hour'];
                $m = $_POST['minuit'];

                $_POST['service_deliverytime'] = $h . ':' . $m;
                unset($_POST['hour']);
                unset($_POST['minuit']);

                $_POST['service_color'] = str_replace("#", "", $_POST['service_color']);


                $sql = $db->make_update("services", $_POST, "service_id", $_POST['service_id']);
                $res = mysqli_query($mycon, $sql) or die(mysqli_error($mycon));

                if ($res) {
                    echo $lang[152];
                } else {
                    echo $lang[153];
                }
            } else {
                if (isset($_GET['id'])) {
                    $ser = $company->get_service($_GET['id']);
                    $newtemp->load_template('edit_services', 5);
                }
            }

            break;

        case 'manage_category':
            $newtemp->load_template('mange_category', 5);
            break;

        case 'category_setting':
            $console = new console(5, $db);
            $header = $console->get_coloums_header();
            $data = $console->get_coloums_data_sql($header, "  client_category");
            $newtemp->load_template('category_setting', 5);
            break;

        case 'add_category':
            if (isset($_POST['cat_name']) && $_POST['cat_name'] != "") {
                $res = $account->add_account_category($_POST['cat_name'], $_POST['cat_type']);
                if ($res) {
                    $_POST['addcat'] = "";
                    echo $lang[139];
                    $logger->compareAndLogV2((int)mysqli_insert_id($mycon), "Category", $_SESSION['user_id'], $_SESSION['name'], "ُAdd ", array(), $_POST);
                } else {
                    $_POST['addcat'] = "";
                    echo $lang[140];
                }
            } else {
                $newtemp->load_template('add_category', 5);
            }
            break;

        case 'category_edit':
            if (isset($_POST['cat_id']) && $_POST['cat_id'] != "") {
                $resold = $account->get_category($_POST['cat_id']);
                $resold=object_to_array($resold);
                //var_dump($resold);
                $res = $account->update_category($_POST['cat_id'], $_POST['cat_name_edit'], $_POST['cat_type_edit']);
                if ($res) {
                    echo $lang[139];
                    $logger->compareAndLogV2((int)$_POST['cat_id'], "Category", $_SESSION['user_id'], $_SESSION['name'], "ُEdit", $resold, $_POST);
                } else {
                    echo $lang[140];
                }
            } else {
                $res = $account->get_category($_GET['cat_id']);
                $newtemp->load_template('category_edit', 5);
            }
            break;


        case 'deletecat':
            if (isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
                $resold = $account->get_category($_GET['cat_id']);
                $resold=object_to_array($resold);
                $res = $account->del_account_category($_GET['cat_id']);
                if ($res) {
                    echo $lang[141];
                    $logger->compareAndLogV2((int)$_GET['cat_id'], "Category", $_SESSION['user_id'], $_SESSION['name'], "ُDelelt", array(), $resold);
                } else {
                    echo $lang[142];
                }
            }
            break;


        case 'taxes_setting':

            if (isset($_POST['tax_id'])) {
                $tax_id = $_POST['tax_id'];
                $tax_name = $_POST['tax_name'];
                $tax_rate = $_POST['tax_rate'];

                $res = false;
                for ($i = 0; $i < count($tax_id); $i++) {
                    //echo "$service_id[$i],$service_name[$i],$service_des[$i],$service_short[$i],$service_color[$i],$service_cuttime[$i],$service_order[$i].<br>";

                    if (is_numeric($tax_id[$i])) {
                        $res = $company->update_tax($tax_id[$i], $tax_name[$i], $tax_rate[$i]);
                    } else {
                        if ($tax_name[$i] != "") {
                            $res = $company->add_tax($tax_name[$i], $tax_rate[$i]);
                        }
                    }
                }

                if ($res) {
                    $_POST['savetax'] = "";
                    echo $lang[152];
                } else {
                    $_POST['savetax'] = "";
                    echo $lang[153];
                }
            } elseif (isset($_POST["group_name"])) {
                $group_id = $_POST['group_id'];
                $group_name = $_POST['group_name'];
                $tax1 = $_POST['tax1'];
                $tax2 = $_POST['tax2'];
                $fs = $_POST['fs'];


                $res = false;
                for ($i = 0; $i < count($group_id); $i++) {
                    //echo "$service_id[$i],$service_name[$i],$service_des[$i],$service_short[$i],$service_color[$i],$service_cuttime[$i],$service_order[$i].<br>";

                    if (isset($_POST['tax2_on_tax1'])) {
                        $tax2_on_tax1 = $_POST['tax2_on_tax1'];
                    } else {
                        $tax2_on_tax1[$i] = 0;
                    }
                    if (!array_key_exists($i, $tax2_on_tax1)) {
                        $tax2_on_tax1[$i] = 0;
                    }


                    if (isset($_POST['fs_rate_1'])) {
                        $fs_rate_1 = $_POST['fs_rate_1'];
                    } else {
                        $fs_rate_1[$i] = 0;
                    }
                    if (!array_key_exists($i, $fs_rate_1)) {
                        $fs_rate_1[$i] = 0;
                    }

                    if (isset($_POST['fs_rate_2'])) {
                        $fs_rate_2 = $_POST['fs_rate_2'];
                    } else {
                        $fs_rate_2[$i] = 0;
                    }

                    if (!array_key_exists($i, $fs_rate_2)) {
                        $fs_rate_2[$i] = 0;
                    }
                    //$fs_services = array(); $fs_wait = array(); $fs_addition = array();
                    if (isset($_POST['fs_services'])) {
                        $fs_services = $_POST['fs_services'];
                    } else {
                        $fs_services[$i] = 0;
                    }

                    if (isset($_POST['fs_wait'])) {
                        $fs_wait = $_POST['fs_wait'];
                    } else {
                        $fs_wait[$i] = 0;
                    }

                    if (isset($_POST['fs_addition'])) {
                        $fs_addition = $_POST['fs_addition'];
                    } else {
                        $fs_addition[$i] = 0;
                    }


                    if (!array_key_exists($i, $fs_services)) {
                        $fs_services[$i] = 0;
                    }


                    if (!array_key_exists($i, $fs_wait)) {
                        $fs_wait[$i] = 0;
                    }


                    if (!array_key_exists($i, $fs_addition)) {
                        $fs_addition[$i] = 0;
                    }


                    $taxgroup_on = $fs_services[$i] . ',' . $fs_wait[$i] . ',' . $fs_addition[$i];


                    if (is_numeric($group_id[$i])) {
                        $res = $company->update_taxgroup($group_id[$i], $group_name[$i], $tax1[$i], $tax2[$i], $tax2_on_tax1[$i], $fs[$i], $fs_rate_1[$i], $fs_rate_2[$i], $taxgroup_on);
                    } else {
                        if ($group_name[$i] != "") {
                            $res = $company->insert_taxgroup($group_name[$i], $tax1[$i], $tax2[$i], $tax2_on_tax1[$i], $fs[$i], $fs_rate_1[$i], $fs_rate_2[$i], $taxgroup_on);
                        }
                    }
                }


                if ($res) {
                    $_POST['savegroup'] = "";
                    echo $lang[152];
                } else {
                    $_POST['savegroup'] = "";
                    echo $lang[153];
                }
            } else {
                $tax_group = $company->get_tax_group();
                $tax = $company->get_tax();
                $page_title = $lang[154];
                $newtemp->load_template('taxes_setting', 5);
            }
            break;

        case 'invoice_setting':
            if (isset($_POST['co_invoice_message'])) {
                $payment_id = $_POST['payment_id'];
                $payment_name = $_POST['payment_name'];
                $payment_order = $_POST['payment_order'];

                $res = false;
                for ($i = 0; $i < count($payment_id); $i++) {
                    //echo "$service_id[$i],$service_name[$i],$service_des[$i],$service_short[$i],$service_color[$i],$service_cuttime[$i],$service_order[$i].<br>";

                    if (is_numeric($payment_id[$i])) {
                        $res = $payment->update_payment($payment_id[$i], $payment_name[$i], $payment_order[$i]);
                    } else {
                        if ($payment_name[$i] != "") {
                            $res = $payment->add_payment($payment_name[$i], $payment_order[$i]);
                        }
                    }
                }


                $option_id = $_POST['option_id'];
                $option_value = $_POST['option_value'];


                $res = false;
                for ($i = 0; $i < count($option_id); $i++) {
                    if (is_numeric($option_id[$i])) {
                        $res = $company->update_billing_frequency($option_id[$i], $option_value[$i]);
                    } else {
                        if ($option_value[$i] != "") {
                            $res = $company->insert_billing_frequency("Billing_Frequency", $option_value[$i]);
                        }
                    }
                }


                $pt_id = $_POST['pt_id'];
                $pt_name = $_POST['pt_name'];
                $pt_des = $_POST['pt_des'];
                $pt_due = $_POST['pt_due'];
                $res = false;
                for ($i = 0; $i < count($pt_id); $i++) {
                    if (is_numeric($pt_id[$i])) {
                        $res = $payment->update_payment_term($pt_id[$i], $pt_name[$i], $pt_des[$i], $pt_due[$i]);
                    } else {
                        if ($pt_name[$i] != "") {
                            $res = $payment->add_payment_term($pt_name[$i], $pt_des[$i], $pt_due[$i]);
                        }
                    }
                }


                unset($_POST['payment_type']);
                unset($_POST['payment_id']);
                unset($_POST['payment_name']);
                unset($_POST['payment_order']);
                unset($_POST['payment_fre']);
                unset($_POST['option_id']);
                unset($_POST['option_value']);
                unset($_POST['add_term']);
                unset($_POST['pt_id']);
                unset($_POST['pt_name']);
                unset($_POST['pt_des']);
                unset($_POST['pt_due']);


                $r = $company->update_company_details($_POST);
            } else {
                $payment_type = $payment->get_payment();
                $payment_term = $payment->get_payment_term();
                $payment_frequency = $company->get_billing_frequency();
                $setting = $company->get_option("");
                $page_title = $lang[158];
                $newtemp->load_template('invoice_setting', 5);
            }
            break;


        case 'mange_page':
            if (!empty($_GET["type"])) {
                $type = $_GET["type"];
            } else {
                $type = "";
            }

            switch ($type) {

                case 'edit_page':
                    if (isset($_GET['id'])) {
                        $page = $company->get_page($_GET['id']);
                        $newtemp->load_template('edit_page', 5);
                    }
                    break;

                case 'edit':
                    if (isset($_POST['page_id'])) {
                        $epage = $company->edit_page($_POST);
                        echo "Pages Saved";
                    }
                    break;

                default:
                    $pages = $company->get_all_page();
                    $page_title = $lang[574];
                    $newtemp->load_template('mange_page', 5);
                    break;
            }

            break;


        case 'mlogo':
            include("../classes/class.upload.php");

            if (isset($_POST['upload'])) {
                $dir_dest = "../images/";

                //Invoice_Logo
                $handle = new Upload($_FILES['invoice_logo']);
                if ($handle->uploaded) {

                    // yes, the file is on the server
                    // below are some example settings which can be used if the uploaded file is an image.
                    $handle->image_resize = true;
                    //$handle->image_ratio_y           = true;
                    $handle->image_x = 300;
                    $handle->image_y = 140;
                    $handle->image_convert = 'jpg';
                    $handle->jpeg_quality = 80;
                    $handle->file_new_name_body = 'invoice_banner';
                    $handle->file_overwrite = true;
                    // now, we start the upload 'process'. That is, to copy the uploaded file
                    // from its temporary location to the wanted location
                    // It could be something like $handle->Process('/home/www/my_uploads/');
                    $handle->Process($dir_dest);

                    // we check if everything went OK
                    if ($handle->processed) {
                        // everything was fine !
                        echo '<p class="result">';
                        echo '  <b>File uploaded with success</b><br />';
                        echo '  <img src="' . $dir_pics . '/' . $handle->file_dst_name . '" />';
                        $info = getimagesize($handle->file_dst_pathname);
                        echo '  File: <a href="' . $dir_pics . '/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a><br/>';
                        echo '   (' . $info['mime'] . ' - ' . $info[0] . ' x ' . $info[1] . ' -  ' . round(filesize($handle->file_dst_pathname) / 256) / 4 . 'KB)';
                        echo '</p>';
                    } else {
                        // one error occured
                        echo '<p class="result">';
                        echo '  <b>File not uploaded to the wanted location</b><br />';
                        echo '  Error: ' . $handle->error . '';
                        echo '</p>';
                    }

                    // we now process the image a second time, with some other settings


                    // we delete the temporary files
                    $handle->Clean();
                } else {
                    // if we're here, the upload file failed for some reasons
                    // i.e. the server didn't receive the file
                    echo '<p class="result">';
                    echo '  <b>File not uploaded on the server</b><br />';
                    echo '  Error: ' . $handle->error . '';
                    echo '</p>';
                }


                //Waybill_Logo
                $handle = new Upload($_FILES['waybill_banner']);
                if ($handle->uploaded) {

                    // yes, the file is on the server
                    // below are some example settings which can be used if the uploaded file is an image.
                    $handle->image_resize = true;
                    //$handle->image_ratio_y           = true;
                    $handle->image_x = 300;
                    $handle->image_y = 140;
                    $handle->image_convert = 'jpg';
                    $handle->jpeg_quality = 80;
                    $handle->file_new_name_body = 'waybill_banner';
                    $handle->file_overwrite = true;
                    // now, we start the upload 'process'. That is, to copy the uploaded file
                    // from its temporary location to the wanted location
                    // It could be something like $handle->Process('/home/www/my_uploads/');
                    $handle->Process($dir_dest);

                    // we check if everything went OK
                    if ($handle->processed) {
                        // everything was fine !
                        echo '<p class="result">';
                        echo '  <b>File uploaded with success</b><br />';
                        echo '  <img src="' . $dir_pics . '/' . $handle->file_dst_name . '" />';
                        $info = getimagesize($handle->file_dst_pathname);
                        echo '  File: <a href="' . $dir_pics . '/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a><br/>';
                        echo '   (' . $info['mime'] . ' - ' . $info[0] . ' x ' . $info[1] . ' -  ' . round(filesize($handle->file_dst_pathname) / 256) / 4 . 'KB)';
                        echo '</p>';
                    } else {
                        // one error occured
                        echo '<p class="result">';
                        echo '  <b>File not uploaded to the wanted location</b><br />';
                        echo '  Error: ' . $handle->error . '';
                        echo '</p>';
                    }

                    // we now process the image a second time, with some other settings


                    // we delete the temporary files
                    $handle->Clean();
                } else {
                    // if we're here, the upload file failed for some reasons
                    // i.e. the server didn't receive the file
                    echo '<p class="result">';
                    echo '  <b>File not uploaded on the server</b><br />';
                    echo '  Error: ' . $handle->error . '';
                    echo '</p>';
                }


                //Invoice_Logo
                $handle = new Upload($_FILES['logo']);
                if ($handle->uploaded) {

                    // yes, the file is on the server
                    // below are some example settings which can be used if the uploaded file is an image.
                    $handle->image_resize = true;
                    //$handle->image_ratio_y           = true;
                    $handle->image_x = 300;
                    $handle->image_y = 140;
                    $handle->image_convert = 'jpg';
                    $handle->jpeg_quality = 80;
                    $handle->file_new_name_body = 'logo';
                    $handle->file_overwrite = true;
                    // now, we start the upload 'process'. That is, to copy the uploaded file
                    // from its temporary location to the wanted location
                    // It could be something like $handle->Process('/home/www/my_uploads/');
                    $handle->Process($dir_dest);

                    // we check if everything went OK
                    if ($handle->processed) {
                        // everything was fine !
                        echo '<p class="result">';
                        echo '  <b>File uploaded with success</b><br />';
                        echo '  <img src="' . $dir_pics . '/' . $handle->file_dst_name . '" />';
                        $info = getimagesize($handle->file_dst_pathname);
                        echo '  File: <a href="' . $dir_pics . '/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a><br/>';
                        echo '   (' . $info['mime'] . ' - ' . $info[0] . ' x ' . $info[1] . ' -  ' . round(filesize($handle->file_dst_pathname) / 256) / 4 . 'KB)';
                        echo '</p>';
                    } else {
                        // one error occured
                        echo '<p class="result">';
                        echo '  <b>File not uploaded to the wanted location</b><br />';
                        echo '  Error: ' . $handle->error . '';
                        echo '</p>';
                    }

                    // we now process the image a second time, with some other settings


                    // we delete the temporary files
                    $handle->Clean();
                } else {
                    // if we're here, the upload file failed for some reasons
                    // i.e. the server didn't receive the file
                    echo '<p class="result">';
                    echo '  <b>File not uploaded on the server</b><br />';
                    echo '  Error: ' . $handle->error . '';
                    echo '</p>';
                }

                $ext = array('jpg', 'png');

                /// upload invoice logo
                // 		$imageFileType = pathinfo(basename($_FILES['invoice_logo']['name']),PATHINFO_EXTENSION);

                // 		$target_dir = "../images/";
                // 		$target_file = $target_dir . 'invoice_banner.'.$imageFileType;
                // 		if(isset($_FILES['invoice_logo']['name']) && $_FILES['invoice_logo']['name'] != '' && in_array($imageFileType, $ext)  ){
                // 			if (move_uploaded_file($_FILES["invoice_logo"]["tmp_name"], $target_file)) {
                // 				img_resize($target_dir, $target_file, 'invoice_banner.'.$imageFileType, '380', '140');
                // 			}
                // 		}

                // 		$imageFileType = pathinfo(basename($_FILES['waybill_banner']['name']),PATHINFO_EXTENSION);

                // 		$target_file = $target_dir . 'waybill_banner'.$imageFileType;
                // 		if(isset($_FILES['waybill_banner']['name']) && $_FILES['waybill_banner']['name'] != '' && in_array($imageFileType, $ext)  ){
                // 			if (move_uploaded_file($_FILES["waybill_banner"]["tmp_name"], $target_file)) {
                // 			img_resize($target_dir, $target_file, 'waybill_banner.'.$imageFileType, '380', '140');
                // 			}
                // 		}

                // 		$imageFileType = pathinfo(basename($_FILES['logo']['name']),PATHINFO_EXTENSION);

                // 		$target_file = $target_dir . 'logo'.$imageFileType;
                // 		if(isset($_FILES['logo']['name']) && $_FILES['logo']['name'] != '' && in_array($imageFileType, $ext)  ){
                // 			if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                // 				img_resize($target_dir, $target_file, 'logo.'.$imageFileType, '380', '140');
                // 			}
                // 		}

                header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
                header('Location: ' . SITEURL . '/administrator/admin_index.php?action=mlogo');
            } else {
                $page_title = $lang[868];
                $invoice = file_exists("../images/invoice_banner.jpg");
                $waybill = file_exists("../images/waybill_banner.jpg");
                $logo = file_exists("../images/logo.jpg");
                $newtemp->load_template('mlogo', 4);
            }

            break;


        case 'mconsole':
            if (isset($_GET['console_id']) && $_GET['console_id'] != "0") {
                if (isset($_POST['items'])) {
                    //var_dump($_POST['items']);
                    $console->update_console_details_sortable($_GET['console_id'], $_POST['items']);

                    echo "Console Page Edited Correctly";
                    return;
                }

                $coloums = $console->get_console_details($_GET['console_id']);
            }

            $page_title = $lang[873];
            $console_list = $db->get_table("console_types where types = '0'");
            $report_list = $db->get_table("console_types where types = '1'");
            $newtemp->load_template('mconsole', 4);
            break;

        default:
            $breadarray[0]['url'] = "admin_index.php";
            $breadarray[0]['name'] = $lang[104];


            $page_title = $lang[190];
            $newtemp->load_template('Mange_setting', 4);
            break;
    }
} else {
    $page_title = $lang[102];
    $newtemp->load_template('login_admin', 5);
}
