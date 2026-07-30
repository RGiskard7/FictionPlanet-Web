$(document).ready(function() {   
    $('#userTable').DataTable({
        "language": {
            "emptyTable": "No hay datos disponibles en la tabla.",
            "lengthMenu": "Mostrar _MENU_ usuarios",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando usuarios del _START_ al _END_ de un total de _TOTAL_ usuarios",
            "infoEmpty": "Mostrando usuarios del 0 al 0 de un total de 0 usuarios",
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
            "url": BASE_URL + "/users/users_data_table_load",
            "dataSrc":"",
            "type": "POST",
            "dataType": "json",
            "data": {
                "action": "userDataTableLoad"
            }
        },
        
        "columns": [
            {"data": "actions", 'orderable': false, 'searchable': false},
            {"data": "index"},
            {"data": "id"},
            {"data": "user_name",
                "width": "10%",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<a href="/users/profile/' + data + '">' + data + '</a>';
                    }
                    return data;
                }
            },
            {"data": "first_name"},
            {"data": "last_name"},
            {"data": "email"},
            {"data": "password"},
            {"data": "address"},
            {"data": "country"},
            {"data": "phone_number"},
            {"data": "role"},
            {"data": "reg_date"},
            {"data": "last_update_date"},
            {"data": "last_access_date"},
            {"data": "status"}
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
        "responsive": true,
    });
    
    $('#userContactsTable').DataTable({
        "language": {
            "searchPlaceholder": "Buscar contacto...",
            "emptyTable": "No hay contactos",
            "lengthMenu": "Mostrar _MENU_ contactos",
            "zeroRecords": "No se encontraron resultados",
            "info": "_TOTAL_ contactos",
            "infoEmpty": "0 contactos",
            "infoFiltered": "(filtrado de un total de _MAX_ contactos)",
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
            "url": BASE_URL + "/users/user_contacts_table_load",
            "dataSrc":"",
            "type": "POST",
            "dataType": "json",
            "data": {
                "action": "userContactsLoad"
            }
        },
        // Eliminar flechas de ordenacion
        "targets": 'no-sort',
        "bSort": false,
        // Eliminar texto informativo de los registros
        //"bInfo": false,
        //"lengthChange":false,
        
        "columns": [
            {"data": "user_name", 'orderable': false, "width": "100%"},
            {"data": "actions", 'orderable': false, 'searchable': false, className: "text-right"}
        ],
        
        "processing": true,
        "scroll": true,
        "responsive": true,
        "bAutoWidth": false, // Para ocupar el ancho
    });
    
    $('#allUserTable').DataTable({
        "language": {
            "searchPlaceholder": "Buscar perfil...",
            "emptyTable": "No hay usuarios",
            "lengthMenu": "Mostrar _MENU_ usuarios",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando usuarios del _START_ al _END_ de un total de _TOTAL_ usuarios",
            "infoEmpty": "Mostrando usuarios del 0 al 0 de un total de 0 usuarios",
            "infoFiltered": "(filtrado de un total de _MAX_ usuarios)",
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
            "url": BASE_URL + "/users/all_users_table_load",
            "dataSrc":"",
            "type": "POST",
            "dataType": "json",
            "data": {
                "action": "allUsersTableLoad"
            }
        },
        //"targets": 'no-sort',
        // Eliminar flechas-boton de ordenacion
        "bSort": false,
        // Eliminar texto informativo de los registros
        "bInfo": false,
        //"lengthChange":false,
        
        "columns": [
            {"data": "user_name", 'orderable': true, "width": "100%"},
            {"data": "actions", 'orderable': false, 'searchable': false, className: "text-right"}
        ],
        
        "processing": true,
        "scroll": true,
        "responsive": true,
        "bAutoWidth": false, // Para ocupar el ancho
    });
       
    $('#friendRequestsTable').DataTable({
        "language": {
            "searchPlaceholder": "Buscar solicitud...",
            "emptyTable": "No hay solicitudes",
            "lengthMenu": "Mostrar _MENU_ solicitudes",
            "zeroRecords": "No se encontraron resultados",
            "info": "_TOTAL_ solicitudes pendientes",
            "infoEmpty": "0 solicitudes",
            "infoFiltered": "(filtrado de un total de _MAX_ solicitudes)",
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
            "url": BASE_URL + "/users/friend_requests_table_load",
            "dataSrc":"",
            "type": "POST",
            "dataType": "json",
            "data": {
                "action": "friendRequestsTableLoad"
            }
        },
        // Eliminar flechas de ordenacion
        "targets": 'no-sort',
        "bSort": false,
        // Eliminar texto informativo de los registros
        //"bInfo": false,
        "lengthChange":false,
        
        "columns": [
            {"data": "user_name", 'orderable': false, "width": "100%"},
            {"data": "actions", 'orderable': false, 'searchable': false, className: "text-right"}
        ],
        
        "processing": true,
        "scroll": true,
        "responsive": true,
        "bAutoWidth": false, // Para ocupar el ancho
    });   
    
    /*Eventos solicitudes contactos*/
    $(document).on('click', '.acceptRequestBtn', function() {
        var frndRequestId = $(this).attr('data-frndRequestid');
        var fromUserId = $(this).attr('data-fromuserid');
        $.ajax({
            url: BASE_URL + 'users/accept_friend_request',
            method: 'POST',
            scriptCharset: 'utf-8',
            //dataType: 'json',
            data: {action:'acceptFriendRequest', frndRequestId:frndRequestId, fromUserId:fromUserId},
            success:function(response){
                //if(respose['succes'] = true)
                if (response == true) {
                   $('#friendRequestsTable').DataTable().ajax.reload();
                   $('#allUserTable').DataTable().ajax.reload();
                   $('#userContactsTable').DataTable().ajax.reload();
                } else {
                   swal('Error', 'Se ha producido un error al aceptar la solicitud de amistad.', 'error');
                }
            },
            error:function(jqXHR, textStatus, errorThrown) {
                ajaxErrorFunction(jqXHR, textStatus, errorThrown);
            }
        });
    });
    
    $(document).on('click', '.rejectRequestBtn', function() {
        var frndRequestId = $(this).attr('data-frndRequestid');
        var fromUserId = $(this).attr('data-fromuserid');
        $.ajax({
            url: BASE_URL + 'users/reject_friend_request',
            method: 'POST',
            scriptCharset: 'utf-8',
            data: {action:'rejectFriendRequest', frndRequestId:frndRequestId, fromUserId:fromUserId},
            success:function(response){
                if (response == true) {
                   $('#friendRequestsTable').DataTable().ajax.reload();
                   $('#allUserTable').DataTable().ajax.reload();
                   $('#userContactsTable').DataTable().ajax.reload();
                } else {
                   swal('Error', 'Se ha producido un error al eliminar la solicitud de amistad.', 'error');
                }
            },
            error:function(jqXHR, textStatus, errorThrown) {
                ajaxErrorFunction(jqXHR, textStatus, errorThrown);
            }
        });
    });
    
    $(document).on('click', '.addContactBtn', function() {
        var touserid = $(this).attr('data-touserid');
        $.ajax({
            url: BASE_URL + 'users/request_friendship',
            method: 'POST',
            scriptCharset: 'utf-8',
            //dataType: 'json',
            data: {action:'requestFriendship', toUserId:touserid},
            success:function(response){
                if (response == true) {
                   swal('Correcto', 'Se ha enviado la solicitud de amistad.', 'success');
                   $('#friendRequestsTable').DataTable().ajax.reload();
                   $('#allUserTable').DataTable().ajax.reload();
                   $('#userContactsTable').DataTable().ajax.reload();
                } else {
                   swal('Error', 'Se ha producido un error al solicitar el contacto.', 'error');
                }
            },
            error:function(jqXHR, textStatus, errorThrown) {
                ajaxErrorFunction(jqXHR, textStatus, errorThrown);
            }
        });
    });
    /*Fin eventos solicitudes contactos*/
       
    $('#passwordNewUser').keyup(function () {
        $('#result').html(checkStrength($('#passwordNewUser').val()));
    });

    $('#newPassword').keyup(function () {
        $('#passwordType').html(checkStrength($('#newPassword').val()));
    });
    
    $(document).on('keyup', '#currentPassword', function() {
        if ($(this).val().length > 0) {
            $.ajax({
                url:BASE_URL + 'users/check_current_password',
                method:'POST',
                data:{action:'checkCurrentPassword', currentPassword:$('#currentPassword').val()},
                success:function(response){
                    $('#feddbackCurrentPassword').html('');
                    $('#currentPassword').removeClass('is-valid is-invalid');
                    if (response == true) {
                        $('#currentPassword').addClass('is-valid');
                    } else {
                        $('#currentPassword').addClass('is-invalid');
                        $('#feddbackCurrentPassword').html('La contraseña introducida es incorrecta');
                    }
                }
            });
        } else {
            $('#feddbackCurrentPassword').html('');
            $('#currentPassword').removeClass('is-valid is-invalid');
        }
    });

    $(document).on('keyup', '#newPassword', function() {
        $(this).removeClass('is-valid is-invalid');
        $('#confirmNewPassword').removeClass('is-valid is-invalid');
        $('#feddbackNewPassword').html('');
        if ($('#confirmNewPassword').val().length > 0) {
            if ($(this).val() !== $('#confirmNewPassword').val()) {
                $(this).addClass('is-invalid');
                $('#confirmNewPassword').addClass('is-invalid');
                $('#feddbackNewPassword').html('No coinciden las contraseñas');
            } else {
                $('#confirmNewPassword').addClass('is-valid');
                $(this).addClass('is-valid');
            }
        } 
    });

    $(document).on('keyup', '#confirmNewPassword', function() {
        $('#newPassword').removeClass('is-valid is-invalid');
        $(this).removeClass('is-valid is-invalid');
        $('#feddbackNewPassword').html('');
        if ($(this).val().length > 0) {
            if ($(this).val() != $('#newPassword').val()) {
                $('#newPassword').addClass('is-invalid');
                $(this).addClass('is-invalid');
                $('#feddbackNewPassword').html('No coinciden las contraseñas');
            } else {
                $('#newPassword').addClass('is-valid');
                $(this).addClass('is-valid');
            }
        } 
    });

    $(document).on('click', '#submitChangePassword', function() {
        $('#passwordChangeAlert').removeClass('alert alert-danger alert-dismissible fade show');
        $('#passwordChangeAlert').html('');
        if ($('#currentPassword').val().length > 0 && $('#newPassword').val().length > 0 
                && $('#confirmNewPassword').val().length > 0) {
            if ($('#newPassword').val() == $('#confirmNewPassword').val()) {
                $.ajax({
                    url:BASE_URL + 'users/submit_change_password',
                    method:'POST',
                    dataType: 'json',
                    data:{action:'submitChangePassword', currentPassword:$('#currentPassword').val(), newPassword:$('#newPassword').val()},
                    success:function(response){
                        if (response['success'] == true) {
                            if (response['password_ok'] == true) {
                                swal('Correcto', 'Se ha cambiado la contraseña correctamente.', 'success');
                                $('#changePasswordModal').modal('hide');
                            } else {
                                $('#passwordChangeAlert').addClass('alert alert-danger alert-dismissible fade show');
                                $('#passwordChangeAlert').html('<button type="button" class="close" data-dismiss="alert">&times;' 
                                        + '</button>La contraseña actual introducida es incorrecta');
                            } 
                        } else {
                            swal('Error', 'Se ha producido un error inesperado.', 'error');
                        }
                    },
                    error:function() {
                        swal('Error', 'Se ha producido un error en la petición al servidor.', 'error');
                    }
                });
            } 
        } else {
            $('#passwordChangeAlert').addClass('alert alert-danger alert-dismissible fade show');
            $('#passwordChangeAlert').html('<button type="button" class="close" data-dismiss="alert">&times;</button>Debes rellenar todos los campos'); 
        }
    });
    
    $(document).on('click', '#editProfileBtn', function() {
        $.ajax({
            url:BASE_URL + 'users/get_logged_in_user_data',
            method:'POST',
            scriptCharset: 'utf-8',
            dataType: 'json',
            data:{action:'getLoggedInUserData'},
            success:function(response){
                if (response['succes']) {
                    $('#userNameEditProfile').val(response['userData'].userName);
                    $('#currentUserNameEditProfile').val(response['userData'].userName);
                    $('#firstNameEditProfile').val(response['userData'].firstName);
                    $('#lastNameEditProfile').val(response['userData'].lastName);
                    $('#emailEditProfile').val(response['userData'].email);
                    $('#currentEmailEditProfile').val(response['userData'].email);
                    $('#addressEditProfile').val(response['userData'].address);
                    $('#countryEditProfile').val(response['userData'].country);
                    $('#telephonEditProfile').val(response['userData'].phoneNumber);
                    $('#editProfileModal').modal('show');
                } else {
                    swal('Error', 'Se ha producido un error en la petición a la base de datos.', 'error');
                    $('#editProfileModal').modal('hide');
                }
            },
            error:function(jqXHR, textStatus, errorThrown) {
                ajaxErrorFunction(jqXHR, textStatus, errorThrown);
            }
        });
    });
    
    $(document).on('keyup', '#userNameEditProfile', function() {
        $('#feddbackUserNameEditProfile').html('');
        $('#userNameEditProfile').removeClass('is-valid is-invalid');
        if ($(this).val().length > 0) {
            if ($(this).val().length > 5) {
                if ($('#userNameEditProfile').val() != $('#currentUserNameEditProfile').val()) {
                    $.ajax({
                        url:BASE_URL + 'users/check_user_name',
                        method:'POST',
                        data:{action:'checkUserName', userName:$('#userNameEditProfile').val()},
                        success:function(response){
                            if (response != true) {
                                $('#userNameEditProfile').addClass('is-valid');
                            } else {
                                $('#userNameEditProfile').addClass('is-invalid');
                                $('#feddbackUserNameEditProfile').html('Ese nombre de usuario ya está en uso.');
                            }
                        },
                        error:function(jqXHR, textStatus, errorThrown) {
                            ajaxErrorFunction(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            } else {
                $('#userNameEditProfile').addClass('is-invalid');
                $('#feddbackUserNameEditProfile').html('El nombre de usuario debe tener 5 caracteres como mínimo.');
            }
        }
    });
    
    $(document).on('keyup', '#userNameNewUser', function() {
        $('#feddbackUserNameNewProfile').html('');
        $('#userNameNewUser').removeClass('is-valid is-invalid');
        if ($(this).val().length > 0) {
            if ($(this).val().length > 5) {
                $.ajax({
                    url:BASE_URL + 'users/check_user_name',
                    method:'POST',
                    data:{action:'checkUserName', userName:$('#userNameNewUser').val()},
                    success:function(response){
                        if (response != true) {
                            $('#userNameNewUser').addClass('is-valid');
                        } else {
                            $('#userNameNewUser').addClass('is-invalid');
                            $('#feddbackUserNameNewProfile').html('Ese nombre de usuario ya está en uso.');
                        }
                    },
                    error:function(jqXHR, textStatus, errorThrown) {
                        ajaxErrorFunction(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                $('#userNameNewUser').addClass('is-invalid');
                $('#feddbackUserNameNewProfile').html('El nombre de usuario debe tener 5 caracteres como mínimo.');
            }
        }
        
    });
    
    $(document).on('keyup', '#emailEditProfile', function() {
        $('#feddbackEmailEditProfile').html('');
        $('#emailEditProfile').removeClass('is-valid is-invalid');
        if ($(this).val().length > 0) {
            if ($('#emailEditProfile').val().indexOf('@', 0) == -1 || $('#emailEditProfile').val().indexOf('.', 0) == -1) {
                $('#emailEditProfile').addClass('is-invalid');
                $('#feddbackEmailEditProfile').html('Debes introducir un email válido: email@example.com.');
            } else {
                if ($('#emailEditProfile').val() != $('#currentEmailEditProfile').val()) {
                    $.ajax({
                        url:BASE_URL + 'users/check_email',
                        method:'POST',
                        data:{action:'checkEmail', email:$('#emailEditProfile').val()},
                        success:function(response){
                            if (response != true) {
                                $('#emailEditProfile').addClass('is-valid');
                            } else {
                                $('#emailEditProfile').addClass('is-invalid');
                                $('#feddbackEmailEditProfile').html('Ese email ya está en uso.');
                            }
                        },
                        error:function(jqXHR, textStatus, errorThrown) {
                            ajaxErrorFunction(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            }
        }
    });
    
    $(document).on('click', '#submitEditProfile', function() {
        var userNameEditProfile = $('#userNameEditProfile').val();
        var firstNameEditProfile = $('#firstNameEditProfile').val();
        var lastNameEditProfile = $('#lastNameEditProfile').val();
        var emailEditProfile = $('#emailEditProfile').val();
        var addressEditProfile = $('#addressEditProfile').val();
        var countryEditProfile = $('#countryEditProfile').val();
        var telephonEditProfile = $('#telephonEditProfile').val();
        
        if (editProfileValidate()) {
            $.ajax({
                url:BASE_URL + 'users/submit_edit_profile',
                method:'POST',
                dataType:'json',
                data:{action:'submitEditProfile', userNameEditProfile:userNameEditProfile, firstNameEditProfile:firstNameEditProfile, 
                    lastNameEditProfile:lastNameEditProfile, emailEditProfile:emailEditProfile, addressEditProfile:addressEditProfile, 
                    countryEditProfile:countryEditProfile, telephonEditProfile:telephonEditProfile},
                success:function(response){
                    if (response['userName_ok'] == true) {
                        if (response['success'] == true) {
                            $('#editUserModal').modal('hide');
                            swal({
                                title: 'Correcto',
                                text: 'Se ha editado el perfil correctamente.',
                                icon: 'success'
                            }).then(() => {
                                $(location).attr('href', BASE_URL + 'users/profile/' + userNameEditProfile);
                            });
                        } else {
                            swal('Error', 'Se ha producido un error inesperado.', 'error');
                        }
                    } else {
                        $('#editProfileAlert').addClass('alert alert-danger alert-dismissible fade show');
                        $('#editProfileAlert').html('<button type="button" class="close" data-dismiss="alert">&times;</button>El nombre de usuario introducido ya existe');
                    }
                },
                error:function(jqXHR, textStatus, errorThrown) {
                    ajaxErrorFunction(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            $('#editProfileAlert').addClass('alert alert-danger alert-dismissible fade show');
            $('#editProfileAlert').html('<button type="button" class="close" data-dismiss="alert">&times;</button>Debes rellenar todos los campos obligatorios'); 
        }
    });
    
    $(document).on('click', '#viewUserBtn', function() {
        var idUser = $(this).attr('data-iduser');
        
        $.ajax({
            url:BASE_URL + 'users/get_data',
            method:'POST',
            scriptCharset:'utf-8',
            dataType:'json',
            data:{action:"getUserData", idUser:idUser},
            success:function(response){
                if (response['succes']) {
                    if (response['userData'].active == 1) {
                        $('#activeUserViewModal').removeClass('badge-danger');
                        $('#activeUserViewModal').addClass('badge-success');
                        var status = "Usuario activo";
                    } else {
                        $('#activeUserViewModal').removeClass('badge-success');
                        $('#activeUserViewModal').addClass('badge-danger');
                        var status = "Usuario no activo";  
                    }
                    
                    $('#activeUserViewModal').text(status);
                    $('#userNameViewModal').text(response['userData'].userName);
                    $('#firstNameViewModal').text(response['userData'].firstName);
                    $('#lastNameViewModal').text(response['userData'].lastName);
                    $('#emailViewModal').text(response['userData'].email);
                    $('#roleViewModal').text(response['userData'].role);
                    $('#addressViewModal').text(response['userData'].address);
                    $('#countryViewModal').text(response['userData'].country);
                    $('#telephoneViewModal').text(response['userData'].phoneNumber);
                    $('#userModal').modal('show');
                } else {
                    /*alert("Se ha producido un error en la petición a la base de datos.");*/
                    swal("Error", "Se ha producido un error en la petición a la base de datos.", "error");
                    $('#userModal').modal('hide');
                }
            },
            error:function(jqXHR, textStatus, errorThrown) {
                ajaxErrorFunction(jqXHR, textStatus, errorThrown);
            }
        });
    });
    
    $(document).on('click', '#updateUserBtn', function() {
        var idUser = $(this).attr('data-iduser');
        var loggedInUserId = $('#loggedInUserId').val();
        $('#selectUserRol').show();
        $('#selectUserStatus').show();
        
        $.ajax({
            url:BASE_URL + 'users/get_data',
            method:"POST",
            scriptCharset: "utf-8",
            dataType: 'json',
            data:{action:"getUserData", idUser:idUser},
            success:function(response){
                if (response['succes']) {
                    if (idUser == loggedInUserId) {
                        $('#selectUserRol').hide();
                        $('#selectUserStatus').hide();
                    }
                    
                    $('#statusEditUser').val(response['userData'].active); 
                    $('#roleEditUser').val(response['userData'].role_id);                    
                    $('#idEditUser').val(response['userData'].idUser);
                    $('#userNameEditProfile').val(response['userData'].userName);
                    $('#currentUserNameEditProfile').val(response['userData'].userName);
                    $('#firstNameEditProfile').val(response['userData'].firstName);
                    $('#lastNameEditProfile').val(response['userData'].lastName);
                    $('#emailEditProfile').val(response['userData'].email);
                    $('#currentEmailEditProfile').val(response['userData'].email);
                    $('#addressEditProfile').val(response['userData'].address);
                    $('#countryEditProfile').val(response['userData'].country);
                    $('#telephonEditProfile').val(response['userData'].phoneNumber);
                    $('#editUserModal').modal('show');
                } else {
                    swal("Error", "Se ha producido un error en la petición a la base de datos.", "error");
                    $('#editUserModal').modal('hide');
                }
            },
            error:function(jqXHR, textStatus, errorThrown) {
                ajaxErrorFunction(jqXHR, textStatus, errorThrown);
            }
        });
    });
    
    $(document).on('click', '#submitEditUser', function() {
        var loggedInUserId = $('#loggedInUserId').val();
        var idUser = $('#idEditUser').val();
        var userNameEditProfile = $('#userNameEditProfile').val();
        var firstNameEditProfile = $('#firstNameEditProfile').val();
        var lastNameEditProfile = $('#lastNameEditProfile').val();
        var emailEditProfile = $('#emailEditProfile').val();
        var addressEditProfile = $('#addressEditProfile').val();
        var countryEditProfile = $('#countryEditProfile').val();
        var telephonEditProfile = $('#telephonEditProfile').val();
        var roleIdEditUser = $('#roleEditUser').val();
        var statusEditUser = $('#statusEditUser').val();
        var newPassword = $('#newPassword').val();
        var confirmNewPassword = $('#confirmNewPassword').val();
        
        if (editProfileValidate()) {
            if (newPassword == confirmNewPassword) {
                $.ajax({
                    url:BASE_URL + 'users/update',
                    method:"POST",
                    dataType:'json',
                    data:{action:"submitEditUser", idUser:idUser, userNameEditProfile:userNameEditProfile, firstNameEditProfile:firstNameEditProfile, lastNameEditProfile:lastNameEditProfile, 
                        newPassword:newPassword, emailEditProfile:emailEditProfile, addressEditProfile:addressEditProfile, countryEditProfile:countryEditProfile, 
                        telephonEditProfile:telephonEditProfile, roleIdEditUser:roleIdEditUser, statusEditUser:statusEditUser},
                    success:function(response){
                        if (response['userName_ok'] == true) {
                            if (response['success'] == true) {                               
                                if (loggedInUserId == idUser) {
                                    $(location).attr('href', BASE_URL + 'users/');
                                    alert("Se ha editado tu usuario correctamente.");
                                } else {
                                    $('#userTable').DataTable().ajax.reload();
                                    swal("Correcto", "Se ha editado el usuario correctamente.", "success");
                                }
                                $('#editUserModal').modal('hide');
                            } else {
                                swal("Error", "Se ha producido un error inesperado. No se ha podido editar el usuario", "error");
                            }
                        } else {
                            $('#editProfileAlert').addClass('alert alert-danger alert-dismissible fade show');
                            $('#editProfileAlert').html('<button type="button" class="close" data-dismiss="alert">&times;</button>El nombre de usuario introducido ya existe');
                        }
                    },
                    error:function(jqXHR, textStatus, errorThrown) {
                        ajaxErrorFunction(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        } else {
            $('#editProfileAlert').addClass('alert alert-danger alert-dismissible fade show');
            $('#editProfileAlert').html('<button type="button" class="close" data-dismiss="alert">&times;</button>Debes rellenar todos los campos obligatorios'); 
        }
    });
        
    $(document).on('click', '#removeUserBtn', function() {
        var idUser = $(this).attr('data-iduser');
        var userName= $(this).attr('data-username');
        
        swal({
            title: '¿Seguro que quieres eliminar el usuario ' + userName + '?',
            text: 'Si aceptas, se eliminará el usuario para siempre.',
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
                    url:BASE_URL + 'users/delete',
                    method:'POST',
                    data:{action:'deleteUser', idUser:idUser},
                    success:function(response){
                        if (response) {
                            swal('Correcto', 'Se ha eliminado el usuario ' + userName + ' correctamente.', 'success');
                            $('#userTable').DataTable().ajax.reload();
                        } else {
                            swal('Error', 'Se ha producido un error en la petición a la base de datos.', 'error');
                        }
                    },
                    error:function(jqXHR, textStatus, errorThrown) {
                        ajaxErrorFunction(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                swal('No se ha eliminado el usuario');
            }
        });
    });
    
    $(document).on('hidden.bs.modal', '#changePasswordModal', function() {
        $('#passwordType').html('');
        $('#feddbackNewPassword').html('');
        $('#feddbackCurrentPassword').html('');
        $('#currentPassword').removeClass('is-valid is-invalid');
        $('#newPassword').removeClass('is-valid is-invalid');
        $('#confirmNewPassword').removeClass('is-valid is-invalid');
        $('#passwordChangeAlert').removeClass('alert alert-danger alert-dismissible fade show');
        $('#passwordChangeAlert').html('');
        $(this).find('form').trigger('reset');
    });
    
    $(document).on('hidden.bs.modal', '#editProfileModal', function() {
        $('#userNameEditProfile').removeClass('is-valid is-invalid');
        $('#firstNameEditProfile').removeClass('is-valid is-invalid');
        $('#lastNameEditProfile').removeClass('is-valid is-invalid');
        $('#emailEditProfile').removeClass('is-valid is-invalid');
        $('#addressEditProfile').removeClass('is-valid is-invalid');
        $('#countryEditProfile').removeClass('is-valid is-invalid');
        $('#telephonEditProfile').removeClass('is-valid is-invalid');
        $('#feddbackUserNameEditProfile').html('');
        $('#feddbackEmailEditProfile').html('');
        $('#currentUserNameEditProfile').val('');
        $('#currentEmailEditProfile').val('');
        $('#editProfileAlert').html('');
        $('#editProfileAlert').removeClass('alert alert-danger alert-dismissible fade show');
        $(this).find('form').trigger('reset');
    });
    
    $(document).on('hidden.bs.modal', '#editUserModal', function() {
        $('#userNameEditProfile').removeClass('is-valid is-invalid');
        $('#firstNameEditProfile').removeClass('is-valid is-invalid');
        $('#lastNameEditProfile').removeClass('is-valid is-invalid');
        $('#emailEditProfile').removeClass('is-valid is-invalid');
        $('#addressEditProfile').removeClass('is-valid is-invalid');
        $('#countryEditProfile').removeClass('is-valid is-invalid');
        $('#telephonEditProfile').removeClass('is-valid is-invalid');
        $('#newPassword').removeClass('is-valid is-invalid');
        $('#confirmNewPassword').removeClass('is-valid is-invalid');
        $('#feddbackUserNameEditProfile').html('');
        $('#feddbackEmailEditProfile').html('');
        $('#feddbackNewPassword').html('');
        $('#currentUserNameEditProfile').val('');
        $('#currentEmailEditProfile').val('');
        $('#editProfileAlert').html('');
        $('#editProfileAlert').removeClass('alert alert-danger alert-dismissible fade show');
        $('#passwordChangeAlert').html('');
        $('#passwordChangeAlert').removeClass('alert alert-danger alert-dismissible fade show');
        $('#passwordType').html('');
        $(this).find('form').trigger('reset');
    });
});

function editProfileValidate() {
    var flag = true;
    $('#userNameEditProfile').removeClass('is-invalid');
    $('#firstNameEditProfile').removeClass('is-invalid');
    $('#lastNameEditProfile').removeClass('is-invalid');
    $('#emailEditProfile').removeClass('is-invalid');
    $('#addressEditProfile').removeClass('is-invalid');
    $('#countryEditProfile').removeClass('is-invalid');
    $('#telephonEditProfile').removeClass('is-invalid');
    $('#editProfileAlert').html('');
    
    if ($('#userNameEditProfile').val().length === 0) {
        $('#userNameEditProfile').addClass('is-invalid');
        flag = false;
    }
    
    if ($('#firstNameEditProfile').val().length === 0) {
        $('#firstNameEditProfile').addClass('is-invalid');
        flag = false;
    }
    
    if ($('#lastNameEditProfile').val().length === 0) {
        $('#lastNameEditProfile').addClass('is-invalid');
        flag = false;
    }
    
    if ($('#emailEditProfile').val().length === 0) {
        $('#emailEditProfile').addClass('is-invalid');
        flag = false;
    }
    
    if ($('#addressEditProfile').val().length === 0) {
        $('#addressEditProfile').addClass('is-invalid');
        flag = false;
    }
    
    if ($('#countryEditProfile').val().length === 0) {
        $('#countryEditProfile').addClass('is-invalid');
        flag = false;
    }
    
    return flag;

};

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

function checkStrength(password) {
    var strength = 0;
    
    if (password.length == 0) {
        $('#result').removeClass();
        return '';
    }
    
    if (password.length < 8) {
        $('#result').removeClass();
        $('#passwordType').addClass('short');
        return 'La contraseña es demasiado corta';
    }
    
    if (password.length > 7) {
        strength += 1;
    }
    // If password contains both lower and uppercase characters, increase strength value.
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
        strength += 1;
    }
    // If it has numbers and characters, increase strength value.
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
        strength += 1;
    }
    // If it has one special character, increase strength value.
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
        strength += 1;
    }
    // If it has two special characters, increase strength value.
    if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) {
        strength += 1;
    }
    // Calculated strength value, we can return messages
    // If value is less than 2
    if (strength < 2) {
        $('#result').removeClass();
        $('#passwordType').addClass('weak');
        return 'La contraseña es débil';
    } else if (strength == 2) {
        $('#result').removeClass();
        $('#passwordType').addClass('good');
        return 'La contraseña es buena';
    } else {
        $('#result').removeClass();
        $('#passwordType').addClass('strong');
        return 'La contraseña es fuerte';
    }
};

