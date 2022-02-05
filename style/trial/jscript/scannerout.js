var added_item = new Array();


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
            data: {barcode: barcode, account_id: account_id}
        });

        req.done(function (msg) {
            console.log(msg);
            //    alert(msg);
            msg.trim();

            if (msg != false) {


                var res = '';
                res = JSON.parse(msg);
                // alert(added_item.indexOf(res.id));

                if (res.error != undefined) {
                    alert(res.error);
                    return;
                }

//alert(added_item.length);
                if (added_item.indexOf(res.id) == -1) {

                    added_item.push(res.id);
                    added_item.sort();
                    append_Db(res.id, 'add');

                    var tr = $('<tr>').append(
                        $('<td>').text(res.easy_order_id + '-' + res.part_order),
                        $('<td>').text(res.operation_name),
                        $('<td>').text(res.office_name),
                        $('<td>').text(res.package_name),
                        $('<td>').text(res.length),
                        $('<td>').text(res.width),
                        $('<td>').text(res.company_name),
                        $('<td>').text(res.glasscolour),
                        $('<td>').text(res.glassPrint),
                        $('<td>').text(res.glassType),
                        $('<td>').text(res.glassScarch),
                        $('<td>').text(res.glassPointing),
                        $('<td>').html('<button class="delrow btn btn-xs btn-danger" data="' + res.id + '"><i class="ace-icon fa fa-trash-o bigger-120"></i></button>')
                    );
                    tr.appendTo('#scannerout_data');


                }


            } else {
                alert("هذة القطعة غير موجودة فى هذة العملية ");

            }


        });


    } // main callback function
});


$(document).ready(function () {

    $('body').on('click', '.delrow', function () {
        var data = $(this).attr('data');
        //alert(data);
        append_Db(data, 'remove');
        added_item.splice(added_item.indexOf(data), 1);
        ;
        added_item.sort();
        $(this).parent().parent().remove(); //Deleting the Row (tr) Element

        // Your Code
    });


});

function append_Db(pid, type) {

    // alert(pid+id+type);
    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=append_out_order',
        data: {pid: pid, id: id, type: type}
    });


    req.done(function (msg) {

        //  alert(msg);
    });

}


$('#auto_form_submit').submit(function (e) {
    e.preventDefault();
    auto_search($('#auto_search_item').val());

});

function auto_search(barcode) {

    // alert(barcode);
    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=search_text',
        data: {barcode: barcode, account_id: account_id}
    });

    req.done(function (msg) {
        console.log(msg);
        //    alert(msg);
        msg.trim();

        if (msg != false) {
            var res = '';
            res = JSON.parse(msg);
            // alert(added_item.indexOf(res.id));
            if (res.error != undefined) {
                alert(res.error);
                return;
            }
            //alert(added_item.length);
            if (added_item.indexOf(res.id) == -1) {
                
                added_item.push(res.id);
                added_item.sort();
                append_Db(res.id, 'add');

                var tr = $('<tr>').append(
                    $('<td>').text(res.easy_order_id + '-' + res.part_order),
                    $('<td>').text(res.operation_name),
                    $('<td>').text(res.office_name),
                    $('<td>').text(res.package_name),
                    $('<td>').text(res.length),
                    $('<td>').text(res.width),
                    $('<td>').text(res.company_name),
                    $('<td>').text(res.glasscolour),
                    $('<td>').text(res.glassPrint),
                    $('<td>').text(res.glassType),
                    $('<td>').text(res.glassScarch),
                    $('<td>').text(res.glassPointing),
                    $('<td>').html('<button class="delrow btn btn-xs btn-danger" data="' + res.id + '"><i class="ace-icon fa fa-trash-o bigger-120"></i></button>')
                );
                tr.appendTo('#scannerout_data');
            }

        } else {
            alert("هذة القطعة غير موجودة فى هذة العملية ");

        }


    });

    return false;

}