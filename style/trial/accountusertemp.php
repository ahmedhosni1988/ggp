<?php
function template_account_manage()
{
    global $lang;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
  <script>
  $(document).ready(function() {
    $("#tabs").tabs();
	

	
  });
  
  </script>
  

<div id="tabs" >

<ul>
   <li><a href="accounts.php?action=active" >' . $lang[713] . '</a></li>
   <li><a href="accounts.php?action=unactive" >' . $lang[714] . '</a></li>
   <li><a href="accounts.php?action=delaccount" >' . $lang[715] . '</a></li>
   <li><a href="accounts.php?action=mange_add_account" >' . $lang[716] . '</a></li>

</ul>

<div id="tabs-0" class="tabset_content" >
</div>

<div id="tabs-1" class="tabset_content">
</div>

<div id="tabs-2" class="tabset_content">
</div>

<div id="tabs-3" class="tabset_content">
</div>

   		<div id="tabs-4" class="tabset_content">
</div>
   		
</div>

';
}

function template_active_account()
{
    global $accounts, $lang;

    if (is_array($accounts)) {
        //print_r($data);
        echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
<link rel="stylesheet" type="text/css" href="'.SITEURL.'/'.STYLE.'/assets/DataTables/DataTables/css/dataTables.jqueryui.min.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
	<style>
    #TableAccount tr:nth-child(odd) {
		background-color: #e9e9e9;
	}
	
    #TableAccount td {
		padding: 5px !important;
		font-size: 15px;
	}
    #TableAccount tr:nth-child(even) {
		background-color: #f6f6f6;
	}
    #TableAccount th{
	font-weight: 900;
		color: #ffffff;
		background:  #307ecc;
	
    }
    .DataTables_sort_wrapper{
        display: inline-block !important;

    }
  	</style>
    <div style="overflow-x: auto">
<table style="width:100%;" border="1" id="TableAccount" class="table table-striped table-bordered table-hover"> 

<thead>
<th>' . $lang[257] . '</th>
<th>' . $lang[717] . '</th>
<th>' . $lang[36] . '</th>
<th>' . $lang['billing_code'] . '</th> 
<th>' . $lang[431] . '</th>
<th>' . $lang[718] . '</th>
<th>' . $lang[11] . '</th>
<th>' . $lang[312] . '</th>
</thead>


';
        if (is_array($accounts) && count($accounts) > 0) {
            for ($i = 0; $i < count($accounts); $i++) {
                echo '<tr>';
                $x = $accounts[$i];
          
                foreach ($x as $val) {
                   
                    //  $tex = $val[key($val)];

                    // $tex = str_replace(",","<br>",$tex);

                    echo '<td>' . $val . '</td>';
                }


                echo '<td><a onclick="show_edit_account(\'' . $accounts[$i]['account_id'] . '\',\'' . $accounts[$i]['account_name'] . '\');" href="#" >' . $lang[312] . '</a></td>';

                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
        }
        echo '</table></div>
      
         <script src="'.SITEURL.'/'.STYLE.'/jscript/jquery.dataTables.min.js"></script>
         <script src="'.SITEURL.'/'.STYLE.'/jscript/dataTables.jqueryui.min.js"></script>
         <script src="'.SITEURL.'/'.STYLE.'/jscript/dataTables.buttons.min.js"></script>
         <script src="'.SITEURL.'/'.STYLE.'/jscript/jszip.min.js"></script>
         <script src="'.SITEURL.'/'.STYLE.'/jscript/pdfmake.min.js"></script>
         <script src="'.SITEURL.'/'.STYLE.'/jscript/vfs_fonts.js"></script>
         <script src="'.SITEURL.'/'.STYLE.'/jscript/buttons.html5.min.js"></script>
       
         <script>
         $("#TableAccount").DataTable({
             lengthMenu: [ 30, 50, 100, 200, 500], 
             dom: "Bfrtip",
             buttons: ["pageLength"
             ],

         });
         </script>

';
    }
}

function template_manage_add_account()
{
    global $lang, $account_id;

    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
  <script>
  $(document).ready(function() {
    $("#mange_add_' . $account_id . '").tabs({
//    beforeActivate: function( event, ui ) {
//        alert($("#open_price").val());
//    }
load: function( event, ui ) {

}
    });  
  });
  </script>
  
<div id="right_side">
<div id="mange_add_' . $account_id . '" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>';

    if (isset($account_id) && $account_id != "") {
        if ($_SESSION['billing_code'] > '0') {
            echo '
            <li><a href="accounts.php?action=account_details&account_id=' . $account_id . '" >' . $lang[497] . '</a></li>
           ';
        } else {
            echo '
            <li><a href="accounts.php?action=account_details&account_id=' . $account_id . '" >' . $lang[497] . '</a></li>
          <!--  <li><a href="accounts.php?action=price_details&account_id=' . $account_id . '" > ' . $lang[1019] . '</a></li>
            <li><a href="pricing.php?action=account_serves&account_id=' . $account_id . '" > ' . $lang[44] . '</a></li>
           -->
           ';
        }
    } else {
        echo '	
   <li><a href="accounts.php?action=account_details" >' . $lang[497] . '</a></li>
  ';
    }

    echo '
</ul>

<div id="mange_add_' . $account_id . '-0"  >
</div>

<div id="mange_add_' . $account_id . '-1" >
</div>

<div id="mange_add_' . $account_id . '-2" >
</div>

<div id="mange_add_' . $account_id . '-3" >
</div>

<div id="mange_add_' . $account_id . '-4" >
</div>

<div id="mange_add_' . $account_id . '-5" >
</div>

	
</div>
<div style="clear:both;"></div>
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<div style="clear:both;"></div>
';
}

function template_account_details()
{

//    <div class="form-group">
    //<label class="col-sm-3 control-label">' . $lang[17] . '</label>
    //<div class="col-sm-9"><input type="text" name="account_name" value="' . (isset($account_details->account_name) ? $account_details->account_name : '') . '" ' . ($account_id != '' ? 'disabled' : '') . '  /></div>
    //</div>
    global $lang, $locations, $usertype, $account_details, $account_id, $zone,$billing_code,$tax_group;
    echo '
    <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/account.js"></script>


<form name="add_account_' . $account_id . '" id="add_account_details_' . $account_id . '" method="post" action="accounts.php?action=account_details&account_id=' . $account_id . '" class="form-horizontal">

<div class="col-sm-6 col-xs-12"  >



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[6] . '</label>
<div class="col-sm-9"><input type="text" name="account_company" value="' . (isset($account_details->account_company) ? $account_details->account_company : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[118] . '</label>
<div class="col-sm-9"><input type="text" name="account_shortname" value="' . (isset($account_details->account_shortname) ? $account_details->account_shortname : '') . '" /></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><textarea name="account_address" >' . (isset($account_details->account_address) ? $account_details->account_address : '') . '</textarea></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[8] . '</label>
<div class="col-sm-9"><input type="text" name="city" value="' . (isset($account_details->city) ? $account_details->city : '') . '" /></div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="phone" value="' . (isset($account_details->phone) ? $account_details->phone : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">الرقم القومى</label>
<div class="col-sm-9"><input type="text" name="ssn" value="' . (isset($account_details->ssn) ? $account_details->ssn : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">رقم البطاقة الضريبيه</label>
<div class="col-sm-9"><input type="text" name="vatno" value="' . (isset($account_details->vatno) ? $account_details->vatno : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">المجموعة</label>
<div class="col-sm-9">
<select name="account_taxgroup">
<option value="">اختار المجموعه الضريبيه</option>
';
    for ($i=0;$i<count($tax_group);$i++) {
        echo '<option value="'.$tax_group[$i]['taxgroup_id'].'" '.(isset($account_details->account_taxgroup) && $account_details->account_taxgroup == $tax_group[$i]['taxgroup_id'] ?  'selected' : '').'>'.$tax_group[$i]['taxgroup_name'].'</option>';
    }
    echo '</select>



</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[440] . '</label>
<div class="col-sm-9"><textarea name="note_comment" >' . (isset($account_details->note_comment) ? $account_details->note_comment : '') . '</textarea></div>
</div>



		
</div>

<div class="col-sm-6 col-xs-12" >

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[120] . ' (1)</label>
<div class="col-sm-9"><input type="text" name="phone2" value="' . (isset($account_details->phone2) ? $account_details->phone2 : '') . '" /></div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label"  >' . $lang[610] . '</label>
<div class="col-sm-9"><input type="text" name="phone2type" value="' . (isset($account_details->phone2type) ? $account_details->phone2type : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[120] . ' (2) </label>
<div class="col-sm-9"><input type="text" name="phone3" value="' . (isset($account_details->phone3) ? $account_details->phone3 : '') . '" /></div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label"  >' . $lang[610] . '</label>
<div class="col-sm-9"><input type="text" name="phone3type" value="' . (isset($account_details->phone3type) ? $account_details->phone3type : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[120] . '(3)</label>
<div class="col-sm-9"><input type="text" name="phone4" value="' . (isset($account_details->phone4) ? $account_details->phone4 : '') . '" /></div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" >' . $lang[610] . '</label>
<div class="col-sm-9"><input type="text" name="phone4type" value="' . (isset($account_details->phone4type) ? $account_details->phone4type : '') . '" /></div>
</div>





<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[177] . '</label>
<div class="col-sm-9">
<select name="status">
<option value="1" ' . (isset($account_details->status) && $account_details->status == "1" ? 'selected' : '') . ' >نشط</option>
<option value="2" ' . (isset($account_details->status) && $account_details->status == "2" ? 'selected' : '') . ' >غير نشط</option>
<option value="3" ' . (isset($account_details->status) && $account_details->status == "3" ? 'selected' : '') . ' >حذف</option>
</select>
</div>
</div>';

    if ($_SESSION['billing_code'] > "0") {
        echo '<input type="hidden" name="billing_code" value="'.$_SESSION['billing_code'].'" />';
    } else {
        echo '
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang['billing_code'] . '</label> 
<div class="col-sm-9">
<select name="billing_code" validate="notempty">
<option value="">اختار الفرع</option>
';
        for ($i = 0; $i < count($billing_code); $i++) {
            echo '<option value="'.$billing_code[$i]['id'].'" ' . (isset($account_details->billing_code) && $account_details->billing_code == $billing_code[$i]['id'] ? 'selected' : '') . ' >'.$billing_code[$i]['billingcode_name'].'</option>';
        }
        echo '
</select>
</div>
</div>';
    }


    echo '</div>
</div>


<div style="clear:both;"></div>

<hr>
<div class="form-group">
<div class="col-sm-9" style="width: 200px; float: none;margin: auto; height:40px;">  
<input type="button" id="add_acc" onclick="add_accountss(\'' . $account_id . '\');"  value="' . $lang[50] . '" class="btn btn-info"  name="edituser"/>';
    if ($account_id != '') {
        echo '<input type="button" style="margin: 5px; " id="close" onclick="close_my_tab(\'' . $account_id . '\');"  value="' . $lang[200] . '" class="btn btn-danger"  />';
    }
    echo '</div>
</div>


<div style="clear:both;"></div>

</form>
<div style="clear:both;"></div>
<div id="result"></div>
<div style="clear:both;"></div>
';
}

