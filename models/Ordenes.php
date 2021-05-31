<?php

namespace app\models;
use app\models\Credenciales;
class Ordenes {
    function view($shopify){
      $cred=new Credenciales();
      return $cred->view($shopify);
    }
}
