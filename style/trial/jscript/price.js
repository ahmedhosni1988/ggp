function edit_vechile(id, name) {
    var url = "pricing.php?action=edit_v&id=" + id;
    var name1 = "Edit : " + name;
    open_new_tab(url, name1, 'vtabs');
    // var wtab = $("#vtabs").children().attr('id');
    // alert(wtab);

    //  $("#vtabs").tabs( "add" , url , name1, ($("#vtabs").tabs( "length" )) );
}
//
function open_price(account_id,where,last_version_id,order_status,pac){

    if(account_id==0)
    var billing = document.getElementById("billing_code_" + account_id).value;

    if(last_version_id!=0) {
        var color = document.getElementById("item_color_" + account_id).value;
        var x = document.getElementById("open_price_"+account_id).value;
        var glass_type = document.getElementById("glass_type_"+account_id).value;
    }
    // console.log(window.location);

    //console.log(x + color);
    if(where == "adminmanager") {
        if(last_version_id!=0) {
            if(account_id==0)
            window.location.href = window.location.pathname + '?item_color=' + color + '&version_id=' + x + '&bill_code=' + billing+ '&glass_type=' + glass_type;
            else
                window.location.href = window.location.pathname + '?item_color=' + color + '&version_id=' + x + '&glass_type=' + glass_type;
        }
        else
            window.location.href = window.location.pathname + '?bill_code=' + billing;
        // location.reload();
    }else{
      
        var query=" `package_status_price`  WHERE `account_id` ='"+account_id+"' and version_id='"+x+"' and item_colour='"+color+"' and glass_type='"+glass_type+"' "
        // alert(query);
        $("#prices").find("tr:gt(0)").remove();
        var req = $.ajax({
            type: "POST",
            url: 'pricing.php?action=query',
            data: {query:query}
        });

        req.done(function (msg) {
            // alert(msg)
            // alert(msg);
            var table=JSON.parse(msg);
            order_status=JSON.parse(order_status)
            pac=JSON.parse(pac)
            // $("#mange_add_" + account_id).tabs("load", 1);
            console.log(pac);
            // document.getElementById("item_color_"+account_id).value=color;
            pac.forEach((element1,index1) => {
                var row ='';
                row+='<tr><td>'+element1['package_name']+'</td>';
                order_status.forEach((element2,index2) => {
                    // console.log(table[element2['disporder']][ element1['package_id']])
                    var value=''
                    table.forEach(el => {
                        if(el['package_id'] ===element1['package_id'] && el['status_id'] === element2['disporder']){
                            value=el['fee']
                        }
                    });
                    row+='<td><input type="text" size="5"  name="price['+element1['package_id']+']['+element2['disporder']+']" value="'+value;

                    row+='" ';
                    if(last_version_id != x   ){
                        row+=' disabled ';
                    }
                    row+= '/></td>';

                });
                row+='</tr>';
                // console.log(row);
                if(last_version_id != x  ){

                    $('#button_price').attr("disabled", "disabled");
                }else{
                    $('#button_price').removeAttr("disabled");

                }
                console.log(row)
                $('#prices').find('tbody').append(row);
                // $('#prices tr:last').after(row);
            });
        });
    }
    // if(x=='new'){
    //     window.location.href= window.location.pathname;
    // }else{
    //     window.location.href= window.location.pathname+'?item_color='+color+'&version_id='+x;
    // }

    
    console.log('tes',x)
}

