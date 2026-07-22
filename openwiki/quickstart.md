---
type: Quickstart
title: FictionPlanet Quickstart
description: Entrypoint for the FictionPlanet PHP social network wiki — architecture, domains, setup, and developer guidance
tags: [quickstart, overview, php, mvc]
---

# FictionPlanet Quickstart

FictionPlanet is a **social network simulation** web application built with **PHP 8**, **MariaDB**, and **Bootstrap 4**, following the **MVC** (Model-View-Controller) pattern with a **Front Controller** routing strategy.

> **Purpose**: Educational project demonstrating a complete PHP web application with MVC architecture, DAO data access layer, role-based access control, and interactive features including live chat, blog posts, and image gallery.

## Tech Stack

| Component | Technology |
|-----------|-----------|
| Backend | PHP 8.1.1 |
| Database | MariaDB 10.4.21 (MySQL-compatible) |
| Frontend | Bootstrap 4.6, jQuery 3.5.1 |
| Rich Text | CKEditor 4 (with PDF export) |
| Admin Tables | DataTables |
| Calendar | FullCalendar |
| Lightbox | baguetteBox.js |
| Emoji | EmojiOneArea |

## Quick Navigation

| Page | What You'll Find |
|------|-----------------|
| [Architecture Overview](/openwiki/architecture/overview.md) | MVC pattern, Front Controller routing, core libraries, permission system |
| [Source Map](/openwiki/architecture/source-map.md) | Complete file inventory with descriptions |
| [Posts Domain](/openwiki/domain/posts.md) | Blog post CRUD, search, file attachments, visibility |
| [Users & Auth](/openwiki/domain/users-and-auth.md) | Login/registration, roles, permissions, profiles, contacts |
| [Image Gallery](/openwiki/domain/images-and-gallery.md) | Image upload, gallery display, CKEditor integration |
| [Chat](/openwiki/domain/chat.md) | Contact-based polling chat, unread messages, online status |
| [Configuration](/openwiki/operations/configuration.md) | Database setup, config constants, upload paths, error logging |

## Setup

### 1. Database
```bash
mysql -u root -p < fictionplanetdb.sql
```

### 2. Configuration
Edit `/config.inc.php`:
- Set `DB_USER`, `DB_PASSWORD` for your MySQL credentials
- Set `BASE_DIR` if the app lives in a subdirectory

### 3. Web Server
Place the project in your web root (e.g., XAMPP `htdocs/`). Ensure `mod_rewrite` is enabled and `.htaccess` is allowed.

### 4. Verify
- Open `http://localhost/` in your browser
- Default login: `correo@correo.com` / `1234` (Root user)

## Key Architecture Concepts

### Request Lifecycle
```
Browser → .htaccess rewrite → index.php → App.php (dispatch)
  → Controller (permission check) → Model/DAO → DB
  → Controller → View (render) → Template → HTML response
```

### Permission System
Every action is gated by a permission check:
```php
if (!Session::is_started() || !$_SESSION['permissions'][MDL_POSTS]['r']) {
    Redirection::redirect(BASE_URL);
}
```
Permissions are role-based with four operations per module: **r** (read), **w** (write), **u** (update), **d** (delete).

### Three-Layer Data Access
- **Model** (`/models/`): Plain PHP entity classes with getters/setters
- **DAO** (`/models/dao/`): Static SQL query methods taking a PDO connection
- **Connection** (`/libs/core/Connection.php`): Singleton PDO factory

## What to Know Before Diving In

1. **No framework**: This is a hand-rolled MVC PHP application — no Laravel, Symfony, or Composer dependencies
2. **Polling-based chat**: The live chat uses AJAX polling (setInterval), not WebSockets
3. **Global JavaScript**: All JS files use global functions with jQuery — no module bundler
4. **Static DAO pattern**: DAOs use static methods and require a PDO connection parameter
5. **Spanish codebase**: Most UI text, comments, and some variable names are in Spanish
6. **No automated tests**: The project has no PHPUnit or other test infrastructure
7. **CKEditor 4**: The full CKEditor distribution is committed to the repo under `/plugins/ckeditor/`

## Domain Map

```
Users ─── has role → Roles ─── has permissions → Permissions (module × r/w/u/d)
  │
  ├── owns → Posts ─── has → Attachments (filesystem)
  │
  ├── owns → Images (gallery) ─── uploaded to → uploads/gallery/
  │
  ├── sends → Chat Messages ─── to → other Users
  │
  ├── has → Contacts ─── bidirectional → other Users
  │
  └── sends → Friend Requests ─── to → other Users
```

## Backlog

- **Calendar Events** (`/app/calendarEventsController.php`, `/models/CalendarEventModel.php`, `/models/dao/CalendarEventsDAO.php`, `/views/modals/calendar_modal.inc.php`, `/templates/modals/new_event_calendar_modal.inc.php`): FullCalendar-based public events with CRUD. Relatively isolated — deferred for brevity.
- **Notifications** (`notifications` table in DB, no dedicated controller): Database table exists but no clear controller implementation. Deferred pending further investigation.
- **Module 5/6 (publisher_data, personal_data)**: Constants defined in config but marked as "Duda" (doubt). Deferred — unclear if fully implemented.

## Related Pages

- [Architecture Overview](/openwiki/architecture/overview.md) — deep dive into the MVC implementation
- [Source Map](/openwiki/architecture/source-map.md) — complete file inventory
- [Configuration](/openwiki/operations/configuration.md) — database setup, config constants