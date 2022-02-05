<?php


function template_invenotry_main()
{
    global $lang, $c_setting;
    echo '
      <script type="text/javascript">

      $(document).ready(function() {
        $("#tabs").tabs();
          var $tabs = $("#tabs").tabs({});
        });

      </script>
      

    <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
    
    <ul>
      <li><a href="inventory.php?action=inventory" >' . $lang[983] . '</a></li>
      <li><a href="inventory.php?action=purchase" >' . $lang[984] . '</a></li>
      <li><a href="inventory.php?action=items" >' . $lang[985] . '</a></li>
      
   </ul>
    
    <div id="tabs-0"  >
    </div>

    <div id="tabs-0"  >
    </div>

    <div id="tabs-0"  >
    </div>
    
    </div>

    
    ';

}


function template_invenotry_data()
{
    global $lang, $c_setting, $invData;
    echo '
    <div style="overflow-x: auto">
<table style="width:auto;" class="table table-striped table-bordered table-hover">
<thead>
<tr>
<td>' . $lang[994] . '</td>
<td>' . $lang[995] . '</td>
<td>' . $lang[996] . '</td>
<td>' . $lang[997] . '</td>
</tr>
</thead>
<tbody>';
    if (is_array($invData) && count($invData) > 0) {
        for ($i = 0; $i < count($invData); $i++) {
            echo '
<tr>
<td>' . $invData[$i]['id'] . '</td>
<td>' . $invData[$i]['item_name'] . '</td>
<td>' . $invData[$i]['quantity'] . '</td>
<td>' . date($c_setting['date_time_format'], strtotime($invData[$i]['last_update'])) . '</td>
</tr>
';
        }
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }
    echo '</tbody>
</table>
</div>
';

}


function template_item_data()
{
    global $lang, $c_setting, $invData;

    echo '
    <div style="overflow-x: auto">
    <table style="width:auto;" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
    <td>' . $lang[994] . '</td>
    <td>' . $lang[995] . '</td>
    <td>' . $lang[989] . '</td>
    <td>' . $lang[991] . '</td>
    <td>' . $lang[990] . '</td>
    <td>' . $lang[1006] . '</td>
    </tr>
    </thead>
    <tbody>';
    if (is_array($invData) && count($invData) > 0) {
        for ($i = 0; $i < count($invData); $i++) {
            echo '
    <tr>
    <td>' . $invData[$i]['id'] . '</td>
    <td>' . $invData[$i]['item_name'] . '</td>
    <td>' . $invData[$i]['color_name'] . '</td>
    <td>' . $invData[$i]['company_name'] . '</td>
    <td>' . $invData[$i]['package_name'] . '</td>
    <td>' . $invData[$i]['size'] . '</td>
    </tr>
    ';
        }
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }
    echo '</tbody>
    </table>
    </div>
    ';

}


function template_item_main()
{
    global $lang, $c_setting;

    echo ' <script type="text/javascript">
    
          $(document).ready(function() {
            $("#item").tabs();
              var $tabs = $("#item").tabs({});
            });
    
          </script>
          
    
        <div id="item" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        
        <ul>
          <li><a href="inventory.php?action=get_item" >' . $lang[987] . '</a></li>
          <li><a href="inventory.php?action=add_item" >' . $lang[988] . '</a></li>
          <li><a href="inventory.php?action=color" >' . $lang[989] . '</a></li>
          <li><a href="inventory.php?action=price_pac&what=mange" >' . $lang[990] . '</a></li>
          <li><a href="inventory.php?action=company" >' . $lang[991] . '</a></li>
          <li><a href="inventory.php?action=size" >' . $lang[992] . '</a></li>
          <li><a href="inventory.php?action=suppmain" >' . $lang[993] . '</a></li>
       </ul>
        
        <div id="item-0"  >
        </div>
    
  
        </div>';
}

