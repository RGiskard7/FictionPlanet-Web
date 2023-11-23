<?php
require_once realpath(dirname(__FILE__)) . "/../../config.inc.php";

class Utilities {
    
    /* Copia el contenido que haya en un directorio origen (sourcerDir) a un 
    directorio destino (targetDir) */
    public static function copy_all_contents_of_directory($sourceDir, $targetDir) {
        if(!file_exists($sourceDir)) return false; /* Si el directorio origen no existe, se devuelve false */
        if(!file_exists($targetDir)) { /* Si el directorio destino no existe, se intenta crear */
            mkdir($targetDir, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
        }

        $dir = opendir($sourceDir) or die("No se puede abrir el directorio"); /* Se intenta abrir directorio origen */

        while (($file = readdir($dir)) !== false){
            if (($file != '.') && ($file != '..')) {
                copy($sourceDir . '/' . $file, $targetDir . '/' . $file);
            }
        }
        
        closedir($dir); 

        return true;
    }
    
    /* Copia un fichero concreto de un directorio origen (sourceDir) a un directorio 
    Destino (targetDir). En caso de que el directorio origen no exista, o que si no existe
    el directorio destino, este no se pueda crear, o que no se encuentra el fichero que se
    quiera copiar en el directorio origen, se devuelve false. En caso contrario, se develve
    true. */
    public static function copy_file_to_directory($sourceDir, $targetDir, $targetFile) {
        if(!file_exists($sourceDir)) return false;
        if(!file_exists($targetDir)) {
            mkdir($targetDir, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
        }
        
        $dir = opendir($sourceDir) or die("No se puede abrir el directorio");
        
        while (($file = readdir($dir)) !== false){
            if (($file != '.') && ($file != '..')) {
                if ($file == $targetFile) { /* Se comprueba que el fichero que se desea copiar se encuentra en el directorio origen */
                    copy($sourceDir . '/' . $file, $targetDir . '/' . $file);
                    closedir($dir);
                    return true;
                } 
            }
        }
        
        closedir($dir);
        
        return false;
    }
    
    /* Comprueba si un directorio esta vacio. Si lo esta, devuelve true, En caso
    contrario, devuelve false */
    public static function directory_is_empty($directory) {
        if (file_exists($directory)) {
            $dir = @scandir($directory);
            if (count($dir) <= 2) return true; // 2 por . y ..
        }
        return false;
    }
    
    /* Elimina un directorio, y todo su contenido */
    public static function delete_directory($directory) {
        if (!file_exists($directory)) return false;
        if (!$fileList = @opendir($directory)) return false; //EL @ es para bloquear los warning y mensajes de error
        while (false !== ($currentFile = readdir($fileList))) {
            if ($currentFile != '.' && $currentFile != '..') {
                if (!@unlink($directory . '/' . $currentFile)) 
                    deleteDirectory($directory . '/' . $currentFile); 
            }       
        }
        
        closedir($fileList);
        
        @rmdir($directory);
        
        return true;
    }
    
    /* Devuelve un listado (array) con todo el contenido de un directorio */
    public static function get_all_contents_of_directory($directory) {
        $files = null;
        if (file_exists($directory)) {
            $files = scandir($directory);
            unset($files[0], $files[1]); // Se ponen a null el indice 0 y 1
            $files = array_slice($files, 0); // Se eliminan los nulls
        }
        return $files;
    }
    
    /* Elimina un fichero concreto de un directorio especifico */
    public static function delete_file_of_directory($directory, $file) {
        if (file_exists($directory)) {
            if (!$fileList = @opendir($directory)) return false;
            while (false !== ($currentFile = readdir($fileList))) {
                if ($currentFile != '.' && $currentFile != '..') {
                    if ($currentFile == $file) {
                        @unlink($directory . '/' . $currentFile);
                        closedir($fileList);
                        return true;
                    }
                }       
            }
            closedir($fileList);
        }
        return false;
    }
    
    public static function summarize_text($text, $maxChar) {
        $result = "";
        
        if (strlen($text) >= $maxChar) {
            $result = mb_substr($text, 0, $maxChar + 1, "UTF-8") . "...";
        } else {
            $result = $text;
        } 

        return $result; 
    }
    
    public static function friendly_url_generator($string) {
        $url = htmlentities($string, ENT_QUOTES, 'UTF-8'); // Convertir caracteres en equivalentes Html
        $url = preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $url); // Reemplazar caracteres
        $url = html_entity_decode($url, ENT_QUOTES, 'UTF-8'); // Convertir simbolos html en caracteres
        $url = preg_replace('~[^0-9a-z]+~i', '-', $url); // Eliminar caracteres que no sean letras o numeros
        $url = trim($url, '-'); // Eliminar guiones del comienzo y final
        
        return strtolower($url); // Convertir todo a minusculas
    }
    
}