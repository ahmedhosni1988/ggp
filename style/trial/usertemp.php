<?php

function template_user_main()
{
    global $data, $lang;
    echo '
              <script>
              $(document).ready(function() {
                $("#tabs_man").tabs();
                
            
            
              });
              </script>
              
            <div id="right_side">
            <div id="tabs_man" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            <ul>
               <li><a href="users.php?action=show" >' . $lang[110] . '</a></li>
               <li><a href="users.php?action=add" >' . $lang[98] . '</a></li>
            </ul>
            
            <div id="ui-tabs-0" >
               ';
    if (is_array($data)) {
        //print_r($data);
        echo '<table border="1" class="table table-striped table-bordered table-hover" >';
        $x = $data[0];
        foreach ($x as $val) {
            echo '<th>' . key($val) . '</th>';
        }
        echo '<th style="width:30px;">' . $lang[312] . '</th>';
        echo '<th style="width:45px;">' . $lang[259] . '</th>';

        for ($i = 0; $i < count($data); $i++) {
            echo '<tr>';
            $x = $data[$i];

            foreach ($x as $val) {
                $tex = $val[key($val)];

                $tex = str_replace(",", "<br>", $tex);

                echo '<td>' . $tex . '</td>';
            }

            echo '<td><a onclick="show_edit_user(\'' . $data[$i][0]['ID'] . '\');" href="#" >' . $lang[312] . '</a></td>';
            echo '<td><a onclick="return confirm(\'' . $lang[796] . '\');" href="' . SITEURL . '/administrator/admin_index.php?action=deletecat&cat_id=' . $data[$i][0]['ID'] . '" >' . $lang[259] . '</a></td>';

            echo '</tr>';
        }
        echo '</table>';
    }
    echo '
            
            </div>
            
            <div id="ui-tabs-1" >
            
            </div>
            </div>
            
            
            </div>
            <div id="result"></div>
            ';
}

function show_user_option($ro)
{
    global $lang;

    for ($i = 0; $i < count($ro); $i++) {
        foreach ($ro[$i] as $key => $value) {
            $rou[$key] = $value;
        }
    }

    $x .= '<a onclick="show_edit_user(\'' . $rou['user_id'] . '\',\'' . $rou['user_name'] . '\');" href="#" >' . $lang[312] . '</a> - ';
    //$x .= '<a onclick="delete_user(\''.$rou['user_id'].'\');"  >'.$lang[259].'</a> ';

    return $x;
}

function template_show_user()
{
    global $data, $lang, $html_grid,$url;
    //var_dump($data[1]);
    echo $html_grid;
}


