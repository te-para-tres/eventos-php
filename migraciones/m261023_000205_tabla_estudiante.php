<?php

use yii\db\Migration;

class m261023_000205_tabla_estudiante extends Migration {
  /**
   * {@inheritdoc}
   */
  public function safeUp() {
    $this->createTable("Estudiante", [
      "id" => $this->string(36),
      "idUnidadAcademica" => $this->string(36),
      "idCarrera" => $this->string(36),
      "idMedia" => $this->string(36),
      "expediente" => $this->string(),
      "correo" => $this->string(),
      "clave" => $this->string(),
      "nombre" => $this->string(),
      "apellidos" => $this->string(),
      "telefono" => $this->string(),
      "estatus" => $this->smallInteger()->defaultValue(1)->comment("0:inactivo, 1:activo"),
      "creado" => $this->timestamp()->append("with time zone"),
      "modificado" => $this->timestamp()->append("with time zone"),
      "eliminado" => $this->timestamp()->append("with time zone"),
    ]); //1
    $this->addPrimaryKey("EstudiantePK", "Estudiante", "id"); //2
    $this->createIndex("EstudianteCorreoUQ", "Estudiante", "correo", true); //3
    $this->createIndex("EstudianteExpedienteUQ", "Estudiante", "expediente", true); //4
    $this->addForeignKey("EUAidUnidadAcademicaFK", "Estudiante", "idUnidadAcademica", "UnidadAcademica", "id"); //5
    $this->addForeignKey("ECidCarreraFK", "Estudiante", "idCarrera", "Carrera", "id"); //6
    $this->addForeignKey("EMidMediaFK", "Estudiante", "idMedia", "Media", "id"); //7
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown() {
    $this->dropForeignKey("EMidMediaFK", "Estudiante"); //7
    $this->dropForeignKey("ECidCarreraFK", "Estudiante"); //6
    $this->dropForeignKey("EUAidUnidadAcademicaFK", "Estudiante"); //5
    $this->dropIndex("EstudianteExpedienteUQ", "Estudiante"); //4
    $this->dropIndex("EstudianteCorreoUQ", "Estudiante"); //3
    $this->dropPrimaryKey("EstudiantePK", "Estudiante"); //2
    $this->dropTable("Estudiante"); //1
  }
}
