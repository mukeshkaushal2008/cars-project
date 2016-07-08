<script src="<?php echo base_url();?>js/eventsource.js"></script> 
<article class="closed live_auctions" >
  <div class="container" >
    <h1>LIVE AUCTIONS</h1>
	<div class="live_auc" id="containeri" >
    </div>
    </div>
  </div>
</article>

<script>
	  window.onload = function setDataSource() {
		if (!!window.EventSource) {
			var source = new EventSource('http://hautebids.com/demo/auction.php');
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
			  //var newElement = document.createElement("li");
			
			  //var obj = JSON.parse(e.data);
			  //console.log(obj.time);
			}, false);
			
		} else {
			document.getElementById("notSupported").style.display = "block";
		}
	}
	var lastId = '';
	function updatePrice(response) {
		//if(response != lastId){
		 var html='';
		 result = JSON.parse(response);
		 get_live_product = result.get_live_product;
		//console.log(get_live_product);
		  if(get_live_product["response"] == "success"){
			 html = ''; url = '';
			 $(get_live_product["message"]).each(function(index, data) {
				//console.log(index+"--+----"+data.name);
				url = BASEURL+'auctions/detail/'+data.slug;
				html +='<div class="slide"  rel = '+url+' onClick="redirect(this)"><img src="<?php echo base_url();?>product_images/thumbnail/'+data.image[0]+'">';
				html +='<h2><Span>MINIMUM PRICE: $'+data.minimum_price+'</span> RETAIL PRICE: $'+data.retail_price+' <span class="star"><img src="'+BASEURL+'images/star.png" ></span> $'+data.last_bid_price+' <span>'+data.end_date+'</span> </h2>';
				html +='</div>';
			 });
			$("#containeri").html(html);
		 }
		 else{
			 $("#containeri").html('');
			 $("#containeri").html(get_live_product["message"]);
		 }
		 /*lastId = response;
		 console.log("fdsf"+lastId)
		}
		else{
				console.log("yes")
		}*/
	}
	function redirect(url){
		window.location.href = $(url).attr("rel");
	}
	</script>