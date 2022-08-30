<?php
require_once DAO_PATH . "PostDAO.php";

class NewPostsValidator {

    protected $title;
    protected $introduction;
    protected $content;
    protected $visible;
    
    protected $error_title;
    protected $error_introduction;
    protected $error_content;
    
    protected $warning_start;
    protected $warning_end;
    
    public function __construct($title, $introduction, $content, $visible, $connection) {
        $this->title = "";
        $this->introduction = "";
        $this->content = "";
        $this->visible = $visible;
        
        $this->error_title = $this->validate_title($connection, $title);
        $this->error_introduction = $this->validate_introduction($introduction);
        $this->error_content = $this->validate_content($content);
        
        $this->warning_start = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>"
                . "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
        $this->warning_end = "</div>";
    }
    
    protected function is_variable_started($variable) {
        if (isset($variable) && !empty($variable)) {
            return true;
        } else {
            return false;
        }
    }
    
    protected function validate_title($connection, $title) {
        if (!$this->is_variable_started($title)) {
            return "El post debe tener un título.";
        } else {
            $this->title = $title;
        }

        if (strlen($title) < 5) {
            return "El título debe tener más de 5 caracteres.";
        }

        if (strlen($title) > 255) {
            return "El titulo no puede sobrepasar los 255 caracteres.";
        }

        if (PostDAO::is_title_exist($connection, $title)) {
            return "Este titulo ya está en uso en otro post. Prueba otro diferente.";
        }

        return "";
    }
    
    protected function validate_introduction($introduction) {
        if (!$this->is_variable_started($introduction)) {
            return "El post debe tener una introducción.";
        } else {
            $this->introduction = $introduction;
        }

        if (strlen($introduction) < 20) {
            return "La introducción debe tener más de 20 caracteres.";
        }

        if (strlen($introduction) > 2000) {
            return "El titulo no puede sobrepasar los 2000 caracteres.";
        }

        return "";
    }
    
    protected function validate_content($content) {
        if (!$this->is_variable_started($content)) {
            return "El post debe tener algún contenido.";
        } else {
            $this->content = $content;
        }

        if (strlen($content) < 50) {
            return "EL contenido debe tener al menos 20 caracteres.";
        }

        return "";
    }
    
    public function get_title() {
        return $this->title;
    }
    
    public function get_introduction() {
        return $this->introduction;
    }
    
    public function get_content() {
        return $this->content;
    }
    
    public function get_error_title() {
        return $this->error_title;
    }
    
    public function get_error_introduction() {
        return $this->error_introduction;
    }
    
    public function get_error_content() {
        return $this->error_content;
    }
    
    public function show_title() {
        if ($this->title !== "") {
            echo 'value="' . $this->title . '"';
        }
    }
    
    public function show_error_title() {
        if ($this->error_title !== "") {
            echo $this->warning_start . $this->error_title . $this->warning_end;
        }
    }
    
    public function show_introduction() {
        if ($this->introduction !== "") {
            echo $this->introduction;
        }
    }
    
    public function show_error_introduction() {
        if ($this->error_introduction !== "") {
            echo $this->warning_start . $this->error_introduction . $this->warning_end;
        }
    }
    
    public function show_content() {
        if ($this->content !== "") {
            echo $this->content;
        }
    }
    
    public function show_error_content() {
        if ($this->error_content !== "") {
            echo $this->warning_start . $this->error_content . $this->warning_end;
        }
    }
    
    public function show_is_visible() {
        echo 'value="' . (($this->visible) ? 1 : 0) . '" ' . (($this->visible) ? 'checked' : '');
    }
    
    public function valid_form() {
        if ($this->error_title === "" && $this->error_introduction === "" && $this->error_content === "") {
            return true;
        } else {
            return false;
        }
    }    
}
?>

