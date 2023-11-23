<?php
require_once MODELS_PATH . "ModuleModel.php";

require_once DAO_PATH . "RoleDAO.php";

class ModuleDAO {
    
    private static function fetch_modules(PDOStatement $queryResult) {
        $moduleArray = array();
        while ($record = $queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (empty($record)) {
                $moduleArray = null;
                break;
            }

            $moduleObject = new ModuleModel($record["id"], $record["name"]);
            $moduleArray[] = $moduleObject;
        }
        return $moduleArray;
    }
    
    public static function get_all_modules($connection) {
        $moduleArray = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM modules");
                $sentence->execute();
                $moduleArray = self::fetch_modules($sentence);
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $moduleArray;
    }
    
    public static function get_all_modules_order_by_id($connection) {
        $moduleArray = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM modules ORDER BY id");
                $sentence->execute();
                $moduleArray = self::fetch_modules($sentence);
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $moduleArray;
    }
    
    public static function get_module_by_id($connection, $idModule) {
        $moduleObject = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM modules WHERE id = :idModule;");
                $sentence->bindParam(':idModule', $idModule, PDO::PARAM_INT);
                $sentence->execute();
                $result = $sentence->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $moduleObject = new ModuleModel($result["id"], $result["name"]);
                }
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $moduleObject;
    }
    
    public static function get_module_by_name($connection, $name) {
        $moduleObject = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM modules WHERE name = :name;");
                $sentence->bindParam(':name', $name, PDO::PARAM_STR);
                $sentence->execute();
                $result = $sentence->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $moduleObject = new ModuleModel($result["id"], $result["name"]);
                }
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $moduleObject;
    }
    
}