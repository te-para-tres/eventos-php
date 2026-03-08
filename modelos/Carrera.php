<?php

namespace app\modelos;

use Yii;

/**
* Clase modelo para la tabla "Carrera".
*
* @property string $id
* @property string|null $idUnidadAcademica
* @property string|null $nombre
* @property string|null $descripcion
* @property string|null $tipo
* @property string|null $estado
* @property string|null $creado
* @property string|null $modificado
* @property string|null $eliminado
*
* @property Evento[] $eventos
* @property UnidadAcademica $unidadAcademica
*/
class Carrera extends ModeloBase {

  /**
  * {@inheritdoc}
  */
  public static function tableName() {
    return 'Carrera';
  }

  /**
  * {@inheritdoc}
  */
  public function rules() {
    return [
      [['idUnidadAcademica', 'nombre', 'descripcion', 'tipo', 'estado', 'creado', 'modificado', 'eliminado'], 'default', 'value' => null],
      [['id'], 'required'],
      [['creado', 'modificado', 'eliminado'], 'safe'],
      [['id', 'idUnidadAcademica'], 'string', 'max' => 36],
      [['nombre', 'descripcion', 'tipo', 'estado'], 'string', 'max' => 255],
      [['id'], 'unique'],
      [['idUnidadAcademica'], 'exist', 'skipOnError' => true, 'targetClass' => UnidadAcademica::class, 'targetAttribute' => ['idUnidadAcademica' => 'id']],
    ];
  }

  /**
  * {@inheritdoc}
  */
  public function attributeLabels() {
    return [
      'id' => 'ID',
      'idUnidadAcademica' => 'Id Unidad Academica',
      'nombre' => 'Nombre',
      'descripcion' => 'Descripcion',
      'tipo' => 'Tipo',
      'estado' => 'Estado',
      'creado' => 'Creado',
      'modificado' => 'Modificado',
      'eliminado' => 'Eliminado',
    ];
  }

  public function fields () {
    return [
      'id',
      'idUnidadAcademica',
      'nombre',
      'descripcion',
      'tipo',
      'estado',
      'creado',
      'modificado',
      'eliminado',
    ];
  }

  public function extraFields() {
    return [
      'eventos',
      'unidadAcademica',
    ];
  }


  public function getEventos() {
    return $this->hasMany(Evento::class, ['idCarrera' => 'id']);
  }

  public function getUnidadAcademica() {
    return $this->hasOne(UnidadAcademica::class, ['id' => 'idUnidadAcademica']);
  }
}