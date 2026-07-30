<?php
$pageTitle = $data['pageTitle'];
$numVisibleImages = $data['numVisibleImages'];
$imagesPerPage = $data['imagesPerPage'];
$maxLinksPager = $data['maxLinksPager'];
$currentPage = $data['currentPage'];
$imageArray = $data['imageArray'];

include TEMPLATES_PATH . 'head.inc.php';

include TEMPLATES_PATH . 'modals/upload_new_image_modal.inc.php';
?>

<script>
    document.getElementById("galleryLink").classList.add("active-nav");
</script>

<div id="main">
    <div class="container">
        <div id="galleryCard" class="card gmd-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Galeria de imagenes</h5>
                <small class="text-muted"><?= $numVisibleImages; ?> imagenes</small>
            </div>
            <div class="card-body p-4">
                <?php if (Session::is_started() && ($_SESSION['permissions'][MDL_IMAGES]['w'] ?? 0)): ?>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <button id="uploadNewImageBtn" name="uploadNewImageBtn" type="button" class="btn btn-primary gmd-1">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Subir nueva imagen
                        </button>
                    </div>   
                </div>
                <?php endif; ?>
                <?php
                $urlPager = "/image_gallery/";
                $pager = new Pager($urlPager, $numVisibleImages, $imagesPerPage, $maxLinksPager, $currentPage); // PAGINATOR
                $htmlPager = $pager->get_data_pager();
                
                include_once TEMPLATES_PATH . "image_gallery_table.inc.php";
                ?>
            </div>
            <?php if ($htmlPager != ""): ?>
            <div class='card-footer text-muted border-top pt-4'>
            <?= $htmlPager; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include TEMPLATES_PATH . 'scripts.inc.php';
include TEMPLATES_PATH . "footer.inc.php";
?>

