            <div id="message" style="text-align:center;" >
                   <span style="color:red;"><?php echo $this->session->flashdata('email_errormsg'); ?></span>
                   <span style="color:green;"><?php echo $this->session->flashdata('email_successmsg'); ?></span>
             </div>
          <div class="col-md-8 col-sm-8 col-xs-12 register_form forgot">
           <span id="signin_error"></span>
            <form method="post" action="" id="validate_form">
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="exampleInputEmail1">Email </label>
                <input type="text" class="form-control" id="email" name="email"  value="" placeholder="">
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="exampleInputEmail1">Password</label>
                <input type="password" class="form-control" id="password" name="password"  value="" placeholder="">
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group"> 
              <a href="#" data-toggle="modal" data-target="#myModal">Forgot your password?</a> </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <button type="submit" class="btn btn-default register_btn">Sign in</button>
              </div>
            </form>
           

<!--  forgot_passsword_popup-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title forgot_title">Forgot Password</h4>
         <span id="forgot_signin_error"></span>
      </div>
      <div class="modal-body">
        <form class="form-horizontal"  id="forgot_form"  method="post"  action="#">
          <div class="form-group forgot_popup">
            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-8">
              <input type="email" class="form-control" id="forgot_email" name="email" value="" placeholder="Email">
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-default">Send</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<!-- /.modal --> 
<!--  forgot_passsword_popup-->


<script>
$(function() {
	 var txt = $("input#password");
	 var func = function() {
		 txt.val(txt.val().replace(/\s/g, ''));
	 }
	 txt.keyup(func).blur(func);
 });
 
 
$(document).ready(function() {
	$("#validate_form").submit(function(e) {
	   e.preventDefault();
	
	   var message,response;
	   
	   var email = $.trim($('#email').val());
	   var password = $.trim($('#password').val());
		
	   var email_regex = /^[a-zA-Z0-9.'+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	   var password_regex = /^[a-zA-Z0-9!-@#$%^&*()_]{6,15}$/;
	   
	   
	   if(email == ""){
			message = "Please enter email";
			response = "error";
			$('#email').focus(); 
	   }
	   else if (!email_regex.test($("#email").val())) {
			var response = "error";
			var message = "Please enter valid email";
			$('#email').focus();
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
	   if(response == "error" && message != ""){
			$('#signin_error').html(message).addClass('alert error-danger alert-danger').css({'color':'red'});
			return false;
		}
		else{
			$.ajax({
				type: "POST",
				url: BASEURL+'login/login_check_user_login/',
				data: $("#validate_form").serialize(),
				beforeSend: function() {
					$('#signin_error').html('<span style="color:green;">Processing....</span>');
				},
				success: function(rep){
					response = JSON.parse(rep);
					//console.log(response)
					if(response["response"] == "error"){
						$('#signin_error').html(response["message"]).addClass('alert error-danger alert-danger').css({'color':'red'});
					}
					else{
						$(location).attr('href', BASEURL+"users/profile/");
					}
				},
				error: function(rep){
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
	
	$("#forgot_form").submit(function(e) {
	   e.preventDefault();
	
	   var message,response;
	   var email = $.trim($('#forgot_email').val());
	   var email_regex = /^[a-zA-Z0-9.'+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	   var password_regex = /^[a-zA-Z0-9!-@#$%^&*()_]{6,15}$/;
	   
	   if(email == ""){
			message = "Please enter email";
			response = "error";
			$('#email').focus(); 
	   }
	   else if (!email_regex.test($("#forgot_email").val())) {
			var response = "error";
			var message = "Please enter valid email";
			$('#email').focus();
	   }
	   if(response == "error" && message != ""){
			$('#forgot_signin_error').html(message).addClass('alert error-danger alert-danger').css({'color':'red'});
			return false;
	   }
	   else{
			$.ajax({
				type: "POST",
				url: BASEURL+'login/forgot_password_email/',
				data: $("#forgot_form").serialize(),
				beforeSend: function() {
					$('#forgot_signin_error').html('<span style="color:green;">Processing....</span>');
				},
				success: function(rep){
					response = JSON.parse(rep);
					//console.log(response)
					if(response["response"] == "error"){
						$('#forgot_signin_error').html(response["message"]).addClass('alert error-danger alert-danger').css({'color':'red'});
					}
					else{
						$('#forgot_signin_error').html(response["message"]).css({'color':'green'});
					}
				},
				error: function(rep){
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

$('.modal').on('hidden.bs.modal', function(){
	$('#signin_error').html('');
	$('#forgot_signin_error').html('');
    $(this).find('form')[0].reset();
}); 
</script>