function template_contact_details()
{
    global $lang, $account_contacts, $account_id;
    echo '


<form name="add_account" id="edit_contact_details_' . $account_id . '" method="post" action="' . SITEURL . '/administrator/accounts.php?action=contact_details&account_id=' . $account_id . '" class="form-horizontal">
<input type="hidden" name="is_post" value="1" />
<div class="col" style=" width:100%;" >

<div class="title">' . $lang[10] . '</div>
<div style="clear:both;"></div>
';


    for ($i = 0; $i < 3; $i++) {
        echo '
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[10] . ' (' . ($i + 1) . ')</label>
<div class="col-sm-9"><input type="text" name="nc__contact_name[]" value="' . (isset($account_contacts[$i]['contact_name']) ? $account_contacts[$i]['contact_name'] : '') . '" /></div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . ' (' . ($i + 1) . ')</label>
<div class="col-sm-9"><input type="text" name="nc__contact_phone[]" value="' . (isset($account_contacts[$i]['phone']) ? $account_contacts[$i]['phone'] : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . ' (' . ($i + 1) . ')</label>
<div class="col-sm-9"><input type="text" name="nc__contact_email[]" value="' . (isset($account_contacts[$i]['email']) ? $account_contacts[$i]['email'] : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">
<input type="hidden" name="nc__email_notify[' . $i . ']" value="0" />
<input type="checkbox" name="nc__email_notify[' . $i . ']" value="1" ' . (isset($account_contacts[$i]['email_notify']) && $account_contacts[$i]['email_notify'] == 1 ? 'checked' : '') . ' />
		</label>
<div class="col-sm-9">' . $lang[441] . '</div>
</div>

<div style="clear:both;"></div>

';
    }
    echo '<hr>
<div style="clear:both;"></div>

<div class="clearfix form-actions">
<div class="col-md-offset-3 col-md-9">
  <button class="btn btn-info" type="button" onclick="edit_contact_details(\'' . $account_id . '\');" name="edituser">
    <i class="ace-icon fa fa-check bigger-110"></i>
    ' . $lang[50] . '
  </button>

  &nbsp; &nbsp; &nbsp;

</div>
</div>



</div>
</form>
<div style="clear:both;"></div>

';
}

function template_finical_details()
{
    global $lang, $tax_group, $billing_freq, $payment_term, $payment_type, $account_details, $account_id, $price_over, $billing_code;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/account.js"></script>


<form name="add_account" id="edit_finical_details_' . $account_id . '" method="post" action="' . SITEURL . '/administrator/accounts.php?action=finical_details&account_id=' . $account_id . '" class="form-horizontal" >
<div class="col" >

<div class="title">' . $lang[439] . '</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[442] . '</label>
<div class="col-sm-9" >' . $lang[443] . '</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[36] . '</label>
<div class="col-sm-9"><input type="text" name="billto_company" value="' . (isset($account_details->billto_company) ? $account_details->billto_company : '') . '"/> </div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><textarea name="billto_addr" >' . (isset($account_details->billto_addr) ? $account_details->billto_addr : '') . '</textarea></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[8] . '</label>
<div class="col-sm-9"><input type="text" name="billto_city" value="' . (isset($account_details->billto_city) ? $account_details->billto_city : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[9] . '</label>
<div class="col-sm-9"><input type="text" name="billto_pcode" value="' . (isset($account_details->billto_pcode) ? $account_details->billto_pcode : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="billto_phone" value="' . (isset($account_details->billto_phone) ? $account_details->billto_phone : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[12] . '</label>
<div class="col-sm-9"><input type="text" name="billto_fax" value="' . (isset($account_details->billto_fax) ? $account_details->billto_fax : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[444] . '</label>
<div class="col-sm-9"><input type="text" name="billto_apcontact" value="' . (isset($account_details->billto_apcontact) ? $account_details->billto_apcontact : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . '</label>
<div class="col-sm-9"><input type="text" name="billto_apcontact_email" value="' . (isset($account_details->billto_apcontact_email) ? $account_details->billto_apcontact_email : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[445] . '</label>
<div class="col-sm-9"><input type="text" name="credit_limit" value="' . (isset($account_details->credit_limit) ? $account_details->credit_limit : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[446] . '</label>
<div class="col-sm-9"><input type="hidden" name="credit_hold" value="0" />
<input type="checkbox" name="credit_hold" value="1" ' . (isset($account_details->credit_hold) && $account_details->credit_hold == 1 ? 'checked' : '') . ' /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[157] . '</label>
<div class="col-sm-9"><select name="account_taxgroup">
<option value="">' . $lang[591] . '</option>
';
    for ($i = 0; $i < count($tax_group); $i++) {
        echo '<option value="' . $tax_group[$i]['taxgroup_id'] . '" ' . (isset($account_details->account_taxgroup) && $account_details->account_taxgroup == $tax_group[$i]['taxgroup_id'] ? 'selected' : '') . '>' . $tax_group[$i]['taxgroup_name'] . '</option>';
    }
    echo '</select></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[162] . '</label>
<div class="col-sm-9"><select name="account_terms">';
    for ($i = 0; $i < count($payment_term); $i++) {
        echo '<option value="' . $payment_term[$i]['pt_id'] . '" ' . (isset($account_details->account_terms) && $account_details->account_terms == $payment_term[$i]['pt_id'] ? 'selected' : '') . ' >' . $payment_term[$i]['pt_name'] . '</option>';
    }
    //$usertype
    echo '</select></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[159] . '</label>
<div class="col-sm-9"><select name="account_method">
<option value="">Select pay Method</option>

';
    for ($i = 0; $i < count($payment_type); $i++) {
        echo '<option value="' . $payment_type[$i]['payment_id'] . '" ' . (isset($account_details->account_method) && $account_details->account_method == $payment_type[$i]['payment_id'] ? 'selected' : '') . ' >' . $payment_type[$i]['payment_name'] . '</option>';
    }
    //$usertype
    echo '</select></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[160] . '</label>
<div class="col-sm-9"><select name="account_billingfreq">
<option value="">Select Billing Frequency</option>
';
    for ($i = 0; $i < count($billing_freq); $i++) {
        echo '<option value="' . $billing_freq[$i]['option_id'] . '" ' . (isset($account_details->account_billingfreq) && $account_details->account_billingfreq == $billing_freq[$i]['option_id'] ? 'selected' : '') . '>' . $billing_freq[$i]['option_value'] . '</option>';
    }
    //$usertype
    echo '</select></div>
</div>';

    if (count($billing_code) > 0) {
        echo '<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[161] . '</label>
<div class="col-sm-9"><select name="billing_code">';
        for ($i = 0; $i < count($billing_code); $i++) {
            echo '<option value="' . $billing_code[$i]['id'] . '" ' . (isset($account_details->billing_code) && $account_details->billing_code == $billing_code[$i]['id'] ? 'selected' : '') . '>' . $billing_code[$i]['billingcode_name'] . '</option>';
        }
        echo '</select></div>
</div>';
    }

    echo '
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[447] . '</label>
<div class="col-sm-9"><input type="text" name="fs_ovrd" value="' . (isset($account_details->fs_ovrd) ? $account_details->fs_ovrd : '') . '" style="clear:both;"/></div>
<br><br>' . $lang[448] . '
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[69] . '</label>
<div class="col-sm-9">
<select name="invoiceoption_8">
<option value="0" ' . (isset($account_details->invoiceoption_8) && $account_details->invoiceoption_8 == 0 ? 'selected' : '') . ' >' . $lang[450] . '</option>
<option value="1" ' . (isset($account_details->invoiceoption_8) && $account_details->invoiceoption_8 == 1 ? 'selected' : '') . ' >' . $lang[451] . '</option>
<option value="2" ' . (isset($account_details->invoiceoption_8) && $account_details->invoiceoption_8 == 2 ? 'selected' : '') . ' >' . $lang[452] . '</option>

</select>
</div>
<br><br>' . $lang[449] . '
</div>
<div style="clear:both;"></div>
<hr/>
<div class="form-group">
<div class="col-sm-9" style="width: 200px; float: none;margin: auto; height:40px;"  ><input type="button"  onclick="edit_finical_details(\'' . $account_id . '\');"  value="' . $lang[50] . '" class="btn btn-info"  /></div>
</div>

</div>
</form>
<div style="clear:both;"></div>
';
}

