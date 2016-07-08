<?php 
class validations_blog extends CI_Model {
 
    function __construct()
    {
        parent::__construct();
    }
	public function validate_blog_data($blogarray)
	{
		if($blogarray["blog_title"]=="")
		{
			$this->session->set_flashdata("errormsg","Please enter blog title");
			$err=1;		
		}
		else if($blogarray["posted_by"]=="")
		{
			$this->session->set_flashdata("errormsg","Please enter posted by");
			$err=1;	
		}
		else if($blogarray["blog_content"]=="")
		{
			$this->session->set_flashdata("errormsg","Please enter blog content");
			$err=1;	
		}
		else if($blogarray["blog_images"]=="")
		{
			$this->session->set_flashdata("errormsg","Please enter blog image");
			$err=1;		
		}
		else if(isset($blogarray["blog_images"]) && $blogarray["blog_images"]!="" && !in_array($this->common->get_extension($blogarray["blog_images"]),$this->config->item("allowedimages")))
		{
			$this->session->set_flashdata("errormsg","File type is not valid");
			$err=1;	
		}
		
		if($err==1)
		{
			return false;	
		}	
		else
		{
			return true;	
		}
			
	}
}
?>