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

    public static function get_all_posts_by_creation_date_desc($connection) {
        $postArray = null;
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM posts ORDER BY creation_date DESC;");
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }
        return $postArray;
    }

    public static function get_all_posts_by_creation_date_desc_paginated($connection, $init, $limit) {
        $postArray = null;
        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM posts ORDER BY creation_date DESC LIMIT :init, :limit;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":init", $init, PDO::PARAM_INT);
                $sentence->bindParam(":limit", $limit, PDO::PARAM_INT);
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }
        return $postArray;
    }

    public static function get_all_posts_by_last_update_date_desc($connection) {
        $postArray = null;
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM posts ORDER BY last_update_date DESC;");
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }
        return $postArray;
    }

    public static function get_all_posts_by_last_update_date_desc_paginated($connection, $init, $limit) {
        $postArray = null;
        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM posts ORDER BY last_update_date DESC LIMIT :init, :limit;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":init", $init, PDO::PARAM_INT);
                $sentence->bindParam(":limit", $limit, PDO::PARAM_INT);
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }
        return $postArray;
    }

    public static function get_all_posts($connection) {
        $postArray = null;
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM posts;");
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }
        return $postArray;
    }

    public static function get_all_posts_paginated($connection, $init, $limit) {
        $postArray = null;
        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM posts LIMIT :init, :limit;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":init", $init, PDO::PARAM_INT);
                $sentence->bindParam(":limit", $limit, PDO::PARAM_INT);
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }
        return $postArray;
    }

    public static function get_all_visible_posts_by_last_update_date_desc($connection) {
        $postArray = null;
        if (isset($connection)) {
            try {
                $sentence = $connection->prepare("SELECT * FROM posts WHERE visible = '1' ORDER BY last_update_date DESC;");
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }
        return $postArray;
    }

    public static function get_all_visible_posts_by_last_update_date_desc_paginated($connection, $init, $limit) {
        $postArray = null;
        if (isset($connection)) {
            try {
                $sql = "SELECT * FROM posts WHERE visible = '1' ORDER BY last_update_date DESC LIMIT :init, :limit;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":init", $init, PDO::PARAM_INT);
                $sentence->bindParam(":limit", $limit, PDO::PARAM_INT);
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }
        return $postArray;
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $postArray;
    }
    
    public static function get_visible_posts_by_author_id($connection, $authorId, $init, $limit) {
        $postArray = null;

        if (isset($connection)) {
            try {                
                $sql = "SELECT * FROM posts WHERE author_id = :authorId AND visible = 1 ORDER BY last_update_date DESC LIMIT :init, :limit;";
                $sentence = $connection->prepare($sql);
                $sentence->bindParam(":authorId", $authorId, PDO::PARAM_INT);
                $sentence->bindParam(":init", $init, PDO::PARAM_INT);
                $sentence->bindParam(":limit", $limit, PDO::PARAM_INT);
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $ex->getMessage(), 500, $ex);
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
                throw new AppException("Database error: " . $ex->getMessage(), 500, $ex);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
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
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        } else {
            return false; // 0
        }
    }
    
    /*public static function search_post($connection, $search, $init, $limit) {
        $postArray = null;
        
        if (isset($connection)) {
            try {                
                $searchSql = "SELECT * FROM posts WHERE visible = '1' AND ("
                        . " title LIKE :search"
                        . " OR introduction LIKE :search"
                        . " OR content LIKE :search"
                        . " OR creation_date LIKE :search"
                        . ") LIMIT " . $init . ", " . $limit . ";";
                
                $sentence = $connection->prepare($searchSql);
                
                $searchTerm = '%' . $search . '%'; -- '%search%'
                $sentence->bindParam(":search", $searchTerm, PDO::PARAM_STR);

                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $postArray;
    }*/
    
    public static function search_post($connection, $search, $init, $limit) {
        $postArray = null;
        
        if (isset($connection)) {
            try {
                
                $searchSql = "SELECT * FROM posts WHERE visible = '1' AND ("
                        . " title LIKE :search"
                        . " OR introduction LIKE :search"
                        . " OR content LIKE :search"
                        . " OR creation_date LIKE :search"
                        . ") LIMIT :init, :limit;";

                $sentence = $connection->prepare($searchSql);
                
                //$searchTerm = '%' . $search . '%'; -- '%search%'
                //$sentence->bindParam(":search", $searchTerm, PDO::PARAM_STR);
                
                $sentence->bindValue(":search", '%' . $search . '%', PDO::PARAM_STR);
                $sentence->bindParam(":init", $init, PDO::PARAM_INT);
                $sentence->bindParam(":limit", $limit, PDO::PARAM_INT);

                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $postArray;
    }
    
    public static function advanced_search_post($connection, $title='', $author='', $introduction='', $content='', $date='', $init, $limit) {
        $postArray = null;

        if (isset($connection)) {
            try {
                
                $searchSql = "SELECT * FROM posts WHERE visible = '1'";
                $params = []; // Diccionario de parametros clave-valor
                
                if (!empty($title)){
                    $searchSql .= " AND title LIKE :title";
                    $params[':title'] = $title;
                }
                
                if (!empty($author)){
                    $searchSql .= " AND author_id IN (SELECT id FROM users WHERE user_name LIKE :author)";
                    $params[':author'] = '%' . $author . '%';
                }
                
                if (!empty($introduction)){
                    $searchSql .= " AND introduction LIKE :introduction";
                    $params[':introduction'] = $introduction;
                }
                
                if (!empty($content)){
                    $searchSql .= " AND content LIKE :content";
                    $params[':content'] = $content;
                }
                
                if (!empty($date)){
                    $searchSql .= " AND creation_date LIKE :date";
                    $params[':date'] = $date;
                }
                
                $searchSql .= " LIMIT :init, :limit;";
                
                $sentence = $connection->prepare($searchSql);
                
                $sentence->bindParam(":init", $init, PDO::PARAM_INT);
                $sentence->bindParam(":limit", $limit, PDO::PARAM_INT);
                
                // parte clave del proceso para vincular dinámicamente los valores 
                // a los parámetros en una sentencia SQL preparada usando PDO en PHP.
                foreach ($params as $key => $value) {
                    //$sentence->bindParam($key, $value);
                    $sentence->bindValue($key, '%' . $value . '%');
                }
                
                $sentence->execute();
                $postArray = self::fetch_posts($sentence);
            } catch (PDOException $e) {
                throw new AppException("Database error: " . $e->getMessage(), 500, $e);
            }
        }

        return $postArray;
    }
}