function template_add_item()
{
    global $lang, $color, $company, $size, $thickness;

    echo '
    <form id="additem_form"  method="post"  action="inventory.php?action=add_item" >
    
            <div class="form-group">
            <label class="col-sm-3 control-label">' . $lang[995] . '</label>
            <div class="col-sm-9"><input type="text" id="item_name_id" name="item_name" value="" ></div>
            </div>

            <div class="form-group">
            <label class="col-sm-3 control-label">' . $lang[989] . '</label>
            <div class="col-sm-9">  
            <select id="item_color_id" name="item_color" onchange="item_name_now()">
            ';
    for ($i = 0; $i < count($color); $i++) {
        echo '<option value="' . $color[$i]['id'] . '" >' . $color[$i]['color_name'] . '</option>';
    }
    echo '
            </select>
            </div>
            </div>

            <div class="form-group">
            <label class="col-sm-3 control-label">' . $lang[991] . '</label>
            <div class="col-sm-9">
            <select id="item_company_id" name="item_company" onchange="item_name_now()">
            ';
    for ($i = 0; $i < count($company); $i++) {
        echo '<option value="' . $company[$i]['id'] . '" >' . $company[$i]['company_name'] . '</option>';
    }
    echo '
            </select></div>
            </div>

            <div class="form-group">
            <label class="col-sm-3 control-label">' . $lang[990] . '</label>
            <div class="col-sm-9">
            <select id="item_thickness_id" name="item_thickness" onchange="item_name_now()">
            ';
    for ($i = 0; $i < count($thickness); $i++) {
        echo '<option value="' . $thickness[$i]['package_id'] . '" >' . $thickness[$i]['package_name'] . '</option>';
    }
    echo '
            </select></div>
            </div>

            <div class="form-group">
            <label class="col-sm-3 control-label">' . $lang[992] . '</label>
            <div class="col-sm-9">
            <select id="item_size_id" name="item_size" onchange="item_name_now()">
            ';
    for ($i = 0; $i < count($size); $i++) {
        echo '<option value="' . $size[$i]['id'] . '" >' . $size[$i]['item_width'] . ' | ' . $size[$i]['item_height'] . '</option>';
    }
    echo '
            </select></div>
            </div>
    
    <hr>
            <div class="wizard-actions">
            <!-- #section:plugins/fuelux.wizard.buttons -->
          
    
            <button type="button" class="btn btn-success btn-next" onclick="add_form_php(\'additem_form\',\'1\')">' . $lang[260] . '</button>
    
            <!-- /section:plugins/fuelux.wizard.buttons -->
        </div>
    
            </form>
            ';
}


function template_invenotry_item_color()
{

    global $lang, $c_setting, $colData;
    echo ' <script type="text/javascript">
    
          $(document).ready(function() {
            $("#item_color").tabs();
              var $tabs = $("#item_color").tabs({});
            });
    
          </script>
          
    
        <div id="item_color" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        
        <ul>
          <li><a href="#item_color-0">' . $lang[989] . '</a></li>
          <li><a href="#item_color-1" >' . $lang[998] . '</a></li>
       </ul>
        
        <div id="item_color-0"  >
        <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
        <td>' . $lang[994] . '</td>
        <td>' . $lang[989] . '</td>
        </tr>
        </thead>
        <tbody>';
    if (is_array($colData) && count($colData) > 0) {
        for ($i = 0; $i < count($colData); $i++) {
            echo '
        <tr>
        <td>' . $colData[$i]['id'] . '</td>
        <td>' . $colData[$i]['color_name'] . '</td>

        </tr>
        ';
        }
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }
    echo '</tbody>
        </table>

        </div>
    


        <div id="item_color-1"  >
        <form id="color_form"  method="post"  action="inventory.php?action=color" >

        <div class="form-group">
        <label class="col-sm-3 control-label">' . $lang[989] . '</label>
        <div class="col-sm-9"><input class="form-control" type="text" name="color_name" value=""></div>
        </div>

        <hr>
        <div class="wizard-actions">
        <!-- #section:plugins/fuelux.wizard.buttons -->
      

        <button type="button" class="btn btn-success btn-next" onclick="add_form_php(\'color_form\',\'1\')">' . $lang[260] . '</button>

        <!-- /section:plugins/fuelux.wizard.buttons -->
        </div>

        </form>

        </div>
    
      
        
        </div>';


}


