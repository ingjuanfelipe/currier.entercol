<?php
namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Ordenes;
use app\models\Shopify;
use app\models\Currier;
use app\models\Xml;
use app\models\WS;

class OrdenesController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * Lista todas las ordenes de Shopify
	 */
	public function actionIndex()
	{
		$ordenes = new Ordenes();
		$shop_url = 'othersideuy.myshopify.com';
		
		if (!$ordenes->view($shop_url)) {
			$this->instalar($shop_url);
		}

		$token = '';
		foreach ($ordenes->view($shop_url) as $rows) {
			$token = $rows['access_token'];
		}
		
		//$url = $shop_url;
		//$token = $shop_row['access_token'];
		//$shop_url.'<br>';
		//echo $token;
		//$ordenes = shopify_call($token,$shop_url,"/admin/api/2021-01/orders.json?status=any",array(),'GET');
		
		$Shopify = new Shopify();
		$ordenes = $Shopify->shopify_call($token, $shop_url, "/admin/api/2021-01/orders.json?status=any",array(),'GET');
		$ordenes = json_decode($ordenes['response'],JSON_PRETTY_PRINT);
		//echo "<pre>";print_r($ordenes);echo "<pre>";
		return $this->render('index',['model'=>$ordenes,'url'=>$token]);
	}

	/**
	 * Instala la APP en Shopify
	*/
	private function instalar($shop_url)
	{
		header("Location:install.php?shop=" .$shop_url['shop']);
		exit;
	}

	/**
	 * No se sabe para qué es esta acción
	 */
	public function actionView($id,$email,$nombre,$direccion,$country,$zip,$city,$phone,$province='')
	{
		$orden = [];
		
		$Shopify = new Shopify();
		// /admin/api/2021-04/orders/450789469.json
		//$ordenesview=$Shopify->shopify_call('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','mlokedo.myshopify.com',"/admin/api/2021-01/orders.json?ids=$id".'.json',array(),'GET');
		
		$ordenesview = $Shopify->shopify_call('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','mlokedo.myshopify.com',"/admin/api/2021-01/orders/$id".'.json',array(),'GET');
		
		//echo "<pre>";print_r($ordenesview);exit;
		  
		$ordenesview = json_decode($ordenesview['response'],JSON_PRETTY_PRINT);
		
		//$odr = $ordenesview;
		$orden_id = '';
	   
		$detalle = $ordenesview;
		
		if (is_array($ordenesview) && $ordenesview['errors']!='Not Found') {
			foreach ($ordenesview as $value) {
				$orden = [
					'id'=>$value['id'],
					'email_destinatario'=>$email,
					'nombre_destinatario'=>$nombre,
					'total_price'=>$value['total_price'],
					'subtotal_price'=>$value['subtotal_price'],
					'peso_total'=>$value['total_weight'],
					'impuesto_total'=>$value['total_tax'],
					'descuento_total'=>$value['total_discounts'],
					'fecha'  =>$value['created_at'],
					'moneda'=> $value['currency'],
					'subtotal'=> $value['current_subtotal_price'],
					'monto'=> $value['current_subtotal_price_set']['shop_money']['amount'],
					'codigo_moneda'=> $value['current_subtotal_price_set']['shop_money']['currency_code'],
					'dinero_presentacion'=> $value['current_subtotal_price_set']['presentment_money']['amount'],
				];
			}
		   
			$admision = [
				'NUMERO_DE BULTOS'=>'1',
				'CLIENTE_REMITENTE'=>'00008493',
				'CENTRO_REMITENTE'=>'53',
				'NOMBRE_REMITENTE'=>'Mlokedo',
				'DIRECCION_REMITENTE'=>'Calle 47 Nro 4-81',
				'PAIS_REMITENTE'=>'057',
				'CODIGO_POSTAL_REMITENTE'=>'730001',
				'POBLACION_REMITENTE'=>'IBAGUE',
				'TIPO_DOCUMENTO_ID_REMITENTE'=>'CC',//NIT?
				'DOCUMENTO_IDENTIDAD_REMITENTE'=>'93238209',
				'PERSONA_CONTACTO_REMITENTE'=>'Camilo Bocanegra',
				'TELEFONO_CONTACTO_REMITENTE'=>'3154961052',
				'DEPARTAMENTO_REMITENTE'=>'TOLIMA',
				'EMAIL_REMITENTE'=>'camilobocanegra@gmail.com',
				'CLIENTE_DESTINATARIO'=>"999999999",
				'CENTRO_DECTINATARIO'=>'99',
				'NOMBRE_DESTINATARIO'=>$nombre,
				'DIRECCION_DESTINATARIO'=>$direccion,
				'PAIS_DESTINATARIO'=>$country,
				'CODIGO_POSTAL_DESTINATARIO'=>$zip,
				'POBLACION_DESTINATARIO'=>$city,
				'TIPO_DOC_DESTINATARIO'=>'CC',
				'DOCUMENTO_IDENTIDAD_DESTINATARIO'=>'9999999',
				'PERSONA_CONTACTO_DESTINATARIO'=>$nombre,
				'TELEFONO_CONTACTO_DESTINATARIO'=>$phone,
				'DEPARTAMENTO_DESTINATARIO'=>$province,
				'EMAIL_DESTINATARIO'=>$email,
				'CODIGO_SERVICIO'=>'',
				'KILOS'=>'0.5',
				'VOLUMEN'=>'10',
				'LARGO'=>'20',
				'ANCHO'=>'15',
				'ALTO'=>'8',
				'NUMERO_REFERENCIA'=>$orden['id'],
				'IMPORTE_REEMBOLSO'=>'',
				'IMPORTE_VALOR_DECLARADO'=>'',
				'OBSERVACIONES1'=>'',
				'OBSERVACIONES2'=>'',
				'TIPO_MERCANCIA'=>'P',
				'TIPO_MONEDA'=>'COP',
			];
			
			$xml = new Xml();
			$datosXML = WS::getAdmisionEnvios($xml->admisiones($admision));
			$params = [
				'errors'=>false,
				'orden'=>$orden,
				'detalle_orden'=>$detalle,
				'response_envia'=>$datosXML,
			];
		}else{
			$params = [
				'errors'=>true,
			];
		}
		return $this->render('view',$params);
	}

	/**
	 * Consulta un servicio del Currier y obtiene el número de Guia
	*/
	public function actionDetalle()
	{
		/**
		 * En este array se deben enviar los datos consultados en Shopify
		*/
		$params = [
			'generarRemito' => 'N',
			'tipo' 			=> 'C',
			'producto' 		=> '111',
			'bultos' 		=> '1',
			'kilos' 		=> '1',
			'destinatario' 	=> 'aaaaaa',
			'direccion' 	=> 'bbbbbb',
			'localidad' 	=> 'maldonado',
			'valorCR' 		=> '0.0',
			'facturaCR' 	=> '0',
		];
		$currier = new Currier();
		$response = $currier->call($params);
		echo "<pre>";print_r($response);exit;
	}

}