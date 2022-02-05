$(document).ready(function () {
   





    $($('form').prop('elements')).each(function () {

        if (this.type != "button" || this.type != "submit" || this.type != "hidden") {

            var validate = $(this).attr("validate");

            if ($(this).attr("validate") && validate != "") {

                if (validate == "notempty") {
                    $(this).css('border', '1px solid red');

                }

            }


        }


    });

});



function dotheneedful(sibling) {
    if (sibling != null) {
      start.focus();
      start.style.backgroundColor = '';
      start.style.color = '';
      sibling.focus();
      sibling.style.backgroundColor = 'green';
      sibling.style.color = 'white';
      start = sibling;
    }
  }


// $("#multi_package").ready(function (){

// var start = document.getElementById('start');
// start.focus();
// start.style.backgroundColor = 'green';
// start.style.color = 'white';

//     document.onkeydown = checkKey;

//     function checkKey(e) {
    
//         e = e || window.event;
//         if (e.keyCode == '38') {
//           // up arrow
//           var idx = start.cellIndex;
//           var nextrow = start.parentElement.previousElementSibling;
//           if (nextrow != null) {
//             var sibling = nextrow.cells[idx];
//             dotheneedful(sibling);
//           }
//         } 
        
//         if (e.keyCode == '40') {
//           // down arrow
//           var idx = start.cellIndex;
//           var nextrow = start.parentElement.nextElementSibling;
//           if (nextrow != null) {
//             var sibling = nextrow.cells[idx];
//             dotheneedful(sibling);
//           }
//         } 
//          if (e.keyCode == '37') {
//           // left arrow
//           var sibling = start.previousElementSibling;
//           dotheneedful(sibling);
//         } 
//          if (e.keyCode == '39') {
//           // right arrow
//           var sibling = start.nextElementSibling;
//           dotheneedful(sibling);
//         }
    
//     }

// });

jQuery(function ($) {
    $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
        _title: function (title) {
            var $title = this.options.title || '&nbsp;'
            if (("title_html" in this.options) && this.options.title_html == true)
                title.html($title);
            else title.text($title);
        }
    }));
});


function getItems(exampleNr) {
    var columns = [];

    $(exampleNr + ' ul.sortable-list').each(function () {
        columns.push($(this).sortable('toArray').join(','));
    });

    return columns.join('|');
}

function update_driver_admin(ele) {

    var req = $.ajax({
        type: "POST",
        url: 'driver.php?action=update_driver_admin',
        data: {driver_id: ele.value}
    });

    req.done(function (msg) {

        //alert(msg);
    });

}

