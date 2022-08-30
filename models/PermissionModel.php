<?php

class PermissionModel {
    
    private $id;
    private $role_id;
    private $module_id;
    private $r;
    private $w;
    private $u;
    private $d;
    
    public function __construct($id, $role_id, $module_id, $r, $w, $u, $d) {
        $this->id = $id;
        $this->role_id = $role_id;
        $this->module_id = $module_id;
        $this->r = $r;
        $this->w = $w;
        $this->u = $u;
        $this->d = $d; 
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_role_id() {
        return $this->role_id;
    }
    
    public function get_module_id() {
        return $this->module_id;
    }
    
    public function get_r() {
        return $this->r;
    }
    
    public function get_w() {
        return $this->w;
    }
    
    public function get_u() {
        return $this->u;
    }
    
    public function get_d() {
        return $this->d;
    } 
}

?>
