$('document').ready(function() {
	/* handling form validation */
	$("#login-form").validate({
		rules: {
			password: {
				required: true,
			},
			user_name: {
				required: true,
			},
		},
		messages: {
			user_name:{
				required: "Ingrese el usuario"
			},
			password:{
			  required: "Ingrese la contraseña"
			}
		},
		submitHandler: submitForm
	});
	/* Handling login functionality */
	function submitForm() {
		var data = $("#login-form").serialize();
		$.ajax({
			type : 'POST',
			url  : 'login.php',
			data : data,
			beforeSend: function(){
				$("#error").fadeOut();
				$("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Enviando ...');
			},
			success : function(response){
				if(response=="ok"){
					$("#login_button").html('<img src="ajax-loader.gif" /> &nbsp; Ingresando ...');
					setTimeout(' window.location.href = "welcome.php"; ',1000);
				} else {
					$("#error").fadeIn(1000, function(){
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>');
						$("#login_button").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
					});
				}
			}
		});
		return false;
	}
});
