<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('email_model');
        $this->load->model('login_model');
        $this->load->model('user_model');
    }

    public function index() {
        $userid = $this->session->userdata("userid");
        if (empty($userid)) {
            $data["item"] = "Login";
            $data["master_title"] = "Login";
            $data["master_body"] = "login";
            //debug($data);die;
            $this->load->theme('mainlayout', $data);
        } else {
            redirect(base_url());
        }
    }

    public function register() {
        $userid = $this->session->userdata("userid");
        if (empty($userid)) {
            $data["countries"] = $this->common->get_all_countries();
            $data["item"] = "Login";
            $data["master_title"] = "Register";
            $data["master_body"] = "register";
            //debug($data);die;
            $this->load->theme('mainlayout', $data);
        } else {
            redirect(base_url());
        }
    }

    //check login details and login the user
    public function login_check_user_login() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $login = array();
        $result = array();
        $data = array();

        $login["email"] = clean($this->input->post("email"));
        $login["password"] = clean($this->input->post("password"));



        $data = $this->common->authenticateUserLogin($login);
        //debug($data);die;

        if ($data['status'] == 1) {

            if ($data['data']['is_verified'] == 0) {
                //not verified
                $result['response'] = "error";
                $result["message"] = 'Your account is not verified yet';
            } elseif ($data['data']['status'] == 4) {
                // suspended
                $result['response'] = "error";
                $result["message"] = 'Account suspended';
            } elseif ($data['data']['status'] == 0) {
                // deactivated
                $result['response'] = "error";
                $result["message"] = 'Your account is deactivated';
            } else {
                //set session here 
                $this->session->set_userdata("userid", $data['data']["id"]);
                $this->session->set_userdata("first_name", $data['data']["first_name"]);
                $this->session->set_userdata("last_name", $data['data']["last_name"]);
                $this->session->set_userdata("email", $data['data']["email"]);
                $this->session->set_userdata("is_logged_in", true);
            }
        } else {
            $result['response'] = "error";
            $result["message"] = $data['message'];
        }
        echo json_encode($result);
        die;
    }

    /*
     * check if email is available or not
     */

    public function check_email_availability() {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $result = array();
        if ($this->input->post('email') != "") {
            $email = $this->input->post('email');
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $result['response'] = "error";
                $result["message"] = "Please enter valid email";
            } else {
                $check_email = $this->login_model->check_email($email);
                if (!$check_email) {
                    $result['response'] = "error";
                    $result["message"] = "0";
                } else {
                    $result['response'] = "success";
                    $result["message"] = "1";
                }
            }
        }
        echo json_encode($result);
    }

    public function verify_email() {
        $user_id = base64_decode($this->input->get("verify")); //$loginId;
        $verify = $this->login_model->verify_email($user_id);

        $this->session->set_userdata("verfy_email", $user_id);
        if ($verify == 0) {
            $this->session->set_flashdata("email_successmsg", "Your email has been successfully verified.Please login to continue");
            $this->session->unset_userdata('verfy_email'); //unset session userid after verification
        } else {
            $this->session->set_flashdata("email_successmsg", "Your email has been already verified please login!");
            $this->session->unset_userdata('verfy_email'); //unset session userid after verification
        }
        redirect(base_url() . "home/?q=true");
    }

    public function add_user_to_database() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        /*
         * validate before save
         */
        $arr = array();
        $data = array();
        $arr["first_name"] = clean($this->input->post("first_name"));
        $arr["last_name"] = clean($this->input->post("last_name"));
        $arr["email"] = clean($this->input->post("email"));
        $arr["password"] = clean($this->input->post("password"));
        $arr["status"] = 1;
        $arr["total_bids"] = 3;
        $arr["created_time"] = time();

        $email = $this->login_model->check_email($arr["email"]);
        if (!$email) {
            $data["response"] = "error";
            $data["message"] = "This email id already registered choose another";
        } else if ($this->login_model->add_user($arr)) {
            $user_id = $this->db->insert_id();

            //insert notification to notigy abotr free bids
            $noti["userid"] = $user_id;
            $noti["type"] = "signup";
            $noti["message"] = "Added to your Account (free bids on registration)";
            $noti["status"] = "1";
            $noti["created_time"] = time();
            $this->login_model->insert_notification($noti);

            /* send email for verification */
            $emailarr["to"] = $arr["email"];
            $emailarr["subject"] = "Sign Up Verification";
            $txt = 'login/verify_email/?verify=' . base64_encode($user_id);
            $link = '<a href=' . base_url() . $txt . '>' . base_url() . $txt . '</a>';
            $emailarr["message"] = "<p>Dear " . $arr["first_name"] . ",</p>
			
			<p>Thanks for signing up for " . $this->config->item("sitename") . "!</p> 
			<p>To complete the sign-up process, please confirm your email by clicking on the link below:</p>
			<p>" . $link . "</p>
			<p>Once you confirm, you will have full access to " . $this->config->item("sitename") . " and all future notifications will be sent to this email address.</p>
			<p>Welcome to " . $this->config->item("sitename") . "</p>
			<p>Cheers,</p>
			<p>The " . $this->config->item("sitename") . " Team</p>
			<p>This email has been sent automatically. Please do not reply to this email.</p>";

            if ($this->email_model->sendIndividualEmail($emailarr) == 0) {
                $data["response"] = "success";
                $data["message"] = "Your account has been successfully created,please verify your account";
            } else {
                $data["response"] = "error";
                $data["message"] = "Your account has been successfully created,but there was an error while sending account verification email";
            }
        }
        echo json_encode($data);
    }

    public function email_already_exists($email) {

        $status = $this->login_model->check_email($email);
//        return $status;//0 -- found in db 1-- not found in db
        if ($status == 0) {//returned false that is found in db 
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function forgot_password_email() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $arr["email"] = clean($this->input->post("email"));
        $arr["id"] = '';

        if ($this->common->validate_forgot_email_exist($arr)) {
            $result = array();
            $result = $this->user_model->forgot_password($arr);

            $em = $arr["email"];
            $emailarr["to"] = $arr["email"];
            $emailarr['subject'] = "Your Reset Password link\n";

            $txt = '?em=' . base64_encode($em) . "&reset=" . 1 . '';
            $link = '<a href=' . base_url() . 'login/reset_password/' . $txt . '>' . base_url() . 'login/reset_password/' . $txt . '</a>';
            $emailarr["message"] = "<p>Dear " . $this->config->item("sitename") . " User,</p>
                                    <p>You're receiving this e-mail because you requested a password rest for your " . $this->config->item("sitename") . " account. To get back into your " . $this->config->item("sitename") . " account you’ll need to create a new password.</p>
                                    <p>Here’s what you have to do:</p>
				    <p>1. Click the link below to open a new and secure browser window.</p>
				    <p>2. Enter the requested information and enter your new password.</p>
				    <p>Reset your password now:</p>"
                    . $link . "
                      <p>If you have any questions or comments feel free to visit our FAQs Page and Contact Page at " . base_url() . "</p>
				    <p>Thanks, <br/>
				    " . $this->config->item("sitename") . " Team</p>";

            if ($this->email_model->sendIndividualEmail($emailarr) == 0) {
                $response["response"] = "success";
                $response['message'] = 'An email containing reset password link has been sent to your email id';
            } else {
                $response["response"] = "error";
                $response['message'] = 'Technical error please contact admin';
            }
        } else {
            $response["response"] = "error";
            $response['message'] = 'Email not found in our database';
        }
        echo json_encode($response);
    }

    public function reset_password() {

        $userid = $this->session->userdata('userid');
        if (empty($userid)) {

            $em = $this->input->get('em');
            $ar['email'] = base64_decode($em);
            //echo $email_real; die;
            $check = $this->common->validate_forgot_email_exist($ar);
            //echo $check;
            if (!empty($check)) {
                $data['email'] = $ar['email'];
                $data["item"] = "Reset Password";
                $data["master_title"] = $this->config->item('sitename');
                $data["master_body"] = "reset_password";
                //debug($data);die;
                $this->load->theme('mainlayout', $data);
            } else {
                $this->session->set_flashdata("errormsg", "Confirmation Code not match with Email Address");
                redirect(base_url());
            }
        } else {
            echo "dfsd";
            die;
            redirect(base_url());
        }
    }

    public function reset_password_update() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $userid = $this->session->userdata('userid');
        if ($userid != '') {
            redirect(base_url());
        } else {
            $arr["password"] = $this->input->post("password");
            $arr["email"] = base64_decode($this->input->post("email"));
            $arr["password"] = $this->common->salt_password($arr);
            //debug($arr);die;
            $updated = $this->login_model->update_password_with_email($arr);
            if ($updated) {
                $response['response'] = 'success';
                $response['message'] = 'Password successfully updated';
            } else {
                $response['response'] = 'error';
                $response['message'] = 'Password not updated technical problem contact administrator';
            }
            echo json_encode($response);
        }
    }

}

?>