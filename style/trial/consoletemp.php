<?php

function buttons()
{
    global $lang, $action, $ajax;
    // 	if(!isset($_GET['ajax'])){
// 	echo '
// 			<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/order.js"></script>
// <p style="text-align:center;">

// 				<button class="btn btn-white btn-sm btn-primary '.($action == "all" ? 'active' : '').'" onclick ="moveto(\'all\');">'.$lang[791].'</button>
// 				<button class="btn btn-white btn-sm btn-primary'.($action == "pending" ? 'active' : '').'" onclick ="moveto(\'pending\');">'.$lang[915].'</button>';
// 				if($_SESSION['status'] == "2") echo '<button class="btn btn-white btn-sm btn-yellow'.($action == "assigned" ? 'active' : '').'" onclick ="moveto(\'assigned\');">'.$lang[916].'</button>';
// 				echo '<button class="btn btn-white btn-sm btn-primary '.($action == "inprogress" ? 'active' : '').'" onclick ="moveto(\'inprogress\');">'.$lang[917].'</button>
// 				<button class="btn btn-white btn-sm btn-primary '.($action == "completed" ? 'active' : '').'" onclick ="moveto(\'completed\');">'.$lang[918].'</button>
// 				<button class="btn btn-white btn-sm btn-primary '.($action == "cancled" ? 'active' : '').'" onclick ="moveto(\'cancled\');">'.$lang[919].'</button>
// </p>';
// 	}
}


function show_row_option($ro)
{
    global $c_setting, $search, $detect, $company, $lang;
    //print_r($ro);
    //$ro = array_unshift($ro);
    //var_dump($ro);
    if ($search == "1") {
        $rou = $ro;
    } else {
        for ($i = 0; $i < count($ro); $i++) {
            foreach ($ro[$i] as $key => $value) {
                $rou[$key] = $value;
            }
        }
    }


    $x .= '<button class="btn btn-info btn-xs" style="width:30px; height:30; margin:2px;"  onclick="refreshwaybill(\'' . $rou['order_id'] . '\');">
		<i class="fa fa-print bigger-125 icon-only" ></i>
															</button>';

    //  var_dump($rou['order_status']);
    if ($rou['order_status'] == '5') {
        $x .= '&nbsp;&nbsp;<span class="red">ملغى</span>';
    }

                                                            
    if ($_SESSION['user_type'] == "manmanger" || $_SESSION['user_type'] == "administrator" || $_SESSION['user_type'] == 'addmanger') {
        $x .= '    <button  class="btn btn-primary btn-xs" style="width:30px; height:30; margin:2px;"  onclick="window.open(\'montior.php?action=edit_orders&id=' . $rou['order_id'] . '\',\'_blank\');">
		<i class="fa fa-external-link bigger-125 icon-only" ></i>
															</button>';
    }

    // echo $_GET['action'];
    // if ($rou['finished'] == '1' || $_SESSION['user_type'] == "manmanger" || $_SESSION['user_type'] == "administrator") {
    //     $x .= '    <button  class="btn btn-success btn-xs" style="width:30px; height:30; margin:2px;"  onclick="deliver_order(\'' . $rou['order_id'] . '\');">
    //                                                          <i class="fa fa-check bigger-125 icon-only" ></i>
    //                                                                                                              </button>';
    // }

    if ($_SESSION['user_type'] == "5" && $rou['order_status'] != '3' && isset($_GET['action'])) {
        $x .= '    <button  class="btn btn-success btn-xs" style="width:30px; height:30; margin:2px;"  onclick="deliver_order(\'' . $rou['order_id'] . '\');">
																 <i class="fa fa-check bigger-125 icon-only" ></i>
																 													</button>';
    }

    if ($rou['order_status'] == "0" && ($_SESSION['user_type'] == "manmanger" || $_SESSION['user_type'] == "administrator")) {
        $x .= '
	  <button class="btn btn-danger btn-xs" style="width:30px; height:30; margin:2px;" onclick="cancel_order(\'' . $rou['order_id'] . '\',\'' . $lang[53] . '\');">
	  <i class="fa fa-trash-o bigger-125 icon-only" ></i>
														  </button> 
	  <button  class="btn btn-success btn-xs" style="width:30px; height:30; margin:2px;"  onclick="start_work(\'' . $rou['order_id'] . '\',\'' . $lang[65] . '\');">
		<i class=" fa  fa-exchange bigger-125 icon-only" ></i>
														</button>

													
														';
    }

    if (($rou['order_status'] == "1") && ($_SESSION['user_type'] == "manmanger" || $_SESSION['user_type'] == "administrator")) {
        $x .= '<button class="btn btn-primary btn-xs" style="width:30px; height:30; margin:2px;" onclick="stop_order(\'' . $rou['order_id'] . '\',\'' . $lang[68] . '\');">
																<i class="fa fa-stop bigger-125 icon-only" ></i>
																													</button> 
																													
																													<button class="btn btn-white btn-xs" style="width:30px; height:30; margin:2px;" onclick="close_order_all(\'' . $rou['order_id'] . '\',\'' . $lang[70] . '\');">
																
																<i class="fa fa-exclamation-triangle red bigger-130 icon-only" ></i>
																													</button>
																													';
    }

    if (($rou['order_status'] == "4") && ($_SESSION['user_type'] == "manmanger" || $_SESSION['user_type'] == "administrator")) {
        $x .= '<button class="btn btn-primary btn-xs" style="width:30px; height:30; margin:2px;" onclick="play_order(\'' . $rou['order_id'] . '\',\'' . $lang[69] . '\');">
																<i class="fa fa-play bigger-125 icon-only" ></i>
																													</button> 
																													<button  class="btn btn-primary btn-xs" style="width:30px; height:30; margin:2px;"  onclick="window.open(\'montior.php?action=edit_orders&id=' . $rou['order_id'] . '\',\'_blank\');">
																													<i class="fa fa-external-link bigger-125 icon-only" ></i>
																																										</button>
																																										';
    }


    return $x;
}


