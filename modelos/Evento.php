<?php

namespace app\modelos;

use Yii;

/**
* Clase modelo para la tabla "Evento".
*
* @property string $id
* @property string|null $idUnidadAcademica
* @property string|null $idCategoriaEvento
* @property string|null $idCarrera
* @property string|null $idImagenDestacada
* @property string|null $nombre
* @property string|null $descripcion
* @property string|null $fechaInicio
* @property string|null $fechaFin
* @property int|null $capacidadMaxima
* @property int|null $capacidadMinima
* @property string|null $estado
* @property string|null $lugar
* @property float|null $latitud
* @property float|null $longitud
* @property string|null $creado
* @property string|null $modificado
* @property string|null $eliminado
*
* @property EventoMaterial[] $eventoMaterials
* @property EventoMedia[] $eventoMedia
* @property Carrera $carrera
* @property CategoriaEvento $categoriaEvento
* @property Media $imagenDestacada
* @property UnidadAcademica $unidadAcademica
*/
class Evento extends ModeloBase {

  /**
  * {@inheritdoc}
  */
  public static function tableName() {
    return 'Evento';
  }

  /**
  * {@inheritdoc}
  */
  public function rules() {
    return [
      [['idUnidadAcademica', 'idCategoriaEvento', 'idCarrera', 'idImagenDestacada', 'nombre', 'descripcion', 'fechaInicio', 'fechaFin', 'capacidadMaxima', 'capacidadMinima', 'estado', 'lugar', 'latitud', 'longitud', 'creado', 'modificado', 'eliminado'], 'default', 'value' => null],
      [['id'], 'required'],
      [['fechaInicio', 'fechaFin', 'creado', 'modificado', 'eliminado'], 'safe'],
      [['capacidadMaxima', 'capacidadMinima'], 'default', 'value' => null],
      [['capacidadMaxima', 'capacidadMinima'], 'integer'],
      [['latitud', 'longitud'], 'number'],
      [['id', 'idUnidadAcademica', 'idCategoriaEvento', 'idCarrera', 'idImagenDestacada'], 'string', 'max' => 36],
      [['nombre', 'descripcion', 'estado', 'lugar'], 'string', 'max' => 255],
      [['id'], 'unique'],
      [['idCarrera'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::class, 'targetAttribute' => ['idCarrera' => 'id']],
      [['idCategoriaEvento'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriaEvento::class, 'targetAttribute' => ['idCategoriaEvento' => 'id']],
      [['idImagenDestacada'], 'exist', 'skipOnError' => true, 'targetClass' => Media::class, 'targetAttribute' => ['idImagenDestacada' => 'id']],
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
      'idCategoriaEvento' => 'Id Categoria Evento',
      'idCarrera' => 'Id Carrera',
      'idImagenDestacada' => 'Id Imagen Destacada',
      'nombre' => 'Nombre',
      'descripcion' => 'Descripcion',
      'fechaInicio' => 'Fecha Inicio',
      'fechaFin' => 'Fecha Fin',
      'capacidadMaxima' => 'Capacidad Maxima',
      'capacidadMinima' => 'Capacidad Minima',
      'estado' => 'Estado',
      'lugar' => 'Lugar',
      'latitud' => 'Latitud',
      'longitud' => 'Longitud',
      'creado' => 'Creado',
      'modificado' => 'Modificado',
      'eliminado' => 'Eliminado',
    ];
  }

  public function fields () {
    return [
      'id',
      'idUnidadAcademica',
      'idCategoriaEvento',
      'idCarrera',
      'idImagenDestacada',
      'nombre',
      'descripcion',
      'fechaInicio',
      'fechaFin',
      'capacidadMaxima',
      'capacidadMinima',
      'estado',
      'lugar',
      'latitud',
      'longitud',
      'creado',
      'modificado',
      'eliminado',
    ];
  }

  public function extraFields() {
    return [
      'eventoMaterial',
      'eventoMedia',
      'carrera',
      'categoriaEvento',
      'imagenDestacada',
      'unidadAcademica',
    ];
  }


  public function getEventoMaterial() {
    return $this->hasMany(EventoMaterial::class, ['idEvento' => 'id']);
  }

  public function getEventoMedia() {
    return $this->hasMany(EventoMedia::class, ['idEvento' => 'id']);
  }

  public function getCarrera() {
    return $this->hasOne(Carrera::class, ['id' => 'idCarrera']);
  }

  public function getCategoriaEvento() {
    return $this->hasOne(CategoriaEvento::class, ['id' => 'idCategoriaEvento']);
  }

  public function getImagenDestacada() {
    return $this->hasOne(Media::class, ['id' => 'idImagenDestacada']);
  }

  public function getUnidadAcademica() {
    return $this->hasOne(UnidadAcademica::class, ['id' => 'idUnidadAcademica']);
  }
}