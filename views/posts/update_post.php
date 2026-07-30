<?php
$pageTitle = $data['pageTitle'];
$post = $data['post'];
$attachedFiles = $data['attachedFiles'];
$url = $data['url'];

include TEMPLATES_PATH . 'head.inc.php';
?>

<div id="main">
    <div class="container-fluid">
        <div id="createPostCard" class="card gmd-0 bg-white">
            <div class="card-header">
                <div class="row text-center">
                    <div class="col-md-12">
                        <button id="submitCancelPostUpdate" class="btn btn-sm btn-outline-secondary float-left mt-2 mr-2 mb-2 gmd-1" type="submit" 
                                name="submitCancelPostUpdate" form="formUpdatePost"><i class="icon fa fa-arrow-left"></i></button>
                        <h3 class="mr-5">Actualizar publicación</h3>
                    </div>
                </div>
            </div>

            <div class="card-body">					
                <form id="formUpdatePost" rol="form" name="formUpdatePost" method="post" action="<?= POSTS_SEO_URL . '/submit_post_update' ?>" enctype="multipart/form-data">
                    <?= Session::csrf_input(); ?>
                    <input type="hidden" name="postID" class="form-control" value="<?= $post->get_id(); ?>">
                    <input type="hidden" name="postURL" class="form-control" value="<?= $post->get_url(); ?>">
                    <input type="hidden" name="oldPostTitle" class="form-control" value="<?= $post->get_title(); ?>">
                    <?php
                    if (isset($data['validator'])) {
                        $validator = $data['validator'];
                        include_once TEMPLATES_PATH . 'update_post_validate.inc.php';
                    } else {
                        include_once TEMPLATES_PATH . 'update_post_empty.inc.php';
                    }
                    ?>
                </form>
                
                <div id="viewAttachedFiles" class="mb-4">
                    <?php include TEMPLATES_PATH . 'update_attached_files.inc.php'; ?>
                </div>
                
                <div class="card form-group">
                    <div class="card-header">
                        <h5><i class="fa fa-paperclip" aria-hidden="true"></i>&nbsp&nbsp&nbspAdjuntar nuevos archivos&nbsp&nbsp<small><em>(Máximo 5 MB por archivo)</em></small></h5>
                    </div>
                    <div class="card-body p-4">
                        <input type="file" id="uploadFile" name="uploadFile[]" multiple="" data-userid="<?= $_SESSION['idUser']; ?>" form="formUpdatePost">
                    </div>
                </div>  

                <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: #ffcc00"></i>&nbsp;&nbsp;<strong>ATENCIÓN:</strong> No se olvide de subir los archivos adjuntos antes de publicar.
                </br>
                <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: #ffcc00"></i>&nbsp;&nbsp;<strong>ATENCIÓN:</strong> Si desea que la publicación sea visible después de actualizar, no 
                se olvide de marcar la casilla <strong><em>Publicación visible</em></strong>.
                <br>
                <br>
                <div class="text-center">
                    <button id="submitCancelPostUpdate" class="btn btn-danger gmd-1" type="submit" name="submitCancelPostUpdate" form="formUpdatePost">Cancelar</button>
                    <button id="submitPostUpdate" class="btn btn-success gmd-1" type="submit" name="submitPostUpdate" form="formUpdatePost">Actualizar</button>
                </div>
            </div>
        </div>
    </div>		
</div>

<script type="text/javascript">
    window.onload = function() {
        CKEDITOR.replace('postContent', {
            height: 500,
            filebrowserUploadUrl: '/posts/upload_editor_image',
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