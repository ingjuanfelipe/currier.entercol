<?php
namespace app\models;
/**
* Clase para consumir API Rest
* Las operaciones soportadas son:
* 	
* 	- POST		: Agregar
* 	- GET		: Consultar
* 	- DELETE	: Eliminar
* 	- PUT		: Actualizar
* 	- PATCH		: Actualizar por parte
* 
* Extras
* 	- autenticación de acceso básica (Basic Auth)
*  	- Conversor JSON
 *
 * @author     	Diego Valladares <dvdeveloper.com>
 * @version 	1.0
 */
class API{
public static $ssl_curl = true;
	/**
	 * autenticación de acceso básica (Basic Auth)
	 * Ejemplo Authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==
	 *
	 * @param string $URL url para acceder y obtener un token
	 * @param string $usuario usuario
	 * @param string $password clave
	 * @return JSON
	 */
	static function Authentication($URL,$usuario,$password){
            
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "$usuario:$password");
		$result = curl_exec($ch);
		curl_close($ch);  
		return $result;
	}
        public static function parseCURL($url, $extracto = false)
	{
		$body='{
LicenseType:null Organization:"" Password:"admin"
RedirectToMyselfInCaseOfError:"false" RememberMe:"false" UserName:"admin"
RedirectToMyselfInCaseOfError:"false" RememberMe:"false" 
HostID:""
}
';
                $arr = self::JSON2Array($body);
//header('Content-Type: text/html; charset=utf-8');
//echo print_r($arr);
                //$bo= json_decode($body,true);
       
                $datapost = '';
		foreach($arr as $key=>$value) {
		    $datapost .= $key . "=" . $value;
		}
          //header('Content-Type: application/xml');

		//echo "<pre>";print_r($body);exit;
		$headers = array(
			'Content-Type: application/json', 
			//'Content-Length: '. strlen($body), 
			'Accept: application/json', 
			'Cache-Control: no-cache', 
			'Pragma: no-cache',
                        'LicenseType:null',
                        'Organization:""',
                        'Password:"admin"',
                        'RedirectToMyselfInCaseOfError:"false"',
                        'RememberMe:"false"',                        
                        'UserName:"admin"',
                        'HostID:""'
		);
               /* $data = array(
                'Userame' => 'lrae617.admin',
                'Password' => 'Ncc1701##'
            );*/
            $ch = curl_init(); 
          // $payload = json_encode(array("user" => $data));
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            //set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datapost); 
		// Valido si el WS se debe consumir con cURL + SSL
		if (self::$ssl_curl) {
			// Desactivo la validación de SSL en cURL
			// Disable CURLOPT_SSL_VERIFYHOST and CURLOPT_SSL_VERIFYPEER by setting them to false.
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    print curl_error($ch);
                    return "Algo fallo";
                } else {
                   
                    curl_close($ch);
                    return 'todo ok';
                }
