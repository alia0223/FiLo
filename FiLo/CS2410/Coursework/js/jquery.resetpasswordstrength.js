(function ($) {
    $.fn.passwordStrength = function (options) {
//password length = 8
        var defaults = $.extend({
            minimumChars: 8
        }, options);
//create div that will contain password strength checker progress bar
        var parentContainer = this.parent();
        var progressHtml = "<div class='reset-progress progress' style=\"margin:0 auto; margin-top:10px;\"><div id='password-progress' class='progress-bar' role='progressbar' aria-valuenow='1' aria-valuemin='0' aria-valuemax='100' style='width:1%;'></div></div><div id='reset-password-score' class='reset-password-score' style='margin-top:10px; margin-left:30px;'></div><div id='reset-password-recommendation' class='reset-password-recommendation' style='margin-left:60px;'></div><input type='hidden' id='password-strength-score' value='0'>";
        $(progressHtml).insertAfter('input[name=\'reset-confirmpwd\']');
        $('#reset-password-score').text(defaults.defaultMessage);
        $('.progress').hide();
        $('#reset-password-score').hide();

        $(this).keyup(function (event) {
            $('.progress').show();
            $('#reset-password-score').show();

            var element = $(event.target);
            var password = element.val();
//if no password then div with id password-score and password imprvoments/recommendation is empty i.e display nothing as user has entered nothing yet
            if (password.length == 0) {
                $('#reset-password-score').html('');
                $('#reset-password-recommendation').html('');

                $('.reset-progress').hide();
                $('#reset-password-score').hide();
                $('#password-strength-score').val(0);
            }
                //user has typed something in password field
            else {
                var score = calculatePasswordScore(password, defaults);
                $('#password-strength-score').val(score);
                $('.progress-bar').css('width', score + '%').attr('aria-valuenow', score);

                $('#reset-password-recommendation').css('margin-top', '0px');
				//weak password score
                if (score < 50) {
                    $('#reset-password-score').html('Weak password <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>');
                    $('#reset-password-recommendation').html('<ul><li>Use at least 8 characters</li><li>Use upper and lower case characters</li><li>Use 1 or more numbers</li><li>Optionally use special characters</li></ul>');
                    $('#password-progress').removeClass();
                    $('#password-progress').addClass('progress-bar progress-bar-danger');
                }
            	//Normal password score
                else if (score <= 60) {
                    $('#reset-password-score').html('Normal password <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>');
                    $('#reset-password-recommendation').html('<div id="reset-password-recommendation-heading">For a stronger password :</div><ul><li>Use upper and lower case characters</li><li>Use 1 or more numbers</li><li>Use special characters for an even stronger password</li></ul>');
                    $('#reset-password-recommendation-heading').css('text-align', 'center');
                    $('#password-progress').removeClass();
                    $('#password-progress').addClass('progress-bar progress-bar-warning');
                }
            	//Strong password score
                else if (score <= 80) {
                    $('#reset-password-score').html('Strong password <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>');
                    $('#reset-password-recommendation').html('<div id="reset-password-recommendation-heading">For an even stronger password :</div><ul><li>Increase the length of your password to 15-30 characters</li><li>Use 2 or more numbers</li><li>Use 2 or more special characters</li></ul>');
                    $('#reset-password-recommendation-heading').css('text-align', 'center');
                    $('#password-progress').removeClass();
                    $('#password-progress').addClass('progress-bar progress-bar-info');
                }
                //Strongest possible password score, full progress bar
                else {
                    $('#reset-password-score').html('Very strong password <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>');
                    $('#reset-password-recommendation').html('');
                    $('#password-progress').removeClass();
                    $('#password-progress').addClass('progress-bar progress-bar-success');
                }
            }

        });
    };
	//function to actually calulcate the apssword score. Calculated by looking at length, special chars, numbers, Capitalization
    function calculatePasswordScore(password, options) {

        var score = 0;
        var hasNumericChars = false;
        var hasSpecialChars = false;
        var hasMixedCase = false;

        if (password.length < 1)
            return score;

        if (password.length < options.minimumChars)
            return score;

        //match numbers
        if (/\d+/.test(password)) {
            hasNumericChars = true;
            score += 20;

            var count = (password.match(/\d+?/g)).length;
            if (count > 1) {
                //apply extra score if more than 1 numeric character
                score += 10;
            }
        }

        //match special characters including spaces
        if (/[\W]+/.test(password)) {
            hasSpecialChars = true;
            score += 20;

            var count = (password.match(/[\W]+?/g)).length;
            if (count > 1) {
                //apply extra score if more than 1 special character
                score += 10;
            }
        }

        //mixed case
        if ((/[a-z]/.test(password)) && (/[A-Z]/.test(password))) {
            hasMixedCase = true;
            score += 20;
        }

        if (password.length >= options.minimumChars && password.length < 12) {
            score += 10;
        } else if (!hasMixedCase && password.length >= 12) {
            score += 10;
        }

        if ((password.length >= 12 && password.length <= 15) && (hasMixedCase && (hasSpecialChars || hasNumericChars))) {
            score += 20;
        }
        else if (password.length >= 12 && password.length <= 15) {
            score += 10;
        }

        if ((password.length > 15 && password.length <= 20) && (hasMixedCase && (hasSpecialChars || hasNumericChars))) {
            score += 30;
        }
        else if (password.length > 15 && password.length <= 20) {
            score += 10;
        }

        if ((password.length > 20) && (hasMixedCase && (hasSpecialChars || hasNumericChars))) {
            score += 40;
        }
        else if (password.length > 20) {
            score += 20;
        }

        if (score > 100)
            score = 100;

        return score;
    }
}(jQuery));
