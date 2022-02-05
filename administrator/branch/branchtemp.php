<?php
function template_receiver_items(){
    global $lang;
    echo '
    <script src="branch.js"></script>

    <div class="row">
    <div class="col-sm-8">
    <h3 class="header smaller lighter green">استلام قطع من المصنع</h3>

    <div id="itemList" style="min-height:300px; max-height:300px; width:100%; border:#ccc 1px solid;">
    <table id="scanner_data" style="float:left;" class="dataTable table table-striped table-bordered table-hover  " >
    <thead>
    <tr>
    <th>رقم الطلبية</th>
    <th>حالة الشغل</th>
    <th>طول</th>
    <th>عرض</th>
    <th>نوع الزجاج</th>
    <th>لون الزجاج</th>
    <!-- <th>الطباعة</th> -->
    <th>مسطح</th>
    <!-- <th>سنفرة</th> -->
    <th>التخليع</th>
    <th></th>
    </tr>
    </thead>

    <tbody>
    </tbody>
    
    </table>

    </div>
    </hr>
    <p style="text-align: center;
    padding: 10px;">
											<button class="btn btn-primary">استلام</button>
											<button class="btn btn-danger">حذف</button>
										</p>
    </div>

    <div class="col-sm-4">
    <h3 class="header smaller lighter green">اخر استلامات من المصنع</h3>

    <table id="scanner_data" style="float:left;" class="dataTable table table-striped table-bordered table-hover  " >
    <thead>
    <tr>
    <th>تاريخ الاستلام</th>
    <th>عدد القطع</th>
    </tr>
    </thead>

    <tbody>
    <tr>
    <td colspan="100%"  style="text-align:center;">لا توجد استلامات</td>
    </tr>
    </tbody>
    
    </table>


    </div>

    </div>
    ';
}

function template_deliver_items(){
    global $lang,$allacc;
    echo '
    
    <div class="row">
    <div class="col-sm-8">
    <h3 class="header smaller lighter green">
    تسليم قطع للعميل
    
    
    <select name="account_id" class="form-control chosen-select" style="float:left; max-width:100px;" >';


    for ($i = 0; $i < count($allacc); $i++) {
        echo '<option value="' . $allacc[$i]['account_id'] . '">' . $allacc[$i]['account_name'] . ' | ' . $allacc[$i]['account_company'] . ' | ' . $allacc[$i]['billingcode_name'].'</option>';
    }

    echo '</select>
    </h3>


    <div id="itemList" style="min-height:300px; max-height:300px; width:100%; border:#ccc 1px solid;">
    <table id="scanner_data" style="float:left;" class="dataTable table table-striped table-bordered table-hover  " >
    <thead>
    <tr>
    <th>رقم الطلبية</th>
    <th>حالة الشغل</th>
    <th>طول</th>
    <th>عرض</th>
    <th>نوع الزجاج</th>
    <th>لون الزجاج</th>
    <!-- <th>الطباعة</th> --> 
    <th>مسطح</th>
    <!-- <th>سنفرة</th> -->
    <th>التخليع</th>
    <th></th>
    </tr>
    </thead>

    <tbody>
    </tbody>
    
    </table>

    </div>
    </hr>
    <p style="text-align: center;
    padding: 10px;">
											<button class="btn btn-primary">استلام</button>
											<button class="btn btn-danger">حذف</button>
										</p>
    </div>

    <div class="col-sm-4">
    <h3 class="header smaller lighter green">اخر تسليمات العميل</h3>

    <table id="scanner_data" style="float:left;" class="dataTable table table-striped table-bordered table-hover  " >
    <thead>
    <tr>
    <th>تاريخ التسليم</th>
    <th>العميل</th>
    <th>عدد القطع</th>
    </tr>
    </thead>

    <tbody>
    <tr>
    <td colspan="100%"  style="text-align:center;">لا توجد استلامات</td>
    </tr>
    </tbody>
    
    </table>


    </div>

    </div>

    ';
}