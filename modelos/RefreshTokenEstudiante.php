<?php

namespace app\modelos;

/**
 * Clase modelo para la tabla "RefreshTokenEstudiante".
 *
 * @property string $token
 * @property string|null $idEstudiante
 * @property string|null $expiracion Fecha en que el token expira
 * @property string|null $creado Fecha de creacion del token
 * @property string|null $eliminado Eliminar validez del token
 *
 * @property Estudiante $estudiante
 */
class RefreshTokenEstudiante extends \yii\db\ActiveRecord {

  /**
   * {@inheritdoc}
   */
  public static function tableName() {
    return 'RefreshTokenEstudiante';
  }

  /**
   * {@inheritdoc}
   */
  public function rules() {
    return [
      [['token'], 'required'],
      [['expiracion', 'creado', 'eliminado'], 'safe'],
      [['token', 'idEstudiante'], 'string', 'max' => 36],
      [['token'], 'unique'],
      [['idEstudiante'], 'exist', 'skipOnError' => true, 'targetClass' => Estudiante::class, 'targetAttribute' => ['idEstudiante' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels() {
    return [
      'token' => 'Token',
      'idEstudiante' => 'Id Estudiante',
      'expiracion' => 'Expiracion',
      'creado' => 'Creado',
      'eliminado' => 'Eliminado',
    ];
  }

  public function fields() {
    return [
      'token',
      'idEstudiante',
      'expiracion',
      'creado',
      'eliminado',
    ];
  }

  public function extraFields() {
    return [
      'estudiante',
    ];
  }

  public function getEstudiante() {
    return $this->hasOne(Estudiante::class, ['id' => 'idEstudiante']);
  }
}
