<?php
require_once DAO_PATH . "UserDAO.php";

class LoginValidator {
    private $user;
    private $error;
    
    public function __construct($connection, $email, $password) {
        $this->error = "";
        $this->user = null;
        
        if (!$this->is_variable_started($email) || !$this->is_variable_started($password)) {
            $this->error = "Debes introducir tu email y tu contraseña.";
        } else {           
            if (UserDAO::is_email_exist($connection, $email)) {
                $user = UserDAO::get_user_by_email($connection, $email);
                
                if (!is_null($user)) {
                    if (!password_verify($password, $user->get_password())) {
                        $this->error = "La contraseña introducida es incorrecta";
                    } else if (!$user->is_active()) {
                        $this->error = "El usuario está inactivo, "
                                . "póngase en contacto con los administradores de la plataforma";
                    } else {
                        $this->user = $user;
                    }
                } else {
                    //$this->error = "Datos incorrectos.";
                    $this->error = "Se ha producido un error inesperado, "
                            . "póngase en contacto con los administradores de la plataforma";
                }
            } else {
                $this->error = "El correo electrónico introducido es incorrecto";
            }
        }
    }
    
    private function is_variable_started($variable) {
        if (isset($variable) && !empty($variable)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function get_user() {
        return $this->user;
    }
    
    public function get_error() {
        return $this->error;
    }
    
    public function show_error() {
        if ($this->error !== '') {
            echo "<div class='alert alert-danger alert-dismissible' role='alert'>";
            echo $this->error;
            echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
            . "<span aria-hidden='true'>&times;</span></button></div>";
        }
    }
    
}