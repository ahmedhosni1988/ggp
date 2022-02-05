

$(document).ready(function () {





    $("#package_details_skid :input").removeAttr("disabled");

    $("#skid_options_forgein :input").attr("disabled", true);
    $("input:radio[name='skid_type']").change(function () {

        if ($(this).val() === 'F') {
            $("#package_details_skid :input").attr("disabled", true);
            $("#skid_options_forgein :input").removeAttr("disabled");

        } else if ($(this).val() === 'L') {
            $("#package_details_skid :input").removeAttr("disabled");

            $("#skid_options_forgein :input").attr("disabled", true);
        }

        $("#totals_of_skid :input").attr("disabled", true);

        $("input:radio[name='skid_type']").removeAttr("disabled");
    });
    $("input:radio[name='skid_type']").removeAttr("disabled");
});


function set_row_color(id, color) {

    $("#orders__" + id).closest("tr").css('background-color', color);
}

function check_form() {
    var x = true;
    var $inputs = $('#add_orderss :input');
    var values = {};
    $('.error').remove();
    $('.postive').remove();
    $inputs.each(function () {
        values[this.name] = $(this).val();
        if ($(this).val() == "") {

            if (this.name == 'order_comment' || this.name == 'confirmation_email' || this.name == 'refrence' || this.name == 'weight' || this.name == 'volume' || this.name == 'parts' || this.name == 'details' || this.name == 'cod' || this.name == 'payment_type' || this.name == 'orderby' || this.name == 'declared_value' || this.name == 'payment_type_s' || this.name == 'collect_s' || this.name == 'pieces_s' || this.name == 'volume_s' || this.name == 'weight_s' || this.tagName == 'checkbox' || this.name == 'comment' || this.name == 'description' || this.name == 'payment_type_s') {

            } else {

                $(this).parent('div').append('<div class="error"></div>');

                x = false;
            }
        } else {
            if ($(this).attr('type') == 'submit' || $(this).attr('type') == 'button') {

            } else {

                $(this).parent('div').append('<div class="postive"></div>');
            }


        }
    });

    return x;
}


function add_orders(type, place) {
    $("#addorder_button").prop('disabled', true);

    //var y = check_form();
    var y = validate_forms('add_orderss');
//alert(y);
    //  y=true;
    if (y || type == "estimate") {

        var data = $('#add_orderss').serialize() + "&type=" + type;
        //alert(data);

        var req = $.ajax({
            type: "POST",
            url: $('#add_orderss').attr('action'),
            data: data
        });

        req.done(function (msg) {
            // alert(msg);
            var obj = JSON.parse(msg);
            //alert(obj.message_type);


            if (obj.message_type == "OrderError") {
                $("#result_dialoge").html(obj.message_html);
                $("#result_dialoge").dialog({
                    modal: true,
                    title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>" + obj.message_title + "</h4></div>",
                    title_html: true,
                    width: '400',
                    height: '200',
                    buttons: {
                        Close: function () {
                            $(this).dialog("close");
                            $("#addorder_button").prop('disabled', false);

                            //document.getElementById('add_orderss').reset();
                        }
                    }
                });

            }


            if (obj.message_type == "Order") {

                if (place == "normal") {

                    $("#result_dialoge").html(obj.message_html);
                    $("#result_dialoge").dialog({
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>  " + obj.message_title + " </h4></div>",
                        title_html: true,
                        width: '600',
                        height: '200',
                        dialogClass: 'no-close',
                        closeOnEscape: false,
                        buttons: [
                            {
                                text: "شاشة تشغيل",
                                "class": "btn btn-info btn-sm",
                                //	icons: { primary: "ace-icon fa fa-print bigger-120" },
                                click: function () {
                                    $(this).dialog("close");
                                    $("#addorder_button").prop('disabled', false);

                                    window.location = 'montior.php?action=all';
                                    // refreshwaybill(obj.message);
                                },
                            },
                            {
                                text: "تعديل",
                                //	icons: { primary: "ace-icon fa fa-print bigger-120" },
                                "class": "btn btn-info btn-sm",
                                click: function () {
                                    // show_waybillbarcode(obj.order_id,obj.account_id,obj.account_name);
                                    window.location = 'montior.php?action=edit_orders&id='+obj.message;

                                },

                            },
                            {
                                text: "اضافة طلبية جديدة",
                                "class": "btn btn-info btn-sm",
                                click: function () {
                                    window.location = window.location.href;
                                },

                            },
                            {
                                text: "غلق",
                                icons: {primary: "ace-icon fa fa-trash-o bigger-120"},
                                "class": "btn   btn-danger btn-sm",
                                click: function () {
                                    window.location = 'index.php?action=choose_client';

                                },

                            }
                        ]
                    });
                    $('button').removeClass("ui-button-text-only");
                    $(".ui-dialog-titlebar-close").hide();
                    $('button').removeClass("ui-button ui-widget ui-state-default ui-corner-all ui-state-hover ui-button-text-only");
                    $('span').removeClass("ui-button-text ui-button-icon-primary ui-icon");


                } else if (place == "montior") {
                    window.location = "montior.php?action=pending";
                } else if (place == "waybill") {
                    refreshwaybill(obj.message);
                } else if (place == "addnew") {
                    window.location = window.location.href;
                }


            }


        });
        req.fail(function (jqXHR, textStatus) {

            alert("Request failed: " + textStatus + jqXHR.responseText);
        });


    } else {
        $("#addorder_button").prop('disabled', false);
        //$("#addorder_button").attr("disabled",false);
    }


}

