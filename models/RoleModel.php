<?php

class RoleModel {
    
    private $id;
    private $name;
    private $description;
    private $sp_name;
    
    public function __construct($id, $name, $description, $sp_name) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->sp_name = $sp_name;
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function set_id($id) {
        $this->id = $id;
    }
    
    public function get_name() {
        return $this->name;
    }
    
    public function set_name($name) {
        $this->name = $name;
    }
    
    public function get_description() {
        return $this->description;
    }
    
    public function set_description($description) {
        $this->description = $description;
    }
    
    public function get_sp_name() {
        return $this->sp_name;
    }
    
    public function set_sp_name($sp_name) {
        $this->sp_name = $sp_name;
    }
}

?>

