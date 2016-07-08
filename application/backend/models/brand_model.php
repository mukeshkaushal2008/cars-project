<?php

class brand_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getbrandData($searchdata = array(), $id = NULL, $employeer_id = NULL) {

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
        $this->db->from('brand');
        $this->db->where(array('brand.status <>' => 4));
        ///// if super admin or admin is fetching the brand under  employee account ////
        $this->db->order_by("brand.id", "desc");
        if (count($searchdata) != 0) {
            foreach ($searchdata as $key => $val) {
                if (isset($searcharray[$key]) && $searchdata[$key] != "") {
                    if (array_key_exists($key, $searcharray)) {
                        $where = array($searcharray[$key] => $val);
                        $this->db->where($where);
                    }
                }
            }
        }
        if (isset($searchdata["search"]) && $searchdata["search"] != "search" && $searchdata["search"] != "") {
            $this->db->like('brand.brand_name', trim($searchdata["search"]));
        }

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

    public function getmodelData($searchdata = array(), $id = NULL, $employeer_id = NULL) {

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

        $this->db->select("*,brand.brand_name");
        $this->db->from('models');
        $this->db->where(array('models.status <>' => 4));
        $this->db->join("brand",'brand.id = models.brand_id');
        ///// if super admin or admin is fetching the brand under  employee account ////
        $this->db->order_by("models.id", "desc");
        if (count($searchdata) != 0) {
            foreach ($searchdata as $key => $val) {
                if (isset($searcharray[$key]) && $searchdata[$key] != "") {
                    if (array_key_exists($key, $searcharray)) {
                        $where = array($searcharray[$key] => $val);
                        $this->db->where($where);
                    }
                }
            }
        }
        if (isset($searchdata["search"]) && $searchdata["search"] != "search" && $searchdata["search"] != "") {
            $this->db->like('models.model_name', trim($searchdata["search"]));
        }

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

    public function view_brand($id) {
        $this->db->select("*");
        $this->db->from('brand');
        $this->db->where(array("id" => $id, "status" => "1"));
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->row_array();
        return $resultset;
    }
public function view_model($id) {
        $this->db->select("*");
        $this->db->from('models');
        $this->db->where(array("id" => $id, "status" => "1"));
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->row_array();
        return $resultset;
    }
    public function view_brand_admin($id) {
        $this->db->select("*");
        $this->db->from('brand');
        $this->db->where(array("id" => $id));
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->row_array();
        return $resultset;
    }
    public function view_model_admin($id) {
        $this->db->select("*");
        $this->db->from('models');
        $this->db->where(array("id" => $id));
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->row_array();
        return $resultset;
    }
    public function getModels($id) {
        $this->db->select("*");
        $this->db->from('models');
        $this->db->where(array("brand_id" => $id));
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->result_array();
        return $resultset;
    }

    public function get_featured_brand() {
        $this->db->select("*");
        $this->db->from('brand');
        $this->db->where(array("status" => "1"));
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->result_array();
        return $resultset;
    }

    public function add_edit_brand($array) {
        if ($array["id"] == "") {
            if ($this->db->insert("brand", $array)) {
                return true;
            } else {
                return false;
            }
        } else {
            $id = $array['id'];
            unset($array['id']);
            $this->db->where("id", $id);
            return $this->db->update("brand", $array);
        }
    }
    
    public function add_edit_model($array){
        if ($array["id"] == "") {
            if ($this->db->insert("models", $array)) {
                return true;
            } else {
                return false;
            }
        } else {
            $id = $array['id'];
            unset($array['id']);
            $this->db->where("id", $id);
            return $this->db->update("models", $array);
        }
    }
    
    public function delete_brand($id) {
        $array['status'] = '4';
        $this->db->where("id", $id);
        return $this->db->update("brand", $array);
    }

    public function enable_disable_brand($tagid, $status) {
        $data = array("status" => $status);
        $this->db->where("id", $tagid);
        $this->db->update("brand", $data);
    }
    
    public function delete_model($id) {
        $array['status'] = '4';
        $this->db->where("id", $id);
        return $this->db->update("models", $array);
    }

    public function enable_disable_model($tagid, $status) {
        $data = array("status" => $status);
        $this->db->where("id", $tagid);
        $this->db->update("models", $data);
    }

}

?>