function finish_operation(order_id, package_id, operation) {
    // alert(package_id+"amrs"+operation)
    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=finish_operation',
        data: {order_id: order_id, id: package_id, operation: operation}
    });

    req.done(function (msg) {
        	// alert(msg);
        $("#orders__" + package_id).remove();
        location.reload();

    });
}


function cancel_package(package_id) {

    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=cancel_package',
        data: {id: package_id}
    });

    req.done(function (msg) {

        $("#orders__" + package_id).remove();
        location.reload();
    });
}


function deliver_order(order_id) {

    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=deliver_order',
        data: {order_id: order_id}
    });

    req.done(function (msg) {
        //	alert(msg);
        location.reload();
        //$("#orders__"+package_id).remove();
    });

}

function show_image(order_id) {
    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=get_image',
        data: {id: order_id}
    });

    req.done(function (msg) {
        //	alert(msg);
        document.getElementById('myCarousel').innerHTML=msg;
        if (msg == false) {
           // alert("لا توجد صور لهذة الطلبية");
        } else {

            //	var res = '';
            //	res = JSON.parse(msg);

            // for(var i=0;i<res.length;i++){

            // }
            console.log(msg)
            document.getElementById('myCarousel').innerHTML=msg;
            // $("#result_dialoge").html(msg);
            // $("#result_dialoge").dialog({
            //     modal: true,
            //     title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>  صور الطلبية </h4></div>",
            //     title_html: true,
            //     width: '1000',
            //
            // });
        }


        //$("#orders__"+package_id).remove();
    });

}

function show_barcode(id) {
    //window.location = siteurl+"/labels.php?order_id="+id+"&clid=&acctno="+acctno;
    var req = $.ajax({
        type: "GET",
        url: 'work.php?action=ptint_item_code',
        data: { id:id}
    });

    req.done(function (msg) {

    });
    window.open(siteurl + "/labels.php?id=" + id, '_blank');


}

function make_scratch(package_id) {

    var req = $.ajax({
        type: "POST",
        url: 'manger.php?action=make_Scratche',
        data: {id: package_id}
    });

    req.done(function (msg) {
        //	alert(msg);

        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>  صور الطلبية </h4></div>",
            title_html: true,
            width: '600',
            buttons: [
                {
                    text: "حفظ وتشغيل",
                    click: function () {

                        var reqq = $.ajax({
                            type: "POST",
                            url: 'manger.php?action=set_Scratche',
                            data: $("#scratche_form").serialize()
                        });

                        reqq.done(function (msg) {
                            $("#result_dialoge").dialog("close");
                            location.reload();
                        });

                    }
                }, {
                    text: "غلق",
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            ]

        });


        //$("#orders__"+package_id).remove();
    });

}

