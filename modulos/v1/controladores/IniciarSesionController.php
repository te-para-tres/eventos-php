<?php

namespace v1\controladores;

use app\modelos\RefreshTokenUsuario;
use app\modelos\Sesion;
use app\modelos\Usuario;
use eDesarrollos\data\Respuesta;
use eDesarrollos\rest\JsonController;
use Yii;
use yii\filters\VerbFilter;

class IniciarSesionController extends JsonController
{

  public function actionPost()
  {
    $req = Yii::$app->getRequest();
    $usuario = trim($req->getBodyParam("usuario", ""));
    $clave = trim($req->getBodyParam("clave", ""));

    $modelo = Sesion::find()
      ->andWhere(["correo" => $usuario])
      ->andWhere('eliminado is null')
      ->one();

    /** @var \app\models\Sesion $modelo */
    if ($modelo === null) {
      $modelo = new Sesion();
      $modelo->addError("correo", "No se encontró el Usuario.");
      return new Respuesta($modelo);
    }

    if (!$modelo->validarClave($clave)) {
      $modelo->addError("clave", "Contraseña incorrecta");
      return new Respuesta($modelo);
    }

    return new Respuesta($modelo);
  }
  
}
