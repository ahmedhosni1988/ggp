var rowheight = 0;

var service_array = null;


function invertColor(hexTripletColor) {
    var color = hexTripletColor;
    color = color.substring(1);           // remove #
    color = parseInt(color, 16);          // convert to integer
    color = 0xFFFFFF ^ color;             // invert three bytes
    color = color.toString(16);           // convert to hex
    color = ("000000" + color).slice(-6); // pad with leading zeros
    color = "#" + color;                  // prepend #
    return color;
}

$(document).ready(function () {


    //	alert();
    var req = $.ajax({
        type: "POST",
        url: "index.php?action=get_services",
        dataType: "jsonp"
    });

    req.done(function (msg) {
        //alert(msg);
        var table;
        var cindex;
        $("table th").each(function () {

            if ($(this).attr("coloum_name") == "service_short") {
                table = $(this).parent().parent().parent();
                cindex = $(this).index();
                //$("table tr td:nth-child(2)")
                //$('table:last tr:nth-child(2) td:nth-child(2)').css("background-color", "#000");

            }
            //alert($(this).index());

        });


        if (cindex != null) {
            //alert(msg);
            table.find('tr').each(function (i, el) {
                var $tds = $(this).find('td');


                $.each(msg, function (i, v) {
                    //	alert(v.service_short);
                    if (v.service_short == $tds.eq(cindex).text()) {
                        // found it...
                        if (v.service_color != null) {

                            $tds.eq(cindex).css("background-color", "#" + v.service_color);
                            $tds.eq(cindex).css("color", invertColor("#" + v.service_color));

                            //$(this).css("background-color", "#"+v.service_color);
                            //$(this).css("color", invertColor("#"+v.service_color));

                        }
                        // return false; // stops the loop
                    }
                });

                //alert(  $tds.eq(cindex).text());

                // do something with productId, product, Quantity
            });
        }

    });


});


function stop_item(package_id){

    var req = $.ajax({
        type: "POST",
        url: "index.php?action=stop_package",
        data : {package_id : package_id} 
    });

    req.done(function (msg) {

        alert(msg);
        location.reload();
    });

}

function play_item(package_id){ 

    var req = $.ajax({
        type: "POST",
        url: "index.php?action=play_package",
        data : {package_id : package_id}
    });

    req.done(function (msg) {

        alert(msg);
        location.reload();
    });

}

function delete_item(package_id){

    var req = $.ajax({
        type: "POST",
        url: "index.php?action=delete_package",
        data : {package_id : package_id}
    });

    req.done(function (msg) {

        alert(msg);
        location.reload();
    });

}

function loadIframes(iframeName, url) {
    var iframe = $('#' + iframeName);
    alert(iframeName);
    if (iframe.length) {
        iframe.attr('src', url);
        return false;
    }
    return true;
}

function callback() {
    setTimeout(function () {
        $("#effect").removeAttr("style").hide().fadeIn();
    }, 1000);
}

function color_notify(ids, table_name) {
    if (ids != null && table_name != "") {
        var obj = JSON.parse(ids);


        $("#" + table_name + "  tr").each(function () {

            for (var i = 0; i < obj.length; i++) {
                //alert(obj[i] );
                if (obj[i] == this.cells[1].innerHTML) {

                    var options = {className: "notify_record"};
                    $(this).effect("pulsate", options, 1500, callback);

                    var req = $.ajax({
                        type: "GET",
                        url: "index.php?action=remove_notify",
                        data: {id: obj[i]}
                    });

                    req.done(function (msg) {
                        $(".orderdetails").html(msg);

                    });


                }

            }


        });
    }


}

