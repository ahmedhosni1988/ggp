<?php

function template_mange_search()
{
    global $lang;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>

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
        $(tabID).html("<b>' . $lang[712] . '....</b>");
      }
	   

});



				

	    

}); 
</script>


<div id="right_side">
<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   <li><a href="search.php?action=search" >' . $lang[54] . '</a></li>

</ul>

<div id="tab0" style="padding:20px;" >

</div>

</div>
</div>

';
}
function template_searchDeliveries()
{
    global $lang;
    echo '
		
	<div class="page-content-area">
	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->			


<form method="post" action="'.formurl.'/search.php?action=searchDeliveries" >

<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">   رقم اذن استلام</label>
<div class="col-sm-9">
<input type="text" name="numOfDeliver" placeholder="رقم اذن استلام"  value=""  />

</div>
</div>	
<br>
<hr/>

<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">رقم الطلبية</label>
<div class="col-sm-9">
<input type="text" name="numOfOrders" placeholder="رقم الطلبية"  value=""  />


</div>
</div>	

<div style="clear:both;"></div>

<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
<input  type="submit"   id="search_1"  value="بحث"  class="btn btn-info"    />



</div>




</form>
</div><div class="col-md-offset-3 col-md-9">


</div>

<div id="result" >

</div>


';
}


function template_searchDeliveries_result()
{
    global $lang;
    
    echo 'a';
}

function template_admin_search()
{
    global $lang, $pay, $services, $tran, $allacc, $c_setting, $zone, $status, $bill, $drivers, $currency, $billing_code;
    
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script> 


<form name="Search" id="Search" method="get" action="' . formurl . '/search.php?action=search_ajax" class="form-horizontal" role="form" >
';

    // if($_SESSION['billing_code'] != '1') {
    // 	echo '<input type="hidden" name="billing_code" value="'.$_SESSION['billing_code'].'" /> ';
    // }
    echo '
<div class ="col " style="width:45%; float:right;" >


<div style="padding:20px;">

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[55] . '</label>
<div class="col-sm-9"><input class="form-control" type="text" name="easy_order_id" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">الرقم الرئيسى</label>
<div class="col-sm-9"><input class="form-control" type="text" name="order_id" value="" /></div>
</div>';

    if ($_SESSION['status'] == 2) {
        echo '
		<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">' . $lang[878] . '</label>
<div class="col-sm-9">
<input type="text" name="acct_name2" id="acct_name2" class="col-xs-10 col-sm-5" value=""  />
</div>
</div>
		<div class="space-4"></div>

<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">' . $lang[407] . '</label>
<div class="col-sm-5">
<select  class="chosen-select" name="account_acctno"  >
<option value="">' . $lang[204] . '
 </option>
';
        for ($i = 0; $i < count($allacc); $i++) {
            echo '<option value="' . $allacc[$i]['account_id'] . '">' . $allacc[$i]['account_name'] . ' | ' . $allacc[$i]['account_company'] . '</option>';
        }
        echo '
</select>
</div>
</div>

<div class="space-4"></div>
		
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right"> ' . $lang[879] . '</label>
<div class="col-sm-5">
<select  class="chosen-select " name="account_acctname" >
<option value="">' . $lang[204] . '
 </option>
';
        for ($i = 0; $i < count($allacc); $i++) {
            echo '<option value="' . $allacc[$i]['account_id'] . '">' . $allacc[$i]['account_company'] . ' | ' . $allacc[$i]['account_name'] . '</option>';
        }
        echo '
</select>
</div>
</div>	
		
		
		
		
';
    } else {
        //   echo '<input class="form-control" type="hidden" name="account_id" value="' . $_SESSION['account_id'] . '" />';
    }


    echo '
					
					

						
				<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right">تاريخ البحث</label>
			    <div class="col-sm-9">
						
						<div class="radio" style="width:50%; float:left;">
													<label>
														<input name="searchdate" type="radio" value="order_date" class="ace" checked>
														<span class="lbl"> تاريخ النظام</span>
													</label>
												</div>
																
						<div class="radio" style="width:50%; float:left;">
													<label>
														<input name="searchdate" type="radio" value="delivery_date" class="ace">
														<span class="lbl"> تاريخ التسليم</span>
													</label>
												</div>
																
						<div class="radio" style="width:50%; float:left;">
													<label>
														<input name="searchdate" type="radio" value="pickup_date" class="ace">
														<span class="lbl"> تاريخ الاستلام</span>
													</label>
												</div>
								<!--								
						<div class="radio" style="width:50%; float:left;">
													<label>
														<input name="searchdate" type="radio" value="delivery_date" class="ace">
														<span class="lbl"> Deliver</span>
													</label>
												</div>
												-->
						
				</div>
				</div>
						


</div>




</div>

<div class="col " style=" width:40%; float:left; ">

<div style="padding:20px;">

<div class="form-group">
<label class="col-sm-3 control-label">اسم المكتب</label>
<div class="col-sm-9"><input class="form-control" type="text" name="office_name" value="" /></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">اسم العملية</label>
<div class="col-sm-9"><input class="form-control" type="text" name="operation_name" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">تاريخ</label>
<div class="col-sm-9">
		<table>
		<tr><th>من</th><th>الى</th></tr>
		<tr>
		<td><input class="form-control timepicker" type="text" name="date_from" id="pickup_date_from" value=""  /></td>
		<td><input class="form-control timepicker" type="text" name="date_to" id="pickup_date_to" value="" /></td>
		</tr>
		</table>
		</div>

<script type="text/javascript">

jQuery(document).ready(function () {
    \'use strict\';
    jQuery(\'#pickup_date_from\').datepicker({
		dateFormat: \'yy-mm-dd\'	
});
});



