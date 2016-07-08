<article class="closed live_auctions closed_auctions"><!--closed-->

  <div class="container"><!--container-->

    <h1>CLOSED AUCTIONS</h1>

    <div class="live_auc"><!--slider1-->

       

 <?php foreach($closed as $ckey=>$cval){ ?>
      <div class="slide" onclick="window.location.href='<?php echo base_url();?>auctions/detail/<?php echo $cval["slug"]?>'"><img src="<?php echo base_url();?>product_images/thumbnail/<?php echo $cval['image'][0];?>">

	  <img class="sold" src="<?php echo base_url()?>images/sold.png" alt="sold image">

        <h2><Span>MINIMUM PRICE: $<?php echo number_format($cval['minimum_price'],2);?></span> RETAIL PRICE: $<?php echo number_format($cval['retail_price'],2);?> <span class="star"><img src="<?php echo base_url()?>images/star.png" alt="rating"></span> $<?php echo number_format($cval['last_bid_price'],2);?> <span>WON BY WHF</span> </h2>

      </div>

<?php } ?>
    </div>

    <!--/slider1--> 

  </div>

  <!--/container--> 

</article>

<!--/live_auctions-->