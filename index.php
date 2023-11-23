<?php
require_once realpath(dirname(__FILE__)) . "/config.inc.php";
require_once CORE_PATH . "App.php";

error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', FALSE);
ini_set('log_errors', TRUE);
ini_set('error_log', ERROR_LOG_PATH);
//error_log('ini app');

$app = new App();