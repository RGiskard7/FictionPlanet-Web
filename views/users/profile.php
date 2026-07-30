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
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-3 col-sm-12 text-center mb-3 mb-md-0">
                        <img src="<?= IMAGES_URL . "avatar_2x.png"; ?>" class="rounded-circle" width="90" height="90" alt="avatar" style="border: 3px solid #E4E6EB; padding: 3px; object-fit: cover;">
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-12">
                        <h2 id="profileUsername" class="mb-1"><?= h($user->get_user_name()); ?></h2>
                        <div class="text-muted small mb-2">
                            <i class="fa fa-calendar mr-1"></i>Miembro desde <?= date('d/m/Y', strtotime($user->get_reg_date())); ?>
                            &nbsp;|&nbsp;
                            <i class="fa fa-clock-o mr-1"></i>Ultimo acceso <?= date('d/m/Y', strtotime($user->get_last_access_date())); ?>
                        </div>
                        <span class="mr-3"><b><?= $numPosts; ?></b> publicaciones <small class="text-muted">(<?= $numVisiblePosts; ?> visibles)</small></span>
                        <span class="badge mr-1" style="background:#E7F3FF;color:#1877F2;"><?= h($_SESSION['role']->get_sp_name()); ?></span>
                        <span class="badge badge-pill <?= ($user->is_active() == 1) ? 'badge-success' : 'badge-danger'; ?>">
                            <?= ($user->is_active() == 1) ? "Activo" : "Inactivo"; ?>
                        </span>
                    </div>
                    <div class="col-lg-3 col-md-3 text-right">
                        <div class="dropdown">
                            <button class="btn btn-light gmd-1 rounded-circle" type="button" id="dropdownProfileConfiguration" 
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:40px;height:40px;padding:0;">
                                <i class="fa fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownProfileConfiguration">
                                <a id="editProfileBtn" class="dropdown-item" href="#"><i class="fa fa-pencil mr-2"></i>Editar perfil</a>
                                <a id="changePasswordBtn" class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal"><i class="fa fa-lock mr-2"></i>Cambiar contrasena</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#"><i class="fa fa-ban mr-2"></i>Desactivar cuenta</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class="mt-3 mb-0">
                
                <div class="row">
                    <div class="col-12">
                        <div id="tabs" class="project-tab">
                            <nav>
                                <div class="nav nav-tabs" id="profileTabs" role="tablist">
                                    <a class="nav-item nav-link active" id="content-tab" data-toggle="tab" href="#content" role="tab">Publicaciones</a>
                                    <a class="nav-item nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab">Imagenes</a>
                                    <a class="nav-item nav-link" id="contacts-tab" data-toggle="tab" href="#contacts" role="tab">Contactos</a>
                                    <a class="nav-item nav-link" id="aboutMe-tab" data-toggle="tab" href="#aboutMe" role="tab">Acerca de</a>
                                </div> 
                            </nav>
                            <div class="tab-content mt-4" id="nav-tabContent">
                                <div class="tab-pane fade" id="aboutMe" role="tabpanel">
                                    <div class="card">
                                        <div class="card-header"><strong>Informacion personal</strong></div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-2"><strong>Nombre:</strong> <?php echo h($user->get_first_name()); ?></div>
                                                <div class="col-md-6 mb-2"><strong>Apellidos:</strong> <?php echo h($user->get_last_name()); ?></div>
                                                <?php if (Session::is_started() && $_SESSION['permissions'][MDL_PRSN_DATA]['r']): ?>
                                                <div class="col-md-6 mb-2"><strong>Email:</strong> <?php echo h($user->get_email()); ?></div>
                                                <div class="col-md-6 mb-2"><strong>Direccion:</strong> <?php echo h($user->get_address()); ?></div>
                                                <div class="col-md-6 mb-2"><strong>Pais:</strong> <?php echo h($user->get_country()); ?></div>
                                                <div class="col-md-6 mb-2"><strong>Telefono:</strong> <?php echo h($user->get_phone_number()); ?></div>
                                                <?php endif; ?>
                                            </div>
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
                                             <div class="card mb-0">
                                                 <div class='card-body'>
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