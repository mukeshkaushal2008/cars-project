

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
            <li> <i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>"> Home </a> <i class="fa fa-angle-right"></i> </li>
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

                            <form id="add" name="add" method="post" class="form-horizontal">
                                <?php if ($do == "edit") { ?>
                                    <input type="hidden" name="id" value="<?php echo!empty($resultset['id']) ? $resultset['id'] : ""; ?>">
                                <?php } ?>
                                <!--newsletters--> 

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> </label>
                                    <div class="col-sm-12"> 

                                        <select multiple id="from" style="width:450px; height:300px;">
                                            <?php foreach ($users as $k => $v) { ?>
                                                <option value="<?php echo $v["email"] ?>"><?php echo $v["email"] ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="controls"> 
                                            <!--                                            <a href="javascript:moveAll('from', 'to')">&gt;&gt;</a> -->
                                            <a title="Select users to send newsletters" href="javascript:moveSelected('from', 'to')">&gt;</a> 
                                            <!--                                            <a href="javascript:moveSelected('to', 'from')">&lt;</a> -->
                                            <!--                                            <a href="javascript:moveAll('to', 'from')" href="#">&lt;&lt;</a>-->
                                        </div>
<!--                                        <select multiple id="to"  style="width:450px;height:300px;" name="topics[]"></select>-->
                                        <div>
                                            <textarea style="width:450px;height:300px; border:1px solid gray; float: left; word-wrap: break-word;" id="to" class="form-control" ></textarea>
                                        </div>

                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Content:</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" id="content" name="content" rows="8" cols="80"><?php echo!empty($resultset['content']) ? $resultset['content'] : ""; ?></textarea>
                                    </div>
                                </div>


                                <!--newsletters--> 

                                <div class="form-group">
                                    <label class="control-label col-md-4">&nbsp; </label>
                                    <div class="col-md-8">
                                        <input onclick="return submit_form();" type="button" value="Save" class="btn theme-btn green pull-left" >
                                        <!--<a href="<?php echo base_url(); ?><?php echo $this->router->class; ?>/donations"  class="btn theme-btn grey pull-left margd">Cancel</a>-->
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

<style type="text/css">
    select {
        width: 200px;
        float: left;
    }
    .controls {
        width: 40px;
        float: left;
        margin: 10px;
    }
    .controls a {
        background-color: #222222;
        border-radius: 4px;
        border: 2px solid #000;
        color: #ffffff;
        padding: 2px;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        margin-top: 120px;
        width: 34px;
    }
</style>
<!-- BEGIN PAGE LEVEL PLUGINS --> 
<script type="text/javascript" src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jsFunctions.js"></script>
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

    jQuery(document).ready(function () {
        // initiate layout and plugins
        App.init();
        ComponentsPickers.init();
    });

    function moveAll(from, to) {
        $('#' + from + ' option').remove().appendTo('#' + to);
    }

    function moveSelected(from, to) {
        var emails = $('#' + from + ' option:selected').map(function (n) {
            return  this.value;
        }).get().join(',');
        //$('#'+from+' option:selected').remove().appendTo('#'+to);
        $('#' + to).html(emails);
    }
    function selectAll() {
        $("select option").attr("selected", "selected");
    }

    function submit_form() {
        var email = $('#to').val();
        var content = $('#content').val();
        var split_email = email.split(',');
        if (split_email == "") {
            var error = "Please select atleast one email";
            $("#to").focus();
        } else if (content == "") {
            var error = "Please enter content";
            $("#content").focus();
        }
        if (error != '' && error != null) {
            jQuery('html,body').animate({scrollTop: 0}, 500);
            $('#message').html(error).show().css({'color': 'red'});
            return false;
        } else {
            var url = BASEURL + 'pages/sendnewsletter/';
            $.ajax({
                method : 'POST',
                url: url,
                data: {'email' : email,'content':content},
                beforeSend: function () {
                   
                },
                success: function (result)
                {
                   var response = JSON.parse(result);
                   if(response["response"] == "success"){
                       alert(response["message"]);
                       location.reload(3000);
                   }else{
                       alert(response["message"]);
                   }
                }
            });
        }
    }

</script>



<script type="text/javascript" src="<?php echo base_url(); ?>js/validate_functions.js"></script>
