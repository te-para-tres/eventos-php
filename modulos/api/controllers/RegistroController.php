<?php

namespace api\controllers;

use app\modelos\Estudiante;
use app\modelos\EstudianteSesion;
use eDesarrollos\data\Respuesta;
use eDesarrollos\rest\JsonController;
use yii\db\Expression;

class RegistroController extends JsonController {

  // Solo estos campos los decide el estudiante; id, estatus y fechas los fija el servidor
  private const CAMPOS_PERMITIDOS = [
    'idUnidadAcademica',
    'idCarrera',
    'expediente',
    'correo',
    'clave',
    'nombre',
    'apellidos',
    'telefono',
  ];

  public function actionGuardar() {
    $datos = array_intersect_key($this->req->getBodyParams(), array_flip(self::CAMPOS_PERMITIDOS));

    $modelo = new EstudianteSesion();
    $modelo->load($datos, '');
    $modelo->uuid();
    $modelo->estatus = Estudiante::ACTIVO;
    $modelo->creado = new Expression('now()');

    if (!$modelo->save()) {
      return (new Respuesta($modelo))
        ->mensaje("Hubo un problema al registrar la cuenta.");
    }

    $modelo->refresh();

    return (new Respuesta($modelo))
      ->mensaje("Cuenta registrada");
  }
}
