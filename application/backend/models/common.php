<?php

class common extends CI_Model {

    function __construct() {

        parent::__construct();

        $http = "";

        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {

            $http = "http://";
        } else {

            $http = "https://";
        }

        $prevurl = array("prevurl" => base_url());

        $this->session->set_userdata($prevurl);

        $this->session->set_userdata("currenturl", base_url());
    }

    public function get_extension($file_name) {

        $ext = explode('.', $file_name);

        $ext = array_pop($ext);

        return strtolower($ext);
    }

    function create_unique_slug($string, $table, $field = 'slug', $key = NULL, $value = NULL) {

        $t = & get_instance();

        $slug = url_title($string);

        $slug = strtolower($slug);

        $i = 0;

        $params = array();

        $params[$field] = $slug;



        if ($key)
            $params["$key !="] = $value;



        while ($t->db->where($params)->get($table)->num_rows()) {

            if (!preg_match('/-{1}[0-9]+$/', $slug))
                $slug .= '-' . ++$i;
            else
                $slug = preg_replace('/[0-9]+$/', ++$i, $slug);



            $params [$field] = $slug;
        }

        return $slug;
    }

    public function get_video_id_from_url($channel) {

        $start = strpos($channel, "?v=") + 3;

        $length = strlen($channel);

        $channel = substr($channel, $start, $length);

        $channeldata = explode("&", $channel);

        $channeldata = $channeldata[0];

        return $channeldata;
    }

    public function parse_vimeo($videoLink) {



        if (preg_match("/https?:\/\/(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/", $videoLink, $id)) {

            $videoId = $id[3];
        }

        //print_r($id); // the array

        return ($videoId); // 11111111
        //die;
    }

    public function get_extensions($file_name = NULL) {

        $ext1 = explode('.', $file_name);

        $ext = array_pop($ext1);

        //print_r($this->config->item("allowedimages"));die;

        if (!in_array($ext, $this->config->item("allowedimages"))) {

            $this->session->set_flashdata("errormsg", "Wrong file format only jpg,png,gif allowded");
        } else {



            return strtolower($ext);
        }
    }

    public function get_extensions_attachement($file_name = NULL) {

        $ext1 = explode('.', $file_name);

        $ext = array_pop($ext1);

        //print_r($this->config->item("allowedimages"));die;

        if (!in_array($ext, $this->config->item("alloweddocs"))) {

            $this->session->set_flashdata("errormsg", "Wrong file format only doc, docx allowded");
        } else {



            return strtolower($ext);
        }
    }

/// for random genrator text	

    public function generate_transaction_number($digits = 6) {

        srand((double) microtime() * 10000000);

        $input = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

        $random_generator = "";

        for ($i = 1; $i <= $digits; $i++) {

            if (rand(1, 2) == 1) {

                $rand_index = array_rand($input);

                $random_generator .=$input[$rand_index];
            } else {

                $random_generator .=rand(1, 9);
            }
        }

        return $random_generator;
    }

    public function convert_date($arr) {

        $from_data = explode('/', $arr);

        $from = strtotime($from_data[1] . "-" . $from_data[0] . "-" . $from_data[2] . " " . "00:00:00");

        return $from;
    }

