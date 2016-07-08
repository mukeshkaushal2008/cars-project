<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("products_model");
    }

    public function index() {

        $this->manage_product();
    }

    public function manage_product() {

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
        $config['base_url'] = base_url() . $this->router->class . "/manage_product/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";
        $countdata["filter"] = $data["filter"];

        $config['total_rows'] = count($this->products_model->getproductData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);


        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];
        $searcharray["filter"] = $data["filter"];

        $data['resultset'] = $this->products_model->getproductData($searcharray);
        $data["item"] = "product";
        //debug($data['resultset']);die;
        $data["master_title"] = "Manage products";
        $data["master_body"] = "manage_product";
        $this->load->theme('mainlayout', $data);
    }

    public function enable_disable_product() {
        $id = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        $data['per_page'] = !empty($_GET['per_page']) ? $_GET['per_page'] : "";

        if ($status == 1) {
            $show_status = "activated";
        } else {
            $show_status = "deactivated";
        }
        $this->products_model->enable_disable_product($id, $status);
        $this->session->set_flashdata("successmsg", "Product " . $show_status . " successfully");
        redirect(base_url() . $this->router->class . "/manage_product/?per_page=" . $data['per_page']);
    }

    public function enable_disable_featured() {
        $tagid = $this->uri->segment(3);
        $status = $this->uri->segment(4);

        if ($status == 0) {
            $show_status = "featured";
        } else {
            $show_status = "unfeatured";
        }
        $this->products_model->enable_disable_featured($tagid, $status);

        $this->session->set_flashdata("successmsg", "Product marked as " . $show_status . " successfully");
        redirect(base_url() . $this->router->class . "/manage_product/?per_page=" . $data['per_page']);
    }

    public function view_product() {
        $id = $this->uri->segment(3);
        $data['per_page'] = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        if ($id == "" || $id == "0") {
            redirect("error_404.php");
        } else {
            $data["resultset"] = $this->products_model->view_product($id);
        }

        //debug($data["resultset"]);die;
        $data["master_title"] = "View product";
        $data["master_body"] = "view_product";
        $this->load->theme('mainlayout', $data);
    }

    public function add_product() {
        $data["categories"] = $this->common->get_table_data("*", "category", "array", array("status" => 1));
        $data["brands"] = $this->common->get_table_data("*", "brand", "array", array("status" => 1));
        $id = $this->uri->segment(3);
        $data['per_page'] = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $data["do"] = "add";
        $data["item"] = "Add product";
        $data["master_title"] = "Add product | " . $this->config->item('sitename');
        $data["master_body"] = "add_product";
        //debug($data);die;
        $this->load->theme('mainlayout', $data);

        if ($this->uri->segment(3) == 1 && $this->uri->segment(4) != '') {
            header("Refresh:3;url=" . base_url() . $this->router->class . "/manage_product/?per_page=" . $data['per_page']);
        }
    }

    public function edit_product() {
        $id = $this->uri->segment(3);
        $data["categories"] = $this->common->get_table_data("*", "category", "array", array("status" => 1));
        $data["brands"] = $this->common->get_table_data("*", "brand", "array", array("status" => 1));
        $data['per_page'] = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $data["productinfo"] = $this->products_model->view_product($id);
        $data["dataset"] = $this->products_model->getproductdatabyid($id);
        $data["do"] = "edit";
        $data["item"] = "Edit product";
        $data["master_title"] = "Edit product | " . $this->config->item('sitename');
        $data["master_body"] = "edit_product";
        //debug($data);die;

        $this->load->theme('mainlayout', $data);

        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '2') {
            header("Refresh:3;url=" . base_url() . $this->router->class . "/manage_product/" . $id . "/?per_page=" . $data['per_page']);
        }
    }

    public function upload_image() {
        //require_once APPPATH.'libraries/server/index.php';
        require_once APPPATH . 'libraries/server/UploadHandler.php';
        $upload_handler = new UploadHandler();
    }

    public function remove_image() {
        $url = $_GET['url'];
        $new_url = explode('file=', $url);
        $path = "../upload/" . $new_url['1'];
        $path1 = "../upload/thumbnail/" . $new_url['1'];
        chmod("$path", 0777);  // set permission to the file.
        chmod("$path1", 0777);
        unlink('../upload/' . $new_url['1']);
        unlink('../upload/thumbnail/' . $new_url['1']);
        $data['result'] = "success";
        $data['img'] = $new_url['1'];
        echo json_encode($data);
        die;
    }

    public function remove_image_edit() {

        $url = $_GET['url'];
        $new_url = explode('file=', $url);

        $path = "../product_images/" . $new_url['1'];
        $path1 = "../product_images/thumbnail/" . $new_url['1'];
        chmod("$path", 0777);  // set permission to the file.
        chmod("$path1", 0777);
        unlink('../product_images/' . $new_url['1']);
        unlink('../product_images/thumbnail/' . $new_url['1']);

        $data['result'] = "success";
        $data['img'] = $new_url['1'];

        echo json_encode($data);
        die;
    }

    public function move_image($image_name) {
        $copy_path = "../upload/" . $image_name;
        $path = "../product_images/" . $image_name;
        chmod("$copy_path", 0777);  // set permission to the file.
        chmod("$path", 0777);  // set permission to the file.
        if (copy($copy_path, $path)) {//  upload the file to the server
            unlink('../upload/' . $image_name);
            $copy_path_thumb = "../upload/thumbnail/" . $image_name;
            $path_thumb = "../product_images/thumbnail/" . $image_name;
            chmod("$copy_path_thumb", 0777);
            chmod("$path_thumb", 0777);
            if (copy($copy_path_thumb, $path_thumb)) {
                unlink('../upload/thumbnail/' . $image_name);
            }
        }
    }

    public function create_unique_slug($string, $table, $field = 'slug', $key = NULL, $value = NULL) {
        $t = & get_instance();
        $slug = url_title($string);
        $slug = strtolower($slug);
        $i = 0;
        $params = array();
        $params[$field] = $slug;

        if ($key)
            $params["$key !="] = $value;

        while ($t->db->where($params)->get($table)->num_rows()) {
            if (!preg_match('/-{1}[0-9]+$/', $slug))
                $slug .= '-' . ++$i;
            else
                $slug = preg_replace('/[0-9]+$/', ++$i, $slug);
            $params [$field] = $slug;
        }
        return $slug;
    }

    public function add_product_to_database() {
        //debug($this->input->post());
        $arr['name'] = clean($this->input->post('name'));
        $arr['category_id'] = clean($this->input->post('category_id'));
        $arr['brand_id'] = clean($this->input->post('brand_id'));
        $arr['model_id'] = clean($this->input->post('model_id'));
        $arr['retail_price'] = clean($this->input->post('retail_price'));
        $arr['minimum_price'] = clean($this->input->post('minimum_price'));
        $arr['start_date'] = $this->common->get_start_time($this->input->post('start_date'));
        $arr['end_date'] = $this->common->get_end_time($this->input->post('end_date'));
        $arr['short_description'] = $this->input->post('short_description');
        $arr['long_description'] = $this->input->post('long_description');
        $arr['created_time'] = time();
        $arr['status'] = 1;
        $arr['is_featured'] = 1;
        //debug($arr);die;
        $arr1['image'] = $this->input->post('image');

        $array = array();
        $string = '';
        $table = '';
        $field = '';
        $key = '';

        $string = $arr['name'];
        $table = 'products';
        $field = 'slug';
        $key = 'id';
        $value = '';
        $arr['slug'] = $this->create_unique_slug($string, $table, $field, $key, $value);
        $is_default_image = '';

        /* debug($arr);
          debug($arr1);
          die; */
        if ($this->products_model->add_product($arr)) {
            $last_id = $this->db->insert_id();

            $is_default_image = range(1, 6);
            foreach ($arr1['image'] as $key => $val) {
                $this->move_image($val);
                $image['product_id'] = $last_id;
                $image['image'] = $val;
                $image['created_time'] = time();
                $image['status'] = 1;
                $image["is_default_image"] = $is_default_image[$key];
                $this->products_model->add_edit_product_images($image);
            }
            $this->session->set_flashdata("successmsg", "Product added successfully");
            redirect(base_url() . $this->router->class . "/add_product/1/" . $last_id);
        } else {
            $this->session->set_flashdata("errormsg", "There is some technical problem to published this product.");
            redirect(base_url() . $this->router->class . "/add_product/1/");
        }
    }

    public function update_product_to_database() {
        $data['per_page'] = $this->input->post("per_page");
        $arr['id'] = clean($this->input->post("id"));
        $arr['name'] = clean($this->input->post('name'));
        $arr['category_id'] = clean($this->input->post('category_id'));
        $arr['brand_id'] = clean($this->input->post('brand_id'));
        $arr['model_id'] = clean($this->input->post('model_id'));
        $arr['retail_price'] = clean($this->input->post('retail_price'));
        $arr['minimum_price'] = clean($this->input->post('minimum_price'));
        $arr['start_date'] = $this->common->get_start_time($this->input->post('start_date'));
        $arr['end_date'] = $this->common->get_end_time($this->input->post('end_date'));
        $arr['short_description'] = $this->input->post('short_description');
        $arr['long_description'] = $this->input->post('long_description');
        $arr1['image'] = $this->input->post('image');
        $arr['is_featured'] = 1;
        /* debug($arr);
          debug($arr1);
          die; */
        if ($this->products_model->edit_product($arr)) {
            $last_id = $arr['id'];
            //// remove prev 
            $this->products_model->delete_product_images($last_id, $arr1['image']);
            $is_default_image = range(1, 6);

            foreach ($arr1['image'] as $key => $val) {
                if ($val != "") {
                    $filename = "product_images/" . $val;
                    if (file_exists($filename)) {
                        
                    } else {
                        $this->move_image($val);
                    }

                    $image['product_id'] = $last_id;
                    $image['image'] = $val;
                    $image['created_time'] = time();
                    $image['status'] = 1;
                    $image["is_default_image"] = $is_default_image[$key];
                    $this->products_model->add_edit_product_images($image);
                }
            }
            $this->session->set_flashdata("successmsg", "Products edited Successfully.");
            redirect(base_url() . $this->router->class . "/edit_product/" . $this->input->post("id") . "/2/?per_page=" . $data['per_page']);
        } else {
            $this->session->set_flashdata("errormsg", "There is some technical problem to edit this product.");
            redirect(base_url() . $this->router->class . "/edit_product/" . $this->input->post("id") . "/1/?per_page=" . $data['per_page']);
        }
    }

    public function delete_product() {
        $per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $id = $this->uri->segment(3);

        if ($this->products_model->delete_product($id)) {
            $this->session->set_flashdata("successmsg", "Product deleted Successfully.");
        } else {
            $this->session->set_flashdata("errormsg", "There is some technical problem to delete this product.");
        }
        redirect(base_url() . $this->router->class . "/manage_product/?per_page=" . $per_page);
    }

}

?>