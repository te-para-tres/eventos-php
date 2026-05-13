<?php

namespace api\controllers;

use app\modelos\Asistente;
use app\modelos\Evento;
use eDesarrollos\data\Respuesta;
use eDesarrollos\rest\JsonController;

class AsistenteController extends JsonController {
  public $modelClass = Asistente::class;

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
        ["ilike", "expediente", $buscar],
        ["ilike", "carrera", $buscar],
      ]);
    }
  }

  public function actionGuardar() {
    $idEvento = trim($this->req->getBodyParam("idEvento", ""));
    $expediente = trim($this->req->getBodyParam("expediente", ""));
    $modelo = null;

    if ($idEvento !== "") {
      $modelo = Evento::findOne($idEvento);
    }

    if ($modelo === null) {
      return (new Respuesta())
        ->esError()
        ->mensaje("No existe un evento con esta id");
    }

    if ($expediente != "") {
      $existe = $modelo->getAsistentes()->andWhere(['expediente' => $expediente])->exists();

      if ($existe) {
        return (new Respuesta())
          ->esError()
          ->mensaje("Este expediente ya está registrado como asistente en este evento.");
      }
    }

    $transaction = \Yii::$app->db->beginTransaction();

    try {
      $asistente = Asistente::findOne(['expediente' => $expediente]);

      if ($asistente === null) {
        $asistente = new Asistente();
      }

      $asistente->load($this->req->getBodyParams(), '');

      if (!$asistente->save()) {
        $transaction->rollBack();
        return (new Respuesta())
          ->esError()
          ->mensaje($asistente->getErrors());
      }

      $asistenteEvento = new \app\modelos\AsistenteEvento();
      $asistenteEvento->idAsistente = $asistente->id;
      $asistenteEvento->idEvento = $idEvento;

      if (!$asistenteEvento->save()) {
        $transaction->rollBack();
        return (new Respuesta())
          ->esError()
          ->mensaje($asistenteEvento->getErrors());
      }

      $transaction->commit();

      return clone(
        new Respuesta($modelo)
          ->mensaje("Asistente guardado exitosamente.")
      );
    } catch (\Throwable $e) {
      $transaction->rollBack();
      \Yii::error('Error al guardar asistente: ' . $e->getMessage(), __METHOD__);
      return clone(
        new Respuesta()
          ->esError(500)
          ->mensaje("Error interno al guardar el asistente.")
      );
    }
  }
}
