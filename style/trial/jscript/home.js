/// register new client page //////////
$("#register_client").ready(function () {
    $(function () {
        $('#register_client #submit').click(function () {


            if (validate_forms("register_client")) {


                var data = $('#register_client').serialize();

                var req = $.ajax({
                    type: "POST",
                    url: $('#register_client').attr('action'),
                    data: data
                });

                req.done(function (msg) {

                    $("#result").html(msg);
                    $("#result").dialog({
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
                        title_html: true,
                        open: function (event, ui) {
                            setTimeout(function () {
                                $('#result').dialog('close');
                            }, 2000);
                        }
                    });
                    // $('#register_client').clearForm();

                });
                req.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });

            } else {
                return false;
            }


        });

    });
});


$.fn.clearForm = function () {
    // iterate each matching form
    return this.each(function () {
        // iterate the elements within the form
        $(':input', this).each(function () {
            var type = this.type, tag = this.tagName.toLowerCase();
            if (type == 'text' || type == 'password' || tag == 'textarea')
                this.value = '';
            else if (type == 'checkbox' || type == 'radio')
                this.checked = false;
            else if (tag == 'select')
                this.selectedIndex = -1;
        });
    });
};


// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};


var placeSearch, from_autocomplete, to_autocomplete;

//  var componentForm = {
//    street_number: 'short_name',
//    postal_code: 'short_name'
//  };

function initAutocomplete() {


    // Create the autocomplete object, restricting the search to geographical
    // location types.
    from_autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('from_address')), {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    from_autocomplete.addListener('place_changed', fillInfromAddress);


    to_autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('to_address')), {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    to_autocomplete.addListener('place_changed', fillIntoAddress);


}

function fillInfromAddress() {
    // Get the place details from the autocomplete object.
    var place = from_autocomplete.getPlace();
    //alert(document.getElementById('from_address'));

//    for (var component in componentForm) {
//      document.getElementById(component).value = '';
//      document.getElementById(component).disabled = false;
//    }

    //alert(JSON.stringify(place));
    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    $("#from_add").val(place.formatted_address);
    for (var i = 0; i < place.address_components.length; i++) {
        //	alert( place.address_components.length);
        var addressType = place.address_components[i].types[0];


        if (addressType == "postal_code") {
            $("#from_pcode").val(place.address_components[i].long_name);
        }


    }

}


function fillIntoAddress() {
    // Get the place details from the autocomplete object.
    var place = to_autocomplete.getPlace();


    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    $("#to_add").val(place.formatted_address);

    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];


        if (addressType == "postal_code") {
            $("#to_pcode").val(place.address_components[i].long_name);
        }
    }

}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            from_autocomplete.setBounds(circle.getBounds());
            to_autocomplete.setBounds(circle.getBounds());
        });
    }
}


function estimate_price_guest() {

    getDistance();

    var data = $('#guest_pricing').serialize();
    //alert(data);

    var req = $.ajax({
        type: "POST",
        url: $('#guest_pricing').attr('action'),
        data: data
    });


    req.done(function (msg) {
        alert(msg);
        var obj = JSON.parse(msg);

        $("#result_dialoge").html(obj.message_html);
        $("#result_dialoge").dialog({
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i>" + obj.message_title + "</h4></div>",
            title_html: true,
            width: '400',
            height: '500',
            buttons: {
                Close: function () {
                    $(this).dialog("close");

                    //document.getElementById('add_orderss').reset();
                }
            }
        });

    });


}



