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
    return re.test(text);
};

// Checks for phone number in the format xxx xxx xxxx
var validateFirstName = function(firstname) {
  var re = /^(?=.*[A-Za-z])$/;
    return re.test(firstname);
};

// Checks for email in the format [a-z]@[a-z].[com, edu, gov]
var validateLastName = function(lastname) {
    var re = /^(?=.*[A-Za-z])$/;
    return re.test(lastname);
};

// Checks for password that has at least 8 characters and at least 1 number
var validatePassword = function(password) {
	var re = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    return re.test(password);
};


$(document).ready(function () {

    //validateField for username
    $("#student").focus(function () {
        validateField($(this), "Must be 8 digit id number",
                      validateID);
    });

    //validateField for phone number
    $("#firstname").focus(function () {
        validateField($(this), "Must only have numeric characters and of the format xxx xxx xxxx",
                      validateFirstName);
    });

    //validateField for email
    $("#lastname").focus(function () {
        validateField($(this), "Must be in form example@example.com or .edu or .gov]",
                      validateLastName);
    });

    //validateField for password
    $("#password").focus(function () {
        validateField($(this), "Must be at least 8 characters and contain at least 1 number ",
                      validatePassword);
    });


    // Submission validation checks
    $('#submit').click(function() {
        if (!$("#s_id").val() != '' || !$("#password").val() != ''
            || !$("#firstname").val() != '' || !$("#lastname").val() != '') {
            alert('You are missing one or more required fields!');
        }
        else {
            return true;
        }
  	});
});
