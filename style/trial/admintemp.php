<?php

function admin_notify_list()
{
    global $lang, $notification, $new_message, $new_invoice, $update_order, $view_message, $new_client;
    global $notifym;


    $norder = search($notification, 'types', 'new_order');
    $norder = array_merge($norder, search($notification, 'types', 'update_order'));
    $norder = array_merge($norder, search($notification, 'types', 'request_cancel_order'));
    //var_dump($norder);
    $x = '<div class="navbar-buttons navbar-header pull-left" role="navigation" >
                            <ul class="nav ace-nav">
                                                    
                                <li class="purple">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                        <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                                        <span class="badge badge-important">' . $update_order . '</span>
                                    </a>
        
                                    <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                                        <li class="dropdown-header">
                                            <i class="ace-icon fa fa-exclamation-triangle"></i>
                                            ' . $update_order . ' ' . $lang[91] . '
                                        </li>';

    if (is_array($norder) && count($norder) > 0) {
        $x .= '<script>
                                                                $(document).ready(function (){
        PlaySound(\'sound1\');
        });
                                                                </script>
                ';

        for ($i = 0; $i < count($norder); $i++) {
            $x .= '
                                                                <li>
                                                    <a href="montior.php?action=edit_orders&id=' . $norder[$i]['order_id'] . '">
                                                        <span class="msg-body">
                                                            <span class="msg-title">
                                                                <span class="blue">Order No. ' . $norder[$i]['order_id'] . ' ' . $notifym[$norder[$i]['types']] . '  by ' . $norder[$i]['account_company'] . '</span>
                                                            
                                                            </span>
        
                                                            <span class="msg-time">
                                                                <i class="ace-icon fa fa-clock-o"></i>
                                                                <span>' . time_elapsed_string($norder[$i]['order_date']) . '</span>
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                                                ';
        }
    } else {
        $x .= '<li>No New Orders.</li>';
    }

    $x .= '
        
                                        
        
                                    
        
                                    
        
                                        <li class="dropdown-footer">
                                            <a href="' . formurl . '/montior.php?action=pending">
                                                See all notifications
                                                <i class="ace-icon fa fa-arrow-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
        
                                
                                <!-- #section:basics/navbar.user_menu -->
                                <li class="light-blue">
                                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                        <span class="user-info">
                                            <small>Welcome,</small>
                                            ' . $_SESSION['name'] . '
                                        </span>
        
                                        <i class="ace-icon fa fa-caret-down"></i>
                                    </a>
        
                                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                        <li>
                                            <a href="' . SITEURL . '/administrator/index.php?action=edit_my_setting">
                                                <i class="ace-icon fa fa-cog"></i>
                                                ' . $lang[82] . '
                                            </a>
                                        </li>
        
        
        
                                        <li class="divider"></li>
                                ';
    if ($_SESSION['user_type']==2) {
        $x.='
                                    <li>
                                        <a href="' . SITEURL . '/administrator/work.php?action=printer_order">
                                            <i class="ace-icon fa fa-print align-top bigger-125"></i>
                                            طباعة طلبية
                                        </a>
                                    </li>';
        $x.='
                                    <li>
                                        <a href="' . SITEURL . '/administrator/work.php?action=finish_order">
                                            <i class="ace-icon fa fa-print align-top bigger-125"></i>
                                            ترحيل طلبية
                                        </a>
                                    </li>';
    }
    $x.='
                                        <li>
                                            <a href="' . SITEURL . '/administrator/index.php?action=logout">
                                                <i class="ace-icon fa fa-power-off"></i>
                                                ' . $lang[25] . '
                                            </a>
                                        </li>
                                    </ul>
                                </li>
        
                                <!-- /section:basics/navbar.user_menu -->
                            </ul>
                        </div>';
    return $x;
}

function template_header_admin()
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
                                            ' .admin_menu().'
                                                                                    
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


    function admin_menu()
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
                                <a href="' . $murl . '">
                                    <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                                    <span class="menu-text"> ' . $lang[1] . ' </span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>
                           ';



        if ($_SESSION['user_type'] == "accounting" ||  $_SESSION['user_type'] == 'smallaccounting') {
            $x .= '
                        

                                             <li>
                                                <a href="accounting.php">
                                                    <i class="menu-icon fa fa-user  blue"></i>
                                                    طلبيات تحت التشغيل
                                                </a>
                                               </li><li>
                                               <a href="search.php?action=searchDeliveries">
                                                    <i class="menu-icon fa fa-user  blue"></i>
                                                بحث التسليمات  
                                                </a>
                                               </li>
                    
                                               <li>
                                                <a href="search.php?action=mangesearch">
                                                    <i class="menu-icon fa fa-user  blue"></i>
                                                  بحث
                                                </a>
                                               </li>
                    
                                               <li>
                                                <a href="outorder.php?action=show_outorder&style=operation">
                                                    <i class="menu-icon fa fa-user  blue"></i>
                                                  التسليمات
                                                </a>
                                               </li>

                                            <!--   <li>
                                               <a href="pricing.php">
                                                   <i class="menu-icon fa fa-user  blue"></i>
                                                 '.$lang[1019].' 
                                               </a> 
                                              </li>-->
                                           
                                           <!--   <li class="">
                                <a href="#" class="dropdown-toggle">
                                    <i class="menu-icon fa  fa-building blue"></i>
                                    <span class="menu-text"> ' . $lang[106] . '</span>
            
                                    <b class="arrow fa fa-angle-down blue"></b>
                                </a>
            
                                <b class="arrow"></b>
                            <ul class="submenu" ' . ($open == "account" ? 'style="display:block;"' : '') . '>
                                    <li class="">
                                        <a href="' . SITEURL . '/administrator/accounts.php" >
                                            <i class="menu-icon fa fa-caret-right"></i>
                                            ' . $lang[148] . '
                                        </a>
                                        <b class="arrow"></b>
                                    </li>
                                </ul>
                            </li>-->
                                                    
                            <li>
                            <a href="pricing.php">
                                <i class="menu-icon fa fa-user  blue"></i>
                              '.$lang[1019]. ' 
                            </a> 
                           </li>  
                           <li class="">
                           <a href="#" class="dropdown-toggle">
                               <i class="menu-icon fa  fa-building blue"></i>
                               <span class="menu-text"> ' . $lang[106] . '</span>
       
                               <b class="arrow fa fa-angle-down blue"></b>
                           </a>
       
                           <b class="arrow"></b>
                       <ul class="submenu" ' . ($open == "account" ? 'style="display:block;"' : '') . '>
                               <li class="">
                                   <a href="' . SITEURL . '/administrator/accounts.php" >
                                       <i class="menu-icon fa fa-caret-right"></i>
                                       ' . $lang[148] . '
                                   </a>
                                   <b class="arrow"></b>
                               </li>
                         </ul>
                       </li>
                    

                                              
					<li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-book blue"></i>
                        <span class="menu-text"> '.$lang['accounting'].'</span>

                        <b class="arrow fa fa-angle-down blue"></b>
                    </a>

                    <b class="arrow"></b>
                <ul class="submenu" '.($open == "accounting" ? 'style="display:block;"' : '').'>
                                
                <!-- 
                                                <li class="">
                    <a href="'.SITEURL.'/administrator/report.php?action=statment_report&nav=nottab">
                        <i class="menu-icon fa fa-tachometer blue"></i>
                        <span class="menu-text">'.$lang['account_statment'].'</span>
                    </a>

                    <b class="arrow"></b>
                </li>
                            
                                    <li class="">
                    <a href="'.SITEURL.'/administrator/accounting.php?action=prepare_invoice">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text">'.$lang['prepare_invoice'].'</span>
                    </a>

                    <b class="arrow"></b>
                </li>-->
                                
                <li class="">
                <a href="'.SITEURL.'/administrator/credit_note.php?action=manage">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text">اشعارات الخصم والاضافة</span>
                </a>

                <b class="arrow"></b>
                </li>         
                                
                <li class="">
                    <a href="'.SITEURL.'/administrator/accounting.php?action=process_invoice&type=get_data">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text">'.$lang['open_invoice'].'</span>
                    </a>

                    <b class="arrow"></b>
                </li>

                                   
                <li class="">
                    <a href="'.SITEURL.'/administrator/accounting.php?action=process_invoice&type=get_data&reviewed=1">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text">'.$lang['open_invoice2'].'</span>
                    </a>

                    <b class="arrow"></b>
                </li>
                
                 <li class="">
                    <a href="'.SITEURL.'/administrator/accounting.php?action=revise_account">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text">حساب عميل</span>
                    </a>

                    <b class="arrow"></b>
                 </li>
                                <!--
                                                                <li class="">
                    <a href="'.SITEURL.'/administrator/accounting.php?action=open_invoice">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text">'.$lang['pay_invoice'].'</span>
                    </a>

                    <b class="arrow"></b>
                </li>
                         -->       
            <li class="">
                    <a href="'.SITEURL.'/administrator/accounting.php?action=history_invoice">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text">'.$lang['search_invoice'].'</span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                <a href="'.SITEURL.'/administrator/accounting.php?action=cashreceipts">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text">'.$lang['cashreceipts'].'</span> 
                </a>

                <b class="arrow"></b>
            </li>

        
                                </ul>
                                </li>
                             
                                                    ';
        }

        if ($_SESSION['user_type'] == 'administrator' || $_SESSION['user_type'] == 'manmanger' || $_SESSION['user_type'] == 'addmanger') {
            if ($_SESSION['user_type'] == 'manmanger') {
                $x .= '	<li class="">
                <a href="' . SITEURL . '/administrator/manger.php">
                    <i class="menu-icon fa fa-car blue"></i>
                    <span class="menu-text"> متابعه الكسر </span>
                </a>

                <b class="arrow"></b>
            </li>
            
            ';
            }
            $x .= '                    <li class="">
            <a href="outorder.php?action=show_outorder">
                <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                <span class="menu-text"> التسليمات </span>
            </a>

            <b class="arrow"></b>
        </li>
        	<li class="">
                                <a href="' . SITEURL . '/administrator/index.php?action=addorder">
                                    <i class="menu-icon fa fa-car blue"></i>
                                    <span class="menu-text"> ' . $lang[23] . ' </span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>';
            if ($_SESSION['user_type'] == 'administrator' || $_SESSION['user_type'] == 'manmanger') {
                $x .= '<li class="">
                            <a href="' . SITEURL . '/administrator/inventory.php">
                                <i class="menu-icon fa fa-car blue"></i>
                                <span class="menu-text"> ' . $lang[983] . ' </span>
                            </a>
        
                            <b class="arrow"></b>
                        </li>';
            }
            $x .= '	<li class="">
                                <a href="' . SITEURL . '/administrator/montior.php?action=all">
                                    <i class="menu-icon fa fa-calendar blue"></i>
                                    <span class="menu-text">' . $lang[24] . '</span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>
                            
                            <li class="">
                                <a href="' . SITEURL . '/administrator/search.php?action=mangesearch">
                                    <i class="menu-icon fa fa-search blue"></i>
                                    <span class="menu-text">' . $lang[26] . '</span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>

                            <li class="">
                            <a href="' . SITEURL . '/administrator/search.php?action=search_item">
                                <i class="menu-icon fa fa-search blue"></i>
                                <span class="menu-text">بحث بالمقاس</span>
                            </a>
        
                            <b class="arrow"></b>
                        </li>

                        <li class="">
                        <a href="' . SITEURL . '/administrator/log.php">
                            <i class="menu-icon fa fa-search blue"></i>
                            <span class="menu-text">الوج</span>
                        </a>
    
                        <b class="arrow"></b>
                    </li>

                        <li class="">
                        <a href="' . SITEURL . '/administrator/search.php?action=searchDeliveries">
                            <i class="menu-icon fa fa-search blue"></i>
                            <span class="menu-text">بحث التسليمات</span>
                        </a>
    
                        <b class="arrow"></b>
                    </li>

                            
                            <li class="">
                                       <a href="' . SITEURL . '/administrator/montior.php?action=today">
                                           <i class="menu-icon fa fa-user bigger-110 blue"></i>
                                           تسليمات اليوم
                                       </a>
                             </li>
                                
                                      ';
            if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == true && $_SESSION['status'] == 2 && ($_SESSION['user_type'] == "administrator" || $_SESSION['user_type'] == "manmanger")) {
                $x .= '
                    <li>
                    <a href="pricing.php">
                        <i class="menu-icon fa fa-user  blue"></i>
                      '.$lang[1019]. ' 
                    </a> 
                   </li>  
                        <li class="hsub open">
                                <a href="#" class="dropdown-toggle">
                                    <i class="menu-icon fa fa-cog blue"></i>
                                    <span class="menu-text"> ' . $lang[104] . '</span>
                                    <b class="arrow fa fa-angle-down"></b>
                                </a>
                                <b class="arrow"></b>
            
                                <ul class="submenu" ' . ($open == "setup" ? 'style="display:block;"' : '') . ' >
                                    <li class="">
                                        <a href="' . SITEURL . '/administrator/admin_index.php" >
                                            <i class="menu-icon fa fa-caret-right blue"></i>
                                            ' . $lang[108] . '
                                        </a>
                                        <b class="arrow"></b>
                                    </li>	
                                   
                                    
                                                    
                                    <li class="">
                                        <a href="' . SITEURL . '/administrator/users.php">
                                            <i class="menu-icon fa fa-caret-right"></i>
                                            ' . $lang[110] . '
                                        </a>
            
                                        <b class="arrow"></b>
                                    </li>
                                                    
                                    
                                                    
                                <li class="">
                                        <a href="' . SITEURL . '/administrator/admin_index.php?action=mconsole">
                                            <i class="menu-icon fa fa-caret-right"></i>
                                            ' . $lang[873] . '
                                        </a>
            
                                        <b class="arrow"></b>
                                    </li>
                                                    
        
                                    <li class="">
                                        <a href="' . SITEURL . '/administrator/admin_index.php?action=mlogo">
                                            <i class="menu-icon fa fa-caret-right"></i>
                                            ' . $lang[868] . '
                                        </a>
            
                                        <b class="arrow"></b>
                                    </li>
                                    
                                    <li class="">
                                        <a href="' . SITEURL . '/administrator/log.php">
                                            <i class="menu-icon fa fa-caret-right"></i>
                                            اللوج
                                        </a>
            
                                        <b class="arrow"></b>
                                    </li>
                                                    
                                </ul>
                            </li>';
        


                $x .= '		<li class="">
                                <a href="#" class="dropdown-toggle">
                                    <i class="menu-icon fa  fa-building blue"></i>
                                    <span class="menu-text"> ' . $lang[106] . '</span>
            
                                    <b class="arrow fa fa-angle-down blue"></b>
                                </a>
            
                                <b class="arrow"></b>
                            <ul class="submenu" ' . ($open == "account" ? 'style="display:block;"' : '') . '>
                                    <li class="">
                                        <a href="' . SITEURL . '/administrator/accounts.php" >
                                            <i class="menu-icon fa fa-caret-right"></i>
                                            ' . $lang[148] . '
                                        </a>
                                        <b class="arrow"></b>
                                    </li>
            
                                    
            
                
                        
                                                    
                                                    
                                            
                                </ul>
                            </li>';
     
                                                    
                $x .= '                                                  <li class="">
                                <a href="#" class="dropdown-toggle">
                                    <i class="menu-icon fa fa-book blue"></i>
                                    <span class="menu-text"> ' . $lang[398] . '</span>
            
                                    <b class="arrow fa fa-angle-down blue"></b>
                                </a>
            
                                <b class="arrow"></b>
                            <ul class="submenu" ' . ($open == "accounting" ? 'style="display:block;"' : '') . '>
                                            
                                    
                                                            <li class="">
                                <a href="' . SITEURL . '/administrator/report.php?action=scratch">
                                    <i class="menu-icon fa fa-tachometer blue"></i>
                                    <span class="menu-text">تقرير الهالك</span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>


                            <li class="">
                            <a href="' . SITEURL . '/administrator/report.php?action=salesReportDetails">
                                <i class="menu-icon fa fa-tachometer blue"></i>
                                <span class="menu-text">تقرير مبيعات مفصل</span>
                            </a>
        
                            <b class="arrow"></b>
                        </li>

                        <li class="">
                        <a href="' . SITEURL . '/administrator/report.php?action=salesReport">
                            <i class="menu-icon fa fa-tachometer blue"></i>
                            <span class="menu-text">تقرير مبيعات عام</span>
                        </a>
    
                        <b class="arrow"></b>
                    </li>


                                        
                                                    <li class="">
                                <a href="' . SITEURL . '/administrator/report.php?action=operation">
                                    <i class="menu-icon fa fa-tachometer"></i>
                                    <span class="menu-text">تقرير الانتاج</span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>
                                            
                                            
                                            
                                                                            <li class="">
                                <a href="' . SITEURL . '/administrator/report.php?action=accounting">
                                    <i class="menu-icon fa fa-tachometer"></i>
                                    <span class="menu-text">تقرير الحسابات</span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>
                                            
                        
                                            
                           
                            <li class="">
                                <a href="' . SITEURL . '/administrator/report.php?action=stock">
                                    <i class="menu-icon fa fa-tachometer"></i>
                                    <span class="menu-text">تقرير الزجاج الخام</span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                            <a href="' . SITEURL . '/administrator/report.php?action=account_accounting">
                                <i class="menu-icon fa fa-tachometer"></i>
                                <span class="menu-text">فواتير و تحصيل</span>
                            </a>
        
                            <b class="arrow"></b>
                        </li>
                        <li class="">
                        <a href="' . SITEURL . '/administrator/report.php?action=accounts_accounting">
                            <i class="menu-icon fa fa-tachometer"></i>
                            <span class="menu-text">حساب عميل</span>
                        </a>
    
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                    <a href="' . SITEURL . '/administrator/index.php?action=get_waybill_report">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text"> تقرير حركة طلبية</span>
                    </a>

                    <b class="arrow"></b>
                </li>
                            <li class="">
                            <a href="' . SITEURL . '/administrator/search.php?action=deficiencies">
                                <i class="menu-icon fa fa-heart blue"></i>
                                <span class="menu-text"> ' . $lang[1012] . ' </span>
                            </a>
        
                            <b class="arrow"></b>
                        </li>
        
        
                    
                                            
                    
        
                        
                                            
                                            
                                            </ul>
                                            </li>
                                            
                
                                                    
                    
                                                    ';
            }
        }


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