function edit_invoice() {
    var data = $('#invoice_setting').serialize();
    var req = $.ajax({
        type: "POST",
        url: $("#invoice_setting").attr('action'),
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


                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}


function printData(id) {

    var head = document.getElementsByTagName('head')[0].innerHTML;
   // alert(head);
    var headContent = "<html dir=\"rtl\"><body>";
    //$("#"+id).remove(".removeprint");
    var divToPrint = document.getElementById(id);

    //  var jHtmlObject = jQuery(divToPrint.outerHTML);
    //  jHtmlObject.removeClass(".removeprint");
    //  divToPrint.remove("");
    var footer = "</body></html>";
    newWin = window.open("");
    newWin.document.write(headContent + divToPrint.outerHTML + footer);
    newWin.print();
    newWin.close();
}

$('button').on('click', function () {
    printData();
})

function edit_cat(catid) {

    var req = $.ajax({
        type: "GET",
        url: 'admin_index.php?action=cateory_ajax',
        data: {cat_id: catid, ajax: "edit", cat_name: $('#cat_name_edit').val(), cat_type: $("#cat_type_edit").val()}
    });

    req.done(function (msg) {

        var first = getUrlVars(msg)["res"];

        if (first == "true#" || first == "true") {
            $('#edit_Cat').empty();
            $('#edit_Cat').text('Category Edited Succefully');
            $("#edit_Cat").hide(2000, function () {
                window.location.replace(msg);
            });


        } else {

        }


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}


function getUrlVars(url) {
    var vars = [], hash;
    url.replace("#", "");
    var hashes = window.location.href.slice(url.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


function add_row_ser() {
    var rowCount = $('#services_table tr').length;
    rowCount = rowCount - 1;
    $("#services_table").last().append("<tr><input type=\"hidden\" name=\"service_id[]\"  value=\"\" /><td><input type=\"text\" name=\"service_name[]\" value=\"\" /></td><td><input type=\"text\" name=\"service_short[]\" value=\"\" size=\"15\"/></td><td><textarea name=\"sevices_description[]\" ></textarea> </td><td><input type=\"text\" name=\"service_color[]\" id=\"service_color_" + rowCount + "\" value=\"\" size=\"6\" /></td><td><input type=\"text\" name=\"service_cuttoff[]\" id=\"service_cuttoff_" + rowCount + "\" value=\"\" size=\"7\"/></td><td><input type=\"text\" name=\"service_order[]\" value=\"\" size=\"2\" /></td></tr>");

    $('#service_cuttoff_' + rowCount + '').timepicker({});

    $('#service_color_' + rowCount + '').ColorPicker({
        onSubmit: function (hsb, hex, rgb, el) {
            $(el).val(hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
            $(this).ColorPickerSetColor(this.value);
        }
    })
        .bind('keyup', function () {
            $(this).ColorPickerSetColor(this.value);
        });

}


function add_row_tax() {
    var rowCount = $('#tax_table tr').length;
    rowCount = rowCount - 1;
    $("#tax_table").last().append("<tr><input type=\"hidden\" name=\"tax_id[]\"  value=\"\" /><td><input type=\"text\" name=\"tax_name[]\" value=\"\" size=\"15\"/></td><td><input type=\"text\" name=\"tax_rate[]\" value=\"\" size=\"5\"/></td></tr>");


}

function check_add_form() {
    var x = true;
    var $inputs = $('#add_user :input');
    var values = {};
    $('.error').remove();
    $('.postive').remove();
    $inputs.each(function () {
        values[this.name] = $(this).val();
        if ($(this).val() == "") {
            $(this).css("float", "left");

            if (this.name == 'fax' || this.name == 'address') {

            } else {

                $(this).parent('div').append('<div class="error">Requied Field</div>');

                x = false;
            }
        } else {
            if ($(this).attr('type') == 'submit' || $(this).attr('type') == 'button') {

            } else if (this.name == 'email' && !check_email($(this).val())) {

                $(this).parent('div').append('<div class="error">Enter Vaild Email</div>');

                x = false;


            } else if (this.name == 'user_name') {


                var req = $.ajax({
                    type: "GET",
                    url: 'users.php',
                    data: {action: "check_username", user_name: $(this).val()}
                });

                req.done(function (msg) {
                    //	alert(msg);
                    if (msg == 0) {
                        $(this).parent('div').append('<div class="error">This name is used</div>');
                        x = false;
                    } else {
                        $(this).parent('div').append('<div class="postive">&nbsp;</div>');
                    }


                });
                req.fail(function (jqXHR, textStatus) {
                    alert('Handler for .submit() called.');


                });
            } else {


                $(this).parent('div').append('<div class="postive">&nbsp;</div>');

            }

        }
    });

    return x;
}


function check_email(email) {
    var hasError = false;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var emailblockReg =
        /^([\w-\.]+@(?!gmail.com)(?!yahoo.com)(?!hotmail.com)([\w-]+\.)+[\w-]{2,4})?$/;
    if (!emailReg.test(email)) hasError = true;

    if (hasError == true) return false;
    else return true;
}

function check_name(username) {
    var z = false;

}


function show_edit_driver(driver_id, name, tabname) {
    var url = "driver.php?action=edit&id=" + driver_id;
    var name1 = "Edit driver : " + name;
    open_new_tab(url, name1, tabname);
    //$("#"+tabname).tabs( "add" , url ,  name1  , ($("#"+tabname).tabs( "length" )) );
}


function add_edit_driver() {

    var y = validate_forms('edit_driver');

//	var y = true;
    if (y) {
        var data = $('#edit_driver').serialize();
//alert(data);
        var req = $.ajax({
            type: "POST",
            url: $('#edit_driver').attr('action'),
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

                        if ($("#driver_id").val() == "") {


                            $("#tabs").tabs("load", 0);
                            //  $( "#tabs").tabs( "refresh" );


                        } else {
                            var wtab = $("#edit_driver").parent().parent().attr('id');
                            var mtab = $("#edit_driver").parent().parent().parent().parent().attr('id');

                            close_my_tab(wtab, '');

                            //  $("#"+wtab).tabs( "remove" , $("#"+wtab).tabs( "option" , "selected"  )  );
                            //$("#"+wtab).tabs( "load" , 0  );
                        }
                    }
                }
            });


            //$("#"+wtab).tabs( "select" , 0  );
        });
        req.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
    }

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
                    url: "accounts.php?action=delete_client_user",
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

function show_edit_account(account_id, name) { 
    var url = "accounts.php?action=mange_add_account&account_id=" + account_id;
    var name1 = "تعديل عميل_"+ name;
    open_new_tab(url, name1, 'tabs');

}


function show_edit_suppliers(account_id, name) {
    var url = "inventory.php?action=mange_add_account&account_id=" + account_id;
    var name1 = "تعديل المورد  : " + name;
    open_new_tab(url, name1, 'suppliers');

}

function show_mange_users(account_id, name) {
    var url = "accounts.php?action=manage_account&id=" + account_id;
    var name1 = "Mange Account : " + name;
    open_new_tab(url, name1, 'tabs');
}

function edit_user_client(user_id, name) {
    var url = "accounts.php?action=edit_client_user&id=" + user_id;
    var name1 = "Edit : " + name;
    var wtab = $("#tabs").children().attr('id');
    // alert(wtab);
    $(".tabs_man").tabs("add", url, name1, ($(".tabs_man").tabs("length")));
}

function del_user_client(user_id, name) {

    var x = confirm('Are you sure to Delete ' + name + ' user? No way to return data...');
    if (x) {
        var req = $.ajax({
            type: "GET",
            url: 'accounts.php?action=delete_client_user&id=' + user_id
        });

        req.done(function (msg) {
            alert(msg);

            $(".tabs_man").tabs("load", 0);

        });
        req.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });


    } else {

    }


}


function add_driver_s() {

    var y = check_add_form();
    if (y) {

        var data = $('#add_driver').serialize();

        var req = $.ajax({
            type: "POST",
            url: $('#add_driver').attr('action'),
            data: data
        });

        req.done(function (msg) {

            alert(msg);
            $("#result").html(msg);
            $("#result").dialog({
                    modal: true,
                    title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
                    title_html: true,
                    buttons: {
                        Ok: function () {
                            $(this).dialog("close");

                        },
                        Cancel: function () {
                            $(this).dialog("close");
                            $("#tabs").tabs("refresh");

                            //$("#tabs").tabs( "load" , 0  );
                            //$("#tabs").tabs( "select" , 0  );

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


function close_tab(element) {

    $(".tabs_man").find('.ui-tabs-nav li:eq(' + $(".tabs_man").tabs("option", "active") + ')').remove();
    $(".tabs_man").tabs("refresh");

}


function add_unassign(account_id, name) {
    var url = "accounts.php?action=edit_unassign&id=" + account_id;
    var name1 = "Edit Account : " + name;
    open_new_tab(url, name1, 'tabs')

}

function remove_unassign(account_id, name) {
    var x = confirm('Are you sure to Delete this Client? No way to return data...');
    if (x) {

        var req = $.ajax({
            type: "GET",
            url: "accounts.php?action=del_unassign",
            data: {id: account_id}
        });

        req.done(function (msg) {
            // $("#tabs").tabs( "load" , "accounts.php#tabs-10"  );
            $("#dialouge").html(msg);
            $("#dialouge").dialog({
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
                title_html: true,
                buttons: {
                    "OK": function () {
                        $(this).dialog("close");

                        $("#tabs").tabs('load', 0);
                    },
                }
            });


        });
        req.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });


    }
}


function edit_page_post(id) {
    var data = $("#update_page_" + id).serialize();
    var page_body = $("#editor1").html();

    data = data + "&page_body=" + page_body;
    // alert(data);
    var req2 = $.ajax({
        type: "POST",
        url: $("#update_page_" + id).attr("action"),
        data: data
    });
    req2.done(function (msg) {

        $("#result_dialoge").html(msg);

        $("#result_dialoge").dialog({
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                "Close": function () {
                    $(this).dialog("close");
                }
            }
        })


    });

}

function edit_page(id) {

    var url = "admin_index.php?action=mange_page&id=" + id + "&type=edit_page";
    open_new_tab(url, "Edit Page", 'tab_pages');

//	
//var req = $.ajax({
//			type: "GET",
//			url: "admin_index.php?action=mange_page",
//			data: {id:id , type:"edit_page" }
//			});
//	 
//	 			req.done(function( msg ) {


//	 				$("#result_dialoge").html(msg);
//						
//						$( "#result_dialoge" ).dialog({ 
//							resizable: false,
//							modal: true,
//							title: "Message",
//							title_html: true,
//		    width: '750',
//			height:'500',
//													  buttons: { 
//													  "Update":function () {
//														  
//														
//														  var data = $("#update_page_"+id).serialize();
//														  alert(data);
//														  var req2 = $.ajax({
//			type: "POST",
//			url: $("#update_page_"+id).attr("action"),
//			data: data
//			});
//														  req2.done(function (msg){
//															$("#update_page_"+id).remove();
//
//															$("#page_body_"+id).remove();
//															for(name in CKEDITOR.instances)
//{
//    CKEDITOR.instances[name].destroy()
//}
//
//																			 });
//														  
//														  
//														  		  $(this).dialog("close"); 
//
//																      $("#tabs").tabs( "load" ,6 );
//														  },
//              "Close": function() { 
//                                $(this).dialog("close"); 
//                               															$("#page_body_"+id).remove();
//																						for(name in CKEDITOR.instances)
//{
//    CKEDITOR.instances[name].destroy()
//}
//
//							
//							 
//                        }, 
//                } 
//        });
//							


    //		});


}


/////////////////////////////////// user temp function ////////////////////////////////

$("#add_user").ready(function () {
    $(function () {
        $('#add_user #submit').click(function () {

            var y = validate_forms('add_user');
            //	alert(y);
            if (y) {

                var data = $('#add_user').serialize();

                var req = $.ajax({
                    type: "POST",
                    url: $('#add_user').attr('action'),
                    data: data
                });

                req.done(function (msg) {

                    $("#tabs").tabs("refresh");
                    $('#tabs').tabs('option', 'active', 0);


                });
                req.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });


            } else {

            }
            return false;
            alert('Handler for .submit() called.');

        });

    });
});


//$("#edit_user").ready(function(){
//$(function() {
//$('#edit_user #submit').click(function() {
//								
//
//		
//		var data = $('#edit_user').serialize();
//	
// var req = $.ajax({
//			type: "POST",
//			url: $('#edit_user').attr('action'),
//			data: data
//			});
// 
//			req.done(function( msg ) {
//				
//				$("#tabs").find('.ui-tabs-nav li:eq('+$("#tabs").tabs( "option" , "active"  )+')').remove();
//				  $( "#tabs" ).tabs( "refresh" );
//					 $('#tabs').tabs('option', 'active',0 );
//			     
//				
//			});
//			req.fail(function(jqXHR, textStatus) {
//               alert( "Request failed: " + textStatus );
//             });		
//	
//
//
//	return false;
//    alert('Handler for .submit() called.');
//	
//});
//
//});
//});


function delete_user(user_id) {

    $("#result").html('Are you sure to Delete this user? Once the record is deleted you will not be able to Retrieve it');
    $("#result").dialog({
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
        title_html: true,
        buttons: {
            Ok: function () {
                var req = $.ajax({
                    type: "GET",
                    url: 'users.php?action=delete&user_id=' + user_id
                });

                req.done(function (msg) {
                    var wtab = $("#user_table").parent().parent().attr('id');

                    $("#" + wtab).tabs("load", 0);

                    //$("#"+wtab).tabs( "select" , 0  );
                });
                req.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });

                $(this).dialog("close");

            },
            Cancel: function () {
                $(this).dialog("close");
            }
        }
    });


}

function show_edit_user(user_id, name) {
    var url = "users.php?action=edit&id=" + user_id;
    var name1 = "تعديل مستخدم  : " + name;
    open_new_tab(url, name1, 'tabs_man');

}

function show_edit_userclient(user_id, name) {
    var url = "accounts.php?action=edit_client_user&userid=" + user_id;
    var name1 = "تعديل المستخدم  : " + name;
    open_new_tab(url, name1, 'tabs_man');

}


function show_edit_userclientportal(user_id, name) {
    var url = "client_admin.php?action=edituser&userid=" + user_id;
    var name1 = "Edit User : " + name;
    open_new_tab(url, name1, 'tabs_man');

}


function close_edit() {

    close_my_tab('tabs_man', '0')
}



////////////////////////////////finish usertemp function///////
//$( "#item_size_id" ).on("input", function() {
    
function item_name_now(){$("#item_name_id").val("زجاج"+" "+$("#item_thickness_id option:selected ").text()+" "+$("#item_color_id option:selected ").text()+" "+$("#item_company_id option:selected ").text()+" "+$("#item_size_id option:selected ").text());}
//////////////////////


function credit_note_acount(ele,id){

    //	alert($(ele).val());

    $('#select_credit_invoice_no_'+id).find('option').not(':first').remove();

    var account_id = $(ele).val();

    var req = $.ajax({
        type : "POST",
        url  : 'credit_note.php?action=get_account_invoices',
        datatype : "json",
        data : {account_id}

    });

    req.done(function( msg ) {

        //$("#system_time").html(msg);
        // console.log(msg);
        // console.log(msg[0]);
        // console.log(count(msg));

        var obj = JSON.parse(msg);
        obj.forEach(function(item){
            $('#select_credit_invoice_no_'+id).append('<option value="'+item.id+'">'+item.id+'</option>');

        });
        $("#credit_invoice_no_"+id).css('display','block');
        //alert(msg);
    });


}


function credit_note_invoice(ele,id){

    //	alert($(ele).val());

    var invoice_id = $(ele).val();

    var req = $.ajax({
        type : "POST",
        url  : 'credit_note.php?action=get_invoices_orders',
        datatype : "json",
        data : {invoice_id}

    });

    req.done(function( msg ) {

        var obj = JSON.parse(msg);
        obj.forEach(function(item){
            $('#select_credit_order_no_'+id).append('<option value="'+item.order_id+'">'+item.order_id+'</option>');

        });
        $("#credit_order_id"+id).css('display','block');

        //$("#system_time").html(msg);

    });


}




function add_form_php(form_id, aftersuccess) {

//alert($('#'+form_id).attr('action'));
    if (validate_forms(form_id)) {

        var data = $('#' + form_id).serialize();
        //alert(data);
        var req = $.ajax({
            type: "POST",
            url: $('#' + form_id).attr('action'),
            data: data
        });

        req.done(function (msg) {


            if (aftersuccess == '0') {
                location.reload();
            } else if (aftersuccess == '1') {

                $("#result_dialoge").html(msg);
                $("#result_dialoge").dialog({
                    resizable: false,
                    modal: true,
                    title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
                    title_html: true,
                    buttons: {
                        Ok: function () {
                            $(this).dialog("close");
                            location.reload(); 
                        },
                        Cancel: function () {
                            $(this).dialog("close");
                            location.reload(); 
                        }
                    }
                });
                 }


        });
        req.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });


    } else {

        $("#result_dialoge").html("Error in Validation");

        $("#result_dialoge").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });
    }


}

