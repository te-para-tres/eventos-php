<?php

namespace v1\controladores;

use app\modelos\Carrera;
use eDesarrollos\rest\AuthController;

class CarreraController extends AuthController {
  public $modelClass = Carrera::class;

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
        ["ilike", "tipo", $buscar],
        ["ilike", "estado", $buscar],
      ]);
    }
  }
}
