<?php


function show_sales_invoice_option($ro){
    for ($i=0;$i<count($ro);$i++) {
        foreach ($ro[$i] as $key => $value) {
            $rou[$key] = $value;
        }
    }
    $x .= '
    <button type="button" title="'.$lang['button_editorder'].'" class="btn btn-app  btn-success btn-xs"  onclick="window.open(\''.SITEURL.'/administrator/accounting/accounting.php?action=edit_invoice&id='.$rou['id'].'\', \'_blank\'); " >
    <i class="fa fa-external-link " ></i>
    </button>


    <button type="button" title="'.$lang['button_editorder'].'" class="btn btn-app  btn-warning btn-xs"  onclick="window.open(\''.SITEURL.'/administrator/invoicing/index.php?id='.$rou['order_id'].'\', \'_blank\'); " >
    <i class="fa fa-print  " ></i>
    </button>

    
    <button type="button" title="'.$lang['button_editorder'].'" class="btn btn-app  btn-default  btn-xs"  onclick="refreshwaybill('.$rou['order_id'].');" >
    <i class=" fa fa-print  " ></i>
    </button>

';

    return $x;

}
function show_account_row_option($ro)
{
    for ($i=0;$i<count($ro);$i++) {
        foreach ($ro[$i] as $key => $value) {
            $rou[$key] = $value;
        }
    }

    $x .= '  <button type="button" title="'.$lang['button_editorder'].'" class="btn btn-app  btn-success btn-xs"  onclick="show_edit_account('.$rou['account_id'].',\''.$rou['account_company'].'\');" >
    <i class="fa fa-external-link " ></i>
    </button>
';

    return $x;
}



function show_supplier_row_option($ro)
{
    for ($i=0;$i<count($ro);$i++) {
        foreach ($ro[$i] as $key => $value) {
            $rou[$key] = $value;
        }
    }

    $x .= '  <button type="button" title="'.$lang['button_editorder'].'" class="btn btn-app  btn-success btn-xs"  onclick="show_edit_suppliers('.$rou['account_id'].',\''.$rou['account_company'].'\');" >
    <i class="fa fa-external-link " ></i>
    </button>
';

    return $x;
}


function show_accounting_order_option($ro){

    for ($i=0;$i<count($ro);$i++) {
        foreach ($ro[$i] as $key => $value) {
            $rou[$key] = $value;
        }
    }

    $x .= '  <button type="button" title="'.$lang['button_editorder'].'" class="btn btn-app  btn-default btn-xs"  onclick="refreshwaybill('.$rou['order_id'].');" >
    <i class="fa fa-print  " ></i>
    </button>
';

return $x;

}

function show_supplier_inv_row_option($ro)
{
    for ($i=0;$i<count($ro);$i++) {
        foreach ($ro[$i] as $key => $value) {
            $rou[$key] = $value;
        }
    }


    //فاتورة جدية يمكن اضافتها للمحزن
    if ($rou['bill_status'] == '0') {
        
    $x .= '  <button type="button" title="'.$lang['button_editorder'].'" class="btn btn-app  btn-warning  btn-xs"  onclick="show_edit_inv_suppliers('.$rou['id'].',\''.$rou['bill_no'].'\');" >
    <i class="fa fa-wrench   " ></i>
    </button>
';

        $x .= '  <button type="button" title="'.$lang['button_editorder'].'" class="btn btn-app  btn-success btn-xs"  onclick="import_to_inventory('.$rou['id'].',\''.$rou['bill_no'].'\');" >
        <i class="fa fa-exchange " ></i>
        </button>
    ';

        $x .= '  <button type="button" title="'.$lang['button_editorder'].'" class="btn btn-app  btn-danger btn-xs"  onclick="delete_inv_purchasing('.$rou['id'].',\''.$rou['bill_no'].'\');" >
    <i class="fa fa-trash-o " ></i>
    </button>
';

    }

    //فانورة تمت اضافتها للمخزن
    if ($rou['bill_status'] == '1') {
        $x .= '  <button type="button" title="'.$lang['button_editorder'].'" class="btn btn-app  btn-default btn-xs"  onclick="print_inv('.$rou['id'].',\''.$rou['bill_no'].'\');" >
        <i class="fa fa-print  " ></i>
        </button>
    ';
    }




    return $x;
}

function template_accounting_console()
{
    global $lang, $grid, $html_grid, $n_ids, $action, $count, $start,$url;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>
		
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/montior.js"></script>



';


    echo '
    <div class="row" style=" width:100%;  float:right; border-bottom: 1px solid #ddd;
    background: #4692bf;">
    <div class="col-xs-6"><h4 style="color:#fff;">
    <i class="'.$gicon.' white"></i>&nbsp;&nbsp;

'.$Gtitle.'
							</h4>			
    </div>
    <div class="col-xs-6" style="padding:10px;">
    <input type="text" id="search_grid" url="'.$url.(strpos($url,'?') ? '' : '?' ).'&ajax=1"  class=" input-sm" style="float:left; margin-left:20px;"  value=""  placeholder="بحث" >
    </div>
    </div>

    <div class="row" style=" width:100%;  float:right; border-bottom: 1px solid #ddd;">
    <div class="col-xs-12" style="padding-right:0px; padding-left:0px;">
    <div id="grid" class="grid"  style=" width:100%;" >

' . $html_grid . '

</div>
</div>
</div>

<div style=" clear:both;"></div>

';
}
