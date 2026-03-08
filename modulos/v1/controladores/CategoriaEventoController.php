<?php

namespace v1\controladores;

use app\modelos\CategoriaEvento;
use eDesarrollos\rest\AuthController;

class CategoriaEventoController extends AuthController {
  public $modelClass = CategoriaEvento::class;

  public function buscador(&$query, $request) {
    $id = $request->get($this->modeloID, "");
    $buscar = $request->get("buscar", "");

    if ($id !== "") {
      $query->andWhere([$this->modeloID => $id]);
    }

    if ($buscar !== "") {
      $query->andWhere([
        "OR",
        ["ilike", "clave", $buscar],
        ["ilike", "nombre", $buscar],
        ["ilike", "descripcion", $buscar],
      ]);
    }
  }
}
