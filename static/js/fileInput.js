$(document).ready(function () {
    // Tipos de archivos admitidos por su extensión
    var tipos = ['docx', 'xlsx', 'pptx', 'pdf', 'jpg', 'png'];

    // Inicializamos el plugin fileinput:
    //  traducción al español
    //  script para procesar las peticiones de subida
    //  desactivar la subida asíncrona
    //  máximo de ficheros que se pueden seleccionar	
    //  Tamaño máximo en Kb de los ficheros que se pueden seleccionar
    //  no mostrar los errores de tipo de archivo (cuando el usuario selecciona un archivo no permitido)
    //  tipos de archivos permitidos por su extensión (array definido al principio del script)
    $('#uploadFile').fileinput({
        theme: "fa",
        language: 'es',
        uploadUrl: '/posts/upload_attachment',
        uploadAsync: false, /* Con false se realizará una sola llamada al servidor enviando toda la información en un array. Recomendable en Ajax */
        maxFileCount: 15,
        maxFileSize: 5120, //KB
        showUpload: true,
        showRemove: true,
        removeFromPreviewOnError: true,
        allowedFileExtensions: tipos,
        msgFilesTooMany: '¡La cantidad de archivos seleccionados para cargar ({n}) excede el valor máximo permitido {m}!',
        dropZoneEnabled: true, // Ya sea para mostrar el área de arrastre
        uploadExtraData: function() {
            var id = $('#uploadFile').attr('data-userid');
            var data = {idUser:"temp-" + id}; //Pasar atributos post a uploadurl
            return data;
        }
    });
    // Evento filecleared del plugin que se ejecuta cuando pulsamos el botón 'Quitar'
    // Vaciamos y ocultamos el div de alerta
    $('#uploadFile').on('filecleared', function(event) {
        /*$('div.alert').empty();
        $('div.alert').hide();*/
    });
    // Evento filebatchuploadsuccess del plugin que se ejecuta cuando se han enviado todos los archivos al servidor
    // Mostramos un resumen del proceso realizado
    // Carpeta donde se han almacenado y total de archivos movidos
    // Nombre y tamaño de cada archivo procesado
    // Totales de archivos por tipo
    $('#uploadFile').on('filebatchuploadsuccess', function(event, data, previewId, index) {
    });
    
    // Cuando un lote de ficheros es subido correctamente
    $('#uploadFile').on('filebatchuploadcomplete', function(event, preview, config, tags, extraData) { 
        $('#syncAttachedFilesBtn').click();
    });
    
    // Cuando un fichero individual es subido
    $('#uploadFile').on('fileuploaded', function(event, data, previewId, index) { 
        $('#syncAttachedFilesBtn').click();
    });
    

    // Ocultamos el div de alerta donde se muestra un resumen del proceso
    // $('div.alert').hide();
});