////category page

function show_edit_cat(catid, name) {

    var url = "admin_index.php?action=category_edit&cat_id=" + catid;
    var name1 = "Edit Category : " + name;
    open_new_tab(url, name1, 'cat');
}

function cat_del(id) {
    //alert(id);
    var req = $.ajax({
        type: "GET",
        url: 'admin_index.php?action=deletecat&cat_id=' + id

    });

    req.done(function (msg) {
        $("#cat_del").html(msg);
        $("#cat_del").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");
                    $("#cat").tabs("load", 0);

                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}


function add_cat() {
    var data = $('#add_cat1').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#add_cat1').attr('action'),
        data: data
    });

    req.done(function (msg) {
        $("#cat_dia").html(msg);
        $("#cat_dia").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");
                    $("#cat").tabs('option', 'active', 0);
                    //$( "#cat" ).tabs( "refresh" );
                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function edit_cata() {
    var data = $('#edit_cat').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#edit_cat').attr('action'),
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
                    close_my_tab("cat", '0')
                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}

///////////////////////end category function


///////////////service function 

function add_servicesss() {


    var data = $('#add_services').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#add_services').attr('action'),
        data: data
    });

    req.done(function (msg) {
        $("#service_dia").html(msg);
        $("#service_dia").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");

                    $("#ser").tabs('option', 'active', 0);
                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}

function edit__services(id, name) {
    var url = "admin_index.php?action=edit_service&id=" + id;
    var name1 = "Edit Services : " + name;
    open_new_tab(url, name1, 'ser');
}

function edit_servicesss() {

    var data = $('#edit_services').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#edit_services').attr('action'),
        data: data
    });

    req.done(function (msg) {
        $("#service_dia_edi").html(msg);
        $("#service_dia_edi").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");
                    close_my_tab("ser", '0')

                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}

///////////////////////////////////////


/////addtion services ////////////

function edit_add_service(id, name) {
    var url = "pricing.php?action=price_checkbox&what=edit&id=" + id;
    var name1 = "Edit : " + name;
    open_new_tab(url, name1, 'check_option');
}

function add_addservices() {
    var data = $('#add_check').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#add_check').attr('action'),
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
                    $("#check_option").tabs('option', 'active', 0);
                }
            }
        });

    });


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}

