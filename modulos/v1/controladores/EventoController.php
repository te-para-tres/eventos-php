<?php

namespace v1\controladores;

use app\modelos\Evento;
use eDesarrollos\data\Respuesta;
use eDesarrollos\rest\AuthController;
use yii\db\Expression;

class EventoController extends AuthController {

  public $modelClass = Evento::class;

  public function buscador(&$query, $request) {
    $id = $request->get($this->modeloID, "");
    $buscar = $request->get("buscar", "");

    if ($id !== "") {
      $query->andWhere([$this->modeloID => $id]);
    }

    if ($buscar !== "") {
      $query->andWhere([
        "OR",
        ["ilike", "nombre", $buscar],
        ["ilike", "descripcion", $buscar],
        ["ilike", "estado", $buscar],
        ["ilike", "lugar", $buscar],
      ]);
    }
  }

  public function actionGuardar() {
    try {
      $id = trim($this->req->getBodyParam("id", ""));
      $modelo = $this->modelClass::findOne($id);

      if ($modelo === null) {
        $modelo = new $this->modelClass();
        $modelo->uuid();
        $modelo->creado = new Expression('now()');
      } else {
        $modelo->modificado = new Expression('now()');
      }

      $modelo->load($this->req->getBodyParams(), "");

      $existeEvento = $this->modelClass::find()
        ->andWhere(["fechaInicio" => $modelo->fechaInicio])
        ->andWhere(["fechaFin" => $modelo->fechaFin])
        ->andWhere(["ilike", "lugar", trim((string) $modelo->lugar)])
        ->andWhere(["eliminado" => null])
        ->andWhere(["!=", "id", $modelo->id])
        ->exists();

      if ($existeEvento) {
        return (new Respuesta())
          ->esError()
          ->mensaje("Ya existe un evento con las mismas fechas y el mismo lugar.");
      }

      if (!$modelo->save()) {
        return (new Respuesta($modelo))
          ->mensaje("Hubo un problema al guardar el evento.");
      }

      $modelo->refresh();

      return (new Respuesta($modelo))
        ->mensaje("Evento guardado");
    } catch (\Throwable $e) {
      \Yii::error('Error al guardar evento: ' . $e->getMessage(), __METHOD__);
      return (new Respuesta())
        ->esError(500)
        ->mensaje("Error interno al guardar el evento.");
    }
  }
}
