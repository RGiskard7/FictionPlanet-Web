<?php
$pageTitle = $data['pageTitle'];

$user = $data['user'];

$numPosts = $data['numPosts'];
$numVisiblePosts = $data['numVisiblePosts'];
$numNotVisiblePosts = $data['numNotVisiblePosts'];
$postsPerPage = $data['postsPerPage'];
$currentPagePost = $data['currentPagePost'];
$postArray = $data['postArray']; 


$maxLinksPager = $data['maxLinksPager'];

$numVisibleImages = $data['numVisibleImages'];
$imagesPerPage = $data['imagesPerPage'];
$currentPage = $data['currentPageImage'];
$imageArray = $data['imageArray'];

include TEMPLATES_PATH . 'head.inc.php';

include TEMPLATES_PATH . 'modals/edit_profile_modal.inc.php';
include TEMPLATES_PATH . 'modals/change_password_modal.inc.php';
include TEMPLATES_PATH . 'modals/upload_new_image_modal.inc.php';
?>

<div id="main">
    <div class="container">
        <div id="personalPageCard" class="card gmd-0">            
            <div class="card-body pl-4 pr-4 pb-4">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-12 text-center">
                        <img src="<?= IMAGES_URL . "avatar_2x.png"; ?>" class="img-thumbnail rounded mb-4" alt="avatar">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-10">
                        <h2 id="profileUsername"><?= h($user->get_user_name()); ?></h2>
                        <i class="fa fa-calendar mr-2"></i><strong>Miembro registrado desde: </strong><?= date('d-m-Y H:i:s', strtotime($user->get_reg_date()));?></br>
                        <i class="fa fa-clock-o mr-2"></i><strong>Último acceso al sitio: </strong><?= date('d-m-Y H:i:s', strtotime($user->get_last_access_date())); ?></br>

                        <span><b><?= $numPosts; ?></b>&nbsp;Publicaciones <small><em>(<?= $numVisiblePosts; ?>&nbsp;visibles, <?= $numNotVisiblePosts; ?>&nbsp;no visibles)</em></small></span></br>

                        <span class="badge badge-pill badge-secondary mt-2">
                        <?= h($_SESSION['role']->get_sp_name()); ?>
                        </span>

                        <span class="badge badge-pill badge-secondary mb-1">  
                        <?= ($user->is_active() == 1) ? "Activo" : "No activo"; ?>
                        </span>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="dropdown">
                            <button class="ml-auto btn btn-outline-secondary dropdown-toggle rounded-lg pull-right gmd-1" type="button" id="dropdownProfileConfiguration" 
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-cog fa-fw" aria-hidden="true"></i>
                                <span>...</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownProfileConfiguration">
                                <a id="editProfileBtn" class="dropdown-item" href="#">Editar perfil</a>
                                <a id="changePasswordBtn" class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal">Cambiar contraseña</a>
                                <a class="dropdown-item" href="#">Desactivar cuenta</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class=" featurette-divider mt-2 mb-3 border">
                
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div id="tabs" class="project-tab">
                            <nav>
                                <div class="nav nav-tabs" id="profileTabs" role="tablist">
                                    <a class="nav-item nav-link active" id="content-tab" data-toggle="tab" href="#content" role="tab" aria-controls="content" aria-selected="true">Publicaciones</a>
                                    <a class="nav-item nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="true">Imagenes</a>
                                    <a class="nav-item nav-link" id="contacts-tab" data-toggle="tab" href="#contacts" role="tab" aria-controls="contacts" aria-selected="true">Contactos</a>
                                    <a class="nav-item nav-link" id="aboutMe-tab" data-toggle="tab" href="#aboutMe" role="tab" aria-controls="aboutMe" aria-selected="true">Acerca de</a>
                                </div> 
                            </nav>
                            <div class="tab-content mt-4" id="nav-tabContent">
                                <div class="tab-pane fade" id="aboutMe" role="tabpanel" aria-labelledby="aboutMe-tab">
                                    <div class="card bg-white border" style="border-radius: 10px;">
                                        <div class="card-header"><strong>Información personal</strong></div>
                                        <div class="card-body p-4">
                                            <label><b>Nombre:</b></label>&nbsp;&nbsp;&nbsp;<?php echo h($user->get_first_name()); ?></br>
                                            <label><b>Apellidos:</b></label>&nbsp;&nbsp;&nbsp;<?php echo h($user->get_last_name()); ?></br>
                                            <?php if (Session::is_started() && $_SESSION['permissions'][MDL_PRSN_DATA]['r']): ?>
                                            <label><b>Email:</b></label>&nbsp;&nbsp;&nbsp;<?php echo h($user->get_email()); ?></br>
                                            <label><b>Direccion:</b></label>&nbsp;&nbsp;&nbsp;<?php echo h($user->get_address()); ?></br>
                                            <label><b>Pais:</b></label>&nbsp;&nbsp;&nbsp;<?php echo h($user->get_country()); ?></br>
                                            <label><b>Numero de telefono:</b></label>&nbsp;&nbsp;&nbsp;<?php echo h($user->get_phone_number()); ?></br>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="content-tab">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Lista</button>
                                        </li>
                                        <?php if (Session::is_started() && $_SESSION['permissions'][MDL_POSTS]['r']): ?>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Crud</button>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                   <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <div id="postListCard" class="card bg-white border">
                                                <div class='card-body mr-2 ml-2'>
                                                <?php
                                                $urlPager = "/users/profile/" . h($user->get_user_name()) . "/posts/";
                                                $pager = new Pager($urlPager, $numVisiblePosts, $postsPerPage, $maxLinksPager, $currentPagePost); // PAGINATOR
                                                $htmlPager = $pager->get_data_pager();

                                                include TEMPLATES_PATH . 'post_list.inc.php';
                                                ?>
                                                </div>
                                            </div></br>
                                            <?php if ($htmlPager != "") echo $htmlPager; ?>
                                        </div>
                                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            <?php include TEMPLATES_PATH . 'crud/post_profile_CRUD.inc.php'; ?>
                                        </div>
                                    </div> 
                                </div>
                                <div class ="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                                    <?php include TEMPLATES_PATH . 'user_contact_list.inc.php'; ?>
                                </div>
                                <div class ="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">

                                            <?php if (Session::is_started() && ($_SESSION['permissions'][MDL_IMAGES]['w'] ?? 0)): ?>

                                                    <button id="uploadNewImageBtn" name="uploadNewImageBtn" type="button" class="btn btn-primary gmd-1">
                                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Subir nueva imagen
                                                    </button>

                                            <?php endif; ?>
                                            <?php
                                            $urlPager = "/users/profile/" . h($user->get_user_name()) . "/image_gallery/";
                                            $pager = new Pager($urlPager, $numVisibleImages, $imagesPerPage, $maxLinksPager, $currentPage); // PAGINATOR
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

<?php
include TEMPLATES_PATH . 'scripts.inc.php';
include TEMPLATES_PATH . "footer.inc.php";
?>