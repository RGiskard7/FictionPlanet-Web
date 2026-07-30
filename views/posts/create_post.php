<?php
$pageTitle = $data['pageTitle'];

include TEMPLATES_PATH . 'head.inc.php';
?>

<div id="main">
    <div class="container">
        <div id="createPostCard" class="card gmd-0 bg-white">
            <div class="card-header">
                <div class="row text-center">
                    <div class="col-md-12 text-center">
                        <a href='<?= CREATE_POST_SEO_URL . "?cancelNewPost=1"; ?>'>
                            <button class="btn btn-sm btn-outline-secondary float-left mt-2 mr-2 mb-2 gmd-1"><i class="icon fa fa-arrow-left"></i></button>
                        </a>
                        <h3 class="mr-5">Crear publicación</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="formNewPost" rol="form" method="post" action="<?= POSTS_SEO_URL . '/submit_new_post' ?>" name="formNewPost" enctype="multipart/form-data">
                    <?= Session::csrf_input(); ?>
                    <?php
                    if (isset($data['validator'])) {
                        $validator = $data['validator'];
                        include_once TEMPLATES_PATH . "create_post_validate.inc.php";
                    } else {
                        include_once TEMPLATES_PATH . "create_post_empty.inc.php";
                    }
                    ?>
                                        
                    <div id="viewAttachedFiles" class="mb-4">
                        <?php include TEMPLATES_PATH . 'update_attached_files.inc.php'; ?>
                    </div>
                    
                    <div class="card form-group">
                        <div class="card-header">
                            <h5><i class="fa fa-paperclip" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Adjuntar archivos&nbsp;&nbsp;<small><em>(Maximo 5 MB por archivo)</em></small></h5>
                        </div>
                        <div class="card-body p-4">
                            <input type="file" id="uploadFile" name="uploadFile[]" multiple="" data-userid="<?= $_SESSION["idUser"]; ?>">
                        </div>
                    </div>
                    <i class="fa fa-exclamation-triangle text-warning mr-1"></i><small>No olvides subir los archivos adjuntos antes de guardar.</small>
                <br>
                <i class="fa fa-exclamation-triangle text-warning mr-1"></i><small>Marca la casilla <strong>Publicacion visible</strong> si quieres que se muestre.</small>
                    </br>
                    </br>
                    <div class="text-center">
                        <button id="submitCancelNewPost" class="btn btn-danger gmd-1" type="submit" name="submitCancelNewPost">Cancelar</button>
                        <button class="btn btn-success gmd-1" type="submit" name="submitNewPost">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.onload = function() {
        CKEDITOR.replace('postContent', {
            height: 500,
            filebrowserUploadUrl: "/posts/upload_editor_image",
            filebrowserUploadMethod: 'form'
        });

        var basic = [
            ['Styles', 'Format', '-', 'Bold', 'Italic', 'Strike', '-', 'NumberedList', 
                'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'Link', 'Unlink', '-', 'About']
        ];

        CKEDITOR.replace('postIntroduction', {
            height: 100,
            toolbar: basic
        });
        //Refrescar la tabla de archivos adjuntos por si la creacion del post
        //se quedo a medias por no pasar el validador
        document.getElementById("syncAttachedFilesBtn").click();
    }
</script>

<?php
include TEMPLATES_PATH . 'scripts.inc.php';
include TEMPLATES_PATH . "footer.inc.php";
?>
