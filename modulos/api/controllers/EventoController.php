<?php

namespace api\controllers;

use app\modelos\Evento;
use eDesarrollos\rest\JsonController;

class EventoController extends JsonController {
  public $modelClass = Evento::class;

  public function buscador(&$query, $request) {
    $id = $request->get($this->modeloID, "");
    $buscar = $request->get("buscar", "");
    $actividad = $request->get("idActividad", "");
    $carrera = $request->get("idCarrera", "");
    $unidadAcademica = $request->get("idUnidadAcademica", "");

    if ($id !== "") {
      $query->andWhere([$this->modeloID => $id]);
    }

    if ($actividad !== "") {
      $query->andWhere(["idActividad" => $actividad]);
    }

    if ($carrera !== "") {
      $query->andWhere(["idCarrera" => $carrera]);
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
