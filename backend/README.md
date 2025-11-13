# Backend – Task Manager

Este es el módulo **backend** del proyecto **Task Manager**, encargado de manejar la lógica de negocio, la base de datos y la API que consume el frontend.

## Estructura del proyecto

- `app/` – lógica de aplicación (controladores, modelos, servicios)
- `routes/` – rutas de la API
- `database/` – migraciones y seeds
- `resources/` – vistas Blade o plantillas
- `.env` – variables de entorno
- `composer.json` – dependencias PHP/Laravel

## Tecnologías principales

- PHP (versión >=8)
- Framework: Laravel
- Base de datos: MySQL
- API RESTful
- Autenticación (JWT o Sanctum)
- Blade templates (si aplica)

## Instalación y puesta en marcha

```bash
cd backend/
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

El servidor correrá por defecto en `http://localhost:8000`.

## Configuración del entorno

Edita el archivo `.env`:

```dotenv
APP_NAME=TaskManager
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager_db
DB_USERNAME=root
DB_PASSWORD=
```

---

¡Gracias por contribuir o revisar este módulo! Si tienes sugerencias, abre un **issue** o un **pull request**.
