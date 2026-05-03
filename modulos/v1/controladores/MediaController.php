<?php

namespace v1\controladores;

use app\modelos\Media;
use eDesarrollos\rest\JsonController;
use Override;

class MediaController extends JsonController {
  public $modelClass = Media::class;
  public function buscador(&$query, $request) {
    $id = $request->get($this->modeloID, "");
    $tipo = $request->get("tipo", "");
    $buscar = $request->get("buscar", "");

    if ($id !== "") {
      $query->andWhere([$this->modeloID => $id]);
    }

    if ($tipo !== "") {
      $query->andWhere(["{{Media}}.extension" => $tipo]);
    }

    if ($buscar !== "") {
      $query->andWhere([
        "OR",
        ["ilike", "nombre", $buscar],
      ]);
    }
  }
}
