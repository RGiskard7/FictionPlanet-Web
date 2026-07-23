<?php
require_once MODELS_PATH . "ImageGalleryModel.php";
require_once MODELS_PATH . "UserModel.php";

require_once DAO_PATH . "UserDAO.php";

class ImageGalleryDAO {
    private static function fetch_images(PDOStatement $queryResult) {
        $imageArray = array();
        while ($record = $queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (empty($record)) {
                $imageArray = null;
                break;
            }

            $imageObject = new ImageGalleryModel($record['id'], $record['author_id'], 
                    $record['title'], $record['description'], $record['url'], $record['path'], 
                    $record['creation_date'], $record['last_update_date'], $record['visible']);
            $imageArray[] = $imageObject;
        }
        return $imageArray;
    }
    
    /*public static function get_all_images_by_date_creation_desc($connection) {
        $imageArray = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM image_gallery ORDER BY creation_date DESC;");
                $sentence->execute();
                $postArray = self::fetch_images($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $imageArray;
    }*/
    
    public static function get_all_images_by_date_creation_desc($connection, $init, $limit) {
        $imageArray = null;

        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM image_gallery ORDER BY creation_date DESC LIMIT " . $init . ", " . $limit . ";";
                $sentence = $connection->prepare($sql);
                $sentence->execute();
                $imageArray = self::fetch_images($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $imageArray;
    }
    
    /*public static function get_all_visible_images_by_last_update_date_desc($connection) {
        $imageArray = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM image_gallery WHERE visible = '1' ORDER BY last_update_date DESC;");
                $sentence->execute();
                $imageArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $imageArray;
    }*/
    
    public static function get_all_visible_images_by_last_update_date_desc($connection, $init, $limit) {
        $imageArray = null;

        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM image_gallery WHERE visible = '1' ORDER BY last_update_date DESC LIMIT " . $init . ", " . $limit . ";";
                $sentence = $connection->prepare($sql);
                $sentence->execute();
                $imageArray = self::fetch_images($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $imageArray;
    }
    
    public static function get_images_by_author_id($connection, $authorId) {
        $imageArray = null;

        if (isset($connection)) {
            try {                
                $sql = "SELECT * FROM image_gallery WHERE author_id = :authorId;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":authorId", $authorId, PDO::PARAM_INT);
                $sentence->execute();
                $imageArray = self::fetch_images($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $imageArray;
    }
    
    public static function get_visible_images_by_author_id($connection, $authorId, $init, $limit) {
        $imageArray = null;

        if (isset($connection)) {
            try {                
                $sql = "SELECT * FROM image_gallery WHERE author_id = :authorId AND "
                        . "visible = 1 ORDER BY last_update_date DESC LIMIT " . $init . ", " . $limit . ";";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":authorId", $authorId, PDO::PARAM_INT); // bindValue en lugar de bindParam
                $sentence->execute();
                $imageArray = self::fetch_images($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $imageArray;
    }
    
    public static function get_number_of_images($connection) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT COUNT(*) FROM image_gallery;");
                $sentence->execute();
                return $sentence->fetchColumn();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }
    
    public static function get_number_of_images_by_author_id($connection, $authorId) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT COUNT(*) FROM image_gallery WHERE author_id = :authorId;");
                $sentence->bindParam(":authorId", $authorId, PDO::PARAM_INT);
                $sentence->execute();
                return $sentence->fetchColumn();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }

    public static function get_number_of_visible_images_by_author_id($connection, $authorId) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT COUNT(*) FROM image_gallery WHERE visible = '1' "
                        . "AND author_id = :authorId;");
                $sentence->bindParam(":authorId", $authorId, PDO::PARAM_INT);
                $sentence->execute();
                return $sentence->fetchColumn();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }

    public static function get_number_of_not_visible_images_by_author_id($connection, $authorId) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT COUNT(*) FROM image_gallery WHERE visible = '0' "
                        . "AND author_id = :authorId;");
                $sentence->bindParam(":authorId", $authorId, PDO::PARAM_INT);
                $sentence->execute();
                return $sentence->fetchColumn();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }
    
    public static function get_number_of_all_visible_images($connection) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT COUNT(*) FROM image_gallery WHERE visible = '1';");
                $sentence->execute();
                return $sentence->fetchColumn();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }
    
    public static function insert_image($connection, ImageGalleryModel $imageObject) {
        if (isset($connection)) {
            try {
                $insertSql = "INSERT INTO image_gallery (author_id, title, description, url, path, visible) VALUES (:author_id, :title, :description, :url, :path, :visible);";
                
                $sentence = $connection->prepare($insertSql);
                $sentence->bindValue(":author_id", $imageObject->get_author_id(), PDO::PARAM_INT);
                $sentence->bindValue(":title", $imageObject->get_title(), PDO::PARAM_STR);
                $sentence->bindValue(":description", $imageObject->get_description(), PDO::PARAM_STR);
                $sentence->bindValue(":url", $imageObject->get_url(), PDO::PARAM_STR);
                $sentence->bindValue(":path", $imageObject->get_path(), PDO::PARAM_STR);
                $sentence->bindValue(":visible", $imageObject->is_visible(), PDO::PARAM_INT);
                
                return $sentence->execute();
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return false; // 0
    }
    
}
