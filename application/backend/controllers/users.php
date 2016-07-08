<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("user_model");
//        $this->load->model("account_model");
        $this->load->helper("form");
    }

    public function index() {

        $this->manage_user();
    }

    public function manage_user() {


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
        $config['base_url'] = base_url() . $this->router->class . "/manage_user/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";
        $countdata["filter"] = $data["filter"];

        $config['total_rows'] = count($this->user_model->getuserData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);


        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];
        $searcharray["filter"] = $data["filter"];

        $data['resultset'] = $this->user_model->getuserData($searcharray);
        $data["item"] = "user";
        //debug($data['resultset']);die;
        $data["master_title"] = "Manage users";
        $data["master_body"] = "manage_user";
        $this->load->theme('mainlayout', $data);
    }

    public function enable_disable_user() {
        $id = $this->uri->segment(3);
        $status = $this->uri->segment(4);
		$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";

        if ($status == 1) {
            $show_status = "activated";
        } else {
            $show_status = "deactivated";
        }
        $this->user_model->enable_disable_user($id, $status);
        $this->session->set_flashdata("successmsg", "User " . $show_status . " successfully");
		
		redirect(base_url() . $this->router->class . "/manage_user/?per_page=" . $per_page);
    }

    public function view_user() {
        $id = $this->uri->segment(3);

        if ($id == "" || $id == "0") {
            redirect("error_404.php");
        } else {
            $data["resultset"] = $this->user_model->view_user($id);
        }

        //debug($data["resultset"]);die;
        $data["master_title"] = "View user";
        $data["master_body"] = "view_user";
        $this->load->theme('mainlayout', $data);
    }

    public function edit_user() {
		$data['per_page'] = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $id = $this->uri->segment(3);
        $data['country'] = $this->account_model->get_countries();
        $data["userinfo"] = $this->user_model->view_user($id);
        $data["do"] = "edit";
        $data["item"] = "Edit user";
        $data["master_title"] = "Edit user | " . $this->config->item('sitename');
        $data["master_body"] = "add_user";
        $this->load->theme('mainlayout', $data);
		
		if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '2') {
            header("Refresh:3;url=" . base_url() . "blogs/manage_blog/?per_page=" . $data['per_page']);
        }
    }

    public function edit_user_to_database() {
        $user_id = ($this->input->post('user_id'));
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

        if ($this->user_model->edit_user($arr, $user_id)) {
            $this->session->set_flashdata('successmsg', 'Your account has been successfully edited');
            redirect(base_url() . $this->router->class . '/manage_user/');
            //$this->session->set_flashdata('successmsg', 'Your account has been successfully edited');
        } else {
            $this->session->set_flashdata('errormsg', 'Your changes are not updated technical error contact administrator');
            redirect(base_url() . $this->router->class . '/edit_user/');
        }
    }

    public function delete_user() {
        //$this->common->is_logged_in();
		$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $id = $this->uri->segment(3);
        if ($this->user_model->delete_user($id)) {
            $this->session->set_flashdata("successmsg", "user deleted Successfully.");
        } else {
            $this->session->set_flashdata("errormsg", "There is some technical problem to delete this user.");
        }
        redirect(base_url() . $this->router->class . "/manage_user/?per_page=" . $per_page);
    }
}

?>