<?php
require_once MODELS_PATH . "PostModel.php";
require_once MODELS_PATH . "UserModel.php";

require_once DAO_PATH . "UserDAO.php";

class PostDAO {

    private static function fetch_posts(PDOStatement $queryResult) {
        $postArray = array();
        while ($record = $queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (empty($record)) {
                $postArray = null;
                break;
            }

            $postObject = new PostModel($record["id"], $record["url"], $record["author_id"], $record["title"], $record["introduction"], $record["content"], 
                    $record["creation_date"], $record["last_update_date"], $record["visible"]);

            $postArray[] = $postObject;
        }
        return $postArray;
    }

    public static function __callStatic($method, $args) { // __call($metodo, $argumentos) cuando no es estatico			
        if ($method == 'get_all_posts_by_creation_date_desc') {
            if (count($args) == 1) { // get_all_posts_by_date_creation_desc($connection)
                $connection = $args[0];
                $postArray = null;

                if (isset($connection)) {
                    try {
                        $sentence = $connection->prepare("SELECT * FROM posts ORDER BY creation_date DESC;");
                        $sentence->execute();
                        $postArray = self::fetch_posts($sentence);
                    } catch (PDOException $e) {
                        echo "Error line: " . $e->getLine();
                        die("Error: " . $e->getMessage());
                    }
                }

                return $postArray;
            } else if (count($args) == 3) { // get_all_posts_by_date_creation_desc($connection, $init, $limit)
                $connection = $args[0];
                $init = $args[1];
                $limit = $args[2];
                $postArray = null;

                if (isset($connection)) {
                    try {
                        $sql = "SELECT * FROM posts ORDER BY creation_date DESC LIMIT " . $init . ", " . $limit . ";";
                        $sentence = $connection->prepare($sql);
                        $sentence->execute();
                        $postArray = self::fetch_posts($sentence);
                    } catch (PDOException $e) {
                        echo "Error line: " . $e->getLine();
                        die("Error: " . $e->getMessage());
                    }
                }

                return $postArray;
            }
        } else if ($method == 'get_all_posts_by_last_update_date_desc') {
            if (count($args) == 1) { // get_all_posts_by_last_update_date_desc($connection)
                $connection = $args[0];
                $postArray = null;

                if (isset($connection)) {
                    try {
                        $sentence = $connection->prepare("SELECT * FROM posts ORDER BY last_update_date DESC;");
                        $sentence->execute();
                        $postArray = self::fetch_posts($sentence);
                    } catch (PDOException $e) {
                        echo "Error line: " . $e->getLine();
                        die("Error: " . $e->getMessage());
                    }
                }

                return $postArray;
            } else if (count($args) == 3) { // get_all_posts_by_last_update_date_desc($connection, $init, $limit)
                $connection = $args[0];
                $init = $args[1];
                $limit = $args[2];
                $postArray = null;

                if (isset($connection)) {
                    try {
                        $sql = "SELECT * FROM posts ORDER BY last_update_date DESC LIMIT " . $init . ", " . $limit . ";";
                        $sentence = $connection->prepare($sql);
                        $sentence->execute();
                        $postArray = self::fetch_posts($sentence);
                    } catch (PDOException $e) {
                        echo "Error line: " . $e->getLine();
                        die("Error: " . $e->getMessage());
                    }
                }

                return $postArray;
            }
        } else if ($method == 'get_all_Posts') {
            if (count($args) == 1) { // get_all_posts($connection)
                $connection = $args[0];
                $postArray = null;

                if (isset($connection)) {
                    try {
                        $sentence = $connection->prepare("SELECT * FROM posts;");
                        $sentence->execute();
                        $postArray = self::fetch_posts($sentence);
                    } catch (PDOException $e) {
                        echo "Error line: " . $e->getLine();
                        die("Error: " . $e->getMessage());
                    }
                }

                return $postArray;
            } else if (count($args) == 3) { // get_all_posts($connection, $init, $limit)
                $connection = $args[0];
                $init = $args[1];
                $limit = $args[2];
                $postArray = null;

                if (isset($connection)) {
                    try {
                        $sql = "SELECT * FROM posts LIMIT " . $init . ", " . $limit . ";";
                        $sentence = $connection->prepare($sql);
                        $sentence->execute();
                        $postArray = self::fetch_posts($sentence);
                    } catch (PDOException $e) {
                        echo "Error line: " . $e->getLine();
                        die("Error: " . $e->getMessage());
                    }
                }

                return $postArray;
            }
        } else if ($method == 'get_all_visible_posts_by_last_update_date_desc') {
            if (count($args) == 1) { // get_all_visible_posts_by_last_update_date_desc($connection)
                $connection = $args[0];
                $postArray = null;

                if (isset($connection)) {
                    try {
                        $sentence = $connection->prepare("SELECT * FROM posts WHERE visible = '1' ORDER BY last_update_date DESC;");
                        $sentence->execute();
                        $postArray = self::fetch_posts($sentence);
                    } catch (PDOException $e) {
                        echo "Error line: " . $e->getLine();
                        die("Error: " . $e->getMessage());
                    }
                }

                return $postArray;
            } else if (count($args) == 3) { // get_all_visible_posts_by_last_update_date_desc($connection, $init, $limit)
                $connection = $args[0];
                $init = $args[1];
                $limit = $args[2];
                $postArray = null;

                if (isset($connection)) {
                    try {
                        $sql = "SELECT * FROM posts WHERE visible = '1' ORDER BY last_update_date DESC LIMIT " . $init . ", " . $limit . ";";
                        $sentence = $connection->prepare($sql);
                        $sentence->execute();
                        $postArray = self::fetch_posts($sentence);
                    } catch (PDOException $e) {
                        echo "Error line: " . $e->getLine();
                        die("Error: " . $e->getMessage());
                    }
                }

                return $postArray;
            }
        }
    }

