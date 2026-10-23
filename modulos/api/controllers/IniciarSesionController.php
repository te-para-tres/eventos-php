<?php

namespace api\controllers;

use app\modelos\Estudiante;
use app\modelos\EstudianteSesion;
use eDesarrollos\data\Respuesta;
use eDesarrollos\rest\JsonController;

class IniciarSesionController extends JsonController {

  public function actionGuardar() {
    $correo = strtolower(trim($this->req->getBodyParam("correo", "")));
    $clave = trim($this->req->getBodyParam("clave", ""));

    $modelo = EstudianteSesion::find()
      ->andWhere(["correo" => $correo])
      ->andWhere(["eliminado" => null])
      ->one();

    if ($modelo === null) {
      $modelo = new EstudianteSesion();
      $modelo->addError("correo", "No se encontró una cuenta con este correo.");
      return new Respuesta($modelo);
    }

    if ((int)$modelo->estatus !== Estudiante::ACTIVO) {
      $modelo->addError("correo", "La cuenta está inactiva.");
      return new Respuesta($modelo);
    }

    if (!$modelo->validarClave($clave)) {
      $modelo->addError("clave", "Contraseña incorrecta");
      return new Respuesta($modelo);
    }

    return new Respuesta($modelo);
  }
}
