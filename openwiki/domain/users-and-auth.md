---
type: Domain
title: Users & Authentication Domain
description: User registration, login, role-based access control, profile management, contacts, and friend requests in FictionPlanet
tags: [domain, users, auth, roles, permissions]
---

# Users & Authentication Domain

The Users and Auth domain covers user registration, authentication, role-based permissions, profile management, contacts, and friend requests.

## Key Source Files

| File | Role |
|------|------|
| `/controllers/Users.php` | User CRUD, profile, contacts, friend requests (38 KB — largest controller) |
| `/controllers/Login.php` | Login form processing |
| `/controllers/Roles.php` | Role CRUD + permission matrix |
| `/libs/Session.php` | Session management |
| `/libs/validators/LoginValidator.php` | Login credential validation |
| `/libs/validators/NewUserValidator.php` | User registration validation (12 KB) |
| `/models/UserModel.php` | User entity |
| `/models/RoleModel.php` | Role entity |
| `/models/PermissionModel.php` | Permission entity |
| `/models/ContactModel.php` | Contact relationship entity |
| `/models/FriendRequestsModel.php` | Friend request entity |
| `/static/js/userFunctions.js` | User CRUD JS (41 KB — largest JS file) |
| `/static/js/roleFunctions.js` | Role management JS |

## User Entity (`UserModel`)

- **id**, **user_name** (unique), **first_name**, **last_name**, **email** (unique)
- **password** (bcrypt via `password_hash()`)
- **address**, **country**, **phone_number**
- **reg_date**, **last_update_date**, **last_access_date**
- **active** (boolean), **avatar** (path), **online** (boolean)
- **role_id** (FK to roles, defaults to `REGISTERED_USER` = 4)

## Authentication Flow

### Login (`Login` controller)
1. Checks if session is already started — redirects to home
2. Sanitizes email and password with `htmlentities()` and `addslashes()`
3. `LoginValidator` validates:
   - Email exists in DB via `UserDAO::is_email_exist()`
   - Password matches via `password_verify()`
   - User is active
4. On success: loads role and permissions, calls `Session::log_in()`, updates `last_access_date`, redirects to home
5. On failure: returns error message, re-renders login form

### Logout (`/app/logoutController.php`)
Calls `Session::log_out()` and redirects to base URL.

### Session (`/libs/Session.php`)
- `log_in($user, $role, $permissions)` — stores user object, id, name, role, and permissions array in `$_SESSION`
- `log_out()` — unsets all session variables and destroys session
- `is_started()` — checks if all session variables are set
- `change_session_data()` — updates session data after profile edit

## Role-Based Access Control

### Roles (`/controllers/Roles.php`)

| ID | Name | Key Permissions |
|----|------|-----------------|
| 1 | **Root** | Full CRUD on all modules (protected from deletion/editing) |
| 2 | **Administrator** | Read/Write/Update on posts, roles, chat, calendar |
| 4 | **Registered user** | Read-only on users, roles, calendar |

### Permission Model
Each role has a row in `permissions` for every module, with four boolean columns: **r** (read), **w** (write), **u** (update), **d** (delete).

### Triggers
- **`new_role_permissions`**: When a new role is created, a permission row (all zeros) is auto-inserted for every module.
- **`delete_role`**: When a role is deleted, all users with that role are reassigned to `REGISTERED_USER` (id=4).

### Role Management UI
- DataTable-based CRUD with AJAX
- Root role (id=1) and Registered User role (id=4) are protected from editing/deletion
- Permission matrix is displayed in a modal with checkboxes per module per operation

## User Management (`Users` controller)

### Admin Actions
| Method | URL | Description |
|--------|-----|-------------|
| `users()` | `/users` | User listing page |
| `create()` | `/users/create` | User creation form + processing |
| `users_data_table_load()` | AJAX | DataTables JSON load |
| `get_user()` | AJAX | Single user data |
| `submit_update_user()` | AJAX | Update user |
| `delete_user()` | AJAX | Delete user |

### Profile Actions
| Method | URL | Description |
|--------|-----|-------------|
| `profile($userName)` | `/users/profile/<name>` | Public profile page |
| `edit_profile()` | AJAX | Edit own profile |
| `change_password()` | AJAX | Change own password |
| `upload_avatar()` | AJAX | Upload avatar image |
| `delete_avatar()` | AJAX | Remove avatar |

### User Creation Validation (`NewUserValidator` — 12 KB)
Validates all 10 fields independently with error tracking:
- **user_name**: 3-50 chars, alphanumeric + underscore/hyphen, unique
- **first_name**, **last_name**: 3-100 chars, alpha + spaces
- **email**: valid format, unique
- **password1**: 5-50 chars, must match password2
- **address**: 3-100 chars
- **country**: 3-100 chars
- **phone_number**: 9 digits
- **role**: must exist in DB

## Contacts & Friend Requests

### Contacts (`ContactModel`, `ContactDAO`)
- Represents bidirectional contact relationships between users
- `contacts` table: `user_id` + `contact_id` pairs
- Used by the chat system to determine conversation partners

### Friend Requests (`FriendRequestsModel`, `FriendRequestsDAO`)
- `friend_requests` table: `from_user_id`, `to_user_id`, `status`, `accepted`
- `status` 0 = pending, 1 = responded
- `accepted` NULL = no response, true = accepted, false = rejected
- Users can view pending requests, accept/reject, and manage their contact list

## Related Pages

- [Architecture Overview](/openwiki/architecture/overview.md) — Session, permission system
- [Posts Domain](/openwiki/domain/posts.md) — permission checks on posts
- [Image Gallery](/openwiki/domain/images-and-gallery.md) — permission checks on images
- [Chat](/openwiki/domain/chat.md) — contacts, user chat lists
- [Configuration](/openwiki/operations/configuration.md) — role constants, DB config