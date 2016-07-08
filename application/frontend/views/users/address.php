<?php //debug($resultset);?>
<article class="closed live_auctions"><!--closed-->
  <div class="container"><!--container-->
    <h1>MY ACCOUNT</h1>
    <div id="myaccount">
      <div class="menu2">
        <nav role="navigation" class="navbar" id="accountMenu">
          <div id="bs-example-navbar-collapse-3" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
             <li><a href="<?php echo base_url();?>users/profile/" >Account Details</a></li>
              <li><a href="<?php echo base_url();?>bids/history/" >Bids History</a></li>
              <li><a href="<?php echo base_url();?>users/address/" class="selected">Address Book</a></li>
              <li><a href="<?php echo base_url();?>login/logout/" >Logout</a></li>
            </ul>
          </div>
        </nav>
      </div>
      <div class="myAcc" id="bidding">
        <div class="row">
          <div class="col-xs-12 col-sm-6  col-md-4">
            <div class="item item2">
              <div class="title">BILLING ADDRESS</div>
              <div class="theform">
             
              <span id="billing_error"></span>
                <form id="billing_info">
                <input type="hidden" name="id" value="<?php echo !empty($resultset["id"]) ? $resultset["id"] : "";?>" />
                <input type="hidden" name="is_billing" value="1" />
                  <div class="form-group">
                    <label for="billingName" class="control-label">Name*</label>
                    <input type="text" value="<?php echo !empty($resultset["name"]) ? $resultset["name"] : "";?>" placeholder="Enter name" name="name" id="name" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="billingEmail" class="control-label">Email Address*</label>
                    <input type="email" value="<?php echo !empty($resultset["email"]) ? $resultset["email"] : "";?>" placeholder="Enter email address" name="email" id="email" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="billingPhone" class="control-label">Phone*</label>
                    <input type="tel" value="<?php echo !empty($resultset["phone"]) ? $resultset["phone"] : "";?>" placeholder="Enter phone" name="phone" id="phone" class="form-control phoneFormat">
                  </div>
                  <div  class="form-group ng-scope">
                    <label for="billingCountryId" class="control-label">Country*</label>
                    <select class="form-control" name="country" id="country">
                      <option value="">Select Country</option>
                      <?php foreach($this->common->get_all_countries() as $k =>$v){?>
                      <option value="<?php echo $v["id"];?>" <?php if($resultset["country"] == $v["id"]){echo 'selected="selected"';}?>><?php echo $v["country"];?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="form-group textarea">
                    <label for="billingAddress" class="control-label">Address* </label>
                    <textarea name="address" id="address" class="form-control"><?php echo !empty($resultset["address"]) ? $resultset["address"] : "";?></textarea>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8">
                      <div class="form-group">
                        <label for="state" class="control-label">City /state*</label>
                        <input type="text" value="<?php echo !empty($resultset["state"]) ? $resultset["state"]: "";?>" name="state" id="state" class="form-control">
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                      <div style="" class="form-group">
                        <label for="billingZipCode" class="control-label">Zip Code</label>
                        <input type="text" value="<?php echo !empty($resultset["zip"]) ? $resultset["zip"] : "";?>" name="zip" id="zip" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12  col-md-12">
                      <button type="submit" class="save btn"> SAVE
                      <div class="loader"></div>
                      </button>
                      <div class="notification-container"></div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6  col-md-4">
            <div class="item item2">
              <div class="title">SHIPPING ADDRESS
                <div class="col-xs-12 col-sm-6  col-md-6">
                  <div class="input-group"> <span class="input-group-addon">
                    <input type="checkbox"  id="same_as_billing" <?php if($resultset1["is_billing"]==1){echo 'checked="checked"';}?>>
                    <label for="sameAsBillingAddress">Same as billing </label>
                    </span> </div>
                </div>
              </div>
             
              <div class="theform">
                <span id="shipping_error"></span>
                <form id="shipping_info"  method="post" action="">
                 <input type="hidden" id="row_id" name="id" value="<?php echo !empty($resultset1["id"]) ? $resultset1["id"] : "";?>" />
                <input type="hidden" name="is_billing" id="is_billing" value="" />
                  <div class="form-group">
                    <label for="shippingName" class="control-label">Name*</label>
                    <input type="text" value="<?php echo !empty($resultset1["name"]) ? $resultset1["name"] : "";?>" placeholder="Enter name" name="shipping_name" id="shipping_name" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="shippingEmail" class="control-label">Email Address*</label>
                    <input type="email" value="<?php echo !empty($resultset1["email"]) ? $resultset1["email"] : "";?>" placeholder="Enter enmail address" name="shipping_email" id="shipping_email" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="shippingPhone" class="control-label">Phone*</label>
                    <input type="tel" value="<?php echo !empty($resultset1["phone"]) ? $resultset1["phone"] : "";?>" placeholder="Enter phone" name="shipping_phone" id="shipping_phone" class="form-control phoneFormat">
                  </div>
                  <div data-ng-controller="dhlCountriesCtrl" class="form-group ng-scope">
                    <label for="shippingCountryId" class="control-label">Country*</label>
                    <select  class="form-control" name="shipping_country" id="shipping_country">
                    <option value="">Select Country</option>
                      <?php foreach($this->common->get_all_countries() as $k =>$v){?>
                      <option value="<?php echo $v["id"];?>" <?php if($resultset1["country"] == $v["id"]){echo 'selected="selected"';}?>><?php echo $v["country"];?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="form-group textarea">
                    <label for="shippingAddress" class="control-label">Address*</label>
                    <textarea name="shipping_address" id="shipping_address" class="form-control"><?php echo !empty($resultset1["address"]) ? $resultset1["address"] : "";?></textarea>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8">
                      <div class="form-group">
                        <label for="shippingCityState" class="control-label">City /state*</label>
                        <input type="text" value="<?php echo !empty($resultset1["state"]) ? $resultset1["state"] : "";?>" name="shipping_state" id="shipping_state" class="form-control">
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                      <div style="" class="form-group">
                        <label for="shippingZipCode" class="control-label">Zip Code</label>
                        <input type="text" name="shipping_zip"  value="<?php echo !empty($resultset1["zip"]) ? $resultset1["zip"] : "";?>" id="shipping_zip" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12  col-md-12">
                      <button type="submit" class="save btn"> SAVE
                      <div class="loader"></div>
                      </button>
                      <div class="notification-container"></div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12  col-md-4"> </div>
        </div>
      </div>
    </div>
    <!--/slider1--> 
  </div>
  <!--/container-->
  </div>
</article>
<script>
$(document).on('change','#same_as_billing',function(){
   var  name = $('#name').val();
   var  email = $('#email').val();
   var  phone = $('#phone').val();
   var  country = $('#country').val();
   var  address = $('#address').val();
   var  state = $('#state').val();
   var  zip = $('#zip').val();
   if($(this).is(":checked") == true){
	  // $("#shipping_info").find('input, textarea, select').css({'background-color': '#ccc;'});
	   $("#is_billing").val('1');
	   $('#shipping_name').val(name);
	   $('#shipping_email').val(email);
	   $('#shipping_phone').val(phone);
	   $('#shipping_country').val(country);
	   $('#shipping_address').val(address);
	   $('#shipping_state').val(state);
	   $('#shipping_zip').val(zip);
   }
   else{
	   //alert("asda")
	   $("#shipping_info").find('input, textarea, select').each(function(index, element) {
        $(this).not("#row_id").val('');$('#shipping_country').val('');
		 $("#is_billing").val('');
      });
   }
});
$("#shipping_info").submit(function(e) {
	   e.preventDefault();
	   var message,response;
	   
	   var  same_as_billing = $('#same_as_billing').is(":checked") ? 1:0;
	 // alert(same_as_billing)
	   var  shipping_name = $('#shipping_name').val();
	   var  shipping_email = $('#shipping_email').val();
	   var  shipping_phone = $('#shipping_phone').val();
	   var  shipping_country = $('#shipping_country').val();
	   var  shipping_address = $('#shipping_address').val();
	   var  shipping_state = $('#shipping_state').val();
	   var  shipping_zip = $('#shipping_zip').val();
	   var email_regex = /^[a-zA-Z0-9.'+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	   
	   if(shipping_name == ""){
			message = "Please enter shipping  name";
			response = "error";
			$('#shipping_name').focus(); 
	   }
	   else if(shipping_email == ""){
			message = "Please enter shipping email";
			response = "error";
			$('#shipping_email').focus(); 
	   }
	   else if (!email_regex.test($("#shipping_email").val())) {
			var response = "error";
			var message = "Please enter valid shipping email";
			$('#shipping_email').focus();
	   }
	   else if(shipping_phone == ""){
			message = "Please enter shipping phone";
			response = "error";
			$('#shipping_phone').focus(); 
	   }
	   else if(shipping_country == ""){
			message = "Please select shipping country";
			response = "error";
			$('#shipping_country').focus(); 
	   }
	   else if(shipping_address == ""){
			message = "Please enter shipping  address";
			response = "error";
			$('#shipping_address').focus(); 
	   }
	   else if(shipping_state == ""){
			message = "Please enter shipping state";
			response = "error";
			$('#shipping_state').focus(); 
	   }
	    else if(shipping_zip == ""){
			message = "Please enter shipping zip";
			response = "error";
			$('#shipping_zip').focus(); 
	   }
	   else{
		   var response = "success";
		   var message = "success";
	   }
	   if(response == "error" && message != ""){
			$('#shipping_error').html(message).addClass('alert error-danger alert-danger').css({'color':'red'});
			return false;
		}
		else{
			$.ajax({
				type: "POST",
				url: BASEURL+'users/add_shipping/',
				data: $("#shipping_info").serialize(),
				beforeSend: function() {
					$('#shipping_error').html('<span style="color:green;">Processing....</span>');
				},
				success: function(rep){
					response = JSON.parse(rep);
					//console.log(response)
					if(response["response"] == "error"){
						$('#shipping_error').html(response["message"]).addClass('alert error-danger alert-danger').css({'color':'red'});
					}
					else{
						$("#row_id").val(response["id"]);
						$('#shipping_error').html(response["message"]).css({'color':'green'});
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
$("#billing_info").submit(function(e) {
	   e.preventDefault();
	
	   var message,response;
	   
	   var  name = $('#name').val();
	   var  email = $('#email').val();
	   var  phone = $('#phone').val();
	   var  country = $('#country').val();
	   var  address = $('#address').val();
	   var  state = $('#state').val();
	   var  zip = $('#zip').val();
	   var email_regex = /^[a-zA-Z0-9.'+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	   
	   if(name == ""){
			message = "Please enter billing  name";
			response = "error";
			$('#first_name').focus(); 
	   }
	   else if(email == ""){
			message = "Please enter billing email";
			response = "error";
			$('#email').focus(); 
	   }
	   else if (!email_regex.test($("#email").val())) {
			var response = "error";
			var message = "Please enter valid billing email";
			$('#email').focus();
	   }
	   else if(phone == ""){
			message = "Please enter billing phone";
			response = "error";
			$('#phone').focus(); 
	   }
	   else if(country == ""){
			message = "Please select billing country";
			response = "error";
			$('#country').focus(); 
	   }
	   else if(address == ""){
			message = "Please enter billing  address";
			response = "error";
			$('#address').focus(); 
	   }
	   else if(state == ""){
			message = "Please enter billing state";
			response = "error";
			$('#state').focus(); 
	   }
	    else if(zip == ""){
			message = "Please enter billing zip";
			response = "error";
			$('#zip').focus(); 
	   }
	   else{
		   var response = "success";
		   var message = "success";
	   }
	   if(response == "error" && message != ""){
			$('#billing_error').html(message).addClass('alert error-danger alert-danger').css({'color':'red'});
			return false;
		}
		else{
			$.ajax({
				type: "POST",
				url: BASEURL+'users/add_billing/',
				data: $("#billing_info").serialize(),
				beforeSend: function() {
					$('#billing_error').html('<span style="color:green;">Processing....</span>');
				},
				success: function(rep){
					response = JSON.parse(rep);
					//console.log(response)
					if(response["response"] == "error"){
						$('#billing_error').html(response["message"]).addClass('alert error-danger alert-danger').css({'color':'red'});
					}
					else{
						$('#billing_error').html(response["message"]).css({'color':'green'});
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
</script>