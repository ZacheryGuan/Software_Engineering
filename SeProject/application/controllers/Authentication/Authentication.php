<?php

/**
 * Created by PhpStorm.
 * User: BoYiLi
 * Date: 17/5/12
 * Time: 上午09:26
 */
class Authentication extends CI_Controller
{
    /**
     * Home constructor.
     */
	
	/* calculate the try times */
	private $auth_cnt = 0;
	private $last_usrName = "";
	
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
		$this->load->library('session');
		$this->load->library('xmlrpc');
        $this->load->model("Authentication/authentication_model");
    }
	
	public function sess_part()
	{
		$query = $this->db->get('ci_sessions');  // Produces: SELECT * FROM mytable
		foreach ($query->result() as $row)
		{
			echo $row->id;
			echo "<br />";
		}
	}
	
	public function auth_start()
	{
		$data['auth_cnt'] = 0;
		$data['locked'] = "false";
		$this->load->view("authentication/authentication.html", $data);
	}
	
	public function authenticate()
	{
		$resp = array();

        $username = $this->input->post("username");
		$password = $this->input->post('password');
		/* echo "controller:$tmp";
        $password = $this->encryption->encrypt($tmp);
		echo "controller_encrypt:$password"; */
		$resp['submitted_data'] = $_POST; 

        $auth_status = 'invalid';

        if (($status=$this->authentication_model->validate($username, $password))=="true") {
            $auth_status = 'success';
        }
		else if($status=="locked"){
			$data['locked'] = "true";
			$data['auth_cnt'] = 5;
			$this->load->view("authentication/authentication.html", $data);
			return;
		}
		else if($status=="none") {
			$data['locked'] = "false";
			$data['auth_cnt'] = -1;
			$this->load->view("authentication/authentication.html", $data);
			return;
		}
		
        $resp['auth_status'] = $auth_status;

        if ($auth_status == 'success') {
            //$username_crypted = $this->encryption->encrypt($username);
			//$_SESSION['username']=$username;
			//$sessionID=session_id();
			//redirect("/Searchmessage/Searchmessage/index/$sessionID");
			
			//echo 'ctrl_sdi: ',session_id(),'<br />';
			//echo $_SESSION['username'];
			//$sid=session_id();
			//redirect("/Searchmessage/Searchmessage/index/$username");
			$this->authentication_model->insert_timestamp($username, strtotime("now"), session_id());
			redirect("/Searchmessage/Searchmessage/index/$username");
        }
		else
		{
			$times = $this->authentication_model->get_error_times($username);
			if ( $times >= 4) {
				$data['locked']="true";
				$times += 1;
				$this->authentication_model->lock_account($username);
			} else {
				$data['locked']="false";
				$times += 1;
				$this->authentication_model->update_error_times($username, $times);
			}
			$data['auth_cnt'] = $times;
			
			$this->load->view("authentication/authentication.html", $data);
		}
		
		/* record last username */
		$this->last_usrName = $username;
		//echo json_encode($resp);
	}

	
	public function log_out()
	{
		$this->load->view("Mainwindow/index.html");
	}

    public function auth_failure()
	{
		$this->load->view("authentication/authentication.html");
	}
}
