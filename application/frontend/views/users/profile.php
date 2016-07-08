
<?php //debug($resultset);?>
<article class="closed live_auctions"><!--closed-->
  <div class="container"><!--container-->
    <h1>MY ACCOUNT</h1>
    <div id="myaccount">
      <div class="menu2">
        <nav role="navigation" class="navbar" id="accountMenu">
          <div id="bs-example-navbar-collapse-3" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li><a href="<?php echo base_url();?>users/profile/" class="selected">Account Details</a></li>
              <li><a href="<?php echo base_url();?>bids/history/" class="">Bids History</a></li>
              <li><a href="<?php echo base_url();?>users/address/" class="">Address Book</a></li>
              <li><a href="<?php echo base_url();?>login/logout/" class="">Logout</a></li>
            </ul>
          </div>
        </nav>
      </div>
      <div class="myBids">
        <div class="row">
          <div class="col-md-3 left_col">
            <div class="item">
              <div class="title">AVAILABLE BIDS</div>
              <div class="nb"><?php echo !empty($my_bids) ? $my_bids : "0";?></div>
            </div>
          </div>
          <div class="col-md-3 right_col"> <a class="buy" href="<?php echo base_url();?>bids/">BUY BIDS</a> </div>
        </div>
      </div>
      <div class="editing">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="item">
              <div class="title">CHANGE YOUR EMAIL ADDRESS</div>
              <div class="theForm">
              <span id="change_email_error"></span>
                <form method="post" action="" id="change_form">
                  <div class="form-group">
                    <label for="" class="control-label">Current email address</label>
                    <input type="email" placeholder="Current email address" value="<?php echo  $this->session->userdata("email");?>" <?php if($this->session->userdata("email") <> ""){?> style="background-color: #ccc;"  readonly <?php }?> name="change_email" id="change_email" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="" class="control-label">New email address</label>
                    <input type="email" placeholder="New email address" name="change_new_email" id="change_new_email" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="" class="control-label">Confirm email address</label>
                    <input type="email" placeholder="Confirm email address" name="confirm_new_email" id="confirm_new_email" class="form-control">
                  </div>
                  <div class="row saveDiv">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                      <button class="save btn" type="submit">SAVE
                      <div class="loader"></div>
                      </button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                      <div class="mssg notification-container"></div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="item">
              <div class="title">CHANGE YOUR PASSWORD</div>
              <div class="theForm">
              <span id="pass_error"></span>
                <form id="reset_form" method="post" action="">
                  <div class="form-group">
                    <label for="" class="control-label">Current password </label>
                    <input type="password" placeholder="Current password" name="old_password" id="old_password" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="" class="control-label">New password</label>
                    <input type="password" placeholder="New password" name="new_password" id="new_password" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="" class="control-label">Confirm new password</label>
                    <input type="password" placeholder="Confirm new password" name="c_password" id="c_password" class="form-control">
                  </div>
                  <div class="row saveDiv">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                      <button class="save btn" type="submit">SAVE
                      <div class="loader"></div>
                      </button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                      <div class="mssg notification-container"></div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="item">
              <div class="title">CHANGE YOUR INFO</div>
              <div ng-init="countryId=105" data-ng-controller="countriesCtrl" class="theForm ng-scope">
               <span id="user_error"></span>
                <form method="post" action="#" id="user_info">
                
                  <div class="form-group">
                    <label for="firstName" class="control-label">First Name*</label>
                    <input type="text" placeholder="First Name" name="first_name" id="first_name" value="<?php echo !empty($resultset["first_name"]) ? $resultset["first_name"] : "";?>" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="lastName" class="control-label">Last Name*</label>
                    <input type="text" placeholder="Last Name" name="last_name" id="last_name" value="<?php echo !empty($resultset["last_name"]) ? $resultset["last_name"] : "";?>" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="" class="control-label">Gender*</label>
                    <select class="form-control" name="gender" class="gender">
                      <option  value="male" <?php if($resultset["gender"] == "male"){echo 'selected="selected"';}?>>Male</option>
                      <option value="female" <?php if($resultset["gender"] == "female"){echo 'selected="selected"';}?>>Female</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="" class="control-label">Country*</label>
                    <select class="form-control"  name="country" id="country">
                      <option value="">Select Country</option>
                      <?php foreach($this->common->get_all_countries() as $k =>$v){?>
                      <option value="<?php echo $v["id"];?>" <?php if($resultset["country"] == $v["id"]){echo 'selected="selected"';}?>><?php echo $v["country"];?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="nickName" class="control-label">Mobile*</label>
                    <div class="mobile-input-container">
                      <input type="tel"  autocomplete="off" placeholder="Enter Mobile" name="phone" id="phone" value="<?php echo !empty($resultset["phone"]) ? $resultset["phone"] : "";?>" class="form-control phoneFormat">
                    </div>
                  </div>
                  <div class="form-group date-container">
                    <label for="strDob" class="control-label">Date of Birth*</label>
                    <div class="date-drp-container">
                    <?php $date = explode('-',$resultset["dob"]);?>
                      <select class="form-control" id="regday" name="day">
                        <option value="">Day</option>
                        <?php for($i=1;$i<=31;$i++){?>
                        <option value="<?php echo $i;?>" <?php if($i ==$date[0]){echo 'selected="selected"';}?>><?php echo $i;?></option>
                        <?php }?>
                      </select>
                      <select class="form-control" id="regmonth" name="month">
                        <option value="">Month</option>
                        <?php for($i=1;$i<=12;$i++){?>
                        <option value="<?php echo $i;?>" <?php if($i ==$date[1]){echo 'selected="selected"';}?>><?php echo $i;?></option>
                        <?php }?>
                      </select>
                      <select class="form-control" id="regyear" name="year">
                        <option value="">Year</option>
                        <?php for($i=date('Y');$i>=1900;$i--){?>
                        <option value="<?php echo $i;?>" <?php if($i ==$date[2]){echo 'selected="selected"';}?>><?php echo $i;?></option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="row saveDiv">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                      <button class="save btn" type="submit">SAVE
                      <div class="loader"></div>
                      </button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                      <div class="mssg notification-container"></div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/slider1--> 
  </div>
  <!--/container-->
  </div>
</article>
<script>
 $(document).ready(function() {
	$("#reset_form").submit(function(e) {
   e.preventDefault();

   var message,response;
   var old_password = $.trim($('#old_password').val());
   var new_password = $.trim($('#new_password').val());
   var c_password = $.trim($('#c_password').val());
   var password_regex = /^[a-zA-Z0-9!-@#$%^&*()_]{6,15}$/;	
   
   if(old_password == ""){
		message = "Please enter old password";
		response = "error";
		$('#old_password').focus(); 
   }
   else if (!password_regex.test(old_password)) {
		var response = 'error';
		var message = "Password must be between 6 to 15 characters";
		$("#old_password").focus();
   }
   else if(new_password == ""){
		message = "Please enter new password";
		response = "error";
		$('#new_password').focus(); 
   }
   else if (!password_regex.test(new_password)) {
		var response = 'error';
		var message = "New password must be between 6 to 15 characters";
		$("#new_password").focus();
   }
   else if(c_password == ""){
		message = "Please enter confirm password";
		response = "error";
		$('#password').focus(); 
   }
   else if (!password_regex.test(c_password)) {
		var response = 'error';
		var message = "Confirm password must be between 6 to 15 characters";
		$("#password").focus();
   }
   else if (new_password != c_password) {
		var response = 'error';
		var message = "Please enter same password in confirm password";
		$("#c_password").focus();
   }
   if(response == "error" && message != ""){
		$('#pass_error').html(message).addClass('alert error-danger alert-danger').css({'color':'red'});
		return false;
	}
	else{
		$.ajax({
			type: "POST",
			url: BASEURL+'users/edit_password/',
			data: $("#reset_form").serialize(),
			beforeSend: function() {
				$('#pass_error').html('<span style="color:green;">Processing....</span>');
			},
			success: function(rep){
				response = JSON.parse(rep);
				if(response["response"] == "error"){
					$('#pass_error').html(response["message"]).addClass('alert error-danger alert-danger').css({'color':'red'});
				}
				else{
					$('#pass_error').html(response["message"]).css({'color':'green'});
				}
			},
			error: function(rep){
				
			}
	 });
	}
 });

	$("#change_form").submit(function(e) {
	   e.preventDefault();
	
	   var message,response;
	   
	   var change_email = $('#change_email').val();
	   var change_new_email = $.trim($('#change_new_email').val());
	   var confirm_new_email = $.trim($('#confirm_new_email').val());
	  // alert(change_email)	
	   var email_regex = /^[a-zA-Z0-9.'+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	   
	   if(change_email == ""){
			message = "Please enter email";
			response = "error";
			$('#change_email').focus(); 
	   }
	   else if (!email_regex.test($("#change_email").val())) {
			var response = "error";
			var message = "Please enter valid email";
			$('#email').focus();
	   }
	   else if(change_new_email == ""){
			message = "Please enter new email";
			response = "error";
			$('#change_new_email').focus(); 
	   }
	   else if (!email_regex.test($("#change_new_email").val())) {
			var response = "error";
			var message = "Please enter valid new email";
			$('#change_new_email').focus();
	   }
	    else if(confirm_new_email == ""){
			message = "Please enter confirm email";
			response = "error";
			$('#confirm_new_email').focus(); 
	   }
	   else if (!email_regex.test($("#confirm_new_email").val())) {
			var response = "error";
			var message = "Please enter valid confirm email";
			$('#confirm_new_email').focus();
	   }
	   else{
		   var response = "success";
		   var message = "success";
	   }
	   if(response == "error" && message != ""){
			$('#change_email_error').html(message).addClass('alert error-danger alert-danger').css({'color':'red'});
			return false;
		}
		else{
			$.ajax({
				type: "POST",
				url: BASEURL+'users/change_email/',
				data: $("#change_form").serialize(),
				beforeSend: function() {
					$('#change_email_error').html('<span style="color:green;">Processing....</span>');
				},
				success: function(rep){
					response = JSON.parse(rep);
					//console.log(response)
					if(response["response"] == "error"){
						$('#change_email_error').html(response["message"]).addClass('alert error-danger alert-danger').css({'color':'red'});
					}
					else{
						$('#change_email_error').html(response["message"]).css({'color':'green'});
						//$(location).attr('href', BASEURL+"users/profile/");
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
	
	$("#user_info").submit(function(e) {
	   e.preventDefault();
	
	   var message,response;
	   
	   var  first_name = $('#first_name').val();
	   var  last_name = $('#last_name').val();
	 
	   var  country = $('#country').val();
	   var  phone = $('#phone').val();
	   var  day = $('#regday').val();
	   var  month = $('#regmonth').val();
	   var  year = $('#regyear').val();
	   var email_regex = /^[a-zA-Z0-9.'+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	   
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
	  
	   else if(country == ""){
			message = "Please select country";
			response = "error";
			$('#first_name').focus(); 
	   }
	   else if(phone == ""){
			message = "Please enter phone";
			response = "error";
			$('#phone').focus(); 
	   }
	   else if(day == ""){
			message = "Please select day";
			response = "error";
			$('#day').focus(); 
	   }
	   else if(month == ""){
			message = "Please select month";
			response = "error";
			$('#month').focus(); 
	   }
	    else if(year == ""){
			message = "Please select year";
			response = "error";
			$('#year').focus(); 
	   }
	   else{
		   var response = "success";
		   var message = "success";
	   }
	   if(response == "error" && message != ""){
			$('#user_error').html(message).addClass('alert error-danger alert-danger').css({'color':'red'});
			return false;
		}
		else{
			$.ajax({
				type: "POST",
				url: BASEURL+'users/edit_user_to_database/',
				data: $("#user_info").serialize(),
				beforeSend: function() {
					$('#user_error').html('<span style="color:green;">Processing....</span>');
				},
				success: function(rep){
					response = JSON.parse(rep);
					//console.log(response)
					if(response["response"] == "error"){
						$('#user_error').html(response["message"]).addClass('alert error-danger alert-danger').css({'color':'red'});
					}
					else{
						$('#user_error').html(response["message"]).css({'color':'green'});
						//$(location).attr('href', BASEURL+"users/profile/");
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
</script>