function delete_add_service(id1) {


    var req = $.ajax({
        type: "GET",
        url: "pricing.php?action=price_checkbox&what=delete",
        data: {id: id1}
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

    $("#check_option").tabs("load", 0);

    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}

function edit_addservices(id) {
    var data = $('#edit_check_'+id).serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#edit_check_'+id).attr('action'),
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
                    close_my_tab("check_option", '0')
                }
            }
        });

    });


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}

////////////////////////////


///////vechile services//////////////

function add_vec_services() {


    var data = $('#add_addservice').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#add_addservice').attr('action'),
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
                    $("#add_option").tabs('option', 'active', 0);

                }
            }
        });

    });


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}

function delete_vec_service(id1) {


    var req = $.ajax({
        type: "GET",
        url: "pricing.php?action=price_addtional&what=delete",
        data: {id: id1}
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
                    $("#add_option").tabs("load", 0);

                }
            }
        });

    });


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}

function edit_vec_service(id, name) {
    var url = "pricing.php?action=price_addtional&what=edit&id=" + id;
    var name1 = "Edit : " + name;
    open_new_tab(url, name1, 'add_option');
}

function edit_vecservices() {
    var data = $('#edit_addservice').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#edit_addservice').attr('action'),
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
                    close_my_tab("add_option", '0')

                }
            }
        });

    });


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}

