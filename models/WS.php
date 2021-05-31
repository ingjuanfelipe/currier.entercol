<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use app\models\WSCURL;
/**
 * Description of WS
 *
 * @author Larry
 */
class WS {
    const ADMISION_ENVIOS = 'https://conectados.avianca.com/conecta2/seam/resource/restv1/admision_envios';
    const PRINTER_ETIQUETA='https://conectados.avianca.com/conecta2/seam/resource/restv1/admision_envios/etiquetas';
	/**
	 * En esta función haces el consumo del servicio y obtienes los resultados
	 * Acá debes tener la lógica para parsear la respuesta, validar los datos y
	 * organizar la información que necesitas antes de enviarlos al index
	 */
	public static function getAdmisionEnvios($xml)
	{
		$respuesta = WSCURL::parseCURL(self::ADMISION_ENVIOS, $xml);
		// Acá va la lógica de validaciones, etc, antes de enviar al index
		return $respuesta;
               
	}
        public static function getPrinter_etiqueta($xml)
	{
		$respuesta = WSCURL::parseCURL(self::PRINTER_ETIQUETA, $xml);
		// Acá va la lógica de validaciones, etc, antes de enviar al index
		return $respuesta;
               
	}
}
