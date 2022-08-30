<?php
require_once MODELS_PATH . "CalendarEventModel.php";

class CalendarEventsDAO {
    private static function fetch_calendar_events($connection, PDOStatement $queryResult) {
        $calendarEventArray = array();
        
        while ($record = $queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (empty($record)) {
                $calendarEventArray = null;
                break;
            }

            $calendarEventObject = new CalendarEventModel($record["id"], $record["start"], $record["end"], $record["title"], $record["color"]);

            $calendarEventArray[] = $calendarEventObject;
        }
        
        return $calendarEventArray;
    }
    
    public static function get_calendar_event_by_id($connection, $id) {
        $calendarEventObject = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM calendar_events WHERE id = :id;");
                $sentence->bindParam(":id", $id, PDO::PARAM_INT);
                $sentence->execute();
                $result = $sentence->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $calendarEventObject = new CalendarEventModel($result["id"], $result["start"], $result["end"], $result["title"], $result["color"]);
                }
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $calendarEventObject;
    }
    
    public static function get_calendar_events_by_dates($connection, $start, $end) {
         $calendarEventArray = null;

        if (isset($connection)) {
            try {                
                $sql = "SELECT * FROM  calendar_events where (date(start) >= :start AND date(start) <= :end)";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":start", $start, PDO::PARAM_STR);
                $sentence->bindParam(":end", $end, PDO::PARAM_STR);
                $sentence->execute();
                $calendarEventArray = self::fetch_calendar_events($connection, $sentence);
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return  $calendarEventArray;
    }
    
    public static function insert_calendar_event($connection, CalendarEventModel $calendarEventObject) {
        if (isset($connection)) {
            try {
                $insertSql = "INSERT INTO calendar_events (start, end, title, color) VALUES (:start, :end, :title, :color);";
                $sentence = $connection->prepare($insertSql);
                
                $sentence->bindValue(":start", $calendarEventObject->get_start(), PDO::PARAM_STR);
                $sentence->bindValue(":end", $calendarEventObject->get_end(), PDO::PARAM_STR);
                $sentence->bindValue(":title", $calendarEventObject->get_title(), PDO::PARAM_STR);
                $sentence->bindValue(":color", $calendarEventObject->get_color(), PDO::PARAM_STR);
                
                return $sentence->execute();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return false; // 0
    }
    
    public static function update_calendar_event($connection, CalendarEventModel $calendarEventObject) {
        if (isset($connection)) {
            try {
                $updateSql = "UPDATE calendar_events SET title = :title, start = :start, end = :end, color = :color WHERE id = :id;";
                
                $sentence = $connection->prepare($updateSql);
                $sentence->bindValue(":start", $calendarEventObject->get_start(), PDO::PARAM_STR);
                $sentence->bindValue(":end", $calendarEventObject->get_end(), PDO::PARAM_STR);
                $sentence->bindValue(":title", $calendarEventObject->get_title(), PDO::PARAM_STR);
                $sentence->bindValue(":color", $calendarEventObject->get_color(), PDO::PARAM_STR);
                $sentence->bindValue(":id", $calendarEventObject->get_id(), PDO::PARAM_INT);

                return $sentence->execute();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        } else {
            return false; // 0
        }
    }
    
    public static function delete_calendar_event($connection, CalendarEventModel $calendarEventObject) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("DELETE FROM calendar_events WHERE id = :id;");
                $sentence->bindValue(":id", $calendarEventObject->get_id(), PDO::PARAM_INT);
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