function template_pricing_details()
{
    global $lang, $company_setting, $package_details, $pieces_details, $ser, $vec, $account_details, $account_id, $price_over, $ser_over, $pickup_fee, $delivery_fee, $dfees, $sett_compnay, $val, $vechile_services;
    global $dfees, $c_setting;
    //var_dump($dfees);
    echo '
		<style>
		.col{
float:none;
width:auto;
}
		</style>
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/account.js"></script>

<form  id="edit_pricing_details_' . $account_id . '"" method="post" action="' . SITEURL . '/administrator/accounts.php?action=pricing_details&account_id=' . $account_id . '" class="form-horizontal">

<div class="col">
' . $lang[453] . '
<div style="clear:both;"></div>

<div class="col" style="width:48%; float:left; border-right:#000 1px solid;">
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[454] . '</label>
<div class="col-sm-9">
<select name="price_ovrd_quotes">
<option value="1"   ' . (isset($account_details->price_ovrd_quotes) && $account_details->price_ovrd_quotes == 0 ? 'selected' : '') . ' >&nbsp;&nbsp; ' . $lang[450] . '</option>
<option value="2"  ' . (isset($account_details->price_ovrd_quotes) && $account_details->price_ovrd_quotes == "N" ? 'selected' : '') . '  >&nbsp;&nbsp; ' . $lang[347] . '</option>
<option value="3"   ' . (isset($account_details->price_ovrd_quotes) && $account_details->price_ovrd_quotes == "H" ? 'selected' : '') . ' >&nbsp;&nbsp; ' . $lang[348] . '</option>
<option value="4"  ' . (isset($account_details->price_ovrd_quotes) && $account_details->price_ovrd_quotes == "S" ? 'selected' : '') . ' >&nbsp;&nbsp; ' . $lang[349] . '</option>
<option value="5"  ' . (isset($account_details->price_ovrd_quotes) && $account_details->price_ovrd_quotes == "Y" ? 'selected' : '') . '  >&nbsp;&nbsp; ' . $lang[350] . '</option>
</select>
<br>
<br>
</div>
<div style="clear:both;"></div>
' . $lang[455] . '
<br>
<br>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[457] . '</label>
<div class="col-sm-9">' . $lang[467] . '<br><br></div>
</div>


<div class="col" style="padding:10px;">
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[43] . '</label>
<div class="col-sm-9">
<table>
<tr><td align="center" >
<input type="radio" name="price_ovrd_apply_overwt"  value="1" ' . (isset($account_details->price_ovrd_apply_overwt) && $account_details->price_ovrd_apply_overwt == 1 ? 'checked' : '') . '></td>
<td >' . $lang[450] . '</td></tr>

<tr><td align="center" ><input type="radio" name="price_ovrd_apply_overwt"  value="2" ' . (isset($account_details->price_ovrd_apply_overwt) && $account_details->price_ovrd_apply_overwt == 2 ? 'checked' : '') . '></td>
<td>' . $lang[335] . '</td></tr>

<tr><td align="center" ><input type="radio" name="price_ovrd_apply_overwt"  value="3" ' . (isset($account_details->price_ovrd_apply_overwt) && $account_details->price_ovrd_apply_overwt == 3 ? 'checked' : '') . '></td>
<td>' . $lang[336] . '</td>
</tr>

</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[47] . '</label>
<div class="col-sm-9">
<table>
<tr><td align="center" >
<input type="radio" name="price_ovrd_apply_overvol"  value="1" ' . (isset($account_details->price_ovrd_apply_overvol) && $account_details->price_ovrd_apply_overvol == 1 ? 'checked' : '') . '></td>
<td >' . $lang[450] . '</td></tr>

<tr><td align="center" ><input type="radio" name="price_ovrd_apply_overvol"  value="2" ' . (isset($account_details->price_ovrd_apply_overvol) && $account_details->price_ovrd_apply_overvol == 2 ? 'checked' : '') . '></td>
<td>' . $lang[337] . '</td></tr>

<tr><td align="center" ><input type="radio" name="price_ovrd_apply_overvol"  value="3" ' . (isset($account_details->price_ovrd_apply_overvol) && $account_details->price_ovrd_apply_overvol == 3 ? 'checked' : '') . ' ></td>
<td>' . $lang[336] . '</td>
</tr>

</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[269] . '</label>
<div class="col-sm-9">
<table>
<tr><td align="center" >
<input type="radio" name="price_ovrd_apply_overpcs"  value="1" ' . (isset($account_details->price_ovrd_apply_overpcs) && $account_details->price_ovrd_apply_overpcs == 1 ? 'checked' : '') . ' ></td>
<td >' . $lang[450] . '</td></tr>

<tr><td align="center" ><input type="radio" name="price_ovrd_apply_overpcs"  value="2" ' . (isset($account_details->price_ovrd_apply_overpcs) && $account_details->price_ovrd_apply_overpcs == 2 ? 'checked' : '') . '></td>
<td>' . $lang[339] . '</td></tr>

<tr><td align="center" ><input type="radio" name="price_ovrd_apply_overpcs"  value="3" ' . (isset($account_details->price_ovrd_apply_overpcs) && $account_details->price_ovrd_apply_overpcs == 3 ? 'checked' : '') . '></td>
<td>' . $lang[336] . '</td>
</tr>

</table>
</div>
</div>


</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[473] . '</label>
<div class="col-sm-9">' . $lang[474] . '</div>
<div class="col" style="padding:10px;">

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[475] . '</label>
<div class="col-sm-9"><input type="text" name="price_ovrd_del_fee" value="' . (isset($account_details->price_ovrd_del_fee) ? $account_details->price_ovrd_del_fee : '') . '" size="10" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[476] . '</label>
<div class="col-sm-9">
<div class="col">
<table>
<tr>
<td>' . $lang[477] . '</td>
<td><input type="radio" name="price_ovrd_apply_delfee"  value="1" ' . (isset($account_details->price_ovrd_apply_delfee) && $account_details->price_ovrd_apply_delfee == 1 ? 'checked' : '') . '></td>
</tr>
<tr>
<td>' . $lang[478] . '</td>
<td><input type="radio" name="price_ovrd_apply_delfee"  value="2" ' . (isset($account_details->price_ovrd_apply_delfee) && $account_details->price_ovrd_apply_delfee == 2 ? 'checked' : '') . '></td>
</tr>
<tr>
<td>' . $lang[479] . '</td>
<td><input type="radio" name="price_ovrd_apply_delfee"  value="3" ' . (isset($account_details->price_ovrd_apply_delfee) && $account_details->price_ovrd_apply_delfee == 3 ? 'checked' : '') . '></td>
</tr>

</table>
</div>
</div>
</div>


</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[480] . '</label>
<div class="col-sm-9">' . $lang[481] . '</div>
<div class="col" style="padding:10px;">

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[480] . '</label>
<div class="col-sm-9"><input type="text" name="price_ovrd_volume_discount" value="' . (isset($account_details->price_ovrd_volume_discount) ? $account_details->price_ovrd_volume_discount : '') . '" size="10" />' . $lang[720] . ' %</div>
</div>

<table>
<tr>
<td >' . $lang[532] . '</td><td><input type="radio" name="price_ovrd_vol_disc_prior"  value="0" ' . (isset($account_details->price_ovrd_vol_disc_prior) && $account_details->price_ovrd_vol_disc_prior == 0 ? 'checked' : '') . '></td>
<td >2 ' . $lang[721] . '</td><td><input type="radio" name="price_ovrd_vol_disc_prior"  value="2" ' . (isset($account_details->price_ovrd_vol_disc_prior) && $account_details->price_ovrd_vol_disc_prior == 2 ? 'checked' : '') . '></td>
<td >3 ' . $lang[721] . '</td><td><input type="radio" name="price_ovrd_vol_disc_prior"  value="3" ' . (isset($account_details->price_ovrd_vol_disc_prior) && $account_details->price_ovrd_vol_disc_prior == 3 ? 'checked' : '') . '></td>
</tr>
<tr>
<td >4 ' . $lang[721] . '</td><td><input type="radio" name="price_ovrd_vol_disc_prior"  value="4" ' . (isset($account_details->price_ovrd_vol_disc_prior) && $account_details->price_ovrd_vol_disc_prior == 4 ? 'checked' : '') . '></td>
<td >5 ' . $lang[721] . '</td><td><input type="radio" name="price_ovrd_vol_disc_prior"  value="5" ' . (isset($account_details->price_ovrd_vol_disc_prior) && $account_details->price_ovrd_vol_disc_prior == 5 ? 'checked' : '') . '></td>
<td >6 ' . $lang[721] . '</td><td><input type="radio" name="price_ovrd_vol_disc_prior"  value="6" ' . (isset($account_details->price_ovrd_vol_disc_prior) && $account_details->price_ovrd_vol_disc_prior == 6 ? 'checked' : '') . '></td>
</tr>

<tr>


</table>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[482] . '</label>
<div class="col-sm-9"><input type="text" name="price_ovrd_volume_threshold" value="' . (isset($account_details->price_ovrd_volume_threshold) ? $account_details->price_ovrd_volume_threshold : '') . '" size="10" /></div>
<br>' . $lang[483] . '
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[476] . '</label>
<div class="col-sm-9">
<div class="col">
<table>
<tr>
<td>' . $lang[477] . '</td>
<td><input type="radio" name="price_ovrd_apply_volume_discount"  value="1" ' . (isset($account_details->price_ovrd_apply_volume_discount) && $account_details->price_ovrd_apply_volume_discount == 6 ? 'checked' : '') . '></td>
</tr>
<tr>
<td>' . $lang[478] . '</td>
<td><input type="radio" name="price_ovrd_apply_volume_discount"  value="2" ' . (isset($account_details->price_ovrd_apply_volume_discount) && $account_details->price_ovrd_apply_volume_discount == 6 ? 'checked' : '') . ' ></td>
</tr>
<tr>
<td>' . $lang[479] . '</td>
<td><input type="radio" name="price_ovrd_apply_volume_discount"  value="3" ' . (isset($account_details->price_ovrd_apply_volume_discount) && $account_details->price_ovrd_apply_volume_discount == 6 ? 'checked' : '') . '></td>
</tr>

</table>
</div>
</div>
</div>
</div>
</div>

</div>


<div class="col" style="width:48%; float:left;">

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[456] . '</label><br>
<div class="col-sm-9">' . $lang[465] . '</div>
<div class="col" style="padding:10px;">
<table>
<tr>
<td>' . $lang[228] . '</td>
<td><input type="text" name="price_ovrd_nocharge_weight" value="' . (isset($account_details->price_ovrd_nocharge_weight) ? $account_details->price_ovrd_nocharge_weight : '') . '" size="10"/>' . $company_setting['price_weight']['option_value'] . '</td>

<td>' . $lang[231] . '</td>
<td><input type="text" name="price_ovrd_nocharge_volume" value="' . (isset($account_details->price_ovrd_nocharge_volume) ? $account_details->price_ovrd_nocharge_volume : '') . '" size="10"/>' . $company_setting['price_volume']['option_value'] . '</td>
</tr>
';
    if (is_array($pieces_details) && count($pieces_details)) {
        for ($p = 0; $p < count($pieces_details); $p++) {
            echo '
<tr>
<td>' . $lang[237] . ' ' . $pieces_details[$p]['package_name'] . '</td>
<td><input type="text" name="nc__price_ovrd_nocharge_pieces__' . $pieces_details[$p]['package_id'] . '" value="' . (isset($price_over[$pieces_details[$p]['package_id']]['nocharge']) ? $price_over[$pieces_details[$p]['package_id']]['nocharge'] : '') . '"  size="10"/></td>

';

            if (isset($pieces_details[$p + 1]['package_id'])) {
                echo '
<td>' . $lang[237] . ' ' . $pieces_details[$p + 1]['package_name'] . '</td>
<td><input type="text" name="nc__price_ovrd_nocharge_pieces__' . $pieces_details[$p + 1]['package_id'] . '" value="' . (isset($price_over[$pieces_details[$p + 1]['package_id']]['nocharge']) ? $price_over[$pieces_details[$p + 1]['package_id']]['nocharge'] : '') . '"  size="10"/></td>

';
            }
            echo '</tr>';
            $p++;
        }
    }
    echo '
</table>
</div>
</div>

		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[459] . '</label>
<div class="col-sm-9">' . $lang[469] . '</div>

<div class="col" style="padding:5px;">
<table>
<tr>
<td >' . $lang[230] . '</td>
<td ><input type="text" name="price_ovrd_extra_weight" value="' . (isset($account_details->price_ovrd_extra_weight) ? $account_details->price_ovrd_extra_weight : '') . '" size="10"/></td>

<td >' . $lang[233] . '</td>
<td ><input type="text" name="price_ovrd_extra_volume" value="' . (isset($account_details->price_ovrd_extra_volume) ? $account_details->price_ovrd_extra_volume : '') . '" size="10"/></td>
</tr>';
    if (is_array($pieces_details) && count($pieces_details)) {
        for ($p = 0; $p < count($pieces_details); $p++) {
            echo '
<tr>
<td>' . $lang[484] . ' ' . $pieces_details[$p]['package_name'] . ' ' . $lang[485] . '</td>
<td><input type="text" name="nc__price_ovrd_extra_pieces__' . $pieces_details[$p]['package_id'] . '" value="' . (isset($price_over[$pieces_details[$p]['package_id']]['extra']) ? $price_over[$pieces_details[$p]['package_id']]['extra'] : '') . '" size="10" /></td>
';

            if (isset($pieces_details[$p + 1]['package_id'])) {
                echo '
<td>' . $lang[484] . ' ' . $pieces_details[$p + 1]['package_name'] . ' ' . $lang[485] . '</td>
<td><input type="text" name="nc__price_ovrd_extra_pieces__' . $pieces_details[$p + 1]['package_id'] . '" value="' . (isset($price_over[$pieces_details[$p + 1]['package_id']]['extra']) ? $price_over[$pieces_details[$p + 1]['package_id']]['extra'] : '') . '"  size="10"/></td>

';
            }
            echo '</tr>';
            $p++;
        }
    }
    echo '
</table>
</div>
</div>
		
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[458] . '</label>
<div class="col-sm-9">' . $lang[468] . '<br><br></div>
<div class="col" style="padding:10px;">
<table>
<tr><td align="center" >
<input type="radio" name="price_ovrd_wpv_method"  value="1" ' . (isset($account_details->price_ovrd_wpv_method) && $account_details->price_ovrd_wpv_method == 1 ? 'checked' : '') . '></td>
<td >' . $lang[450] . '</td></tr>

<tr><td align="center" ><input type="radio" name="price_ovrd_wpv_method"  value="2" ' . (isset($account_details->price_ovrd_wpv_method) && $account_details->price_ovrd_wpv_method == 2 ? 'checked' : '') . ' ></td>
<td>' . $lang[342] . '</td></tr>

<tr><td align="center" ><input type="radio" name="price_ovrd_wpv_method"  value="3" ' . (isset($account_details->price_ovrd_wpv_method) && $account_details->price_ovrd_wpv_method == 3 ? 'checked' : '') . '></td>
<td>' . $lang[343] . '</td>
</tr>

</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[460] . '</label>
<div class="col-sm-9">' . $lang[471] . '</div>
<div class="col" style="padding:10px;">
<table>
';
    if (is_array($package_details) && count($package_details) > 0) {
        for ($i = 0; $i < count($package_details); $i++) {
            echo '<tr>
<td >' . $package_details[$i]['name'] . '</td>
<td ><input type="text" name="nc__t_package_type__' . $package_details[$i]['id'] . '" value="' . (isset($price_over[$package_details[$i]['id']]['addservices']) ? $price_over[$package_details[$i]['id']]['addservices'] : '') . '" size="10"/></td>
</tr>';
        }
    } else {
        echo '<tr>
<td colspane="2">' . $lang[472] . '</td>
</tr>';
    }

    if (is_array($vechile_services) && count($vechile_services) > 0) {
        echo '<tr><td colspan="2"><hr></td></tr>';

        for ($v = 0; $v < count($vechile_services); $v++) {
            echo '<tr>
<td >' . $vechile_services[$v]['name'] . '</td>
<td ><input type="text" name="nc__vechile_services__' . $vechile_services[$v]['id'] . '" value="' . (isset($price_over[$vechile_services[$v]['id']]['vechile_services']) ? $price_over[$vechile_services[$v]['id']]['vechile_services'] : '') . '" size="10"/></td>
</tr>';
        }
    }

    echo '</table>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[486] . '</label>
<div class="col-sm-9">
' . $lang[487] . '
<div class="col">
<table class="table table-striped table-bordered table-hover" border="1">
<tr>
<th>' . $lang[44] . '</th>
<th>' . $lang[488] . '</th>
</tr>';
    for ($s = 0; $s < count($ser); $s++) {
        echo '
<tr>
<td>' . $ser[$s]['service_name'] . '</td>
<td><input type="text" name="nc__min_service__' . $ser[$s]['service_id'] . '" size="5" value="' . (isset($price_over[$ser[$s]['service_id']]['min_service']) ? $price_over[$ser[$s]['service_id']]['min_service'] : '') . '"/></td>
</tr>
';
    }

    echo '</table>
</div>
</div>
</div>



</div>

<div style="clear:both;"></div>

</div>

';

    if ($c_setting['company_skid'] != "1") {
        echo '
<div class="well">
<h4 class="green smaller lighter">' . $lang[489] . '</h4>
' . $lang[490] . '
</div>
		
<table class="table table-striped table-bordered table-hover" border="1">
<tr>
<th>' . $lang[492] . '</th>
';
        for ($s = 0; $s < count($ser); $s++) {
            echo '<th>' . $ser[$s]['service_name'] . '</th>';
        }

        echo '</tr>';
        for ($v = 0; $v < count($vec); $v++) {
            echo '
<tr>
<td>' . $vec[$v]['vehicle'] . '</td>';
            for ($sv = 0; $sv < count($ser); $sv++) {
                echo '<td><input type="text" name="nc__ser_vec__' . $ser[$sv]['service_id'] . '__' . $vec[$v]['id'] . '" size="5" value="' . (isset($ser_over[$ser[$sv]['service_id']][$vec[$v]['id']]['flat_rate']) ? $ser_over[$ser[$sv]['service_id']][$vec[$v]['id']]['flat_rate'] : '') . '"/></td>';
            }
            echo '</tr>
';
        }

        echo '</table>
		
		
<h3 class="header smaller lighter green">' . $lang[493] . '  </h3>
' . $lang[494] . '
<table class="table table-striped table-bordered table-hover" border="1">
<tr>
<th>' . $lang[506] . '</th>
';
        for ($s = 0; $s < count($ser); $s++) {
            echo '<th>' . $ser[$s]['service_name'] . '</th>';
        }

        echo '</tr>';
        for ($v = 0; $v < count($vec); $v++) {
            echo '
<tr>
<td>' . $vec[$v]['vehicle'] . '</td>';
            for ($sv = 0; $sv < count($ser); $sv++) {
                echo '<td>
<input type="text" 
name="nc__distance_fee__' . $ser[$sv]['service_id'] . '__' . $vec[$v]['id'] . '" 
size="5" 
value="' . (isset($ser_over[$ser[$sv]['service_id']][$vec[$v]['id']]['distance_fee']) ? $ser_over[$ser[$sv]['service_id']][$vec[$v]['id']]['distance_fee'] : '') . '"/>
</td>';
            }
            echo '</tr>
';
        }

        echo '</table>
		
		

<div class="well">
<h4 class="green smaller lighter">' . $lang[495] . '</h4>
' . $lang[496] . '
</div>
		
		<h3 class="header smaller lighter green">' . $lang[210] . '  </h3>
		
<table class="table table-striped table-bordered table-hover" border="1" id="pickup_table_' . $account_id . '">
<tr>
<th>' . $lang[208] . '</th>
';
        for ($v = 0; $v < count($vec); $v++) {
            echo '<th>' . $vec[$v]['vehicle'] . '</th>';
        }

        echo '</tr>';
        $num = 3;
        if (is_array($pickup_fee) && count($pickup_fee) > 0) {
            $num = (count($pickup_fee) + 1);
        }
        for ($i = 0; $i < $num; $i++) {
            echo '
<tr>
<td><input type="text" name="nc__pickup__zone__' . $i . '" size="8" value="' . (count($pickup_fee) > 0 ? $pickup_fee[$i]['zone'] : '') . '"/></td>
';
            for ($sv = 0; $sv < count($vec); $sv++) {
                echo '<td><input type="text" name="nc__pickup__' . $vec[$sv]['id'] . '__' . $i . '" size="8" value="' . (count($pickup_fee[$i]['vec_fee']) > 0 && isset($pickup_fee[$i]['vec_fee'][$pickup_fee[$i]['zone']][$vec[$sv]['id']]) ? $pickup_fee[$i]['vec_fee'][$pickup_fee[$i]['zone']][$vec[$sv]['id']] : '') . '"/></td>';
            }
            echo '</tr>';
        }

        echo '
<tr>
<td colspan="' . (count($vec) + 1) . '">
<input type="button"  onclick="add_pickup_rows(\'' . $account_id . '\');"  value="' . $lang[221] . '" class="btn btn-info" style="margin:auto; float:none;"  />
</td>
</tr>

</table>
		
		
		<h3 class="header smaller lighter green">' . $lang[211] . '  </h3>
		

<table class="table table-striped table-bordered table-hover" border="1" id="delivery_table_' . $account_id . '">
<tr>
<th>' . $lang[354] . '</th>
<th>' . $lang[355] . '</th>
';
        for ($v = 0; $v < count($ser); $v++) {
            echo '<th>' . $ser[$v]['service_name'] . '</th>';
        }

        echo '</tr>';
        $num = 3;
        //var_dump($delivery_fee);
        if (is_array($delivery_fee) && count($delivery_fee) > 0) {
            $num = (count($delivery_fee) + 1);
        }
        if (count($delivery_fee) > $num) {
            $num = count($delivery_fee);
        }
        for ($i = 0; $i < $num; $i++) {
            echo '
<tr>
<td><input type="text" name="nc__delivery__zonefrom__' . $i . '" size="8" value="' . (count($delivery_fee) > 0 ? $delivery_fee[$i]['zonefrom'] : '') . '"/></td>
<td><input type="text" name="nc__delivery__zoneto__' . $i . '" size="8" value="' . (count($delivery_fee) > 0 ? $delivery_fee[$i]['zoneto'] : '') . '"/></td>

';
            for ($sv = 0; $sv < count($ser); $sv++) {
                echo '<td><input type="text" name="nc__delivery__' . $ser[$sv]['service_id'] . '__' . $i . '" size="5" value="' . (count($delivery_fee[$i]['srv_fee']) > 0 && isset($delivery_fee[$i]['srv_fee'][$delivery_fee[$i]['zonefrom']][$delivery_fee[$i]['zoneto']][$ser[$sv]['service_id']]) ? $delivery_fee[$i]['srv_fee'][$delivery_fee[$i]['zonefrom']][$delivery_fee[$i]['zoneto']][$ser[$sv]['service_id']] : '') . '"/></td>';
            }
            echo '</tr>';
        }

        echo '
<tr>
<td colspan="100%">
<input type="button" id="add_acc" onclick="add_delivery_rows(\'' . $account_id . '\');"  value="' . $lang[221] . '" class="btn btn-info" style="margin:auto; float:none;"  name="edituser"/>
</td>
</tr>

</table>
		

<h3 class="header smaller lighter green">' . $lang[578] . ' - ' . $sett_compnay['co_uom_distance']['option_value'] . ' </h3>

<table border="1" class="table table-striped table-bordered table-hover">
<tr>
<th>+</th>
';
        for ($s = 0; $s < count($ser); $s++) {
            echo '<th>' . $ser[$s]['service_name'] . '</th>';
        }
        echo '</tr>';

        for ($v = 0; $v < count($vec); $v++) {
            echo '<tr>
<td>' . $vec[$v]['vehicle'] . '</td>';
            for ($s = 0; $s < count($ser); $s++) {
                echo '<td><input type="text" name="distance__' . $vec[$v]['id'] . '__' . $ser[$s]['service_id'] . '" onblur="check_numeric(this,\'distance__' . $vec[$v]['id'] . '__' . $ser[$s]['service_id'] . '\');" value="' . (isset($dfees[$vec[$v]['id']][$ser[$s]['service_id']]) ? $dfees[$vec[$v]['id']][$ser[$s]['service_id']] : '') . '" size="5" /></td>';
            }

            echo '</tr>';
        }


        echo '</table>




<h3 class="header smaller lighter green">' . $lang[579] . '</h3>
		
<table border="1" class="table table-striped table-bordered table-hover">
<tr>
<th>' . $lang[580] . '</th>
';
        for ($s = 0; $s < count($ser); $s++) {
            echo '<th>' . $ser[$s]['service_name'] . '</th>';
        }
        echo '</tr>

<tr>
<td>
<input type="text" name="pattern" value="' . $val['pattern'][$ser[0]['service_id']]['every'] . '" size="10"  />' . $sett_compnay['co_uom_distance']['option_value'] . '
</td>
';
        for ($s = 0; $s < count($ser); $s++) {
            echo '<td><input type="text" name="pattern__' . $ser[$s]['service_id'] . '" value="' . $val['pattern'][$ser[$s]['service_id']]['ratio'] . '" size="5" /> </td>';
        }


        echo '</tr>

</table>
';
    } else {
        echo '<div style="clear:both;"></div>

<hr/>
<h3 class="header smaller lighter green">Skid fees pricing</h3>

<table border="1" class="table table-striped table-bordered table-hover">
<tr>
<th>+</th>
';
        //var_dump($dfees);
        for ($s = 0; $s < count($ser); $s++) {
            echo '<th>' . $ser[$s]['service_name'] . '</th>';
        }
        echo '</tr>';

        for ($v = 0; $v < count($vec); $v++) {
            echo '<tr><td>' . $vec[$v]['vehicle'] . '</td>';


            for ($s = 0; $s < count($ser); $s++) {
                echo '<td>
<table>
<tr>
<td></td>
<td>' . ($c_setting['company_skid'] == "1" ? $lang[608] : $lang[285]) . '</td>
<td>Price</td>
</tr>';
                for ($l = 0; $l < 6; $l++) {
                    $va = $dfees[$vec[$v]['id']][$ser[$s]['service_id']][($l + 1)];
                    //rint_r($va);
                    echo '<tr>
<td>
<input type="hidden" name="order[]" value="' . ($l + 1) . '" />

' . ($l + 1) . '</td>
<td>

<input type="text" name="distance__' . $vec[$v]['id'] . '__' . $ser[$s]['service_id'] . '[]" value="' . (isset($va['distance']) ? $va['distance'] : '') . '" size="5" />

</td>

<td>

<input type="text" name="price__' . $vec[$v]['id'] . '__' . $ser[$s]['service_id'] . '[]" value="' . (isset($va['fees']) ? $va['fees'] : '') . '" size="5" />

</td>
</tr>';
                }
                echo '
<tr>
<td>' . ($c_setting['company_skid'] == "1" ? 'Extra Skid' : 'Per ' . $c_setting['co_uom_distance']) . '</td>
<input type="hidden" name="order[]" value="0" />
<td><input type="text" name="distance__' . $vec[$v]['id'] . '__' . $ser[$s]['service_id'] . '[]" value="' . (isset($dfees[$vec[$v]['id']][$ser[$s]['service_id']][0]) ? $dfees[$vec[$v]['id']][$ser[$s]['service_id']][0]['distance'] : '') . '" size="5" /></td>
<td><input type="text" name="price__' . $vec[$v]['id'] . '__' . $ser[$s]['service_id'] . '[]" value="' . (isset($dfees[$vec[$v]['id']][$ser[$s]['service_id']][0]['fees']) ? $dfees[$vec[$v]['id']][$ser[$s]['service_id']][0]['fees'] : '') . '" size="5" /></td>
</tr>
</table>

</td>';
            }

            echo '</tr>';
        }


        echo '</table>
<div style="clear:both;"></div>
		';
    }

    echo '<div class="form-group">
<div class="col-sm-9" style="width: 200px; float: none;margin: auto; height:40px;" ><input type="button"  onclick="edit_pricing_details(\'' . $account_id . '\');"  value="' . $lang[50] . '" class="btn btn-info"  /></div>
</div>

<div style="clear:both;"></div>

</form>
<div style="clear:both;"></div>

';
}

