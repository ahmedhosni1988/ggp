<?php


function template_stock_report()
{
    global $lang;
    echo '
	
	
	<form name="stock" method="post" action="' . SITEURL . '/administrator/report.php?action=stock" class="form-horizontal" role="form">

	<input type="hidden" name="report" value="1" />



<button type="submit" class="btn btn-danger btn-block  name="report">
<i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
تقرير الخام&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</button>
	
</form>
	';
}


function template_operation_report()
{
    global $lang, $pack;

    echo '
    <link rel="stylesheet" href="' . SITEURL .'/'. STYLE .'/css/jquery.datetimepicker.min.css">  
	<form name="stock" autocomplete="off" method="post" action="' . SITEURL . '/administrator/report.php?action=operation" class="form-horizontal" role="form">

	<input type="hidden" name="report" value="1" />


	
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">العملية</label>
<div class="col-sm-9">
<select name="operation">
<option value="">كل العمليات</option>
<option value="2">تقطيع</option>
<option value="3">شطف </option>
<option value="7">تشطيب </option>
<option value="4">فرن</option>
<option value="5">تسليمات</option>
</select>
</div>
</div>

    
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">نوع الشغل</label>
<div class="col-sm-9">
<select name="option_type">
<option value="">كل </option>
<option value="2">اجرة</option>
<option value="1">شامل</option>

</select>
</div>
</div>

<script>
jQuery(document).ready(function () {
    \'use strict\';
    jQuery(\'.filter-date\').datetimepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });
});
</script>

<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">التاريخ من :</label>
<div class="col-sm-9">
<input class="filter-date" type="text" name="from_date" value=""  />
</div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">التاريخ الى </label>
<div class="col-sm-9">
<input class="filter-date" type="text" name="to_date" value=""  />
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">السمك </label>
<div class="col-sm-9">
<select  name="package_type">
<option value="" >' . $lang[362] . ' </option>';
    for ($i = 0; $i < count($pack); $i++) {
        echo '<option value="' . $pack[$i]['package_id'] . '" >' . $pack[$i]['package_name'] . '</option>';
    }
    echo '
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">نوع التقريب</label>
<div class="col-sm-9">
<input type="radio" name="status"   value="1" checked />الكل <br>
<input type="radio" name="status"   value="3"  /> تم الانتهاء  <br>
<input type="radio" name="status"   value="2"  />  تحت التشغيل  

</div>
</div>



<button type="submit" class="btn btn-danger btn-block  name="report">
<i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
تقرير الانتاج&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</button>
	
</form>
	';
}




function template_view_accounts_accounting()
{
    global $data;
    // echo '<pre>';
    // var_dump($data);
    // echo '</pre>';
    echo'
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="'.SITEURL.'/'.STYLE.'/assets/DataTables/DataTables/css/dataTables.jqueryui.min.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
	
	<style>
    #List tr:nth-child(odd) {
		background-color: #e9e9e9;
	}
	
    #List td {
		padding: 5px !important;
		font-size: 10px;
	}
    #List tr:nth-child(even) {
		background-color: #f6f6f6;
	}
    #List th{
	font-weight: 900;
		color: #ffffff;
		background:  #307ecc;
	
    }
    

	
	.dataTable>thead>tr>th[class*=sort]:after {
	
		display: none ;
	}
	</style>';
    echo '
    <h3>التحصيل</h3>

    <table id="List"  class="ui celled table " style="width:100%">
    <thead>
      
        <tr>
            <th>العميل</th>
            <th>اجمالى الفواتير</th>
            <th>اجمالى التحصيل</th>
            <th>المديونيه</th>
         </tr>
    </thead>
    <tbody>
	</tbody>
	<tfoot>
      
	<tr>
    <th>العميل</th>
            <th>اجمالى الفواتير</th>
            <th>اجمالى التحصيل</th>
            <th>المديونيه</th>
    </tr>
</tfoot>
</table>
    
    
	';

    echo ' 
    <script>
   var dataList='.json_encode($data).'
   </script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/jquery.dataTables.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/dataTables.jqueryui.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/dataTables.buttons.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/jszip.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/pdfmake.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/vfs_fonts.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/buttons.html5.min.js"></script>
    <script src="'.SITEURL.'/'.STYLE.'/jscript/account_accountingTable.js"></script> 
';
}



