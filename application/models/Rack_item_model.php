<?php
class Rack_item_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_all()
	{
		$query = $this->db->get('rack_item');
		return $query->result();
	}

	public function get_details($id)
	{
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get_where('rack_item',["rack_id" => $id]);

		return $query->result();	
	}

	public function update_item($idItem, $newValue)
	{
		$this->db->set('value', $newValue);
		$this->db->where('id', $idItem);
		$this->db->update('rack_item');

		return ($this->db->affected_rows() != 1) ? false : true;
	}
}