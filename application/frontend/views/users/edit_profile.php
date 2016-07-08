<!-- BANNER -->

<div class="banner"> <img src="<?php echo base_url();?>images/About_Us.jpg" alt="...">
  <div class="text_banner">
    <div class="container">
      <div class="row">
        <div class="col-md-5 bnr">
          <div class="text_left">
            <h1><strong>Edit my account</strong> </h1>
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
<div class="white_bg">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-sm-8 left_side">
        <div class="blog_one">
          <div class="col-md-12 main_title creat_regis">Edit account</div>
          <div class="col-md-10 col-sm-12 col-xs-12 register_form">
           <span id="signin_error"></span>
            <form method="post" action="#" id="edit_form">
              <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                <label for="exampleInputEmail1">First Name *</label>
               <input type="hidden" class="form-control" id="id" name="id" value="<?php echo !empty($resultset["id"]) ? $resultset["id"] : "";?>" placeholder="abc">
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo !empty($resultset["first_name"]) ? $resultset["first_name"] : "";?>" placeholder="abc">
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                <label for="exampleInputEmail1">Last Name *</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo !empty($resultset["last_name"]) ? $resultset["last_name"] : "";?>" placeholder="xyz">
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo !empty($resultset["email"]) ? $resultset["email"] : "";?>"  placeholder="wsc@gmail.com" >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <label class="" for="exampleInputEmail3">Country/region</label>
                <select id="country" name="country" class="selectpicker form-control" data-size="5" style="display: none;">
                  <option value="">Select country</option>
                  <?php foreach($countries as $k =>$v){?>
                  <option value="<?php echo $v["id"];?>" <?php if($resultset["country"] == $v["id"]){echo 'selected="selected"';}?>><?php echo $v["country"];?></option>
                  <?php }?>
                </select>
              </div>
              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <label class="" for="exampleInputEmail3">Country code</label>
                <select id="country_code" name="country_code" class="selectpicker form-control" data-size="5" style="display: none;">
                  <option value="">Select country code</option>
				  <?php foreach($countries as $k =>$v){?>
                  <option value="<?php echo $v["id"];?>" <?php if($resultset["country_code"] == $v["id"]){echo 'selected="selected"';}?>><?php echo $v["country"];?> (<?php echo $v["phone_prefix"]?>)</option>
                  <?php }?>
                </select>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="exampleInputEmail1">Phone number</label>
                <input type="text" class="form-control" id="phone" name="phone"  value="<?php echo !empty($resultset["phone"]) ? $resultset["phone"] : "";?>" placeholder="+91 9612345678">
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group edit_accont">
                <button type="submit" class="btn btn-default register_btn">Save</button>
                <button type="button" class="btn btn-default register_btn i_dont" onClick="window.location.href='<?php echo base_url();?>users/profile'">Cancel</button>
              </div>
            </form>
          </div>
        </div>
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
$("#edit_form").submit(function(e) {
   e.preventDefault();

   var message,response;
   
   var first_name = $.trim($('#first_name').val());
   var last_name = $.trim($('#last_name').val());
   var email = $.trim($('#email').val());
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
   else if(country == ""){
	    message = "Please select country";
		response = "error";
		$('#country').focus(); 
   }
   else if(country_code == ""){
	    message = "Please select country code";
		response = "error";
		$('#country_code').focus(); 
   }
   else if(phone == ""){
	    message = "Please enter phone";
		response = "error";
		$('#phone').focus(); 
   }
	if(response == "error" && message != ""){
		$('#signin_error').html(message).addClass('alert error-danger alert-danger').css({'color':'red'});
		return false;
	}
	else{
		$.ajax({
			type: "POST",
			url: BASEURL+'users/edit_user_to_database/',
			data: $("#edit_form").serialize(),
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
					//$(location).attr('href', BASEURL+"users/profile/");
				}
			},
			error: function(rep){
				
			}
	 });
	}
 });
});	 

</script>
<!-- black bottom div --> 