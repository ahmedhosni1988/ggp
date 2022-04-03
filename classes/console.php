<?php
//class to mange console data and return values from database

class console
{

//var console_type;
    public $allow_total = "";
    public $db;
    public $nodata = "";
    public $page = 0;
    public $perpage = 0;
    public $pageCount = 0;
    public $search_txt = "";
    public $has_paging = 0;
    public $dba;

    public function __construct($type, $db)
    {
        $this->console_type = $type;
        $this->dba = $db;
        $this->set_db(($db));
        $this->perpage = 10;
        $this->page = 1;
        $this->has_paging = 1;
    }


    public function set_allowtotal($allow_total)
    {
        $this->allow_total = $allow_total;
    }

    public function set_db($db)
    {
        $this->db = $db->get_conn();
    }

    public function set_ND($nodata)
    {
        $this->nodata = $nodata;
    }
    public function set_has_paging($has_paging)
    {
        $this->has_paging = 0;
    }
    public function set_search($search_txt)
    {
        $this->search_txt = $search_txt;
    }

    public function get_search($search_txt)
    {
        return $this->search_txt;
    }
    public function set_page($page, $perpage)
    {
        $this->page = $page;
        $this->perpage = $perpage;
    }

    public function set_count($pageCount)
    {
        $this->pageCount = $pageCount;
    }
    public function get_count()
    {
        return $this->pageCount ;
    }

    public function get_perpage()
    {
        return $this->perpage ;
    }

    public function get_page()
    {
        return $this->page ;
    }

    public function get_pageNo()
    {
        $x = $this->pageCount / $this->perpage;

        if ($x < 1) {
            $x =1;
        } else {
            $x = ceil($x);
        }
        return $x;
    }

    ////
    public function get_coloums_header($col = "null", $so = "null", $item = "null")
    {
        $query = mysqli_query($this->db, "select c_d.other_table_name,c_d.name as name_def,c_d.status,c_d.Console_details,c_d.coloum_style,c_d.type,c_d.name,c_d.size,c_d.view_value,cd.display_".$_SESSION['language'].",cd.Fieldname,cd.table_name,cd.is_sortable as ordering,c_d.total,c_d.orders,c_d.type from consol_def as c_d inner join  columns_details as cd on (c_d.Console_details = cd.id ) where Console_id = '".$this->console_type."' order by c_d.orders ASC ") or die(mysqli_error($this->db));

        $coloums = array();


        while ($row = mysqli_fetch_array($query)) {
            if (!is_array($so) && $so != "null" && $item == $row['Fieldname']) {
                $sort = $so;
            } else {
                $sort = "";
            }

            if ($row['status'] == "0") {
                $coloums[] = array('coloum_header' => $row['display_' . $_SESSION['language']], 'name_def' => $row['name_def'], 'coloum_fieldname' => $row['Fieldname'], 'table_name' => $row['table_name'], 'type' => $row['type'], 'name' => $row['name'], 'size' => $row['size'], 'view_value' => $row['view_value'], 'coloum_style' => $row['coloum_style'], 'other_table_name' => $row['other_table_name'], 'ordering' => $row['ordering'], 'sort' => $sort, 'total' => $row['total']);
            }

            if ($row['status'] == "2") {
                $coloums[] = array('name_def' => $row['name_def'], 'coloum_fieldname' => $row['Fieldname'], 'table_name' => $row['table_name'], 'type' => $row['type'], 'name' => $row['name'], 'size' => $row['size'], 'view_value' => $row['view_value'], 'coloum_style' => $row['coloum_style'], 'other_table_name' => $row['other_table_name'], 'ordering' => $row['ordering'], 'sort' => $sort, 'total' => $row['total']);
            }
        }


        //for insert coloumsn manullay

        if ($col != "null" && is_array($col)) {
            for ($c = 0; $c < count($col); $c++) {
                if (isset($col[$c]['pos']) && $col[$c]['pos'] == "first") {
                    $fun = "";
                    if (isset($col[$c]['function'])) {
                        $fun = $col[$c]['function'];
                    }

                    $coloum_fieldname = "";
                    if (isset($col[$c]['coloum_fieldname'])) {
                        $coloum_fieldname = $col[$c]['coloum_fieldname'];
                    }

                    array_unshift($coloums, array('coloum_header' => $col[$c]['headername'], 'coloum_fieldname' => $coloum_fieldname, 'function' => $fun, 'table_name' => '', 'width' => $col[$c]['width'], 'class' => $col[$c]['class']));
                }

                if (isset($col[$c]['pos']) && $col[$c]['pos'] == "last") {
                    $coloums[] = array('coloum_header' => $col[$c]['headername'], 'coloum_fieldname' => $col[$c]['coloum_fieldname'], 'function' => $col[$c]['function'], 'table_name' => '', 'width' => $col[$c]['width'], 'class' => $col[$c]['class']);
                }
            }
        }
        //var_dump($coloums);
        return $coloums;
    }
    ////get header form database allowed by user
    /////////////////////////////////////////////////////////
    ///get data for order according to header
    public function get_coloums_data($header, $sql)
    {
        //echo $sql;
        if ($this->has_paging == 1) {
            $csql = substr($sql, strpos($sql, " from "), strlen($sql));
            $countsql = "select count(*) as num ".$csql;
    
            $cq = mysqli_query($this->db, $countsql) or die(mysqli_error($this->db));
            $cr = mysqli_fetch_assoc($cq);
            $this->set_count($cr['num']);
            //echo $countsql;
    
            $selected = "";
            $coloums_data = array();
            $sql = $sql." Limit ".(($this->page - 1) * $this->perpage)." , ".$this->perpage." ";
        }

        //   echo $sql;

        $selected = "";
        $coloums_data = array();


        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        $request_array = "";


        $request_array = substr_replace($request_array, "", -1);

        $y = 0;
        while ($row = mysqli_fetch_array($query)) {
            for ($x = 0; $x < count($header); $x++) {
                if ($header[$x]['table_name'] == '') {
                    $header[$x]['coloum_fieldname'] = $header[$x]['view_value'];
                }

                if (isset($row[$header[$x]['coloum_fieldname']])) {
                    $coloums_data[$y][$x] = array($header[$x]['coloum_fieldname'] => $row[$header[$x]['coloum_fieldname']]);
                } else {
                    $coloums_data[$y][$x] = array($header[$x]['coloum_header'] => '');
                }
            }
            $y++;
        }
        //$row = mysqli_fetch_array($query);
        return $coloums_data;
    }

