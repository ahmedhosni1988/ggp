<?php

session_start();
include("../setting.php");
include("../".STYLE."/logtemp.php");

$newtemp = new template();

if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}

if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == true  &&  $_SESSION['status'] == 2) {
    if ($_SESSION['user_type'] != 'administrator') {
        $newtemp->load_template('unauthorized', 4);

        return;
    }
    $open = "setup";
    switch ($action) {
        case 'check':
            echo 'ok';
            break;
        default:
        //new log table
        // $newtemp->load_template('main_logpage_new',4);
        ////////old log
            if (isset($_GET['search'])) {
                if ($_POST['start'] == 0) {
                    $search_result = $logger->searchLog($_POST['oid'], $_POST['oname'], $_POST['uname'], $_POST['start_time'], $_POST['end_time'], 0, PERPAGE);
                } else {
                    $search_result = $logger->searchLog($_POST['oid'], $_POST['oname'], $_POST['uname'], $_POST['start_time'], $_POST['end_time'], $_POST['start'], PERPAGE);
                }
                
                $count = $logger->count_searchLog($_POST['oid'], $_POST['oname'], $_POST['uname'], $_POST['start_time'], $_POST['end_time']);
                $arr = array(
                    'tbl' => $search_result,
                    'cnt' => $count,
                    'perpage' => PERPAGE
                    //'lang'      => $lang
                );
                echo json_encode($arr);
            } elseif (isset($_GET['paging'])) {
                $all_logs = $logger->getAllLog($_POST['start'], PERPAGE);
                echo json_encode($all_logs);
            } else {
                $all_logs = $logger->getAllLog(0, PERPAGE);
                $count =  $logger->get_log_count();
                $newtemp->load_template('main_logpage', 4);
            }
            break;
    }
}
