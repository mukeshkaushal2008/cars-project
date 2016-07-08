<!-- BANNER -->


<div class="banner"> <img src="<?php echo base_url();?>images/Contact_us.jpg" alt="...">
  <div class="text_banner">
    <div class="container">
      <div class="row">
        <div class="col-md-5 bnr">
          <div class="text_left">
            <h2><strong>Welcome To </strong> </h2>
            <h1><strong>My Account</strong></h1>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<!-- BANNER --> 

<!-- WHITE DIV -->
<div class="white_bg">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-sm-8 left_side">
        <div class="blog_one">
          <div class="col-md-12 main_title">Change Password </div>
          <div class="col-md-10 col-sm-12 col-xs-12 register_form"> <span id="forgot_signin_error"></span>
            <form method="post" id="change_password">
              <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                <label for="exampleInputEmail1">Old Password</label>
                <input type="password" placeholder="" id="old_password"  name="old_password"  value="" class="form-control">
              </div>
              <div class="clearfix"></div>
              <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                <label for="exampleInputEmail1">New Password</label>
                <input type="password" placeholder="" id="new_password" name="new_password" value="" class="form-control">
              </div>
              <div class="clearfix"></div>
              <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                <label for="exampleInputEmail1">Confirm Password</label>
                <input type="password" placeholder="" id="c_password" name="c_password" value="" class="form-control">
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group edit_accont">
                <button class="btn btn-default register_btn" type="submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-4 right_side">
        <div class="col-md-12 col-sm-12 col-xs-12 welcome_div about_right">
          <h3>Account summary</h3>
          <div class="overview over_right">
            <h5>abcd</h5>
            <ul>
              <li><a href="edit_account.html">Edit display name</a></li>
            </ul>
          </div>
          <div class="overview over_right">
            <h5>Password and security</h5>
            <ul>
              <li><a href="<?php echo base_url()?>users/change_password/">Change password</a></li>
              <li><a href="<?php echo base_url()?>users/edit/">Edit security info</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 welcome_div about_right">
          <h3>Get more help</h3>
          <p>Find answers to your technology questions with our collection of articles, videos and tutorials.</p>
          <a href="#"><img src="<?php echo base_url();?>images/im2.png" alt="">Chat With Us Now</a> <a href="#"><img src="<?php echo base_url();?>images/im1.png" alt="">Create a Support Case Now</a> </div>
      </div>
    </div>
  </div>
</div>
<!-- WHITE DIV --> 

<!-- black bottom div -->
<div class="gray_btm">
  <div class="container">
    <div class="row">
      <ul class="logos">
        <li><img src="<?php echo base_url();?>images/bottom_logo1.png" alt=""/></li>
        <li><img src="<?php echo base_url();?>images/bottom_logo2.png" alt=""/></li>
        <li><img src="<?php echo base_url();?>images/bottom_logo3.png" alt=""/></li>
        <li><img src="<?php echo base_url();?>images/bottom_logo4.png" alt=""/></li>
        <li><img src="<?php echo base_url();?>images/bottom_logo5.png" alt=""/></li>
      </ul>
    </div>
  </div>
</div>

<!-- black bottom div --> 
<script>
	$("#change_password").submit(function(e) {
	   e.preventDefault();
	
	   var message,response;
	   var old_password = $("#old_password").val().trim();
	   var new_password = $("#new_password").val().trim();
	   var c_password = $("#c_password").val().trim();
	   var password_regex = /^[a-zA-Z0-9!-@#$%^&*()_]{6,15}$/;
	   
	   
	    if(old_password == ""){
			var response = 'error';
			var message = "Please enter old password";
			$("#old_password").focus();
		}
		else if(new_password == ""){
			var response = 'error';
			var message = "Please enter new password";
			$("#new_password").focus();
		}
		else if(!password_regex.test(new_password)){
			var response = 'error';
			var message = "Password must be between 6 to 15 characters";
			$("#new_password").focus();
		}
		else if(c_password == ""){
			var response = 'error';
			var message = "Please enter confirm password";
			$("#c_password").focus();
		}
		else if(!password_regex.test(c_password)){
			var response = 'error';
			var message = "Confirm Password must be between 6 to 15 characters";
			$("#confirm_password").focus();
		}
		else if(c_password != new_password){
			var response = 'error';
			var message = "Both password should match";
			$("#confirm_password").focus();
		}
	   if(response == "error" && message != ""){
			$('#forgot_signin_error').html(message).addClass('alert error-danger alert-danger').css({'color':'red'});
			return false;
	   }
	   else{
			$.ajax({
				type: "POST",
				url: BASEURL+'users/edit_password/',
				data: $("#change_password").serialize(),
				beforeSend: function() {
					$('#forgot_signin_error').html('<span style="color:green;">Processing....</span>');
				},
				success: function(rep){
					response = JSON.parse(rep);
					
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
</script>