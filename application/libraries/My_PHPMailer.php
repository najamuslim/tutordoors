<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class My_PHPMailer {
    public function __construct() {
		require 'PHPMailer/src/Exception.php';
		require 'PHPMailer/src/PHPMailer.php';
		require 'PHPMailer/src/SMTP.php';
    }
}