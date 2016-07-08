<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class partners extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('our_partners_model');
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
        $config['base_url'] = base_url() . "partners/index/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";

        $config['total_rows'] = count($this->our_partners_model->getPartnerData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);
        /* --------------------------Paging code ends--------------------------------------------------- */
        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];

        $data["resultset"] = $this->our_partners_model->getPartnerData($searcharray);
        $data["item"] = "News";
        $data["master_title"] = "Partners";
        $data["master_body"] = "partners";
        $this->load->theme('home_layout', $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */