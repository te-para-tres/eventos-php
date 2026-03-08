<?php

namespace v1\controladores;

use app\modelos\EventoMaterial;
use eDesarrollos\rest\AuthController;

class EventoMaterialController extends AuthController {
  public $modelClass = EventoMaterial::class;

  public function buscador(&$query, $request) {
    $id = $request->get($this->modeloID, "");
    $buscar = $request->get("buscar", "");

    if ($id !== "") {
      $query->andWhere([$this->modeloID => $id]);
    }

    if ($buscar !== "") {
      $query->andWhere([
        "OR",
        ["ilike", "cantidad ", $buscar],
      ]);
    }
  }
}