function loadiframe(row, type) {

    grow = row;
    gtype = type;

    if (rowheight != 0) {
        $("#grid table tr").css('height', rowheight);
    } else {
        rowheight = $(row).height();
    }
    //$(".orderdetails").html("Fetching Data...");
    $('.red').removeClass();


    var offset = $(row).offset();
//alert(offset.left);
//alert(offset.top);


    row.className = "red";
    //alert(row.cells[1]);
    if (row.cells[1] != undefined) {

        var url = "montior.php?action=order_details&type=" + type + "&id=" + row.cells[1].innerHTML;


//var iFrame = $('#order_details');
//iFrame.load(url);

        var req = $.ajax({
            type: "GET",
            url: url
        });

        req.done(function (msg) {

            $("#result_console").html(msg);
            $("#result_console").css("top", (offset.top + $(row).height()));
            $("#result_console").css("left", (offset.left));
            $("#result_console").css("width", $("#grid").width());
            $("#result_console").css("position", "absolute");
            $("#result_console").css("z-index", "1000");
            $("#result_console").css("display", "block");

            $(row).css('height', $(row).height() + $("#result_console").height());

        });
        req.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

    }
    else return;
//$('#orderdetails').attr("src",url);
    //  loadIframes("order_details", url);
    //document.getElementById("order_details").contentDocument.location.reload(true);
}


function order_details_active(id, type, tab) {

    //alert($(this).attr("class"));
    var urls = "montior.php?action=change_status&type=" + type + "&id=" + id + "&driver_id=" + tab;
    var req = $.ajax({
        type: "GET",
        url: urls
    });

    req.done(function (msg) {
        // $("#tabs").tabs( "select" , tab  );
        $(".table tr").each(function () {
            //alert(this);
            if (typeof this.cells[1] != "undefined" && this.cells[1].innerHTML == id) {
                $(this).hide(1000);
                $("#result_console").css("display", "none");
                return;
            }
        });

        // window.location.reload();

    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function order_details_view(id) {

    var url = "montior.php?action=edit_orders&id=" + id;
    window.location.href = url;
//var name1 = "Editing Order : " + id;
//$("#tabs").tabs( "add" , url , name1 , ($("#tabs").tabs( "length" )) );

}

function order_details_red(row) {
    var url = "montior.php?action=edit_orders&id=" + row.cells[1].innerHTML;
    window.location.href = url;
}

function close_order_details(id) {
    $("#result_console").html("");
    $("#result_console").css("display", "none");
    $("#grid table tr").css('height', rowheight);
}

function countChecked() {
    var n = 0;
    n = $("input:checked").length;
    return n;
}

function set_driver(driver_id, driver_name) {
    var n = countChecked();

    if (n == 0) {
        $("#result").html("Please Select orders To Assign Driver!!!!");
        $("#result").dialog({
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
                title_html: true,
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                    }
                }
            }
        );

    } else {
        var z = "";
        var i = 1;
        var y = "";
        $("input:checked").each(function () {
            z = z + "Order " + i + " : " + $(this).val() + "<br>";
            y = y + $(this).val() + ",";
            i++;
        });


        $("#result").html("Are you Sure To Assign This Driver (" + driver_name + ") to This order(s) ? <br> " + z);

        $("#result").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Yes: function () {

                    //alert("montior.php?action=set_driver&id="+y+"&did="+driver_id);
                    var req = $.ajax({
                        type: "GET",
                        url: "montior.php?action=set_driver&id=" + y + "&did=" + driver_id

                    });

                    req.done(function (msg) {
                        var myarr = msg.split(",");
                        //alert(msg);
                        //alert(myarr.length);
                        $("#result_console").html("");
                        $("#result_console").css("display", "none");

                        $(".table tr").each(function () {
                            var ro = this;
                            //alert(ro.cells[1]);
                            $("input:checked").each(function () {

                                if (typeof ro.cells[1] != "undefined" && ro.cells[1].innerHTML == $(this).val()) {
                                    $(ro).remove();
                                }

                            });

                        });


                    });
                    req.fail(function (jqXHR, textStatus) {
                        alert("Request failed: " + textStatus);
                    });


                    $(this).dialog("close");

                },
                No: function () {
                    $(this).dialog("close");
                }

            }
        });


    }


    //alert(driver_id);
}


function close_order() {
    window.location.href = "montior.php?action=pending";
}

function edit_order(id) {

    var data = $("#edit_orderss_" + id).serialize();
    var req = $.ajax({
        type: "POST",
        url: $("#edit_orderss_" + id).attr('action'),
        data: data
    });

    req.done(function (msg) {
        //	alert(msg);
        $("#tabs").tabs("load", $("#tabs").tabs("option", "selected"));

    });


}

function edit_order_close(id) {
    var data = $("#edit_orderss_" + id).serialize();
    var req = $.ajax({
        type: "POST",
        url: $("#edit_orderss_" + id).attr('action'),
        data: data
    });

    req.done(function (msg) {
        //alert(msg);
        console.log(msg);
        location.reload();

    });
}

