function forgetpassword() {

    if (validate_forms("forget_password")) {


        var data = $('#forget_password').serialize();

        var req = $.ajax({
            type: "POST",
            url: $('#forget_password').attr('action'),
            data: data
        });

        req.done(function (msg) {

            var res = JSON.parse(msg);

            if (res.type == "error") {
                grecaptcha.reset();
                $("#result").html(res.message);
                $("#result").dialog({
                    modal: true,
                    title: "Error",
                    title_html: true,
                    open: function (event, ui) {
                        setTimeout(function () {
                            $('#result').dialog('close');
                        }, 4000);
                    }
                });

//alert(res.message);
            } else {
                $("#result").html(res.message);
                $("#result").dialog({
                    modal: true,
                    title: "Message",
                    title_html: true,
                    open: function (event, ui) {
                        setTimeout(function () {
                            $('#result').dialog('close');
                        }, 4000);
                    }
                });
                window.location.href = 'index.php?e=10';


            }


        });
        req.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

    } else {
        return false;
    }

}


function newpassword() {

    if (validate_forms("new_password")) {


        var data = $('#new_password').serialize();

        var req = $.ajax({
            type: "POST",
            url: $('#new_password').attr('action'),
            data: data
        });

        req.done(function (msg) {

            var res = JSON.parse(msg);

            if (res.type == "error") {
                grecaptcha.reset();
                $("#result").html(res.message);
                $("#result").dialog({
                    modal: true,
                    title: "Error",
                    title_html: true,
                    open: function (event, ui) {
                        setTimeout(function () {
                            $('#result').dialog('close');
                        }, 4000);
                    }
                });

                //alert(res.message);
            } else {
                $("#result").html(res.message);
                $("#result").dialog({
                    modal: true,
                    title: "Message",
                    title_html: true,
                    open: function (event, ui) {
                        setTimeout(function () {
                            $('#result').dialog('close');
                        }, 4000);
                    }
                });
                window.location.href = 'index.php?e=11';


            }


        });
        req.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

    } else {
        return false;
    }

}