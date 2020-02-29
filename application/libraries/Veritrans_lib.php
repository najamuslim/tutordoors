<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Veritrans_lib {

	/**
   	* Your merchant's server key
   	* @static
   	*/
	public static $serverKey;
	
	/**
   	* true for production
   	* false for sandbox mode
   	* @static
   	*/
	public static $isProduction = false;

   	/**
   	* Default options for every request
   	* @static
   	*/
  	public static $curlOptions = array();	

  	const SANDBOX_BASE_URL = 'https://api.sandbox.veritrans.co.id/v2';
  	const PRODUCTION_BASE_URL = 'https://api.veritrans.co.id/v2';

    public function config($params)
    {
        Veritrans_lib::$serverKey = $params['server_key'];
        Veritrans_lib::$isProduction = $params['production'];
    }

    /**
    * @return string Veritrans API URL, depends on $isProduction
    */
  	public static function getBaseUrl()
  	{
    	return Veritrans_lib::$isProduction ?
        	Veritrans_lib::PRODUCTION_BASE_URL : Veritrans_lib::SANDBOX_BASE_URL;
  	}

	/**
	 * Send GET request
	 * @param string  $url
	 * @param string  $server_key
	 * @param mixed[] $data_hash
	 */
	public static function get($url, $server_key, $data_hash)
	{
	  return self::remoteCall($url, $server_key, $data_hash, false);
	}

	/**
	 * Send POST request
	 * @param string  $url
	 * @param string  $server_key
	 * @param mixed[] $data_hash
	 */
	public static function post($url, $server_key, $data_hash)
	{
	    return self::remoteCall($url, $server_key, $data_hash, true);
	}

  	/**
	 * Actually send request to API server
	 * @param string  $url
	 * @param string  $server_key
	 * @param mixed[] $data_hash
	 * @param bool    $post
	 */
    public static function remoteCall($url, $server_key, $data_hash, $post = true)
    {	
    
	    $ch = curl_init();

	    $curl_options = array(
	      CURLOPT_URL => $url,
	      CURLOPT_HTTPHEADER => array(
	        'Content-Type: application/json',
	        'Accept: application/json',
	        'Authorization: Basic ' . base64_encode($server_key . ':')
	      ),
	      CURLOPT_RETURNTRANSFER => 1,
	      CURLOPT_CAINFO => dirname(__FILE__) . "/veritrans/cacert.pem"
	    );

	    // merging with Veritrans_Config::$curlOptions
	    if (count(Veritrans_lib::$curlOptions)) {
	      // We need to combine headers manually, because it's array and it will no be merged
	      if (Veritrans_lib::$curlOptions[CURLOPT_HTTPHEADER]) {
	        $mergedHeders = array_merge($curl_options[CURLOPT_HTTPHEADER], Veritrans_lib::$curlOptions[CURLOPT_HTTPHEADER]);
	        $headerOptions = array( CURLOPT_HTTPHEADER => $mergedHeders );
	      } else {
	        $mergedHeders = array();
	      }

	      $curl_options = array_replace_recursive($curl_options, Veritrans_lib::$curlOptions, $headerOptions);
	    }

	    if ($post) {
	      $curl_options[CURLOPT_POST] = 1;

	      if ($data_hash) {
	        $body = json_encode($data_hash);
	        $curl_options[CURLOPT_POSTFIELDS] = $body;
	      } else {
	        $curl_options[CURLOPT_POSTFIELDS] = '';
	      }
	    }

	    curl_setopt_array($ch, $curl_options);

	    $result = curl_exec($ch);
	    // curl_close($ch);
	   
	    if ($result === FALSE) {
	      throw new Exception('CURL Error: ' . curl_error($ch), curl_errno($ch));
	    }
	    else {
	      $result_array = json_decode($result);
	      if (!in_array($result_array->status_code, array(200, 201, 202, 407))) {
	        $message = 'Veritrans Error (' . $result_array->status_code . '): '
	            . $result_array->status_message;
	        throw new Exception($message, $result_array->status_code);
	      }
	      else {
	        return $result_array;
	      }
	    }
    }

    public static function vtweb_charge($payloads)
    {	

    	$result = Veritrans_lib::post(
        Veritrans_lib::getBaseUrl() . '/charge',
        Veritrans_lib::$serverKey,
        $payloads);

        return $result->redirect_url;


    	//$url = Veritrans_lib::getBaseUrl();
    	//return Veritrans_lib::$serverKey.Veritrans_lib::getBaseUrl() . '/charge' ;
    }

    public static function vtdirect_charge($payloads)
    {	

    	$result = Veritrans_lib::post(
        Veritrans_lib::getBaseUrl() . '/charge',
        Veritrans_lib::$serverKey,
        $payloads);

        return $result;


    	//$url = Veritrans_lib::getBaseUrl();
    	//return Veritrans_lib::$serverKey.Veritrans_lib::getBaseUrl() . '/charge' ;
    }
	
    /**
   	* Retrieve transaction status
   	* @param string $id Order ID or transaction ID
    * @return mixed[]
    */
	public static function status($id)
 	{
    	return Veritrans_lib::get(
        	Veritrans_lib::getBaseUrl() . '/' . $id . '/status',
        	Veritrans_lib::$serverKey,
        	false);
  	}

  	/**
   	* Appove challenge transaction
   	* @param string $id Order ID or transaction ID
   	* @return string
   	*/
  	public static function approve($id)
  	{
    	return Veritrans_lib::post(
        	Veritrans_lib::getBaseUrl() . '/' . $id . '/approve',
        	Veritrans_lib::$serverKey,
        	false)->status_code;
  	}

  	/**
   	* Cancel transaction before it's setteled
   	* @param string $id Order ID or transaction ID
   	* @return string
   	*/
  	public static function cancel($id)
  	{
    	return Veritrans_lib::post(
        	Veritrans_lib::getBaseUrl() . '/' . $id . '/cancel',
        	Veritrans_lib::$serverKey,
        	false)->status_code;
  	}

   /**
    * Expire transaction before it's setteled
    * @param string $id Order ID or transaction ID
    * @return mixed[]
    */
  	public static function expire($id)
  	{
    	return Veritrans_lib::post(
        	Veritrans_lib::getBaseUrl() . '/' . $id . '/expire',
        	Veritrans_lib::$serverKey,
        	false);
  	}

}
