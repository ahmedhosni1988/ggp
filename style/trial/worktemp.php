<?php

function insert_images_into_scren()
{
    global $res;
//    $list=" <ul class=\"carousel-indicators\">";
    $items="<div  class=\"carousel-inner\">";
    for ($i = 0; $i < count($res); $i++) {
//        $list.='<li data-target="#myCarousel" data-slide-to="'.$i.'" '.($i.'" '.$i==0? ' class="active"' : '').' ></li>';
        $items .= '  <div style="margin:20px;" class="item '.($i.'" '.$i==0? ' active' : '').'">
                    <a class="fancybox" rel="group" href="' . SITEURL . '/' . $res[$i]['image_url'] . '"><img width="1100" height="500" style="width:100%;" src="' . SITEURL . '/' . $res[$i]['image_url'] . '" alt="" /></a>
               </div>';
    }
//    $list.="</ul>";
    $items.="</div>";
//    $list.=$items;
    $items.='
<a class="right carousel-control" href="#myCarousel" data-slide="prev">
    <span class="icon-prev"></span>
  </a>
  <a class="left carousel-control" href="#myCarousel" style="float: right !important;right:auto !important; left: 0px !important;" data-slide="next">
    <span class="icon-next" style="left: 20%; !important " ></span>
  </a>  ';
    echo $items;
}