function show_map(id, from, to) {
    var req = $.ajax({
        type: "GET",
        url: "index.php?action=show_map",
        data: {order_id: id, fd: from, td: to}
    });

    req.done(function (msg) {

        $("#result").html(msg);

        $("#result").dialog({
            modal: true,
            height: 800,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            width: 700,
            buttons: {
                Yes: function () {
                }
            }

        });

    });
}


function popWinAbs(theURL, winName, features, windowx, windowy, posx, posy) {
    var availx;
    var availy;
    availx = screen.availWidth;
    availy = screen.availHeight;
    if (windowx == 0) windowx = availx - 20;                 //leave a bit of of the parent showing at the edges
    if (windowy == 0) windowy = availy - 50;                 //less 50 to accomodate taskbar
    if (posx == "centre") {
        posx = (availx - windowx) / 2;
    }
    if (posy == "centre") {
        posy = (availy - windowy) / 2;
    }

    if (windowx > availx) {
        posx = 0;
        windowx = availx
    }
    ;
    if (windowy > availy) {
        posy = 0;
        windowy = availy - 50
    }
    ;    //less 50 to accomodate taskbar

    var hd = window.open(theURL, winName, features + ',width=' + windowx + ',height=' + windowy + ',left=' + posx + ',top=' + posy);
    hd.focus()
    if (!hd.opener) hd.opener = self;
}

