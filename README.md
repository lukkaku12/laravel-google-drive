# Proyecto Laravel - API Backend

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  </a>
</p>

---

## Descripción

Este proyecto es un backend desarrollado en Laravel que cuenta con autenticación avanzada usando JWT y OAuth con Google. Además, integra almacenamiento de archivos en AWS S3, y está preparado para correr en contenedores Docker con un servidor Nginx como proxy reverso.

El proyecto está pensado para ser escalable, seguro y fácil de desplegar en ambientes de producción.

---

## Features Principales

- **Autenticación JWT** para APIs seguras y stateless.
- **OAuth2 con Google** para login social.
- **Almacenamiento de archivos en AWS S3**, permitiendo subir y servir archivos de forma eficiente y segura.
- **Docker + Nginx**: Contenedores configurados para desarrollo y producción.
- **API RESTful** con endpoints protegidos.
- Middleware y políticas de autorización para roles y permisos.
- Manejo de errores y validaciones con respuestas JSON claras.
- Sistema de migraciones y seeders para manejo de base de datos.

---

## Tecnologías y Herramientas

| Herramienta      | Descripción                           |
|------------------|-------------------------------------|
| Laravel          | Framework PHP para backend robusto  |
| JWT (tymon/jwt)  | Autenticación basada en tokens       |
| Socialite        | OAuth con Google y otros providers  |
| AWS S3           | Almacenamiento en la nube de archivos|
| Docker           | Contenerización para entornos        |
| Nginx            | Servidor web y proxy reverso         |
| MySQL / Postgres | Base de datos relacional             |

---

## Requisitos Previos

- Docker y Docker Compose instalados
- AWS Credentials configuradas en `.env`
- Google OAuth Credentials creadas en Google Cloud Console
- Composer instalado (solo para desarrollo local sin Docker)

---

## Configuración y Ejecución

### 1. Clonar el repositorio

```bash
git clone https://github.com/lukkaku12/laravel-google-drive.git
cd laravel-google-drive
```

### 2. Copiar archivo de configuración
```bash
cp .env.example .env
```

### 3. Configurar variables de entorno

## Edita .env para agregar:
 - Configuración de base de datos (DB_HOST, DB_PORT, DB_DATABASE, etc.)
 - Claves AWS (AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, AWS_DEFAULT_REGION, AWS_BUCKET)
 - Configuración JWT (JWT_SECRET)
 - Configuración OAuth Google (GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REDIRECT_URI)

### 4. Construir y levantar contenedores Docker

```bash
docker-compose up -d --build
```

# Esto levantará:
 - Contenedor Laravel PHP-FPM
 - Contenedor Nginx sirviendo la app
 - Contenedor de base de datos (MySQL/Postgres)
 - Otros contenedores necesarios

 ### Estructura de proyecto

<pre>
├── app
├── bootstrap
├── config
├── database
│   ├── migrations
│   └── seeders
├── nginx
│   └── default.conf
├── public
├── resources
├── routes
└── tests
.env
.env.template
.gitignore
Dockerfile
docker-compose.yml
composer.json
composer.lock

</pre>
## 🚀 API Endpoints

A continuación, se listan los endpoints disponibles en la API, con su método HTTP, ruta y controlador asociado.

| Método       | Ruta                          | Descripción / Controlador                             |
|--------------|-------------------------------|------------------------------------------------------|
| GET, HEAD    | `/api/auth/google/callback`   | Callback para OAuth con Google                        |
| GET, HEAD    | `/api/auth/google/redirect`   | Redirección para OAuth con Google                     |
| POST         | `/api/auth/login`             | Login de usuario (`UserController@login`)            |
| POST         | `/api/auth/logout`            | Logout de usuario (`UserController@logout`)          |
| GET, HEAD    | `/api/auth/me`                | Obtener info del usuario autenticado (`UserController@me`) |
| POST         | `/api/auth/refresh`           | Refrescar token JWT (`UserController@refresh`)       |
| POST         | `/api/auth/register`          | Registro de nuevo usuario (`UserController@register`)|
| GET, HEAD    | `/api/files`                  | Listar archivos (`FileController@index`)             |
| POST         | `/api/files`                  | Subir nuevo archivo (`FileController@store`)         |
| GET, HEAD    | `/api/files/{path}`           | Obtener archivo por ruta (`FileController@show`)     |
| DELETE       | `/api/files/{path}`           | Eliminar archivo por ruta (`FileController@destroy`) |
| GET, HEAD    | `/sanctum/csrf-cookie`        | Obtener cookie CSRF (`CsrfCookieController@show`)    |
| GET, HEAD    | `/storage/{path}`             | Servir archivo estático desde storage local           |
| GET, HEAD    | `/up`                        | Endpoint de estado / health check                      |