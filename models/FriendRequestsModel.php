<?php

class FriendRequestsModel {
    private $id;
    private $from_user_id;
    private $to_user_id;
    private $creation_date;
    private $last_update_date;
    private $status;
    private $accepted;
    
    public function __construct($id, $from_user_id, $to_user_id, $creation_date, $last_update_date, $status, $accepted) {
        $this->id = $id;
        $this->from_user_id = $from_user_id;
        $this->to_user_id = $to_user_id;
        $this->creation_date = $creation_date;
        $this->last_update_date = $last_update_date;
        $this->status = $status;
        $this->accepted = $accepted;
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_from_user_id() {
        return $this->from_user_id;
    }
    
    public function get_to_user_id() {
        return $this->to_user_id;
    }
    
    public function get_creation_date() {
        return $this->creation_date;
    }
    
    public function get_last_update_date() {
        return $this->last_update_date;
    }
    
    public function set_last_update_date($last_update_date) {
        $this->last_update_date = $last_update_date;
    }
    
    public function get_status() {
        return $this->status;
    }
    
    public function set_status($status) {
        $this->status = $status;
    }
    
    public function get_accepted() {
        return $this->accepted;
    }
    
    public function set_accepted($accepted) {
        $this->accepted = $accepted;
    }
}
