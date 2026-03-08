<?php

namespace v1\controladores;

use app\modelos\CategoriaEvento;
use app\modelos\UnidadAcademica;
use eDesarrollos\rest\AuthController;

class UnidadAcademicaController extends AuthController {
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
