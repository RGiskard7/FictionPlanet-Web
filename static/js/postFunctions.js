$(document).ready(function() {
    $('#postTable').DataTable({
        "language": {
            "emptyTable": "No hay datos disponibles en la tabla.",
            "lengthMenu": "Mostrar _MENU_ publicaciones",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando publicaciones del _START_ al _END_ de un total de _TOTAL_ publicaciones",
            "infoEmpty": "Mostrando publicaciones del 0 al 0 de un total de 0 publicaciones",
            "infoFiltered": "(filtrado de un total de _MAX_ publicaciones)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
            "loadingRecords": "Cargando...",
            "aria": {
                "sortAscending": "Ordenación ascendente",
                "sortDescending": "Ordenación descendente"
            }
        },
        "ajax": {
            "url": BASE_URL + "/posts/posts_data_table_load",
            "dataSrc": "",
            "type": "POST",
            "dataType": "json",
            "data": {
                "action": "postsDataTableLoad"
            }
        },
        "columns": [
            {"data": "actions", 
                'orderable': false, 
                'searchable': false, 
                "width": "2%"},
            {"data": "index", "width": "2%"},
            {"data": "id", "width": "2%"},
            {"data": "status", "width": "2%"},
            {"data": "title", "width": "15%"},
            {"data": "creation_date", "width": "10%"},
            {"data": "date_last_update", "width": "10%"},
            {"data": "author", 
                "width": "10%",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<a href="users/profile/' + data + '">' + data + '</a>'; // Revisar
                    }
                    return data;
                 }
            }
        ],
        
        "processing": true,
        "dom": 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='fa fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary gmd-1 mr-2 mb-2 rounded"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fa fa-file-excel-o'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success gmd-1 mr-2 mb-2 rounded"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fa fa-file-pdf-o'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger gmd-1 mr-2 mb-2 rounded"
            },{
                "extend": "colvis",
                "text":"Columnas visibles",
                "className": "btn btn-warning gmd-1 mb-2 rounded"
            },  
        ],
        
        "scroll": true,
        "responsive": true
    });
    
    $('#postTableProfile').DataTable({
        "language": {
            "emptyTable": "No hay datos disponibles en la tabla.",
            "lengthMenu": "Mostrar _MENU_ publicaciones",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando publicaciones del _START_ al _END_ de un total de _TOTAL_ publicaciones",
            "infoEmpty": "Mostrando publicaciones del 0 al 0 de un total de 0 publicaciones",
            "infoFiltered": "(filtrado de un total de _MAX_ publicaciones)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
            "loadingRecords": "Cargando...",
            "aria": {
                "sortAscending": "Ordenación ascendente",
                "sortDescending": "Ordenación descendente"
            }
        },
        "ajax": {
            "url": BASE_URL + "/posts/posts_data_table_load/true",
            "dataSrc": "",
            "type": "POST",
            "dataType": "json",
            "data": {
                "action": "postsDataTableLoad"
            }
        },
        "columns": [
            {"data": "actions", 
                'orderable': false, 
                'searchable': false, 
                "width": "2%"},
            {"data": "index", "width": "2%"},
            {"data": "id", "width": "2%"},
            {"data": "status", "width": "2%"},
            {"data": "title", "width": "15%"},
            {"data": "creation_date", "width": "10%"},
            {"data": "date_last_update", "width": "10%"},
        ],
        
        "processing": true,
        "dom": 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='fa fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary gmd-1 mr-2 mb-2 rounded"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fa fa-file-excel-o'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success gmd-1 mr-2 mb-2 rounded"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fa fa-file-pdf-o'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger gmd-1 mr-2 mb-2 rounded"
            },{
                "extend": "colvis",
                "text":"Columnas visibles",
                "className": "btn btn-warning gmd-1 mb-2 rounded"
            },  
        ],
        
        "scroll": true,
        "responsive": true,
        "bAutoWidth": false,
    });
    
    $(document).on('click', '.createPostBtn', function() {
        Cookies.set("sourceURL", location.href/*, {expires: 1}*/);
    });
    
    $(document).on('click', '#updatePostBtn', function() {
        Cookies.set("sourceURL", location.href/*, {expires: 1}*/);
    });
    
    $(document).on('click', '#removePostBtn', function() {
        var idPost = $(this).attr('data-idpost');
        swal({
            title: '¿Seguro que quieres eliminar la publicación?',
            text: 'Si aceptas, se eliminará la publicación para siempre.',
            icon: 'warning',
            buttons: {
                ok: 'Eliminar',
                cancel: 'Cancelar'
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BASE_URL + 'posts/delete',
                    method:'POST',
                    data:{action: 'deletePost', idPost: idPost},
                    success:function(response){
                        if (response) {
                            swal('Correcto', 'Se ha eliminado la publicación correctamente.', 'success');
                            $('#postTable').DataTable().ajax.reload();
                        } else {
                            swal('Error', 'Se ha producido un error en la petición a la base de datos.', 'error');
                        }
                    },
                    error:function(jqXHR, textStatus, errorThrown) {
                        ajaxErrorFunction(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                swal('No se ha eliminado la publicación');
            }
        });
    });
    
    $(document).on('click', '#removeFileBtn', function() {
        var nameFile = $(this).attr('data-namefile');    
        removeAttachedFile(nameFile);
    });
    
    $(document).on('click', '#syncAttachedFilesBtn', function() {
        $.ajax({
            url: BASE_URL + 'posts/refresh_attached_files',
            method: 'POST',
            data:{action: 'refreshAttachedFiles'},
            success:function(response){
                $('#viewAttachedFiles').html(response);
            },
            error:function(jqXHR, textStatus, errorThrown){
                ajaxErrorFunction(jqXHR, textStatus, errorThrown);
            }
        });
    });
});

function removeAttachedFile(nameFile) {
    $.ajax({
        url: BASE_URL + 'posts/remove_attached_file',
        method: 'POST',
        dataType: 'json',
        data:{action: 'removeAttachedFile', nameFile:nameFile},
        success:function(response){
            if (response['success']) {
                $('#viewAttachedFiles').html(response['output']);
            } else {
                swal('Error', 'Se ha producido un error inesperado al eliminar el fichero.', 'error');
            }
        },
        error:function(jqXHR, textStatus, errorThrown){
            ajaxErrorFunction(jqXHR, textStatus, errorThrown);
        }
    });
}