function template_invoice_format()
{
    global $lang, $account_details, $account_id;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/account.js"></script>
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/main.js"></script>

<form name="add_account" id="edit_invoice_details_' . $account_id . '" method="post" action="' . SITEURL . '/administrator/accounts.php?action=invoice_format&account_id=' . $account_id . '" class="form-horizontal">

<div class="col"  style="width:40%; float:left;">
<div class="title">' . $lang[640] . '</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[642] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table >
<tr><td>
' . $lang[722] . '
</td>
</tr>

<tr><td>
<select name="invoiceoption_rb1">
<option value="1" ' . ($account_details->invoiceoption_rb1 == "1" ? 'selected' : '') . ' >' . $lang[450] . '</option>
<option value="2" ' . ($account_details->invoiceoption_rb1 == "2" ? 'selected' : '') . '>' . $lang[723] . '</option>
<option value="3" ' . ($account_details->invoiceoption_rb1 == "3" ? 'selected' : '') . '>' . $lang[724] . '</option>
<option value="4" ' . ($account_details->invoiceoption_rb1 == "4" ? 'selected' : '') . '>' . $lang[725] . '</option></select>
</td></tr>
</table>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[643] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>
' . $lang[726] . '
</td></tr>
<tr><td>
<select name="invoiceoption_rb2">
<option value="1" ' . ($account_details->invoiceoption_rb2 == "1" ? 'selected' : '') . '>' . $lang[450] . '</option>
<option value="2" ' . ($account_details->invoiceoption_rb2 == "2" ? 'selected' : '') . '>' . $lang[451] . '</option>
<option value="3" ' . ($account_details->invoiceoption_rb2 == "3" ? 'selected' : '') . ' >' . $lang[452] . '</option>
</select>
</td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[644] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>
' . $lang[728] . '
</td></tr>
<tr><td>
<select name="invoiceoption_rb3">
<option  value="1" ' . ($account_details->invoiceoption_rb3 == "1" ? 'selected' : '') . '>' . $lang[450] . '</option>
<option value="2" ' . ($account_details->invoiceoption_rb3 == "2" ? 'selected' : '') . '>' . $lang[729] . '</option>
<option value="3" ' . ($account_details->invoiceoption_rb3 == "3" ? 'selected' : '') . ' >' . $lang[730] . '</option>
<option value="4" ' . ($account_details->invoiceoption_rb3 == "4" ? 'selected' : '') . ' >' . $lang[452] . '</option></select>
</td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[645] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>
		' . $lang[737] . '
</td></tr>
<tr>
<td>
<select name="invoiceoption_rb4">
<option  value="1" ' . ($account_details->invoiceoption_rb4 == "1" ? 'selected' : '') . '>' . $lang[450] . '</option>
<option value="2" ' . ($account_details->invoiceoption_rb4 == "2" ? 'selected' : '') . '>' . $lang[731] . '</option>
<option value="3" ' . ($account_details->invoiceoption_rb4 == "3" ? 'selected' : '') . ' >' . $lang[732] . '</option>
</select>
</td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[646] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>
' . $lang[738] . '
</td></tr>
<tr><td>
<select name="invoiceoption_rb7">
<option  value="1" ' . ($account_details->invoiceoption_rb7 == "1" ? 'selected' : '') . '>' . $lang[450] . '</option>
<option value="2" ' . ($account_details->invoiceoption_rb7 == "2" ? 'selected' : '') . '>' . $lang[733] . '</option>
<option value="3" ' . ($account_details->invoiceoption_rb7 == "3" ? 'selected' : '') . ' >' . $lang[734] . '</option>
<option value="4" ' . ($account_details->invoiceoption_rb7 == "4" ? 'selected' : '') . '>' . $lang[735] . '</option>
<option value="5" ' . ($account_details->invoiceoption_rb7 == "5" ? 'selected' : '') . '>' . $lang[736] . '</option>
</select>
</td></tr>
</table>
</div>
</div>


</div>


<div class="col"  style="width:40%; float:left;">


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[647] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>' . $lang[739] . '</td></tr>
<tr><td>
<select name="invoiceoption_1">
<option value="1" ' . ($account_details->invoiceoption_1 == "1" ? 'selected' : '') . '>' . $lang[450] . '</option>
<option value="2" ' . ($account_details->invoiceoption_1 == "2" ? 'selected' : '') . '>' . $lang[451] . '</option>
<option value="3" ' . ($account_details->invoiceoption_1 == "3" ? 'selected' : '') . '>' . $lang[452] . '</option>
</select>
</td></tr>
</table>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[648] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>' . $lang[740] . '</td></tr>
<tr><td>
<select name="invoiceoption_7">
<option  value="1" ' . ($account_details->invoiceoption_7 == "1" ? 'selected' : '') . '>' . $lang[450] . '</option>
<option value="2" ' . ($account_details->invoiceoption_7 == "2" ? 'selected' : '') . ' >' . $lang[451] . '</option>
<option value="3" ' . ($account_details->invoiceoption_7 == "3" ? 'selected' : '') . '>' . $lang[452] . '</option>
</select></td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[649] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>' . $lang[741] . '</td></tr>
<tr><td>
<select name="invoiceoption_5">
<option  value="1" ' . ($account_details->invoiceoption_5 == "1" ? 'selected' : '') . '>' . $lang[450] . '</option>
<option value="2" ' . ($account_details->invoiceoption_5 == "2" ? 'selected' : '') . ' >' . $lang[451] . '</option>
<option value="3" ' . ($account_details->invoiceoption_5 == "3" ? 'selected' : '') . ' >' . $lang[452] . '</option>
</select>
</td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[650] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>' . $lang[742] . ' </td></tr>
<tr><td>
<select name="invoiceoption_6">
<option value="1" ' . ($account_details->invoiceoption_6 == "1" ? 'selected' : '') . '>' . $lang[450] . '</option>
<option value="2" ' . ($account_details->invoiceoption_6 == "2" ? 'selected' : '') . '>' . $lang[451] . '</option>
<option value="3" ' . ($account_details->invoiceoption_6 == "3" ? 'selected' : '') . '>' . $lang[452] . '</option>
</select></td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[651] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>' . $lang[743] . '</td></tr>
<tr><td>
<select name="invoiceoption_4">
<option value="1" ' . ($account_details->invoiceoption_4 == "1" ? 'selected' : '') . '>' . $lang[450] . '</option>
<option  value="2" ' . ($account_details->invoiceoption_4 == "2" ? 'selected' : '') . '>' . $lang[451] . '</option>
<option value="3" ' . ($account_details->invoiceoption_4 == "3" ? 'selected' : '') . '>' . $lang[452] . '</option>
</select></td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[652] . '</label>
<div class="col-sm-9" style="width:60%;" >
<table>
<tr><td>' . $lang[744] . '</td></tr>
<tr><td>
<select name="invoiceoption_rb6">
<option  value="1" ' . ($account_details->invoiceoption_rb6 == "1" ? 'selected' : '') . '>' . $lang[450] . '</option>
<option value="2" ' . ($account_details->invoiceoption_rb6 == "2" ? 'selected' : '') . '>' . $lang[745] . '</option>
<option value="3" ' . ($account_details->invoiceoption_rb6 == "3" ? 'selected' : '') . '>' . $lang[746] . '</option>
<option value="4" ' . ($account_details->invoiceoption_rb6 == "4" ? 'selected' : '') . '>' . $lang[747] . '</option>
</select></td></tr>
</table>
</div>
</div>

</div>



<div style="clear:both;"></div>

<hr>
<div class="form-group">
<div class="col-sm-9" style="width: 200px; float: none;margin: auto; height:40px;">
<input type="button" id="add_acc" onclick="edit_invoice_account(\'' . $account_id . '\');"  value="' . $lang[50] . '" class="btn btn-info"  name="edituser"/>';
    if ($account_id != '') {
        echo '<input type="button" id="close" onclick="close_account(\'' . $account_id . '\');"  value="' . $lang[200] . '" class="btn btn-info"  />';
    }
    echo '</div>
</div>


<div style="clear:both;"></div>

</form>
<div style="clear:both;"></div>
<div id="result"></div>
<div style="clear:both;"></div>
';
}

