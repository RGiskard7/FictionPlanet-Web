<?php

class AppException extends Exception {

    public function __construct($message = "", $code = 500, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public static function handle(Throwable $exception) {
        $logPath = defined('ERROR_LOG_PATH') ? ERROR_LOG_PATH : __DIR__ . '/../../php-error.log';
        $message = sprintf(
            "[%s] %s in %s:%d\nStack trace:\n%s\n",
            date('Y-m-d H:i:s'),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );
        error_log($message, 3, $logPath);

        if (defined('APP_DEBUG') && APP_DEBUG) {
            http_response_code(500);
            echo "<h1>Error interno del servidor</h1>";
            echo "<pre>" . htmlspecialchars($exception->getMessage()) . "</pre>";
            return;
        }

        http_response_code(500);
        echo "<h1>Error interno del servidor</h1>";
        echo "<p>Ha ocurrido un error inesperado. Por favor, inténtelo más tarde.</p>";
    }
}
