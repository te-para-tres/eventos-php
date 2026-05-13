<?php

namespace app\modelos;

use Yii;

/**
* Clase modelo para la tabla "Asistente".
*
* @property string $id
* @property string|null $idUnidadAcademica
* @property string|null $idCarrera
* @property string|null $expediente
* @property string|null $carrera
* @property string|null $nombre
* @property string|null $creado
* @property string|null $modificado
* @property string|null $eliminado
*
* @property AsistenteEvento[] $asistenteEventos
*/
class Asistente extends ModeloBase {

  /**
  * {@inheritdoc}
  */
  public static function tableName() {
    return 'Asistente';
  }

  /**
  * {@inheritdoc}
  */
  public function rules() {
    return [
      [['idUnidadAcademica', 'idCarrera', 'expediente', 'carrera', 'nombre', 'creado', 'modificado', 'eliminado'], 'default', 'value' => null],
      [['id'], 'required'],
      [['creado', 'modificado', 'eliminado'], 'safe'],
      [['id', 'idUnidadAcademica', 'idCarrera'], 'string', 'max' => 36],
      [['expediente'], 'string', 'max' => 13],
      [['carrera'], 'string', 'max' => 150],
      [['nombre'], 'string', 'max' => 300],
      [['id'], 'unique'],
    ];
  }

  /**
  * {@inheritdoc}
  */
  public function attributeLabels() {
    return [
      'id' => 'ID',
      'idUnidadAcademica' => 'Id Unidad Academica',
      'idCarrera' => 'Id Carrera',
      'expediente' => 'Expediente',
      'carrera' => 'Carrera',
      'nombre' => 'Nombre',
      'creado' => 'Creado',
      'modificado' => 'Modificado',
      'eliminado' => 'Eliminado',
    ];
  }

  public function fields () {
    return [
      'id',
      'idUnidadAcademica',
      'idCarrera',
      'expediente',
      'carrera',
      'nombre',
      'creado',
      'modificado',
      'eliminado',
    ];
  }

  public function extraFields() {
    return [
      'asistenteEventos',
    ];
  }


  public function getAsistenteEventos() {
    return $this->hasMany(AsistenteEvento::class, ['idAsistente' => 'id']);
  }
}