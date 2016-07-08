<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('email_model');
        $this->load->model("page_model");
        $this->load->model('products_model');
    }

    public function _remap() {
        $pagedata = $this->uri->segment(2);

        /* if($pagedata == 'terms_of_use'){
          $this->terms_of_use($pagedata);
          } */

        if ($pagedata == 'about_us') {
            $this->about_us($pagedata);
        } else if ($pagedata == 'terms') {
            $this->terms($pagedata);
        } else if ($pagedata == 'privacy') {
            $this->privacy($pagedata);
        } else if ($pagedata == 'contact_us') {
            $this->contact_us($pagedata);
        } else if ($pagedata == 'contact_request') {
            $this->contact_request($pagedata);
        } else {
            
        }
    }

    public function about_us($pagedata) {
        $data['item'] = 'About Us';
        $data['active'] = $pagedata;
        $data['resultset'] = $this->page_model->getPageData($pagedata);
        $data['master_title'] = $this->config->item('sitename') . ' | About Us';
        $data['master_body'] = 'about_us';
        //debug($data);die;
        $this->load->theme("mainlayout", $data);
    }

    public function terms($pagedata) {
        $data["item"] = "Terms";
        $data["master_title"] = $this->config->item('sitename');
        $data["resultset"] = $this->page_model->getPageData($pagedata);
        $data["master_body"] = "terms";
        //debug($data);die;
        $this->load->theme('mainlayout', $data);
    }

    public function privacy($pagedata) {
        $data["item"] = "Privacy";
        $data["master_title"] = $this->config->item('sitename');
        $data["resultset"] = $this->page_model->getPageData($pagedata);
        $data["master_body"] = "privacy";
        //debug($data);die;
        $this->load->theme('mainlayout', $data);
    }

    public function contact_us($pagedata) {

        $data["item"] = "Contact us";
        $data["master_title"] = $this->config->item('sitename');
        $data["resultset"] = $this->page_model->getPageData($pagedata);
        $data["master_body"] = "contact_us";
        //debug($data);die;
        $this->load->theme('mainlayout', $data);
    }

    public function contact_request() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $data = array();
        $arr["to"] = $this->config->item("adminemail");
        $arr["name"] = clean($this->input->post("name"));
        $arr["email"] = clean($this->input->post("email"));
        $arr["phone"] = $this->input->post("phone");
        $arr['subject'] = $arr["name"] . " has sent you an request";
        $arr['country'] = clean($this->input->post("country"));
        $arr["message"] = ($this->input->post("message"));

        //debug($arr);die;

        if (!empty($arr)) {
            $message = '<table width="100%" border="0" bgcolor="#E0E0E0" cellspacing="1" cellpadding="6" style="border:solid 4px #0076BE;">';
            $message .= '<tr><td colspan="2" style="font-size:24px; font-weight:bold; color:#002a76;">User Has Sent You a Mail</td></tr>';
            $message .= '<tr><td bgcolor="#fbf9f9" width="100"><strong>Name</strong></td><td width="150" bgcolor="#fbf9f9">' . $arr['name'] . '</td></tr>';
            $message .= '<tr><td bgcolor="#fbf9f9" width="100"><strong>Email Id</strong></td><td width="150" bgcolor="#fbf9f9">' . $arr['email'] . '</td></tr>';
            $message .= '<tr><td bgcolor="#fbf9f9" width="100"><strong>Phone</strong></td><td width="150" bgcolor="#fbf9f9">' . $arr['phone'] . '</td></tr>';
            $message .= '<tr><td bgcolor="#fbf9f9" width="100"><strong>Country</strong></td><td width="150" bgcolor="#fbf9f9">' . $arr['country'] . '</td></tr>';
            $message .= '<tr><td bgcolor="#fbf9f9" width="100"><strong>Message</strong></td><td width="150" bgcolor="#fbf9f9">' . $arr['message'] . '</td></tr></table>';

            $arr["message"] = $message;
            //debug($arr);die;
            if ($this->email_model->sendIndividualEmail($arr) == 1) {
                $data["response"] = "error";
                $data["message"] = "There was error in sending email.";
            } else {
                $data["response"] = "success";
                $data["message"] = "Your request has been successfully submitted Thanks!";
            }
        }
        echo json_encode($data);
        die;
    }

}