function show_waybillbarcode(id, clid, acctno) {
    //window.location = siteurl+"/labels.php?order_id="+id+"&clid=&acctno="+acctno;

    window.open(formurl + "/index.php?action=waybill_barcode&order_id=" + id + "&clid=" + clid + "&acctno=" + acctno, '_blank');


}

//
//function assign_driver(order_id,driver_id){
//	
//	 var req2 = $.ajax({
//		   type: "POST",
//         url: 'montior.php?action=assign_driver',
//         data : {order_id : order_id,driver_id:driver_id}
//		   });
//
//req2.done(function(waybill){	  
//				$("#result_dialoge").html(waybill);
//				$( "#result_dialoge" ).dialog({
//					title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>Assign Driver to Order No  "+order_id+" </h4></div>",
//					title_html: true,
//					width: '500',
//					height: '350',
//modal: true,
//
//buttons: {
//	Assign: function (){
//		set_driver(driver_id,driver_name);
//	},
//	Close: function(){
//		$( this ).dialog( "close" );
//		}
//}
//});
//				
//				   });
//req2.fail(function (){
//					alert("Error in adding Order");
//					});
//}

function get_order_state(easy_order_id){
    console.log($('#easy_order_id').val())
    var easy_order_id=$('#easy_order_id').val()
    var req = $.ajax({
        type: "POST",
        url: 'index.php?action=get_waybill_report', 
        data: {easy_order_id: easy_order_id}
    });

    
    req.done(function (msg) {
        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> طلبية رقم :  " + easy_order_id + "</h4></div>",
            title_html: true,
            width: '800',
            height: '550',
            modal: true,

            buttons: [

                {
                    text: "طباعة",

                    click: function() {
                  
                        var w = window.open();
                        w.document.open();
                        w.document.write('<head>');
                        w.document.write($('head').html());
                        w.document.write('</head>');
                        w.document.write('<body onload="window.print(); window.close();" class="no-skin rtl">');
                        w.document.write($("#result_dialoge").html());
                        w.document.write('</body>');
                        w.document.write('</html>');
                        w.document.close();

    
                    }

                }, {
                    text: "اغلاق",

                    click: function () {
                        $(this).dialog("close");
                        //window.location = window.location.href;
                    }
                }
            ]

        });

    });
    req.fail(function () {
        alert("Error in adding Order");
    });

}

function refreshwaybill(msg) {
    //alert(msg);
    var req2 = $.ajax({
        type: "GET",
        url: 'index.php?action=get_waybill', 
        data: {order_id: msg}
    });

    req2.done(function (waybill) {
        $("#result_dialoge").html(waybill);
        $("#result_dialoge").dialog({
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> طلبية رقم :  " + msg + "</h4></div>",
            title_html: true,
            width: '800',
            height: '550',
            modal: true,

            buttons: [

                {
                    text: "طباعة",

                    click: function (params) {
                        prrint_waybill(msg);
                    }

                }, {
                    text: "اغلاق",

                    click: function () {
                        $(this).dialog("close");
                        //window.location = window.location.href;
                    }
                }
            ]

        });

    });
    req2.fail(function () {
        alert("Error in adding Order");
    });


}

function PrintDiv() {
    var mywindow = window.open();
    var is_chrome = Boolean(mywindow.chrome);
    mywindow.document.write($("#print").html());

    if (is_chrome) {
        setTimeout(function () { // wait until all resources loaded
            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10
            mywindow.print(); // change window to winPrint
            mywindow.close(); // change window to winPrint
        }, 250);
    } else {
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10
        mywindow.print();
        mywindow.close();
    }

    return true;
}