function mapwindow(faddr, fpc, taddr, tpc, ordernum, driver_id) {
    //Need to replace CR LF with blanks as these are dropped when passed, resulting in parts getting concatonated...
    //... an then & Google cant find the place.
    var cleanfaddr;
    var cleantaddr;
    cleanfaddr = faddr.replace(/\r/gim, " ");
    cleanfaddr = cleanfaddr.replace(/\n/gim, " ");
    cleanfaddr = cleanfaddr.replace(/#/gim, " ");
    cleanfaddr = cleanfaddr.replace(/'/gim, "");
    cleanfaddr = cleanfaddr.replace(/,/gim, " ");

    cleantaddr = taddr.replace(/\r/gim, " ");
    cleantaddr = cleantaddr.replace(/\n/gim, " ");
    cleantaddr = cleantaddr.replace(/#/gim, " ");
    cleantaddr = cleantaddr.replace(/'/gim, "");
    cleantaddr = cleantaddr.replace(/,/gim, " ");

    popWinAbs("gmap.php?fa=" + cleanfaddr + " " + fpc + "&ta=" + cleantaddr + " " + tpc + "&ordernum=" + ordernum + "&did=" + driver_id, "mapwindow", "scrollbars=1,resizable=1", "628", "720", "4", "4");
}


/*function moveScroll(){
//	alert();
    var scroll = $("#grid").scrollTop();
    var anchor_top = $("#pending_table").offset().top;
    var anchor_bottom = $("#bottom_anchor").offset().top;
    if (scroll>anchor_top && scroll<anchor_bottom) {
    clone_table = $("#clone");
    if(clone_table.length == 0){
        clone_table = $("#pending_table").clone();
        clone_table.attr('id', 'clone');
        clone_table.css({position:'fixed',
                 'pointer-events': 'none',
                 top:0});
        clone_table.width($("#pending_table").width());
        $("#grid").append(clone_table);
        $("#clone").css({visibility:'hidden'});
        $("#clone thead").css({visibility:'visible'});
    }
    } else {
    $("#clone").remove();
    }
}
$("#grid").scroll(moveScroll);*/
//$("table tr:first").css("position", "fixed");
var old_row_data = {};
var last_row_data = {};
var old_focus = "";
var is_edit = 0;

function focusrow(row, row_id, table_id) {
    //alert(old_focus);
    if (old_focus != "" && old_focus != row.id && old_row_data.length != 0 && is_edit == 1) {

        var allelement = $("#" + old_focus + " :input");
        allelement.each(function (index, ele) {
            // alert(ele.name);
            if (this.type != 'button') last_row_data[ele.name] = ele.value;
        });
        //alert(old_row_data['status__id']+ "--" +last_row_data['status__id']);

        var r = compare_two_array(old_row_data, last_row_data);
        //alert(r);

        if (compare_two_array(old_row_data, last_row_data) == true) {
            $("#" + old_focus + " :input").attr("disabled", true);


        } else {
            alert("Changes Will not be saved");
            var allelement = $("#" + old_focus + " :input");

            allelement.each(function (index, ele) {
                if (this.type != 'button') ele.value = old_row_data[ele.name];
            });


            $("#" + old_focus + " :input").attr("disabled", true);

        }


    }


    $('.focus').removeClass();
    row.className = "focus";
    old_focus = row.id;
    if (old_focus != row.id) is_edit = 0;
}

function editrow(row, rowid, table_id) {
    is_edit = 1;
    $("#" + row.id + " .edit_row").show();
    $("#" + row.id + " :input").attr("disabled", false);
    var allelement = $("#" + row.id + " :input");
    allelement.each(function (index, ele) {
        if (this.type != 'button') old_row_data[ele.name] = ele.value;
    });


    //alert(row.id);
}

function cancel_edit_row(rowid, table_id) {

    var allelement = $("#" + rowid + " :input");

    allelement.each(function (index, ele) {
        if (this.type != 'button') last_row_data[ele.name] = ele.value;
    });

    if (compare_two_array(old_row_data, last_row_data) == true) {


        $("#" + rowid + " :input").attr("disabled", true);
    } else {
        var allelement = $("#" + rowid + " :input");

        allelement.each(function (index, ele) {
            if (this.type != 'button') ele.value = old_row_data[ele.name];
        });


        alert("Changes Will not be saved");
        $("#" + rowid + " :input").attr("disabled", true);
    }
    $("#" + rowid + " .edit_row").hide();
    old_row_data = {};
    is_edit = 0;
}


function compare_two_array(old_array, new_array) {
    var x = false;
    $.each(old_array, function (key, value) {
        if (old_array[key] != new_array[key]) {
            x = false;
            return x;
        } else {
            x = true;
        }
    });
    if (x == true) return x;

}


function save_row(row, row_id, table_id) {
    var myarr = row_id.split("__");
    var allelement = $("#" + row_id + " :input");
    var row_data = {};
    allelement.each(function (index, ele) {
        if (this.type != 'button') row_data[ele.name] = ele.value;
    });

    var req = $.ajax({
        type: "POST",
        url: 'index.php?action=grid_edit',
        data: {info: row_data, table_name: 'orders', order_id: myarr[1]}
    });
    req.done(function (msg) {
        alert("Order Saved");
        $("#" + row_id + " :input").attr("disabled", true);
    });
    $("#" + row_id + " .edit_row").hide();

    old_row_data = {};
    is_edit = 0;

}

function calc_waittime(element, min_price, form_id) {
    var value = $(element).val();
    if (value != "") {
        var result = min_price * value;

        $("#" + form_id + " input[name=\"wait_charges\"] ").val(result);
    }

}


function send_driver_where(id, type) {


    var req = $.ajax({
        type: "GET",
        url: 'index.php?action=send_google_push_message',
        data: {driver_id: id, type: type}
    });
//	alert($('#bu_'+id).offset().top);
    req.done(function (msg) {

//	$("#page").html(msg);
//	 $( "#page" ).dialog({
//			modal: false,
//			resizable: true,
//			width:'250', 
//			height:'auto',
//			position: { my: 'top', at: 'top+'+ $('#bu_'+id).offset().top},
//			position: { my: 'left', at: 'left+'+ $('#bu_'+id).offset().left},
//	 
//	 });
        var myWindow = window.open("index.php?action=track&type=" + type + "&did=" + id, "_blank", "width=600, height=600");
        // var win = window.open('index.php?action=track&type='+type, '_blank');
        win.focus();
        $("#bu_" + id).append('<i class="ace-icon fa fa-spinner fa-spin orange bigger-125"></i>');
    });

}


$(".page-content-area").ready(function () {
    var contents = '';


    var c = {};

    var div = $('#driver_grid');
    div.resizable(
        {
            stop: function (event, ui) {
                var top = getTop(ui.helper);
                ui.helper.css('position', 'fixed');
                ui.helper.css('top', top + "px");
            }
        });

    $("#driver_grid tr").draggable({
        revert: true,
        helper: "clone",
        appendTo: 'body',
        zIndex: 100000,
        start: function (event, ui) {
            //c.css("position","fixed");
            c.tr = this;
            c.helper = ui.helper;
            contents = $(this).attr('value');
        },


    });


    $("#grid tbody tr").droppable({

        hoverClass: "bgreen",
        accept: "#driver_grid tr",
        drop: function (event, ui) {
            //$(this).css("background","green");
            // var item = ui.draggable;
            // console.log(item);
            var ro = this;
            var req = $.ajax({
                type: "GET",
                url: "montior.php?action=set_driver&id=" + this.cells[1].innerHTML + ",&did=" + contents

            });

            req.done(function (msg) {

                //alert(msg);
                $("#result_console").html("");
                $("#result_console").css("display", "none");
                $(ro).hide(1000);

            });


            $(c.helper).remove();
        }
    });


    function getTop(ele) {
        var eTop = ele.offset().top;
        var wTop = $(window).scrollTop();
        var top = eTop - wTop;

        return top;
    }


});

function send_driver_message(order) {
    //alert(JSON.stringify(order));
    var req = $.ajax({
        url: "index.php?action=send_driver_message",
        type: 'POST',
        contentType: 'application/json; charset=utf-8',
        data: JSON.stringify(order)
    });

    req.done(function (msg) {


        $("#page").html(msg);
        $("#page").dialog({
            modal: true,
            resizable: true,
            width: '450',
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>Message To Driver</h4></div>",
            title_html: true,
            buttons: {
                Send: function () {

                    var req = $.ajax({
                        url: "index.php?action=send_driver_message",
                        type: 'POST',
                        data: $("#driver_message").serialize()
                    });

                    req.done(function (msg) {

                    });
                    $(this).dialog("close");

                },
                Close: function () {
                    $(this).dialog("close");
                }
            }

        });
    });

    //alert(order.driverno);
}

function set_table_height(driver_id) {
    $("#driver_activity_" + driver_id + " .tbody").height($(window).height() - 290);
}

function show_driver_details(orders) {

    var driver_id = search(orders, 'driver_id');
    var dirver_name = search(orders, 'name');

    var req = $.ajax({
        type: "GET",
        url: "index.php?action=get_driver_order&driver_id=" + driver_id
    });

    req.done(function (msg) {


        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            create: function (event, ui) {
                $("body").css({overflow: 'hidden'})
            },
            beforeClose: function (event, ui) {
                $("body").css({overflow: 'inherit'})
            },
            close: function (event, ui) {
                $(this).find("form").remove();
                $(this).dialog('destroy').remove();
                var div = $("<div>", {id: "result_dialoge"});

                $("body").append(div);

            },
            modal: true,
            resizable: true,
            width: '60%',
            height: $(window).height(),
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Driver " + dirver_name + " Activity</h4></div>",
            title_html: true,
            buttons: {
                Close: function () {
                    $(this).dialog("close");
                    //$(this).dialog('destroy');
                },
                Change_Driver: function () {

                },
                Print: function () {
                    window.open("index.php?type=print&action=get_driver_order&driver_id=" + driver_id, '_blank');

                    //index.php?action=get_driver_order&driver_id="+driver_id
                    //PrintElem('#driver_activity_'+driver_id);
                },
                Print_WayBill: function () {
                    window.open("index.php?type=print&action=get_driver_order_waybill&driver_id=" + driver_id, '_blank');

                },
                Email: function () {
                    var request = $.ajax({
                        type: "GET",
                        url: "index.php?action=email_driver_order&driver_id=" + driver_id
                    });

                    request.done(function (msgg) {

                        alert("Mail Send");
                    });


                }

            }

        });
        set_table_height(driver_id);

    });


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


    //var json = JSON.parse(JSON.stringify(orders));

//	var json = JSON.stringify(orders);
    //alert(json);
    //json = JSON.parse(json);
    //alert(json['driver_id']);
}


function PrintElem(elem) {
    Popup($(elem).html());
}

function Popup(data) {
    var mywindow = window.open('', 'my div', 'height=400,width=600');
    mywindow.document.write('<html><head><title>my div</title>');
    /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10

    mywindow.print();
    mywindow.close();

    return true;
}


function reload_grid() {
    $("#grid").empty();


}

function delete_photo(order_id) {

    var req = $.ajax({
        type: "POST",
        url: 'montior.php?action=delete_photo',
        data: {id: order_id}
    });

    req.done(function (msg) {

        $('table#table tr#image_' + order_id).remove();


    });

}


function start_work(order_id, mymsg) {

    $("#result_dialoge").html(mymsg);
    $("#result_dialoge").dialog({
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> طلب الغاء طلبية </h4></div>",
        title_html: true,
        width: '400',
        height: '200',
        buttons: {
            Ok: function () {
                var req = $.ajax({
                    type: "POST",
                    url: 'montior.php?action=start_work',
                    data: {order_id: order_id}
                });

                req.done(function (msg) {
                    	//alert(msg);
                        debugger;
                    $("#result_console").html("");
                    $("#result_console").css("display", "none");


                    location.reload();


                });
                $(this).dialog("close");
            },
            Close: function () {
                $(this).dialog("close");

                //document.getElementById('add_orderss').reset();
            }
        }
    });


}

function close_order_all(order_id, mymsg) {

    $("#result_dialoge").html(mymsg);
    $("#result_dialoge").dialog({
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> طلب الغاء طلبية </h4></div>",
        title_html: true,
        width: '400',
        height: '200',
        buttons: {
            Ok: function () {
                var req = $.ajax({
                    type: "POST",
                    url: 'montior.php?action=close_order_all',
                    data: {order_id: order_id}
                });

                req.done(function (msg) {
                    //	alert(msg);
                    $("#result_console").html("");
                    $("#result_console").css("display", "none");


                    location.reload();


                });
                $(this).dialog("close");
            },
            Close: function () {
                $(this).dialog("close");

                //document.getElementById('add_orderss').reset();
            }
        }
    });


}


function stop_order(order_id, mymsg) {

    $("#result_dialoge").html(mymsg);
    $("#result_dialoge").dialog({
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> طلب الغاء طلبية </h4></div>",
        title_html: true,
        width: '400',
        height: '200',
        buttons: {
            Ok: function () {
                var req = $.ajax({
                    type: "POST",
                    url: 'montior.php?action=stop_work',
                    data: {order_id: order_id}
                });

                req.done(function (msg) {
                    //	alert(msg);
                    $("#result_console").html("");
                    $("#result_console").css("display", "none");


                    location.reload();


                });
                $(this).dialog("close");
            },
            Close: function () {
                $(this).dialog("close");

                //document.getElementById('add_orderss').reset();
            }
        }
    });


}


function play_order(order_id, mymsg) {

    $("#result_dialoge").html(mymsg);
    $("#result_dialoge").dialog({
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> طلب الغاء طلبية </h4></div>",
        title_html: true,
        width: '400',
        height: '200',
        buttons: {
            Ok: function () {
                var req = $.ajax({
                    type: "POST",
                    url: 'montior.php?action=play_work',
                    data: {order_id: order_id}
                });

                req.done(function (msg) {
                    //	alert(msg);
                    $("#result_console").html("");
                    $("#result_console").css("display", "none");


                    location.reload();


                });
                $(this).dialog("close");
            },
            Close: function () {
                $(this).dialog("close");

                //document.getElementById('add_orderss').reset();
            }
        }
    });


}

function cancel_order(order_id, mymsg) {

    $("#result_dialoge").html(mymsg);
    $("#result_dialoge").dialog({
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> طلب الغاء طلبية </h4></div>",
        title_html: true,
        width: '400',
        height: '200',
        buttons: {
            Ok: function () {
                var req = $.ajax({
                    type: "POST",
                    url: 'montior.php?action=cancel_request',
                    data: {order_id: order_id}
                });

                req.done(function (msg) {
                    //	alert(msg);
                    $("#result_console").html("");
                    $("#result_console").css("display", "none");

                    var x = 0;
                    $(".table tr").each(function () {

                        var ro = this;


                        if (typeof ro.cells[1] != "undefined" && ro.cells[1].innerHTML == order_id) {
                            x++;
                            $(ro).hide(1000);
                        }


                    });

                    if (x == 0) {
                        location.reload();
                    }


                });
                $(this).dialog("close");
            },
            Close: function () {
                $(this).dialog("close");

                //document.getElementById('add_orderss').reset();
            }
        }
    });


}




