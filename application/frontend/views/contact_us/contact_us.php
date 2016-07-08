<style type="text/css">
    .error_contact{
        /*display: none;*/
        color: red;
    }
</style>
<style type="text/css">

    .msg_err{
        left: 15px;
        position: absolute;
        top: -25px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $("#contact_form :input").not("[name='contact']").focus(function() {

            $(this).removeClass('error_signup');

        })
        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
        $("#contact_form").submit(function(e) {
//            alert('here');
            e.preventDefault();
            var email_regex = /^[ A-Za-z0-9_@./#&+-]*$/;
//            var phone_regex = /[0-9-()+]{2,20}/;
            var reason = $("#reason").val().trim();
            var contact_name = $("#contact_name").val().trim();
            var contact_email = $("#contact_email").val().trim();
            var contact_message = $("#contact_message").val().trim();
            var contact_phone = $("#phone").val().trim();

//            $("#contact_name_error").fadeOut();
//            $("#contact_email_error").fadeOut();
//            $("#contact_message_error").fadeOut();
//            $("#contact_phone_error").hide();

            if (contact_name == '') {
                $("#contact_name").addClass('error_signup');
//                $("#contact_name_error").text('Required').fadeIn();
                $(".allerror_contact").text('Please enter name').fadeIn();
                var err = 1; return false;
            }
            if (contact_email == '') {
                $("#contact_email").addClass('error_signup');
//                $("#contact_email_error").text('Required').fadeIn();
                $(".allerror_contact").text('Please enter your email id').fadeIn();
                var err = 1; return false;
            }
            if (!validateEmail(contact_email)) {
                $("#contact_email").addClass('error_signup');
//                $("#contact_email_error").text('Please enter valid email').fadeIn();
                $(".allerror_contact").text('Please enter valid email').fadeIn();
                var err = 1; return false;

            }
//            if ($("#phone").val()=='') {
////                $("#contact_phone_error").text('Please enter digits only').show();
//                $(".allerror_contact").text('Not a valid phone no.').show();
////                        alert('Please enter digits only');
//                $('#phone').focus();
//                var err = 1;
//                return false;
//            }
            if (contact_message == '') {
                $("#contact_message").addClass('error_signup');
//                $("#contact_message_error").text('Required').fadeIn();
                $(".allerror_contact").text('Please enter message').fadeIn();
                var err = 1; return false;
            }
//            if (err == 1) {
//                return false;
//            }
//
            $.ajax({
                type: 'POST',
                url: BASEURL + 'contact_us/submit_contact_info/',
                data: $("#contact_form").serialize(),
                beforeSend: function(res) {
                    $('.allerror_contact').text('');
                    $('.allsuccess_contact').text('');
                    $('#contact').attr('disabled', 'disabled');
                },
                success: function(res) {
//                    console.log(res);
                    obj = JSON.parse(res);
                    if (obj.status == 1) {
                        //redirect to account page obj.message
                        $('.allsuccess_contact').text(obj.message).show();
//                        $('.allsuccess_contact').text(obj.message).show().fadeOut(3000);
//                        setTimeout(function() {
//                            $('#sign-in-modal').modal('hide');
//                        }, 3000);
//                        $('#signin_form')[0].reset();
                        
                        $('#contact_form')[0].reset();
                    } else {
                        //show error 
                        $('.allerror_contact').text(obj.message).show();
//                        $('#allerror').html(obj.message).fadeOut(500);
                    }
                    $('#contact').removeAttr('disabled');

                }
            });
        });

    });
</script>
<div class="container">
    <div class="inner_container">
        <div class="main_content">
            <div class="page_heading">
                <h1>Contact Us</h1>
            </div>
            <div class="contact_left">
                <div class="contact_form">
                    <form name="contact_form" id="contact_form" role="form" action="<?php echo base_url(); ?>contact_us/submit_contact_info" method="post">
                        <span class="allerror_contact" style="display:none;color: red;"> All fields are necessary!</span>
                        <span class="allsuccess_contact" style="display:none;color: green;"></span>
                        <div class="fields">
                            <label for="name">Name</label>
                            <input name="name" type="text" id="contact_name">
                            <p class="mt10 error_contact" id="contact_name_error"></p>
                        </div>
                        <div class="fields">
                            <label>Email Address</label>
                            <input name="email" type="text" id="contact_email" >
                            <p class="mt10 error_contact" id="contact_email_error"></p>
                        </div>
                        <div class="form-group-select fields">
                            <label>Subject</label>
                            <div class="select-style">
                                <select id="reason" name="reason">
                                    <option value="Technical support">Technical support</option>
                                    <option value="Advertising">Advertising</option>
                                    <option value="General">General</option>
                                    <option value="Suggestions">Suggestions</option>
                                    <option value="Press">Press</option>

                                </select>
                            </div>
                            <p class="mt10 error_contact" id="contact_reason_error"></p>
                        </div>
                        <div class="fields">
                            <label>Phone</label>
                            <input type="text" name="phone" id="phone" value="">
                            <p class="mt10 error_contact" id="contact_phone_error"></p>
                        </div>
                        <div class="fields">
                            <label>Message</label>
                            <textarea name="message" id="contact_message"></textarea>
                            <p class="mt10 error_contact" id="contact_message_error"></p>
                        </div>
                        <div class="send_button">
                            <button type="submit" name="contact" id="contact">Submit</button>
                            
                        </div>
                    </form>
                </div>
            </div>
            <div class="contact_right"> <img alt="" src="images/contact.png">
                <h2>Any Questions? We're here to help. Give us a call </h2>
                <h3>Contact Info</h3>
                <p>Addrees -  C-110, Industrial Area , Phase VII, Phase 7, Industrial Area Mohali, Sector 73, </p>
                <p>Sahibzada Ajit Singh Nagar, Punjab 160055</p>
                <p>Phone - 8776338186</p>
                <p>Phone Alt: 7066238186</p>
                <p>Fax: 7068351645</p>
            </div>
        </div>
    </div>
</div>