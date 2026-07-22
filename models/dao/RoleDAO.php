<?php
require_once MODELS_PATH . "RoleModel.php";
require_once MODELS_PATH . "PermissionModel.php";

require_once DAO_PATH . "PermissionDAO.php";

class RoleDAO {
    
    private static function fetch_roles(PDOStatement $queryResult) {
        $roleArray = array();
        while ($record = $queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (empty($record)) {
                $roleArray = null;
                break;
            }

            $roleObject = new RoleModel($record["id"], $record["name"], $record["description"], $record["name_esp"]);
            $roleArray[] = $roleObject;
        }
        return $roleArray;
    }
    
    public static function get_all_roles($connection) {
        $roleArray = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM roles");
                $sentence->execute();
                $roleArray = self::fetch_roles($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $roleArray;
    }
    
    public static function get_role_by_id($connection, $idRole) {
        $roleObject = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM roles WHERE id = :idRole;");
                $sentence->bindParam(':idRole', $idRole, PDO::PARAM_INT);
                $sentence->execute();
                $result = $sentence->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $roleObject = new RoleModel($result["id"], $result["name"], $result["description"], $result["name_esp"]);
                }
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $roleObject;
    }
    
    public static function is_role_name_exist($connection, $roleName) {
        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM roles WHERE name = :roleName;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":roleName", $roleName, PDO::PARAM_STR);
                $sentence->execute();
                $result = $sentence->fetchAll();

                if (count($result)) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $ex) {
                throw new AppException("Database error: " . $ex->getMessage(), 500, $ex);
            }
        } else {
            return false; // 0
        }
    }
    
    public static function insert_role($connection, RoleModel $role) {
        if (isset($connection)) {
            try {
                $insertSql = "INSERT INTO roles (name, description, name_esp) VALUES (:name, :description, :name_esp)";
                
                $sentence = $connection->prepare($insertSql);
                
                $sentence->bindValue(":name", $role->get_name(), PDO::PARAM_STR);
                $sentence->bindValue(":description", $role->get_description(), PDO::PARAM_STR);
                $sentence->bindValue(":name_esp", $role->get_sp_name(), PDO::PARAM_STR);
                
                return $sentence->execute();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }
    
    public static function delete_role($connection, RoleModel $role) {
        if (isset($connection)) {
            try {
                $deleteSql = "DELETE FROM roles WHERE id = :idRole;";
                $sentence = $connection->prepare($deleteSql);
                $sentence->bindValue(':idRole', $role->get_id(), PDO::PARAM_INT);

                return $sentence->execute();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }

        } else {
            return false; // 0
        }
    }
    
    public static function update_role($connection, RoleModel $role) {
        if (isset($connection)) {
            try {
                $updateSql = "UPDATE roles SET name = :name, description = :description, name_esp = :name_esp WHERE id = :idRole;";

                $sentence = $connection->prepare($updateSql);

                $sentence->bindValue(':idRole', $role->get_id(), PDO::PARAM_INT);
                $sentence->bindValue(":name", $role->get_name(), PDO::PARAM_STR);
                $sentence->bindValue(":description", $role->get_description(), PDO::PARAM_STR);
                $sentence->bindValue(":name_esp", $role->get_sp_name(), PDO::PARAM_STR);
                
                return $sentence->execute();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
            
        } else {
            return false; // 0
        }
    }
}
?>

