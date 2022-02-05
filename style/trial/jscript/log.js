$(document).ready(function() {

    $('.timepicker').datetimepicker({
        pickTime: false
    });

    $('#search_log_btn').click(function(){
        var oid         = $('#search_oid').val();
        var oname       = $('[name=o_name]').val();
        var uname       = $('#search_uname').val();
        var start_time  = $('#start_time').val();
        var end_time    = $('#end_time').val();
        
        // validate if start time less than end time
        //if(start_time > end_time) start_time = '';
        search(oid, oname, uname, start_time, end_time,0);


    });

    // VIEW DETAILS LINK CLICKED
    bindings();

    

$('#template_main_logpage_new').DataTable( {  
    lengthMenu: [30, 50, 100, 200, 500],
    "order": [[ 0, "desc" ]],
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": php,
        "type": "POST"
    },
    "fnRowCallback": ( nRow, aData, iDisplayIndex )=> {
        console.log(aData)
    var a=`<b><a href="#" class="op-details" onclick="set_data(this)" data-head='${aData.OPERATION_NAME} ${aData.OBJECT_NAME} ${aData.ID} من خلال ${aData.USER_NAME}</br> فى تاريخ :${aData.DATE}' data-before-op='${aData.BEFORE_CHANGE.split("'").join("") }' data-after-op='${aData.AFTER_CHANGE.split("'").join("")}'  data-toggle="modal" data-target="#logDetailsModal"> ( view details ) </a></b>`
    $(nRow).find('td:last').html($(nRow).find('td:last').html() +a)
            return nRow;
          }
} );


});
                /*          >>>>>>>>>>>>>   FUNCTIONS   <<<<<<<<<<<      */

                
function set_data(e){
    console.log(e);
    var head = $(e).data("head");
    $(".modal-header h3").empty(); 
    $(".modal-header h3").append(head); 
    $(".modal-body #rows").empty(); 
    var before_op = $(e).data("before-op");
    var after_op = $(e).data("after-op");
    console.log(before_op,after_op)
    before_op_ordered = {};
    after_op_ordered = {};
    if(before_op.length == 0) { 
        //$('#modal_log_tbl thead tr').find('th:eq(1)').remove();
        $('#modal_log_tbl thead tr').remove();
        $('#modal_log_tbl thead').append('<tr><th>Column</th><th>After Operation</th></tr>');
        Object.keys(after_op).sort().forEach(function(key) {
            after_op_ordered[key] = after_op[key];
            $(".modal-body #rows").append('<tr><td>' + key + '</td><td>' + after_op_ordered[key] + '</td></tr>');
        });
    }else {
        $('#modal_log_tbl thead tr').remove();
        $('#modal_log_tbl thead').append('<tr><th>Column</th><th>Before Operation</th><th>After Operation</th></tr>');
        Object.keys(before_op,after_op).sort().forEach(function(key) {
            before_op_ordered[key] = before_op[key];
            after_op_ordered[key] = after_op[key];
            $(".modal-body #rows").append('<tr><td>' + key + '</td><td>' + before_op_ordered[key] + '</td><td>' + after_op_ordered[key] + '</td></tr>');
        });
        }
}

function search(oid, oname, uname, start_time, end_time, start) {

    $.ajax({
        method: "POST",
        url:  "log.php?search=1",
        data: {oid:oid, oname:oname, uname:uname, start_time:start_time, end_time:end_time, start:start},
        success: function(data){
            var obj = JSON.parse(data);
            //console.log(obj['lang']);
            $('#log_tbl').html(buildTable(obj['tbl']));
            $('.pagination').empty();
            
            var count = obj['cnt'];
            //var lang = obj['lang'];
            var pages = Math.ceil(count/obj['perpage']);
            var step = parseInt(obj['perpage']);

            // call function "start - pages - step"
            var row = buildPaging(start, pages, step);
            $('#log_tbl .table-striped').after(row);

            bindings();
        }
    })

}

