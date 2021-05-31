<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of WSCURL
 *
 * @author Larry
 */
class WSCURL {
    public static $ssl_curl = true;

	/**
	 * Se encarga de ejecutar el servicio a través de CURL 
	 * y obtener los resultados en formato Array
	 */
	public static function parseCURL($url, $body, $extracto = false)
	{
		//header('Content-Type: application/xml');

		//echo "<pre>";print_r($body);exit;
		$headers = array(
			'Content-Type: application/xml; charset="utf-8"', 
			'Content-Length: '. strlen($body), 
			//'Accept: application/xml', 
			'Cache-Control: no-cache', 
			'Pragma: no-cache'
		);

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
		// Valido si el WS se debe consumir con cURL + SSL
		if (self::$ssl_curl) {
			// Desactivo la validación de SSL en cURL
			// Disable CURLOPT_SSL_VERIFYHOST and CURLOPT_SSL_VERIFYPEER by setting them to false.
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}

		$result = curl_exec($ch);
		//echo $result."\n\n---\n\n";exit;
		if (curl_error($ch)) {
			$result = curl_error($ch);
		}else{
			if (!$extracto)
				$result = strtolower(utf8_encode($result));

			$xml = @simplexml_load_string($result);
			//echo "<pre>";print_r($xml)."\n\n---\n\n";exit;
		}
		
		curl_close($ch);
		// echo $result."\n\n---\n\n";
		
		$result_array = array();
		if (isset($xml)) {
			// print_r($xml);exit;
			
			$json_string = json_encode($xml);
			// self::saveLog($json_string);			// Datos a guardar en el Log de las respuestas del Servicio
			$result_array = json_decode($json_string, TRUE);
		}
		// print_r($result_array);		// Array para procesar los datos en el aplicativo
		return $result_array;
	}
}
