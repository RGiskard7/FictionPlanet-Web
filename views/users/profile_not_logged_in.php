<?php
$pageTitle = $data['pageTitle'];
$numPosts = $data['numPosts'];
$numVisiblePosts = $data['numVisiblePosts'];
$numNotVisiblePosts = $data['numNotVisiblePosts'];
$postsPerPage = $data['postsPerPage'];
$maxLinksPager = $data['maxLinksPager'];
$currentPagePost = $data['currentPagePost'];
$user = $data['user'];
$userRole = $data['userRole'];
$postArray = $data['postArray']; 

$numVisibleImages = $data['numVisibleImages'];
$imagesPerPage = $data['imagesPerPage'];
$currentPageImage = $data['currentPageImage'];
$imageArray = $data['imageArray'];

include TEMPLATES_PATH . 'head.inc.php';
?>

<div id="main">
    <div class="container">
        <div id="personalPageCard" class="card gmd-0">            
            <div class="card-body pl-4 pr-4 pb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-2 text-center">
                                <img src="<?= IMAGES_URL . "avatar_2x.png"; ?>" class="img-thumbnail rounded mb-4" alt="avatar">
                            </div>
                            <div class="col-md-8">
                                <h2 id="profileUsername"><?= $user->get_user_name(); ?></h2>
                                <i class="fa fa-calendar mr-2"></i><strong>Miembro registrado desde: </strong><?= date('d-m-Y H:i:s', strtotime($user->get_reg_date()));?></br>
                                <i class="fa fa-clock-o mr-2"></i><strong>Último acceso al sitio: </strong><?= (!is_null($user->get_last_access_date())) ? date('d-m-Y H:i:s', strtotime($user->get_last_access_date())) : "Nunca"; ?></br>
                                
                                <?php if (Session::is_started() && $_SESSION['permissions'][MDL_PUBL_DATA]['r']): ?>
                                <span><strong><?= $numPosts; ?></strong>&nbsp;Publicaciones <small><em>(<?= $numVisiblePosts; ?>&nbsp;visibles, <?= $numNotVisiblePosts; ?>&nbsp;no visibles)</em></small></span></br>
                                <?php else: ?>
                                <span><strong><?= $numVisiblePosts; ?></strong>&nbsp;Publicaciones</span></br>
                                <?php endif; ?>
                                
                                <?php if (Session::is_started() && $_SESSION['permissions'][MDL_USERS]['r']): ?> 
                                <span class="badge badge-pill badge-secondary mt-2">
                                <?= $userRole->get_sp_name(); ?>
                                </span>
                                <span class="badge badge-pill badge-secondary mb-1">  
                                <?= ($user->is_active() == 1) ? "Activo" : "No activo"; ?>
                                </span>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class=" featurette-divider mt-2 mb-3 border">
                
                <div id="tabs" class="row project-tab">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs" id="myTab" role="tablist">
                                <?php if (Session::is_started() && $_SESSION['permissions'][MDL_PRSN_DATA]['r']): ?>
                                <a class="nav-item nav-link active" id="aboutMe-tab" data-toggle="tab" href="#aboutMe" role="tab" aria-controls="aboutMe" aria-selected="true">Acerca de</a>
                                <?php endif; ?>
                                <a class="nav-item nav-link <?= (!Session::is_started() || (Session::is_started() && !$_SESSION['permissions'][MDL_PRSN_DATA]['r'])) ? "active" : "" ?>" 
                                   id="content-tab" data-toggle="tab" href="#content" role="tab" aria-controls="content" aria-selected="false">Publicaciones</a>
                                <a class="nav-item nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="true">Imágenes</a>
                            </div>   
                        </nav>

                        <div class="tab-content mt-4" id="nav-tabContent">
                            <?php if (Session::is_started() && $_SESSION['permissions'][MDL_PRSN_DATA]['r']): ?>
                            <div class="tab-pane fade show active" id="aboutMe" role="tabpanel" aria-labelledby="aboutMe-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card bg-white border" style="border-radius: 10px;">
                                            <div class="card-header"><strong>Información persona</strong></div>
                                            <div class="card-body p-4">
                                                <label><b>Nombre:</b></label>&nbsp;&nbsp;&nbsp;<?php echo $user->get_first_name(); ?></br>
                                                <label><b>Apellidos:</b></label>&nbsp;&nbsp;&nbsp;<?php echo $user->get_last_name(); ?></br>
                                                <label><b>Email:</b></label>&nbsp;&nbsp;&nbsp;<?php echo $user->get_email(); ?></br>
                                                <label><b>Dirección:</b></label>&nbsp;&nbsp;&nbsp;<?php echo $user->get_address(); ?></br>
                                                <label><b>País:</b></label>&nbsp;&nbsp;&nbsp;<?php echo $user->get_country(); ?></br>
                                                <label><b>Número de teléfono:</b></label>&nbsp;&nbsp;&nbsp;<?php echo $user->get_phone_number(); ?></br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="tab-pane fade <?= (!Session::is_started() || (Session::is_started() && !$_SESSION['permissions'][MDL_PRSN_DATA]['r'])) ? "show active" : "" ?>" 
                                 id="content" role="tabpanel" aria-labelledby="content-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="postListCard" class="card bg-white border">
                                            <div class='card-body mr-2 ml-2'>
                                            <?php
                                            $urlPager = "/users/profile/" . $user->get_user_name() . "/posts/";
                                            $pager = new Pager($urlPager, $numVisiblePosts, $postsPerPage, $maxLinksPager, $currentPagePost); // PAGINATOR
                                            $htmlPager = $pager->get_data_pager();

                                            include TEMPLATES_PATH . 'post_list.inc.php';
                                            ?>
                                            </div>
                                        </div></br>
                                        <?php if ($htmlPager != "") echo $htmlPager; ?>
                                    </div>
                                </div>
                            </div>
                            <div class ="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                <div class="row">
                                    <div class="col-md-12">   
                                        <?php
                                        $urlPager = "/users/profile/" . $user->get_user_name() . "/image_gallery/";
                                        $pager = new Pager($urlPager, $numVisibleImages, $imagesPerPage, $maxLinksPager, $currentPageImage); // PAGINATOR
                                        $htmlPager = $pager->get_data_pager();

                                        include_once TEMPLATES_PATH . "image_gallery_table.inc.php";
                                        ?>                             
                                        <?php if ($htmlPager != "") echo $htmlPager; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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