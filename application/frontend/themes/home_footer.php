<footer class="footer"><!--footer-->
  <div class="container">
    <ul class="footer_menu">
      <li><a href="<?php echo base_url();?>home/live/">Live Auctions</a></li>
      <li><a href="<?php echo base_url();?>home/closed/">Closed Auctions</a></li>
      <li><a href="javascript:void(0);">How it works</a></li>
      <li><a href="javascript:void(0);">Buy bids</a></li>
      <li><a href="<?php echo base_url();?>pages/contact_us">Contact Us</a></li>
      <li class="newsletter" id="nws"><a href="javascript:void(0);">Newsletter</a></li>
    </ul>
    <!--/footer_menu-->
    
    <div class="invite"><!--invite-->
      <h2>INVITE YOUR FRIENDS<br>
        <span>and get free bids</span></h2>
      <a href="javascript:void(0);"><img src="<?php echo base_url();?>images/invitearrow.png"></a> </div>
    <!--/invite-->
    
    <ul class="social_ic">
      <!--social_ic-->
      <li><a href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
      <li><a href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
      <li><a href="javascript:void(0);"><i class="fa fa-pinterest"></i></a></li>
      <li><a href="javascript:void(0);"><i class="fa fa-google-plus"></i></a></li>
      <li><a href="javascript:void(0);"><i class="fa fa-instagram"></i></a></li>
      <li><a href="javascript:void(0);"><i class="fa fa-linkedin"></i></a></li>
    </ul>
    <!--/social_ic--> 
  </div>
  <div class="copyright"><!--copyright-->
    <p>© Copyright Bidsforyou</p>
  </div>
  <!--/copyright--> 
  
</footer>
<!--/footer-->

<div id="login_block"><!--login_block-->
  <div class="formwrap">
    <div class="box-head"> <a href="javascript:void(0)" class="log-url current">Login</a> <span>or</span> <a href="javascript:void(0)" class="reg-url">Register</a> </div>
    <div class="box-body">
      <div class="form-fields">
       <div id="message" style="text-align:center;" >
           <span style="color:red;"><?php echo $this->session->flashdata('email_errormsg'); ?></span>
           <span style="color:green;"><?php echo $this->session->flashdata('email_successmsg'); ?></span>
       </div>
       <span id="login_signin_error"></span>
        <form method="post" action="" id="login_validate_form">
        <div class="form-row">
          <label for="reg_email">Email <span class="required">*</span></label>
          <input required type="text" value="" id="email" name="email" class="input-text">
        </div>
        <div class="form-row btm0">
          <label for="reg_password">Password <span class="required">*</span></label>
          <input required type="password" value="" id="password" name="password" class="input-text">
        </div>
        <div class="form-row">
          <input type="checkbox" value="" id="forget-your-password"  class="input-check">
          <label class="forget-your" for="forget-your-password">Forget your password</label>
        </div>
        <!-- Spam Trap -->
        <div class="form-row btm10">
          <input type="submit" value="Submit" name="Submit" class="button">
        </div>
        </form>
        <p class="pop_info center">* You must be a free registered user ro submit content.</p>
      </div>
    </div>
  </div>
</div>



<div id="register_block" class="popup"><!--register_block-->
  <div class="formwrap">
    <div class="box-head"> <a href="javascript:void(0);" class="log-url" id="log">Login</a> <span>or</span> <a href="javascript:void(0);" class="reg-url current">Register</a> </div>
    <div class="box-body">
      <h4>Create an Account</h4>
      <div class="element-box">
        <div class="form-fields">
         <span id="signin_error"></span>
         <form id="validate_form" method="post" action="">
          <div class="form-row">
            <label for="reg_email">First Name <span class="required">*</span></label>
            <input type="text"  value=""  id="first_name" name="first_name"  class="input-text">
          </div>
          <div class="form-row">
            <label for="reg_email">Last Name <span class="required">*</span></label>
            <input type="text" value="" id="last_name" name="last_name" class="input-text">
          </div>
          <div class="form-row">
            <label for="password">Password <span class="required">*</span></label>
            <input type="password" class="input-text"  id="password" name="password">
          </div>
          <div class="form-row">
            <label for="reg_password">Confirm Password <span class="required">*</span></label>
            <input type="password" class="input-text"  id="c_password" name="c_password" >
          </div>
          <div class="form-row">
            <label for="reg_email">Email address <span class="required">*</span></label>
            <input type="email" value="" id="email" name="email"  class="input-text">
          </div>
          
          <!-- Spam Trap -->
          <div class="form-row btm0">
            <input type="submit" value="Create your account" name="Create your account" class="button">
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="forgetpassword_block"><!--forgetpassword_block-->
  <div class="formwrap">
    <div class="box-head">Forgot Your Password?</div>
    <div class="box-body">
      <h4>Retrieve your password here</h4>
      <p class="pop_info">Please enter your email address below. You will receive a link to  reset your password.</p>
      <div class="form-fields">
       <span id="forgot_signin_error"></span>
      <form  id="forgot_form"  method="post"  action="#">
        <div class="form-row">
          <label for="reg_email">Email address <span class="required">*</span></label>
          <input type="email" value="" id="forgot_email" name="email" class="input-text">
        </div>
        <!-- Spam Trap -->
        <div class="form-row btm0">
          <input type="submit" value="Submit" name="Submit" class="button">
        </div>
        </form>
        <p class="pop_info center">* You must be a free registered user ro submit content.</p>
      </div>
    </div>
  </div>
