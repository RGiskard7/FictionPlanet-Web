<?php

class PostModel {

    private $id;
    private $url;
    private $author_id;
    private $title;
    private $introduction;
    private $content;
    private $date_creation;
    private $date_last_update;
    private $visible;

    public function __construct($id, $url, $author_id, $title, $introduction, $content, $date_creation, $date_last_update, $visible) {
        $this->id = $id;
        $this->url = $url;
        $this->author_id = $author_id;
        $this->title = $title;
        $this->introduction = $introduction;
        $this->content = $content;
        $this->date_creation = $date_creation;
        $this->date_last_update = $date_last_update;
        $this->visible = $visible;
    }

    public function get_id() {
        return $this->id;
    }

    public function set_id($id) {
        $this->id = $id;
    }
    
    public function get_url() {
        return $this->url;
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

    public function get_introduction() {
        return $this->introduction;
    }

    public function set_introduction($introduction) {
        $this->introduction = $introduction;
    }

    public function get_content() {
        return $this->content;
    }

    public function set_content($content) {
        $this->content = $content;
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

?>