    function validate_email($email = NULL) {

        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    //to check login status

    public function check_authentication() {



        $controllername = $this->router->class;

        $methodname = $this->router->method;



        if (($controllername == "login") && $methodname != "logout") {

            $username = $this->session->userdata("username");

            if (isset($username) && $username != "") {

                redirect(base_url() . "dashboard");
            }
        }



        if ($controllername != "login") {

            // echo $this->config->item("usertype");die;

            if ($this->config->item("usertype") == "admin") {

                $this->db->select("username");

                $this->db->from("admin");

                $query = $this->db->get();

                $resultset = $query->row_array();

                //debug($resultset);
                //echo $this->session->userdata("username");
                //	echo $this->db->last_query();die;

                if ($resultset["username"] != $this->session->userdata("username")) {

                    $this->session->set_flashdata("errormsg", "Please login to access admin panel first");

                    redirect(base_url() . "login/");
                }
            }
        }
    }

    public function checkpasswordvalidity($arr) {

        $this->db->select("*");

        $this->db->from("admin");

        $this->db->where("username", $this->session->userdata("username"));

        $query = $this->db->get();

        //echo $this->db->last_query();die;

        $result = $query->row_array();



        if ($this->validateHash($arr["oldpassword"], $result["password"])) {

            return false;
        } else {

            return true;
        }
    }

    //update user profile data

    public function update_profile($arr = NULL) {

        //2736f2f2cb760b84488b342f26e6210e:xl

        $newarr["password"] = $this->salt_password(array("password" => $arr["newpassword"]));

        if (isset($arr["username"]) && $arr["username"] != "") {

            $newarr["username"] = $arr["username"];
        }

        return $this->db->update("admin", $newarr);
    }

    //remove parameter from url

    public function removeUrl($parametername = NULL, $querystring = NULL) {

        $newquerystring = "";

        $querystring = explode("&", $querystring);



        foreach ($querystring as $key => $val) {

            $newval = explode("=", $val);

            if ($newval[0] != "") {

                if ($newval[0] != $parametername) {

                    $newquerystring.="&" . $newval[0] . "=" . $newval[1];
                }
            }
        }



        $newquerystring = substr($newquerystring, 1, strlen($newquerystring));



        return $newquerystring;
    }

    public function addUrl($parametername = NULL, $parametervalue = NULL, $querystring = NULL) {



        //echo $parametername."=".$parametervalue;		

        $querystring = explode("&", $querystring);

        $newquerystring = "";

        $i = 0;

        if (count($querystring) != 0 && $querystring[0] != "") {

            foreach ($querystring as $key => $val) {

                $valnew = explode("=", $val);

                if ($valnew[0] != $parametername) {

                    $newquerystring.="&" . $valnew[0] . "=" . $valnew[1];
                } else {

                    $newquerystring.="&" . $parametername . "=" . $parametervalue;

                    $i = 1;
                }
            }
        }

        if ($i == 0) {

            $newquerystring.="&" . $parametername . "=" . $parametervalue;
        }

        return $newquerystring = substr($newquerystring, 1, strlen($newquerystring));
    }

    //to check user login status 	

    public function is_logged_in() {



        $is_logged_in = $this->session->userdata('is_logged_in');

        if ($is_logged_in != true) {

            $this->session->set_flashdata("errormsg", "Authentication failed. You need to login to access this page");

            redirect(base_url());

            //return false;
            // echo 'You need to login to access this page';
            //die();
        } else {
            
        }
    }

    //login user and set session

    public function authenticateUserLogin($loginarray) {

        $this->db->select("*");

        $this->db->from("users");

        $this->db->where(array("email" => $loginarray["email"]));

        $result = $this->db->get();

        //echo $this->db->last_query();

        $countrows = $result->num_rows();

        $result = $result->row_array();



        $response = array();



        if (!empty($result)) {

            if ($this->validateHash($loginarray["password"], $result["password"])) {

                $response['status'] = 1;

                $response['message'] = 'Login success';

                $response['data'] = $result;
            } else {

                $response['status'] = 0;

                $response['message'] = 'Invalid email or password';

                $response['data'] = '';
            }
        } else {//email not found
            $response['status'] = 0;

            $response['message'] = 'Email does not exist';

            $response['data'] = '';
        }

        return $response;
    }

//for user login



    public function login_check_user_login($data) {

        $login["email"] = trim($data['email']);

        $login["password"] = trim($data['password']);

        $this->session->set_flashdata("tempdata", $login);

        if ($this->common->authenticateUserLogin($login)) {

            redirect(base_url() . "user/dashboard");
        } else {

            redirect(base_url() . "home/login");
        }
    }

    public function get_age($birth_date) {

        return floor((time() - strtotime($birth_date)) / 31556926);
    }

    //make encrypted. password

    public function salt_password($arr = NULL) {

        //print_r($arr["password"]);die;

        $salt_key = $this->common->random_generator(2);

        $pas = md5($salt_key . $arr["password"]);

        $column = ':';

        return $pas . $column . $salt_key;
    }

    public function validateHash($password = NULL, $hash = NULL) {

        $hashArr = explode(':', $hash);

        if (md5($hashArr[1] . $password) === $hashArr[0]) {

            //echo "matched";die;

            return true;
        } else {

            //echo "not matched";die;

            return false;
        }
    }

    public function random_generator($digits = NULL) {

        // function starts

        srand((double) microtime() * 10000000);

        $input = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

        $random_generator = "";

        // Initialize the string to store random numbers

        for ($i = 1; $i <= $digits; $i++) {

            // Loop the number of times of required digits

            if (rand(1, 2) == 1) {

                // to decide the digit should be numeric or alphabet
                // Add one random alphabet

                $rand_index = array_rand($input);

                $random_generator .=$input[$rand_index];

                // One char is added
            } else {

                // Add one numeric digit between 1 and 9

                $random_generator .=rand(1, 9);

                // one number is added
            }

            // end of if else
        }

        // end of for loop

        return $random_generator;
    }

///===================================================================================================/

    public function get_time_stamp($date = NULL) {

        $date = explode("-", $date);

        $date = $date[2] . "-" . $date[1] . "-" . $date[0]; //d-m-y

        $time = strtotime($date);

        return $time;
    }

    public function get_start_time($date_time) {

        $posted_date = explode("/", $date_time);

        $result = mktime(0, 0, 0, $posted_date[1], $posted_date[0], $posted_date[2]);

        return $result;
    }

    public function get_end_time($date_time) {

        $posted_date = explode("/", $date_time);

        $result = mktime(23, 59, 59, $posted_date[1], $posted_date[0], $posted_date[2]);

        return $result;
    }

//for get user id	

    public function getuser_id($email) {

        //echo $email;die;

        $this->db->select("*");

        $this->db->from("volunteer");

        $this->db->where(array("email" => $email, "status =" => 1));

        $query = $this->db->get();

        // echo $this->db->last_query();
        //  echo var_dump($this->db->queries);

        $countrows = $query->num_rows();

        //echo $countrows;

        if ($countrows == 0) {



            $results = $query->row_array();

            if ($results["status"] == 0) {

                $arr["id"] = $results["id"];

                $arr["name"] = $results["name"];

                $arr["email"] = $results["email"];

                $arr["password"] = $results["password"];

                return $arr;
            } else {

                $this->session->set_flashdata("errormsg", "Your account is currently inactive. Please contact admin.");

                return false;
            }
        } else {

            $result = $query->row_array();

            if ($result["status"] == "1") {

                $arr["id"] = $result["id"];

                // $arr["user_name"]=$result["firstname"]." ".$result["lastname"];

                $arr["email"] = $result["email"];

                $arr["name"] = $result["name"];

                $arr["username"] = $result["username"];

                $arr["password"] = $result["password"];

                return $arr;
            }

            /* else{

              $this->session->set_flashdata("errormsg","Your account is currently inactive. Please contact admin.");

              return false;

              } */
        }
    }

    //get user data	

    public function getuser_id_new($email) {

        //echo $email;die;

        $this->db->select("*");

        $this->db->from("users");

        $this->db->where(array("email" => $email, "status" => 1));

        $query = $this->db->get();

        $resultset = $query->num_rows();

        $result = $query->row_array();



        if ($resultset == 0) {

            $this->db->select("*");

            $this->db->from("organisations");

            $this->db->where(array("email" => $email, "status" => 1));

            $query = $this->db->get();

            $resultset = $query->num_rows();

            $result = $query->row_array();



            if ($resultset == 0) {

                return false;
            } else {

                return $result;
            }
        } else {

            return $result;
        }
    }

// for get data by id

    public function get_data_passing_id($table, $id) {

        $this->db->select("*");

        $this->db->from("$table");

        $this->db->where(array("status" => 1, "archive <>" => "1", 'id' => $id));

        $this->db->order_by("name asc");

        $result = $this->db->get();

        // $this->db->last_query(); die;

        $c = $result->result_array();

        //echo print_r($c); 

        return $c;
    }

//for content pages data like login, signup, security

    public function getcontentpagedata($arr) {

        //$resultset=$this->db->select("*")->from("contents")->get();

        $this->db->select("*");

        $this->db->from("content_pages");

        $this->db->where(array("page_name" => $arr));

        $query = $this->db->get();

        //$this->db->last_query();

        return $resultset = $query->row_array();
    }

//for header phone number and email id

    public function header_content_data() {

        $sql = "select contact_email, contact_number from content_pages where id=4";

        $query = $this->db->query($sql);

        $resultset = $query->row_array();



        return $resultset;
    }

//for update logged in time

    public function last_login($table, $id) {

        $this->db->where("id", $id);

        $noti['last_login'] = time();

        $result = $this->db->update("$table", $noti);

        //echo $this->db->last_query(); die;

        return $result;
    }

    //show time in ago

    public function convert_time_days($time) {



        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();

        $difference = $now - $time;

        $tense = "ago";



        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {

            $difference /= $lengths[$j];
        }



        $difference = round($difference);

        if ($difference != 1) {

            $periods[$j].= "s";
        }

        return "$difference $periods[$j] ago ";
    }

    public function validate_forgot_email_exist($arr = NULL) {



        $this->db->select('email');

        $this->db->from('users');

        if ($arr["id"] == "") {

            $this->db->where(array("email" => $arr["email"], "status <>" => "4"));
        } else {

            $this->db->where(array("email" => $arr["email"], "status <>" => "4", "id <>" => $arr["id"]));
        }

        $query = $this->db->get();

        //echo	$this->db->last_query();die;

        $resultset = $query->num_rows();



        if ($resultset == 0) {

            return false;
        } else {

            return true;
        }
    }

    public function get_mktime_time_stamp($date = NULL) {

        $data = explode("-", $date);

        $open_time = mktime(23, 59, 59, $data[1], $data[2], $data[0]);

        return $open_time;
    }

    public function get_banners() {



        $this->db->select('*');

        $this->db->from('banners');

        $this->db->where(array("status" => "1", "archive <>" => "1"));

        $query = $this->db->get();

        //echo	$this->db->last_query();die;

        $resultset = $query->result_array();

        return $resultset;
    }

    public function get_all_products() {

        $this->db->select("*");

        $this->db->from("products");

        //$this->db->join("product_images","product_images.product_id = products.id","left outer");	

        $this->db->where(array("products.status" => 1));

        $this->db->order_by("products.id desc");

        $result = $this->db->get();

        //echo $this->db->last_query(); die;

        $c = $result->result_array();

        return $c;
    }

    public function get_default_image($id) {

        $this->db->select("*");

        $this->db->from("product_images");

        //$this->db->join("product_images","product_images.product_id = products.id","left outer");	

        $this->db->where(array("product_images.product_id" => $id, "product_images.status" => 1, "is_default_image" => "1"));

        $result = $this->db->get();

        //echo $this->db->last_query(); die;

        $c = $result->row_array();

        return $c;
    }

    public function get_all_countries() {

        $this->db->select("*");

        $this->db->from("country");

        //$this->db->join("product_images","product_images.product_id = products.id","left outer");	

        $this->db->where(array("id <>" => ""));

        $result = $this->db->get();

        //echo $this->db->last_query(); die;

        $c = $result->result_array();

        return $c;
    }

    public function get_country_name($id) {

        $this->db->select("*");

        $this->db->from("country");

        //$this->db->join("product_images","product_images.product_id = products.id","left outer");	

        $this->db->where(array("id" => $id));

        $result = $this->db->get();

        //echo $this->db->last_query(); die;

        $c = $result->row_array();

        return $c;
    }

    public function get_table_data($field = null, $table = null, $type = null, $where = null, $group = null, $order = null, $limit = null) {


        $this->db->select($field);

        $this->db->from($table);

        $this->db->where($where);
        if ($group <> "") {
            $this->db->group_by($group);
        }
        if ($order <> "") {
            $this->db->order_by($order);
        }
        if ($limit <> "") {
            $this->db->limit($limit);
        }
        $result = $this->db->get();

        //echo $this->db->last_query();die;

        if ($type == "" || $type == "row") {

            $c = $result->row_array();
        } else {

            $c = $result->result_array();
        }

        return $c;
    }

    public function get_my_bids() {

        $this->db->select("total_bids");
        $this->db->from("users");
        $this->db->where(array("id" => $this->session->userdata("userid"), "users.status" => 1));
        $result = $this->db->get();
        $c = $result->row_array();
        return !empty($c["total_bids"]) ? $c["total_bids"] : "";
    }

}

if (FRONTPATH != "frontend") {

    $common = new common;

    $common->check_authentication();
}