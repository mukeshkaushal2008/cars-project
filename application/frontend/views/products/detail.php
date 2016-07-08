<div id="content">
    <div class="content">

        <div class="main_wrapper">

            <h1><strong><?php echo $resultset["model_name"]; ?></strong> </h1>
            <div class="car_image_wrapper car_group">
                <div class="big_image">

                    <a href="<?php echo $resultset["images"][0]["image"] != '' ? base_url() . 'product_images/' . $resultset["images"][0] : base_url() . 'images/placeholders/480x292.gif'; ?>" class="car_group">
                        <img src="<?php echo base_url(); ?>images/zoom.png" alt="" class="zoom"/>
                        <img src="<?php echo $resultset["images"][0]["image"] != '' ? base_url() . 'product_images/' . $resultset["images"][0] : base_url() . 'images/placeholders/480x292.gif'; ?>" alt=""/>
                    </a>
                </div>

                <div class="small_img">
                    <?php
                    if (isset($resultset["images"]) && !empty($resultset["images"])) {
                        foreach ($resultset["images"] as $k => $v) {
                            ?>

                            <a href="<?php echo $v != '' ? base_url() . 'product_images/' . $v : base_url() . base_url() . 'images/placeholders/81x62.gif'; ?>" class="car_group">
                                <img src="<?php echo $v != '' ? base_url() . 'product_images/thumbnail/' . $v : base_url() . base_url() . 'images/placeholders/81x62.gif'; ?>" alt=""/>
                            </a>

    <?php }
} ?></div>
            </div>
            <div class="car_characteristics">
                <a href="#" class="print"></a>
                <div class="price"><?php echo number_format($resultset["retail_price"],2);?> EURO <span>* Price negotiable</span></div>
                <div class="clear"></div>
                <div class="features_table">
                    <div class="line grey_area">
                        <div class="left">Model, Body type:</div>
                        <div class="right"><?php echo $resultset["model_name"];?></div>
                    </div>
                    
                </div>
               
            </div>
            <div class="clear"></div>
            <div class="info_box">
                <div class="car_info">
                    <div class="info_left">
                        <h2><strong>Vehicle</strong> information</h2>
                        <?php echo nl2br(stripcslashes($resultset["short_description"]));?>
                    </div>
                    <div class="info_right">
                        <h2><strong>More</strong> info</h2>
                       
                       <?php echo nl2br(stripcslashes($resultset["long_description"]));?>
                         
                    </div>
                    <div class="clear"></div>
                </div>
                
            </div>
            
            <div class="clear"></div>
            <div class="recent_cars">
                <h2><strong>Similar</strong> offers</h2>
                <ul>
                   <?php if (isset($offers_category_products) && !empty($offers_category_products)) {
                        foreach($offers_category_products as $k => $v) {
                            ?>
                    <li>
                        <a href="<?php echo base_url();?>products/detail/<?php echo $v["slug"];?>">
                            <img src="<?php echo $v["image"] != '' ? base_url() . 'product_images/thumbnail/' . $v["image"] : base_url() . 'images/placeholders/220x164.gif' ; ?>" alt=""/>
                             <div class="description"><?php echo $v["category_name"];?>
                                 <br/> <?php echo $v["brand_name"];?></div>
                            <div class="title"><?php echo $v["model_name"];?> <span class="price">$ <?php echo number_format($v["retail_price"],2);?></span></div>
                        </a>
                    </li>
                   <?php }}?>
                </ul>
            </div>
        </div>
    </div>
</div>