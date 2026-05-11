<?php

namespace v1\controladores;

use app\modelos\Evento;
use app\modelos\EventoMaterial;
use app\modelos\EventoMedia;
use app\modelos\Material;
use eDesarrollos\data\Respuesta;
use eDesarrollos\rest\AuthController;
use yii\db\Expression;

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

  public function actionGuardar() {
    $transaction = null;

    try {
      $transaction = \Yii::$app->db->beginTransaction();
      $id = trim($this->req->getBodyParam("id", ""));
      $anexos = $this->req->getBodyParam("anexos", []);
      $materiales = $this->req->getBodyParam("materiales", []);
      $modelo = null;

      if ($id !== "") {
        $modelo = $this->modelClass::findOne($id);
      }

      if ($modelo === null) {
        $modelo = new $this->modelClass();
        $modelo->uuid();
        $modelo->creado = new Expression("now()");
      } else {
        $modelo->modificado = new Expression("now()");
      }

      $modelo->load($this->req->getBodyParams(), "");
      $modelo->idCategoriaEvento = $this->req->getBodyParam("idCategoriaEvento", $this->req->getBodyParam("categoria", $modelo->idCategoriaEvento));
      $modelo->idCarrera = $this->req->getBodyParam("idCarrera", $this->req->getBodyParam("carrera", $modelo->idCarrera));
      $modelo->idImagenDestacada = $this->req->getBodyParam("idImagenDestacada", $this->req->getBodyParam("imagenPrincipal", $modelo->idImagenDestacada));

      $existeEvento = $this->modelClass::find()
        ->andWhere(["fechaInicio" => $modelo->fechaInicio])
        ->andWhere(["fechaFin" => $modelo->fechaFin])
        ->andWhere(["ilike", "lugar", trim((string) $modelo->lugar)])
        ->andWhere(["eliminado" => null])
        ->andWhere(["!=", "id", $modelo->id])
        ->exists();

      if ($existeEvento) {
        $transaction->rollBack();
        return (new Respuesta())
          ->esError()
          ->mensaje("Ya existe un evento con las mismas fechas y el mismo lugar.");
      }

      if (!$modelo->save()) {
        $transaction->rollBack();
        return (new Respuesta($modelo))
          ->mensaje("Hubo un problema al guardar el evento.");
      }

      $modelo->refresh();

      if (is_array($anexos)) {
        EventoMedia::updateAll(
          ["eliminado" => new Expression("now()")],
          ["idEvento" => $modelo->id, "eliminado" => null]
        );

        foreach ($anexos as $anexo) {
          $datosAnexo = is_array($anexo) ? $anexo : ["idMedia" => $anexo];
          $idAnexo = $datosAnexo["id"] ?? "";
          unset($datosAnexo["id"]);

          $eventoMedia = $idAnexo != ""
            ? EventoMedia::find()->andWhere(["id" => $idAnexo, "idEvento" => $modelo->id])->one()
            : null;

          if ($eventoMedia === null) {
            $eventoMedia = new EventoMedia();
            $eventoMedia->uuid();
            $eventoMedia->creado = new Expression("now()");
          } else {
            $eventoMedia->eliminado = null;
            $eventoMedia->modificado = new Expression("now()");
          }

          $eventoMedia->load($datosAnexo, "");
          $eventoMedia->idEvento = $modelo->id;

          if (!$eventoMedia->save()) {
            $transaction->rollBack();
            return (new Respuesta($eventoMedia))
              ->esError()
              ->mensaje("Hubo un problema al guardar el anexo del evento");
          }
        }
      }

      if (is_array($materiales)) {
        EventoMaterial::updateAll(
          ["eliminado" => new Expression("now()")],
          ["idEvento" => $modelo->id, "eliminado" => null]
        );

        foreach ($materiales as $material) {
          if (!is_array($material)) {
            $material = ["idMaterial" => $material];
          }

          $idMaterialEvento = $material["id"] ?? "";
          $datosMaterial = $material;
          unset($datosMaterial["id"]);

          $eventoMaterial = $idMaterialEvento != ""
            ? EventoMaterial::find()->andWhere(["id" => $idMaterialEvento, "idEvento" => $modelo->id])->one()
            : null;

          if ($eventoMaterial === null) {
            $eventoMaterial = new EventoMaterial();
            $eventoMaterial->uuid();
            $eventoMaterial->creado = new Expression("now()");
          } else {
            $eventoMaterial->eliminado = null;
            $eventoMaterial->modificado = new Expression("now()");
          }

          $idMaterial = $datosMaterial["idMaterial"] ?? "";
          $materialCatalogo = $idMaterial !== "" ? Material::findOne($idMaterial) : null;

          if ($materialCatalogo === null) {
            $materialCatalogo = new Material();
            $materialCatalogo->uuid();
            $materialCatalogo->creado = new Expression("now()");
          } else {
            $materialCatalogo->modificado = new Expression("now()");
          }

          $datosCatalogo = $datosMaterial;
          unset($datosCatalogo["idMaterial"]);
          $materialCatalogo->load($datosCatalogo, "");

          if (!$materialCatalogo->save()) {
            $transaction->rollBack();
            return (new Respuesta($materialCatalogo))
              ->esError()
              ->mensaje("Hubo un problema al guardar el material");
          }

          $eventoMaterial->cantidad = $datosMaterial["cantidad"] ?? null;
          $eventoMaterial->idMaterial = $materialCatalogo->id;
          $eventoMaterial->idEvento = $modelo->id;

          if (!$eventoMaterial->save()) {
            $transaction->rollBack();
            return (new Respuesta($eventoMaterial))
              ->esError()
              ->mensaje("Hubo un problema al guardar el material del evento");
          }
        }
      }

      $transaction->commit();

      return (new Respuesta($modelo))
        ->mensaje("Evento guardado");
    } catch (\Throwable $e) {
      if ($transaction !== null && $transaction->isActive) {
        $transaction->rollBack();
      }

      \Yii::error('Error al guardar evento: ' . $e->getMessage(), __METHOD__);
      return (new Respuesta())
        ->esError(500)
        ->mensaje("Error interno al guardar el evento.");
    }
  }
}
