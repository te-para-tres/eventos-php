<?php

use yii\db\Migration;

class m260308_065345_tablas_catalogos extends Migration {
  /**
   * {@inheritdoc}
   */
  public function safeUp() {
    $this->createTable("CategoriaEvento", [
      "id" => $this->string(36),
      "clave" => $this->string(),
      "nombre" => $this->string(),
      "descripcion" => $this->string(),
      "creado" => $this->timestamp()->append("with time zone"),
      "modificado" => $this->timestamp()->append("with time zone"),
      "eliminado" => $this->timestamp()->append("with time zone"),
    ]);

    $this->addPrimaryKey("CategoriaEventoPK", "CategoriaEvento", "id");

    $this->createTable("UnidadAcademica", [
      "id" => $this->string(36),
      "nombre" => $this->string(),
      "descripcion" => $this->string(),
      "telefono" => $this->string(),
      "correo" => $this->string(),
      "estado" => $this->string(),
      "creado" => $this->timestamp()->append("with time zone"),
      "modificado" => $this->timestamp()->append("with time zone"),
      "eliminado" => $this->timestamp()->append("with time zone"),
    ]); //1

    $this->addPrimaryKey("UAIdPK", "UnidadAcademica", "id"); //2

    $this->createTable("Material", [
      "id" => $this->string(36),
      "nombre" => $this->string(),
      "descripcion" => $this->string(),
      "estado" => $this->string(),
      "cantidad" => $this->integer(),
      "nota" => $this->string(),
      "creado" => $this->timestamp()->append("with time zone"),
      "modificado" => $this->timestamp()->append("with time zone"),
      "eliminado" => $this->timestamp()->append("with time zone"),
    ]); //4

    $this->addPrimaryKey("MaterialPK", "Material", "id"); //5

    $this->createTable("Carrera", [
      "id" => $this->string(36),
      "idUnidadAcademica" => $this->string(36),
      "nombre" => $this->string(),
      "descripcion" => $this->string(),
      "tipo" => $this->string(),
      "estado" => $this->string(),
      "creado" => $this->timestamp()->append("with time zone"),
      "modificado" => $this->timestamp()->append("with time zone"),
      "eliminado" => $this->timestamp()->append("with time zone"),
    ]); //6

    $this->addPrimaryKey("CarreraPK", "Carrera", "id"); //7
    $this->addForeignKey("CUAidUnidadAcademicaFK", "Carrera", "idUnidadAcademica", "UnidadAcademica", "id"); //8

    $this->createTable("Evento", [
      "id" => $this->string(36),
      "idUnidadAcademica" => $this->string(36),
      "idCategoriaEvento" => $this->string(36),
      "idCarrera" => $this->string(36),
      "idImagenDestacada" => $this->string(36),
      "nombre" => $this->string(),
      "descripcion" => $this->string(),
      "fechaInicio" => $this->timestamp()->append("with time zone"),
      "fechaFin" => $this->timestamp()->append("with time zone"),
      "capacidadMaxima" => $this->integer(),
      "capacidadMinima" => $this->integer(),
      "estado" => $this->string(),
      "lugar" => $this->string(),
      "latitud" => $this->decimal(17, 7),
      "longitud" => $this->decimal(17, 7),
      "creado" => $this->timestamp()->append("with time zone"),
      "modificado" => $this->timestamp()->append("with time zone"),
      "eliminado" => $this->timestamp()->append("with time zone"),
    ]);

    $this->addPrimaryKey("EventoPK", "Evento", "id");
    $this->addForeignKey("EUAidUnidadAcademicaFK", "Evento", "idUnidadAcademica", "UnidadAcademica", "id");
    $this->addForeignKey("ECEidCategoriaEventoFK", "Evento", "idCategoriaEvento", "CategoriaEvento", "id");
    $this->addForeignKey("ECidCarrera", "Evento", "idCarrera", "Carrera", "id");
    $this->addForeignKey("EIDidImagenDestacada", "Evento", "idImagenDestacada", "Media", "id");

    $this->createTable("EventoMedia", [
      "id" => $this->string(36),
      "idMedia" => $this->string(36),
      "idEvento" => $this->string(36),
      "creado" => $this->timestamp()->append("with time zone"),
      "modificado" => $this->timestamp()->append("with time zone"),
      "eliminado" => $this->timestamp()->append("with time zone"),
    ]); // 9

    $this->addPrimaryKey("EventoMediaPK", "EventoMedia", "id"); //10
    $this->addForeignKey("EMMidMediaFK", "EventoMedia", "idMedia", "Media", "id"); //11
    $this->addForeignKey("EMEidEventoFK", "EventoMedia", "idEvento", "Evento", "id"); //12

    $this->createTable("EventoMaterial", [
      "id" => $this->string(36),
      "idEvento" => $this->string(36),
      "idMaterial" => $this->string(36),
      "cantidad" => $this->integer(),
      "creado" => $this->timestamp()->append("with time zone"),
      "modificado" => $this->timestamp()->append("with time zone"),
      "eliminado" => $this->timestamp()->append("with time zone"),
    ]);

    $this->addPrimaryKey("EventoMaterialPK", "EventoMaterial", "id");
    $this->addForeignKey("EMEventoidEventoFK", "EventoMaterial", "idEvento", "Evento", "id");
    $this->addForeignKey("EMMaterialidMaterialFK", "EventoMaterial", "idMaterial", "Material", "id");
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown() {

    $this->dropForeignKey("EMMaterialidMaterialFK", "EventoMaterial");
    $this->dropForeignKey("EMEventoidEventoFK", "EventoMaterial");
    $this->dropPrimaryKey("EventoMaterialPK", "EventoMaterial");
    $this->dropTable("EventoMaterial");

    $this->dropForeignKey("EMEidEventoFK", "EventoMedia"); //12
    $this->dropForeignKey("EMMidMediaFK", "EventoMedia"); //11
    $this->dropPrimaryKey("EventoMediaPK", "EventoMedia"); //10
    $this->dropTable("EventoMedia"); //9

    $this->dropForeignKey("EIDidImagenDestacada", "Evento");
    $this->dropForeignKey("ECidCarrera", "Evento");
    $this->dropForeignKey("ECEidCategoriaEventoFK", "Evento");
    $this->dropForeignKey("EUAidUnidadAcademicaFK", "Evento");
    $this->dropPrimaryKey("EventoPK", "Evento");
    $this->dropTable("Evento");

    $this->dropForeignKey("CUAidUnidadAcademicaFK", "Carrera"); //8
    $this->dropPrimaryKey("CarreraPK", "Carrera"); //7
    $this->dropTable("Carrera"); //6

    $this->dropPrimaryKey("MaterialPK", "Material"); //5
    $this->dropTable("Material"); //4

    $this->dropPrimaryKey("UAIdPK", "UnidadAcademica"); //2
    $this->dropTable("UnidadAcademica"); //1

    $this->dropPrimaryKey("CategoriaEventoPK", "CategoriaEvento");
    $this->dropTable("CategoriaEvento");
  }
}
