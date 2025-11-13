# Task Manager

**Task Manager** es una aplicación **full‑stack** diseñada para gestionar tareas de manera eficiente.  
Cuenta con una arquitectura modular que separa claramente el **frontend** y el **backend**, lo que facilita el mantenimiento, la escalabilidad y el desarrollo colaborativo.
Despliegue: https://tastmanager12.netlify.app/

---

## Estructura del proyecto

```
task‑manager/
├─ backend/   → Lógica del servidor, base de datos y API
├─ frontend/  → Interfaz de usuario desarrollada con Vue.js
└─ README.md
```

---

## Tecnologías utilizadas

### Frontend
- **Vue.js 3** con componentes reutilizables  
- **Vue Router** para la navegación entre vistas  
- **Axios** para comunicación con la API REST  
- **TailwindCSS** o **Bootstrap** (según preferencia de estilos)  
- **Vite / Webpack** para compilación y optimización

### Backend
- **PHP 8+** con **Laravel** (o framework similar)
- **Blade** como motor de plantillas (si aplica)
- **MySQL** como sistema de gestión de base de datos
- **Eloquent ORM** para manejo de modelos y relaciones
- **API RESTful** para la comunicación con el frontend
- **Autenticación y autorización** con JWT o Laravel Sanctum

---

## Funcionalidades principales

 CRUD completo de tareas (crear, leer, actualizar, eliminar)  
 Filtrado por estado, prioridad o usuario asignado  
 Cambio de estado (“pendiente” → “en curso” → “completada”)  
 Asignación de tareas a usuarios específicos  
 Interfaz clara, responsiva y moderna  
 Persistencia de datos con control de errores  
 Arquitectura escalable y desacoplada

---

## Instalación y puesta en marcha

### Backend

1. Navega al directorio del backend:
   ```bash
   cd backend/
   ```

2. Instala las dependencias:
   ```bash
   composer install
   ```

3. Copia el archivo de entorno:
   ```bash
   cp .env.example .env
   ```

4. Configura tu base de datos en `.env`:
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task_manager_db
   DB_USERNAME=root
   DB_PASSWORD=password
   ```

5. Ejecuta las migraciones y los seeders (si aplica):
   ```bash
   php artisan migrate --seed
   ```

6. Inicia el servidor:
   ```bash
   php artisan serve
   ```

El servidor estará disponible en:  
`http://localhost:8000`

---

### Frontend

1. Navega al directorio del frontend:
   ```bash
   cd frontend/
   ```

2. Instala las dependencias:
   ```bash
   npm install
   # o
   yarn install
   ```

3. Configura la URL base de la API en `src/config.js` (o en `.env.local`):
   ```js
   export const API_BASE_URL = 'http://localhost:8000/api';
   ```

4. Inicia el servidor de desarrollo:
   ```bash
   npm run serve
   # o
   yarn serve
   ```

5. Abre el navegador en:  
 `http://localhost:8080`

---

## Configuración adicional

- Asegúrate de que el backend y frontend estén corriendo simultáneamente.  
- Si usas **CORS**, configura correctamente los orígenes permitidos.  
- Revisa tus credenciales de base de datos y variables de entorno (`APP_ENV`, `APP_DEBUG`, etc.).  
- Para producción:  
  - Compila el frontend con `npm run build`.  
  - Configura un servidor (Nginx/Apache) y SSL.  
  - Usa `.env.production` para variables específicas.

---

## Objetivo del proyecto

**Task Manager** busca ofrecer una solución práctica y didáctica para la gestión de tareas, ideal tanto para proyectos de aprendizaje como para implementaciones reales en equipos pequeños.  
Su arquitectura limpia y desacoplada permite extender fácilmente el sistema con nuevas funcionalidades como:

- Notificaciones y recordatorios  
- Gestión de roles y permisos  
- Integración con APIs externas  
- Aplicación móvil o PWA  
- Dashboard con métricas y estadísticas  

---

*Desarrollado con pasión por [Dutga‑p](https://github.com/Dutga-p)*  
¡Las contribuciones y sugerencias son bienvenidas!
