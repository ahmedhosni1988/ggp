<?php


function template_invoice_header()
{
    global $invhdr;

    $x = '
    <style>
    .maintd {
        text-align: right;
        background : #f4f4f4;
        padding-right:5px;
        font-weight:bold;
    }
    
    .tableheader{
        text-align: center;
        background : #eeeeee;
        font-weight:bold;
        padding:5px;


    }
    .tabletd{
        font-weight:bold;
        padding:5px;
    }

    .tableannounce{

    }
    </style>
    <table border="1" cellspacing="0" width="100%" dir="rtl" >
    
    <tr>
    
    <td style="text-align:center;">
    <img src="' . SITEURL . '/images/logo.jpg"  max-height="70">
    </td>
    
    <td style="text-align:right; width:70%;"  valign="top">
    <table border="2" width="100%" cellpadding="5" class="table_details">
    <tr>
    <td class="maintd">رفم الفاتورة</td><td>'.$invhdr['id'].'</td>
    <td class="maintd">حاله</td><td>'.($invhdr['reviewed'] == '0' ? 'لم تتم المراجعه' : 'تمت مراجعة هذه الطلبية').'</td>
    </tr>
    <tr>
    <td class="maintd">التاريخ</td><td>' . date("d - m- Y", strtotime($invhdr['date'])) . '</td>
    
    <td class="maintd">رقم الطلبية</td><td>' . $invhdr['easy_order_id'] . ' </td>
    </tr>
    <tr>
    <td class="maintd">نوع الطلبية</td><td>' . $invhdr['service_name'] . ' </td>
    <td class="maintd">العميل</td><td>' . $invhdr['account_name'] . ' | ' . $invhdr['account_company'] . '</td>
    </tr>
    <tr>
    <td class="maintd">اسم المكتب</td><td>' . $invhdr['office_name'] . '</td>
    <td class="maintd">اسم العملية</td><td>' . $invhdr['operation_name'] . '</td>
    </tr>
    <tr>
    <td class="maintd">تاريخ الاستلام </td><td>' . $invhdr['pickup_date'] . '</td>
    <td class="maintd"> تاريخ التسليم </td><td>' . $invhdr['delivery_date'] . '</td>
    </tr>
    
    <tr>
    <td class="maintd">كمية الزجاج </td><td>' . ($invhdr['order_size'] / 10000) . '</td>
    <td class="maintd"> عدد القطع</td><td>' . $invhdr['pieces'] . '</td>
    </tr>
    </table>
    </td>
    </tr>
    </table>';

    return $x;
}

function template_invoice_main()
{
    global $invhdr,$invdetails,$mytotal;
    echo '
    <div id="print" style="width:29.5cm; height:40cm; margin:auto;">
    <div style="padding:0px 5px;">
    '.template_invoice_header().'


    
    
   
    <table class="table_details" border="1" cellspacing="0" width="100%" dir="rtl">
    ';
    
    if ($invhdr['service_id'] == "2") {
        echo '<tr>
            
        <td class="tableheader">القطعة</td>
        <td class="tableheader">طول</td>
        <td class="tableheader">عرض</td>
        <td class="tableheader">سمك</td>
        <td class="tableheader">لون</td>
        <td class="tableheader">مسطح</td>
        <td class="tableheader">تخليع</td>
        <td class="tableheader">التفاصيل</td>
        <td class="tableheader">التسعير</td>
       
        </tr>';
    } elseif ($order_details->service_id == "1") {
    }

    $mytotal = 0;
    
    for ($j = 0; $j < count($invdetails); $j++) {
        $pac = $invdetails[$j];
        $mytotal += $pac['amount'];

        echo '<tr>';
        if ($pac['chgtype'] == 'S') {
            echo '
            <td class="tabletd">'.$pac['item'].'</td>
            <td class="tabletd">'.$pac['length'].'</td>
            <td class="tabletd">'.$pac['width'].'</td>
            <td class="tabletd">'.$pac['package_name'].'</td>
            <td class="tabletd">'.$pac['glasscolour'].'</td>
            <td class="tabletd">'.$pac['glassType'].'</td>
            <td class="tabletd">'.$pac['glassPointing'].'</td>
            <td class="tabletd">'.$pac['details'].'</td>
            <td class="tabletd">'.$pac['amount'].'</td>
            ';
        } else {
            echo '
            <td class="tabletd">'.$pac['item'].'</td>
            <td colspan="7"  class="tabletd">'.$pac['descn'].'</td>
            <td  class="tabletd">'.$pac['amount'].'</td>
            ';
        }
       
        echo '</tr>';
    }
    
    
    echo '
    </table>
    '.template_invoice_footer().'

    </div>
    </div>

    ';
}

function template_invoice_footer()
{
    global $mytotal,$package_division,$invhdr;
    echo '<table  border="1" cellspacing="0" width="100%" dir="rtl" >
    <tr>
    <td colspan="100%" class="tableheader">'.SITENAME.'</td>
    </tr>

    <tr>
    <td style="width:50%;">
    <table>
    <tr>
    <td class="tableheader">السمك</td>
    <td class="tableheader">الكمية</td>
    <td class="tableheader">التكلفة</td>
    </tr>';

    foreach ($package_division as $key =>$value) {
        echo '<tr>
        <td class="tabletd">'.$value['package_name'].'</td>
        <td class="tabletd">'.$value['meters'].'</td>
        <td class="tabletd">'.$value['price'].'</td>

        </tr>';
    }
    echo '</table>
    
    </td>
    
    <td class="tabletd" style="width:50%; font-size:20px;">
    <div style="text-align:left; margin:20px;">
    <table>
    <tr>
    <td class="tableheader">المجموع:</td>
    <td class="tabletd">'.$mytotal.'</td>
    </tr>
    ';
    if($invhdr['discount_value'] > '0'){
        echo '<tr>
        <td class="tableheader">الخصم:</td>
        <td class="tabletd">'.$invhdr['discount_value'].'</td>
        </tr>';
     
        echo '<tr>
        <td class="tableheader">الاجمالى:</td>
        <td class="tabletd">'.($mytotal - $invhdr['discount_value']).'</td>
        </tr>';

    }
    echo '

    </table>
    </div>
    </td>
    </tr>
    
    </table>';
}
