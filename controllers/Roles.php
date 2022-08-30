<?php
require_once MODELS_PATH . 'RoleModel.php';
require_once MODELS_PATH . 'PermissionModel.php';

require_once DAO_PATH . 'RoleDAO.php';
require_once DAO_PATH . 'PermissionDAO.php';

class Roles extends Controller {
    
    public function roles() {
        if (!Session::is_started() || !$_SESSION['permissions'][MDL_ROLES]['r']) {
            Redirection::redirect(BASE_URL);
        }
        
        $data['pageTitle'] = 'Roles de usuario | Fiction Planet';
        
        $this->view->render($this, 'roles', $data);
    }
    
    public function roles_data_table_load() {
        if (Session::is_started() && $_SESSION['permissions'][MDL_ROLES]['r']) {  
            if (isset($_POST['action']) && $_POST['action'] === 'roleDataTableLoad') {
                $roleDataTable = array(); // Para enviar un array vacio si no hay roles

                Connection::open_connection();
                $roleArray = RoleDAO::get_all_roles(Connection::get_connection());

                if (!is_null($roleArray)) {
                    for ($i = 0; $i < count($roleArray); $i++) {
                        $permissionsBtn = "";
                        $editBtn = "";
                        $removeBtn = "";

                        if ($_SESSION['permissions'][MDL_ROLES]['u'] && $roleArray[$i]->get_id() != ROOT) {
                            $permissionsBtn = '<button type="button" class="btn btn-info btn-sm gmd-1" name="permissionsRoleBtn" id="permissionsRoleBtn" '
                                . 'data-roleid="' . $roleArray[$i]->get_id() . '" title="Permisos">'
                                . '<i class="fa fa-key fa-lg" style="color:white" aria-hidden="true"></i></button>&nbsp;&nbsp;';
                        } else {
                            $permissionsBtn = '<button type="button" class="btn btn-info btn-sm" title="Permisos" disabled>'
                                . '<i class="fa fa-key fa-lg" style="color:white" aria-hidden="true"></i></button>&nbsp;&nbsp;';
                        }

                        if ($_SESSION['permissions'][MDL_ROLES]['u'] && $roleArray[$i]->get_id() != ROOT && $roleArray[$i]->get_id() != REGISTERED_USER) {
                            $editBtn = '<button type="button" class="btn btn-warning btn-sm gmd-1" name="updateRoleBtn" id="updateRoleBtn" '
                                . 'data-roleid="' . $roleArray[$i]->get_id() . 'title="Editar"><i class="fa fa-pencil fa-lg" '
                                . 'style="color:white" aria-hidden="true"></i></button>&nbsp;&nbsp;';
                        } else {
                            $editBtn = '<button type="button" class="btn btn-warning btn-sm" title="Editar" disabled>'
                                . '<i class="fa fa-pencil fa-lg" style="color:white" aria-hidden="true"></i></button>&nbsp;&nbsp;';
                        }

                        if ($_SESSION['permissions'][MDL_ROLES]['d'] && $roleArray[$i]->get_id() != ROOT && $roleArray[$i]->get_id() != REGISTERED_USER) {
                            $removeBtn = '<button type="button" class="btn btn-danger btn-sm gmd-1" name="removeRoleBtn" id="removeRoleBtn" data-roleid="' 
                                . $roleArray[$i]->get_id() . '" data-rolename="' . $roleArray[$i]->get_sp_name() . '" title="Eliminar">'
                                . '<i class="fa fa-trash fa-lg" style="color:white" aria-hidden="true"></i></button>';
                        } else {
                            $removeBtn = '<button type="button" class="btn btn-danger btn-sm" title="Eliminar" disabled>'
                                . '<i class="fa fa-trash fa-lg" style="color:white" aria-hidden="true"></i></button>';
                        }

                        $roleDataTable[$i]['actions'] = $permissionsBtn . $editBtn . $removeBtn;
                        $roleDataTable[$i]['index'] = $i + 1;
                        $roleDataTable[$i]['id'] = $roleArray[$i]->get_id();
                        $roleDataTable[$i]['name'] = $roleArray[$i]->get_name();
                        $roleDataTable[$i]['description'] = $roleArray[$i]->get_description();
                        $roleDataTable[$i]['name_esp'] = $roleArray[$i]->get_sp_name();
                    }
                }
                Connection::close_connection();

                $response = json_encode($roleDataTable, JSON_UNESCAPED_UNICODE);

                echo $response;
                exit;  
            } 
        }
    }
    
    public function get_role_permissions() {
        if (Session::is_started() /*&& $_SESSION['permissions'][MDL_ROLES]['u']*/) {
            if (isset($_POST['action']) && $_POST['action'] === 'get_role_permissions' && isset($_POST['roleID'])) {
                Connection::open_connection();
                $role = RoleDAO::get_role_by_id(Connection::get_connection(), trim($_POST['roleID']));
                $modulesPermissions = PermissionDAO::get_permissions_of_role_ordered_by_module(Connection::get_connection(), $role);
                Connection::close_connection();

                ob_start(); // Abrir buffer
                include TEMPLATES_PATH . 'modals/permissions_role_modal.inc.php';
                $output = ob_get_contents();
                ob_end_clean(); // Carrar buffer

                echo $output; 
            }
        }
        exit;
    }
    
