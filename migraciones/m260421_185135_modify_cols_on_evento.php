<?php

use yii\db\Migration;

class m260421_185135_modify_cols_on_evento extends Migration {
  /**
   * {@inheritdoc}
   */
  public function safeUp() {
    $this->addColumn("Evento", "fechaCancelacion", $this->timestamp()->append("with time zone"));
    $this->addColumn("Evento", "visibilidad", $this->string(50));
    $this->addColumn("Evento", "idQr", $this->string(36));
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown() {
    $this->dropColumn("Evento", "fechaCancelacion");
    $this->dropColumn("Evento", "visibilidad");
    $this->dropColumn("Evento", "idQr");
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260421_185135_modify_cols_on_evento cannot be reverted.\n";

        return false;
    }
    */
}