function template_invenotry_item_company()
{

    global $lang, $c_setting, $colData;
    echo ' <script type="text/javascript">
        
              $(document).ready(function() {
                $("#item_company").tabs();
                  var $tabs = $("#item_company").tabs({});
                });
        
              </script>
              
        
            <div id="item_company" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            
            <ul>
              <li><a href="#item_color-0">' . $lang[999] . '</a></li>
              <li><a href="#item_color-1" >' . $lang[1000] . '</a></li>
           </ul>
            
            <div id="item_color-0"  >
            <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
            <td>' . $lang[994] . '</td>
            <td>' . $lang[991] . '</td>
            </tr>
            </thead>
            <tbody>';
    if (is_array($colData) && count($colData) > 0) {
        for ($i = 0; $i < count($colData); $i++) {
            echo '
            <tr>
            <td>' . $colData[$i]['id'] . '</td>
            <td>' . $colData[$i]['company_name'] . '</td>
    
            </tr>
            ';
        }
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }
    echo '</tbody>
            </table>
    
            </div>
        
    
    
            <div id="item_color-1"  >
            <form id="company_form"  method="post"  action="inventory.php?action=company" >
    
            <div class="form-group">
            <label class="col-sm-3 control-label">' . $lang[991] . '</label>
            <div class="col-sm-9"><input type="text" name="company_name" value=""></div>
            </div>
    
    <hr>
            <div class="wizard-actions">
            <!-- #section:plugins/fuelux.wizard.buttons -->
          
    
            <button type="button" class="btn btn-success btn-next" onclick="add_form_php(\'company_form\',\'1\')">' . $lang[260] . '</button>
    
            <!-- /section:plugins/fuelux.wizard.buttons -->
        </div>
    
            </form>
    
            </div>
        
          
            
            </div>';


}


function template_inventory_items_size()
{

    global $lang, $c_setting, $colData;
    echo ' <script type="text/javascript">
            
                  $(document).ready(function() {
                    $("#item_size").tabs();
                      var $tabs = $("#item_size").tabs({});
                    });
            
                  </script>
                  
            
                <div id="item_size" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                
                <ul>
                  <li><a href="#item_size-0">' . $lang[1006] . '</a></li>
                  <li><a href="#item_size-1" >' . $lang[1009] . '</a></li>
               </ul>
                
                <div id="item_size-0"  >
                <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                <td>' . $lang[994] . '</td>
                <td>' . $lang[1007] . '</td>
                <td>' . $lang[1008] . '</td>
                </tr>
                </thead>
                <tbody>';
    if (is_array($colData) && count($colData) > 0) {
        for ($i = 0; $i < count($colData); $i++) {
            echo '
                <tr>
                <td>' . $colData[$i]['id'] . '</td>
                <td>' . $colData[$i]['item_width'] . '</td>
                <td>' . $colData[$i]['item_height'] . '</td>
                </tr>
                ';
        }
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }
    echo '</tbody>
                </table>
        
                </div>
            
        
        
                <div id="item_size-1"  >
                <form id="size_form"  method="post"  action="inventory.php?action=size" >
        
                <div class="form-group">
                <label class="col-sm-3 control-label">' . $lang[1007] . '</label>
                <div class="col-sm-9"><input type="text" name="item_width" value=""></div>
                </div>

                <div class="form-group">
                <label class="col-sm-3 control-label">' . $lang[1008] . '</label>
                <div class="col-sm-9"><input type="text" name="item_height" value=""></div>
                </div>
        
        <hr>
                <div class="wizard-actions">
                <!-- #section:plugins/fuelux.wizard.buttons -->
              
        
                <button type="button" class="btn btn-success btn-next" onclick="add_form_php(\'size_form\',\'1\')">' . $lang[260] . '</button>
        
                <!-- /section:plugins/fuelux.wizard.buttons -->
            </div>
        
                </form>
        
                </div>
            
              
                
                </div>';


}

