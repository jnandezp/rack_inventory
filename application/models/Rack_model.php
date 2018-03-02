<?php
class Rack_model extends CI_Model {

    public function __construct()
    {
            $this->load->database();
    }

    public function get_all()
	{
		$this->db->order_by('id', 'DESC');
        $query = $this->db->get('rack');
        return $query->result();
	}

	public function get_last_id()
	{
		$this->db->select_max('id');
		// // $this->db->limit(1);
		$query = $this->db->get('rack');
		$result = $query->row_array();

		$lastId = !empty($result) && isset($result['id']) ? $result['id'] : null;

        return $lastId;
	}

	public function get_detail($id)
	{
		$query = $this->db->get_where('rack',["id" => $id]);
        return $query->row_array();	
	}
}