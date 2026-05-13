<?php

use yii\db\Migration;

class m260512_235818_rename_media extends Migration {
  /**
   * {@inheritdoc}
   */
  public function safeUp() {
    $this->alterColumn("Media", "idUsuario", $this->string(36));
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown() {
    $this->execute('ALTER TABLE "Media" ALTER COLUMN "idUsuario" TYPE integer USING "idUsuario"::integer');
  }
}
