<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function google_prelogin($user_level){
	$ci =& get_instance();
	// Include two files from google-php-client library in controller
	require_once APPPATH . "libraries/google-api-php-client-2.1.0/vendor/autoload.php";
	$ci->config->load('google');

	$client_id = $ci->config->item('client_id');
	$client_secret = $ci->config->item('client_secret');
	$redirect_uri = $ci->config->item('redirect_uri').'/'.$user_level;
	$simple_api_key = $ci->config->item('api_key');
	
	// Create Client Request to access Google API
	$client = new Google_Client();
	$client->setApplicationName("PHP Google OAuth Login Example");
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);
	$client->setDeveloperKey($simple_api_key);
	$client->addScope("https://www.googleapis.com/auth/userinfo.email");
	
	// Send Client Request
	$objOAuthService = new Google_Service_Oauth2($client);

	// Add Access Token to Session
	if (isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}

	// Set Access Token to make Request
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	$client->setAccessToken($_SESSION['access_token']);
	}

	// Get User Data from Google and store them in $data
	if ($client->getAccessToken()) {
		$userData = $objOAuthService->userinfo->get();
		$data['userData'] = $userData;
		$_SESSION['access_token'] = $client->getAccessToken();
	} else {
		$authUrl = $client->createAuthUrl();
		$data['google_auth_url'] = $authUrl;
	}

	return $data;
}

function google_post_login($user_level){
	$ci =& get_instance();
	// Include two files from google-php-client library in controller
	require_once APPPATH . "libraries/google-api-php-client-2.1.0/vendor/autoload.php";
	$ci->config->load('google');

	$client_id = $ci->config->item('client_id');
	$client_secret = $ci->config->item('client_secret');
	$redirect_uri = $ci->config->item('redirect_uri').'/'.$user_level;
	$simple_api_key = $ci->config->item('api_key');
	
	// Create Client Request to access Google API
	$client = new Google_Client();
	$client->setApplicationName("PHP Google OAuth Login Example");
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);
	$client->setDeveloperKey($simple_api_key);
	$client->addScope("https://www.googleapis.com/auth/userinfo.email");
	
	// Send Client Request
	$objOAuthService = new Google_Service_Oauth2($client);

	// Add Access Token to Session
	if (isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}

	// Set Access Token to make Request
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	$client->setAccessToken($_SESSION['access_token']);
	}

	// Get User Data from Google and store them in $data
	if ($client->getAccessToken()) {
		$userData = $objOAuthService->userinfo->get();
		$data['g_user_info'] = $userData;
		$_SESSION['access_token'] = $client->getAccessToken();
	} else {
		$authUrl = $client->createAuthUrl();
		$data['google_auth_url'] = $authUrl;
	}

	return $data;
}

function google_is_authenticated($user_level){
	$ci =& get_instance();
	// Include two files from google-php-client library in controller
	require_once APPPATH . "libraries/google-api-php-client-2.1.0/vendor/autoload.php";
	$ci->config->load('google');

	$client_id = $ci->config->item('client_id');
	$client_secret = $ci->config->item('client_secret');
	$redirect_uri = $ci->config->item('redirect_uri').'/'.$user_level;
	$simple_api_key = $ci->config->item('api_key');
	
	// Create Client Request to access Google API
	$client = new Google_Client();
	$client->setApplicationName("PHP Google OAuth Login Example");
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);
	$client->setDeveloperKey($simple_api_key);
	$client->addScope("https://www.googleapis.com/auth/userinfo.email");
	
	// Send Client Request
	$objOAuthService = new Google_Service_Oauth2($client);

	// Add Access Token to Session
	if (isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}

	// Set Access Token to make Request
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	$client->setAccessToken($_SESSION['access_token']);
	}

	// Get User Data from Google and store them in $data
	if ($client->getAccessToken()) {
		$user_data = $objOAuthService->userinfo->get();
		$_SESSION['access_token'] = $client->getAccessToken();
		return $user_data;
	}
	else
		return false;
}