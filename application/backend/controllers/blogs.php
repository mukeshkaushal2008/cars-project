<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class blogs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('validations_blog');
        $this->load->model('blog_model');
    }

    public function index() {
        $this->manage_blog();
    }

    //to bring all the data 	
    public function manage_blog() {
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
        $config['base_url'] = base_url() . "blogs/manage_blog/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["countdata"] = "yes";
		$countdata["access"] = "admin";
		 
        $config['total_rows'] = count($this->blog_model->getBlogData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);
        /* --------------------------Paging code ends--------------------------------------------------- */
        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];
		$searcharray["access"] = "admin";

        $data["resultset"] = $this->blog_model->getBlogData($searcharray);
        $data["item"] = "Blogs";
        $data["master_title"] = "Manage blogs";
        $data["master_body"] = "manage_blog";
        $this->load->theme('mainlayout', $data);
    }

    public function add_blog() {

        $data["item"] = "Blogs";
        $data["do"] = "add";
        $data["blogdata"] = $this->session->userdata("temp_blog_data");
        $data["master_title"] = "Add blogs";
        $data["master_body"] = "add_blog";
        $this->load->theme('mainlayout', $data);
        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '0') {
            header("Refresh:3;url=" . base_url() . "blogs/manage_blog");
        }
    }

    public function edit_blog() {
        $data['per_page'] = !empty($_GET['per_page']) ? $_GET['per_page'] : "";
        $data["item"] = "Blogs";
        $data["do"] = "edit";
        $blogid = $this->uri->segment(3);
        $data["blogdata"] = $this->blog_model->getIndividualBlog($blogid,'id');
        $data["master_title"] = "Edit blogs";
        $data["master_body"] = "add_blog";
        $this->load->theme('mainlayout', $data);
        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == '2') {
            header("Refresh:3;url=" . base_url() . "blogs/manage_blog/?per_page=" . $data['per_page']);
        }
    }

    public function add_blog_to_database() {
        $data['per_page'] = $this->input->post("per_page");
        $arr["id"] = $this->input->post("id");
        $arr["blog_title"] = clean($this->input->post("blog_title"));
		$arr["posted_by"] = clean($this->input->post("posted_by"));
        $arr["blog_content"] = trim($this->input->post("blog_content"));
        if($arr["id"] == ""){
			$arr["status"] = 1;
		}
		else{
		}
        $arr["blog_images"] = $_FILES["userfile"]["name"];

        //debug($data);die;

        if (empty($arr["id"])) {
            $string = $arr['blog_title'];
            $table = 'blogs';
            $field = 'slug';
            $key = 'id';
            $value = '';
            $arr['slug'] = $this->common->create_unique_slug($string, $table, $field, $key, $value);
        }
        if ($arr["blog_images"] != "") {
            $arr["blog_images"] = time() . "." . $this->common->get_extension($_FILES["userfile"]["name"]);
        } else {
            $arr["blog_images"] = $this->input->post("blog_images");
        }
        $this->session->set_userdata("temp_blog_data", strip_slashes($arr));

        if ($this->validations_blog->validate_blog_data($arr)) {
            //echo $this->blog_model->add_edit_blog($arr);die;
            if ($this->blog_model->add_edit_blog($arr)) {
                $last_id = $this->db->insert_id();
                if ($arr["blog_images"] != $this->input->post("blog_images")) {
                    $config['upload_path'] = '../blogimages/';
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $arr["blog_images"];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload()) {
                        $err = 0;
                    } else {
                        //echo $this->upload->display_errors();die;
                        $this->session->set_flashdata("successmsg", "There is some error uploading the files to server. Please contact server admin");
                    }
                }
                if ($arr["id"] == "" && $last_id != '') {
                    $err = 0; // for blog added succesfully
                    $this->session->unset_userdata("temp_blog_data");
                    $this->session->set_flashdata("successmsg", "Blog added successfully");
                    redirect(base_url() . "blogs/add_blog/" . $last_id . "/0");
                } else {
                    $this->session->unset_userdata("temp_blog_data");
                    $err = 2; // for blog updated succesfully
                    $this->session->set_flashdata("successmsg", "Blog updated successfully");
                    redirect(base_url() . "blogs/edit_blog/" . $arr["id"] . "/2/?per_page=" . $data['per_page']);
                }
            } else {
                $this->session->set_flashdata("errormsg", "There is error adding blog to data base . Please contact database admin");
                $err = 1;
            }
        } else {
            if ($arr["id"] == "") {
                $err = 1;
                redirect(base_url() . "blogs/add_blog");
            } else {
                redirect(base_url() . "blogs/edit_blog/" . $arr["id"]);
            }
        }
    }

    public function enable_disable_blog() {
        $blogid = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        $per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";

        if ($status == 0) {
            $show_status = "deactivated";
        } else {
            $show_status = "activated";
        }
        $this->session->set_flashdata("successmsg", "Blog " . $show_status . " successfully");
        $this->blog_model->enable_disable_blog($blogid, $status);

        redirect(base_url() . "blogs/manage_blog/?per_page=" . $per_page);
    }

    public function archive_blog() {
        $delid = $this->uri->segment(3);
        $per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";

        if ($delid != "") {
            $this->blog_model->archive_blog($delid);
            $this->session->set_flashdata("successmsg", "Blog archived successfully");
            redirect(base_url() . "blogs/manage_blog/?per_page=" . $per_page);
        } else {
            $data = $this->input->post("chk");
            if (!isset($_REQUEST["chk"]) && count($_REQUEST["chk"]) == 0) {
                $this->session->set_flashdata("errormsg", "No blog selected");
                redirect(base_url() . "blogs/manage_blog/?per_page=" . $per_page);
            }
            foreach ($data as $key => $val) {
                $this->blog_model->archive_blog($val);
            }

            $this->session->set_flashdata("successmsg", "Selected blogs archived successfully");
            redirect(base_url() . "blogs/manage_blog/?per_page=" . $per_page);
        }
    }

    public function view_blog() {
        $blogid = $this->uri->segment(3);
        if ($blogid == "") {
            redirect(base_url() . "invalidpage");
        } else {
            $data["resultset"] = $this->blog_model->getIndividualBlog($blogid,'id');
        }
        $data["master_title"] = "View blog";
        $data["master_body"] = "view_blog";
        $this->load->theme('mainlayout', $data);
    }