function template_account_options()
{
    global $lang, $account_details, $account_id, $account_users;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/account.js"></script>
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/main.js"></script>



<form name="add_account" id="edit_option_account_' . $account_id . '" method="post" action="' . SITEURL . '/administrator/accounts.php?action=options&account_id=' . $account_id . '" style=" width:100%;">

<div class="col"  style="width:40%; float:left;">
<div class="title">' . $lang[641] . '</div>



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[64] . '</label>
<div class="col-sm-9"><input type="text" name="extra_waybills" value="' . (isset($account_details->extra_waybills) ? $account_details->extra_waybills : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[653] . '</label>
<div class="col-sm-9" style="width:50%;">
<table>
<tr><td colspan="100%">' . $lang[748] . '</td></tr>

<tr>
<td><input type="radio" name="waybills_perpage" value="1"  ' . ($account_details->waybills_perpage == "1" ? 'checked' : '') . '></td>
<td>1 ' . $lang[36] . '</td>
</tr>
<tr>
<td><input type="radio" name="waybills_perpage"  value="2"  ' . ($account_details->waybills_perpage == "2" ? 'checked' : '') . '></td>
<td>2 ' . $lang[36] . '</td>
</tr>

</table>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[654] . '</label>
<div class="col-sm-9" style="width:50%;">
<table>
<tr>
<td colspan="100%">' . $lang[749] . '</td>
</tr>

<tr><td colspan="100%"><input type="text" name="online_invoicing_email"  value="' . (isset($account_details->online_invoicing_email) ? $account_details->online_invoicing_email : '') . '" size="50" ></td></tr>

<tr><td colspan="100%">' . $lang[750] . '</td></tr>
<tr><td colspan="100%">' . $lang[751] . '</td></tr>
<tr><td colspan="100%"><input type="text" name="online_invoicing_email2"  value="' . (isset($account_details->online_invoicing_email2) ? $account_details->online_invoicing_email2 : '') . '" size="50" ></td></tr>
<tr><td colspan="100%">' . $lang[752] . '</td></tr>
<tr><td colspan="100%"><input type="text" name="online_invoicing_email3"  value="' . (isset($account_details->online_invoicing_email3) ? $account_details->online_invoicing_email3 : '') . '" size="50" ></td></tr>

</table>
</div>
</div>

</div>

<div class="col"  style="width:50%; float:left;">

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[18] . ' (1)</label>
<div class="col-sm-9" style="width:50%; ">
<table>
<tr><td>' . $lang[753] . '</td></tr>
<tr><td>

<select name="online_invoicing_userid1">
<option value="">' . $lang[513] . '</option>
';
    if (is_array($account_users) && count($account_users) > 0) {
        //var_dump($account_users);

        for ($u = 0; $u < count($account_users); $u++) {
            echo '<option value="' . $account_users[$u]['user_id'] . '" ' . ($account_details->online_invoicing_userid1 == $account_users[$u]['user_id'] ? 'selected' : '') . '  >' . $account_users[$u]['user_name'] . '</option>';
        }
    } else {
    }

    echo '
</select>
</td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label"  >' . $lang[42] . '</label>
<div class="col-sm-9" style="width:50%; ">
<table><input type="hidden" name="price_in_email" value="N" />

<tr><td><input type="checkbox" name="price_in_email" value="Y" ' . ($account_details->price_in_email == 'Y' ? 'checked' : '') . ' >Include the price</td></tr>
<tr><td>' . $lang[754] . '</td></tr>
</table>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[655] . '</label>
<div class="col-sm-9" style="width:50%; ">
<table>
<tr><td colspan="100%">' . $lang[755] . '</td></tr>

<tr> 
<input type="hidden" name="ref_mandatory" value="N" />
<td><input type="checkbox" name="ref_mandatory" value="Y" ' . ($account_details->ref_mandatory == 'Y' ? 'checked' : '') . '></td>
<td>' . $lang[656] . '</td>
</tr>

<tr> 
<input type="hidden" name="pieces_mandatory" value="N" />
<td><input type="checkbox" name="pieces_mandatory" value="Y" ' . ($account_details->pieces_mandatory == 'Y' ? 'checked' : '') . '></td>
<td>' . $lang[657] . '</td>
</tr>

<tr> 
<input type="hidden" name="weight_mandatory" value="N" />
<td><input type="checkbox" name="weight_mandatory" value="Y" ' . ($account_details->weight_mandatory == 'Y' ? 'checked' : '') . '></td>
<td>Weight</td>
</tr>
		
		
</table>
</div>
</div>



</div>
<div style="clear:both;"></div>

<hr>
<div class="form-group" style="text-align: center;">

<input type="button" id="add_acc" onclick="edit_option_account(\'' . $account_id . '\');"  value="' . $lang[50] . '" class="btn btn-sm btn-info"  name="edituser"/>';
    if ($account_id != '') {
        echo '&nbsp;&nbsp;&nbsp;<input type="button" id="close"  onclick="close_account(\'' . $account_id . '\');"  value="' . $lang[200] . '" class="btn btn-sm btn-danger "  />';
    }
    echo '
		
</div>


<div style="clear:both;"></div>

</form>
<div style="clear:both;"></div>
<div id="result"></div>
<div style="clear:both;"></div>
';
}


