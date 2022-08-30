<?php
require_once MODELS_PATH . "PostModel.php";
require_once DAO_PATH . "PostDAO.php";
require_once LIBS_PATH . "validators/NewPostsValidator.php";

class UpdatedPostsValidator extends NewPostsValidator {

    private $oldTitle;
    
    public function __construct($oldTitle, $title, $introduction, $content, $visible, $connection) {
        $this->oldTitle = $oldTitle;
        
        parent::__construct($title, $introduction, $content, $visible, $connection);
    }
    
    protected function validate_title($connection, $title) {
        if ($title !== $this->oldTitle) {
            return parent::validate_title($connection, $title);
        }
        
        $this->title = $title;
 
        return "";
    }  
}
?>