//==================================================Blog Comments Section start=============================================================================//	
    public function manage_blog_comment() {
        $data["blogid"] = $this->uri->segment(3);
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
        $bid = $data['blogid'];
        $config["per_page"] = $this->config->item("perpageitem");
        $config['base_url'] = base_url() . $this->router->class . "/manage_blog_comment/" . $bid . "/?" . $this->common->removeUrl("per_page", $_SERVER["QUERY_STRING"]);
        $countdata = array();
        $countdata = $_GET;
        $countdata["blogid"] = $data["blogid"];
        $countdata["countdata"] = "yes";

        $config['total_rows'] = count($this->blog_model->getBlogCommentData($countdata));
        $config["uri_segment"] = (isset($_GET["per_page"]) && $_GET["per_page"] != "") ? $_GET["per_page"] : "0";
        $this->pagination->initialize($config);
        /* --------------------------Paging code ends--------------------------------------------------- */
        $searcharray = array();
        $searcharray = $_GET;
        $searcharray["blogid"] = $data["blogid"];
        $searcharray["per_page"] = $config["per_page"];
        $searcharray["page"] = $config["uri_segment"];
        //debug($searcharray);die;
        $data["resultset"] = $this->blog_model->getBlogCommentData($searcharray);
        $data['page'] = $page;
        $data["item"] = "Blogs comments";
        $data["master_title"] = $this->config->item('sitename') . " | Manage blogs comment";
        $data["master_body"] = "manage_blog_comment";
        $this->load->theme('mainlayout', $data);
    }

    public function enable_disable_blog_comment() {
        $id = $this->uri->segment(3);
        $blog_comments_id = $this->uri->segment(4);
        $per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";

        $status = $this->uri->segment(5);

        if ($status == 0) {
            $show_status = "deactivated";
        } else {
            $show_status = "activated";
        }
        $this->blog_model->enable_disable_blog_comment($blog_comments_id, $status);
        $this->session->set_flashdata("successmsg", "Blog comment " . $show_status . " successfully");
        redirect(base_url() . $this->router->class . "/manage_blog_comment/" . $id . "/?per_page=" . $per_page);
    }

    public function archive_blog_comment() {
        $id = $this->uri->segment(3);
        $delid = $this->uri->segment(4);
        $per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : "";

        if ($delid != "") {
            $this->blog_model->archive_blog_comment($delid);
            $this->session->set_flashdata("successmsg", "Blog comments archived successfully");
            redirect(base_url() . $this->router->class . "/manage_blog_comment/" . $id . "/?per_page=" . $per_page);
        } else {
            $data = $this->input->post("chk");
            if (!isset($_REQUEST["chk"]) && count($_REQUEST["chk"]) == 0) {
                $this->session->set_flashdata("errormsg", "No blog comments selected");
                redirect(base_url() . $this->router->class . "/manage_blog_comment/" . $id . "/?per_page=" . $per_page);
            }
            foreach ($data as $key => $val) {
                $this->blog_model->archive_blog_comment($val);
            }

            $this->session->set_flashdata("successmsg", "Selected blog comments archived successfully");
            redirect(base_url() . $this->router->class . "/manage_blog_comment/" . $id . "/?per_page=" . $per_page);
        }
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