<?php
$index = 1;
?>

<div>
    <?php if (isset($postArray)): ?>                 
        <?php if (!empty($postArray)): ?>
            <?php foreach($postArray as $post): ?>
                <div>
                    <a class="titlePostLink" href="<?= POST_SEO_URL . '/' . $post->get_url(); ?>"><h4 class='card-title'><?= h($post->get_title()); ?></h4></a>
                </div>

                <div class="mb-4">
                    <?php 
                    $introduction = "<p>" . html_entity_decode($post->get_introduction(), ENT_QUOTES, "UTF-8") . "</p>";   
                    $introduction = strip_tags($introduction, "<p><br><strong><em><h4><h5><h6>");

                    $content = "<p>" . html_entity_decode($post->get_content(), ENT_QUOTES, "UTF-8") . "</p>";
                    $content = strip_tags($content, "<p><br>");
                    $content = Utilities::summarize_text($content, 1000);

                    echo $introduction;
                    echo $content;
                    ?>
                </div>

                <div class="mb-4">
                    <a id="keepReading" href="<?= POST_SEO_URL . '/' . $post->get_url(); ?>">
                        <button class="btn btn-sm btn-primary gmd-1">Seguir leyendo</button>
                    </a>
                </div>

                <?php
                Connection::open_connection();
                $author = UserDAO::get_user_by_id(Connection::get_connection(), $post->get_author_id());
                Connection::close_connection();
                ?>

                <div class="mb-2">
                    <i class='fa fa-user'></i> Publicado por 
                    <a href="<?= PROFILE_SEO_URL . "/" . h($author->get_user_name()); ?>"><?= h($author->get_user_name()); ?></a>
                    &nbsp;|&nbsp;
                    <i class='fa fa-calendar'></i> <?= date('d-m-Y H:i:s', strtotime($post->get_date_creation())); ?>
                    <?php if($post->get_date_last_update() !== $post->get_date_creation()): ?>
                    &nbsp;|&nbsp;
                    <i class='fa fa-clock-o'></i> <?= date('d-m-Y H:i:s', strtotime($post->get_date_last_update())); ?>
                    <?php endif; ?>
                </div>

                <?php 
                if ($index < count($postArray)) {
                    echo "<hr class='featurette-divider mt-4'>";
                }

                $index++;
                ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class='alert alert-warning m-0 text-center border' role='alert'>
                <!--No hay ningún artículo publicado todavía.-->
                No se ha encontrado ninguna publicación
            </div>      
        <?php endif; ?>
    <?php else: ?>
        <div class='alert alert-danger m-0 text-center border' role='alert'>
            Error inesperado.
        </div>
    <?php endif; ?> 
</div>