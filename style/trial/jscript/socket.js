var socket;
var system_id;
var user_id
var driver_id = 0;

var driversDetails;

var map;
var mar = new Array();
var m = 0;


function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}


var has_ws = 0;

function checkWebSocket() {

    try {

        var websocket = new WebSocket("wss://socket.courier-connex.com/socket");
        // websocket.close();
        has_ws = 0;
//    var req = $.ajax({
//		type: "GET",
//		url: 'http://www.courier-connex.com/server/testwebsock.php'
//		});

    } catch (e) { //throws code 15 if has socket to me babies
        has_ws = 1;

//    var req = $.ajax({
//		type: "GET",
//		url: 'http://www.courier-connex.com/server/testwebsock.php'
//		});

    }

}

//checkWebSocket();

function init(system_id, user_id, driverDetail) {
    driversDetails = driverDetail;
    system_id = system_id;
    user_id = user_id;
    var host = "wss://socket.courier-connex.com/socket"; // SET THIS TO YOUR SERVER
    try {


        socket = new WebSocket(host);
        log('WebSocket - status ' + socket.readyState);
        socket.onopen = function (msg) {
            log("Welcome - status " + this.readyState);
            // alert(system_id+'_'+user_id);
            send('{"action":"my_name","data":"' + system_id + '_' + user_id + '"}');
        };
        socket.onmessage = function (msg) {
            //alert(JSON.stringify(msg.data));
            update_marker(msg.data, system_id);
            log("Received: " + msg.data);

        };
        socket.onclose = function (msg) {

            socket.close();
            log("Disconnected - status " + this.readyState);
        };


    }
    catch (ex) {
        log(ex);
    }
    $("msg").focus();
    //socket.send("id::10");

    //alert(JSON.stringify(driversDetails));
    //alert(Object.keys(driversDetails).length);
    //console.log(driversDetails);

    //alert(driversDetails);
    if (driversDetails != '' || driversDetails != 'undefined') {
        //alert("x");
        if (Object.keys(driversDetails).length > 0) {
            drawDriverDetails(driversDetails);
        }
    }

}


function getdriverdetails(id) {

    for (var i = 0; i < Object.keys(driversDetails).length; i++) {


        if (typeof driversDetails[i] === 'undefined') {

        } else {

            if (driversDetails[i].id == id) {
                return driversDetails[i];
            }

        }
    }


}

function drawDriverDetails(driverDetails) {

    var list = $('ul.tracklist');
    for (var i = 0; i < Object.keys(driverDetails).length; i++) {


        if (typeof driverDetails[i] === 'undefined') {

        } else {

            var but = $('<button/>', {
                html: "<span class='drivername'>" + driverDetails[i].name + "</span><span id= 'info_" + driverDetails[i].id + "'></span>",
                id: 'dbtn_' + driverDetails[i].id,
                class: 'driverbutton'

            });
            var li = $('<li/>');
            but.appendTo(li);
            li.appendTo(list);
            //$('<span/>'),{id:'info_'+driverDetails[i].id}
            // but.innerHtml = "<span id= 'info_"+driverDetails[i].id+"'></span>";

            $("#driverdetails").append(but);

        }
    }

}


function updateDriverDetails(driver_id, type) {

    if ($("#dbtn_" + driver_id).length) {

        $("#dbtn_" + driver_id).removeClass("btn-warning btn-info btn-danger btn-success");
        if (type == "sendingpush") {
            $("#info_" + driver_id).html("Connecting...");
            $("#dbtn_" + driver_id).addClass("btn-warning");

            $("#dbtn_" + driver_id).attr("data-sort", "2");
        }

        if (type == "sentpush") {
            $("#info_" + driver_id).html("Requesting");
            $("#dbtn_" + driver_id).addClass("btn-info");
            $("#dbtn_" + driver_id).attr("data-sort", "1");

        }

        if (type == "gpsclosed") {
            $("#dbtn_" + driver_id).addClass("btn-danger");
            $("#dbtn_" + driver_id).attr("data-sort", "0");
            $("#info_" + driver_id).html("GPS Off !!!");
        }

        if (type == "gpsupdated") {
            $("#dbtn_" + driver_id).addClass("btn-success");
            $("#dbtn_" + driver_id).attr("data-sort", "-1");
            $("#dbtn_" + driver_id).attr("onclick", "focus_marker(" + driver_id + ")");
            $("#info_" + driver_id).html("Located");
        }


//		 $('button').sort(function (a, b) {
//
//		      var contentA =parseInt( $(a).attr('data-sort'));
//		      var contentB =parseInt( $(b).attr('data-sort'));
//		      return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
//		   })

    }
}

function focus_marker(driver_id) {
    map.setZoom(17);
    map.panTo(mar[driver_id].position);
}

function handleNoGeolocation(errorFlag) {
    var newyork = new google.maps.LatLng(40.69847032728747, -73.9514422416687);

    if (errorFlag == true) {
        // alert("Geolocation service failed.");
        initialLocation = newyork;
    } else {
        //   alert("Your browser doesn't support geolocation. We've placed you in Nework.");
        initialLocation = siberia;
    }
    map.setCenter(initialLocation);
}


function send(msg) {

    try {
        socket.send(msg);
        log('Sent: ' + msg);
    } catch (ex) {
        log(ex);
    }
}

function quit() {
    if (socket != null) {
        log("Goodbye!");
        socket.close();
        socket = null;
    }
}

