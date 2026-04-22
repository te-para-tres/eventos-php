<?php

namespace api\controllers;

use app\modelos\Material;
use eDesarrollos\rest\JsonController;

class MaterialController extends JsonController {
  public $modelClass = Material::class;

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
        ["ilike", "cantidad", $buscar],
        ["ilike", "nota", $buscar],
      ]);
    }
  }
}