function template_view_account_accounting()
{
    global $cashreceiptsList,$invoicehdr_Not_paid,$invoicehdr_paid;
    // var_dump($cashreceiptsList);
    // var_dump($invoicehdr_Not_paid);
    // var_dump($invoicehdr_paid);

    echo'
	
	
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="'.SITEURL.'/'.STYLE.'/assets/DataTables/DataTables/css/dataTables.jqueryui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
	
	<style>
	#cashreceiptsList tr:nth-child(odd), #account_accounting2 tr:nth-child(odd),#account_accounting tr:nth-child(odd) {
		background-color: #e9e9e9;
	}
	
	#cashreceiptsList td,#account_accounting2 td,#account_accounting td {
		padding: 5px !important;
		font-size: 10px;
	}
	#cashreceiptsList tr:nth-child(even),#account_accounting2 tr:nth-child(even),#account_accounting tr:nth-child(even) {
		background-color: #f6f6f6;
	}
	#cashreceiptsList th, #account_accounting2 th,#account_accounting th{
	font-weight: 900;
		color: #ffffff;
		background:  #307ecc;
	
    }
    

	
	.dataTable>thead>tr>th[class*=sort]:after {
	
		display: none ;
	}
	</style>';
    echo '
    <h3>التحصيل</h3>

    <table id="cashreceiptsList"  class="ui celled table " style="width:100%">
    <thead>
      
        <tr>
            <th>عميل</th>
            <th>المبلغ</th>
            <th>طريقه الدفع</th>
            <th>المستخدم</th>
            <th>التاريخ</th>
            <th>رقم الوصل</th>
          
		 </tr>
    </thead>
    <tbody>';
    foreach ($cashreceiptsList as $key => $value) {
        echo'
		<tr>
		<td>'.$value['account_company'].'</td>
		<td>'.$value['pymt_amount'].'</td>
		<td>'.$value['payment_name'].'</td>
		<td>'.$value['user_name'].'</td>
		<td>'.$value['date'].'</td>
		<td>'.$value['invoiceno'].'</td>
	 </tr>';
    }
    echo'</tbody>
	<tfoot>
      
	<tr>
		<th>عميل</th>
		<th>المبلغ</th>
		<th>طريقه الدفع</th>
		<th>المستخدم</th>
		<th>التاريخ</th>
		<th>رقم الوصل</th>
		
	 </tr>
</tfoot>
</table>
    
    
    
    <div class="row">
    <div class="col-md-6">
    <h3>فواتير غير مدفوعة</h3>
    <table id="account_accounting"  class="ui celled table " style="width:100%">
    <thead>
      
        <tr>
            <th>رقم الفاتورة</th>
            <th>التاريخ</th>
            <th>المستحق</th>
		 </tr>
    </thead>
    <tbody>';
    foreach ($invoicehdr_Not_paid as $key => $value) {
        echo'      
        <tr>
        <td>'.$value['easy_order_id'].'</td>
    
        <td>'.$value['date'].'</td>
        <td>'.$value['subtotal'].'</td>
         </tr>';
    }
    echo'
	</tbody>
	<tfoot>
      
	<tr>
    <th>رقم الفاتورة</th>

    <th>التاريخ</th>
    <th> الدفع</th>
	 </tr>
</tfoot>
</table>
    </div>
    
    <div class="col-md-6">
    <h3>فواتير مدفوعة</h3>
    <table id="account_accounting2"  class="ui celled table " style="width:100%">
    <thead>
      
        <tr>
            <th>رقم الفاتورة</th>
            <th>التاريخ</th>
            <th>المستحق</th>
		 </tr>
    </thead>
    <tbody>';
    foreach ($invoicehdr_paid as $key => $value) {
        echo'      
        <tr>
        <td>'.$value['easy_order_id'].'</td>
    
        <td>'.$value['date'].'</td>
        <td>'.$value['subtotal'].'</td>
         </tr>';
    }
    echo'
	</tbody>
	<tfoot>
      
	<tr>
    <th>رقم الفاتورة</th>

    <th>التاريخ</th>
    <th> الدفع</th>
	 </tr>
</tfoot>
</table>
    </div>
    </div>
   
  

<script>
	';

    echo ' 
    var php="'.SITEURL.'/administrator/account_accountingTable.php";  
    var php2="'.SITEURL.'/administrator/account_accountingTable2.php";  
    var php3="'.SITEURL.'/administrator/cashreceiptsTable.php";  
	</script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/jquery.dataTables.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/dataTables.jqueryui.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/dataTables.buttons.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/jszip.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/pdfmake.min.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/vfs_fonts.js"></script>
	<script src="'.SITEURL.'/'.STYLE.'/jscript/buttons.html5.min.js"></script>
    <script src="'.SITEURL.'/'.STYLE.'/jscript/account_accountingTable.js"></script> 
';
}



function template_accounts_accounting()
{
    global $lang, $pack,$acc;
    // var_dump($acc[0]);
    echo '
	
	
	<form name="stock" method="post" action="' . SITEURL . '/administrator/report.php?action=accounts_accounting" class="form-horizontal" role="form">

	<input type="hidden" name="action" value="accounts_accounting" />


<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">العملية</label>
<div class="col-sm-9">

<select name="account_id">


<option value="0" >كل العملاء</option>';

    foreach ($acc as $key => $value) {
        echo '<option value="'.$value['account_id'].'">'.$value['account_company'].' | '.$value['billingcode_name'].'</option>';
    }



    echo'
</select>
</div>
</div>


<button type="submit" class="btn btn-danger btn-block  name="report">
<i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
تقرير حساب عميل&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</button>
	
</form>
	';
}

