<?php
require_once realpath(dirname(__FILE__)) . "/../config.inc.php";

ini_set('display_errors', '0');

require_once CORE_PATH . "Connection.php";
require_once CORE_PATH . "Utilities.php";

require_once LIBS_PATH . "Session.php";

require_once MODELS_PATH . "ImageGalleryModel.php";
require_once DAO_PATH . "ImageGalleryDAO.php";

if (!Session::is_started() || !($_SESSION['permissions'][MDL_IMAGES]['w'] ?? 0)) {
    http_response_code(403);
    exit;
}

if (!Session::verify_csrf()) {
    http_response_code(403);
    exit;
}

if (isset($_POST["submitUploadNewImage"])) {
    if ($_POST["imageTitle"] !== "") {
        $file = $_FILES['imageFile']['name'];
        $file_image = '';
        if($_FILES['imageFile']['name'] != "") {
            $infoExt = getimagesize($_FILES['imageFile']['tmp_name']);
            if(strtolower($infoExt['mime']) == 'image/jpeg' || strtolower($infoExt['mime']) == 'image/jpg' 
                    || strtolower($infoExt['mime']) == 'image/png'){
                
                define('DIR_GALERIA_IMG', ROOT_DIRECTORY . UPLOAD_IMG_GALLERY_DIR);
                define('DIR_DESCARGAS', DIR_GALERIA_IMG . $_SESSION["idUser"]);
            
                if(!file_exists(DIR_DESCARGAS)) @mkdir(DIR_DESCARGAS);
                
                // Extraemos el nombre y la extensión del nombre completo del fichero
                list($base, $extension) = explode('.', basename($_FILES['imageFile']['name']));
                $newName = implode('_', ["image", $base, $_SESSION["idUser"], time()]);
                        
                // Creamos la ruta de destino
                $path = DIR_DESCARGAS . DIRECTORY_SEPARATOR . utf8_decode($newName) . '.' . $extension;
                $url = UPLOAD_IMG_GALLERY_URL . $_SESSION["idUser"] . DIRECTORY_SEPARATOR . utf8_decode($newName) . '.' . $extension;
                
                if (move_uploaded_file($_FILES['imageFile']['tmp_name'], $path)) {
                    Connection::open_connection();
                    $imageObject = new ImageGalleryModel(0, $_SESSION["idUser"], $_POST["imageTitle"], null, $url, $path, 0, 0, 1);
                    $insert = ImageGalleryDAO::insert_image(Connection::get_connection(), $imageObject);
                    Connection::close_connection();
                    
                    if($insert){ 
                        echo 1;
                        exit;
                    }
                } 
                echo 0; 
            }else{
                echo 2;
            }
        } else {
            echo 3;
        }
    } else {
        echo 4;
    }
    exit;
}