function add_new_price(account_id,where){


if(account_id==0)
    var billing=document.getElementById("billing_code_"+account_id).value;

else
    billing='1';
    var req = $.ajax({
        type: "POST",
        url: 'pricing.php?action=add_new_price',
        data: { new_price:"1" , account_id,billing_code:billing }
    });

    req.done(function (msg) {

        console.log(msg);

        if(where == "adminmanager") location.reload();
        else $("#mange_add_"+account_id).tabs("load", 1);
    });

}
function open_price_account(view=null,account_id,last_version_id,order_status,pac){
    var version_id = document.getElementById("open_price_"+account_id).value;
    // console.log(window.location);
    // console.log('tes',version_id,account_id)

    $("#price_account").find("tr:gt(0)").remove();
    var query=" `package_status_price`  WHERE `account_id` ='"+account_id+"' and version_id='"+version_id+"' and item_colour='"+item_color+"' "
    var req = $.ajax({
        type: "POST",
        url: 'pricing.php?action=query',
        data: {query:query}
    });

    req.done(function (tablex) {
    var table=JSON.parse(tablex)
    order_status=JSON.parse(order_status)
    pac=JSON.parse(pac)
    console.log(order_status)
    console.log(pac)
    console.log('table',table)
    pac.forEach((element1,index1) => {
        var row ='';
       row+='<tr><td>'+element1['package_name']+'</td>';
        order_status.forEach((element2,index2) => {
            console.log(table[element2['disporder']][ element1['package_id']])
            var value=''
            table.forEach(el => {
                if(el['package_id'] ===element1['package_id'] && el['status_id'] === element2['disporder']){
                    value=el['fee']
                }
            });
            row+='<td><input type="text"  name="price['+element1['package_id']+']['+element2['disporder']+']" value="'+value;
       
                    row+='" ';
                    if(last_version_id != version_id   ){
                        row+=' disabled ';
                    }
                    if(view)row+=' disabled ';
                    row+= '/></td>';
        });
        row+='</tr>';
        // console.log(row);
        if(last_version_id != version_id  ){
           
            $('#button_price_account').attr("disabled", "disabled");
        }else{
            $('#button_price_account').removeAttr("disabled");

        }
    $('#price_account tr:last').after(row);
  });
  
     
        
    


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}

function delete_zone(id, from, to, chart) {

    var req = $.ajax({
        type: "POST",
        url: 'pricing.php?action=delete_dzone',
        data: {fromzone: from, tozone: to, chart: chart}
    });

    req.done(function (msg) {
        $(id).fadeTo("slow", 0.7, function () {
            $(this).remove();
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}

function search_zones() {
    $("#search_result").html("");
    var data = $('#search_zone').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#search_zone').attr('action'),
        data: data
    });

    req.done(function (msg) {
        $("#search_result").html(msg);
        //	alert(msg);


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function copy_serivces() {

    var data = $('#copy_zone').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#copy_zone').attr('action'),
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
            }
        );

        $("#tabs").tabs("load", 0);
    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function save_zone(type) {
    $("#loading-image").show();
    var data = $('#edit_zone').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#edit_zone').attr('action') + "&type=" + type,
        data: data
    });

    req.done(function (msg) {
        $("#loading-image").hide();
        $("#result").html(msg);
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

        $("#tabs").tabs("load", 0);
    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function add_row_zone() {
    $("#zones_table").last().append("<tr><td><input type=\"text\" value=\"\"  name=\"zone[]\" /></td><td><input type=\"text\"  value=\"\" name=\"prefix[]\" /></td><td><input type=\"text\" value=\"\"  name=\"pcodes[]\" /></td></tr>");
}


function delivery_save(ser, chart) {

    var data = $('#edit_deliver_services_' + ser + '_' + chart).serialize();

//alert(data);

    var req = $.ajax({
        type: "POST",
        url: $('#edit_deliver_services_' + ser + '_' + chart).attr('action'),
        data: data
    });

    req.done(function (msg) {
        //	alert(msg);

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
            }
        );

        $("#tabs").tabs("load", 0);
    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function save_zone_time() {

    var data = $('#edit_zone_time').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#edit_zone_time').attr('action'),
        data: data
    });

    req.done(function (msg) {
        //alert(msg);

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
            }
        );

        $("#tabs").tabs("load", 0);
    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function pickup_vechile() {

    var data = $('#zone_pickup').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#zone_pickup').attr('action'),
        data: data
    });

    req.done(function (msg) {
        //alert(msg);
        $("#result_dialoge").html("Zones updates correctly");
        $("#result_dialoge").dialog({
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

        $("#tabs").tabs("load", 0);
    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}


function add_vechile() {

    var data = $('#add_v').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#add_v').attr('action'),
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
            }
        );

        $("#tabs").tabs("load", 0);
    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}


function edit_vechil() {

    var data = $('#edit_v').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#edit_v').attr('action'),
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
            }
        );

        $("#tabs").tabs("load", 0);
    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}


////////////////////////////////////////////////addtional services for vechiles


function pricesetting_save() {


    var data = $('#option_price').serialize();
// console.log(data)
// console.log($('#option_price').attr('action'))
    var req = $.ajax({
        type: "POST",
        url: $('#option_price').attr('action'),
        data: data
    });

    req.done(function (msg) {
    // console.log(msg)

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

    $("#price_pac").tabs("load", 0);


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function save_distance_inc() {


    var data = $('#vec_distance_inc').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#vec_distance_inc').attr('action'),
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
                    $("#tabs").tabs("load", 0);

                }
            }
        });

    });


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}


function save_distance_fees() {


    var data = $('#vec_distance').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#vec_distance').attr('action'),
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
                    $("#tabs").tabs("load", 0);

                }
            }
        });

    });


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}


function save_distance_ratio() {


    var data = $('#distance_increase_ratio').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#distance_increase_ratio').attr('action'),
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
                    $("#tabs").tabs("load", 0);

                }
            }
        });

    });


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}






