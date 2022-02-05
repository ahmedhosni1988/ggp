function revise_search() {

    var client=document.getElementById('client').value;
    var from=document.getElementById('revise_date_from').value;
    var to=document.getElementById('revise_date_to').value;
    // open_new_tab('accounting.php?action=revise_account'+ '&client='+client+'&from='+from+'&to='+to , "Search Result : " + 1, "revise");


    var req = $.ajax({
        type: "POST",
        url:'accounting.php?action=revise_account',
        data: {client:client,from:from,to:to}
    });


    req.done(function (msg) {
        console.log(msg);
        document.getElementById('showResult').innerHTML=msg;
        console.log(msg);
    })
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}
function prepare_invoices() {

    var data = $('#prepare_invoice').serialize();

    //alert(data);
    var req = $.ajax({
        type: "POST",
        url: $('#prepare_invoice').attr('action'),
        data: data
    });

    req.done(function(msg) {
        $("#result_dialoge").html(msg);

        $("#result_dialoge").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function() {
                    $(this).dialog("close");
                }
            }
        });


    });

}


function edit_invoice(id, tab) {

    var url = "accounting.php?action=edit_invoice&invoice_id=" + id;
    var name1 = "Edit Invoice : " + id;

    open_new_tab(url, name1, tab);
}

var tt = 0;

function add_rows(t) {
    //alert(t);
    if (tt == 0) tt = t;
    else tt++;
    var rowCount = $('#inv_dtls tr').length;
    rowCount = rowCount - 1;
    $("#inv_dtls tr:last").before("<tr><td>" + tt + "</td><td><input type=\"text\" name=\"items[]\" value=\"\" /></td><td><input type=\"text\" name=\"items[]\" value=\"\" /></td><td><input type=\"text\" name=\"items[]\" value=\"\" size=\"5\"/></td><td><input type=\"text\" name=\"items[]\" value=\"\"  size=\"5\"/></td></tr>");

    $("#showlines_count").attr('value', rowCount);


}


