<?php
require_once realpath(dirname(__FILE__)) . "/../../config.inc.php";

class Connection {

    private static $connection;

    public static function open_connection() {
        if (!isset(self::$connection)) {
            try {
                self::$connection = new PDO(DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASSWORD);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Cada vez que ocurra un error PDO lanza una excepcion
            } catch (PDOException $e) {
                throw new AppException("Database connection failed: " . $e->getMessage(), 500, $e);
            }
        }
    }

    public static function close_connection() {
        if (isset(self::$connection)) {
            self::$connection = null;
        }
    }

    public static function get_connection() {
        return self::$connection;
    }

}
?>