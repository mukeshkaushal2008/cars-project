<?php

class blog_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*     * ******************************************************Blog function starts************************************************** */

    public function getBlogData($searchdata = array()) {
        $searcharray = array("status" => "status");

        if (!isset($searchdata["page"]) || $searchdata["page"] == "") {
            $searchdata["page"] = 0;
        }
        if (!isset($searchdata["countdata"])) {
            if (isset($searchdata["per_page"]) && $searchdata["per_page"] != "") {
                $recordperpage = $searchdata["per_page"];
            } else {
                $recordperpage = 1;
            }
            if (isset($searchdata["page"]) && $searchdata["page"] != "") {
                $startlimit = $searchdata["page"];
            } else {
                $startlimit = 0;
            }
        }

        $this->db->select("*,blogs.id as blogid");
        $this->db->from("blogs");
        if (isset($searchdata["search"]) && $searchdata["search"] != "" && $searchdata["search"] != "search") {
            $this->db->like("blogs.blog_title", $searchdata["search"]);
        }
        foreach ($searchdata as $key => $val) {
            if (isset($searcharray[$key]) && $searchdata[$key] != "") {
                if (array_key_exists($key, $searcharray)) {
                    $where = array($searcharray[$key] => $val);
                    $this->db->where($where);
                }
            }
        }
		if($searchdata["access"] == "front"){
        	$where = array("blogs.status" => "1");
		}
		else{
			$where = array("blogs.status <>" => "4");
		}
        $this->db->where($where);
        $this->db->order_by("blogs.id desc");
        	
        if (isset($searchdata["per_page"]) && $searchdata["per_page"] != "") {
            if (isset($recordperpage) && $recordperpage != "" && ($startlimit != "" || $startlimit == 0)) {
                $this->db->limit($recordperpage, $startlimit);
            }
        }
        $query = $this->db->get();
		//echo $this->db->last_query();die;
        $resultset = $query->result_array();
      	//debug($resultset);die;
        return $resultset;
    }

    public function add_edit_blog($blogarray) {
        if ($blogarray["id"] == "") {
            $blogarray["date_posted"] = time();
            $blogarray["last_modified"] = time();
            return $this->db->insert("blogs", $blogarray);
        } else {
            if ($_FILES["userfile"]["name"] != '') {
                $this->db->select("*");
                $this->db->from("blogs");
                $this->db->where("id", $blogarray["id"]);
                $query = $this->db->get();
                $Images = $query->row_array();
                $Images['blog_images'];
                unlink('../blogimages/' . $Images['blog_images']);
            }
            $blogarray["last_modified"] = time();
            $this->db->where("id", $blogarray["id"]);
            return $this->db->update("blogs", $blogarray);
        }
    }

    public function add_comment($arr) {
        return $this->db->insert("blog_comments", $arr);
    }

    public function get_all_comments($blogid) {
        $this->db->select("*");
        $this->db->from('blog_comments');
        $where = array("blog_comments.blog_id" => $blogid, "blog_comments.status" => 1);
        $this->db->where($where);
        $this->db->order_by("id desc");
        $this->db->limit(10, 0);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->result_array();
        return $resultset;
    }

    public function get_comments_count($blogid) {
        $this->db->select("*");
        $this->db->from('blog_comments');
        $where = array("blog_comments.blog_id" => $blogid, "blog_comments.status" => 1);
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->result_array();
        return count($resultset);
    }

    public function getIndividualBlog($blogid, $field_to_query = null) {
        $this->db->select("*,blogs.id as blogid");
        $this->db->from('blogs');
        if (!empty($field_to_query)) {
            $where = array("blogs.$field_to_query" => $blogid);
        } else {
            $where = array("blogs.id" => $blogid);
        }

        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->row_array();
        return $resultset;
    }

    public function get_recent_blog() {
        $this->db->select("*");
        $this->db->from('blogs');
        $where = array("blogs.status <> " => 4);
        $this->db->where($where);
        $this->db->order_by("id desc");
        $this->db->limit(3, 0);
        $query = $this->db->get();
        $resultset = $query->result_array();
        return $resultset;
    }

    public function enable_disable_blog($blogid, $status) {
        $this->db->where("id", $blogid);
        $array = array("status" => $status);
        $this->db->update("blogs", $array);
    }

    public function enable_disable_featured($blogid, $status) {
        $this->db->where("id", $blogid);
        $array = array("featured" => $status);
        $this->db->update("blogs", $array);
    }

    public function get_featured_blog() {
        $this->db->select("*");
        $this->db->from('blogs');
        $where = array("blogs.featured" => 1, "blogs.status <> " => 4);
        $this->db->where($where);
        $this->db->order_by('id', 'RANDOM');
        $this->db->limit(2, 0);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->result_array();
        return $resultset;
    }

    public function archive_blog($blogid) {
        $this->db->select("*");
        $this->db->from('blog_comments');
        $where = array("blog_id" => $blogid);
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->result_array();
        foreach ($resultset as $k => $v) {
            $where = array("id" => $v["id"]);
            $array = array("status" => 4);
            $this->db->where($where);
            $this->db->update("blog_comments", $array);
        }

        //unlink images
        $this->db->select("blog_images");
        $this->db->from("blogs");
        $this->db->where("id", $blogid);
        $query = $this->db->get();
        $images = $query->row_array();
        unlink('../blogimages/' . $images['blog_images']);

        //blog delete
        $where = array("id" => $blogid);
        $array = array("status" => 4);
        $this->db->where($where);
        $this->db->update("blogs", $array);
    }

    public function load_more($last_id, $blogid) {
        $this->db->select("*");
        $this->db->from('blog_comments');
        $where = array("blog_comments.blog_id" => $blogid, "blog_comments.id <" => $last_id);
        $this->db->where($where);
        $this->db->order_by("blog_comments.id desc");
        $this->db->limit(5, 0);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->result_array();
        return $resultset;
    }

    //=================================================Blog Comment Function Start==================================================================//	
    public function getBlogCommentData($searchdata = array()) {

        if (!isset($searchdata["page"]) || $searchdata["page"] == "") {
            $searchdata["page"] = 0;
        }
        if (!isset($searchdata["countdata"])) {
            if (isset($searchdata["per_page"]) && $searchdata["per_page"] != "") {
                $recordperpage = $searchdata["per_page"];
            } else {
                $recordperpage = 1;
            }
            if (isset($searchdata["page"]) && $searchdata["page"] != "") {
                $startlimit = $searchdata["page"];
            } else {
                $startlimit = 0;
            }
        }

        $this->db->select("blog_comments.*,blog_comments.id as blog_comments_id,blog_comments.status as blog_comments_status , blogs.id as blogid,blogs.blog_title as blog_title");
        $this->db->from("blog_comments");
        $this->db->join("blogs", "blogs.id=blog_comments.blog_id");

        if (isset($searchdata["search"]) && $searchdata["search"] != "" && $searchdata["search"] != "search") {
            $this->db->like("blog_comments.comment", urldecode($searchdata["search"]));
        }

        foreach ($searchdata as $key => $val) {
            if (isset($searcharray[$key]) && $searchdata[$key] != "") {
                if (array_key_exists($key, $searcharray)) {
                    $where = array($searcharray[$key] => $val);
                    $this->db->where($where);
                }
            }
        }

        $where = array("blog_comments.blog_id" => $searchdata["blogid"], "blog_comments.status <>" => 4);
        $this->db->where($where);
        $this->db->order_by("blog_comments.id desc");
        //$this->db->group_by("blog_comments.id DESC");		
        if (isset($searchdata["per_page"]) && $searchdata["per_page"] != "") {
            if (isset($recordperpage) && $recordperpage != "" && ($startlimit != "" || $startlimit == 0)) {
                $this->db->limit($recordperpage, $startlimit);
            }
        }

        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->result_array();
        return $resultset;
    }

    public function enable_disable_blog_comment($blogcommentid, $status) {
        $this->db->where("id", $blogcommentid);
        $array = array("status" => $status);
        $this->db->update("blog_comments", $array);
    }

    public function archive_blog_comment($blogcommentid) {
        $where = array("id" => $blogcommentid);
        $array = array("status" => 4);
        $this->db->where($where);
        $this->db->update("blog_comments", $array);
    }

    /*
     * fetches single comment data
     */

    public function getIndividualBlogComment($blogcommentid) {
        $this->db->select("blog_comments.*,blog_comments.time as btime,blogs.*,blog_comments.id as blog_comments_id");
        $this->db->from('blog_comments');
        $this->db->join("blogs", "blogs.id=blog_comments.blog_id");
        $where = array("blog_comments.id" => $blogcommentid);
        $this->db->where($where);
        $query = $this->db->get();
        $resultset = $query->row_array();
        return $resultset;
    }

    /*
     * get commemnts of blog on front end
     */

    public function get_all_comments_front($identifier,$field_to_query) {
        $this->db->select("*");
        $this->db->from('blog_comments');
        $where = array("blog_comments.$field_to_query" => $identifier, "blog_comments.status" => 1);
        $this->db->where($where);
        $this->db->order_by("id desc");
        $this->db->limit(5, 0);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->result_array();
        return $resultset;
    }

}

?>