function template_user_edit()
{
    global $lang, $user_data;
    echo '
            <form name="edit_user_' . $user_data->user_id . '" id="edit_user_' . $user_data->user_id . '" method="post" action="' . SITEURL . '/administrator/users.php?action=edituser" class="form-horizontal" role="form" autocomplete="off" >
            <input type="hidden" name="user_id" value="' . $user_data->user_id . '" />
                    <div class="row">
            <div class="col" style="width:40%;">
            <div class="form-group">
            <label class="col-sm-3 control-label">اسم الدخول</label>
            <div class="col-sm-9"><input type="text" name="user_name" value="' . $user_data->user_name . '" disabled="disabled" size="50"/></div>
            </div>
            
            <div class="form-group">
            <label class="col-sm-3 control-label">' . $lang[101] . '</label>
            
            <div class="col-sm-9">
            <select name="user_type" >
            
            
            <option value="">' . $lang[756] . '</option>
            <option value="5" ' . ($user_data->user_type == '5' ? 'selected' : '') . '>توريد</option>
            <option value="4" ' . ($user_data->user_type == '4' ? 'selected' : '') . '>فرن</option>
            <option value="3" ' . ($user_data->user_type == '3' ? 'selected' : '') . '>شطف </option>
            <option value="7" ' . ($user_data->user_type == '7' ? 'selected' : '') . '>تشطيب </option>
            <option value="2" ' . ($user_data->user_type == '2' ? 'selected' : '') . '>تقطيع</option>
            <option value="manger" ' . ($user_data->user_type == 'manger' ? 'selected' : '') . '>متابعة</option>
            <option value="accounting" ' . ($user_data->user_type == 'accounting' ? 'selected' : '') . '>محاسب</option>
            <option value="addmanger" ' . ($user_data->user_type == 'addmanger' ? 'selected' : '') . '>اضافة انتاج</option>
            <option value="manmanger" ' . ($user_data->user_type == 'manmanger' ? 'selected' : '') . '>مدير انتاج</option>
            <option value="administrator" ' . ($user_data->user_type == 'administrator' ? 'selected' : '') . '>مدير نظام</option>
            <option value="smallaccounting" ' . ($user_data->user_type == 'smallaccounting' ? 'selected' : '') . ' >محاسب فرع</option>

            </select>
            
            </div>
            </div>';

    if ($user_data->user_type == '3') {
        echo '
            <div class="form-group">
            <label class="col-sm-3 control-label">صور فقط</label>
            <div class="col-sm-9">
            <input type="hidden" name="user_action" value="0" />
            <input type="checkbox" name="user_action" value="1" ' . ($user_data->user_action == "1" ? 'checked' : '') . ' /></div>
            </div>
            ';
    }


    if ($user_data->user_type == '4') {
        echo '
                <div class="form-group">
                <label class="col-sm-3 control-label">داخل فرن</label>
                <div class="col-sm-9">
            
                <input type="radio" name="user_action" value="1" ' . ($user_data->user_action == "1" ? 'checked' : '') . ' />
                </div>
            
                </div>
            
                <div class="form-group">
                <label class="col-sm-3 control-label">خارج فرن</label>
                <div class="col-sm-9">
            
                <input type="radio" name="user_action" value="2" ' . ($user_data->user_action == "2" ? 'checked' : '') . ' />
                </div>
            
                </div>
            
            
                ';
    }

    if ($user_data->user_type == '7') {
        echo '
                <div class="form-group">
                <label class="col-sm-3 control-label">اخرام</label>
                <div class="col-sm-9">
                <input type="radio" name="user_action" value="1" ' . ($user_data->user_action == "1" ? 'checked' : '') . ' />
                </div>
                </div>
            
                <div class="form-group">
                <label class="col-sm-3 control-label">اخلاع</label>
                <div class="col-sm-9">
                <input type="radio" name="user_action" value="2" ' . ($user_data->user_action == "2" ? 'checked' : '') . ' />
                </div>
            
                </div>
                ';
    }


    echo '<div class="form-group">
            <label class="col-sm-3 control-label">' . $lang[36] . '</label>
            <div class="col-sm-9"><input type="text" name="name" value="' . $user_data->name . '" size="50"/></div>
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
            <div class="col-sm-9"><input type="text" name="phone" value="' . $user_data->phone . '" size="50"/></div>
            </div>
            
            <div class="form-group">
            <label class="col-sm-3 control-label">الفرع</label>
            <div class="col-sm-9">
            <select name="billing_code">
            <option value="0">اختار الفرع</option>
            ';
    global $billing_codes;
    for ($i=0;$i<count($billing_codes);$i++) {
        echo '<option value="'.$billing_codes[$i]['id'].'" '.($billing_codes[$i]['id'] == $user_data->billing_code ? 'selected' : '').'>'.$billing_codes[$i]['billingcode_name'].'</option>';
    }
    echo '
      </select>
      </div>
            </div>
    
            <div class="form-group">
            <label class="col-sm-3 control-label">انترنت</label>
            <div class="col-sm-9">
            <input type="hidden" name="allow_internet" value="0"/>
            <input type="checkbox" name="allow_internet" value="1" '.("1"== $user_data->allow_internet ? 'checked' : '').' /></div>
            </div>
            
            </div>
            
            
            
            
                    
            
            
            
            
                    
            
            
                    </div>
                    
            <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
            <input type="button"  class="btn btn-info" value="' . $lang[50] . '"  name="edituser" onclick="add_form_php(\'edit_user_' . $user_data->user_id . '\',\'1\');"/>
            <input type="button" onclick="close_my_tab(\'tabs_man\',\'0\');" id="close" class="btn btn-danger" value="' . $lang[200] . '"  name="edituser"/>
                    </div>
            </div>
            
            
            </form>
            
            ';
}

