<!-- BANNER -->

<div class="banner"> <img src="<?php echo base_url();?>images/About_Us.jpg" alt="...">
  <div class="text_banner">
    <div class="container">
      <div class="row">
        <div class="col-md-5 bnr">
          <div class="text_left">
            <h1><strong>Blog</strong> </h1>
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
          <div class="col-md-12 main_title"><?php echo $resultset['blog_title']; ?></div>
          <div class="col-md-12 posted">Posted by <span><?php echo $resultset['posted_by']; ?></span> | <?php echo date('d-F-Y',$resultset["date_posted"]);?></div>
          <div class="col-md-12 col-sm-12 col-xs-12 about_div blog_page"> <img src="<?php echo $this->config->item('blogimages'); ?><?php echo $resultset['blog_images']; ?>" alt="" />
            <p><?php echo $resultset['blog_content'];?></p>
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-4 right_side">
        <div class="col-md-12 col-sm-12 col-xs-12 welcome_div about_right">
          <h3>Get more help</h3>
          <p>Find answers to your technology questions with our collection of articles, videos and tutorials.</p>
          <a href="#"><img src="<?php echo base_url();?>images/im2.png" alt="">Chat With Us Now</a> <a href="#"><img src="<?php echo base_url();?>images/im1.png" alt="">Create a Support Case Now</a> </div>
        <div class="col-md-12 col-sm-12 latest latest_abt">
          <h3>LATEST TWEETS</h3>
          <div class="scroll" id="scrol">
            <div class="scrol_one">
              <div class="col-md-3 col-sm-3 imga_scoll"><img src="<?php echo base_url();?>images/logo1.jpg" alt=""/></div>
              <div class="col-md-9 col-sm-9 text_scoll">
                <p>Office 365 firm.com <small>@EPCGroup</small> <small class="minut">1 min ago</small></p>
                <p>Yammy in Space: <a href="https://www.youtube.com/"><span>http://youtube/DMtqW7L65Fg?a </span></a> via <span>@YouTube</span></p>
                <p><i class="fa fa-youtube-play"></i><small>Show Media</small></p>
              </div>
            </div>
            <div class="scrol_one">
              <div class="col-md-3 col-sm-3 imga_scoll"><img src="<?php echo base_url();?>images/logo1.jpg" alt=""/></div>
              <div class="col-md-9 col-sm-9 text_scoll">
                <p>Office 365 firm.com <small>@EPCGroup</small> <small class="minut">1 min ago</small></p>
                <p>Yammy in Space: <a href="https://www.youtube.com/"><span>http://youtube/DMtqW7L65Fg?a </span></a> via <span>@YouTube</span></p>
                <p><i class="fa fa-youtube-play"></i><small>Show Media</small></p>
              </div>
            </div>
            <div class="scrol_one">
              <div class="col-md-3 col-sm-3 imga_scoll"><img src="<?php echo base_url();?>images/logo1.jpg" alt=""/></div>
              <div class="col-md-9 col-sm-9 text_scoll">
                <p>Office 365 firm.com <small>@EPCGroup</small> <small class="minut">1 min ago</small></p>
                <p>Yammy in Space: <a href="https://www.youtube.com/"><span>http://youtube/DMtqW7L65Fg?a </span></a> via <span>@YouTube</span></p>
                <p><i class="fa fa-youtube-play"></i><small>Show Media</small></p>
              </div>
            </div>
            <div class="scrol_one">
              <div class="col-md-3 col-sm-3 imga_scoll"><img src="<?php echo base_url();?>images/logo1.jpg" alt=""/></div>
              <div class="col-md-9 col-sm-9 text_scoll">
                <p>Office 365 firm.com <small>@EPCGroup</small> <small class="minut">1 min ago</small></p>
                <p>Yammy in Space: <a href="https://www.youtube.com/"><span>http://youtube/DMtqW7L65Fg?a </span></a> via <span>@YouTube</span></p>
                <p><i class="fa fa-youtube-play"></i><small>Show Media</small></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- WHITE DIV --> 