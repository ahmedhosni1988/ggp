<?php
session_start();
include("../setting.php");
include("../classes/notifiy.php");

$notify = new notify($db);
$data = $notify->get_notify();

echo json_encode($data);
?>