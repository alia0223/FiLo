$(function() {
	$("#pass_error_message").hide();
	$("#confirmpass_error_message").hide();

	var error_password = false;
	var error_retype_password = false;

	$("#form_pass").focusout(function() {

		check_password();
		
	});

	$("#form_confirmpass").focusout(function() {

		check_retype_password();
		
	});

	function check_password() {
	
		var password_length = $("#form_pass").val().length;
		
		if(password_length < 8) {
			$("#pass_error_message").html("Password Must Be At least 8 characters!");
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
			$("#confirmpass_error_message").html("Passwords Do Not match!");
			$("#confirmpass_error_message").show();
			error_retype_password = true;
		} else {
			$("#confirmpass_error_message").hide();
		}
	
	}

	$("#registration_form").submit(function() {
											
		error_password = false;
		error_retype_password = false;
											
		check_password();
		check_retype_password();
		
		if(error_password == false && error_retype_password == false) {
			return true;
		} else {
			return false;	
		}

	});

});