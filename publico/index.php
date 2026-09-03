<?php

$yiiEnv = getenv('YII_ENV') ?: 'prod';
$yiiDebug = getenv('YII_DEBUG');

defined('YII_ENV') or define('YII_ENV', $yiiEnv);
defined('YII_DEBUG') or define(
  'YII_DEBUG',
  $yiiDebug === false ? false : filter_var($yiiDebug, FILTER_VALIDATE_BOOLEAN)
);
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
