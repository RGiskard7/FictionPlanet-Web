# FictionPlanet

Red social educativa construida desde cero con **PHP 8.1 MVC + jQuery + Bootstrap 4**. Proyecto de portafolio que demuestra arquitectura MVC personalizada, RBAC, chat en tiempo real por SSE, y buenas prácticas de seguridad.

## Stack

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.1+ (MVC propio, sin framework) |
| Base de datos | MariaDB 10.4 / MySQL (PDO) |
| Frontend | Bootstrap 4.6 + jQuery 3.5 |
| Editor WYSIWYG | CKEditor 4 |
| Librerías JS | DataTables, FullCalendar 3, baguetteBox, emojiOneArea, SweetAlert |
| Chat en vivo | Server-Sent Events (SSE) |
| Testing | PHPUnit 9+ |
| Calidad | Composer PSR-4 autoloading, .env config, CSRF protection |

## Funcionalidades

- **Autenticación** — Login con bcrypt, sesiones PHP, gestión de permisos
- **RBAC** — 8 módulos con control granular (lectura/escritura/actualización/eliminación)
- **Publicaciones** — CRUD de posts con CKEditor, archivos adjuntos, visibilidad pública/privada
- **Usuarios** — Registro, perfiles, contactos, solicitudes de amistad
- **Chat en vivo** — 1-a-1 con SSE (Server-Sent Events), soporte emoji
- **Galería de imágenes** — Subida con validación, lightbox baguetteBox
- **Calendario público** — Eventos CRUD vía FullCalendar
- **Roles y permisos** — CRUD completo con matriz de permisos por módulo
- **Búsqueda avanzada** — Por título, autor, introducción, contenido, fecha

## Arquitectura

```
HTTP → .htaccess → index.php → App (Front Controller)
  → Controller → Validator → DAO (PDO) → Model
  → View::render() → HTML
```

- **Front Controller**: URL parsing (`/controller/method/params`)
- **MVC**: Controladores, modelos de entidad, DAOs estáticos con PDO
- **Autoloading**: PSR-4 vía Composer
- **Sesiones**: Clase `Session` con manejo CSRF integrado
- **Errores**: `AppException` con logging a archivo, sin `die()` en producción

## Requisitos

- PHP 8.0+
- MariaDB/MySQL
- Apache con mod_rewrite (o nginx equivalente)
- Composer

## Instalación

### Docker (recomendado — funciona en macOS M1/M2/M3)

```bash
# Requisito previo: Docker Desktop instalado
# https://www.docker.com/products/docker-desktop/

git clone https://github.com/RGiskard7/fiction-planet-web.git
cd fiction-planet-web
bash docker/setup.sh

# Abrir http://localhost:8080
# Login: Asimov / 1234 (Root) o Asimov2 / 1234 (Admin)
```

Comandos Docker útiles:
```bash
docker compose down           # Parar
docker compose up -d          # Iniciar
docker compose logs -f app    # Logs
docker compose exec app composer test  # Tests
```

### Manual (XAMPP/MAMP)

```bash
git clone https://github.com/RGiskard7/fiction-planet-web.git
cd fiction-planet-web

cp .env.example .env
# Editar .env con credenciales de BD
composer install
mysql -u root -p < fictionplanetdb.sql

# Apuntar Apache a la raíz del proyecto
# Usuarios: Asimov / 1234 (Root), Asimov2 / 1234 (Admin)
```

## Testing

```bash
composer test        # Todos los tests
composer test:unit   # Solo tests unitarios
```

## Estructura del proyecto

```
fiction-planet-web/
├── index.php                  # Entry point
├── config.inc.php             # Constantes desde .env
├── composer.json              # PSR-4 autoloading
├── phpunit.xml.dist
├── .env.example
├── controllers/               # 9 controladores MVC
├── models/                    # Entidades + DAO/
├── libs/core/                 # App, Controller, View, Connection, AppException
├── libs/validators/           # Login, NewUser, NewPosts, UpdatedPosts
├── views/                     # Vistas PHP server-rendered
├── templates/                 # Fragmentos reutilizables (.inc.php)
├── app/                       # Endpoints independientes (SSE, calendario, subidas)
├── static/                    # CSS, JS, imágenes
├── tests/                     # PHPUnit tests
└── uploads/                   # Archivos de usuario
```

## Mejoras recientes (v2.0)

- **Seguridad**: CSRF en todos los formularios y AJAX, `.env` para credenciales, eliminado `extract()` y `addslashes()` redundante
- **Errores**: `AppException` con handler global reemplaza todos los `die()` en DAOs
- **Chat**: Migrado de polling (3 llamadas/segundo) a SSE (Server-Sent Events)
- **Autoloading**: PSR-4 con Composer, eliminado `__callStatic` mágico de PostDAO
- **Bugs fix**: Typos en setters (`set_firs_name`, `set_phone_numbre`, `set_last_acess_date`), `ContactModel::set_contact_id()` no-op, `Image_gallery` variables indefinidas, `reciever` → `receiver`
- **Testing**: PHPUnit configurado con tests para validators, modelos y sesión CSRF
- **Assets**: Eliminados CSS duplicados (~3.6K líneas)
- **Código**: Limpieza de código comentado y dead code

## Licencia

MIT © [RGiskard7](https://github.com/RGiskard7)