////////////////////////////////////////////////package services for vechiles

function add_pac_services() {


    var data = $('#add_pacervice').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#add_pacervice').attr('action'),
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
                    $("#price_pac").tabs('option', 'active', 0);
                    location.reload(); 

                }
            }
        });

    });


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function delete_pac_service(id1) {


    var req = $.ajax({
        type: "GET",
        url: "pricing.php?action=price_pac&what=delete",
        data: {id: id1}
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
                    $("#price_pac").tabs("load", 0);

                }
            }
        });

    });


    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}

function edit_pac_service(id, name) {
    var url = "pricing.php?action=price_pac&what=edit&id=" + id;
    var name1 = "Edit : " + name;
    open_new_tab(url, name1, 'price_pac');
}

function edit_pacservices() {
    var data = $('#edit_pacservice').serialize();

    var req = $.ajax({
        type: "POST",
        url: $('#edit_pacservice').attr('action'),
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
                    close_my_tab("price_pac", '0');

                }
            }
        });

    });

    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}


//////////////////////////////cash receipts part /////////////////

function cashreceipts_history(account_id, account_name, date) {
    //alert(date);
    var req = $.ajax({
        type: "POST",
        url: 'accounting.php?action=cash_receipts_history',
        data: {account_id: account_id, from_invoice_date: date}
    });

    req.done(function (msg) {


        $("#result_dialoge").html(msg);

        $("#result_dialoge").dialog({
            modal: true,
            resizable: true,
            width: 'auto',
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> الدفعة الأخيرة من " + account_name + " منذ " + date + "</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='ace-icon glyphicon glyphicon-time bigger-110'></i>&nbsp; 3 شهور",
                    "class": "btn btn-danger btn-xs",
                    click: function () {
                        $(this).dialog("close");
                        cashreceipts_history(account_id, account_name, addMonths(new Date(), -3));
                    }
                }
                ,
                {
                    html: "<i class='ace-icon glyphicon glyphicon-time bigger-110'></i>&nbsp; 6 شهور",
                    "class": "btn btn-danger btn-xs",
                    click: function () {
                        $(this).dialog("close");
                        cashreceipts_history(account_id, account_name, addMonths(new Date(), -6));

                    }
                }
                ,
                {
                    html: "<i class='ace-icon glyphicon glyphicon-time bigger-110'></i>&nbsp; 12 شهور",
                    "class": "btn btn-danger btn-xs",
                    click: function () {
                        $(this).dialog("close");
                        cashreceipts_history(account_id, account_name, addMonths(new Date(), -12));

                    }
                }
                ,
                {
                    html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; اغلاق",
                    "class": "btn btn-xs",
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            ]
        });

    });

    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}