function template_add_admin_user()
{
    global $lang;
    echo '
        
        <form name="add_user" id="add_user"  method="post" action="' . SITEURL . '/administrator/users.php?action=add" class="form-horizontal" role="form" autocomplete="off">
        
        <input type="hidden" name="account_id" value="0" />
                <input type="hidden" name="status" value="2" />
                
        <div class="col" style="width:40%;">
        <div class="form-group">
        <label class="col-sm-3 control-label">' . $lang[101] . '</label>
        
        <div class="col-sm-9">
        <select name="user_type" >
        <option value="">' . $lang[756] . '</option>
        <option value="5">توريد</option>
        <option value="4">فرن</option>
        <option value="3">شطف </option>
        <option value="7">تشطيب </option>
        <option value="2">تقطيع</option>
        <option value="manger">متابعة</option>
        <option value="accounting" >محاسب</option>
        <option value="addmanger" >اضافة انتاج</option>
        <option value="manmanger" >مدير انتاج</option>
        <option value="administrator">مدير نظام</option>
        <option value="smallaccounting">محاسب فرع</option>
        </select>
        
        </div>
        </div>
        
        
        <div class="form-group">
        <label class="col-sm-3 control-label">' . $lang[18] . '</label>
        <div class="col-sm-9"><input type="text" name="user_name" value="" size="50" /></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label">' . $lang[36] . '</label>
        <div class="col-sm-9"><input type="text" name="name" value="" size="50"/></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label">' . $lang[19] . '</label>
        <div class="col-sm-9"><input type="password" name="user_pass" id="user_pass" value="" size="50"/></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label">' . $lang[167] . '</label>
        <div class="col-sm-9"><input type="password" name="confirm_password" id="user_pass_confirm" value="" size="50"/></div>
        </div>
        
        
        
        <div class="form-group">
        <label class="col-sm-3 control-label">' . $lang[11] . '</label>
        <div class="col-sm-9"><input type="text" name="phone" value="" size="50"/></div>
        </div>
            
        <div class="form-group">
        <label class="col-sm-3 control-label">الفرع</label>
        <div class="col-sm-9">
        <select name="billing_code">
        <option value="0">اختار الفرع</option>
        ';
    global $billing_codes;
    for ($i=0;$i<count($billing_codes);$i++) {
        echo '<option value="'.$billing_codes[$i]['id'].'">'.$billing_codes[$i]['billingcode_name'].'</option>';
    }
    echo '
  </select>
  </div>
        </div>

        <div class="form-group">
        <label class="col-sm-3 control-label">انترنت</label>
        <div class="col-sm-9">
        <input type="hidden" name="allow_internet" value="0"/>
        <input type="checkbox" name="allow_internet" value="1"/></div>
        </div>
        
        <div class="form-group">
        <div class="col-sm-9"><input type="button" id="submit" onclick="add_form_php(\'add_user\',\'1\');" class="btn btn-info" value="' . $lang[50] . '"  name="addusers"/></div>
        </div>
        
        </div>
        
        </form>
        <div style="clear:both;"></div>
        ';
}


function template_admin_edit_user()
{
    global $lang, $user_data;
    echo '
        <div id="row">
        
                <div class="col-xs-12 col-sm-6 widget-container-col ui-sortable">
        
                <div class="widget-box widget-color-blue ui-sortable-handle">
                <div class="widget-header">
                <div class="widget-title">' . $lang[92] . '</div>
                </div>
        
                <div class="widget-body">
                <div class="widget-main">
        
        <form id="edit_admin" name="edit_admin" method="post" action="index.php?action=edit_my_setting" class="form-horizontal" role="form">
        
        
        ';
    if ($_SESSION['status'] == 1) {
        echo '
                <div class="form-group">
        <label class="col-sm-3 control-label">' . $lang[17] . '</label>
        <div class="col-sm-9"><input type="text" name="account_name" value="' . $user_data->account_name . '" disabled="disabled"/></div>
        </div>';
    }
    //var_dump($user_data);
    echo '<div class="form-group">
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
        
        <div class="form-group">
        <label class="col-sm-3 control-label">الفرع</label>
        <div class="col-sm-9">
        <select name="billing_code">
        <option value="0">اختار الفرع</option>
        ';
    global $billing_codes;
    for ($i=0;$i<count($billing_codes);$i++) {
        echo '<option value="'.$billing_codes[$i]['id'].'" '.($billing_codes[$i]['id'] == $user_data->billing_code ? 'selected' : '').'>'.$billing_codes[$i]['billingcode_name'].'</option>';
    }
    echo '
  </select>
  </div>
        </div>

        <div class="form-group">
        <label class="col-sm-3 control-label">انترنت</label>
        <div class="col-sm-9">
        <input type="hidden" name="allow_internet" value="0"/>
        <input type="checkbox" name="allow_internet" value="1" '.("1"== $user_data->allow_internet ? 'checked' : '').' /></div>
        </div>

        <div class="form-group" style="text-align:center;">
        <input type="button" value="' . $lang[50] . '"  name="edituser" onclick="add_form_php(\'edit_admin\',\'1\');" class="btn btn-info"/>
        </div>
        
        
        
        </form>
                </div>
                </div>
                </div>
                </div>
        </div>
        ';
}
