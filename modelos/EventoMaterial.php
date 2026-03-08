<?php

namespace app\modelos;

use Yii;

/**
* Clase modelo para la tabla "EventoMaterial".
*
* @property string $id
* @property string|null $idEvento
* @property string|null $idMaterial
* @property int|null $cantidad
* @property string|null $creado
* @property string|null $modificado
* @property string|null $eliminado
*
* @property Evento $evento
* @property Material $material
*/
class EventoMaterial extends ModeloBase {

  /**
  * {@inheritdoc}
  */
  public static function tableName() {
    return 'EventoMaterial';
  }

  /**
  * {@inheritdoc}
  */
  public function rules() {
    return [
      [['idEvento', 'idMaterial', 'cantidad', 'creado', 'modificado', 'eliminado'], 'default', 'value' => null],
      [['id'], 'required'],
      [['cantidad'], 'default', 'value' => null],
      [['cantidad'], 'integer'],
      [['creado', 'modificado', 'eliminado'], 'safe'],
      [['id', 'idEvento', 'idMaterial'], 'string', 'max' => 36],
      [['id'], 'unique'],
      [['idEvento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::class, 'targetAttribute' => ['idEvento' => 'id']],
      [['idMaterial'], 'exist', 'skipOnError' => true, 'targetClass' => Material::class, 'targetAttribute' => ['idMaterial' => 'id']],
    ];
  }

  /**
  * {@inheritdoc}
  */
  public function attributeLabels() {
    return [
      'id' => 'ID',
      'idEvento' => 'Id Evento',
      'idMaterial' => 'Id Material',
      'cantidad' => 'Cantidad',
      'creado' => 'Creado',
      'modificado' => 'Modificado',
      'eliminado' => 'Eliminado',
    ];
  }

  public function fields () {
    return [
      'id',
      'idEvento',
      'idMaterial',
      'cantidad',
      'creado',
      'modificado',
      'eliminado',
    ];
  }

  public function extraFields() {
    return [
      'evento',
      'material',
    ];
  }


  public function getEvento() {
    return $this->hasOne(Evento::class, ['id' => 'idEvento']);
  }

  public function getMaterial() {
    return $this->hasOne(Material::class, ['id' => 'idMaterial']);
  }
}