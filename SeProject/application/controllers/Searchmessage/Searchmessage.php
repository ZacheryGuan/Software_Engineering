<?php

/**
 * Created by PhpStorm.
 * User: BoYiLi
 * Date: 17/5/14
 * Time: 上午08:28
 */
class Searchmessage extends CI_Controller
{
    /**
     * Home constructor.
     */
	
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
		//$this->load->library('session');
		$this->load->library('encryption');
        $this->load->model("Searchmessage/searchmessage_model");
    }
	
	public function search()
	{
		//$username = $_SESSION['username'];
		$data['status'] = "Not Null";
		$data['username'] = $username;
		$data['records'] = $this->searchmessage_model->get_message($username);
		$this->load->view("Searchmessage/tables-datatable.html", $data);
	}
	
	/* initial status, no message return */
	public function index($username)
    {
 		//$this->session->sess_destroy();
		//session_id();
		//session_start($crypt_username);
		//$_SESSION['uid']=1;
		//echo 'sid:', session_id(), 'un:', $_SESSION['username'];
		//$_SESSION['username'] = 'value';
		
		//echo $_GET['loggin_un'];
		//return;
		
		//$username = $this->encryption->decrypt($crypt_username);
		$stat = $this->searchmessage_model->judge_timestamp($username, session_id());
		$data['username'] = "$username";
		$data['status'] = "Not Null";
		$data['records'] = $this->searchmessage_model->get_message($username);
		
		if($stat == "true") {
			$this->load->view("Searchmessage/tables-datatable.html", $data);
		} else if($stat == "false") {
			$this->searchmessage_model->delete_timestamp($username);
			echo "<script>alert('超时！请重新验证！')</script>"; 
			$this->load->view("Authentication/Authentication/auth_start", $data);
		}
    }
	
	public function log_out($username) 
	{
		$this->searchmessage_model->delete_timestamp($username);
		$this->load->view("Authentication/Authentication/auth_start", $data);
	}

}