function template_header_work()
{
    global $lang, $notification, $new_message, $new_invoice, $updated_order, $new_client;

    echo '<!-- #section:basics/navbar.layout -->
    <!-- 	<script src="' . SITEURL . '/' . STYLE . '/jscript/socket.js" type="text/javascript" ></script> -->

    <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/fancybox-master/dist/jquery.fancybox.css" />

	<script src="' . SITEURL . '/' . STYLE . '/fancybox-master/dist/jquery.fancybox.js" type="text/javascript" ></script>

    <script type="text/javascript">
    $("[data-fancybox]").fancybox({ });
    </script>

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

                    <nav role="navigation" class="navbar-menu pull-right  navbar-collapse">
					<!-- #section:basics/navbar.nav -->
					<ul class="nav navbar-nav">
						<li class="">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								الخصائص
	  		&nbsp;
								<i class="ace-icon fa fa-angle-down bigger-110"></i>
							</a>

                            <ul class="dropdown-menu dropdown-light-blue dropdown-caret">

                            <li class="">
                           <a href="search.php?action=search_item&style=operation">
                               <i class="menu-icon fa fa-search blue"></i>
                               <span class="menu-text">بحث بالمقاس</span>
                           </a>
       
                           <b class="arrow"></b>
                       </li>
                            ';

    if ($_SESSION['user_type'] == "manger") {
        echo '

        <li>
                                <a href="search.php?action=deficiencies">
                                    <i class="ace-icon fa fa-user bigger-110 blue"></i>
النواقص
                                </a>
                               </li>

                                <li>
                                <a href="manger.php">
                                    <i class="ace-icon fa fa-user bigger-110 blue"></i>
                                    تشغيل الكسر
                                </a>
                               </li>

                               <li>
                                <a href="manger.php?action=view">
                                    <i class="ace-icon fa fa-user bigger-110 blue"></i>
                                   متابعة المصنع
                                </a>
                               </li>

                               <li>
                               <a href="manger.php?action=today">
                                   <i class="ace-icon fa fa-user bigger-110 blue"></i>
                                   تسليمات اليوم
                               </a>
                              </li>

                               <li>
                                <a href="manger.php?action=orders">
                                    <i class="ace-icon fa fa-user bigger-110 blue"></i>
                                   طلبيات تحت التشغيل
                                </a>
                               </li>

                               <li>
                            <a href="search.php?action=mangesearch&style=operation">
                                <i class="ace-icon fa fa-user bigger-110 blue"></i>
                              بحث
                            </a>
                           </li>

                           


                               ';
    } elseif ($_SESSION['user_type'] == "accounting") {
        echo '
                                <li>
                            <a href="accounting.php">
                                <i class="ace-icon fa fa-user bigger-110 blue"></i>
                                طلبيات تحت التشغيل
                            </a>
                           </li><li>
                           <a href="search.php?action=searchDeliveries">
                                <i class="ace-icon fa fa-user bigger-110 blue"></i>
                            بحث التسليمات  
                            </a>
                           </li>

                           <li>
                            <a href="search.php?action=mangesearch&style=operation">
                                <i class="ace-icon fa fa-user bigger-110 blue"></i>
                              بحث
                            </a>
                           </li>

                           <li>
                            <a href="outorder.php?action=show_outorder&style=operation">
                                <i class="ace-icon fa fa-user bigger-110 blue"></i>
                              التسليمات
                            </a>
                           </li>


                                ';
    } elseif ($_SESSION['user_type'] == "7") {
        echo '
        <li>
    <a href="work.php?action=pointing">
        <i class="ace-icon fa fa-user bigger-110 blue"></i>
        تشغيل بالصور
    </a>
   </li>
   <li>
   <a href="work.php">
       <i class="ace-icon fa fa-user bigger-110 blue"></i>
       تشغيل عادى
   </a>
  </li>
  <li>
  <a href="search.php?action=mangesearch&style=operation">
      <i class="ace-icon fa fa-user bigger-110 blue"></i>
    بحث
  </a>
 </li>

   ';
    } else {
        echo '
                                <li>
                            <a href="'.($_SESSION['user_type']=="3"?   "work.php?action=pointing":"work.php").'">
                                <i class="ace-icon fa fa-user bigger-110 blue"></i>
                                تشغيل
                            </a>
                           </li>
                           <li>
                           <a href="search.php?action=mangesearch&style=operation">
                               <i class="ace-icon fa fa-user bigger-110 blue"></i>
                             بحث
                           </a>
                          </li>
                                ';
    }


    if ($_SESSION['user_type'] == '2') {
        echo '
                               
                               <li>
                               <a href="work.php?action=inventory">
                                   <i class="ace-icon fa fa-eye bigger-110 blue"></i>
                                   سحب من المحزن
                               </a>
                           </li>
                           ';
    }

    if ($_SESSION['user_type'] == '5') {
        echo '
                                <li>
                                <a href="work.php?action=delivery">
                                    <i class="ace-icon fa fa-user bigger-110 blue"></i>
                                    تسليم طلبية
                                </a>
                               </li>
                               

                               <li>
                                <a href="work.php?action=create_order">
                                    <i class="ace-icon fa fa-user bigger-110 blue"></i>
                                  انشاء امر تسليم
                                </a>
                               </li>
<!--
                               <li>
                               <a href="search.php?action=mangesearch&style=operation">
                                   <i class="ace-icon fa fa-user bigger-110 blue"></i>
                                 بحث
                               </a>
                              </li>
-->
                              <li>
                               <a href="manger.php?action=today">
                                   <i class="ace-icon fa fa-user bigger-110 blue"></i>
                                   تسليمات اليوم
                               </a>
                              </li>
                              <li >
            <a href="outorder.php?action=show_outorder">
                <i class="menu-icon glyphicon  glyphicon-home blue"></i>
                <span class="menu-text"> التسليمات </span>
            </a>

            <b class="arrow"></b>
        </li>

                              

                               ';
    }


    echo '	

								

								
							</ul>
						</li>

						
					</ul>

					<!-- /section:basics/navbar.nav -->

					<!-- #section:basics/navbar.form -->
                    ';
    if ($_SESSION['user_type'] != 'accounting') {
        echo '   <form id="auto_form_submit" class="navbar-form navbar-left form-search"  " role="search">
						<div class="form-group">
							<input type="text" placeholder="بحث...." id="auto_search_item" >
						</div>

                        
						<button type="submit" class="btn btn-xs btn-info2">
							<i class="ace-icon fa fa-search icon-only bigger-110"></i>
						</button>
                    </form>';
    }
    echo '
					<!-- /section:basics/navbar.form -->
				</nav>
    
        
                    
            ' . admin_notify_list() . '
                </div><!-- /.navbar-container -->
            </div>
            
            
                    <div class="main-container" id="main-container">
                                       
                                                                                
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

function build_table_for_pointing()
{
    global $res;

    if ($_SESSION['user_type'] == '7') {
        $oper = '7';
    } else {
        $oper = '3';
    }

    return "<input type='hidden' id='imgId' value='".$res['order_id']."'> <table style='margin-top: 10px' id=\"scanner_data\" style='width: 50px;' class=\" table table-striped table-bordered   \">
        <thead>
            <tr>
                <th>رقم الطلبية</th>
               <!-- <th>حالة الشغل</th>-->
                <th>طول</th>
                <th>عرض</th>
                <!--<th>نوع الزجاج</th>
                <th>لون الزجاج</th>
                <th>الطباعة</th>-->
                <th>مسطح</th>
             <!--   <th>سنفرة</th> -->
                <th>التخليع</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                 <td>".$res["easy_order_id"] . "-" . $res["part_order"]."</td>
                <!--<td>-</td>-->
                <td>".$res["length"]."</td>
                <td>".$res["width"]."</td>
                <!--<td>".$res["company_name"]."</td>-->
                <!--<td>".$res["glasscolour"]."</td>
                <td>".$res["glassPrint"]."</td>-->
                <td>".$res["glassType"]."</td>
               <!-- <td>".$res["glassScarch"]."</td> -->
                <td>".$res["glassPointing"]."</td>
                <td><button class=\"delrow btn btn-xs btn-danger\" data=\"' + ".$res['id']." '\"><i class=\"ace-icon fa fa-trash-o bigger-120\"></i></button></td>
            </tr>
        </tbody>
        </table>
        <button class=\"btn btn-danger\" onclick='cancel_package(".$res['id'].");' > كسر </button>
        <button class=\"btn  btn-success\" onclick=\"finish_operation('',".$res['id'].",'".$oper."');\" > ترحيل </button>
        
        <script></script>
        " ;
}
function template_pointing()
{
    $header1 = '<!--<style>#top,
#myCarousel {
    position: fixed;
    left: 0;
    right: 0;
    height: 40%;
}



#myCarousel {
    bottom: 0;
    
}