function prrint_waybill(msg) {
    //alert($("#printed_no").val());

    var w = window.open();
//	var printing;
//printing = $("#print").html();

//var printing = '<html>';
    w.document.open();
    w.document.write('<head>');
    w.document.write($('head').html());
    w.document.write('</head>');
    w.document.write('<body onload="window.print(); window.close();" class="no-skin rtl">');
    w.document.write($("#print").html());
    w.document.write('</body>');
    w.document.write('</html>');
    w.document.close();
    var req2 = $.ajax({
        type: "GET",
        url: 'index.php?action=is_printed',
        data: {order_id: msg}
    });

    req2.done(function (waybill) {});


}

function red_mon(siteurl) {
    window.location = siteurl + "/montior.php?action=pending";
}


/*$("#add_orderss").ready(function (){
$("#add_orderss :input").attr("disabled", true)	;
$("#acctno").removeAttr("disabled");

});
function set_account_id(id){
	$("#add_orderss :input").removeAttr("disabled");
	
	$("#account_id").remove();
$('<input>').attr({
    type: 'hidden',
    id: 'account_id',
    name: 'account_id',
	value : id
}).appendTo('#add_orderss');
	
	}*/
function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

var res = 1;

function make_admin_search() {

    var data = $('#Search').serialize();
    //alert(data);
    var url = $('#Search').attr('action') + "&" + data + "&" + res;

    //alert(url);

    var req = $.ajax({
        type: "get",
        url: $('#Search').attr('action'),
        data: data
    });

    req.done(function (msg) {
        //var obj = JSON.parse(msg);


        if (IsJsonString(msg)) {

            var obj = JSON.parse(msg);
            if (obj.no_result != undefined) {


                $("#result_dialoge").html(obj.no_result);
                $("#result_dialoge").dialog({
                    modal: true,
                    title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>Error</h4></div>",
                    title_html: true,
                    width: '400',
                    height: '150',
                    buttons: {
                        Close: function () {
                            $(this).dialog("close");

                            //document.getElementById('add_orderss').reset();
                        }
                    }
                });
            }

        } else {
            res++;
            open_new_tab(url, "Search Result " + res, "tabs");
        }
        //
        //drawsearchresult(msg);

    });

    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function order_details_view_invoice(id) {

    var url = "montior.php?action=edit_orders&id=" + id + "&cinvoice=1";

    window.open('montior.php?action=edit_orders&id=' + id);

//var name1 = "Editing Order : " + id;
//$("#tabs").tabs( "add" , url , name1 , ($("#tabs").tabs( "length" )) );

}


var table = "";
var win = "";

var i = 2;

function valedChk (objec) {

    //alert($(objec).val());

    //alert($(objec).attr("name"));
    var value =$(objec).val();
    var name = $(objec).attr("name");
   // alert ($(objec).attr("checked"));
    if(value==1)
        {
            if($(objec).prop('checked')){

                $('input[name="'+name+'"][value=2]').attr("disabled", "1");
                $('input[name="'+name+'"][value=3]').attr("disabled", "1");
                $('input[name="'+name+'"][value=4]').attr("disabled", "1");
                $('input[name="'+name+'"][value=5]').attr("disabled", "1");
            }
            else {
                $('input[name="'+name+'"][value=2]').removeAttr( "disabled" );
                $('input[name="'+name+'"][value=3]').removeAttr( "disabled" );
                $('input[name="'+name+'"][value=4]').removeAttr( "disabled" );
                $('input[name="'+name+'"][value=5]').removeAttr( "disabled" );
            }


        }
                //    $('input[name="order_status[0][]"][value=2]').removeAttr( "disabled" );


    if(value==2)
    {
        if($(objec).prop('checked')){

            $('input[name="'+name+'"][value=1]').attr("disabled", "1");
            $('input[name="'+name+'"][value=3]').attr("disabled", "1");
            $('input[name="'+name+'"][value=4]').attr("disabled", "1");
            $('input[name="'+name+'"][value=5]').attr("disabled", "1");
        }
        else {
            $('input[name="'+name+'"][value=1]').removeAttr( "disabled" );
            $('input[name="'+name+'"][value=3]').removeAttr( "disabled" );
            $('input[name="'+name+'"][value=4]').removeAttr( "disabled" );
            $('input[name="'+name+'"][value=5]').removeAttr( "disabled" );
        }


    }
    if(value==3||value==4||value==5)
        {
            if($(objec).prop('checked')){

                $('input[name="'+name+'"][value=1]').attr("disabled", "1");
                $('input[name="'+name+'"][value=2]').attr("disabled", "1");
            }
            else {
                $('input[name="'+name+'"][value=1]').removeAttr( "disabled" );
                $('input[name="'+name+'"][value=2]').removeAttr( "disabled" );
            }
        }


    $('input[name= name ]')

        // if ($(this).attr("checked")==true) {
        //     alert("id checked ");
        // } else {
        //     alert($(this).attr("checked"));
        // }
    }

function add_package_row(x ) {
          
            for (var i = 0; i < 1; i++) {
                    var str = $("#multi_package tr:last").html();

                    var c = $('#multi_package tr').length;
                    var cold = c - 1;

                    str = str.replace(/\[\d+\]/g, "[" + (c - 1) + "]");

                    //	str.replace("[1]", "[2]");
                var numberOfNewItem =$("#multi_package tr:last td.numOfItem").html();
                //alert(numberOfNewItem);
                    $("#multi_package").last().append("<tr>" + str + "</tr>");
                    $("#multi_package tr:last ").find("input[name*='length']").val('');
                    $("#multi_package tr:last ").find("input[name*='width']").val('');

                    $("#multi_package tr:last ").find("input[name*='details']").val('');
                 $("#multi_package tr:last ").find("input[name*='id']").val('');
                 $("#multi_package tr:last ").find("input[name*='part_order']").val('');

                $("#multi_package tr:last #box").css("display", "");
                $("#multi_package tr:last td.numOfItem").html(++numberOfNewItem);
                }


                $("input[type='checkbox']").each(function (){

                    //  alert("1");
                    if(this.checked) {
                        //Do stuff
                        $(this).attr("checked","checked");
                        $(this).prop(true);
                    }else{
                        $(this).removeAttr("checked");
                        $(this).prop(false);
                    }

                });






            }
function mov_package_row(){
                var items =new Array();
                
                index =0;
                $("#multi_package tr").find('input[name="record"]').each(function(){
                
                    if($(this).is(":checked")){
                
                    
                        if($(this).parents("tr").find("input[name*='id']").val())
                            {var id=$(this).parents("tr").find("input[name*='id']").val();

                            var req = $.ajax({
                                type: "POST",
                                url: 'montior.php?action=delete_item&id='+id,
                            
                            });
                            
                            req.done(function (msg) {


                        
                            });

                            $(this).parents("tr").remove();
                            }
                            else{$(this).parents("tr").remove();}
                        
                    } });
                    

                

                    
                


                var num=0;
                $('td.numOfItem' ).each(function () {

                    $(this).html(++num);

                });

                var numx = 0;
                $('td.chkAction' ).each(function () {
            //alert(numx);
            var x = $(this).children('input[type="checkbox"]') ;
            $(x).attr("name","order_status["+ numx +"][]");
           
                    numx++;
                    

                });



                $('td.editchkAction' ).each(function () {
                    //alert(numx);
                    var x = $(this).children('input[type="checkbox"]') ;
                    $(x).attr("name","order_status["+ numx +"][]");
                  
                            numx++;
                            
                    
                        });

                        
                $("input[type='checkbox']").each(function (){

                    //  alert("1");
                    if(this.checked) {
                        //Do stuff
                        $(this).attr("checked","checked");
                        $(this).prop(true);
                    }else{
                        $(this).removeAttr("checked");
                        $(this).prop(false);
                    }
                    
                });




}

$(document).ready(function (){

    $("input[type='checkbox']").change(function (){

      //  alert("1");
         //  alert("1");
         if(this.checked) {
            //Do stuff
            $(this).attr("checked","checked");
            $(this).prop(true);
        }else{
            $(this).removeAttr("checked");
            $(this).prop(false);
        }
       // alert($(this).val());
 

    });

});

$(document).change(function (){
    $("input[type='checkbox']").change(function (){

        //  alert("1");
              //  alert("1");
              if(this.checked) {
                //Do stuff
                $(this).attr("checked","checked");
                $(this).prop(true);
            }else{
                $(this).removeAttr("checked");
                $(this).prop(false);
            }
   
  
      });
});

$(document).ready(function (){
    $('body').on('click', 'input[type=\'checkbox\']', function() {
         //  alert("1");
         if(this.checked) {
            //Do stuff
            $(this).attr("checked","checked");
            $(this).prop(true);
        }else{
            $(this).removeAttr("checked");
            $(this).prop(false);
        }
       // alert($(this).val());
    });

    $("input[type='checkbox']").click(function (){

        //  alert("1");
          if(this.checked) {
              //Do stuff
              $(this).attr("checked","checked");
              $(this).prop(true);
          }else{
              $(this).removeAttr("checked");
              $(this).prop(false);
          }
         // alert($(this).val());
   
  
      });
});

var error =0;
function check_edit_order(form_id){
error = 0;
    ///////////////////////////////////////////////////////////////////////////////////////////
//alert("");
    var tr = 1
    $("#multi_package tr").each(function(){

        if($(this).attr('id') == 'head')
        {
           
            }else{

                // var name=$("tr.editchkAction").children().attr("name");
                // ///////////validate of order_status  in edit_order///////////////
               
                //    if($(this).val()=='1' && $( "input[name='"+name+"'][value='2']" ).attr("checked")=="checked")
                //     {
                //             alert("غير مسموح اختيار شامل و اخرة معا");
                //             $( "input[name='"+name+"'][value='2']" ).removeAttr("checked");
                        
                //     }
                //     if($(this).val()=='2' && $( "input[name='"+name+"'][value='1']" ).attr("checked")=="checked")
                //     {
                //             alert("غير مسموح اختيار شامل و اخرة معا");
                //             $( "input[name='"+name+"'][value='1']" ).removeAttr("checked");
                           
                //     }


                // if($(this).find('select[name="package_type[]"]').val()=="")
                //     { alert( "حدد السمك");  error++;}
                if($(this).find('input[name="length[]"]').val()=="")
                    { alert( "حدد الطول"); error++;}
                if($(this).find('input[name="width[]"]').val()=="")
                    {alert("حدد العرض"); error++;}
                var numberOfChoices=0;
                
                //alert($(this).find( "input[name^='order_status'][checked]" ).attr('checked') );
                
                var attr = $(this).find( "input[name^='order_status'][checked]" ).attr('checked');

                //if (typeof attr !== typeof undefined && attr !== false) {
                    // ...
                

                // if($(this).find( "input[name^='order_status']" ).prop('checked')==true || $(this).find( "input[name^='order_status'][checked]" ).attr('checked') == "checked"){
                           
    
                // }else{
        
                //     alert(" حدد نوع الشغل فى الصف رقم "+tr); 
                //     error++;
                // } 
           // }
            
            
            }
       // alert($(this).find('input[name="id[]"]').val());
tr++;
    });

    
if(error==0){ 
        $("#")
    $( "#"+form_id ).submit();
}
   
   
}
/*$(document).ready(function (){
    $("select[name='option_type']").change(function (){

        alert( $("select[name='option_type']").val());
        var valueOfoption_type = $( "select[  name='option_type' ]" ).val();
    
      
       $('.chkAction' ).children('input[type="checkbox"]').removeAttr("checked");

         $('.chkAction' ).children('input[type="checkbox"]').removeAttr("disabled");



        if(valueOfoption_type==1)
            {  

                $('.chkAction' ).children('input[value="1"]').attr("checked","checked");
                $('.chkAction' ).children('input[value="1"]').prop("checked",true);
             
            }
        else if(valueOfoption_type==2)
            {   
               

                $('.chkAction' ).children('input[value="2"]').attr("checked","checked");
                $('.chkAction' ).children('input[value="2"]').prop("checked",true);
               

            }



    })

});*/

function check_order_ststes()
    {

        var valueOfoption_type = $( "select[  name='option_type' ]" ).val();
      
       $('.chkAction' ).children('input[type="checkbox"]').removeAttr("checked");
    //   $('.chkAction' ).children('input[value="2"]').removeAttr("checked");

         $('.chkAction' ).children('input[type="checkbox"]').removeAttr("disabled");



        if(valueOfoption_type==1)
            {  // $('.chkAction' ).children('input[type="checkbox"]').attr("disabled",false);
               // $('.chkAction' ).children('input[type="checkbox"]').attr("checked",false);

                $('.chkAction' ).children('input[value="1"]').attr("checked","checked");
                $('.chkAction' ).children('input[value="1"]').prop("checked",true);
              //  $('.chkAction' ).children('input[value="1"]').attr("checked",true);
                // $('.chkAction' ).children('input[value="2"]').attr("disabled","disabled");
                // $('.chkAction' ).children('input[value="3"]').attr("disabled","disabled");
                // $('.chkAction' ).children('input[value="4"]').attr("disabled","disabled");
                // $('.chkAction' ).children('input[value="5"]').attr("disabled","disabled");
            }
        else if(valueOfoption_type==2)
            {   
               // $('.chkAction' ).children('input[type="checkbox"]').attr("disabled",false);
              //  $('.chkAction' ).children('input[type="checkbox"]').attr("checked",false);

                $('.chkAction' ).children('input[value="2"]').attr("checked","checked");
                $('.chkAction' ).children('input[value="2"]').prop("checked",true);
               // $('.chkAction' ).children('input[value="2"]').attr("checked",true);
                //  $('.chkAction' ).children('input[value="1"]').attr("disabled","disabled");
                // $('.chkAction' ).children('input[value="3"]').attr("disabled","disabled");
                // $('.chkAction' ).children('input[value="4"]').attr("disabled","disabled");
                // $('.chkAction' ).children('input[value="5"]').attr("disabled","disabled");

            }

    }


    $(document).ready(function (){

        $(window).load(function(){

           // check_order_ststes();
        });

        $("#add_orderss select[name='option_type']").change(function(){

            check_order_ststes();
        });

    });

function estimate_price() {

    //var y = check_form();
    var y = true;
    if (y) {

        var data = $('#add_orderss').serialize();

        var req = $.ajax({
            type: "POST",
            url: 'index.php?action=estimate_price',
            data: data
        });

        req.done(function (msg) {
            //	alert(msg);

            $("#result").html(msg);
            $("#result").dialog({
                    modal: true,
                    title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Estimated Cost</h4></div>",
                    title_html: true,
                    buttons: {

                        OK: function () {
                            $(this).dialog("close");

                        }
                    }
                }
            );


        });
        req.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });


    } else {

    }

}

