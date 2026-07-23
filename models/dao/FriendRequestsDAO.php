<?php
require_once MODELS_PATH . "FriendRequestsModel.php";

class FriendRequestsDAO {
    private static function fetch_requests(PDOStatement $queryResult) {
        $requestsArray = array();
        while ($record = $queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (empty($record)) {
                $requestsArray = null;
                break;
            }

            $requestObject = new FriendRequestsModel($record['id'], $record['from_user_id'], 
                    $record['to_user_id'], $record['creation_date'], $record['last_update_date'], $record['status'], 
                    $record['accepted']);
            $requestsArray[] = $requestObject;
        }
        return $requestsArray;
    }
    
    /*public static function get_all_requests_not_answered_by_date_creation_desc($connection, $init, $limit) {
        $requestsArray = null;

        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM friend_requests WHERE status = '0' ORDER BY "
                        . "creation_date DESC LIMIT " . $init . ", " . $limit . ";";
                $sentence = $connection->prepare($sql);
                $sentence->execute();
                $requestsArray = self::fetch_requests($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $requestsArray;
    }*/
    
    public static function get_friend_request_by_id($connection, $friendRequestId) {
        $friendRequestObject = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM friend_requests WHERE id = :friendRequestId;");
                $sentence->bindParam(":friendRequestId", $friendRequestId, PDO::PARAM_INT);
                $sentence->execute();
                $result = $sentence->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $friendRequestObject = new FriendRequestsModel($record['id'], $record['from_user_id'], 
                            $record['to_user_id'], $record['creation_date'], $record['last_update_date'], $record['status'], 
                            $record['accepted']);
                }
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $postObject;
    }
    
    public static function get_friend_request_not_answered_by_to_user_id($connection, $toUserId) {
        $requestsArray = null;

        if (isset($connection)) {
            try {                
                $sql = "SELECT * FROM friend_requests WHERE to_user_id = :toUserId AND status = '0'";
                $sentence = $connection->prepare($sql);
                $sentence->bindValue(":toUserId", $toUserId, PDO::PARAM_INT); // bindValue en lugar de bindParam
                $sentence->execute();
                $requestsArray = self::fetch_requests($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $requestsArray;
    }
    
    public static function get_friend_request_not_answered_by_from_user_id($connection, $FromUserId) {
        $requestsArray = null;

        if (isset($connection)) {
            try {                
                $sql = "SELECT * FROM friend_requests WHERE from_user_id = :fromUserId "
                        . "AND status = '0' ORDER BY creation_date";
                $sentence = $connection->prepare($sql);
                $sentence->bindValue(":fromUserId", $fromUserId, PDO::PARAM_INT); // bindValue en lugar de bindParam
                $sentence->execute();
                $requestsArray = self::fetch_requests($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $requestsArray;
    }
    // Status representa si la solicitud ha sido respondida, al margen de si ha sido aceptada o no
    /*public static function set_status($connection, $fromUserId, $toUserId, $oldStatus, $newStatus) {
        if (isset($connection)) {
            try {
                $updateSql = "UPDATE friend_requests SET status = :newStatus WHERE from_user_id = :fromUserId AND "
                        . "to_user_id = :toUserId AND status = :oldStatus";
                
                $sentence = $connection->prepare($updateSql);
                $sentence->bindParam(":fromUserId", $fromUserId, PDO::PARAM_INT);
                $sentence->bindParam(":toUserId", $toUserId, PDO::PARAM_INT);
                $sentence->bindParam(":oldStatus", $oldStatus, PDO::PARAM_INT);
                $sentence->bindParam(":newStatus", $newStatus, PDO::PARAM_INT);
                
                return $sentence->execute();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }*/
    
    public static function answer_friend_request($connection, $friendRequestId, $answer) {
        if (isset($connection)) {
            try {
                $updateSql = "UPDATE friend_requests SET accepted = :answer, status = '1' "
                        . "WHERE id = :friendRequestId";
                
                $sentence = $connection->prepare($updateSql);
                $sentence->bindParam(":friendRequestId", $friendRequestId, PDO::PARAM_INT);
                $sentence->bindParam(":answer", $answer, PDO::PARAM_INT);
                
                return $sentence->execute();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }
    // Solicitud de amistad sin responder
    public static function is_friend_request_send($connection, $fromUserId, $toUserId) {
        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM friend_requests WHERE from_user_id = :fromUserId AND to_user_id = :toUserId AND status = '0'";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(':fromUserId', $fromUserId, PDO::PARAM_INT);
                $sentence->bindParam(':toUserId', $toUserId, PDO::PARAM_INT);
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
                
    public static function insert_friend_request($connection, FriendRequestsModel $FriendRequestObject) {
        if (isset($connection)) {
            try {
                $insertSql = "INSERT INTO friend_requests (from_user_id, to_user_id) VALUES (:fromUserId, :toUserId)";
                
                $sentence = $connection->prepare($insertSql);
                $sentence->bindValue(":fromUserId", $FriendRequestObject->get_from_user_id(), PDO::PARAM_INT);
                $sentence->bindValue(":toUserId", $FriendRequestObject->get_to_user_id(), PDO::PARAM_INT);

                return $sentence->execute();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    } 
}