///////////////////////////////////////////////////


function template_account_edit()
{
    global $account_details, $lang, $locations, $usertype, $tax_group, $account_contacts;
    echo '<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/account.js"></script>

<form name="edit_account" id="edit_account" method="post" action="' . SITEURL . '/administrator/accounts.php?action=edit&id=' . $account_details->account_id . '" class="form-horizontal">

<input type="hidden" name="account_id" value="' . $account_details->account_id . '" />

<div class="col" style="width:25%;float:left; ">
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[17] . '</label>
<div class="col-sm-9"><input type="text" name="account_id" value="' . $account_details->account_name . '" disabled="disabled" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[6] . '</label>
<div class="col-sm-9"><input type="text" name="company_name" value="' . $account_details->account_company . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><textarea name="company_address" >' . $account_details->account_address . '</textarea></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[8] . '</label>
<div class="col-sm-9"><input type="text" name="city" value="' . $account_details->city . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[9] . '</label>
<div class="col-sm-9"><input type="text" name="pcode" value="' . $account_details->pcode . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="phone" value="' . $account_details->phone . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[12] . '</label>
<div class="col-sm-9"><input type="text" name="fax" value="' . $account_details->fax . '" /></div>
</div>
<div class="form-group">
<div class="col-sm-9"><input type="button" class="btn btn-info" onclick="edit_accountss();" id="submit" value="' . $lang[50] . '"  name="edituser"/></div>
</div>

</div>


<div class="col" style="width:25%; float:left;  ">

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[175] . '</label>
<div class="col-sm-9">
<select name="user_category">';
    for ($i = 0; $i < count($usertype); $i++) {
        echo '<option value="' . $usertype[$i]['cat_id'] . '" ' . ($usertype[$i]['cat_id'] == $account_details->account_catid ? 'selected' : '') . '>' . $usertype[$i]['cat_name'] . '</option>';
    }
    //$usertype
    echo '</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[176] . '</label>
<div class="col-sm-9">
<select name="client_location">';
    for ($i = 0; $i < count($locations); $i++) {
        echo '<option value="' . $locations[$i]['cat_id'] . '"  ' . ($locations[$i]['cat_id'] == $account_details->account_location ? 'selected' : '') . '>' . $locations[$i]['cat_name'] . '</option>';
    }
    //$usertype
    echo '</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[177] . '</label>
<div class="col-sm-9"><select name="status">
<option value="1" ' . (1 == $account_details->status ? 'selected' : '') . ' >نشط</option>
<option value="2" ' . (2 == $account_details->status ? 'selected' : '') . ' >غير نشط</option>
<option value="3" ' . (3 == $account_details->status ? 'selected' : '') . '>حذف</option>
</select></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[157] . '</label>
<div class="col-sm-9"><select name="tax_group">';
    for ($i = 0; $i < count($tax_group); $i++) {
        echo '<option value="' . $tax_group[$i]['taxgroup_id'] . '" ' . ($tax_group[$i]['taxgroup_id'] == $account_details->account_taxgroup ? 'selected' : '') . '>' . $tax_group[$i]['taxgroup_name'] . '</option>';
    }
    //$usertype
    echo '</select></div>
</div>


</div>

<div class="col border" style="width:25%; "  >
<div class="head">' . $lang[10] . '</div>
<div style="clear:both;"></div>
';

    if (is_array($account_contacts)) {
        for ($i = 0; $i < 3; $i++) {
            echo '<div class="form-group">
<input type="hidden" name="valid[]" value="' . (!empty($account_contacts[$i]['contact_id']) ? $account_contacts[$i]['contact_id'] : '') . '" />

<label class="col-sm-3 control-label">' . $lang[10] . ' (' . ($i + 1) . ')</label>
<div class="col-sm-9"><input type="text" name="contact_name[]" value="' . (!empty($account_contacts[$i]['contact_name']) ? $account_contacts[$i]['contact_name'] : '') . '" /></div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . ' (' . ($i + 1) . ')</label>
<div class="col-sm-9"><input type="text" name="contact_phone[]" value="' . (!empty($account_contacts[$i]['phone']) ? $account_contacts[$i]['phone'] : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . ' (' . ($i + 1) . ')</label>
<div class="col-sm-9"><input type="text" name="contact_email[]" value="' . (!empty($account_contacts[$i]['email']) ? $account_contacts[$i]['email'] : '') . '" /></div>
</div>

<div style="clear:both;"></div>
<hr>

';
        }
    }

    echo '
</div>

</form>
<div id="result"></div>
<div style="clear:both;"></div>';
}

