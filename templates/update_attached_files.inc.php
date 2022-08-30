 <div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-10">
                <h6><i class="fa fa-paperclip" aria-hidden="true"></i>&nbsp&nbsp&nbspArchivos adjuntados <small><em>(Refrescar para visualizar las modificaciones)</small></em><h6>
            </div>
            <div class="col-md-2">
                <button type="button" id="syncAttachedFilesBtn" class="btn btn-default p-0 pull-right" title="Actualizar archivos">
                    <i class="fa fa-refresh" aria-hidden="true"></i>&nbsp&nbspRefrescar
                </button>
            </div>
        </div>
    </div>
    <?php if (isset($attachedFiles) && !empty($attachedFiles)): ?>
    <div class="card-body p-4">
        <div  class="table-responsive">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre del archivo</th>
                        <th class="text-center">Tamaño</th>
                        <th class="text-center">Descargar</th>
                        <th class="text-center">Eliminar</th>
                    </tr>
                </thead>
                <?php $num = 1; ?>
                <?php foreach ($attachedFiles as $attachedFile): ?>
                <tbody>
                    <tr>
                        <td scope="row"><?php echo $num;?></td>

                        <?php 
                            switch(pathinfo($attachedFile, PATHINFO_EXTENSION)):
                                case "pdf":
                                    $icon = '<i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #F40F02;"></i>';
                                    break;
                                case "jpg":
                                    $icon = '<i class="fa fa-file-image-o" aria-hidden="true" style="color: #3B83BD;"></i>';
                                    break;
                                case "png":
                                    $icon = '<i class="fa fa-file-image-o" aria-hidden="true" style="color: #3B83BD"></i>';
                                    break;
                                default:
                                    $icon = '<i class="fa fa-file" aria-hidden="true"></i>';
                                    break;
                            endswitch;
                        ?>

                        <?php if (strlen($attachedFile) >= 80) {
                            $fileName = mb_substr($attachedFile, 0, 80 + 1, "UTF-8") . "...";
                        } else {
                            $fileName = $attachedFile;
                        } ?> 

                        <td><?php echo $icon . "&nbsp&nbsp&nbsp"; ?><a id="viewFile" title="Visualizar archivo" href="<?php echo BASE_URL . 
                                    UPLOAD_POSTS_DIR . 'temp-' . $_SESSION["idUser"] . '/' . $attachedFile; ?>"target="_blank"><?php echo $fileName; ?></a></td>

                        <?php $size = round(filesize(ROOT_DIRECTORY . UPLOAD_POSTS_DIR . 'temp-' . $_SESSION["idUser"] . '/' . $attachedFile) / 1024, 3); ?>

                        <td class="text-center"><?php echo $size . " KB"; ?></td>
                        <td class="text-center"><a title="Descargar archivo" href="<?php echo BASE_URL . UPLOAD_POSTS_DIR . 'temp-' . $_SESSION["idUser"] . 
                                '/' . $attachedFile; ?>" download="<?php echo $attachedFile; ?>" style="color: blue; font-size:18px;">
                                <i class="fa fa-download" aria-hidden="true"></i></a></td>
                        <td class="text-center"><button type="button" id="removeFileBtn" class="btn btn-default p-0" title="Eliminar archivo" 
                                data-confirm="¿Eliminar el archivo?" data-namefile="<?php echo $attachedFile;?>">
                                <i class='fa fa-trash fa-lg' style='color:red' aria-hidden='true'></i></button></td>
                    </tr>
                </tbody>
                <?php $num++; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="card-body p-4">
        <div class="alert alert-secondary text-center" role="alert">
            <em>No hay archivos adjuntados a esta publicación</em>
        </div>
    </div>
    <?php endif; ?>
</div>