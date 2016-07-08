<article class="closed live_auctions"><!--closed-->
  <div class="container"><!--container-->
    <h1>GET BIDS </h1>
    <div  id="message">
    <span style="color:red"><?php echo $this->session->flashdata('errormsg'); ?></span> 
    <span style="color:green"><?php echo $this->session->flashdata('successmsg'); ?></span> 
    </div>
    <div id="bidding">
      <div class="row">
        <form method="post" id="addToBascketFormId" action="#" novalidate class="ng-pristine ng-valid">
          <div class="col-md-4">
            <div class="item item1">
              <div class="title">YOUR PACKAGE</div>
              <div class="box">
                <div class="nb"><?php echo $resultset["total_bids"]?> BIDS</div>
                <div class="price"><span>$</span><?php echo $resultset["price"]?></div>
                <div class="plus ">+<?php echo $resultset["free_bids"]?> FREE BIDS </div>
              </div>
              <a class="change" href="<?php echo base_url()?>bids/">CHANGE PACKAGE</a> </div>
          </div>
          <div class="col-md-4">
            <div class="item item2">
              <div class="title">BILLING ADDRESS</div>
              <div class="theform">
                <input type="hidden" name="__RequestVerificationToken">
                <input type="hidden" value="210" name="ekomProductId" id="ekomProductId">
                <div class="form-group">
                  <label for="billingName" class="control-label">Name*</label>
                  <input type="text" value="<?php echo !empty($user_info["name"]) ? $user_info["name"] : "";?>" placeholder="Enter name" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                  <label for="billingEmail" class="control-label">Email Address*</label>
                  <input type="email" value="<?php echo !empty($user_info["email"]) ? $user_info["email"] : "";?>" placeholder="Enter email address" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                  <label for="billingPhone" class="control-label">Phone*</label>
                  <input type="tel" value="<?php echo !empty($user_info["phone"]) ? $user_info["phone"] : "";?>" placeholder="Enter phone" name="phone" id="phone" class="form-control phoneFormat">
                </div>
                <div data-ng-controller="countriesCtrl" class="form-group ng-scope">
                  <label for="billingCountryId" class="control-label">Country*</label>
                  <select value="105" class="form-control" name="country" id="country">
                    <option value="">Select Country</option>
                    <?php foreach($countries as $k =>$v){?>
                    <option value="<?php echo $v["id"];?>" <?php if($v["id"] == $user_info["country"]){echo 'selected="selected"';}?>><?php echo $v["country"];?></option>
                    <?php }?>
                  </select>
                </div>
                <div class="form-group textarea">
                  <label for="billingAddress" class="control-label">Address* </label>
                  <textarea name="address" id="address" class="form-control"><?php echo !empty($user_info["address"]) ? $user_info["address"] : "";?></textarea>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-8 col-md-8">
                    <div class="form-group">
                      <label for="billingcityState" class="control-label">City /state*</label>
                      <input type="text" value="<?php echo !empty($user_info["state"]) ? $user_info["state"] : "";?>" name="state" id="state" class="form-control">
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4">
                    <div style="" class="form-group">
                      <label for="billingZipCode" class="control-label">Zip Code</label>
                      <input type="text" value="<?php echo !empty($user_info["zip"]) ? $user_info["zip"] : "";?>" name="zip" id="zip" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="item">
              <table>
                <tbody>
                  <tr>
                    <td><button type="button" class="pay btn" id="pay">PAY NOW
                      <div class="loader"></div>
                      </button>
                      <div class="notification-container"></div>
                      <div style="text-align: center;"> <img border="0" alt="NetCommerce Security Seal" src="http://www.netcommerce.com.lb/logo/NCseal_M.gif"> </div></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </form>
      </div>
      <div id="hiddenFormContainer"></div>
    </div>
    <!--/slider1--> 
  </div>
  <!--/container-->
  </div>
</article>
<div id="payment_block" class="popup"><!--register_block-->
  <div class="formwrap">
    <div class="box-head"> <a href="javascript:void(0);" class="reg-url current">Payment</a> </div>
    <div class="box-body">
      <div class="element-box">
        <div class="form-fields">
          <span class="payment-errors"></span>
         <form method="POST" id="payment-form" action="<?php echo base_url()?>bids/payment/">
         <input type="hidden" name="plan_id" value="<?php echo $this->uri->segment(3);?>"/>
          <div class="form-row">
            <label for="reg_email">Credit Card No <span class="required">*</span></label>
            <input type="text" id="card"  name="card" maxlength="20" data-stripe="number" value=""  class="input-text">
          </div>
          <div class="form-row">
            <label for="password">Cvv <span class="required">*</span></label>
            <input type="password" id="cvv" class="input-text" name="cvv"  maxlength="4" data-stripe="cvc" value="">
          </div>
          <div class="form-row">
            <label for="reg_email">Expiration Date <span class="required">*</span></label>
            <select name="month" id="month" data-stripe="exp-month">
            <option value="">Select month</option>
            <?php foreach(range(1,31) as $k => $v){?>
             <option value="<?php echo $v;?>" <?php if(date('m')== $v){echo 'selected="selected"';}?>><?php echo $v;?></option>
            <?php }?>
            </select>
            
             <select name="year" id="year" data-stripe="exp-year">
            <option value="">Select year</option>
            <?php foreach(range(date('Y'),date('Y')+15) as $k => $v){?>
             <option value="<?php echo $v;?>" <?php if(date('Y')== $v){echo 'selected="selected"';}?>><?php echo $v;?></option>
            <?php }?>
            </select>
          </div>
          
          
          <!-- Spam Trap -->
          <div class="form-row btm0">
            <input type="submit" value="Pay" name="pay" class="button">
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

  <!-- The required Stripe lib -->
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

  <!-- jQuery is used only for this example; it isn't required to use Stripe -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script type="text/javascript">
  
  $("#pay").click(function(){
	$("#payment_block").show();
	$("#uri").val($(this).attr('rel'));
	$(".overlay").show();
	});

    // This identifies your website in the createToken call below
    Stripe.setPublishableKey('pk_test_Ki2saK26RRG91xJL4iV0zVyY');

    var stripeResponseHandler = function(status, response) {
      var $form = $('#payment-form');
	  //console.log(response)
      if (response.error) {
		  alert(response.error.message);
        // Show the errors on the form
        $form.find('.payment-errors').text(response.error.message);
        $form.find('button').prop('disabled', false);
      } else {
        // token contains id, last4, and card type
        var token = response.id;
        // Insert the token into the form so it gets submitted to the server
		//console.log(token)
        $form.append($('<input type="hidden" name="stripeToken" />').val(token));
        // and re-submit
        $form.get(0).submit();
      }
    };

    jQuery(function($) {
      $('#payment-form').submit(function(e) {
		
		if($("#card").val() == ""){
			alert("Please enter card number");
			return false;
		}
		else if(isNaN($("#card").val())){
			alert("Please enter valid card number");
			return false;
		}
		else if($("#cvv").val() == ""){
			alert("Please enter cvv");
			return false;
		}
		else if(isNaN($("#cvv").val())){
			alert("Please enter valid cvv");
			return false;
		}
		else if($("#month").val() == ""){
			alert("Please select month");
			return false;
		}
		else if($("#year").val() == ""){
			alert("Please select year");
			return false;
		}
		else{
			var $form = $(this);
			// Disable the submit button to prevent repeated clicks
			$form.find('button').prop('disabled', true);
	
			Stripe.card.createToken($form, stripeResponseHandler);
	
			// Prevent the form from submitting with the default action
			return false;
		}
      });
    });
  </script>