function template_manage_account_main()
{
    global $lang, $id;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>

 <script type="text/javascript">
  $(document).ready(function() {
    $("#tabs_man").tabs();
	
  });
  </script>
  

<div id="tabs_man" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   <li><a href="accounts.php?action=mangeuser&id=' . $id . '" >' . $lang[198] . '</a></li>
   <li><a href="accounts.php?action=add_client_user&id=' . $id . '" >' . $lang[98] . '</a></li>

</ul>

<div id="tabs-10" style="padding:0px;" >
</div>

<div id="tabs-11" >
</div>





</div>


<div style=" clear:both;"></div>

';
}

function template_show_users_admin()
{
    global $html_grid, $lang;
    echo '	<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
<div id="res"></div>';
    echo $html_grid . '
<div style="clear:both"></div>
<div class="form-group" style="width:100%; text-align:center;">
<div class="col-sm-9">
<input type="button" name="close" onclick="close_my_tab(\'tabs\',\'0\');" value="' . $lang[200] . '" class="btn btn-info" style="margin:auto; float:none; text-align:center;">
</div>
</div>
';
}

function print_editlink_admin($ro)
{
    $ro = change_index_to_key($ro);
    //var_dump($ro);

    return '<a onclick="show_edit_userclient(\'' . $ro['user_id'] . '\',\'' . $ro['name'] . '\')">Edit</a>';
}

