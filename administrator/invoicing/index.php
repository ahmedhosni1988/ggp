<?php
include("../../setting.php");
include("invoicetemp.php");


if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = "";
}


switch ($action) {

    default:
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $q = mysqli_query($mycon,"select 
        invoicehdr.*,
        orders.pieces, 
        orders.service_id, 
        orders.office_name, 
        orders.operation_name, 
        orders.pickup_date, 
        orders.delivery_date, 
        orders.pickup_date, 
        orders.order_size,
        account.account_name,
        account.account_company,
        services.service_name
        from invoicehdr 
        inner join orders on (orders.order_id = invoicehdr.order_id) 
        inner join account on (orders.account_id=account.account_id) 
        inner join services on (orders.service_id = services.service_id) 
        where invoicehdr.id = '$id' ") or die(mysqli_error($mycon));

        $invhdr = mysqli_fetch_assoc($q);


        $qd = mysqli_query($mycon,"select invoicedtl.*,
        orders_package.part_order,
        orders_package.length,
        orders_package.width,
        orders_package.details,
        orders_package.glasscolour,
        orders_package.glassPrint,
        orders_package.glassType,
        orders_package.glassScarch,
        orders_package.glassPointing,
        orders_package.package_type,

        package_type.package_name
        from invoicedtl
        inner join orders_package on (orders_package.id = invoicedtl.waybill ) 
        inner join package_type on (orders_package.package_type = package_type.package_id ) 

        where invoicedtl.invoiceno = '".$invhdr['id']."' order by invoicedtl.lineno ASC , invoicedtl.chgtype DESC ") or die(mysqli_error($mycon));

        $invdetails = array();

        $package_division = array();

        while ($row = mysqli_fetch_assoc($qd)) {
            $invdetails[] = $row;
            
            $package_division[$row['package_type']]['price'] += $row['amount'];
            if ($row['chgtype'] == 'S') {
                $package_division[$row['package_type']]['meters'] += ($row['length'] * $row['width']) / 10000;
            }
            $package_division[$row['package_type']]['package_name'] = $row['package_name'] ;
        }





        $newtempAll->load_template('invoice_main', 5);
    } else {
        echo 'Error in data';
    }
    break;

}