    public function get_coloums_data_sql($header, $after_from)
    {
        $selected = "";
        $coloums_data = array();

        for ($i = 0; $i < count($header); $i++) {
            if (isset($header[$i]['table_name']) && $header[$i]['coloum_fieldname']) {
                $selected .= $header[$i]['table_name'] . "." . $header[$i]['coloum_fieldname'] . " , ";
            }
        }

        $sql = "select " . substr($selected, 0, strlen($selected) - 2) . " from " . $after_from;

        $query = mysqli_query($this->db, $sql) or die($sql);

        $request_array = "";


        $request_array = substr_replace($request_array, "", -1);

        $y = 0;
        while ($row = mysqli_fetch_array($query)) {
            for ($x = 0; $x < count($header); $x++) {
                $coloums_data[$y][$x] = array($header[$x]['coloum_header'] => $row[$header[$x]['coloum_fieldname']]);
            }
            $y++;
        }
        //$row = mysqli_fetch_array($query);
        return $coloums_data;
    }

    //get query to buld grid
    public function get_grid_sql($header, $after_from)
    {
        $selected = "";
        $coloums_data = array();

        for ($i = 0; $i < count($header); $i++) {
            if ($header[$i]['table_name'] != '' && $header[$i]['coloum_fieldname'] != '') {
                $selected .= $header[$i]['table_name'] . "." . $header[$i]['coloum_fieldname'] . " , ";
            } elseif ($header[$i]['table_name'] == '' && $header[$i]['coloum_fieldname'] != '') {
                $selected .= $header[$i]['coloum_fieldname'] . " , ";
            }
        }

        $sql = "select " . substr($selected, 0, strlen($selected) - 2) . " from " . $after_from;


        return $sql;
    }

    public function build_grid_search($header, $searchtxt)
    {
        $selected = "";
        $coloums_data = array();

        $this->set_search($searchtxt);
    
        // for ($i=0;$i<count($header);$i++) {
        //     if ($header[$i]['table_name'] != '' && $header[$i]['coloum_fieldname'] != '') {
        //         $selected .=  "ifnull(".$header[$i]['table_name'].".".$header[$i]['coloum_fieldname'].",'') , ";
        //     } elseif ($header[$i]['table_name'] == '' && $header[$i]['coloum_fieldname'] != '' && !isset($header[$i]['man'])) {
        //         $selected .= "ifnull(".$header[$i]['coloum_fieldname'].",'') , ";
        //     }
        // }
    
        
        for ($i=0;$i<count($header);$i++) {
            if ($header[$i]['table_name'] != '' && $header[$i]['coloum_fieldname'] != '' && $header[$i]['view_value'] == '') {
                $selected .=  "ifnull(".$header[$i]['table_name'].".".$header[$i]['coloum_fieldname'].",'') , ";
            } elseif ($header[$i]['table_name'] == '' && $header[$i]['coloum_fieldname'] != '' && !isset($header[$i]['man'])  && $header[$i]['view_value'] == '') {
                // $selected .= "ifnull(".$header[$i]['coloum_fieldname'].",'') , ";
            }
        }
    

        $sql = "concat(". substr($selected, 0, strlen($selected)-2) .") like '%".$searchtxt."%' and ";
    
    
        return $sql;
    }


    public function search_row_array($array, $key1)
    {
        for ($t = 0; $t < count($array); $t++) {
            foreach ($array[$t] as $key => $value) {
                if ($key == $key1) {
                    return $value;
                }
            }
        }
    }

