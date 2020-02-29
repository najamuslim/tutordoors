<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function set_top_header()
{
	$style = array(
			'font' => array(
				'bold' => true,
				'name' => 'Arial',
				'size' => '11'
			),
		);

	return $style;
}

function set_alignment()
{
	$style = array(
			'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
	return $style;
}