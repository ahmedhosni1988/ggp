<?php

function template_main_accounting()
{
    echo 'Ahmed';
}



function template_edit_invoice()
{
    global $lang,$c_setting,$invDetails;

    echo '
    
    
    ';
}





function template_cashreceipts()
{
    global $lang, $bill, $acc, $tax,$payment_type;
    $allacc = $acc;
    echo '
	<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/invoice.js"></script> 
<script  type="text/javascript">


 $(document).ready(function () {
	 $("#tabs").tabs();

 });

</script>



<div id="tabs">
<ul >
<li><a href="accounting.php?action=view_cashreceipts" >الدفعات</a></li>   
<li><a href="accounting.php?action=cash" >' . $lang['cashreceipts'] . '</a></li>  

</ul>



<div id="tabs-0" class="tabset_content">


</div>
<div id="tabs-1" class="tabset_content">


</div>


</div>
';
}





function template_out_order_view()
{
    global $lang, $res;

    echo '
        <table class="dataTable table  table-bordered ">
 
        <tr>
        <th>رقم اذن التسليم</th>
        <th>تاريخ</th>
        <th>العميل</th>
        <th></th>
        </tr>';

    for ($i = 0; $i < count($res); $i++) {
        echo '
            <tr>
            <td>' . $res[$i]['id'] . '</td>
            <td>' . date("Y-m-d", strtotime($res[$i]['finishe_date'])) . '</td>
            <td>' . $res[$i]['account_company'] . '</td>
            <td>
            
            <button class="btn  btn-info btn-xs" onclick="window.open(\'work.php?action=create_out_order&amp;print=1&amp;id=' . $res[$i]['id'] . '\',\'_blank\') ">
			<i class="fa fa-print "></i>
            </button>

            </td>
            </tr>
            ';
    }


    echo '<table>
        ';
}
