<?php
require_once MODELS_PATH . "UserModel.php";
require_once MODELS_PATH . "RoleModel.php";

require_once DAO_PATH . "UserDAO.php";
require_once DAO_PATH . "RoleDAO.php";

class Session {

    public static function log_in($user, $role, $permissions) {
        if (session_id() == '') {
            session_start(); // Habilita el espacio en la memoria del servidor
        }

        $_SESSION['loggedInUser'] = $user;
        $_SESSION['idUser'] = $user->get_id();
        $_SESSION['userName'] = $user->get_user_name();
        $_SESSION['role'] = $role;
        $_SESSION['permissions'] = $permissions;
    }

    public static function log_out() {
        if (session_id() == '') {
            session_start();
        }
        
        if (isset($_SESSION['loggedInUser'])) {
            unset($_SESSION['loggedInUser']);
        }

        if (isset($_SESSION['idUser'])) {
            unset($_SESSION['idUser']); // Eliminar el id de la cookie (sesion) almacenada en el servidor
        }

        if (isset($_SESSION['userName'])) {
            unset($_SESSION['userName']);
        }
        
        if (isset($_SESSION['role'])) {
            unset($_SESSION['role']);
        }
        
        if (isset($_SESSION['permissions'])) {
            unset($_SESSION['permissions']);
        }

        session_destroy(); // Se destruye el espacio de memoria reservado para la sesión
    }
    
    public static function is_started() {
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['idUser']) && isset($_SESSION['userName'])
                && isset($_SESSION['role']) && isset($_SESSION['loggedInUser']) 
                && isset($_SESSION['permissions'])) {
            return true;
        }

        return false;
    }
    
    public static function user_is_logged_in($user) {
        if ($_SESSION['idUser'] == $user->get_id()) {
            return true;
        }
        return false;
    }
    
    public static function change_session_data($loggedInUser, $idUser, $userName, $role, $permissions) {
        if (self::is_started()) {
            $_SESSION['loggedInUser'] = $loggedInUser;
            $_SESSION['idUser'] = $idUser;
            $_SESSION['userName'] = $userName;
            $_SESSION['role'] = $role;
            $_SESSION['permissions'] = $permissions;
            return true;
        }
        return false;
    }
    
}