</style>-->
<style>
.split {
  height: 100%;
  width: 60%;
  position: fixed;
  z-index: 1;
  top: 0;
  overflow-x: hidden;
  padding-top: 20px;
}

/* Control the left side */
.left {
  left: 0;
  padding-right:300px ;
 margin-top: 100px;
}

/* Control the right side */
.right {
  right: 0;
  margin-top: 100px;
}


</style>
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/scanner.js?v='.date('YmdHiS').'"></script>
<script type="text/javascript" src="'.SITEURL.'/'.STYLE.'/jscript/order.js?v='.date('YmdHiS').'"></script>
<div class="row">
<div  class="col-xs-4"> 
<h3 class="header smaller lighter green">البحث</h3>
    
    <div class="input-group">
																	<input type="text" class="form-control search-query" id="auto_search_items" placeholder="إدخل رقم القطعة">
																	<span class="input-group-btn">
																		<button onclick="auto_search1($(\'#auto_search_items\').val());" type="button" class="btn btn-purple btn-sm">
																			بحث
																			<i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
																		</button>
																	</span>
																</div>
																<script>document.querySelector(\'#auto_search_items\').addEventListener(\'keypress\', function (e) {

      if (e.key === \'Enter\') {
          auto_search1(document.getElementById(\'auto_search_items\').value);
       }
      });   </script>
    <div id="result1">
    
    </div>
</div>

						';


    $header1 .=   " 
    
    <div s class='col-xs-8'>

    <script type=\"text/javascript\" src=\"".SITEURL."/style/trial/jscript/jquery-1.10.2.js\"></script>

<!-- Add mousewheel plugin (this is optional) -->
<script type=\"text/javascript\" src=\"../fancybox/lib/jquery.mousewheel.pack.js\"></script>

<!-- Add fancyBox -->
<link rel=\"stylesheet\" href=\"../fancybox/source/jquery.fancybox.css?v=2.1.7\" type=\"text/css\" media=\"screen\" />
<script type=\"text/javascript\" src=\"../fancybox/source/jquery.fancybox.pack.js?v=2.1.7\"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel=\"stylesheet\" href=\"../fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5\" type=\"text/css\" media=\"screen\" />
<script type=\"text/javascript\" src=\"../fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5\"></script>
<script type=\"text/javascript\" src=\"../fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6\"></script>

<link rel=\"stylesheet\" href=\"../fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7\" type=\"text/css\" media=\"screen\" />
<script type=\"text/javascript\" src=\"../fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7\"></script>
  <script type=\"text/javascript\">
	$(document).ready(function() {
		$(\".fancybox\").fancybox({
        autoSize : true,
        scrolling : 'auto',
        fitToView : false,
        width : 'auto',
        maxWidth : '100%',
    });
	});
