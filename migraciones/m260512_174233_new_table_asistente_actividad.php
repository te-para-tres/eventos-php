<?php

use yii\db\Migration;

class m260512_174233_new_table_asistente_actividad extends Migration {
  /**
   * {@inheritdoc}
   */
  public function safeUp() {
    // TODO: popular la tabla para poder generar la relacion
    $this->createTable("Asistente", [
      "id" => $this->string(36),
      "idUnidadAcademica" => $this->string(36),
      "idCarrera" => $this->string(36),
      "expediente" => $this->string(13),
      "carrera" => $this->string(150),
      "nombre" => $this->string(300),
      "creado" => $this->timestamp()->append("with time zone"),
      "modificado" => $this->timestamp()->append("with time zone"),

      "eliminado" => $this->timestamp()->append("with time zone"),
    ]); //1
    $this->addPrimaryKey("AsistentePK", "Asistente", "id"); //2

    $this->createTable("AsistenteEvento", [
      "id" => $this->string(36),
      "idAsistente" => $this->string(36),
      "idEvento" => $this->string(36),
      "creado" => $this->timestamp()->append("with time zone"),
      "modificado" => $this->timestamp()->append("with time zone"),
      "eliminado" => $this->timestamp()->append("with time zone"),
    ]); //3
    $this->addPrimaryKey("AsistenteEventoPK", "AsistenteEvento", "id"); //4
    $this->addForeignKey("AEEAsistenteEventoFK", "AsistenteEvento", "idAsistente", "Asistente", "id"); //5
    $this->addForeignKey("AEEAAsistenteEventoFK", "AsistenteEvento", "idEvento", "Evento", "id"); //6

    $this->createTable("Actividad", [
      "id" => $this->string(36),
      "clave" => $this->string(40),
      "descripcion" => $this->string(300),
      "nombre" => $this->string(120),
      "creado" => $this->timestamp()->append("with time zone"),
      "modificado" => $this->timestamp()->append("with time zone"),
      "eliminado" => $this->timestamp()->append("with time zone"),
    ]); //7
    $this->addPrimaryKey("ActividadPK", "Actividad", "id"); //8

    $this->addColumn("Evento", "idActividad", $this->string(36)); //9
    $this->addForeignKey("AEActividadEventoFK", "Evento", "idActividad", "Actividad", "id"); //10
  }




  /**
   * {@inheritdoc}
   */
  public function safeDown() {
    $this->dropForeignKey("AEActividadEventoFK", "Evento"); //10
    $this->dropColumn("Evento", "idActividad"); //9
    $this->dropPrimaryKey("ActividadPK", "Actividad"); //8
    $this->dropTable("Actividad"); //7

    $this->dropForeignKey("AEEAAsistenteEventoFK", "AsistenteEvento"); //6
    $this->dropForeignKey("AEEAsistenteEventoFK", "AsistenteEvento"); //5
    $this->dropPrimaryKey("AsistenteEventoPK", "AsistenteEvento"); //4
    $this->dropTable("AsistenteEvento"); //3

    $this->dropPrimaryKey("AsistentePK", "Asistente"); //2
    $this->dropTable("Asistente"); //1

  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260512_174233_new_table_asistente_actividad cannot be reverted.\n";

        return false;
    }
    */
}
