<p align="center">
    <a href="https://edesarrollos.com" target="_blank">
        <img src="https://edesarrollos.com/img/logo.png" height="100px">
    </a>
    <h1 align="center">Extensión de eDesarrollos para Yii 2</h1>
    <br>
</p>

Proyecto Base de eDesarrollos
=============================

Instalación
-----------

Para instalar el proyecto, utiliza el siguiente comando:

```bash
composer create-project --prefer-dist edesarrollos/yii2-app-ed
```

Servidor Web de Desarrollo
--------------------------

Para iniciar el servidor local:

```bash
php index.php
```

Estructura de Configuración
---------------------------

- `config/params.php`: Contiene la configuración general. La `jwt.key` se lee dinámicamente desde el archivo secreto local.
- `config/db.php`: Configuración de la base de datos (ignorado por Git, debe configurarse por entorno).

Docker y Dokploy
----------------

El proyecto incluye una imagen PHP/Apache y un servicio PostgreSQL. Antes de
levantar la aplicación, el contenedor ejecuta automáticamente las migraciones
de Yii configuradas en `migraciones/`.

Para probarlo localmente:

```bash
docker compose up --build
```

En Dokploy, crea un servicio de tipo **Docker Compose**, selecciona
`compose.yaml` como Compose Path y configura el dominio apuntando al puerto
interno `80` del servicio `app`.

Configura estos **Watch Paths** en Dokploy para que los cambios relevantes
disparen un nuevo despliegue:

```text
migraciones/**
composer.json
Dockerfile
compose.yaml
```

Cada despliegue reconstruye la imagen cuando corresponde y el entrypoint vuelve
a ejecutar `php yii migrate --interactive=0`. La tabla de migraciones de Yii
evita aplicar dos veces una migración ya registrada.
