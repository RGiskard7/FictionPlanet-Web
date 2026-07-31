<div>
    <?php if (isset($imageArray) && !empty($imageArray)): ?>
        <div class="row tz-gallery">
            <?php foreach($imageArray as $image): ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <?php if (file_exists($image->get_path())): ?>
                <div class="card" style="overflow:hidden;">
                    <a class="lightbox d-block" href="<?= $image->get_url(); ?>" data-title="<?= h($image->get_title()); ?>">
                        <img src="<?= $image->get_url(); ?>" class="card-img-top" alt="" style="height:180px;object-fit:cover;">
                    </a>
                    <div class="card-body py-2 px-3">
                        <small class="font-weight-bold text-truncate d-block"><?= h($image->get_title()); ?></small>
                        <?php if (Session::is_started() && $image->get_author_id() == $_SESSION['idUser']): ?>
                        <div class="d-flex mt-1">
                            <?php if (($_SESSION['permissions'][MDL_IMAGES]['u'] ?? 0)): ?>
                            <button class="btn btn-sm btn-outline-secondary editImageBtn" data-id="<?= $image->get_id(); ?>" data-title="<?= h($image->get_title()); ?>" title="Editar" style="font-size:0.7rem;padding:0.1rem 0.4rem;"><i class="fa fa-pencil"></i></button>
                            <?php endif; ?>
                            <?php if (($_SESSION['permissions'][MDL_IMAGES]['d'] ?? 0)): ?>
                            <button class="btn btn-sm btn-outline-danger deleteImageBtn ml-1" data-id="<?= $image->get_id(); ?>" data-title="<?= h($image->get_title()); ?>" title="Eliminar" style="font-size:0.7rem;padding:0.1rem 0.4rem;"><i class="fa fa-trash"></i></button>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
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
