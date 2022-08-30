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
            $email = trim(htmlentities(addslashes($_POST['emailLogin']), ENT_QUOTES));
            $password = trim(htmlentities(addslashes($_POST["passwordLogin"]), ENT_QUOTES));

            Connection::open_connection();
            $validator = new LoginValidator(Connection::get_connection(), $email, $password);
            if ($validator->get_error() === '' && !is_null($validator->get_user())) {
                $role = RoleDAO::get_role_by_id(Connection::get_connection(), $validator->get_user()->get_role());
                $permissions = PermissionDAO::get_permissions_of_role_ordered_by_module(Connection::get_connection(), $role);

                Session::log_in($validator->get_user(), $role, $permissions);
                UserDAO::update_last_access(Connection::get_connection(), $validator->get_user());
                Redirection::redirect(BASE_URL);
            }
            Connection::close_connection();

            $data['validator'] = $validator;
            $data['lastEmail'] = $email;
        }
        
        $data['pageTitle'] = 'Iniciar sesión | Fiction Planet';
        
        $this->view->render($this, "login", $data);
    }
    
}

?>