function reconnect() {
    quit();
    init();

}

function log(msg) {
    //alert(msg);
//	$(".modal").css("display","block");
//	$(".modal").css("width","300");
//	$(".modal").css("height","300");
//	$(".modal").css("background","#fff");
//	$(".modal").append("<br>"+msg); 

}


function initMap(initial_address) {


    var mapOptions = {
        zoom: 14,

        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE
        }
    };

    map = new google.maps.Map(document.getElementById("map"), mapOptions);

    geocoder = new google.maps.Geocoder();

    geocoder.geocode({'address': initial_address}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {

            //In this case it creates a marker, but you can get the lat and lng from the location.LatLng
            map.setCenter(results[0].geometry.location);

        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });


//		google.maps.event.addListener(map, 'zoom_changed', function() {
//		    zoomChangeBoundsListener = 
//		        google.maps.event.addListener(map, 'bounds_changed', function(event) {
//		            if (this.getZoom() > 15 && this.initialZoom == true) {
//		                // Change max/min zoom here
//		                this.setZoom(15);
//		                this.initialZoom = false;
//		            }
//		        google.maps.event.removeListener(zoomChangeBoundsListener);
//		    });
//		});


}


function update_marker(msg, system_id) {


    var driver_id = getParameterByName("did", window.location.href);

    //alert(driver_id);
    var page_name = location.pathname.substring(location.pathname.lastIndexOf("/") + 1);
    //alert();

    var json = JSON.stringify(msg);
    $("#status").append(json);

    var obj = JSON.parse(msg);
    //alert(obj.result);

    if (obj.hasOwnProperty("id")) {

    } else {
        return;
    }
    var myarr = obj.id.split("__");

    if (myarr[0] == system_id) {

        console.log(obj);

        if (obj.driver_id != driver_id && page_name != "trackdrivers.php") {
            return;
        }

        if (obj.result == "1") {
            updateDriverDetails(driver_id, "gpsclosed");
            $("#track_driver").attr('disable', true);
            $(".alert").show();
            return;
        } else {
            $("#track_driver").attr('enable', true);
            $(".alert").hide();
        }


        if (obj.type == "0" || obj.type == "1" || obj.type == "2") {

            //alert(obj.lat);

            if (obj.lat == "0.0" || obj.lng == "0.0" || obj.lat == "0" || obj.lng == "0") {
                updateDriverDetails(obj.driver_id, "gpsclosed");
                //alert("Gps Not Working ");
                return;
            }
            var point = new google.maps.LatLng(obj.lat, obj.lng)


            var news = 0;
            if (typeof mar[obj.driver_id] === 'undefined') {
                // does not exist

                var drivvalues = getdriverdetails(obj.driver_id);


                mar[obj.driver_id] = new google.maps.Marker({
                    position: point,
                    map: map,
                    animation: google.maps.Animation.DROP,
                    label: drivvalues.name
                });
                news = 1;

            }
            else {
                // does exist

                mar[obj.driver_id].setPosition(point);
            }

            updateDriverDetails(obj.driver_id, "gpsupdated");

            if (news == 1) {
                var bounds = new google.maps.LatLngBounds();

                //alert(mar.length);

                for (var i = 0; i < mar.length; i++) {

                    if (typeof mar[i] === 'undefined') {

                    } else {
                        //alert(i);
                        bounds.extend(mar[i].getPosition());
                    }

                }

//	
//	if (bounds.getNorthEast().equals(bounds.getSouthWest())) {
//		   var extendPoint = new google.maps.LatLng(bounds.getNorthEast().lat() + 0.01, bounds.getNorthEast().lng() + 0.01);
//		   bounds.extend(extendPoint);
//		}
//	
//	


//	map.initialZoom = true;
                map.fitBounds(bounds);
            }

            //map.setCenter(point);
            m++;

        }

    }


}

function track_driver(id, type, name) {


    driver_id = id;
    //alert(driver_id);
    updateDriverDetails(driver_id, "sendingpush");
    var req = $.ajax({
        type: "GET",
        url: 'index.php?action=send_google_push_message',
        data: {driver_id: id, type: type}
    });

    req.done(function (msg) {
//alert(msg);

        updateDriverDetails(id, "sentpush");


        if (type == "1") {
            $("#track_driver").text("Stop Tracking " + name);
            $("#track_driver").attr('onclick', 'track_driver(' + id + ',2,\'' + name + '\')');
        }

        if (type == "2") {
            updateDriverDetails(id, "stoptrack");
            $("#track_driver").text("Start Tracking " + name);
            $("#track_driver").attr('onclick', 'track_driver(' + id + ',1,\'' + name + '\')');


        }
        //var myWindow = window.open("index.php?action=track&type="+type+"&did="+id, "_blank", "width=600, height=600");
        // var win = window.open('index.php?action=track&type='+type, '_blank');
        //  win.focus();
        //$("#bu_"+id).append('<i class="ace-icon fa fa-spinner fa-spin orange bigger-125"></i>');
    });

}


$(window).bind("beforeunload", function () {

    for (var i = 0; i < mar.length; i++) {

        if (typeof mar[i] === 'undefined') {

        } else {
            //alert(i);
            track_driver(i, '2', '')
            //	bounds.extend(mar[i].getPosition());
        }

    }

    // return confirm("Do you really want to close?");
})




