var validateField = function(fieldElem, infoMessage, validateFn) {
	//Span message that notifies user of correct form
    var spanMsg = "<span>" + infoMessage + "</span>";

    if (fieldElem.next().length === 0) {
        fieldElem.after(spanMsg);
    }
    // Initially hides the span
    if (fieldElem.val() === undefined || fieldElem.val().length === 0) {
        fieldElem.next().hide();
    }

    // View the span message when they edit the input fields
    fieldElem.on('input', function () {
        fieldElem.next().removeClass();
        fieldElem.next().text(infoMessage);
        fieldElem.next().addClass("info");
        fieldElem.next().show();
        if (this.value.length > 0) {
            fieldElem.next().show();
        }
    });

    // Updates the span message according to the inputted format
    fieldElem.focusout(function() {
        if (validateFn(fieldElem.val()) === true) {
            fieldElem.next().text("OK");
            fieldElem.next().removeClass();
            fieldElem.next().addClass("ok");
        } else {
            fieldElem.next().text("Error");
            fieldElem.next().removeClass();
            fieldElem.next().addClass("error");
        }
        // When no boxes are selected then the span is hidden
        if (fieldElem.val() === undefined || fieldElem.val().length === 0) {
            fieldElem.next().hide();
        }
    });
};

// Checks that username consists of only alphanumeric values
var validateID = function(text) {
    var re = /^\d{8}$/;
    return re.test(s_id);
};

// Checks for password that has at least 8 characters and at least 1 number
var validatePassword = function(password) {
	var re = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    return re.test(password);
};

// Checks for phone number in the format xxx xxx xxxx
var validatePhoneNumber = function(phonenumber) {
    var re = /^\d{3}[\s]\d{3}[\s]\d{4}$/;
    return re.test(phonenumber);
};

// Checks for email in the format [a-z]@[a-z].[com, edu, gov]
var validateEmail = function(text) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(text);
};

// Checks that one radio button is selected
var validateRadio = function(radio) {
    if ($("input[type='radio']:checked").val()) {
    	return true;
    } else {
    	return false;
    }
};

// Checks that at least two checkboxes are selected
var validateCheckbox = function(radio) {
    if ($("input[type='checkbox']:checked").length >= 2) {
    	return true;
    } else {
    	return false;
    }
};


$(document).ready(function () {

    //validateField for username
    $("#s_id").focus(function () {
        validateField($(this), "Must be the 8 digit id number",
                      validateID);
    });

    //validateField for password
    $("#password").focus(function () {
        validateField($(this), "Must be at least 8 characters and contain at least 1 number ",
                      validatePassword);
    });

    //validateField for phone number
    $("#phonenumber").focus(function () {
        validateField($(this), "Must only have numeric characters and of the format xxx xxx xxxx",
                      validatePhoneNumber);
    });

    //validateField for email
    $("#email").focus(function () {
        validateField($(this), "Must be in form example@example.com or .edu or .gov]",
                      validateEmail);
    });

    //validateField for radio buttons
    $("input[type = 'radio'").focus(function () {
        validateField($(this), "Must have one box checked!",
                      validateRadio);
    });

    //validateField for checkboxes
    $("input[type = 'checkbox'").focus(function () {
        validateField($(this), "Must have at least two boxes checked!",
                      validateCheckbox);
    });

    // Submission validation checks
    $('#submit').click(function() {
        if (!$("#username").val() != '' || !$("#password").val() != ''
            || !$("#phonenumber").val() != '' || !$("#email").val() != '') {
            alert('You are missing one or more required fields!');
        }

        if ($("input[name=holiday]:checked").length >= 2 && $("input[name='year']:checked").val()) {
            return true;
        }

        else if ($("input[name=holiday]:checked").length < 2 || !$("input[name='year']:checked").val()) {
        	alert('You are missing a check!');
        }
        else {
            return true;
        }
  	});
});
