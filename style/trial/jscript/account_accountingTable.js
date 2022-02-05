$(document).ready(function() {

    //////////////////////////////// new table//////////////////
    $.fn.dataTable.ext.errMode = ( settings, techNote, message )=>{
        ////error
        console.log(settings, techNote, message)
    }

    
$('#List').DataTable( {  
    lengthMenu: [ 30, 50, 100, 200, 500], 
    dom: 'Bfrtip',
    buttons: ['pageLength',{
            extend: 'excel',
            // messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.'
        }
    ],
    // "columns": [
    //     { "data": "name" },
    //     { "data": "allinvoises" },
    //     { "data": "allCash" },
    //     { "data": "sub" },
        
    // ],
    // "processing": true,
    // "data": dataList,
    footerCallback: function (row, data, start, end, display) {
        console.log(data)
         var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over all pages
        total2 = api
            .column( 2 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total1 = api
        .column( 1 )
        .data()
        .reduce( function (a, b) {
            return intVal(a) + intVal(b);
        }, 0 );
        total3 = api
        .column( 3 )
        .data()
        .reduce( function (a, b) {
            return intVal(a) + intVal(b);
        }, 0 );

        // Total over this page
        pageTotal2 = api
            .column( 2, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal1 = api
        .column( 1, { page: 'current'} )
        .data()
        .reduce( function (a, b) {
            return intVal(a) + intVal(b);
        }, 0 );
        pageTotal3 = api
        .column( 3, { page: 'current'} )
        .data()
        .reduce( function (a, b) {
            return intVal(a) + intVal(b);
        }, 0 );

        // Update footer
        $( api.column( 1 ).footer() ).html(
            pageTotal1 +' ( '+ total1 +' اجمالى الفواتير)'
        );
        $( api.column( 2 ).footer() ).html(
            pageTotal2 +' ( '+ total2 +' اجمالى التحصيل)'
        );
        $( api.column( 3 ).footer() ).html(
            pageTotal3 +' ( '+ total3 +' اجمالى المديونية)'
        );

      }
} );

   $('#account_accounting').DataTable( {  
        lengthMenu: [ 30, 50, 100, 200, 500], 
        dom: 'Bfrtip',
        buttons: ['pageLength',{
                extend: 'excel',
                // messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.'
            }
        ],
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
        // "ajax": {
        //     "url": php,
        //     "type": "POST"
        // },
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
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 2 ).footer() ).html(
                pageTotal +' ( '+ total +' المجموع الكلى)'
            );

          }
    } );

    
   $('#account_accounting2').DataTable( {  
    lengthMenu: [ 30, 50, 100, 200, 500], 
    dom: 'Bfrtip',
    buttons: ['pageLength',{
            extend: 'excel',
            // messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.'
        }
    ],
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
    // "ajax": {
    //     "url": php2,
    //     "type": "POST"
    // },
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
            .column( 2 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Total over this page
        pageTotal = api
            .column( 2, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column( 2 ).footer() ).html(
            pageTotal +' ( '+ total +' المجموع الكلى)'
        );

      }
} );

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
    // "ajax": {
    //     "url": php3,
    //     "type": "POST"
    // },
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

      }
} );

  
})

function show_edit_cashreceipts(data) {
    var obj = JSON.parse(data)
    console.log(obj)
    var name1 = "تعديل : " + obj[0];

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
