<?php

class ImageGalleryModel {
    
    private $id;
    private $author_id;
    private $title;
    private $description;
    private $url;
    private $path;
    private $date_creation;
    private $date_last_update;
    private $visible;
    
    public function __construct($id, $author_id, $title, $description, $url, $path, $date_creation,
            $date_last_update, $visible) {
        $this->id = $id;
        $this->author_id = $author_id;
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->path = $path;
        $this->date_creation = $date_creation;
        $this->date_last_update = $date_last_update;
        $this->visible = $visible;       
    }
    
    public function get_id() {
        return $this->id;
    }

    private function set_id($id) {
        $this->id = $id;
    }
    
    public function get_author_id() {
        return $this->author_id;
    }
    
    public function get_title() {
        return $this->title;
    }

    public function set_title($title) {
        $this->title = $title;
    }
    
    public function get_description() {
        return $this->description;
    }
    
    public function set_description($description) {
        $this->description = $description;
    }
    
    public function get_url() {
        return $this->url;
    }
    
    public function set_url($url) {
        $this->url = $url;
    }
    
    public function get_path() {
        return $this->path;
    }
    
    public function set_path($path) {
        $this->path = $path;
    }
    
    public function get_date_creation() {
        return $this->date_creation;
    }

    public function set_date_creation($date) {
        $this->date_creation = $date;
    }

    public function get_date_last_update() {
        return $this->date_last_update;
    }

    public function set_date_last_update($date) {
        $this->date_last_update = $date;
    }

    public function is_visible() {
        return $this->visible;
    }

    public function set_visible($visible) {
        $this->visible = $visible;
    }
}
