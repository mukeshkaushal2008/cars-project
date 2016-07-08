<?php

class home_partners_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_home_partners() {
        $this->db->select("*");
        $this->db->from('home_partners');
        $where = array("status" => 1);
        $this->db->where($where);

        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->result_array();
        return $resultset;
    }

    public function add_edit_home_partners($arr) {

        if ($arr["id"] == "") {
            return $this->db->insert("home_partners", $arr);
            //echo $this->db->last_query();
        } else {
            $this->db->where("id", $arr["id"]);
            return $this->db->update("home_partners", $arr);
        }
    }

    public function gethome_partnersData($searchdata) {
        $recordperpage = "";
        $startlimit = "";
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
        $this->db->select("*");
        $this->db->from("home_partners");
        foreach ($searchdata as $key => $val) {
            if (isset($searcharray[$key]) && $searchdata[$key] != "") {
                if (array_key_exists($key, $searcharray)) {
                    $where = array($searcharray[$key] => $val);
                    $this->db->where($where);
                }
            }
        }

        if (isset($searchdata["search"]) && $searchdata["search"] != "search" && $searchdata["search"] != "") {
            $this->db->like('title', trim($searchdata["search"]));
        }


        $where = array('status <> ' => '4');
        $this->db->where($where);
        $this->db->order_by("id DESC");


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

    public function enable_disable_home_partners($id, $status) {
        //echo $id;
        //echo $status;
        $this->db->where("id", $id);
        $arr = array("status" => $status);
        return $this->db->update("home_partners", $arr);
        //return $this->db->last_query();
    }

    public function delete_home_partners($newsid) {

        $this->db->select("image");
        $this->db->from("home_partners");
        $this->db->where("id", $newsid);
        $query = $this->db->get();
        $images = $query->row_array();
        unlink('../content_images/' . $images['image']);

        $where = array("id" => $newsid);
        $array = array("status" => 4);
        $this->db->where($where);
        $this->db->update("home_partners", $array);
    }

    public function view_home_partners($id) {

        $this->db->select("*");
        $this->db->from('home_partners');
        $where = array("id" => $id);
        $this->db->where($where);
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        $resultset = $query->row_array();
        return $resultset;
    }

    public function get_home_partners_byid($id) {
        //echo $id;
        $this->db->select("name");
        $this->db->from('home_partners');
        $where = array("id" => $id, "status <> " => 1);
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result_array();
    }

}

?>