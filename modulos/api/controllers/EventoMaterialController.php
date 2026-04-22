<?php

namespace app\modules\api\controllers;

use app\modelos\EventoMaterial;
use eDesarrollos\rest\JsonController;

class EventoMaterialController extends JsonController {
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
