<?php
namespace app\models;
use Yii;

/**
 * Servicio del Currier
 */
class Currier
{
	private $url;
	private $user;
	private $pass;
	private $credenciales;
	private $method = 'GET';
	
	function __construct()
	{
		$currier = Yii::$app->params['currier'];
		$this->url  = $currier['url'];
		$this->user = $currier['user'];
		$this->pass = $currier['pass'];
		$this->credenciales = [
			'cliente'		=> YII_DEBUG? '1111' : $currier['user'],
			'pwd' 			=> YII_DEBUG? 'prueba' : $currier['pass'],
			'agenciaOrigen' => YII_DEBUG? '001' : $currier['agenciaOrigen'],
			'claveExterna' 	=> YII_DEBUG? 'AAAAAAAAAAAAAA' : $currier['claveExterna'],
		];
	}

	public function call($query = [], $method = 'GET', $request_headers = [])
	{
		$query = array_merge($this->credenciales, $query);
		
		// Build URL
		if ( !empty($query) && in_array($this->method, ['GET','DELETE']) ) {
			$this->url = $this->url . "?" . http_build_query($query);
			//echo $this->url;exit;
		}

		// Configure cURL
		$curl = curl_init($this->url);
		curl_setopt($curl, CURLOPT_HEADER, TRUE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 3);
		// curl_setopt($curl, CURLOPT_SSLVERSION, 3);
		curl_setopt($curl, CURLOPT_USERAGENT, 'MIRTRANS – WEB SERVICE DE DESPACHO');
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);

		// Setup headers
		curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

		if ($this->method != 'GET' && in_array($this->method, array('POST', 'PUT'))) {
			if (is_array($query)) $query = http_build_query($query);
			curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
		}
		
		// Send request to Shopify and capture any errors
		$response = curl_exec($curl);
		$error_number = curl_errno($curl);
		$error_message = curl_error($curl);

		// Close cURL to be nice
		curl_close($curl);

		// Return an error is cURL has a problem
		if ($error_number) {
			return $error_message;
		} else {
			// No error, return Shopify's response by parsing out the body and the headers
			$response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

			// Convert headers into an array
			$headers = array();
			$header_data = explode("\n",$response[0]);
			$headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
			array_shift($header_data); // Remove status, we've already set it above
			foreach($header_data as $part) {
				$h = explode(":", $part);
				$headers[trim($h[0])] = trim($h[1]);
			}

			// Return headers and Shopify's response
			return array('headers' => $headers, 'response' => $response[1]);
		}
	}
}