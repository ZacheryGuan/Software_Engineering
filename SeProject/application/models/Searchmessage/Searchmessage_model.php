<?php
class Searchmessage_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_message($username)
	{
		$sql = "SELECT * FROM Trade WHERE buyer=? or seller=?";
		$query = $this->db->query($sql, array($username, $username));
        return $query->result_array();
	}
	public function delete_timestamp($id)
	{
		$sql = "DELETE * FROM UserAuth WHERE id=?";
		$query = $this->db->query($sql, array($id));
	}
	public function judge_timestamp($id, $sid)
	{
		$sql = "SELECT * FROM UserAuth WHERE id=? or sid=?";
		$query = $this->db->query($sql, array($id, $sid));
		$row = $query->row();
		if(isset($row)) {
			return "true";
		} else {
			return "false";
		}
	}
}