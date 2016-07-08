<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class blogs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('blog_model');
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
        $config['base_url'] = base_url() . "blogs/index/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";
        $countdata["access"] = 'front';
        
        $config['total_rows'] = count($this->blog_model->getBlogData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);
        /* --------------------------Paging code ends--------------------------------------------------- */
        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["per_page"] = $this->config->item("perpageitem");
        $searcharray["page"] = $config["uri_segment"];
        $searcharray["access"] = 'front';

        $data["resultset"] = $this->blog_model->getBlogData($searcharray);
        //debug($data);die;
        $data["item"] = "Blogs";
        $data["master_title"] = "Blogs";
        $data["master_body"] = "blogs";
        $this->load->theme('mainlayout', $data);
    }

    
    /*
     * gets detail of blog
     * getindividual blog ---- > first param is id or slug , second param is field to query (id or slug)
     */
    public function detail() {
        $blogslug = $this->uri->segment(2);
        if ($blogslug == "") {
            redirect(base_url() . "invalidpage");
        } else {
            $data["resultset"] = $this->blog_model->getIndividualBlog($blogslug,'slug');
           // $data["resultset"]['comments'] = $this->blog_model->get_all_comments_front($data["resultset"]['id'],'blog_id');
        }
        $data["master_title"] = "Blog Detail";
        $data["master_body"] = "detail";
   	    //debug($data);die;
        $this->load->theme('mainlayout', $data);
    }


    public function view_blog_comment() {
        $blogcommentid = $this->uri->segment(4);
        if ($blogcommentid == "") {
            redirect(base_url() . "invalidpage");
        } else {
            $data["resultset"] = $this->blog_model->getIndividualBlogComment($blogcommentid);
        }

        $data["master_title"] = $this->config->item('sitename') . " | View blog";
        $data["master_body"] = "view_blog_comment";
        $this->load->theme('mainlayout', $data);
    }

//==================================================Blog Comments Section End=============================================================================//
}

?>