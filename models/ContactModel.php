<?php

class ContactModel {
    private $id;
    private $user_id;
    private $contact_id;
    private $creation_date;
    
    public function __construct($id, $user_id, $contact_id, $creation_date) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->contact_id = $contact_id;
        $this->creation_date = $creation_date;
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_user_id() {
        return $this->user_id;
    }
    
    public function set_user_id($user_id) {
        $this->user_id = $user_id;
    }
    
    public function get_contact_id() {
        return $this->contact_id;
    }
    
    public function set_contact_id($contact_id) {
        $this->contact_id = $this->contact_id;
    }
    
    public function get_creation_date() {
        return $this->creation_date;
    }
}

?>

