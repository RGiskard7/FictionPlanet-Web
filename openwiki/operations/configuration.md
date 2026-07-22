---
type: Operations Guide
title: Configuration & Operations
description: Database setup, configuration constants, upload paths, error logging, and operational notes for FictionPlanet
tags: [operations, configuration, database, deployment]
---

# Configuration & Operations

## System Requirements

- **PHP** 8.1.1+ (with PDO MySQL extension)
- **MariaDB** 10.4.21+ (or MySQL 5.7+)
- **Apache** with `mod_rewrite` enabled
- **Node.js** (only for the `openwiki` documentation dependency)

## Database Setup

### Schema
The database schema is in `/fictionplanetdb.sql` (529 lines):

1. **Tables**: `calendar_events`, `chat_message`, `contacts`, `friend_requests`, `image_gallery`, `modules`, `notifications`, `permissions`, `posts`, `roles`, `users`
2. **Seed data**: Default roles (Root, Administrator, Registered user), default modules (7), default permissions, and 2 sample users
3. **Triggers**: `new_role_permissions` (auto-create permissions for new roles), `delete_role` (reassign users to Registered user on role deletion)
4. **Foreign keys**: All tables reference `users(id)` with CASCADE

### Setup Steps
```sql
CREATE DATABASE fictionplanetdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
SOURCE /path/to/fictionplanetdb.sql;
```

### Default Users
| Username | Password | Role |
|----------|----------|------|
| Asimov | 1234 | Root |
| Asimov2 | 1234 | Administrator |

## Configuration (`/config.inc.php`)

### Database Settings
```php
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'fictionplanetdb');
define('DB_CHARSET', 'utf8mb4');
```

**Must change**: `DB_USER`, `DB_PASSWORD` for production.

### Base URL
```php
define('BASE_DIR', '/');
define('BASE_URL', 'http://' . $_SERVER['SERVER_NAME'] . BASE_DIR);
```
For development on a subdirectory or custom port, adjust `BASE_DIR` and uncomment `BASE_PORT`.

### Module Constants
```php
define('MDL_USERS', 1);
define('MDL_ROLES', 2);
define('MDL_POSTS', 3);
define('MDL_PUBLIC_CALENDAR', 4);
define('MDL_PUBL_DATA', 5);
define('MDL_PRSN_DATA', 6);
define('MDL_CHAT', 7);
define('MDL_IMAGES', 8);
```

### Role Constants
```php
define('ROOT', 1);           // Protected role
define('REGISTERED_USER', 4); // Default role for new users
```

### Upload Paths
```php
define('UPLOAD_POSTS_DIR', '/uploads/posts/attachments/');
define('UPLOAD_IMG_EDITOR_DIR', '/uploads/editor/img/');
define('UPLOAD_IMG_GALLERY_DIR', '/uploads/gallery/');
```

### Apache Configuration
The `.htaccess` file enables `mod_rewrite` and rewrites all non-file requests to `index.php?url=<path>`:
```
RewriteEngine On
RewriteCond %{SCRIPT_FILENAME} !-d
RewriteCond %{SCRIPT_FILENAME} !-f
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

## Error Logging

Configured in `/index.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', FALSE);
ini_set('log_errors', TRUE);
ini_set('error_log', ERROR_LOG_PATH);  // /php-error.log
```

Errors are logged to `/php-error.log` (not displayed to users). The `ERROR_LOG_PATH` constant is defined in `config.inc.php`.

## File Uploads

- **Post attachments**: `uploads/posts/attachments/{postId}/` — managed via Bootstrap FileInput plugin
- **CKEditor images**: `uploads/editor/img/` — uploaded via `/app/ckeditorUpload.php`
- **Gallery images**: `uploads/gallery/{authorId}/` — uploaded via `/app/imageGalleryController.php`
- **Avatars**: stored in `static/img/` (referenced by path in `users.avatar` column)

All upload directories must be writable by the web server.

## Guidelines for Developers

### Adding a New Module
1. Add a row to the `modules` table
2. Define a constant in `config.inc.php` (e.g., `define('MDL_NEW_MODULE', 9)`)
3. Permission rows for new roles will be auto-created by the `new_role_permissions` trigger
4. Add permission checks in controllers via `$_SESSION['permissions'][MDL_NEW_MODULE]['r']`

### Adding a New Controller
1. Create the controller file in `/controllers/` (class name matches filename, extends `Controller`)
2. Create a view directory `/views/{controller_lowercase}/`
3. URLs automatically route via the Front Controller (`/controller/method/params`)

### Adding a New Validator
1. Create the validator class in `/libs/validators/`
2. Follow the pattern of collecting errors per field with `valid_form()` returning boolean
3. Use `show_error()` methods for HTML error display

### JavaScript Conventions
- All JS files use global functions and jQuery (no module system)
- AJAX endpoints use `$_POST['action']` to identify the operation
- DataTables are used for admin CRUD tables
- Chat uses polling (setInterval-based AJAX to `update_user_chat_history`)

## Related Pages

- [Architecture Overview](/openwiki/architecture/overview.md) — MVC pattern, routing
- [Source Map](/openwiki/architecture/source-map.md) — complete file inventory
- [Posts Domain](/openwiki/domain/posts.md) — upload paths, post attachments
- [Users & Auth](/openwiki/domain/users-and-auth.md) — role constants, user validation
- [Image Gallery](/openwiki/domain/images-and-gallery.md) — gallery upload paths
- [Chat](/openwiki/domain/chat.md) — chat module constant