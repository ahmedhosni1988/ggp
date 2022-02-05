function confirm_password(password, confirm_password) {

    if ($("#" + password).val() == $("#" + confirm_password).val()) {
        $(".error").remove();
        $("#" + confirm_password).parent('div').append('<div class="postive">&nbsp</div>');
    }
    else {
        $("#" + confirm_password).parent('div').remove('.postive');
        $(".postive").remove();
        $("#" + confirm_password).parent('div').append('<div class="error">Error in Password Check both fields</div>');
    }
}


function show_notify() {
    if ($('#notify').is(':visible')) {
        $("#notify").hide();
    }
    else {
        $("#notify").show();
    }

}


function validate_forms(form_id) {

    $(".fa-times-circle").remove();

    $(".help-block").remove();

    //$('#'+form_id).toggleClass('has-error');

    //if(lastClass == "has-error" ) $(this).removeClass(lastClass);

    var x = true;

    $('#' + form_id + ' :input').each(function () {

        if (this.type != "button" || this.type != "submit" || this.type != "hidden") {

            var validate = $(this).attr("validate");

            if ($(this).attr("validate") && validate != "") {

                if (validate == "notempty") {
                    if ($(this).val() == "") {
                        x = false;
                     //   alert($(this).attr("validate_message") );
                        $(this).parent('div').append('<i class="ace-icon fa fa-times-circle"></i><div class="help-block col-xs-12 col-sm-reset inline"> </div>');
                        $($(this).closest('div[class^="form-group"]')).addClass("has-error");
                    }
                }

            }


            var validate_type = $(this).attr("validate_type");

            if ($(this).attr("validate_type") && validate_type != "") {

                switch (validate_type) {
                    case 'phone':

                        if (validatePhone(this.value) == false) {
                            x = false;
                            $(this).parent('div').append('<div class="error"></div>');
                        }

                        break;

                    case 'pcode':
                        if (validatezip(this.value) == false) {
                            x = false;
                            $(this).parent('div').append('<div class="error"></div>');
                        }
                        break;

                    case 'email':
                        if (validateEmail(this.value) == false) {
                            //alert(this.value);
                            x = false;
                            $(this).parent('div').append('<div class="error"></div>');
                        }
                        break;

                    // Start koko
                    case 'terms_checkbox':
                        if (validateTermsCheckBox(this.value) == false) {
                            //alert(this.value);
                            x = false;
                            $(this).parent('div').append('<div class="error"></div>');
                        }
                        break;
                    //End koko

                    case 'time':
                        break;

                    case 'date':
                        if (isDate(this.value) == false) {
                            x = false;
                            $(this).parent('div').append('<div class="error"></div>');
                        }
                        break;

                }


            }


        }


        if (this.type == "radio") {
        }

    });


    return x;

}


function validatePhone(txtPhone) {

    var filter = /^[0-9-+]+$/;
    if (filter.test(txtPhone)) {
        return true;
    }
    else {
        return false;
    }
}

function validatezip(txtzip) {

    var zipRegex = /^\d{5}$/;

    if (!zipRegex.test(txtzip)) {
        return true;
    }
    else {
        return true;
    }

}


function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if (!emailReg.test($email)) {
        return false;
    } else {
        return true;
    }
}

// Start koko
function validateTermsCheckBox($checkbox) {
    //alert($checkbox);

    if ($checkbox == 'check') {
        return true;
    } else {
        return false;
    }
}

// End koko

function isDate(txtDate) {

    //alert(txtDate);
    var currVal = txtDate;
    if (currVal == '')
        return false;

    //Declare Regex
    var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;
    var dtArray = currVal.match(rxDatePattern); // is format OK?
//alert(dtArray);
    if (dtArray == null)
        return false;

    //Checks for mm/dd/yyyy format.
    dtDay = dtArray[1];
    dtMonth = dtArray[3];
    dtYear = dtArray[5];


    if (dtMonth < 1 || dtMonth > 12)
        return false;
    else if (dtDay < 1 || dtDay > 31)
        return false;
    else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31)
        return false;
    else if (dtMonth == 2) {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay > 29 || (dtDay == 29 && !isleap))
            return false;
    }
    return true;
}

