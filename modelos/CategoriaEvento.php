<?php

namespace app\modelos;

use Yii;

/**
* Clase modelo para la tabla "CategoriaEvento".
*
* @property string $id
* @property string|null $clave
* @property string|null $nombre
* @property string|null $descripcion
* @property string|null $creado
* @property string|null $modificado
* @property string|null $eliminado
*
* @property Evento[] $eventos
*/
class CategoriaEvento extends ModeloBase {

  /**
  * {@inheritdoc}
  */
  public static function tableName() {
    return 'CategoriaEvento';
  }

  /**
  * {@inheritdoc}
  */
  public function rules() {
    return [
      [['clave', 'nombre', 'descripcion', 'creado', 'modificado', 'eliminado'], 'default', 'value' => null],
      [['id'], 'required'],
      [['creado', 'modificado', 'eliminado'], 'safe'],
      [['id'], 'string', 'max' => 36],
      [['clave', 'nombre', 'descripcion'], 'string', 'max' => 255],
      [['id'], 'unique'],
    ];
  }

  /**
  * {@inheritdoc}
  */
  public function attributeLabels() {
    return [
      'id' => 'ID',
      'clave' => 'Clave',
      'nombre' => 'Nombre',
      'descripcion' => 'Descripcion',
      'creado' => 'Creado',
      'modificado' => 'Modificado',
      'eliminado' => 'Eliminado',
    ];
  }

  public function fields () {
    return [
      'id',
      'clave',
      'nombre',
      'descripcion',
      'creado',
      'modificado',
      'eliminado',
    ];
  }

  public function extraFields() {
    return [
      'eventos',
    ];
  }


  public function getEventos() {
    return $this->hasMany(Evento::class, ['idCategoriaEvento' => 'id']);
  }
}