    public static function get_post_by_id($connection, $idPost) {
        $postObject = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM posts WHERE id = :idPost;");
                $sentence->bindParam(":idPost", $idPost, PDO::PARAM_INT);
                $sentence->execute();
                $result = $sentence->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $postObject = new PostModel($result["id"], $result["url"], $result["author_id"], $result["title"], $result["introduction"], $result["content"], 
                            $result["creation_date"], $result["last_update_date"], $result["visible"]);
                }
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $postObject;
    }

    public static function get_posts_by_author_id($connection, $authorId) {
        $postArray = null;

        if (isset($connection)) {
            try {                
                $sql = "SELECT * FROM posts WHERE author_id = :authorId;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":authorId", $authorId, PDO::PARAM_INT);
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $postArray;
    }
    
    public static function get_visible_posts_by_author_id($connection, $authorId, $init, $limit) {
        $postArray = null;

        if (isset($connection)) {
            try {                
                $sql = "SELECT * FROM posts WHERE author_id = :authorId AND visible = 1 ORDER BY last_update_date DESC LIMIT " . $init . ", " . $limit . ";";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":authorId", $authorId, PDO::PARAM_INT);
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $postArray;
    }
    
    public static function get_posts_by_author_id_last_update_date_desc($connection, $authorId) {
        $postArray = null;

        if (isset($connection)) {
            try {    
                $sql = "SELECT * FROM posts WHERE author_id = :authorId ORDER BY last_update_date DESC;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":authorId", $authorId, PDO::PARAM_INT);
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $postArray;
    }
    
    public static function get_post_by_url($connection, $url) {
        $postObject = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM posts WHERE url = :url;");
                $sentence->bindParam(":url", $url, PDO::PARAM_STR);
                $sentence->execute();
                $result = $sentence->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $postObject = new PostModel($result["id"], $result["url"], $result["author_id"], $result["title"], $result["introduction"], $result["content"], 
                            $result["creation_date"], $result["last_update_date"], $result["visible"]);
                }
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $postObject;
    }
    
    public static function get_post_by_title($connection, $title) {
        $postObject = null;

        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM posts WHERE title = :title;");
                $sentence->bindParam(":title", $title, PDO::PARAM_STR);
                $sentence->execute();
                $result = $sentence->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $postObject = new PostModel($result["id"], $result["url"], $result["author_id"], $result["title"], $result["introduction"], $result["content"], 
                            $result["creation_date"], $result["last_update_date"], $result["visible"]);
                }
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return $postObject;
    }
    
    public static function get_number_of_posts($connection) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT COUNT(*) FROM posts;");
                $sentence->execute();
                return $sentence->fetchColumn();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        } else {
            return false; // 0
        }
    }
    
    public static function get_number_of_posts_by_author_id($connection, $authorId) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT COUNT(*) FROM posts WHERE author_id = :authorId;");
                $sentence->bindParam(":authorId", $authorId, PDO::PARAM_INT);
                $sentence->execute();
                return $sentence->fetchColumn();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        } else {
            return false; // 0
        }
    }

    public static function get_number_of_visible_posts_by_author_id($connection, $authorId) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT COUNT(*) FROM posts WHERE visible = '1' AND author_id = :authorId;");
                $sentence->bindParam(":authorId", $authorId, PDO::PARAM_INT);
                $sentence->execute();
                return $sentence->fetchColumn();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        } else {
            return false; // 0
        }
    }

    public static function get_number_of_not_visible_posts_by_author_id($connection, $authorId) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT COUNT(*) FROM posts WHERE visible = '0' AND author_id = :authorId;");
                $sentence->bindParam(":authorId", $authorId, PDO::PARAM_INT);
                $sentence->execute();
                return $sentence->fetchColumn();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        } else {
            return false; // 0
        }
    }

    public static function get_last_post_id($connection) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT MAX(id) FROM posts;");
                $sentence->execute();
                return $sentence->fetchColumn();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        } else {
            return false; // 0
        }
    }

    public static function get_number_of_all_visible_posts($connection) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT COUNT(*) FROM posts WHERE visible = '1';");
                $sentence->execute();
                return $sentence->fetchColumn();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        } else {
            return false; // 0
        }
    }

    public static function is_title_exist($connection, $title) {
        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM posts WHERE title = :title;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":title", $title, PDO::PARAM_STR);
                $sentence->execute();
                $result = $sentence->fetchAll();

                if (count($result)) { // SI ya existe un post con el mismo titulo se devuelve true
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
    
    public static function is_url_exist($connection, $url) {
        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM posts WHERE url = :url;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":url", $url, PDO::PARAM_STR);
                $sentence->execute();
                $result = $sentence->fetchAll();

                if (count($result)) { // SI ya existe un post con la misma url se devuelve true
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

    public static function insert_post($connection, PostModel $postObject) {
        if (isset($connection)) {
            try {
                $insertSql = "INSERT INTO posts (title, url, author_id, introduction, content, visible) VALUES (:title, :url, :author_id, :introduction, :content, :visible);";
                
                $sentence = $connection->prepare($insertSql);
                $sentence->bindValue(":title", $postObject->get_title(), PDO::PARAM_STR);
                $sentence->bindValue(":url", $postObject->get_url(), PDO::PARAM_STR);
                $sentence->bindValue(":author_id", $postObject->get_author_id(), PDO::PARAM_INT);
                $sentence->bindValue(":introduction", $postObject->get_introduction(), PDO::PARAM_STR);
                $sentence->bindValue(":content", $postObject->get_content(), PDO::PARAM_STR);
                $sentence->bindValue(":visible", $postObject->is_visible(), PDO::PARAM_INT);
                
                return $sentence->execute();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        }

        return false; // 0
    }
    
    public static function update_post($connection, PostModel $postObject) {
        if (isset($connection)) {
            try {
                $updateSql = "UPDATE posts SET url = :url, title = :title, introduction = :introduction, content = :content, visible = :visible WHERE id = :idPost;";
                
                $sentence = $connection->prepare($updateSql);
                $sentence->bindValue(":title", $postObject->get_title(), PDO::PARAM_STR);
                $sentence->bindValue(":url", $postObject->get_url(), PDO::PARAM_STR);
                $sentence->bindValue(":introduction", $postObject->get_introduction(), PDO::PARAM_STR);
                $sentence->bindValue(":content", $postObject->get_content(), PDO::PARAM_STR);
                $sentence->bindValue(":visible", $postObject->is_visible(), PDO::PARAM_INT);
                $sentence->bindValue(":idPost", $postObject->get_id(), PDO::PARAM_INT);

                return $sentence->execute();
            } catch (PDOException $e) {
                echo "Error line: " . $e->getLine();
                die("Error: " . $e->getMessage());
            }
        } else {
            return false; // 0
        }
    }

    public static function delete_post($connection, $idPost) {
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("DELETE FROM posts WHERE id = :idPost;");
                $sentence->bindParam(":idPost", $idPost, PDO::PARAM_INT);
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