var cash_value = '';

function cashreceipts_add(account_id, account_name, date) {

    //alert(cash_value);
    var date = '';
    var url = '';
    if (cash_value == '') url = 'accounting.php?action=cash_receipts_new';
    if (cash_value == 'commit') url = 'accounting.php?action=cash_receipts_new&type=commit';
    if (cash_value == 'viewpayment') url = 'accounting.php?action=cash_receipts_new&type=viewpayment';

    cash_value = '';
    data = $('#add_cash_' + account_id).serialize();

    if (data != '') data = data;
    else data = "account_id=" + account_id;

	// alert(data);
    var req = $.ajax({
        type: "POST",
        url: url,
        data: data
    });

    req.done(function (msg) {


        $("#result_dialoge").html(msg);
// console.log(msg)
        $("#result_dialoge").dialog({
            modal: true,
            resizable: true,
            width: 'auto',
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> إيصالات استلام المبلغ للحساب : " + account_name + " فى " + date + "</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='ace-icon glyphicon glyphicon-time bigger-110'></i>&nbsp; تنفيذ الدفع",
                    "class": "btn btn-danger btn-xs",
                    click: function () {
                        $(this).dialog("close");
                        cash_value = 'commit';
                        cashreceipts_add(account_id, account_name, date);
                    }
                }
                ,
                {
                    html: "<i class='ace-icon glyphicon glyphicon-time bigger-110'></i>عرض طرق الدفع",
                    "class": "btn btn-danger btn-xs",
                    click: function () {
                        $(this).dialog("close");
                        cash_value = 'viewpayment';
                        cashreceipts_add(account_id, account_name, date);

                    }
                }
                ,
                {
                    html: "<i class='ace-icon glyphicon glyphicon-time bigger-110'></i>&nbsp; تنظيف",
                    "class": "btn btn-danger btn-xs",
                    click: function () {
                        $(this).dialog("close");
                        cash_value = 'clear';
                        cashreceipts_add(account_id, account_name, date);

                    }
                }
                ,
                {
                    html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; اغلاق",
                    "class": "btn btn-xs",
                    click: function () {
                        $(this).dialog("close");
                        location.reload();
                    }
                }
            ]
        });

    });

    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function edit_console(id) {

    var urls = "admin_index.php?action=mconsole&console_id=" + id;

    var req = $.ajax({
        type: "post",
        url: urls,
        data: {items: getItems('#example-2-1')}
    });

    req.done(function (msg) {

        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");

                },
                Cancel: function () {
                    $(this).dialog("close");

                }
            }
        });

    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


    //alert(getItems('#example-2-1'));

}


