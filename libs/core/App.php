<?php
require_once CORE_PATH . 'Connection.php';
require_once CORE_PATH . 'Redirection.php';
require_once CORE_PATH . 'Utilities.php';

require_once CORE_PATH . 'Controller.php';
require_once CORE_PATH . 'View.php';

require_once LIBS_PATH . 'Session.php';

require_once CONTROLLERS_PATH . 'Fault.php';

/*
 * La función App analiza la URL solicitada, extrae el controlador y el método de la URL, 
 * y luego invoca el método correspondiente en el controlador. También maneja la lógica 
 * de pasar parámetros a los métodos si están presentes en la URL.
 */

class App {
    
    public function __construct() {
        $url = !empty($_GET['url']) ? $_GET['url'] : 'home/home';
        $url = rtrim($url, '/'); // Elimina barra inclinada del lado derecho
	$arrUrl = explode('/', $url); // Se obtiene cada componente de la URL separada por / y se almacena en un array
	$controller = $arrUrl[0]; // Se obtiene el nombre del controlador
	$method = $arrUrl[0]; // De serie se pone el metodo con el mismo nombre que el controlador
	$params = '';

	if(!empty($arrUrl[1])) { // Si hay un segundo elemento del array, hay un metodo con nombre diferente al nombre del controlador
            $method = $arrUrl[1];
	}

	if(!empty($arrUrl[2])) { // Si hay un tercer elemento, hay al menos un parametro para el metodo del controlador
            for ($i = 2; $i < count($arrUrl); $i++) { // Se aniaden todos los parametros que haya, separados por una coma, a un string
                $params .=  $arrUrl[$i].',';
            }
            $params = trim($params,','); // Elimina la coma de ambos lados (principio y final, por si acaso)
	}
        
        $controller = ucwords($controller); // Convertir en mayuscula el primer caracter
	$controllerFile = CONTROLLERS_PATH . $controller . '.php';
	if(file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controller();
            
            if(method_exists($controller, $method)) {
                $controller->{$method}($params);
            } else {
                $fault = new Fault();
                $fault->error_404();
            }
	} else {
            $fault = new Fault();
            $fault->error_404();
	}
    }
}
?>