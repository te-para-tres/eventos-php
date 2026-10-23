<?php

namespace app\modelos;

class EstudianteSesion extends Estudiante {

  public function fields() {
    return array_merge(parent::fields(), [
      'token' => function ($model) {
        return $model->getAuthKey();
      },
      'refreshToken' => function ($model) {
        return $model->addRefreshToken();
      },
    ]);
  }
}
