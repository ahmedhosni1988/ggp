function copy_price() {

    var data = $('#copyprice_account').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#copyprice_account').attr('action'),
        data: data
    });

    req.done(function (msg) {

        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");

                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}


function is_numeric(input) {
    return typeof(input) == 'number';
}


function show_edit_account2(account_id, name) {
    var url = "accounts.php?action=mange_add_account&account_id=" + account_id;
    var name1 = "تعديل الحساب : " + name;
    $("#tabs").tabs("add", url, name1, ($("#tabs").tabs("length")));
}

function add_accountss(account_id) {

   var y =  validate_forms('add_account_details_' + account_id);

   if(y != true) return;
    
    var data = $('#add_account_details_' + account_id).serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#add_account_details_' + account_id).attr('action'),
        data: data
    });

    req.done(function (msg) {
     
        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>رسالة</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {


                    if (account_id == '') {
                        $('#add_account_details_' + account_id).trigger('reset');
                        //show_edit_account2(msg,"new client");
                    }

                    $(this).dialog("close");
                    location.reload(); 


                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function edit_invoice_account(account_id) {

    var data = $('#edit_invoice_details_' + account_id).serialize();


    var req = $.ajax({
        type: "POST",
        url: $('#edit_invoice_details_' + account_id).attr('action'),
        data: data
    });

    req.done(function (msg) {

        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {


                    $(this).dialog("close");


                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function edit_option_account(account_id) {

    var data = $('#edit_option_account_' + account_id).serialize();
//alert(data);

    var req = $.ajax({
        type: "POST",
        url: $('#edit_option_account_' + account_id).attr('action'),
        data: data
    });

    req.done(function (msg) {

        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");
                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}

function edit_contact_details(account_id) {


    var data = $('#edit_contact_details_' + account_id).serialize();


    var req = $.ajax({
        type: "POST",
        url: $('#edit_contact_details_' + account_id).attr('action'),
        data: data
    });

    req.done(function (msg) {

        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> الرسالة</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {


                    $(this).dialog("close");


                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function edit_finical_details(account_id) {


    var data = $('#edit_finical_details_' + account_id).serialize();


    var req = $.ajax({
        type: "POST",
        url: $('#edit_finical_details_' + account_id).attr('action'),
        data: data
    });

    req.done(function (msg) {

        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {


                    $(this).dialog("close");


                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function edit_pricing_details(account_id) {


    var data = $('#edit_pricing_details_' + account_id).serialize();


    var req = $.ajax({
        type: "POST",
        url: $('#edit_pricing_details_' + account_id).attr('action'),
        data: data
    });

    req.done(function (msg) {

        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {

                    $("#mange_add_" + account_id).tabs("load", $("#mange_add_" + account_id).tabs("option", "selected"));
                    $(this).dialog("close");


                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function close_account(id) {
    close_my_tab('tabs', '')

}


function edit_accountss() {
    var data = $('#edit_account').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#edit_account').attr('action'),
        data: data
    });

    req.done(function (msg) {
        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");
                    $("#tabs").tabs("remove", $("#tabs").tabs("option", "selected"));
                    $("#tabs").tabs("select", 0);
                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


$("#add_client_user").ready(function () {
    $(function () {
        $('#add_client_user #submit').click(function () {

            if (validate_forms('add_client_user')) {


                var data = $('#add_client_user').serialize();

                var req = $.ajax({
                    type: "POST",
                    url: $('#add_client_user').attr('action'),
                    data: data
                });

                req.done(function (msg) {

                    $("#add_result").html(msg);
                    $("#add_result").dialog({
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
                        title_html: true,
                        buttons: {
                            Ok: function () {
                                $(this).dialog("close");
                                // $(".tabs_man" ).tabs( "refresh" );
                                $('#tabs_man').tabs('option', 'active', 0);
                                //("#tabs_man").tabs( "load" , -1  );

                            }
                        }
                    });


                });
                req.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });

            }

            return false;
            alert('Handler for .submit() called.');

        });

    });
});


$("#edit_client_user").ready(function () {
    $(function () {
        $('#edit_client_user #submit').click(function () {
            alert("ahmed");
            if (validate_forms('edit_client_user')) {

                var data = $('#edit_client_user').serialize();

                var req = $.ajax({
                    type: "POST",
                    url: $('#edit_client_user').attr('action'),
                    data: data
                });

                req.done(function (msg) {
                    alert(msg);
                    $("#result_dialoge").html(msg);
                    $("#result_dialoge").dialog({
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
                        title_html: true,
                        buttons: {
                            Ok: function () {
                                $(this).dialog("close");
                                $(".tabs_man").find('.ui-tabs-nav li:eq(' + $(".tabs_man").tabs("option", "active") + ')').remove();
                                $(".tabs_man").tabs("refresh");
                                $(".tabs_man").tabs("load", 0);
                            }
                        }
                    });


                });
                req.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }


            return false;
            alert('Handler for .submit() called.');

        });

    });
});


function assig_accountss() {
    var data = $('#assign_account').serialize();

    var account = $("#account_name").val();

    if (account.indexOf("new_client") != -1) {

        $("#assign_acc").html("you should Change Account Id");
        $("#assign_acc").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");


                }
            }
        });


    } else {

        var req = $.ajax({
            type: "POST",
            url: $('#assign_account').attr('action'),
            data: data
        });

        req.done(function (msg) {
            $("#assign_acc").html(msg);
            $("#assign_acc").dialog({
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
                title_html: true,
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                        close_my_tab('tabs', '');

                    }
                }
            });


        });
        req.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

    }

}


$(document).ready(function () {


    $("#acct_name").autocomplete({

        source: function (request, response) {

            $.ajax({
                url: "index.php?action=search_add",
                dataType: "jsonp",
                data: {
                    n: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 1,
        select: function (event, ui) {
            $("#acct_name").val(ui.item.label);

        },
        open: function () {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }


    });


    $("#acct_name2").autocomplete({

        source: function (request, response) {

            $.ajax({
                url: "index.php?action=search_add",
                dataType: "jsonp",
                data: {
                    n: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 1,
        select: function (event, ui) {
            $("#acct_name2").val(ui.item.label);

        },
        open: function () {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }


    });

});

function log(message) {
    $("<div>").text(message).prependTo("#log");
    $("#log").scrollTop(0);
}

function search_account(name, number, id) {

    //alert(id);
    var req = $.ajax({
        type: "GET",
        dataType: "json",
        url: 'index.php?action=search_add',
        data: {n: name, num: number}
    });

    req.done(function (msg) {


//				if (msg.length > 0){
//					
//					var x = $(id).position();
//	
//	$(".jsonSuggestResults").remove();
//
//	var div  = $("<div >").insertAfter($(id));
//	
//	
//	
//	var list = $("<div >").addClass("jsonSuggestResults").appendTo(div);
//	list.css("left",x.left);
//	list.css("top",(x.top+20));
//	list.css("z-index","1000");
//	list.css("width",$(id).width());
//	
//
//
//
//
//
//				for (var j = 0; j < msg.length; j++){
//				
//			if(j%2 ==0 ){
//	           var tex = $("<div >").addClass("resultItem").addClass("even").appendTo(list);
//			   tex.attr('onclick','set_clients(\''+ msg[j].account_name +'\',\'#acct_name\')');
//			   tex.attr('onmouseover','set_class(this);');
//	           var val = $("<p ></p>").addClass("text").appendTo(tex);
//	           val.html(msg[j].account_name + ' | ' + msg[j].account_company);
//			}else{
//			   var tex = $("<div >").addClass("resultItem").addClass("odd").appendTo(list);
//			   tex.attr('onclick','set_clients(\''+ msg[j].account_name +'\',\'#acct_name\')');
//			   tex.attr('onmouseover','set_class(this);');
//	           var val = $("<p ></p>").addClass("text").appendTo(tex);
//	           val.html(msg[j].account_name + ' | ' + msg[j].account_company);
//				}
//	
//	
//				}
//				
//				
//				
//				}
//					else{
//						$(".jsonSuggestResults").remove();
//						}
//			
        // $("#client_addr").html(msg);


    });


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function set_clients(id, mm) {
    $(".jsonSuggestResults").remove();
    $(mm).attr("value", id);
    set_account_id(id);
}


function set_account_id(id) {
    $("#acct_id").attr("value", id);
}


function submit_chooseclient(id) {


    if (id != "") {
        //alert(id);
        window.location = "index.php?action=addorder&acctno=" + id;

    } else {
        alert("Please Select client");
    }
    return false;
}


function add_pickup_rows(account_id) {

    var req = $.ajax({
        type: "POST",
        url: "accounts.php?action=get_vec",
        dataType: 'json'
    });
    var row = "";
    req.done(function (msg) {

        var rowCount = $("#pickup_table_" + account_id + " tr").length;
        rowCount = rowCount + 1;
        row += "<tr><td><input type=\"text\" name=\"nc__pickup__zone__" + (rowCount) + "\" size=\"8\" value=\"\"/></td>";

        for (var i = 0; i < msg.length; i++) {
            row += "<td><input type=\"text\" name=\"nc__pickup__" + msg[i].id + "__" + (rowCount) + "\" size=\"8\" value=\"\"/></td>";
        }
        row += "</tr>";
        $("#pickup_table_" + account_id + " tr:last").prev().after(row);

    });
}


function add_delivery_rows(account_id) {

    var req = $.ajax({
        type: "POST",
        url: "accounts.php?action=get_ser",
        dataType: 'json'
    });
    var row = "";
    req.done(function (msg) {
        var rowCount = $("#delivery_table_" + account_id + " tr").length;
        rowCount = rowCount + 1;

        row += "<tr><td><input type=\"text\" name=\"nc__delivery__zonefrom__" + rowCount + "\" size=\"8\" value=\"\"/></td><td><input type=\"text\" name=\"nc__delivery__zoneto__" + rowCount + "\" size=\"8\" value=\"\"/></td>";

        for (var i = 0; i < msg.length; i++) {
            row += "<td><input type=\"text\" name=\"nc__delivery__" + msg[i].service_id + "__" + rowCount + "\" size=\"5\" value=\"\"/></td>";
        }

        row += "</tr>";

        $("#delivery_table_" + account_id + " tr:last").prev().after(row);

    });

}

$("#search_account_value").ready(function () {

    $("#search_account_value").on('change input', function () {
//	alert($('#search_account').serialize());

        if ($("#search_account_value").val().length > 2) {

            var req = $.ajax({
                type: "POST",
                url: "accounts.php?action=search",
                data: $('#search_account').serialize()
            });

            req.done(function (msg) {
                //alert(msg);
                $("#search_result").html(msg);
            });


        }

    });
});