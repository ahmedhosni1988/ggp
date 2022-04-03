<?php
include("../setting.php");


$q = mysqli_query($mycon,"SELECT * FROM `orders` WHERE `order_status` = 1");

while($row = mysqli_fetch_array($q)){

    $s = mysqli_query($mycon,"select * from orders_package where order_id = '".$row['order_id']."' and package_status != '2' ") or die (mysqli_error($mycon));
    $num = mysqli_num_rows($s);

    if($num == "0"){

        mysqli_query($mycon,"update orders set finished = '1' where order_id = '".$row['order_id']."' ");
    }

}

?>