$(function() {
	$("#pass_error_message").hide();
	$("#confirmpass_error_message").hide();
	$("#email_error_message").hide();

	var error_password = false;
	var error_retype_password = false;
	var error_email = false;

	$("#form_pass").focusout(function() {

		check_password();
		
	});

	$("#form_confirmpass").focusout(function() {

		check_retype_password();
		
	});

	$("#form_email").focusout(function() {

		check_email();
		
	});

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