<?php

global $vechile_id;

//calculating price for vechils

if (isset($vechile_id) && $vechile_id != 0) {


///get return trip details
    $ret = $company->get_option("co_returntrip_");
//get vechiles_details for price///
    $vechile = $price->get_vechile($vechile_id);
///get weight volume piecse price 

    $weight = $_POST['weight_s'];
    $volume = $_POST['volume_s'];
    $pieces = $_POST['pieces_s'];

    if ($weight < 0) $weight = 0;
    if ($volume < 0) $volume = 0;
    if ($pieces < 0) $pieces = 0;

    $return_rate = 1;

    if ($vechile->return_multiplier != "" && $vechile->return_multiplier != 0) $return_rate = $vechile->return_multiplier;

///get weight price ///
    $over_weight = "";
    if (isset($_POST['over_weight']) && $_POST['over_weight'] != "") {
        $over_weight = $_POST['over_weight'];
    }

    if ($weight > 0 && $weight > $vechile->nocharge_weight) {
        $price_weight_charge = $sett['price_weightcharge'];

        if ($price_weight_charge == 'Y') {
///charge full weight
            $diff = $weight;
        } else {
///charge increased weight
            $diff = $weight - $vechile->nocharge_weight;
        }

        $pc_xwt = round($vechile->extra_weight_fee * $diff, 2);
        ///get return trip charge gor weight
        if ($ret['co_returntrip_Weight'] == "Y") $pc_xwt = $pc_xwt * $return_rate;

        if ($estimate != 1) $order->add_order_price($order_id, "weight", "0", $pc_xwt, "weight", 0, $over_weight);

    } else {

        if ($over_weight != "") if ($estimate != 1) $order->add_order_price($order_id, "weight", "0", "", "weight", 0, $over_weight);

    }


//get volume price//
    $over_volume = "";
    if (isset($_POST['over_volume']) && $_POST['over_volume'] != "") {
        $over_volume = $_POST['over_volume'];
    }

    if ($volume > 0 && $volume > $vechile->nocharge_volume) {
        $price_volume_charge = $sett['price_volumecharge'];

        if ($price_volume_charge == 'Y') {
///charge full weight
            $diff = $volume;
        } else {
///charge increased weight
            $diff = $volume - $vechile->nocharge_volume;
        }

        $pc_xvl = round($vechile->extra_volume_fee * $diff, 2);
        ///get return trip charge gor weight
        if ($ret['co_returntrip_Volume'] == "Y") $pc_xvl = $pc_xvl * $return_rate;

        if ($estimate != 1) $order->add_order_price($order_id, "volume", "0", $pc_xvl, "volume", 0, $over_volume);

    } else {
        if ($over_volume != "") if ($estimate != 1) $order->add_order_price($order_id, "volume", "0", "", "volume", 0, $over_volume);
    }


//get pieces price 
    $over_pieces = "";
    if (isset($_POST['over_pieces']) && $_POST['over_pieces'] != "") {
        $over_pieces = $_POST['over_pieces'];
    }

    if ($pieces > 0 && $sett_compnay["company_skid"]["option_value"] != "1") {

        $piece_type = $_POST['package_type_s'];

        $price_pieces_charge = $sett['price_piececharge'];
        $pieceprice = $price->get_vechile_package_rates($vechile_id, $piece_type);

        if ($price_pieces_charge == 'Y') {
///charge full weight
            $diff = $pieces;
        } else {
///charge increased weight
            $diff = $pieces - $pieceprice->no_charge_per_pack;
        }

        $pc_xpcs = round($pieceprice->extra_per_pack * $diff, 2);
        ///get return trip charge gor weight
        if ($pieceprice->package_return == "Y") $pc_xpcs = $pc_xpcs * $return_rate;


        if ($estimate != 1) $order->add_order_price($order_id, "pieces", "0", $pc_xpcs, "pieces", 0, $over_pieces);


    } else {
        if ($over_pieces != "") if ($estimate != 1) $order->add_order_price($order_id, "pieces", "0", $pc_xpcs, "pieces", 0, $over_pieces);
    }


///addtional services price
    $check = $price->get_add_check_price();
/////////////////////////////////
    for ($i = 0; $i < count($check); $i++) {

        $return_rate = 1;
        if ($return == 1 && $check[$i]['return_cal'] == 'Y') {
            if ($vechile->return_multiplier != "" && $vechile->return_multiplier != 0) $return_rate = $vechile->return_multiplier;
        }

        if (isset($_POST['addtser_' . str_replace(' ', '', $check[$i]['name'])])) {
            $override = "";
            if (isset($_POST['addtserover_' . $check[$i]['id']])) $override = $_POST['addtserover_' . $check[$i]['id']];
            $addtional_services[] = round($check[$i]['price'] * $return_rate, 2) . '-' . $check[$i]['name'];
            if ($estimate != 1) $add_add_price = $order->add_order_price($order_id, $check[$i]['name'], "0", round($check[$i]['price'] * $return_rate, 2), "addtional_services", $check[$i]['id'], $override);
        }

    }
/////////////////////////////////


////vechile service price////////////
    $addser = $serv->get_addtional_services();
    $vechile_service = array();
    for ($i = 0; $i < count($addser); $i++) {
        $return_rate = 1;
        if ($return == 1 && $addser[$i]['return_cal'] == 'Y') {

            if ($vechile->return_multiplier != "" && $vechile->return_multiplier != 0) $return_rate = $vechile->return_multiplier;
        }
        if (isset($_POST['vecser_' . str_replace(' ', '', $addser[$i]['name'])])) {
            $override = "";
            if (isset($_POST['vecpriceover_' . $check[$i]['id']])) $override = $_POST['vecpriceover_' . $check[$i]['id']];

            if ($vechile_id != 0) {

                $vechile_service[] = round($price->get_vechile_service_price($vechile_id, $_POST['vecser_' . str_replace(' ', '', $addser[$i]['name'])]) * $return_rate, 2) . "-" . $addser[$i]['name'];

                if ($estimate != 1) $add_add_price = $order->add_order_price($order_id, $addser[$i]['name'], "0", round($price->get_vechile_service_price($vechile_id, $_POST['vecser_' . str_replace(' ', '', $addser[$i]['name'])]) * $return_rate, 2), "vechile_services", $addser[$i]['id'], $override);
            } else {
                if ($estimate != 1) $add_add_price = $order->add_order_price($order_id, $addser[$i]['name'], "0", "", "vechile_services", $addser[$i]['id'], $override);
            }
        }
    }
////////////////////////////////


///////get pickup price/////
    $over_pickup_price = "";
    $pickup_price = "";
    if (isset($_POST['over_pickup_price']) && $_POST['over_pickup_price'] != "") {
        $over_pickup_price = $_POST['over_pickup_price'];

    }

    if ($from_zone != "" && $_POST['pickup_time'] != "" && $sett_compnay["company_skid"]["option_value"] != "1" && $c_setting['co_uom_distance'] == "N") {

        $pickup_price = $price->get_pickup_price($from_zone, $vechile_id);
        $time_rate = $price->get_todat_rate($from_zone, get_rate($_POST['pickup_time']));

        if ($time_rate == "" || $time_rate == "0") $time_rate = 1;
        $return_rate = 1;

        if ($return == 1 && $ret['co_returntrip_Pickup'] == 'Y') {
            if ($vechile->return_multiplier != "" && $vechile->return_multiplier != 0) $return_rate = $vechile->return_multiplier;
        }

        if ($estimate != 1) $order->add_order_price($order_id, "pickup_price", "0", $pickup_price->fee * $time_rate * $return_rate, "pickup_price", 0, $over_pickup_price);


    } else if ($from_zone != "" && $_POST['pickup_time'] != "" && $sett_compnay["company_skid"]["option_value"] == "1") {

        $pieces = $_POST['pieces_s'];
        $pickup_price = $price->get_pickup_price($from_zone, $vechile_id);
        $time_rate = $price->get_todat_rate($from_zone, get_rate($_POST['pickup_time']));


        if ($vechile->return_multiplier != "" && $vechile->return_multiplier != 0) $return_rate = $vechile->return_multiplier;

        if ($time_rate == "" || $time_rate == "0") $time_rate = 1;


        $first_skid = $pickup_price->fee;

        $second_skid = 0;

        if ($pieces > 1) {
            $second_skid = ($pickup_price->skid_fee) * ($pieces - 1);
        }

//echo "f".$first_skid."-s".$second_skid."".$time_rate."-".$return_rate;

//dontot forget return and time zone price
        if ($estimate != 1) {
//echo "First skid".$first_skid."<br>";
//$order->add_order_price($order_id,"pickup_price","0", $first_skid  ,"pickup_price",0,$over_pickup_price);
        }

    } else {

        if ($over_pickup_price != "") {
            echo $over_pickup_price;
            if ($estimate != 1 && $c_setting['co_uom_distance'] == "N") {

                $order->add_order_price($order_id, "pickup_price", "0", "", "pickup_price", 0, $over_pickup_price);
            }

        }

    }
///////////////////////////


//get delivery price /////
    $over_delivery_price = "";
    $delivery_price = "";
    if (isset($_POST['over_delivery_price']) && $_POST['over_delivery_price'] != "") {
        $over_delivery_price = $_POST['over_delivery_price'];
    }

    if (isset($_POST['service_id']) && $_POST['service_id'] != 0 && $from_zone != "" && $to_zone != "" && $vechile_id != "" && $_POST['delivery_time'] != "" && $sett_compnay["company_skid"]["option_value"] != "1") {
        $delivery_price = $price->get_delivery_price($from_zone, $to_zone, $_POST['service_id'], $vechile_id);
///multibly delivery with zone rate multipler
        $zone_rate = $price->get_vechile_zonerate($vechile_id, $_POST['service_id']);
        if ($zone_rate == "" || $zone_rate == "0") $zone_rate = 1;
///multiply by todorate
        $time_rate = $price->get_todat_rate($to_zone, get_rate($_POST['delivery_time']));
        if ($time_rate == "" || $time_rate == "0") $time_rate = 1;
///get return trip for delivery // make tom 26-9-2012
        $return_rate = 1;
        if ($return == 1 && $ret['co_returntrip_Delivery'] == 'Y') {
            if ($vechile->return_multiplier != "" && $vechile->return_multiplier != 0) $return_rate = $vechile->return_multiplier;
        }
        $delivery_price = round($delivery_price->price * $zone_rate * $time_rate * $return_rate, 2);


        if ($estimate != 1) $order->add_order_price($order_id, "delivery_price", "0", $delivery_price, "delivery_price", 0, $over_delivery_price);


    } else if (isset($_POST['service_id']) && $_POST['service_id'] != 0 && $from_zone != "" && $to_zone != "" && $vechile_id != "" && $sett_compnay["company_skid"]["option_value"] == "1" && $_POST['pieces_s'] != "" && $_POST['pieces_s'] != "0") {

        $pieces = $_POST['pieces_s'];

        $delivery_price = $price->get_delivery_price($from_zone, $to_zone, $_POST['service_id'], $vechile_id);
///multibly delivery with zone rate multipler
        $zone_rate = $price->get_vechile_zonerate($vechile_id, $_POST['service_id']);
        if ($zone_rate == "" || $zone_rate == "0") $zone_rate = 1;
///multiply by todorate
        $time_rate = $price->get_todat_rate($to_zone, get_rate($_POST['delivery_time']));
        if ($time_rate == "" || $time_rate == "0") $time_rate = 1;
///get return trip for delivery // make tom 26-9-2012
        $return_rate = 1;
        if ($return == 1 && $ret['co_returntrip_Delivery'] == 'Y') {
            if ($vechile->return_multiplier != "" && $vechile->return_multiplier != 0) $return_rate = $vechile->return_multiplier;
        }


        if ($time_rate == "" || $time_rate == "0") $time_rate = 1;
        $first_skid = $delivery_price->price;
        if ($estimate != 1) $order->add_order_price($order_id, "pickup_price", "0", ($first_skid) * $time_rate * $return_rate, "pickup_price", 0, $over_pickup_price);

        $second_skid = 0;

        if ($pieces > 1) {
            $second_skid = ($delivery_price->skid_price) * ($pieces - 1);
        }

//echo "f".$first_skid."-s".$second_skid."".$time_rate."-".$return_rate."-".$zone_rate;
        if ($estimate != 1 && $c_setting['co_uom_distance'] == "N") $order->add_order_price($order_id, "delivery_price", "0", ($second_skid) * $zone_rate * $time_rate * $return_rate, "delivery_price", 0, $over_delivery_price);


    } else {

        if ($over_delivery_price != "") {
            if ($estimate != 1 && $c_setting['co_uom_distance'] == "N") $order->add_order_price($order_id, "delivery_price", "0", "", "delivery_price", 0, $over_delivery_price);
        }

    }
//////////////////////////


///get fuelsurcharge price ////


}


