<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class brand extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("brand_model");
        $this->load->model("validations_brand");
        $this->load->model("validations_model");
    }

    public function index() {
        $this->manage_brand();
    }

    public function manage_brand() {

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
        $config['base_url'] = base_url() . $this->router->class . "/manage_brand/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";
        $countdata["filter"] = $data["filter"];

        $config['total_rows'] = count($this->brand_model->getbrandData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);

        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];
        $searcharray["filter"] = $data["filter"];

        $data['resultset'] = $this->brand_model->getbrandData($searcharray);
        $data["item"] = "brand";
        //debug($data['resultset']);die;
        $data["master_title"] = "Manage brand";
        $data["master_body"] = "manage_brand";
        $this->load->theme('mainlayout', $data);
    }

    public function manage_model() {

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
        $config['base_url'] = base_url() . $this->router->class . "/manage_model/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";
        $countdata["filter"] = $data["filter"];

        $config['total_rows'] = count($this->brand_model->getmodelData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);

        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];
        $searcharray["filter"] = $data["filter"];

        $data['resultset'] = $this->brand_model->getmodelData($searcharray);
        $data["item"] = "Model";
        //debug($data['resultset']);die;
        $data["master_title"] = "Manage model";
        $data["master_body"] = "manage_model";
        $this->load->theme('mainlayout', $data);
    }

    public function enable_disable_brand() {
        $id = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        $per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";

        if ($status == 1) {
            $show_status = "activated";
        } else {
            $show_status = "deactivated";
        }
        $this->brand_model->enable_disable_brand($id, $status);
        $this->session->set_flashdata("successmsg", "brand " . $show_status . " successfully");
        redirect(base_url() . $this->router->class . "/manage_brand/?per_page=" . $per_page);
    }

    public function enable_disable_model() {
        $id = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        $per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";

        if ($status == 1) {
            $show_status = "activated";
        } else {
            $show_status = "deactivated";
        }
        $this->brand_model->enable_disable_model($id, $status);
        $this->session->set_flashdata("successmsg", "model " . $show_status . " successfully");
        redirect(base_url() . $this->router->class . "/manage_model/?per_page=" . $per_page);
    }

    public function view_brand() {
        $id = $this->uri->segment(3);

        if ($id == "" || $id == "0") {
            redirect("error_404.php");
        } else {
            $data["resultset"] = $this->brand_model->view_brand($id);
        }

        //debug($data["resultset"]);die;
        $data["master_title"] = "View brand";
        $data["master_body"] = "view_brand";
        $this->load->theme('mainlayout', $data);
    }

    public function view_model() {
        $id = $this->uri->segment(3);

        if ($id == "" || $id == "0") {
            redirect("error_404.php");
        } else {
            $data["resultset"] = $this->brand_model->view_model($id);
        }

        //debug($data["resultset"]);die;
        $data["master_title"] = "View model";
        $data["master_body"] = "view_model";
        $this->load->theme('mainlayout', $data);
    }

    public function getModels() {
        $brand_id = $this->input->post("brand_id");
        $model_id = $this->input->post("model_id");
        $get_models = $this->brand_model->getModels($brand_id);
        //debug($get_models);die;

        $select = '';
        $data = array();
        $select = '<select id="model" class="selectpicker" name="model_id">
                  <option value="">select model</option>';
        foreach ($get_models as $k => $v) {
            if ($v['id'] == $model_id) {
                $sel = 'selected="selected"';
            } else {
                $sel = '';
            }

            $select .= '<option ' . $sel . ' value="' . $v['id'] . '">' . $v['model_name'] . '</option>';
        }
        $select .= '</select>';


        if (isset($get_models) && !empty($get_models)) {
            $data["response"] = "success";
            $data["message"] = $select;
        } else {
            $data["response"] = "success";
            $data["message"] = '<select id="model" class="selectpicker" name="model_id">
                  <option value="">No model found</option></select>';
        }
        echo json_encode($data);
        die;
    }

    public function add_brand() {

        $id = $this->uri->segment(3);
        $data["do"] = "add";
        $data["item"] = "Add brand";
        $data["master_title"] = "Add brand | " . $this->config->item('sitename');
        $data["master_body"] = "add_brand";
        $this->load->theme('mainlayout', $data);

        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '0') {
            header("Refresh:3;url=" . base_url() . $this->router->class . "/manage_brand");
        }
    }

    public function add_model() {
        $data["brands"] = $this->common->get_table_data("*", "brand", "array", array("status" => 1));
        $id = $this->uri->segment(3);
        $data["do"] = "add";
        $data["item"] = "Add model";
        $data["master_title"] = "Add model | " . $this->config->item('sitename');
        $data["master_body"] = "add_model";
        $this->load->theme('mainlayout', $data);

        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '0') {
            header("Refresh:3;url=" . base_url() . $this->router->class . "/manage_model");
        }
    }

    public function edit_brand() {
        $data['per_page'] = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $id = $this->uri->segment(3);
        $data["brandinfo"] = $this->brand_model->view_brand_admin($id);
        $data["do"] = "edit";
        $data["item"] = "Edit brand";
        $data["master_title"] = "Edit brand | " . $this->config->item('sitename');
        $data["master_body"] = "add_brand";
        //debug($data);die;

        $this->load->theme('mainlayout', $data);

        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '2') {
            header("Refresh:4;url=" . base_url() . $this->router->class . "/manage_brand");
        }
    }

    public function edit_model() {
        $data["brands"] = $this->common->get_table_data("*", "brand", "array", array("status" => 1));
        $data['per_page'] = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $id = $this->uri->segment(3);
        $data["modelinfo"] = $this->brand_model->view_model_admin($id);
        $data["do"] = "edit";
        $data["item"] = "Edit model";
        $data["master_title"] = "Edit model | " . $this->config->item('sitename');
        $data["master_body"] = "add_model";
        //debug($data);die;

        $this->load->theme('mainlayout', $data);

        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '2') {
            header("Refresh:4;url=" . base_url() . $this->router->class . "/manage_model");
        }
    }

    public function add_brand_to_database() {
        $data['per_page'] = $this->input->post("per_page");
        $arr['id'] = clean($this->input->post('id'));
        $arr['brand_name'] = clean($this->input->post('brand_name'));
        $arr['created_time'] = time();

        $array = array();
        $string = '';
        $table = '';
        $field = '';
        $key = '';


        if ($arr["id"] == "") {
            $arr['status'] = 1;
            $string = $arr['brand_name'];
            $table = 'brand';
            $field = 'slug';
            $key = 'id';
            $value = '';
            $arr['slug'] = $this->common->create_unique_slug($string, $table, $field, $key, $value);
        }
        //debug($arr);die;
        if ($this->validations_brand->validate_data($arr)) {
            if ($this->brand_model->add_edit_brand($arr)) {
                $last_id = $this->db->insert_id();

                if ($arr["id"] == "" && $last_id != '') {
                    $this->session->set_flashdata("successmsg", "brand added succesfully");
                    $err = 0;      // for brand added succesfully
                    redirect(base_url() . $this->router->class . "/add_brand/" . $last_id . "/" . $err);
                } else {
                    $this->session->set_flashdata("successmsg", "brand updated succesfully");
                    $err = 2; // for brand updated succesfully
                    redirect(base_url() . $this->router->class . "/edit_brand/" . $arr["id"] . "/" . $err . "?per_page=" . $data['per_page']);
                }
            }
        } else {
            if ($arr["id"] == "") {
                $err = 1;
                //$this->session->set_flashdata("errormsg", "There is some technical problem to adding this brand.");
                redirect(base_url() . $this->router->class . "/add_brand");
            } else {
                $err = 2;
                //$this->session->set_flashdata("errormsg", "There is some technical problem to editing this brand.");
                redirect(base_url() . $this->router->class . "/edit_brand/" . $arr["id"] . "/" . $err . "/?per_page=" . $data['per_page']);
            }
        }
    }

    public function add_model_to_database() {
        $data['per_page'] = $this->input->post("per_page");
        $arr['id'] = clean($this->input->post('id'));
        $arr['brand_id'] = clean($this->input->post('brand_id'));
        $arr['model_name'] = clean($this->input->post('model_name'));
        $arr['created_time'] = time();
        //debug($arr);
        $array = array();
        $string = '';
        $table = '';
        $field = '';
        $key = '';


        if ($arr["id"] == "") {
            $arr['status'] = 1;
            $string = $arr['model_name'];
            $table = 'models';
            $field = 'slug';
            $key = 'id';
            $value = '';
            $arr['slug'] = $this->common->create_unique_slug($string, $table, $field, $key, $value);
        }
        //debug($arr);die;
        if ($this->validations_model->validate_data($arr)) {
            if ($this->brand_model->add_edit_model($arr)) {
                $last_id = $this->db->insert_id();

                if ($arr["id"] == "" && $last_id != '') {
                    $this->session->set_flashdata("successmsg", "model added succesfully");
                    $err = 0;      // for model added succesfully
                    redirect(base_url() . $this->router->class . "/add_model/" . $last_id . "/" . $err);
                } else {
                    $this->session->set_flashdata("successmsg", "model updated succesfully");
                    $err = 2; // for model updated succesfully
                    redirect(base_url() . $this->router->class . "/edit_model/" . $arr["id"] . "/" . $err . "?per_page=" . $data['per_page']);
                }
            }
        } else {

            if ($arr["id"] == "") {
                $err = 1;
                //$this->session->set_flashdata("errormsg", "There is some technical problem to adding this brand.");
                redirect(base_url() . $this->router->class . "/add_model");
            } else {
                $err = 2;
                //$this->session->set_flashdata("errormsg", "There is some technical problem to editing this brand.");
                redirect(base_url() . $this->router->class . "/edit_model/" . $arr["id"] . "/" . $err . "/?per_page=" . $data['per_page']);
            }
        }
    }

    public function delete_brand() {
        $per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $id = $this->uri->segment(3);

        if ($this->brand_model->delete_brand($id)) {
            $this->session->set_flashdata("successmsg", "brand deleted Successfully.");
        } else {
            $this->session->set_flashdata("errormsg", "There is some technical problem to delete this brand.");
        }
        //redirect(base_url().$this->router->class."manage_brand/");
        redirect(base_url() . $this->router->class . "/manage_brand/?per_page=" . $per_page);
    }

    public function delete_model() {
        $per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $id = $this->uri->segment(3);

        if ($this->brand_model->delete_model($id)) {
            $this->session->set_flashdata("successmsg", "model deleted Successfully.");
        } else {
            $this->session->set_flashdata("errormsg", "There is some technical problem to delete this model.");
        }
        //redirect(base_url().$this->router->class."manage_brand/");
        redirect(base_url() . $this->router->class . "/manage_model/?per_page=" . $per_page);
    }

}

?>