<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pages extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('page_model');
    }

    /*     * ********************************************************Page functions starts *********************************************** */

    public function index() {

        $this->manage_page();
    }

    /*

     * 1) ABOUT US

     * 2) Our vision

     * 3) Terms

     * 4) FAQS

     * 5) Mobile APp

     * 6) Advertising

     * 7) Partners

     * 8) Contact us

     */

    public function manage_page() {

        $pagename = $this->uri->segment(3);



        if ($pagename == 'about_us') {

            $data["do"] = "edit";

            $data["resultset"] = $this->page_model->getPageData($pagename);

            $data["update_page_to_database"] = 'update_page_to_database'; //function to be called on save

            $data["item"] = "About us";

            $data["master_title"] = "About us";

            $data["master_body"] = "manage_page";

            $this->load->theme('mainlayout', $data);
        } else if ($pagename == 'terms') {

            $data["do"] = "edit";

            $data["resultset"] = $this->page_model->getPageData($pagename);

            $data["update_page_to_database"] = 'update_page_to_database'; //function to be called on save

            $data["item"] = "Terms";

            $data["master_title"] = "Terms";

            $data["master_body"] = "manage_page";

            $this->load->theme('mainlayout', $data);
        } else if ($pagename == 'privacy') {

            $data["do"] = "edit";

            $data["resultset"] = $this->page_model->getPageData($pagename);

            $data["update_page_to_database"] = 'update_page_to_database'; //function to be called on save

            $data["item"] = "Privacy";

            $data["master_title"] = "Privacy";

            $data["master_body"] = "manage_page";

            //debug($data);die;

            $this->load->theme('mainlayout', $data);
        } else if ($pagename == 'newsletter') {
            $data["users"] = $this->user_model->getAllUsers($pagename);
            $data["do"] = "edit";

            $data["resultset"] = $this->session->flashdata("temp_data");

            //debug($data["resultset"]);//die;

            $data["sendnewsletter"] = 'sendnewsletter'; //function to be called on save

            $data["item"] = "Newsletters";

            $data["master_title"] = "Newsletters";

            $data["master_body"] = "newsletter";

            $this->load->theme('mainlayout', $data);



            if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '0') {

                header("Refresh:3;url=" . base_url() . $this->router->class . "/manage_page/newsletter");
            }
        }
    }

    public function update_page_to_database() {

        $arr["id"] = $this->input->post("id");

        $arr["page_title"] = $this->input->post("page_title");

        $arr["page_content"] = $this->input->post("page_content");

        $arr["page_name"] = $this->input->post("page_name");

        $arr["video_id"] = $this->input->post("video_id");

        if ($arr["video_id"] == "" && $arr["page_name"] == "design") {

            $this->session->set_flashdata("errormsg", "Please enter vimeo video id");
        } else if ($arr["page_title"] == "" && $arr["page_name"] == "home_content") {

            $this->session->set_flashdata("errormsg", "Please enter title");
        } else if ($arr["page_content"] == '' || $arr["page_content"] == " ") {

            $this->session->set_flashdata("errormsg", "Please enter Page Content");
        } else {

            if ($this->page_model->updatepagedata($arr)) {

                $this->session->set_flashdata("successmsg", "Content updated successfully");
            } else {

                $this->session->set_flashdata("errormsg", "There is error updating content to database. Please contact database admin");
            }
        }

        redirect(base_url() . "pages/manage_page/" . $arr["page_name"] . '/edit');
    }

    public function sendnewsletter() {
        $arr["email"] = $_REQUEST["email"];
        $arr["content"] = $this->input->post("content");
        
        //debug($arr);die;
        
        $message = '<table width="100%" border="0" bgcolor="#E0E0E0" cellspacing="1" cellpadding="6" style="border:solid 4px #0076BE;">';
        $message .= '<tr><td colspan="2" style="font-size:24px; font-weight:bold; color:#002a76;">You have received a new newsletter from ' . $this->config->item("sitename") . '</td></tr>';
        //$message .= '<tr><td bgcolor="#fbf9f9" width="100"><strong>Email Id</strong></td><td width="150" bgcolor="#fbf9f9">'.$arr['email'].'</td></tr>';
        //<td bgcolor="#fbf9f9" width="100"><strong>Message</strong></td>
        $message .= '<tr><td colspan="2" width="150" bgcolor="#fbf9f9">' . nl2br(stripcslashes($arr['content'])) . '</td></tr></table>';
        $arr["subject"] = "You have received a new newsletter from " . $this->config->item("sitename");
        $arr["message"] = $message;
        if ($this->email_model->send_newsletter($arr) == 1) {
            $data["response"] = "error";
            $data["message"] = "There was error in sending newsletters";
        } else {
            $data["response"] = "success";
            $data["message"] = "Newsletters has been sent successfully";
        }
        echo json_encode($data);die;
    }

    public function get_image_Extension($imagename) {

        $imagename = explode(".", $imagename);

        return $imagename[1];
    }

    public function upload_images() {

        $config['upload_path'] = '../ckeditorimages/';

        $config['allowed_types'] = '*';

        $config['file_name'] = $_FILES['upload']['name'];

        $this->upload->initialize($config);

        $validimages = array("jpg", "gif", "png", "jpeg", "bmp");

        if (in_array($this->get_image_Extension($_FILES['upload']['name']), $validimages)) {

            if ($this->upload->do_upload('upload')) {

                $arr = $this->upload->data();

                $url = $this->config->item("ckeditorimages") . $arr['file_name'];
            } else {

                $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
            }
        } else {

            $message = "Only images file with " . implode(",", $validimages) . " extensions are allowed";
        }

        $funcNum = $_GET['CKEditorFuncNum'];

        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
    }

}

?>