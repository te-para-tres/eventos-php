<?php

namespace api\controllers;

use app\modelos\RefreshTokenEstudiante;
use eDesarrollos\data\Respuesta;
use eDesarrollos\rest\JsonController;
use yii\db\Expression;

class CerrarSesionController extends JsonController {

  // Sin Bearer a propósito: el refresh token basta para revocarse, aunque el JWT ya haya expirado
  public function actionGuardar() {
    $token = trim($this->req->getBodyParam("refreshToken", ""));

    $refreshToken = RefreshTokenEstudiante::findOne(["token" => $token, "eliminado" => null]);

    if ($refreshToken !== null) {
      // También los tokens rotados que siguen en su gracia de 30 s; si no, servirían para reabrir la sesión
      RefreshTokenEstudiante::updateAll(["eliminado" => new Expression("NOW()")], [
        "AND",
        ["idEstudiante" => $refreshToken->idEstudiante, "eliminado" => null],
        ["OR", ["token" => $token], ["<=", "expiracion", new Expression("NOW() + INTERVAL '30 seconds'")]],
      ]);
    }

    return (new Respuesta())
      ->mensaje("Sesión cerrada");
  }
}
