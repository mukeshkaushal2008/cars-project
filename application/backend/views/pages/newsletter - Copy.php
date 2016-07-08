

<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="<?php echo base_url(); ?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css"/>

<!-- BEGIN PAGE HEADER-->
<div class="row">
<div class="col-md-12"> 
  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
  <h3 class="page-title">  Newsletters </h3>
  <ul class="page-breadcrumb breadcrumb">
    <li> <i class="fa fa-home"></i> <a href="<?php echo base_url();?>"> Home </a> <i class="fa fa-angle-right"></i> </li>
    <li> <a href="javascript:void(0);"> Content Mangement / Newsletters  </a> </li>
  </ul>
  <!-- END PAGE TITLE & BREADCRUMB--> 
</div>
</div>
<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->
<div class="row profile">
<div class="col-md-12"> 
  <!--BEGIN TABS-->
  <div class="tabbable tabbable-custom tabbable-full-width">
    <ul class="nav nav-tabs">
      <li class="active"> <a href="#tab_1_1" data-toggle="tab">  Newsletters </a> </li>
    </ul>
      <div class="message2" id="message"> <font color='red'><?php echo $this->session->flashdata('errormsg'); ?></font> <font color='green'><?php echo $this->session->flashdata('successmsg'); ?></font> </div>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1_1">
        <div class="row">
          <div class="col-md-9" style="width:100%">
            <div class="row">  </div>
            <!--end row-->
            <div class="tab-pane active" id="tab1"> </div>
            
            <form id="add" name="add" method="post" action="<?php echo BASEURL;?><?php echo $this->router->class;?>/sendnewsletter" enctype="multipart/form-data" class="form-horizontal">
              <?php if($do == "edit"){ ?>
                <input type="hidden" name="id" value="<?php echo !empty($resultset['id']) ? $resultset['id'] : ""; ?>">
			  <?php	} ?>
           <!--newsletters--> 
            <div class="form-group flare">
               <label for="inputEmail3" class="col-sm-3 control-label">Subscribers:</label>
                <div class="col-sm-9">
                  <input type="radio"  name="type" <?php if($resultset['type'] == "all"){echo 'checked="checked"';}?> onchange="select_all();"  value="all"/>
                  All
                  <input type="radio"  name="type"  <?php if($resultset['type'] == "user"){echo 'checked="checked"';}?> onchange="particular();" value="user"/>
                  Particular </div>
            </div>
            
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label"> </label>
                <div class="col-sm-9"> <span  id="all" style="display:none;">
                  <?php $users = $this->page_model->get_newsletter();?>
                  <select class="form-control" name="email"  style="width: 200px;min-height: 35px;" >
                    <option value="all" >All</option>
                  </select>
                  </span> <br class="clear" />
                  <?php $users = $this->page_model->get_newsletter();?>
                  <span  id="user" style="display:none;">
                  <select name="email[]"  multiple style="width: 600px;min-height: 100px;" >
                    <?php if(count($users) > 0){
				$msg = '';
				foreach($users as $k => $v){
					$ids = array();
					if($resultset['type']=="user"){
						$j=0;foreach($resultset["email"] as $key =>$val){
							$ids[$j] = $val;
							$j++;
						}
					}
					
					if(in_array($v["email"],$ids)){$msg = 'selected=selected';}else {$msg = '';}
				?>
                  <option value="<?php echo $v["email"];?>" <?php echo $msg;?>><?php echo $v["email"];?></option>
                    <?php } } ?>
                  </select>
                  </span> </div>
                <br class="clear" / >
              </div>
            
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-3 control-label">Content:</label>
                <div class="col-sm-9">
                  <textarea class="form-control" name="content" rows="8" cols="80"><?php echo !empty($resultset['content']) ? $resultset['content'] : ""; ?></textarea>
                </div>
              </div>
              
              
           <!--newsletters--> 
            
            <div class="form-group">
              <label class="control-label col-md-4">&nbsp; </label>
              <div class="col-md-8">
              <input type="submit" value="Save" class="btn theme-btn green pull-left" >
              <!--<a href="<?php echo base_url();?><?php echo $this->router->class;?>/donations"  class="btn theme-btn grey pull-left margd">Cancel</a>-->
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

   
<!-- BEGIN PAGE LEVEL PLUGINS --> 
<script type="text/javascript" src="<?php echo base_url();?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jsFunctions.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/msdropdown/jquery.dd.min.js"></script> 
 
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script> 
<!-- END CORE PLUGINS --> 
<!-- BEGIN PAGE LEVEL PLUGINS --> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script> 
<!-- END PAGE LEVEL PLUGINS --> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
<!-- BEGIN PAGE LEVEL SCRIPTS --> 
<script src="<?php echo base_url(); ?>assets/scripts/core/app.js"></script> 
<script src="<?php echo base_url(); ?>assets/scripts/custom/components-pickers.js"></script> 
<!-- END PAGE LEVEL SCRIPTS --> 
<script>
$(document).ready(function(e) {
	<?php if($resultset['type']=="all"){?>
    $("#user").hide();
	$("#all").show();
	<?php }?> 
	
	<?php if($resultset['type']=="user"){?>
	$("#all").hide();
	$("#user").show();
	<?php }?> 
})
jQuery(document).ready(function() {       
   // initiate layout and plugins
   App.init();
  ComponentsPickers.init();
});   
</script> 

<script type="text/javascript" src="<?php echo base_url(); ?>js/validate_functions.js"></script>
<script>
function select_all(){
    $("#user").hide();
	$("#all").show();
};
$(document).ready(function(e) {
	
   <?php if($resultset['type']=="all"){?>
    $("#user").hide();
	$("#all").show();
	<?php }?> 
	
	<?php if($resultset['type']=="user"){?>
	$("#all").hide();
	$("#user").show();
	<?php }?> 
});

function particular(){
	$("#all").hide();
    $("#user").show();
};
</script>
<?php //debug($resultset);?>
