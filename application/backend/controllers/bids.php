<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class bids extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("bid_model");
    }

    public function index() {

        $this->manage_bid();
    }

    public function manage_bid() {


        $data["filter"] = $this->input->get("filter");

        $page = isset($_GET["per_page"]) ? $_GET["per_page"] : "";
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
        $config['base_url'] = base_url() . $this->router->class . "/manage_bid/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";
        $countdata["filter"] = $data["filter"];

        $config['total_rows'] = count($this->bid_model->getbidData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);


        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];
        $searcharray["filter"] = $data["filter"];

        $data['resultset'] = $this->bid_model->getbidData($searcharray);
        $data["item"] = "bid";
        //debug($data['resultset']);die;
        $data["master_title"] = "Manage bids";
        $data["master_body"] = "manage_bid";
        $this->load->theme('mainlayout', $data);
    }

    public function enable_disable_bid() {
        $id = $this->uri->segment(3);
        $status = $this->uri->segment(4);
		$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";

        if ($status == 1) {
            $show_status = "activated";
        } else {
            $show_status = "deactivated";
        }
        $this->bid_model->enable_disable_bid($id, $status);
        $this->session->set_flashdata("successmsg", "bid " . $show_status . " successfully");
		
		redirect(base_url() . $this->router->class . "/manage_bid/?per_page=" . $per_page);
    }

    public function view_bid() {


        $data["id"] = $this->uri->segment(3);

        $page = isset($_GET["per_page"]) ? $_GET["per_page"] : "";
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
        $config['base_url'] = base_url() . $this->router->class . "/view_bid/".$data["id"]."/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";
        $countdata["id"] = $data["id"];

        $config['total_rows'] = count($this->bid_model->view_bid($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);


        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];
        $searcharray["id"] = $data["id"];

        $data['resultset'] = $this->bid_model->view_bid($searcharray);
        $data["item"] = "bid";
        
        $data["master_title"] = "view bids";
        $data["master_body"] = "view_bid";
		//debug($data['resultset']);die;
        $this->load->theme('mainlayout', $data);
    }

   
    public function edit_bid() {
		$data['per_page'] = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $id = $this->uri->segment(3);
        $data['country'] = $this->account_model->get_countries();
        $data["bidinfo"] = $this->bid_model->view_bid($id);
        $data["do"] = "edit";
        $data["item"] = "Edit bid";
        $data["master_title"] = "Edit bid | " . $this->config->item('sitename');
        $data["master_body"] = "add_bid";
        $this->load->theme('mainlayout', $data);
		
		if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '2') {
            header("Refresh:3;url=" . base_url() . "blogs/manage_blog/?per_page=" . $data['per_page']);
        }
    }

    public function edit_bid_to_database() {
        $bid_id = ($this->input->post('bid_id'));
        $arr['name'] = clean($this->input->post('personal_full_name'));
        $arr['nationality'] = clean($this->input->post('personal_nationality'));
        $arr['identification_type'] = clean($this->input->post('personal_identification_type'));
        $arr['identification_number'] = clean($this->input->post('personal_identification_number'));
        $arr['gender'] = clean($this->input->post('personal_gender'));
        $arr['contact_hp'] = clean($this->input->post('personal_contact_hp'));
        $arr['contact_home'] = clean($this->input->post('personal_contact_home'));
        $arr['contact_office'] = clean($this->input->post('personal_contact_office'));
        $arr['postal_code'] = clean($this->input->post('personal_postal_code'));
        $arr['address'] = clean($this->input->post('personal_address'));
        $arr['unit_f'] = clean($this->input->post('personal_unit_f'));
        $arr['unit_l'] = clean($this->input->post('personal_unit_l'));
        $personal_date = clean($this->input->post("personal_date"));
        $personal_month = clean($this->input->post("personal_month"));
        $personal_year = clean($this->input->post("personal_year"));
        $arr['d_o_b'] = $personal_year . '-' . $personal_month . '-' . $personal_date;

        //debug($arr);die;

        if ($this->bid_model->edit_bid($arr, $bid_id)) {
            $this->session->set_flashdata('successmsg', 'Your account has been successfully edited');
            redirect(base_url() . $this->router->class . '/manage_bid/');
            //$this->session->set_flashdata('successmsg', 'Your account has been successfully edited');
        } else {
            $this->session->set_flashdata('errormsg', 'Your changes are not updated technical error contact administrator');
            redirect(base_url() . $this->router->class . '/edit_bid/');
        }
    }

    public function delete_bid() {
        //$this->common->is_logged_in();
		$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $id = $this->uri->segment(3);
        if ($this->bid_model->delete_bid($id)) {
            $this->session->set_flashdata("successmsg", "bid deleted Successfully.");
        } else {
            $this->session->set_flashdata("errormsg", "There is some technical problem to delete this bid.");
        }
        redirect(base_url() . $this->router->class . "/manage_bid/?per_page=" . $per_page);
    }
}

?>