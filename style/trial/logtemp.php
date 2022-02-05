<?php


function template_main_logpage_new(){
  echo'
  
  
  <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="'.SITEURL.'/'.STYLE.'/assets/DataTables/DataTables/css/dataTables.jqueryui.min.css">
  
  <style>
  #template_main_logpage_new tr:nth-child(odd) {
    background-color: #e9e9e9;
  }
  
  #template_main_logpage_new td {
    padding: 5px !important;
    font-size: 10px;
  }
  #template_main_logpage_new tr:nth-child(even) {
    background-color: #f6f6f6;
  }
  #template_main_logpage_new th{
  font-weight: 900;
    color: #ffffff;
    background:  #307ecc;
  
  }
  

  
  .dataTable>thead>tr>th[class*=sort]:after {
  
    display: none ;
  }
  </style>
  <div class="log_tbl"> 
  <table id="template_main_logpage_new" class="ui celled table " style="width:100%">
  <thead>
      <tr>
          <th>Id</th>
          <th>OBJECT_ID</th>
          <th>OBJECT_NAME</th>
          <th>USER_NAME</th>
          <th>DATE</th>
          <th>OPERATION_NAME</th>
         
      </tr>
  </thead>
  <tfoot>
      <tr>
      <th>Id</th>
      <th>OBJECT_ID</th>
      <th>OBJECT_NAME</th>
      <th>USER_NAME</th>
      <th>DATE</th>
      <th>OPERATION_NAME</th>
     
      </tr>
  </tfoot>
  </table> 
  </div>
  <!-- Modal -->
  <div id="logDetailsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" >Details</h3>
        </div>
        <div class="modal-body" style="overflow-x: auto;">
        
        <table id="modal_log_tbl" class="table table-striped">
          <thead>
              <!--<tr>
                <th>Column</th>
                <th>Before Operation</th> 
                <th>After Operation</th>
              </tr>-->
            </thead>
            <tbody id="rows">
              
            </tbody>
          </table>
  
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
  
    </div>
  </div>
  
  <script>
  
  var php="'.SITEURL.'/administrator/logTable.php";
  </script>
  <script src="'.SITEURL.'/'.STYLE.'/jscript/jquery.dataTables.min.js"></script>
  <script src="'.SITEURL.'/'.STYLE.'/jscript/dataTables.buttons.min.js"></script>
  <script src="'.SITEURL.'/'.STYLE.'/jscript/jszip.min.js"></script>
  <script src="'.SITEURL.'/'.STYLE.'/jscript/pdfmake.min.js"></script>
  <script src="'.SITEURL.'/'.STYLE.'/jscript/vfs_fonts.js"></script>
  <script src="'.SITEURL.'/'.STYLE.'/jscript/buttons.html5.min.js"></script>
  <script src="'.SITEURL.'/'.STYLE.'/jscript/log.js"></script>
  
  
  ';
  
  }


function template_main_logpage(){
    global $lang,$all_logs,$count;

    if($count > PERPAGE) $pages = ceil($count/PERPAGE);
    else $page = 1;

    echo '
    <div class="container">
    
        <div class="panel panel-primary" style="margin-top:1%;">
        <div class="panel-heading">Search Options </div>
        <div class="panel-body">
          <form class="form-inline">
          <div class="form-group">
            <input type="text" name="search_oid" id="search_oid" placeholder="Object ID" />
          </div>
          <div class="form-group">
            <input type="text" name="search_uname" id="search_uname" placeholder="User Name" />
          </div>
          <div class="form-group">
            <select name="o_name">
              <option value="" selected >Object Name</option>
              <option value="company_details" '.($sett_compnay["o_name"]["option_value"] == "company_details" ? 'selected' : '' ).' >Comapny Details</option>
              <option value="order" '.($sett_compnay["o_name"]["option_value"] == "order" ? 'selected' : '' ).'>Order</option>
              <option value="driver" '.($sett_compnay["o_name"]["option_value"] == "driver" ? 'selected' : '' ).'>Driver</option>
              <option value="client" '.($sett_compnay["o_name"]["option_value"] == "client" ? 'selected' : '' ).'>Client</option>
              <option value="account" '.($sett_compnay["o_name"]["option_value"] == "account" ? 'selected' : '' ).'>Account</option>
            </select>

          </div>

          <div class="form-group">

              <label for="start_time">Start time </label>
                <input type="text" id="start_time" class="form-control timepicker" name="start_time" data-date-format="YYYY-MM-DD" />
                <span class="glyphicon glyphicon-calendar"></span>

          </div>

          <div class="form-group">
              
              <label for="end_time">End time </label>
                <input type="text" id="end_time" class="form-control timepicker" name="end_time" data-date-format="YYYY-MM-DD" />
                <span class="glyphicon glyphicon-calendar"></span>

          </div>
          
            <input type="button" class="btn btn-info btn-xs" name="search_log" id="search_log_btn" value="Search" />
          </form>
          </div>
        </div>
       
        <div style="overflow-x: auto">
        <div id="log_tbl">         
            <table  style="width:auto;" class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>object id</th>
                    <th>object name</th>
                    <th>user name</th>
                    <th>operation</th>
                    <th>date</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($all_logs as $row) {
                echo '<tr>
                        <td>'.$row['ID'].'</td>
                        <td>'.$row['OBJECT_ID'].'</td>
                        <td>'.$row['OBJECT_NAME'].'</td>
                        <td>'.$row['USER_NAME'].'</td>
                        ';
                        (!empty($row['BEFORE_CHANGE'])) ? $row['BEFORE_CHANGE'] : $row['BEFORE_CHANGE'] = 'no';
                        echo '
                        <td>'.$row['OPERATION_NAME'].'<b><a href="#" data-before-op=\''.str_replace('\'','',html_entity_decode ($row['BEFORE_CHANGE'])).'\' data-after-op=\''.str_replace('\'','',html_entity_decode ($row['AFTER_CHANGE'])).'\'  class="op-details" data-toggle="modal" data-target="#logDetailsModal" > ( view details ) </a></b></td>
                        <td>'.$row['DATE'].'</td>
                    </tr>';
            }
            echo '
            </tbody>
            </table>
            
        </div>

        <ul class="pagination">';
          for($i=1;$i<=$pages;$i++){
            echo '<li><a onclick="paging_log('.(($i-1)*PERPAGE).');" >'.$i.'</a></li>';
          }
        echo ' </ul>
        </div>
    </div>
  
<!-- Modal -->
<div id="logDetailsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title" >Details</h3>
      </div>
      <div class="modal-body" style="overflow-x: auto;">
      
      <table id="modal_log_tbl" class="table table-striped">
        <thead>
            <!--<tr>
              <th>Column</th>
              <th>Before Operation</th>
              <th>After Operation</th>
            </tr>-->
          </thead>
          <tbody id="rows">
            
          </tbody>
        </table>

        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    
<script src="'.SITEURL.'/'.STYLE.'/jscript/log.js"></script>

    ';
}

?>
