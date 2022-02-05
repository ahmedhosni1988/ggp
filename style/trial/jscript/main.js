//window.onbeforeunload = function(){
//            return 'Are you sure you want to leave?';
//        };


function out_order_finish(id) {
    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=finish_out_order',
        data: {out_id: id}
    });

    req.done(function (msg) {

        alert(msg);
        location.href = 'work.php?action=delivery';
    });

}

function out_order_finish_all(id) {

    var req = $.ajax({
        type: "POST",
        url: 'outorder.php?action=finish_out_order_all',
        data: {out_id: id}
    });

    req.done(function (msg) {

        alert(msg);

    });

}


jQuery(function ($) {
    $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
        _title: function (title) {
            var $title = this.options.title || '&nbsp;'
            if (("title_html" in this.options) && this.options.title_html == true)
                title.html($title);
            else title.text($title);
        }
    }));


    $('.chosen-select').chosen({allow_single_deselect: true});
//resize the chosen on window resize

    $(window)
        .off('resize.chosen')
        .on('resize.chosen', function () {
            $('.chosen-select').each(function () {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        }).trigger('resize.chosen');


});


function run_presch() {
    var req = $.ajax({
        type: "GET",
        url: 'ajax_presched_load.php',
    });

    req.done(function (msg) {
        //alert(msg.length);

        if (msg.length > 1 && msg != " Orders posted.") {

            $("#result_dialoge").html(msg);
            $("#result_dialoge").dialog({
                modal: true,
                width: '450',
                height: '300',
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Contract Orders</h4></div>",
                title_html: true,
                buttons: {
                    Close: function () {
                        $(this).dialog("close");
                    }
                }
            });

        }
    });
}


function addMonths(date, months) {
    date.setMonth(date.getMonth() + months);
    var dd = date.getDate();
    var mm = date.getMonth() + 1; //January is 0!

    var yyyy = date.getFullYear();

    return yyyy + '-' + mm + '-01';
}


function close_my_tab(tab_name, back_index) { 
    console.log($("#tabs").tabs( "option" , "active"  ));
    $("#tabs").find('.ui-tabs-nav li:eq(' + $("#tabs").tabs("option", "active") + ')').remove();
    $("#tabs").tabs("refresh");
    if (back_index != '') $("#" + tab_name).tabs('option', 'active', back_index);


}


function open_new_tab(url, name, tabname) {

    var tabs = $("#" + tabname).tabs();
    var ul = tabs.find("ul");

    $("<li class=\"ui-tabs-active ui-state-active\"><a href='" + url + "'>" + name + "</a></li>").appendTo(ul);


    tabs.tabs("refresh");
    $('#' + tabname).tabs('option', 'active', -1);


}


function open_page(page_id) {

    var req = $.ajax({
        type: "GET",
        url: siteurl + '/index.php?action=get_page&page_id=' + page_id
    });

    req.done(function (msg) {


        $("#page").html(msg);
        $("#page").dialog({
                modal: true,
                width: '800',
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Help Page</h4></div>",
                title_html: true,
                height: '550',
                buttons: {
                    Close: function () {
                        $(this).dialog("close");
                    }
                }
            }
        );

    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}


function show_title(page_id, ele) {

    var req = $.ajax({
        type: "GET",
        url: siteurl + '/index.php?action=get_page_title&page_id=' + page_id
    });

    req.done(function (msg) {

        $(ele).attr("title", msg);

    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}

function check_numeric(val, elename) {

    var x = false;
    var num = $(val).val();

    if (num.match(/^\d+$/)) {
        //valid integer
        x = true;
    } else if (num.match(/^\d+\.\d+$/)) {
        //valid float
        x = true;
    } else if (num == "") {
        x = true;
    } else {
        //not valid number
        x = false;
    }

    if (x == false) $("input[name=" + elename + "]").parent().append("<div class=\"error\">Not Numeric</div>");

}


$(document).ready(function () {

    $('.datepick').each(function () {
        $(this).datepicker({


            dateFormat: 'yy-mm-dd'


        });
    });
});


$(document).ready(function () {
    $("#custom_page").css('min-height', $(window).height() - 30);
    $("#page_content").css('min-height', $(window).height() - 120);
});


function show_client_message_test() {

    var html = $("#co_loginmessage_subject").val() + '<br>' + $("#co_loginmessage_body").val() + '<br><hr>';

    $("#result_dialoge").html(html);
    $("#result_dialoge").dialog({
        modal: true,
        width: '450',
        height: '300',
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
        title_html: true,
        buttons: {
            Close: function () {
                $(this).dialog("close");
            }
        }
    });
}


function show_client_message(message) {

    var html = "";
    for (var i = 0; i < message.length; i++) {
        html = html + message[i].subject + '<br>' + message[i].body + '<br><hr>';
    }


    $("#result_dialoge").html(html);
    $("#result_dialoge").dialog({
        modal: true,
        width: '450',
        height: '300',
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
        title_html: true,
        buttons: {
            Close: function () {
                $(this).dialog("close");
            }
        }
    });

}

function select_all(id) {
    $('#' + id + ' input[type="checkbox"]').each(function () {
        this.checked = true;
    });
}

function deselect(id) {
    $('#' + id + ' input[type="checkbox"]').each(function () {
        this.checked = false;
    });
}


function getDistance() {

    //alert();
    $('select[name="service_id"] option:selected').val();

    var service_id = $('select[name="service_id"] option:selected').val();


    if (($("#from_address").val() != '' || $("#from_pcode").val() != '') && ($("#to_address").val() != '' || $("#to_pcode").val() != '')) {
        var req = $.ajax({
            type: "POST",
            url: 'index.php?action=get_distance',
            data: {
                from_add: $("#from_address").val() + ' ' + $("#from_pcode").val(),
                to_add: $("#to_address").val() + ' ' + $("#to_pcode").val(),
                service_id: service_id
            }
        });

        req.done(function (msg) {
            //alert(msg);
            if (msg != '') $("#meters").attr("value", msg);

        });

        req.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
    }
}