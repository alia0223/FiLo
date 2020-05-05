$(function() {
	$("#pass_error_message").hide();
	$("#confirmpass_error_message").hide();
	$("#email_error_message").hide();
	//variables that contain error status i.e true = error, false = no error
	var error_password = false;
	var error_retype_password = false;
	var error_email = false;
	//perform checks upon clicking off input field so as to prevent getting in the way of the user typing/concentrating
	$("#form_pass").focusout(function() {
		check_password();
	});

	$("#form_confirmpass").focusout(function() {
		check_retype_password();
	});

	$("#form_email").focusout(function() {
		check_email();
	});
	//check first password box, is it atleats 8 characters? enforcing security of password
	function check_password() {
	
		var password_length = $("#form_pass").val().length;
		
		if(password_length < 8) {
			$("#pass_error_message").html("At least 8 characters");
			$("#pass_error_message").show();
			error_password = true;
		} else {
			$("#pass_error_message").hide();
		}
	
	}
	//once both passwords have been typed, check if they match, enforces security of password
	function check_retype_password() {
	
		var password = $("#form_pass").val();
		var retype_password = $("#form_confirmpass").val();
		
		if(password !=  retype_password) {
			$("#confirmpass_error_message").html("Passwords don't match");
			$("#confirmpass_error_message").show();
			error_retype_password = true;
		} else {
			$("#confirmpass_error_message").hide();
		}
	
	}
	//check for suitable email
	function check_email() {

		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
	
		if(pattern.test($("#form_email").val())) {
			$("#email_error_message").hide();
		} else {
			$("#email_error_message").html("Invalid email address");
			$("#email_error_message").show();
			error_email = true;
		}
	
	}
	//perform all checks one final time upon clicking submit button.
	//Submit form if all error variables are false i.e. no errors
	//Do not submit form if atleast any one of the variables are set to true
	$("#registration_form").submit(function() {
											
		error_password = false;
		error_retype_password = false;
		error_email = false;
											
		check_password();
		check_retype_password();
		check_email();
		
		if(error_password == false && error_retype_password == false && error_email == false) {
			return true;
		} else {
			return false;	
		}

	});

});