<?php


function template_main_address()
{
    global $lang;
    echo '
  <script>
  $(document).ready(function() {
    $("#tabs").tabs();
	
	  var $tabs = $("#tabs").tabs({
        add: function(event, ui) {
        $tabs.tabs("select", "#" + ui.panel.id);
    }
});
		
});
</script>

<div id="tabs" >
<ul >';


    echo '
   <li><a href="address.php?action=show_all" class="active">' . $lang[960] . '</a></li> 
   <li><a href="address.php?action=search_address" class="active">' . $lang[432] . '</a></li>
  <!-- <li><a href="address.php?action=address" class="active">' . $lang[507] . '</a></li>  -->
</ul>

<div id="tab1" class="tabset_content">
</div>

<div id="tab2" class="tabset_content">
</div>



</div>

<div id="result"></div>

';

}


function template_search_address()
{
    global $lang, $allacc;

    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/address.js"></script>

<form id="search_address" name="search_address" method="post" action="' . formurl . '/address.php?action=search_address" class="form-horizontal" role="form" >';

    if ($_SESSION['status'] != 1) {
        echo '
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[17] . '</label>
<div class="col-sm-9">
<select name="client"  >
<option value="0">' . $lang[204] . '</option>
';
        for ($i = 0; $i < count($allacc); $i++) {
            echo '<option value="' . $allacc[$i]['account_id'] . '">' . $allacc[$i]['account_name'] . ' | ' . $allacc[$i]['account_company'] . '</option>';
        }

        echo '
</select>
</div>
</div>';
    } else {
        echo '<input type="hidden" name="client" value="' . $_SESSION['account_id'] . '" />';
    }

    echo '<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[36] . '</label>
<div class="col-sm-9"><input type="text" name="name" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><textarea name="addr" ></textarea></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[9] . '</label>
<div class="col-sm-9"><input type="text" name="postalcode" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[288] . '</label>
<div class="col-sm-9"><input type="text" name="attn" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="phone" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[386] . '</label>
<div class="col-sm-9"><input type="text" name="route" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[12] . '</label>
<div class="col-sm-9"><input type="text" name="fax" value=""></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . '</label>
<div class="col-sm-9"><input type="text" name="email" value=""></div>
</div>

<div style="clear:both;"></div>

<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
<input type="button" onclick="full_search_address();" value="' . $lang[26] . '"  name="search" class="btn btn-info" />
</div>
</div>



</form>

<div id="search_result">
</div>
<div id="edit_address"></div>
';

}

function template_maddress()
{
    global $add_no, $lang, $allacc, $id;

    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/address.js"></script>

<form id="address_' . $id . '" action="' . formurl . '/address.php?action=address&id=' . $id . '"  method="post" class="form-horizontal" role="form" >';

    if ($_SESSION['status'] != 1) {
        echo '
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[17] . '</label>
<div class="col-sm-9">
<select name="client"  >
<option value="0">' . $lang[204] . '</option>
';
        for ($i = 0; $i < count($allacc); $i++) {
            echo '<option value="' . $allacc[$i]['account_id'] . '"  ' . (isset($add_no->client) && ($allacc[$i]['account_id'] == $add_no->client) ? 'selected' : '') . '>' . $allacc[$i]['account_name'] . ' | ' . $allacc[$i]['account_company'] . '</option>';
        }

        echo '
</select>
</div>
</div>';

    } else {
        echo '<input type="hidden" name="client" value="' . $_SESSION['account_id'] . '" />';
    }


    echo '
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[36] . '</label>
<div class="col-sm-9"><input type="text" name="name" value="' . (isset($add_no->name) ? $add_no->name : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><textarea name="addr" >' . (isset($add_no->addr) ? $add_no->addr : '') . '</textarea></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[9] . '</label>
<div class="col-sm-9"><input type="text" name="postalcode" value="' . (isset($add_no->postalcode) ? $add_no->postalcode : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[288] . '</label>
<div class="col-sm-9"><input type="text" name="attn" value="' . (isset($add_no->attn) ? $add_no->attn : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="phone" value="' . (isset($add_no->phone) ? $add_no->phone : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[386] . '</label>
<div class="col-sm-9"><input type="text" name="route" value="' . (isset($add_no->route) ? $add_no->route : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[12] . '</label>
<div class="col-sm-9"><input type="text" name="fax" value="' . (isset($add_no->fax) ? $add_no->fax : '') . '"></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . '</label>
<div class="col-sm-9"><input type="text" name="email" value="' . (isset($add_no->email) ? $add_no->email : '') . '"></div>
</div>


<div style="clear:both;"></div>

<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">

';

    if (isset($_GET['id'])) {
        echo '<input type="button" onclick="add_address(\'' . $id . '\');" value="' . $lang[510] . '"  name="addorder" class="btn btn-info" style="margin:10px auto; float:none;"/>';
    } else {
        echo '<input type="button" onclick="add_address(\'' . $id . '\');" value="' . $lang[507] . '"  name="addorder" class="btn btn-info" style="margin:10px auto; float:none;"/>';
    }

    echo '</div>
</div>


</form>
<div style="clear:both;"></div>

';
}

