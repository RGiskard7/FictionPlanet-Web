---
type: Source Map
title: FictionPlanet Source Map
description: Complete file inventory and directory structure guide for the FictionPlanet PHP social network application
tags: [source-map, structure, php]
---

# Source Map

## Directory Tree

```
/
├── index.php                          # Front Controller entry point
├── .htaccess                          # Apache URL rewriting rules
├── config.inc.php                     # Application configuration constants
├── fictionplanetdb.sql                # MariaDB schema dump with seed data
├── package.json                       # Node.js dependency (openwiki only)
├── AGENTS.md / CLAUDE.md              # Agent instructions
│
├── controllers/                       # MVC Controller layer
│   ├── About_us.php                   # Static "About Us" page
│   ├── Fault.php                      # 404 error handler
│   ├── Home.php                       # Homepage with post listing + search
│   ├── Image_gallery.php              # Image gallery (list, paginate, view)
│   ├── Instant_messaging.php          # Live chat between contacts
│   ├── Login.php                      # Email/password authentication
│   ├── Posts.php                      # Post CRUD (create, read, update)
│   ├── Roles.php                      # Role CRUD + permission management
│   └── Users.php                      # User CRUD, profile, contacts, friend requests
│
├── models/                            # MVC Model layer (entities)
│   ├── CalendarEventModel.php
│   ├── ChatMessageModel.php
│   ├── ContactModel.php
│   ├── FriendRequestsModel.php
│   ├── ImageGalleryModel.php
│   ├── ModuleModel.php
│   ├── PermissionModel.php
│   ├── PostModel.php
│   ├── RoleModel.php
│   └── UserModel.php
│   └── dao/                           # Data Access Objects
│       ├── CalendarEventsDAO.php
│       ├── ChatMessageDAO.php
│       ├── ContactDAO.php
│       ├── FriendRequestsDAO.php
│       ├── ImageGalleryDAO.php
│       ├── ModuleDAO.php
│       ├── PermissionDAO.php
│       ├── PostDAO.php (26KB)         # Largest DAO with search/pagination
│       ├── RoleDAO.php
│       └── UserDAO.php
│
├── libs/                              # Core libraries
│   ├── Pager.php                      # HTML pagination component
│   ├── Session.php                    # Session management (login/logout/permissions)
│   ├── core/
│   │   ├── App.php                    # Front Controller / URL dispatcher
│   │   ├── Connection.php            # Singleton PDO connection
│   │   ├── Controller.php            # Base controller class
│   │   ├── Redirection.php           # HTTP redirect utility
│   │   ├── Utilities.php             # File system helpers + friendly URL generator
│   │   └── View.php                  # View renderer
│   └── validators/
│       ├── LoginValidator.php         # Email/password login validation
│       ├── NewPostsValidator.php      # Post creation validation (title, intro, content)
│       ├── NewUserValidator.php (12KB)# Largest validator — validates all user fields
│       └── UpdatedPostsValidator.php  # Post update validation
│
├── views/                             # View files (server-side rendered PHP)
│   ├── home.php                       # Homepage with post cards + pagination
│   ├── about_us/
│   │   └── about_us.php
│   ├── fault/
│   │   └── 404.php
│   ├── image_gallery/
│   │   └── gallery.php
│   ├── login/
│   │   └── login.php
│   ├── posts/
│   │   ├── create_post.php
│   │   ├── post.php                   # Single post view
│   │   ├── posts.php                  # Post listing (admin)
│   │   └── update_post.php
│   ├── roles/
│   │   └── roles.php
│   └── users/
│       ├── create_user.php
│       ├── profile.php
│       ├── profile_inactive.php
│       ├── profile_not_logged_in.php
│       └── users.php
│
├── templates/                         # Reusable template fragments
│   ├── head.inc.php                   # HTML <head> with asset includes
│   ├── footer.inc.php                 # Site footer
│   ├── scripts.inc.php                # JavaScript bundle includes
│   ├── chat_window.inc.php            # Chat message window
│   ├── create_post_empty.inc.php      # Empty post creation form
│   ├── create_post_validate.inc.php   # Post creation validation errors
│   ├── create_user_empty.inc.php      # User creation form
│   ├── create_user_validated.inc.php  # User creation with validation
│   ├── image_gallery_table.inc.php    # Image gallery data table
│   ├── post_list.inc.php              # Post card list template
│   ├── update_attached_files.inc.php  # File attachment manager
│   ├── update_post_empty.inc.php      # Post update form
│   ├── update_post_validate.inc.php   # Post update validation errors
│   ├── user_chat_list.inc.php         # Chat contact list
│   ├── user_contact_list.inc.php      # User contact list template
│   ├── crud/
│   │   ├── post_CRUD.inc.php          # Post admin CRUD table
│   │   ├── post_profile_CRUD.inc.php  # Post CRUD in user profile
│   │   ├── role_CRUD.inc.php          # Role admin CRUD table
│   │   └── user_CRUD.inc.php          # User admin CRUD table
│   ├── modals/
│   │   ├── calendar_modal.inc.php
│   │   ├── change_password_modal.inc.php
│   │   ├── data_confirm_modal.inc.php
│   │   ├── edit_profile_modal.inc.php
│   │   ├── edit_role_modal.inc.php
│   │   ├── edit_user_modal.inc.php
│   │   ├── new_event_calendar_modal.inc.php
│   │   ├── new_role_modal.inc.php
│   │   ├── permissions_role_modal.inc.php
│   │   ├── upload_new_image_modal.inc.php
│   │   └── user_modal.inc.php
│   └── nav/
│       ├── chat_sidebar.inc.php
│       ├── sidebar.inc.php
│       └── top_navbar.inc.php
│
├── app/                               # Standalone AJAX endpoint controllers
│   ├── calendarEventsController.php    # FullCalendar event CRUD (JSON)
│   ├── ckeditorUpload.php             # CKEditor image upload handler
│   ├── imageGalleryController.php     # Image gallery upload/metadata endpoints
│   ├── logoutController.php           # Session logout + redirect
│   └── uploadAttachments-fileinput.php# Post attachment file upload
│
├── static/                            # Static assets
│   ├── css/
│   │   ├── style.css                  # Custom styles
│   │   ├── common.css                 # Shared utilities
│   │   ├── content.css                # Content area
│   │   ├── navbar.css                 # Navigation bar
│   │   ├── aside.css / header.css / footer.css  # Layout sections
│   │   └── vendor (Bootstrap 4.6, Font Awesome, DataTables, FullCalendar, etc.)
│   ├── js/
│   │   ├── main.js                    # Core JS (sidebar, notifications, modals)
│   │   ├── chatFunctions.js           # Live chat (polling-based)
│   │   ├── fileInput.js               # File upload UI
│   │   ├── imageGalleryFunctions.js   # Gallery CRUD (DataTables)
│   │   ├── postFunctions.js           # Post CRUD (DataTables)
│   │   ├── roleFunctions.js           # Role CRUD + permission management
│   │   ├── userFunctions.js           # User CRUD + profile management
│   │   └── vendor (jQuery 3.5.1, Bootstrap, DataTables, FullCalendar, etc.)
│   └── img/                           # Static images (logos, backgrounds, icons)
│
├── plugins/                           # Third-party plugins
│   └── ckeditor/                      # CKEditor 4 (full distribution with export PDF)
│
├── uploads/                           # User-uploaded content
│   ├── editor/img/                    # CKEditor image uploads
│   ├── gallery/                       # Image gallery files
│   └── posts/attachments/            # Post attachment files
│
├── doc/                               # Documentation images
│   └── images/                        # README screenshots
│
└── skills/                            # Agent skills (OpenWiki)
```

## Key File Sizes (Largest Sources)

| File | Size | Purpose |
|------|------|---------|
| `models/dao/PostDAO.php` | 26 KB | Post queries with search, pagination, visibility |
| `controllers/Users.php` | 38 KB | User CRUD, profile, contacts, friend requests |
| `static/js/userFunctions.js` | 41 KB | User management JS (DataTables, modals) |
| `controllers/Posts.php` | 18 KB | Post CRUD with file attachments |
| `controllers/Roles.php` | 12 KB | Role CRUD + permission matrix |
| `libs/validators/NewUserValidator.php` | 12 KB | User registration validation |

## Related Pages

- [Architecture Overview](/openwiki/architecture/overview.md) — MVC pattern, routing, core libraries
- [Configuration](/openwiki/operations/configuration.md) — constants, database, upload paths