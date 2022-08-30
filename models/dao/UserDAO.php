<?php
require_once MODELS_PATH . "UserModel.php";

class UserDAO {

    private static function fetch_users(PDOStatement $queryResult) {
        $userArray = array();
        while ($record = $queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (empty($record)) {
                $userArray = null;
                break;
            }

            $objectUser = new UserModel($record["id"], $record["user_name"], $record["first_name"], $record["last_name"], $record["email"], $record["password"], 
                    $record["address"], $record["country"], $record["phone_number"], $record["role_id"], $record["active"], $record["reg_date"], 
                    $record["last_update_date"], $record["last_access_date"]);

            $userArray[] = $objectUser;
        }
        return $userArray;
    }

    public static function get_all_user($connection) {
        $userArray = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM users");
                $sentence->execute();
                $userArray = self::fetch_users($sentence);
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $userArray;
    }
    
    public static function get_all_user_other_than($connection, $idUser) {
        $userArray = null;
        
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM users WHERE id != :idUser");
                $sentence->bindParam(':idUser', $idUser, PDO::PARAM_INT);
                $sentence->execute();
                $userArray = self::fetch_users($sentence);
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $userArray;
    }
    
    public static function get_all_active_user_other_than($connection, $idUser) {
        $userArray = null;
        
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM users WHERE id != :idUser AND active = '1'");
                $sentence->bindParam(':idUser', $idUser, PDO::PARAM_INT);
                $sentence->execute();
                $userArray = self::fetch_users($sentence);
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $userArray;
    }

    public static function get_all_user_by_reg_date_desc($connection) {
        $userArray = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM users ORDER BY reg_date DESC");
                $sentence->execute();
                $userArray = self::fetch_users($sentence);
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $userArray;
    }

