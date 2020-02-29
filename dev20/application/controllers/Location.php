<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends MY_Controller {
	public function __construct() {
        parent::__construct();
	}
	function province(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'setup-province',
			'title_page' => 'Set Province Data',
			'title' => 'Province Data'
			);

		$data['provinces'] = $this->Location_m->get_province();

		$this->open_admin_page('admin/base_setup/province', $data);
	}

	function city(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'setup-city',
			'title_page' => 'Set City Data',
			'title' => 'City Data'
			);

		$data['provinces'] = $this->Location_m->get_province();
		$data['cities'] = $this->Location_m->get_city();

		$this->open_admin_page('admin/base_setup/city', $data);
	}

	function update_province(){
		$data = array('province_name' => $this->input->post('val', TRUE), 'user_identifier' => $this->input->post('uid', TRUE));
		$upd = $this->Common->update_data_on_table('provinces', 'province_id', $this->input->post('id', TRUE), $data);
		if($upd)
			$response = array('status'=>'200');
		else
			$response = array('status'=>'301', $upd->output);

		echo json_encode($response);
	}

	function delete_province($id){
		$del = $this->Common->delete_from_table_by_id('provinces', 'province_id', $id);
		$this->set_session_response_no_redirect('delete', $del);

		redirect('location/province');
	}

	function add_city(){
		$data = array(
			'city_name' => $this->input->post('city', TRUE),
			'province_id' => $this->input->post('province', TRUE),
			'user_identifier' => $this->input->post('uid', TRUE)
			);
		$add = $this->Common->add_to_table('cities', $data);
		$this->set_session_response_no_redirect('add', $add);

		redirect('location/city');
	}

	function update_city(){
		$data = array('city_name' => $this->input->post('val', TRUE), 'user_identifier' => $this->input->post('uid', TRUE));
		$upd = $this->Common->update_data_on_table('cities', 'city_id', $this->input->post('id', TRUE), $data);
		if($upd)
			$response = array('status'=>'200');
		else
			$response = array('status'=>'301', $upd->output);

		echo json_encode($response);
	}

	function delete_city($id){
		$del = $this->Common->delete_from_table_by_id('cities', 'city_id', $id);
		$this->set_session_response_no_redirect('delete', $del);

		redirect('location/city');
	}

	function get_provinces(){
		$provinces = $this->Location_m->get_province();
		if($provinces==false){
			$response = array('status' => '204');
		}
		else{
			foreach($provinces->result() as $province){
				$response['status'] = '200';
				$response['provinces'][] = array(
					'id' => $province->province_id,
					'name' => $province->province_name);
			}
		}

		echo json_encode($response);
	}

	function get_cities_by_province($prov_id){
		$cities = $this->Location_m->get_city(array('c.province_id' => $prov_id));
		if($cities==false){
			$response = array('status' => '204');
		}
		else{
			foreach($cities->result() as $city){
				$response['status'] = '200';
				$response['cities'][] = array(
					'id' => $city->city_id,
					'name' => $city->city_name);
			}
		}

		echo json_encode($response);
	}

	function get_city_name($id){
		$city = $this->Location_m->get_city(array('c.city_id' => $id));
		$response = array(
			'name' => $city==false ? '' : $city->row()->city_name
		);

		echo json_encode($response);
	}

	function export($what)
	{
		//load the excel library
		$this->load->library('excel');
		$this->load->helper('excel_helper');
		// styling
		$style_top_header = set_top_header();
		$alignment = set_alignment();

		if($what=="province")
		{
			$data = $this->Location_m->get_province();
			$header = array(
				'PROVINCE ID', 'PROVINCE', 'USER IDENTIFIER'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('Province Data');

	        $this->excel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($style_top_header);
			$this->excel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($alignment);

			// filling the header
			$col = 0; // starting at A1
			$row = 1;
			foreach($header as $head){
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $head);
				$col++;
			}
			// filling the content
			$col = 0; // starting at A2
			$row = 2;
			foreach($data->result() as $prov)
			{
				// set the user_id as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$row, $prov->province_id, PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $prov->province_name); // B3
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $prov->user_identifier); // C3
				
				$row++;
			}

			// set auto width
			foreach(range('A','C') as $columnID) {
			    $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
	 
	        $filename='Data Province.xls'; //save our workbook as this file name

		}
		else if($what=="city")
		{
			$data = $this->Location_m->get_city();
			$header = array(
				'PROVINCE ID', 'PROVINCE', 'CITY ID', 'CITY', 'USER IDENTIFIER'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('City Data');

	        $this->excel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($style_top_header);
			$this->excel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($alignment);

			// filling the header
			$col = 0; // starting at A1
			$row = 1;
			foreach($header as $head){
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $head);
				$col++;
			}
			// filling the content
			$col = 0; // starting at A2
			$row = 2;
			foreach($data->result() as $city)
			{
				// set the user_id as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$row, $city->province_id, PHPExcel_Cell_DataType::TYPE_STRING); //A2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $city->province_name); // B2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $city->city_id); // C2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $city->city_name); // D2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $city->city_user_identifier); // E2
				
				$row++;
			}

			// set auto width
			foreach(range('A','E') as $columnID) {
			    $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
	 
	        $filename='Data City.xls'; //save our workbook as this file name

		}

		header('Content-Type: application/vnd.ms-excel'); //mime type
	 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
}