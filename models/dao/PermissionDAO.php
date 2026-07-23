<?php
require_once MODELS_PATH . "PermissionModel.php";
require_once MODELS_PATH . "ModuleModel.php";
require_once MODELS_PATH . "RoleModel.php";

require_once DAO_PATH . "ModuleDAO.php";

class PermissionDAO {
    
    private static function fetch_permissions($connection, PDOStatement $queryResult) {
        $permissionArray = array();
        while ($record = $queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (empty($record)) {
                $permissionArray = null;
                break;
            }

            $objectPermission = new PermissionModel($record["id"], $record["role_id"], $record["module_id"], 
                    $record["r"], $record["w"], $record["u"], $record["d"]);

            $permissionArray[] = $objectPermission;
        }
        return $permissionArray;
    }
    
    /* Devuelve todos los permisos de los diferentes roles en los distintos modulos
    existentes en la base de datos     */
    public static function get_all_permission($connection) {
        $permissionArray = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM permissions");
                $sentence->execute();
                $permissionArray = self::fetch_permissions($connection, $sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $permissionArray;
    }
    
    /* Devuelve los permisos de un mododulo y un rol concretos especificados por un
    identificador */
    public static function get_permission_by_id($connection, int $idPermission) {
        $permissionObject = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM permissions WHERE id = :idPermission;");
                $sentence->bindParam(":idPermission", $idPermission, PDO::PARAM_INT);
                $sentence->execute();
                $result = $sentence->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $permissionObject = new PermissionModel($result["id"], $result["role_id"], $result["module_id"], 
                        $result["r"], $result["w"], $result["u"], $result["d"]);
                }
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $permissionObject;
    }
    
    /* Actualiza los permisos de un modulo especifico que tiene un rol concreto. Para ello, se indica el rol
    que tiene los permisos mediante un idRol y tambien se indica el modulo sobre el que recaen dichos permisos mediante
    un idModule */
    public static function update_permissions_role($connection, $idModule, $idRole, $r, $w, $u, $d) {
        if (isset($connection)) {
            try {
                $updateSql = "UPDATE permissions SET r = :r, w = :w, u = :u, d = :d WHERE role_id = :idRole AND module_id = :idModule";
                
                $sentence = $connection->prepare($updateSql);
                
                $sentence->bindParam(":r", $r, PDO::PARAM_INT);
                $sentence->bindParam(":w", $w, PDO::PARAM_INT);
                $sentence->bindParam(":u", $u, PDO::PARAM_INT);
                $sentence->bindParam(":d", $d, PDO::PARAM_INT);
                $sentence->bindParam(":idRole", $idRole, PDO::PARAM_INT);
                $sentence->bindParam(":idModule", $idModule, PDO::PARAM_INT);
                
                return $sentence->execute();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false;
        }
    }
    
    /* Devuelve todos los permisos asociados a un modulo especifico, asi como los identificadores de los roles que tienen 
    dichos persimos */
    public static function get_permission_by_module($connection, ModuleModel $module) {
        $permissionArray = null;

        if (isset($connection)) {
            try {                
                $sql = "SELECT * FROM permissions WHERE module_id = :idModule;";
                $sentence = $connection->prepare($sql);
                $sentence->bindValue(":idModule", $module->get_id(), PDO::PARAM_INT); // bindValue en lugar de bindParam
                $sentence->execute();
                $permissionArray = self::fetch_permissions($connection, $sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $permissionArray;
    }
    
    /* Devuelve todos los permisos que tiene un rol concreto sobre cada uno de los modulos existentes. El resultado estará 
    ordenado por el numero identificativo de los modulos ascendente */
    public static function get_permissions_of_role_ordered_by_module($connection, RoleModel $role) {
        $modulePermissionsArray = null;
        
        if (isset($connection)) {
            try {                
                $sql = "SELECT P.module_id, M.name, M.name_esp, P.role_id, P.r, P.w, P.u, P.d FROM permissions AS P "
                        . "INNER JOIN modules AS M ON P.module_id = M.id WHERE P.role_id = :idRole ORDER BY P.module_id;";
                
                $sentence = $connection->prepare($sql);
                $sentence->bindValue(":idRole", $role->get_id(), PDO::PARAM_INT); // bindValue en lugar de bindParam
                $sentence->execute();
                $modulePermissionsArray = array();
                while ($record = $sentence->fetch(PDO::FETCH_ASSOC)) {
                    $modulePermissionsArray[$record["module_id"]] = $record;
                }
                
                /*$request = $sentence->fetchAll(PDO::FETCH_ASSOC); Funciona*/
                
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }
        
        return $modulePermissionsArray;
    }
    
    /* Devuelve todos los permisos sobre todos los modulos que tienen cada uno de los roles existentes. El resultado estará
    ordenado por el numero de identificativo de los roles de forma ascendente */
    public static function get_permissions_of_all_roles_ordered_by_role($connection) {
        $modulePermissionsArray = null;
        
        if (isset($connection)) {
            try {                
                $sql = "SELECT P.module_id, M.name, M.name_esp, P.role_id, P.r, P.w, P.u, P.d FROM permissions AS P "
                        . "INNER JOIN modules AS M ON P.module_id = M.id ORDER BY P.role_id";
                
                $sentence = $connection->prepare($sql);
                $sentence->execute();
                $modulePermissionsArray = array();
                while ($record = $sentence->fetch(PDO::FETCH_ASSOC)) {
                    $modulePermissionsArray[$record["role_id"]][] = $record;
                }
                
                /*$request = $sentence->fetchAll(PDO::FETCH_ASSOC); Funciona*/
                
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }
        
        return $modulePermissionsArray;
    }
    
    /* Asocia a un nuevo rol especificado todos los permisos de cada modulo a 0 */
    public static function insert_permission_to_role($connection, RoleModel $role) {
        if (isset($connection)) {
            try {
                $modules = ModuleDAO::get_all_modules($connection);
                if (!is_null($modules) && !empty($modules)) {
                    foreach($modules as $module) {
                        $sql = "INSERT INTO permissions (role_id, module_id, r, w, u, d) VALUES (:idRole, :idModule, 0, 0, 0, 0)";
                
                        $sentence = $connection->prepare($sql);
                        $sentence->bindValue(":idRole", $role->get_id(), PDO::PARAM_INT);
                        $sentence->bindValue(":idModule", $module->get_id(), PDO::PARAM_INT);
                        $result = $sentence->execute();
                        
                        if (!$result) {
                            break;
                        }
                    }
                    return $result;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }
    
}