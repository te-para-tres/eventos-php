<?php

namespace app\modelos;

use Yii;

/**
* Clase modelo para la tabla "EventoMedia".
*
* @property string $id
* @property string|null $idMedia
* @property string|null $idEvento
* @property string|null $creado
* @property string|null $modificado
* @property string|null $eliminado
*
* @property Evento $evento
* @property Media $media
*/
class EventoMedia extends ModeloBase {

  /**
  * {@inheritdoc}
  */
  public static function tableName() {
    return 'EventoMedia';
  }

  /**
  * {@inheritdoc}
  */
  public function rules() {
    return [
      [['idMedia', 'idEvento', 'creado', 'modificado', 'eliminado'], 'default', 'value' => null],
      [['id'], 'required'],
      [['creado', 'modificado', 'eliminado'], 'safe'],
      [['id', 'idMedia', 'idEvento'], 'string', 'max' => 36],
      [['id'], 'unique'],
      [['idEvento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::class, 'targetAttribute' => ['idEvento' => 'id']],
      [['idMedia'], 'exist', 'skipOnError' => true, 'targetClass' => Media::class, 'targetAttribute' => ['idMedia' => 'id']],
    ];
  }

  /**
  * {@inheritdoc}
  */
  public function attributeLabels() {
    return [
      'id' => 'ID',
      'idMedia' => 'Id Media',
      'idEvento' => 'Id Evento',
      'creado' => 'Creado',
      'modificado' => 'Modificado',
      'eliminado' => 'Eliminado',
    ];
  }

  public function fields () {
    return [
      'id',
      'idMedia',
      'idEvento',
      'creado',
      'modificado',
      'eliminado',
    ];
  }

  public function extraFields() {
    return [
      'evento0',
      'media0',
    ];
  }


  public function getEvento() {
    return $this->hasOne(Evento::class, ['id' => 'idEvento']);
  }

  public function getMedia() {
    return $this->hasOne(Media::class, ['id' => 'idMedia']);
  }
}