function delete_contract(id) {
    $("#result_dialoge").html("Are You sure to delete This Contract? All Deliveiries will be removed.");
    $("#result_dialoge").dialog({
        resizable: false,
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
        title_html: true,
        buttons: {
            Ok: function () {
                $(this).dialog("close");

                var req = $.ajax({
                    type: "post",
                    url: 'contract.php?action=delete',
                    data: {contractno: id, type: 'contract'}

                });

                req.done(function (msg) {

                    location.reload();
                });


            },
            Cancel: function () {
                $(this).dialog("close");

            }
        }
    });
}


function delete_contract_delivery(id) {
    $("#result_dialoge").html("Are You sure to delete This Deliviery?");
    $("#result_dialoge").dialog({
        resizable: false,
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
        title_html: true,
        buttons: {
            Ok: function () {
                $(this).dialog("close");

                var req = $.ajax({
                    type: "post",
                    url: 'contract.php?action=delete',
                    data: {contractno: id, type: 'deliviery'}

                });

                req.done(function (msg) {

                    location.reload();
                });


            },
            Cancel: function () {
                $(this).dialog("close");

            }
        }
    });
}


function add_contracts() {
    var y = validate_forms('add_contract');
    if (y) {
        $("#add_contract").submit();
    }
}


function set_clid(id) {
    $("#clid").val(id);
}

function show_hide(val, id) {

    if (val == "1") $("#" + id).show();
    else $("#" + id).hide();
}

function show_fsapply() {
    $("#fs_apply").show();
}

function show_hide_fsapply() {
    if ($("#fsovrd").value != "")
        $("#fs_apply").show();
    else {
        $("#fs_apply").hide();
        document.contract_details_form.fs_on_service.checked = false;
        document.contract_details_form.fs_on_wait.checked = false;
        document.contract_details_form.fs_on_xtra.checked = false;
    }
}

function add_contracts_delivery() {
    var y = validate_forms('add_delivery');
    if (y) {
        $("#add_delivery").submit();
    }
}


var res = 1;

