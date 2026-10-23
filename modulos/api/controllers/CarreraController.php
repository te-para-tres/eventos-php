<?php

namespace api\controllers;

use app\modelos\Carrera;
use eDesarrollos\rest\JsonController;

class CarreraController extends JsonController {
  public $modelClass = Carrera::class;

  public function buscador(&$query, $request) {
    $id = $request->get($this->modeloID, "");
    $buscar = $request->get("buscar", "");
    $unidadAcademica = $request->get("idUnidadAcademica", "");

    if ($id !== "") {
      $query->andWhere([$this->modeloID => $id]);
    }

    if ($unidadAcademica !== "") {
      $query->andWhere(["idUnidadAcademica" => $unidadAcademica]);
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
