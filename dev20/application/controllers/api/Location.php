<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Location extends REST_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('Location_m');
	}

	function province_get(){
		$this->response($this->Location_m->get_province()->result());
	}

	function city_get(){
		$id = $this->get('id');
		if ($id === NULL)
			$this->response($this->Location_m->get_city()->result());
		else
			$this->response($this->Location_m->get_city(array('c.province_id' => $id))->result());
	}

	function index_get(){
		$locations = array();
		foreach($this->Location_m->get_province()->result() as $province){
			$cities = array();
			foreach($this->Location_m->get_city(array('c.province_id' => $province->province_id))->result() as $city){
				$cities[] = array(
					'city_id' => $city->city_id,
					'city_name' => $city->city_name
				);
			}
			$locations[] = array(
				'prov_id' => $province->province_id,
				'prov_name' => $province->province_name,
				'city' => $cities
				);
		}

		$this->response($locations);
	}
}