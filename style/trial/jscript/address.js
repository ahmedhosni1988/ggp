function show_address_to(type, startp) {
    $("#addressbook").empty();
    var x = $("#addressbook").css('display');

    var div = $("#addressbook");
    if (x == "none") {
        $("#addressbook").show("slow");
        $('#loading').fadeIn();

        var request = $.ajax({
            type: 'GET',
            dataType: 'json',
            url: 'index.php',
            data: {action: 'address_ajax', start: startp},

        });

        request.done(function (msg) {

            var list = "";
            list = $('<ul>');
            for (var x = 0; x < msg.length; x++) {
                list.append('<li onclick="add_address(\'' + type + '\',\'' + msg[x].contact_name + '\',\'' + msg[x].address.replace(/(\r\n|\n|\r)/gm, "") + '\',\'' + msg[x].pcode + '\',\'' + msg[x].phone + '\')">' + msg[x].contact_name + '  |  ' + msg[x].address + '</li>');

            }

            div.append(list);
            $('#loading').hide();

        });

        request.fail(function (jqXHR, textStatus) {
            alert("Request failed: Error in Add Please Check Javascript");
            $("#addressbook").hide("slow");

        });


    } else {
        $("#addressbook").hide("slow");

    }


}


function addaddr(row_id, ty) {

    if (row_id != 0 && row_id != "") {
        var req = $.ajax({
            type: "GET",
            dataType: 'json',
            url: 'index.php?action=get_address',
            data: {id: row_id}
        });
        req.done(function (msg) {


            $('#' + ty + '_name').val(msg.name);
            $('#' + ty + '_address').val(msg.addr);
            $('#' + ty + '_pcode').val(msg.postalcode);
            $('#' + ty + '_phone').val(msg.phone);
            $('#' + ty + '_contact').val(msg.attn);
            $('#' + ty + '_altphone').val(msg.alt_phone);


            if (ty == "from") {
                $('#comment').append(msg.comments);
                $('#tracking_sender').val(msg.email);
            } else {
                $('#description').append(msg.comments);
                //alert(msg.email);
                $('#tracking_receiver').val(msg.email);
            }

            getDistance();
            $("#address_dialoge").dialog("close");


        });
    }

    //alert();

//	var type=$("#ty").attr("value");
//	alert(type)
//	$("#address").dialog( "close" );
//	$('#'+type+'_name').val(name);
//	$('#'+type+'_address').html(address);
//	$('#'+type+'_pcode').val(pzip);
//	$('#'+type+'_phone').val(phone);
//	
    //$("#address").hide("slow");

}


function show_addrbook(ty, account, start, sort_valu, sort_type) {

    if ($("#account_id").val() != "") {
        account = $("#account_id").val();

    }

    var req = $.ajax({
        type: "GET",
        url: 'index.php?action=address',
        data: {id: account, ty: ty}
    });

    req.done(function (msg) {

        $("#address_dialoge").html(msg);

        $("#address_dialoge").dialog({
            modal: true,
            width: 800,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Address Book</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='ace-icon glyphicon glyphicon-time bigger-110'></i>&nbsp; Ok",
                    "class": "btn btn-danger btn-xs",
                    click: function () {


                        var x = $('input[name=emb]:checked', '#add_form').val();

                        if (x != 0 && x != "") {
                            var req = $.ajax({
                                type: "GET",
                                dataType: 'json',
                                url: 'index.php?action=get_address',
                                data: {id: x}
                            });
                            req.done(function (msg) {


                                $('#' + ty + '_name').val(msg.name);
                                $('#' + ty + '_address').val(msg.addr);
                                $('#' + ty + '_pcode').val(msg.postalcode);
                                $('#' + ty + '_phone').val(msg.phone);
                                $('#' + ty + '_contact').val(msg.attn);
                                getDistance();
                                $("#address_dialoge").dialog("close");
                                //	$( "#address_dialoge" ).dialog( "destroy" );


                            });
                        }

                    }
                },
                {
                    html: "<i class='ace-icon glyphicon glyphicon-time bigger-110'></i>&nbsp; Add New",
                    "class": "btn btn-danger btn-xs",
                    click: function () {

                        var req = $.ajax({
                            type: "GET",
                            url: 'index.php?action=address_edit',
                            data: {id: '', account: account}
                        });

                        req.done(function (msg) {


                            $("#address_dialoge_option").html(msg);

                            ///////////////

                            $("#address_dialoge_option").dialog({
                                autoOpen: false,
                                width: 400,
                                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Add Address</h4></div>",
                                title_html: true,
                                buttons:
                                    [
                                        {
                                            html: "<i class='ace-icon glyphicon glyphicon-time bigger-110'></i>&nbsp; Save",
                                            "class": "btn btn-danger btn-xs",
                                            click: function () {

                                                $("#edit_addre").submit();
                                                $(this).dialog("close");
                                                // addr_paging(start,account,sort_valu,sort_type);
                                                show_addrbook(ty, account, start, sort_valu, sort_type)

                                            }
                                        }, {
                                        html: "<i class='ace-icon glyphicon glyphicon-time bigger-110'></i>&nbsp; Close",
                                        "class": "btn btn-danger btn-xs",
                                        click: function () {
                                            $(this).dialog("close");

                                        }

                                    }
                                    ]
                            });

                            $("#address_dialoge_option").dialog('open');


                            //////////////


                        });

                    }
                }

            ]

        });


    });
}

