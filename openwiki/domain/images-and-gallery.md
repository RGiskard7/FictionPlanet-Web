---
type: Domain
title: Image Gallery Domain
description: Image upload, gallery display, pagination, and permission-controlled image management in FictionPlanet
tags: [domain, images, gallery, upload]
---

# Image Gallery Domain

The Image Gallery provides image upload, metadata management, and paginated public gallery display with visibility control.

## Key Source Files

| File | Role |
|------|------|
| `/controllers/Image_gallery.php` | Gallery controller with pagination and CRUD |
| `/models/ImageGalleryModel.php` | Image entity |
| `/models/dao/ImageGalleryDAO.php` | Image SQL queries |
| `/app/imageGalleryController.php` | AJAX image upload + metadata endpoints |
| `/app/ckeditorUpload.php` | CKEditor image upload handler |
| `/views/image_gallery/gallery.php` | Gallery view with lightbox |
| `/static/js/imageGalleryFunctions.js` | Gallery CRUD JS (DataTables) |

## Image Entity (`ImageGalleryModel`)

- **id**, **author_id** (FK to users)
- **title**, **description**, **url** (slug), **path** (filesystem path)
- **creation_date**, **last_update_date**
- **visible** (boolean)

## Gallery Controller (`Image_gallery`)

### Public Actions

| Method | URL | Description |
|--------|-----|-------------|
| `image_gallery()` | `/image_gallery` | Public gallery (paginated, visible images only) |
| `page($number)` | `/image_gallery/page/<n>` | Paginated gallery page |

Both methods use `ImageGalleryDAO::get_all_visible_images_by_last_update_date_desc()` with pagination (12 images per page, 7 max links).

### Admin Actions (AJAX)

| Method | Description |
|--------|-------------|
| `images_data_table_load()` | DataTables JSON load for user's own images |
| `upload_new_image()` | Process image upload |
| `submit_update_image()` | Update image metadata |
| `delete_image()` | Delete image |

## Upload Flow

### Via Image Gallery (`/app/imageGalleryController.php`)
1. User uploads through the gallery modal
2. File is saved to `uploads/gallery/{authorId}/` with a timestamped filename
3. `ImageGalleryDAO::insert_image()` stores metadata in the DB
4. The image URL is generated from the original filename

### Via CKEditor (`/app/ckeditorUpload.php`)
1. CKEditor sends image upload via its standard file browser
2. File is saved to `uploads/editor/img/`
3. Returns the URL to CKEditor for inline embedding in post content

## Gallery Display

The public gallery (`/views/image_gallery/gallery.php`) uses `baguetteBox.js` for a lightbox experience. Images are displayed in a responsive grid with title and description.

## Permission Checks

- Viewing gallery: `MDL_IMAGES['r']` check for admin DataTable access
- Upload: `MDL_IMAGES['w']` check
- Edit/Delete: `MDL_IMAGES['u']` / `['d']` checks
- The public gallery displays all visible images without authentication

## Related Pages

- [Architecture Overview](/openwiki/architecture/overview.md) — permission system, pagination
- [Posts Domain](/openwiki/domain/posts.md) — CKEditor image embedding in posts
- [Users & Auth](/openwiki/domain/users-and-auth.md) — author identity, permission checks
- [Configuration](/openwiki/operations/configuration.md) — upload paths, gallery directory