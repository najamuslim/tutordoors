<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('generate_random_string'))
{
    function generate_random_string($type, $length)
    {
        if($type=="letter")
			$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		else if($type=="number")
			$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
    }   
}

function set_image_thumb_name($user_info){
	$add_dot = '';
	if(substr($user_info->file_extension, 0, 1) <> ".")
		$add_dot = ".";
	$image_thumb = str_replace($user_info->file_extension, "", $user_info->file_name).'_thumb'.$add_dot.$user_info->file_extension;

	return $image_thumb;
}

function get_month_string($number){
	$month_array = array(
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember'
		);

	return $month_array[$number];
}

function download_file($path, $name){
	if(is_file($path)) {
		$ci =& get_instance();
	    // required for IE
	    if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

	    // get the file mime type using the file extension
	    $ci->load->helper('file');

	    $mime = get_mime_by_extension($path);

	    // Build the headers to push out the file properly.
	    header('Pragma: public');     // required
	    header('Expires: 0');         // no cache
	    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	    header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
	    header('Cache-Control: private',false);
	    header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
	    header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
	    header('Content-Transfer-Encoding: binary');
	    header('Content-Length: '.filesize($path)); // provide file size
	    header('Connection: close');
	    readfile($path); // push it out
	    exit();
	}
}