function addr_paging(start, account, sort_valu, sort_type, ty) {


    var req = $.ajax({
        type: "GET",
        url: 'index.php?action=address',
        data: {id: account, start: start, sort_valu: sort_valu, sort_type: sort_type, ajax: "ajax", ty: ty}
    });

    req.done(function (msg) {
        //alert(msg);
        $("#client_addr").html(msg);


    });
}

function show_address_list(text, id, account) {
    //alert(account);
    if (text != "") {
        var req = $.ajax({
            type: "GET",
            dataType: "json",
            url: 'index.php?action=Search_address',
            data: {q: text, acc: account}
        });

        req.done(function (msg) {


            if (msg.length > 0) {

                var x = $(id).position();

                $(".jsonSuggestResults").remove();

                var div = $("<div >").insertAfter($(id));


                var list = $("<div >").addClass("jsonSuggestResults").appendTo(div);
                list.css("left", x.left);
                list.css("top", (x.top + 20));
                list.css("z-index", "1000");
                list.css("width", $(id).width());


                for (var j = 0; j < msg.length; j++) {

                    if (j % 2 == 0) {
                        var tex = $("<div >").addClass("resultItem").addClass("even").appendTo(list);
                        tex.attr('onclick', 'set_addresss(\'' + msg[j].name + '\',\'' + id + '\')');
                        tex.attr('onmouseover', 'set_class(this);');
                        var val = $("<p ></p>").addClass("text").appendTo(tex);
                        val.html(msg[j].name);
                    } else {
                        var tex = $("<div >").addClass("resultItem").addClass("odd").appendTo(list);
                        tex.attr('onclick', 'set_addresss(\'' + msg[j].name + '\',\'' + id + '\')');
                        tex.attr('onmouseover', 'set_class(this);');
                        var val = $("<p ></p>").addClass("text").appendTo(tex);
                        val.html(msg[j].name);
                    }


                }


            }
            else {
                $(".jsonSuggestResults").remove();
            }

            // $("#client_addr").html(msg);


        });

    }


}

function set_class(id) {
    //$(".jsonSuggestResults").removeClass('hover');
    $(".resultItem").removeClass("hover");
    $(id).addClass("hover");


}


function set_addresss(id, mm) {
    $(".jsonSuggestResults").remove();

    $(mm).val(id);
}


$('#beginwith').on("keypress", function (e) {
    /* ENTER PRESSED*/
    if (e.keyCode == 13) {
        /* FOCUS ELEMENT */

        return false;
    }
});

$("#add_form").ready(function () {


    $('#add_form').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });


});


function search_address(type, account) {


    if ($('#beginwith').val() != "") {

        var req = $.ajax({
            type: "GET",
            url: 'index.php?action=address_search',
            data: {account_id: account, start: 0, sear: $('#beginwith').val(), ty: type}
        });

        req.done(function (msg) {
            //alert(msg);
            $("#client_addr").html(msg);


        });


    } else {

        alert("Please Write name");
    }


}


function edit_addresss(id, start, account, sort_valu, sort_type) {

    var req = $.ajax({
        type: "GET",
        url: 'index.php?action=address_edit',
        data: {id: id}
    });

    req.done(function (msg) {
        //	alert(msg);
        // $("#client_addr").html(msg);

        $("#address_dialoge_option").html(msg);
        $("#address_dialoge_option").dialog({
            autoOpen: false,
            width: 400,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Edit Address</h4></div>",
            title_html: true,
            buttons: {

                YES: function () {

                    //$("#edit_addre").submit();
                    edit_add();

                    addr_paging(start, account, sort_valu, sort_type);

                    $("#address_dialoge_option").dialog("close");
                },
                NO: function () {

                    $(this).dialog("close");
                }


            }


        });


        $("#address_dialoge_option").dialog('open');


    });


}