    public function submit_permissions_role() {
        if (Session::is_started() /*&& $_SESSION['permissions'][MDL_ROLES]['u']*/) {
            if (isset($_POST['submitPermissionsRole'])) {
                $idRole = $_POST['rolePermissionsID'];
                $numModules = $_POST['numModulesPermissions'];

                for($i = 0; $i < $numModules; $i++) {
                    $moduleID = $_POST['moduleID-' . ($i + 1)];
                    if (isset($_POST['module-' . $moduleID])) {
                        if (in_array('r', $_POST['module-' . $moduleID])) {
                            $rCheck = 1;
                        } else {
                            $rCheck = 0;
                        }
                        if (in_array('w', $_POST['module-' . $moduleID])) {
                            $wCheck = 1;
                        } else {
                            $wCheck = 0;
                        }
                        if (in_array('u', $_POST['module-' . $moduleID])) {
                            $uCheck = 1;
                        } else {
                            $uCheck = 0;
                        }
                        if (in_array('d', $_POST['module-' . $moduleID])) {
                            $dCheck = 1;
                        } else {
                            $dCheck = 0;
                        }
                    } else {
                        $rCheck = 0;
                        $wCheck = 0;
                        $uCheck = 0;
                        $dCheck = 0;
                    }

                    Connection::open_connection();
                    $response = PermissionDAO::update_permissions_role(Connection::get_connection(), $moduleID, $idRole, $rCheck, $wCheck, $uCheck, $dCheck);
                    Connection::close_connection();

                    if (!$response) {
                        break;
                    }
                }

                echo $response;
            }
        }
        exit;
    }
    
    public function check_new_role_name() {
        if (Session::is_started() /*&& $_SESSION['permissions'][MDL_ROLES]['u']*/) {
            if (isset($_POST['action']) && $_POST['action'] === 'check_new_role_name') {
                $roleTitle = trim(htmlentities(addslashes($_POST['roleTitle']), ENT_QUOTES));

                Connection::open_connection();
                $response = RoleDAO::is_role_name_exist(Connection::get_connection(), $roleTitle);
                Connection::close_connection();

                echo $response;  
            }
        }
        exit;
    }
    
    public function get_role_data() {
        if (Session::is_started() /*&& $_SESSION['permissions'][MDL_ROLES]['r']*/) {
            if (isset($_POST['action']) && $_POST['action'] === 'get_role_data' &&  isset($_POST['roleID'])) {
                Connection::open_connection();
                $role = RoleDAO::get_role_by_id(Connection::get_connection(), trim($_POST['roleID']));
                Connection::close_connection();

                if ($role !== null) {
                    $result = ['succes' => true, 'roleData' => 
                        ['roleID' => html_entity_decode($role->get_id(), ENT_QUOTES, 'UTF-8'),
                        'roleName' => html_entity_decode($role->get_sp_name(), ENT_QUOTES, 'UTF-8'),
                        'roleDescription' => html_entity_decode($role->get_description(), ENT_QUOTES, 'UTF-8')]];
                } else {
                    $result = ['succes' => false, 'roleData' => null];
                }

                $response = json_encode($result);

                echo $response;   
            }
        }
        exit;
    }
    
    public function insert_new_role() {
        if (Session::is_started() /*&& $_SESSION['permissions'][MDL_ROLES]['w']*/) {
            if (isset($_POST['action']) && $_POST['action'] === 'insert_new_role') {
                $roleTitle = trim(htmlentities(addslashes($_POST['roleTitle']), ENT_QUOTES));
                $roleDescription = trim(htmlentities(addslashes($_POST['roleDescription']), ENT_QUOTES));

                Connection::open_connection();
                $role = new RoleModel(null, $roleTitle, $roleDescription, $roleTitle);
                if (!is_null($role)) {
                    $response = RoleDAO::insert_role(Connection::get_connection(), $role);
                } else {
                    $response = 0;
                }
                Connection::close_connection();

                echo $response;  
            }
        }
        exit;
    }
    
    public function submit_edit_role() {
        if (Session::is_started() /*&& $_SESSION['permissions'][MDL_ROLES]['u']*/) {
            /*if (isset($_POST["action"]) && $_POST["action"] === "submit_edit_role") {*/
            if (isset($_POST['submitEditRole'])) {
                //$roleID = trim($_POST['roleID']);
                $roleID = trim($_POST['editRoleID']);
                $editRoleTitle = trim(htmlentities(addslashes($_POST['editRoleTitle']), ENT_QUOTES));
                $editRoleDescription = trim(htmlentities(addslashes($_POST['editRoleDescription']), ENT_QUOTES));

                Connection::open_connection();
                $role = RoleDAO::get_role_by_id(Connection::get_connection(), $roleID);

                $role->set_name($editRoleTitle);
                $role->set_description($editRoleDescription);
                $role->set_sp_name($editRoleTitle);

                $result = RoleDAO::update_role(Connection::get_connection(), $role);
                Connection::close_connection();

                echo $result;  
            }
        }
        exit;
    }
    
    public function delete_role() {
        if (Session::is_started() /*&& $_SESSION['permissions'][MDL_ROLES]['d']*/) {
            if (isset($_POST["action"]) && $_POST["action"] === "delete_role" && isset($_POST["roleID"])) {
                Connection::open_connection();
                $role = RoleDAO::get_role_by_id(Connection::get_connection(), trim($_POST["roleID"]));
                $result = RoleDAO::delete_role(Connection::get_connection(), $role);
                Connection::close_connection();

                echo $result; 
            }
        }
        exit;
    }
}

?>
