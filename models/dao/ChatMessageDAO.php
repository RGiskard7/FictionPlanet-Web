<?php
require_once MODELS_PATH . "ChatMessageModel.php";
require_once MODELS_PATH . "UserModel.php";

require_once DAO_PATH . "UserDAO.php";

class ChatMessageDAO {
    
    private static function fetch_chat_messages(PDOStatement $queryResult) {
        $ChatMessagesArray = array();
        
        while ($record = $queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (empty($record)) {
                $ChatMessagesArray = null;
                break;
            }

            $chatMessagesObject = new ChatMessageModel($record["id"], $record["sender_user_id"], $record["receiver_user_id"], 
                    $record["message"], $record["timestamp"], $record["status"]);

            $ChatMessagesArray[] = $chatMessagesObject;
        }
        
        return $ChatMessagesArray;
    }
    
    public static function get_all_chat_message($connection) {
        $chatMessagesArray = null;
        
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM chat_message");
                $sentence->execute();
                $chatMessagesArray = self::fetch_chat_messages($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }
        
        return $chatMessagesArray;
    }
    
    public static function get_chat_message($connection, $senderUserId, $receiverUserId) {
        $chatMessagesArray = null;
        
        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM chat_message WHERE (sender_user_id = :sender_user_id AND receiver_user_id = :receiver_user_id) "
                        . "OR (sender_user_id = :receiver_user_id AND receiver_user_id = :sender_user_id) ORDER BY timestamp ASC;";
                
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":sender_user_id", $senderUserId, PDO::PARAM_INT);
                $sentence->bindParam(":receiver_user_id", $receiverUserId, PDO::PARAM_INT);
                $sentence->execute();
                
                $chatMessagesArray = self::fetch_chat_messages($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $chatMessagesArray;
    }
    
    public static function set_status_chat_message($connection, $senderUserId, $receiverUserId, $oldStatus, $newStatus) {
        if (isset($connection)) {
            try {
                $updateSql = "UPDATE chat_message SET status = :newStatus WHERE sender_user_id = :receiverUserId AND "
                        . "receiver_user_id = :senderUserId AND status = :oldStatus";
                
                $sentence = $connection->prepare($updateSql);
                $sentence->bindParam(":senderUserId", $senderUserId, PDO::PARAM_INT);
                $sentence->bindParam(":receiverUserId", $receiverUserId, PDO::PARAM_INT);
                $sentence->bindParam(":oldStatus", $oldStatus, PDO::PARAM_INT);
                $sentence->bindParam(":newStatus", $newStatus, PDO::PARAM_INT);
                
                return $sentence->execute();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }
    
    public static function get_unread_message_count($connection, $senderUserId, $receiverUserId) {
        if (isset($connection)) {
            try {
                $sql = "SELECT COUNT(*) FROM chat_message WHERE sender_user_id = :senderUserId AND "
                        . "receiver_user_id = :receiverUserId AND status = '0'";
                
                $sentence = $connection->prepare($sql);
                
                $sentence->bindParam(":senderUserId", $senderUserId, PDO::PARAM_INT);
                $sentence->bindParam(":receiverUserId", $receiverUserId, PDO::PARAM_INT);
                $sentence->execute();
                
                $num = $sentence->fetchColumn();
                
                $output = "";
                if ($num > 0) {
                    $output = $num;
                }
                return $output;
                
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }
    
    public static function get_all_unread_message_count($connection, $receiverUserId) {
        if (isset($connection)) {
            try {
                $sql = "SELECT COUNT(*) FROM chat_message WHERE receiver_user_id = :receiverUserId AND status = '0'";
                
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":receiverUserId", $receiverUserId, PDO::PARAM_INT);
                $sentence->execute();
                
                $num = $sentence->fetchColumn();

                $output = "";
                if ($num > 0) {
                    $output = $num;
                }
                return $output;
                
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }
    
    public static function insert_chat_message($connection, ChatMessageModel $chatMessagesObject) {
        if (isset($connection)) {
            try {
                $insertSql = "INSERT INTO chat_message (sender_user_id, receiver_user_id, message, status) "
                        . "VALUES (:senderUserId, :receiverUserId, :message, :status);";
                
                $sentence = $connection->prepare($insertSql);
                
                $sentence->bindValue(":senderUserId", $chatMessagesObject->getSenderUserId(), PDO::PARAM_INT);
                $sentence->bindValue(":receiverUserId", $chatMessagesObject->getReceiverUserId(), PDO::PARAM_INT);
                $sentence->bindValue(":message", $chatMessagesObject->getMessage(), PDO::PARAM_STR);
                $sentence->bindValue(":status", $chatMessagesObject->getStatus(), PDO::PARAM_INT);
                
                 return $sentence->execute();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }
}
