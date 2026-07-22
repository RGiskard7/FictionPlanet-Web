<?php
require_once MODELS_PATH . "ContactModel.php";

class ContactDAO {
    private static function fetch_contacts(PDOStatement $queryResult) {
        $contactsArray = array();
        while ($record = $queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (empty($record)) {
                $contactsArray = null;
                break;
            }

            $contactObject = new contactModel($record['id'], $record['user_id'], $record['contact_id'], $record['creation_date']);
            $contactsArray[] = $contactObject;
        }
        return $contactsArray;
    }
    
    public static function get_all_contact_by_user_id($connection, $userId) {
        $contactsArray = null;
        
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM contacts WHERE user_id = :userId");
                $sentence->bindParam(':userId', $userId, PDO::PARAM_INT);
                $sentence->execute();
                $contactsArray = self::fetch_contacts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $contactsArray;
    }
    
    public static function is_contact_exist($connection, $userId, $contactId) {
        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM contacts WHERE user_id = :userId AND contact_id = :contactId;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(':userId', $userId, PDO::PARAM_INT);
                $sentence->bindParam(':contactId', $contactId, PDO::PARAM_INT);
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
    
    public static function insert_contact($connection, ContactModel $contactObject) {
        if (isset($connection)) {
            try {
                $insertSql = "INSERT INTO contacts (user_id, contact_id) VALUES (:userId, :contactId);";
                
                $sentence = $connection->prepare($insertSql);
                $sentence->bindValue(":userId", $contactObject->get_user_id(), PDO::PARAM_INT);
                $sentence->bindValue(":contactId", $contactObject->get_contact_id(), PDO::PARAM_INT);

                return $sentence->execute();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }
    
    public static function delete_contact($connection, $id) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("DELETE FROM contacts WHERE id = :id;");
                $sentence->bindParam(":id", $id, PDO::PARAM_INT);
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