</script>
 <h3 class=\"header smaller lighter green\">الصور</h3>
 
<div style='background: #0a0a0a' id=\"myCarousel\" data-interval=\"false\" class=\"carousel \" data-ride=\"carousel\">
  

</div>
</div>
</div>

  <!-- Next and previous buttons -->
  
";

    //var_dump($totals);

    echo $header1;
}

function show_row_option_manger($ro)
{
    for ($i = 0; $i < count($ro); $i++) {
        foreach ($ro[$i] as $key => $value) {
            $rou[$key] = $value;
        }
    }

    //  var_dump($ro);

    $x .= '

        <style>
        table .btn{
            width:25px;
            height:25px;
        }
        </style>
        
        <button type="button" class="btn  btn-danger btn-xs"   type="button"   onclick="make_scratch(\'' . $rou['id'] . '\');">
        <i class="fa  fa-shopping-cart "  ></i>
    </button>';

    return $x;
}

function show_row_option_work_image($ro)
{
    for ($i = 0; $i < count($ro); $i++) {
        foreach ($ro[$i] as $key => $value) {
            $rou[$key] = $value;
        }
    }


    $x .= '

        <style>
        table .btn{
            width:25px;
            height:25px;
        }
        </style>
        <script type="text/javascript">';


    if ($rou['scratche'] == "1") {
        $x .= 'set_row_color(\'' . $rou['id'] . '\',\'green\'); ';
    }

    if ($rou['in_work'] == "1" && $rou['out_work'] == "0") {
        $x .= 'set_row_color(\'' . $rou['id'] . '\',\'blue\') ; ';
    }


    $x .= '</script>
        <button type="button" class="btn  btn-success btn-xs"   type="button"   onclick="show_image(\'' . $rou['order_id'] . '\');">
        <i class="fa  fa-eye "  ></i>
    </button>
    
    <button type="button" class="btn  btn-info btn-xs"   type="button"   onclick="refreshwaybill(\'' . $rou['order_id'] . '\');">
    <i class="fa fa-print "  ></i>
</button>

    ';

    return $x;
}

function show_row_option_work($ro)
{
    for ($i = 0; $i < count($ro); $i++) {
        foreach ($ro[$i] as $key => $value) {
            $rou[$key] = $value;
        }
    }

    //  var_dump($rou);

    $x .= '

        <style>
        table .btn{
            width:25px;
            height:25px;
        }
        </style>
       
        <script type="text/javascript">';


    if ($rou['scratche'] == "1") {
        $x .= 'set_row_color(\'' . $rou['id'] . '\',\'green\'); ';
    }

    if ($rou['in_work'] == "1" && $rou['out_work'] == "0") {
        $x .= 'set_row_color(\'' . $rou['id'] . '\',\'blue\') ; ';
    }


    $x .= '</script>

       <button type="button" class="btn  btn-info btn-xs"   type="button"   onclick="refreshwaybill(\'' . $rou['order_id'] . '\');">
       <i class="fa fa-print "  ></i>
   </button>
   <!--
        
        <button type="button" class="btn  btn-success btn-xs"   type="button"   onclick="finish_operation(\'' . $rou['order_id'] . '\',\'' . $rou['id'] . '\',\'' . $_SESSION['user_type'] . '\');">
        <i class="fa fa-shopping-cart "  ></i>
    </button>


    ';

    if ($_SESSION['user_type'] == "2") {
        $x .= ' <button type="button" class="btn  btn-purple btn-xs"   onclick="show_barcode(\'' . $rou['id'] . '\')">
    <i class="fa  fa-barcode " ></i>
</button>';
    }

    $x .= '

<button class="btn  btn-danger btn-xs" type="button"  onclick="cancel_package(\'' . $rou['id'] . '\');">
<i class="fa fa-trash-o" ></i>
</button>
-->

        ';


    return $x;
}