function make_report_search() {

    var data = $('#main_report').serialize();
    //alert(data);
    var url = $('#main_report').attr('action') + "&" + data + "&res=" + res;

    //alert(url);
    // $("#page").html(url);
    var req = $.ajax({
        type: "POST",
        url: $('#main_report').attr('action'),
        data: data
    });

    req.done(function (msg) {
        //	alert(msg);


        //alert(msg);
        open_new_tab(url, "Search Result " + res, "tabs");
        res++;


        //drawsearchresult(msg);

    });

    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function make_aged_report_search() {

    var data = $('#aged_report').serialize();
    //alert(data);
//var url = $('#aged_report').attr('action') + "&" + data;


    var req = $.ajax({
        type: "POST",
        url: $('#aged_report').attr('action'),
        data: data
    });

    req.done(function (msg) {

        if (msg == "true") {


        } else {


            $("#result_dialoge").html(msg);
            $("#result_dialoge").dialog({
                resizable: false,
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
                title_html: true,
                width: 800,
                buttons: {
                    Close: function () {
                        $(this).dialog("close");
                    },
                    Print: function () {
                        window.open("report.php?action=print&type=aged_report&" + data, '_blank');
                        //window.location = "report.php?action=print_aged_report&"+data;
                    }
                }
            });
        }


        //drawsearchresult(msg);

    });

    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}

function make_console_grid_sort(data, type) {

    var field_name = data['coloum_fieldname'];
    var table = data['table_name'];


    var url = window.location.href;
    //alert(type);

    var req = $.ajax({
        type: "POST",
        url: url + "&ajax=1",
        data: {table_name: table, field_name: field_name, dir: type}
    });

    req.done(function (msg) {
        $("#grid").html(msg);
    });

}

function make_aged_report_search() {

    var data = $('#aged_report').serialize();
    //alert(data);
//var url = $('#aged_report').attr('action') + "&" + data;


    var req = $.ajax({
        type: "POST",
        url: $('#aged_report').attr('action'),
        data: data
    });

    req.done(function (msg) {

        if (msg == "true") {


        } else {


            $("#result_dialoge").html(msg);
            $("#result_dialoge").dialog({
                resizable: false,
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Aged Report</h4></div>",
                title_html: true,
                width: 800,
                buttons: {
                    Close: function () {
                        $(this).dialog("close");
                    },
                    Print: function () {
                        window.open("report.php?action=print&type=aged_report&" + data, '_blank');
                        //window.location = "report.php?action=print_aged_report&"+data;
                    }
                }
            });
        }


        //drawsearchresult(msg);

    });

    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}

function make_statment_report_search() {

    var data = $('#statment_report').serialize();
    //alert(data);
//var url = $('#aged_report').attr('action') + "&" + data;


    var req = $.ajax({
        type: "POST",
        url: $('#statment_report').attr('action'),
        data: data
    });

    req.done(function (msg) {


        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Account Statment Report</h4></div>",
            title_html: true,
            width: 800,
            buttons: {
                Close: function () {
                    $(this).dialog("close");
                },
                Print: function () {
                    window.open("report.php?action=print&type=statment_report&" + data, '_blank');
                    //window.location = "report.php?action=print_aged_report&"+data;
                }
//						,{
//							text : 'Resend Invoices';
//						click: function(){
//							window.open("report.php?action=resend&type=statment_report&"+data, '_blank');
//							//window.location = "report.php?action=print_aged_report&"+data;
//						}
//						}
            }
        });


        //drawsearchresult(msg);

    });

    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}

function search(source, name) {

    for (var i = 0; i < source.length; i++) {
        var se = source[i];
        if (se[name]) return se[name];
    }


}

/////////////////////search driver payment 

function driver_search_payment(email) {

    var data = $('#driver_payment').serialize();


    if (email == "1") {
        data += "&email=1";
    } else {
        data += "&email=0";
    }
//alert(data);
    var req = $.ajax({
        type: "POST",
        url: $('#driver_payment').attr('action'),
        data: data
    });

    req.done(function (msg) {


        if (email == "0") {
            $("#searchresult").empty();
            $("#searchresult").append(msg);
        }

        if (email == "1") {
            alert(msg);
        }

    });


}


function alldriver_search_payment(email) {

    var data = $('#all_driver_payment').serialize();


    if (email == "1") {
        data += "&email=1";
    } else {
        data += "&email=0";
    }
//alert(data);
    var req = $.ajax({
        type: "POST",
        url: $('#all_driver_payment').attr('action'),
        data: data
    });

    req.done(function (msg) {


        if (email == "0") {
            $("#searchresultall").empty();
            $("#searchresultall").append(msg);
        }

        if (email == "1") {
            alert(msg);
        }

    });


}


function delete_photo(order_id) {

    var req = $.ajax({
        type: "POST",
        url: 'montior.php?action=delete_photo',
        data: {id: order_id}
    });

    req.done(function (msg) {

        alert(msg);


    });

}

function passant_order(sorted_order) {
    //alert(sorted_order);

    var req = $.ajax({
        type: "POST",
        url: 'montior.php?action=sort_driver_orders',
        data: {data: sorted_order}
    });

    req.done(function (msg) {


        //alert(msg);

    });

}


function price_checkbox_account(account_id) {  

    var data = $('#price_checkbox_account_'+account_id).serialize();
    // alert(data);



    var req = $.ajax({
        type: "POST",
        url: $('#price_checkbox_account_'+account_id).attr('action'),
        data: data
    });

    req.done(function (msg) { 


        $("#result_dialoge").html(msg);
        $("#result_dialoge").dialog({
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>رسالة</h4></div>",
            title_html: true,
            width: 800,
            buttons: {
                اغلاق: function () {
                    $(this).dialog("close");
                }
					
            }
        });


       

    });

    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


