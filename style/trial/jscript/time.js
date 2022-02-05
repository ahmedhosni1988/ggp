function tpStartOnHourShowCallback(hour) {
    var tpEndHour = $('#delivery_time').timepicker('getHour');
    // all valid if no end time selected
    if ($('#delivery_time').val() == '') {
        return true;
    }
    // Check if proposed hour is prior or equal to selected end time hour
    if (hour <= tpEndHour) {
        return true;
    }
    // if hour did not match, it can not be selected
    return false;
}

function tpStartOnMinuteShowCallback(hour, minute) {
    var tpEndHour = $('#delivery_time').timepicker('getHour');
    var tpEndMinute = $('#delivery_time').timepicker('getMinute');
    // all valid if no end time selected
    if ($('#delivery_time').val() == '') {
        return true;
    }
    // Check if proposed hour is prior to selected end time hour
    if (hour < tpEndHour) {
        return true;
    }
    // Check if proposed hour is equal to selected end time hour and minutes is prior
    if ((hour == tpEndHour) && (minute < tpEndMinute)) {
        return true;
    }
    // if minute did not match, it can not be selected
    return false;
}


function tpEndOnHourShowCallback(hour) {
    var tpStartHour = $('#pickup_time').timepicker('getHour');
    // all valid if no start time selected
    if ($('#pickup_time').val() == '') {
        return true;
    }
    // Check if proposed hour is after or equal to selected start time hour
    if (hour >= tpStartHour) {
        return true;
    }
    // if hour did not match, it can not be selected
    return false;
}

function tpEndOnMinuteShowCallback(hour, minute) {
    var tpStartHour = $('#pickup_time').timepicker('getHour');
    var tpStartMinute = $('#pickup_time').timepicker('getMinute');
    // all valid if no start time selected
    if ($('#pickup_time').val() == '') {
        return true;
    }
    // Check if proposed hour is after selected start time hour
    if (hour > tpStartHour) {
        return true;
    }
    // Check if proposed hour is equal to selected start time hour and minutes is after
    if ((hour == tpStartHour) && (minute > tpStartMinute)) {
        return true;
    }
    // if minute did not match, it can not be selected
    return false;
}


function start_date() {

}


function end_date() {


    var x = $("#pickup_date").datepicker("getDate");
    if (x == null) {

        alert("You SHould Choose Pickup Date First");


    } else {
        $("#delivery_date").datepicker('option', 'minDate', x);
    }


}



