<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * @@@@ LIST OF FUNCTIONS IN THIS HELPER
 * 
 * 1)debug
 * 2)timestamp_to_human
 * 3)clean
 * 4)get_full_name
 * 5)get_profile_pic
 * 6)limit_string
 * 7)get user categories for singup process
 */


/*
 * used to print output
 */
if (!function_exists('debug')) {

    function debug($arr) {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

}
/*
 * used to convert unix timestamp to human readabledate
 *  
 */
if (!function_exists('timestamp_to_human')) {

    function timestamp_to_human($timestamp, $date_format = null) {
        return !empty($date_format) ? date($date_format, $timestamp) : date('Y-m-d H:i:s',$timestamp );
    }

}
/*
 * This function cleans input and protects from sql injection
 */
if (!function_exists('clean')) {

    function clean($arr) {
        $arr = strip_tags($arr);
        $ci = & get_instance();
        $ci->load->database();
        //debug($arr);
        return trim(mysqli_real_escape_string($ci->db->conn_id, $arr));
    }

}
/*
 * Get full username of person
 */
if (!function_exists('get_full_name')) {

    function get_full_name($userid) {
        $ci = & get_instance();
        $ci->db->select("first_name,last_name");
        $ci->db->from('users');
        $where = array("id" => $userid);
        $ci->db->where($where);
        $query = $ci->db->get();
        //echo $ci->db->last_query();die;
        $resultset = $query->row_array();
//        debug($Cresultset);
        return $resultset['first_name'].' '.$resultset['last_name'];
    }

}
/*
 * Get profile picture of person
 */
if (!function_exists('get_profile_pic')) {

    function get_profile_pic($userid) {
        $ci = & get_instance();
        $ci->db->select("phototitle");
        $ci->db->from('user_photos');
        $where = array("isactiveprofilephoto" => 1);
        $ci->db->where($where);
        $query = $ci->db->get();
        //echo $ci->db->last_query();die;
        $resultset = $query->row_array();
//        debug($Cresultset);
        return $resultset['phototitle'];
    }

}

if (!function_exists('limit_string')) {

    function limit_string($string, $limit) {
        return strlen($string) >$limit ? substr($string,0,$limit).'..' :$string;
    }

}


if (!function_exists('get_all_user_categories')) {
	function get_all_user_categories() {
			$ci = & get_instance();
			$ci->db->select("*");
			$ci->db->from('user_categories');
			$where = array("status" => 1);
			$ci->db->where($where);
			//$ci->db->order_by('name','ASC');
			$query = $ci->db->get();
			//echo $ci->db->last_query();die;
			$resultset = $query->result_array();
			//debug($Cresultset);
			return $resultset;
	}
}


/* End of file custom_helper.php */
/* Location: ./system/helpers/custom_helper.php */