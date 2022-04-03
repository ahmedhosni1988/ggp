<?php


function printDeleteLink($params)
{
    extract($params);
    return '<a onclick="return confirm(\'' . $lang[759] . '\');"  href="' . SITEURL . '/client/client_admin.php?action=deluser&userid=' . $record['user_id'] . '" >' . $lang[259] . '</a>';
}

function notify_list()
{
    global $lang, $notification, $new_message, $new_invoice, $updated_order, $view_message, $update_order;

    $nmes = search($notification, 'types', 'new_message');

    $norder = search($notification, 'types', 'update_order');
    $norder = array_merge($norder, search($notification, 'types', 'cancel_order'));

    $ninv = search($notification, 'types', 'new_invoice');

//	print_r($nmes);
    $x = '<div class="navbar-buttons navbar-header pull-right" role="navigation" >
					<ul class="nav ace-nav">
						<li class="grey">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-tasks"></i>
								<span class="badge badge-grey">' . $new_invoice . '</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-check"></i>
									' . $new_invoice . ' Invoices
								</li>

							';

    if (is_array($ninv) && count($ninv) > 0) {

        for ($i = 0; $i < count($ninv); $i++) {
            //echo "ahmed";
            $x .= '
														<li>
											<a href="#">
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Invoice No. ' . $ninv[$i]['invoiceno'] . ' Due Date ' . $ninv[$i]['duedate'] . '</span>
													
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>' . time_elapsed_string($ninv[$i]['date']) . '</span>
													</span>
												</span>
											</a>
										</li>
														';
        }
    } else {
        $x .= '<li>No New Invoices.</li>';

    }

    $x .= '

								<li class="dropdown-footer">
									<a href="' . formurl . '/client_admin.php?action=current_invoice">
										See New Invoices
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="purple">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important">' . $update_order . '</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									' . $update_order . ' Notifications
								</li>

								';

    if (is_array($norder) && count($norder) > 0) {

        for ($i = 0; $i < count($norder); $i++) {
            //echo "ahmed";
            $x .= '
														<li>
											<a href="#">
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Order No. ' . $norder[$i]['order_id'] . ' Status Changed</span>
													
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
        $x .= '<li>No New Orders updates.</li>';

    }

    $x .= '
											

								<li class="dropdown-footer">
									<a href="' . formurl . '/montior.php?action=pending">
										Go to motior orders
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="green">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
								<span class="badge badge-success">' . $new_message . '</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-envelope-o"></i>
									' . $new_message . ' Messages
								</li>

								<li class="dropdown-content ace-scroll" style="position: relative;"><div class="scroll-track" style="display: none;"><div class="scroll-bar"></div></div><div class="scroll-content" style="max-height: 200px;">
									<ul class="dropdown-menu dropdown-navbar">
											';

    if (is_array($nmes) && count($nmes) > 0) {
        for ($i = 0; $i < count($nmes); $i++) {
            $x .= '
														<li>
											<a href="#">
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">' . $nmes[0]['m_user_name'] . ':</span>
														' . $nmes[0]['m_body'] . ' ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>' . time_elapsed_string($nmes[0]['notify_times']) . '</span>
													</span>
												</span>
											</a>
										</li>
														';
        }
    } else {
        $x .= '<li>No New Message.</li>';

    }

    $x .= '
										

									</ul>
								</div></li>

								<li class="dropdown-footer">
									<a href="' . formurl . '/messages.php#send">
										See all messages
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
									<a href="' . SITEURL . '/client/index.php?action=edit_my_setting">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>

						

								<li class="divider"></li>

								<li>
									<a href="' . SITEURL . '/client/index.php?action=logout">
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

function template_header_client()
{
    global $lang, $notification, $new_message, $new_invoice, $updated_order, $view_message;

    if ($view_message != "" && $_SESSION['logged_no'] == 0) {
        echo '
<script type="text/javascript">
$(document).ready(function (){
show_client_message(' . json_encode($view_message) . ');
});

</script>
';
        $_SESSION['logged_no'] = 1;
    }

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
				<div class="navbar-header pull-left">
					<!-- #section:basics/navbar.layout.brand -->
					<a href="#" class="navbar-brand">
						<small>
							<i class="fa fa-leaf"></i>
							' . SITENAME . '
						</small>
					</a>

					<!-- /section:basics/navbar.layout.brand -->

					<!-- #section:basics/navbar.toggle -->

					<!-- /section:basics/navbar.toggle -->
				</div>

		' . notify_list() . '
			</div><!-- /.navbar-container -->
		</div>
		
		
				<div class="main-container" id="main-container">
									' . client_menu() . '
																			
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

function client_menu()
{
    global $lang;
    $x = '	

			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar responsive">
				<script type="text/javascript">
					try{ace.settings.check(\'sidebar\' , \'fixed\')}catch(e){}
				</script>



				<ul class="nav nav-list">
					<li class="">
						<a href="' . SITEURL . '/client">
							<i class="menu-icon glyphicon  glyphicon-home"></i>
							<span class="menu-text"> ' . $lang[1] . ' </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="' . SITEURL . '/client/index.php?action=addorder">
							<i class="menu-icon fa fa-car"></i>
							<span class="menu-text"> ' . $lang[23] . ' </span>
						</a>

						<b class="arrow"></b>
					</li>

							<!--		
					<li class="">
						<a href="' . SITEURL . '/client/index.php?action=express_entry">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> ' . $lang[869] . ' </span>
						</a>

						<b class="arrow"></b>
					</li>
							-->
											
					<li class="">
						<a href="' . SITEURL . '/client/montior.php?action=pending">
							<i class="menu-icon fa fa-calendar"></i>
							<span class="menu-text">' . $lang[24] . '</span>
						</a>

						<b class="arrow"></b>
					</li>
									
					<li class="">
						<a href="' . SITEURL . '/client/search.php?action=mangesearch">
							<i class="menu-icon fa fa-search"></i>
							<span class="menu-text">' . $lang[26] . '</span>
						</a>

						<b class="arrow"></b>
					</li>
					
					<li class="">
						<a href="' . SITEURL . '/client/messages.php">
							<i class="menu-icon fa fa-envelope"></i>
							<span class="menu-text">' . $lang[89] . '</span>
						</a>

						<b class="arrow"></b>
					</li>
									';

    if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_type']) && $_SESSION['logged_in'] == true && $_SESSION['user_type'] == "administrator") {
        $x .= '<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-cog"></i>
							<span class="menu-text"> Settings</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="' . SITEURL . '/client/client_admin.php?action=company_details" >
									<i class="menu-icon fa fa-caret-right"></i>
									' . $lang[29] . '
								</a>
								<b class="arrow"></b>			
							</li>

							<li class="">
								<a href="' . SITEURL . '/client/client_admin.php?action=mange_user">
									<i class="menu-icon fa fa-caret-right"></i>
									' . $lang[30] . '
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="' . SITEURL . '/client/address.php">
									<i class="menu-icon fa fa-caret-right"></i>
									' . $lang[382] . '
								</a>

								<b class="arrow"></b>
							</li>
																	
						</ul>
					</li>

					
											
											<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-book"></i>
							<span class="menu-text"> Accounting</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="' . SITEURL . '/client/client_admin.php?action=current_invoice" >
									<i class="menu-icon fa fa-caret-right"></i>
									' . $lang[32] . '
								</a>
								<b class="arrow"></b>			
							</li>

							<li class="">
								<a href="' . SITEURL . '/client/client_admin.php?action=search_invoice">
									<i class="menu-icon fa fa-caret-right"></i>
									' . $lang[33] . '
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

function template_menu_client_menu()
{
    global $lang;
    echo '<div id="left_side_client">

				
			</div>';
}

function template_client_index()
{
    global $lang;
    echo '<div id="right_side" style="font-size:18px; font-weight:bold; line-height:30px; ">

<table class="main_page_table" style="width:100%;">
<tr>
<td>


<a href="index.php?action=addorder">
<img src="' . SITEURL . '/' . STYLE . '/css/images/order.jpg" width="120" height="120" />
<br>
' . $lang[23] . '
</a>


</td>



<td>
<a href="montior.php"><img src="' . SITEURL . '/' . STYLE . '/css/images/ordermanagment1.jpg" width="120" height="120" />
<br>
' . $lang[79] . '
</a>


</td>

<td><a href="index.php?action=search"><img src="' . SITEURL . '/' . STYLE . '/css/images/search.jpg" width="120" height="120" />
<br>
' . $lang[54] . '
</a></td>

<td><a href="client_admin.php?action=mange_user"><img src="' . SITEURL . '/' . STYLE . '/css/images/userman.jpg" width="120" height="120" />
<br>
' . $lang[461] . '
</a></td>



</tr>


<tr>
<td><a href="address.php">
<img src="' . SITEURL . '/' . STYLE . '/css/images/accounting.jpg" width="120" height="120" />
<br>
' . $lang[382] . '
</a></td>

<td><a href="client_admin.php?action=company_details"><img src="' . SITEURL . '/' . STYLE . '/css/images/setting.jpg" width="120" height="120" />
<br>
' . $lang[29] . '
</a></td>

<td><a href="client_admin.php?action=current_invoice"><img src="' . SITEURL . '/' . STYLE . '/css/images/money.png" width="120" height="120" />
<br>
' . $lang[760] . '
</a></td>

<td><a href="index.php?action=logout"><img src="' . SITEURL . '/' . STYLE . '/css/images/logout.jpg" width="120" height="120" />
<br>
' . $lang[25] . '
</a></td>


</tr>



</table>
<div style="clear:both;"></div>



</div>';
}


function template_company_details()
{
    global $lang, $account_details, $account_contacts, $account_users;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/client.js"></script>



<form id="companydetails" name="companydetails" method="post" action="' . SITEURL . '/client/client_admin.php?action=company_details" class="form-horizontal" role="form">
<h4 class="header green">' . $lang[58] . '</h4>


<div class="col " style="width:30%; border-right:1px solid #ccc; "  >
<h4 class="header green">' . $lang[59] . '</h4>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[17] . '</label>
<div class="col-sm-9"><input type="text" name="account_id" value="' . $account_details->account_name . '" disabled="disabled" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[6] . '</label>
<div class="col-sm-9"><input type="text" name="account_company" value="' . $account_details->account_company . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><textarea name="account_address" >' . $account_details->account_address . '</textarea></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[8] . '</label>
<div class="col-sm-9"><input type="text" name="city" value="' . $account_details->city . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[9] . '</label>
<div class="col-sm-9"><input type="text" name="pcode" value="' . $account_details->pcode . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="phone" value="' . $account_details->phone . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[12] . '</label>
<div class="col-sm-9"><input type="text" name="fax" value="' . $account_details->fax . '" /></div>
</div>

</div>

<div class="col " style="width:30%; border-right:1px solid #ccc; "   >
<h4 class="header green">' . $lang[10] . '</h4>

';
    if (is_array($account_contacts)) {
        for ($i = 0; $i < 3; $i++) {
            echo '
		<div class="form-group">
<input type="hidden" name="nc__valid[]" value="' . (!empty($account_contacts[$i]['contact_id']) ? $account_contacts[$i]['contact_id'] : '') . '" />

<label class="col-sm-3 control-label">' . $lang[10] . ' (' . ($i + 1) . ')</label>
<div class="col-sm-9"><input type="text" name="nc__contact_name[]" value="' . (!empty($account_contacts[$i]['contact_name']) ? $account_contacts[$i]['contact_name'] : '') . '" /></div>
</div>
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . ' (' . ($i + 1) . ')</label>
<div class="col-sm-9"><input type="text" name="nc__contact_phone[]" value="' . (!empty($account_contacts[$i]['phone']) ? $account_contacts[$i]['phone'] : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . ' (' . ($i + 1) . ')</label>
<div class="col-sm-9"><input type="text" name="nc__contact_email[]" value="' . (!empty($account_contacts[$i]['email']) ? $account_contacts[$i]['email'] : '') . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">
<input type="checkbox" name="nc__email_notify[' . $i . ']" value="1" ' . (isset($account_contacts[$i]['email_notify']) && $account_contacts[$i]['email_notify'] == 1 ? 'checked' : '') . ' />
		</label>
<div class="col-sm-9">' . $lang[441] . '</div>
</div>

<hr>

';
        }
    }

    echo '
</div>

<div class="col " style="width:30%; "  >
<h4 class="header green">' . $lang[60] . '</h4>

<div class="form-group">
<label class="col-sm-3 control-label"><input type="checkbox" name="ref_mandatory" value="1" ' . ($account_details->ref_mandatory == 1 ? 'checked' : '') . '></label>
<div class="col-sm-9">' . $lang[512] . '</div>
</div>

<div class="title">' . $lang[69] . '</div>
<div style="clear:both;"></div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[85] . '</label>
<div class="col-sm-9"><input type="text" name="online_invoicing_email" value="' . $account_details->online_invoicing_email . '" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[71] . '</label>
<div class="col-sm-9">
<select name="online_invoicing_userid1">
<option value="">' . $lang[513] . '</option>';
    if (is_array($account_users) && count($account_users) > 0) {
        for ($u = 0; $u < count($account_users); $u++) {
            echo '<option value="' . $account_users[$u]['user_id'] . '"  ' . ($account_users[$u]['user_id'] == $account_details->online_invoicing_userid1 ? 'selected' : '') . '>' . $account_users[$u]['user_name'] . '</option>';
        }

    }
    echo '
</select>
</div>
</div>


</div>
<div style="clear:both;"></div>
<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
<input type="button" value="' . $lang[50] . '"  name="edit_account" onclick="edit_accounts(\'' . $_SESSION['account_id'] . '\');" class="btn btn-info" />
</div>
</div>

</form>
<div id="result"></div>
';
}

function template_manage_account_user()
{
    global $lang, $grid, $test;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
 <script type="text/javascript">
  $(document).ready(function() {
    $("#tabs_man").tabs();
  });
  </script>
  
<div id="tabs_man" class="ui-tabs ui-widget ui-widget-content ui-corner-all">

<ul>
   <li><a href="client_admin.php?action=mange_user&get_users=1" >' . $lang[198] . '</a></li>
   <li><a href="client_admin.php?action=adduser" >' . $lang[98] . '</a></li>

</ul>

<div id="tabs-10" style="padding:0px;" >
</div>

<div id="tabs-11" >
</div>
</div>


<div style=" clear:both;"></div>

<div style=" clear:both;"></div>
';
}


function template_show_users()
{
    global $html_grid;
    echo '	<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/client.js"></script>
<div id="res"></div>';
    echo $html_grid;

}

function print_editlink($ro)
{
    global $lang;
    $ro = change_index_to_key($ro);

    return '
		<div class="hidden-sm hidden-xs btn-group">
		<button class="btn btn-xs btn-info" onclick="show_edit_userclientportal(\'' . $ro['user_id'] . '\',\'' . $ro['name'] . '\')">
																<i class="ace-icon fa fa-pencil bigger-120"></i>
															</button>
				<button class="btn btn-xs btn-danger" onclick="delete_users(\'' . $ro['user_id'] . '\',\'' . $ro['name'] . '\');">
																<i class="ace-icon fa fa-trash-o bigger-120"></i>
															</button>
				
		</div>';
}

function print_deletelink($ro)
{
    $ro = change_index_to_key($ro);

    return '<a onclick="delete_users(\'' . $ro['user_id'] . '\',\'' . $ro['name'] . '\');" >' . $lang[259] . '</a>';
}


function template_current_invoice_console()
{
    global $html_grid;
    echo $html_grid;

}

function print_invoice($ro)
{
    $ro = change_index_to_key($ro);

    return '<a href="' . SITEURL . '/client/client_admin.php?action=payinvoice&id=' . $ro['id'] . '" target="_blank"  ><img src="' . SITEURL . '/' . STYLE . '/css/images/printer.jpg" height="30" width="30"/></a>';
}

function template_print_invoice()
{
    global $lang, $inv_details, $inv_balance, $acc_details, $inv_lines, $account_id, $invoiceno, $c_setting, $total;

    $trwidth = 245;

    $page_no = 1;
    $maxlines = $c_setting["co_lines_perpage"];
    $save_maxlines = $maxlines;  //* this gets incremented for pg2 etc, so we need to
    //  restore it each loop if printing multiple copies.
    $invoiceoption_1 = $c_setting["co_invoiceoption_1"];
    $invoiceoption_2 = $c_setting["co_invoiceoption_2"];
    $invoiceoption_3 = $c_setting["co_invoiceoption_3"];
    $invoiceoption_4 = $c_setting["co_invoiceoption_4"];
    $invoiceoption_5 = $c_setting["co_invoiceoption_5"];
    $invoiceoption_6 = $c_setting["co_invoiceoption_6"];
    $invoiceoption_7 = $c_setting["co_invoiceoption_7"];
    $invoiceoption_8 = $c_setting["co_invoiceoption_8"];
    $invoiceoption_9 = $c_setting["co_invoiceoption_9"];

    $invoiceoption_rb1 = $c_setting["co_invoiceoption_rb1"];
    $invoiceoption_rb2 = $c_setting["co_invoiceoption_rb2"];
    $invoiceoption_rb3 = $c_setting["co_invoiceoption_rb3"];
    $invoiceoption_rb4 = $c_setting["co_invoiceoption_rb4"];
    $invoiceoption_rb5 = $c_setting["co_invoiceoption_rb5"];
    $invoiceoption_rb6 = $c_setting["co_invoiceoption_rb6"];
    $invoiceoption_rb7 = $c_setting["co_invoiceoption_rb7"];
    $invoiceoption_rb8 = $c_setting["co_invoiceoption_rb8"];
    $invoiceoption_rb9 = $c_setting["co_invoiceoption_rb9"];


    $rc = mysqli_query($mycon,"select * from account where account_id ='$account_id'") or die(mysqli_error($mycon));
    $customer = mysqli_fetch_array($rc);
    mysqli_free_result($rc);
    //$clid  = $customer["id"];
    $name = $customer["account_company"];
    $addr = $customer["account_address"];
    $city = $customer["city"];
    $pcode = $customer["pcode"];
    $billto_name = $customer["billto_company"];
    $billto_addr = $customer["billto_addr"];
    $billto_city = $customer["billto_city"];
    $billto_pcode = $customer["billto_pcode"];
    $billto_apcontact = $customer["billto_apcontact"];
    //*just in case... if not set-> set to Standard.
    if ($customer["invoiceoption_1"] == 0) $customer["invoiceoption_1"] = 1;
    if ($customer["invoiceoption_2"] == 0) $customer["invoiceoption_2"] = 1;
    if ($customer["invoiceoption_3"] == 0) $customer["invoiceoption_3"] = 1;
    if ($customer["invoiceoption_4"] == 0) $customer["invoiceoption_4"] = 1;
    if ($customer["invoiceoption_5"] == 0) $customer["invoiceoption_5"] = 1;
    if ($customer["invoiceoption_6"] == 0) $customer["invoiceoption_6"] = 1;
    if ($customer["invoiceoption_7"] == 0) $customer["invoiceoption_7"] = 1;
    if ($customer["invoiceoption_8"] == 0) $customer["invoiceoption_8"] = 1;
    if ($customer["invoiceoption_9"] == 0) $customer["invoiceoption_9"] = 1;

    //Checkboxes
    //option 1 - reference
    if ($customer["invoiceoption_1"] != 1) {
        if ($customer["invoiceoption_1"] == 2) $invoiceoption_1 = "Y";
        else                                    $invoiceoption_1 = "N";
    }
    //option 2 - Unused - (was doublespace)
    if ($customer["invoiceoption_2"] != 1) {
        if ($customer["invoiceoption_2"] == 2) $invoiceoption_2 = "Y";
        else                                    $invoiceoption_2 = "N";
    }
    //option 3 - Unused
    if ($customer["invoiceoption_3"] != 1) {
        if ($customer["invoiceoption_3"] == 2) $invoiceoption_3 = "Y";
        else                                    $invoiceoption_3 = "N";
    }
    //option 4 - Print stmt info on invoice
    if ($customer["invoiceoption_4"] != 1) {
        if ($customer["invoiceoption_4"] == 2) $invoiceoption_4 = "Y";
        else                                    $invoiceoption_4 = "N";
    }
    //option 5 - Print F.S. on lineform-groups
    if ($customer["invoiceoption_5"] != 1) {
        if ($customer["invoiceoption_5"] == 2) $invoiceoption_5 = "Y";
        else                                    $invoiceoption_5 = "N";
    }
    //option 6 - Print Taxes on lineform-groups
    if ($customer["invoiceoption_6"] != 1) {
        if ($customer["invoiceoption_6"] == 2) $invoiceoption_6 = "Y";
        else                                    $invoiceoption_6 = "N";
    }
    //option 7 - Sort & subtotal by Reference code
    if ($customer["invoiceoption_7"] != 1) {
        if ($customer["invoiceoption_7"] == 2) $invoiceoption_7 = "Y";
        else                                    $invoiceoption_7 = "N";
    }

    //option 8  -  Unused
    if ($customer["invoiceoption_8"] != 1) {
        if ($customer["invoiceoption_8"] == 2) $invoiceoption_8 = "Y";
        else                                    $invoiceoption_8 = "N";
    }
    //option 9  -  Unused
    if ($customer["invoiceoption_9"] != 1) {
        if ($customer["invoiceoption_9"] == 2) $invoiceoption_9 = "Y";
        else                                    $invoiceoption_9 = "N";
    }

    //RadioButtons
    //option rb1 - Lineform-group detail
    if ($customer["invoiceoption_rb1"] > 1)
        $invoiceoption_rb1 = $customer["invoiceoption_rb1"] - 1;
    //option rb2 - Service type
    if ($customer["invoiceoption_rb2"] > 1)
        $invoiceoption_rb2 = $customer["invoiceoption_rb2"] - 1;
    //option rb3 - unused
    if ($customer["invoiceoption_rb3"] > 1)
        $invoiceoption_rb3 = $customer["invoiceoption_rb3"] - 1;
    //option rb4 - Wait & Extra; same/separte lines
    if ($customer["invoiceoption_rb4"] > 1)
        $invoiceoption_rb4 = $customer["invoiceoption_rb4"] - 1;
    //option rb5 - unused
    if ($customer["invoiceoption_rb5"] > 1)
        $invoiceoption_rb5 = $customer["invoiceoption_rb5"] - 1;
    //option rb6 - Fontsize
    if ($customer["invoiceoption_rb6"] > 1)
        $invoiceoption_rb6 = $customer["invoiceoption_rb6"] - 1;
    //option rb7 - Print Detail (spacing/wrapping)
    if ($customer["invoiceoption_rb7"] > 1)
        $invoiceoption_rb7 = $customer["invoiceoption_rb7"] - 1;
    //option rb8 - unused
    if ($customer["invoiceoption_rb8"] > 1)
        $invoiceoption_rb8 = $customer["invoiceoption_rb8"] - 1;
    //option rb9 - unused
    if ($customer["invoiceoption_rb9"] > 1)
        $invoiceoption_rb9 = $customer["invoiceoption_rb9"] - 1;

    //Ensure valid RB options
    if ($invoiceoption_rb1 == 0) $invoiceoption_rb1 = 1;
    if ($invoiceoption_rb2 == 0) $invoiceoption_rb2 = 1;
    if ($invoiceoption_rb3 == 0) $invoiceoption_rb3 = 1;
    if ($invoiceoption_rb4 == 0) $invoiceoption_rb4 = 1;
    if ($invoiceoption_rb5 == 0) $invoiceoption_rb5 = 1;
    if ($invoiceoption_rb6 == 0) $invoiceoption_rb6 = 1;
    if ($invoiceoption_rb7 == 0) $invoiceoption_rb7 = 1;
    if ($invoiceoption_rb8 == 0) $invoiceoption_rb8 = 1;
    if ($invoiceoption_rb9 == 0) $invoiceoption_rb9 = 1;

    //*Adjust $maxsize IF they have a customer override for FontSize.
    //Here's the stats;  (per 6" of lineform-group body)
    // 1.Small:  41 lines
    // 2.Medium: 33 lines
    // 3.Large:  28 liens

    //$xxx =$invoiceoption_rb6;
    //$yyy =$c_setting["co_invoiceoption_rb6"];

    if ($invoiceoption_rb6 != $c_setting["co_invoiceoption_rb6"]) {
        //1. c_setting is SMALL
        if ($c_setting["co_invoiceoption_rb6"] == 1) {
            if ($invoiceoption_rb6 == 2) $maxlines = round($maxlines * 0.80);
            if ($invoiceoption_rb6 == 3) $maxlines = round($maxlines * 0.68);
        }
        //2. c_setting is MEDIUM
        if ($c_setting["co_invoiceoption_rb6"] == 2) {
            if ($invoiceoption_rb6 == 1) $maxlines = round($maxlines * 1.24);
            if ($invoiceoption_rb6 == 3) $maxlines = round($maxlines * 0.85);
        }
        //3. c_setting is LARGE
        if ($c_setting["co_invoiceoption_rb6"] == 3) {
            if ($invoiceoption_rb6 == 1) $maxlines = round($maxlines * 1.46);
            if ($invoiceoption_rb6 == 2) $maxlines = round($maxlines * 1.18);
        }
        $save_maxlines = $maxlines;  //* do this again, since we just changed it
    }

    //*Put these options in terms we can understand.
    //note: $copies set in adminbilling_invoice
    $option_reference = $invoiceoption_1;
    $option_unused_2 = $invoiceoption_2;  // was - doublespace
    $option_unused_3 = $invoiceoption_3;
    $option_stmt = $invoiceoption_4;
    $option_fs_on_lines = $invoiceoption_5;
    $option_tax_on_lines = $invoiceoption_6;
    $option_sortby_ref = $invoiceoption_7;
    $option_unused_8 = $invoiceoption_8;
    $option_unused_9 = $invoiceoption_9;

    $option_linedetail = $invoiceoption_rb1;
    $option_svctype = $invoiceoption_rb2;
    $option_fromto_detail = $invoiceoption_rb3;
    $option_wait_extra_lines = $invoiceoption_rb4;
    $option_copies = $invoiceoption_rb5;  //not used here, but is used in invoiceall.
    $option_line_fontsize = $invoiceoption_rb6;
    $option_spacing = $invoiceoption_rb7;
    $option_unused_rb8 = $invoiceoption_rb8;
    $option_unused_rb9 = $invoiceoption_rb9;

//echo $maxlines;


    echo '
<link rel="stylesheet" href="' . SITEURL . '/' . STYLE . '/css/print.css" type="text/css" media="print" />

		<div class="ivoice_body" style="margin:auto; width:700px;">

<div class="hideprint" STYLE="width:600;">

<center>';

    if ($c_setting["co_online_payments"] == "Y")
        //***REAL***
        echo '<FORM name=_xclick action=https://www.paypal.com/cgi-bin/webscr method=post>  ';
    //***SANDBOX***
    //ho "<FORM name=_xclick action=https://www.sandbox.paypal.com/cgi-bin/webscr method=post>  ";
    else
        echo '<form align="center">  ';


    echo '<input type=hidden name=invoiceno value="' . $invoiceno . '" >

<input type=button
        value="&nbsp;&nbsp;' . $lang[603] . '&nbsp;&nbsp;"
        onClick="print()"
        style="font-weight:bold;
                font-size:14;
                color:white;
                font-family:Comic Sans Ms;
                background:#A0A0A0"  />';

    if ($c_setting["co_online_payments"] == "Y") {

        if ($cu['co_online_payments_currency'] == 1) $currency = "CAD";
        else if ($cu['co_online_payments_currency'] == 2) $currency = "USD";
        else if ($cu['co_online_payments_currency'] == 3) $currency = "EUR";
        else if ($cu['co_online_payments_currency'] == 4) $currency = "GBP";
        else                                               $currency = "USD";

        $return_url = "http://" . SITEURL . "/thanksp.php";
        $item_name = "Invoice&nbsp;no.&nbsp;" . $_GET['id'];

        echo '
   <INPUT type="hidden" name=cmd              value="_xclick"        />
   <INPUT type=hidden name=business         value=' . $c_setting["co_online_payments_email"] . '     / >
   <INPUT type=hidden name=invoice          value=' . $inv_details->id . '     />
   <INPUT type=hidden name=form-group_name  value=' . $item_name . '     />
   		
   <INPUT type=hidden name=currency_code    value=' . $currency . '      />
   <INPUT type=hidden name=amount           value=' . $inv_balance . '  />
   <INPUT type=hidden name=return           value=' . $return_url . '    />

   <INPUT type=image alt="' . $lang[766] . '" src="http://www.paypal.com/en_US/i/btn/x-click-but02.gif" border="10" name="submit" />
';
    }

    echo '<tr><td align=center>   &nbsp;&nbsp;&nbsp;
         <input type=button value="&nbsp;&nbsp;' . $lang[767] . '&nbsp;&nbsp;"
         onclick=\'top.window.close()\'
         style="font-weight:bold;
                 font-size:14;
                 color:white;
                 font-family:Comic Sans Ms;
                 background:#A0A0A0" /></td></tr> <br><br>
</form>
</center>
</div> 


<table border="2" cellspacing="0" width="670">
<tbody><tr><td>
<table border="0" cellspacing="0">
<tbody>
<tr> 
<td bgcolor="ffffff"> 
<table border="0" cellspacing="0">  
<tbody>
<tr>
<td valign="top" width="375"> 
<table border="0" cellspacing="0"> 
<tbody><tr><td align="left" bgcolor="ffffff">
<font face="verdana" size="' . $option_line_fontsize . '">
<img src="' . SITEURL . '/images/invoice_banner.jpg">
</font>
</td></tr>
      </tbody>
	  </table> 
	  </td> 
	  <td valign="center" width="11"> 
	  <table border="0" cellspacing="0">        
	  </table> 
	  
	  </td><td align="left" valign="top" width="260"> 
	  <table border="0" cellspacing="3"> 
	  <tbody>
	  <tr>
	  <td valign="bottom" align="center" width="250" colspan="2" bgcolor="444444">
	  <font color="white" size="3" face="tahoma"><b>' . $lang[768] . '</b></font>
	  </td>
	  </tr>
<tr>
<td align="left" bgcolor="f4f4f4"><font face="verdana" size="2">' . $lang[532] . ' </font></td>
<td align="right" bgcolor="ffffff"><font face="verdana" size="2">' . $inv_details->id . '</font></td>
</tr>
<tr>
<td align="left" bgcolor="f4f4f4"><font face="verdana" size="2">' . $lang[280] . ' </font></td>
<td align="right" bgcolor="ffffff"><font face="verdana" size="2">' . date(DATE_FORMAT, strtotime($inv_details->date)) . '</font></td>
</tr>
<tr>
<td align="left" bgcolor="f4f4f4"><font face="verdana" size="2">' . $lang[533] . ' </font></td>
<td align="right" bgcolor="ffffff"><font face="verdana" size="2">' . $inv_details->terms . '</font></td>
</tr>

<tr>
<td align="left" bgcolor="f4f4f4"><font face="verdana" size="2">' . $lang[533] . ' </font></td>
<td align="right" bgcolor="ffffff"><font face="verdana" size="2">' . date(DATE_FORMAT, strtotime($inv_details->duedate)) . '</font></td>
</tr>
<tr>
<td align="left" bgcolor="ffffff"><font face="verdana" size="2">' . $lang[390] . ' </font></td>
<td bgcolor="ffffff"><font face="verdana" size="2">&nbsp;&nbsp;&nbsp;' . $page_no . '</font></td>
</tr>
       </tbody>
	   
	   </table> 
	   </td> 
	   </tr></tbody>
	   </table> 
	   </td> </tr>
	   <tr> 
	   <td bgcolor="ffffff"> 
	   <table border="0" cellspacing="0">  <tbody><tr><td align="left" valign="top" width="390"> 
	   <table border="0" cellspacing="1"> <tbody>
	   <tr><td align="left" bgcolor="f4f4f4"><font face="verdana" size="2">Sold to: &nbsp;' . $acc_details->account_name . '</font></td></tr>
<tr><td align="left" bgcolor="ffffff"><font face="verdana" size="2"><b>' . $acc_details->account_company . '</b></font></td></tr>
<tr><td align="left" bgcolor="ffffff"><font face="verdana" size="2"><b>' . $acc_details->account_address . '</b></font></td></tr>
<tr><td align="left" bgcolor="ffffff"><font face="verdana" size="2"><b>' . $acc_details->city . '</b></font></td></tr>
<tr><td align="left" bgcolor="ffffff"><font face="verdana" size="2"><b>' . $acc_details->pcode . '</b></font></td></tr>
      </tbody></table> 
	  </td> </tr></tbody>
	  </table> </td> </tr></tbody></table>
	  </td></tr>  
	  
	  
	  <tr> <td> 
	  
		<table border="0">
		<tbody>
	  <tr>
	  ';

    if ($option_reference == 'Y') {
        echo '<td valign="bottom" align="center" width="67.5" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>' . $lang[647] . '</b></font></td>';
    }

    echo '<td valign="bottom" align="center" width="67.5" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>' . $lang[535] . '</b></font></td>';

    echo '<td valign="bottom" align="center" width="295" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>' . $lang[59] . '</b></font></td>';

    echo '<td valign="bottom" align="center" width="45" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>&nbsp;&nbsp;' . $lang[379] . ' </b></font></td>';

    if ($option_fs_on_lines == "Y") {
        echo '<td valign="bottom" align="center" width="60" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>' . $lang[769] . '</b></font></td>';
    }

    echo '<td valign="bottom" align="center" width="45" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>&nbsp;' . $lang[770] . '&nbsp;</b></font></td>';

    if ($option_tax_on_lines == "Y") {
        echo ' <td valign="bottom" align="center" width="45" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>&nbsp;&nbsp;&nbsp;' . $lang[771] . '&nbsp;&nbsp;</b></font></td>';
    }


    echo '<td valign="bottom" align="center" width="45" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>&nbsp;&nbsp;' . $lang[376] . ' </b></font></td>';

    echo '</tr>
 </tbody>
 </table> </td> 
			</tr>   
 
 <tr>   
 
 <td bgcolor="ffffff"> <table border="0"><tbody><tr><td width="67.5" valign="top" bgcolor="ffffff"><font color="black" size="2" face="verdana">    </font></td>
 
 <td width="67.5" valign="top" bgcolor="ffffff"><font color="black" size="2" face="verdana">  ' . $lang[772] . '  </font></td>
 
 <td width="295" valign="top" bgcolor="ffffff"><font color="black" size="2" face="verdana">  ' . $lang[773] . ': ' . substr($inv_details->billingpd, 0, 10) . ' - ' . substr($inv_details->billingpd, 10, 10) . '  </font></td>
 
 <td width="45" valign="top" bgcolor="ffffff" align="right"><font color="black" size="2" face="verdana">    </font></td>
 
 </tr>
 </tbody>
 </table> 
 </td> 
 </tr>';
    //print_r($inv_lines);
    for ($l = 0; $l < count($inv_lines); $l++) {
        echo ' 
 <tr><td>
 <table>
  ';

        if ($option_fs_on_lines == "Y") {
            $line[4] = sprintf("%01.2f", $xfs);
            $line[5] = sprintf("%01.2f", $xamount + $xfs);
            $rowamount = sprintf("%01.2f", $inv_lines[$l]['amount'] + $inv_lines[$l]['fsamount']);
        }
        //show Taxes
        if ($option_tax_on_lines == "Y") {
            $line[3] = sprintf("%01.2f", $xamount + $xfs);
            $line[4] = sprintf("%01.2f", $xtax);
            $line[5] = sprintf("%01.2f", $xamount + $xfs + $xtax);
        }
        //show both, f.s. & taxes
        if (($option_fs_on_lines == "Y") and ($option_tax_on_lines == "Y")) {
            $line[3] = sprintf("%01.2f", $xamount);
            $line[4] = sprintf("%01.2f", $xfs);
            $line[5] = sprintf("%01.2f", $xsubtot);
            $line[6] = sprintf("%01.2f", $xtax);
            $line[7] = sprintf("%01.2f", $xamount + $xfs + $xtax);
        }

        if ($option_reference == 'Y') {
            echo '
 <td width="67.5" valign="top" bgcolor="ffffff"><font color="black" size="' . $option_line_fontsize . '" face="verdana"> ' . $inv_lines[$l]['waybill_ref'] . '     </font></td>';
        }

        echo '
 <td width="67.5" valign="top" bgcolor="ffffff"><font color="black" size="' . $option_line_fontsize . '" face="verdana">  ' . $inv_lines[$l]['form-group'] . '     </font></td>
 <td width="295" valign="top" bgcolor="ffffff"><font color="black" size="' . $option_line_fontsize . '" face="verdana">  ' . $inv_lines[$l]['delivery_date'] . '   <br>' . $lang[34] . ':' . $inv_lines[$l]['from_address'] . '    <br>' . $lang[35] . ':' . $inv_lines[$l]['to_address'] . '</font></td>
 <td width="45" valign="top" bgcolor="ffffff" align="right"><font color="black" size="' . $option_line_fontsize . '" face="verdana">  ' . $inv_lines[$l]['amount'] . '     </font></td>
 ';
        if ($option_fs_on_lines == "Y") {
            echo '<td width="60" valign="top" bgcolor="ffffff" align="right"><font color="black" size="' . $option_line_fontsize . '" face="verdana"> ' . $inv_lines[$l]['fsamount'] . '     </font></td>';

        }
        echo '<td width="45" valign="top" bgcolor="ffffff" align="right"><font color="black" size="' . $option_line_fontsize . '" face="verdana">  ' . ($inv_lines[$l]['amount'] + $inv_lines[$l]['fsamount']) . '</font></td>';

        if ($option_tax_on_lines == "Y") {
            echo '<td width="45" valign="top" bgcolor="ffffff" align="right"><font color="black" size="' . $option_line_fontsize . '" face="verdana">  ' . ($inv_lines[$l]['tax1amount'] + $inv_lines[$l]['tax2amount']) . '     </font></td>';
        }

        echo '<td width="45" valign="top" bgcolor="ffffff" align="right"><font color="black" size="' . $option_line_fontsize . '" face="verdana">  ' . ($inv_lines[$l]['amount'] + $inv_lines[$l]['fsamount'] + $inv_lines[$l]['tax1amount'] + $inv_lines[$l]['tax2amount']) . '</font></td>

</table>
</td>
 </tr>
';

        if (preg_match('/^[1-9]+$/', ($l / $maxlines))) {
            echo ' </td> 
 </tr>
 
 </tbody>
 </table>
 </td>
 </tr>
  </tbody>
 </table>
 <h6 style="page-break-after:always"></h6>
 
 <table border="2" cellspacing="0" width="670">
 <tbody>
 <tr> <td> 
 		<table border="0">      
 		
 		<tbody>
 		
 		<tr>
 		
 		<td width="210"> 
 		
 		<table border="0"> 
 		<tbody><tr><td align="left" bgcolor="f4f4f4"><font face="verdana" size="2">Sold to: &nbsp;' . $acc_details->account_name . '</font></td></tr>

 		<tr><td><font face="verdana" size="2">' . $acc_details->account_company . '</font></td></tr>
      </tbody></table> </td> <td valign="center" width="180"> <table border="0"> <tbody><tr><td align="left" colspan="2" bgcolor="ffffff"><font face="verdana" size="2">' . $acc_details->account_company . '</font></td></tr>
<tr><td><font face="verdana" size="2">' . $lang[390] . '</font></td><td><font face="verdana" size="2">' . (($l / $maxlines) + 1) . '</font></td></tr>
 </tbody></table>                          </td><td align="right" valign="top" width=""> <table border="0"> <tbody><tr><td valign="bottom" align="center" width="190" colspan="2" bgcolor="444444"><font color="white" size="3" face="tahoma"><b> ' . $lang[768] . ' </b></font></td></tr>
<tr><td align="left" bgcolor="f4f4f4"><font face="verdana" size="2">' . $lang[532] . '</font></td><td align="right" bgcolor="ffffff"><font face="verdana" size="2">' . $inv_details->id . '</font></td></tr>
       </tbody></table> </td> </tr></tbody></table> </td> </tr>
	   
	   
	   
	  <tr> <td> 
	  <table border="0"><tbody>
	  <tr>
	  
	  <td valign="bottom" align="center" width="67.5" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>' . $lang[647] . '</b></font></td>
	  
	  <td valign="bottom" align="center" width="67.5" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>' . $lang[535] . '</b></font></td>
	  
	  <td valign="bottom" align="center" width="295" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>' . $lang[59] . '</b></font></td>
	  
	  <td valign="bottom" align="center" width="45" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>&nbsp;&nbsp;' . $lang[379] . ' </b></font></td>
	  
	  <td valign="bottom" align="center" width="60" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>' . $lang[769] . '</b></font></td>
	  
	  <td valign="bottom" align="center" width="45" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>&nbsp;' . $lang[770] . '&nbsp;</b></font></td>';

            echo '<td valign="bottom" align="center" width="45" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>&nbsp;&nbsp;&nbsp;' . $lang[771] . '&nbsp;&nbsp;</b></font></td>';

            echo '<td valign="bottom" align="center" width="45" bgcolor="eeeeee"><font color="black" size="' . $option_line_fontsize . '" face="tahoma"><b>&nbsp;&nbsp;' . $lang[376] . ' </b></font></td>
	  
	  </tr>
 </tbody>
 </table> </td> </tr> 
 
 
 
 
	   

 ';
        }

    }
    echo '
 </td> 
 </tr>
 <!-- mesage part -->
 <tr>
 <td align="center" bgcolor="f4f4f4">' . $inv_details->message . '</td>
 </tr>
 
 <!-- totla part -->
 <td  align=right valign=bottom width=$trwidth> 
 <table >';

    //* Format data in totals section
    $subtotal_fmt = sprintf("%01.2f", $inv_details->subtotal);
    $fsamount_fmt = sprintf("%01.2f", $inv_details->fsamount);
    $tax1amount_fmt = sprintf("%01.2f", $inv_details->tax1amount);
    $tax2amount_fmt = sprintf("%01.2f", $inv_details->tax2amount);
    $tax3amount_fmt = sprintf("%01.2f", $inv_details->tax3amount);
    $tax4amount_fmt = sprintf("%01.2f", $inv_details->tax4amount);
    $tax5amount_fmt = sprintf("%01.2f", $inv_details->tax5amount);
    $total_fmt = sprintf("%01.2f", $total);
    if ($inv_details->ppd_amount == 0)
        $ppd_amount_fmt = null;
    else
        $ppd_amount_fmt = sprintf("%01.2f", $inv_details->ppd_amount);
    $inv_balance_fmt = sprintf("%01.2f", $inv_balance);


    $inputfmnd_prt = array("align=left   bgcolor=f4f4f4", "align=right bgcolor=ffffff", "align=right bgcolor=ffffff");
    showrow(array($lang[543] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       &nbsp;&nbsp;&nbsp;", "&nbsp;&nbsp;",
        $subtotal_fmt), $inputfmnd_prt);

    if ($inv_details->fsamount != 0)
        showrow(array($lang[544] . "", "", $fsamount_fmt), $inputfmnd_prt);

    if ($inv_details->tax1amount != 0)
        showrow(array($inv_details->tax1type, "", $tax1amount_fmt), $inputfmnd_prt);

    if ($inv_details->tax2amount != 0)
        showrow(array($inv_details->tax2type, "", $tax2amount_fmt), $inputfmnd_prt);

    if ($inv_details->tax3amount != 0)
        showrow(array($inv_details->tax3type, "", $tax3amount_fmt), $inputfmnd_prt);

    if ($inv_details->tax4amount != 0)
        showrow(array($inv_details->tax4type, "", $tax4amount_fmt), $inputfmnd_prt);

    if ($inv_details->tax5amount != 0)
        showrow(array($inv_details->tax5type, "", $tax5amount_fmt), $inputfmnd_prt);

    $ttl = $lang[376];                                    //$option_stmt = "n";
    $ppd = $lang[774];
    $due = $lang[535];

    if ($option_stmt == "Y") {
        $ttl = $lang[775];
        $ppd = $lang[545];
        $due = $lang[776];
    }
    showrow(array($ttl, "", $total_fmt), $inputfmnd_prt);
    if ($inv_details->ppd_amount != 0) {
        showrow(array($ppd, "", $ppd_amount_fmt), $inputfmnd_prt);
        showrow(array($due, "", $inv_balance_fmt), $inputfmnd_prt);
    }

//*The Statement Info.   ...(don't include "un-processed" invoices - they don't count just yet).
//*** THE SCHEME FOR BUILING AN ACCURATE PREVIOUS BALANCE WITHOUT RECORDING IT ***
//the rules:
//1. ALL Open invoices, regardless of date. Except This ONE!
//2. ALL payments to THOSE invoices, but NONE from TODAY.
//Payments: the Rules:
//1. ALL payments since(incl of) the date of the last invoice, up to yesterday.
//same theory. Any payments received today -DIDN'T HAPPEN.
//  this allows the case of the possibility of >1 invoice today even if ther were payments today
//  to accurately show payments since the last invoice/stmt without trying to sequence the events
//  of today with multiple invoices and payments posted.
//When the next invoice is produced, it will include the payments ON THE SAME DAY as this
//  previous inv/stmt, therefore none will be missed.
//  and the closing<->opening balances should link.
    if ($option_stmt == "Y") {

        /*

         showrow(array("Invoice no                ","",$invoiceno             ),$inputfmd);
         showrow(array("Last Invoice no           ","",$last_invoiceno        ),$inputfmd);
         showrow(array("Last Invoice total        ","",$lastinv_total         ),$inputfmd);
         showrow(array("no of openinvoice recs
                             before lastinvoice   ","",$coi                   ),$inputfmd);
         showrow(array("no of Credit  invoice recs
                             after  lastinvoice   ","",$ccr                   ),$inputfmd);
         showrow(array("oi tally                  ","",$oi_tally              ),$inputfmd);
         showrow(array("oi pymts                  ","",$oi_pymts              ),$inputfmd);
         showrow(array("paid to paidinv since lastinv ","",$paid_to_paidinv_since_lastinv),$inputfmd);
         showrow(array("current pymts             ","",$curr_pymts            ),$inputfmd);
         showrow(array("last invoice date         ","",$last_invoice_date     ),$inputfmd);
         showrow(array("stmt date                 ","",$stmt_date             ),$inputfmd);

         */


        showrow(array($lang[777] . " ", "", $prev_bal_fmt), $inputfmnd_prt);
        showrow(array($lang[778], "", $pymts_curr_fmt), $inputfmnd_prt);
        if ($curr_credits != 0)
            showrow(array($lang[779] . "         ", "", $credits_fmt), $inputfmnd_prt);

//++++++++++++++++ TEMP ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// if ($deposits != 0)
//  showrow(array("Deposits        ","",$deposits_fmt),   $inputfmnd_prt);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


        showrow(array($lang[780] . "       ", "", $amt_due_fmt), $inputfmnd_prt);
    }


    echo '
 </table>
 </td>
 
 </tbody>
 
 </table>
 
 </tbody>
 
 </table>



<div class="hideprint" style="width:600;">
 <center>
 <form><input type="hidden" name="invoiceno" value="1088">
<input type="button" value="&nbsp;&nbsp;' . $lang[603] . '&nbsp;&nbsp;" onclick="print()" style="font-weight:bold;
               font-size:14;
               color:white;
               font-family:Comic Sans Ms;
               background:#A0A0A0">
       &nbsp;&nbsp;&nbsp;&nbsp;
         <input type="button" value="&nbsp;&nbsp;' . $lang[767] . '&nbsp;&nbsp;" onclick="top.window.close()" style="font-weight:bold;
                 font-size:14;
                 color:white;
                 font-family:Comic Sans Ms;
                 background:#A0A0A0"> <br><br>
 </form>
 </center>
 </div>
         		</div>
 
 
';
}

function template_search_invoice()
{
    global $lang;
    echo '

<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/client.js"></script>

<form id="invoice_search" method="post" action="' . SITEURL . '/client/client_admin.php?action=search_invoice"  class="form-horizontal" role="form">

<input type="hidden" name="client" value="' . $_SESSION['account_id'] . '" />
<div class="col " style="width:70%; ;"  >
<h4 class="header green" >' . $lang[73] . '</h4>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[74] . '</label>
<div class="col-sm-9"><input type="text" name="invoice_no" value=""/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[56] . '</label>
<div class="col-sm-9"><input type="text" name="invoice_date_form" id="invoice_date_form" value=""/></div>
<script type="text/javascript">
			var date = new Date();
       date.setMonth(date.getMonth() - 1);
						
$(\'#invoice_date_form\').datepicker({
		format: \'yyyy-mm-dd\',
		   autoclose: true
});
						
						
				$("#invoice_date_form").datepicker(\'setDate\', date);
		

		
</script>

</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[57] . '</label>
<div class="col-sm-9"><input type="text" name="invoice_date_to" id="invoice_date_to" value=""/></div>
<script type="text/javascript">
$(\'#invoice_date_to\').datepicker({
			format: \'yyyy-mm-dd\',
		   autoclose: true
});
		$("#invoice_date_to").datepicker(\'setDate\', new Date());
		
</script>
</div>


<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
<input type="button" onclick="search_invoice();" value="' . $lang[26] . '"  name="edituser"  class="btn btn-info"/>
</div>
</div>
		
</div>
<div id="result" align="center" style="width:800px; padding:10px; margin:auto 10px;"></div>

</form>


';
}

function template_edit_user()
{
    global $lang, $user_data;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/client.js"></script>

<form id="user_setting" method="post" action="' . SITEURL . '/client/index.php?action=edit_my_setting" class="form-horizontal" role="form">
<input type="hidden" name="account_id" value="' . $user_data->account_id . '" />

<div class="col"  style="width:100%" >
<h4 class="header green" >' . $lang[92] . '</h4>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[17] . '</label>
<div class="col-sm-9"><input type="text" name="account_name" value="' . $user_data->account_name . '" disabled="disabled"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[18] . '</label>
<div class="col-sm-9"><input type="text" name="user_name" value="' . $user_data->user_name . '" disabled="disabled"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[36] . '</label>
<div class="col-sm-9"><input type="text" name="name" value="' . $user_data->name . '"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[19] . '</label>
<div class="col-sm-9"><input type="password" name="user_pass" value=""/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[167] . '</label>
<div class="col-sm-9"><input type="password" name="confirm_password" value=""/></div>
</div>
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="phone" value="' . $user_data->phone . '"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[12] . '</label>
<div class="col-sm-9"><input type="text" name="fax" value="' . $user_data->fax . '"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . '</label>
<div class="col-sm-9"><input type="text" name="email" value="' . $user_data->email . '"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><textarea name="address" >' . $user_data->address . '</textarea></div>
</div>

		<div style="clear:both;"></div>
<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
<input type="button" onclick="edit_my_setting();" value="' . $lang[50] . '"  name="edituser"  class="btn btn-info"/>
</div>
</div>

</div>
</form>
<div id="result"></div>
';
}


function template_edit_user_admin()
{
    global $lang, $user_data, $userid;
    echo '
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/client.js"></script>


<form id="edit_client_user_' . $user_data->user_id . '" name="edit_client_user_' . $user_data->user_id . '" method="post" action="' . SITEURL . '/client/client_admin.php?action=edituser&userid=' . $user_data->user_id . '" class="form-horizontal" role="form">
<input type="hidden" name="account_id" value="' . $user_data->account_id . '"  />
<input type="hidden" name="user_id" value="' . $user_data->user_id . '"  />



<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[17] . '</label>
<div class="col-sm-9"><input type="text" name="account_name" value="' . $user_data->account_name . '" disabled="disabled" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[18] . '</label>
<div class="col-sm-9"><input type="text" name="user_name" value="' . $user_data->user_name . '" disabled="disabled" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[101] . '</label>
<div class="col-sm-9">
<select name="user_type" validate="notempty">
<option value="">' . $lang[756] . '</option>
<option value="client" ' . ($user_data->user_type == "client" ? 'selected' : '') . ' >' . $lang[693] . '</option>
<option value="administrator" ' . ($user_data->user_type == "administrator" ? 'selected' : '') . ' >' . $lang[164] . '</option>

</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[36] . '</label>
<div class="col-sm-9"><input type="text" name="name" value="' . $user_data->name . '" size="50" validate="notempty"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[19] . '</label>
<div class="col-sm-9"><input type="password" name="user_pass" value="" size="50"/></div>
</div>
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[167] . '</label>
<div class="col-sm-9"><input type="password" name="confirm_password" value="" size="50"/></div>
</div>
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="phone" value="' . $user_data->phone . '" size="50" validate="notempty" validate_type="phone" /></div>
</div>

		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[12] . '</label>
<div class="col-sm-9"><input type="text" name="fax" value="' . $user_data->fax . '" size="50"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . '</label>
<div class="col-sm-9"><input type="text" name="email" value="' . $user_data->email . '" size="50" validate="notempty" validate_type="email" /></div>
</div>



<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
<input type="button"  class="btn btn-info" value="' . $lang[50] . '"  name="edituser" onclick="add_form_php(\'edit_client_user_' . $user_data->user_id . '\',\'1\');"/>
	<input type="button" onclick="close_my_tab(\'tabs_man\',\'0\');" id="close" class="btn btn-danger" value="' . $lang[200] . '"  name="edituser"/>
</div>
</div>


</form>

		
';
}

function template_add_user()
{
    global $lang, $user_data, $userid;
    echo '

<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/client.js"></script>

<form name="add_user" id="add_user" method="post" action="' . SITEURL . '/client/client_admin.php?action=adduser" class="form-horizontal" role="form" autocomplete="off">
<input type="hidden" name="status" value="1" />

<div class="col " style="width:30%; "  >

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[17] . '</label>
<div class="col-sm-9"><input type="text" name="account_name" value="' . $user_data->account_name . '" disabled="disabled"/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[101] . '</label>
<div class="col-sm-9">
<select name="user_type">
<option value="">' . $lang[756] . '</option>
<option value="client">' . $lang[693] . '</option>
<option value="administrator">' . $lang[164] . '</option>
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[18] . '</label>
<div class="col-sm-9"><input type="text" name="user_name" value="" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[36] . '</label>
<div class="col-sm-9"><input type="text" name="name" value=""/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[19] . '</label>
<div class="col-sm-9"><input type="password" name="user_pass" value=""/></div>
</div>

		<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[167] . '</label>
<div class="col-sm-9"><input type="password" name="confirm_password" value=""/></div>
</div>
		
		</div>
		<div class="col" style="width:30%;" >
		
<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[11] . '</label>
<div class="col-sm-9"><input type="text" name="phone" value=""/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[12] . '</label>
<div class="col-sm-9"><input type="text" name="fax" value=""/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[13] . '</label>
<div class="col-sm-9"><input type="text" name="email" value=""/></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[7] . '</label>
<div class="col-sm-9"><textarea name="address" ></textarea></div>
</div>

</div>
		
<div style="clear:both;"></div>

<div class="clearfix form-actions"  >
<div class="col-md-offset-3 col-md-9">
<input type="button" value="' . $lang[50] . '" onclick="add_users();" name="adduser" class="btn btn-info" />
</div>
</div>

</form>
<div id="result"></div>
<div style="clear:both;"></div>
';
}

?>