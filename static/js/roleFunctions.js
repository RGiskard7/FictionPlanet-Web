$(document).ready(function() {
    var roleTable = $('#roleTable').DataTable({
        "language": {
            "emptyTable": "No hay datos disponibles en la tabla.",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
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
            "url": BASE_URL + "/roles/roles_data_table_load",
            "dataSrc":"",
            "type": "POST",
            "dataType": "json",
            "data": {
                "action": "roleDataTableLoad"
            }
        },
        "columns": [
            {"data": "actions", 
                'orderable': false, 
                'searchable': false,
                "width": "2%"},
            {"data": "index", "width": "2%"},
            {"data": "id", "width": "2%"},
            {"data": "name_esp", "width": "20%"},
            {"data": "description"}
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
                "extend": "csvHtml5",
                "text": "<i class='fa fa-file-o'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info gmd-1 mr-2 mb-2 rounded"
            },{
                "extend": "colvis",
                "text":"Columnas visibles",
                "className": "btn btn-warning gmd-1 mb-2 rounded"
            },  
        ],
        "scroll": true,
        "responsive": true
    });
   
   $(document).on('click', '#permissionsRoleBtn', function() {
        var roleID = $(this).attr('data-roleid');
              
        $.ajax({
            url:BASE_URL + "/roles/get_role_permissions",
            method:"POST",
            data:{action:"get_role_permissions", roleID:roleID},
            success:function(response){
                $('#modalDeclaration').html(response);
                $('#permissionsRoleModal').modal('show');
            },
            error:function(jqXHR, textStatus, errorThrown) {
                ajaxErrorFunction(jqXHR, textStatus, errorThrown);
            }
            
        });
    });
    
    $(document).on('click', '#submitPermissionsRole', function() {
        $.post($('#permissionForm').attr('action'), $("#permissionForm").serialize() + "&submitPermissionsRole=1", function(data) {
            if (data == 1) {
                $('#permissionsRoleModal').modal('hide');
                swal({
                    title: "Correcto",
                    text: "Se han actualizado los permisos correctamente.",
                    icon: "success"
                }).then(() => {
                    location.reload(); // Revisar
                });
            } else {
                swal("Error", "Se ha producido un error al intentar acceder a la base de datos.", "error");
            } 
        }).fail(function() {
            swal("Error", "Se ha producido un error inesperado.", "error");
        });
        //ev.preventDefault(); // evita la ejecución del submit del formulario, tambien vale return false
        return false;
    });
    
    $(document).on('keyup', '#roleTitle', function() {
        $('#feddbackNewRoleName').html('');
        $('#roleTitle').removeClass('is-valid is-invalid');
        if ($(this).val().length > 0) {
            if ($(this).val().length > 3) {
                $.ajax({
                    url:BASE_URL + "/roles/check_new_role_name",
                    method:"POST",
                    data:{action:"check_new_role_name", roleTitle:$('#roleTitle').val()},
                    success:function(response){
                        if (response != true) {
                            $('#roleTitle').addClass('is-valid');
                            $('#submitNewRole').attr('disabled', false);
                        } else {
                            $('#roleTitle').addClass('is-invalid');
                            $('#feddbackNewRoleName').html('Ese nombre de rol ya está en uso.');
                            $('#submitNewRole').attr('disabled', true);
                        }
                    },
                    error:function(jqXHR, textStatus, errorThrown) {
                        ajaxErrorFunction(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                $('#roleTitle').addClass('is-invalid');
                $('#feddbackNewRoleName').html('El nombre de usuario debe tener 5 caracteres como mínimo.');
                $('#submitNewRole').attr('disabled', true);
            }
        }
        $('#submitNewRole').attr('disabled', true);
    });
    
    
    $(document).on('click', '#insertRoleBtn', function() {
        $('#newRoleModal').modal('show');
    });
    
    $(document).on('click', '#updateRoleBtn', function() {
        var roleID = $(this).attr('data-roleid');
        
        $.ajax({
            url:BASE_URL + "/roles/get_role_data",
            method:"POST",
            scriptCharset: "utf-8",
            dataType: 'json',
            data:{action:"get_role_data", roleID:roleID},
            success:function(response){
                if (response['succes']) {
                    $('#editRoleID').val(response['roleData'].roleID);
                    $('#editRoleTitle').val(response['roleData'].roleName);
                    $('#editRoleDescription').val(response['roleData'].roleDescription);
                    $('#editRoleModal').modal('show');
                } else {
                    swal("Error", "Se ha producido un error en la petición a la base de datos.", "error");
                    $('#editRoleModal').modal('hide');
                }
            },
            error:function(jqXHR, textStatus, errorThrown) {
                ajaxErrorFunction(jqXHR, textStatus, errorThrown);
            }
        });
        
    });
    
    $(document).on('click', '#submitNewRole', function() { 
        $.ajax({
            url:BASE_URL + "/roles/insert_new_role",
            method:"POST",
            data:{action:"insert_new_role", roleTitle:$('#roleTitle').val(), roleDescription:$('#roleDescription').val()},
            success:function(response){
                if (response) {
                    alert("Se ha creado el nuevo rol correctamente.");
                    $('#newRoleModal').modal('hide');
                    $('#roleTable').DataTable().ajax.reload();
                } else {
                    swal("Error", "Se ha producido un error inesperado.", "error");
                }
            },
            error:function(jqXHR, textStatus, errorThrown) {
                ajaxErrorFunction(jqXHR, textStatus, errorThrown);
            }
        }); 
    });
    
    $(document).on('click', '#submitEditRole', function() {        
        $.post(BASE_URL + '/roles/submit_edit_role', $('#formEditRole').serialize() + '&submitEditRole=1', function(data) {
            if (data == 1) {
                $('#editRoleModal').modal('hide');
                swal({
                    title: 'Correcto',
                    text: 'Se ha actualizado el rol correctamente.',
                    icon: 'success'
                }).then(() => {
                    $('#roleTable').DataTable().ajax.reload();
                });
            } else {
                swal('Error', 'Se ha producido un error al intentar acceder a la base de datos.', 'error');
            } 
        }).fail(function() {
            swal('Error', 'Se ha producido un error inesperado.', 'error');
        });
        //ev.preventDefault(); // evita la ejecución del submit del formulario, tambien vale return false
        return false;
    });
    
    $(document).on('click', '#removeRoleBtn', function() {
        var roleID = $(this).attr('data-roleid');
        var roleName = $(this).attr('data-rolename');
        
        swal({
            title: "¿Seguro que quieres eliminar el rol " + roleName + "?",
            text: "Si aceptas, se eliminará el rol para siempre.",
            icon: "warning",
            buttons: {
                ok: "Eliminar",
                cancel: "Cancelar"
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url:BASE_URL + '/roles/delete_role',
                    method:'POST',
                    data:{action:"delete_role", roleID:roleID},
                    success:function(response){
                        if (response) {
                            swal("Correcto", "Se ha eliminado el rol " + roleName + " correctamente.", "success");
                            $('#roleTable').DataTable().ajax.reload();
                        } else {
                            swal("Error", "Se ha producido un error en la petición a la base de datos.", "error");
                        }
                    },
                    error:function(jqXHR, textStatus, errorThrown) {
                        ajaxErrorFunction(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                swal("No se ha eliminado el rol");
            }
        });
    });
    
    $(document).on('hidden.bs.modal', '#newRoleModal', function() {
        $('#roleTitle').html('');
        $('#roleTitle').removeClass('is-valid is-invalid');
        $('#roleDescription').html('');
        $('#feddbackNewRoleName').html('');
        $('#submitNewRole').attr('disabled', true);
        $(this).find('form').trigger('reset');
    });
});

function ajaxErrorFunction(jqXHR, textStatus, errorThrown) {
    if (jqXHR.status === 0) {
            alert('Not connect: Verify Network.');
    } else if (jqXHR.status == 404) {
        alert('Requested page not found [404]');
    } else if (jqXHR.status == 500) {
        alert('Internal Server Error [500].');
    } else if (textStatus === 'parsererror') {
        alert('Requested JSON parse failed.');
    } else if (textStatus === 'timeout') {
        alert('Time out error.');
    } else if (textStatus === 'abort') {
        alert('Ajax request aborted.');
    } else {
        alert('Uncaught Error: ' + jqXHR.responseText);
    } 
};

