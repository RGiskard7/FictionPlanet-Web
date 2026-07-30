<?php
$pageTitle = $data['pageTitle'];
$post = $data['post'];
$author = $data['author'];
$attachedFiles = $data['attachedFiles'];
$postStatus = $data['postStatus'];

include TEMPLATES_PATH . 'head.inc.php';
?>

<div id="main">
    <div id="postViewContainer" class="container">
            <div class="card">
            <div class="card-body p-4">
                <button class="btn btn-sm btn-light mb-3 gmd-1" onclick="history.back()"><i class="fa fa-arrow-left mr-1"></i>Volver</button>
                
                <h1 class="font-weight-bold mb-2"><?= h($post->get_title()); ?></h1>
                
                <div class="d-flex align-items-center text-muted small mb-3">
                    <img src="<?= IMAGES_URL . "f2.png"; ?>" class="rounded-circle mr-2" width="28" height="28" alt="" style="border:1px solid #E4E6EB;">
                    <a href="<?= PROFILE_SEO_URL . "/" . h($author->get_user_name()); ?>" class="font-weight-bold mr-2"><?= h($author->get_user_name()); ?></a>
                    <span class="mr-2"><?= date('d/m/Y H:i', strtotime($post->get_date_creation())); ?></span>
                    <?php if ($post->get_date_creation() !== $post->get_date_last_update()): ?>
                    <span class="mr-2">&middot; Actualizado <?= date('d/m/Y H:i', strtotime($post->get_date_last_update())); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($postStatus)): ?>
                    <span class="badge badge-warning"><?= h($postStatus); ?></span>
                    <?php endif; ?>
                </div>
                
                <hr>

                <div class="post-content" style="font-size:1.05rem;line-height:1.7;">
                    <?= html_entity_decode($post->get_introduction(), ENT_QUOTES, "UTF-8"); ?>
                    <?= html_entity_decode($post->get_content(), ENT_QUOTES, "UTF-8"); ?>
                </div>
                
                <?php if (isset($attachedFiles) && !empty($attachedFiles)): ?>
                <hr class="mt-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fa fa-paperclip mr-2"></i>Archivos adjuntos</h6>
                    </div>
                    <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre del archivo</th>
                                                <th class="text-center">Tamaño</th>
                                                <th class="text-center">Descargar</th>
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
                                                
                                                <td><?= $icon . "&nbsp;&nbsp;&nbsp;"; ?><a id="viewFile" title="Visualizar archivo" href="<?= BASE_URL . UPLOAD_POSTS_DIR 
                                                        . $post->get_id() . '/' . urlencode($attachedFile); ?>"target="_blank"><?= h($fileName); ?></a></td>

                                                <?php $size = round(filesize(ROOT_DIRECTORY . UPLOAD_POSTS_DIR . $post->get_id() . '/' . $attachedFile) / 1024, 3); ?>

                                                <td class="text-center"><?= $size . " KB"; ?></td>
                                                <td class="text-center"><a title="Descargar archivo" href="<?= BASE_URL . UPLOAD_POSTS_DIR . $post->get_id() . 
                                                        '/' . urlencode($attachedFile); ?>" download="<?= h($attachedFile); ?>" style="color: blue; font-size:18px;">
                                                        <i class="fa fa-download" aria-hidden="true"></i></a></td>
                                            </tr>
                                        </tbody>
                                        <?php $num++; ?>
                                        <?php endforeach; ?>
                                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>
    </div>
</div>

<?php
include TEMPLATES_PATH . 'scripts.inc.php';
include TEMPLATES_PATH . "footer.inc.php";
?>