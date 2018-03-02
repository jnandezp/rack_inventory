<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('rack_model');
		$this->load->model('rack_item_model');
		$this->load->helper('url');
	}

	/**
	 * @return [type]
	 */
	public function index()
	{
		$this->load->helper('form');
		// Obtenemos el listado de racks
		$rackList = $this->rack_model->get_all();
		// Pasamos el listado y el navbar
		$data = [
			'navbar' => 'partials/_navbar',
			'rackList' => $rackList
		];
		
		$this->load->view('template', $data);
	}

	public function addRack()
	{
		$niveles = $this->input->post('niveles');
		$ubicaciones = $this->input->post('ubicaciones');
		// Si no tiene niveles o ubicaciones no realizamos ninguna accion
		if($niveles == 0 || $ubicaciones == 0){
			redirect('/inventory/index');
		}

		$lastId = $this->rack_model->get_last_id();
		// Si no existen registros inicializamos con el primero
		// Solo es por la comodidad de darle un numbre al rack para visualizar su informacion
		if(!$lastId){
			$lastId = 1;
		}else{
			$lastId += 1;
		}
		


		$dataRack = array(
			'name' => 'Rack ' . $lastId,
			'niveles' => $niveles,
			'ubicaciones' => $ubicaciones
		);
		// Guardamos el rack 
		$this->db->insert('rack', $dataRack);
		
		// Obtenemos el id con el que se inserto 
		$insert_id = $this->db->insert_id();


		// Generamos un array de letras(ubicaciones) 
		$letter = range('A', 'Z');

		// Iteramos los niveles
		for ($i=0; $i < $niveles; $i++) { 
			for ($j=0; $j < $ubicaciones; $j++) { 
				$dataItemRack = [
					'rack_id' => $insert_id,
					'nivel' => $i+1,
					'ubicacion' => $letter[$j],
					'value' => 0.00
				];	
				// Guardamos el elemento
				$this->db->insert('rack_item', $dataItemRack);
			}
		}


		redirect('/inventory/index');
	}

	public function detail($rackId)
	{
		// Generamos un array de letras(ubicaciones) 
		$letter = range('A', 'Z');
		
		// Obtenemos la informacion del rack 
		$dataRack = $this->rack_model->get_detail($rackId);

		// Obtenemos la informacion de lso elementos del rack
		$detail = $this->rack_item_model->get_details($rackId);

		$data = [
			'navbar' => 'partials/_navbar',
			'dataRack' => $dataRack,
			'letter' => $letter,
			'detail' => $detail
		];

		$this->load->view('rack_item', $data);
	}

	public function updateItemRack()
	{
		// Recuperamos los valores
		$idItem = $this->input->post('idItem');
		$newValue = $this->input->post('newValue');

		// Actualizamos el elemento y guardamos el estado
		$estado = $this->rack_item_model->update_item($idItem, $newValue);


		if($estado){
			$response = [
				'msg' => 'El elemento fue actualizado correctamente.',
				'status' => 'success',
				'code' => 200 
			];
		}else{
			$response = [
				'msg' => 'No se pudo realizar la modificación.',
				'status' => 'success',
				'code' => 400
			];
		}

		header('Content-Type: application/json');
		// Regresamos un json con las respuesta
		echo json_encode($response);
		die();
	}

	public function delete($rackId)
	{
		// Eliminamos el rack completo
		$this->db->delete('rack', array('id' => $rackId));
		redirect('/inventory/index');
	}
}
