<?php

function template_overall_header()
{
    global $lang, $page_title;

    echo '
                <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8"/>
            <meta name="description" content="overview &amp; stats" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
                
                <title>' . SITENAME . ' - ' . $page_title . '</title>
                <!-- bootstrap & fontawesome -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap.min.css" />
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap-timepicker.css" />
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/font-awesome.min.css" />
                <!-- page specific plugin styles -->
                
            <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/jquery-ui.min.css" />
                        
                        
                <!-- page specific plugin styles -->
        
                <!-- text fonts -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-fonts.css" />
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/chosen.css" />
        
                 <!-- Start koko -->
                 <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ui.jqgrid.css" />
                 <!end koko -->
        
                <!-- ace styles -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.min.css" id="main-ace-style" />
                
                <!--[if lte IE 9]>
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-part2.min.css" />
                <![endif]-->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-skins.min.css" />
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-rtl.min.css" />
        
                <!--[if lte IE 9]>
                  <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-ie.min.css" />
                <![endif]
                <link href="' . SITEURL . '/' . STYLE . '/css/jquery.datetimepicker.css" type="text/css" rel="stylesheet" />
                -->
              

                <!-- inline styles related to this page -->
        
                <!-- ace settings handler -->
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/ace-extra.min.js"></script>
                
                
                
        
                <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
        
                <!--[if !IE]> -->
                
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.min.js"></script> 
            

                <!-- <![endif]-->
                
                 <!-- Start koko -->
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jqGrid/i18n/grid.locale-en.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jqGrid/jquery.jqGrid.min.js"></script>
                 <!-- End koko -->
                
                <!--[if lte IE 8]>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/html5shiv.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/respond.min.js"></script>
                <![endif]-->
                    
                <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/validation.js"></script>
                <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/main.js"></script>
                <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
                    
                <!--<script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery-ui.custom.min.js"></script>-->
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.ui.touch-punch.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/chosen.jquery.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/fuelux/fuelux.spinner.min.js"></script>
                <!--<script src="' . SITEURL . '/' . STYLE . '/assets/js/date-time/bootstrap-datepicker.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/date-time/bootstrap-timepicker.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/date-time/moment.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/date-time/daterangepicker.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/date-time/bootstrap-datetimepicker.min.js"></script>-->
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/bootstrap-colorpicker.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.knob.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.autosize.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.maskedinput.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/bootstrap-tag.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/typeahead.jquery.min.js"></script>
                        
        
                <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/jquery.scannerdetection.js"></script>
                <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/console.js"></script>

            <script type="text/javascript">
            var siteurl = \'' . SITEURL . '\';
                    
            var FORMURL = \'' . formurl . '\';
        
            var userstatus = \'' . $_SESSION['user_type'] . '\' ;
            var image_only = \'' . $_SESSION['user_action'] . '\'
                    
        
                    
            
                    
            </script>
                    
                    <style type="text/css">
                    
                    @media print {
               .removeprint {display:none}
             table td.removeprint {display:none}
               table th.removeprint {display:none}
           }
                    
                    </style>
                    
        
        
                    <style>
                    .btn.btn-app.btn-xs{
                        width:25px !important;
                        height:25px !important;
                        font-size : 12px;
                        padding-top:1px;
                        padding-bottom:1px;
                    }
                    </style>
                    
                    
            </head>
        
            <body class="skin-3 no-skin rtl">
        <div id="ScannerDialoge" style="display:none;">
        
        <table id="scanner_data" class="dataTable table table-striped table-bordered table-hover  " >
        <thead>
        <tr>
        <th>رقم الطلبية</th>
        <th>حالة الشغل</th>
        <th>طول</th>
        <th>عرض</th>
        <th>نوع الزجاج</th>
        <th>لون الزجاج</th>
      <!--   <th>الطباعة</th> -->
        <th>مسطح</th>
       <!--  <th>سنفرة</th> -->
        <th>التخليع</th>
        <th></th>
        </tr>
        </thead>
        
        </table>
        </div>
        
                <div id="address_dialoge" ></div>	
            <div id="address_dialoge_option" ></div>
        <div class="modal"></div>
        <div id="page" ></div>
        
   <div id="review_invo" style="display:none"; > 
     <div class="form-group">
     <label class="col-sm-3 control-label">قيمة الخصم</label>
     <div class="col-sm-9"><input class="form-control"  type="number" id="discountEntered"  value=""  /></div>
     </div>
</div>

        <div id="result_dialoge" ></div>
        <div id="result_dialoge_2" ></div>
        
        <div id="result_console"></div>
        
        ';
}