function buildPaging(start, pages, step) {

    var row = "<ul class='pagination'>";
    if(start > 0) row += "<li><a onclick='search_paging_log(" + (start - step) + ")' > << </a></li>";
            
    /*
    for(var i=1;i<=pages;i++){
        var next_page = (i-1)*step;
        row += "<li>";

        if(next_page == (start)) row += "<a style='background-color:#4692bf;color:#000' >" + i + "</a>";
        else row += "<a onclick='search_paging_log(" + next_page + ")' >" + i + "</a>";

        row += " </li>";
        //if(i == 3) break;
    }
    */
    

    if(start < (pages * step) - step) row += "<li><a onclick='search_paging_log(" + (start + step) + ")' > >> </a></li>";
    row += "</ui";

    return row;
}


function buildTable(data){
    var table = "<table class='table table-striped'><thead><tr><th>id</th><th>object id</th><th>object name</th><th>user name</th><th>operation</th><th>date</th></tr></thead><tbody>";
    if(typeof data == 'object') {
        var obj = data;
    }else var obj = JSON.parse(data);
   //console.log(typeof data);

    for (var i = 0; i < obj.length; i++) {
        var bopd = obj[i].BEFORE_CHANGE.replace("'", "", 'g');
        if(bopd === "") bopd = 'no';
        var aopd = obj[i].AFTER_CHANGE.replace("'", "", 'g');
        table += "<tr>" +
                    "<td>"+ obj[i].ID +"</td>" +
                    "<td>"+ obj[i].OBJECT_ID +"</td>" +
                    "<td>"+ obj[i].OBJECT_NAME +"</td>" +
                    "<td>"+ obj[i].USER_NAME +"</td>" +
                    "<td>"+ obj[i].OPERATION_NAME +"<b><a href='#' data-before-op='" + bopd + "' data-after-op='"+ aopd + "' class='op-details' data-toggle='modal' data-target='#logDetailsModal' > ( view details ) </a></b></td>" +
                    "<td>"+ obj[i].DATE +"</td>" +
                "</tr>";
        //console.log(obj[i]);
        //console.log(bopd + aopd);
    }
    table += "</table>";
    return table;
}


function paging_log(start){

    $.ajax({
        method: "POST",
        url:  "log.php?paging=1",
        data: {start:start},
        success: function(data){
            //console.log(data);
            $('#log_tbl').html(buildTable(data));
            // rebibd 
            bindings();
        }
    });
}

function search_paging_log(start){

    var oid         = $('#search_oid').val();
    var oname       = $('[name=o_name]').val();
    var uname       = $('#search_uname').val();
    var start_time  = $('#start_time').val();
    var end_time    = $('#end_time').val();
    //console.log(start);
    // validate if start time less than end time
    //if(start_time > end_time) start_time = '';
    search(oid, oname, uname, start_time, end_time,start);

}

function bindings(){
    $('.op-details').click(function () {
        $(".modal-body #rows").empty();
        var before_op = $(this).data("before-op");
        var after_op = $(this).data("after-op");
        before_op_ordered = {};
        after_op_ordered = {};
        alert(before_op);
        if(before_op == 'no' || before_op == '') {
            //$('#modal_log_tbl thead tr').find('th:eq(1)').remove();
            $('#modal_log_tbl thead tr').remove();
            $('#modal_log_tbl thead').append('<tr><th>Column</th><th>After Operation</th></tr>');
            Object.keys(after_op).sort().forEach(function(key) {
                after_op_ordered[key] = after_op[key];
                $(".modal-body #rows").append('<tr><td>' + key + '</td><td>' +  after_op_ordered[key] + '</td></tr>');
            });
        }else {
            $('#modal_log_tbl thead tr').remove();
            $('#modal_log_tbl thead').append('<tr><th>Column</th><th>Before Operation</th><th>After Operation</th></tr>');
            Object.keys(before_op,after_op).sort().forEach(function(key) {
                before_op_ordered[key] = before_op[key];
                after_op_ordered[key] = after_op[key];
                $(".modal-body #rows").append('<tr><td>' + key + '</td><td>' + before_op_ordered[key] + '</td><td>' + after_op_ordered[key] + '</td></tr>');
            });
         }
    });
}