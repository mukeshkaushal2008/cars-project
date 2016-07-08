<article class="featured"><!-- featured-->
  
  <div class="container" id="containeri"><!-- container-->
   <!--  <h1>FEATURED AUCTIONS</h1>
    
   <div id="insert_product">
    </div>-->
    
    
    
    
  </div>
  <!--/container--> 
</article>
<!--/featured-->

<article class="closed"><!--closed-->
  <div class="container" ><!--container-->
  <h1>CLOSED AUCTIONS</h1>
    <div class="slider1" id="containerii">
   
    </div>
  </div>
  <!--/container--> 
</article>
<!--/closed-->

 <script src="<?php echo base_url();?>js/eventsource.js"></script>
    <script>
	  window.onload = function setDataSource() {
		if (!!window.EventSource) {
			var source = new EventSource('http://hautebids.com/demo/events.php');
			//var source = new EventSource('http://hautebids.com/demo/home/getdata/');
			//console.log(source);
			source.addEventListener("message", function(e) {
				//console.log(e.data);
				updatePrice(e.data);
			}, false);
			
			source.addEventListener("open", function(e) {
				console.log("OPENED");
				//logMessage("OPENED");
			}, false);

			source.addEventListener("error", function(e) {
				//logMessage("ERROR");
				console.log("ERROR");
				if (e.readyState == EventSource.CLOSED) {
					console.log("CLOSED");
					//logMessage("CLOSED");
				}
			}, false);
			
			source.addEventListener("ping", function(e) {
			 // var newElement = document.createElement("li");
			
			  //var obj = JSON.parse(e.data);
			  //console.log(obj.time);
			}, false);
			
		} else {
			document.getElementById("notSupported").style.display = "block";
		}
	}


	function updatePrice(response) {
		 var html='';
		 result = JSON.parse(response);
		 get_featured_product = result.get_featured_product;
		 get_closed_product = result.get_closed_product;
		console.log(get_closed_product["message"]);
		 if(get_closed_product["response"] == "success"){
			 //val = '<h1>CLOSED AUCTIONS</h1>';
			// val += '<div class="slider1">';
			var closed='';
			 $(get_closed_product["message"]).each(function(index, d){
				//console.log(index+"--+----"+d.minimum_price);
				closed +='<div class="slide"><img src="<?php echo base_url();?>product_images/thumbnail/'+d.image[0]+'"><h2><Span>MINIMUM PRICE: $'+d.minimum_price+'</span> RETAIL PRICE: $'+d.retail_price+' <span class="star"><img src="<?php echo base_url();?>images/star.png" alt="rating"></span> $'+d.last_bid_price+' <span>PASSED</span> </h2>';
			 });
			 //val += '</div>';
			//val += '</div>';
			$("#containerii").html(closed);
		 }
		 else{
			  $("#containerii").html('');
			  $("#containerii").html(get_closed_product["message"]);
		 }
		 if(get_featured_product["response"] == "success"){
			 //console.log(gethomeproductdata["message"][0].name);
			 //$(gethomeproductdata["message"]).each(function(index, data) {
				//console.log(index+"--+----"+data.name);
				 data0 = get_featured_product["message"][0];
				 data1 = get_featured_product["message"][1];
				 data2 = get_featured_product["message"][2];
				 data3 = get_featured_product["message"][3];
				 data4 = get_featured_product["message"][4];
				 data5 = get_featured_product["message"][5]; 
				html = '<h1>FEATURED AUCTIONS</h1>';
				if(data0 != undefined){
					 html +='<div class="product">';
					 html +='<figure class="product_img"><img  src="<?php echo base_url();?>product_images/'+data0.image[0]+'" alt="product"> </figure>';
					 html +='<div class="product_left">';
					 html +='<img src="<?php echo base_url();?>product_images/thumbnail/'+data0.image[1]+'" alt="product image"> </div>';
					 html +='<div class="product_right">';
					 html +='<h2><Span>MINIMUM PRICE: $'+data0.minimum_price+'</span> RETAIL PRICE: $'+data0.retail_price+' <span class="star">';
					 html +='<img src="'+BASEURL+'images/star.png" ></span> $'+data0.last_bid_price+' <span>$ '+data0.end_date+'</span> </h2>';
					 html +='<button class="buy" type="button">BUY NOW</button>';
					 html +='</div>';
					 html +='</div>';
				}
				 if(data1 != undefined){
					 html +='<div class="product product_mid">';
					 html +='<figure class="product_img">';
					 html +='<img src="<?php echo base_url();?>product_images/'+data1.image[0]+'" alt="product"> </figure>';
					 html +='<div class="product_center">';
					 html +='<h2><Span>MINIMUM PRICE: $'+data1.minimum_price+'</span> RETAIL PRICE: $'+data1.retail_price+' <span class="star"><img src="<?php echo base_url();?>images/star.png" alt="rating"></span> $'+data1.last_bid_price+' <span>$ '+data1.end_date+'</span> </h2>';
					 html +='<button class="buy" type="button">BUY NOW</button>';
					 html +='</div>';
					 html +='</div>';
				 }
				 if(data2 != undefined){
					 html +='<div class="product product_last">';
					 html +='<figure class="product_img">';
					 html +='<img src="<?php echo base_url();?>product_images/'+data2.image[0]+'" alt="product"> </figure>';
					 html +='<div class="second_p">';
					 html +='<div class="product_left">';
					 html +=' <h2><Span>MINIMUM PRICE: $'+data2.minimum_price+'</span> RETAIL PRICE: $'+data2.retail_price+' <span class="star"><img src="<?php echo base_url();?>images/star.png" alt="rating"></span> $'+data2.last_bid_price+' <span>$ '+data2.end_date+'</span> </h2>';
					 html +=' <button class="buy" type="button">BUY NOW</button>';
					 html +='</div>';
					 html +='<div class="product_right">';
					 html +='<img src="<?php echo base_url();?>product_images/'+data2.image[1]+'" alt="product image"> </div>';
					 html +='</div>';
					 html +='</div>';
				 }
				 if(data3 != undefined){
					 html +='<div class="product product_mid">';
					 html +='<figure class="product_img">'; 
					 html +='<img src="<?php echo base_url();?>product_images/'+data3.image[0]+'" alt="product"> </figure>';
					 html +='<div class="product_center">';
					 html +='<h2><Span>MINIMUM PRICE: $'+data3.minimum_price+'</span>';
					 html +='RETAIL PRICE: $'+data3.retail_price+' <span class="star"><img src="'+BASEURL+'images/star.png" alt="rating"></span> $'+data3.last_bid_price+' <span>$'+data3.end_date+'</span> </h2>';
					 html +='<button class="buy" type="button">BUY NOW</button>';
					 html +='</div>';
					 html +='</div>';
				 }
    			 if(data4 != undefined){
					 html +='<div class="product product_last">';
					 html +='<figure class="product_img">'; 
					 html +='<img src="<?php echo base_url();?>product_images/'+data4.image[0]+'" alt="product"> </figure>';
					 html +='<div class="second_p">';
					 html +='<div class="product_left">';
					 html +='<h2><Span>MINIMUM PRICE: $'+data4.minimum_price+'</span> RETAIL PRICE: $'+data4.retail_price+' <span class="star"><img src="'+BASEURL+'images/star.png" alt="rating"></span> $'+data4.last_bid_price+' <span>$'+data4.end_date+'</span> </h2>';
					 html +='<button class="buy" type="button">BUY NOW</button>';
					 html +='</div>';
					 html +='<div class="product_right">'; 
					 html +='<img src="<?php echo base_url();?>product_images/'+data4.image[1]+'" alt="product image"> </div>';
					 html +='</div>';
					 html +='</div>';
				 }
				 if(data5 != undefined){
					 html +='<div class="product product_mid">';
					 html +='<figure class="product_img">'; 
					 html +='<img src="<?php echo base_url();?>product_images/'+data5.image[0]+'" alt="product"> </figure>';
					 html +='<div class="product_center">';
					 html +='<h2><Span>MINIMUM PRICE: $'+data5.minimum_price+'</span> RETAIL PRICE: $'+data5.retail_price+' <span class="star"><img src="'+BASEURL+'images/star.png" alt="rating"></span> $'+data5.last_bid_price+' <span>$'+data5.end_date+'</span> </h2>';
					 html +='<button class="buy" type="button">BUY NOW</button>';
					 html +='</div>';
					 html +='</div>';
				 }
			//});
			$("#containeri").html(html);
		 }
		 else{
			 $("#containeri").html('');
			 $("#containeri").html(get_featured_product["message"]);
		 }
	}
	//logMessage(data);
	function show_bidder(e){
		
		var el = document.getElementById("log");
		el.innerHTML += e + "<br>";
	}
	function logMessage(obj) {
		
		var el = document.getElementById("log");
		if (typeof obj === "string") {
			el.innerHTML += obj + "<br>";
		} else {
			el.innerHTML += obj.lastEventId + " - " + obj.data + "<br>";
		}
		
		
		el.scrollTop += 20;
	}

