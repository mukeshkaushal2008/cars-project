<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home_partners extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('home_partners_model');//to load the model 
    }

    public function index() {
        $this->manage_home_partners();
    }
	/**
	 * To view add home page partners 
	 * PHP versions 5+
	 * @Date 10-feb-2015
	 * @Purpose:Admin can add home page partners 
	 * @Parameters admin should be logged in 
	 * @Author     *****Mukesh Kaushal*****
	 **/ 
    public function add_home_partners() {
        $data["item"] = "home partners";
        $data["do"] = "add";
        $data["homepartnersdata"] = $this->session->userdata("homepartners_tempdata");
        $data["add_homepartners_to_database"] = "add_home_partners_to_database";
        $data["master_title"] = $this->config->item("sitename") . " | Add home partners";   // Please enter the title of page......
        $data["master_body"] = "add_home_partners";  //  Please use view name in this field please do not include '.php' for including view name
        $this->load->theme('mainlayout', $data);
        //echo debug($data);die;
        if ($this->uri->segment(3) != '' && $this->uri->segment(3) == '1') {
            header("Refresh:3;url=" . base_url() . $this->router->class . "/manage_home_partners");
        }
    }

	/**
	 * To edit home page partners 
	 * PHP versions 5+
	 * @Date 10-feb-2015
	 * @Purpose:Admin can edit home page partners 
	 * @Parameters admin should be logged in 
	 * @Author *****Mukesh Kaushal*****
	 **/ 
    public function edit_home_partners() {
		$data['per_page'] = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $data["item"] = "home_partners";
        $data["do"] = "edit";
        $id = $this->uri->segment(3);
        $data["homepartnersdata"] = $this->home_partners_model->view_home_partners($id);
        $data["add_homepartners_to_database"] = "add_home_partners";
        $data["master_title"] = $this->config->item("sitename") . " |edit home partners";   // Please enter the title of page......
        $data["master_body"] = "add_home_partners";  //  Please use view name in this field please do not include '.php' for including view name
        
		$this->load->theme('mainlayout', $data);

        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '2') {
            header("Refresh:3;url=" . base_url() . $this->router->class . "/manage_home_partners/?per_page=" . $data['per_page']);
        }
    }

	/**
	 * To add home page partners to database
	 * PHP versions 5+
	 * @Date 10-feb-2015
	 * @Purpose:Admin can edit home page partners 
	 * @Parameters admin should be logged in 
	 * @Author     *****Mukesh Kaushal*****
	 **/ 
    public function add_home_partners_to_database() {
		$data['per_page'] = $this->input->post("per_page");
      	$arr["id"] = ($this->input->post("id"));
        $arr["image"] = $_FILES["image"]["name"];
	
        if ($arr["image"] != "") {
            $arr["image"] = time() . "." . $this->common->get_extension($_FILES["image"]["name"]);
        } else {
            $arr["image"] = $this->input->post("homepartners_image");
        }
        $arr["status"] = 1;
		$arr["created_on"] = time();
	   // debug($arr);die;
        $this->session->set_userdata("homepartners_tempdata", $arr);
		
        if ($this->validations->validate_home_partners_data($arr)) {
            if ($arr["image"] != $this->input->post("homepartners_image")) {
                $image_info = getimagesize($_FILES['image']['tmp_name']);
                $image_width = $image_info[0];
                $image_height = $image_info[1];
                if ($image_width > 45 || $image_height >  45) {
                    $path = "../content_images/" . $arr["image"];
                    chmod("$path", 0777);  // set permission to the file.
                    if (copy($_FILES['image']['tmp_name'], $path)) {//  upload the file to the server
                        unlink('../content_images/' . $this->input->post("homepartners_image"));
                        $err = 0;
                    } else {
                        //echo $this->upload->display_errors();die;
                        $this->session->set_flashdata("successmsg", "There is some error uploading the files to server. Please contact server admin");
                        if ($arr["id"] == "") {
                            redirect(base_url() . $this->router->class . "/add_home_partners");
                        } else {
                            redirect(base_url() . $this->router->class . "/edit_home_partners/" . $arr["id"]."/?per_page=" . $data['per_page']);
                        }
                    }
                } else {
                    $this->session->set_flashdata("errormsg", "Please upload an image with a size of 45 X 45 or greater.");
                    if ($arr["id"] == "") {
						redirect(base_url() . $this->router->class . "/add_home_partners");
                    } else {
                        redirect(base_url() . $this->router->class . "/edit_home_partners/" . $arr["id"]."/?per_page=" . $data['per_page']);
                    }
                }
            }
            if ($this->home_partners_model->add_edit_home_partners($arr)) {
                if ($arr["id"] == '') {
					
                    $err = 1;
                    $this->session->set_flashdata("successmsg", "home partners added successfully");
                } else {
                    $err = 2;
                    $this->session->set_flashdata("successmsg", "home partners edited successfully");
                }
            } else {
                $this->session->set_flashdata("errormsg", "There was error in adding this homepartners.");
                $err = 1;
            }
            if ($err == 0) {
                redirect(base_url() . $this->router->class . "/add_home_partners" . "/0");
            } else if ($err == 1) {
				$this->session->unset_userdata("homepartners_tempdata");
                redirect(base_url() . $this->router->class . "/add_home_partners" . "/1");
            } else if ($err == 2) {
				$this->session->unset_userdata("homepartners_tempdata");
                redirect(base_url() . $this->router->class . "/edit_home_partners/" . $arr["id"] . "/2/?per_page=" . $data['per_page']);
            }
        } else {
            if ($arr["id"] == "") {
                redirect(base_url() . $this->router->class . "/add_home_partners");
            } else {
                redirect(base_url() . $this->router->class . "/edit_home_partners/" . $arr["id"]."/?per_page=" . $data['per_page']);
            }
        }
    }

    public function manage_home_partners() {
        /* --------------------------Paging code starts--------------------------------------------------- */
        $page = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : ""; //$this->input->get("page");

        if ($page == '') {
            $page = '0';
        } else {
            if (!is_numeric($page)) {
                redirect(BASEURL . '404');
            } else {
                $page = $page;
            }
        }

        $config["per_page"] = $this->config->item("perpageitem");
        $config['base_url'] = base_url() . $this->router->class."/manage_home_partners/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";

        $config['total_rows'] = count($this->home_partners_model->gethome_partnersData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);
        /* --------------------------Paging code ends--------------------------------------------------- */
        $searcharray = array();
        $searcharray = $_GET;

        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];

        $data["item"] = "homepartners";
        $data["master_title"] = $this->config->item("sitename") . " | Manage category";   // Please enter the title of page......
        $data["master_body"] = "manage_home_partners";  //  Please use view name in this field please do not include '.php' for including view name
        $data["resultset"] = $this->home_partners_model->gethome_partnersData($searcharray);
        $this->load->theme('mainlayout', $data);
    }

    public function enable_disable_home_partners() {
        $id = $this->uri->segment(3);
        $vstatus = $this->uri->segment(4);
		$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
		
        if ($vstatus == 0) {
            $status = "deactivated";
        } else {
            $status = "activated";
        }
        $result = $this->home_partners_model->enable_disable_home_partners($id, $vstatus);

        if ($result) {
            $this->session->set_flashdata("successmsg", "home partners " . $status . " successfully");
            redirect(base_url() . $this->router->class . "/manage_home_partners/?per_page=" . $per_page);
        } else {
            $this->session->set_flashdata("errormsg", "Query error ");
            redirect(base_url() . $this->router->class . "/manage_home_partners");
        }
    }

    public function delete_home_partners() {
        $delid = $this->uri->segment(3);
		$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
		 
        if ($delid != '') {
            $this->home_partners_model->delete_home_partners($delid);
            $this->session->set_flashdata("successmsg", "home partners archived successfully");
            redirect(base_url() . $this->router->class . "/manage_home_partners/?per_page=" . $per_page);
        } else {
            $data = $this->input->post("chk");
            if (!isset($_REQUEST["chk"]) && count($_REQUEST["chk"]) == 0) {
                $this->session->set_flashdata("errormsg", "No home partners selected");
            }
            foreach ($data as $key => $val) {
                $this->home_partners_model->delete_home_partners($val);
                $this->session->set_flashdata("successmsg", "Selected home partners archived successfully");
            }
            redirect(base_url() . $this->router->class . "/manage_home_partners/?per_page=" . $per_page);
        }
    }

    public function view_home_partners() {
        $state_id = $this->uri->segment(3);
        $data["resultset"] = $this->home_partners_model->view_home_partners($state_id);
        $data["item"] = "View homepartners";
        $data["master_title"] = $this->config->item("sitename") . " | View homepartners";   // Please enter the title of page......
        $data["master_body"] = "view_home_partners";  //  Please use view name in this field please do not include '.php' for including view name
        $this->load->theme('mainlayout', $data);
    }

    /*     * ********************************************************state functions *********************************************** */
}

?>