function show_report_option($ro)
{
    global $c_setting, $search, $detect;
    //print_r($ro);
    //$ro = array_unshift($ro);
    //var_dump($ro);
    if ($search == "1") {
        $rou = $ro;
    } else {
        for ($i = 0; $i < count($ro); $i++) {
            foreach ($ro[$i] as $key => $value) {
                $rou[$key] = $value;
            }
        }
    }
    //var_dump($rou);
    //	echo $rou['order_status'];


    $x .= '
															<button type="button" class="btn   btn-grey btn-xs" style="margin:2px;" onclick="refreshwaybill(\'' . $rou['order_id'] . '\');">
																<i class="ace-icon fa fa-print" style="width:12px; height:12px;"></i>
															</button>';

    if ($c_setting['barcode_option'] == 'Y' && $search != "1") {
        $x .= '<button type="button" class="btn btn-inverse btn-xs" style="margin:2px;" onclick="show_barcode(\'' . $rou['order_id'] . '\',\'' . $rou['account_id'] . '\',\'' . $rou['account_name'] . '\')">
																<i class="ace-icon fa  fa-barcode " style="width:12px; height:12px;"></i>
															</button>';
    }

    // 			                                             $x .= '
    // 															<button class="btn btn-sm btn-info" onclick="assign_driver(\''.$ro[0]['order_id'].'\',\''.$ro[3]['driver_id'].'\');">
    // 																<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
    // 															</button>';


    if ($_SESSION['status'] == "2") {
        $x .= '   <button type="button" class="btn btn-success btn-xs" style="margin:2px; -webkit-appearance: none;" onclick="window.open(\'montior.php?action=edit_orders&id=' . $rou['order_id'] . '\',\'_blank\');">
																<i class="ace-icon fa fa-external-link" style="width:12px; height:12px;"></i>
															</button>

														';
    }


    return $x;
}

function console_paging()
{
    global $lang, $action, $ajax;
    if ($count > PERPAGE) {
        echo '
				<ul class="pagination pull-right no-margin">';

        if (($start - PERPAGE) >= 0) {
            echo '<li class="prev " ><a href="montior.php?action=' . $action . '&start=' . ($start - PERPAGE) . '"  >Previous</a></li>';
        }

        $pages = ceil($count / PERPAGE);

        $no = 0;
        $fi = $start / PERPAGE;
        $fi = $fi - 2;
        if ($fi > 0) {
            $fi = $fi;
        } else {
            $fi = 1;
        }

        for ($i = $fi; $i < $pages; $i++) {
            $no++;
            if ($start == ($i * PERPAGE)) {
                echo '<li class="active"><a>' . $i . '</a></li>';
            } else {
                echo '<li><a href="montior.php?action=' . $action . '&start=' . ($i * PERPAGE) . '">' . $i . '</a></li>';
            }
            if ($no > 4) {
                break;
            }
        }


        if (($start + PERPAGE) < $count) {
            echo '<li class="next"><a href="montior.php?action=' . $action . '&start=' . ($start + PERPAGE) . '">Next</a></li>';
        }

        echo '	</ul>';
    }
}


function template_admin_montior_console()
{
    global $lang, $grid, $html_grid, $n_ids, $action, $count, $start;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>
		
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/montior.js"></script>



';


    echo '	<div style="clear:both;"></div>	
<div id="grid" class="grid" style="margin:10px; "  >
<div style="overflow-x: auto">

' . $html_grid . '
</div>
</div>



<div style=" clear:both;"></div>

';
}


