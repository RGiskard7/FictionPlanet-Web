<?php
require_once DAO_PATH . "UserDAO.php";

class NewUserValidator {

    private $user_name;
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $address;
    private $country;
    private $phone_number;
    private $role;
    
    private $error_user_name;
    private $error_first_name;
    private $error_last_name;
    private $error_email;
    private $error_password1;
    private $error_password2;
    private $error_address;
    private $error_country;
    private $error_role;
    private $error_phone_number;
    
    private $warning_start;
    private $warning_end;

    public function __construct($user_name, $first_name, $last_name, $email, $password1, $password2, $address, $country, $phone_number, $role, $connection) {
        $this->user_name = "";
        $this->first_name = "";
        $this->last_name = "";
        $this->email = "";
        $this->address = "";
        $this->country = "";
        $this->phone_number = "";
        $this->role = "";

        $this->error_user_name = $this->validate_user_name($connection, $user_name);
        $this->error_first_name = $this->validate_first_name($first_name);
        $this->error_last_name = $this->validate_last_name($last_name);
        $this->error_email = $this->validate_email($connection, $email);
        $this->error_password1 = $this->validate_password1($password1);
        $this->error_password2 = $this->validate_password2($password1, $password2);
        $this->error_address = $this->validate_address($address);
        $this->error_country = $this->validate_country($country);
        $this->error_phone_number = $this->validate_phone_number($phone_number);
        $this->error_role = $this->validate_role($role);
        
        if ($this->error_password1 === "" && $this->error_password2 === "") {
            $this->password = $password2;
        }

        $this->warning_start = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>"
                . "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
        $this->warning_end = "</div>";
    }

    private function is_variable_started($variable) {
        if (isset($variable) && !empty($variable)) {
            return true;
        } else {
            return false;
        }
    }

    private function validate_user_name($connection, $user_name) {
        if (!$this->is_variable_started($user_name)) {
            return "Complete este campo.";
        } else {
            $this->user_name = $user_name;
        }

        if (strlen($user_name) < 6) {
            return "El nombre de usuario debe tener más de 6 caracteres.";
        }

        if (strlen($user_name) > 20) {
            return "El nombre de usuario no puede tener más de 20 caracteres.";
        }

        if (UserDAO::is_user_name_exist($connection, $user_name)) {
            return "Este nombre de usuario ya está en uso. Prueba otro diferente.";
        }

        return "";
    }

    private function validate_first_name($first_name) {
        if (!$this->is_variable_started($first_name)) {
            return "Complete este campo.";
        } else {
            $this->first_name = $first_name;
        }

        if (strlen($first_name) < 2) {
            return "El nombre completo debe tener más de 2 caracteres.";
        }

        if (strlen($first_name) > 25) {
            return "El nombre completo no puede tener más de 25 caracteres.";
        }

        return "";
    }

    private function validate_last_name($last_name) {
        if (!$this->is_variable_started($last_name)) {
            return "Complete este campo.";
        } else {
            $this->last_name = $last_name;
        }

        if (strlen($last_name) < 4) {
            return "Los apellidos deben tener más de 4 caracteres.";
        }

        if (strlen($last_name) > 30) {
            return "Los apellidos no pueden tener más de 30 caracteres.";
        }

        return "";
    }

    private function validate_email($connection, $email) {
        if (!$this->is_variable_started($email)) {
            return "Complete este campo.";
        } else {
            $this->email = $email;
        }
        
        if (UserDAO::is_email_exist($connection, $email)) {
            return "Este email ya está en uso. Prueba otro diferente.";
        }
    
        return "";
    }

    private function validate_password1($password1) {
        if (!$this->is_variable_started($password1)) {
            return "Complete este campo.";
        }

        if (strlen($password1) < 8) {
            return "La contrasena debe tener al menos 8 caracteres.";
        }

        return "";
    }

    private function validate_password2($password1, $password2) {
        if (!$this->is_variable_started($password1)) {
            return "Primero debes rellenar la contrasena.";
        }

        if (!$this->is_variable_started($password2)) {
            return "Complete este campo.";
        }

        if ($password1 !== $password2) {
            return "Ambas contrasenas deben coincidir.";
        }

        return "";
    }

    private function validate_address($address) {
        if (!$this->is_variable_started($address)) {
            return "Complete este campo.";
        } else {
            $this->address = $address;
        }

        return "";
    }

    private function validate_country($country) {
        if (!$this->is_variable_started($country)) {
            return "Complete este campo.";
        } else {
            $this->country = $country;
        }

        return "";
    }

    private function validate_phone_number($phone_number) {
        if (!$this->is_variable_started($phone_number)) {
            return "Complete este campo.";
        } else {
            $this->phone_number = $phone_number;
        }

        return "";
    }
    
