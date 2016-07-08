<?php //debug($productinfo); ?>
<link href="<?php echo base_url(); ?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css"/>

<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12"> 
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title"> Edit product </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li> <i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>"> Home </a> <i class="fa fa-angle-right"></i> </li>
            <li> <a href="javascript:void(0);"> Edit product </a> </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB--> 
    </div>
</div>
<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->
<div  id="message"> <font color='red'><?php echo $this->session->flashdata('errormsg'); ?></font> <font color='green'><?php echo $this->session->flashdata('successmsg'); ?></font> </div>
<div class="row profile">
    <div class="col-md-12"> 
        <!--BEGIN TABS-->
        <div class="tabbable tabbable-custom tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active"> <a href="#tab_1_1" data-toggle="tab"> Edit product </a> </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1_1">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row"></div>
                            <!--end row-->
                            <div class="tab-pane active" id="tab1"></div>
                            <form name="frm" id="validation_product" action="<?php echo base_url() . $this->router->class; ?>/update_product_to_database" method="post">
                                <?php if ($do == "edit") { ?>
                                    <input type="hidden" name="per_page" value="<?php echo!empty($_GET['per_page']) ? $_GET['per_page'] : ""; ?>">
                                    <input type="hidden" name="id" value="<?php echo!empty($productinfo['id']) ? $productinfo['id'] : ""; ?>">
                                <?php } ?>
                                <div class="form-group flare">
                                    <label class="control-label col-md-4"> Name<span class="required"> * </span> </label>
                                    <div class="col-md-8">
                                        <input class="form-control"  name="name" id="name" type="text" value="<?php echo!empty($productinfo['name']) ? $productinfo['name'] : ""; ?>"/>
                                    </div>
                                </div>

                                <div class="form-group flare">
                                    <label class="control-label col-md-4"> Category<span class="required"> * </span> </label>
                                    <div class="col-md-8">
                                        <select id="category" class="selectpicker" name="category_id">
                                            <option value="">select category</option>	
                                            <?php foreach ($categories as $k => $v) { ?>
                                                <option value="<?php echo $v["id"] ?>" <?php if ($productinfo['category_id'] == $v["id"]) {
                                                echo 'selected="selected"';
                                            } ?>><?php echo $v["category_name"]; ?></option>
<?php } ?>  
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group flare">
                                    <label class="control-label col-md-4"> Brand<span class="required"> * </span> </label>
                                    <div class="col-md-8">
                                        <select id="brand" class="selectpicker" name="brand_id">
                                            <option value="">select brand</option>
                                            <?php foreach ($brands as $k => $v) { ?>
                                                <option value="<?php echo $v["id"] ?>" <?php if ($productinfo['brand_id'] == $v["id"]) {
                                                echo 'selected="selected"';
                                            } ?>><?php echo $v["brand_name"]; ?></option>
<?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group flare">
                                    <label class="control-label col-md-4"> Model<span class="required"> * </span> </label>
                                    <div class="col-md-8" id="insert_model">
                                        <select id="model" class="selectpicker" name="model_id">
                                            <option value="">select model</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group flare">
                                    <label class="control-label col-md-4"> Retail price<span class="required"> * </span> </label>
                                    <div class="col-md-8">
                                        <input class="form-control"  name="retail_price" id="retail_price" type="text" value="<?php echo!empty($productinfo['retail_price']) ? $productinfo['retail_price'] : ""; ?>"/>
                                    </div>
                                </div>

                                <div class="form-group flare">
                                    <label class="control-label col-md-4"> Minimum price </label>
                                    <div class="col-md-8">
                                        <input class="form-control"  name="minimum_price" id="minimum_price" type="text" value="<?php echo!empty($productinfo['minimum_price']) ? $productinfo['minimum_price'] : ""; ?>"/>
                                    </div>
                                </div>

                                <!--                   <div class="form-group flare">
                                                  <label class="control-label col-md-4"> Start date<span class="required"> * </span> </label>
                                                  <div class="col-md-8">
                                                    <input class="form-control"  name="start_date" id="start_date" type="text" value="<?php echo!empty($productinfo['start_date']) ? date('d/m/Y', $productinfo['start_date']) : ""; ?>"/>
                                                  </div>
                                                </div>
                                -->

                                <div class="form-group flare">
                                    <label class="control-label col-md-4"> End date<span class="required"> * </span> </label>
                                    <div class="col-md-8">
                                        <input class="form-control"  name="end_date" id="end_date" type="text" value="<?php echo!empty($productinfo['end_date']) ? date('d/m/Y', $productinfo['end_date']) : ""; ?>"/>
                                    </div>
                                </div>

                                <div class="form-group flare">
                                    <label class="control-label col-md-4"> Short description<span class="required"> * </span> </label>
                                    <div class="col-md-8">
                                        <textarea style="min-height:80px" class="form-control" name="short_description" id="short_description" ><?php echo!empty($productinfo['short_description']) ? $productinfo['short_description'] : ""; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group flare">
                                    <label class="control-label col-md-4"> Long description<span class="required"> * </span> </label>
                                    <div class="col-md-8">
                                        <textarea  class="ckeditor form-control" name="long_description" id="long_description"><?php echo!empty($productinfo['long_description']) ? $productinfo['long_description'] : ""; ?></textarea>
                                        <!-- <textarea style="min-height:150px" class="ckediter"  ></textarea>--> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"> Image<span class="required"> * </span> </label>
                                    <div class="col-md-8 adfile">
                                        <div id="dropzone"  class="dropzone" style="height: auto; min-height: 400px;">
                                            <div id="append_data">
                                                <?php
                                                foreach ($dataset['images'] as $key => $val) {
                                                    $video = array('3g2', '3gp', 'asf', 'asx', 'avi', 'flv', 'm4v', 'mov', 'mp4', 'mpg', 'wmv');
                                                    $columnName = preg_replace('/[`~!@#$%\^&*()+={}[\]\\\\|;:\'",.><?\/]/', '-', $val);
                                                    ?>
                                                    <div id="<?php echo $columnName; ?>" class="temp_upload_img">
                                                        <div>
                                                            <div><?php echo $val; ?></div>
    <?php
    $name = end(explode('.', $val));
    $src = $this->config->item("product_thumb") . $val;
    ?>
                                                            <ul class="app_data_ul">
                                                                <li class="image" style="background-image:url(<?php echo $src; ?>); border:1px solid white;position:relative; background-size:cover; height:100px;background-position: center center;"></li>
                                                            </ul>
                                                        </div>
                                                        <span style="float:left; line-height:2;">
                                                            <input type="hidden" value="<?php echo $val; ?>" name="image[]">
                                                            <a id="<?php echo base_url(); ?>?file=<?php echo $val; ?>" style="cursor:pointer;" onclick="remove_image_edit(this.id, this.name);" name="<?php echo $columnName; ?>">Delete</a> </span> </div>
<?php } ?>
                                            </div>
                                            <span id="upload_1" style=" display:none;color: #0163BE;position: absolute;top: 75px;font-size: 30px;left: 25px;">Please wait uploading in progress.....</span> </div>
                                        <div class="clearfix"></div>
                                        <div class="pull-right browse_icon"> <!--<img id="webcamon" src="<?php echo base_url(); ?>images/browse_icon.png" class="br_icon" / >-->

                                            <div id='file_browse_wrapper' style="margin-right: -160px; margin-top: 13px">
                                                <input type='file' id='fileupload' name="files[]" multiple />
                                            </div>
                                        </div>
                                        <span style="color:red;">Max size: 4mb</span> </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">&nbsp; </label>
                                    <div class="col-md-8">
                                        <button type="button" value="Save" class="btn theme-btn green pull-left" onclick="return validation_form();">Save</button>
                                        <a href="<?php echo base_url() . $this->router->class; ?>/manage_product"  class="btn theme-btn grey pull-left margd">Cancel</a> </div>
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
<!-- BEGIN PAGE LEVEL PLUGINS --> 
<script type="text/javascript" src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jsFunctions.js"></script> 
<script src="<?php echo base_url(); ?>assets/scripts/msdropdown/jquery.dd.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>calender/jquery.datetimepicker.js"></script>
<link rel="stylesheet"  type="text/css" href="<?php echo base_url(); ?>calender/jquery.datetimepicker.css">
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
                                            $(document).ready(function () {
                                                getModels('<?php echo!empty($productinfo['brand_id']) ? $productinfo['brand_id'] : ''; ?>', '<?php echo!empty($productinfo['model_id']) ? $productinfo['model_id'] : ''; ?>');
                                            });

                                            $(document).on('change', '#brand', function () {
                                                getModels($(this).val());
                                            });

                                            function getModels(brand_id, model_id)
                                            {
                                                var url = BASEURL + 'brand/getModels/';
                                                $.ajax({
                                                    method: 'POST',
                                                    url: url,
                                                    data: {'brand_id': brand_id, 'model_id': model_id},
                                                    beforeSend: function () {

                                                    },
                                                    success: function (result)
                                                    {
                                                        var response = JSON.parse(result);
                                                        if (response["response"] == "success") {
                                                            $("#insert_model").html('');

                                                            $("#insert_model").html(response["message"]);
                                                            $('.selectpicker').selectpicker('render');
                                                        } else {
                                                            $("#insert_model").html('');

                                                            $("#insert_model").html(response["message"]);
                                                            $('.selectpicker').selectpicker('render');
                                                        }
                                                    }
                                                });
                                            }

                                            jQuery(function () {
                                                $('#start_date').datetimepicker({
                                                    format: 'd/m/Y',
                                                    timepicker: false,
                                                    minDate: '0', //yesterday is minimum date(for today use 0 or -1970/01/01)
                                                    step: 5,
                                                    opened: false,
                                                    validateOnBlur: false,
                                                    closeOnDateSelect: false,
                                                    closeOnTimeSelect: false,
                                                    onChangeDateTime: function (dp, $input) {
                                                        //$input.nextAll('.temp_date_value').remove();
                                                        //$input.after($('<input  type="hidden" class="temp_date_value" value="">').val($input.val()));
                                                    }
                                                });

                                                jQuery('#end_date').datetimepicker({
                                                    format: 'd/m/Y',
                                                    step: 5,
                                                    opened: false,
                                                    timepicker: false,
                                                    validateOnBlur: false,
                                                    closeOnDateSelect: false,
                                                    closeOnTimeSelect: false,
                                                    onChangeDateTime: function (dp, $input) {
                                                        //console.log($input.val())
                                                    }
                                                });
                                            });
                                            jQuery(document).ready(function () {
                                                App.init();
                                                //Search.init();
                                            });
</script> 
<script>

    $(function () {
        $("#append_data").sortable();
        $("#append_data").disableSelection();
    });


    function remove_image_edit(id, name) {

        var url = BASEURL + 'products/remove_image_edit/';
        $("#" + name).remove();
        /* $.ajax({
         url:url,
         data:'type=json&url='+id,
         beforeSend:function(){
         $("#" + name).append('<span style="color:red;position:absolute;left: 15px;top: 160px">Deleting...</span>');
         },
         success:function(result)
         {
         $("#" + name).html('');
         $("#"+name).remove();
         var temp_images = $('input[name*="image"]').length;
         if(temp_images < 6){
         $("#file_browse_wrapper").show();
         } 
         }	
         });	*/
    }

    $(document).bind('drop dragover', function (e) {
        e.preventDefault();
    });


    $(document).bind('dragover', function (e) {
        var dropZone = $('.dropzone'),
                foundDropzone,
                timeout = window.dropZoneTimeout;
        if (!timeout) {
            dropZone.addClass('in');
        } else {
            clearTimeout(timeout);
        }
        var found = false,
                node = e.target;
        do {
            if ($(node).hasClass('dropzone')) {
                found = true;
                foundDropzone = $(node);
                break;
            }
            node = node.parentNode;
        } while (node != null);
        dropZone.removeClass('in hover');
        if (found) {
            foundDropzone.addClass('hover');
        }
        window.dropZoneTimeout = setTimeout(function () {
            window.dropZoneTimeout = null;
            dropZone.removeClass('in hover');
        }, 100);
    });
    /**********************************drag and  drop file for uploading starts**********************************************/
    $(function () {
//var jj=LAST_ID;
        $("#progress").hide();
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = BASEURL + 'products/upload_image/';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            dropZone: $('#dropzone'),
            beforeSend: function (event, files, index, xhr, handler, callBack) {
                $("#upload_1").show();
                $("#browse_image").hide();
                $("#image_loading").show();
            },
            add: function (e, data) {
                var uploadErrors = [];
                var file = data.originalFiles[0]['name'];
                var choosen_length = data.originalFiles.length;
                var temp_images = $('input[name*="image"]').length;
                var total_temp_images = parseInt(choosen_length) + parseInt(temp_images);
                var exts = ['gif', 'GIF', 'jpg', 'jpeg', 'JPEG', 'png', 'PNG'];

                $.each(data.originalFiles, function (index, value) {
                    //console.log("INDEX: " + index + " VALUE: " + value.name);
                    var get_ext = value.name.split('.');// split file name at dot
                    var myext = get_ext.reverse();// reverse name to check extension
                    if ($.inArray(myext[0].toLowerCase(), exts) > -1) {
                        // check file type is valid as given in 'exts' array
                    } else {
                        uploadErrors.push('Wrong file type only .jpg, .png and .gif allowed');
                    }
                });

                if (total_temp_images >= 6) {
                    $("#file_browse_wrapper").hide();
                }
                if (total_temp_images > 6) {
                    uploadErrors.push(' You can\'t upload more than 6 images');
                } else if (data.originalFiles[0]['size'] > 4000000) {
                    uploadErrors.push(' Filesize is too big please upload file less than 4 mb');
                }
                if (uploadErrors.length > 0) {
                    window.scroll(0, 0);
                    $('#error_msgs').html(uploadErrors[0]).show().css({'color': 'red'});
                    // jQuery('html,body').animate({scrollTop:0},500);
                    //alert(uploadErrors.join("\n"));
                } else {
                    data.submit();
                }
            },
            complete: function (response) { // on complete

            },
            progressall: function (e, data) {
                $("#progress").show();
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                        ).text(progress + '%');
            },
            done: function (e, data) {

                $("#upload_1").hide();
                $("#image_loading").hide();
                $("#browse_image").show();
                $('#message').val('');
                $("#progress").hide();

                $.each(data.result.files, function (index, file) {
                    //if(file.error == ""){
                    var name = file.name;
                    var type = file.type;
                    var file_type = type.split('/');
                    var newString = name.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/ig, "-");
                    $('#append_data').append('<div  id="' + newString + '" class="temp_upload_img"><div><div>' + file.name + '</div>\n\
                                        <ul class="app_data_ul">\n\
                                        <li class="image" style="background-image:url(' + file.thumbnailUrl + ');background-size:cover; height:100px;background-position: center center;border: 2px solid white;"></li>\n\
                                        </ul>\n\
                                        </div><span  style="float:left;line-height: 2;"><input type="hidden" name="image[]" value="' + file.name + '" /><a id=' + file.deleteUrl + '  name=' + newString + ' onclick="remove_image_edit(this.id,this.name);" style="cursor:pointer;">Delete</a></span></div></div>');
                    //jj++;
                    /*}
                     else{
                     $('#error_msgs').html(file.error).show().css({'color': 'red'});
                     }*/
                });
            }
        }).bind('fileuploadsubmit', function (e, data) {
            var message_sender = $("#message_sender").val();
            data.formData = {message_sender: message_sender};
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
    });


    function validation_form() {

        var name = $("#name").val();
        var category = $("#category").val();
        var brand = $("#brand").val();
        var model = $("#model").val();
        var retail_price = $("#retail_price").val();
        var minimum_price = $("#minimum_price").val();
        var short_description = $("#short_description").val();
        var long_description = CKEDITOR.instances['long_description'].getData();
        var images = $('input[name*="image"]').length;
        var is_image = $('input[class*="temp_upload_img"]').length;

        if (name == "") {
            var error = "Please enter name";
            $("#name").focus();
        } else if (name.length > 140) {
            var error = "You can\'t enter more than 140 characters in name";
            $("#name").focus();
        } else if (category == "") {
            var error = "Please select category";
            $("#category").focus();
        } else if (brand == "") {
            var error = "Please select brand";
            $("#brand").focus();
        } else if (model == "") {
            var error = "Please select model";
            $("#model").focus();
        } else if (retail_price == "") {
            var error = "Please retail price";
            $("#retail_price").focus();
        } else if (isNaN(retail_price)) {
            var error = "Please enter valid retail price";
            $("#retail_price").focus();
        } else if (minimum_price != "" && isNaN(minimum_price)) {
            var error = "Please enter valid minimum price";
            $("#minimum_price").focus();
        } else if (short_description == "") {
            var error = "Please enter short description";
            $("#short_description").focus();
        } else if (long_description == "") {
            var error = "Please enter long description";
            $("#long_description").focus();
        } else if (images == "") {
            var error = "Please provide atleast two images";
            $("#dropzone").focus();
        } else if (images < 2) {
            var error = "Please provide atleast two images";
            $("#dropzone").focus();
        }
        if (error != '' && error != null) {
            jQuery('html,body').animate({scrollTop: 0}, 500);
            $('#message').html(error).show().css({'color': 'red'});
            return false;
        } else {
            $('#validation_product').submit();
        }
    }
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script> 
<script src="<?php echo base_url(); ?>js/uploader/jquery.ui.widget.js"></script> 
<script src="<?php echo base_url(); ?>js/uploader/jquery.iframe-transport.js"></script> 
<script src="<?php echo base_url(); ?>js/uploader/jquery.fileupload.js"></script> 
</script>
<style type="text/css">
    #append_data .app_data_ul{
        list-style-type: none;
        margin: 0;
        padding: 0 0 0 10px;
        width: 123px;
    }
    /*#append_data { list-style-type: none; margin: 0; padding: 0; width: 450px; }
    */
    #append_data li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
    #append_data li:hover{cursor:move;}
    #append_data > div {
        float: left;
    }
    #append_data > div img, #append_data > div span {
        margin-left: 10px;
        margin-top: 5px;
    }
    #append_data1 > div {
        float: left;
    }
    #append_data1 > div img, #append_data > div span {
        margin-left: 10px;
        margin-top: 5px;
    }
    .dropzone {
        /*palegreen*/
        background: #ACE7F0;
        /* width: 150px;*/
        height: auto;
        line-height: 50px;
        text-align: center;
        font-weight: bold;
    }
    .dropzone.in {
        width: 600px;
        height: 200px;
        line-height: 200px;
        font-size: larger;
    }
    .dropzone.hover {
        background: gray;
    }
    .dropzone.fade {
        -webkit-transition: all 0.3s ease-out;
        -moz-transition: all 0.3s ease-out;
        -ms-transition: all 0.3s ease-out;
        -o-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
        opacity: 1;
    }
    .progress {
        overflow: hidden;
        height: 20px;
        margin-bottom: 0px;
        background-color: #f5f5f5;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
        box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
        width: 64%;
        margin-left: 16px;
        margin-top: 17px;
    }

</style>
