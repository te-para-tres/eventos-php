<?php

namespace app\modules\api\controllers;

use app\modelos\EventoMedia;
use eDesarrollos\rest\JsonController;

class EventoMediaController extends JsonController {
  public $modelClass = EventoMedia::class;

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
      ]);
    }
  }
}
