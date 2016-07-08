<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class banners extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('banner_model');
    }

    public function index() {
        $this->manage_banners();
    }

    public function add_banners() {
        $data["item"] = "Banners";
        $data["do"] = "add";
        $data["bannerdata"] = $this->session->flashdata("tempdata");

        $data["add_banner_to_database"] = "add_banners_to_database";
        $data["master_title"] = $this->config->item("sitename") . " | Add Banners";   // Please enter the title of page......
        $data["master_body"] = "add_banners";  //  Please use view name in this field please do not include '.php' for including view name
        $this->load->theme('mainlayout', $data);

        //echo debug($data);die;
        if ($this->uri->segment(3) != '' && $this->uri->segment(3) == '0') {
            header("Refresh:3;url=" . base_url() . $this->router->class . "/manage_banners");
        }
    }

    public function edit_banners() {
		$data['per_page'] = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $data["item"] = "Banners";
        $data["do"] = "edit";
        $stateid = $this->uri->segment(3);
        $data["bannerdata"] = $this->banner_model->view_banner($stateid);

        $data["add_banner_to_database"] = "edit_category_to_database";
        $data["master_title"] = $this->config->item("sitename") . " | Edit Banners";   // Please enter the title of page......
        $data["master_body"] = "add_banners";  //  Please use view name in this field please do not include '.php' for including view name
        $this->load->theme('mainlayout', $data);

        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '2') {
            header("Refresh:3;url=" . base_url() . $this->router->class . "/manage_banners/?&per_page=".$data['per_page']);
        }
    }

    public function add_banners_to_database() {
	
		$data['per_page'] = $this->input->post("per_page");
      	$arr["id"] = ($this->input->post("id"));
        $arr["title"] = clean($this->input->post("title"));
        $arr["description1"] = trim($this->input->post("description1"));
       
        $arr["image"] = $_FILES["image"]["name"];
	
        if ($arr["image"] != "") {
            $arr["image"] = time() . "." . $this->common->get_extension($_FILES["image"]["name"]);
        } else {
            $arr["image"] = $this->input->post("banner_image");
        }
        if($arr["id"] == ""){
        	$arr['status'] = 1;
		}
		else{
		}
		
        
       // debug($arr);die;
        $this->session->set_flashdata("tempdata", $arr);
		
        if ($this->validations->validate_slideshow_data($arr)) {
            if ($arr["image"] != $this->input->post("banner_image")) {
                $image_info = getimagesize($_FILES['image']['tmp_name']);
                $image_width = $image_info[0];
                $image_height = $image_info[1];
				
				if(!in_array($this->common->get_extension($_FILES["image"]["name"]),$this->config->item("allowedimages")))
				{
					//echo "asxdasx";die;
					$this->session->set_flashdata("errormsg", "Only .png, .png, .gif allowed");
                    if ($arr["id"] == "") {
                        redirect(base_url() . $this->router->class . "/add_banners");
                    } else {
                        redirect(base_url() . $this->router->class . "/edit_banners/" . $arr["id"]);
                    }
				}
				else if ($image_width == 1349 || $image_height ==  482) {
                    $path = "../slideshowimages/" . $arr["image"];
                    chmod("$path", 0777);  // set permission to the file.
                    if (copy($_FILES['image']['tmp_name'], $path)) {//  upload the file to the server
                        unlink('../slideshowimages/' . $this->input->post("banner_image"));
                        $err = 0;
                    } else {
                        //echo $this->upload->display_errors();die;
                        $this->session->set_flashdata("successmsg", "There is some error uploading the files to server. Please contact server admin");
                        if ($arr["id"] == "") {
                            redirect(base_url() . $this->router->class . "/add_banners");
                        } else {
                            redirect(base_url() . $this->router->class . "/edit_banners/" . $arr["id"]);
                        }
                    }
                } else {
                    $this->session->set_flashdata("errormsg", "Please upload an image with a size of 1349 X 482.");
                    if ($arr["id"] == "") {
                        redirect(base_url() . $this->router->class . "/add_banners");
                    } else {
                        redirect(base_url() . $this->router->class . "/edit_banners/" . $arr["id"]);
                    }
                }
            }
            if ($this->banner_model->add_edit_banners($arr)) {
                if ($arr["id"] == '') {
                    $err = 0;
                    $this->session->set_flashdata("successmsg", "Banner added successfully");
                } else {
                    $err = 2;
                    $this->session->set_flashdata("successmsg", "Banner edited successfully");
                }
            } else {
                $this->session->set_flashdata("errormsg", "There was error in adding this Banner.");
                $err = 1;
            }
            if ($err == 0) {
                redirect(base_url() . $this->router->class . "/add_banners" . "/0");
            } else if ($err == 1) {
                redirect(base_url() . $this->router->class . "/add_banners" . "/1");
            } else if ($err == 2) {
                redirect(base_url() . $this->router->class . "/edit_banners/" . $arr["id"] . "/2/?per_page=".$data['per_page']);
            }
        } else {
            if ($arr["id"] == "") {
                redirect(base_url() . $this->router->class . "/add_banners");
            } else {
                redirect(base_url() . $this->router->class . "/edit_banners/" . $arr["id"]);
            }
        }
    }

    public function manage_banners() {
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
        $config['base_url'] = base_url() . "banners/manage_banners/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";

        $config['total_rows'] = count($this->banner_model->getbannersData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);
        /* --------------------------Paging code ends--------------------------------------------------- */
        $searcharray = array();
        $searcharray = $_GET;

        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];
		
        $data["item"] = "banner";
        $data["master_title"] = $this->config->item("sitename") . " | Manage category";   // Please enter the title of page......
        $data["master_body"] = "manage_banners";  //  Please use view name in this field please do not include '.php' for including view name
        $data["resultset"] = $this->banner_model->getbannersData($searcharray);
        $this->load->theme('mainlayout', $data);
		
		
    }

    public function enable_disable_banners() {
        $id = $this->uri->segment(3);
        $vstatus = $this->uri->segment(4);
		$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
		
        if ($vstatus == 0) {
            $status = "deactivated";
        } else {
            $status = "activated";
        }
        $result = $this->banner_model->enable_disable_banner($id, $vstatus);

        if ($result) {
            $this->session->set_flashdata("successmsg", "Banners " . $status . " successfully");
			//redirect(base_url()."blogs/manage_blog/?&per_page=".$this->uri->segment(5));
            redirect(base_url() . $this->router->class . "/manage_banners/?&per_page=".$per_page);
        } else {
            $this->session->set_flashdata("errormsg", "Query error");
            redirect(base_url() . $this->router->class . "/manage_banners/?&per_page=".$per_page);
        }
	}

    public function delete_banners() {
        $delid = $this->uri->segment(3);
		$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
		
        if ($delid != '') {
            $this->banner_model->delete_banner($delid);
			
            $this->session->set_flashdata("successmsg", "Banners archived successfully");
            redirect(base_url() . $this->router->class . "/manage_banners/?per_page=".$per_page);
        } else {
            $data = $this->input->post("chk");
            if (!isset($_REQUEST["chk"]) && count($_REQUEST["chk"]) == 0) {
                $this->session->set_flashdata("errormsg", "No banners selected");
            }
            foreach ($data as $key => $val) {
                $this->banner_model->delete_banner($val);
                $this->session->set_flashdata("successmsg", "Selected banners archived successfully");
            }
            redirect(base_url() . $this->router->class . "/manage_banners");
        }
    }

    public function view_banner() {
        $state_id = $this->uri->segment(3);
        $data["resultset"] = $this->banner_model->view_banner($state_id);

        $data["item"] = "View banner";
        $data["master_title"] = $this->config->item("sitename") . " | View banner";   // Please enter the title of page......
        $data["master_body"] = "view_banners";  //  Please use view name in this field please do not include '.php' for including view name
        $this->load->theme('mainlayout', $data);
    }

    /*     * ********************************************************state functions *********************************************** */
}

?>