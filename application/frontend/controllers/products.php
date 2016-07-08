<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('products_model');
    }

    public function index() {

        //$slug = $this->uri->segment(3);
        // $data["resultset"] = $this->products_model->getproductdatabyslug($slug);

        $data["item"] = "Products";
        $data["master_title"] = "Products";
        $data["master_body"] = "index";
        //debug($data);die;
        //$this->load->view('products/detail', $data);
        $this->load->theme('mainlayout', $data);
    }

    public function detail() {
        $slug = $this->uri->segment(3); 
        $data["resultset"] = $this->products_model->getFrontEndProductDataBySlug($slug);
        $data['offers_category_products'] = $this->products_model->getFrontEndProductsDataByCategory($data["resultset"]["category_id"],$data["resultset"]["id"]);
        $data["item"] = "Product  detail";
        $data["master_title"] = "Product  detail";
        $data["master_body"] = "detail";
        //debug($data);
        //$this->load->view('products/detail', $data);
        $this->load->theme('mainlayout', $data);
    }

//==================================================Product Comments Section End=============================================================================//
}

?>