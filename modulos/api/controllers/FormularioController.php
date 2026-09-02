<?php

namespace api\controllers;

use eDesarrollos\data\Respuesta;
use eDesarrollos\rest\JsonController;
use yii\db\Expression;

class FormularioController extends JsonController {
  public $modelClass = '\\app\\modelos\\Formulario';

  public function actionPost() {
    $id = trim($this->req->getBodyParam("id", ""));
    $modelo = null;

    if ($id !== "") {
      $modelo = $this->modelClass::findOne($id);
    }
    if ($modelo === null) {
      $modelo = new $this->modelClass();
      $modelo->uuid();
      $modelo->creado = new Expression('now()');
    } else {
      $modelo->modificado = new Expression('now()');
    }

    $modelo->load($this->req->getBodyParams(), '');

    if (!$modelo->save()) {
      return (new Respuesta($modelo))
        ->mensaje("Hubo un problema al guardar el {$this->nombreSingular}");
    }

    $modelo->refresh();
    return (new Respuesta($modelo))
      ->mensaje("{$this->nombreSingular} guardado");
  }

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
      ]);
    }
  }
}
