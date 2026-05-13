<?php

namespace api\controllers;

use app\modelos\Actividad;
use eDesarrollos\rest\JsonController;

class ActividadController extends JsonController {
  public $modelClass = Actividad::class;

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
      ]);
    }
  }
}
