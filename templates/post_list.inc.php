<?php $index = 1; ?>

<div>
    <?php if (isset($postArray) && !empty($postArray)): ?>
        <?php foreach($postArray as $post): ?>
        <?php
        Connection::open_connection();
        $author = UserDAO::get_user_by_id(Connection::get_connection(), $post->get_author_id());
        Connection::close_connection();
        ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <?php $authorAv = $author->get_avatar(); ?>
                    <img src="<?= $authorAv ? UPLOAD_IMG_GALLERY_URL . 'avatars/' . $authorAv : IMAGES_URL . 'avatar_2x.png'; ?>" class="rounded-circle mr-2" width="40" height="40" alt="" style="border:2px solid #E4E6EB;padding:1px;object-fit:cover;">
                    <div>
                        <a href="<?= PROFILE_SEO_URL . "/" . h($author->get_user_name()); ?>" class="font-weight-bold text-dark"><?= h($author->get_user_name()); ?></a>
                        <div class="text-muted" style="font-size:0.8rem;">
                            <?= date('d/m/Y H:i', strtotime($post->get_date_creation())); ?>
                            <?php if($post->get_date_last_update() !== $post->get_date_creation()): ?>
                            &middot; <i class="fa fa-clock-o"></i> Actualizado
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <a class="titlePostLink" href="<?= POST_SEO_URL . '/' . $post->get_url(); ?>">
                    <h5 class="font-weight-bold mb-2"><?= h($post->get_title()); ?></h5>
                </a>

                <div class="mb-3" style="font-size:0.9375rem;line-height:1.5;">
                    <?php 
                    $intro = strip_tags(html_entity_decode($post->get_introduction(), ENT_QUOTES, "UTF-8"), "<p><br><strong><em>");
                    $content = Utilities::summarize_text(strip_tags(html_entity_decode($post->get_content(), ENT_QUOTES, "UTF-8"), "<p><br>"), 800);
                    echo $intro;
                    if ($content !== $intro) echo "<p class='text-muted'>" . $content . "</p>";
                    ?>
                </div>

                <a id="keepReading" href="<?= POST_SEO_URL . '/' . $post->get_url(); ?>">
                    <button class="btn btn-sm btn-light gmd-1">Seguir leyendo</button>
                </a>
            </div>
        </div>
        <?php $index++; ?>
        <?php endforeach; ?>
    <?php elseif (isset($postArray) && empty($postArray)): ?>
        <div class="alert alert-warning text-center m-0">No se ha encontrado ninguna publicacion</div>
    <?php else: ?>
        <div class="alert alert-danger text-center m-0">Error inesperado</div>
    <?php endif; ?>
</div>