function template_header()
{
    echo '
            <!-- #section:basics/navbar.layout -->
                <div id="navbar" class="navbar navbar-default">
                    <script type="text/javascript">
                        try{ace.settings.check(\'navbar\' , \'fixed\')}catch(e){}
                    </script>
        
                    <div class="navbar-container" id="navbar-container">
                        <!-- #section:basics/sidebar.mobile.toggle -->
                        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
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
                                    <i class="fa fa-bicycle red"></i>
                                    ' . SITENAME . '
                                </small>
                            </a>
        
                            <!-- /section:basics/navbar.layout.brand -->
        
                            <!-- #section:basics/navbar.toggle -->
        
                            <!-- /section:basics/navbar.toggle -->
                        </div>
        
                
                    </div><!-- /.navbar-container -->
                </div>
                
                
                        <div class="main-container" id="main-container">
                
                                                    
                ';
}


function home_button()
{
}


function template_menu_1()
{
    global $lang, $breadarray, $c_setting;
    echo '
                            <!-- #section:basics/sidebar -->
                    <div id="sidebar" class="sidebar                  responsive">
                        <script type="text/javascript">
                            try{ace.settings.check(\'sidebar\' , \'fixed\')}catch(e){}
                        </script>
        
        
        
                        <ul class="nav nav-list">
                            <li class="">
                                <a href="' . SITEURL . '">
                                    <i class="menu-icon fa fa-tachometer"></i>
                                    <span class="menu-text"> ' . $lang[1] . ' </span>
                                </a>
        
                                <b class="arrow"></b>
                            </li>
        
                            <li class="">
                                <a href="' . SITEURL . '/index.php?action=aboutus">
                                    <i class="menu-icon fa fa-tachometer"></i>
                                    <span class="menu-text"> ' . $lang[2] . ' </span>
                                </a>
        
                                <b class="arrow"></b>
                            </li>
                                            
                            <li class="">
                                <a href="' . SITEURL . '/index.php?action=contactus">
                                    <i class="menu-icon fa fa-tachometer"></i>
                                    <span class="menu-text">' . $lang[3] . '</span>
                                </a>
        
                                <b class="arrow"></b>
                            </li>
                                            
                            <li class="">
                                <a href="' . SITEURL . '/index.php?action=register">
                                    <i class="menu-icon fa fa-tachometer"></i>
                                    <span class="menu-text">' . $lang[4] . '</span>
                                </a>
        
                                <b class="arrow"></b>
                            </li>
                                        
                            ';
    if ($c_setting['tracking'] == 'Y') {
        echo '
                            <li class="">
                                <a href="' . SITEURL . '/index.php?action=tracking">
                                    <i class="menu-icon fa fa-tachometer"></i>
                                    <span class="menu-text">' . $lang[937] . '</span>
                                </a>
        
                                <b class="arrow"></b>
                            </li>
                            ';
    }
    echo '													
                            <li class="">
                                <a href="#" class="dropdown-toggle">
                                    <i class="menu-icon fa fa-desktop"></i>
                                    <span class="menu-text"> Login</span>
        
                                    <b class="arrow fa fa-angle-down"></b>
                                </a>
        
                                <b class="arrow"></b>
        
                                <ul class="submenu">
                                    <li class="">
                                        <a href="' . SITEURL . '/client" >
                                            <i class="menu-icon fa fa-caret-right"></i>
        
                                            ' . $lang[16] . '
                                            
                                        </a>
        
                                        <b class="arrow"></b>
        
                                        
                                    </li>
        
                                    <li class="">
                                        <a href="' . SITEURL . '/administrator">
                                            <i class="menu-icon fa fa-caret-right"></i>
                                            ' . $lang[20] . '
                                        </a>
        
                                        <b class="arrow"></b>
                                    </li>
        
                                
                                </ul>
                            </li>
        
                            
                            
                        </ul><!-- /.nav-list -->
        
                        <!-- #section:basics/sidebar.layout.minimize -->
                        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                            <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                        </div>
        
                        <!-- /section:basics/sidebar.layout.minimize -->
                        <script type="text/javascript">
                            try{ace.settings.check(\'sidebar\' , \'collapsed\')}catch(e){}
                        </script>
                    </div>
                                                    
                <div class="main-content">
                                                    ' . breadcrumbs() . '
                        <!-- /section:basics/content.breadcrumbs -->
                        <div class="page-content">
                            <!-- #section:settings.box -->
                            <div class="ace-settings-container" id="ace-settings-container">
                                <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                                    <i class="ace-icon fa fa-cog bigger-150"></i>
                                </div>
        
                                <div class="ace-settings-box clearfix" id="ace-settings-box">
                                    <div class="pull-left width-50">
                                        <!-- #section:settings.skins -->
                                        <div class="ace-settings-item">
                                            <div class="pull-left">
                                                <select id="skin-colorpicker" class="hide">
                                                    <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                                    <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                                    <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                                    <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                                </select>
                                            </div>
                                            <span>&nbsp; Choose Skin</span>
                                        </div>
        
                                        <!-- /section:settings.skins -->
        
                                        <!-- #section:settings.navbar -->
                                        <div class="ace-settings-item">
                                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                                            <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                                        </div>
        
                                        <!-- /section:settings.navbar -->
        
                                        <!-- #section:settings.sidebar -->
                                        <div class="ace-settings-item">
                                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                                            <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                                        </div>
        
                                        <!-- /section:settings.sidebar -->
        
                                        <!-- #section:settings.breadcrumbs -->
                                        <div class="ace-settings-item">
                                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                                            <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                                        </div>
        
                                        <!-- /section:settings.breadcrumbs -->
        
                                        <!-- #section:settings.rtl -->
                                        <div class="ace-settings-item">
                                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                                            <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                                        </div>
        
                                        <!-- /section:settings.rtl -->
        
                                        <!-- #section:settings.container -->
                                        <div class="ace-settings-item">
                                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                                            <label class="lbl" for="ace-settings-add-container">
                                                Inside
                                                <b>.container</b>
                                            </label>
                                        </div>
        
                                        <!-- /section:settings.container -->
                                    </div><!-- /.pull-left -->
        
                                    <div class="pull-left width-50">
                                        <!-- #section:basics/sidebar.options -->
                                        <div class="ace-settings-item">
                                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
                                            <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                                        </div>
        
                                        <div class="ace-settings-item">
                                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
                                            <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                                        </div>
        
                                        <div class="ace-settings-item">
                                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
                                            <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                                        </div>
        
                                        <!-- /section:basics/sidebar.options -->
                                    </div><!-- /.pull-left -->
                                </div><!-- /.ace-settings-box -->
                            </div><!-- /.ace-settings-container -->
        
                            <!-- /section:settings.box -->
                            <div class="page-content-area">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <!-- PAGE CONTENT BEGINS -->
                                                    
                                                    
                                    
        ';
}

function template_index()
{
    global $page, $c_setting, $lang;
    global $showicon_admin, $showicon_client, $showicon_register, $showicon_tracking, $showicon_pricing;
    global $button, $me;


    //echo $button;
    $url = curPageURL(SITEURL);
    //	echo $url;

    if ($button == "") {
        $x = '
                <div style="padding-top:10px; background:#fff; height:100%; text-align:center; font-weight:bold; font-size:16px; color:#438eb9;">
                
                <h1>' . SITENAME . '</h1>';


        //echo $url.'--'.SITEURL;

        if ($showicon_admin == true || ($url == SITEURL . '/' || $url == SITEURL . '/index.php')) {
            $x .= '
                    <div class="icon">
                    <a href="' . SITEURL . '/administrator" class="btn btn-info btn-app radius-4">
                    <i class="ace-icon fa fa-user-plus bigger-230"></i>
                    Admin
                    </a>';
        }

        if ($showicon_client == true || ($url == SITEURL . '/' || $url == SITEURL . '/index.php')) {
            $x .= '
                    <a href="' . SITEURL . '/client" class="btn btn-info btn-app radius-4">
                    <i class="ace-icon fa fa-user-circle-o bigger-230"></i>
                    Client
                    </a>';
        }

        if ($showicon_register == true || ($url == SITEURL . '/' || $url == SITEURL . '/index.php')) {
            $x .= '
                    <a href="' . SITEURL . '/index.php?action=register" class="btn btn-info btn-app radius-4">
                    <i class="ace-icon fa fa-pencil-square bigger-230"></i>
                    Register
                    </a>';
        }


        if ($showicon_tracking == true || ($url == SITEURL . '/' || $url == SITEURL . '/index.php')) {
            if ($c_setting['tracking'] == 'Y') {
                $x .= '<a href="' . SITEURL . '/index.php?action=tracking" class="btn btn-info btn-app radius-4">
                        <i class="ace-icon fa fa-search bigger-230"></i>
                        Tracking
                        </a>';
            }
        }


        if ($showicon_pricing == true || ($url == SITEURL . '/' || $url == SITEURL . '/index.php')) {
            if ($c_setting['guestpricing'] == 'Y') {
                $x .= '<a href="' . SITEURL . '/index.php?action=pricing" class="btn btn-info btn-app radius-4">
                                                        <i class="ace-icon fa fa-money  bigger-230"></i>
                                                        Pricing
                                                    </a>';
            }
        }

        $x .= '</div>	
                          <div style="clear:both;"></div>
                          </div>
                          <div style="clear:both;"></div>';
    }

    if ($me == "1") {
        echo $x;
    } else {
        return $x;
    }
}


function template_register()
{
    global $lang, $c_setting;


    echo '				
        <script src=\'https://www.google.com/recaptcha/api.js\'></script>
        <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/home.js"></script>
        
                ' . template_index() . '
        <div style="width:1000px; margin:auto;">
                            <div class="page-header" >
                                    <h1>
                                        ' . $lang[5] . '
                                    </h1>
                                </div><!-- /.page-header -->
                
        
        <form name="register_client" id="register_client" method="post" action="' . SITEURL . '/index.php?action=register" class="form-horizontal" >
        
                <div class="col-xs-4">
        
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[6] . ' * </label>
        <div class="col-sm-9"><input type="text" name="companyname" validate="notempty" value="" size="30"  /></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[7] . ' * </label>
        <div class="col-sm-9"><textarea name="address"  cols="40"  validate="notempty" class="control-form" style="height: 81px"></textarea></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[8] . ' * </label>
        <div class="col-sm-9"><input type="text" name="city" validate="notempty" value="" size="30"/></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[9] . ' * </label>
        <div class="col-sm-9"><input type="text" name="pcode" validate="notempty" value="" size="30"/></div>
        </div>
        
        
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[10] . ' * </label>
        <div class="col-sm-9"><input type="text" name="contact" validate="notempty" value="" size="30"/></div>
        </div>
        
        
        </div>
        
        <div class="col-xs-4">
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[11] . ' * </label>
        <div class="col-sm-9"><input type="text" name="phone" validate="notempty" value="" size="30"/></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[12] . '</label>
        <div class="col-sm-9"><input type="text" name="fax"  value="" size="30"/></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[13] . ' * </label>
        <div class="col-sm-9"><input type="text" name="email" validate="notempty" validate_type="email" value="" size="30" /></div>
        </div>
                
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">How did you hear about us? * </label>
        <div class="col-sm-9">
                <select name="market_way" validate="notempty">
                <option value="" >Select Option</option>';
    global $mar;
    for ($i = 0; $i < count($mar); $i++) {
        echo '<option value="' . $i . '">' . $mar[$i] . '</option>';
    }

    echo '</select>	</div>
        </div>
                
            <!--Start koko -->
            
            <div class="form-group" id="terms_check" >
            <div class="col-sm-9">
            <input type="checkbox" name="terms_checkbox"  validate_type="terms_checkbox" value="check"  /> I have read and agree to the <a href="' . SITEURL . '/index.php?action=terms_condition" target="_blank"> Terms and Conditions </a> and Privacy Policy *
            </div>
            </div>
        
        <!--End koko -->
                
                
                <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> * </label>
        <div class="col-sm-9">
                <div class="g-recaptcha" data-sitekey="6LcnTSkTAAAAAOmeV601iujCamXRqr3OmpzwBvOl"></div>
        </div>
                </div>
                <span>* Required</span>
                </div>
                
                <div class="col-xs-4">
                <div class="well">
            <h3 class="lighter smaller blue " style="font-weight:bold;">	' . $lang[571] . '</h3>
                    </div>
                </div>
                
                <div style="clear:both;"></div>
                
                             <div class="clearfix form-actions">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button class="btn btn-info" type="button" id="submit" name="c_reg">
                                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                                        ' . $lang[14] . '
                                                    </button>
        
                                                    &nbsp; &nbsp; &nbsp;
                                                    <button class="btn" type="reset" onclick="$(\'#register_client\').clearForm();">
                                                        <i class="ace-icon fa fa-undo bigger-110"></i>
                                                        Reset
                                                    </button>
                                                </div>
                                            </div>
                </form>
        
        <div id="result" style="">
        </div>
                                                                </div>
        ';
}

//Start koko

function template_terms_condition()
{
    global $lang, $c_setting;
    echo '
	   
	
	              <div class="form-group c">
	              <div class="form-group" id="terms" >' . $lang[592] . '</div>
                  <div  id="terms_content">' . $c_setting['co_terms'] . '</div>
				   </div>';
}


function template_login_client()
{
    global $lang, $error;
    echo '
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
                <meta charset="utf-8" />
                <title>' . SITENAME . ' - ' . $page_title . '</title>
        
                <meta name="description" content="User login page" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        
                <!-- bootstrap & fontawesome -->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap.min.css" />
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/font-awesome.min.css" />
        
                <!-- text fonts -->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-fonts.css" />
        
                <!-- ace styles -->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.min.css" />
        
                <!--[if lte IE 9]>
                    <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-part2.min.css" />
                <![endif]-->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-rtl.min.css" />
        
                <!--[if lte IE 9]>
                  <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-ie.min.css" />
                <![endif]-->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.onpage-help.css" />
        
                <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        
                <!--[if lt IE 9]>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/html5shiv.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/respond.min.js"></script>
                <![endif]-->
            </head>
        
            <body class="login-layout">
                <div class="main-container">
                    <div class="main-content">
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="login-container">
                                    <div class="center">
                                        <h1>
                                            <i class="ace-icon fa fa-car green"></i>
                                            <span class="red">' . $lang[16] . '</span>
                                            
                                        </h1>
                                        <h4 class="blue" id="id-company-text">&copy; ' . SITENAME . '</h4>
                                    </div>
        
                                    <div class="space-6"></div>
        
                                    <div class="position-relative">
                                        <div id="login-box" class="login-box visible widget-box no-border">
                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <h4 class="header blue lighter bigger">
                                                        <i class="ace-icon fa fa-coffee green"></i>
                                                                ' . $lang[570] . '
                                                    </h4>
        
                                                    ';
    if (isset($_GET['e'])) {
        echo '<div class="well red bold" style="font-weight:bold;">' . $error[$_GET['e']] . '</div><div style="clear:both;"></div>';
    }

    echo '
                                                    <div class="space-6"></div>
        
                                                    <form name="client_login" method="post" action="' . SITEURL . '/client/login.php?action=login">
                                                        <fieldset>
                                                            <label class="block clearfix">
                                                                <span class="block input-icon input-icon-right">
                                                                    <input type="text" class="form-control" name="account_name" placeholder="' . $lang[17] . '" />
                                                                    <i class="ace-icon fa fa-user"></i>
                                                                </span>
                                                            </label>
        
                                                            <label class="block clearfix">
                                                                <span class="block input-icon input-icon-right">
                                                                    <input type="text" class="form-control"  name="user_name" placeholder="' . $lang[18] . '" />
                                                                    <i class="ace-icon fa fa-user"></i>
                                                                </span>
                                                            </label>
        
                                                            <label class="block clearfix">
                                                                <span class="block input-icon input-icon-right">
                                                                    <input type="password" class="form-control" name="user_pass" placeholder="' . $lang[19] . '" />
                                                                    <i class="ace-icon fa fa-lock"></i>
                                                                </span>
                                                            </label>
                                                                            
                                                        <label class="block clearfix">
                                                                <span class="block input-icon input-icon-right">
                                                                            <select name="language" class="form-control">
                                                                            <option value="">Select Language</option>
                                                                            <option value="en">English</option>
                                                                            <option value="gr">German</option>
                                                                            
                                                                            </select>
                                                                </span>
                                                            </label>
                                                                            
        
                                                            <div class="space"></div>
        
                                                            <div class="clearfix">
                                                                <label class="inline">
                                                                    <input type="checkbox" class="ace" />
                                                                    <span class="lbl"> Remember Me</span>
                                                                </label>
        
                                                                <button type="submit" class="width-35 pull-right btn btn-sm btn-primary name="login"">
                                                                    <i class="ace-icon fa fa-key"></i>
                                                                    <span class="bigger-110">' . $lang[21] . '</span>
                                                                </button>
                                                            </div>
        
                                                            <div class="space-4"></div>
                                                        </fieldset>
                                                    </form>
        
                                                    
        
                                                    
        
                                                    
                                                </div><!-- /.widget-main -->
        
                                                <div class="toolbar clearfix">
                                                    <div>
                                                        <a href="' . SITEURL . '"  class="forgot-password-link">
                                                            <i class="ace-icon fa fa-arrow-left"></i>
                                                            ' . $lang[1] . '
                                                        </a>
                                                    </div>
        
                                                    <div>
                                                        <a href="' . SITEURL . '/index.php?action=register"  class="user-signup-link">
                                                            ' . $lang[829] . '
                                                            <i class="ace-icon fa fa-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div><!-- /.widget-body -->
                                        </div><!-- /.login-box -->
        
                                    
                                    
                                    </div><!-- /.position-relative -->
        
                                    
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.main-content -->
                </div><!-- /.main-container -->
        
                <!-- basic scripts -->
        
                <!--[if !IE]> -->
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.min.js"></script>
                <!-- <![endif]-->
        
                <!--[if IE]>
        <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery1x.min.js"></script>
        <![endif]-->
                <script type="text/javascript">
                    if(\'ontouchstart\' in document.documentElement) document.write("<script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.mobile.custom.min.js"></script>");
                </script>
        
                <!-- inline scripts related to this page -->
        
            </body>
        </html>
                
                
        
        
        ';
}


function template_forget_password()
{
    global $lang, $error, $page_title;

    echo '
                <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        
            
                <title>' . SITENAME . ' - ' . $page_title . '</title>
            
                <meta name="description" content="User login page" />
                
                        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
            
                        <meta name="viewport" content="user-scalable=0, initial-scale=1.0">
                        
                        
                <!-- bootstrap & fontawesome -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap.min.css" />
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/font-awesome.min.css" />
            
                <!-- text fonts -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-fonts.css" />
            
                <!-- ace styles -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.min.css" />
            
                <!--[if lte IE 9]>
                    <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-part2.min.css" />
                <![endif]-->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-rtl.min.css" />
            
                <!-- page specific plugin styles -->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/jquery-ui.min.css" />
            
            
                <!--[if lte IE 9]>
                  <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-ie.min.css" />
                <![endif]-->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.onpage-help.css" />
            
                <script src=\'https://www.google.com/recaptcha/api.js\'></script>
            
                <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
            
                <!--[if lt IE 9]>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/html5shiv.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/respond.min.js"></script>
                <![endif]-->
            
            
                
            </head>
            
            <body class="login-layout">
            <div id="result" ></div>
                <div class="main-container">
                    <div class="main-content">
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
            
                            <div class="login-container">
                            <div class="center">
                                <h1>
                                    <i class="ace-icon fa fa-car green"></i>
                                    <span class="red">' . $lang[20] . '</span>
                                    
                                </h1>
                                <h4 class="blue" id="id-company-text">&copy; ' . SITENAME . '</h4>
                            </div>
            
                            <div class="space-6"></div>
            
                            <div class="position-relative">
            
            
            
                            <div id="forgot-box" class="forgot-box widget-box no-border visible" style="visibility: visible">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header red lighter bigger">
                                        <i class="ace-icon fa fa-key"></i>
                                        Retrieve Password
                                    </h4>
            
                                    <div class="space-6"></div>
                                    <p>
                                        Enter your email to receive instructions
                                    </p>
            
                                    <form id="forget_password" name="forget_password" action="' . SITEURL . '/administrator/login.php?action=forget_password" method="post">
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="email" name="email" class="form-control" placeholder="Email" validate="notempty" />
                                                    <i class="ace-icon fa fa-envelope"></i>
                                                </span>
                                            </label>
            
            
                                        
                                            <label class="block clearfix">
                                            
                                                    <div class="g-recaptcha" data-sitekey="6LcnTSkTAAAAAOmeV601iujCamXRqr3OmpzwBvOl"></div>
                                        
                                                    
                                                    </label>
                                                    
            
            
            
                                            <div class="clearfix">
                                                <button type="button" onclick="forgetpassword();" class="width-35 pull-right btn btn-sm btn-danger">
                                                    <i class="ace-icon fa fa-lightbulb-o"></i>
                                                    <span class="bigger-110">Send</span>
                                                </button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div><!-- /.widget-main -->
            
                                <div class="toolbar center">
                                    <a href="' . SITEURL . '/administrator/login.php" data-target="#login-box" class="back-to-login-link">
                                        Back to login
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div><!-- /.widget-body -->
                            </div><!-- /.forgot-box -->
            
            
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
            
                        
            
                    
                        <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.min.js"></script>
                    
                        <script src="' . SITEURL . '/' . STYLE . '/assets/js/bootstrap.min.js"></script>
                        
                        <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.min.js"></script> 
                        
                        <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery-ui.min.js"></script>
                        <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.ui.touch-punch.min.js"></script>
                
                    
                        <script src="' . SITEURL . '/' . STYLE . '/jscript/validation.js"></script>
                        <script src="' . SITEURL . '/' . STYLE . '/jscript/guest.js"></script>
            
                        </body>
                        </html>
            
                    ';
}


function template_new_password()
{
    global $lang, $error, $page_title;

    echo '
                <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        
            
                <title>' . SITENAME . ' - ' . $page_title . '</title>
            
                <meta name="description" content="User login page" />
                
                        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
            
                        <meta name="viewport" content="user-scalable=0, initial-scale=1.0">
                        
                        
                <!-- bootstrap & fontawesome -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap.min.css" />
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/font-awesome.min.css" />
            
                <!-- text fonts -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-fonts.css" />
            
                <!-- ace styles -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.min.css" />
            
                <!--[if lte IE 9]>
                    <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-part2.min.css" />
                <![endif]-->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-rtl.min.css" />
            
                <!-- page specific plugin styles -->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/jquery-ui.min.css" />
            
            
                <!--[if lte IE 9]>
                  <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-ie.min.css" />
                <![endif]-->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.onpage-help.css" />
            
                <script src=\'https://www.google.com/recaptcha/api.js\'></script>
            
                <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
            
                <!--[if lt IE 9]>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/html5shiv.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/respond.min.js"></script>
                <![endif]-->
            
            
                
            </head>
            
            <body class="login-layout">
            <div id="result" ></div>
                <div class="main-container">
                    <div class="main-content">
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
            
                            <div class="login-container">
                            <div class="center">
                                <h1>
                                    <i class="ace-icon fa fa-car green"></i>
                                    <span class="red">' . $lang[20] . '</span>
                                    
                                </h1>
                                <h4 class="blue" id="id-company-text">&copy; ' . SITENAME . '</h4>
                            </div>
            
                            <div class="space-6"></div>
            
                            <div class="position-relative">
            
            
            
                            <div id="forgot-box" class="forgot-box widget-box no-border visible" style="visibility: visible">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header red lighter bigger">
                                        <i class="ace-icon fa fa-key"></i>
                                        New Password
                                    </h4>
            
                                    <div class="space-6"></div>
                                    <p>
                                        Enter your New password
                                    </p>
            
                                    <form id="new_password" name="forget_password" action="' . SITEURL . '/administrator/login.php?action=resetpassword" method="post">
                                    <input type="hidden" name="code" value="' . $_GET['code'] . '" />	
                                    
                                    <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" name="password" class="form-control" placeholder="Password" validate="notempty" />
                                                    <i class="ace-icon fa fa-envelope"></i>
                                                </span>
                                            </label>
            
                                            <label class="block clearfix">
                                            <span class="block input-icon input-icon-right">
                                                <input type="password" name="confirm_passord" class="form-control" placeholder="Confirm Password" validate="notempty" />
                                                <i class="ace-icon fa fa-envelope"></i>
                                            </span>
                                            </label>
            
                                        
                                            <label class="block clearfix">
                                            
                                                    <div class="g-recaptcha" data-sitekey="6LcnTSkTAAAAAOmeV601iujCamXRqr3OmpzwBvOl"></div>
                                        
                                                    
                                                    </label>
                                                    
            
            
            
                                            <div class="clearfix">
                                                <button type="button" onclick="newpassword();" class="width-35 pull-right btn btn-sm btn-danger">
                                                    <i class="ace-icon fa fa-lightbulb-o"></i>
                                                    <span class="bigger-110">Change password!</span>
                                                </button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div><!-- /.widget-main -->
            
                                <div class="toolbar center">
                                    <a href="' . SITEURL . '/administrator/login.php" data-target="#login-box" class="back-to-login-link">
                                        Back to login
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div><!-- /.widget-body -->
                             </div><!-- /.forgot-box -->
            
            
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
            
                        
            
                    
                    <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.min.js"></script>
                    
                        <script src="' . SITEURL . '/' . STYLE . '/assets/js/bootstrap.min.js"></script>
                        
                        <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.min.js"></script> 
                        
                        <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery-ui.min.js"></script>
                        <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.ui.touch-punch.min.js"></script>
                
                    
                        <script src="' . SITEURL . '/' . STYLE . '/jscript/validation.js"></script>
                        <script src="' . SITEURL . '/' . STYLE . '/jscript/guest.js"></script>
            
                        </body>
                        </html>
            
                    ';
}

function template_login_admin()
{
    global $lang, $error, $page_title;

    echo '
        
                <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        
        
                <title>' . SITENAME . ' - ' . $page_title . '</title>
        
                <meta name="description" content="User login page" />
                
                        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        
                        <meta name="viewport" content="user-scalable=0, initial-scale=1.0">
                        
                        
                <!-- bootstrap & fontawesome -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap.min.css" />
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/font-awesome.min.css" />
        
                <!-- text fonts -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-fonts.css" />
        
                <!-- ace styles -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.min.css" />
        
                <!--[if lte IE 9]>
                    <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-part2.min.css" />
                <![endif]-->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-rtl.min.css" />
        
                <!--[if lte IE 9]>
                  <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-ie.min.css" />
                <![endif]-->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.onpage-help.css" />
        
                <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        
                <!--[if lt IE 9]>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/html5shiv.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/respond.min.js"></script>
                <![endif]-->
            </head>
        
            <body class="login-layout rtl">
                <div class="main-container">
                    <div class="main-content">
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="login-container">
                                    <div class="center">
                                        <h1>
                                            <i class="ace-icon fa fa-car green"></i>
                                            <span class="red">' . $lang[20] . '</span>
                                            
                                        </h1>
                                        <h4 class="blue" id="id-company-text">&copy; ' . SITENAME . '</h4>
                                    </div>
        
                                    <div class="space-6"></div>
        
                                    <div class="position-relative">
                                        <div id="login-box" class="login-box visible widget-box no-border">
                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <h4 class="header blue lighter bigger">
                                                        <i class="ace-icon fa fa-coffee green"></i>
                                                                ' . $lang[570] . '
                                                    </h4>
        ';
    if (isset($_GET['e'])) {
        echo '<div class="well red bold" style="font-weight:bold;">' . $error[$_GET['e']] . '</div><div style="clear:both;"></div>';
    }

    echo '
                                                    <div class="space-6"></div>
        
                                                    <form name="admin_login" method="post" action="' . SITEURL . '/administrator/login.php?action=login">
                                                        <fieldset>
                                                    
        
                                                            <label class="block clearfix">
                                                                <span class="block input-icon input-icon-right">
                                                                    <input type="text" class="form-control"  name="user_name" placeholder="' . $lang[18] . '" />
                                                                    <i class="ace-icon fa fa-user"></i>
                                                                </span>
                                                            </label>
        
                                                            <label class="block clearfix">
                                                                <span class="block input-icon input-icon-right">
                                                                    <input type="password" class="form-control" name="user_pass" placeholder="' . $lang[19] . '" />
                                                                    <i class="ace-icon fa fa-lock"></i>
                                                                </span>
                                                            </label>
                                                                            
                                                            
                                                                            
                                                            
        
                                                            <div class="space"></div>
        
                                                            <div class="clearfix">
                                                            
        
                                                                <button type="submit" class="width-35 pull-right btn btn-sm btn-primary name="login">
                                                                    <i class="ace-icon fa fa-key"></i>
                                                                    <span class="bigger-110">' . $lang[21] . '</span>
                                                                </button>
                                                            </div>
        
                                                            <div class="space-4"></div>
                                                        </fieldset>
                                                    </form>
        
                                                    
        
                                                    
        
                                                    
                                                </div><!-- /.widget-main -->
        
                                                <div class="toolbar clearfix">
                                                    
                                                </div>
                                            </div><!-- /.widget-body -->
                                        </div><!-- /.login-box -->
        
                                    
                                    
                                    </div><!-- /.position-relative -->
        
                                    
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.main-content -->
                </div><!-- /.main-container -->
        
                <!-- basic scripts -->
        
                <!--[if !IE]> -->
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.min.js"></script>
                <!-- <![endif]-->
        
                <!--[if IE]>
        <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery1x.min.js"></script>
        <![endif]-->
                <script type="text/javascript">
                    if(\'ontouchstart\' in document.documentElement) document.write("<script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.mobile.custom.min.js"></script>");
                </script>
        
                <!-- inline scripts related to this page -->
        
            </body>
        </html>
        
        ';
}

function template_footer()
{
    global $lang;
    echo '
                                            <!-- PAGE CONTENT ENDS -->
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div><!-- /.page-content-area -->
                        </div><!-- /.page-content -->
                    </div><!-- /.main-content -->
                    
                    
                    <div class="footer">
                        <div class="footer-inner">
                            <!-- #section:basics/footer -->
                            <div class="footer-content">
                                <span class="bigger-120">
                                    <span class="blue bolder">Pyramids</span>
                                    ' . $lang[600] . '
                                </span>
        
                                &nbsp; &nbsp;
                                
                            </div>
        
                            <!-- /section:basics/footer -->
                        </div>
                    </div>
        
                    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
                    </a>
                    
            </div>
        
            
        
                <!--[if IE]>
        <script type="text/javascript">
         window.jQuery || document.write("<script src=\'' . SITEURL . '/' . STYLE . '/assets/js/jquery1x.min.js\'>"+"<"+"/script>");
        </script>
        <![endif]-->
                <script type="text/javascript">
                    if(\'ontouchstart\' in document.documentElement) document.write("<script src=\'' . SITEURL . '/' . STYLE . '/assets/js/jquery.mobile.custom.min.js\'>"+"<"+"/script>");
                </script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/bootstrap.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery-ui.min.js"></script>              
                <!--<script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery-ui.custom.min.js"></script>-->
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/markdown/markdown.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/markdown/bootstrap-markdown.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.hotkeys.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/bootstrap-wysiwyg.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/bootbox.min.js"></script>
        
                                
                <!-- page specific plugin scripts -->
        
                        <!--[if lte IE 8]>
                  <script src="' . SITEURL . '/' . STYLE . '/assets/js/excanvas.min.js"></script>
                <![endif]-->
        
                <link rel="stylesheet" type="text/css" href="'.SITEURL.'/'.STYLE.'/assets/DataTables/DataTables/css/dataTables.jqueryui.min.css">

                <script type="text/javascript" charset="utf8" src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.dataTables.min.js"></script>

                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.sparkline.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/flot/jquery.flot.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/flot/jquery.flot.pie.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/flot/jquery.flot.resize.min.js"></script>
                        
                        
                <!-- ace scripts -->
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/ace-elements.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/ace.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/jscript/jquery.datetimepicker.full.min.js"></script>

                                    
                                        <script>
                    $(\'[data-rel=tooltip]\').tooltip({container:\'body\'});
        
                    $(document).ready(function (){
        
                        $(".dateinput").datepicker({   
                            dateFormat: \'yy-mm-dd\',   
                            changeMonth: true
                        });
                            
                            $(".dateinput").datepicker(\'setDate\', new Date());


                        $(".datetimeinput").datetimepicker({   
                               // format: \'YYYY-MM-DD HH:mm\',
                        });
                                
                        $(".datetimeinput").datetimepicker(\'setDate\', new Date());
        
                    });
        
                    </script>

                    <div id="myCarousel"></div>
                                
        </body>
        
        </HTML>
        
        ';
}

function setting_box()
{
    global $setting_box;

    $x = '
			<!-- 
			<div class="ace-help-container" id="ace-help-container">
						<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
							<i class="ace-icon fa fa-question-circle bigger-150"></i>
						</div>
			
			</div>
			-->
			';


    return $x;
}

function breadcrumbs()
{
    global $lang, $breadarray;
    $x = '			<!-- #section:basics/content.breadcrumbs -->
                    <div class="breadcrumbs" id="breadcrumbs">
                        <script type="text/javascript">
                            try{ace.settings.check(\'breadcrumbs\' , \'fixed\')}catch(e){}
                        </script>
    
                        <ul class="breadcrumb">
                            <li>
                                <i class="ace-icon fa fa-home home-icon"></i>
                                <a href="' . formurl . '">' . $lang[1] . '</a>
                            </li>';

    if (is_array($breadarray) && count($breadarray) > 0) {
        for ($i = 0; $i < count($breadarray); $i++) {
            if ($i == (count($breadarray) - 1)) {
                $x .= '<li class="active">' . $breadarray[$i]['name'] . '</li>';
            } else {
                $x .= '<li ><a href="' . $breadarray[$i]['url'] . '">' . $breadarray[$i]['name'] . '</a></li>';
            }
        }
    }
    $x .= '				
                            
                        </ul><!-- /.breadcrumb -->
    
    
                    ';
    if (basename($_SERVER['PHP_SELF']) == "montior.php") {
        $action = $_GET['action'];

        $x .= '			
                <script type="text/javascript">
            function moveto(x){
        window.location.href = "montior.php?action="+x;
        }
            </script>
            
            <div class="nav-search">
    
            
    
                    
                                    
        </div>';
    }
    $x .= '</div>
    
                    <!-- /section:basics/content.breadcrumbs -->
                    
                    ';

    return $x;
}

function template_console()
{
    global $page_title, $header, $grid;

    echo '<html>
        <head>
        <title>' . $page_title . '</title>
        </head>
        <body>
        <div class="console_header"></div>
        <div class="console_body">
        
        <table>';

    while ($grid2 = mysqli_fetch_array($grid)) {
        echo '<tr>';
        for ($i = 0; $i < count($header); $i++) {
            $mm = explode($header[$i]['fieldname'], ".");
            echo $mm[0];

            //echo '<td>'.$grid2[$mm[1]].'</td>';
        }
        echo '
        </tr>';
    }

    echo '</table>
        
        </div>
        <div class="console_footer"></div>
        </body>
        </html>';
}

function template_redirect($redirect_url, $redirect_message)
{
    global $lang;

    echo '
    <div id="redirection_box">
    ', $redirect_message, '<br /><br />
    ' . $lang[75] . '
    <script type="text/javascript"> setTimeout("window.location = \'', $redirect_url, '\';", 2000); </script>
    </div>
    <div style="clear:both;"></div>';
}

function template_address()
{
    global $lang, $add, $add_no, $page_no, $start, $ty, $account_id;
    echo '
        <link rel="stylesheet" type="text/css" href="' . SITEURL . '/' . STYLE . '/css/pagination.css"/>
        
        <link rel="stylesheet" type="text/css" href="' . SITEURL . '/' . STYLE . '/css/jsonSuggest.css"/>
        
        <script  type="text/javascript">
        
        
        $(\'#beginwith\').keyup(function() {
        var message =  $(\'#beginwith\').val();
          show_address_list(message , \'#beginwith\',\'' . $_GET['id'] . '\');
        });
        
        
        </script>
        <div id="del_address" style="font-size:12px;" title="' . $lang[391] . '" > </div>
        <div id="edit_address" style="font-size:12px;" title="' . $lang[394] . '" > </div>
        
        
        <form id="add_form" method="post" action="' . formurl . '/index.php?action=address_search"   onsubmit="return false;" style="width:750px; font-size:10px;" autocomplete="off" >
        <input type="hidden" name="ty" id="ty"  value="' . $ty . '" />
        <input type="hidden" name="account_id" id="account_id"  value="' . $account_id . '" />
        <div class="form-group" style="padding:10px;">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[383] . '</label>
        <div class="col-sm-9"><input type="text" autocomplete="off" name="beginwith" id="beginwith"  size = "50"/>
        <div id="resu"></div>
        </div>
        <div class="col-sm-9">
        <input type="button" onclick="search_address(\'' . $ty . '\',\'' . $account_id . '\');" name="search" value="' . $lang['385'] . '" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="font-size:10px;" /></div>
        </div>
        
        
        
        
        
        <div style="clear:both;"></div>
        
        <table class="table table-striped table-bordered table-hover" id="client_addr" >
        <tr>
        <th></th>
        <th>' . $lang[36] . '</th>
        <th>' . $lang[7] . ', ' . $lang[9] . '</th>
        <th>' . $lang[13] . '</th>
        <th>' . $lang[288] . '</th>
        <th>' . $lang[11] . '</th>
        <th>' . $lang[120] . '</th>
        <th>' . $lang[957] . '</th>
        <th></th>
        <th></th>
        </tr>';

    if (is_array($add) && count($add) > 0) {
        for ($i = 0; $i < count($add); $i++) {
            echo '
        <tr id="addr_' . $add[$i]['id'] . '"  onclick="addaddr(\'' . $add[$i]['id'] . '\',\'' . $ty . '\');" >
        <td><input type="radio" name="emb" value="' . $add[$i]['id'] . '"></td>
        <td>' . $add[$i]['name'] . '</td>
        <td>' . $add[$i]['addr'] . ', ' . $add[$i]['postalcode'] . '</td>
        <td>' . $add[$i]['email'] . '</td>
        <td>' . $add[$i]['attn'] . '</td>
        <td>' . $add[$i]['phone'] . '</td>
        <td>' . $add[$i]['alt_phone'] . '</td>
        <td>' . $add[$i]['comments'] . '</td>
        <td><img src="' . SITEURL . '/' . STYLE . '/css/images/icon-edit.gif" height="17" width="33" alt="Edit this entry" onclick="edit_addresss(\'' . $add[$i]['id'] . '\',\'' . ($start) . '\',\'' . $add[$i]['client'] . '\',\'id\',\'DESC\');"></td>
        
        <td><img src="' . SITEURL . '/' . STYLE . '/css/images/icon-delete.gif" height="11" width="11" alt="Delete this entry" onclick="delete_address(\'' . $add[$i]['id'] . '\',\'' . $add[$i]['name'] . '\',\'' . ($start) . '\',\'' . $add[$i]['client'] . '\',\'id\',\'DESC\');"></td>
        </tr>
        ';
        }

        if ($add_no > 10) {
            echo '
        <tr>
        <th >' . $lang[390] . '' . $page_no . '</th>
        <th colspan="6">
        
        <div class="pagination">
        
                                                            
        <ul class="pag_list">
                                                            
        ';

            $x = 10;
            if ((round(($add_no - $start) / 10)) < 10) {
                $x = (round(($add_no - $start) / 10));
            }

            $m = 0;
            for ($p = ($start / 10); $p < ($start / 10) + 7; $p++) {
                if ($start > 10 && $m == 0) {
                    echo '<li><a href="#" onclick="addr_paging(\'' . ($start - 10) . '\',\'' . $add[0]['client'] . '\',\'id\',\'DESC\',\'' . $ty . '\');" class="button light_blue_btn"><span><span>' . $lang[782] . '</span></span></a> </li>';
                    $m++;
                }

                echo '<li><a href="#" onclick="addr_paging(\'' . ($p * 10) . '\',\'' . $add[0]['client'] . '\',\'id\',\'DESC\',\'' . $ty . '\');" class="current_page"><span><span>' . ($p + 1) . '</span></span></a></li>';
            }
            if ((($start / 10) + 7) < $page_no) {
                echo '<li><a href="#"  onclick="addr_paging(\'' . ($start + 10) . '\',\'' . $add[0]['client'] . '\',\'id\',\'DESC\',\'' . $ty . '\');" class="button light_blue_btn"><span><span>' . $lang[783] . '</span></span></a> </li>';
            }


            echo '
        
        </ul>
        <div>
        
        
        
        </th>
        <th colspan="3">' . $lang[389] . '' . $add_no . '</th>
        </tr>';
        }
    } else {
        echo '<tr>
        <td colspan="100%">' . $lang[388] . '</td>
        </tr>';
    }

    echo '
        </table>
        
        
        
        
        
        </form>
        ';
}

function template_address_table()
{
    global $lang, $add, $add_no, $page_no, $start, $ty;
    echo '
            <table border="1" class="table table-striped table-bordered table-hover" id="client_addr" >
            <tr>
            <th></th>
            <th>' . $lang[36] . '</th>
            <th>' . $lang[7] . ', ' . $lang[9] . '</th>
            <th>' . $lang[13] . '</th>
            <th>' . $lang[288] . '</th>
            <th>' . $lang[11] . '</th>
            <th>' . $lang[120] . '</th>
            <th>' . $lang[957] . '</th>
                    
            <th></th>
            <th></th>
            </tr>';

    if (is_array($add) && count($add) > 0) {
        for ($i = 0; $i < count($add); $i++) {
            echo '
            <tr id="addr_' . $add[$i]['id'] . '"  onclick="addaddr(\'' . $add[$i]['id'] . '\',\'' . $ty . '\');" >
            <td><input type="radio" name="emb" value="' . $add[$i]['id'] . '"></td>
            <td>' . $add[$i]['name'] . '</td>
            <td>' . $add[$i]['addr'] . ', ' . $add[$i]['postalcode'] . '</td>
            <td>' . $add[$i]['email'] . '</td>
            <td>' . $add[$i]['attn'] . '</td>
            <td>' . $add[$i]['phone'] . '</td>
            <td>' . $add[$i]['alt_phone'] . '</td>
                <td>' . $add[$i]['comments'] . '</td>
                    
            <td><img src="' . SITEURL . '/' . STYLE . '/css/images/icon-edit.gif" height="17" width="33" alt="' . $lang[784] . '" onclick="edit_addresss(\'' . $add[$i]['id'] . '\',\'' . ($start) . '\',\'' . $add[$i]['client'] . '\',\'id\',\'DESC\');"></td>
            
            <td><img src="' . SITEURL . '/' . STYLE . '/css/images/icon-delete.gif" height="11" width="11" alt="' . $lang[785] . '" onclick="delete_address(\'' . $add[$i]['id'] . '\',\'' . $add[$i]['name'] . '\',\'' . ($start) . '\',\'' . $add[$i]['client'] . '\',\'id\',\'DESC\');"></td>
            </tr>
            ';
        }

        if ($add_no > 10) {
            echo '
            <tr>
            <th >' . $lang[390] . '' . $page_no . '</th>
            <th colspan="6">
            
            <div class="pagination">
            
                                                                
            <ul class="pag_list">
                                                                
            ';
            $x = 10;
            if ((round(($add_no - $start) / 10)) < 10) {
                $x = (round(($add_no - $start) / 10));
            }

            $m = 0;
            for ($p = ($start / 10); $p < ($start / 10) + 7; $p++) {
                if ($start > 10 && $m == 0) {
                    echo '<li><a href="#" onclick="addr_paging(\'' . ($start - 10) . '\',\'' . $add[0]['client'] . '\',\'id\',\'DESC\');" class="button light_blue_btn"><span><span>' . $lang[782] . '</span></span></a> </li>';
                    $m++;
                }

                echo '<li><a href="#" onclick="addr_paging(\'' . ($p * 10) . '\',\'' . $add[0]['client'] . '\',\'id\',\'DESC\');" class="current_page"><span><span>' . ($p + 1) . '</span></span></a></li>';
            }
            if ((($start / 10) + 7) < $page_no) {
                echo '<li><a href="#"  onclick="addr_paging(\'' . ($start + 10) . '\',\'' . $add[0]['client'] . '\',\'id\',\'DESC\');" class="button light_blue_btn"><span><span>' . $lang[783] . '</span></span></a> </li>';
            }


            echo '
            
            </ul>
            <div>
            
            
            
            </th>
            <th colspan="3">' . $lang[389] . '' . $add_no . '</th>
            </tr>';
        }
    } else {
        echo '<tr>
            <td colspan="100%">' . $lang[388] . '</td>
            </tr>';
    }

    echo '
            </table>
            ';
}

function template_edit_address()
{
    global $add_no, $lang;

    echo '
        
        <form id="edit_addre" name="edit_addre" action="' . formurl . '/index.php?action=address_edit" class="form-horizontal" role="form" onsubmit="return edit_add();" method="post"  >
        <input type="hidden" name="account" value="' . $_GET['account'] . '" />
                
        <input type="hidden" name="id" value="' . $add_no->id . '" />
                
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[36] . '</label>
        <div class="col-sm-9"><input type="text" name="name" value="' . $add_no->name . '" /></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[7] . '</label>
        <div class="col-sm-9"><textarea name="addr" style="margin: 0px; width: 179px; height: 45px;" >' . $add_no->addr . '</textarea></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[9] . '</label>
        <div class="col-sm-9"><input type="text" name="postalcode" value="' . $add_no->postalcode . '" /></div>
        </div>
                
                <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[13] . '</label>
        <div class="col-sm-9"><input type="text" name="email" value="' . $add_no->email . '" /></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[288] . '</label>
        <div class="col-sm-9"><input type="text" name="attn" value="' . $add_no->attn . '" /></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[11] . '</label>
        <div class="col-sm-9"><input type="text" name="phone" value="' . $add_no->phone . '" /></div>
        </div>
        
                
                <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[120] . '</label>
        <div class="col-sm-9"><input type="text" name="alt_phone" value="' . $add_no->alt_phone . '" /></div>
        </div>
                
                
                <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">' . $lang[957] . '</label>
        <div class="col-sm-9"><input type="text" name="comments" value="' . $add_no->comments . '" /></div>
        </div>
                
        
        
        
        </form>';
}


function template_tracking()
{
    global $lang, $trackno, $order_details, $c_setting;
    echo '
                    
                    ' . template_index() . '
                                
                                <div style="width:1000px; margin:auto;">
                                
                    <div class="row">
                    <div class="col-sm-9" style="margin:auto; text-align:center; float:none;">
                    
                    <form id="trackno" method="post" action="' . SITEURL . '/index.php?action=tracking" >
                    <div class="form-group">
                    <p>
                    <span>Search Package by Tracking No.</span>
        
                    <div class="col-sm-9" style="margin:auto; text-align:center; float:none;">
                    <input type="text" name="trackno" value="' . ($trackno != '' ? $trackno : 'Enter Tracking No.') . '" onfocus="if (this.value==this.defaultValue) this.value = \'\'" 
         onblur="if (this.value==\'\') this.value = this.defaultValue" size="50" style="height:42px; font-size:18px;" />
                    <button class="btn btn-danger" style="margin-top:-5px;" onclick="$("#trackno").submit();">
                                                        <i class="ace-icon glyphicon  glyphicon-search bigger-110"></i>
        
                                                        Search
                                                        
                    </button>
                    </div>
                    </p>
                    </div>
                    </form>
                            <div style="clear:both;"></div>
                            ';


    if (isset($order_details->order_id)) {
        echo '
                            <h3 class="header smaller lighter blue">Order No. ' . $order_details->order_id . ' Details</h3>
                                    <p>
                    <div class="col-sm-6 form-horizontal"  style="font-weight:bold;" >
                                                        
        <div class="form-group">
        <label class="col-sm-6 control-label">' . $lang[827] . '</label>
        <div class="col-sm-6">' . $order_details->order_id . '</div>
        </div>
        ';

        echo '			
        <div class="form-group">
        <label class="col-sm-6 control-label">' . $lang[402] . '</label>
        <div class="col-sm-6">' . date(DATETIME_FORMAT, strtotime($order_details->order_date)) . '</div>
        </div>
        ';

        echo '
        <div class="form-group">
        <label class="col-sm-6 control-label">' . $lang[279] . '</label>
        <div class="col-sm-6">' . $order_details->account_name . ' - ' . $order_details->account_company . '</div>
        </div>
        ';

        echo '
        <div class="form-group">
        <label class="col-sm-6 control-label">' . $lang[371] . '</label>
        <div class="col-sm-6">' . date(DATETIME_FORMAT, strtotime($order_details->pickup_date . ' ' . $order_details->pickup_time)) . '</div>
        </div>
        
        ';

        echo '
        <div class="form-group">
        <label class="col-sm-6 control-label">' . $lang[34] . '</label>
        <div class="col-sm-6">' . $order_details->from_address . ' - ' . $order_details->from_pcode . '</div>
        </div>
        
        ';

        if ($order_details->from_contact != '') {
            echo '
        <div class="form-group">
        <label class="col-sm-6 control-label">' . $lang[10] . '</label>
        <div class="col-sm-6">' . $order_details->from_contact . '</div>
        </div>
        ';
        }

        echo '
        <div class="form-group">
        <label class="col-sm-6 control-label">' . $lang[590] . '</label>
        <div class="col-sm-6">' . date(DATETIME_FORMAT, strtotime($order_details->delivery_date . ' ' . $order_details->delivery_time)) . '</div>
        </div>
        ';

        echo '
        <div class="form-group">
        <label class="col-sm-6 control-label">' . $lang[35] . '</label>
        <div class="col-sm-6">' . $order_details->to_address . ' - ' . $order_details->to_pcode . '</div>
        </div>
        ';

        if ($order_details->to_att != '') {
            echo '
        <div class="form-group">
        <label class="col-sm-6 control-label">' . $lang[288] . '</label>
        <div class="col-sm-6">' . $order_details->to_att . '</div>
        </div>
        ';
        }

        if ($order_details->orderedby != '') {
            echo '
        <div class="form-group">
        <label class="col-sm-6 control-label">' . $lang[40] . '</label>
        <div class="col-sm-6">' . $order_details->orderedby . '</div>
        </div>';
        }


        echo '	</div>
                
                
                <div class="col-sm-6 form-horizontal"  style="font-weight:bold;" >
                <h3 class="header smaller lighter green">Service</h3>
                
                ' . $order_details->service_name . '
                
                <h3 class="header smaller lighter red">Status</h3>
                
                ' . ($order_details->order_status == 3 && $order_details->actual_pickup_time == '' ? 'Acknowledged' : ($order_details->order_status == 3 && $order_details->actual_pickup_time != '' ? 'Picked up' : $order_details->statusname)) . '
                </div>
        
        </p>		
                            ';
    }

    echo '
                    </div>
                    </div>
                    </div>';
}

function template_overall_report_header()
{
    global $lang, $page_title, $decription_txt, $order_waybill;


    $otw = 670;

    echo '
                <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
                <meta charset="utf-8" />
                <title>' . SITENAME . ' - ' . $page_title . '</title>
        
                <meta name="description" content="overview &amp; stats" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        
        
        
        
                <!-- bootstrap & fontawesome -->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap.min.css" />
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap-timepicker.css" />
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/font-awesome.min.css" />
                <!-- page specific plugin styles -->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/jquery-ui.min.css" />
        
                <!-- page specific plugin styles -->
        
                <!-- text fonts -->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-fonts.css" />
        
                <!-- ace styles -->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.min.css" id="main-ace-style" />
        
                <!--[if lte IE 9]>
                    <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-part2.min.css" />
                <![endif]-->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-skins.min.css" />
        
                <!--[if lte IE 9]>
                  <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-ie.min.css" />
                <![endif]-->
        
                    <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/css/hideprint.css" />
                    <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.min.js"></script> 
        
                <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/validation.js"></script>
                <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/main.js"></script>
                <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
        
            <script type="text/javascript">
            var siteurl = \'' . SITEURL . '\'
            </script>
        
            <style>
            .removeprint{
                display:none;
            }
            </style>
            </head>
        
            <body style="background:#fff;">
                
        <div class="hideprint" style="width:600;">
                    <hr/>
        <center>
        <input type="button" value="&nbsp;&nbsp;طباعة&nbsp;&nbsp;" onclick="print()" style="font-weight:bold;
                        font-size:14;
                        color:white;
                        font-family:Comic Sans Ms;
                        background:#A0A0A0">
                    &nbsp;&nbsp;&nbsp;
            
        
        </center>
        
                <hr/>
        </div>';

    // if(!isset($order_waybill) && $order_waybill != true ){
    // echo'
    //     <div style="border:2px solid #000; padding:5px; margin:auto; width:'.($otw+15).'px;" id="print"   >

    //     <table style="margin:auto;" width='.$otw.' >
    //     <tr style="border-bottom:1pt solid black;">
    // 	<td>
    // 	<div class="left" style="width:50%; height:100px; float:left;">
    // 	<img src="'.SITEURL.'/images/waybill_banner.jpg" width="100%" height="90px;" />
    // 	</div>

    // 	<div class="right" style="width:50%; float:left; text-align:center;   font-weight:bold; vertical-align: middle;">
    // 			'.$decription_txt.'
    // 	</div>

    // 	</td>

    // 	</tr>';
    // }else{
    echo '
                <div style=" padding:5px; margin:auto; width:' . ($otw + 15) . 'px;" id="print"   >
                
                <table style="margin:auto;" width=' . $otw . ' dir="rtl" >';
    //	}

    echo '<tr>
                <td>';
}

function template_report_footer()
{
    global $lang;
    echo '
        </td>
		</tr>

        </table>
		</div>
    </body>

    </HTML>

    ';
}

///////////////////////////////////////////////////////////

function templateemail_overall_header()
{
    global $lang, $page_title;

    $x = '
                <!DOCTYPE html>
        <html lang="en">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
                <title>' . SITENAME . ' - ' . $page_title . '</title>
                <!-- bootstrap & fontawesome -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap.min.css" />
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/bootstrap-timepicker.css" />
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/font-awesome.min.css" />
                <!-- page specific plugin styles -->
                <link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/jquery-ui.min.css" />
                <!-- page specific plugin styles -->
        
                <!-- text fonts -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-fonts.css" />
        
                <!-- ace styles -->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace.min.css" id="main-ace-style" />
        
                <!--[if lte IE 9]>
                    <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-part2.min.css" />
                <![endif]-->
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-skins.min.css" />
                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-rtl.min.css" />
        
                <!--[if lte IE 9]>
                  <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/assets/css/ace-ie.min.css" />
                <![endif]-->
            </head>
            <body class="no-skin">
        ';
    return $x;
}

function templateemail_header()
{
    $x = '
    <!-- #section:basics/navbar.layout -->
		<div id="navbar" class="navbar navbar-default">
			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<!-- #section:basics/navbar.layout.brand -->
					<a href="#" class="navbar-brand">
						<small>
							<i class="fa fa-bicycle"></i>
							' . SITENAME . '
						</small>
					</a>
				</div>
			</div><!-- /.navbar-container -->
		</div>
				<div class="main-container" id="main-container">';
    return $x;
}


function templateemail_footer()
{
    global $lang;
    $x = '
									<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content-area -->
				</div><!-- /.page-content -->
			</div><!-- /.main-content -->
		
		
			<div class="footer">
				<div class="footer-inner">
					<!-- #section:basics/footer -->
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Courier-Connex.com</span>
							' . $lang[600] . '
						</span>
						
					</div>

					<!-- /section:basics/footer -->
				</div>
			</div>

		
		
	</div>


    </body>

    </HTML>

    ';

    return $x;
}

function template_price_order()
{
    global $lang, $c_setting, $services, $res;

    echo '    
            <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
        <script src=\'https://www.google.com/recaptcha/api.js\'></script>
        ' . template_index() . '
                    <div style="width:1000px; margin:auto;">
                    
                            
                            <div class="page-header" >
                                    <h1>
                                    Order Pricing
                                    </h1>
                                </div><!-- /.page-header -->
        
                    
                            
                    
                    <div class="row">
                    <div class="col-xs-4">
                    
                    <form name="guest_pricing"   id="guest_pricing" action="index.php?action=pricing" method="post" class="form-horizontal" >
                        
                <input type="hidden" id="meters" name="meters" value="' . $_POST['meters'] . '"/>
                <input type="hidden" id="from_pcode" name="from_pcode" value="' . $_POST['from_pcode'] . '"  />
                <input type="hidden" id="to_pcode" name="to_pcode" value="' . $_POST['to_pcode'] . '" />
                
                                                                    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">From Addresss * </label>
                                            <div class="col-sm-9">	
                                                
        <input type="text" class="autocomplete" style="width:300px;"  onFocus="geolocate();" name="from_address" id="from_address"  value="' . $_POST['from_address'] . '" />
                    
                        
                
                                        </div>
                                                </div>	
                
                
                                                                            <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">To Addresss * </label>
                                            <div class="col-sm-9">	
                                                <div id="locationField">
                         <input id="to_address" class="autocomplete" placeholder="Enter your address"
                     onFocus="geolocate();" style="width:300px;" type="text" name="to_address" value="' . $_POST['to_address'] . '" ></input>
                </div>
                
                                        </div>
                                                </div>	';


    echo '<div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> * </label>
        <div class="col-sm-9">
                <div class="g-recaptcha" data-sitekey="6LcnTSkTAAAAAOmeV601iujCamXRqr3OmpzwBvOl"></div>
        </div>
                </div>
                <span>* Required</span>
            
                    
                        
                        <div class="clearfix form-actions"  >
        <div class="col-md-offset-3 col-md-9">
                        
                        <button class="btn btn-danger"  >
                                                        <i class="ace-icon fa fa-usd align-top bigger-125"></i>
                                                        ' . $lang[52] . '
                                                    </button>
                                                                
                                            </div>
        
                                                                </div>
                                                                
                                                                <div style="clear:both;"></div>
                    </form>
                                                                <h4 class="red"><i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i>
                            ' . $lang[969] . '									
                                                                </h4>
                    </div>
                    
                    <div class="col-xs-8">
                    ';

    if (is_array($res) & count($res) > 0) {
        for ($i = 0; $i < count($res); $i++) {
            echo '<div style="width:45%; margin:2.5%;float:left;"><h3 class="header smaller lighter green">' . $res[$i]['service_name'] . '</h3>
                            ';

            if ($res[$i]['message_html'] != '') {
                echo $res[$i]['message_html'];
            } else {
                echo $lang[970];
            }

            echo "</div>";
        }
    }
    echo '
                    </div>
                    </div>
                    
                    
        
                    <script  src="' . SITEURL . '/' . STYLE . '/jscript/home.js" ></script>
                    <script  src="https://maps.googleapis.com/maps/api/js?key=' . $c_setting['googlemap_api'] . '&libraries=places&callback=initAutocomplete" async defer></script>
                        
                                                </div>
                    
                    ';
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
                        </li>';



    if ($_SESSION['user_type'] == 'accounting') {
        $x .= '                    <li class="hsub ">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-shopping-cart  blue"></i>
                        <span class="menu-text"> المشتريات </span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu" >
                    <li class="">
                    <a href="suppliers.php">
                        <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                        <span class="menu-text"> الموردين </span>
                    </a>
        
                    <b class="arrow"></b>
                </li>

            
                   <li class="">
                   <a href="inventory.php?action=purchase">
                       <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                       <span class="menu-text"> الفواتير </span>
                   </a>
            
                   <b class="arrow"></b>
                   </li>
            
                    </ul>
                    </li>';
    }
    if ($_SESSION['user_type'] == 'accounting') {
        $x .=  '                  <li class="">
                    <a href="inventory.php">
                        <i class="menu-icon fa fa-dropbox blue"></i>
                        <span class="menu-text"> المحزن </span>
                    </a>
            
                    <b class="arrow"></b>
                   </li>';
    }
    if ($_SESSION['user_type'] == 'accounting') {
        $x .=  '              <li class="hsub ">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-bar-chart-o blue"></i>
                        <span class="menu-text"> المبيعات </span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
            
                    <b class="arrow"></b>
            
                    <ul class="submenu" >
                    <li class="">
                        <a href="accounts.php">
                            <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                            <span class="menu-text"> العملاء </span>
                        </a>
            
                        <b class="arrow"></b>
                    </li>

                    <li class="">
                    <a href="accounting.php">
                        <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                        <span class="menu-text"> الفواتير </span>
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
                <a href="pricing.php">
                    <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                    <span class="menu-text"> التسعير </span>
                </a>
    
                <b class="arrow"></b>
            </li>
            
            
            
                    </ul>
                    </li>';
    }
    if ($_SESSION['user_type'] == 'accounting') {
        $x .=  ' 
                    <li class=" hsub">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa fa-money blue"></i>
                        <span class="menu-text"> الحسابات </span>
                        <b class="arrow fa fa-angle-down"></b>

                    </a>

                    <b class="arrow"></b>
            
                    <ul class="submenu" >
                    
                    <li class="">
                    <a href="accounting.php?action=revise_account">
                        <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                        <span class="menu-text"> حساب العميل </span>
                    </a>
      
                    <b class="arrow"></b>
                   </li>

              <li class="">
              <a href="credit_note.php?action=manage">
                  <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                  <span class="menu-text"> اشعار الخصم والاضافة </span>
              </a>

              <b class="arrow"></b>
             </li>

                    </ul>
                </li>';
    }
    if ($_SESSION['user_type'] == 'accounting') {
        $x .=  ' 
        <li class="hsub ">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-usd blue"></i>
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
';
    }
    if ($_SESSION['user_type'] == 'accounting') {
        $x .= '<li class="hsub ">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-search blue"></i>
            <span class="menu-text"> بحث </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu" >
        <li class="">
            <a href="accounting.php?action=history_invoice" >
                <i class="menu-icon fa fa-caret-right"></i>
               فواتير
            </a>
            <b class="arrow"></b>
        </li>
        <li class="">
            <a href="search.php?action=mangesearch" >
                <i class="menu-icon fa fa-caret-right"></i>
                الطلبيات
            </a>
            <b class="arrow"></b>
        </li>
        </ul>
        </li>

        <li class="hsub ">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file-text-o blue"></i>
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
