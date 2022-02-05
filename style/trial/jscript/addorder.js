var is_edit_delivery = 0;


$(function () {

    $("#services_comb").change(function () {
        var element = $(this).find('option:selected');
        var auto_delivery = element.attr("auto_delivery");
        var cut_off = element.attr("cut_off");
        var max_distance = element.attr("max_distance");

        var pickdate = $("#pickup_date").val();
        var picktime = $("#pickup_time").val();
//alert(myTag);
        $('#cutofftime').val(cut_off);
        $('#autodeliverytime').val(auto_delivery);
        $('#max_distance').val(max_distance);

        if (is_edit_delivery == 0) {

            if (auto_delivery != "00:00:00" && auto_delivery != undefined && auto_delivery != null) {
                //alert(auto_delivery.substring(3,5));
                var d = new Date();
                //alert(picktime.substring(picktime.indexOf(":"),picktime.indexOf(" ")));
                d.setHours(picktime.substring(0, picktime.indexOf(":")), picktime.substring(picktime.indexOf(":") + 1, picktime.indexOf(" ")), 00);
                //	alert(d.getHours() + " - " +  auto_delivery.substring(0,2));

                d.setHours(d.getHours() + parseInt(auto_delivery.substring(0, 2)) + 12);
                d.setMinutes(d.getMinutes() + parseInt(auto_delivery.substring(3, 5)));

                $('#delivery_time').timepicker('setTime', d);
            }

            $("#delivery_time").val();

            //alert(pickdate+picktime);
            var deliverydate = $("#delivery_date").val();

            var deliverytime = $("#delivery_time").val();
            //alert(deliverydate+deliverytime);
        }


    });

    $("#pickup_time").change(function () {
        var auto_delivery = $('#autodeliverytime').val();
        var picktime = $("#pickup_time").val();

        if (auto_delivery != "00:00:00" && auto_delivery != "") {
            //alert(auto_delivery.substring(3,5));
            var d = new Date();
            //alert(picktime.substring(picktime.indexOf(":"),picktime.indexOf(" ")));
            d.setHours(picktime.substring(0, picktime.indexOf(":")), picktime.substring(picktime.indexOf(":") + 1, picktime.indexOf(" ")), 00);
            //	alert(d.getHours() + " - " +  auto_delivery.substring(0,2));

            d.setHours(d.getHours() + parseInt(auto_delivery.substring(0, 2)));
            d.setMinutes(d.getMinutes() + parseInt(auto_delivery.substring(3, 5)));

            $('#delivery_time').timepicker('setTime', d);
        }
    });


}); 