var added_item = new Array();

var button = [
    {

        text: 'اغلاق',
        click: function () {
            // $("#scanner_data tr").remove();
            $("#scanner_data").find("tr:gt(0)").remove();
            added_item = [];

            $(this).dialog("close");
        }

    }


];


if (userstatus == 2 || (userstatus == 3 & image_only == 0)) {

    button.push({
        text: "ترحيل ",

        //	icons: { primary: "ace-icon fa fa-print bigger-120" },
        click: function () {

            var package_id = added_item.join();
            // alert(package_id+"amr"+userstatus)
            finish_operation('', package_id, userstatus);
            $(this).dialog("close");
            window.location = 'work.php';
            // refreshwaybill(obj.message);
        },
    });


    button.push({
        text: "كسر",
        click: function () {
            var package_id = added_item.join();

            cancel_package(package_id);
            $(this).dialog("close");
            window.location = 'work.php';
        },
    });


}

if (userstatus == 4) {

    if (image_only == "1") {

        button.push({
            text: "داخل فرن",
            click: function () {
                var package_id = added_item.join();

                in_work(package_id, userstatus);

                $(this).dialog("close");
                window.location = 'work.php';
            },
        });

    } else if (image_only == "2") {

        button.push({
            text: "خارج فرن",
            click: function () {

                var package_id = added_item.join();
                out_work(package_id, userstatus);

                $(this).dialog("close");
                window.location = 'work.php';
            },
        });


    }


    button.push({
        text: "كسر",
        click: function () {
            var package_id = added_item.join();

            cancel_package(package_id);
            $(this).dialog("close");
            window.location = 'work.php';
        },
    });

}


if (userstatus == 5) {

    button.push({
        text: "داخل تسليم",
        click: function () {
            var package_id = added_item.join();
            in_work(package_id, userstatus);
            $(this).dialog("close");
            window.location = 'work.php';
        },
    });

    // button.push({
    //     text: "خارج امر توريد",
    //     click: function () {
    //         var package_id = added_item.join();
    //       //  out_work (package_id,userstatus);
    //         out_work_form(package_id,userstatus)
    //   //  $( this ).dialog( "close" );
    //   //  window.location = 'work.php';
    //      },
    // });


    button.push({
        text: "كسر",
        click: function () {
            var package_id = added_item.join();

            cancel_package(package_id);
            $(this).dialog("close");
            window.location = 'work.php';
        },
    });

}

if (userstatus == 'manger') {

    button.push({
        text: "كسر",
        click: function () {
            var package_id = added_item.join();

            cancel_package(package_id);
            $(this).dialog("close");
            window.location = 'work.php';
        },
    });
}

$(document).ready(function () {

    $("#ScannerDialoge").dialog({

        width: '700',
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-search red'></i> نتيجة البحث </h4></div>",
        title_html: true,
        autoOpen: false,
        buttons: button


    });


});


function in_work(package_id, operation) {

    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=start_operation',
        data: { id: package_id, operation: operation }
    });

    req.done(function (msg) {
        //	alert(msg);

    });
}

function out_work(package_id, operation) {

    finish_operation('', package_id, operation)

}


function out_work_form(package_id, operation) {
    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=out_order',
        data: { id: package_id }
    });

    req.done(function (msg) {
        $("#result_dialoge_2").html(msg);
        $("#result_dialoge_2").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>  صور الطلبية </h4></div>",
            title_html: true,
            width: '800',
            height: '600',
            position: { my: "center", at: "top" },
            buttons: [
                {
                    text: "حفظ",
                    click: function () {

                        location.href = 'work.php?action=create_out_order&id=' + package_id;

                    }
                },
                {
                    text: "غلق",
                    click: function () {
                        $("#result_dialoge_2").dialog("close");
                    }
                }

            ]
        });

    });

}

$(document).bind('scannerDetectionComplete', function (e, data) {
    //alert(e+" - "+data);
})

$(document).scannerDetection({
    timeBeforeScanTest: 300, // wait for the next character for upto 200ms
    startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
    endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
    avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
    preventDefault: false,
    ignoreIfFocusOn: 'input',
    onError: function (string, e) {
        alert('Error ' + string + e);
    },
    onComplete: function (barcode, e) {

        // alert(barcode);

        var req = $.ajax({
            type: "POST",
            url: 'work.php?action=search',
            data: { barcode: barcode }
        });

        req.done(function (msg) {
            console.log(msg);
            //    alert(msg);
            msg.trim();

            if (msg != false) {

                if ($('#ScannerDialoge').dialog('isOpen') == true) {


                } else {
                    $('#ScannerDialoge').dialog('open');


                }


                var res = '';
                res = JSON.parse(msg);
                // alert(added_item.indexOf(res.id));

                //alert(added_item.length);
                if (added_item.indexOf(res.id) == -1) {

                    added_item.push(res.id);

                    var tr = $('<tr>').append(
                        $('<td>').text(res.easy_order_id + '-' + res.part_order),
                        $('<td>').text('-'),
                        $('<td>').text(res.length),
                        $('<td>').text(res.width),
                        $('<td>').text(res.company_name),
                        $('<td>').text(res.glasscolour),
                        // $('<td>').text(res.glassPrint),
                        $('<td>').text(res.glassType),
                        // $('<td>').text(res.glassScarch),
                        $('<td>').text(res.glassPointing),
                        $('<td>').html('<button class="delrow btn btn-xs btn-danger" data="' + res.id + '"><i class="ace-icon fa fa-trash-o bigger-120"></i></button>')
                    );
                    tr.appendTo('#scanner_data');


                }


            } else {
                get_piecs_details(barcode);

            }


        });


    } // main callback function
});

