<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class news extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('new_model');
    }

    public function index() {
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
        $config['base_url'] = base_url() . "news/index/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";

        $config['total_rows'] = count($this->new_model->getNewData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);
        /* --------------------------Paging code ends--------------------------------------------------- */
        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];

        $data["resultset"] = $this->new_model->getNewData($searcharray);
        $data["item"] = "News";
        $data["master_title"] = "News";
        $data["master_body"] = "news";
        $this->load->theme('home_layout', $data);
    }

    
    /*
     * gets detail of news
     * getindividual news ---- > first param is id or slug , second param is field to query (id or slug)
     */
    public function detail() {
        $news_slug = $this->uri->segment(3);
        if ($news_slug == "") {
            redirect(base_url() . "invalidpage");
        } else {
            $data["resultset"] = $this->new_model->getIndividualNew($news_slug,'slug');
        }
        $data["master_title"] = "News Detail";
        $data["master_body"] = "detail";
        $this->load->theme('home_layout', $data);
    }
   

//==================================================New Comments Section End=============================================================================//
}

?>