function template_order_quickdetails()
{
    global $lang, $order_details, $dri, $type, $sett_compnay;
    $t[1] = "before";
    $t[2] = "after";
    $t[3] = "at";

    echo '
		<div class="orderdetails" name="orderdetails"  style="width:100%; color:#31708f; background:#d9edf7; padding:10px; ">
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>

<form id="quick_details"  style="width:98%;  margin:0px auto; border:none;">
<table  style="float:left; width:24%;" >
<tr>
<th colspan="2">' . $lang[281] . '</th>
</tr>

<tr>
<td>' . $lang[277] . '</td>
<td>' . $order_details->order_id . '</td>
</tr>

<tr>
<td>' . $lang[279] . '</td>
<td>' . $order_details->account_name . '</td>
</tr>

<tr>
<td>' . $lang[286] . '</td>
<td>' . sprintf("%01.2f", round($order_details->price)) . '</td>
</tr>

<tr>
<td>' . $lang[280] . '</td>
<td>' . date(DATETIME_FORMAT, strtotime($order_details->order_date)) . '</td>
</tr>
</table>


<table   style="float:left; width:49%;" >
<tr>

<th colspan="2">' . $lang[282] . '</th>
<th colspan="2">' . $lang[283] . '</th>
</tr>

<tr>
<td>' . $lang[36] . '</td>
<td>' . $order_details->from_name . '</td>

<td>' . $lang[36] . '</td>
<td>' . $order_details->to_name . '</td>
</tr>

<tr>
<td>' . $lang[7] . '</td>
<td>' . $order_details->from_address . '</td>

<td>' . $lang[7] . '</td>
<td>' . $order_details->to_address . '</td>
</tr>

<tr>
<td>' . $lang[10] . '</td>
<td>' . $order_details->from_name . '</td>

<td>' . $lang[288] . '</td>
<td>' . $order_details->to_name . '</td>
</tr>

<tr>
<td>' . $lang[37] . '</td>';
    if ($order_details->pickup_date == '0000-00-00') {
        echo '<td>No Date</td>';
    } else {
        echo '<td>' . $t[$order_details->pickup_by] . ' ' . date(DATETIME_FORMAT, strtotime($order_details->pickup_date . ' ' . $order_details->pickup_time)) . '</td>';
    }

    echo '<td>' . $lang[38] . '</td>';
    if ($order_details->delivery_date == '0000-00-00') {
        echo '<td>No Date</td>';
    } else {
        echo '<td>' . $t[$order_details->deliver_by] . ' ' . date(DATETIME_FORMAT, strtotime($order_details->delivery_date . ' ' . $order_details->delivery_time)) . '</td>';
    }

    echo '</tr>

</table>

<table   style="float:left; width:24%;" >
<tr>
<th colspan="2">' . $lang[352] . '</th>
</tr>

<tr>
<td>' . $lang[284] . '</td>
<td>';
    if (is_array($dri)) {
        for ($d = 0; $d < count($dri); $d++) {
            if ($dri[$d]['id'] == $order_details->driver_id) {
                echo $dri[$d]['name'];
            }
        }
    }
    echo '
</td>
</tr>

';

    if ($sett_compnay["company_skid"]["option_value"] == "1") {
        echo '<tr>
<td>' . $lang[608] . '</td>
<td>' . $order_details->pieces . '</td>
</tr>';
    }
    echo '<tr>
<td>' . $lang[353] . '</td>
<td>' . $order_details->service_name . '</td>
</tr>

<tr>
<td>' . $lang[287] . '</td>
<td>' . $order_details->pod . '</td>
</tr>

<tr>
<td>' . $lang[287] . '</td>
<td>' . $order_details->pop . '</td>
</tr>

</table>

<div style="clear:both;"></div>
';
    if ($type == "pending") {
        echo '
<input id="cancel_order"  type="button" onclick="order_details_active(\'' . $order_details->order_id . '\',\'5\',\'' . $order_details->driver_id . '\');" name="edit_company" class="btn btn-info" value="' . $lang[601] . '">

<input id="pending"  type="button" onclick="order_details_view(\'' . $order_details->order_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[296] . '">';
    }

    if ($type == "completed") {
        echo '
<input id="cancel_order"  type="button" onclick="order_details_active(\'' . $order_details->order_id . '\',\'5\',\'' . $order_details->driver_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[601] . '">

<input id="pending"  type="button" onclick="order_details_view(\'' . $order_details->order_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[296] . '">';
    }
    if ($type == "inprogress") {
        echo '
<input id="complete_order"  type="button" onclick="order_details_active(\'' . $order_details->order_id . '\',\'2\',\'' . $order_details->driver_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[599] . '">

<input id="cancel_order"  type="button" onclick="order_details_active(\'' . $order_details->order_id . '\',\'5\',\'' . $order_details->driver_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[601] . '">

<input id="pending"  type="button" onclick="order_details_view(\'' . $order_details->order_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[296] . '">';
    }
    if ($type == "cancled") {
        echo '
<input id="pending_order"  type="button" onclick="order_details_active(\'' . $order_details->order_id . '\',\'1\',\'' . $order_details->driver_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[602] . '">

<input id="pending"  type="button" onclick="order_details_view(\'' . $order_details->order_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[296] . '">

<input id="delte_order"  type="button" onclick="delete_order(\'' . $order_details->order_id . '\',\'' . $lang[604] . '\');" name="delte_order" class="btn btn-xs" value="' . $lang[259] . '">

';
    }
    if ($type == "assigned") {
        echo '
<input id="actievt_order"  type="button" onclick="order_details_active(\'' . $order_details->order_id . '\',\'3\',\'' . $order_details->driver_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[605] . '">

<input id="cancel_order"  type="button" onclick="order_details_active(\'' . $order_details->order_id . '\',\'5\',\'' . $order_details->driver_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[601] . '">

<input id="pending"  type="button" onclick="order_details_view(\'' . $order_details->order_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[296] . '">

';
    }

    echo '


<input id="print_order"  type="button" onclick="refreshwaybill(\'' . $order_details->order_id . '\');" name="print_order" class="btn btn-xs" value="' . $lang[603] . '">

<!--
<input id="actievt_order"  type="button" onclick="order_details_active(\'' . $order_details->order_id . '\',\'3\',\'1\');" name="edit_company" class="btn btn-xs" value="' . $lang[292] . '">

<input id="complete_order"  type="button" onclick="order_details_active(\'' . $order_details->order_id . '\',\'2\',\'2\');" name="edit_company" class="btn btn-xs" value="' . $lang[599] . '">

<input id="cancel_order"  type="button" onclick="order_details_active(\'' . $order_details->order_id . '\',\'5\',\'3\');" name="edit_company" class="btn btn-xs" value="' . $lang[601] . '">

<input id="pending"  type="button" onclick="order_details_view(\'' . $order_details->order_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[296] . '">
		-->


<input id="close"  type="button" onclick="close_order_details(\'' . $order_details->order_id . '\');" name="edit_company" class="btn btn-xs" value="' . $lang[200] . '">
		


</form>
		</div>
		
';
}


