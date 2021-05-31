<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Ordenes;
use app\models\Shopify;
use app\models\Xml;
use app\models\WS;
class EtiquetaController extends Controller
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
     * Displays homepage.
     *
     * @return string
     */
    
    public function actionPrinter($etiqueta)
    {
         $etiq=[
         'ETIQUETA'=>$etiqueta,
                   
         
        ];
        $xml=new Xml();        
        $datosXML = WS::getAdmisionEnvios($xml->imprimir_etiqueta($etiq));         
       // return $this->render('view',['orden'=>$orden,'detalle_orden'=>$detalle,'response_envia'=>$datosXML]);
        
    }
   
}