if ((isset($_POST['quoted_distance']) && $_POST['quoted_distance'] != "" && $_POST['quoted_distance'] != 0) || (isset($_POST['override_distance']) && $_POST['override_distance'] != "" && $_POST['override_distance'] != 0) || $c_setting['co_uom_distance'] != "N" && $sett_compnay["company_skid"]["option_value"] != "1") {

    $vechile = $price->get_vechile($vechile_id);
    $address1 = $_POST['from_address'];
    $address2 = $_POST['to_address'];
    $distance = "";

//echo $distance;

    if (isset($_POST['quoted_distance']) && $_POST['quoted_distance'] != "" && $_POST['quoted_distance'] != 0) {
        $distance = $_POST['quoted_distance'];
    }

    if (isset($_POST['override_distance']) && $_POST['override_distance'] != "" && $_POST['override_distance'] != 0) {
        $distance = $_POST['override_distance'];
    } else {

        $info = get_driving_information($_POST['from_address'], $_POST['to_address'], $_POST['from_pcode'], $_POST['to_pcode']);
        $distance = convert_distance($info['distance'], $c_setting['co_uom_distance']);
        $distance = ceil($distance);

    }

    $ser_id = $_POST['service_id'];

//$ar = $price->get_distance_sheet($ser_id,$vechile_id);
//$lastunit = $price->get_distance_lastunit($ser_id,$vechile_id);
//$dprice = cal_distance($distance,$ar,$lastunit);
//$dprice = 
//old distance cacl///////////////

    /*$firstunitprice = $price->get_dist_unitprice($ser_id,$vechile_id,$_POST['account_id']);
    $min_distance = $sett['price_distance_min'];
    if ($distance > $min_distance ){
    $exceed_distance = $distance - $min_distance;
    $inc_val = $price->get_every_ratio($ser_id,$exceed_distance,$_POST['account_id']);
    $dprice = $firstunitprice +  $inc_val;
    }else{
    $dprice = $firstunitprice;
    }
    */

//echo $min_distance.' - '.$exceed_distance.' - '.$distance.' - '.$inc_val;


    if ($estimate != 1) {
//$order->update_order_distance($order_id,$_POST['from_address'],$_POST['to_address'],$distance);

        $order->add_order_price($order_id, "distance_price", "0", $dprice, "distance_price", 0, $dprice);

    }

}

