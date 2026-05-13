<?php

namespace app\modelos;

use Yii;

/**
* Clase modelo para la tabla "AsistenteEvento".
*
* @property string $id
* @property string|null $idAsistente
* @property string|null $idEvento
* @property string|null $creado
* @property string|null $modificado
* @property string|null $eliminado
*
* @property Asistente $asistente0
* @property Evento $evento0
*/
class AsistenteEvento extends ModeloBase {

  /**
  * {@inheritdoc}
  */
  public static function tableName() {
    return 'AsistenteEvento';
  }

  /**
  * {@inheritdoc}
  */
  public function rules() {
    return [
      [['idAsistente', 'idEvento', 'creado', 'modificado', 'eliminado'], 'default', 'value' => null],
      [['id'], 'required'],
      [['creado', 'modificado', 'eliminado'], 'safe'],
      [['id', 'idAsistente', 'idEvento'], 'string', 'max' => 36],
      [['id'], 'unique'],
      [['idAsistente'], 'exist', 'skipOnError' => true, 'targetClass' => Asistente::class, 'targetAttribute' => ['idAsistente' => 'id']],
      [['idEvento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::class, 'targetAttribute' => ['idEvento' => 'id']],
    ];
  }

  /**
  * {@inheritdoc}
  */
  public function attributeLabels() {
    return [
      'id' => 'ID',
      'idAsistente' => 'Id Asistente',
      'idEvento' => 'Id Evento',
      'creado' => 'Creado',
      'modificado' => 'Modificado',
      'eliminado' => 'Eliminado',
    ];
  }

  public function fields () {
    return [
      'id',
      'idAsistente',
      'idEvento',
      'creado',
      'modificado',
      'eliminado',
    ];
  }

  public function extraFields() {
    return [
      'asistente0',
      'evento0',
    ];
  }


  public function getAsistente0() {
    return $this->hasOne(Asistente::class, ['id' => 'idAsistente']);
  }

  public function getEvento0() {
    return $this->hasOne(Evento::class, ['id' => 'idEvento']);
  }
}