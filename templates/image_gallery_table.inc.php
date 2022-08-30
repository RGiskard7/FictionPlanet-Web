<div>
    <?php if (isset($imageArray)): ?> <!--Eliminar y dejar solo empty-->
        <?php if (!empty($imageArray)): ?>
            <div id="tz-gallery" class="row tz-gallery">
                <?php foreach($imageArray as $image): ?>
                <div class="col-sm-6 col-md-3">
                    <?php if (file_exists($image->get_path())): ?>
                    <a class="lightbox" href="<?= $image->get_url(); ?>" data-title="<?= $image->get_title(); ?>" 
                       data-description="<?= $image->get_description(); ?>" data-author="<?= $image->get_author_id(); ?>">
                        <img src="<?= $image->get_url(); ?>" title="<?= $image->get_title(); ?>">
                    </a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class='alert alert-warning m-0 text-center border' role='alert'>
                No hay ninguna imagen publicada todavía.
            </div>      
        <?php endif; ?>
    <?php else: ?>
        <div class='alert alert-danger m-0 text-center border' role='alert'>
            Error inesperado.
        </div>
    <?php endif; ?>
</div>