///////////pacjage managment////////
function template_price_pac_mange()
{
    global $lang;

    echo ' <script>
      $(document).ready(function() {
        $("#price_pac").tabs();
      });
      </script>
      
    <div id="price_pac" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
    
    <ul>
       <li><a href="inventory.php?action=price_pac&what=setting" >' . $lang[326] . '</a></li>
       <li><a href="inventory.php?action=price_pac&what=add" >' . $lang[327] . '</a></li>
       
    </ul>
    
    <div id="price_pac-0" style="padding:0px;" >
    </div>
    
    <div id="price_pac-1" >
    </div>
    
    </div>
    ';
}

function template_price_pac_add()
{
    global $lang;
    echo '
    <form id="add_pacervice" method="post" action="inventory.php?action=price_pac"  >
    
    <input type="hidden" name="add_pac" value="1" />
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[328] . '</label>
    <div class="col-sm-9"><input class="form-control" type="text" name="pac_name" value="" /></div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[329] . '</label>
    <div class="col-sm-9"><input class="form-control" type="text" name="pac_name_short" value="" /></div>
    </div>
    
    
    <div class="form-group">
    <label class="col-sm-3 control-label"></label>
    <div class="col-sm-9"><input type="button" onclick="add_pac_services();" class="btn btn-info" style="margin:0 auto;" value="' . $lang[327] . '" name="update"/>
    </div>
    </div>
    
    </form>
    <div style="clear:both;"></div>
    ';
}

function template_price_pac_edit()
{
    global $lang, $edit;

    echo '
    <form id="edit_pacservice" method="post" action="inventory.php?action=price_pac" style="width:100%;" >
    <input class="form-control" type="hidden" name="edit_pac" value="1" />
    <input class="form-control" type="hidden" name="edit_pac_id" value="' . $edit->package_id . '" />
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[328] . '</label>
    <div class="col-sm-9"><input class="form-control" type="text" name="pac_name" value="' . $edit->package_name . '" /></div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[329] . '</label>
    <div class="col-sm-9"><input class="form-control" type="text" name="pac_name_short" value="' . $edit->package_short . '" /></div>
    </div>
    
    
    <div class="form-group">
    <label class="col-sm-3 control-label"></label>
    <div class="col-sm-9">
    <input type="button" onclick="edit_pacservices();" class="btn btn-info" style="margin:0 auto;" value="' . $lang[330] . '" name="update"/>
    </div>
    </div>
    
    </form>
    <div id="prdia"></div>
    <div style="clear:both;"></div>
    ';
}

function template_price_pac()
{
    global $lang, $pac;
    echo '
    <div style="overflow-x: auto">
    <table  style="width:auto;" border="1" class="table table-striped table-bordered table-hover" id="add_serv" >
    <thead>
    <tr>
    <th>' . $lang[257] . '</th>
    <th>' . $lang[36] . '</th>
    <th>' . $lang[118] . '</th>
    <th>' . $lang[312] . '</th>
    <th>' . $lang[259] . '</th>
    </tr>
    </thead>
    
    <tbody>
    ';

    if (count($pac) > 0) {
        for ($i = 0; $i < count($pac); $i++) {
            echo '
    <tr>
    <td>' . $pac[$i]['package_id'] . '</td>
    <td>' . $pac[$i]['package_name'] . '</td>
    <td>' . $pac[$i]['package_short'] . '</td>
    <td><a href="#" onclick="edit_pac_service(\'' . $pac[$i]['package_id'] . '\',\'' . $pac[$i]['package_name'] . '\');">' . $lang[312] . '</a></td>
    <td><a href="#" onclick="delete_pac_service(\'' . $pac[$i]['package_id'] . '\');">' . $lang[259] . '</a></td>
    </tr>
    ';
        }
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }

    echo '
    </tbody>
    
    
    </table>
    </div>
    <div style="clear:both;"></div>
    ';
}


