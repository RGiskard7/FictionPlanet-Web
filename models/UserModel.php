<?php

class UserModel {

    private $id;
    private $user_name;
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $address;
    private $country;
    private $phone_number;
    private $role;
    private $active;
    private $reg_date;
    private $last_update_date;
    private $last_access_date;

    public function __construct($id, $user_name, $first_name, $last_name, $email, $password, $address, $country, $phone_number, $role, 
            $active, $reg_date, $last_update_date, $last_access_date) {
        $this->id = $id;
        $this->user_name = $user_name;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->address = $address;
        $this->country = $country;
        $this->phone_number = $phone_number;
        $this->role = $role;
        $this->active = $active;
        $this->reg_date = $reg_date;
        $this->last_update_date = $last_update_date;
        $this->last_access_date = $last_access_date;
    }

    public function get_id() {
        return $this->id;
    }

    private function set_id($id) {
        $this->id = $id;
    }

    public function get_user_name() {
        return $this->user_name;
    }

    public function set_user_name($user_name) {
        $this->user_name = $user_name;
    }

    public function get_first_name() {
        return $this->first_name;
    }

    public function set_first_name($first_name) {
        $this->first_name = $first_name;
    }

    public function get_last_name() {
        return $this->last_name;
    }

    public function set_last_name($last_name) {
        $this->last_name = $last_name;
    }

    public function get_email() {
        return $this->email;
    }

    public function set_email($email) {
        $this->email = $email;
    }

    public function get_password() {
        return $this->password;
    }

    public function set_password($password) {
        $this->password = $password;
    }

    public function get_address() {
        return $this->address;
    }

    public function set_address($address) {
        $this->address = $address;
    }

    public function get_country() {
        return $this->country;
    }

    public function set_country($country) {
        $this->country = $country;
    }

    public function get_phone_number() {
        return $this->phone_number;
    }

    public function set_phone_number($phone_number) {
        $this->phone_number = $phone_number;
    }

    public function get_role() {
        return $this->role;
    }

    public function set_role($role) {
        $this->role = $role;
    }

    public function is_active() {
        return $this->active;
    }

    public function set_active($active) {
        $this->active = $active;
    }

    public function get_reg_date() {
        return $this->reg_date;
    }

    public function set_reg_date($reg_date) {
        $this->reg_date = $reg_date;
    }

    public function get_last_update_date() {
        return $this->last_update_date;
    }

    public function set_last_update_date($last_update_date) {
        $this->last_update_date = $last_update_date;
    }
    
    public function get_last_access_date() {
        return $this->last_access_date;
    }
    
    public function set_last_access_date($last_access_date) {
        $this->last_access_date = $last_access_date;
    }
}

?>