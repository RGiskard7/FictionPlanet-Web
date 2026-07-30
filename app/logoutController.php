<?php
require_once realpath(dirname(__FILE__)) . "/../config.inc.php";

ini_set('display_errors', '0');

require_once CORE_PATH . "Redirection.php";
require_once LIBS_PATH . "Session.php";

Session::log_out();
Redirection::redirect(BASE_URL);