<?php 
//1434862799
//echo time()+25?>
<script src="<?php echo base_url();?>js/eventsource.js"></script>

<article class="closed live_auctions">
<!--closed-->
<div class="container">
<!--container-->
<h1>Product Detail</h1>
<div class="product" id="product_images"><!--product--> 
  
</div>
<!--/product-->

<form method="post" id="form_product">

<input type="hidden" name="bid_price" id="current_bidder_price" value="" />
<input type="hidden" name="product_id" id="product_id" value="" />
<input type="hidden" name="end_timestamp" id="end_sec" value="" />

  <div class="product_det">
    <div class="title" id="brand"></div>
    <div class="subtitle" id="name"></div>
    <!--if product time is not expired -->
    <div id="product_live" style="display:none">
    <div class="details">
      <div class="product_blocker">
        <div class="titre">Retail</div>
        <div class="value" id="retail_price">$ </div>
      </div>
      <div class="product_blocker">
        <div class="titre">Minimum Price</div>
        <div class="value ng-binding" id="min_price">$ </div>
      </div>
      <div class="product_blocker">
        <div class="titre">You save</div>
        <div class="value ng-binding" id="save_price">$ </div>
      </div>
    </div>
	<div class="timeDiv">
      <div class="row">
        <div class="price ng-binding">$ <span id="last_bidder_price"></span></div>
        <div class="date">
          <div class="no-connection">INTERNET DISCONNECTED</div>
          <div class="timer-container">
          
            <timer class="timer" id="counter"></timer>
            <div class="bidder"><span>last bidder <strong id="last_bidder_name"></strong></span></div>
           
          </div>
        </div>
        <?php if($this->session->userdata("userid") <> ""){?>
        	<div class="bid_toggle bid_now">BID NOW</div>
        <?php }else{?>
        <div class="bid_toggle bid_now" id="bid_login" rel="<?php echo current_url();?>">Login</div>
        <?php }?>
       <span  id="error_news"></span>
        <div ng-show="productEntry.isLive" ng-if="productEntry.isLive" class="bidBox ng-scope">
          <div class="row"> 
           
            <div class="col-xs-12 col-sm-12 col-md-5"> <a class="how" data-toggle="modal" data-target="#howPop">HOW DOES AN AUCTION END <span class="toltipaction">?
			
			<div class="toltipcoption">when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived.</div>
			
			</span></a> </div>
          </div>
        </div>
        
      </div>
    </div>    
    </div>
    
   <div id="product_close" style="display:none">
        <div class="details" >
        <div class="row">
            <div ng-class="productEntry.isLive ?'col-xs-6 col-sm-4 col-md-3':'col-xs-6 col-sm-6 col-md-6'" class="col-xs-6 col-sm-6 col-md-6">
                <div class="titre">Retail</div>
                <div class="value ng-binding strike" id="retail_price_close">$ </div>
            </div>
        </div>
    </div>
        <div class="winner ng-scope">
       <div class="ng-scope" >WON BY <span class="name ng-binding" id="winner_name"></span></div>
        <br>
        <span class="price ng-binding" id="winner_price">$ </span>
        <span class="saved ng-binding" id="winner_saved">$ </span>
    </div>
       <!-- if product time is not expired -->
    </div>
  </div>
</form>
<div class="product_summary">
<div class="product_about">
  <h2>ABOUT THIS ITEM</h2>
  <p id="short_description"></p>
</div>
<div class="latest_bidder">
<h2>LAST BIDDERS</h2>
<ul class="latest_bodder_list" id="bidder_list">
<ul>
</div>
</div>
<!--/slider1-->
</div>
<!--/container-->
</div>
</article>


