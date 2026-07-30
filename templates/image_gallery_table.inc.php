<div>
    <?php if (isset($imageArray) && !empty($imageArray)): ?>
        <div class="row tz-gallery">
            <?php foreach($imageArray as $image): ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <?php if (file_exists($image->get_path())): ?>
                <a class="lightbox d-block" href="<?= $image->get_url(); ?>" data-title="<?= h($image->get_title()); ?>" 
                   data-description="<?= h($image->get_description()); ?>" data-author="<?= $image->get_author_id(); ?>">
                    <div class="card" style="overflow:hidden;">
                        <img src="<?= $image->get_url(); ?>" class="card-img-top" alt="<?= h($image->get_title()); ?>" 
                             style="height:200px;object-fit:cover;transition:transform 0.3s ease;">
                        <div class="card-body py-2 px-3">
                            <small class="font-weight-bold text-truncate d-block"><?= h($image->get_title()); ?></small>
                        </div>
                    </div>
                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (isset($imageArray) && empty($imageArray)): ?>
        <div class="text-center py-5">
            <i class="fa fa-image fa-3x text-muted mb-3"></i>
            <p class="text-muted">No hay ninguna imagen publicada todavia.</p>
        </div>
    <?php else: ?>
        <div class="alert alert-danger text-center m-0">Error inesperado.</div>
    <?php endif; ?>
</div>
