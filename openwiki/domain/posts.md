---
type: Domain
title: Posts Domain
description: Blog-style post creation, editing, search, visibility control, and file attachment management in FictionPlanet
tags: [domain, posts, crud, search]
---

# Posts Domain

The Posts domain is the core content feature of FictionPlanet. Posts are blog-style articles with title, introduction, rich-text content, visibility control, and file attachments.

## Key Source Files

| File | Role |
|------|------|
| `/controllers/Posts.php` | Post CRUD controller |
| `/models/PostModel.php` | Post entity with getters/setters |
| `/models/dao/PostDAO.php` | All post SQL queries (26 KB — largest DAO) |
| `/libs/validators/NewPostsValidator.php` | Post creation validation |
| `/libs/validators/UpdatedPostsValidator.php` | Post update validation |
| `/views/posts/post.php` | Single post view |
| `/views/posts/create_post.php` | Post creation form |
| `/views/posts/update_post.php` | Post editing form |
| `/static/js/postFunctions.js` | Post CRUD DataTables + AJAX |

## Post Entity (`PostModel`)

- **id**, **url** (unique slug), **author_id** (FK to users)
- **title**, **introduction**, **content** (mediumtext — rich HTML via CKEditor)
- **creation_date**, **last_update_date**
- **visible** (boolean — can be hidden from public view)

The database has unique constraints on both `title` and `url`.

## Post Controller (`Posts`)

### Permission Checks
All post actions check `$_SESSION['permissions'][MDL_POSTS]['r']` for read, `['w']` for create, `['u']` for update, `['d']` for delete. Unauthorized users are redirected to the homepage.

### Actions

| Method | URL | Description |
|--------|-----|-------------|
| `posts()` | `/posts` | Admin post listing page |
| `get($postURL)` | `/posts/get/<slug>` | View single post |
| `create($validator)` | `/posts/create` | Show creation form |
| `submit_new_post()` | `/posts/submit_new_post` | Process post creation |
| `update($postURL)` | `/posts/update/<slug>` | Show edit form |
| `submit_update_post()` | `/posts/submit_update_post` | Process post update |
| `delete_post()` | `/posts/delete_post` | AJAX delete |
| `restore_post()` | `/posts/restore_post` | AJAX restore |
| `posts_data_table_load()` | AJAX | DataTables JSON load |
| `profile_posts_data_table_load()` | AJAX | User profile DataTables load |
| `upload_attachments()` | AJAX | File upload handler |
| `delete_attached_file()` | AJAX | File removal |
| `update_attached_file()` | AJAX | File rename |

## Post Creation Workflow

1. User visits `/posts/create` — temporary directory `uploads/posts/attachments/temp-{userId}/` is created
2. User uploads files via AJAX (`upload_attachments()`) to the temp directory
3. User submits the form — `NewPostsValidator` validates title, introduction, content, visibility
4. On validation success:
   - A friendly URL slug is generated from the title via `Utilities::friendly_url_generator()`
   - `PostDAO::insert_post()` inserts the row
   - The new post ID is retrieved via `PostDAO::get_post_by_title()`
   - The temp directory is moved to `uploads/posts/attachments/{postId}/`
5. Post visibility defaults to **not visible** (unchecked checkbox)

## Post Update Workflow

1. User visits `/posts/update/<slug>` — post data is loaded
2. User edits and submits — `UpdatedPostsValidator` validates
3. On success, `PostDAO::update_post()` updates the row
4. Attached files can be managed (uploaded, renamed, deleted) via AJAX

## Search

The `Home` controller handles post search at `/home/search`:

- Searches by title, author, introduction, content, or all fields
- Uses `PostDAO::search_post()` or `PostDAO::advanced_search_post()` with LIKE queries
- Results are paginated with the standard pagination component

## Visibility & Access Control

- **Visible posts**: Shown in homepage, gallery, and search to all users
- **Hidden posts**: Only visible to the author and users with `MDL_POSTS['r']` permission
- The `Home` controller only fetches visible posts via `PostDAO::get_all_visible_posts_by_last_update_date_desc()`

## File Attachments

- Uploaded to `uploads/posts/attachments/{postId}/`
- Listed via `Utilities::get_all_contents_of_directory()`
- Managed through AJAX endpoints in `Posts` controller
- CKEditor uploads go to `uploads/editor/img/` (separate from post attachments)

## Related Pages

- [Architecture Overview](/openwiki/architecture/overview.md) — MVC pattern, permission system
- [Users & Auth](/openwiki/domain/users-and-auth.md) — author identity, permission checks
- [Image Gallery](/openwiki/domain/images-and-gallery.md) — image uploads used in posts
- [Configuration](/openwiki/operations/configuration.md) — upload paths, module constants