function template_order_quickdetails_client()
{
    global $lang, $order_details, $sett_compnay;
    echo '
		<div class="orderdetails" name="orderdetails"  style="width:100%; color:#31708f; background:#d9edf7; padding:10px; ">
		
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>

<div id="result"></div>

<form id="quick_details"  style="width:100%;  margin:0px;">
<table   style="float:left; width:24%;" >
<tr>
<th colspan="2">' . $lang[281] . '</th>
</tr>

<tr>
<td>' . $lang[277] . '</td>
<td>' . $order_details->order_id . '</td>
</tr>

<tr>
<td>' . $lang[279] . '</td>
<td>' . $order_details->account_name . '</td>
</tr>

<tr>
<td>' . $lang[278] . '</td>
<td>' . $order_details->user_name . '</td>
</tr>

<tr>
<td>' . $lang[280] . '</td>
<td>' . $order_details->order_date . '</td>
</tr>
</table>


<table  style="float:left; width:49%;" >
<tr>

<th colspan="2">' . $lang[282] . '</th>
<th colspan="2">' . $lang[283] . '</th>
</tr>

<tr>
<td>' . $lang[36] . '</td>
<td>' . $order_details->from_name . '</td>

<td>' . $lang[36] . '</td>
<td>' . $order_details->to_name . '</td>
</tr>

<tr>
<td>' . $lang[7] . '</td>
<td>' . $order_details->from_address . '</td>

<td>' . $lang[7] . '</td>
<td>' . $order_details->to_address . '</td>
</tr>

<tr>
<td>' . $lang[10] . '</td>
<td>' . $order_details->from_name . '</td>

<td>' . $lang[288] . '</td>
<td>' . $order_details->to_name . '</td>
</tr>

<tr>
<td>' . $lang[37] . '</td>
<td>' . $t[$order_details->pickup_by] . ' ' . date(DATETIME_FORMAT, strtotime($order_details->pickup_date . ' ' . $order_details->pickup_time)) . '</td>

<td>' . $lang[38] . '</td>
<td>' . $t[$order_details->deliver_by] . ' ' . date(DATETIME_FORMAT, strtotime($order_details->delivery_date . ' ' . $order_details->delivery_time)) . '</td>
</tr>

</table>

<table style="float:left; width:24%;" >
<tr>
<th colspan="2">' . $lang[352] . '</th>
</tr>

<tr>
<td>' . $lang[284] . '</td>
<td>' . $order_details->name . '
</td>
</tr>

<tr>';

    if ($_SESSION['status'] == 2) {
        echo '<td>' . $lang[286] . '</td>
<td>' . $order_details->price . '</td>';
    } elseif (isset($_SESSION['account_id']) && ($_SESSION['price_ovrd_quotes'] == 'Y' || ($_SESSION['price_ovrd_quotes'] == '0' && $sett_compnay["price_control"]["option_value"] == "Y"))) {
        echo '<td>' . $lang[286] . '</td>
<td>' . $order_details->price . '</td>';
    } else {
        echo '<td></td><td></td>';
    }


    echo '
</tr>

';

    if ($sett_compnay["company_skid"]["option_value"] == "1") {
        echo '<tr>
<td>' . $lang[608] . '</td>
<td>' . $order_details->pieces . '</td>
</tr>';
    }
    echo '


<tr>
<td>' . $lang[353] . '</td>
<td>' . $order_details->service_name . '</td>
</tr>

<tr>
<td>' . $lang[280] . '</td>
<td>' . date(DATETIME_FORMAT, strtotime($order_details->order_date)) . '</td>
</tr>
</table>

<div style="clear:both;"></div>
<input id="print_order"  type="button" onclick="refreshwaybill(\'' . $order_details->order_id . '\');" name="print_order" class="btn btn-info" value="' . $lang[603] . '">&nbsp&nbsp';

    if ($order_details->order_status == 1) {
        echo '<input id="Request_Cancel"  type="button" onclick="cancel_order(\'' . $order_details->order_id . '\',\'' . $lang[53] . '\');" name="cancel_request" class="btn btn-danger" value="' . $lang[922] . '">';
    }
    echo '</form>
</div>
';
}


