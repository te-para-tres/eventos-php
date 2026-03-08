<?php

namespace v1\controladores;

use app\modelos\Evento;
use eDesarrollos\rest\AuthController;

class EventoController extends AuthController {

  public $modelClass = Evento::class;

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
        ["ilike", "lugar", $buscar],
      ]);
    }
  }
}
