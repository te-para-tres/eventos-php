<?php

namespace api\controllers;

use app\modelos\Estudiante;
use eDesarrollos\data\Respuesta;
use eDesarrollos\rest\AuthController;

class EstudianteController extends AuthController {

  public function actionIndex() {
    $query = Estudiante::find()
      ->andWhere(["id" => $this->usuario->id]);

    return new Respuesta($query);
  }

  public function actionGuardar() {
    throw new \yii\web\MethodNotAllowedHttpException();
  }

  public function actionEliminar() {
    throw new \yii\web\MethodNotAllowedHttpException();
  }
}