<script>
$(document).on('mouseover','.thumb_hover',function(){
	var div = $('#product_images .main_image img');
	div.attr('src',BASEURL+'product_images/'+$(this).data('src'));
});
	  window.onload = function setDataSource() {
		if (!!window.EventSource) {
			var source = new EventSource('http://hautebids.com/demo/products.php');
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
			
		} else {
			document.getElementById("notSupported").style.display = "block";
		}
	}
	var lastId = '';
	function updatePrice(response) {
		//if(response != lastId){
		 var html='';var bidder=''; var image='';
		 result = JSON.parse(response);
		 get_product_detail = result.get_product_detail;
			
		  if(get_product_detail["response"] == "success"){
			 html = ''; url = '';
			// $(get_product_detail["message"]).each(function(index, data) {
				//console.log(index+"--+----"+data.name);
				data = get_product_detail["message"][0];
				//console.log(data);
				/*url = BASEURL+'auctions/detail/'+data.slug;
				html +='<div class="slide"  rel = '+url+' onClick="redirect(this)"><img src="<?php echo base_url();?>product_images/thumbnail/'+data.image[0]+'">';
				html +='<h2><Span>MINIMUM PRICE: $'+data.minimum_price+'</span> RETAIL PRICE: $'+data.retail_price+' <span class="star"><img src="'+BASEURL+'images/star.png" ></span> $'+data.last_bid_price+' <span>'+data.end_date+'</span> </h2>';
				html +='</div>';*/
				image ='<div class="main_image ng-scope-img">';
				image +='<img style="max-width:372px;max-height:267px;" src="<?php echo base_url();?>product_images/'+data.image[0]+'" class="zoomImg" >';
				image +='</div>';
				 $(data.image).each(function(i, img) {
					// console.log(i)
					image +='<div data-src="'+img+'" class="thumb_hover product_inner" style="float:none !important">';
					image +='<div class="inner" style="text-align: left !important;width:23.33% !important">';
					image +='<img alt="" style="width:100%; height:80px;margin-top:10px;"  src="<?php echo base_url();?>product_images/thumbnail/'+img+'"> </div>';
					image +='</div>';
				 });
				
				//last bidder section 
				if(data.last_bidder != 0){
					$(data.last_bidder).each(function(i, b) {
						console.log(b.price)
						if(i==0){last_bidder_name = b.name;last_bidder_price = b.price;}
						bidder +='<li class="item ng-scope">';
						bidder +='<div class="flag ng-scope"></div>';
						bidder +='<div class="name ng-binding">'+b.name+'</div>';
						bidder +='<div class="price ng-binding">$ '+b.price+'</div>';
						bidder +='</li>';
					});
					$("#current_bidder_price").val(last_bidder_price);
				}else{
					last_bidder_name = 'N/A';
					last_bidder_price = '0';
					bidder = 'No bidder found';
					$("#current_bidder_price").val(last_bidder_price);
				}
			
			 //});
			 if(data.end_date == "0d 0h 0m 0s")
			 {
				 $("#product_live").hide();
				 $("#product_close").show();
				 $("#retail_price_close").text(data.retail_price);
				 $("#winner_name").text();
				 $("#winner_price").text();
				 $("#winner_saved").text();
			 }
			 else{
				 $("#product_live").show();
				 $("#product_close").hide();
			}	 
			 $("#end_sec").text(data.end_seconds);
			 $("#product_id").val(data.product_id);
			 $("#product_images").html(image);
			 $("#name").text(data.name);
			 $("#brand").text(data.brand);
			 $("#retail_price").text(data.retail_price);
			 $("#min_price").text(data.minimum_price);
			 $("#save_price").text(data.save);
			 $("#short_description").text(data.short_description);
			 $("#counter").text(data.end_date);
			 $("#last_bidder_price").text(last_bidder_price);
			 $("#last_bidder_name").text(last_bidder_name);
			 $("#bidder_list").html(bidder);
		 }
		 else{
			 $("#containeri").html('');
			 $("#containeri").html(get_product_detail["message"]);
		 } 
	}
$(document).on('click','.bid_now',function(){

	$.ajax({
			type : 'POST',
			url  : BASEURL+'auctions/bid_now',
			data : $("#form_product").serialize(),
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
						//window.location.href = uri;
					});
				}
			},
			error: function(rep)
			{
				$('#form_product').find('input, textarea, select, button, checkbox, radio').prop('disabled',false);
				if(rep.readyState == 4){
					$('#error_news').html(rep.statusText).css({'color':'red'}).show();
				}
			}
		});
});

	</script>