function print_deletelink_admin($ro)
{
    $ro = change_index_to_key($ro);

    return '<a onclick="delete_users(\'' . $ro['user_id'] . '\',\'' . $ro['name'] . '\');" >Delete</a>';
}

function printDeleteLink_manage($params)
{
    extract($params);
    return '<a onclick="del_user_client(\'' . $record['user_id'] . '\',\'' . $record['name'] . '\');"   >Delete</a>';
}

function printEditLink_manage($params)
{
    extract($params);
    return '<a onclick="edit_user_client(\'' . $record['user_id'] . '\',\'' . $record['name'] . '\');"   >Edit</a>';
}


function template_add_client_user()
{
    global $lang, $account_details;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/account.js"></script>


<form name="add_client_user" id="add_client_user" method="post" action="' . SITEURL . '/administrator/accounts.php?action=add_client_user" autocomplete="off" class="form-horizontal" role="form" >


<div class="col" style="width:40%" >

<input type="hidden" name="account_name" value="' . $account_details->account_name . '"  />

<input type="hidden" name="account_id" value="' . $account_details->account_id . '"  size="50"/>
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[17] . '</label>
<div class="col-sm-9"><input type="text" name="account_name1" value="' . $account_details->account_name . '" disabled="disabled" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[101] . '</label>
<div class="col-sm-9">
<select name="user_type" validate="notempty" >
<option value="">' . $lang[756] . '</option>
<option value="client">' . $lang[693] . '</option>
<option value="administrator">' . $lang[164] . '</option>

</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[18] . '</label>
<div class="col-sm-9"><input type="text" name="user_name" value=""  size="50" validate="notempty"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[36] . '</label>
<div class="col-sm-9"><input type="text" name="name" value="" size="50" validate="notempty" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[19] . '</label>
<div class="col-sm-9"><input type="password" name="user_pass" value="" size="50" validate="notempty"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[167] . '</label>
<div class="col-sm-9"><input type="password" name="confirm_password" value="" size="50" validate="notempty"/></div>
</div>


</div>

<div class="col" style="width:40%">
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="phone" value="" size="50" validate_type="phone"  validate="notempty"/></div>
</div>
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[12] . '</label>
<div class="col-sm-9"><input type="text" name="fax" value="" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . '</label>
<div class="col-sm-9"><input type="text" name="email" value="" size="50" validate="notempty" validate_type="email"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><textarea name="address" cols="50" rows="2" validate="notempty" ></textarea></div>
</div>

<div class="form-group">
<div class="col-sm-9"><input type="button" id="submit" class="btn btn-info" value="' . $lang[50] . '"  name="adduser"/></div>

</div>


</div>
</form>
<div id="add_result"></div>
<div style="clear:both;"></div>
';
}

function template_edit_client_user()
{
    global $lang, $user_data;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/account.js"></script>

<form id="edit_client_user_' . $user_data->user_id . '" name="edit_client_user_' . $user_data->user_id . '" method="post" action="' . SITEURL . '/administrator/accounts.php?action=edit_client_user" class="form-horizontal" role="form">
<input type="hidden" name="account_id" value="' . $user_data->account_id . '"  />
<input type="hidden" name="user_id" value="' . $user_data->user_id . '"  />



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[17] . '</label>
<div class="col-sm-9"><input type="text" name="account_name" value="' . $user_data->account_name . '" disabled="disabled" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[18] . '</label>
<div class="col-sm-9"><input type="text" name="user_name" value="' . $user_data->user_name . '" disabled="disabled" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[101] . '</label>
<div class="col-sm-9">
<select name="user_type" validate="notempty">
<option value="">' . $lang[756] . '</option>
<option value="client" ' . ($user_data->user_type == "client" ? 'selected' : '') . ' >' . $lang[693] . '</option>
<option value="administrator" ' . ($user_data->user_type == "administrator" ? 'selected' : '') . ' >' . $lang[164] . '</option>

</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[36] . '</label>
<div class="col-sm-9"><input type="text" name="name" value="' . $user_data->name . '" size="50" validate="notempty"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[19] . '</label>
<div class="col-sm-9"><input type="password" name="user_pass" value="" size="50"/></div>
</div>
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[167] . '</label>
<div class="col-sm-9"><input type="password" name="confirm_password" value="" size="50"/></div>
</div>
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="phone" value="' . $user_data->phone . '" size="50" validate="notempty" validate_type="phone" /></div>
</div>

		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[12] . '</label>
<div class="col-sm-9"><input type="text" name="fax" value="' . $user_data->fax . '" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . '</label>
<div class="col-sm-9"><input type="text" name="email" value="' . $user_data->email . '" size="50" validate="notempty" validate_type="email" /></div>
</div>



<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
<input type="button"  class="btn btn-info" value="' . $lang[50] . '"  name="edituser" onclick="add_form_php(\'edit_client_user_' . $user_data->user_id . '\',\'1\');"/>
	<input type="button" onclick="close_my_tab(\'tabs_man\',\'0\');" id="close" class="btn btn-danger" value="' . $lang[200] . '"  name="edituser"/>
</div>
</div>


</form>

';
}


function template_search_account()
{
    global $lang;

    echo '
			<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/account.js"></script>
			
			<form id="search_account" method="post"   class="form-horizontal" autocomplete="off" style="width:60%; margin:auto;">
			
			<input type="text" name="search_account_value"  id="search_account_value" value=""  class="form-control" placeholder="اكتب رقم الحساب او اسم الشركة" />
			
			
	     </form>
			
			<div id="search_result">
			
			</div>
			
			';
}