function isNumber(value) {
    if ((undefined === value) || (null === value)) {
        return false;
    }
    if (typeof value == 'number') {
        return true;
    }
    return !isNaN(value - 0);
}

function calc(id) {
    var ids = id.split('_');
//	alert(ids[1]);

    if (isNumber($("#" + id).val())) {

        var x = new Array();

        x[0] = $("#skidq_" + ids[1]).val();
        x[1] = $("#skidl_" + ids[1]).val();
        x[2] = $("#skidw_" + ids[1]).val();
        x[3] = $("#skidh_" + ids[1]).val();

        var total = 1;

        for (var i = 0; i < x.length; i++) {
            if (x[i] != 0 || x[i] != "") {
                total = Number(total) * (x[i]);
            }
        }
        if (total == 1) total = 0;
        //alert(total);
        total = Number(total) / 1728;
        //alert(total);
        $("#skidt_" + ids[1]).val(total);


        calc_total();

    } else {
        alert("All values should be numeric");
    }

    return;
}

function calcw(id) {
    var ids = id.split('_');
//	alert(ids[1]);

    if (isNumber($("#" + id).val())) {

        var x = new Array();

        x[0] = $("#skidq_" + ids[1]).val();
        x[1] = $("#skidwe_" + ids[1]).val();
    }

    var w = 0;
    $('.skid_weight').each(function () {
        w = Number(w) + Number($(this).val());
    });

    $("#tweight").val(w);

}


