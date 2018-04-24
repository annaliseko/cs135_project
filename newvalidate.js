var validateField = function(fieldElem, infoMessage, validateFn) {
	
	if(validateFn() == true){
		$(fieldElem).parent().children('span').attr('style', 'display:none');
		$(fieldElem).attr('style', 'border-color:green');
		$(fieldElem).parent().children('span').attr('style', 'color:green');
		$(fieldElem).parent().children('span').text("Success");
	}
	else{
		$(fieldElem).parent().children('span').attr('style', 'display:inline');
		$(fieldElem).attr('style', 'border-color:red');
		$(fieldElem).parent().children('span').attr('style', 'color:red');
		$(fieldElem).parent().children('span').text(infoMessage);
	
	}	
};



var validateS_ID= function() {
	var SIDValue = document.getElementsByName("studentid")[0].value;
	var rexp = /^\d{9}$/;
	if(rexp.test(SIDValue)){
		return true;
	}
	else{
		return false;
	}
};


var validatePassword = function(){
	var passwordValue = document.getElementsByName("password")[0].value;
	var rexp = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
	if(rexp.test(passwordValue)){
		return true;
	}
	else{
		return false;
	}
}

var validateFirstName = function() {
	var firstNameValue = document.getElementsByName("firstname")[0].value;
	var rexp = /^[a-zA-Z]+$/;
	if(rexp.test(firstNameValue)){
		return true;
	}
	else{
		return false;
	}
};


var validateLastName = function(){
	var lastNameValue = document.getElementsByName("lastname")[0].value;
	var rexp = /^[a-zA-Z]+$/;
	if(rexp.test(lastNameValue)){
		return true;
	}
	else{
		return false;
	}
};


$(document).ready(function() {

	var studentID = document.getElementsByName("studentid")[0];
	studentID.addEventListener("keyup", function(){
		validateField(this, "Error: Enter 9 numbers 0-9", validateS_ID)
	});
	var firstName = document.getElementsByName("firstname")[0];
	firstName.addEventListener("keyup", function(){
		validateField(this, "Error: Enter a letter a-z or A-Z", validateFirstName)
	});
	
	var lastName = document.getElementsByName("lastname")[0];
	lastName.addEventListener("keyup", function(){
		validateField(this, "Error: Enter a letter a-z or A-Z", validateLastName)
	});
    
    var password = document.getElementsByName("password")[0];
	password.addEventListener("keyup", function(){
		validateField(this, "Error: Must have at least 8 letters and 1 number", validatePassword)
    });

});