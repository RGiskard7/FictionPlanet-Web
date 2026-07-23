<?php
require_once MODELS_PATH . "UserModel.php";
require_once MODELS_PATH . "RoleModel.php";
require_once MODELS_PATH . "PermissionModel.php";

require_once DAO_PATH . "UserDAO.php";
require_once DAO_PATH . "RoleDAO.php";
require_once DAO_PATH . "PermissionDAO.php";

require_once LIBS_PATH . "validators/LoginValidator.php";

class Login extends Controller{
    
    public function login() {
        if (Session::is_started()) {
            Redirection::redirect(BASE_URL);
        }
        
        if (isset($_POST["submitLogin"])) {
            if (!Session::verify_csrf()) {
                $data['pageTitle'] = 'Iniciar sesión | Fiction Planet';
                $this->view->render($this, "login", $data);
                return;
            }

            $now = time();
            $attempts = $_SESSION['login_attempts'] ?? ['count' => 0, 'first_at' => $now];
            if ($attempts['count'] >= 5 && ($now - $attempts['first_at']) < 60) {
                $wait = 60 - ($now - $attempts['first_at']);
                $data['pageTitle'] = 'Iniciar sesión | Fiction Planet';
                $data['rate_limit'] = "Demasiados intentos. Espere {$wait} segundos.";
                $this->view->render($this, "login", $data);
                return;
            }
            if (($now - $attempts['first_at']) >= 60) {
                $attempts = ['count' => 0, 'first_at' => $now];
            }

            $email = trim(htmlentities($_POST['emailLogin'], ENT_QUOTES));
            $password = trim(htmlentities($_POST["passwordLogin"], ENT_QUOTES));

            Connection::open_connection();
            $validator = new LoginValidator(Connection::get_connection(), $email, $password);
            if ($validator->get_error() === '' && !is_null($validator->get_user())) {
                unset($_SESSION['login_attempts']);
                $role = RoleDAO::get_role_by_id(Connection::get_connection(), $validator->get_user()->get_role());
                $permissions = PermissionDAO::get_permissions_of_role_ordered_by_module(Connection::get_connection(), $role);

                Session::log_in($validator->get_user(), $role, $permissions);
                UserDAO::update_last_access(Connection::get_connection(), $validator->get_user());
                Redirection::redirect(BASE_URL);
            }
            Connection::close_connection();

            $_SESSION['login_attempts'] = ['count' => $attempts['count'] + 1, 'first_at' => $attempts['first_at']];
            $data['validator'] = $validator;
            $data['lastEmail'] = $email;
        }
        
        $data['pageTitle'] = 'Iniciar sesión | Fiction Planet';
        
        $this->view->render($this, "login", $data);
    }
    
}