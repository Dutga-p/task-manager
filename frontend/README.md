# Frontend – Task Manager

Este es el módulo “frontend” del proyecto **Task Manager**, implementado con Vue.js. Su función es proporcionar la interfaz de usuario que consume la API del backend.

## Estructura del proyecto

- `src/` – código fuente de la aplicación Vue (componentes, vistas, rutas, estado)  
- `public/` – activos públicos (ícono, `index.html`, etc.)  
- `package.json`, `vue.config.js` (o similar) – configuración de dependencias, scripts, puertos, variables de entorno  
- Otros archivos de configuración (por ejemplo: `.env`, `.gitignore`, README adicional)

## Tecnologías principales

- Vue.js  
- Router de Vue (vue‑router)  
- Estado global o administración de datos (Vuex / Pinia)  
- Axios (o fetch) para comunicación con el backend  
- CSS / SCSS / framework de estilos (Tailwind, Bootstrap, Bulma, etc.)  
- Build & bundling (Webpack / Vite)  

## Instalación y puesta en marcha

1. Clona o accede a la carpeta del frontend:  
   ```bash
   cd frontend/
   ```
2. Instala dependencias:  
   ```bash
   npm install
   # o
   yarn install
   ```
3. Configura la URL base de la API (si aplica):  
   Por ejemplo, crea o edita un archivo `.env.local` o similar:
   ```env
   VUE_APP_API_BASE_URL=http://localhost:8000/api
   ```
4. Inicia el servidor de desarrollo:  
   ```bash
   npm run serve
   # o
   yarn serve
   ```
   Luego abre en el navegador `http://localhost:8080` (o el puerto que muestre).

5. Para construir la versión de producción:  
   ```bash
   npm run build
   # o
   yarn build
   ```

## Configuración adicional

- Si el backend corre en otro puerto o dominio, configura CORS, proxy local o `vue.config.js` para evitar problemas de origen cruzado.  
- Variables de entorno: puedes definir `VUE_APP_API_BASE_URL`, `VUE_APP_ENV`, `VUE_APP_DEBUG`, etc.  
- Estilo de código: puedes agregar `eslint`, `prettier`, tests unitarios o de integración si quieres.  
- Producción: sirve los archivos de `dist/` usando un servidor estático (Nginx, Apache) o plataforma de hosting.


## Objetivo del frontend

Este módulo busca:  
- Ofrecer una interfaz sencilla para que los usuarios gestionen sus tareas (crear, ver, editar, eliminar).  
- Comunicar con el backend mediante API REST y mostrar los datos de forma clara.  
- Ser responsivo, fácil de usar, y servir como base para futuras extensiones o mejoras (por ejemplo panel de administración, usuarios, roles, notificaciones).

## Estructura sugerida mínima

```
frontend/
├─ public/
│  └─ index.html
├─ src/
│  ├─ assets/
│  ├─ components/
│  ├─ views/
│  ├─ router/
│  ├─ store/
│  └─ App.vue
├─ .env.local
├─ package.json
└─ README.md
```

---

¡Gracias por usar este módulo! Si tienes sugerencias o quieres contribuir, abre un **issue** o envía un **pull request**.
