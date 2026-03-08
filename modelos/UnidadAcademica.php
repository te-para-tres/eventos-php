<?php

namespace app\modelos;

use Yii;

/**
* Clase modelo para la tabla "UnidadAcademica".
*
* @property string $id
* @property string|null $nombre
* @property string|null $descripcion
* @property string|null $telefono
* @property string|null $correo
* @property string|null $estado
* @property string|null $creado
* @property string|null $modificado
* @property string|null $eliminado
*
* @property Carrera[] $carreras
* @property Evento[] $eventos
*/
class UnidadAcademica extends ModeloBase {

  /**
  * {@inheritdoc}
  */
  public static function tableName() {
    return 'UnidadAcademica';
  }

  /**
  * {@inheritdoc}
  */
  public function rules() {
    return [
      [['nombre', 'descripcion', 'telefono', 'correo', 'estado', 'creado', 'modificado', 'eliminado'], 'default', 'value' => null],
      [['id'], 'required'],
      [['creado', 'modificado', 'eliminado'], 'safe'],
      [['id'], 'string', 'max' => 36],
      [['nombre', 'descripcion', 'telefono', 'correo', 'estado'], 'string', 'max' => 255],
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
      'telefono' => 'Telefono',
      'correo' => 'Correo',
      'estado' => 'Estado',
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
      'telefono',
      'correo',
      'estado',
      'creado',
      'modificado',
      'eliminado',
    ];
  }

  public function extraFields() {
    return [
      'carreras',
      'eventos',
    ];
  }


  public function getCarreras() {
    return $this->hasMany(Carrera::class, ['idUnidadAcademica' => 'id']);
  }

  public function getEventos() {
    return $this->hasMany(Evento::class, ['idUnidadAcademica' => 'id']);
  }
}