function admin_menu_internet()
{
    global $lang, $open, $c_setting;


    if ($c_setting['start_page'] == 'all') {
        $murl = formurl . "/montior.php?action=all";
    } else {
        $murl = formurl;
    }

    if ($_SESSION['user_type'] == 'smallaccounting') {
        $murl = formurl . "/accounting.php";
    }

    $x = '
            
                    <!-- #section:basics/sidebar -->
                    <div id="sidebar" class="sidebar responsive">
                        <script type="text/javascript">
                            try{ace.settings.check(\'sidebar\' , \'fixed\')}catch(e){}
                        </script>
            
            
            
                        <ul class="nav nav-list">
                            <li class="">
                                <a href="' . $murl . '">
                                    <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                                    <span class="menu-text"> ' . $lang[1] . ' </span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>
                           ';

    if ($_SESSION['user_type'] == "accounting" || $_SESSION['user_type'] == "smallaccounting") {
        $x .= '
                            <li>
                            <a href="'.SITEURL.'/administrator/branch/index.php?action=receiver_items">
                                <i class="menu-icon fa fa-user  blue"></i>
                                استلام من المصنع
                            </a>
                    </li>
                    
                           <li>
                           <a href="'.SITEURL.'/administrator/branch/index.php?action=deliver_items">
                               <i class="menu-icon fa fa-user  blue"></i>
                    تسليم عميل
                           </a>
                          </li>
                            <li class="">
                                <a href="' . SITEURL . '/administrator/index.php?action=addorder">
                                    <i class="menu-icon fa fa-car blue"></i>
                                    <span class="menu-text"> ' . $lang[23] . ' </span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>

                                             <li>
                                                <a href="' . SITEURL . '/administrator/accounting.php">
                                                    <i class="menu-icon fa fa-user  blue"></i>
                                                    طلبيات تحت التشغيل
                                                </a>
                                               </li><li>
                                               <a href="' . SITEURL . '/administrator/search.php?action=searchDeliveries">
                                                    <i class="menu-icon fa fa-user  blue"></i>
                                                بحث التسليمات  
                                                </a>
                                               </li>
                    
                                               <li>
                                                <a href="' . SITEURL . '/administrator/search.php?action=mangesearch">
                                                    <i class="menu-icon fa fa-user  blue"></i>
                                                  بحث
                                                </a>
                                               </li>
                    
                                               <li>
                                                <a href="' . SITEURL . '/administrator/outorder.php?action=show_outorder&style=operation">
                                                    <i class="menu-icon fa fa-user  blue"></i>
                                                  التسليمات
                                                </a>
                                               </li>

                                            <!--   <li>
                                               <a href="' . SITEURL . '/administrator/pricing.php">
                                                   <i class="menu-icon fa fa-user  blue"></i>
                                                 '.$lang[1019].' 
                                               </a> 
                                              </li>-->
                                           
                                              <li class="">
                                <a href="#" class="dropdown-toggle">
                                    <i class="menu-icon fa  fa-building blue"></i>
                                    <span class="menu-text"> ' . $lang[106] . '</span>
            
                                    <b class="arrow fa fa-angle-down blue"></b>
                                </a>
            
                                <b class="arrow"></b>
                            <ul class="submenu" ' . ($open == "account" ? 'style="display:block;"' : '') . '>
                                    <li class="">
                                        <a href="' . SITEURL . '/administrator/accounts.php" >
                                            <i class="menu-icon fa fa-caret-right"></i>
                                            ' . $lang[148] . '
                                        </a>
                                        <b class="arrow"></b>
                                    </li>
                                </ul>
                            </li>
                                                    
     
                    

                                              
					<li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-book blue"></i>
                        <span class="menu-text"> '.$lang['accounting'].'</span>

                        <b class="arrow fa fa-angle-down blue"></b>
                    </a>

                    <b class="arrow"></b>
                <ul class="submenu" '.($open == "accounting" ? 'style="display:block;"' : '').'>
                                
                        
                                                <li class="">
                    <a href="'.SITEURL.'/administrator/report.php?action=statment_report&nav=nottab">
                        <i class="menu-icon fa fa-tachometer blue"></i>
                        <span class="menu-text">'.$lang['account_statment'].'</span>
                    </a>

                    <b class="arrow"></b>
                </li>
                            
                                   <!--     <li class="">
                    <a href="'.SITEURL.'/administrator/accounting.php?action=prepare_invoice&type=get_data">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text">'.$lang['prepare_invoice'].'</span>
                    </a>

                    <b class="arrow"></b>
                </li>-->
                                
                                
                                
                <li class="">
                    <a href="'.SITEURL.'/administrator/accounting.php?action=process_invoice&type=get_data">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text">'.$lang['open_invoice'].'</span>
                    </a>

                    <b class="arrow"></b>
                </li>

                                   
                <li class="">
                    <a href="'.SITEURL.'/administrator/accounting.php?action=process_invoice&reviewed=1&type=get_data">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text">'.$lang['open_invoice2'].'</span>
                    </a>

                    <b class="arrow"></b>
                </li>
                                
                                                                <li class="">
                    <a href="'.SITEURL.'/administrator/accounting.php?action=open_invoice">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text">'.$lang['pay_invoice'].'</span>
                    </a>

                    <b class="arrow"></b>
                </li>
                                
            <li class="">
                    <a href="'.SITEURL.'/administrator/accounting.php?action=history_invoice">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text">'.$lang['search_invoice'].'</span>
                    </a>

                    <b class="arrow"></b>
                </li>

        
                                
                <li class="">
                <a href="'.SITEURL.'/administrator/accounting.php?action=cashreceipts">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text">'.$lang['cashreceipts'].'</span> 
                </a>

                <b class="arrow"></b>
            </li>

                                
                                
                                </ul>
                                </li>
                    
                                                    ';
    }

    if ($_SESSION['user_type'] == 'administrator' || $_SESSION['user_type'] == 'manmanger' || $_SESSION['user_type'] == 'addmanger') {
        $x .= '	<li class="">
                                <a href="#">
                                    <i class="menu-icon fa fa-car blue"></i>
                                    <span class="menu-text"> ' . $lang[23] . ' </span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>';
        
        $x .= '	<li class="">
                                <a href="' . SITEURL . '/administrator/montior.php?action=all">
                                    <i class="menu-icon fa fa-calendar blue"></i>
                                    <span class="menu-text">' . $lang[24] . '</span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>
                            
                            <li class="">
                                <a href="' . SITEURL . '/administrator/search.php?action=mangesearch">
                                    <i class="menu-icon fa fa-search blue"></i>
                                    <span class="menu-text">' . $lang[26] . '</span>
                                </a>
            
                                <b class="arrow"></b>
                            </li>
                                

                    <li class="">
                            <a href="#">
                                <i class="menu-icon fa fa-list blue"></i>
                                <span class="menu-text">اضافة وصل للعميل</span>
                            </a>
        
                            <b class="arrow"></b>
                        </li>

                                      ';
    }


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

function template_admin_index()
{
    global $lang, $array, $notification, $driverjson, $agedjson, $agedjson, $invoicejson, $all;

    $nmes = search($notification, 'types', 'new_message');
    $nuser = search($notification, 'types', 'new_user');
    $norder = search($notification, 'types', 'new_order');

    echo '
		
		
		
		<div class="alert alert-block alert-success">
									

									<i class="ace-icon fa fa-check green"></i>

									Welcome to
									<strong class="green">
										' . SITENAME . '.
										<small>(v1.2)</small>
									</strong>
								</div>
		
		
		
		<div class="row">
									<div class="space-6"></div>
									</div>

							
';
}

function template_unauthorized()
{
    global $lang;

    echo '<div class="page-content-area">
		<div class="page-header">
		<h1>لا توجد صلحيات</h1>
		</div>
				<div class="row">
				<div class="col-xs-12">
                </div>
                </div>
                </div>
                ';
}
function template_choose_client()
{
    global $lang, $allacc, $dr, $error, $services;


    echo '		
		<div class="page-content-area">
		<div class="page-header">
		<h1>' . $lang[865] . '</h1><span>' . $lang[973] . '</span>
		</div>
				<div class="row">
				<div class="col-xs-12">
				
				<form id="choose_client"  action="' . SITEURL . '/administrator/index.php?action=choose_client"  method="post" onsubmit="return validate_forms(\'choose_client\')" class="form-horizontal" role="form" enctype="multipart/form-data">
		';
    if (isset($_GET['e'])) {
        echo '<div class="alert alert-danger">
															<button type="button" class="close" data-dismiss="alert">
																<i class="ace-icon fa fa-times"></i>
															</button>

															<strong>
																<i class="ace-icon fa fa-times"></i>
																' . $error[$_GET['e']] . '
															</strong>

														
														</div>';
    }
    echo '
<div class="col-xs-6" >


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
<select  class="col-xs-10 col-sm-5 chosen-select" name="account_acctno"   > 
<option value="">' . $lang[204] . '
 </option>
';
    for ($i = 0; $i < count($allacc); $i++) {
        echo '<option value="' . $allacc[$i]['account_name'] . '">' . $allacc[$i]['account_name'] . ' | ' . $allacc[$i]['account_company'] . ' | ' . $allacc[$i]['billingcode_name'].'</option>';
    }
    echo '
</select>
</div>
</div>

<div class="space-4"></div>
		
<div class="form-group">
<label class="col-sm-3 control-label no-padding-right"> ' . $lang[879] . '</label>
<div class="col-sm-5">
<select  class="col-xs-10 col-sm-3 chosen-select" name="account_acctname" >  
<option value="">' . $lang[204] . '
 </option>
';
    for ($i = 0; $i < count($allacc); $i++) {
        echo '<option value="' . $allacc[$i]['account_name'] . '">' . $allacc[$i]['account_company'] . ' | ' . $allacc[$i]['account_name'] . ' | ' . $allacc[$i]['billingcode_name']. '</option>';
    }
    echo '
</select>
</div>
</div>	


		

		

	</div>

	<div class="col-xs-6">

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[974] . '</label>
<div class="col-sm-9">
<select name="service_id">
<option value="1">' . $lang[975] . ' </option>
<option value="2" selected>' . $lang[976] . ' </option>

</select>
</div>
</div>

		

		

														</div>

														<div style="clear:both;"></div>

<div class="clearfix form-actions">
<div class=" col-md-12">
		
<button type="submit"  class="btn btn-sm btn-info" name="choosesingleorder">
<i class="ace-icon fa fa-cloud-upload bigger-110"></i>
<span class="bigger-110 no-text-shadow">' . $lang[935] . '</span>
</button>
		

		
		

				
		
		</div>
</div>


		

</form>
				
				</div>
				</div>
		</div>
<script src="' . SITEURL . '/' . STYLE . '/assets/js/ace-extra.min.js"></script>
<script src="' . SITEURL . '/' . STYLE . '/assets/js/ace/elements.fileinput.js"></script>
		
		
		
		<script type="text/javascript">
			$("#id-input-file-1 , #id-input-file-2").ace_file_input({
					style: \'well\',
		            btn_change:null,
					no_icon:\'ace-icon fa fa-cloud-upload\',
                    no_file: \'Click to choose or drag & drop\',
                    droppable: true, //html5 browsers only
					allowExt:  [\'xls\', \'xlsx\']
					//onchange:""
					//
				});
		</script>
';
}


function template_admin_add_order()
{
    global $lang, $account_contact, $services, $pack, $tran, $pay, $allacc, $order_status, $check, $zone, $c_setting;
    global $itemData,$glassType,$glassColor;
    global $price, $drivers, $comData,$last_price_version_system, $last_price_version_account;

    //var_dump($itemData);
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/home.js"></script>
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/addorder.js"></script>
	<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>

	
	
<form name="add_orderss" id="add_orderss" onsubmit="return false;"  method="post" action="' . formurl . '/index.php?action=addorder" autocomplete="off"  class="form-horizontal" role="form" style="width:98%;  margin:1% 1% 1% 1%; ">
<input type="hidden" name="is_add_order" value="1" />	
<input type="hidden" name="price_version_system_id" value="'.($last_price_version_system > 0 ? $last_price_version_system : 0).'" />	
<input type="hidden" name="price_version_account_id" value="'.($last_price_version_account > 0 ? $last_price_version_account : 0) .'" />		
<input type="hidden" name="account_id" id="account_id" value="' . $allacc->account_id . '" />

		
		
<div class="row">

<div class=" pricing-box">
<div class="widget-box widget-color-blue">
<div class="widget-header ">
<div class="widget-title">' . $lang[977] . '</div>
</div>

<div class="widget-body">
<div class="widget-main">


<div class="col-xs-6">

<div class="form-group">
<label class="col-sm-3 control-label ">' . $lang[36] . '</label>
<div class="col-sm-9">' . trim($allacc->account_company, ' ') . '</div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[17] . '</label>
<div class="col-sm-9">' . $_GET['acctno'] . '</div>
</div>


';


    if (is_array($services) && count($services) > 0) {
        echo '<div class="form-group">
	<label class="col-sm-3 control-label">نوع الطلبية</label>
	<div class="col-sm-9">
';

        for ($i = 0; $i < count($services); $i++) {
            if (isset($_GET['ser']) && $_GET['ser'] == $services[$i]['service_id']) {
                $service_name = $services[$i]['service_name'];
                $service_id = $services[$i]['service_id'];
                echo '
			<input type="hidden" name="service_id" value="' . $service_id . '" /> 
			' . $services[$i]['service_name'];
            }
        }
        echo '
	</div>
	</div>';
    }


    echo '

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[357] . '</label>
<div class="col-sm-9">

		
<input   type="text" name="pickup_date" id="pickup_date" readonly="true"  validate="notempty"  value=""  /> 

<script type="text/javascript">
		
		$(document).ready(function (){

 $( "#pickup_date" ).datepicker({
		dateFormat: \'yy-mm-dd\',
        changeMonth: true,  
        minDate:0,  
		defaultDate: new Date()
    });
		
    $( "#delivery_date" ).datepicker({   
		dateFormat: \'yy-mm-dd\',   
        changeMonth: true
	});
		
		$("#pickup_date").datepicker(\'setDate\', new Date());
		var d = new Date()
		d.setDate(d.getDate() + 3); 
		$("#delivery_date").datepicker(\'setDate\', d );
		
		});	
</script>

</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[358] . '</label>
<div class="col-sm-9">
<input   type="text" name="delivery_date"  readonly="true"  id="delivery_date"  ' . ($_SESSION['status'] == '2' ? '' : 'validate="notempty"') . '   value="" />
</div>
</div>




<div class="form-group">
<label class="col-sm-3 control-label">نوع الطلبية</label>
<div class="col-sm-9">
<select name="order_type">
<option value="1" >طلبية جديدة</option>
<option value="5" >كسر عميل</option>
<option value="2" >خطا مصنع</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">نوع الزجاج </label>
<div class="col-sm-9">
<select name="glass_type">
<option value="0">نوع الزجاج</option>
';
    for ($i = 0; $i < count($comData); $i++) {
        echo '<option value="' . $comData[$i]['id'] . '">' . $comData[$i]['company_name'] . '</option>';
    }
    echo '</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">رقم التشغيل</label>
<div class="col-sm-9">
<input type="text" name="easy_order_id" value="" validate="notempty"/>
</div>
</div>


</div>


<div class="col-xs-6">

<div class="form-group">
<label class="col-sm-3 control-label">حالة الشغل</label>
<div class="col-sm-9">
<select name="work_status">
<option value="1" >عادى</option>
<option value="2" >مستعجل</option>
</select>
</div>
</div>';

    if ($_GET['ser'] == "2") {
//         echo '<div class="form-group">
        // <label class="col-sm-3 control-label">' . $lang[980] . '</label>
        // <div class="col-sm-9"><input class="form-control"  type="text" name="office_name"    value="" /></div>
        // </div>';
        
        echo '<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[981] . '</label>
<div class="col-sm-9"><input class="form-control"  type="text" name="operation_name"   value="" /></div>
</div>';
    }

    echo '<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[440] . '</label>
<div class="col-sm-9">
<textarea   name="order_comment"  rows="2" cols="30">' . $order_details->order_comment . '</textarea>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">نوع التشغيل</label>
<div class="col-sm-9">
<select name="option_type" validate="notempty">
<option value="1" >شامل </option>
<option value="2" >اجرة</option>
<option value="3" >خام</option>

</select>
</div>
</div>';

    echo '
<div class="form-group">
<label class="col-sm-3 control-label">تفاصيل التشغيل</label>
<div class="col-sm-9 chkAction">';

    if (is_array($order_status) && count($order_status) > 0) {
        for ($a = 0; $a < count($order_status); $a++) {
            echo  '<input name="order_status[]" type="checkbox"  '.($order_status[$a]['disporder']  == '1' ? 'checked' : '').'   value="' . $order_status[$a]['disporder'] . '"  > ' . $order_status[$a]['statusname'] . '<br>
    ';
        }
    }
    echo '</div>
    </div>';
    
    echo '
    <div class="form-group">
<label class="col-sm-3 control-label">السمك</label>
<div class="col-sm-9">

    <select  name="package_type"  validate="notempty">
<option value="" >' . $lang[362] . ' </option>';
    for ($i = 0; $i < count($pack); $i++) {
        echo '<option value="' . $pack[$i]['package_id'] . '" '.($pack[$i]['package_id']  == 1 ? '' : '').'>' . $pack[$i]['package_name'] . '</option>';
    }
    echo '
</select></div></div>';


    echo '    <div class="form-group">
    <label class="col-sm-3 control-label">الون</label>
    <div class="col-sm-9">
    ';
    if (is_array($glassColor) && count($glassColor) > 0) {
        echo'		
<select name="glasscolour"  >';
        for ($a = 0; $a < count($glassColor); $a++) {
            echo '<option value="' . $glassColor[$a]['color_name'] . '" >' . $glassColor[$a]['color_name'] . '</option>';
        }
        echo '</select>';
    }
    echo '</div>
    </div>';


    echo '
    <div class="form-group">
    <label class="col-sm-3 control-label">مسطح</label>
    <div class="col-sm-9">
<select name="glassType">
<option value="' . $glassType[1] . '" selected>' . $glassType[1] . '</option>
<option value="' . $glassType[2] . '" >' . $glassType[2] . '</option>
</select>
</div>
</div>
';




    if ($_SESSION['billing_code'] > "0") {
        echo '<input type="hidden" name="billing_code" value="'.$_SESSION['billing_code'].'" /> ';
    } else {
        echo '<div class="form-group">
<label class="col-sm-3 control-label">الفرع</label>
<div class="col-sm-9">
<select name="billing_code" >
<option value="0">اختار الفرع</option>';
        global $billing_codes;
        for ($i=0;$i<count($billing_codes);$i++) {
            echo '<option value="'.$billing_codes[$i]['id'].'" '.($billing_codes[$i]['id'] == $allacc->billing_code ? 'selected' : '').' >'.$billing_codes[$i]['billingcode_name'].'</option>';
        }
        echo '
</select>
</div>
</div>';
    }


    echo '</div>



</div>

<div style="clear:both;"></div>


</div>
</div>
</div>
</div>

<div class=".col-xs-12 pricing-box">
<div class="widget-box widget-color-blue">
<div class="widget-header ">
<div class="widget-title">' . $lang[978] . '</div>
</div>

<div class="widget-body">
<div class="widget-main">

<table  class="table table-striped table-bordered table-hover" id="multi_package">
<tr >
<th>' . $lang[1011] . '</th>
<th>' . $lang[43] . '</th>
<th>' . $lang[47] . '</th>
<th>' . $lang[363] . '</th>
<th style="width:200px;">' . $lang[59] . '</th>
<!-- <th style="width:300px;">خدمات</th> -->
<!-- 
<th>الوان</th>
<th>المسطح</th>
-->
';
    if ($_GET['ser'] == "2") {
        echo '
<th>التخليع</th>
<th>حدد للمسح  </th>
';
    }

    $x .= '</tr>
<tr>
<td class="numOfItem"> 1 </td> 
<td><input   type="text" name="length[]" size="4"  validate="notempty" validate_message = "length is requied" /></td>
<td><input   type="text" name="width[]" size="4"    validate="notempty" validate_message = "width is requied" /></td>
<td><input   type="text" name="parts[]" size="2" value="1" /></td>
<td>
<!--
<input   type="text" name="details[]" size="30" placeholder="التفاصيل 1" /><hr> -->

<input   type="text" name="details_2[]" size="30" placeholder="التفاصيل 2" />

</td>
';


    global  $glassPrint, $glassColor, $glassScarch, $glassPointing, $glassFixedPointing,$pack_options;

    if ($_GET['ser'] == "2") {
        $x .= '

	<td>
	<select name="glassPointing[]">
	<option value="' . $glassPointing[1] . '" >' . $glassPointing[1] . '</option>
    <option value="' . $glassPointing[2] . '" >' . $glassPointing[2] . '</option>
    <option value="' . $glassPointing[3] . '" selected>' . $glassPointing[3] . '</option>
    <option value="' . $glassPointing[4] . '" >' . $glassPointing[4] . '</option>

	</select>
	</td>
	';
    }

    if ($_GET['ser'] == "2") {
        $x .= '
	<td>
	<input type="checkbox" name="record" id="box"  style=\'display:none;\' >
	</td>
	';
    }

    if ($_GET['ser'] == "1") {
        $x .= '<td>
	<select name="glassFixedPointing[]">
	<option value="' . $glassFixedPointing[1] . '" selected>' . $glassFixedPointing[1] . '</option>
	<option value="' . $glassFixedPointing[2] . '" >' . $glassFixedPointing[2] . '</option>
	</select>
	</td>
	<td><input type="text" name="noofprinting[]" value="1" size="3" /></td>
	<td><input type="text" name="colorofprinting[]" value="" size="5" /></td>
	<td>
	<input type="checkbox" name="record"   id="box"  style=\'display:none;\'>
	</td>
	';
    }


    $x .= '</tr>';


    echo $x . '</table>

<button class="btn btn-success"  onclick="add_package_row(1);">
<i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
اضافة قطعة&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</button>
<button class="btn btn-success"  onclick="mov_package_row();">
<i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
مسح قطعة&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</button>



</div>
</div>
</div>
</div>

	<div style="clear:both;"></div>
				
<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
		
		<button class="btn btn-primary" id="addorder_button" onclick="add_orders(\'addorder\',\'normal\');">
												<i class="ace-icon fa fa-floppy-o align-top bigger-125"></i>
												اضافة الطلبية&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</button>
		
	
</div>
</div>
</form>

<div id="result"></div>
<div id="address" title="' . $lang[382] . '" style="font-size:12px;" >

</div>
<div style="clear:both; "></div>
		
';
}

function template_price_list()
{
    global $result, $lang, $errormsg, $rowwarnings, $c_setting;

    //var_dump($result);
    if ($errormsg != '') {
        $x .= $errormsg . "<br>" . $rowwarnings;
    } elseif (count($result) > 0 && is_array($result)) {
        $x .= $rowwarnings . '<br><table class="table table-striped table-bordered table-hover">';

        $total = 0;
        for ($i = 0; $i < count($result); $i++) {
            if ($c_setting['company_skid'] == '1') {
                if ($result[$i]['desc'] == "Pickup Price") {
                    $result[$i]['desc'] = "First Skid Price";
                }
                if ($result[$i]['desc'] == "Delivery Price") {
                    $result[$i]['desc'] = "Extra Skid Price";
                }
            }

            $x .= '<tr>
			<td>' . $result[$i]['desc'] . '</td>
			<td>' . sprintf("%01.2f", $result[$i]['price']) . '</td>
			</tr>';
            $total += $result[$i]['price'];
        }

        $x .= '<tr>
		<td>Total</td>
		<td><span class="label label-success arrowed-in arrowed-in-right">' . sprintf("%01.2f", $total) . '</span></td>
		</tr>
		</table>';
    }
    return $x;
}



function template_waybill_report()
{
    global $order_details, $order_package_details, $c_setting, $lang;

    
    echo '
<style>



.table_details td{
 padding:5px;
}

</style>
<div id="print">
<!-- 
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




<table border="3" cellspacing="0" width="100%" dir="rtl" >

<tr>

<td style="text-align:center;">
<img src="' . SITEURL . '/images/logo.jpg"  max-height="70">
</td>

<td style="text-align:right; width:70%;"  valign="top">
<table border="2" width="100%" cellpadding="5" class="table_details">
<tr>
<td>التاريخ</td><td>' . date("d - m- Y", strtotime($order_details->order_date)) . '</td>

<td>رقم الطلبية</td><td>' . $order_details->easy_order_id . ' </td>
</tr>
<tr>
<td>نوع الطلبية</td><td>' . $order_details->service_name . ' </td>
<td>العميل</td><td>' . $order_details->account_name . ' | ' . $order_details->account_company . '</td>
</tr>
<tr>
<td>اسم المكتب</td><td>' . $order_details->office_name . '</td>
<td>اسم العملية</td><td>' . $order_details->operation_name . '</td>
</tr>
<tr>
<td>تاريخ الاستلام </td><td>' . $order_details->pickup_date . '</td>
<td> تاريخ التسليم </td><td>' . $order_details->delivery_date . '</td>
</tr>

<tr>
<td>كمية الزجاج </td><td>' . ($order_details->order_size / 10000) . '</td>
<td> عدد القطع</td><td>' . $order_details->pieces . '</td>
</tr>

<tr>
<td>تاريخ الاستلام </td><td>' . $order_details->pickup_date . '</td>
<td> تاريخ التسليم </td><td>' . $order_details->delivery_date . '</td>
</tr>
</table>
</td>
</tr>


<td>
<tr>
<td colspan="2">
<br>
<table class="table_details" border="2" cellspacing="0" width="100%" dir="rtl">
';

    if ($order_details->service_id == "2") {
        echo '<tr>
        
	<td>م</td>
	<td>طول</td>
	<td>عرض</td>
	<td>سمك</td>
	<td>لون</td>
	<td>مسطح</td>
	<td>تخليع</td>
	<td>التفاصيل</td>
	<td>تقطيع</td>
	<td>شطف </td>
    <td>تشطيب </td>
	<td>فرن</td>
	<td>توريد</td>
	<td>تسليم</td>
	</tr>';
    } elseif ($order_details->service_id == "1") {
    }

    for ($j = 0; $j < count($order_package_details); $j++) {
        echo '<tr>';

        foreach ($order_package_details[$j] as $key => $value) {
            if ($key == "id") {
                echo '';
            } elseif ($key == "2" || $key == "3" || $key == "4" || $key == "6" || $key == "7") {
                echo '<td ' . ($value['on'] == "1" ? 'style="background-color:#ccc !important; text-align:center;"' : '') . ' >' . ($value['done'] == "1" && $value['on'] == "1" ? '<i class="ace-icon fa fa-check-square-o"></i>' : ($value['on'] == "1" ? '<i class="ace-icon fa fa-square-o"></i>' : '')) . '<br>'.$value['name']. '</td>';
            } elseif ($key == "5") {
                //var_dump($value);

                echo '<td ' . ($value['on'] == "1" ? 'style="background-color:#ccc !important; text-align:center;"' : '') . ' >' . (($value['done'] == "1" && $value['on'] == "1") || $value['in_work'] == "1" ? '<i class="ace-icon fa fa-check-square-o"></i>' : ($value['on'] == "1" ? '<i class="ace-icon fa fa-square-o"></i>' : '')) . '<br>'.$value['name']. '</td>';
            } else {
                echo '<td>' . $value . '</td>';
            }
        }
        echo '</tr>';
    }


    echo '
</table>
</td>
</tr>
</td>


</table>
</div>';
    // echo'<pre>';
// print_r($order_package_details);
// echo'</pre>';
}
function template_report_order_state()
{
    global $lang;
    echo '
		
	<div class="page-content-area">
	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->			



<div class="form-group">
<label class="col-sm-2 control-label no-padding-right" style="
text-align: left;
">رقم الطلبية</label>
<div class="col-sm-9">
<input type="text" id="easy_order_id" placeholder="رقم الطلبية"  value=""  />

<button   onclick="get_order_state()" class="btn btn-info"    >
بحث</button>
</div>
</div>	

<div style="clear:both;"></div>

<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">

 
<script src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>

';
}
function template_waybill()
{
    global $order_details, $order_package_details, $c_setting, $lang,$option_type_lang,$orderLog;

    
    echo '
<style>



.table_details td{
 padding:5px;
}

</style>
<div id="print">


<!--
        <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap-timepicker.css" />
		<link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/font-awesome.min.css" />
		
	    <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/jquery-ui.min.css" />
				
        		

		<link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.min.css" id="main-ace-style" />
		
	
		<link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-skins.min.css" />
		<link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-rtl.min.css" />
-->

<table border="3" cellspacing="0" width="100%" dir="rtl" >

<tr>

<td style="text-align:center;">
<img src="' . SITEURL . '/images/logo.jpg"  max-height="70">
</td>

<td style="text-align:right; width:70%;"  valign="top">
<table border="2" width="100%" cellpadding="5" class="table_details">
<tr>
<td>التاريخ</td><td>' . date("d - m- Y", strtotime($order_details->order_date)) . '</td>

<td>رقم الطلبية</td><td>' . $order_details->easy_order_id . ' </td>
</tr>
<tr>
<td>نوع الطلبية</td><td>' . $order_details->service_name . ' </td>
<td>العميل</td><td>' . $order_details->account_name . ' | ' . $order_details->account_company . '</td>
</tr>
<tr>
<td>اسم المكتب</td><td>' . $order_details->office_name . '</td>
<td>اسم العملية</td><td>' . $order_details->operation_name . '</td>
</tr>
<tr>
<td>تاريخ الاستلام </td><td>' . $order_details->pickup_date . '</td>
<td> تاريخ التسليم </td><td>' . $order_details->delivery_date . '</td>
</tr>

<tr>
<td>كمية الزجاج </td><td>' . ($order_details->order_size / 10000) . '</td>
<td> عدد القطع</td><td>' . $order_details->pieces . '</td>
</tr>

<tr>
<td>نوع التشغيل </td><td>' . $option_type_lang[$order_details->option_type] . '</td>
<td> تاريخ التسليم </td><td>' . $order_details->delivery_date . '</td>
</tr>

<tr>
<td>تفاصيل</td><td colspan="3">' . $order_details->order_comment . '</td>

</tr>


</table>
</td>
</tr>
';

    if ($orderLog != false && count($orderLog) > 0) {
        echo '
        <tr>
<td colspan="2">';

        for ($i=0;$i<count($orderLog);$i++) {
            echo $orderLog[$i]['USER_NAME'].'-'.$orderLog[$i]['BEFORE_CHANGE'];
        }
        echo '</td>
</tr>
    ';
    }
    echo '<tr>
<td colspan="2">
<table class="table_details" border="2" cellspacing="0" width="100%" dir="rtl">
';

    if ($order_details->service_id == "2") {
        echo '<tr>
        
	<td>م</td>
	<td>طول</td>
	<td>عرض</td>
	<td>سمك</td>
	<td>لون</td>
	<td>مسطح</td>
	<td>تخليع</td>
	<td>التفاصيل</td>
	<td>تقطيع</td>
	<td>شطف </td>
    <td>التشطيب </td>
	<td>فرن</td>
	<td>توريد</td>
	<td>تسليم</td>
	</tr>';
    } elseif ($order_details->service_id == "1") {
    }

    for ($j = 0; $j < count($order_package_details); $j++) {
        echo '<tr>';

        foreach ($order_package_details[$j] as $key => $value) {
            if ($key == "id") {
                echo '';
            } elseif ($key == "2" || $key == "3" || $key == "4" || $key == "6" || $key == "7") {
                echo '<td ' . ($value['on'] == "1" ? 'style="background-color:#ccc !important; text-align:center;"' : '') . ' >' . ($value['done'] == "1" && $value['on'] == "1" ? '<i class="ace-icon fa fa-check-square-o"></i>' : ($value['on'] == "1" ? '<i class="ace-icon fa fa-square-o"></i>' : '')) . '</td>';
            } elseif ($key == "5") {
                //var_dump($value);

                echo '<td ' . ($value['on'] == "1" ? 'style="background-color:#ccc !important; text-align:center;"' : '') . ' >' . (($value['done'] == "1" && $value['on'] == "1") || $value['in_work'] == "1" ? '<i class="ace-icon fa fa-check-square-o"></i>' : ($value['on'] == "1" ? '<i class="ace-icon fa fa-square-o"></i>' : '')) . '</td>';
            } else {
                echo '<td>' . $value . '</td>';
            }
        }
        echo '</tr>';
    }


    echo '
</table>
</td>
</tr>
</td>


</table>
</div>';
}


function template_show_map()
{
    global $lang, $dri, $c_setting, $driversList;
    echo '
			<html>
			<head>
			<title>Track driver ' . $dri->name . '</title>
					
					
		<!-- ace settings handler -->
		<script src="' . SITEURL . '/' . STYLE . '/assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

					<!--[if !IE]> -->
		
			<script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.min.js"></script>
	

		<!-- <![endif]-->
					
			
	<script  src="https://maps.googleapis.com/maps/api/js?key=' . $c_setting['googlemap_api'] . '"  type="text/javascript"></script>

					
			</head>
					
			<body>
					<div class="modal"></div>
		
		 		
			<script type="text/javascript">
			
					 		$(document).ready(function (){
			var driversList = ' . $driversList . ';
					
		 				init(\'' . system_id . '\',\'' . $_SESSION['user_id'] . '_' . $dri->id . '\',driversList);
		 		
		 						var intial_address = \'' . $c_setting['co_address'] . '\' + \',' . $c_setting['co_city'] . '\' + \',' . $c_setting['co_provstate'] . '\'
		 	initMap(intial_address);
});
		 						
			 		 window.onbeforeunload = function() {
        return "Your text here";
      };
			 		
			 		window.onbeforeunload = function() {
	//alert(\'' . $dri->id . '\');
	return track_driver(\'' . $dri->id . '\',2,\'\');
			
	
};
			

			
			</script>
			

		 		<div class="alert alert-danger" style="display:none;">
															<button type="button" class="close" data-dismiss="alert">
																<i class="ace-icon fa fa-times"></i>
															</button>
GPS is Not working plz contact driver to open it.
		 		
											</div>
		 <p>
		<button class="btn btn-danger btn-block" id="track_driver" onclick="track_driver(\'' . $dri->id . '\',\'1\',\'' . $dri->name . '\');">Track Driver ' . $dri->name . '</button>
		</p>
				
			<div id="map" style="width:100%;height:80%;">

</div>
			</body>
				
				</html>
	';
}


function template_driver_order()
{
    global $lang, $dri_ord, $email, $driver_id;
    $x .= '
		<link rel="stylesheet" type="text/css" href="' . SITEURL . '/' . STYLE . '/css/hideprint.css" />
			
				<script type="text/javascript">
				
				$( "#sortable" ).sortable({
				 stop: function(event, ui) {
        var data = "";
var sort_index = [];
        $("#sortable tr").each(function(i, el){
				
				 sort_index.push({ 
        "index" : i,
        "order_id"  : $(el).attr("order_id"),
        "driver_id1"       : $(el).attr("driver_id"),
		"driver_id2"       : $(el).attr("driver_id2"),
		"driver" : $(el).attr("this_driver")
    });     
        });
				
      passant_order(sort_index);
       
    }
		
	});
				</script>
			<div id="sample-table-2_wrapper" class="dataTables_wrapper form-inline no-footer">
			
		<div class="row">
			
			
			<div >
			
			<div style="width:48%; margin:1%; float:left;">
			
			<div  class="from-group" >
			<label>' . $dri_ord[0]['name'] . '-' . $dri_ord[0]['driverno'] . '</label>
			</div>
					<div style="clear:both;"></div> ';

    if (isset($dri_ord[0]['phone']) && $dri_ord[0]['phone'] != '') {
        $x .= '<div class="from-group">
	    	<label>Phone : ' . $dri_ord[0]['phone'] . '</label>
			</div>
	    			<div style="clear:both;"></div> 
	    			';
    }

    $x .= '
		<div class="from-group">
	    	<label>Orders Count : ' . count($dri_ord) . '</label>
		</div>
	    		<div style="clear:both;"></div> 	
		</div>
			
			
		<div style="width:48%; margin:1%; float:left;">';

    if (isset($dri_ord[0]['cell']) && $dri_ord[0]['cell'] != '') {
        $x .= '<div class="from-group">
	    	<label>Cell : ' . $dri_ord[0]['cell'] . '</label>
			</div>
	    			<div style="clear:both;"></div> ';
    }
    if (isset($dri_ord[0]['notify_email']) && $dri_ord[0]['notify_email'] != '') {
        $x .= '<div class="from-group">
	    	<label>Email : ' . $dri_ord[0]['notify_email'] . '</label>
			</div>
	    			<div style="clear:both;"></div> 
';
    }

    $x .= '

		<div class="from-group">
		<label class="red">Drag and drop orders to sort.</label>
		</div>
				
				</div>
			
			
			
					';
    //koko modification start


    $x .= '
	<!-- koko modification end -->		
			</div>


				<div style="clear:both;"></div>	
			</div>
			
		<style  type="text/css" media="screen">
    		.thead {
display:table; width:96.70%; table-layout:fixed;
}
    		
    		    		.tbody {
 overflow-y: scroll; display:block;
}
    		.tr{
display:table; width:100%; table-layout:fixed;
}
    		
    	</style>			
			
	<table id="driver_activity_' . $dri_ord[0]['id'] . '" class="table table-striped table-bordered table-hover ">
		
		<thead>
		<tr class="thead">
		<th style="width:25px;">+</th>
		<th style="width:70px;">' . $lang[840] . '</th>
		<th style="width:70px;">Status</th>
		<th style="width:90px;">SRV</th>
		<th>' . $lang[34] . '</th>
		<th>' . $lang[35] . '</th>
		' . ($email == "1" ? '' : '<th  class="removeprint" ></th>') . '
		</tr>
		</thead>	
		
		<tbody class="tbody" id="sortable" >';
    if (count($dri_ord) > 0 && is_array($dri_ord)) {
        //var_dump($dri_ord);
        for ($i = 0; $i < count($dri_ord); $i++) {
            $x .= ' <tr this_driver = "' . $driver_id . '"  driver_id="' . $dri_ord[$i]['driver_id'] . '" driver_id2="' . $dri_ord[$i]['driver_id2'] . '" order_id="' . $dri_ord[$i]['order_id'] . '" class="tr">
					<td style="width:25px;" class="removeprint"><input type="checkbox" name="order_id[]" value="' . $dri_ord[$i]['order_id'] . '" ></td>
					<td style="width:70px;">' . $dri_ord[$i]['order_id'] . '</td>
					<td style="width:70px;">' . $dri_ord[$i]['statusname'] . '</td>
					<td style="width:90px;" >' . $dri_ord[$i]['service_short'] . '</td>
					<td><div style="color:red; font-weight:bold;">Pickup:  ' . date(DATE_FORMAT, strtotime($dri_ord[$i]['pickup_date'])) . ' ' . time_req($dri_ord[$i]['pickup_by']) . ' ' . date(TIME_FORMAT, strtotime($dri_ord[$i]['pickup_time'])) . '</div>' . $dri_ord[$i]['from_address'] . '<br><div style="color:red; font-weight:bold;">' . ($dri_ord[$i]['order_type'] == "2" ? $dri_ord[$i]['other_driver'] : '') . '</div></td>
					<td><div style="color:red; font-weight:bold;">Deliver: ' . date(DATE_FORMAT, strtotime($dri_ord[$i]['delivery_date'])) . ' ' . time_req($dri_ord[$i]['deliver_by']) . ' ' . date(TIME_FORMAT, strtotime($dri_ord[$i]['delivery_time'])) . '</div>' . $dri_ord[$i]['to_address'] . '<br><div style="color:red; font-weight:bold;">' . ($dri_ord[$i]['order_type'] == "1" ? $dri_ord[$i]['other_driver'] : '') . '</div></td>	
					' . ($email == "1" ? '' : ' <td  class="removeprint">
							
					
					<button style="float:left;" class="btn btn-app btn-danger btn-xs" onclick="send_driver_message(' . htmlspecialchars(json_encode($dri_ord[$i])) . ')">
										<i class="ace-icon fa fa-envelope bigger-110"></i>
									
									</button>
					
					<button style="float:left;" class="btn btn-app btn-success btn-xs"  onclick="javascript:location.href=\'montior.php?action=edit_orders&id=' . $dri_ord[$i]['order_id'] . '\'">
														<i class="ace-icon fa fa-external-link bigger-110" ></i>
													</button>
							
							<button style="float:left;" class="btn btn-app btn-info btn-xs"  onclick="refreshwaybill(\'' . $dri_ord[$i]['order_id'] . '\');">
														<i class="ace-icon fa fa-print bigger-110" ></i>
								</button>
									
						<button style="float:left;" class="btn btn-app btn-purple btn-xs" onclick="show_barcode(\'' . $dri_ord[$i]['order_id'] . '\',\'' . $dri_ord[$i]['account_id'] . '\',\'' . $dri_ord[$i]['account_name'] . '\')">
														<i class="ace-icon fa  fa-barcode bigger-110 " ></i>
													</button>
								
									
							

									</td>') . '
					</tr>';
        }
    } else {
        $x .= '<tr style="display:table; width:96.70%; table-layout:fixed;"><td colspan="100%">' . $lang[472] . '</td></tr>';
    }
    $x .= ' 
	       </tbody>
	        </table>
			</div>';

    if ($email == "1") {
        return $x;
    } else {
        echo $x;
    }
}

function template_send_driver_order_message()
{
    global $lang, $jsonObj;
    echo '
	<form id="driver_message" class="form-horizontal" method="post"  >
			<input type="hidden" name="send_message" value="1" />
			<input type="hidden" name="driver_id" value="' . $jsonObj['id'] . '" />
			<input type="hidden" name="order_id" value="' . $jsonObj['order_id'] . '" />
	<div class="from-group">
			<label class="col-sm-3 control-label">Email/Notification</label>
			<div class="col-sm-9">
			<textarea name="driver_message" cols="40" rows="2"></textarea>
			</div>
			
			</div>		
	</form>		
	';
}


function template_client_add_order()
{
    global $lang, $account_contact, $services, $pack, $tran, $pay, $allacc, $addser, $check, $zone, $c_setting;
    global $account_emails;
    global $price, $drivers;

    echo '
			
			
			<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/home.js"></script>
	
					
						<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/addorder.js"></script>
			
				<script src="' . SITEURL . '/' . STYLE . '/assets/js/chosen.jquery.min.js"></script>
		<link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/chosen.css" />
	<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/address.js"></script>
	<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>
	<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/time.js"></script>

			
			
			<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
			
			<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
			
			
<form name="add_orderss" id="add_orderss"  method="post" action="' . formurl . '/index.php?action=addorder" class="form-horizontal" role="form" style="width:98%;  margin:1% 1% 1% 1%; ">
<input type="hidden" name="is_add_order" value="1" />
<input type="hidden" id="meters" name="meters" value="0" />

<input type="hidden" name="account_id" id="account_id" value="' . $allacc->account_id . '" />

		<input type="hidden" id="cutofftime" name="cutofftime" value="" /> 
<input type="hidden" id="autodeliverytime" name="autodeliverytime" value="" />
<input type="hidden" id="max_distance" name="max_distance" value="" />


		<div class="row">


		<div class="col-xs-4  pricing-box">
		<div class="widget-box">
		<div class="widget-header">
		<div class="widget-title">' . $lang[589] . '</div>
		<div class="widget-toolbar">
				<img src="' . SITEURL . '/style/trial/images/addressbook-icon.png" onclick="show_addrbook(\'from\',\'' . $allacc->account_id . '\',\'0\',\'\',\'\');"  width="25" height="20">

						<span class="label label-success" onclick="switchcontact();" name="show-option" title="Click Here to switch contact">
														<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
													</span>


		</div>
		</div>

				<div class="widget-body">
				<div class="widget-main">

				<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[36] . '</label>
<div class="col-sm-9"><input type="text" name="from_name" id="from_name" validate="notempty" class="form-control"   value="' . trim($allacc->account_company, ' ') . '"   /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><input  class="autocomplete form-control" Focus="geolocate();"  validate="notempty" name="from_address" id="from_address"  value="' . $allacc->account_address . '" ></div>
</div>


<div class="form-group" style="width:50%; float:left;">
<label class="col-sm-3 control-label">' . $lang[9] . '</label>
<div class="col-sm-9"><input   type="text"  name="from_pcode" id="from_pcode"  validate="notempty"   value="' . $allacc->pcode . '" /></div>
</div>';

    if (($c_setting['allow_zones'] == 'Y' || $_SESSION['status'] == '2') && count($zone) > 0) {
        //$zo =	$price->get_zone_pcode($allacc->pcode);
        echo '<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[354] . '</label>
<div class="col-sm-9">
<select  class="form-control"  class="form-control"name="from_zone" >
<option value="">' . $lang[356] . '</option>';
        for ($z = 0; $z < count($zone); $z++) {
            echo '<option value="' . $zone[$z]['zone'] . '" ' . ($zone[$z]['zone'] == $allacc->zone ? 'selected' : '') . '>' . $zone[$z]['zone'] . '</option>';
        }
        echo '
</select>
</div>
</div>';
    }

    echo '
			
<div class="form-group" style="width:50%; float:left;">
<label class="col-sm-3 control-label">' . $lang[10] . '</label>
<div class="col-sm-9"><input   type="text" name="from_contact" id="from_contact"  value="" /></div>
</div>

		
		
		
<div class="form-group" style="width:50%; float:left;">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9">
		<input   type="text" name="from_phone" id="from_phone"   value="' . $allacc->phone . '" />
				</div>
</div>

<div class="form-group" style="width:50%; float:left;">
<label class="col-sm-3 control-label">' . $lang[120] . '</label>
<div class="col-sm-9">
				<input  type="text" name="from_altphone" id="from_altphone" value="' . $allacc->phone1 . '"/>
				</div>
</div>

				<div style="clear:both;"></div>

					<hr/>	
						
						<div class="form-group" style="font-weight:bold; margin:5px;">
						
	<table>
						<tr>
						<td>' . $lang[357] . '</td>
						<td>
								<table style="width:100%;text-align: center;" >
<tr>
<td style="padding:0px 10px;">before</td>
<td style="padding:0px 10px;">after</td>
<td style="padding:0px 10px;">at</td>
</tr>
								</table>
								</td>
						<td>' . $lang[37] . '</td>
						</tr>
						
								<tr>
								<td><input  type="text" name="pickup_date" id="pickup_date" readonly="true"  validate="notempty"  size="10" value=""  />
								<span id="pickup_Day"></span>
								</td>
								<td>
								
								<table style="width:100%;text-align: center;">

<tr>
<td style="padding:0px 10px;"><input   type="radio" tabindex="8" name="pickup_by"  validate="notempty" value="1" style="background-color: rgb(255, 255, 224);"></td>
<td style="padding:0px 10px;">
<input   type="radio" tabindex="8" name="pickup_by"   validate="notempty" value="2" style="background-color: rgb(255, 255, 224);">
</td>
<td style="padding:0px 10px;">
<input   type="radio" tabindex="8" name="pickup_by"  validate="notempty" value="3" style="background-color: rgb(255, 255, 224);">
</td>
</tr>
</table>
								
								</td>
								<td><input class="form-control"  type="text" name="pickup_time" id="pickup_time" validate="notempty" value="' . date("h:i A") . '"  />
								</td>
								
								</tr>
								
								
								
								
		</table>
						
				</div>

										



<script type="text/javascript">
		
		$(document).ready(function (){

 $( "#pickup_date" ).datepicker({
		dateFormat: \'yy-mm-dd\',
      changeMonth: true,  
        minDate:0,  
	//	 defaultDate: new Date(),
      onSelect: function( selectedDate ) {
        $( "#delivery_date" ).datepicker( "option", "minDate", selectedDate );
		
		 var eventDate = $("#pickup_date").val();
    var dateElement = eventDate.split("-");
    var dateFormat = dateElement[2]+\'-\'+dateElement[0]+\'-\'+dateElement[1];
		var date = new Date(eventDate+\'T10:00:00Z\'); //To avoid timezone issues
    var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var day = weekday[date.getDay()];
				
    		$("#pickup_day").html( "On : " + day );
		
      }
    });
    $( "#delivery_date" ).datepicker({   
		dateFormat: \'yy-mm-dd\',   
      changeMonth: true,   
	defaultDate: new Date(),
      onSelect: function( selectedDate ) {
        $( "#pickup_date" ).datepicker( "option", "maxDate", selectedDate );
		
		 var eventDate = $("#delivery_date").val();
    var dateElement = eventDate.split("-");
    var dateFormat = dateElement[2]+\'-\'+dateElement[0]+\'-\'+dateElement[1];
		var date = new Date(eventDate+\'T10:00:00Z\'); //To avoid timezone issues
    var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var day = weekday[date.getDay()];
				
    		$("#delivery_day").html( "On : " + day );
		
		
      }
			});
		
		$("#pickup_date").datepicker(\'setDate\', new Date());
	//	$("#delivery_date").datepicker(\'setDate\', new Date());
		});
		
		
$(\'#pickup_time\').timepicker({
    timeFormat: \'h:mm p\',
    interval: 15,
	startTime: \'00:00\',
	dynamic: false,
    dropdown: true,
    scrollbar: false
		 
});
		
</script>








				</div>
				</div>
		</div>
		</div>

		<div class="col-xs-4  pricing-box">
		<div class="widget-box">
		<div class="widget-header">
		<div class="widget-title">' . $lang[590] . '</div>
		<div class="widget-toolbar">

				<img src="' . SITEURL . '/style/trial/images/addressbook-icon.png" onclick="show_addrbook(\'to\',\'' . $allacc->account_id . '\');"  width="25" height="20">

				<span class="label label-success" onclick="switchcontact();" name="show-option" title="Click Here to switch contact">
														<i class="ace-icon fa fa-arrow-left icon-on-left"></i>
													</span>

						</div>
		</div>

			<div class="widget-body">
				<div class="widget-main">

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[36] . '</label>
<div class="col-sm-9"><input class="form-control"  type="text" validate="notempty" name="to_name" id="to_name" placeholder="' . $lang[961] . '"  value="" size="25" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><input type="text" class="autocomplete form-control" onfocus="geolocate();" name="to_address" validate="notempty"  id="to_address"  value=""  /></div>
</div>

<div class="form-group" style="width:50%; float:left;" >
<label class="col-sm-3 control-label">' . $lang[9] . '</label>
<div class="col-sm-9"><input class="form-control"  type="text" name="to_pcode"  id="to_pcode"  validate="notempty"  value="" /></div>
</div>';

    if (($c_setting['allow_zones'] == 'Y' || $_SESSION['status'] == '2') && count($zone) > 0) {
        echo '<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[355] . '</label>
<div class="col-sm-9">
<select  class="form-control"  class="form-control"name="to_zone" >
<option value="">' . $lang[356] . '</option>';
        for ($z = 0; $z < count($zone); $z++) {
            echo '<option value="' . $zone[$z]['zone'] . '"  >' . $zone[$z]['zone'] . '</option>';
        }
        echo '
</select>
</div>
</div>';
    }

    echo '
<div class="form-group" style="width:50%; float:left;">
<label class="col-sm-3 control-label">' . $lang[288] . '</label>
<div class="col-sm-9"><input class="form-control"  type="text" name="to_contact" id="to_contact"  value="" /></div>
</div>

<div class="form-group" style="width:50%; float:left;">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9">
		<input class="form-control"  type="text" name="to_phone" id="to_phone"  value="" />
		<input   type="hidden" name="to_altphone" id="to_altphone"  value="" />
		</div>
</div>
		
		
		<div class="form-group" style="width:50%; float:left;">
<label class="col-sm-3 control-label">' . $lang[120] . '</label>
<div class="col-sm-9">
			<input  class="form-control"  type="text" name="to_altphone" id="to_altphone"  value="" />
		</div>
</div>
		
		<div style="clear:both;"></div>
		
		<hr/>

			<div class="form-group" style="font-weight:bold; margin:5px;">
						
	<table >
						<tr>
						<td>' . $lang[358] . '</td>
						<td>
								<table style="width:100%;text-align: center;" >
<tr>
<td style="padding:0px 10px;">before</td>
<td style="padding:0px 10px;">after</td>
<td style="padding:0px 10px;">at</td>
</tr>
								</table>
								</td>
						<td>' . $lang[38] . '</td>
						</tr>
								<tr>
								<td><input class="form-control"  type="text" name="delivery_date" readonly="true"  id="delivery_date"  ' . ($_SESSION['status'] == '2' ? '' : 'validate="notempty"') . '   value="" />
<span id="delivery_day"></span></td>
								<td>
										<table style="width:100%;text-align: center;">
<tr>
<td style="padding:0px 10px;"><input  validate="notempty"   type="radio" tabindex="8" name="deliver_by"  value="1" style="background-color: rgb(255, 255, 224);"></td>
<td style="padding:0px 10px;">
<input   type="radio" tabindex="8"  validate="notempty" name="deliver_by"  value="2" style="background-color: rgb(255, 255, 224);">
</td>
<td style="padding:0px 10px;">
<input  type="radio" tabindex="8"  validate="notempty" name="deliver_by"  value="3" style="background-color: rgb(255, 255, 224);">
</td>
</tr>
</table>
										</td>
								<td><input class="form-control"  type="text" name="delivery_time"  id="delivery_time" validate="notempty"  value=""   />
										</td>
								</tr>
								</table>



</div>


		<script type="text/javascript">
$(\'#delivery_time\').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	showPeriodLabels: true,
	minutes: { interval: 15 }
});
		$(\'#delivery_time\').val("");
</script>


				</div>
				</div>
		</div>
		</div>


		<div class="col-xs-4  pricing-box">

			<div class="widget-box">
		<div class="widget-header">
		<div class="widget-title">' . $lang[39] . '</div>
		</div>

				<div class="widget-body">
				<div class="widget-main">


				<div class="form-group" style="float:left; width:50%;">
<label class="col-sm-3 control-label">' . $lang[824] . '</label>
<div class="col-sm-9"><input class="form-control"  type="text" name="pod" value="" size="10"/></div>
</div>

<div class="form-group" style="float:left; width:50%;">
<label class="col-sm-3 control-label">' . $lang[866] . '</label>
<div class="col-sm-9"><input class="form-control"  type="text" name="pop" value="" size="10" /></div>
</div>


<div class="form-group" style="float:left; width:50%;" >
<label class="col-sm-3 control-label">' . $lang[41] . '</label>
<div class="col-sm-9"><input class="form-control"  type="text" name="refrence" value="" /></div>
</div>

<div class="form-group" style="float:left; width:50%;" >
<label class="col-sm-3 control-label">' . $lang[40] . '</label>
<div class="col-sm-9"><input class="form-control"  type="text" name="orderby" value=""/></div>
</div>




<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[42] . '</label>
<div class="col-sm-9"><input class="form-control"  type="text" name="confirmation_email" value="" size="30" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[410] . '</label>
<div class="col-sm-9"><input   type="checkbox" name="return" value="1"  /></div>
</div>';

    if (is_array($services) && count($services) > 0) {
        echo '<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[44] . '</label>
<div class="col-sm-9">
<select  class="form-control"  class="form-control" name="service_id" validate="notempty" id="services_comb">
<option value="">' . $lang[587] . '</option>';

        for ($i = 0; $i < count($services); $i++) {
            echo '<option value="' . $services[$i]['service_id'] . '" auto_delivery="' . $services[$i]['service_deliverytime'] . '" cut_off="' . $services[$i]['service_cutoff'] . '" max_distance="' . $services[$i]['service_maxdistance'] . '">' . $services[$i]['service_short'] . '</option>';
        }
        echo '</select>
</div>
</div>';
    }
    if (is_array($tran) && count($tran) > 0) {
        echo '
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[45] . '</label>
<div class="col-sm-9">
<select  class="form-control"  class="form-control" name="transport_type">
<option value="Any">' . $lang[763] . '</option>
';

        for ($i = 0; $i < count($tran); $i++) {
            echo '<option value="' . $tran[$i]['transport_id'] . '">' . $tran[$i]['trnasport_type'] . '</option>';
        }

        echo '
</select>
</div>

</div>
';
    }


    if (is_array($drivers) && count($drivers) > 0) {
        echo '
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[284] . '</label>
<div class="col-sm-9">
<select  class="form-control" name="driver_id">
<option value="">' . $lang[380] . '</option>
';

        for ($i = 0; $i < count($drivers); $i++) {
            echo '<option value="' . $drivers[$i]['id'] . '">' . $drivers[$i]['driverno'] . '|' . $drivers[$i]['name'] . '</option>';
        }

        echo '
</select>
</div>

</div>
';
    }


    echo '
		';


    if (is_array($addser) && count($addser) > 0) {
        echo '
			<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[323] . '</label>
<div class="col-sm-9">

	<select name="vec_services[ ]" multiple="" class="chosen-select" id="form-field-select-4" data-placeholder="Choose a State...">
					';
        for ($a = 0; $a < count($addser); $a++) {
            echo '<option value="' . $addser[$a]['id'] . '" >' . $addser[$a]['name'] . '</option>';
        }
        echo '</select>
		
			</div>
			</div>';
    }


    if ((is_array($check) && count($check) > 0) && ($_SESSION['status'] == '2' || ($_SESSION['status'] == "1" && $c_setting['show_addtional'] == 'Y'))) {
        echo '
			<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[252] . '</label>
<div class="col-sm-9">

	<select name="add_services[ ]" multiple="" class="chosen-select"  >
					';
        for ($a = 0; $a < count($check); $a++) {
            echo '<option value="' . $check[$a]['id'] . '" >' . $check[$a]['name'] . '</option>';
        }
        echo '</select>

			</div>
			</div>';
    }


    echo '
	    	</div>
		</div>
    </div>
</div>

			</div>
			
			<div class="row">
			
			<div class="col-xs-12  widget-container-col " style="min-height: 127px;">
										<div class="widget-box ui-sortable-handle collapsed" style="opacity: 1; z-index: 0;">
											<!-- #section:custom/widget-box.header.options -->
											<div class="widget-header widget-header-large">
												<h4 class="widget-title">Advanced Options</h4>

												<div class="widget-toolbar">
												

													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-down"></i>
													</a>

													
												</div>
											</div>

											<!-- /section:custom/widget-box.header.options -->
											<div class="widget-body" style="display: none;">
												<div class="widget-main">
			
			
			<div class="row">
			';
    if ($c_setting['co_package_details'] == 'Y') {
        echo '
			<div class="col-xs-5" id="package_details_skid" style="margin-left:10px;">
			<h3 class="header smaller lighter green">' . $lang[46] . '</h3>
';
        if ($c_setting['company_skid'] != "1") {
            echo '
<div class="form-group" >
<label class="col-sm-3 control-label"  >' . $lang[362] . ' </label>
<div class="col-sm-9" >
<select  class="form-control" name="package_type_s">
<option value="" >' . $lang[362] . ' </option>';
            for ($i = 0; $i < count($pack); $i++) {
                echo '<option value="' . $pack[$i]['package_id'] . '">' . $pack[$i]['package_name'] . '</option>';
            }
            echo '
</select>
</div>
</div>';
        }

        echo '<div class="form-group" >
<label class="col-sm-3 control-label" >' . ($c_setting['company_skid'] == "1" ? $lang[608] : $lang['867']) . ' </label>
<div class="col-sm-9"><input class="form-control"  type="text" name="pieces_s" value="1" onload="add_package_row(this.value);" onblur="add_package_row(this.value)" size="5" /></div>
</div>
<div style="clear:both;"></div>
		';
        echo '<div class="form-group" >
<label class="col-sm-3 control-label" >' . ($c_setting["company_skid"] == 1 ? $lang['566'] : $lang['43']) . ' (' . $c_setting['co_uom_weight'] . ')</label>
<div class="col-sm-9" ><input class="form-control"  type="text" name="weight_s" value=""  size="3"/></div>
</div>
<div class="form-group" >
<label class="col-sm-3 control-label" >' . ($c_setting["company_skid"] == 1 ? $lang['567'] : $lang['47']) . '  (' . $c_setting['co_uom_volume'] . ')</label>
<div class="col-sm-9" ><input class="form-control"  type="text" name="volume_s" value=""  size="3"/></div>
</div>
</td></tr>';
        echo '<tr>
<td colspan="2">
	
<table width="98%" style="
    font-size: 9px;
" align="center" id="multi_package" border="1" class="table table-striped table-bordered table-hover">
<tr>
<th style="padding:2px;">' . $lang[43] . '  (' . $c_setting['co_uom_weight'] . ')</th>
<th style="padding:2px;">' . $lang[47] . '  (' . $c_setting['co_uom_volume'] . ')</th>
<th style="padding:2px;">' . $lang[936] . '</th>
<th style="padding:2px;">' . $lang[59] . '</th>
</tr>
<tr>
<td style="padding:2px;"><input class="form-control"  type="text" name="weight[]" size="2" /></td>
<td style="padding:2px;"><input class="form-control"  type="text" name="volume[]" size="2" /></td>
<td style="padding:2px;"><input class="form-control"  type="text" name="parts[]" size="2" /></td>
<td style="padding:2px;"><input class="form-control"  type="text" name="details[]" size="5" /></td>
</tr>
</table>
		</div>
';
        //	echo '</div>';
    }


    echo '<div class="col-xs-3">
			<h3 class="header smaller lighter green">Details</h3>
					
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[359] . '</label>
<div class="col-sm-9">
<textarea  class="form-control" name="comment" id="comment" rows="2" cols="30">' . $order_details->order_comment . '</textarea>


</div>
</div>
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[360] . '</label>
<div class="col-sm-9">
<textarea  class="form-control" name="description" id="description" rows="2" cols="30">' . $order_details->order_des . '</textarea>

    
</div>
</div>
		
</div>
		
		
		
			
		
		
		
		';

    if ($c_setting['tracking'] == 'Y') {
        echo '
	<div class="col-xs-2" id="package_details_skid">
	<h3 class="header smaller lighter green">' . $lang[923] . '</h3>
				
	
	
				<div class="form-group">
<label class="col-sm-3 control-label"  >' . $lang[924] . '</label>
<div class="col-sm-9">
<input class="form-control"  type="text" name="tracking_sender" id="tracking_sender" value="' . $account_emails . '"  />
		</div>
		</div>
	
		<div class="form-group">
<label class="col-sm-3 control-label"  >' . $lang[925] . '</label>
<div class="col-sm-9">
<input class="form-control"  type="text" name="tracking_receiver" id="tracking_receiver" value=""  />
		</div>
		</div>
	
	
		<div class="well">' . $lang[926] . '</div>
	

				</div>
	
	';
    }

    if ($c_setting['allow_payment_details'] == 'Y') {
        echo '
				
				<div class="col-xs-2" >
	<h3 class="header smaller lighter green">Payment Details</h3>
			
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[361] . '</label>
<div class="col-sm-9"><input  type="checkbox" name="COD_S" value="1" ></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label"  >' . $lang[565] . '</label>
<div class="col-sm-9">
<input class="form-control"  type="text" name="collect" value=""  size="5"/>
		</div>
		</div>';

        echo '<div class="form-group" >
<label class="col-sm-3 control-label"  >' . $lang[585] . ' </label>
<div class="col-sm-9" >
<select  class="form-control" name="payment_type_s" style=" ">
<option value="" >' . $lang[162] . '</option>
';
        for ($i = 0; $i < count($pay); $i++) {
            echo '<option value="' . $pay[$i]['payment_id'] . '">' . $pay[$i]['payment_name'] . '</option>';
        }

        echo '
</select>
</div>
</div>';

        echo '<div class="form-group" >
<label class="col-sm-3 control-label">' . $lang[351] . '</label>
<div class="col-sm-9">
<input class="form-control"  type="text" name="declared_value" value="" />
</div>
</div>
		
				
			</div>
				
		

		';
    }

    echo '
		
			
			
				</div>
				
												</div>
											</div>
										</div>
									</div>
			
		';


    echo '

	<div style="clear:both;"></div>

<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">

		
		<input type="button" onclick="add_orders(\'addorder\',\'normal\');" id="addorder_button" value="Save"  name="addorder" class="btn btn-info"/>&nbsp;&nbsp;&nbsp;

			<!--
			<input type="button" onclick="add_orders(\'addorder\',\'montior\');" value="Save & Close"  name="addorder" class="btn btn-info"/>&nbsp;&nbsp;&nbsp;
<input type="button" onclick="add_orders(\'addorder\',\'waybill\');" value="Save & Print"  name="addorder" class="btn btn-info"/>&nbsp;&nbsp;&nbsp;
<input type="button" onclick="add_orders(\'addorder\',\'addnew\');" value="Save & New"  name="addorder" class="btn btn-info"/>&nbsp;&nbsp;&nbsp;	
		-->
		';

    if ($_SESSION['status'] == 2) {
        echo '<input type="button" onclick="add_orders(\'estimate\',\'normal\');" value="' . $lang[52] . '"  class="btn btn-danger "/>';
    } elseif ($c_setting["custflag"] != "3" && $c_setting["custflag"] != "1") {
        echo '<input type="button" onclick="add_orders(\'estimate\',\'normal\');" value="' . $lang[52] . '" class="btn "/>';
    }

    echo '</div>



</div>








</form>

<div id="result"></div>
<div id="address" title="' . $lang[382] . '" style="font-size:12px;" >

</div>
<div style="clear:both; "></div>
		<script src="https://maps.googleapis.com/maps/api/js?key=' . $c_setting['googlemap_api'] . '&libraries=places&callback=initAutocomplete" async defer></script>
		
';
}

function error_msg($msg)
{
    global $lang;

    $x = '<div class="alert alert-danger">
															<button type="button" class="close" data-dismiss="alert">
																<i class="ace-icon fa fa-times"></i>
															</button>

															<strong>
																<i class="ace-icon fa fa-times"></i>
																Oh snap!
															</strong>

															' . $msg . '
															<br>
														</div>';
    return $x;
}

function notification_msg($msg)
{
}



function template_main_console()
{
    global $lang, $grid, $html_grid, $n_ids, $action, $count, $start,$url,$no_search;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>
		
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/montior.js"></script>


<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/console.js"></script>

';


    echo '
    <div class="row" style=" width:100%;  float:right; border-bottom: 1px solid #ddd;
    background: #4692bf;">
    <div class="col-xs-6">
';
    if ($_SESSION['user_type'] == "2") {
        echo '
        <p>
        <button class="btn btn-primary" onclick="print_barcode();">
        <i class="ace-icon fa fa-print align-top bigger-125"></i>
                                            طباعة
        </button>
        
        <button class="btn btn-primary" onclick="print_outside();">
        <i class="ace-icon fa fa-print align-top bigger-125"></i>
                                        خارجية 	طباعة
        </button>
        </p>


        ';
    }

    echo '
    </div>
    <div class="col-xs-6" style="padding:10px;">';
    if ($no_search != '1') {
        echo '<input type="text" id="search_grid" url="'.$url.''.(strpos($url, '?') !== false ? '&' : '?').'ajax=1"  class=" input-sm" style="float:left; margin-left:20px;"  value=""  placeholder="بحث" >
    ';
    }
    echo '</div>
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
