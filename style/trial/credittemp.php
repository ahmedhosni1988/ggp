<?php


function template_mange_credit(){
    global $lang,$c_setting;

    echo '
    
<script  type="text/javascript">


$(document).ready(function(){     


      
  
       $("#tabs").tabs();
	   
  var $tabs = $("#tabs").tabs({
	    
	
		load: function (e, ui) {
     $(ui.panel).find(".tab-loading").remove();
   },

	   add: function(event, ui) {
       
	    $tabs.tabs("select", "#" + ui.panel.id);
       
	   },
select: function(event, ui) {
        var tabID = "#" + (ui.panel.id);
        $(tabID).html("<b>'.$lang[712].'....</b>");
      }
	   

});

}); 
</script>


<div id="right_side">
<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
<ul>
   <li><a href="credit_note.php?action=view" >الإشعارات</a></li> 
   <li><a href="credit_note.php?action=add_edit" >إضافة الإشعارات</a></li> 

</ul>
<div id="tab0" style="padding:20px;" >
</div>

<div id="tab0" style="padding:20px;" >
</div>

</div>
</div>

';    
}


function template_add_edit_credit(){
    global $lang,$c_setting,$credit_note,$allacc,$credit_type,$account_invoices,$orders_invoices;

    
    echo '
    <script>
    $(\'.chosen-select\').chosen({allow_single_deselect:true}); 
    
          
    $(window)
    .off(\'resize.chosen\')
    .on(\'resize.chosen\', function() {
          $(\'.chosen-select\').each(function() {
                 var $this = $(this);
                 $this.next().css({\'width\': $this.parent().width()});
          })
    }).trigger(\'resize.chosen\');
    
    
    </script>
    
    <form id="add_edit_credit_'.$credit_note->id.'" method="post" action="credit_note.php?action=add_edit" class="form-horizontal" role="form">
    <input type="hidden" name="id" value="'.$credit_note->id.'" />
    <div class="row">

    <div class="col-xs-4">

    <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">الإشعار</label>
    <div class="col-sm-9">
    <select  class="col-xs-10 col-sm-5 chosen-select " name="credit_type" validate="notempty"  >
    <option value="">إختر إشعار</option>';
    for ($i=0;$i<count($credit_type);$i++){
    echo '<option value="'.$credit_type[$i]['value'].'" '.($credit_type[$i]['value'] == $credit_note->credit_type ? 'selected' : '').' >'.$credit_type[$i]['name'].'</option>';
    }
    echo '
    </select>
    </div>
    </div>

    
<div class="form-group" >
<label class="col-sm-3 control-label no-padding-right">الحساب</label>
<div class="col-sm-9">
<select  class=" col-xs-10 col-sm-5 chosen-select " name="account_id"  validate="notempty" onchange="credit_note_acount(this,\''.$credit_note->id.'\');"  >
<option value="">'.$lang[204].'</option>';
for ($i=0;$i<count($allacc);$i++){
echo '<option value="'.$allacc[$i]['account_id'].'" '.($allacc[$i]['account_id'] == $credit_note->account_id ? 'selected' : '').' >'.$allacc[$i]['account_name'].' | '.$allacc[$i]['account_company'].'</option>';
}
echo '
</select>
</div>
</div>

    <div class="form-group"  id="credit_invoice_no_'.$credit_note->id.'" '.($credit_note->id == '' ? 'style="display:none;"' : '').' >
    <label class="col-sm-3 control-label">رقم الفاتورة</label>
    <div class="col-sm-9">
    <select name="invoice_id" class="col-xs-10 col-sm-5 "   id="select_credit_invoice_no_'.$credit_note->id.'" onchange="credit_note_invoice(this,\''.$credit_note->id.'\');"  >
    <option value="" > إختر فاتورة</option>
    ';
    for ($i=0;$i<count($account_invoices);$i++){
    echo '<option value="'.$account_invoices[$i]['id'].'" '.($account_invoices[$i]['id'] == $credit_note->invoice_id ? 'selected' : '').' >'.$account_invoices[$i]['id'].'</option>';
    }
    echo '
    </select>
    <!--
    <input class="form-control"  type="number" name="invoice_id" validate="notempty"  value="'.$credit_note->invoice_id.'"  />
    -->
    </div>
    </div>

    <div class="form-group" id="credit_order_id" '.($credit_note->id == '' ? 'style="display:none;"' : '').' >
    <label class="col-sm-3 control-label">رقم الطلب</label>

    <div class="col-sm-9">
    <select name="order_id" class="col-xs-10 col-sm-5 "   id="select_credit_order_no_'.$credit_note->id.'" onchange="credit_note_invoice(this,\''.$credit_note->id.'\');"  >
    <option value="" >إختر طلب</option>
    ';
    for ($i=0;$i<count($orders_invoices);$i++){
    echo '<option value="'.$orders_invoices[$i]['order_id'].'" '.($orders_invoices[$i]['order_id'] == $credit_note->order_id ? 'selected' : '').' >'.$orders_invoices[$i]['order_id'].'</option>';
    }
    echo '
    </select>
<!--
    <input class="form-control"  type="number" name="order_id"  value="'.$credit_note->order_id.'"  />
    -->
    </div>
    </div>

    <div class="form-group">
    <label class="col-sm-3 control-label">ملاحظاة</label>
    <div class="col-sm-9"><input class="form-control"  type="text" name="note"  value="'.$credit_note->note.'"  /></div>
    </div>


    <div class="form-group">
    <label class="col-sm-3 control-label">الكمية</label>
    <div class="col-sm-9"><input class="form-control"  type="text" name="credit_value" validate="notempty" size="5" value="'.$credit_note->credit_value.'" /></div>
    </div>

    <div class="clearfix form-actions"  >
    <div class="col-md-offset-3 col-md-9">
    <input type="button"  class="btn btn-info" value="Save"  name="edituser" onclick="add_form_php(\'add_edit_credit_'.$credit_note->id.'\',\'1\');"/>';

if($credit_note->id != '' ){

    echo '&nbsp;&nbsp;&nbsp;<input type="button"  class="btn btn-danger" value="close"  name="close_edituser" onclick="close_my_tab(\'tabs\',\'0\');"/>';
}
    
echo '</div>
    </div>

    </div>
    </div>

    </form>';
}


function template_show_credit(){
    global $lang,$c_setting,$credit_note;

    echo '
    <table class="dataTable table table-striped table-bordered table-hover  ">
    <thead class="go">
    <tr>
    <th>+</th>
    <th>المستخدم</th>
    <th>الحساب</th>
    <th>رقم الفاتورة</th>
    <th>التاريخ</th>
    <th>ملاحظات</th>
    <th>القيمة</th>
    <th>+</th>
    </tr>
    </thead>
    ';
    if(count($credit_note) > 0){
    for($i=0;$i<count($credit_note);$i++){
    echo '
    <tr>
    <td>'.$credit_note[$i]['id'].'</td>
    <td>'.$credit_note[$i]['user_name'].'</td>
    <td>'.$credit_note[$i]['account_name'].' | '.$credit_note[$i]['account_company'].'</td>
    <td>'.$credit_note[$i]['invoice_id'].'</td>
    <td>'.date("Y-m-d",strtotime($credit_note[$i]['date_added'])).'</td>
    <td>'.$credit_note[$i]['note'].'</td>
    <td>'.$credit_note[$i]['credit_value'].'</td>
    <td>
    <button type="button" class="btn btn-app  btn-danger btn-xs"  onclick="open_new_tab(\'credit_note.php?action=add_edit&id='.$credit_note[$i]['id'].'\',\'Edit Credit Note No : '.$credit_note[$i]['id'].'\',\'tabs\');">
    <i class="fa fa-external-link "  ></i>
        </button>
    </td>
 
    </tr>';

    }
}else{
    echo '<tr>
    <td colspan="100%">No data found</td>
    </tr>';
}



    echo '</table>
    
    ';
}