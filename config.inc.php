<?php
define('BASE_DIR', '/');
//define('BASE_PORT', ':8080');
define('BASE_URL', 'http://' . $_SERVER['SERVER_NAME'] . BASE_DIR);

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
define('SEARCH', 'buscar');

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


// PATHS----------->
//define("ROOT_DIRECTORY", realpath(dirname(__FILE__))); //para php < 5.3
define("ROOT_DIRECTORY", realpath(__DIR__));
// realpath(__DIR__) para php 5.3+
// define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/' . BASE_DIR); --> lo mismo que ROOT_DIRECTORY
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
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'fictionplanetdb');
define('DB_CHARSET', 'utf8mb4');

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
define('MODULE_5', 'publisher_data'); /* Duda */
define('MODULE_6', 'personal_data'); /* Duda */
define('MODULE_7', 'chat_services');
define('MODULE_8', 'shopping_data'); /* Duda */
define('MODULE_9', 'images');

define('MDL_USERS', 1);
define('MDL_ROLES', 2);
define('MDL_POSTS', 3);
define('MDL_PUBLIC_CALENDAR', 4);
define('MDL_PUBL_DATA', 5); /* Duda */
define('MDL_PRSN_DATA', 6); /* Duda */
define('MDL_CHAT', 7);
//define('MDL_SHPPNG_DATA', 8); /* Duda */
//define('MDL_IMAGES', 9);

define('OPERATION_1', 'view');
define('OPERATION_2', 'create');
define('OPERATION_3', 'edit');
define('OPERATION_4', 'delete');
define('OPERATION_5', 'list');
?>