/////////////////set addtional price and wait price
///wait time
if (isset($_POST['wait_charges']) and $_POST['wait_charges'] != "" and $_POST['wait_charges'] > 0) {
    $order->add_order_price($order_id, $_POST['wait_auth'], "0", $_POST['wait_charges'], "wait_price");
}
if (isset($_POST['add1_charge']) and $_POST['add1_charge'] != "" and $_POST['add1_charge'] > 0) {
    $order->add_order_price($order_id, $_POST['add1_des'], "0", $_POST['add1_charge'], "add1_charge");
}
if (isset($_POST['add2_charge']) and $_POST['add2_charge'] != "" and $_POST['add2_charge'] > 0) {
    $order->add_order_price($order_id, $_POST['add2_des'], "0", $_POST['add2_charge'], "add2_charge");
}
if (isset($_POST['add3_charge']) and $_POST['add3_charge'] != "" and $_POST['add3_charge'] > 0) {
    $order->add_order_price($order_id, $_POST['add3_des'], "0", $_POST['add3_charge'], "add3_charge");
}


////calculate total and fsrate////
if (isset($_POST['account_id'])) {


    if ($estimate == 1) {
        $total_aser = 0;
        for ($v = 0; $v < count($addtional_services); $v++) {
            $x = explode('-', $addtional_services[$v]);
            $total_aser += $x[0];
        }

        $total_vser = 0;
        for ($v = 0; $v < count($vechile_service); $v++) {
            $x = explode('-', $vechile_service[$v]);
            $total_vser += $x[0];
        }


        $testimate = $pc_xwt + $pc_xvl + $pc_xpcs + $pickup_price->fee + $delivery_price + $total_vser + $total_aser + $dprice;

        $taxgroup = $account->get_account_taxgroup($_POST['account_id']);
        $tp_tax = $testimate;
        $fsrate = $price->get_fsrate($taxgroup, $vechile_id, $_POST['account_id']);
        $fuelsurcharge = sprintf("%01.2f", $tp_tax * $fsrate / 100);

    }


    if ($estimate != 1) {

        $taxgroup = $account->get_account_taxgroup($_POST['account_id']);
        $tp_tax = $price->get_tax_price($taxgroup, $order_id);
        $fsrate = $price->get_fsrate($taxgroup, $vechile_id);
        $fuelsurcharge = sprintf("%01.2f", $tp_tax * $fsrate / 100);

        if ($fsrate != "") $order->add_order_price($order_id, "fsrate", $fsrate, $fuelsurcharge, "fsrate");

        $tp = $price->get_total_price($order_id);
//if ($tp_tax != ""){
        $order->add_order_price($order_id, "total", "0", $tp, "total", null, $_POST['total_price']);
// echo $_POST['total_price'];
        if ($tp == 1) $tp = $_POST['total_price'];
        $tos['price'] = $tp;

        $order->update_orders($tos, $order_id);

//}

    }

}


?>