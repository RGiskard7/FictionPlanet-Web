<?php
require_once CORE_PATH . 'Connection.php';
require_once CORE_PATH . 'Redirection.php';
require_once CORE_PATH . 'Utilities.php';

require_once CORE_PATH . 'Controller.php';
require_once CORE_PATH . 'View.php';

require_once LIBS_PATH . 'Session.php';

require_once CONTROLLERS_PATH . 'Fault.php';

class App {
    
    public function __construct() {
        $url = !empty($_GET['url']) ? $_GET['url'] : 'home/home';
        $url = rtrim($url, '/'); // Elimina barra inclinada del lado derecho
	$arrUrl = explode('/', $url);
	$controller = $arrUrl[0]; // Metodo con el mismo nombre que el controlador
	$method = $arrUrl[0];
	$params = '';

	if(!empty($arrUrl[1])) {
            $method = $arrUrl[1];
	}

	if(!empty($arrUrl[2])) {
            for ($i = 2; $i < count($arrUrl); $i++) {
                $params .=  $arrUrl[$i].',';
            }
            $params = trim($params,','); // Elimina la coma de ambos lados
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