function calc_total_weight() {
    var r = 0;
    $("#skid tr:not(:first-child, :last-child)  ").each(function () {
        // this represents the row
        //alert($(this).attr("type"));
        r++;

    });
    //alert(r);
    var q = 0;
    var w = 0;
    var total = 0;

    for (var x = 0; x < r; x++) {
        q = Number($("#skidq_" + x).val());
        w = Number($("#skidwe_" + x).val());
        total += q * w;

    }

    $("#tweight").val(total);
}


function calc_total() {
    var r = 0;
    $("#skid tr:not(:first-child, :last-child)  ").each(function () {
        // this represents the row
        //alert($(this).attr("type"));
        r++;

    });
    //alert(r);
    var l = 0;
    var w = 0;
    var h = 0;
    for (var x = 0; x < r; x++) {
        l += Number($("#skidl_" + x).val());
        w += Number($("#skidw_" + x).val());
        h += Number($("#skidh_" + x).val());

    }
    $("#tlength").val(l);
    $("#twidth").val(w);
    $("#theight").val(h);

    if (l == 0) l = 1;
    if (w == 0) w = 1;
    if (h == 0) h = 1;


    var tt = 0;
    for (var x = 0; x < 6; x++) {

        if (isNumber($("#skidt_" + x).val())) {
            tt += Number($("#skidt_" + x).val());
        }

    }


    $("#ttotal").val(tt);


}