/* var_dump(http_response_code());
		return $result = curl_exec($ch);
               
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
                        return $resureturnlt_array;
                }else{
                    return $result;
                }
		// print_r($result_array);		// Array para procesar los datos en el aplicativo*/
		
	}
    static function JSON2Array($data){
    return  (array) json_decode(stripslashes($data));
}
        static function authen(){
            //API URL
            $url = 'http://www.example.com/api';

            //create a new cURL resource
            $ch = curl_init($url);

            //setup request to send json via POST
            $data = array(
                'username' => 'codexworld',
                'password' => '123456'
            );
            $payload = json_encode(array("user" => $data));

            //attach encoded JSON string to the POST fields
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            //set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

            //return response instead of outputting
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //execute the POST request
            $result = curl_exec($ch);

            //close cURL resource
            curl_close($ch);
        }

	/**
	 * Enviar parámetros a un servidor a través del protocolo HTTP (POST).
	 * Se utiliza para agregar datos en una API REST
	 *
	 * @param string $URL URL recurso, ejemplo: http://website.com/recurso
	 * @param string $TOKEN token de autenticación
	 * @param array $ARRAY parámetros a envíar
	 * @return JSON
	 */
	static function POST($URL,$TOKEN,$ARRAY){
		$datapost = '';
		foreach($ARRAY as $key=>$value) {
		    $datapost .= $key . "=" . $value . "&";
		}

		$headers 	= array('Authorization: Bearer ' . $TOKEN);
		$ch 		= curl_init();
		curl_setopt($ch,CURLOPT_URL,$URL);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$datapost);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
		curl_setopt($ch,CURLOPT_TIMEOUT, 20);
		curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		curl_close ($ch);
		return $response;
	}

	/**
	 * Consultar a un servidor a través del protocolo HTTP (GET).
	 * Se utiliza para consultar recursos en una API REST
	 *
	 * @param string $URL URL recurso, ejemplo: http://website.com/recurso/(id) no obligatorio
	 * @param string $TOKEN token de autenticación
	 * @return JSON
	 */
	static function GET($URL,$TOKEN){
		$headers 	= array('Authorization: Bearer ' . $TOKEN);
		$ch 		= curl_init();
		curl_setopt($ch,CURLOPT_URL,$URL);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_TIMEOUT, 20);
		curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		curl_close ($ch);
		return $response;
	}

	/**
	 * Consultar a un servidor a través del protocolo HTTP (DELETE).
	 * Se utiliza para eliminar recursos en una API REST
	 *
	 * @param string $URL URL recurso, ejemplo: http://website.com/recurso/id
	 * @param string $TOKEN token de autenticación
	 * @return JSON
	 */
	static function DELETE($URL,$TOKEN){
		$headers 	= array('Authorization: Bearer ' . $TOKEN);
		$ch 		= curl_init();

		curl_setopt($ch,CURLOPT_URL,$URL);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_TIMEOUT, 20);
		curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		curl_close ($ch);
		return $response;
	}

	/**
	 * Enviar parámetros a un servidor a través del protocolo HTTP (PUT).
	 * Se utiliza para editar un recurso en una API REST
	 *
	 * @param string $URL URL recurso, ejemplo: http://website.com/recurso/id
	 * @param string $TOKEN token de autenticación
	 * @param array $ARRAY parámetros a envíar
	 * @return JSON
	 */
	static function PUT($URL,$TOKEN,$ARRAY){
		$datapost = '';
		foreach($ARRAY as $key=>$value) {
		    $datapost .= $key . "=" . $value . "&";
		}

		$headers 	= array('Authorization: Bearer ' . $TOKEN);
		$ch 		= curl_init();
		curl_setopt($ch,CURLOPT_URL,$URL);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$datapost);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
		curl_setopt($ch,CURLOPT_TIMEOUT, 20);
		curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		curl_close ($ch);
		return $response;
	}

	/**
	 * Enviar parámetros a un servidor a través del protocolo HTTP (PATCH).
	 * Se utiliza para editar un atributo específico (recurso) en una API REST
	 *
	 * @param string $URL URL recurso, ejemplo: http://website.com/recurso/id
	 * @param string $TOKEN token de autenticación
	 * @param array $ARRAY parametros parámetros a envíar
	 * @return JSON
	 */
	static function PATCH($URL,$TOKEN,$ARRAY){
		$datapost = '';
		foreach($ARRAY as $key=>$value) {
		    $datapost .= $key . "=" . $value . "&";
		}

		$headers 	= array('Authorization: Bearer ' . $TOKEN);
		$ch 		= curl_init();
		curl_setopt($ch,CURLOPT_URL,$URL);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$datapost);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
		curl_setopt($ch,CURLOPT_TIMEOUT, 20);
		curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		curl_close ($ch);
		return $response;
	}

	/**
	 * Convertir JSON a un ARRAY
	 *
	 * @param json $json Formato JSON
	 * @return ARRAY
	 */
	static function JSON_TO_ARRAY($json){
		return json_decode($json,true);
	}
}
?>
