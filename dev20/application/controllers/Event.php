<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('Event_m');
        $this->load->helper('form');
	}

	/* pages begin */
	function jobfair($event_id){
		$event_info = $this->Event_m->get_event_data(array('event_id' => $event_id));
		if($event_info==false){
			$data = array('error_no' => '204', 'error_message' => 'Event not found');
			$this->load->view('iknow/event/error_message.php', $data);
		}
		else{
			$data = array(
				'event_title' => $event_info->row()->event_name,
				'event_id' => $event_id,
				'city_id_for_user_identifier' => $event_info->row()->event_city_user_identifier,
				'religion' => array(
					'Islam' => 'Islam', 
					'Kristen' => 'Kristen', 
					'Katholik' => 'Katholik', 
					'Hindu' => 'Hindu', 
					'Budha' => 'Budha', 
					'Lainnya' => 'Lainnya'
					),
				'edu_level' => array(
					'D1' => 'D1', 
					'D2' => 'D2', 
					'D3' => 'D3', 
					'D4' => 'D4', 
					'S1' => 'S1', 
					'S2' => 'S2', 
					'S3' => 'S3'
					)
				);
			$this->load->view('iknow/event/jobfair', $data);
		}
	}

	function hexxa_jobfair($event_id){
		$event_info = $this->Event_m->get_event_data(array('event_id' => $event_id));
		if($event_info==false){
			$data = array('error_no' => '204', 'error_message' => 'Event not found');
			$this->load->view('iknow/event/hexxa_error_message.php', $data);
		}
		else{
			$data = array(
				'event_title' => $event_info->row()->event_name,
				'event_id' => $event_id,
				'city_id_for_user_identifier' => $event_info->row()->event_city_user_identifier,
				'religion' => array(
					'Islam' => 'Islam', 
					'Kristen' => 'Kristen', 
					'Katholik' => 'Katholik', 
					'Hindu' => 'Hindu', 
					'Budha' => 'Budha', 
					'Lainnya' => 'Lainnya'
					),
				'edu_level' => array(
					'D1' => 'D1', 
					'D2' => 'D2', 
					'D3' => 'D3', 
					'D4' => 'D4', 
					'S1' => 'S1', 
					'S2' => 'S2', 
					'S3' => 'S3'
					)
				);
			$this->load->view('iknow/event/hexxa_jobfair', $data);
		}
	}

	function success(){
		$this->load->view('iknow/event/jobfair_success.php');
	}

	function hexxa_success(){
		$this->load->view('iknow/event/hexxa_jobfair_success.php');
	}

	function jobfair_report(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'jobfair',
			'title_page' => 'Job Fair Event Reports'
			);

		$data['events'] = $this->Event_m->get_event_data(array('event_type' => 'job_fair'));

		$this->open_admin_page('admin/event/jobfair_report', $data);
	}

	/* pages END */

	/* functions begin */

	function jobfair_save($event_id){
		$check_exist_email = $this->User_m->check_exist_user($this->input->post('email', TRUE));
		if($check_exist_email<>false){
			$data = array('error_no' => '710', 'error_message' => 'Email sudah pernah didaftarkan.');
			$this->load->view('iknow/event/error_message.php', $data);
		}
		else{
			$this->db->trans_start();

			// 1. create data user
			$check_exist_user = true;
			$data = array(
				'email_login' => $this->input->post('email', TRUE),
				'password' => md5($this->input->post('fn', TRUE).'12345'),
				'first_name' => $this->input->post('fn', TRUE),
				'last_name' => $this->input->post('ln', TRUE),
				'user_level' => 'job_applicant'
				);
			// get user identifier for province and city
			$location_uid = $this->input->post('user_identifier', true);

			$this->load->helper('myfunction_helper');
			while ($check_exist_user==true){
				$random_number = generate_random_string('number', 5);
				$new_user_id = $this->input->post('company_id',true).$location_uid.$random_number;
				if(!$this->User_m->check_user_id_exist($new_user_id))
					$check_exist_user=false;
			}
			$data['user_id'] = $new_user_id;

			$create = $this->Common->add_to_table('users', $data);

			// 2. create user info
			$personal_data = array(
				'user_id' => $new_user_id,
				'national_card_number' => $this->input->post('ktp', TRUE),
				'sex' => $this->input->post('sex', TRUE),
				'religion' => $this->input->post('religion', TRUE),
				'birth_place' => $this->input->post('birth-place', TRUE),
				'birth_date' => $this->input->post('birth-date', TRUE),
				'address_national_card' => $this->input->post('address-ktp', TRUE),
				'address_domicile' => $this->input->post('address-domicile', TRUE),
				'phone_1' => $this->input->post('phone-1', TRUE),
				'phone_2' => $this->input->post('phone-2', TRUE),
				'email_2' => $this->input->post('email-2', TRUE)
				);

			$add_user_info = $this->Common->add_to_table('user_info_data', $personal_data);

			// 3. create education data
			foreach($this->input->post('edu_level') as $key => $value){
				$data_edu = array(
					'user_id' => $new_user_id,
					'degree' => $this->input->post('edu_level', true)[$key],
					'institution' => $this->input->post('institution', true)[$key],
					'major' => $this->input->post('major', true)[$key],
					'date_in' => $this->input->post('edu_in', true)[$key],
					'date_out' => $this->input->post('edu_out', true)[$key],
					'grade_score' => $this->input->post('graduate_score', true)[$key]
					);
				
				$add_edu = $this->Common->add_to_table('user_education_experiences', $data_edu);
			}

			// save other data into json array
			$json_data = array();

			// 4. create pengalaman bekerja
			foreach($this->input->post('company') as $key => $value){
				$json_data['work_experience'][] = array(
					'company' => $this->input->post('company', true)[$key],
					'position' => $this->input->post('position', true)[$key],
					'work_period' => $this->input->post('work_period', true)[$key],
					'reason_quit' => $this->input->post('reason_quit', true)[$key],
					'last_salary' => $this->input->post('last_salary', true)[$key]
					);
			}

			// 5. create pengalaman mengajar
			foreach($this->input->post('instansi-mengajar') as $key => $value){
				$json_data['teach_experience'][] = array(
					'instansi' => $this->input->post('instansi-mengajar', true)[$key],
					'mapel' => $this->input->post('mapel', true)[$key],
					'periode_mengajar' => $this->input->post('periode_mengajar', true)[$key],
					'fee_tatap_muka' => $this->input->post('fee_tatap_muka', true)[$key]
					);
			}

			// 6. create skill mapel
			foreach($this->input->post('skill-mapel') as $key => $value){
				$json_data['skill_mapel'][] = $value;
			}

			// 7. create area mengajar
			foreach($this->input->post('area-mengajar') as $key => $value){
				$json_data['area_mengajar'][] = $value;
			}

			// 8. create jadwal mengajar
			$json_data['jadwal_mengajar'] = array(
				'senin' => $this->input->post('jadwal-senin', true),
				'selasa' => $this->input->post('jadwal-selasa', true),
				'rabu' => $this->input->post('jadwal-rabu', true),
				'kamis' => $this->input->post('jadwal-kamis', true),
				'jumat' => $this->input->post('jadwal-jumat', true),
				'sabtu' => $this->input->post('jadwal-sabtu', true),
				'minggu' => $this->input->post('jadwal-minggu', true)
				);

			// 9. create kendaraan pribadi
			$json_data['ada_kendaraan_pribadi'] = $this->input->post('ada-kendaraan-pribadi', true);

			// 10. create terikat kerja
			$json_data['mau_terikat_kerja'] = $this->input->post('mau-terikat-kerja', true);

			// 11. selain mengajar
			$json_data['selain_mengajar'] = array($this->input->post('selain-mengajar-1', true), $this->input->post('selain-mengajar-2', true), $this->input->post('selain-mengajar-3', true));

			// create json data and save to db
			$json_data = json_encode($json_data);
			$data_applicant = array(
				'user_id' => $new_user_id,
				'event_id' => $event_id,
				'data_string' => $json_data
				);
			
			$add_applicant = $this->Common->add_to_table('jobfair_applicants', $data_applicant);

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
			    $this->db->trans_rollback();
			}
			else
			{
		        $this->db->trans_commit();

		        if($this->input->post('company_id', true)=="TD")
		        	redirect('event/success');
		        else
		        	redirect('event/hexxa_success');
		    }
		}
	}

	function search_applicants($event_id){
		// 1. get applicants
		$applicants = $this->Event_m->get_applicants(array('event_id' => $event_id));
		if($applicants==false){
			$response = array('status'=>'204', 'message'=>'No applicants found.');
		}
		else{
			$response = array('status'=>'200', 'message'=>$applicants->num_rows().' applicants found');
			$response['applicants'] = array();
			$cnt = 0;
			foreach($applicants->result() as $applicant){
				// 2. get user 
				$user_info = $this->User_m->get_user_info($applicant->user_id);
				$response['applicants'][$cnt]['user_info'] = array(
					'applicant_id' => $applicant->applicant_id,
					'user_id' => $applicant->user_id,
					'full_name' => $user_info->first_name.' '.$user_info->last_name,
					'no_ktp' => $user_info->national_card_number,
					'address_ktp' => $user_info->address_national_card,
					'address_domicile' => $user_info->address_domicile,
					'gender' => ucwords($user_info->sex),
					'religion' => $user_info->religion,
					'birth_place' => $user_info->birth_place,
					'birth_date' => date_format(new DateTime($user_info->birth_date), 'd F Y'),
					'email_primary' => $user_info->email_login,
					'email_2' => $user_info->email_2,
					'phone_1' => $user_info->phone_1,
					'phone_2' => $user_info->phone_2
					);

				// 3. get education 
				$educations = $this->User_m->get_education_history_by_userid($applicant->user_id);
				// foreach($educations->result() as $edu){
				// 	$response['applicants'][$cnt]['educations'][] = array(
				// 		'degree' => $edu->degree,
				// 		'institution' => $edu->institution,
				// 		'major' => $edu->major,
				// 		'period' => $edu->date_in.' - '.$edu->date_out,
				// 		'score' => $edu->grade_score
				// 		);
				// }
				$latest_educations = $educations->last_row();
				$response['applicants'][$cnt]['latest_education'] = array(
						'degree' => $latest_educations->degree,
						'institution' => $latest_educations->institution,
						'major' => $latest_educations->major,
						'period' => $latest_educations->date_in.' - '.$latest_educations->date_out,
						'score' => $latest_educations->grade_score
						);

				// 4. get other data in json
				// $other_data_json = $applicant->data_string;
				// $response['applicants'][$cnt]['other_data'] = json_decode($other_data_json);

				$cnt++;
			}
		}

		echo json_encode($response);
	}

	function open_applicant($applicant_id){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'jobfair',
			'title_page' => 'Applicant Data'
			);

		$applicant = $this->Event_m->get_applicants(array('applicant_id' => $applicant_id));
		$data['applicant_info'] = $applicant->result();
		
		$data['applicant_user_info'] = $this->User_m->get_user_info($applicant->row()->user_id);

		$data['educations'] = $this->User_m->get_education_history_by_userid($applicant->row()->user_id);

		$data['other_data'] = json_decode($applicant->row()->data_string);

		$this->open_admin_page('admin/event/jobfair_applicant_user', $data);
	}

	function export($what, $event_id)
	{
		//load the excel library
		$this->load->library('excel');
		$this->load->helper('excel_helper');
		// styling
		$style_top_header = set_top_header();
		$alignment = set_alignment();

		$event_info = $this->Event_m->get_event_data(array('event_id' => $event_id));

		if($what=="jobfair")
		{
			$applicants = $this->Event_m->get_applicants(array('event_id' => $event_id));
			
			$header = array(
				'Perusahaan', 'No', 'User ID', 'Nama', 'No KTP', 'Alamat KTP', 'Alamat Domisili', 'Tempat Tanggal Lahir', 'Agama', 'Jenis Kelamin', 'Email 1', 'Email 2', 'Telp/HP 1', 'Telp/HP 2', 'Pendidikan', 'Pengalaman Bekerja', 'Pengalaman Mengajar', 'Mata Pelajaran Yang Dikuasai', 'Area Mengajar', 'Jam Mengajar', 'Kendaraan Pribadi', 'Kontrak 6 Bulan', 'Minat Pekerjaan 1', 'Minat Pekerjaan 2', 'Minat Pekerjaan 3'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('Data Pelamar');

	        $this->excel->getActiveSheet()->getStyle('A1:AB1')->applyFromArray($style_top_header);
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray($alignment);

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

			$cnt = 0; // counter
			foreach($applicants->result() as $applicant)
			{
				$cnt++;

				$user_info = $this->User_m->get_user_info($applicant->user_id);
				$company = '';

				if(substr($applicant->user_id, 0, 2)=="TD")
					$company = "Tutordoors";
				else if(substr($applicant->user_id, 0, 2)=="HX")
					$company = "Hexxa";

				// pendidikan
				$education_string = '';
				$educations = $this->User_m->get_education_history_by_userid($applicant->user_id);
				foreach($educations->result() as $edu){
					$education_string .= $edu->degree." ".$edu->major.", ".$edu->institution." (".$edu->date_in." - ".$edu->date_out.") IPK ".$edu->grade_score."\n";
				}
				$education_string = rtrim($education_string, "\n");

				$other_data = json_decode($applicant->data_string);

				// pengalaman kerja
				$work_string = '';
				foreach($other_data->work_experience as $work){
					if($work->position=="")
						$work_string = "(-)";
					else {
						$work_string .= $work->position." di ".$work->company.". Masa kerja ".$work->work_period.". Gaji terakhir ".number_format(intval($work->last_salary), 0, ',', '.').". Alasan keluar: ".$work->reason_quit."\n";
					}
				}
				$work_string = rtrim($work_string, "\n");

				// pengalaman mengajar
				$teach_string = '';
				foreach($other_data->teach_experience as $teach){
					if($teach->instansi=="")
						$teach_string = "(-)";
					else {
						$teach_string .= $teach->instansi." Mapel: ".$teach->mapel.". Masa mengajar ".$teach->periode_mengajar.". Fee per tatap muka ".number_format(intval($teach->fee_tatap_muka), 0, ',', '.')."\n";
					}
				}
				$teach_string = rtrim($teach_string, "\n");

				// mata pelajaran
				$mapels = "";
				if(isset($other_data->skill_mapel)){
					foreach($other_data->skill_mapel as $mapel){
						$string_mapel = explode('-', $mapel);
						$kategori_mapel = '';
						switch($string_mapel[0]){
							case "nas":
								$kategori_mapel = 'Nasional';
								break;
							case "internas":
								$kategori_mapel = 'Internasional';
								break;
							case "or":
								$kategori_mapel = 'Olahraga';
								break;
							case "seni":
								$kategori_mapel = 'Seni';
								break;
							case "komp":
								$kategori_mapel = 'Komputer';
								break;
							case "bahasa":
								$kategori_mapel = 'Bahasa';
								break;
							case "lain":
								$kategori_mapel = 'Lainnya';
								break;
						}
						$mapel = '';
						for($i=1; $i<sizeof($string_mapel); $i++){
							$mapel .= ucwords($string_mapel[$i]).' ';
						}
						$mapel = rtrim($mapel, ' ');

						$mapels .= $kategori_mapel." - ".$mapel."\n";
					}
				}
				$mapels = rtrim($mapels, "\n");

				// area mengajar 
				$areas = "";
				if(isset($other_data->area_mengajar)){
					foreach($other_data->area_mengajar as $area){
						$string_area_mengajar = explode('-', $area);
						$kategori_area = '';
						switch($string_area_mengajar[0]){
							case "jaksel":
								$kategori_area = 'Jakarta Selatan';
								break;
							case "jakbar":
								$kategori_area = 'Jakarta Barat';
								break;
							case "jakpus":
								$kategori_area = 'Jakarta Pusat';
								break;
							case "jaktim":
								$kategori_area = 'Jakarta Timur';
								break;
							case "jakuta":
								$kategori_area = 'Jakarta Utara';
								break;
							case "jakaround":
								$kategori_area = 'Sekitar Jakarta';
								break;
						}
						$area_mengajar = '';
						for($i=1; $i<sizeof($string_area_mengajar); $i++){
							$area_mengajar .= ucwords($string_area_mengajar[$i]).' ';
						}
						$area_mengajar = rtrim($area_mengajar, ' ');

						$areas .= $kategori_area.' - '.$area_mengajar."\n";
					}
				}

				$areas = rtrim($areas, "\n");

				// waktu available
				$ngajar = "Senin ".($other_data->jadwal_mengajar->senin=="" ? "(-)" : $other_data->jadwal_mengajar->senin)."\n";
				$ngajar .= "Selasa ".($other_data->jadwal_mengajar->selasa=="" ? "(-)" : $other_data->jadwal_mengajar->selasa)."\n";
				$ngajar .= "Rabu ".($other_data->jadwal_mengajar->rabu=="" ? "(-)" : $other_data->jadwal_mengajar->rabu)."\n";
				$ngajar .= "Kamis ".($other_data->jadwal_mengajar->kamis=="" ? "(-)" : $other_data->jadwal_mengajar->kamis)."\n";
				$ngajar .= "Jum'at ".($other_data->jadwal_mengajar->jumat=="" ? "(-)" : $other_data->jadwal_mengajar->jumat)."\n";
				$ngajar .= "Sabtu ".($other_data->jadwal_mengajar->sabtu=="" ? "(-)" : $other_data->jadwal_mengajar->sabtu)."\n";
				$ngajar .= "Minggu ".($other_data->jadwal_mengajar->minggu=="" ? "(-)" : $other_data->jadwal_mengajar->minggu);

				$cells_value = array(
					$company,
					$cnt,
					$applicant->user_id,
					$user_info->first_name.' '.$user_info->last_name,
					$user_info->national_card_number,
					$user_info->address_national_card,
					$user_info->address_domicile,
					$user_info->birth_place.', '.date_format(new DateTime($user_info->birth_date), 'd F Y'),
					$user_info->religion,
					$user_info->sex=="male" ? "Laki-laki" : "Perempuan",
					$user_info->email_login,
					$user_info->email_2,
					$user_info->phone_1,
					$user_info->phone_2,
					$education_string,
					$work_string,
					$teach_string,
					$mapels,
					$areas,
					$ngajar,
					$other_data->ada_kendaraan_pribadi,
					$other_data->mau_terikat_kerja,
					);

				// kerja selain mengajar
				foreach($other_data->selain_mengajar as $selain)
					array_push($cells_value, $selain);

				$col_cnt = 0;
				foreach($cells_value as $value){
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col_cnt, $row, $value); // B2
					$this->excel->getActiveSheet()->getStyle('O'.$row)
                              ->getAlignment()
                              ->setWrapText(true);
                    $this->excel->getActiveSheet()->getStyle('P'.$row)
                              ->getAlignment()
                              ->setWrapText(true);
                    $this->excel->getActiveSheet()->getStyle('Q'.$row)
                              ->getAlignment()
                              ->setWrapText(true);
                    $this->excel->getActiveSheet()->getStyle('R'.$row)
                              ->getAlignment()
                              ->setWrapText(true);
                    $this->excel->getActiveSheet()->getStyle('S'.$row)
                              ->getAlignment()
                              ->setWrapText(true);
                    $this->excel->getActiveSheet()->getStyle('T'.$row)
                              ->getAlignment()
                              ->setWrapText(true);

                    // for phone column
                    if($col_cnt==12)
                    	$this->excel->getActiveSheet()->setCellValueExplicit('M'.$row, $value, PHPExcel_Cell_DataType::TYPE_STRING);
                    else if($col_cnt==13)
                    	$this->excel->getActiveSheet()->setCellValueExplicit('N'.$row, $value, PHPExcel_Cell_DataType::TYPE_STRING);

					$col_cnt++;
				}


				// set the user_id as a text
				// $this->excel->getActiveSheet()->setCellValueExplicit('A'.$row, $tutor->user_id, PHPExcel_Cell_DataType::TYPE_STRING);
				
				$row++;
			}

			// set auto width
			$nCols = 26; //set the number of columns

		    foreach (range(0, $nCols) as $col) {
		        $this->excel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);                
		    }
	 
	        $filename='Data Pelamar '.$event_info->row()->event_name.'.xls'; //save our workbook as this file name

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
	
	/* functions END */
}