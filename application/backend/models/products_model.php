<?php

ob_start();

class products_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function enable_disable_featured($tagid, $status) {
        $data = array("is_featured" => $status);
        $this->db->where("id", $tagid);
        $this->db->update("products", $data);
    }

    public function bid_now($array) {
        return $this->db->insert("bids", $array);
    }

    public function get_whole_product_data() {

        ob_start();
        header("Content-Type: text/event-stream");
        header("Cache-Control: no-cache");
        header("Access-Control-Allow-Origin: *");

        $lastEventId = !empty($_SERVER["HTTP_LAST_EVENT_ID"]) ? $_SERVER["HTTP_LAST_EVENT_ID"] : "";
        if (isset($lastEventId) && !empty($lastEventId) && is_numeric($lastEventId)) {
            $lastEventId = intval($lastEventId);
            $lastEventId++;
        } else {
            $lastEventId = 0;
        }
        echo ":" . str_repeat(" ", 2048) . "\n"; // 2 kB padding for IE
        echo "retry: 1000\n";
        while (true) {
            $reply["get_featured_product"] = $this->get_featured_product();
            //$reply["gethomeproductdata"] = $this->gethomeproductdata();
            $this->send_msg($lastEventId, $reply);
            $lastEventId++;
        }
    }

    public function get_img($id) {
        $this->db->select("image");
        $this->db->from('product_images');
        $where_image = array("product_id" => $id, "status" => "1");
        $this->db->where($where_image);
        $this->db->order_by('is_default_image', 'ASC');
        $query_image = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset1 = $query_image->result_array();
        $j = 0;
        foreach ($resultset1 as $key => $val) {
            $resultset[$j] = $val["image"];
            $j++;
        }
        return $resultset;
    }

    public function send_msg($lastEventId, $result) {
        echo "id: " . $lastEventId . PHP_EOL;
        echo "data: " . json_encode($result["get_featured_product"]) . "\n\n";
        //echo "data: " . json_encode($result["gethomeproductdata"]) . "\n\n";
        //return $d;
        ob_flush();
        flush();
        sleep(1);
    }

    public function get_featured_product() {
        $result = "";
        $data = array();
        $this->db->select("*");
        $this->db->from('products');
        $where = array("products.is_featured" => 1, "products.status" => 1, "products.end_date >=" => time());
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $set = $query->result_array();

        $j = 0;
        foreach ($set as $key => $val) {
            $resultset[$j]['name'] = $val["name"];
            $resultset[$j]['end_date'] = $this->time_remaining($timeLeft = 0, $val['end_date']);
            $resultset[$j]['retail_price'] = $val["retail_price"];
            $resultset[$j]['minimum_price'] = $val["minimum_price"];
            $resultset[$j]["image"] = $this->get_img($val["id"]);
            $j++;
        }
        //debug($resultset);die;
        if (empty($resultset)) {
            $data["response"] = "error";
            $data["message"] = "No record found";
        } else {
            $data["response"] = "success";
            $data["message"] = $resultset;
        }
        return $data;
    }

    public function last_product_bid($id) {

        $this->db->select("max(bid_price) as price");
        $this->db->from('bids');
        $where = array("bids.product_id" => $id);
        $this->db->where($where);
        $query = $this->db->get();
        $set = $query->row_array();
        return !empty($set["price"]) ? $set["price"] : "0";
    }

    public function get_homeclosed_product() {
        $result = "";
        $data = array();
        $this->db->select("*");
        $this->db->from('products');
        $where = array("products.status" => 1, "products.end_date <=" => time());
        $this->db->where($where);
        $this->db->order_by("id", "desc");
        $this->db->limit(8, 0);
        $query = $this->db->get();
        $set = $query->result_array();

        $j = 0;
        foreach ($set as $key => $val) {
            $resultset[$j]['name'] = $val["name"];
            $resultset[$j]['slug'] = $val["slug"];
            $resultset[$j]['end_date'] = 'Passed';
            $resultset[$j]['retail_price'] = $val["retail_price"];
            $resultset[$j]['minimum_price'] = $val["minimum_price"];
            $resultset[$j]['last_bid_price'] = $this->last_product_bid($val["id"]);
            $resultset[$j]["image"] = $this->get_img($val["id"]);
            $j++;
        }

        return $resultset;
    }

    public function get_closed_product() {
        $result = "";
        $data = array();
        $this->db->select("*");
        $this->db->from('products');
        $where = array("products.status" => 1, "products.end_date <=" => time());
        $this->db->where($where);
        $this->db->order_by("end_date", "desc");
        $query = $this->db->get();
        $set = $query->result_array();

        $j = 0;
        foreach ($set as $key => $val) {
            $resultset[$j]['name'] = $val["name"];
            $resultset[$j]['slug'] = $val["slug"];
            $resultset[$j]['end_date'] = 'Passed';
            $resultset[$j]['retail_price'] = $val["retail_price"];
            $resultset[$j]['minimum_price'] = $val["minimum_price"];
            $resultset[$j]['last_bid_price'] = $this->last_product_bid($val["id"]);
            $resultset[$j]["image"] = $this->get_img($val["id"]);
            $j++;
        }

        return $resultset;
    }

    public function gethomeproductdata() {
        $result = "";
        $data = array();
        $this->db->select("*");
        $this->db->from('products');
        $this->db->join('product_images', 'product_images.product_id = products.id', 'left');
        $where = array("products.status" => 1, "products.end_date >=" => time());
        $this->db->where($where);
        $this->db->group_by('products.id');
        $this->db->order_by('products.id', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->result_array();
        if (empty($resultset)) {
            $data["response"] = "error";
            $data["message"] = "No record found";
        } else {
            $data["response"] = "success";
            $i = 0;
            foreach ($resultset as $k => $fetch) {
                $data["message"][$i]['name'] = $fetch["name"];
                $data["message"][$i]['end_date'] = $this->time_remaining($timeLeft = 0, $fetch['end_date']);
                $data["message"][$i]['retail_price'] = !empty($fetch["retail_price"]) ? $fetch["retail_price"] : "N/A";
                $data["message"][$i]['minimum_price'] = !empty($fetch["minimum_price"]) ? $fetch["minimum_price"] : "N/A";
                $data["message"][$i]['image'] = !empty($fetch["image"]) ? $fetch["image"] : "N/A";
                $i++;
            }
        }
        return $data;
    }

    public function live_auctions() {
        $result = "";
        $data = array();
        $this->db->select("*");
        $this->db->from('products');
        $this->db->join('product_images', 'product_images.product_id = products.id', 'left');
        $where = array("products.status" => 1, "products.start_date <" => time(), "products.end_date >" => time());
        $this->db->where($where);
        $this->db->group_by('products.id');
        $this->db->order_by('products.id', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->result_array();
        if (empty($resultset)) {
            $data["response"] = "error";
            $data["message"] = "No record found";
        } else {
            $data["response"] = "success";
            $i = 0;
            foreach ($resultset as $k => $fetch) {
                $data["message"][$i]['name'] = $fetch["name"];
                $data["message"][$i]['end_date'] = $this->time_remaining($timeLeft = 0, $fetch['end_date']);
                $data["message"][$i]['retail_price'] = !empty($fetch["retail_price"]) ? $fetch["retail_price"] : "N/A";
                $data["message"][$i]['minimum_price'] = !empty($fetch["minimum_price"]) ? $fetch["minimum_price"] : "N/A";
                $data["message"][$i]['image'] = !empty($fetch["image"]) ? $fetch["image"] : "N/A";
                $i++;
            }
        }
        return $data;
    }

    public function time_remaining($timeLeft = 0, $endTime = null) {

        if ($endTime != null)
            $timeLeft = $endTime - time();
        if ($timeLeft > 0) {
            $days = floor($timeLeft / 86400);
            $timeLeft = $timeLeft - $days * 86400;
            $hrs = floor($timeLeft / 3600);
            $timeLeft = $timeLeft - $hrs * 3600;
            $mins = floor($timeLeft / 60);
            $secs = $timeLeft - $mins * 60;
        } else {
            return '0d 0h 0m 0s';
        }
        return $days . 'd ' . $hrs . 'h ' . $mins . 'm' . $secs . 's';
    }

    public function getproductData($searchdata = array(), $id = NULL, $employeer_id = NULL) {

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

        $this->db->select("products.*,products.id as products_id");
        $this->db->from('products');
        $this->db->where(array('products.status <>' => 4));
        ///// if super admin or admin is fetching the product under  employee account ////
        $this->db->order_by("products.id", "desc");
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
            $this->db->like('products.name', trim($searchdata["search"]));
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

    public function SelectproductDataByid($id) {
        $this->db->select("products.*,products.id as product_id");
        $this->db->from('products');
        $this->db->where(array("id" => $id, "status <> " => "4"));
        $query = $this->db->get();
        $resultset = $query->row_array();
        return $resultset;
    }

    public function SelectproductDataByemail($email) {
        $this->db->select("products.*,products.id as product_id");
        $this->db->from('products');
        $this->db->where(array("email" => $email, "status <> " => "4"));
        $query = $this->db->get();
        $resultset = $query->row_array();
        return $resultset;
    }

    public function view_product($id) {
        $this->db->select("*");
        $this->db->from('products');
        $this->db->where(array("id" => $id));
        $query = $this->db->get();
        $resultset = $query->row_array();
        return $resultset;
    }

    public function chk_bids_available() {
        $this->db->select("total_bids");
        $this->db->from('users');
        $this->db->where(array("id" => $this->session->userdata("userid")));
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->row_array();
        return $resultset["total_bids"] ? $resultset["total_bids"] : "0";
    }

    public function add_product($array) {
        if ($this->db->insert("products", $array)) {
            return true;
        } else {
            return false;
        }
    }

    public function add_edit_product_images($array) {
        $this->db->insert("product_images", $array);
    }

    public function edit_product($array) {
        $id = $array['id'];
        unset($array['id']);
        $this->db->where("id", $id);
        return $this->db->update("products", $array);
    }

    public function reset_counter($array) {
        $id = $array['id'];
        unset($array['id']);
        $this->db->where("id", $id);
        return $this->db->update("products", $array);
    }

    public function deduct_bids() {
        $this->db->select("total_bids");
        $this->db->from('users');
        $this->db->where(array("id" => $this->session->userdata("userid")));
        $query = $this->db->get();
        $resultset = $query->row_array();
        $bids = $resultset["total_bids"] - 1;
        $array = array("total_bids" => $bids);
        $this->db->where("id", $this->session->userdata("userid"));
        return $this->db->update("users", $array);
    }

    public function getproductdatabyid($slug) {

        $this->db->select("*");
        $this->db->from('products');
        $where = array("products.id" => $slug, "products.status <>" => "4");
        $this->db->where($where);
        $query = $this->db->get();
        $resultset = $query->row_array();

        $this->db->select("image");
        $this->db->from('product_images');
        $where_image = array("product_id" => $resultset['id'], "status" => "1");
        $this->db->where($where_image);
        $this->db->order_by('is_default_image', 'ASC');
        $query_image = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset1 = $query_image->result_array();

        $j = 0;
        foreach ($resultset1 as $key => $val) {
            $resultset["images"][$j] = $val["image"];
            $j++;
        }
        return $resultset;
    }

    public function getproductdatabyslug($slug) {

        $this->db->select("*");
        $this->db->from('products');
        $where = array("products.slug" => $slug, "products.status" => "1");
        $this->db->where($where);
        $query = $this->db->get();
        $resultset = $query->row_array();

        $this->db->select("image");
        $this->db->from('product_images');
        $where_image = array("product_id" => $resultset['id'], "status" => "1");
        $this->db->where($where_image);
        $this->db->order_by('is_default_image', 'ASC');
        $query_image = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset1 = $query_image->result_array();

        $j = 0;
        foreach ($resultset1 as $key => $val) {
            $resultset["images"][$j] = $val["image"];
            $j++;
        }
        return $resultset;
    }

    public function delete_product_images($datarr, $newarr) {
        $this->db->select("image");
        $this->db->from("product_images");
        $this->db->where(array("status" => 1, "product_id" => $datarr));
        $result = $this->db->get();
        $result = $result->result_array();

        foreach ($result as $keys => $vals) {
            //echo $vals['image_name'];
            if (in_array($vals['image'], $newarr)) {
                
            } else {
                unlink('../product_images/' . $vals['image']);
                unlink('../product_images/thumbnail/' . $vals['image']);
            }
        }
        $this->db->where(array("product_id" => $datarr));
        return $this->db->delete("product_images");
    }

    public function delete_product($id) {
        $array['status'] = '4';
        $this->db->where("id", $id);
        return $this->db->update("products", $array);
    }

    public function enable_disable_product($tagid, $status) {
        $data = array("status" => $status);
        $this->db->where("id", $tagid);
        $this->db->update("products", $data);
    }

    public function getFrontEndProductsData() {

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

        $this->db->select("products.id as products_id ,products.*,product_images.image,product_images.is_default_image,
        category.category_name,models.model_name,brand.brand_name");

        $this->db->from('products');

        $this->db->join("category", "category.id = products.category_id");
        $this->db->join("models", "models.id = products.model_id");
        $this->db->join("brand", "brand.id = models.brand_id");
        $this->db->join("product_images", "product_images.product_id = products.id");

        $this->db->where(array('products.status <>' => 4));
        ///// if super admin or admin is fetching the product under  employee account ////

        $this->db->group_by("products.id");
        $this->db->order_by("product_images.is_default_image ", "asc");
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
            $this->db->like('products.name', trim($searchdata["search"]));
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

    public function getFrontEndProductDataBySlug($slug) {

        $this->db->select("products.id as products_id ,products.*,
        category.category_name,models.model_name,brand.brand_name");

        $this->db->from('products');

        $this->db->join("category", "category.id = products.category_id");
        $this->db->join("models", "models.id = products.model_id");
        $this->db->join("brand", "brand.id = models.brand_id");


        $this->db->where(array('products.status' => 1, 'products.slug' => $slug));
        //$this->db->group_by("products.id");


        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset = $query->row_array();


        $this->db->select("image");
        $this->db->from('product_images');
        $where_image = array("product_id" => $resultset['id'], "status" => "1");
        $this->db->where($where_image);
        $this->db->order_by('is_default_image', 'ASC');
        $query_image = $this->db->get();
        //echo $this->db->last_query();die;
        $resultset1 = $query_image->result_array();

        $j = 0;
        foreach ($resultset1 as $key => $val) {
            $resultset["images"][$j] = $val["image"];
            $j++;
        }

        return $resultset;
    }

    public function getFrontEndProductsDataByCategory($cat_id,$pdt_id) {
        $this->db->select("products.id as products_id ,products.*,product_images.image,product_images.is_default_image,
        category.category_name,models.model_name,brand.brand_name");

        $this->db->from('products');

        $this->db->join("category", "category.id = products.category_id");
        $this->db->join("models", "models.id = products.model_id");
        $this->db->join("brand", "brand.id = models.brand_id");
        $this->db->join("product_images", "product_images.product_id = products.id");

        $this->db->where(array('products.category_id' => $cat_id,'products.id <>' => $pdt_id,'products.status' => 1));
        ///// if super admin or admin is fetching the product under  employee account ////

        $this->db->group_by("products.id");
        $this->db->order_by("product_images.is_default_image ", "asc");
        
        $query = $this->db->get();
        ///echo $this->db->last_query();die;
        $resultset = $query->result_array();
        return $resultset;
    }

}

?>