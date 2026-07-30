<?php

function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) {
            continue;
        }
        $key = trim($parts[0]);
        $value = trim($parts[1]);
        if (!array_key_exists($key, $_ENV) && !array_key_exists($key, $_SERVER)) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

loadEnv(realpath(__DIR__) . '/.env');

function h($s) {
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

define('BASE_DIR', '/');
define('BASE_URL', (getenv('APP_URL') ?: 'http://' . $_SERVER['SERVER_NAME']) . BASE_DIR);

// URLS------------>
define('VIEW_URL', BASE_URL . 'views/');
define('APP_URL', BASE_URL . 'app/');
define('STATIC_URL', BASE_URL . 'static/');
define('IMAGES_URL', STATIC_URL . 'img/');
define('MODEL_URL', BASE_URL . 'model/');
define('TEMPLATES_URL', BASE_URL . 'templates/');
define('PLUGINS_URL', BASE_URL . 'plugins/');

// FRIENDLY URLS---->
define('CONTACT', 'about_us');
define('HOME', '');
define('USERS', 'users');
define('POSTS', 'posts');
define('ROLES', 'roles');
define('LOGIN', 'login');
define('PROFILE', USERS . '/profile');
define('CREATE_USER', USERS . '/create');
define('GET_POST', POSTS . '/get');
define('CREATE_POST', POSTS . '/create');
define('UPDATE_POST', POSTS . '/update');
define('PAGE', 'page');
define('GALLERY', 'image_gallery');
define('GET_IMAGE', GALLERY . '/get');

define('SEARCH', 'home/search');

define('CONTACT_SEO_URL', BASE_URL . CONTACT);
define('HOME_SEO_URL', BASE_URL . HOME);
define('PROFILE_SEO_URL', BASE_URL . PROFILE);
define('USERS_SEO_URL', BASE_URL . USERS);
define('POST_SEO_URL', BASE_URL . GET_POST);
define('POSTS_SEO_URL', BASE_URL . POSTS);
define('ROLES_SEO_URL', BASE_URL . ROLES);
define('LOGIN_SEO_URL', BASE_URL . LOGIN);
define('CREATE_POST_SEO_URL', BASE_URL . CREATE_POST);
define('CREATE_USER_SEO_URL', BASE_URL . CREATE_USER);
define('UPDATE_POST_SEO_URL', BASE_URL . UPDATE_POST);
define('GALLERY_SEO_URL', BASE_URL . GALLERY);
define('IMAGE_SEO_URL', BASE_URL . GALLERY);
define('SEARCH_POST_SEO_URL', BASE_URL . SEARCH);

// PATHS----------->
define("ROOT_DIRECTORY", realpath(__DIR__));
define('VIEWS_PATH', ROOT_DIRECTORY . '/views/');
define('APP_PATH', ROOT_DIRECTORY . '/app/');
define('STATIC_PATH', ROOT_DIRECTORY . '/static/');
define('IMAGES_PATH', STATIC_PATH . 'img/');
define('TEMPLATES_PATH', ROOT_DIRECTORY . '/templates/');
define('MODELS_PATH', ROOT_DIRECTORY . '/models/');
define('DAO_PATH', MODELS_PATH . 'dao/');
define('LIBS_PATH', ROOT_DIRECTORY . '/libs/');
define('CORE_PATH', LIBS_PATH . 'core/');
define('CONTROLLERS_PATH', ROOT_DIRECTORY . '/controllers/');
define('ERROR_LOG_PATH', ROOT_DIRECTORY . '/php-error.log');

// DB MYSQL-------->
define('DB_TYPE', $_ENV['DB_TYPE'] ?? 'mysql');
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'fictionplanetdb');
define('DB_CHARSET', $_ENV['DB_CHARSET'] ?? 'utf8mb4');

// APP----------->
define('APP_DEBUG', filter_var($_ENV['APP_DEBUG'] ?? 'false', FILTER_VALIDATE_BOOLEAN));

// TIPOS USUARIOS
define('ROOT', 1);
define('REGISTERED_USER', 4);

define('UPLOAD_POSTS_DIR', '/uploads/posts/attachments/');
define('UPLOAD_IMG_EDITOR_DIR', '/uploads/editor/img/');
define('UPLOAD_IMG_GALLERY_DIR', '/uploads/gallery/');
define('UPLOAD_IMG_GALLERY_URL', BASE_URL . 'uploads/gallery/');

define('MODULE_1', 'users');
define('MODULE_2', 'roles');
define('MODULE_3', 'posts');
define('MODULE_4', 'calendar_events');
define('MODULE_5', 'publisher_data');
define('MODULE_6', 'personal_data');
define('MODULE_7', 'chat_services');
define('MODULE_8', 'images');

define('MDL_USERS', 1);
define('MDL_ROLES', 2);
define('MDL_POSTS', 3);
define('MDL_PUBLIC_CALENDAR', 4);
define('MDL_PUBL_DATA', 5);
define('MDL_PRSN_DATA', 6);
define('MDL_CHAT', 7);
define('MDL_IMAGES', 8);
