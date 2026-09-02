<?php

$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5432';
$name = getenv('DB_NAME') ?: 'base';
$user = getenv('DB_USER') ?: 'base';
$password = getenv('DB_PASSWORD') ?: 'base';

return [
    'class' => 'yii\\db\\Connection',
    'dsn' => "pgsql:host={$host};port={$port};dbname={$name}",
    'username' => $user,
    'password' => $password,
    'charset' => 'utf8',
];