function edit_add() {


    var data = $("#edit_addre").serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#edit_addre').attr('action'),
        data: data
    });

    req.done(function (msg) {

        alert(msg);

    });


    return false;

}


function delete_address1(id, name, start, account, sort_valu, sort_type) {


    $("#address_dialoge_option").html("Are You Sure To Delete " + name + " Address? ");
    $("#address_dialoge_option").dialog({
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>Delete Address</h4></div>",
        title_html: true,

        buttons: {

            YES: function () {

                var req = $.ajax({
                    type: "GET",
                    url: 'index.php?action=address_delete',
                    data: {id: id}
                });

                req.done(function (msg) {
                    //alert(msg);
                    // $("#client_addr").html(msg);
                    $("#tabs").tabs("load", $("#tabs").tabs("option", "active"));

                });


                $(this).dialog("close");
            },
            NO: function () {

                $(this).dialog("close");
            }


        }


    });


}


function delete_address(id, name, start, account, sort_valu, sort_type) {


    $("#address_dialoge_option").html("Are You Sure To Delete " + name + " Address? ");
    $("#address_dialoge_option").dialog({
        autoOpen: false,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>Delete Address</h4></div>",
        title_html: true,

        buttons: {

            YES: function () {

                var req = $.ajax({
                    type: "GET",
                    url: 'index.php?action=address_delete',
                    data: {id: id}
                });

                req.done(function (msg) {
                    //alert(msg);
                    // $("#client_addr").html(msg);
                    addr_paging(start, account, sort_valu, sort_type);

                });


                $("#address_dialoge_option").dialog("close");
            },
            NO: function () {

                $(this).dialog("close");
            }


        }


    });
    $("#address_dialoge_option").dialog('open');


}


function switchcontact() {
    var ty = "from";

    var from_name = $('#' + ty + '_name').val();
    var from_address = $('#' + ty + '_address').val();
    var from_pcode = $('#' + ty + '_pcode').val();
    var from_phone = $('#' + ty + '_phone').val();
    var from_contact = $('#' + ty + '_contact').val();

    ty = "to";
    var to_name = $('#' + ty + '_name').val();
    var to_address = $('#' + ty + '_address').val();
    var to_pcode = $('#' + ty + '_pcode').val();
    var to_phone = $('#' + ty + '_phone').val();
    var to_contact = $('#' + ty + '_contact').val();


    $('#' + ty + '_name').val(from_name);
    $('#' + ty + '_address').val(from_address);
    $('#' + ty + '_pcode').val(from_pcode);
    $('#' + ty + '_phone').val(from_phone);
    $('#' + ty + '_contact').val(from_contact);

    ty = "from";
    $('#' + ty + '_name').val(to_name);
    $('#' + ty + '_address').val(to_address);
    $('#' + ty + '_pcode').val(to_pcode);
    $('#' + ty + '_phone').val(to_phone);
    $('#' + ty + '_contact').val(to_contact);


}


function add_address(id) {

    var data = $("#address_" + id).serialize();

    var req = $.ajax({
        type: "post",
        url: $("#address_" + id).attr('action'),
        data: data
    });

    req.done(function (msg) {

        $("#result").html(msg);
        $("#result").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {

                    $(this).dialog("close");
                    if (id != "") {

                        close_my_tab("tabs", '');
                    } else {

                        $("#tabs").tabs("select", 0);

                    }
                }
            }
        });
        //koko start
        clear_inputs();
        //koko end

    });

}

function full_search_address() {

    var data = $("#search_address").serialize();

    var url = $("#search_address").attr('action') + "&" + data;
//	alert(url);
    var name1 = "Search Result";
    open_new_tab(url, name1, "tabs")


//	 var req = $.ajax({
//			type: "post",
//			url: $("#search_address").attr('action'),
//			data: data
//			});
//	 
//	 req.done(function( msg ) {
//					   
//		
//		$("#search_result").html(msg);
//			 
//					   });

}

function show_edit_address(id, name) {
    var url = "address.php?action=address&id=" + id;
    var name1 = "Edit Address : " + name;
    //$("#tabs").tabs( "add" , url , name1 , ($("#tabs").tabs( "length" )) );
    open_new_tab(url, name1, "tabs")

}

//koko start	
function clear_inputs() {
    $("input:text,textarea").val("");
}

//koko end
