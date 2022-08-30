<div id="uploadNewImageModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="uploadNewImageModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva imagen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="msgNewImage"></div>
                <form action="<?= APP_URL . 'imageGalleryController.php'; ?>" method="post" class="form-horizontal" 
                      id="image-form" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <input class="form-control" id="imageTitle" name="imageTitle" placeholder="Título (255 carácteres max.)" type="text">
                        <div id="feddbackImageTitle" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <!--<textarea class="form-control" name="imageDescription" id="imageDescription" placeholder="Descripción (opcional)"></textarea>-->
                    </div>
                    <div class="form-group">
                        <input type="file" id="imageFile" name="imageFile" class="file_2">
                        <div class="input-group my-3">
                            <input type="text" class="form-control" disabled placeholder="Cargar imagen" id="imageFileName">
                            <div class="input-group-append">
                                <button type="button" class="browse btn btn-primary">Explorar...</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <img src='<?= IMAGES_URL . "80x80.png"; ?>' id="preview" class="img-thumbnail">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger gmd-1" type="button" data-dismiss="modal">Salir</button>
                <button type="submit" id="submitUploadNewImage" name="submitUploadNewImage" class="btn btn-success gmd-1" form="image-form">Subir imagen</button>
            </div>
        </div>
    </div>
</div>                    



