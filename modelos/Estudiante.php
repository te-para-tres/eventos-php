<?php

namespace app\modelos;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Ramsey\Uuid\Uuid;
use Yii;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
* Clase modelo para la tabla "Estudiante".
*
* @property string $id
* @property string|null $idUnidadAcademica
* @property string|null $idCarrera
* @property string|null $idMedia
* @property string $expediente
* @property string $correo
* @property string $clave
* @property string $nombre
* @property string $apellidos
* @property string|null $telefono
* @property int|null $estatus 0:inactivo, 1:activo
* @property string|null $creado
* @property string|null $modificado
* @property string|null $eliminado
*
* @property UnidadAcademica $unidadAcademica
* @property Carrera $carrera
* @property Media $media
*/
class Estudiante extends ModeloBase implements IdentityInterface {

  public const ACTIVO = 1;
  public const INACTIVO = 0;
  public const DURACION_TOKEN = 3600;

  /**
  * {@inheritdoc}
  */
  public static function tableName() {
    return 'Estudiante';
  }

  /**
  * {@inheritdoc}
  */
  public function rules() {
    return [
      [['correo'], 'filter', 'filter' => fn($valor) => strtolower(trim((string)$valor))],
      [['idUnidadAcademica', 'idCarrera', 'idMedia', 'telefono', 'creado', 'modificado', 'eliminado'], 'default', 'value' => null],
      [['estatus'], 'default', 'value' => self::ACTIVO],
      [['id', 'expediente', 'correo', 'clave', 'nombre', 'apellidos'], 'required'],
      [['estatus'], 'integer'],
      [['creado', 'modificado', 'eliminado'], 'safe'],
      [['id', 'idUnidadAcademica', 'idCarrera', 'idMedia'], 'string', 'max' => 36],
      [['expediente', 'correo', 'clave', 'nombre', 'apellidos', 'telefono'], 'string', 'max' => 255],
      [['clave'], 'string', 'min' => 8],
      [['correo'], 'email'],
      [['id'], 'unique'],
      [['correo'], 'unique'],
      [['expediente'], 'unique'],
      [['idUnidadAcademica'], 'exist', 'skipOnError' => true, 'targetClass' => UnidadAcademica::class, 'targetAttribute' => ['idUnidadAcademica' => 'id']],
      [['idCarrera'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::class,
        'targetAttribute' => ['idCarrera' => 'id', 'idUnidadAcademica' => 'idUnidadAcademica'],
        'message' => 'La carrera no pertenece a la unidad académica seleccionada.'],
      [['idMedia'], 'exist', 'skipOnError' => true, 'targetClass' => Media::class, 'targetAttribute' => ['idMedia' => 'id']],
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
      'idMedia' => 'Id Media',
      'expediente' => 'Expediente',
      'correo' => 'Correo',
      'clave' => 'Clave',
      'nombre' => 'Nombre',
      'apellidos' => 'Apellidos',
      'telefono' => 'Telefono',
      'estatus' => 'Estatus',
      'creado' => 'Creado',
      'modificado' => 'Modificado',
      'eliminado' => 'Eliminado',
    ];
  }

  // 'clave' se omite a propósito para no exponer el hash en la API
  public function fields () {
    return [
      'id',
      'idUnidadAcademica',
      'idCarrera',
      'idMedia',
      'expediente',
      'correo',
      'nombre',
      'apellidos',
      'telefono',
      'estatus',
      'creado',
      'modificado',
      'eliminado',
    ];
  }

  public function extraFields() {
    return [
      'unidadAcademica',
      'carrera',
      'media',
    ];
  }

  public function agregarClave($pwd) {
    $this->clave = Yii::$app->getSecurity()->generatePasswordHash($pwd);
  }

  public function validarClave($pwd) {
    return Yii::$app->getSecurity()->validatePassword($pwd, $this->clave);
  }

  public function beforeSave($insert) {
    if ($insert || $this->isAttributeChanged('clave')) {
      $this->agregarClave($this->clave);
    }

    return parent::beforeSave($insert);
  }

  public static function findIdentity($id) {
    return static::findOne(['id' => $id, 'eliminado' => null, 'estatus' => self::ACTIVO]);
  }

  public static function findIdentityByAccessToken($token, $type = null) {
    try {
      $jwt = JWT::decode($token, new Key(Yii::$app->params['jwt.key'], 'HS256'));
    } catch (\Exception $e) {
      return null;
    }

    return isset($jwt->id) ? static::findIdentity($jwt->id) : null;
  }

  public function getId() {
    return $this->id;
  }

  public function getAuthKey() {
    $token = [
      "id" => $this->id,
      "exp" => time() + self::DURACION_TOKEN,
    ];

    return JWT::encode($token, Yii::$app->params['jwt.key'], 'HS256');
  }

  public function validateAuthKey($authKey) {
    return $this->getAuthKey() === $authKey;
  }

  public function addRefreshToken() {
    $refreshToken = new RefreshTokenEstudiante();
    $refreshToken->token = Uuid::uuid4()->toString();
    $refreshToken->idEstudiante = $this->id;
    $refreshToken->expiracion = new Expression("NOW() + INTERVAL '30 DAYS'");
    $refreshToken->creado = new Expression('NOW()');
    if (!$refreshToken->save()) {
      throw new \Exception("Error al generar el refresh token");
    }

    return $refreshToken->token;
  }

  public function getUnidadAcademica() {
    return $this->hasOne(UnidadAcademica::class, ['id' => 'idUnidadAcademica']);
  }

  public function getCarrera() {
    return $this->hasOne(Carrera::class, ['id' => 'idCarrera']);
  }

  public function getMedia() {
    return $this->hasOne(Media::class, ['id' => 'idMedia']);
  }
}
