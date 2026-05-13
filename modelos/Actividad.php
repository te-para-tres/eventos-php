<?php

namespace app\modelos;

use Yii;

/**
* Clase modelo para la tabla "Actividad".
*
* @property string $id
* @property string|null $clave
* @property string|null $descripcion
* @property string|null $nombre
* @property string|null $creado
* @property string|null $modificado
* @property string|null $eliminado
*
* @property Evento[] $eventos
*/
class Actividad extends ModeloBase {

  /**
  * {@inheritdoc}
  */
  public static function tableName() {
    return 'Actividad';
  }

  /**
  * {@inheritdoc}
  */
  public function rules() {
    return [
      [['clave', 'descripcion', 'nombre', 'creado', 'modificado', 'eliminado'], 'default', 'value' => null],
      [['id'], 'required'],
      [['creado', 'modificado', 'eliminado'], 'safe'],
      [['id'], 'string', 'max' => 36],
      [['clave'], 'string', 'max' => 40],
      [['descripcion'], 'string', 'max' => 300],
      [['nombre'], 'string', 'max' => 120],
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
      'descripcion' => 'Descripcion',
      'nombre' => 'Nombre',
      'creado' => 'Creado',
      'modificado' => 'Modificado',
      'eliminado' => 'Eliminado',
    ];
  }

  public function fields () {
    return [
      'id',
      'clave',
      'descripcion',
      'nombre',
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
    return $this->hasMany(Evento::class, ['idActividad' => 'id']);
  }
}