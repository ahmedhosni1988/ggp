var added_item = new Array();


function auto_search(barcode) {

    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=search_text',
        data: {barcode: barcode, type: 'all'}
    });

    req.done(function (msg) {
        console.log(msg);
        //    alert(msg);
        msg.trim();

        if (msg != false) {


            var res = '';
            res = JSON.parse(msg);
            // alert(added_item.indexOf(res.id));

//alert(added_item.length);
            if (added_item.indexOf(res.id) == -1) {

                added_item.push(res.id);

                var tr = $('<tr>').append(
                    $('<td>').text(res.easy_order_id + '-' + res.part_order),
                    $('<td>').text(res.length),
                    $('<td>').text(res.width),
                    $('<td>').text(res.package_name),
                    $('<td>').html('<button class="delrow btn btn-xs btn-danger" data="' + res.id + '"><i class="ace-icon fa fa-trash-o bigger-120"></i></button>')
                );
                tr.appendTo('#print_resut');


            }


        } else {
            alert("هذة القطعة غير موجودة فى هذة العملية ");

        }


    });

    return false;

}
function finish_order_barcode(){
    var finish_order=document.getElementById('finish_order_id').value;
    // alert(finish_order)
    // alert(userstatus)
    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=finish_operation',
        data: {order_id: '', id: '', operation: userstatus,all:finish_order}
    });


    req.done(function (msg) {
        $("#result_dialoge").html("تم ترحيل الطلب");
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

}
function print_order_barcode(SITEURL){
   
    var easy_order_id=$('#easy_order_id').val();
    console.log('test',easy_order_id) 

    var req = $.ajax({
        type: "POST",
        url: 'work.php?action=printer_order',
        data: {easy_order_id: easy_order_id}
    });

    
    req.done(function (msg) {
        msg=msg.trim();
        console.log(msg);
        
       if(msg=='error'){
        $("#result_dialoge").html('لا توجد طلبية بهذا الرقم او لم يتم تشغيلها');
        $("#result_dialoge").dialog({
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> رساله</h4></div>",
                title_html: true,
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                    }
                }
            }
        );
            

        }else window.open(SITEURL+"/labels.php?id="+msg.slice(0, -1)); 
    })

}
function print_barcode() {

    var y = "";
    $.each(added_item, function (index, value) {
        //  alert( index + ": " + value );
        y = y + value + ",";
    });


    if (y == "") {
        alert("من فضلك اختار قطع للطباعة");
    } else {
        y = y.substring(0, y.length - 1);
        show_barcode(y);
    }

}


function print_outside() {
    window.open('work.php?action=printer_option', "طباعة", 'width=400,height=500');

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


    $('form#out_side_print').submit(function (e) {
        e.preventDefault();
        //  alert($('#auto_search').val());
        auto_search($('#auto_search').val());

    });


});


function show_barcode(id) {
    //window.location = siteurl+"/labels.php?order_id="+id+"&clid=&acctno="+acctno;
   
   window.open(siteurl + "/labels.php?id=" + id, '_blank');
    

    



}