---
type: Architecture Overview
title: FictionPlanet Architecture
description: MVC architecture with Front Controller routing, DAO data access layer, role-based access control, and server-side rendered views in PHP
tags: [architecture, mvc, routing, php]
---

# Architecture Overview

FictionPlanet is a PHP 8 web application following the **Model-View-Controller (MVC)** pattern with a **Front Controller** routing strategy, **DAO (Data Access Object)** data access layer, and **role-based permission** system.

## Request Flow

```
Browser → .htaccess → index.php → App.php → Controller → Model → DAO → DB
                                              → Controller → View → Template → HTML
```

1. **Apache `.htaccess`** rewrites all non-file/non-dir requests to `index.php?url=<path>` (`/.htaccess`)
2. **`index.php`** loads config, sets error handling, and instantiates `App` (`/index.php`)
3. **`App.php`** (Front Controller) parses the URL as `/Controller/method/params`, loads the controller file, instantiates it, and calls the method (`/libs/core/App.php`)
4. **Controller** (extends `Controller`) processes the request, calls models/DAOs, and passes data to a view (`/libs/core/Controller.php`)
5. **View::render()** resolves the view file path and renders it (`/libs/core/View.php`)
6. **Templates** (`.inc.php` files in `/templates/`) are included from views for reusable UI components

## URL Routing

The URL format is `/[controller]/[method]/[params]`. Default method equals the controller name lowercased.

| URL | Controller | Method | Params |
|-----|-----------|--------|--------|
| `/` | `Home` | `home` | — |
| `/posts` | `Posts` | `posts` | — |
| `/posts/get/my-post-slug` | `Posts` | `get` | `my-post-slug` |
| `/users/profile/5` | `Users` | `profile` | `5` |

**Key detail**: `App.php` (`/libs/core/App.php`) converts the first URL segment to `ucwords()` (CamelCase) to find the controller file. If the controller or method doesn't exist, it renders a 404 via `Fault::error_404()`.

## Core Libraries

### `/libs/core/App.php`
The Front Controller. Parses `$_GET['url']`, resolves controller/method/params, loads the controller class, and dispatches. If no URL is provided, defaults to `home/home`.

### `/libs/core/Controller.php`
Base class for all controllers. Constructor creates a `View` instance and calls `session_start()`.

### `/libs/core/View.php`
Renders views by mapping controller class names to view directories. The `Home` controller's views live directly in `/views/`; all other controllers' views live in `/views/<controller_lowercase>/`.

### `/libs/core/Connection.php`
Singleton PDO connection to MySQL/MariaDB with `PDO::ERRMODE_EXCEPTION`. Uses constants from `config.inc.php` (`DB_TYPE`, `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_CHARSET`).

### `/libs/core/Redirection.php`
Sends a 301 redirect header and terminates execution.

### `/libs/core/Utilities.php`
File-system utilities: directory copy, file copy, directory emptiness check, directory deletion, directory listing, file deletion, friendly URL generator, and image URL generation.

### `/libs/Session.php`
Manages user sessions: `log_in()`, `log_out()`, `is_started()`, `change_session_data()`. Stores `loggedInUser`, `idUser`, `userName`, `role`, and `permissions` in `$_SESSION`.

### `/libs/Pager.php`
HTML pagination component. Renders a Bootstrap-styled pagination strip with first/prev/page numbers/next/last links. Takes URL, total items, items per page, max visible links, and current page.

## Data Access Layer

### DAO Pattern
Each domain entity has a corresponding DAO class in `/models/dao/` that contains all SQL queries. DAOs are static methods taking a PDO connection parameter. The pattern is:

- **Model** → Plain PHP class with properties and getters/setters (e.g., `PostModel`, `UserModel`)
- **DAO** → Static CRUD methods executing SQL through PDO (e.g., `PostDAO`, `UserDAO`)
- **Connection** → Singleton PDO instance passed to DAO methods

### Available DAOs

| DAO | Entity | Key Operations |
|-----|--------|---------------|
| `UserDAO` | `UserModel` | CRUD, email/user existence, search, last-access update |
| `PostDAO` | `PostModel` | CRUD, visibility filtering, search, pagination |
| `RoleDAO` | `RoleModel` | CRUD, all roles |
| `PermissionDAO` | `PermissionModel` | Permission CRUD, role-module permission matrix |
| `ContactDAO` | `ContactModel` | Contact CRUD by user |
| `FriendRequestsDAO` | `FriendRequestsModel` | Friend request CRUD, status management |
| `ChatMessageDAO` | `ChatMessageModel` | Message CRUD, conversation history, status updates |
| `ImageGalleryDAO` | `ImageGalleryModel` | Image CRUD, visibility filtering, pagination |
| `CalendarEventsDAO` | `CalendarEventModel` | Event CRUD, date-range queries |
| `ModuleDAO` | `ModuleModel` | Module listing |

## Permission System

The application uses a **module-level RBAC** (Role-Based Access Control) with four operations per module: **r** (read), **w** (write), **u** (update), **d** (delete).

### Modules (from `modules` table)

| ID | Constant | Name |
|----|----------|------|
| 1 | `MDL_USERS` | users |
| 2 | `MDL_ROLES` | roles |
| 3 | `MDL_POSTS` | posts |
| 4 | `MDL_PUBLIC_CALENDAR` | calendar_events |
| 5 | `MDL_PUBL_DATA` | publisher_data |
| 6 | `MDL_PRSN_DATA` | personal_data |
| 7 | `MDL_CHAT` | chat_services |
| 8 | `MDL_IMAGES` | images |

### Built-in Roles

| ID | Name | Description |
|----|------|-------------|
| 1 | Root | Full access to all modules |
| 2 | Administrator | Broad access (posts, roles, chat, calendar) |
| 4 | Registered user | Limited read access |

Controllers check permissions at the start of each action via `$_SESSION['permissions'][MDL_XXX]['r']` (or `w`/`u`/`d`). Unauthorized access is redirected to the homepage.

## Templates

Reusable template fragments live in `/templates/`:

- `head.inc.php` — HTML `<head>`, CSS/JS includes
- `footer.inc.php` — Footer with social links, logo, credits
- `nav/top_navbar.inc.php` — Top navigation bar
- `nav/sidebar.inc.php` — Left sidebar
- `nav/chat_sidebar.inc.php` — Chat sidebar panel
- `modals/*.inc.php` — Bootstrap modals for CRUD operations
- `crud/*.inc.php` — CRUD table templates
- `scripts.inc.php` — JavaScript includes

## Related Pages

- [Source Map](/openwiki/architecture/source-map.md) — complete file inventory
- [Configuration](/openwiki/operations/configuration.md) — constants, database, upload paths
- [Posts Domain](/openwiki/domain/posts.md) — post creation, editing, search
- [Users & Auth](/openwiki/domain/users-and-auth.md) — user management, roles, permissions
- [Image Gallery](/openwiki/domain/images-and-gallery.md) — image upload and gallery
- [Chat](/openwiki/domain/chat.md) — real-time messaging