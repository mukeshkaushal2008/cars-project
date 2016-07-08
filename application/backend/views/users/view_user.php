<!-- BEGIN PAGE HEADER-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title"> View user</h3>
        <ul class="page-breadcrumb breadcrumb">
            <li> <i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>dashboard/"> Home </a> <i class="fa fa-angle-right"></i> </li>
            <li> <a href="javascript:void(0);"> View user</a> </li>
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
                <li class="active"> <a href="#tab_1_1" data-toggle="tab"> View user </a> </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1_1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <!--end col-md-8-->
                                <!--end col-md-4-->
                            </div>
                            <!--end row-->
                            <div class="tab-pane active" id="tab1">
                                <div class="form-group detra">
                                    <label class="control-label col-md-4">First name :</label>
                                    <div class="col-md-8"> <span class="detail_for_name">
                                            <?php echo!empty($resultset['first_name']) ? ucfirst($resultset['first_name']) : ""; ?>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group detra">
                                    <label class="control-label col-md-4">Last name :</label>
                                    <div class="col-md-8"> <span class="detail_for_name">
                                            <?php echo !empty($resultset['last_name']) ? ucfirst($resultset['last_name']) : ""; ?>
                                        </span> 
                                    </div>
                                </div>
								
                                 <div class="form-group detra">
                                    <label class="control-label col-md-4">Email :</label>
                                    <div class="col-md-8"> <span class="detail_for_name">
                                            <?php echo !empty($resultset['email']) ? ucfirst($resultset['email']) : ""; ?>
                                        </span> 
                                    </div>
                                </div>

								
                                 <div class="form-group detra">
                                    <label class="control-label col-md-4">Country :</label>
                                    <div class="col-md-8"> <span class="detail_for_name">
                                            <?php $data = $this->common->get_country_name($resultset['country_code']); 
											echo $data["country"]; ?>
                                        </span> 
                                    </div>
                                </div>
                                
                                 <div class="form-group detra">
                                    <label class="control-label col-md-4">Country code :</label>
                                    <div class="col-md-8"> <span class="detail_for_name">
                                            <?php $data = $this->common->get_country_name($resultset['country_code']); 
											echo $data["phone_prefix"];
											?>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group detra">
                                    <label class="control-label col-md-4"> Phone:</label>
                                    <div class="col-md-8"> <span class="detail_for_name">
                                            <?php echo !empty($resultset['phone']) ? ucfirst($resultset['phone']) : ""; ?>
                                        </span> </div>
                                </div>
                               
                              
                            </div>
                        </div>
                    </div>
                    <!--tab_1_2-->
                </div>
            </div>
            <!--END TABS-->
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
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
    jQuery(document).ready(function() {
        // initiate layout and plugins
        App.init();
        //  ComponentsPickers.init();
    });
</script>
<!-- END JAVASCRIPTS -->
