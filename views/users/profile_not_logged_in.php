<?php
$pageTitle = $data['pageTitle'];
$user = $data['user'];
$userRole = $data['userRole'];
$numPosts = $data['numPosts'];
$numVisiblePosts = $data['numVisiblePosts'];
$numNotVisiblePosts = $data['numNotVisiblePosts'];
$postsPerPage = $data['postsPerPage'];
$currentPagePost = $data['currentPagePost'];
$postArray = $data['postArray'];
$maxLinksPager = $data['maxLinksPager'];
$numVisibleImages = $data['numVisibleImages'];
$imagesPerPage = $data['imagesPerPage'];
$currentPageImage = $data['currentPageImage'];
$imageArray = $data['imageArray'];

include TEMPLATES_PATH . 'head.inc.php';
?>

<div id="main">
    <div class="container">
        <div class="card gmd-0">            
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-3 text-center mb-3 mb-md-0">
                        <?php $av = $user->get_avatar(); ?>
                        <img src="<?= $av ? UPLOAD_IMG_GALLERY_URL . 'avatars/' . $av : IMAGES_URL . 'avatar_2x.png'; ?>" class="rounded-circle" width="90" height="90" alt="" style="border:3px solid #E4E6EB;padding:3px;object-fit:cover;">
                    </div>
                    <div class="col-md-9">
                        <h2 class="font-weight-bold mb-1"><?= h($user->get_user_name()); ?></h2>
                        <div class="text-muted small mb-2">
                            <i class="fa fa-calendar mr-1"></i>Miembro desde <?= date('d/m/Y', strtotime($user->get_reg_date())); ?>
                            &nbsp;|&nbsp;
                            <i class="fa fa-clock-o mr-1"></i>Ultimo acceso <?= (!is_null($user->get_last_access_date())) ? date('d/m/Y', strtotime($user->get_last_access_date())) : "Nunca"; ?>
                        </div>
                        <?php if (Session::is_started() && $_SESSION['permissions'][MDL_PUBL_DATA]['r']): ?>
                        <span class="mr-3"><b><?= $numPosts; ?></b> publicaciones <small class="text-muted">(<?= $numVisiblePosts; ?> visibles)</small></span>
                        <?php else: ?>
                        <span class="mr-3"><b><?= $numVisiblePosts; ?></b> publicaciones</span>
                        <?php endif; ?>
                        <?php if (Session::is_started() && $_SESSION['permissions'][MDL_USERS]['r']): ?> 
                        <span class="badge mr-1" style="background:#E7F3FF;color:#1877F2;"><?= h($userRole->get_sp_name()); ?></span>
                        <span class="badge badge-pill <?= ($user->is_active() == 1) ? 'badge-success' : 'badge-danger'; ?>">
                            <?= ($user->is_active() == 1) ? "Activo" : "Inactivo"; ?>
                        </span>
                        <?php endif;?>
                    </div>
                </div>
                <hr class="mt-3 mb-0">
                <nav>
                    <div class="nav nav-tabs" role="tablist">
                        <a class="nav-item nav-link active" data-toggle="tab" href="#content">Publicaciones</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#images">Imagenes</a>
                    </div>   
                </nav>
                <div class="tab-content mt-4">
                    <div class="tab-pane fade show active" id="content">
                        <?php
                        $urlPager = "/users/profile/" . h($user->get_user_name()) . "/posts/";
                        $pager = new Pager($urlPager, $numVisiblePosts, $postsPerPage, $maxLinksPager, $currentPagePost);
                        $htmlPager = $pager->get_data_pager();
                        include TEMPLATES_PATH . 'post_list.inc.php';
                        if ($htmlPager != "") echo '<div class="text-center mt-3">' . $htmlPager . '</div>';
                        ?>
                    </div>
                    <div class="tab-pane fade" id="images">
                        <?php
                        $urlPager = "/users/profile/" . h($user->get_user_name()) . "/image_gallery/";
                        $pager = new Pager($urlPager, $numVisibleImages, $imagesPerPage, $maxLinksPager, $currentPageImage);
                        $htmlPager = $pager->get_data_pager();
                        include_once TEMPLATES_PATH . "image_gallery_table.inc.php";
                        if ($htmlPager != "") echo '<div class="text-center mt-3">' . $htmlPager . '</div>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include TEMPLATES_PATH . 'scripts.inc.php';
include TEMPLATES_PATH . "footer.inc.php";
?>
