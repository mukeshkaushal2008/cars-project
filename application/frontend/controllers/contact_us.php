<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class contact_us extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('email_model');
    }

    public function index() {

        $data["item"] = "Contact";
        $data["master_title"] = $this->config->item('sitename');
        $data["master_body"] = "contact_us";
        $this->load->theme('home_layout', $data);
    }

    public function submit_contact_info() {

//        debug($this->input->post());
//        die;
       
        $user_email = 'testing.slinfy02@gmail.com';
//        $User = $onsite_data["first_name"];

        $emailarr["to"] = $user_email;
        $emailarr["subject"] = "Contact Form";
        $emailarr["message"] = "<p>Hi,</p>
   <p>Please find contact us information below</p> 
   <p>User Name : " . $this->input->post('name') . "</p>
   <p>User Email : " . $this->input->post('email') . "</p>
   <p>User Phone : " . $this->input->post('phone') . "</p>
   <p>Reason : " . $this->input->post('reason') . "</p>
   <p>Message : " . $this->input->post('message') . "</p>
   <p>Thanks,</p>
   <p>The" . $this->config->item("sitename") . " Team</p>";

        $email_send = $this->email_model->sendIndividualEmail($emailarr); //send email ro the users

        $res['status'] = 1;
        $res['message'] = 'Sent Successfully';

        echo json_encode($res);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */