 <span id="signin_error"></span>
<form id="validate_form" method="post" action="">
  <div class="col-md-6 col-sm-6 col-xs-12 form-group">
    <label for="exampleInputEmail1">First Name *</label>
    <input type="text" class="form-control"  id="first_name" name="first_name" value=""  placeholder="">
  </div>
  <div class="col-md-6 col-sm-6 col-xs-12 form-group">
    <label for="exampleInputEmail1">Last Name *</label>
    <input type="text" class="form-control" id="last_name" name="last_name" value="" placeholder="">
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
    <label for="exampleInputEmail1">Password</label>
    <input type="password" class="form-control" id="password" name="password"  value="" placeholder="">
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
    <label for="exampleInputEmail1">Re-enter password</label>
    <input type="password" class="form-control" id="c_password" name="c_password" value=""  placeholder="">
  </div>
  
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="text" class="form-control" id="email" name="email" value=""  placeholder="">
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
    <button type="submit" class="btn btn-default register_btn">Create account</button>
  </div>
</form>
<script>

$(function() {
	 var txt = $("input#password");
	 var func = function() {
		 txt.val(txt.val().replace(/\s/g, ''));
	 }
	 txt.keyup(func).blur(func);
	 
	 var txt = $("input#c_password");
	 var func = function() {
		 txt.val(txt.val().replace(/\s/g, ''));
	 }
	 txt.keyup(func).blur(func);
	 
 });
 
 
$(document).ready(function() {
$("#validate_form").submit(function(e) {
   e.preventDefault();

   var message,response;
   
   var first_name = $.trim($('#first_name').val());
   var last_name = $.trim($('#last_name').val());
   var email = $.trim($('#email').val());
   var password = $.trim($('#password').val());
   var c_password = $.trim($('#c_password').val());
   var country = $.trim($('#country').val());
   var country_code = $.trim($('#country_code').val());
   var phone = $.trim($('#phone').val());
 	
   var email_regex = /^[a-zA-Z0-9.'+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
   var password_regex = /^[a-zA-Z0-9!-@#$%^&*()_]{6,15}$/;
   
   
   if(first_name == ""){
	    message = "Please enter first name";
		response = "error";
		$('#first_name').focus(); 
   }
   else if(last_name == ""){
	    message = "Please enter last name";
		response = "error";
		$('#last_name').focus(); 
   }
   else if(password == ""){
	    message = "Please enter password";
		response = "error";
		$('#password').focus(); 
   }
   else if (!password_regex.test(password)) {
		var response = 'error';
		var message = "Password must be between 6 to 15 characters";
		$("#password").focus();
   }
   else if(c_password == ""){
	    message = "Please enter confirm password";
		response = "error";
		$('#c_password').focus(); 
   }
   else if (!password_regex.test(c_password)) {
		var response = 'error';
		var message = "Password must be between 6 to 15 characters";
		$("#c_password").focus();
   }
   else if (password != c_password) {
		var response = 'error';
		var message = "Please enter same password in re-enter password";
		$("#c_password").focus();
	}
	else if(email == ""){
	    message = "Please enter email";
		response = "error";
		$('#email').focus(); 
   }
   else if (!email_regex.test($("#email").val())) {
		var response = "error";
		var message = "Please enter valid email";
		$('#email').focus();
   }
   if(response == "error" && message != ""){
		$('#signin_error').html(message).addClass('alert error-danger alert-danger').css({'color':'red'});
		return false;
	}
	else{
		$.ajax({
			type: "POST",
			url: BASEURL+'login/add_user_to_database/',
			data: $("#validate_form").serialize(),
			beforeSend: function() {
				$('#signin_error').html('<span style="color:green;">Processing....</span>');
			},
			success: function(rep){
				response = JSON.parse(rep);
				if(response["response"] == "error"){
					$('#signin_error').html(response["message"]).addClass('alert error-danger alert-danger').css({'color':'red'});
				}
				else{
					$('#signin_error').html(response["message"]).css({'color':'green'});
					$('input').val('');
					//$(location).attr('href', BASEURL+"users/profile/");
				}
			},
			error: function(rep, exception) {
                    //$('#'+formid).find('radio, textarea, select, checkbox, input, file').prop('disabled',true);
                    if (rep.status === 0) {
                        alert('Please check your internet connection .\n Verify Network.');
                    } else if (rep.status == 404) {
                        alert('Requested page not found. [404]');
                    } else if (rep.status == 500) {
                        alert('Internal Server Error [500].');
                    } else if (exception === 'parsererror') {
                        alert('Requested JSON parse failed.');
                    } else if (exception === 'timeout') {
                        alert('Time out error.');
                    } else if (exception === 'abort') {
                        alert('Ajax request aborted.');
                    } else {
                        alert('Uncaught Error.\n' + rep.responseText);
                    }
                }
	 });
	}
 });
});	 
</script>