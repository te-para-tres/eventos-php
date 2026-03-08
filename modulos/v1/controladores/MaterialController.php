<?php

namespace v1\controladores;

use app\modelos\CategoriaEvento;
use app\modelos\Material;
use eDesarrollos\rest\AuthController;

class MaterialController extends AuthController {
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
