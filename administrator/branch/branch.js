var added_item = new Array();


$(document).bind('scannerDetectionComplete', function (e, data) {
    //alert(e+" - "+data);
});

    
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

       //  alert(barcode);

         

        var req = $.ajax({
            type: "POST",
            url: 'index.php?action=search',
            data: {barcode: barcode}
        });

        req.done(function (msg) {
            console.log(msg);
            //    alert(msg);
            msg.trim();

            if (msg != false) {
                var res = '';
                res = JSON.parse(msg);
                // alert(added_item.indexOf(res.id));
                alert(added_item.length);
                if (added_item.indexOf(res.id) == -1) {
                    added_item.push(res.id);
                    var tr = $('<tr>').append(
                        $('<td>').text(res.easy_order_id + '-' + res.part_order),
                        $('<td>').text('-'),
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
                    tr.appendTo('#scanner_data tbody');
                    //alert();
                }


            } else {
                alert("هذة القطعة غير موجودة فى هذة العملية ");

            }


        });


    } // main callback function
});

