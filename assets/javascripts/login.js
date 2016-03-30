$( document ).ready(function() {
	$("#reglogToggle").click( function(evt) {
		$login_trigger = $(evt.target);
		if($login_trigger.attr("data-login") === "true") {
				$(".login-field").removeClass("hidden");
				$("#reglogToggle").html("Take me back");
				$("#loginBox-button").attr("value", 'Register');
				$("#forget-pass").addClass("hidden");
				$login_trigger.attr("data-login", "false");
				$(".login-field[name='first-name']")[0].required = true;
				$(".login-field[name='last-name']")[0].required = true;
				$(".login-field[name='confirmed-password']")[0].required = true;
		} else {
				$(".login-field").addClass("hidden");
				$("#reglogToggle").html("Register");
				$("#loginBox-button").attr("value", 'Login');
				$("#forget-pass").removeClass("hidden");
				$login_trigger.attr("data-login", "true");
				$(".login-field[name='first-name']")[0].required = false;
				$(".login-field[name='last-name']")[0].required = false;
				$(".login-field[name='confirmed-password']")[0].required = false;
		}
		});
});