function template_create_order()
{
    global $lang, $allacc, $dr, $error, $services, $out_order;
    echo '		
<div class="page-content-area">
<div class="page-header">
<h1>انشاء امر تسليم</h1><span>اختار عميل او اختار امر تسليم لم يكتمل</span>
</div>
        <div class="row">
        <div class="col-xs-12">
        
        <form id="choose_client"  action="' . SITEURL . '/administrator/work.php?action=create_order"  method="post" onsubmit="return validate_forms(\'choose_client\')" class="form-horizontal" role="form" enctype="multipart/form-data">
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
<select  class="col-xs-10 col-sm-5 chosen-select" name="account_acctno"  >
<option value="">' . $lang[204] . '
</option>
';
    for ($i = 0; $i < count($allacc); $i++) {
        echo '<option value="' . $allacc[$i]['account_name'] . '">' . $allacc[$i]['account_name'] . ' | ' . $allacc[$i]['account_company'] . '</option>';
    }
    echo '
</select>
</div>
</div>

<div class="space-4"></div>

<div class="form-group">
<label class="col-sm-3 control-label no-padding-right"> ' . $lang[879] . '</label>
<div class="col-sm-5">
<select  class="col-xs-10 col-sm-5 chosen-select" name="account_acctname" >
<option value="">' . $lang[204] . '
</option>
';
    for ($i = 0; $i < count($allacc); $i++) {
        echo '<option value="' . $allacc[$i]['account_name'] . '">' . $allacc[$i]['account_company'] . ' | ' . $allacc[$i]['account_name'] . '</option>';
    }
    echo '
</select>
</div>
</div>	






</div>

<div class="col-xs-6">

<div class="form-group">
<label class="col-sm-3 control-label">اختار امر تسليم</label>
<div class="col-sm-9">
<select name="out_order_id">
<option value=""></option>
';

    for ($i = 0; $i < count($out_order); $i++) {
        echo '<option value="' . $out_order[$i]['id'] . '">' . $out_order[$i]['id'] . ' - ' . $out_order[$i]['account_company'] . ' - ' . date("Y-m-d", strtotime($out_order[$i]['create_date'])) . ' </option>';
    }
    echo '</select>
</div>
</div>





                                                </div>

                                                <div style="clear:both;"></div>

<div class="clearfix form-actions">
<div class=" col-md-12">

<button type="submit"  class="btn btn-sm btn-info" name="choosesingleorder">
<i class="ace-icon fa fa-cloud-upload bigger-110"></i>
<span class="bigger-110 no-text-shadow">امر التسليم</span>
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

function template_out_order()
{
    global $data, $acc, $r;
    //echo "<pre>";var_dump($r['finishe_date']);exit();

    echo '  
                <script type="text/javascript">
                var id= \'' . $_GET['id'] . '\' ;
                var account_id = \'' . $acc->account_id . '\';
                </script>

                <script src="' . SITEURL . '/' . STYLE . '/jscript/deliver.js" type="text/javascript" ></script>

                <script src="' . SITEURL . '/' . STYLE . '/jscript/scannerout.js" type="text/javascript" ></script>

                <link type="text/css" rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/css/hideprint.css" />



                <div style="border:solid 2px #000; width:595px;  margin: 10px auto; font-size:9px; padding:10px;" id="out_order_print">
             
                <div class="title" style="text-align:center; float:right; font-size:18px; line-height:30px; font-size:15px;   border-bottom: 1px solid;
                padding: 5px;
                width: 150px;
                margin: auto;"> اذن تسليم منتج رقم (' . $_GET['id'] . ') </div>
          
                
           

                <table style="width:150px; float:right; margin-right:20px; font-size:11px;" >
                <tr>
                <td>اسم العميل</td>
                <td>' . $acc->account_company . '</td>
                </tr>
        
                <tr>
                <td >تاريخ التسليم </td>
                <td>' . date("Y-m-d", strtotime($r['create_date'])) . '</td>                              
                </tr>
        
                <tr>
                <td>اجمالى عدد القطع</td>
                <td id="item_no">' . count($data) . '</td>
                
                </tr>
        
             
                </table>

        <div class="float:left;">
        <img src="' . SITEURL . '/images/logo.jpg" width="50" style="float:left; " />
        </div>

            <div style="clear:both;"></div>    
        <hr/>        
        <table  class="table table-bordered" id="scannerout_data" >
        <thead>
        <tr>
        <th>الطلبية</th>
        <th>العملية</th>
        <th>المكتب</th>
        <th>السمك</th>
        <th>طول</th>
        <th>عرض</th>
        <th>نوع</th>
        <th>الون </th>
        <th>الطباعة</th>
        <th>مسطح</th>
        <th>سنفرة</th>
        <th>التخليع</th>
        <th class="removeprint"></th>
        </tr>
        </thead>
        ';


    for ($i = 0; $i < count($data); $i++) {
        echo '<tr>
    <th>' . $data[$i]['easy_order_id'] . ' - ' . $data[$i]['part_order'] . ' </th>
<th>' . $data[$i]['operation_name'] . ' </th>
<th>' . $data[$i]['office_name'] . ' </th>
<th>' . $data[$i]['package_name'] . ' </th>
<th>' . $data[$i]['length'] . '</th>
<th>' . $data[$i]['width'] . '</th>
<th>' . $data[$i]['company_name'] . ' </th>
<th>' . $data[$i]['glasscolour'] . '</th>
<th>' . $data[$i]['glassPrint'] . '</th>
<th>' . $data[$i]['glassType'] . '</th>
<th>' . $data[$i]['glassScarch'] . '</th>
<th>' . $data[$i]['glassPointing'] . '</th>
<th class="removeprint"><button class="delrow btn btn-xs btn-danger" data="' . $data[$i]['id'] . '"><i class="ace-icon fa fa-trash-o bigger-120"></i></button></th>
    </tr>';
    }


    echo '</table>';
    echo ' 

    <table style="width:100%; font-size:12px; text-align:center;">
    <tr>
    <td>التسليمات</td>
    <td>المالية</td>
    <td>المستلم</td>
   
    </tr>

    <tr>
    <td>&nbsp&nbsp</td>
    <td>&nbsp&nbsp</td>
    <td>&nbsp&nbsp</td>
    
    </tr>
    </table>

    </div>';

    if (!isset($_GET['print'])) {
        echo '
    <div class="removeprint" style="margin:auto; text-align:center;" >
    
    <button class="btn btn-primary" onclick="javascript:location.href=\'work.php?action=create_out_order&print=1&id=' . $_GET['id'] . '\'">
			<i class="ace-icon fa fa-print align-top bigger-125"></i>
												طباعة
            </button>





            <button class="btn btn-primary" onclick="out_order_finish(\'' . $_GET['id'] . '\');" >
												انهاء امر التسليم
            </button>
    </div>

    ';
    }


    if ($_SESSION['user_type'] == "accounting") {
        echo '
    <div class="noprint" style="margin:auto; text-align:center;" >
    


            <button class="btn btn-primary" onclick="out_order_finish_all(\'' . $_GET['id'] . '\');" >
												انهاء امر التسليم
            </button>
    </div>

    ';
    }
}

function template_scratche_form()
{
    global $data, $lang,$allreason;
    // var_dump($data);
    echo
    '<form id="scratche_form" name="scratche_form" action="" method="post" >
    <input type="hidden" name="id" value="' . $data['id'] . '" />
    <input type="hidden" name="package_id" value="' . $data['package_id'] . '" />
    
    <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">اسم العملية</label>
    <div class="col-sm-9">
    <input type="text" name=""  value ="'. $data['statusname'].'" readonly class="col-xs-10 col-sm-5" value=""  />
    </div>
    </div>
     <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">اسم العامل</label>
    <div class="col-sm-9">
    <input type="text" name=""  value ="'. $data['user_name'].'" readonly class="col-xs-10 col-sm-5" value=""  />
    </div>
    </div>       
    <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">اسم المتسبب</label>
    <div class="col-sm-9">
    <input type="text" name="perosn" id="perosn" class="col-xs-10 col-sm-5" value=""  />
    </div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">السبب</label>
    <div class="col-sm-9">
    <select name="reason" id="reason">
    <option value="">اختار السبب
     </option>
    ';
    
    for ($i = 0; $i < count($allreason); $i++) {
        echo '<option value="' . $allreason[$i]['value'] . '">' . $allreason[$i]['value'] . '</option>';
    }
    echo '
    </select>
    </div>
    </div>
    
    
    <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">العملية</label>
    <div class="col-sm-9">
    <select name="applied_operation" >
    <option value="">اختار العملية</option>
    <option value="6">جملون</option>
    <option value="2">تقطيع</option>
    <option value="3">شطف وتخليع</option>
    <option value="4">فرن</option>
    <option value="5">توريد</option>
    </select>
    </div>
    </div>
    
            </form>';
}

function template_work_index()
{
    global $lang, $c_setting, $html_grid;


    echo '<script src="' . SITEURL . '/' . STYLE . '/jscript/order.js"></script>
        <script src="' . SITEURL . '/' . STYLE . '/jscript/scanner.js"></script>

        
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
    echo '<div id="grid">'.$html_grid."</div>";
}


function template_printer_order()
{
    global $lang;

    echo '   
                    <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/outsideprint.js"></script>

         
                    <div  class="form-horizontal" >

                        <input type="hidden" name="action" value="accounts_accounting">
                    
                    
                    <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">رقم الطلبية</label>
                    <div class="col-sm-9">
                    
                    <input type="text" id="easy_order_id">
                    </div>
                    </div>
                    
                    
                    <button onclick="print_order_barcode(\''.SITEURL.'\');" class="btn btn-danger btn-block  >
                    <i class="ace-icon fa fa-print align-top bigger-125"></i>
                      طباعة&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </button>
                        
                    </div>
        
        
';
}
function template_finish_order()
{
    global $lang;

    echo '   
                    <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/outsideprint.js"></script>

         
                    <div  class="form-horizontal" >

                        <input type="hidden" name="action" value="accounts_accounting">
                    
                    
                    <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">رقم الطلبية</label>
                    <div class="col-sm-9">
                    
                    <input type="text" id="finish_order_id">
                    </div>
                    </div>
                    
                    
                    <button onclick="finish_order_barcode();" class="btn btn-danger btn-block  >
                    <i class="ace-icon fa fa-print align-top bigger-125"></i>
                      ترحيل&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </button>
                        
                    </div>
        
        
';
}
function template_outside_print()
{
    global $lang;

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
                <![endif]-->
        
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
                    
            
                    
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery-ui.custom.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.ui.touch-punch.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/chosen.jquery.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/fuelux/fuelux.spinner.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/date-time/bootstrap-datepicker.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/date-time/bootstrap-timepicker.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/date-time/moment.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/date-time/daterangepicker.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/date-time/bootstrap-datetimepicker.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/bootstrap-colorpicker.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.knob.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.autosize.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/jquery.maskedinput.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/bootstrap-tag.min.js"></script>
                <script src="' . SITEURL . '/' . STYLE . '/assets/js/typeahead.jquery.min.js"></script>
                        
        
                <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/jquery.scannerdetection.js"></script>
        

            <script type="text/javascript">
            var siteurl = \'' . SITEURL . '\';
                    
            var formurl = \'' . formurl . '\';
        
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
                    <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/outsideprint.js"></script>

            </head>
        
            <body class="no-skin rtl">
            


            <div id="navbar" class="navbar navbar-default">
            <script type="text/javascript">
                try{ace.settings.check(\'navbar\' , \'fixed\')}catch(e){}
            </script>

            <div class="navbar-container" id="navbar-container">
                <!-- #section:basics/sidebar.mobile.toggle -->
              

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
                </div>

            </div><!-- /.navbar-container -->
        </div>
        
        
                <div class="main-container" id="main-container">
                                   
                                                                            
        <div class="main-content">     
                <div class="page-content">
     

                    <div class="page-content-area">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->			
    

                            <form id="out_side_print" class="form-horizontal" onsubmit="serch_form();"   >

                            <div class="input-group">
																<input class="form-control input-mask-date" type="text" id="auto_search">
																<span class="input-group-btn">
																	<button class="btn btn-sm btn-default" type="submit">
																		<i class="ace-icon fa fa-search bigger-110"></i>
																		بحث
																	</button>
																</span>
                                                            </div>
                                                            
              
                            </form>
<br>
                            <p>
											<button class="btn btn-danger btn-block" onclick="print_barcode();">طباعة</button>
										</p>

                            <table class="dataTable table  table-bordered   "  id="print_resut">
<tr>
<td>رقم القطعة</td>
<td>طول</td>
<td>عرض</td>
<td>سمك</td>
<td style="width:30px;"></td>
</tr>
                            </table>

                            </div>
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>

            </body>
            </html>';
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