function template_account_accounting()
{
    global $lang, $pack,$acc;
    // var_dump($acc[0]);
    echo '
	
	
	<form name="stock" method="get" action="' . SITEURL . '/administrator/report.php?action=account_accounting" class="form-horizontal" role="form">

	<input type="hidden" name="action" value="account_accounting" />


<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">العملية</label>
<div class="col-sm-5">

<select name="account_id" class="chosen-select" >';

    foreach ($acc as $key => $value) {
        echo '<option value="'.$value['account_id'].'">'.$value['account_company'].' | '.$value['billingcode_name'].'</option>';
    }



    echo'
</select>
</div>
</div>


<button type="submit" class="btn btn-danger btn-block  name="report">
<i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
تقرير حساب عميل&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</button>
	
</form>
	';
}

function template_scratch_report()
{
    global $lang, $pack;
    echo '
    <link rel="stylesheet" href="' . SITEURL .'/'. STYLE .'/css/jquery.datetimepicker.min.css">  

	
	<form name="stock" method="post" action="' . SITEURL . '/administrator/report.php?action=scratch" class="form-horizontal" role="form">

	<input type="hidden" name="report" value="1" />


<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">العملية</label>
<div class="col-sm-9">
<select name="operation">
<option value="">كل العمليات</option>
<option value="2">تقطيع</option>
<option value="3">شطف وتخليع</option>
<option value="4">فرن</option>
<option value="5">تسليمات</option>
</select>
</div>
</div>

	
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">التاريخ من :</label>
<div class="col-sm-9">
<input type="text" name="from_date"  class="filter-date" value=""  />
</div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">التاريخ الى </label>
<div class="col-sm-9">
<input type="text" name="to_date"  class="filter-date" value=""  />
</div>
</div>


<script>
jQuery(document).ready(function () {
    \'use strict\';
    jQuery(\'.filter-date\').datetimepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });
});
</script>



<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">السمك </label>
<div class="col-sm-9">
<select  name="package_type">
<option value="" >' . $lang[362] . ' </option>';
    for ($i = 0; $i < count($pack); $i++) {
        echo '<option value="' . $pack[$i]['package_id'] . '">' . $pack[$i]['package_name'] . '</option>';
    }
    echo '
</select>
</div>
</div>


<button type="submit" class="btn btn-danger btn-block  name="report">
<i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
تقرير الهالك&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</button>
	
</form>
	';
}


function template_salesReportDetails()
{
    global $lang, $pack;
    echo '
    <link rel="stylesheet" href="' . SITEURL .'/'. STYLE .'/css/jquery.datetimepicker.min.css">  

	
	<form name="stock" method="post" action="' . SITEURL . '/administrator/report.php?action=salesReportDetails" class="form-horizontal" role="form">

	<input type="hidden" name="report" value="1" />




	
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">التاريخ من :</label>
<div class="col-sm-9">
<input type="text" name="from_date"  class="filter-date" value=""  />
</div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">التاريخ الى </label>
<div class="col-sm-9">
<input type="text" name="to_date"  class="filter-date" value=""  />
</div>
</div>


<script>
jQuery(document).ready(function () {
    \'use strict\';
    jQuery(\'.filter-date\').datetimepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });
});
</script>





<button type="submit" class="btn btn-danger btn-block  name="report">
<i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
تقرير المبيعات المفصل&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</button>
	
</form>
	';
}


function template_salesReport()
{
    global $lang, $pack;
    echo '
    <link rel="stylesheet" href="' . SITEURL .'/'. STYLE .'/css/jquery.datetimepicker.min.css">  

	
	<form name="stock" method="post" action="' . SITEURL . '/administrator/report.php?action=salesReport" class="form-horizontal" role="form">

	<input type="hidden" name="report" value="1" />




	
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">التاريخ من :</label>
<div class="col-sm-9">
<input type="text" name="from_date"  class="filter-date" value=""  />
</div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">التاريخ الى </label>
<div class="col-sm-9">
<input type="text" name="to_date"  class="filter-date" value=""  />
</div>
</div>


<script>
jQuery(document).ready(function () {
    \'use strict\';
    jQuery(\'.filter-date\').datetimepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });
});
</script>





<button type="submit" class="btn btn-danger btn-block  name="report">
<i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
تقرير المبيعات&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</button>
	
</form>
	';
}


function template_accounting_report()
{
    global $lang;
    echo '
	
	
	<form name="stock" method="post" action="' . SITEURL . '/administrator/report.php?action=accounting" class="form-horizontal" role="form">

	<input type="hidden" name="report" value="1" />



<button type="submit" class="btn btn-danger btn-block  name="report">
<i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
تقرير الحسابات&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</button>
	
</form>
	';
}