</div>
<div id="newsletter_block"><!--newsletter_block-->
  <div class="formwrap">
    <div class="box-head">Newsletter</div>
    <div class="box-body">
      <h4>Be the first to know</h4>
      <p class="pop_info">Subscribe to the eCommerce newsletter to receive timely updates from your favorite products.</p>
      <div class="form-fields">
        <div class="form-row">
          <label for="reg_email">Email address <span class="required">*</span></label>
          <input type="email" value="" id="reg_email" name="email" class="input-text">
        </div>
        <!-- Spam Trap -->
        <div class="form-row btm0">
          <input type="submit" value="Subscribe" name="Subscribe" class="button">
        </div>
        <p class="pop_info center">* You must be a free registered user ro submit content.</p>
      </div>
    </div>
  </div>
</div>
<div class="overlay"></div>
<script src="<?php echo base_url(); ?>js/jquery.bxslider.js" type="text/javascript"></script> 
<script>


$(document).ready(function(){
  $('.slider1').bxSlider({
    slideWidth: 269,
    minSlides: 2,
    maxSlides: 4,
    slideMargin: 20
  });
});


$(".toggle").click(function(){
    $(".nav").slideToggle();
	});
	
	$("#login").click(function(){
    $("#login_block").fadeIn();
	$(".overlay").show();
	});
	$(".overlay").click(function(){
    $("#login_block").fadeOut();
	$("#register_block").fadeOut();
	$("#forgetpassword_block").fadeOut();
	$("#newsletter_block").fadeOut();
	$(".overlay").fadeOut();
	});
	$(".reg-url").click(function(){
    $("#register_block").fadeIn();
	$(".overlay").show();
	$("#login_block").hide();
	});
	$("#log").click(function(){
	$("#login_block").fadeIn();
	$("#register_block").fadeOut();
	$(".overlay").show();
	});
	$(".forget-your").click(function(){
	$("#forgetpassword_block").fadeIn();
	$("#login_block").fadeOut();
	$(".overlay").show();
	});
	$(".newsletter").click(function(){
	$("#newsletter_block").fadeIn();
	$(".overlay").show();

	});


$(function() {
	 var txt = $("input#password");
	 var func = function() {
		 txt.val(txt.val().replace(/\s/g, ''));
	 }
	 txt.keyup(func).blur(func);
	 
	 var txt1 = $("input#c_password");
	 var func1 = function() {
		 txt1.val(txt1.val().replace(/\s/g, ''));
	 }
	 txt1.keyup(func1).blur(func1);
	 
 });
 $(document).ready(function() {
	$("#login_validate_form").submit(function(e) {
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
			$('#login_signin_error').html(message).addClass('alert error-danger alert-danger').css({'color':'red'});
			return false;
		}
		else{
			$.ajax({
				type: "POST",
				url: BASEURL+'login/login_check_user_login/',
				data: $("#login_validate_form").serialize(),
				beforeSend: function() {
					$('#login_signin_error').html('<span style="color:green;">Processing....</span>');
				},
				success: function(rep){
					response = JSON.parse(rep);
					//console.log(response)
					if(response["response"] == "error"){
						$('#login_signin_error').html(response["message"]).addClass('alert error-danger alert-danger').css({'color':'red'});
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
		var message = "Please enter same password in confirm password";
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

$(document).ready(function(){
<?php
//$_GET["q"]="";
 if($_GET["q"] <> "" && $_GET['q']==true){?>
	$("#login_block").show();
	$(".overlay").show();
<?php }?> 
});
</script>