// $("#auto_search_items").ready(function (){
//     document.querySelector('#auto_search_items').addEventListener('keypress', function (e) {
//       //  alert("hello")
//         if (e.key === 'Enter') {
//             auto_search1(document.getElementById('auto_search_items').value);
//         }
//     });

// });




function auto_search(barcode) {

    // alert(barcode);
    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=search_text',
        data: { barcode: barcode }
    });

    req.done(function (msg) {
        console.log(msg);
        //    alert(msg);
        msg.trim();

        if (msg != false) {
            
            var res = '';
            res = JSON.parse(msg);

            if ($("#auto_search_items").length) {


                var myitem = res.easy_order_id + "-" + res.part_order;
                auto_search1(myitem);
                return;
            } else {

                if ($('#ScannerDialoge').dialog('isOpen') == true) {


                } else {
                    $('#ScannerDialoge').dialog('open');


                }
            }


            if (added_item.indexOf(res.id) == -1) {

                added_item.push(res.id);

                var tr = $('<tr>').append(
                    $('<td>').text(res.easy_order_id + '-' + res.part_order),
                    $('<td>').text('-'),
                    $('<td>').text(res.length),
                    $('<td>').text(res.width),
                    $('<td>').text(res.company_name),
                    $('<td>').text(res.glasscolour),
                    //  $('<td>').text(res.glassPrint),
                    $('<td>').text(res.glassType),
                    // $('<td>').text(res.glassScarch),
                    $('<td>').text(res.glassPointing),
                    $('<td>').html('<button class="delrow btn btn-xs btn-danger" data="' + res.id + '"><i class="ace-icon fa fa-trash-o bigger-120"></i></button>')
                );
                tr.appendTo('#scanner_data');


            }


        } else {
            get_piecs_details(barcode);


        }


    });

    return false;

}
function auto_search1(barcode) {

    // alert(barcode);
    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=search_text1',
        data: { barcode: barcode }
    });

    req.done(function (msg) {
        // console.log(msg);
        //    alert(msg);
        // msg.trim();

        if (msg != false) {

            // if ($('#ScannerDialoge').dialog('isOpen') == true) {
            //
            //
            // } else {
            //     $('#ScannerDialoge').dialog('open');
            //
            //
            // }


            // var res = '';
            // res = JSON.parse(msg);
            // alert(added_item.indexOf(res.id));

            //alert(added_item.length);
            //             if (added_item.indexOf(res.id) == -1) {
            //
            //                 added_item.push(res.id);

            // var tr = $('<tr>').append(
            //     $('<td>').text(res.easy_order_id + '-' + res.part_order),
            //     $('<td>').text('-'),
            //     $('<td>').text(res.length),
            //     $('<td>').text(res.width),
            //     $('<td>').text(res.company_name),
            //     $('<td>').text(res.glasscolour),
            //     $('<td>').text(res.glassPrint),
            //     $('<td>').text(res.glassType),
            //     $('<td>').text(res.glassScarch),
            //     $('<td>').text(res.glassPointing),
            //     $('<td>').html('<button class="delrow btn btn-xs btn-danger" data="' + res.id + '"><i class="ace-icon fa fa-trash-o bigger-120"></i></button>')
            // );
            console.log(msg)
            // if(msg!=0)
            document.getElementById('result1').innerHTML = msg;
            show_image(document.getElementById('imgId').value);




        } else {
            get_piecs_details(barcode);


        }


    });

    return false;

}

$('#auto_form_submit').submit(function (e) {
    console.log('test2')
    e.preventDefault();
    auto_search($('#auto_search_item').val());

});

function print_barcode() {

    var y = "";
    $("input:checked").each(function () {
        y = y + $(this).val() + ",";

    });

    if (y == "") {
        alert(y + "من فضلك اختار قطع للطباعة");
    } else {
        //  alert(y+"من فضلك اختار قطع للطباعة");

        y = y.substring(0, y.length - 1);
        show_barcode(y);
    }

}


function print_outside() {
    window.open('work.php?action=printer_option', "طباعة", 'width=400,height=500');

}

function get_piecs_details(barcode) {

    // alert(barcode);
    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=get_pieces_details',
        data: { barcode: barcode }
    });

    req.done(function (msg) {
        console.log(msg);
        //    alert(msg);
        msg.trim();

        if (msg != false) {

            var res = '';
            res = JSON.parse(msg);

            alert('القطهة غير موجودة فى العميلة . تاكد من تواجد القطعه فى : ' + res.myoperation);





        } else {

            alert("هذة القطعة غير موجودة فى هذة العملية ");

        }


    });

    return false;


}


$(document).ready(function () {

    $('body').on('click', '.delrow', function () {
        var data = $(this).attr('data');
        //alert(data);
        added_item.splice(added_item.indexOf(data), 1);
        ;
        $(this).parent().parent().remove(); //Deleting the Row (tr) Element

        // Your Code
    });


});