function delete_order(order_id, msg) {
    $("#result").html(msg);
    $("#result").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {

                OK: function () {

                    var req = $.ajax({
                        type: "POST",
                        url: 'index.php?action=delete_order&order_id=' + order_id
                    });
                    req.done(function (msg) {


                        $("#tabs").tabs("load", $("#tabs").tabs("option", "selected"));

                    });

                    $(this).dialog("close");

                },

                Cancel: function () {
                    $(this).dialog("close");

                }


            }
        }
    );
}


function add_skid_row() {
    var rowCount = $('#skid tr').length;
    rowCount = rowCount - 3;

    $("#skid tr:last").prev().prev().after("<tr><td>" + (rowCount + 1) + "</td><td><input type=\"text\" name=\"quantiy[]\" id=\"skidq_" + rowCount + "\" onblur=\"calc('skidq_" + rowCount + "');\" value=\"1\" size=\"5\" /></td><td><input type=\"text\" name=\"skid_weight[]\" id=\"skidwe_" + rowCount + "\" onblur=\"calc_total_weight();\" value=\"\" size=\"5\" class=\"skid_weight\"  /></td><td><input type=\"text\" name=\"length[]\" id=\"skidl_" + rowCount + "\" onblur=\"calc('skidl_" + rowCount + "');\" value=\"\" size=\"5\" /></td><td><input type=\"text\" name=\"width[]\"  id=\"skidw_" + rowCount + "\" onblur=\"calc('skidw_" + rowCount + "');\" value=\"\" size=\"5\" /></td><td><input type=\"text\" name=\"height[]\" id=\"skidh_" + rowCount + "\" onblur=\"calc('skidh_" + rowCount + "');\" value=\"\" size=\"5\" /></td><td><input type=\"text\" name=\"total[]\" id=\"skidt_" + rowCount + "\" onblur=\"calc('skidt_" + rowCount + "');\" value=\"\" size=\"5\"  readonly /></td></tr>");

}


function send_request_sig(id, order_id) {


    var req = $.ajax({
        type: "GET",
        url: 'index.php?action=send_google_push_message',
        data: {driver_id: id, order_id: order_id, type: 'request_image'}
    });

    req.done(function (msg) {

    });

}
 


