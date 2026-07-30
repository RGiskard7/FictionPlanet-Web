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
        <div id="postCard" class="card gmd-2 bg-white border">
            <div class="card-header">
                <button class="btn btn-sm btn-outline-secondary mt-2 mr-2 ml-2 mb-2 gmd-1" onclick="history.back()"><i class="fa fa-arrow-left"></i></button>
            </div>
            <div class="card-body justify-content-center">
                <div class="row pl-2 pr-2">
                    <div class="col-md-12">
                        <h1 class="primary-heading">
                            <?= h($post->get_title()); ?>
                        </h1>
                        <span>
                        <hr class="featurette-divider mb-2">
                        <span>
                            <i class='fa fa-user'></i> Publicado por <a href="<?= PROFILE_SEO_URL . "/" . h($author->get_user_name()); ?>">
                            <?= h($author->get_user_name()); ?></a>
                            &nbsp;|&nbsp;
                            <i class="fa fa-calendar"></i> Creado en <?= date('d-m-Y H:i:s', strtotime($post->get_date_creation())); ?>
                            <?php if ($post->get_date_creation() !== $post->get_date_last_update()): ?>
                            &nbsp;|&nbsp; <i class="fa fa-clock-o"></i> Actualizado en <?= date('d-m-Y H:i:s', strtotime($post->get_date_last_update())); ?>
                            <?php endif; ?>
                            <?php if (!empty($postStatus)): ?>
                            <strong><em>&nbsp;&nbsp;(<?= h($postStatus); ?>)</em></strong>
                            <?php endif; ?>
                        </span>
                        <hr class="featurette-divider mt-2 mb-0">
                    </div>
                </div>
                
                <div class="row pl-2 pr-2">
                    <div class="col-md-12">
                        <p><?= html_entity_decode($post->get_introduction(), ENT_QUOTES, "UTF-8"); ?></p>
                        <p><?= html_entity_decode($post->get_content(), ENT_QUOTES, "UTF-8"); ?></p>
                    </div>
                </div>
                
                <?php if (isset($attachedFiles) && !empty($attachedFiles)): ?>
                <div class="row pt-0 pl-2 pr-2 pb-2">
                    <div class="col-md-12">
                        <hr class="featurette-divider mt-0 mb-4">
                        <div class="card" style="border-radius: 10px;"> 
                            <div class="card-header">
                                <h6><i class="fa fa-paperclip" aria-hidden="true"></i>&nbsp&nbsp&nbspArchivos adjuntos:</h6>
                            </div>
                            <div class="card-body p-4">
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