//Start koko
function template_show_all()
{
    global $lang;

    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] == 1) {
            echo '<script> var type = "client"; </script>';
        }
        if ($_SESSION['status'] == 2) {
            echo '<script> var type = "administrator"; </script>';
        }
    }

    echo '<table id="grid-table"></table>
	      <div id="perpage"></div>
	      <script>
		 
		 
	$("#grid-table").jqGrid({
		url: "../"+type+"/address.php?action=get_data",
		datatype: "json",
		mtype: "GET",
		colNames: ["Id", "Name", "Address", "Phone","Alt Phone", "Email", "Attention", "PC/Zip", "Client Name"],
		colModel: [
		{ name: "id",align:"center","width": 60,searchoptions:{sopt:["eq"]},editable:false,editoptions:{readonly:true,size:10}},
		{ name: "name",align:"center","width": 115,searchoptions:{sopt:["eq","cn"]},editable:true,editoptions:{size:30}},
		{ name: "addr",align:"center","width": 120,searchoptions:{sopt:["eq","cn"]},editable:true,editoptions:{size:30}},
		{ name: "phone",align:"center","width": 115,searchoptions:{sopt:["eq","cn"]},editable:true,editoptions:{size:30}},
		{ name: "alt_phone",align:"center","width": 100,searchoptions:{sopt:["eq","cn"]},editable:true,editoptions:{size:30}},
		{ name: "email",align:"center","width": 115,searchoptions:{sopt:["eq","cn"]},editable:true,editoptions:{size:30}},
		{ name: "attn",align:"center","width": 115,searchoptions:{sopt:["eq","cn"]},editable:true,editoptions:{size:30}},
		{ name: "postalcode",align:"center","width": 100,searchoptions:{sopt:["eq","cn"]},editable:true,editoptions:{size:30}},
		{ 
		name: "client",
		align:"center",
		"width": 100,	
		searchoptions:{sopt:["eq","cn"]},
		editable:true,
		edittype:"select",
		editoptions:{dataUrl:"../"+type+"/address.php?action=show_accounts"}},
		],
		pager: "#perpage",
		rowNum: 10,
		rowList: [10,20,30],
		sortname: "id",
		sortorder: "desc",
		height: "auto",
		viewrecords: true,
		gridview: true,
		caption: "Address",
		editurl:"../"+type+"/address.php?action=edit_address"
		}); 

   jQuery("#grid-table").navGrid("#perpage",{},{height:432,width:580,reloadAfterSubmit:false,closeAfterEdit: true},{height:432,width:580,reloadAfterSubmit:true,closeAfterAdd: true},{reloadAfterSubmit:false},{}
);

  
   </script>';

}

//End koko

function template_faddress_table()
{

    global $lang, $add, $add_no, $page_no, $start;
    echo '
<div id="del_address"></div>
<table border="1" class="table table-striped table-bordered table-hover" id="client_addr" style="width:100%; font-size:10px; line-height:10px;">
<tr>
<th>' . $lang[36] . '</th>
<th>' . $lang[7] . '</th>
<th>' . $lang[9] . '</th>
<th>' . $lang[288] . '</th>
<th>' . $lang[11] . '</th>
<th>' . $lang[386] . '</th>
<th>' . $lang[387] . '</th>
<th>' . $lang[312] . '</th>
<th>' . $lang[259] . '</th>
</tr>';

    if (is_array($add) && count($add) > 0) {

        for ($i = 0; $i < count($add); $i++) {
            echo '
<tr id="addr_' . $add[$i]['id'] . '" onclick="addaddr(\'' . $add[$i]['id'] . '\');" >
<td>' . $add[$i]['name'] . '</td>
<td>' . $add[$i]['addr'] . '</td>
<td>' . $add[$i]['postalcode'] . '</td>
<td>' . $add[$i]['attn'] . '</td>
<td>' . $add[$i]['phone'] . '</td>
<td>' . $add[$i]['route'] . '</td>
<td>' . $add[$i]['terms'] . '</td>
<td><img src="' . SITEURL . '/' . STYLE . '/css/images/icon-edit.gif" height="17" width="33" alt="Edit this entry" onclick="show_edit_address(\'' . $add[$i]['id'] . '\',\'' . $add[$i]['name'] . '\');"></td>

<td><img src="' . SITEURL . '/' . STYLE . '/css/images/icon-delete.gif" height="11" width="11" alt="Delete this entry" onclick="delete_address1(\'' . $add[$i]['id'] . '\',\'' . $add[$i]['name'] . '\',\'' . ($start) . '\',\'' . $add[0]['client'] . '\',\'id\',\'DESC\');"></td>
</tr>
';

        }

        if ($add_no > 10) {


            echo '
<tr>
<th >' . $lang[390] . '' . $page_no . '</th>
<th colspan="6">

<div class="pagination">

													
<ul class="pag_list">
													
';
            $x = 10;

            if ((round(($add_no - $start) / 10)) < 10)
                $x = (round(($add_no - $start) / 10));

            $m = 0;
            $n = 0;
            for ($p = ($start / 10); $p < (($start / 10) + 10); $p++) {


                if ($m == 0 and ($start) >= 10) {
                    echo '<li><a href="#" onclick="addr_paging(\'' . ($start - 10) . '\',\'' . $add[0]['client'] . '\',\'id\',\'DESC\');" class="button light_blue_btn"><span><span>PREVIOUS</span></span></a> </li>';
                    $m++;
                }


                echo '<li><a href="#" onclick="addr_paging(\'' . ($p * 10) . '\',\'' . $add[0]['client'] . '\',\'id\',\'DESC\');" class="current_page"><span><span>' . ($p + 1) . '</span></span></a></li>';


                if ($p == (($start / 10) + 9) and ($start + 10) < ($page_no + 1) * 10) {
                    echo '<li><a href="#"  onclick="addr_paging(\'' . ($start + 10) . '\',\'' . $add[0]['client'] . '\',\'id\',\'DESC\');" class="button light_blue_btn"><span><span>NEXT</span></span></a> </li>';
                }


            }

            echo '
</ul>
<div>
</th>
<th colspan="3">' . $lang[389] . '' . $add_no . '</th>
</tr>';
        }

    } else {
        echo '<tr>
<td colspan="8">' . $lang[388] . '</td>
</tr>';
    }

    echo '
</table>
';
}


?>