function template_account_manage()
{
    global $lang;
    echo '
    <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
      <script>
      $(document).ready(function() {
        $("#suppliers").tabs();
        
    
        
      });
      
      </script>
      
    
    <div id="suppliers" >
    
    <ul>
      <li><a href="inventory.php?action=search" >' . $lang[1001] . '</a></li>
       <li><a href="inventory.php?action=Suppliers" >' . $lang[1002] . '</a></li>
       <li><a href="inventory.php?action=mange_add_account" >' . $lang[1003] . '</a></li>
    
    </ul>
    
    <div id="suppliers-0" class="tabset_content" >
    </div>
    
    <div id="suppliers-1" class="tabset_content">
    </div>
    
    <div id="suppliers-2" class="tabset_content">
    </div>
    
    <div id="tabs-3" class="tabset_content">
    </div>
    
               <div id="suppliers-4" class="tabset_content">
    </div>
               
    </div>
    
    ';
}

function template_active_suppliers()
{
    global $accounts, $lang;

    if (is_array($accounts)) {
        //print_r($data);
        echo '
        <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
        
        <div style="overflow-x: auto">
        <table style="width:auto" border="1" class="table table-striped table-bordered table-hover">
        
        <thead>
        <th>' . $lang[257] . '</th>
        <th>' . $lang[717] . '</th>
        <th>' . $lang[36] . '</th>
        <th>' . $lang[431] . '</th>
        <th>' . $lang[718] . '</th>
        <th>' . $lang[719] . '</th>
        <th>' . $lang[11] . '</th>
        <th>' . $lang[12] . '</th>
        <th>' . $lang[133] . '</th>
        <th>' . $lang[312] . '</th>
        </thead>
        
        
        ';
        if (is_array($accounts) && count($accounts) > 0) {
            for ($i = 0; $i < count($accounts); $i++) {
                echo '<tr>';
                $x = $accounts[$i];

                foreach ($x as $val) {

                    //  $tex = $val[key($val)];

                    // $tex = str_replace(",","<br>",$tex);

                    echo '<td>' . $val . '</td>';
                }


                echo '<td><a onclick="show_edit_suppliers(\'' . $accounts[$i]['account_id'] . '\',\'' . $accounts[$i]['account_name'] . '\');" href="#" >' . $lang[312] . '</a>
                
            
            </td>';

                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
        }
        echo '</table>
        </div>
        
        ';
    }

}


function template_search_account()
{
    global $lang;

    echo '
                    <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/account.js"></script>
                    
                    <form id="search_account" method="post"   class="form-horizontal" autocomplete="off" style="width:60%; margin:auto;">
                    
                    <input type="text" name="search_account_value"  id="search_account_value" value=""  class="form-control" placeholder="اكتب رقم الحساب او اسم الشركة" />
                    
                    
                 </form>
                    
                    <div id="search_result">
                    
                    </div>
                    
                    ';
}


function template_manage_add_account()
{
    global $lang, $account_id;

    echo '
    <script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/admin.js"></script>
      <script>
      $(document).ready(function() {
        $("#mange_add_' . $account_id . '").tabs({});  
      });
      </script>
      
    <div id="right_side">
    <div id="mange_add_' . $account_id . '" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
    
    <ul>';

    if (isset($account_id) && $account_id != "") {

        echo '
       <li><a href="inventory.php?action=account_details&account_id=' . $account_id . '" >' . $lang[497] . '</a></li>
      ';

    } else {
        echo '	
       <li><a href="inventory.php?action=account_details" >' . $lang[497] . '</a></li>
      ';
    }

    echo '
              
      
    
    </ul>
    
    <div id="mange_add_' . $account_id . '-0"  >
    </div>
    
    <div id="mange_add_' . $account_id . '-1" >
    </div>
    
    <div id="mange_add_' . $account_id . '-2" >
    </div>
    
    <div id="mange_add_' . $account_id . '-3" >
    </div>
    
    <div id="mange_add_' . $account_id . '-4" >
    </div>
    
    <div id="mange_add_' . $account_id . '-5" >
    </div>
    
        
    </div>
    <div style="clear:both;"></div>
    <div style="clear:both;"></div>
    </div>
    <div style="clear:both;"></div>
    <div style="clear:both;"></div>
    ';
}


function template_account_details()
{
    global $lang, $locations, $usertype, $account_details, $account_id, $zone;
    echo '
    
    
    <form name="add_account" id="add_account_details_' . $account_id . '" method="post" action="inventory.php?action=account_details&account_id=' . $account_id . '" class="form-horizontal">
    
    <div class="col-sm-6 col-xs-12"  >
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[1004] . '</label>
    <div class="col-sm-9"><input type="text" name="account_name" value="' . (isset($account_details->account_name) ? $account_details->account_name : '') . '" ' . ($account_id != '' ? 'disabled' : '') . '  /></div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[1005] . '</label>
    <div class="col-sm-9"><input type="text" name="account_company" value="' . (isset($account_details->account_company) ? $account_details->account_company : '') . '" /></div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[118] . '</label>
    <div class="col-sm-9"><input type="text" name="account_shortname" value="' . (isset($account_details->account_shortname) ? $account_details->account_shortname : '') . '" /></div>
    </div>
    
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[7] . '</label>
    <div class="col-sm-9"><textarea name="account_address" >' . (isset($account_details->account_address) ? $account_details->account_address : '') . '</textarea></div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[8] . '</label>
    <div class="col-sm-9"><input type="text" name="city" value="' . (isset($account_details->city) ? $account_details->city : '') . '" /></div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[9] . '</label>
    <div class="col-sm-9"><input type="text" name="pcode" value="' . (isset($account_details->pcode) ? $account_details->pcode : '') . '" /></div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[11] . '</label>
    <div class="col-sm-9"><input type="text" name="phone" value="' . (isset($account_details->phone) ? $account_details->phone : '') . '" /></div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[12] . '</label>
    <div class="col-sm-9"><input type="text" name="fax" value="' . (isset($account_details->fax) ? $account_details->fax : '') . '" /></div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[440] . '</label>
    <div class="col-sm-9"><textarea name="note_comment" >' . (isset($account_details->note_comment) ? $account_details->note_comment : '') . '</textarea></div>
    </div>
    
    
    
            
    </div>
    
    <div class="col-sm-6 col-xs-12" >
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[120] . ' (1)</label>
    <div class="col-sm-9"><input type="text" name="phone2" value="' . (isset($account_details->phone2) ? $account_details->phone2 : '') . '" /></div>
    </div>
    <div class="form-group">
    <label class="col-sm-3 control-label"  >' . $lang[610] . '</label>
    <div class="col-sm-9"><input type="text" name="phone2type" value="' . (isset($account_details->phone2type) ? $account_details->phone2type : '') . '" /></div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[120] . ' (2) </label>
    <div class="col-sm-9"><input type="text" name="phone3" value="' . (isset($account_details->phone3) ? $account_details->phone3 : '') . '" /></div>
    </div>
    <div class="form-group">
    <label class="col-sm-3 control-label"  >' . $lang[610] . '</label>
    <div class="col-sm-9"><input type="text" name="phone3type" value="' . (isset($account_details->phone3type) ? $account_details->phone3type : '') . '" /></div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[120] . '(3)</label>
    <div class="col-sm-9"><input type="text" name="phone4" value="' . (isset($account_details->phone4) ? $account_details->phone4 : '') . '" /></div>
    </div>
    <div class="form-group">
    <label class="col-sm-3 control-label" >' . $lang[610] . '</label>
    <div class="col-sm-9"><input type="text" name="phone4type" value="' . (isset($account_details->phone4type) ? $account_details->phone4type : '') . '" /></div>
    </div>
    
    
    
    
    
    
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[175] . '</label>
    <div class="col-sm-9">
    <select name="account_catid">
    <option value="0" >' . $lang['204'] . '</option>
    ';
    for ($i = 0; $i < count($usertype); $i++) {
        echo '<option value="' . $usertype[$i]['cat_id'] . '"  ' . (isset($account_details->account_catid) && $account_details->account_catid == $usertype[$i]['cat_id'] ? 'selected' : '') . ' >' . $usertype[$i]['cat_name'] . '</option>';
    }
    //$usertype
    echo '</select>
    </div>
    </div>
    
    <div class="form-group">
    <label class="col-sm-3 control-label">' . $lang[176] . '</label>
    <div class="col-sm-9" >
    <select name="account_location">
    <option value="0">' . $lang['491'] . '</option>
    ';
    for ($i = 0; $i < count($locations); $i++) {
        echo '<option value="' . $locations[$i]['cat_id'] . '"  ' . (isset($account_details->account_location) && $account_details->account_location == $locations[$i]['cat_id'] ? 'selected' : '') . ' >' . $locations[$i]['cat_name'] . '</option>';
    }
    //$usertype
    echo '</select>
    </div>
    </div>
    
    <input type="hidden" name="status" value="5" />

    
    </div>
    
    
    <div style="clear:both;"></div>
    
    <hr>
    <div class="form-group"> 
    <div class="col-sm-9" style="width: 200px; float: none;margin: auto; height:40px;">
    <input type="button" id="add_acc" onclick="add_accountss(\'' . $account_id . '\');"  value="' . $lang[50] . '" class="btn btn-info"  name="edituser"/>';
    if ($account_id != '') {
        echo '<input type="button" id="close" onclick="close_my_tab(\'suppliers\');"  value="' . $lang[200] . '" class="btn btn-info"  />';
    }
    echo '</div>
    </div>
    
    
    <div style="clear:both;"></div>
    
    </form>
    <div style="clear:both;"></div>
    <div id="result"></div>
    <div style="clear:both;"></div>
    ';
}


function template_purchase_main()
{
    global $lang, $c_setting;
    echo ' <script type="text/javascript">
        
              $(document).ready(function() {
                $("#purchase").tabs();
                  var $tabs = $("#purchase").tabs({});
                });
        
              </script>
              
        
            <div id="purchase" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            
            <ul>
              <li><a href="inventory.php?action=get_purchase" >' . $lang[90] . '</a></li>
              <li><a href="inventory.php?action=add_purchase" >' . $lang[1010] . '</a></li>
           </ul>
            
            <div id="purchase-0"  >
            </div>
        
            <div id="purchase-0"  >
            </div>
        
            <div id="purchase-0"  >
            </div>
            
            </div>';
}


function template_purchase_data()
{
    global $lang, $c_setting, $invData;

    echo '
    <div style="overflow-x: auto">
    <table style="width:auto;" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
    <td>' . $lang[994] . '</td>
    <td>الفاتورة</td>
    <td>المورد</td>
    <td>التاريخ</td>
    <td>المجموع</td>
    </tr>
    </thead>
    <tbody>';
    if (is_array($invData) && count($invData) > 0) {
        for ($i = 0; $i < count($invData); $i++) {
            echo '
    <tr>
    <td>' . $invData[$i]['id'] . '</td>
    <td>' . $invData[$i]['bill_no'] . '</td>
    <td>' . $invData[$i]['account'] . '</td>
    <td>' . date($c_setting['date_format'], strtotime($invData[$i]['bill_date'])) . '</td>
    <td>' . $invData[$i]['total_price'] . '</td>
    </tr>
    ';
        }
    } else {
        echo '<tr><td colspan="100%">' . $lang[472] . '</td></tr>';
    }
    echo '</tbody>
    </table>
    </div>
    ';

}

function template_add_purchase()
{
    global $lang, $c_setting, $accountsData, $itemData;

    echo '    
 <form id="addbill_form"  method="post"  action="inventory.php?action=add_purchase" >
    
            <div class="form-group">
            <label class="col-sm-3 control-label">رقم الفاتورة</label>
            <div class="col-sm-9"><input type="text" name="bill_no" value=""></div>
            </div>

            <div class="form-group">
            <label class="col-sm-3 control-label">تاريخ الفاتورة</label>
            <div class="col-sm-9">  <input id="bill_date" type="text" class="timepicker hasDatepicker bill_date" name="bill_date" value>
            </div>
            </div>

            <div class="form-group">
            <label class="col-sm-3 control-label">المورد</label>
            <div class="col-sm-9">
            <select name="account_id">
            ';
    for ($i = 0; $i < count($accountsData); $i++) {
        echo '<option value="' . $accountsData[$i]['account_id'] . '" >' . $accountsData[$i]['account_name'] . ' | ' . $accountsData[$i]['account_company'] . '</option>';
    }
    echo '
            </select></div>
            </div>

            <div class="form-group">
            <label class="col-sm-3 control-label">اجمالى السعر</label>
            <div class="col-sm-9"><input type="text" name="total_price" value="">
            </div>
            </div>
            <div style="clear:both;"></div>

            <hr/>

            <table class="table table-striped table-bordered table-hover">
            <tr>
            <td>المنتج</td>
            <td>الكمية</td>
            <td>سعر الوحدة</td>
            </tr>';

    for ($j = 0; $j < 10; $j++) {
        echo '<tr>
            <td>
            <div class="form-group">
            <select class="form-control" name="item_id[]" >
            <option value="">اختار المنتج</option>';
        for ($i = 0; $i < count($itemData); $i++) {

            echo '<option value="' . $itemData[$i]['id'] . '">' . $itemData[$i]['item_name'] . '</option>';
        }
        echo '</select></div></td>
          <td>
            <div class="form-group">
                <input class="form-control" type="text" name="quantity[]" value="" size="10"/>
            </div> 
            </td>
        <td>
            <div class="form-group">
                <input class="form-control" type="text" name="price[]" value="" size="10" />
            </div>
        </td>
          </tr>';
    }
    echo '  </table>

      
    
<script type="text/javascript">
$(document).ready(function(){
    $(\'.bill_date\').datepicker();
});
</script>
    <hr>
            <div class="wizard-actions">
            <!-- #section:plugins/fuelux.wizard.buttons -->
          
    
            <button type="button" class="btn btn-success btn-next" onclick="add_form_php(\'addbill_form\',\'1\')">' . $lang[260] . '</button>
    
            <!-- /section:plugins/fuelux.wizard.buttons -->
        </div>
    
            </form>
    ';

}


function template_out_inventory()
{
    global $lang, $itemData, $inv;

    echo '
  
  <form id="inventory_out"  method="post"  action="work.php?action=inventory" >
    
<input type="hidden" name="get_stock" value="1"/>
  <table class="table table-striped table-bordered table-hover">
  <tr>
  <td>المنتج</td>
  <td>الكمية</td>
  </tr>';

    for ($j = 0; $j < 4; $j++) {
        echo '<tr>
  <td>
  <select name="item_id[]" >
  <option value="">اختار المنتج</option>';
        for ($i = 0; $i < count($itemData); $i++) {

            echo '<option value="' . $itemData[$i]['id'] . '">' . $itemData[$i]['item_name'] . '</option>';
        }
        echo '</select></td>
<td><input type="text" name="quantity[]" value="" size="10"/> </td>
</tr>';
    }
    echo '  </table>



<hr>
  <div class="wizard-actions">
  <!-- #section:plugins/fuelux.wizard.buttons -->


  <button type="submit" class="btn btn-success btn-next" style="margin:auto;" >سحب انتاج</button>

  <!-- /section:plugins/fuelux.wizard.buttons -->
</div>

  </form>

  <hr>
  ';

    if (is_array($inv) and count($inv) > 0) {

        echo '
    <table class="table table-striped table-bordered table-hover">
    <tr>
    <th></th>
    <th>المنتج</th>
    <th>الكمية</th>
    <th>التاريخ</th>
    </tr>';

        for ($i = 0; $i < count($inv); $i++) {

            echo '
      <tr>
      <td>' . ($i + 1) . '</td>
      <td>' . $inv[$i]['item_name'] . '</td>
      <td>' . $inv[$i]['quantity'] . '</td>
      <td>' . date("l jS \of F Y h:i:s A", strtotime($inv[$i]['action_time'])) . '</td>
      </tr>
      ';
        }


        echo '</table>';
    }

}

?>

