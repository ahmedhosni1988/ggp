<?php

function template_main_accounting()
{
    echo 'Ahmed';
}


function accounting_menu()
{
    global $lang, $open, $c_setting;


    //  echo "test".$_SESSION['user_type'];

    if ($c_setting['start_page'] == 'all') {
        $murl = formurl . "/montior.php?action=all";
    } else {
        $murl = formurl;
    }

    $x = '
        
                <!-- #section:basics/sidebar -->
                <div id="sidebar" class="sidebar responsive">
                    <script type="text/javascript">
                        try{ace.settings.check(\'sidebar\' , \'fixed\')}catch(e){}
                    </script>
        
        
        
                    <ul class="nav nav-list">
                        <li class="">
                            <a href="index.php">
                                <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                                <span class="menu-text"> ' . $lang[1] . ' </span>
                            </a>
        
                            <b class="arrow"></b>
                        </li>

                        <li class="">
                        <a href="inventory.php">
                            <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                            <span class="menu-text"> المحزن </span>
                        </a>
                
                        <b class="arrow"></b>
                       </li>

                        <li class="">
                            <a href="index.php?action=orders">
                                <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                                <span class="menu-text"> الطلبيات </span>
                            </a>
        
                            <b class="arrow"></b>
                        </li>

 

                    <li class="">
                        <a href="index.php?action=show_outorder">
                            <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                            <span class="menu-text"> التسليمات </span>
                        </a>
    
                        <b class="arrow"></b>
                    </li>

                    <li class="">
                    <a href="' . $murl . '">
                        <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                        <span class="menu-text"> الفواتير </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                


 

              <li class="">
              <a href="' . $murl . '">
                  <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                  <span class="menu-text"> اشعار الخصم والاضافة </span>
              </a>

              <b class="arrow"></b>
             </li>

       


            
            <li class="">
            <a href="pricing.php">
                <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                <span class="menu-text"> التسعير </span>
            </a>

            <b class="arrow"></b>
        </li>

            <li class="">
            <a href="index.php?action=accounts">
                <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                <span class="menu-text"> العملاء </span>
            </a>

            <b class="arrow"></b>
        </li>

        <li class="hsub ">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon glyphicon  glyphicon-home blue"></i>
            <span class="menu-text"> الحزنة </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu" >
        <li class="">
        <a href="cash.php">
            <i class="menu-icon glyphicon  glyphicon-home blue"></i>
            <span class="menu-text"> استلام نقدى </span>
        </a>

        <b class="arrow"></b>
       </li>

       <li class="">
       <a href="index.php?action=orders">
           <i class="menu-icon glyphicon  glyphicon-home blue"></i>
           <span class="menu-text"> المصروفات </span>
       </a>

       <b class="arrow"></b>
       </li>

        </ul>
        </li>


        <li class="hsub ">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon glyphicon  glyphicon-home blue"></i>
            <span class="menu-text"> بحث </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu" >
        <li class="">
            <a href="" >
                <i class="menu-icon fa fa-caret-right"></i>
               فواتير
            </a>
            <b class="arrow"></b>
        </li>
        <li class="">
            <a href="" >
                <i class="menu-icon fa fa-caret-right"></i>
                الطلبيات
            </a>
            <b class="arrow"></b>
        </li>
        </ul>
        </li>

        <li class="hsub ">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon glyphicon  glyphicon-home blue"></i>
            <span class="menu-text"> التقارير </span>
            <b class="arrow fa fa-angle-down"></b>

        </a>

        <b class="arrow fa fa-angle-down"></b>

        <ul class="submenu" >
        <li class="">
            <a href="" >
                <i class="menu-icon fa fa-caret-right"></i>
                تقرير مبيعات
            </a>
            <b class="arrow"></b>
        </li>
        <li class="">
        <a href="" >
            <i class="menu-icon fa fa-caret-right"></i>
            تقرير مبيعات مفصل
        </a>
        <b class="arrow"></b>
    </li>

    <li class="">
    <a href="" >
        <i class="menu-icon fa fa-caret-right"></i>
        تقرير الهالك
    </a>
    <b class="arrow"></b>
</li>

<li class="">
<a href="' . $murl . '">
    <i class="menu-icon glyphicon  glyphicon-home blue"></i>
    <span class="menu-text"> حساب العميل </span>
</a>

<b class="arrow"></b>
</li>


        </ul>

    </li>


                       ';

    $x .= '</ul><!-- /.nav-list -->
            
                       <!-- #section:basics/sidebar.layout.minimize -->
                       <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                           <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                       </div>
           
                       <!-- /section:basics/sidebar.layout.minimize -->
                       <script type="text/javascript">
                           try{ace.settings.check(\'sidebar\' , \'collapsed\')}catch(e){}
                       </script>
                   </div>
       ';

    return $x;
}


function template_menu_accounting_menu()
{
    global $lang, $notification, $new_message, $new_invoice, $updated_order, $new_client;

    echo '<!-- #section:basics/navbar.layout -->
        <!-- 	<script src="' . SITEURL . '/' . STYLE . '/jscript/socket.js" type="text/javascript" ></script> -->
                <script type="text/javascript">
                //init(\'' . system_id . '\',\'' . $_SESSION['user_id'] . '\');
                
                
                </script>
                <style>
                body{
                    color:#000;
                    font-weight:bold;
                    font-size :15px;
                }
                </style>
                <div id="navbar" class="navbar navbar-default">
                    <script type="text/javascript">
                        try{ace.settings.check(\'navbar\' , \'fixed\')}catch(e){}
                    </script>
        
                    <div class="navbar-container" id="navbar-container">
                        <!-- #section:basics/sidebar.mobile.toggle -->
                        <button type="button" class="navbar-toggle menu-toggler pull-right" id="menu-toggler">
                            <span class="sr-only">Toggle sidebar</span>
        
                            <span class="icon-bar"></span>
        
                            <span class="icon-bar"></span>
        
                            <span class="icon-bar"></span>
                        </button>
        
                        <!-- /section:basics/sidebar.mobile.toggle -->
                        <div class="navbar-header pull-right">
                            <!-- #section:basics/navbar.layout.brand -->
                            <a href="#" class="navbar-brand">
                                <small>
                                    <i class="fa fa-car"></i>
                                    ' . SITENAME . '
                                </small>
                            </a>
        
                            <!-- /section:basics/navbar.layout.brand -->
        
                            <!-- #section:basics/navbar.toggle -->
        
                            <!-- /section:basics/navbar.toggle -->
                
            
                        
                        </div>
        
            
                        
                ' . admin_notify_list() . '
                    </div><!-- /.navbar-container -->
                </div>
                
                
                        <div class="main-container" id="main-container">
                                            ' .accounting_menu().'
                                                                                    
                <div class="main-content">
            ' . breadcrumbs() . '
                                        
                        <div class="page-content">
                    ' . setting_box() . '
        
                            <div class="page-content-area">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <!-- PAGE CONTENT BEGINS -->			
            
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
    <input type="text" id="search_grid" url="'.$url.'&ajax=1"  class=" input-sm" style="float:left; margin-left:20px;"  value=""  placeholder="بحث" >
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
