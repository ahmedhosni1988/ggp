<?php
include("../setting.php");


$q = mysql_query("SELECT * FROM `orders` WHERE `order_status` = 1");

while($row = mysql_fetch_array($q)){

    $s = mysql_query("select * from orders_package where order_id = '".$row['order_id']."' and package_status != '2' ") or die (mysql_error());
    $num = mysql_num_rows($s);

    if($num == "0"){

        mysql_query("update orders set finished = '1' where order_id = '".$row['order_id']."' ");
    }

}

?>