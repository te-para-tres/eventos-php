<?php

// Configuración del generador de documentación OpenAPI (edesarrollos/yii2-ed ^2.0)
// Uso: php yii openapi/generar  ->  genera publico/openapi.json y publico/scalar.html
return [
  'title' => 'API Eventos UES',
  'version' => '1.0.0',
  'description' => 'API REST del sistema de gestión de eventos de la Universidad Estatal de Sonora. Expone dos familias de endpoints: el módulo v1 (administración, requiere JWT Bearer) y el módulo api (consulta pública).',
  'formats' => ['json', 'xml', 'csv', 'html', 'xlsx', 'pdf', 'docx'],
  'servers' => [
    [
      'url' => 'https://api.eventues.app',
      'description' => 'Producción',
    ],
    [
      'url' => 'http://localhost:8080',
      'description' => 'Servidor local',
    ],
  ],
  'controllers' => [
    [
      'module' => 'v1',
      'path' => '@app/modulos/v1/controladores',
      'namespace' => 'v1\controladores',
    ],
    [
      'module' => 'api',
      'path' => '@app/modulos/api/controllers',
      'namespace' => 'api\controllers',
    ],
  ],
  'output' => '@publico/openapi.json',
  'scalar' => [
    'title' => 'API Eventos UES - Documentación',
    'specUrl' => './openapi.json',
    'output' => '@publico/scalar.html',
    'cdnUrl' => 'https://cdn.jsdelivr.net/npm/@scalar/api-reference',
  ],
];