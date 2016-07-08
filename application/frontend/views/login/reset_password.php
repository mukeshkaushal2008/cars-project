<!-- BANNER -->

<div class="banner"> <img src="<?php echo base_url();?>images/Contact_us.jpg" alt="...">
  <div class="text_banner">
    <div class="container">
      <div class="row">
        <div class="col-md-5 bnr">
          <div class="text_left">
            <h1><strong>Reset password</strong> </h1>
            <h2> The Office 365Firm</h2>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<!-- BANNER --> 

<!-- WHITE DIV -->
<div class="white_bg sign_page">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-8 left_side">
        <div class="blog_one">
          <div class="col-md-12 main_title creat_regis">Update password!</div>
            <div id="message" style="text-align:center;" >
                   <span style="color:red;"><?php echo $this->session->flashdata('email_errormsg'); ?></span>
                   <span style="color:green;"><?php echo $this->session->flashdata('email_successmsg'); ?></span>
             </div>
          <div class="col-md-8 col-sm-8 col-xs-12 register_form forgot">
           <span id="signin_error"></span>
            <form method="post" action="" id="reset_form">
              
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="exampleInputEmail1">New Password</label>
                 <input type="hidden" class="form-control" id="email" name="email"  value="<?php echo !empty($_GET["em"]) ? $_GET["em"] : "";?>" placeholder="">
                <input type="password" class="form-control" id="password" name="password"  value="" placeholder="">
              </div>
              
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="exampleInputEmail1">Re-Enter Password</label>
                <input type="password" class="form-control" id="c_password" name="c_password"  value="" placeholder="">
              </div>
              
              
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <button type="submit" class="btn btn-default register_btn">Update password</button>
              </div>
            </form>
            
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-4 left_side contact_right">
        <div class="blog_one">
          <div class="col-md-12 sign"><img src="<?php echo base_url();?>images/sign.jpg" alt="" /></div>
          <div class="col-md-12 main_title creat_regis">Need our help ?</div>
          <div class="col-md-12 col-sm-12 col-xs-12 register_p">Don’t hestiate to ask us something. Email us directly support@office365firm.com or call us at <br/>
            <span>1-888-899-8899.</span> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- WHITE DIV --> 


<script>
$(document).ready(function() {

$("#reset_form").submit(function(e) {
   e.preventDefault();

   var message,response;
   
   var password = $.trim($('#password').val());
   var c_password = $.trim($('#c_password').val());
   var password_regex = /^[a-zA-Z0-9!-@#$%^&*()_]{6,15}$/;	
   var email = $.trim($('#email').val());
   
   if(password == ""){
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
		message = "Please enter re-password";
		response = "error";
		$('#password').focus(); 
   }
   else if (!password_regex.test(c_password)) {
		var response = 'error';
		var message = "Password must be between 6 to 15 characters";
		$("#password").focus();
   }
   else if (password != c_password) {
		var response = 'error';
		var message = "Please enter same password in re-enter password";
		$("#c_password").focus();
   }
   if(response == "error" && message != ""){
		$('#signin_error').html(message).addClass('alert error-danger alert-danger').css({'color':'red'});
		return false;
	}
	else{
		$.ajax({
			type: "POST",
			url: BASEURL+'login/reset_password_update/',
			data: $("#reset_form").serialize(),
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
				}
			},
			error: function(rep){
				
			}
	 });
	}
 });
});	
</script>