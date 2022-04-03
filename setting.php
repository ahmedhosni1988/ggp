<?php
date_default_timezone_set("Africa/Cairo");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['language'])) {
    include("includes/language_".$_SESSION['language'].".php");
} else {
    $_SESSION['language'] = 'en';
    include("includes/language_".$_SESSION['language'].".php");
}

include("classes/template.php");
include("classes/newconn.php");
include("classes/notifiy.php");
include("classes/users.php");
include("includes/error.php");
include("includes/function.php");
include("classes/logger.php");




error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));

///main site configration
define("SITEURL", "http://localhost/ggpn");
define("HOSTNAME", "localhost");
define("DBUSER", "root");
define("DBPASS", "1234");
define("DBNAME", "pyramids_server_db");
//define("DBNAME","newsystem_locallogestic");
define("STYLE", "style/trial");
define("PERPAGE", "30");
define("system_id", "1");
include(STYLE."/maintemp.php");
include(STYLE."/clienttemp.php");
include(STYLE."/admintemp.php");



$db = new dba(DBUSER, DBPASS, DBNAME, HOSTNAME);	// - and away we go
$mycon = $db->get_conn();


$notify = new notify($db);
$logger = new logger($db);

$c_setting = c_setting();

mysqli_query($mycon, "SET NAMES utf8");
mysqli_query($mycon, "SET CHARACTER SET utf8");

//////////////////////////////
///Site attibutes/////////////


if (isset($_SESSION['status']) && $_SESSION['status'] == 1) {
    define("formurl", "http://localhost/ggp/client");
    if (!isset($_SESSION['services_table'])) {
        $_SESSION['services_table'] = $db->get_table("services");
    }
}

if (isset($_SESSION['status']) && $_SESSION['status'] == 2) {
    define("formurl", "http://localhost/ggp/administrator");




    if (!isset($_SESSION['services_table'])) {
        $_SESSION['services_table'] = $db->get_table("services");
    }

    if (!isset($_SESSION['status_table'])) {
        $_SESSION['status_table'] = $db->get_table("status");
    }
}

$notification = array();
$updated_order="";
$new_invoice="";
$new_message="";
$new_client="";

if (isset($_SESSION['status']) && $_SESSION['status'] == 1) {
    $notification = $notify->get_account_notify($_SESSION['account_id'], $_SESSION['user_type']);
}



if (isset($_SESSION['status']) && $_SESSION['status'] == 2) {
    $notification = $notify->get_admin_notify(0);
}

for ($i=0;$i<count($notification);$i++) {
    if ($notification[$i]['types'] == "new_order") {
        $update_order++;
    }
    if ($notification[$i]['types'] == "update_order") {
        $update_order++;
    }
    if ($notification[$i]['types'] == "request_cancel_order") {
        $update_order++;
    }
    if ($notification[$i]['types'] == "cancel_order") {
        $update_order++;
    }


    if ($notification[$i]['types'] == "new_invoice") {
        $new_invoice++;
    }
    if ($notification[$i]['types'] == "new_message") {
        $new_message++;
    }
    if ($notification[$i]['types'] == "new_user") {
        $new_client++;
    }
}




function c_setting()
{
    global $mycon;
    $query = mysqli_query($mycon, "select * from options  ") or die(mysqli_error($mycon));


    $company_details = array();

    while ($row = mysqli_fetch_array($query)) {
        $company_details[$row['option_name']] =$row['option_value'];
    }

    return $company_details;
}

define("SITENAME", $c_setting['co_name']);

if (isset($c_setting['time_zone']) &&  $c_setting['time_zone'] != '') {
    date_default_timezone_set($c_setting['time_zone']);
}
if (isset($c_setting['date_format'])) {
    define("DATE_FORMAT", $c_setting['date_format']);
}
if (isset($c_setting['time_format'])) {
    define("TIME_FORMAT", $c_setting['time_format']);
}
if (isset($c_setting['date_time_format'])) {
    define("DATETIME_FORMAT", $c_setting['date_time_format']);
}



//echo "ahmed";
//echo $_COOKIE['username'];
//$user = new users($db);
CheckCookieLogin();
include("setting_config.php");
