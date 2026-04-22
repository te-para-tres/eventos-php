<?php

namespace api\controllers;

use app\modelos\UnidadAcademica;
use eDesarrollos\rest\JsonController;

class UnidadAcademicaController extends JsonController {
  public $modelClass = UnidadAcademica::class;

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
        ["ilike", "telefono", $buscar],
        ["ilike", "correo", $buscar],
        ["ilike", "estado", $buscar],
      ]);
    }
  }
}
