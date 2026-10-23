<?php

namespace api\controllers;

use app\modelos\EstudianteSesion;
use app\modelos\RefreshTokenEstudiante;
use eDesarrollos\data\Respuesta;
use eDesarrollos\rest\JsonController;
use yii\db\Expression;

class RefrescarTokenController extends JsonController {

  public function actionGuardar() {
    $token = trim($this->req->getBodyParam("refreshToken", ""));

    $refreshToken = RefreshTokenEstudiante::find()
      ->andWhere(["token" => $token])
      ->andWhere(["eliminado" => null])
      ->andWhere([">=", "expiracion", new Expression("NOW()")])
      ->one();

    $modelo = $refreshToken === null ? null : EstudianteSesion::findIdentity($refreshToken->idEstudiante);

    if ($modelo === null) {
      return (new Respuesta())
        ->esError(401)
        ->mensaje("La sesión expiró, inicia sesión de nuevo.");
    }

    // Rotación con gracia: el token usado vale 30 s más por si la respuesta se pierde (red, pestaña cerrada, iframe de dev)
    $refreshToken->updateAttributes([
      "expiracion" => new Expression("LEAST(expiracion, NOW() + INTERVAL '30 seconds')"),
    ]);

    return new Respuesta($modelo);
  }
}
