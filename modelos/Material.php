<?php

namespace app\modelos;

use Yii;

/**
* Clase modelo para la tabla "Material".
*
* @property string $id
* @property string|null $nombre
* @property string|null $descripcion
* @property string|null $estado
* @property int|null $cantidad
* @property string|null $nota
* @property string|null $creado
* @property string|null $modificado
* @property string|null $eliminado
*
* @property EventoMaterial[] $eventoMaterials
*/
class Material extends ModeloBase {

  /**
  * {@inheritdoc}
  */
  public static function tableName() {
    return 'Material';
  }

  /**
  * {@inheritdoc}
  */
  public function rules() {
    return [
      [['nombre', 'descripcion', 'estado', 'cantidad', 'nota', 'creado', 'modificado', 'eliminado'], 'default', 'value' => null],
      [['id'], 'required'],
      [['cantidad'], 'default', 'value' => null],
      [['cantidad'], 'integer'],
      [['creado', 'modificado', 'eliminado'], 'safe'],
      [['id'], 'string', 'max' => 36],
      [['nombre', 'descripcion', 'estado', 'nota'], 'string', 'max' => 255],
      [['id'], 'unique'],
    ];
  }

  /**
  * {@inheritdoc}
  */
  public function attributeLabels() {
    return [
      'id' => 'ID',
      'nombre' => 'Nombre',
      'descripcion' => 'Descripcion',
      'estado' => 'Estado',
      'cantidad' => 'Cantidad',
      'nota' => 'Nota',
      'creado' => 'Creado',
      'modificado' => 'Modificado',
      'eliminado' => 'Eliminado',
    ];
  }

  public function fields () {
    return [
      'id',
      'nombre',
      'descripcion',
      'estado',
      'cantidad',
      'nota',
      'creado',
      'modificado',
      'eliminado',
    ];
  }

  public function extraFields() {
    return [
      'eventoMaterial',
    ];
  }


  public function getEventoMaterial() {
    return $this->hasMany(EventoMaterial::class, ['idMaterial' => 'id']);
  }
}