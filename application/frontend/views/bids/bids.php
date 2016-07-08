
<article class="closed live_auctions"><!--closed-->
  <div class="container"><!--container-->
    <h1>GET BIDS</h1>
    <div id="getBids">
      <div class="row ng-scope"> 
        <!-- ngRepeat: entry in entries -->
        <?php foreach($resultset as $k =>$v){?>
        <div class="col-xs-12 col-sm-6 col-md-3 ng-scope">
         <a class="item"  href="javascript:void(0);">
          <div class="nb ng-binding"><?php echo $v["price"];?>$</div>
          <div class="price ng-binding"><span>BIDS</span><?php echo $v["total_bids"];?></div>
          <div class="plus ng-binding visibility-hidden">+<?php echo $v["free_bids"];?> FREE BIDS</div>
          <?php if($this->session->userdata("userid") == ""){?>
          	<div class="buy" id="bid_login" rel="<?php echo base_url();?>bids/buy_plan/<?php echo $v["id"];?>">BUY PACKAGE</div>
          <?php }else{?>
          <div class="buy" onclick="window.location.href='<?php echo base_url();?>bids/buy_plan/<?php echo $v["id"];?>'">BUY PACKAGE</div>
          <?php }?>
          </a>
          </div>
          <?php }?>
        <!-- end ngRepeat: entry in entries --> 
      </div>
    </div>
    <!--/slider1--> 
  </div>
  <!--/container-->
  </div>
</article>

