<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12"> 
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title"> Add Blog </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li> <i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>"> Home </a> <i class="fa fa-angle-right"></i> </li>
            <li> <a href="javascript:void(0);"> Add Blog </a> </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB--> 
    </div>
</div>
<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->
<div  id="message">
    <font color='red'><?php echo $this->session->flashdata('errormsg'); ?></font> 
    <font color='green'><?php echo $this->session->flashdata('successmsg'); ?></font> </div>
<div class="row profile">
    <div class="col-md-12"> 
        <!--BEGIN TABS-->
        <div class="tabbable tabbable-custom tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active"> <a href="#tab_1_1" data-toggle="tab"> Add Blog </a> </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1_1">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row"></div>
                            <!--end row-->
                            <div class="tab-pane active" id="tab1"></div>
                            <form name="frm" id="frm" action="<?php echo base_url() . $this->router->class; ?>/add_blog_to_database" method="post" enctype="multipart/form-data">

                                <?php if ($do == "edit") { ?>
                                    <input type="hidden" name="id" value="<?php echo $blogdata['id']; ?>">
                                    <input type="hidden" name="per_page" value="<?php echo!empty($_GET['per_page']) ? $_GET['per_page'] : ""; ?>">
                                <?php } ?>


                                <div class="form-group flare">
                                    <label class="control-label col-md-4"> Title<span class="required"> * </span> </label>
                                    <div class="col-md-8">
                                        <input class="form-control"  name="blog_title" id="blog_title" type="text" value="<?php echo !empty($blogdata['blog_title']) ? $blogdata['blog_title'] : ""; ?>"/>
                                    </div>
                                </div>
								
                                <div class="form-group flare">
                                    <label class="control-label col-md-4"> Posed by<span class="required"> * </span> </label>
                                    <div class="col-md-8">
                                        <input class="form-control"  name="posted_by" id="posted_by" type="text" value="<?php echo !empty($blogdata['posted_by']) ? $blogdata['posted_by'] : ""; ?>"/>
                                    </div>
                                </div>
                                
                                <div class="form-group flare">
                                    <label class="control-label col-md-4"> Description :<span class="required"> * </span> </label>
                                    <div class="col-md-8">
                                        <textarea style="min-height:150px" class="form-control" name="blog_content" id="blog_content"><?php echo !empty($blogdata['blog_content']) ? $blogdata['blog_content'] : ""; ?></textarea>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-md-4">Upload Photo<?php if ($do != "edit") { ?><span class="required">*</span><?php } ?></label>
                                    <div class="col-md-8">
                                        <div style="position:relative;margin-bottom: 15px;">
                                            <a class='btn btn-primary' href='javascript:void(0);'>
                                                Choose File...
                                                <input accept="image/*"  name="userfile"  id="userfile" type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;'  size="40"  onchange='$("#upload-file-info").html($(this).val());'>
                                            </a>
                                            &nbsp;
                                            <span class='label label-info' id="upload-file-info"></span>
                                        </div>

  <!--<input type="file" class="form-control" name="image" id="image">
  </br>-->

                                        <?php if ($do == "edit") { ?>
                                            <img src="<?php echo!empty($blogdata['blog_images']) ? $this->config->item("blogimages") . $blogdata['blog_images'] : $this->config->item("default_image"); ?>" style="height:100px;width:120px; border:1px solid gray;" />
                                            <input type="hidden" name="blog_images" value="<?php echo $blogdata["blog_images"]; ?>">
                                        <?php } ?>
                                        <span class="help-block" id="image_error"> </span>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-md-4">&nbsp; </label>
                                    <div class="col-md-8">
                                        <input type="submit" value="Save" class="btn theme-btn green pull-left" >
                                        <a href="<?php echo base_url() . $this->router->class; ?>/manage_blog"  class="btn theme-btn grey pull-left margd">Cancel</a>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--tab_1_2--> 

    </div>
</div>

<!--END TABS--> 
</div>
<!-- END PAGE CONTENT--> 

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script> 
<!-- END CORE PLUGINS --> 
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"  type="text/javascript" ></script> 
<script src="<?php echo base_url(); ?>assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script> 
<script src="<?php echo base_url(); ?>assets/scripts/core/app.js"></script> 
<script src="<?php echo base_url(); ?>assets/scripts/custom/search.js"></script> 
<script>
                                                    jQuery(document).ready(function() {
                                                        App.init();
                                                        Search.init();
                                                    });
</script>
<?php empty_field('temp_blog_data'); ?>