function process_invoice(type) {


    var data = $('#edit_invoice').serialize();

    data = data + "&type=" + type

    var req = $.ajax({
        type: "POST",
        url: $('#edit_invoice').attr('action'),
        data: data
    });

    req.done(function(msg) {

        window.location.href = window.location.href + "&e=" + msg;


    });
    req.fail(function(jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}

var xx = 0;

function invoice_history() {

    open_new_tab($('#search_invoices').attr('action') + '&' + $('#search_invoices').serialize(), "Search Result : " + (xx + 1), "tabs_history");
    xx++;

}


function add_cashreceipts(form_id) {

$(".addeditcash").attr("disabled", true);

    var data = $('#' + form_id).serialize();
    //console.log(data)
    //alert($('#open_invoice_form').attr('action'));

    //open_new_tab($('#open_invoice_form').attr('action')+'&'+$('#open_invoice_form').serialize(),"Search Result : "+$("#open_invoice").tabs( "length" ),"open_invoice");

    var req = $.ajax({
        type: "POST",
        url: $('#' + form_id).attr('action'),
        data: data
    });


    req.done(function(msg) {

       // alert(msg);
        
          //  var obj = JSON.parse(msg)
                //console.log(obj)

            $("#result_dialoge").html(msg);
            title = "<div class='widget-header' ><h4 class='smaller'>طباعة الوصل</h4></div>";
            btns = [{
                text: "طباعة",
                click: function(params) {
                    var divToPrint = document.getElementById('result_dialoge');
                    var newWin = window.open('', 'Print-Window');
                    newWin.document.open();
                    newWin.document.write('<div">' + divToPrint.innerHTML + '</div>');
                    newWin.document.close();
                    newWin.print()
                    setTimeout(function() { newWin.close(); }, 10);
                    // $("#print_cash").print();
                }
            }, {
                text: "اغلاق",
                click: function() {
                    $(this).dialog("close");
                    location.reload(true)
                        //window.location = window.location.href;
                }
            }];


        

        $("#result_dialoge").dialog({
            modal: true,
            title: title,
            //title: "<div class='widget-header' ><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> وصل رقم :  " + obj['invoiceno'] + " ,  تابع االعميل :" + obj['account_company'] + "</h4></div>",
            title_html: true,
            width: '700',
            buttons: btns

        });


    });
    req.fail(function(jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}

function print_cash(id){
   
    
    var req = $.ajax({
        type: "POST",
        url: 'accounting.php?action=cashreceipts_print',
        data: {id}
    });


    req.done(function(msg) {


        $("#result_dialoge").html(msg);
        title = "<div class='widget-header' ><h4 class='smaller'>طباعة الوصل</h4></div>";
        btns = [{
            text: "طباعة",
            click: function(params) {
                var divToPrint = document.getElementById('result_dialoge');
                var newWin = window.open('', 'Print-Window');
                newWin.document.open();
                newWin.document.write('<div">' + divToPrint.innerHTML + '</div>');
                newWin.document.close();
                newWin.print()
                setTimeout(function() { newWin.close(); }, 10);
                // $("#print_cash").print();
            }
        }, {
            text: "اغلاق",
            click: function() {
                $(this).dialog("close");
              //  location.reload(true)
                    //window.location = window.location.href;
            }
        }];


    

    $("#result_dialoge").dialog({
        modal: true,
        title: title,
        //title: "<div class='widget-header' ><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> وصل رقم :  " + obj['invoiceno'] + " ,  تابع االعميل :" + obj['account_company'] + "</h4></div>",
        title_html: true,
        width: '700',
        buttons: btns

    });


});

}

function change_price_version(account_id, order_id, version_id) {
    console.log(account_id, order_id, version_id)

    var req = $.ajax({
        type: "GET",
        url: 'accounts.php?action=price_details&account_id=' + account_id + '&view=1',
        // &version_id='+version_id
    });
    req.done(function(msg) {

        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            modal: true,
            title: `<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>
     ` + (account_id == 0 ? 'تغير اسعار المصنع' : 'تغير السعار العميل') + `</h4></div>`,
            title_html: true,
            width: '1200',
            height: '800',
            buttons: {
                Ok: function() {


                    console.log($('#open_price').children("option:selected").val())
                    var V_price_id = $('#open_price').children("option:selected").val();
                    var data = {}
                    data.order_id = order_id;
                    debugger;
                    if (account_id == 0) {
                        data.quary = 'UPDATE  `orders` SET `price_version_system_id` = ' + V_price_id + ' WHERE  `order_id` =' + order_id;
                    } else {
                        data.quary = 'UPDATE  `orders` SET `price_version_account_id` = ' + V_price_id + ' WHERE  `order_id` =' + order_id;
                    }
                    data.account_id = account_id;

                    var req2 = $.ajax({
                        type: "POST",
                        url: 'accounts.php?action=change_price_version',
                        data: data
                    });
                    req2.done((msg2) => {
                        console.log('msg2', msg2)
                        if (msg2 !== 'Array') {
                            $(this).dialog("close");
                            //  location.reload();
                        }
                    })
                },
                Close: function() {
                    $(this).dialog("close");

                }
            }
        });

    });



}

function open_invoices() {


    var data = $('#open_invoice_form').serialize();

    //alert($('#open_invoice_form').attr('action'));

    //open_new_tab($('#open_invoice_form').attr('action')+'&'+$('#open_invoice_form').serialize(),"Search Result : "+$("#open_invoice").tabs( "length" ),"open_invoice");

    var req = $.ajax({
        type: "POST",
        url: $('#open_invoice_form').attr('action'),
        data: data
    });


    req.done(function(msg) {});
    req.fail(function(jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}


function cancel_invoices() {
    var val = "";

    $('#invoices input[type="checkbox"]:checked').each(function() {
        val += $(this).val() + ",";
    });

    if (val != "") {
        var req = $.ajax({
            type: "POST",
            url: 'accounting.php?action=cancel_invoices',
            data: { ids: val }
        });


        req.done(function(msg) {
            //alert(msg);
            $("#page").html(msg);
            $("#page").dialog({
                modal: true,
                width: '400',
                height: '200',
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
                title_html: true,
                buttons: {
                    Ok: function() {
                        $(this).dialog("close");
                        $("#process_invoice").tabs("load", $("#process_invoice").tabs("option", "selected"));


                    }
                }
            });

        });
    }

}


function resend_emails() {
    var val = "";

    $('#invoices input[type="checkbox"]:checked').each(function() {
        val += $(this).val() + ",";
    });

    if (val != "") {

        var req = $.ajax({
            type: "POST",
            url: 'accounting.php?action=resend_invoices',
            data: { ids: val }
        });


        req.done(function(msg) {
            //alert(msg);
            $("#result_dialoge").html(msg);
            $("#result_dialoge").dialog({
                modal: true,
                width: '400',
                height: '200',
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
                title_html: true,
                buttons: {
                    Ok: function() {
                        $(this).dialog("close");


                    }
                }
            });

        });
    }
}
function openModlaToreviewInvoice(invoice_id)
{
    var button = [{
        id: 'btn13',
        text: 'حفظ الخصم',

        click: function () {
            var req = $.ajax({
                type: "POST",
                url: 'accounting.php?action=discount_req',
                data: {amount: document.getElementById('discountEntered').value, invoiceid: invoice_id}
            });
            req.done(function(msg) {
                alert(msg)

                var button = [{
                    id:'btn11',
                    text: 'اغلاق',

                    click: function() {
                        $(this).dialog("close");
                    }
                },
                    {
                        text: 'الخصم',
                        id:'btn12',
                        style:'float:left;',
                        click: function() {
                            openModlaToreviewInvoice(id);
                        }
                    }
                ];
                var req = $.ajax({
                    type: "GET",
                    url: 'accounting.php?action=show_invoice',
                    contentType: "application/json; charset=utf-8",
                    data: { invoiceid: invoice_id }
                });
                req.done(function(msg) {
                    //alert(msg);
                    $("#page").html(msg);
                    $("#page").dialog({
                        modal: true,
                        width: '850px',
                        height: '600',
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> فاتورة رقم " + invoice_id + "</h4></div>",
                        title_html: true,
                        buttons: button
                    });
                });
                $(this).dialog("close");
            });

        }
    }];

    $("#review_invo").dialog({
        modal: true,
        width: '400px',
        height: '200',
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> فاتورة رقم </h4></div>",
        title_html: true,
        buttons: button
    });
}

function show_invoice(id, reviewed) {

    var button = [{
        id:'btn11',
        text: 'اغلاق',

        click: function() {
            $(this).dialog("close");
        }
    },
        {
            text: 'الخصم',
            id:'btn12',
            style:'float:left;',
            click: function() {
                openModlaToreviewInvoice(id);
            }
        }
    ];

    if (reviewed == 0) {
        button.push({
            text: "تم المراجعه ",
            click: function() {
                var req = $.ajax({
                    type: "POST",
                    url: '../invoice/invoice.php',
                    data: { order_id: id }
                });
                req.done(function(msg) {
                    $('#' + id).remove();
                    show_invoice(id)

                });
            },
        });
    }
    var req = $.ajax({
        type: "GET",
        url: 'accounting.php?action=show_invoice',
        contentType: "application/json; charset=utf-8",
        data: { invoiceid: id }
    });
    req.done(function(msg) {
        //alert(msg);
        $("#page").html(msg);
        $("#page").dialog({
            modal: true,
            width: '850px',
            height: '600',
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> فاتورة رقم " + id + "</h4></div>",
            title_html: true,
            buttons: button
        });
    });
}

function invoice_search() {
    var input, filter, table, tr, td, i, txtValue, date, name, order;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("invoices");
    tr = table.getElementsByTagName("tr");
    th = table.getElementsByTagName("th");

    var arr = [1, 2, 3];
    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = "none";
        for (var j = 0; j < 3; j++) {
            td = tr[i].getElementsByTagName("td")[arr[j]];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }



    }
}