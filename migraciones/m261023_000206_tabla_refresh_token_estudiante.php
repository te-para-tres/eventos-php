<?php

use yii\db\Migration;

class m261023_000206_tabla_refresh_token_estudiante extends Migration {
  /**
   * {@inheritdoc}
   */
  public function safeUp() {
    $this->createTable("RefreshTokenEstudiante", [
      "token" => $this->string(36)->notNull(),
      "idEstudiante" => $this->string(36),
      "expiracion" => $this->timestamp()->append("with time zone")->comment("Fecha en que el token expira"),
      "creado" => $this->timestamp()->append("with time zone")->comment("Fecha de creacion del token"),
      "eliminado" => $this->timestamp()->append("with time zone")->comment("Eliminar validez del token"),
    ]); //1
    $this->addPrimaryKey("RefreshTokenEstudiantePK", "RefreshTokenEstudiante", "token"); //2
    $this->addForeignKey("RTEidEstudianteFK", "RefreshTokenEstudiante", "idEstudiante", "Estudiante", "id"); //3
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown() {
    $this->dropForeignKey("RTEidEstudianteFK", "RefreshTokenEstudiante"); //3
    $this->dropPrimaryKey("RefreshTokenEstudiantePK", "RefreshTokenEstudiante"); //2
    $this->dropTable("RefreshTokenEstudiante"); //1
  }
}
