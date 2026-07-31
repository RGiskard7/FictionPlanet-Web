$(document).ready(function () {
    baguetteBox.run('.tz-gallery', {
        animation: 'fadeIn', // fadeIn or slideIn
        captions: createCaption
    }); // Para visualizar las imagenes en la galeria

    $(document).on('click', '#uploadNewImageBtn', function () {
        var idRole = $(this).attr('data-idrole');

        $('#uploadNewImageModal').modal('show');
    });

    $(document).on("click", ".browse", function () {
        var file = $(this)
                .parent()
                .parent()
                .parent()
                .find(".file_2");
        file.trigger("click");
    });
    
    /*$(document).on("click", ".lightbox", function () {
        var title = $(this).attr('data-title');
        var description = $(this).attr('data-description');
        var author = $(this).attr('data-author');
        
        imageCaption(title, description, author);
    });*/

    $('#imageFile').change(function (e) {
        var fileName = e.target.files[0].name;
        $("#imageFileName").val(fileName);

        var reader = new FileReader();
        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });
    
    $("#image-form").on("submit", function (event) {
        event.preventDefault(); // Evitamos que salte el enlace.
          
        if ($('#imageFile')[0].files.length !== 0) {
            if ($("#imageTitle").val().length > 0) {
                if ($("#imageTitle").val().length > 5) {
                    $("#msgNewImage").html('<div class="alert alert-info"><i class="fa fa-spin fa-spinner"></i> Espere por favor...!</div>');
                    
                    var imageFile = $('#imageFile')[0].files[0];
                    var typeImageFile = imageFile.type;
                    var match= ["image/jpeg", "image/png", "image/jpg"];
                    
                    /*if((typeImageFile == match[0]) || (typeImageFile == match[1])){*/
                    if (match.includes(typeImageFile)) {
                        var formData = new FormData(this);
                        formData.append("submitUploadNewImage", 1);

                        $.ajax({
                            url: "/image_gallery/upload",
                            type: "POST",
                            data: formData,
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                if (data === 1 || parseInt(data) === 1) {
                                    $('#uploadNewImageModal').modal('hide');
                                    swal({
                                        title: "Correcto",
                                        text: "Se ha subido la imagen correctamente.",
                                        icon: "success"
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else if (data === 2 || parseInt(data) === 2) {
                                    $("#msgNewImage").html(
                                            '<div class="alert alert-info"><i class="fa fa-exclamation-triangle"></i> La extensión no es buena, solo prueba con <strong>GIF, JPG, PNG, JPEG</strong>.</div>'
                                            );
                                } else if (data === 3 || parseInt(data) === 3) {
                                    $("#msgNewImage").html(
                                            '<div class="alert alert-info"><i class="fa fa-exclamation-triangle"></i> Debe seleccionar una imagen para subirla</strong>.</div>'
                                            );
                                } else if (data === 4 || parseInt(data) === 4) {
                                    $("#msgNewImage").html(
                                            '<div class="alert alert-info"><i class="fa fa-exclamation-triangle"></i> Debe ponerse un título a la imagen</strong>.</div>'
                                            );
                                }
                            },
                            error: function () {
                                $("#msgNewImage")
                                        .html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Hay algo mal..</div>');
                            }
                        });
                    } else {
                        $("#msgNewImage").html(
                                '<div class="alert alert-info"><i class="fa fa-exclamation-triangle"></i> La extensión no es válida, prueba con <strong>JPG, PNG, JPEG</strong>.</div>');
                    }
                } else {
                    $('#imageTitle').addClass('is-invalid');
                    $('#feddbackImageTitle').html('El titulo de la imagen debe tener 5 caracteres como mínimo.');
                }
            } else {
                $('#imageTitle').addClass('is-invalid');
                $('#feddbackImageTitle').html('Debe ponerse un título a la imagen.');
            }
            
        } else {
            $("#msgNewImage")
                    .html('<div class="alert alert-info"><i class="fa fa-exclamation-triangle"></i> Debe seleccionar una imagen para subirla</strong>.</div>');
        }
        // return false; // Para no cerrar el formulario 
    });
    
    $(document).on('hidden.bs.modal', '#uploadNewImageModal', function() {
        $('#imageTitle').html('');
        $('#imageTitle').removeClass('is-valid is-invalid');
        $('#imageDescription').html('');
        $('#feddbackImageTitle').html('');
        $('#msgNewImage').html('');
        $("#imageFileName").attr("placeholder", "Cargar imagen");
        $('#preview').attr('src','static/images/80x80.png');
        $(this).find('form').trigger('reset');
    });

    $(document).on('click', '.deleteImageBtn', function() {
        var id = $(this).data('id');
        var title = $(this).data('title');
        swal({
            title: "Eliminar imagen?",
            text: "\"" + title + "\" se eliminara permanentemente.",
            icon: "warning",
            buttons: { cancel: "Cancelar", ok: { text: "Eliminar", className: "btn-danger" } },
            dangerMode: true,
        }).then(function(willDelete) {
            if (willDelete) {
                $.ajax({
                    url: BASE_URL + 'image_gallery/delete',
                    method: 'POST',
                    data: { action: 'deleteImage', idImage: id },
                    success: function(r) {
                        if (r.success) { location.reload(); }
                        else { swal("Error", "No se pudo eliminar.", "error"); }
                    },
                    error: function() { swal("Error", "Error de conexion.", "error"); }
                });
            }
        });
    });

    $(document).on('click', '.editImageBtn', function() {
        var id = $(this).data('id');
        var currentTitle = $(this).data('title');
        swal({
            title: "Editar imagen",
            content: {
                element: "input",
                attributes: { placeholder: "Nuevo titulo...", value: currentTitle, type: "text" }
            },
            buttons: { cancel: "Cancelar", ok: { text: "Guardar", className: "btn-primary" } },
        }).then(function(newTitle) {
            if (newTitle) {
                $.ajax({
                    url: BASE_URL + 'image_gallery/update',
                    method: 'POST',
                    data: { action: 'updateImage', idImage: id, title: newTitle, visible: 1 },
                    success: function(r) {
                        if (r.success) { location.reload(); }
                        else { swal("Error", "No se pudo actualizar.", "error"); }
                    },
                    error: function() { swal("Error", "Error de conexion.", "error"); }
                });
            }
        });
    });
    
    function createCaption(element) {
        return '<button id="imageInfo" class="btn btn-success"><span>Más información</span></button>';
    }
    
    function imageCaption(title, description, author) {
        return '<div class="card"><p>' + title + ' ' + author + '</p></div>';
    }
});
