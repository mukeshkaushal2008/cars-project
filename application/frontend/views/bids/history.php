<article class="closed live_auctions"><!--closed-->
  <div class="container"><!--container-->
    <h1>MY ACCOUNT</h1>
    <div id="myaccount">
      <div class="menu2">
        <nav role="navigation" class="navbar" id="accountMenu">
          <div id="bs-example-navbar-collapse-3" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li><a href="<?php echo base_url();?>users/profile/" >Account Details</a></li>
              <li><a href="<?php echo base_url();?>bids/history/" class="selected">Bids History</a></li>
              <li><a href="<?php echo base_url();?>users/address/" >Address Book</a></li>
              <li><a href="<?php echo base_url();?>login/logout/" >Logout</a></li>
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
      <div data-ng-controller="getBidsHistoryListingCtrl" id="bid_details" class="ng-scope"> 
        <!-- ngRepeat: entry in filteredEntries -->
        <?php 
		//debug($bids_history);
		if(count($bids_history) > 0){
		 foreach($bids_history as $k => $v){?>
        	<div class="item ng-scope added">
          <div class="row">
            <div class="col-xs-12 col-sm-1 col-md-1">
              <div class="nb ng-binding"><?php 
			  
			  if($v["type"]=="bid_purchase"){echo '+ '.$v['bids_credited'].' Bids';}
			  else if($v["type"]=="signup"){echo '+ 3 Bids';}else{echo '-1 bid';}
			  ?></div>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-8">
              <div class="details ng-scope"><?php echo $v["message"]?>
              <?php if($v["type"] != "signup" && $v["type"] != "bid_purchase"){?>
              (<?php echo $this->bid_model->get_product_name($v["product_id"]);?>)
              <?php }?>
              </div>
              <!-- end ngIf: entry.isFreeBidsOnRegistration --> 
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3">
              <div class="date ng-binding"><?php echo date('F j,Y h:i a',$v["created_time"]);?></div>
            </div>
          </div>
        </div>
        <?php }}?>
        <!-- end ngRepeat: entry in filteredEntries -->
        <!--<div class="more ng-hide">LOAD MORE</div>-->
      </div>
    </div>
    <!--/slider1--> 
  </div>
  <!--/container-->
  </div>
</article>
