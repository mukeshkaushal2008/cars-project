<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("category_model");
        $this->load->model("validations_category");
    }

    public function index() {
        $this->manage_category();
    }

    public function manage_category() {

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
        $config['base_url'] = base_url() . $this->router->class . "/manage_category/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";
        $countdata["filter"] = $data["filter"];

        $config['total_rows'] = count($this->category_model->getcategoryData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);

        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];
        $searcharray["filter"] = $data["filter"];

        $data['resultset'] = $this->category_model->getcategoryData($searcharray);
        $data["item"] = "category";
        //debug($data['resultset']);die;
        $data["master_title"] = "Manage category";
        $data["master_body"] = "manage_category";
        $this->load->theme('mainlayout', $data);
    }

    public function enable_disable_category() {
        $id = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        $per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";

        if ($status == 1) {
            $show_status = "activated";
        } else {
            $show_status = "deactivated";
        }
        $this->category_model->enable_disable_category($id, $status);
        $this->session->set_flashdata("successmsg", "Category " . $show_status . " successfully");
        redirect(base_url() . $this->router->class . "/manage_category/?per_page=" . $per_page);
    }

    public function view_category() {
        $id = $this->uri->segment(3);

        if ($id == "" || $id == "0") {
            redirect("error_404.php");
        } else {
            $data["resultset"] = $this->category_model->view_category($id);
        }

        //debug($data["resultset"]);die;
        $data["master_title"] = "View category";
        $data["master_body"] = "view_category";
        $this->load->theme('mainlayout', $data);
    }

    public function add_category() {
        $id = $this->uri->segment(3);
        $data["do"] = "add";
        $data["item"] = "Add category";
        $data["master_title"] = "Add category | " . $this->config->item('sitename');
        $data["master_body"] = "add_category";
        $this->load->theme('mainlayout', $data);

        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '0') {
            header("Refresh:3;url=" . base_url() . $this->router->class . "/manage_category");
        }
    }

    public function edit_category() {
        $data['per_page'] = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $id = $this->uri->segment(3);
        $data["categoryinfo"] = $this->category_model->view_category_admin($id);
        $data["do"] = "edit";
        $data["item"] = "Edit category";
        $data["master_title"] = "Edit category | " . $this->config->item('sitename');
        $data["master_body"] = "add_category";
        //debug($data);die;

        $this->load->theme('mainlayout', $data);

        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '2') {
            header("Refresh:4;url=" . base_url() . $this->router->class . "/manage_category");
        }
    }

    public function add_category_to_database() {
        $data['per_page'] = $this->input->post("per_page");
        $arr['id'] = clean($this->input->post('id'));
        $arr['category_name'] = clean($this->input->post('category_name'));
        $arr['created_time'] = time();
        if ($arr["id"] == "") {
            $arr['status'] = 1;
            $string = $arr['category_name'];
            $table = 'category';
            $field = 'slug';
            $key = 'id';
            $value = '';
            $arr['slug'] = $this->common->create_unique_slug($string, $table, $field, $key, $value);
        }
        if ($this->validations_category->validate_data($arr)) {
            if ($this->category_model->add_edit_category($arr)) {
                $last_id = $this->db->insert_id();

                if ($arr["id"] == "" && $last_id != '') {
                    $this->session->set_flashdata("successmsg", "Category added succesfully");
                    $err = 0;      // for category added succesfully
                    redirect(base_url() . $this->router->class . "/add_category/" . $last_id . "/" . $err);
                } else {
                    $this->session->set_flashdata("successmsg", "Category updated succesfully");
                    $err = 2; // for category updated succesfully
                    redirect(base_url() . $this->router->class . "/edit_category/" . $arr["id"] . "/" . $err . "?per_page=" . $data['per_page']);
                }
            }
        } else {
            if ($arr["id"] == "") {
                $err = 1;
                //$this->session->set_flashdata("errormsg", "There is some technical problem to adding this category.");
                redirect(base_url() . $this->router->class . "/add_category");
            } else {
                $err = 2;
                //$this->session->set_flashdata("errormsg", "There is some technical problem to editing this category.");
                redirect(base_url() . $this->router->class . "/edit_category/" . $arr["id"] . "/" . $err . "/?per_page=" . $data['per_page']);
            }
        }
    }

    public function delete_category() {
        $per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $id = $this->uri->segment(3);

        if ($this->category_model->delete_category($id)) {
            $this->session->set_flashdata("successmsg", "Category deleted Successfully.");
        } else {
            $this->session->set_flashdata("errormsg", "There is some technical problem to delete this category.");
        }
        //redirect(base_url().$this->router->class."manage_category/");
        redirect(base_url() . $this->router->class . "/manage_category/?per_page=" . $per_page);
    }

}

?>