function template_admin_edit_order()
{
    global $lang, $order_details, $services, $pack, $comData, $pay, $order_status, $order_packages,$pack_options;
    global $glassType, $glassColor,$allacc;

    $_SESSION["order_details"]=$order_details;

    echo '
		
			<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/home.js"></script>
	
		<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>
		
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/montior.js" ></script>
    ';

    // if($order_details->order_status  > "0"  && $_SESSION['user_id'] != '4'  ){


    // echo '<script type="text/javascript">

    // //$("#edit_order_ah :input").prop("disabled", true);
    // //$("#edit_order_ah :input").attr("disabled", true);
    // $(document).ready(function(){
//     $("#edit_order_ah :input").prop("disabled", true);

//     $(".stop_item").prop("disabled", false);
    // });

    // </script>';

    // }
    echo '
<form id = "edit_order_ah" name="edit_order_ah" enctype="multipart/form-data"  id="edit_orderss"  method="post" action="' . SITEURL . '/administrator/montior.php?action=edit_detailsorder" class="form-horizontal" role="form">



<input type="hidden" name="is_edit_order" value="1" />

<input type="hidden" name="easy_order" value="' . $order_details->easy_order_id . '" />
<input type="hidden" name="order_id" value="' . $order_details->order_id . '" />
<input type="hidden" name="account_id" value="' . $order_details->account_id . '" />
		

<div class="row">

<div class=" pricing-box">
<div class="widget-box widget-color-blue">
<div class="widget-header ">
<div class="widget-title">' . $lang[977] . '</div>
</div>

<div class="widget-body">
<div class="widget-main">


<div class="col-xs-6">

<div class="form-group">
<label class="col-sm-3 control-label ">' . $lang[36] . '</label>
<div class="col-sm-9">' . trim($order_details->account_company, ' ') . '</div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[17] . '</label>
<div class="col-sm-9">' . $order_details->account_name . '</div>
</div>


';
    if ($_SESSION['user_type'] == 'manmanger') {
        echo '
        <div class="form-group">
        <label class="col-sm-3 control-label">' . $lang[17] . '</label>
        <div class="col-sm-3">
        <select  class="form-control chosen-select" name="new_account_id"   > 
        <option value="">' . $lang[204] . '</option>';

        for ($i = 0; $i < count($allacc); $i++) {
            echo '<option value="' . $allacc[$i]['account_id'] . '">' . $allacc[$i]['account_name'] . ' | ' . $allacc[$i]['account_company'] . ' | ' . $allacc[$i]['billingcode_name'].'</option>';
        }
        echo '
        </select>
        </div>
        </div>
        ';
    }

    if (is_array($services) && count($services) > 0) {
        echo '<div class="form-group">
	<label class="col-sm-3 control-label">نوع الطلبية</label>
	<div class="col-sm-9">
';

        for ($i = 0; $i < count($services); $i++) {
            if (isset($_GET['ser']) && $_GET['ser'] == $services[$i]['service_id']) {
                $service_name = $services[$i]['service_name'];
                $service_id = $services[$i]['service_id'];
                echo '
			<input type="hidden" name="service_id" value="' . $service_id . '" /> 
			' . $services[$i]['service_name'];
            }
        }
        echo '
	</div>
	</div>';
    }


    echo '

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[357] . '</label>
<div class="col-sm-9">

		
<input type="text" name="pickup_date" id="pickup_date" readonly="true"  validate="notempty"  value="' . date('Y-m-d', strtotime($order_details->pickup_date)) . '"  /> 

<script type="text/javascript">
		
		$(document).ready(function (){

 $( "#pickup_date" ).datepicker({
		dateFormat: \'yy-mm-dd\',
        changeMonth: true,  
        minDate:0,  
    });
		
    $( "#delivery_date" ).datepicker({   
		dateFormat: \'yy-mm-dd\',   
        changeMonth: true
	});
		
		$("#pickup_date").datepicker(\'setDate\', new Date());
		var d = new Date()
		d.setDate(d.getDate() + 3); 		
		});	
</script>

</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[358] . '</label>
<div class="col-sm-9">
<input   type="text" name="delivery_date"  readonly="true"  id="delivery_date"    value="' . date('Y-m-d', strtotime($order_details->delivery_date)) . '" />
</div>
</div>




<div class="form-group">
<label class="col-sm-3 control-label">نوع الطلبية</label>
<div class="col-sm-9">
<select name="order_type">
<option value="1" ' . ($order_details->order_type == "1" ? 'selected' : '') . ' >طلبية جديدة</option>
<option value="5" ' . ($order_details->order_type == "5" ? 'selected' : '') . '>كسر عميل</option>
<option value="2" ' . ($order_details->order_type == "2" ? 'selected' : '') . '>خطا مصنع</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">نوع الزجاج </label>
<div class="col-sm-9">
<select name="glass_type">
<option value="">نوع الزجاج</option>
';
    for ($i = 0; $i < count($comData); $i++) {
        echo '<option value="' . $comData[$i]['id'] . '" ' . ($order_details->glass_type == $comData[$i]['id'] ? 'selected' : '') . ' >' . $comData[$i]['company_name'] . '</option>';
    }
    echo '</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">رقم التشغيل</label>
<div class="col-sm-9">
'.$order_details->easy_order_id.'
</div>
</div>';

    if ($_SESSION['user_type'] == 'manmanger') {
        echo '
<div class="form-group">
<label class="col-sm-3 control-label">تغير رقم التشغيل</label>
<div class="col-sm-3">
<input class="form-control"  type="text" name="new_easy_number"   value="" />
</div>
</div>
<div class="alert danger">يرجى العلم فى حالة تغير العميل او رقم التشغيل يجب اعادة طباعة الباركود وتبيلغ الانتاج بسحب الباركود القديم </div>
';
    }

    echo '
</div>


<div class="col-xs-6">

<div class="form-group">
<label class="col-sm-3 control-label">حالة الشغل</label>
<div class="col-sm-9">
<select name="work_status">
<option value="1" ' . ($order_details->work_status == 1 ? 'selected' : '') . ' >عادى</option>
<option value="2" ' . ($order_details->work_status == 2 ? 'selected' : '') . ' >مستعجل</option>
</select>
</div>
</div>';

    if ($_GET['ser'] == "2") {
        echo '<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[980] . '</label>
<div class="col-sm-9"><input class="form-control"  type="text" name="office_name"    value="' . $order_details->office_name . '" /></div>
</div>
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[981] . '</label>
<div class="col-sm-9"><input class="form-control"  type="text" name="operation_name"   value="' . $order_details->operation_name . '" /></div>
</div>';
    }
    $optiontype;
    if ($order_details->option_type =='1') {
        $optiontype="1";
    }
    if ($order_details->option_type =='2') {
        $optiontype="2";
    }


    echo "<div class='form-group'>
<label class='col-sm-3 control-label'>" . $lang[440] . "</label>
<div class='col-sm-9'>
<textarea   name='order_comment'  rows='2' cols='30'>" . $order_details->order_comment . "</textarea>

</div>
<div class='form-group'>
<label class='col-sm-3 control-label'>نوع التشغيل</label>
<div class='col-sm-9'>
<select name='option_type'>
<option value='1' ";
    if ($order_details->option_type =='1') {
        echo " selected";
    }
    echo ">شامل </option><option value='2' ";
    if ($order_details->option_type =='2') {
        echo " selected";
    }

    echo '>اجرة</option>
<option value="3" '.($order_details->option_type == '3' ? 'selected' :'').'>خام</option>
</select>
</div>
</div>';

    echo '
<div class="form-group">
<label class="col-sm-3 control-label">تفاصيل التشغيل</label>
<div class="col-sm-9 chkAction">';

    if (is_array($order_status) && count($order_status) > 0) {
        $status = $order_packages[0]['order_status'];
        $sd = explode(',', $status);

        for ($a = 0; $a < count($order_status); $a++) {
            $check = "";

            for ($b = 0; $b < count($sd); $b++) {
                if ($order_status[$a]['disporder'] == $sd[$b]) {
                    $check = "checked";
                }
            }
            echo '<input name="order_status[]" type="checkbox" ' . $check . ' value="' . $order_status[$a]['disporder'] . '" > ' . $order_status[$a]['statusname'] . '<br>';
        }
    }

    echo '</div>
</div>';


    echo '<div class="form-group">
    <label class="col-sm-3 control-label">السمك</label>
    <div class="col-sm-9">
    <select  name="package_type">
<option value="" >' . $lang[362] . ' </option>';
    for ($i = 0; $i < count($pack); $i++) {
        echo '<option value="' . $pack[$i]['package_id'] . '" ' . ($order_packages[0]['package_type'] == $pack[$i]['package_id'] ? 'selected' : '') . '>' . $pack[$i]['package_name'] . '</option>';
    }
    echo '
</select>
</div>
</div>';



    echo  '<div class="form-group">
    <label class="col-sm-3 control-label">اللون</label>
    <div class="col-sm-9">';
    if (is_array($glassColor) && count($glassColor) > 0) {
        echo '		
<select name="glasscolour"  >';
        for ($a = 0; $a < count($glassColor); $a++) {
            echo '<option value="' . $glassColor[$a]['color_name'] . '"  '.(trim($order_packages[0]['glasscolour']) == trim($glassColor[$a]['color_name']) ? 'selected' : '') . ' >' . $glassColor[$a]['color_name'] . '</option>';
        }
        echo '</select>';
    }

    echo '
    </div>
    </div>


    <div class="form-group">
    <label class="col-sm-3 control-label">المسطح</label>
    <div class="col-sm-9">
<select name="glassType">
<option value="' . $glassType[1] . '" ' . ($order_packages[0]['glassType'] == $glassType[1] ? 'selected' : '') . '>' . $glassType[1] . '</option>
<option value="' . $glassType[2] . '" ' . ($order_packages[0]['glassType'] == $glassType[2] ? 'selected' : '') . '>' . $glassType[2] . '</option>
</select>
</div>
</div>
';




    echo '<div class="form-group">
<label class="col-sm-3 control-label">الفرع</label>
<div class="col-sm-9">
<select name="billing_code">
<option value="0">اختار الفرع</option>
';
    global $billing_codes;
    for ($i=0;$i<count($billing_codes);$i++) {
        echo '<option value="'.$billing_codes[$i]['id'].'" '.($billing_codes[$i]['id'] == $order_details->billing_code ? 'selected' : '').'>'.$billing_codes[$i]['billingcode_name'].'</option>';
    }
    echo '
</select>
</div>
</div>


</div>





</div>

<div style="clear:both;"></div>


<table class="table table-striped table-bordered " id="table" >
';
    global $orders_image;
    for ($i = 0; $i < count($orders_image); $i++) {
        echo '<tr id="image_' . $orders_image[$i]['id'] . '" >
	<td>' . ($i + 1) . '</td>
	<td><img src="' . SITEURL . '/' . $orders_image[$i]['image_url'] . '"  height="100" /> </td>
	<td>
	<div class="hidden-sm hidden-xs btn-group" >
	<button class="btn btn-xs btn-danger" type="button" onclick="delete_photo(\'' . $orders_image[$i]['id'] . '\');">
		<i class="ace-icon fa fa-trash-o bigger-120"></i>
	</button>
    </div>
	</td>
	</tr>';
    }
    for ($j = $i; $j < ($i + 1); $j++) {
        echo '<tr>
<td>' . ($j + 1) . '</td>
<td><input type="file"  name="order_image[]" multiple="" /></td>
<td></td>
</tr>';
    }


    echo '</table>





</div>
</div>
</div>
</div>

<div class=".col-xs-12 pricing-box">
<div class="widget-box widget-color-blue">
<div class="widget-header ">
<div class="widget-title">' . $lang[978] . '</div>
</div>

<div class="widget-body">
<div class="widget-main">

<table  class="table table-striped table-bordered table-hover" id="multi_package">
<tr id="head" name="headofTable">
<th style="width:25px;">+</th>
<th>' . $lang[43] . '</th>
<th>' . $lang[47] . '</th>
<th>' . $lang[363] . '</th>
<th  style="width:200px;">' . $lang[59] . '</th>
<!-- <th style="width:300px;">خدمات</th>
<th>الوان</th>
<th>المسطح</th> -->
';
    if ($_GET['ser'] == "2") {
        echo '
<th>التخليع</th>
<th>حدد للمسح </th>

';
    }
    if ($_GET['ser'] == "1") {
        echo '<th>التخريم</th>
<th>عدد الطبعات</th>
<th>لون الطبعات</th>
<th>حدد للمسح </th>

';
    }
    $x .= '</tr>';

    global  $glassPrint, $glassScarch, $glassPointing, $glassFixedPointing ;
    $numberOfItem = 0 ;



    // if ($order_details->order_status == '0') {
    for ($p = 0; $p < count($order_packages); $p++) {
        $x = "";

        $x .= '<tr>
      
        
        <td class="numOfItem"> '.++$numberOfItem.' </td>
       
	<input type="hidden" name="id[]" value="' . $order_packages[$p]['id'] . '" />
	<input type="hidden" name="part_order[]" value="' . $order_packages[$p]['part_order'] . '" />

<td><input   type="text" name="length[]" size="4" value="' . $order_packages[$p]['length'] . '" /></td>
<td><input   type="text" name="width[]" size="4" value="' . $order_packages[$p]['width'] . '" /></td>
<td><input   type="text" name="parts[]"  size="2" '.($order_details->order_status != 0 ? 'readonly' : '').' value="' . $order_packages[$p]['parts'] . '" /></td>
<td>
<!-- 
<input   type="text" name="details[]" size="30" value="' . $order_packages[$p]['details'] . '" />
<hr/>
-->
    <input   type="text" name="details_2[]" size="30" value="' . $order_packages[$p]['details_2'] . '" />

</td>

';



        if ($_GET['ser'] == "2") {
            $x .= '

	<td>
	<select name="glassPointing[]">
	<option value="' . $glassPointing[1] . '" ' . ($order_packages[$p]['glassPointing'] == $glassPointing[1] ? 'selected' : '') . '>' . $glassPointing[1] . '</option>
    <option value="' . $glassPointing[2] . '" ' . ($order_packages[$p]['glassPointing'] == $glassPointing[2] ? 'selected' : '') . '>' . $glassPointing[2] . '</option>
    <option value="' . $glassPointing[3] . '" ' . ($order_packages[$p]['glassPointing'] == $glassPointing[3] ? 'selected' : '') . '>' . $glassPointing[3] . '</option>
    <option value="' . $glassPointing[4] . '" ' . ($order_packages[$p]['glassPointing'] == $glassPointing[4] ? 'selected' : '') . '>' . $glassPointing[4] . '</option>
    </select>
    </td>
    <td>';
    
            if ($order_packages[$p]['package_status'] == '4') {
                $x .= ' <button type="button" class="btn btn-primary btn-xs stop_item" style="width:30px; height:30; margin:2px;" onclick="event.preventDefault(); play_item(\'' . $order_packages[$p]['id'] . '\');">
<i class="fa fa-play bigger-125 icon-only"></i>
</button>

<button type="button" class="btn btn-primary btn-xs stop_item" style="width:30px; height:30; margin:2px;" onclick="event.preventDefault(); delete_item(\'' . $order_packages[$p]['id'] . '\');">
<i class="fa fa-exclamation-triangle red bigger-130 icon-only"></i>
</button>';
            }

            if ($order_packages[$p]['package_status'] == '1') {
                $x .= '<button type="button" class="btn btn-primary btn-xs stop_item" style="width:30px; height:30; margin:2px;" onclick="event.preventDefault(); stop_item(\'' . $order_packages[$p]['id'] . '\');">
		<i class="fa fa-stop bigger-125 icon-only"></i>
    </button>';
            }
 

   
                                                            
            $x .= '<input type="checkbox" name="record" id="box"   >
	</td>
	';
        }

        if ($_GET['ser'] == "1") {
            $x .= '<td>
	<select name="glassFixedPointing[]">
	<option value="' . $glassFixedPointing[1] . '" ' . ($order_packages[$p]['glassFixedPointing'] == $glassFixedPointing[1] ? 'selected' : '') . '>' . $glassFixedPointing[1] . '</option>
	<option value="' . $glassFixedPointing[2] . '" ' . ($order_packages[$p]['glassFixedPointing'] == $glassFixedPointing[2] ? 'selected' : '') . '>' . $glassFixedPointing[2] . '</option>
	</select>
	</td>
	<td><input type="text" name="noofprinting[]" value="' . $order_packages[$p]['noofprinting'] . '" size="3" /></td>
    <td><input type="text" name="colorofprinting[]" value="' . $order_packages[$p]['colorofprinting'] . '" size="5" /></td>
    <td>
	<input type="checkbox" name="record" id="box"   >
	</td>
	';
        }
        $x .= '</tr>';

        echo $x;
    }


    ///////////
    //  }
    
//     else{

        
//     for ($p = 0; $p < count($order_packages); $p++) {
      
//        $x = "";
//         // <td class="numOfItem"> '.++$numberOfItem.' </td>
//         //<td>'.$order_packages[$p]['part_order'].'</td>
//         $x .= '<tr>
      
        
//         <td class="numOfItem"> '.++$numberOfItem.' </td>
       
    // 	<input type="hidden" name="id[]" value="' . $order_packages[$p]['id'] . '" />
    // 	<input type="hidden" name="part_order[]" value="' . $order_packages[$p]['part_order'] . '" />

    // <td><input   type="text" name="length[]" size="4" value="' . $order_packages[$p]['length'] . '" /></td>
    // <td><input   type="text" name="width[]" size="4" value="' . $order_packages[$p]['width'] . '" /></td>
    // <td><input   type="text" name="parts[]" ' . ($order_packages[$p]['service_id'] == "2" ? 'readonly="true"' : '') . '  size="2" value="' . $order_packages[$p]['parts'] . '" /></td>
    // <td><input   type="text" name="details[]" size="30" value="' . $order_packages[$p]['details'] . '" /><hr/>
    // <input   type="text" name="details_2[]" size="30" value="' . $order_packages[$p]['details_2'] . '" />
    // </td>

    // ';



//         if ($_GET['ser'] == "2") {
//             $x .= '

    // 	<td>
    // 	<select name="glassPointing[]">
    // 	<option value="' . $glassPointing[1] . '" ' . ($order_packages[$p]['glassPointing'] == $glassPointing[1] ? 'selected' : '') . '>' . $glassPointing[1] . '</option>
//     <option value="' . $glassPointing[2] . '" ' . ($order_packages[$p]['glassPointing'] == $glassPointing[2] ? 'selected' : '') . '>' . $glassPointing[2] . '</option>
//     <option value="' . $glassPointing[3] . '" ' . ($order_packages[$p]['glassPointing'] == $glassPointing[3] ? 'selected' : '') . '>' . $glassPointing[3] . '</option>
//     <option value="' . $glassPointing[4] . '" ' . ($order_packages[$p]['glassPointing'] == $glassPointing[4] ? 'selected' : '') . '>' . $glassPointing[4] . '</option>
//     </select>
//     </td>
//     <td>';
    
//             if ($order_packages[$p]['package_status'] == '4') {
//                 $x .= ' <button type="button" class="btn btn-primary btn-xs stop_item" style="width:30px; height:30; margin:2px;" onclick="event.preventDefault(); play_item(\'' . $order_packages[$p]['id'] . '\');">
    // <i class="fa fa-play bigger-125 icon-only"></i>
    // </button>

    // <button type="button" class="btn btn-primary btn-xs stop_item" style="width:30px; height:30; margin:2px;" onclick="event.preventDefault(); delete_item(\'' . $order_packages[$p]['id'] . '\');">
    // <i class="fa fa-exclamation-triangle red bigger-130 icon-only"></i>
    // </button>';
//             }

//             if ($order_packages[$p]['package_status'] == '1') {
//                 $x .= '<button type="button" class="btn btn-primary btn-xs stop_item" style="width:30px; height:30; margin:2px;" onclick="event.preventDefault(); stop_item(\'' . $order_packages[$p]['id'] . '\');">
    // 		<i class="fa fa-stop bigger-125 icon-only"></i>
//     </button>';
//             }
 

   
                                                            
//             $x .= '<input type="checkbox" name="record" id="box"   >
    // 	</td>
    // 	';
//         }

//         if ($_GET['ser'] == "1") {
//             $x .= '<td>
    // 	<select name="glassFixedPointing[]">
    // 	<option value="' . $glassFixedPointing[1] . '" ' . ($order_packages[$p]['glassFixedPointing'] == $glassFixedPointing[1] ? 'selected' : '') . '>' . $glassFixedPointing[1] . '</option>
    // 	<option value="' . $glassFixedPointing[2] . '" ' . ($order_packages[$p]['glassFixedPointing'] == $glassFixedPointing[2] ? 'selected' : '') . '>' . $glassFixedPointing[2] . '</option>
    // 	</select>
    // 	</td>
    // 	<td><input type="text" name="noofprinting[]" value="' . $order_packages[$p]['noofprinting'] . '" size="3" /></td>
//     <td><input type="text" name="colorofprinting[]" value="' . $order_packages[$p]['colorofprinting'] . '" size="5" /></td>
//     <td>
    // 	<input type="checkbox" name="record" id="box"   >
    // 	</td>
    // 	';
//         }
//         $x .= '</tr>';

//         echo $x;
//     }

//     }



   
    echo '


</table>
';
    if ($order_details->order_status == 0) {
        echo '
        <button class="btn btn-danger" type="button" onclick="mov_package_row();">
        <i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
        مسح قطعة&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </button>
        </button>
        <button class="btn btn-danger" type="button"  onclick="add_package_row(1);">
        <i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
        اضافة قطعة&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </button>
        ';
    }


    echo '


</div>
</div>
</div>
</div>



	</div>

		<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">

										<button id="SAVE_' . $order_details->order_id . '" type="button" onclick="check_edit_order(\'edit_order_ah\');" class="btn   btn-info btn-sm"   name="editorderc">
										<i class="ace-icon fa fa-save-o bigger-120" ></i>' . $lang[675] . '
								    	</button>
															
																		
				
										</div>
									</div>
		

		



</form>
';
}