$(document).on('click','.bid_now',function(){

	$.ajax({
			type : 'POST',
			url  : 'stocks.php',
			data : {'bid_price':email},
			beforeSend : function(){
		
			},
			success: function(rep){
				object = JSON.parse(rep);
				
				if(object["response"] == 'error')
				{
					$('#error_news').html(object["message"]).css({'color':'red'}).show();
				}
				else
				{
					$('#error_news').html(object["message"]).css({'color':'green'}).show("fast",function(){
						window.location.href = uri;
					});
				}
			},
			error: function(rep)
			{
				$('#'+formid).find('input, textarea, select, button, checkbox, radio').prop('disabled',false);
				if(rep.readyState == 4){
					$('#error_news').html(rep.statusText).css({'color':'red'}).show();
				}
			}
		});
});
 /********************************news letters starts ***************************************************/   
function newsletters(element){	
	 var e = $(element);//element 
	 var formid = e.parents("form").attr("id");
	 var email = $("#news_email").val();
	 var uri = $("#news_uri").val();
	 var email_regex =  /^[a-zA-Z0-9.'+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	 var response,message;
	
	if(email == ""){
		 response = 'error';
		 message = "Please enter email subscribe";
		 $("#news_email").focus();
    }
	else if (!email_regex.test($("#news_email").val())) {
		response = "error";
		message = "Please enter correct email";
		$('#news_email').focus();
	}
	else{
		 $.ajax({
			type : 'POST',
			url  : BASEURL+'users/newsletters/',
			data : {'email':email,'uri':uri},
			beforeSend : function(){
			},
			success: function(rep){
				object = JSON.parse(rep);
				console.log(object)
				if(object["response"] == 'error')
				{
					$('#error_news').html(object["message"]).css({'color':'red'}).show();
				}
				else
				{
					$('#error_news').html(object["message"]).css({'color':'green'}).show("fast",function(){
  						window.location.href = uri;
					});
				}
			},
			error: function(rep)
			{
				if(rep.readyState == 4){
					$('#error_news').html(rep.statusText).css({'color':'red'}).show();
				}
			}
		});
		//return false;
	 }
	 if(message != '' && message != null) {
		if(response == 'error'){
			$('#error_news').html(message).css({'color':'red'}).show();
			return false;
		}
	}
  }
 /********************************news letters ends ***************************************************/   


</script>	