    public function build_grid($coloum, $coulum_attribute, $rows, $rows_attribute, $table_id= "null", $data = null, $des="")
    {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        $actual_link = $protocol.$_SERVER['HTTP_HOST'].(strpos($_SERVER['REQUEST_URI'], '.php') ? $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'], '?') !== false ? '&' : '?').'ajax=1&pageno=' : $_SERVER['REQUEST_URI'].'index.php?&ajax=1&pageno=');

        $header = "";
        if ($des != "") {
            $header .= '<div class="table-header"><span class="bold">'.$des.'</span> '.count($rows).'</div>';
        }

        $header .= '

<table border="1" style="font-weight:bold; font-size:10px; " class="dataTable table table-bordered   " '.($table_id != "null" ? 'id="'.$table_id.'"' : '').' style=" border-collapse: collapse;">
<thead class="go">';

        //var_dump($coloum);
        for ($i=0;$i<count($coloum);$i++) {
            if (isset($coloum[$i]['coloum_header'])) {
                if ($coloum[$i]['sort']  != '') {
                    $class= "sorting_".$coloum[$i]['sort'];
                    $dir = $coloum[$i]['sort'];
                } else {
                    $dir = '';
                    $class = "sorting";
                }
    
                $header .= '<th '.($coloum[$i]['ordering'] == '1' ? 'class="'.$class.'" onclick="make_console_grid_sort('.htmlspecialchars(json_encode($coloum[$i])).',\''.$dir.'\')"' : '').'  '.(isset($coloum[$i]['coloum_style']) ? $coloum[$i]['coloum_style'] : '').' class="'.(isset($coloum[$i]['class']) ? $coloum[$i]['class'] : '').'" coloum_name="'.$coloum[$i]['coloum_fieldname'].'" '.(isset($coloum[$i]['onclick']) && $coloum[$i]['onclick'] != '' ? 'onclick="'.$coloum[$i]['onclick'].'"' : '').' >'.$coloum[$i]['coloum_header'].'</th>';

                $totals[$coloum[$i]['coloum_header']] = "";
            }
        }

        $header .= "</thead>";
        if (count($rows) > 0) {
            for ($r=0;$r<count($rows);$r++) {
                $ro = $rows[$r];
                //var_dump($ro);

                if (is_array($rows_attribute) && count($rows_attribute) >0) {
                    $header .= '<tr ';
                    foreach ($rows_attribute as $key => $value) {
                        $v = explode('__', $value);


                        if (count($v) ==  1) {
                            $header .= ' '.$key.' = '.$value.' ';
                        } else {
                            $header .= ' '.$key.' = '.$v[0].'__'.$this->search_row_array($ro, $v[1]).' ';
                        }
                    }


                    $header .= ' >';
                } else {
                    $header .='<tr>';
                }


                //  print_r($ro);

                for ($t=0;$t<count($ro);$t++) {
                    $rov = $ro[$t];

                    foreach ($rov as $key => $value) {

                     //   $myJsonrow = json_encode($rov);

                        if (isset($coloum[$t]['coloum_header'])) {
                            if (isset($coloum[$t]['type']) && $coloum[$t]['type'] != '') {
                                if ($coloum[$t]['type'] == "text") {
                                    $header .= '<td><input type="'.$coloum[$t]['type'].'" name="'.$coloum[$t]['name'].'" value="'.$value.'" size="'.$coloum[$t]['size'].'" /></td>';
                                }
                                if ($coloum[$t]['type'] == "href") {
                                    $header .= '<td><a onclick="'.$coloum[$t]['name'].'('.htmlspecialchars(json_encode($ro)).')" />'.$value.' '.(isset($ro[5]['over_due']) && $coloum[$t]['name'] == 'show_account_form' && $ro[5]['over_due'] == '1' ? '<span class="badge badge-transparent tooltip-error" title="" data-original-title="Account Over Due"><i class="ace-icon fa fa-exclamation-triangle red bigger-130"></i></span>' : '').'</a></td>';
                                }
                                if ($coloum[$t]['type'] == "image") {
                                    $header .= '<td><img '.$coloum[$t]['coloum_style'].' src="'.SITEURL.'/'.($value == '' ? $coloum[$t]['name'] : $value).'"    /></td>';
                                }
                                if ($coloum[$t]['type'] == "checkbox") {
                                    $header .= '<td><input type="'.$coloum[$t]['type'].'" name="'.$coloum[$t]['name'].'['.$value.']" value="'.$value.'"  /></td>';
                                }
                                if ($coloum[$t]['type'] == "date") {
                                    if ($value == '' || $value == '0000-00-00 00:00:00') {
                                        $header .= '<td></td>';
                                    } else {
                                        $datec = date(DATETIME_FORMAT, strtotime($value));
                                        $datec = str_replace('00:00:00', '', $datec);
                                        $header .= '<td>'.$datec.'</td>';
                                    }
                                }
                                if ($coloum[$t]['type'] == "order_price") {
                                    $op = mysqli_query($this->db, "select * from orders_price where order_id = '".$ro[0]['order_id']."' and type in (".$coloum[$t]['name'].") ") or die(mysqli_error($this->db));
                                    $price = 0;
                                    while ($ops = mysqli_fetch_array($op)) {
                                        if ($ops['override'] != '') {
                                            $price += $ops['override'];
                                        } else {
                                            $price +=  $ops['price'];
                                        }
                                    }
                                    $header .= '<td>'.$price.'</td>';

                                    if (is_numeric($price)  && $coloum[$t]['total'] == "1") {
                                        $totals[$coloum[$t]['coloum_header']] += $price;
                                    }
                                }
                                if ($coloum[$t]['type'] == "driver_price") {
                                    //print_r($ro);
                                    if (isset($data['driver_id'])) {
                                        $newsql = " orders_driver_commission.driver_id = '".$data['driver_id']."' and ";
                                    }
                                    $op = mysqli_query($this->db, "select * from orders_driver_commission  where $newsql  orders_driver_commission.order_id = '".$ro[0]['order_id']."'    and commission_name in (".$coloum[$t]['name'].")  ") or die(mysqli_error($this->db)."x");
                                    $price = 0;
                                    while ($ops = mysqli_fetch_array($op)) {
                                        if ($ops['commission_override'] != ''  && $ops['commission_override'] > 0) {
                                            $price += $ops['commission_override'];
                                        } else {
                                            $price +=  $ops['commission_value'];
                                        }
                                    }
                                    $header .= '<td><a onclick="edit_driver_price(\''.$ro[0]['order_id'].'\' , \''.$data['driver_id'].'\',$(this))" >'.$price.'</a></td>';
                                    if (is_numeric($price) && $coloum[$t]['total'] == "1") {
                                        $totals[$coloum[$t]['coloum_header']] += $price;
                                    }
                                }
                                if ($coloum[$t]['type'] == "edit_row") {
                                    $header .= '<td >
<div class="edit_row" style="display:none;">
<a onclick="save_row(this,\''.$v[0].'__'.$this->search_row_array($ro, $v[1]).'\',\''.$table_id.'\');" >Save</a>
<a onclick="cancel_edit_row(\''.$v[0].'__'.$this->search_row_array($ro, $v[1]).'\',\''.$table_id.'\');" >Cancel<a>
</div>
</td>';
                                }

                                if ($coloum[$t]['type'] == "combo") {
                                    if ($coloum[$t]['other_table_name'] == "account") {
                                        $sarray = $this->dba->get_table("account");
                                    }
                                    if ($coloum[$t]['other_table_name'] == "drivers") {
                                        $sarray = $this->dba->get_table("drivers where active = 'Y'");
                                    }
                                    if ($coloum[$t]['other_table_name'] == "services") {
                                        $sarray = $_SESSION['services_table'];
                                    }
                                    if ($coloum[$t]['other_table_name'] == "status") {
                                        $sarray = $_SESSION['status_table'];
                                    }
                                    $header .= '<td>
 <select name="'.$coloum[$t]['table_name'].'__'.$coloum[$t]['coloum_fieldname'].'"  style="width:'.$coloum[$t]['size'].'px" >
 <option value="">Choose '.$coloum[$t]['table_name'].'</option>';
                                    for ($s=0;$s<count($sarray);$s++) {
                                        $tvalues = explode(',', $coloum[$t]['view_value']);
                                        $viewvalue = "";
                                        for ($ts=0 ;$ts<count($tvalues);$ts++) {
                                            $viewvalue .= $sarray[$s][$tvalues[$ts]].' | ';
                                        }
                                        $viewvalue = substr($viewvalue, 0, strlen($viewvalue)-2);
                                        $header .= '<option value = "'.$sarray[$s][$coloum[$t]['name']].'" '.($sarray[$s][$coloum[$t]['name']] == $value ? 'selected' : '').'>'.$viewvalue.'</option>';
                                    }
                                    $header .= '</select>
 </td>';
                                }
                                if ($coloum[$t]['type'] == "user_type") {
                                    if ($value == 'administrator') {
                                        $vv = "مدير نظام";
                                    }
                                    if ($value == 'manger') {
                                        $vv = "متابعة مصنع";
                                    }
                                    if ($value == 'accounting') {
                                        $vv = "محاسب";
                                    }
                                    if ($value == 'addmanger') {
                                        $vv = "اضافة متابعة";
                                    }
                                    if ($value == 'manmanger') {
                                        $vv = "مدير متابعة";
                                    }
                                    if ($value == '2') {
                                        $vv = "تقطيع";
                                    }
                                    if ($value == '3') {
                                        $vv = "شطف ";
                                    }
                                    if ($value == '4') {
                                        $vv = "فرن";
                                    }
                                    if ($value == '5') {
                                        $vv = "توريد";
                                    }
                                    if ($value == '7') {
                                        $vv = "تشطيب";
                                    }
                                    
                                    $header .= '<td>' . $vv . '</td>';
                                }
                                    
                                if ($coloum[$t]['type'] == "lookup_table") {
                                    $query = mysqli_query($this->db, "select " . $coloum[$t]['view_value'] . " from " . $coloum[$t]['other_table_name'] . " where " . $coloum[$t]['name'] . " = '" . $value . "' ");
                                    
                                    if (mysqli_num_rows($query) == "1") {
                                        $rr = mysqli_fetch_array($query);
                                    
                                        $header .= '<td>' . $rr[$coloum[$t]['view_value']] . '</td>';
                                    } else {
                                        $header .= '<td>لا يوجد</td>';
                                    }
                                }
                                    
                                if ($coloum[$t]['type'] == "order_status") {
                                    if ($value == '0') {
                                        $vv = "<span class=\"label label-danger \">طلبية جديدة</span>";
                                    }
                                    if ($value == '1') {
                                        $vv = "<span class=\"label label-warning \">قيد التشغيل</span>";
                                    }
                                    if ($value == '2') {
                                        $vv = "<span class=\"label label-info \">تم الانتهاء وجارى التسليم</span>";
                                    }
                                    if ($value == '3') {
                                        $vv = "<span class=\"label label-success \">تم التسليم</span>";
                                    }
                                    
                                    if ($value == '4') {
                                        $vv = "<span class=\"label label-success \">تم ايقاف الطلبية</span>";
                                    }
                                    
                                    $header .= '<td  >' . $vv . '</td>';
                                }
                            } elseif (isset($coloum[$t]['function']) && $coloum[$t]['function'] != '') {
                                $fun = $coloum[$t]['function'];
                                $header .= '<td '.(isset($coloum[$t]['width']) ? 'style="width:'.$coloum[$t]['width'].'"' : '').'>'.$fun($ro).'</td>';
                            } else {
                                $header .= '<td>'.$value.'</td>';
                                if (is_numeric($totals[$coloum[$t]['coloum_header']])  && $coloum[$t]['total'] == "1") {
                                    $totals[$coloum[$t]['coloum_header']] += $value;
                                }
                            }
                        }

                        $value = '';
                    }
                    ////end for each
                }
                $header .='</tr>';
            }
        } else {
            if ($this->nodata == "") {
                $header .=  '<tr>
<td colspan="'.count($coloum).'" align="center"  >No Data To display</td>
</tr>';
            }
        }

        if (count($totals) > 0 && $this->allow_total == "") {
            $header .= '<tr>';
    
            foreach ($totals as $x=>$y) {
                $header .= '<td>'.$y.'</td>';
                $y=0;
            }
    
            $header .= '</tr>';
        }

       
        if ($this->has_paging == 1) {
            $header .= "
<tfoot>
<tr><td colspan=\"100%\" class=\"gridfooter\">
";


            //$next_link = $actual_link.($this->get_page()+1);

            //$prev_link = $actual_link.();

            $header .= '<table cellspacing="0" cellpadding="0" border="0" class="ui-pg-table" style="width:100%;table-layout:fixed;height:100%; " role="row">
<tbody>
<tr>
<td id="grid-pager_left" align="left">

</td>
<td id="grid-pager_center" align="center" style="text-align: center;">
<table cellspacing="0" cellpadding="0" border="0" style="table-layout:auto; margin: 10px;" class="ui-pg-table">
<tbody>
<tr>
<td id="first_grid-pager" class="ui-pg-button ui-corner-all '.($this->get_page() > 1 ? '' : 'ui-state-disabled').'" onclick="previos_page(2,\''.$actual_link.'\')" style="cursor: default;">
<span class="ui-icon ace-icon fa fa-angle-double-left bigger-140"></span>
</td>
<td id="prev_grid-pager" class="ui-pg-button ui-corner-all '.($this->get_page() > 1 ? '' : 'ui-state-disabled').'" onclick="previos_page('.$this->get_page().',\''.$actual_link.'\')" style="cursor: default;">
<span class="ui-icon ace-icon fa fa-angle-left bigger-140"></span>
</td>
<td class="ui-pg-button ui-state-disabled" style="width: 4px; cursor: default;">
<span class="ui-separator"></span></td><td dir="ltr">Page '.$this->get_page().' of <span id="sp_1_grid-pager">'.($this->get_pageNo()).'</span>
</td>
<td class="ui-pg-button ui-state-disabled" style="width: 4px; cursor: default;" >
<span class="ui-separator"></span></td>
<td id="next_grid-pager" class="ui-pg-button ui-corner-all '.($this->get_page() == $this->get_pageNo()  ? 'ui-state-disabled' : '').'" onclick="next_page('.$this->get_page().',\''.$actual_link.'\')" style="cursor: pointer;"><span class="ui-icon ace-icon fa fa-angle-right bigger-140"></span></td>
<td id="last_grid-pager" class="ui-pg-button ui-corner-all '.($this->get_page() == $this->get_pageNo()  ? 'ui-state-disabled' : '').'" onclick="next_page('.($this->get_pageNo() - 1).',\''.$actual_link.'\')" >
<span class="ui-icon ace-icon fa fa-angle-double-right bigger-140"></span>
</td>

<td>
</td>
</tr>
</tbody>
</table>
</td>

<td id="grid-pager_right" align="right">
<div dir="ltr" style="text-align:right; margin-right: 10px;" class="ui-paging-info">View '.(($this->page * $this->perpage) - $this->perpage + 1).' - '.(($this->page * $this->perpage) >= $this->get_count() ? $this->get_count() :  ($this->page * $this->perpage)).' of '.$this->get_count().'</div>
</td>
</tr>
</tbody>
</table>';

            $header .= "</td></tr>
</tfoot>";
        } else {
            $header .= '<tr>
        <td colspan="100%">Number of Rows : '.count($rows).'</td>
        </tr>';
        }
        //var_dump($totals);

        $header .= "</table>";

        return $header;
    }


//     public function build_grid($coloum, $coulum_attribute, $rows, $rows_attribute, $table_id = "null")
//     {
//         $header='';

//         $header = '<table border="1" style="font-weight:bold; font-size:10px; width:auto;min-width: 100%;" class="dataTable table  table-bordered   " ' . ($table_id != "null" ? 'id="' . $table_id . '"' : '') . ' style=" border-collapse: collapse;">
    // <thead class="go">';
//         //var_dump($coloum);
//         for ($i = 0; $i < count($coloum); $i++) {
//             if (isset($coloum[$i]['coloum_header'])) {

    // // 	if($coloum[$i]['sort']  != '' ){
//                 // 		$class= "sorting_".$coloum[$i]['sort'];
//                 // 		$dir = $coloum[$i]['sort'];
//                 // 	}
//                 // 	else {
//                 // 		$dir = '';
//                 // 		$class = "sorting";
//                 // 	}

//                 $header .= '<th   ' . $coloum[$i]['coloum_style'] . ' class="' . $coloum[$i]['class'] . '" coloum_name=' . $coloum[$i]['coloum_fieldname'] . ' >' . $coloum[$i]['coloum_header'] . '</th>';

//                 $totals[$coloum[$i]['coloum_header']] = "";
//             }
//         }

//         $header .= "</thead>";
//         if (count($rows) > 0) {
//             for ($r = 0; $r < count($rows); $r++) {
//                 $ro = $rows[$r];
//                 //var_dump($ro);

//                 if (is_array($rows_attribute) && count($rows_attribute) > 0) {
//                     $header .= '<tr ';
//                     foreach ($rows_attribute as $key => $value) {
//                         $v = explode('__', $value);


//                         if (count($v) == 1) {
//                             $header .= ' ' . $key . ' = ' . $value . ' ';
//                         } else {
//                             $header .= ' ' . $key . ' = ' . $v[0] . '__' . $this->search_row_array($ro, $v[1]) . ' ';
//                         }
//                     }


//                     $header .= ' >';
//                 } else {
//                     $header .= '<tr>';
//                 }


//                 //print_r($ro);

//                 for ($t = 0; $t < count($ro); $t++) {
//                     $rov = $ro[$t];

//                     foreach ($rov as $key => $value) {
//                         if (isset($coloum[$t]['coloum_header'])) {
//                             if (isset($coloum[$t]['type']) && $coloum[$t]['type'] != '') {
//                                 if ($coloum[$t]['type'] == "text") {
//                                     $header .= '<td><input type="' . $coloum[$t]['type'] . '" name="' . $coloum[$t]['name'] . '" value="' . $value . '" size="' . $coloum[$t]['size'] . '" /></td>';
//                                 }
//                                 if ($coloum[$t]['type'] == "href") {
//                                     $header .= '<td><a onclick="' . $coloum[$t]['name'] . '(' . htmlspecialchars(json_encode($ro)) . ')" />' . $value . '</a></td>';
//                                 }
//                                 if ($coloum[$t]['type'] == "image") {
//                                     $header .= '<td><img ' . $coloum[$t]['coloum_style'] . ' src="' . SITEURL . '/' . $coloum[$t]['view_value'] . ($value == '' ? $coloum[$t]['name'] : $value) . '"    /></td>';
//                                 }
//                                 if ($coloum[$t]['type'] == "checkbox") {
//                                     $header .= '<td><input type="' . $coloum[$t]['type'] . '" name="' . $coloum[$t]['name'] . '[' . $value . ']" value="' . $value . '"  /></td>';
//                                 }
//                                 if ($coloum[$t]['type'] == "date") {
//                                     $header .= '<td>' . date($coloum[$t]['name'], strtotime($value)) . '</td>';
//                                 }
//                                 if ($coloum[$t]['type'] == "order_price") {
//                                     $op = mysqli_query($this->db,"select * from orders_price where order_id = '" . $ro[0]['order_id'] . "' and type in (" . $coloum[$t]['name'] . ") ") or die(mysqli_error($this->db));
//                                     $price = 0;
//                                     while ($ops = mysqli_fetch_array($op)) {
//                                         if ($ops['override'] != '') {
//                                             $price += $ops['override'];
//                                         } else {
//                                             $price += $ops['price'];
//                                         }
//                                     }
//                                     $header .= '<td>' . $price . '</td>';

//                                     if (is_numeric($price) && $coloum[$t]['total'] == "1") {
//                                         $totals[$coloum[$t]['coloum_header']] += $price;
//                                     }
//                                 }

//                                 if ($coloum[$t]['type'] == "edit_row") {
//                                     $header .= '<td >
    // <div class="edit_row" style="display:none;">
    // <a onclick="save_row(this,\'' . $v[0] . '__' . $this->search_row_array($ro, $v[1]) . '\',\'' . $table_id . '\');" >Save</a>
    // <a onclick="cancel_edit_row(\'' . $v[0] . '__' . $this->search_row_array($ro, $v[1]) . '\',\'' . $table_id . '\');" >Cancel<a>
    // </div>
    // </td>';
//                                 }

//                                 if ($coloum[$t]['type'] == "combo") {
//                                     if ($coloum[$t]['other_table_name'] == "account") {
//                                         $sarray = $this->db->get_table("account");
//                                     }
//                                     if ($coloum[$t]['other_table_name'] == "drivers") {
//                                         $sarray = $db->get_table("drivers where active = 'Y'");
//                                     }
//                                     if ($coloum[$t]['other_table_name'] == "services") {
//                                         $sarray = $_SESSION['services_table'];
//                                     }
//                                     if ($coloum[$t]['other_table_name'] == "status") {
//                                         $sarray = $_SESSION['status_table'];
//                                     }
//                                     $header .= '<td>
    //  <select name="' . $coloum[$t]['table_name'] . '__' . $coloum[$t]['coloum_fieldname'] . '"  style="width:' . $coloum[$t]['size'] . 'px" >
    //  <option value="">Choose ' . $coloum[$t]['table_name'] . '</option>';
//                                     for ($s = 0; $s < count($sarray); $s++) {
//                                         $tvalues = explode(',', $coloum[$t]['view_value']);
//                                         $viewvalue = "";
//                                         for ($ts = 0; $ts < count($tvalues); $ts++) {
//                                             $viewvalue .= $sarray[$s][$tvalues[$ts]] . ' | ';
//                                         }
//                                         $viewvalue = substr($viewvalue, 0, strlen($viewvalue) - 2);
//                                         $header .= '<option value = "' . $sarray[$s][$coloum[$t]['name']] . '" ' . ($sarray[$s][$coloum[$t]['name']] == $value ? 'selected' : '') . '>' . $viewvalue . '</option>';
//                                     }
//                                     $header .= '</select>
    //  </td>';
//                                 }

//                                 if ($coloum[$t]['type'] == "user_type") {
//                                     if ($value == 'administrator') {
//                                         $vv = "مدير نظام";
//                                     }
//                                     if ($value == 'manger') {
//                                         $vv = "متابعة مصنع";
//                                     }
//                                     if ($value == 'accounting') {
//                                         $vv = "محاسب";
//                                     }
//                                     if ($value == 'addmanger') {
//                                         $vv = "اضافة متابعة";
//                                     }
//                                     if ($value == 'manmanger') {
//                                         $vv = "مدير متابعة";
//                                     }
//                                     if ($value == '2') {
//                                         $vv = "تقطيع";
//                                     }
//                                     if ($value == '3') {
//                                         $vv = "شطف ";
//                                     }
//                                     if ($value == '4') {
//                                         $vv = "فرن";
//                                     }
//                                     if ($value == '5') {
//                                         $vv = "توريد";
//                                     }
//                                     if ($value == '7') {
//                                         $vv = "تشطيب";
//                                     }

//                                     $header .= '<td>' . $vv . '</td>';
//                                 }

//                                 if ($coloum[$t]['type'] == "lookup_table") {
//                                     $query = mysqli_query($this->db,"select " . $coloum[$t]['view_value'] . " from " . $coloum[$t]['other_table_name'] . " where " . $coloum[$t]['name'] . " = '" . $value . "' ");

//                                     if (mysqli_num_rows($query) == "1") {
//                                         $rr = mysqli_fetch_array($query);

//                                         $header .= '<td>' . $rr[$coloum[$t]['view_value']] . '</td>';
//                                     } else {
//                                         $header .= '<td>لا يوجد</td>';
//                                     }
//                                 }

//                                 if ($coloum[$t]['type'] == "order_status") {
//                                     if ($value == '0') {
//                                         $vv = "<span class=\"label label-danger \">طلبية جديدة</span>";
//                                     }
//                                     if ($value == '1') {
//                                         $vv = "<span class=\"label label-warning \">قيد التشغيل</span>";
//                                     }
//                                     if ($value == '2') {
//                                         $vv = "<span class=\"label label-info \">تم الانتهاء وجارى التسليم</span>";
//                                     }
//                                     if ($value == '3') {
//                                         $vv = "<span class=\"label label-success \">تم التسليم</span>";
//                                     }

//                                     if ($value == '4') {
//                                         $vv = "<span class=\"label label-success \">تم ايقاف الطلبية</span>";
//                                     }

//                                     $header .= '<td  >' . $vv . '</td>';
//                                 }
//                             } elseif (isset($coloum[$t]['function']) && $coloum[$t]['function'] != '') {
//                                 $fun = $coloum[$t]['function'];
//                                 $header .= '<td ' . (isset($coloum[$t]['width']) ? 'style="width:' . $coloum[$t]['width'] . '"' : '') . '>' . $fun($ro) . '</td>';
//                             } else {
//                                 $header .= '<td>' . $value . '</td>';
//                                 if (is_numeric($value) && $coloum[$t]['total'] == "1") {
//                                     $totals[$coloum[$t]['coloum_header']] += $value;
//                                 }
//                             }
//                         }

//                         $value = '';
//                     }
//                     ////end for each
//                 }
//                 $header .= '</tr>';
//             }
//         } else {
//             if ($this->nodata == "") {
//                 $header .= '<tr>
    // <td colspan="' . count($coloum) . '" align="center"  >No Data To display</td>
    // </tr>';
//             }
//         }

//         if (count($totals) > 0 && $this->allow_total == "") {
//             $header .= '<tr>';

//             foreach ($totals as $x => $y) {
//                 $header .= '<td>' . $y . '</td>';
//                 $y = 0;
//             }

//             $header .= '</tr>';
//         }
//         // $header .= '<tr>
//         // <td colspan="100%">Number of Rows : '.count($rows).'</td>
//         // </tr>';
//         $header .= "</table></div>
    // ";

//         return $header;
//     }


    public function build_grid_data($coloum, $coulum_attribute, $rows, $rows_attribute, $table_id = "null")
    {
        $data = array();


        for ($i = 0; $i < count($coloum); $i++) {
            if (isset($coloum[$i]['coloum_header'])) {
                if ($coloum[$i]['sort'] != '') {
                    $class = "sorting_" . $coloum[$i]['sort'];
                    $dir = $coloum[$i]['sort'];
                } else {
                    $dir = '';
                    $class = "sorting";
                }


                $data[0][] = $coloum[$i]['coloum_header'];

                $totals[$coloum[$i]['coloum_header']] = "";
            }
        }


        if (count($rows) > 0) {
            for ($r = 0; $r < count($rows); $r++) {
                $ro = $rows[$r];


                for ($t = 0; $t < count($ro); $t++) {
                    $rov = $ro[$t];

                    foreach ($rov as $key => $value) {
                        if (isset($coloum[$t]['coloum_header'])) {
                            if (isset($coloum[$t]['type']) && $coloum[$t]['type'] != '') {
                                if ($coloum[$t]['type'] == "text") {
                                    $data[$r + 1][] = $value;
                                }
                                if ($coloum[$t]['type'] == "href") {
                                    $data[$r + 1][] = $value;
                                }
                                if ($coloum[$t]['type'] == "checkbox") {
                                    $data[$r + 1][] = $value;
                                }
                                if ($coloum[$t]['type'] == "date") {
                                    $data[$r + 1][] = date($coloum[$t]['name'], strtotime($value));
                                }
                                if ($coloum[$t]['type'] == "order_price") {
                                    $op = mysqli_query($this->db, "select * from orders_price where order_id = '" . $ro[0]['order_id'] . "' and type in (" . $coloum[$t]['name'] . ") ") or die(mysqli_error($this->db));
                                    $price = 0;
                                    while ($ops = mysqli_fetch_array($op)) {
                                        if ($ops['override'] != '') {
                                            $price += $ops['override'];
                                        } else {
                                            $price += $ops['price'];
                                        }
                                    }
                                    $data[$r + 1][] = $price;

                                    if (is_numeric($price) && $coloum[$t]['total'] == "1") {
                                        $totals[$coloum[$t]['coloum_header']] += $price;
                                    }
                                }
                                if ($coloum[$t]['type'] == "driver_price") {
                                    $op = mysqli_query($this->db, "select * from orders_driver_commission where order_id = '" . $ro[0]['order_id'] . "' and commission_name in (" . $coloum[$t]['name'] . ")  ") or die(mysqli_error($this->db) . "x");
                                    $price = 0;
                                    while ($ops = mysqli_fetch_array($op)) {
                                        if ($ops['commission_override'] != '' && $ops['commission_override'] > 0) {
                                            $price += $ops['commission_override'];
                                        } else {
                                            $price += $ops['commission_value'];
                                        }
                                    }
                                    $data[$r + 1][] = $price;
                                    if (is_numeric($price) && $coloum[$t]['total'] == "1") {
                                        $totals[$coloum[$t]['coloum_header']] += $price;
                                    }
                                }
                                if ($coloum[$t]['type'] == "edit_row") {
                                    $data[$r + 1][] = "";
                                }

                                if ($coloum[$t]['type'] == "combo") {
                                    if ($coloum[$t]['other_table_name'] == "account") {
                                        $sarray = $this->db->get_table("account");
                                    }
                                    if ($coloum[$t]['other_table_name'] == "drivers") {
                                        $sarray = $db->get_table("drivers where active = 'Y'");
                                    }
                                    if ($coloum[$t]['other_table_name'] == "services") {
                                        $sarray = $_SESSION['services_table'];
                                    }
                                    if ($coloum[$t]['other_table_name'] == "status") {
                                        $sarray = $_SESSION['status_table'];
                                    }


                                    for ($s = 0; $s < count($sarray); $s++) {
                                        $tvalues = explode(',', $coloum[$t]['view_value']);
                                        $viewvalue = "";
                                        for ($ts = 0; $ts < count($tvalues); $ts++) {
                                            $viewvalue .= $sarray[$s][$tvalues[$ts]] . ' | ';
                                        }
                                        $viewvalue = substr($viewvalue, 0, strlen($viewvalue) - 2);
                                        $data[$r + 1][] = $viewvalue;
                                    }
                                }
                            } elseif (isset($coloum[$t]['function']) && $coloum[$t]['function'] != '') {
                                $fun = $coloum[$t]['function'];
                                $data[$r + 1][] = $fun($ro);
                            } else {
                                $data[$r + 1][] = $value;

                                if (is_numeric($value) && $coloum[$t]['total'] == "1") {
                                    $totals[$coloum[$t]['coloum_header']] += $value;
                                }
                            }
                        }
                    }
                    ////end for each
                }
            }
        } else {
            $header .= '<tr>
<td colspan="' . count($coloum) . '" align="center">No Data To display</td>
</tr>';
        }

        if (count($totals) > 0) {
            foreach ($totals as $x => $y) {
                $data[$r + 1][] = $y;
                $y = 0;
            }
        }

        //var_dump($totals);
        return $data;
    }


    public function build_input_grid($coloum, $coulum_attribute, $rows, $rows_attribute, $table_id = "null", $row_no, $default_input, $post_input)
    {
        $header = '<table class="table table-striped table-bordered table-hover " ' . ($table_id != "null" ? 'id="' . $table_id . '"' : '') . ' style=" border-collapse: collapse;">
<thead class="go">';

        for ($i = 0; $i < count($coloum); $i++) {
            $header .= '<th ' . ($coloum[$i]['coloum_style'] != '' ? $coloum[$i]['coloum_style'] : '') . '>' . $coloum[$i]['coloum_header'] . '</th>';
        }

        $header .= "</thead>";
        if (count($row_no) > 0) {
            for ($r = 0; $r < $row_no; $r++) {
                $ro = $rows[$r];
                //var_dump($ro);

                if (is_array($rows_attribute) && count($rows_attribute) > 0) {
                    $header .= '<tr ';
                    foreach ($rows_attribute as $key => $value) {
                        $v = explode('__', $value);


                        if (count($v) == 1) {
                            $header .= ' ' . $key . ' = ' . $value . ' ';
                        } else {
                            $header .= ' ' . $key . ' = ' . $v[0] . '__' . $this->search_row_array($ro, $v[1]) . ' ';
                        }
                    }


                    $header .= ' >';
                } else {
                    $header .= '<tr>';
                }


                //print_r($ro);

                for ($t = 0; $t < count($coloum); $t++) {
                    $rov = $ro[$t];


                    if (isset($coloum[$t]['type']) && $coloum[$t]['type'] != '') {
                        if ($coloum[$t]['type'] == "text") {
                            $header .= '<td><input type="' . $coloum[$t]['type'] . '" name="' . $coloum[$t]['name'] . '[]" value="' . (isset($post_input[$coloum[$t]['name']][$r]) ? $post_input[$coloum[$t]['name']][$r] : $default_input[$coloum[$t]['name']]) . '" size="' . $coloum[$t]['size'] . '" /></td>';
                        }
                        if ($coloum[$t]['type'] == "href") {
                            $header .= '<td><a onclick="" />' . $coloum[$t]['coloum_header'] . '</a></td>';
                        }


                        if ($coloum[$t]['type'] == "checkbox") {
                            $header .= '<td><input type="' . $coloum[$t]['type'] . '" name="' . $coloum[$t]['name'] . '[' . $value . ']" value="' . $value . '"  /></td>';
                        }


                        if ($coloum[$t]['type'] == "date") {
                            $header .= '<td>' . date($coloum[$t]['name'], strtotime($value)) . '</td>';
                        }
                        if ($coloum[$t]['type'] == "edit_row") {
                            $header .= '<td >
<div class="edit_row" style="display:none;">
<a onclick="save_row(this,\'' . $v[0] . '__' . $this->search_row_array($ro, $v[1]) . '\',\'' . $table_id . '\');" >Save</a>
<a onclick="cancel_edit_row(\'' . $v[0] . '__' . $this->search_row_array($ro, $v[1]) . '\',\'' . $table_id . '\');" >Cancel<a>
</div>
</td>';
                        }

                        if ($coloum[$t]['type'] == "combo") {

                            //$qu = mysqli_query($this->db,"select * from ".$coloum[$t]['table_name']." ");

                            $_SESSION['status_table'] = $this->db->get_table("status where id < 4 ");

                            if ($coloum[$t]['other_table_name'] == "account") {
                                $sarray = $this->db->get_table("account");
                            }
                            if ($coloum[$t]['other_table_name'] == "drivers") {
                                $sarray = $db->get_table("drivers where active = 'Y'");
                            }
                            if ($coloum[$t]['other_table_name'] == "services") {
                                $sarray = $_SESSION['services_table'];
                            }
                            if ($coloum[$t]['other_table_name'] == "status") {
                                $sarray = $_SESSION['status_table'];
                            }
                            if ($coloum[$t]['other_table_name'] == "zones") {
                                $sarray = $this->db->get_table("pricezones");
                            }
                            if ($coloum[$t]['other_table_name'] == "package") {
                                $sarray = $this->db->get_table("package_type");
                            }


                            //$multiinput = "";
                            //$multiinput = explode("__",$coloum[$t]['coloum_fieldname']);
                            //$coloum[$t]['coloum_fieldname'] = $multiinput[0];

                            if (isset($multiinput[1])) {
                                $fn = $multiinput[1];
                            }

                            $header .= '<td>

 <select name="' . $coloum[$t]['table_name'] . '__' . $fn . $coloum[$t]['coloum_fieldname'] . '[]"  style="width:' . $coloum[$t]['size'] . 'px" >
 <option value=""></option>
 ';


                            for ($s = 0; $s < count($sarray); $s++) {
                                //var_dump($sarray[$s]);
                                $tvalues = explode(',', $coloum[$t]['view_value']);
                                $viewvalue = "";
                                for ($ts = 0; $ts < count($tvalues); $ts++) {
                                    $viewvalue .= $sarray[$s][$tvalues[$ts]] . ' | ';
                                }
                                $viewvalue = substr($viewvalue, 0, strlen($viewvalue) - 2);


                                $header .= '<option value = "' . $sarray[$s][$coloum[$t]['coloum_fieldname']] . '"      ' . (isset($post_input[$coloum[$t]['table_name'] . '__' . $coloum[$t]['coloum_fieldname']][$r]) && $post_input[$coloum[$t]['table_name'] . '__' . $coloum[$t]['coloum_fieldname']][$r] == $sarray[$s][$coloum[$t]['coloum_fieldname']] ? 'selected' : '') . '   ' . (!isset($post_input[$coloum[$t]['table_name'] . '__' . $coloum[$t]['coloum_fieldname']][$r]) && $sarray[$s][$coloum[$t]['coloum_fieldname']] == $default_input[$coloum[$t]['name_def']] ? 'selected' : '') . ' >' . $viewvalue . '</option>';
                            }

                            // while($row = mysqli_fetch_array($qu)){
                            // $header .= '<option value = "'.$row[$coloum[$t]['name']].'" '.($row[$coloum[$t]['name']] == $value ? 'selected' : '' ).'>'.$row[$coloum[$t]['view_value']].'</option>';
                            // }

                            $header .= '</select>
 </td>';
                        }
                    } elseif (isset($coloum[$t]['function']) && $coloum[$t]['function'] != '') {
                        $fun = $coloum[$t]['function'];

                        $header .= '<td>' . $fun($ro) . '</td>';
                    } else {
                        $header .= '<td>' . $post_input[$coloum[$t]['name']][$r] . '</td>';
                    }
                }
                $header .= '</tr>';
            }
        } else {
            $header .= '<tr>
<td colspan="' . count($coloum) . '" align="center">No Data To display</td>
</tr>';
        }
        $header .= "</table>";

        return $header;
    }


    public function change_index_to_key($array)
    {
        $key_array = array();

        for ($i = 0; $i < count($array); $i++) {
            foreach ($array[$i] as $key => $value) {
                $key_array[$key] = $value;
            }
        }
        return $key_array;
    }


    public function get_console_details($id)
    {
        $query = mysqli_query($this->db, "select consol_def.id,consol_def.is_default,consol_def.status,consol_def.orders,columns_details.display_" . $_SESSION['language'] . " as display from consol_def inner join columns_details on (columns_details.id = consol_def.console_details) where consol_def.console_id = '" . $id . "' ORDER BY consol_def.orders ASC ") or die(mysqli_error($this->db));
        $category = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;
    }

    public function update_console_details($id, $status, $orders)
    {
        foreach ($status as $key => $value) {
            //	echo $key.'--'.$value;
            mysqli_query($this->db, "update consol_def  set orders = '" . $orders[$key] . "',status = '" . $status[$key] . "'  where console_id = '" . $id . "' and id = '" . $key . "' ") or die(mysqli_error($this->db));
        }
    }


    public function update_console_details_sortable($id, $data)
    {
        mysqli_query($this->db, "update consol_def set orders = 0 where console_id = '" . $id . "' and is_default = '1'");
        $x = explode("|", $data);


        $not = explode(",", $x[0]);
        $in = explode(",", $x[1]);

        for ($i = 0; $i < count($not); $i++) {
            mysqli_query($this->db, "update consol_def  set orders = '" . ($i + 1) . "',status = '1'  where console_id = '" . $id . "' and id = '" . $not[$i] . "' ") or die(mysqli_error($this->db));
        }


        for ($i = 0; $i < count($in); $i++) {
            mysqli_query($this->db, "update consol_def  set orders = '" . ($i + 1) . "',status = '0'  where console_id = '" . $id . "' and id = '" . $in[$i] . "' ") or die(mysqli_error($this->db));
        }

        mysqli_query($this->db, "update consol_def set orders = '-1' where console_id = '" . $id . "' and name = 'order_checked' ");
    }
}
