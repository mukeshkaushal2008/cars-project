<?php //debug($resultset)?>
<!-- BEGIN PAGE HEADER-->
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <h3 class="page-title"> Blog Comment </h3>
    <ul class="page-breadcrumb breadcrumb">
      <li class="btn-group">  </li>
      <li> <i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>"> Home </a> <i class="fa fa-angle-right"></i> </li>
      <li> <a href="javascript:void(0);"> Manage Blog Comment</a> </li>
    </ul>
    <!-- END PAGE TITLE & BREADCRUMB--> 
  </div>
</div>
<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->
<div class="row">
  <div class="col-md-12">
    <div class="tabbable tabbable-custom tabbable-full-width">
      <ul class="nav nav-tabs">
        <li class="active"> <a data-toggle="tab" href="#tab_1_5"> Manage Blog Comment</a> </li>
      </ul>
	   <div id="message"> <font color='red'><?php echo $this->session->flashdata('errormsg'); ?></font> <font color='green'><?php echo $this->session->flashdata('successmsg'); ?></font> </div>
      <div class="tab-content"> 
        
        <!--end tab-pane-->
        <div id="tab_1_5" >
          <div class="row search-form-default">
            <div class="col-md-12">
              <?php $search=$this->input->get("search"); ?>
              <form class="form-inline" action="<?php echo base_url().$this->router->class?>/manage_blog/" id="search">
                <div class="input-group">
                  <div class="input-cont">
                    <input type="text" placeholder="Search..." class="form-control"  name="search"  value="<?php echo ($search!='' && $search!='search')?$search:''; ?>"/>
                  </div>
                  <span class="input-group-btn">
                  <button type="button" class="btn green" onclick="document.getElementById('search').submit()"> Search &nbsp; <i class="m-icon-swapright m-icon-white"></i> </button>
                  </span> </div>
              </form>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-advance table-hover">
              <thead>
                <tr>
                  <th> Comment </th>
                  <th> Created on </th>
				  <th> Status </th>
				  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($resultset) > 0) {
					foreach($resultset as $key => $val){
				?>
				<tr>
                  <td><?php echo strlen($val['comment']) > 40 ? substr(ucfirst($val['comment']), 0,40).".." : ucfirst($val['comment']);?></td>
                  <td><?php echo date('m-d-Y',$val['time']);?></td>
				  <td><?php if($val['status'] == '1'){ ?>
                    <span class="label label-sm label-success"> <a href="<?php echo base_url().$this->router->class;?>/enable_disable_blog_comment/<?php echo $val['blogid'];?>/<?php echo $val["blog_comments_id"]?>/0" onclick="return dis_fun('<?php echo $item?>');">Inactive</a> </span>
                    <?php }else{ ?>
                    <span class="label label-sm label-success"> <a href="<?php echo base_url().$this->router->class;?>/enable_disable_blog_comment/<?php echo $val['blogid'];?>/<?php echo $val["blog_comments_id"]?>/1" onclick="return enb_fun('<?php echo $item?>');">Active</a> </span>
                    <?php } ?></td>
                     <td>
                     <!-- <a class="javascript:void(0)" href="<?php echo base_url().$this->router->class; ?>/view_tag/<?php echo $val['blog_comments_id'];?>"> <i class="fa fa-search fonta"></i> </a> -->
                     <a class="javascript:void(0)" href="<?php echo base_url().$this->router->class;?>/archive_blog_comment/<?php echo $val['blogid'];?>/<?php echo $val['blog_comments_id'];?>" onclick="return archive_fun('<?php echo $item?>');"><i class="fa fa-times fonta"></i></a> 
                     <!--<a class="javascript:void(0)" href="<?php echo base_url().$this->router->class; ?>/edit_blog/<?php echo $val['blogid'];?>"><i class="fa fa-edit fonta"></i></a>--></td>
                </tr>
                                                 
                <?php }}else{?>
                <tr class="scndrow">
                  <td colspan="6" align="center">No record found</td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
          <div class="margin-top-20">
          	<ul class="pagination">
            <?php echo $this->pagination->create_links();?>
            </ul>
          </div>
        </div>
        <!--end tab-pane--> 
      </div>
    </div>
  </div>
  <!--end tabbable--> 
</div>
<!-- END PAGE CONTENT--> 

<!--<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script> 
<script src="<?php echo base_url(); ?>assets/scripts/core/app.js"></script> 
<script src="<?php echo base_url(); ?>assets/scripts/custom/search.js"></script> 
<script>
jQuery(document).ready(function() {    
   App.init();
   Search.init();
});
</script>-->