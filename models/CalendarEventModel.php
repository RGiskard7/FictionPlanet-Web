<?php

class CalendarEventModel {
    
    private $id;
    private $start;
    private $end;
    private $title;
    private $color;
    
    public function __construct($id, $start, $end, $title, $color) {
        $this->id = $id;
        $this->start = $start;
        $this->end = $end;
        $this->title = $title;
        $this->color = $color;
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_start() {
        return $this->start;
    }
    
    public function get_end() {
        return $this->end;
    }
    
    public function get_title() {
        return $this->title;
    }
    
    public function get_color() {
        return $this->color;
    }
}
