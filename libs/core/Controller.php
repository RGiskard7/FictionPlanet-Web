<?php 
class Controller {
    
    public function __construct() {
        $this->view = new View();
        session_start(); // Siempre se tiene que llamar a session_start para poder usar variables de sesion (eliminar)
    }
    
}