    private function validate_role($role) {
        if (!$this->is_variable_started($role)) {
            return "Complete este campo.";
        } else {
            $this->role = $role;
        }
        
        if ($role == 0) {
            return "Seleccione el rol del usuario.";
        }
        
        /*if ($role > 3) {
            return "Error. Seleccione un rol correcto para el usuario.";
        }*/

        return "";
    }

    public function get_user_name() {
        return $this->user_name;
    }

    public function get_first_name() {
        return $this->first_name;
    }

    public function get_last_name() {
        return $this->last_name;
    }

    public function get_email() {
        return $this->email;
    }
    
    public function get_password() {
        return $this->password;
    }

    public function get_address() {
        return $this->address;
    }

    public function get_country() {
        return $this->country;
    }
    
    public function get_phone_number() {
        return $this->phone_number;
    }
    
    public function get_role() {
        return $this->role;
    }

    public function get_error_user_name() {
        return $this->error_user_name;
    }

    public function get_error_first_name() {
        return $this->error_first_name;
    }

    public function get_error_last_name() {
        return $this->error_last_name;
    }

    public function get_error_email() {
        return $this->error_email;
    }

    public function get_error_password1() {
        return $this->error_password1;
    }

    public function get_error_password2() {
        return $this->error_password2;
    }

    public function get_error_address() {
        return $this->error_address;
    }

    public function get_error_country() {
        return $this->error_country;
    }

    public function get_error_phone_number() {
        return $this->error_phone_number;
    }
    
    public function get_error_role() {
        return $this->error_role;
    }

    public function show_user_name() {
        if ($this->user_name !== "") {
            echo 'value="' . $this->user_name . '"';
        }
    }

    public function show_error_user_name() {
        if ($this->error_user_name !== "") {
            echo $this->warning_start . $this->error_user_name . $this->warning_end;
        }
    }

    public function show_first_name() {
        if ($this->first_name !== "") {
            echo 'value="' . $this->first_name . '"';
        }
    }

    public function show_error_first_name() {
        if ($this->error_first_name !== "") {
            echo $this->warning_start . $this->error_first_name . $this->warning_end;
        }
    }

    public function show_last_name() {
        if ($this->last_name !== "") {
            echo 'value="' . $this->last_name . '"';
        }
    }

    public function show_error_last_name() {
        if ($this->error_last_name !== "") {
            echo $this->warning_start . $this->error_last_name . $this->warning_end;
        }
    }

    public function show_email() {
        if ($this->email !== "") {
            echo 'value="' . $this->email . '"';
        }
    }

    public function show_error_email() {
        if ($this->error_email !== "") {
            echo $this->warning_start . $this->error_email . $this->warning_end;
        }
    }

    public function show_error_password1() {
        if ($this->error_password1 !== "") {
            echo $this->warning_start . $this->error_password1 . $this->warning_end;
        }
    }

    public function show_error_password2() {
        if ($this->error_password2 !== "") {
            echo $this->warning_start . $this->error_password2 . $this->warning_end;
        }
    }

    public function show_address() {
        if ($this->address !== "") {
            echo 'value="' . $this->address . '"';
        }
    }

    public function show_error_address() {
        if ($this->error_address !== "") {
            echo $this->warning_start . $this->error_address . $this->warning_end;
        }
    }

    public function show_country() {
        if ($this->country !== "") {
            echo 'value="' . $this->country . '"';
        }
    }

    public function show_error_country() {
        if ($this->error_country !== "") {
            echo $this->warning_start . $this->error_country . $this->warning_end;
        }
    }

    public function show_phone_number() {
        if ($this->phone_number !== "") {
            echo 'value="' . $this->phone_number . '"';
        }
    }

    public function show_error_phone_number() {
        if ($this->error_phone_number !== "") {
            echo $this->warning_start . $this->error_phone_number . $this->warning_end;
        }
    }
    
    public function show_role($valueSelected) {
        if ($this->role !== "" && $this->role == $valueSelected) {
            echo 'selected="selected"';
        }
    }
    
    public function show_error_role() {
        if ($this->error_role !== "") {
            echo $this->warning_start . $this->error_role . $this->warning_end;
        }
    }

    public function valid_form() {
        if ($this->error_user_name === "" && $this->error_first_name === "" && $this->error_last_name === "" &&
                $this->error_email === "" && $this->error_password1 === "" && $this->error_password2 === "" &&
                $this->error_address === "" && $this->error_country === "" && $this->error_phone_number === "" &&
                $this->error_role === "") {
            return true;
        } else {
            return false;
        }
    }
    
}