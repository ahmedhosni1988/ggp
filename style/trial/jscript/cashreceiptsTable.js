$(document).ready(function() { 

    //////////////////////////////// new table//////////////////
    $.fn.dataTable.ext.errMode = ( settings, techNote, message )=>{
        ////error
        console.log(settings, techNote, message)
    }

   $('#cashreceiptsList').DataTable( {  
        lengthMenu: [ 30, 50, 100, 200, 500], 
        // "columns": [
        //     { "data": "name" },
        //     { "data": "position" },
        //     { "data": "office" },
        //     { "data": "extn" },
        //     { "data": "start_date" },
        //     { "data": "salary" }
        // ],
        // "processing": true,
        // "serverSide": true,
        // "ajax":  {
        //     "url": php,
        //     "type": "POST"
        // }
        
        // ,
        // "paging": false,
        // "searching": false, 
        // "info": false,
        // "cache": false,
        footerCallback: function (row, data, start, end, display) {

             var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 1, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 1 ).footer() ).html(
                pageTotal +' ( '+ total +' المجموع الكلى)'
            );

          },
        // "fnRowCallback": ( nRow, aData, iDisplayIndex )=> {

        // var a=`<button type="button" class="btn  btn-success btn-xs"
        //          onclick='show_edit_cashreceipts(\``+JSON.stringify(aData)+`\`)'>
        //              <i class="fa fa-external-link "></i>
        //         </button>
        //         <button type="button" class="btn btn-info btn-xs"
        //          onclick='print_cash(\``+JSON.stringify(aData)+`\`,\``+logo+`\`,\``+name+`\`)'>
        //              <i class="fa fa-print bigger-125 icon-only "></i>
        //         </button>
        //         `;
        // $(nRow).find('td:last').html(a)
       
        //         return nRow;
        //       }
    } );

  
})


function show_edit_cashreceipts(data) {
    var obj = JSON.parse(data)
    console.log(obj)
    var name1 = "تعديل : " + obj['account_company'];

    var req = $.ajax({
        type: "POST",
        url:'accounting.php?action=cash',
        data: obj
    });


    req.done(function (msg) { 
        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            minWidth: 700,
                modal: true,
                title: "<div class='widget-header' style=\"width: 500px;\"><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>"+name1+"</h4></div>",
                title_html: true,
                buttons: {
                    Close: function () {
                        $(this).dialog("close");


                    }
                }
            });
    })

    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
       
   
}
