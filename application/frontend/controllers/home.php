<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('products_model');
        //$this->load->model('page_model');
    }

    public function index() {

        $data["search"] = $this->input->get("search");

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
        $config['base_url'] = base_url() . $this->router->class . "/index/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";
        $countdata["search"] = $data["search"];

        $config['total_rows'] = count($this->products_model->getFrontEndProductsData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);


        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];
        $searcharray["search"] = $data["search"];

        $data['resultset'] = $this->products_model->getFrontEndProductsData($searcharray);
        $data['master_title'] = 'home';
        $data['master_body'] = 'home';
        $this->load->theme('mainlayout', $data);
        //debug($data);die;
    }

}
