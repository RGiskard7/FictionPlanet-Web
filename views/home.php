<?php
$pageTitle = $data['pageTitle'];
$numVisiblePosts = $data['numVisiblePosts'];
$postsPerPage = $data['postsPerPage'];
$maxLinksPager = $data['maxLinksPager'];
$currentPage = $data['currentPage'];
$postArray = $data['postArray'];

include TEMPLATES_PATH . 'head.inc.php';

include TEMPLATES_PATH . 'modals/calendar_modal.inc.php';
if (Session::is_started() && $_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['w']) {
    include TEMPLATES_PATH . 'modals/new_event_calendar_modal.inc.php';
}

$carouselSlides = [
    ['img' => 'image_carousel_14.jpg', 'quote' => '"Cualquier tecnologia suficientemente avanzada es indistinguible de la magia."', 'author' => 'Arthur C. Clarke'],
    ['img' => 'image_carousel_15.jpg', 'quote' => '"No llores porque algo termina, sonrie porque sucedio."', 'author' => 'Dr. Seuss'],
    ['img' => 'image_carousel_16.jpg', 'quote' => '"El espacio, la ultima frontera..."', 'author' => 'Star Trek'],
];
?>

<script>
    document.getElementById("homeLink").classList.add("active-nav");
</script>

<div id="main">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-3 d-none d-lg-block">
                <?php if (Session::is_started()): ?>
                <a href="<?= PROFILE_SEO_URL . "/" . h($_SESSION['loggedInUser']->get_user_name()); ?>" class="text-decoration-none">
                <div class="card mb-3" style="border-radius:8px;overflow:hidden;">
                    <div style="height:56px;background:linear-gradient(135deg,#1877F2,#42B72A);"></div>
                    <div class="card-body text-center pt-0" style="margin-top:-28px;">
                        <?php $av = $_SESSION['loggedInUser']->get_avatar(); ?>
                        <img src="<?= $av ? UPLOAD_IMG_GALLERY_URL . 'avatars/' . $av : IMAGES_URL . 'avatar_2x.png'; ?>" class="rounded-circle" width="56" height="56" alt="" style="border:3px solid #fff;object-fit:cover;">
                        <h6 class="mt-2 mb-0 font-weight-bold text-dark"><?= h($_SESSION['loggedInUser']->get_user_name()); ?></h6>
                        <small class="text-muted"><?= h($_SESSION['role']->get_sp_name()); ?></small>
                    </div>
                </div>
                </a>

                <div class="card mb-3">
                    <div class="list-group list-group-flush">
                        <?php if ($_SESSION['permissions'][MDL_POSTS]['r']): ?>
                        <?php if ($_SESSION['permissions'][MDL_POSTS]['w']): ?>
                        <a href="<?= CREATE_POST_SEO_URL; ?>" class="list-group-item list-group-item-action border-0 d-flex align-items-center"><i class="fa fa-plus-circle fa-fw mr-3" style="color:#1877F2;"></i>Crear publicacion</a>
                        <?php endif; ?>
                        <a href="<?= POSTS_SEO_URL; ?>" class="list-group-item list-group-item-action border-0 d-flex align-items-center"><i class="fa fa-file-text fa-fw mr-3" style="color:#1877F2;"></i>Publicaciones</a>
                        <?php if ($_SESSION['permissions'][MDL_USERS]['r']): ?>
                        <a href="<?= USERS_SEO_URL; ?>" class="list-group-item list-group-item-action border-0 d-flex align-items-center"><i class="fa fa-users fa-fw mr-3" style="color:#1877F2;"></i>Usuarios</a>
                        <?php endif; ?>
                        <?php if ($_SESSION['permissions'][MDL_ROLES]['r']): ?>
                        <a href="<?= ROLES_SEO_URL; ?>" class="list-group-item list-group-item-action border-0 d-flex align-items-center"><i class="fa fa-id-card-o fa-fw mr-3" style="color:#1877F2;"></i>Roles</a>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="list-group list-group-flush">
                        <a href="<?= LOGIN_SEO_URL . '/logout'; ?>" data-confirm="Desea cerrar sesion?" class="list-group-item list-group-item-action border-0 d-flex align-items-center"><i class="fa fa-sign-out fa-fw mr-3 text-danger"></i>Cerrar sesion</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <?php if (!Session::is_started()): ?><div class="col-lg-10 offset-lg-1"><div class="row"><?php endif; ?>

            <div class="<?= Session::is_started() ? 'col-lg-6' : 'col-lg-7'; ?> col-md-8">

                <div id="carouselIndicators" class="carousel slide mb-3" data-ride="carousel" style="border-radius:8px;overflow:hidden;box-shadow:0 1px 2px rgba(0,0,0,0.08);">
                    <ol class="carousel-indicators">
                        <?php foreach($carouselSlides as $i => $s): ?>
                        <li data-target="#carouselIndicators" data-slide-to="<?= $i; ?>" <?= $i===0?'class="active"':''; ?>></li>
                        <?php endforeach; ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php foreach($carouselSlides as $i => $s): ?>
                        <div class="carousel-item <?= $i===0?'active':''; ?>">
                            <img class="d-block w-100" src="<?= IMAGES_URL . $s['img']; ?>" alt="Slide" style="height:220px;object-fit:cover;">
                            <div class="carousel-caption d-none d-md-block" style="background:rgba(0,0,0,0.5);border-radius:8px;padding:0.75rem;bottom:15px;left:8%;right:8%;">
                                <p class="mb-1 font-italic small"><?= $s['quote']; ?></p>
                                <small><?= $s['author']; ?></small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselIndicators" data-slide="prev"><span class="carousel-control-prev-icon"></span></a>
                    <a class="carousel-control-next" href="#carouselIndicators" data-slide="next"><span class="carousel-control-next-icon"></span></a>
                </div>

                <div class="card mb-3">
                    <div class="card-body p-2">
                        <form id="formSearchPost" role="form" method="get" action="<?= SEARCH_POST_SEO_URL ?>">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-0"><i class="fa fa-search text-muted"></i></span>
                            </div>
                            <input type="search" id="search" name="search" class="form-control border-0" placeholder="Buscar publicaciones..." style="background:transparent;">
                            <div class="input-group-append">
                                <select class="custom-select border-0 bg-transparent text-muted" id="searchBySelect" name="searchBySelect" style="max-width:100px;box-shadow:none;">
                                    <option value="all">Todo</option>
                                    <option value="title">Titulo</option>
                                    <option value="author">Autor</option>
                                    <option value="introduction">Intro</option>
                                    <option value="content">Contenido</option>
                                    <option value="date">Fecha</option>
                                </select>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

                <?php
                $urlPager = "/home/";
                $pager = new Pager($urlPager, $numVisiblePosts, $postsPerPage, $maxLinksPager, $currentPage);
                $htmlPager = $pager->get_data_pager();
                include_once TEMPLATES_PATH . "post_list.inc.php";
                ?>
                
                <?php if ($htmlPager != ""): ?>
                <div class="text-center mt-3"><?= $htmlPager; ?></div>
                <?php endif; ?>
            </div>

            <div class="<?= Session::is_started() ? 'col-lg-3' : 'col-lg-4'; ?> col-md-4">
                <div class="card mb-3">
                    <div class="card-header"><strong><i class="fa fa-calendar mr-1"></i>Calendario</strong></div>
                    <div class="card-body p-2">
                        <div id="calendarMini"></div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header"><strong>Proximos eventos</strong></div>
                    <div class="card-body p-2">
                        <div id="calendarDiary"></div>
                    </div>
                </div>
            </div>

            <?php if (!Session::is_started()): ?></div></div><?php endif; ?>

        </div>
    </div>
</div>

<?php
include TEMPLATES_PATH . 'scripts.inc.php';
include TEMPLATES_PATH . "footer.inc.php";
?>