$(\'#pickup_date_to\').datepicker({
		dateFormat: \'yy-mm-dd\'	
});

var now = new Date();
current = new Date(now.getFullYear(), now.getMonth()-1, 1);

	$("#pickup_date_from").datepicker(\'setDate\', current);
		$("#pickup_date_to").datepicker(\'setDate\', new Date());	
		
</script>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">البحث</label>
<div class="col-sm-9">
<select class="form-control" name="type" validate="notempty" >
<option value="">الكل</option>
<option value="1" selected >تحت التشغيل</option>
<option value="3"  >تم التسليم</option>

</select>
</div>
</div>';

    if ($_SESSION['billing_code'] > '0') {
        echo '<input type="hidden" name="billing_code" value="'.$_SESSION['billing_code'].'" /> ' ;
    } else {
        echo '<div class="form-group">
<label class="col-sm-3 control-label">' . $lang['billing_code'] . '</label> 
<div class="col-sm-9">
<select name="billing_code">
<option value="" >الكل</option>
';

        for ($i = 0; $i < count($billing_code); $i++) {
            echo '<option value="'.$billing_code[$i]['id'].'"   >'.$billing_code[$i]['billingcode_name'].'</option>';
        }

        echo '
</select>
</div>
</div>

';
    }
    echo '		

</div>
</div>

<div style="clear:both;"></div>

<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
		<input  type="button" id="search_1" onclick="make_admin_search();"; value="' . $lang[26] . '" class="btn btn-info"   />
</div>
</div>

</form>
<div style="clear:both;"></div>
<script>$(\'.chosen-select\').chosen({allow_single_deselect:true}); $(window).off(\'resize.chosen\').on(\'resize.chosen\', function() {$(\'.chosen-select\').each(function() {var $this = $(this);$this.next().css({\'width\': $this.parent().width()});	})}).trigger(\'resize.chosen\');</script>

';
}

function template_admin_search_result()
{
    global $lang, $search_result, $sear, $search;
    //var_dump($sear);

    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/montior.js"></script>

<form method="post" action="' . formurl . '/search.php?action=search_ajax" onsubmit="return false" style="width:100%; background:none; border:none;" >
<input class="form-control" type="hidden" name="x" value="1" />

<input class="form-control" type="hidden" name="search_query" value="' . htmlentities(serialize($sear)) . '" />
<div id="export">
		<div style="width:100%; float:left;  overflow-x: scroll; ">
		
<table class="table table-striped table-bordered table-hover" id="rounded-corner-result-search" >
<thead>
		<tr>
		
		';
    echo '<th></th>';
    foreach ($search_result[0] as $key => $value) {
        echo '<th>' . $key . '</th>';
    }
    echo '</thead></tr>';

    for ($i = 0; $i < count($search_result); $i++) {
        echo '<tr>';
        foreach ($search_result[$i] as $key => $value) {
            if ($key == "order_id") {
                echo '<td>' . show_row_option($search_result[$i]) . '</td>';
            }

            if ($key == "order_id" && $_SESSION['status'] == 2) {
                echo '<td>' . $value . '</td>';
            } else {
                echo '<td>' . $value . '</td>';
            }
        }
        echo '</tr>';
    }
    echo '
</table>
		</div>
</div>

		
<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
<input  type="button" name="excel"  value="Export To excel" onclick="" class="btn btn-danger" />
<input  type="button" name="close" onclick="close_my_tab(\'tabs\',\'0\');" value="' . $lang[200] . '" class="btn btn-info" />
<div style="clear:both;"></div>
</div>
</div>
<div style="clear:both;"></div>
</form>
<div style="clear:both;"></div>

';
}
function template_deficiencies_results()
{
    global $lang,$result,$order_package_details;

    //var_dump($order_package_details);
    /* var prtContent = document.getElementById('data');
    var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();/////
    ////

            var w = window.open();
            //	var printing;
            //printing = $('#data').html();

            //var printing = '<html>';
                w.document.open();
                w.document.write('<head>');
                w.document.write($('head').html());
                w.document.write('</head>');
                w.document.write('<body onload='window.print(); window.close();' class='no-skin rtl'>');
                w.document.write($('#data').html());
                w.document.write('</body>');
                w.document.write('</html>');
                w.document.close();
    */
    echo "<script>
	function Print_this_page() {


		
		var w = window.open();
		//	var printing;
		//printing = $('#data').html();
		
		//var printing = '<html>';
			w.document.open();
			w.document.write('<head>');
			w.document.write($('head').html());
			w.document.write('</head>');
			w.document.write('<body onload=\'window.print(); window.close();\' class=\'no-skin rtl\'>');
			w.document.write($('#data').html());
			w.document.write('</body>');
			w.document.write('</html>');
			w.document.close();
		
		
}
	</script>";

    echo' <div  class="text-center">
	<button  class="btn btn-primary " onclick="Print_this_page()"><i class="ace-icon fa fa-print bigger-160"></i>اطبع</button>
	
	
	<a class="btn btn-danger  " href="' . SITEURL . '/administrator/search.php?action=deficiencies"  ><i class="ace-icon fa fa-share  bigger-160"></i>النواقص</a>
	</div>
	<br>
	
	
	<div id="data" style="font-size:12px !important;" >
	<link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap-timepicker.css" />
		<link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/font-awesome.min.css" />
		<!-- page specific plugin styles -->
		
	    <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/jquery-ui.min.css" />
				
        		
		<!-- page specific plugin styles -->

		

		<!-- ace styles -->
		<link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.min.css" id="main-ace-style" />
		
	
		<link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-skins.min.css" />
		<link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-rtl.min.css" />



		<style>



table td{
 font-size:10px;
}

table th, table td {
	border:1px solid #000;
	
	}

</style>

	<table class="dataTable table  table-bordered" border="3" cellspacing="0" width="100%" dir="rtl" >
	<thead>
	<tr>

	
	<th>العميل</th>
	<th>رقم الطلبية</th>
	<th>تاريخ التسليم</th>
	
		<th>طول</th>
		<th>عرض</th>
		<th>سمك</th>
		<th>لون</th>
		<th>طباعة</th>
		<th>مسطح</th>
		<th>سنفرة</th>
		<th>تخليع</th>
		<th>التفاصيل</th>
		<th>تقطيع</th>
		<th>شطف </th>
		<th>فرن</th>
		<th>توريد</th>
		<th>تسليم</th>
		</tr>
		</thead>';
    
    $old_account_company="";
    $now_account_company="";
    
    for ($j = 0; $j < count($order_package_details); $j++) {
        echo '<tr>';
    
        foreach ($order_package_details[$j] as $key => $value) {
            if ($key == "id") {
                echo '';
            } elseif ($key == "2" || $key == "3" || $key == "4" || $key == "6") {
                echo '<td ' . ($value['on'] == "1" ? 'style="background-color:#ccc !important; text-align:center;"' : '') . ' >' . ($value['done'] == "1" && $value['on'] == "1" ? '<i class="ace-icon fa fa-check-square-o"></i>' : ($value['on'] == "1" ? '<i class="ace-icon fa fa-square-o"></i>' : '')) . '</td>';
            } elseif ($key == "5") {
                //var_dump($value);
            
                echo '<td ' . ($value['on'] == "1" ? 'style="background-color:#ccc !important; text-align:center;"' : '') . ' >' . (($value['done'] == "1" && $value['on'] == "1") || $value['in_work'] == "1" ? '<i class="ace-icon fa fa-check-square-o"></i>' : ($value['on'] == "1" ? '<i class="ace-icon fa fa-square-o"></i>' : '')) . '</td>';
            } else {
                echo '<td>' . $value . ' </td>';
            }
        }
    }
    echo '</tr>';
    
    echo '</table></div>';
}
    
    
        
    

function template_deficiencies()
{
    global $lang,$result,$allacc;

    echo '
<form method="post" action="'.formurl.'/search.php?action=deficiencies" >
		
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right"> '.$lang[879].'</label>
<div class="col-sm-3">
<select  class="col-xs-10 col-sm-5 chosen-select" placeholder="Amr" id="account_acctname[]" name="account_acctname[]" multiple   >

 </option>
';
    for ($i=0;$i<count($allacc);$i++) {
        echo '<option value="'.$allacc[$i]['account_id'].'">'.$allacc[$i]['account_company'].' | '.$allacc[$i]['account_name'].'</option>';
    }
    echo '
</select>
</div>
</div>	
		<br>
		<hr/>
		
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">التاريخ من :</label>
<div class="col-sm-9">
<input type="text" name="from_date"  class="dateinput" value=""  />
</div>
</div>

<br>
<hr/>

<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">التاريخ الى :</label>
<div class="col-sm-9">
<input type="text" name="to_date"  class="dateinput" value=""  />
</div>
</div>


<br>
<hr/>
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right"> المقاس :</label>
<div class="col-sm-9">
<select name="package_type" style="border: 1px solid red;">
<option value="">اختار الثمك </option><option value="1">10 ملى </option><option value="2">4 ملى</option><option value="3">5 ملى</option><option value="4">6 ملى</option><option value="5">8 ملى</option><option value="6">12 ملى</option><option value="7">15 ملى</option><option value="8">20 ملى</option>
</select>
</div>
</div>


<br>
<hr/>

<div class="form-group">
<label class="col-sm-3 control-label no-padding-right"> مسطح :</label>
<div class="col-sm-9">
<select name="glassType">
<option value="" ></option>
<option value="مسطح" >مسطح</option>
<option value="بومبية">بومبية</option>
</select>
</div>
</div>

<br>
<hr/>

<div class="form-group">
<label class="col-sm-3 control-label no-padding-right"> مسطح :</label>
<div class="col-sm-9">
<select name="glasscolour" >
<option value="" ></option>
<option value="شفاف" >شفاف</option><option value="فامية">فامية</option><option value="عاكس">عاكس</option><option value="مرايا">مرايا</option><option value="رمادى">رمادى</option><option value="برونز">برونز</option><option value="أزرق">أزرق</option></select>
</div>
</div>


<div style="clear:both;"></div>

<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
		<input  type="submit"   id="search_1"  value="'.$lang[26].'"  class="btn btn-info"    />
	



</div>




</form>
</div><div class="col-md-offset-3 col-md-9">


</div>

<div id="result" >

</div>

';
}
function template_search_item()
{
    global $lang,$result,$allacc,$_GET;

    echo '
<form method="post" action="'.formurl.'/search.php?action=search_item" >
<input type="hidden" name="style" value="'.$_GET['style'].'" />

<div class="form-group">
<label class="col-sm-3 control-label no-padding-right"> '.$lang[879].'</label>
<div class="col-sm-3">
<select  class=" chosen-select" name="account_acctname"  >
<option value="">'.$lang[204].'
 </option>
';
    for ($i=0;$i<count($allacc);$i++) {
        echo '<option value="'.$allacc[$i]['account_id'].'">'.$allacc[$i]['account_company'].' | '.$allacc[$i]['account_name'].'</option>';
    }
    echo '
</select>
</div>
</div>	
		<br>
		<hr/>
		
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right">المقاس</label>
<div class="col-sm-9">
<input type="text" name="length" placeholder="الطول"  value=""  required/>
<input type="text" name="width" placeholder="العرض"  value="" required />

</div>
</div>	

<div style="clear:both;"></div>

<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
		<input  type="submit"   id="search_1"  value="'.$lang[26].'"  class="btn btn-info"    />
	


</div>




</form>
</div><div class="col-md-offset-3 col-md-9">


</div>

<div id="result" >

</div>

';
}

function template_search_item_result()
{
    global $items_details;

    //var_dump($items_details);
    echo '
	<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>
	<table class="dataTable table  table-bordered   ">
	<thead class="go">
	<tr>
	<th>الطلبية</th>
	
	<th>اسم العميل</th>
	<th>العملية</th>
	<th>اسم المكتب</th>
	
	<th>طول</th>
	<th>عرض</th>
	<th>سمك</th>
	<th>لون</th>
	<th>طباعة</th>
	<th>مسطح</th>
	<th>سنفرة</th>
	<th>تخليع</th>
	<th>تفاصيل</th>
	<th></th>
	</tr>
	</thead>
	';
    foreach ($items_details as $item) {
        echo '<tr><th>' . $item['order_id'] .'-'.$item['part_order'].'</td>
		
		<td>'. $item['account_company'] .'</td>
		<td>'. $item['operation_name'] .'</td>
		<td>'. $item['office_name'] .'</td>

		 <td>'. $item['length'] .'</td>
		 <td>'. $item['width'] .'</td>
		 <td>'. $item['package_name'] .'</td>
		 <td>'. $item['glasscolour'] .'</td>
		 <td>'. $item['glassPrint'] .'</td>
		 <td>'. $item['glassType'] .'</td>
		 <td>'. $item['glassScarch'] .'</td>
		 <td>'. $item['glassPointing'] .'</td>
		 <td>'. $item['details'] .'</td>
		 <td>
		 <button class="btn btn-info btn-xs" style="width:30px; height:30; margin:2px;" onclick="refreshwaybill(\''.$item['order_id'].'\');">
		<i class="fa fa-print bigger-125 icon-only"></i>
															</button>
		 </td>
	</tr>';
    }

    echo '</table>';
}
