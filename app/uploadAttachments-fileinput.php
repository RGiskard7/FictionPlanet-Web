<?php
require_once realpath(dirname(__FILE__)) . "/../config.inc.php";

$paths= array();
$processStatus = NULL;
$directory = NULL;

// DEFINICIÓN DE LAS VARIABLES DE TRABAJO (CONSTANTES, ARRAYS Y VARIABLES)
// ************************************************************************

// Definimos la constante con el directorio de destino de las descargas
define('DIR_DESCARGAS', ROOT_DIRECTORY . UPLOAD_POSTS_DIR . $_POST["idUser"]);
// Obtenemos el array de ficheros enviados
$ficheros = $_FILES['uploadFile'];
// Establecemos el indicador de proceso correcto (simplemente no indicando nada)
$processStatus = NULL;
// Paths para almacenar
$paths = array();
// Obtenemos los nombres de los ficheros
$nombres_ficheros = $ficheros['name'];

// LÍNEAS ENCARGADAS DE REALIZAR EL PROCESO DE UPLOAD POR CADA FICHERO RECIBIDO
// ****************************************************************************

// Si no existe la carpeta de destino la creamos
if(!file_exists(DIR_DESCARGAS)) @mkdir(DIR_DESCARGAS);
// Sólo en el caso de que exista esta carpeta realizaremos el proceso
if(file_exists(DIR_DESCARGAS)) {
    // Recorremos el array de nombres para realizar proceso de upload
    for($i=0; $i < count($_FILES['uploadFile']['name']); $i++){
        // Extraemos el nombre y la extensión del nombre completo del fichero
        $nombre_extension = explode('.', basename($_FILES['uploadFile']['name'][$i]));
        // Obtenemos la extensión
        $extension = array_pop($nombre_extension);
        // Obtenemos el nombre
        $nombre = array_pop($nombre_extension);
        // Creamos la ruta de destino
        $archivo_destino = DIR_DESCARGAS . DIRECTORY_SEPARATOR . utf8_decode($nombre) . '.' . $extension;
        // Mover el archivo de la carpeta temporal a la nueva ubicación
        if(move_uploaded_file($_FILES['uploadFile']['tmp_name'][$i], $archivo_destino)) {
                // Activamos el indicador de proceso correcto
                $processStatus = true;
                // Almacenamos el nombre del archivo de destino
                $paths[] = $archivo_destino;
        } else {
                // Activamos el indicador de proceso erroneo		
                $processStatus = false;
                // Rompemos el bucle para que no continue procesando ficheros
                break;
        }
    }
}

$reply = array();
if ($processStatus) {
    $reply = ['dirupload' => basename(DIR_DESCARGAS), 'total'=>count($paths)]; 
} elseif (!$processStatus) {
    $reply = ['error'=>'Error al subir los archivos. Póngase en contacto con el administrador del sistema'];
    foreach ($paths as $file) {
        unlink($file);
    }
} else {
    $reply = ['error'=>'No se ha procesado ficheros.'];
}

// RESPUESTA DEVUELTA POR EL SCRIPT EN FORMATO JSON
// **********************************************************************
echo json_encode($reply);