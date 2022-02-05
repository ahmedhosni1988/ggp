function add_message() {

    var data = $('#send_form').serialize();


    var req = $.ajax({
        type: "POST",
        url: $('#send_form').attr('action'),
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
                    document.getElementById('send_form').reset()
                    $(this).dialog("close");
                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });


}


function view_mess(id) {
    var req = $.ajax({
        type: "GET",
        url: "messages.php?action=view_message",
        data: {m_id: id}
    });

    req.done(function (msg) {

        $("#result").html(msg);
        $("#result").dialog({
            modal: true,
            width: 600,
            height: 400,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Ok: function () {
                    if (document.getElementById('send_form')) {
                        document.getElementById('send_form').reset();
                    }
                    $("#tabs").tabs("load", $("#tabs").tabs("option", "selected"));

                    $(this).dialog("close");

                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}


function replay_mess(id) {
    var req = $.ajax({
        type: "GET",
        url: "messages.php?action=replay",
        data: {m_id: id}
    });

    req.done(function (msg) {

        $("#result").html(msg);
        $("#result").dialog({
            modal: true,
            width: 600,
            height: 550,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa  fa-envelope red'></i> Message</h4></div>",
            title_html: true,
            buttons: {
                Replay: function () {
                    var data = $('#replay_form').serialize();
                    var req = $.ajax({
                        type: "POST",
                        url: "messages.php?action=replay",
                        data: data
                    });


                    $("#tabs").tabs("load", $("#tabs").tabs("option", "selected"));

                    $(this).dialog("close");

                },
                Close: function () {
                    $(this).dialog("close");
                }
            }
        });


    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}

function close_mess(id) {

    var req = $.ajax({
        type: "GET",
        url: "messages.php?action=close",
        data: {m_id: id}
    });

    req.done(function (msg) {


        $("#tabs").tabs("load", $("#tabs").tabs("option", "selected"));

    });
    req.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}