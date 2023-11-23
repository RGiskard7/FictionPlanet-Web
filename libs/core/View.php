<?php
class View {
    
    public function render($controller, $view, $data="") {
        $controller = get_class($controller);
        $controller = strtolower($controller);
        
        if($controller == "home") { // home es index.php, tiene que estar en la raiz
            $view = VIEWS_PATH . $view . ".php";
        }else{
            // La carpeta donde estan las vistas correspondientes 
            // tiene el nombre del controlador en minusculas
            $view = VIEWS_PATH . $controller . "/" . $view . ".php";
        }
        
        require_once $view;
    }
    
}