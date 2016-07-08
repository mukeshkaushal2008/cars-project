<?php

class user_model extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    public function edit_account($arr) {

        //debug($arr);die;

        $id = $arr["id"];

        unset($arr["id"]);

        $this->db->where('id', $id);

        return $this->db->update('users', $arr);
    }

    public function newsletter($arr) {



        $this->db->select("*");

        $this->db->from("newsletters");

        $this->db->where(array("email" => $arr["email"]));

        $query = $this->db->get(); //run query 
        //echo $this->db->last_query();die;

        $num = $query->num_rows();

        if ($num == 0) {

            if ($this->db->insert("newsletters", $arr)) {

                $resultset = '0';
            } else {

                $resultset = '2';
            }
        } else {

            $resultset = '1';
        }

        return $resultset;
    }

    public function check_email($arr) {

        $this->db->select('id');

        $this->db->from('users');

        if ($arr["id"] == "") {

            $this->db->where(array('email' => $arr['email'], "status" => "1"));
        } else {

            $this->db->where(array('email' => $arr['email'], "id <>" => $arr["id"], "status" => "1"));
        }

        $query = $this->db->get();

        //echo $this->db->last_query();die;

        $resultset = $query->num_rows();



        if ($resultset == 0) {

            return true;
        } else {

            return false;
        }
    }

    public function forgot_password($arr) {



        $this->db->select('*');

        $this->db->from('users');

        $this->db->where(array('email' => $arr["email"], 'status' => 1));

        $query = $this->db->get();

        //echo $this->db->last_query();die;

        $resultset = $query->row_array();

        return $resultset;
    }

    public function getuserData($searchdata = array()) {



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

        $this->db->from("users");







        if (isset($searchdata["filter"]) && ($searchdata["filter"] == "name")) {

            //$this->db->like('users.nationality', ($searchdata["search"]));

            $where = array("users.name" => $searchdata["search"]);

            $this->db->where($where);
        }



        //fetch record according to country
//        if (isset($searchdata["filter"]) && ($searchdata["filter"] == "nationality")) {
//            //$this->db->like('users.nationality', ($searchdata["search"]));
//            $where = array("users.nationality" => $searchdata["search"]);
//            $this->db->where($where);
//        }
//

//        //fetch record according to country
//        else if (isset($searchdata["filter"]) && ($searchdata["filter"] == "identification_type")) {
//            $where = array("users.identification_type" => $searchdata["search"]);
//            $this->db->where($where);
//        }
//

//        //fetch record according to country
//        else if (isset($searchdata["filter"]) && ($searchdata["filter"] == "email")) {
//            $this->db->like("users.email", $searchdata["search"]);
//            //	$where = array("users.email" => $searchdata["search"]);
//            //$this->db->where($where);
//        }



        foreach ($searchdata as $key => $val) {

            if (isset($searcharray[$key]) && $searchdata[$key] != "") {

                if (array_key_exists($key, $searcharray)) {

                    $where = array($searcharray[$key] => $val);

                    $this->db->where($where);
                }
            }
        }



        $where = array("users.status <>" => "4");

        $this->db->where($where);

        $this->db->order_by("id DESC");

        //$this->db->order_by("name ASC");	



        if (isset($searchdata["per_page"]) && $searchdata["per_page"] != "") {

            if (isset($recordperpage) && $recordperpage != "" && ($startlimit != "" || $startlimit == 0)) {

                $this->db->limit($recordperpage, $startlimit);
            }
        }



        $query = $this->db->get();

        //echo $this->db->last_query();die;

        $resultset = $query->result_array();

        //debug($resultset);

        return $resultset;
    }
    public function getAllUsers() {

        $this->db->select("*");

        $this->db->from('users');

        $where = array("status" => 1);

        $this->db->where($where);

        $query = $this->db->get();

        //echo $this->db->last_query();

        $resultset = $query->result_array();

        return $resultset;
    }
    public function view_user($id) {

        $this->db->select("*");

        $this->db->from('users');

        $where = array("id" => $id, "status <> " => '4');

        $this->db->where($where);

        $query = $this->db->get();

        //echo $this->db->last_query();

        $resultset = $query->row_array();

        return $resultset;
    }

    public function get_user_billing_info($id) {

        $this->db->select("*");

        $this->db->from('users_billing_shipping_address');

        $where = array("userid" => $id, "is_billing" => '1');

        $this->db->where($where);

        $query = $this->db->get();

        //echo $this->db->last_query();

        $resultset = $query->row_array();

        return $resultset;
    }

    public function get_user_shipping_info($id) {

        $this->db->select("*");

        $this->db->from('users_billing_shipping_address');

        $where = array("userid" => $id, "is_shipping" => '1');

        $this->db->where($where);

        $query = $this->db->get();

        //  echo $this->db->last_query();

        $resultset = $query->row_array();

        return $resultset;
    }

    public function enable_disable_user($id, $status) {

        $this->db->where("id", $id);

        $arr = array("status" => $status);

        return $this->db->update("users", $arr);

        //return $this->db->last_query();
    }

    public function delete_user($id) {

        $this->db->where("id", $id);

        $arr = array("status" => 4);

        return $this->db->update("users", $arr);

        //return $this->db->last_query();
    }

    public function add_billing($arr) {

        if ($arr["id"] == "") {

            return $this->db->insert('users_billing_shipping_address', $arr);
        } else {
            $id = $arr["id"];

            unset($arr["id"]);
            $this->db->where('id', $id);

            return $this->db->update('users_billing_shipping_address', $arr);
        }
    }

    public function add_shipping($arr) {

        if ($arr["id"] == "") {
            return $this->db->insert('users_billing_shipping_address', $arr);
        } else {
            $id = $arr["id"];

            unset($arr["id"]);

            $this->db->where('id', $id);

            return $this->db->update('users_billing_shipping_address', $arr);
        }
    }

    public function edit_user($arr) {

        $id = $arr["id"];

        unset($arr["id"]);

        $this->db->where('id', $id);

        return $this->db->update('users', $arr);
    }

    public function change_email($arr) {

        $id = $arr["id"];

        unset($arr["id"]);
        unset($arr["change_new_email"]);
        unset($arr["confirm_new_email"]);
        $this->db->where('id', $id);

        return $this->db->update('users', $arr);
    }

}

?>