    public static function get_user_by_id($connection, $idUser) {
        $userObject = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM users WHERE id = :idUser;");
                $sentence->bindParam(':idUser', $idUser, PDO::PARAM_INT);
                $sentence->execute();
                $result = $sentence->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $userObject = new UserModel($result["id"], $result["user_name"], $result["first_name"], $result["last_name"], $result["email"], 
                            $result["password"], $result["address"], $result["country"], $result["phone_number"], $result["role_id"], $result["active"], 
                            $result["reg_date"], $result["last_update_date"], $result["last_access_date"]);
                }
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $userObject;
    }
    
    public static function get_user_by_user_name($connection, $userName) {
        $userObject = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM users WHERE user_name = :userName;");
                $sentence->bindParam(':userName', $userName, PDO::PARAM_STR);
                $sentence->execute();
                $result = $sentence->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $userObject = new UserModel($result["id"], $result["user_name"], $result["first_name"], $result["last_name"], $result["email"], 
                            $result["password"], $result["address"], $result["country"], $result["phone_number"], $result["role_id"], $result["active"], 
                            $result["reg_date"], $result["last_update_date"], $result["last_access_date"]);
                }
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }
        
        return $userObject;
    }

    public static function get_user_by_email($connection, $emailUser) {
        $userObject = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM users WHERE email = :email;");
                $sentence->bindParam(':email', $emailUser, PDO::PARAM_STR);
                $sentence->execute();
                $result = $sentence->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $userObject = new UserModel($result["id"], $result["user_name"], $result["first_name"], $result["last_name"], $result["email"], 
                            $result["password"], $result["address"], $result["country"], $result["phone_number"], $result["role_id"], $result["active"], 
                            $result["reg_date"], $result["last_update_date"], $result["last_access_date"]);
                }
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $userObject;
    }

    public static function get_number_of_user($connection) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT COUNT(*) FROM users;");
                $sentence->execute();
                return $sentence->fetchAll();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        } else {
            return false; // 0
        }
    }
    
    public static function is_user_name_exist($connection, $userName) {
        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM users WHERE user_name = :userName;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":userName", $userName, PDO::PARAM_STR);
                $sentence->execute();
                $result = $sentence->fetchAll();

                if (count($result)) { // Si ya existe un usuario con el mismo userName se devuelve true
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $ex) {
                echo "Error line: " . $ex->getLine();
                die("Error: " . $ex->getMessage());
            }
        } else {
            return false; // 0
        }
    }

    public static function is_email_exist($connection, $email) {
        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM users WHERE email = :email;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":email", $email, PDO::PARAM_STR);
                $sentence->execute();
                $result = $sentence->fetchAll();

                if (count($result)) { // Si ya existe un usuario con el mismo email se devuelve true
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $ex) {
                echo "Error line: " . $ex->getLine();
                die("Error: " . $ex->getMessage());
            }
        } else {
            return false; // 0
        }
    }
    
    public static function update_last_access($connection, UserModel $userObject) {
        if (isset($connection)) {
            try {
                $updateSql = "UPDATE users SET last_access_date = current_timestamp() WHERE id = :idUser;";
                $sentence = $connection->prepare($updateSql);
                $sentence->bindValue(":idUser", $userObject->get_id(), PDO::PARAM_INT);
                return $sentence->execute();
            } catch (Exception $ex) {
                echo "Error line: " . $ex->getLine();
                die("Error: " . $ex->getMessage());
            } 
        } else {
            return false; // 0
        }
    }

    public static function insert_user($connection, UserModel $userObject) {
        if (isset($connection)) {
            try {
                $insertSql = "INSERT INTO users (user_name, first_name, last_name, email, password, role_id, address, country, phone_number, active) "
                        . "VALUES (:userName, :firstName, :lastName, :email, :password, :role, :address, :country, :phoneNumber, :active);";

                $sentence = $connection->prepare($insertSql);

                $sentence->bindValue(":userName", $userObject->get_user_name(), PDO::PARAM_STR);
                $sentence->bindValue(":firstName", $userObject->get_first_name(), PDO::PARAM_STR);
                $sentence->bindValue(":lastName", $userObject->get_last_name(), PDO::PARAM_STR);
                $sentence->bindValue(":email", $userObject->get_email(), PDO::PARAM_STR);
                $sentence->bindValue(":password", $userObject->get_password(), PDO::PARAM_STR);
                $sentence->bindValue(":role", $userObject->get_role(), PDO::PARAM_INT);
                $sentence->bindValue(":address", $userObject->get_address(), PDO::PARAM_STR);
                $sentence->bindValue(":country", $userObject->get_country(), PDO::PARAM_STR);
                $sentence->bindValue(":phoneNumber", $userObject->get_phone_number(), PDO::PARAM_INT);
                $sentence->bindValue(":active", $userObject->is_active(), PDO::PARAM_INT);

                return $sentence->execute(); //execute devuelve true si se ha realizado correctamente la consulta, o false en caso contrario
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        } else {
            return false; // 0
        }
    }
    
    public static function change_password($connection, UserModel $userObject) {
        if (isset($connection)) {
            try {
                $updateSql = "UPDATE users SET password = :password WHERE id = :idUser;";
                $sentence = $connection->prepare($updateSql);
                $sentence->bindValue(":idUser", $userObject->get_id(), PDO::PARAM_INT);
                $sentence->bindValue(":password", $userObject->get_password(), PDO::PARAM_STR);
                return $sentence->execute(); //execute devuelve true si se ha realizado correctamente la consulta, o false en caso contrario
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        } else {
            return false; // 0
        }
    }

    public static function update_user($connection, UserModel $userObject) {
        if (isset($connection)) {
            try {
                $updateSql = "UPDATE users SET user_name = :userName, first_name = :firstName, last_name = :lastName, "
                        . "email = :email, password = :password, address = :address, country = :country, phone_number = :phoneNumber, "
                        . "role_id = :role_id, active = :active WHERE id = :idUser;";

                $sentence = $connection->prepare($updateSql);

                $sentence->bindValue(':idUser', $userObject->get_id(), PDO::PARAM_INT);
                $sentence->bindValue(":userName", $userObject->get_user_name(), PDO::PARAM_STR);
                $sentence->bindValue(":firstName", $userObject->get_first_name(), PDO::PARAM_STR);
                $sentence->bindValue(":lastName", $userObject->get_last_name(), PDO::PARAM_STR);
                $sentence->bindValue(":email", $userObject->get_email(), PDO::PARAM_STR);
                $sentence->bindValue(":password", $userObject->get_password(), PDO::PARAM_STR);
                $sentence->bindValue(":address", $userObject->get_address(), PDO::PARAM_STR);
                $sentence->bindValue(":country", $userObject->get_country(), PDO::PARAM_STR);
                $sentence->bindValue(":phoneNumber", $userObject->get_phone_number(), PDO::PARAM_INT);
                $sentence->bindValue(":role_id", $userObject->get_role(), PDO::PARAM_INT);
                $sentence->bindValue(":active", $userObject->is_active(), PDO::PARAM_INT);

                return $sentence->execute();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }

        } else {
            return false; // 0
        }
    }

    public static function delete_user($connection, UserModel $userObject) {
        if (isset($connection)) {
            try {
                $deleteSql = "DELETE FROM users WHERE id = :idUser;";
                $sentence = $connection->prepare($deleteSql);
                $sentence->bindValue(':idUser', $userObject->get_id(), PDO::PARAM_INT);

                return $sentence->execute();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }

        } else {
            return false; // 0
        }
    }
}

?>