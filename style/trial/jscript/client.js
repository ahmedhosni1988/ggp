function edit_accounts(account_id) {

    var data = $('#companydetails').serialize();


    var req = $.ajax({
        type: "POST",
        url: $('#companydetails').attr('action'),
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
                    $(".tabs_man").tabs("select", 0);
                    $(this).dialog("close");
                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function add_users() {

    var data = $('#add_user').serialize();


    var req = $.ajax({
        type: "POST",
        url: $('#add_user').attr('action'),
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
                    // $('#tabs_man').tabs('option', 'active',0 );

                    $(this).dialog("close");
                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function edit_users() {

    var data = $('#edit_user').serialize();


    var req = $.ajax({
        type: "POST",
        url: $('#edit_user').attr('action'),
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

                    close_my_tab('tabs_man', 0);


                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function edit_my_setting() {

    var data = $('#user_setting').serialize();


    var req = $.ajax({
        type: "POST",
        url: $('#user_setting').attr('action'),
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
                    $(".tabs_man").tabs("remove", $(".tabs_man").tabs("option", "selected"));

                    $(".tabs_man").tabs("select", 0);


                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function delete_users(id, name) {
    $("#res").html("Are you sure to delete  user " + name + "?");
    $("#res").dialog({
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
        title_html: true,
        buttons: {
            Ok: function () {
                var req = $.ajax({
                    type: "GET",
                    url: "client_admin.php?action=deluser",
                    data: {userid: id}
                });
                req.done(function (msg) {
                    $("#res").dialog("close");
                    $("#tabs_man").tabs("load", 0);

                });
            },
            Cancel: function () {
                $(this).dialog("close");

            }
        }
    });
}

function show_edit_user(user_id, name) {
    var url = "client_admin.php?action=edituser&userid=" + user_id;
    var name1 = "Edit User : " + name;
    open_new_tab(url, name1, "tabs_man");
    //    $(".tabs_man").tabs( "add" , url , name1, ($(".tabs_man").tabs( "length" )) );

}


function search_invoice() {

    var data = $('#invoice_search').serialize();


    var req = $.ajax({
        type: "POST",
        url: $('#invoice_search').attr('action'),
        data: data
    });

    req.done(function (msg) {
//							alert(msg);
        $("#result").html(msg);
//	         $( "#result" ).dialog({
//			modal: true,
//			buttons: {
//				Ok: function() {
//										$(".tabs_man").tabs("select",0 );
//
//							$( this ).dialog( "close" );
//				}
//			}
//		});


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}