<?php
$pageTitle = $data['pageTitle'];
$numPosts = $data['numPosts'];
$numVisiblePosts = $data['numVisiblePosts'];
$numNotVisiblePosts = $data['numNotVisiblePosts'];
$user = $data['user'];

$numVisibleImages = $data['numVisibleImages'];
$imagesPerPage = $data['imagesPerPage'];
$maxLinksPager = $data['maxLinksPager'];
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
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-2 text-center">
                                <img src="<?= IMAGES_URL . "avatar_2x.png"; ?>" class="img-thumbnail rounded mb-4" alt="avatar">
                            </div>
                            <div class="col-md-8">
                                <h2 id="profileUsername"><?= $user->get_user_name(); ?></h2>
                                <i class="fa fa-calendar mr-2"></i><strong>Miembro registrado desde: </strong><?= date('d-m-Y H:i:s', strtotime($user->get_reg_date()));?></br>
                                <i class="fa fa-clock-o mr-2"></i><strong>Último acceso al sitio: </strong><?= date('d-m-Y H:i:s', strtotime($user->get_last_access_date())); ?></br>
                                
                                <span><strong><?= $numPosts; ?></strong>&nbsp;Publicaciones <small><em>(<?= $numVisiblePosts; ?>&nbsp;visibles, <?= $numNotVisiblePosts; ?>&nbsp;no visibles)</em></small></span></br>

                                <span class="badge badge-pill badge-secondary mt-2">
                                <?= $_SESSION['role']->get_sp_name(); ?>
                                </span>

                                <span class="badge badge-pill badge-secondary mb-1">  
                                <?= ($user->is_active() == 1) ? "Activo" : "No activo"; ?>
                                </span>
                            </div>
                            <div class="col-md-2">
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
                    </div>
                </div>
                
                <hr class=" featurette-divider mt-2 mb-3 border">
                
                <div id="tabs" class="row project-tab">
                    <div class="col-md-12">
                        <div class="nav nav-tabs" id="profileTabs" role="tablist">
                            <a class="nav-item nav-link active" id="aboutMe-tab" data-toggle="tab" href="#aboutMe" role="tab" aria-controls="aboutMe" aria-selected="true">Acerca de</a>
                            <a class="nav-item nav-link" id="content-tab" data-toggle="tab" href="#content" role="tab" aria-controls="content" aria-selected="true">Publicaciones</a>
                            <a class="nav-item nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="true">Imágenes</a>
                            <!--<a class="nav-item nav-link" id="planner-tab" data-toggle="tab" href="#planner" role="tab" aria-controls="planner" aria-selected="true">Planificador</a>-->
                            <a class="nav-item nav-link" id="contacts-tab" data-toggle="tab" href="#contacts" role="tab" aria-controls="contacts" aria-selected="true">Contactos</a>
                        </div> 

                        <div class="tab-content mt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="aboutMe" role="tabpanel" aria-labelledby="aboutMe-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card bg-white border" style="border-radius: 10px;">
                                            <div class="card-header"><strong>Información personal</strong></div>
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
                            <div class="tab-pane fade" id="content" role="tabpanel" aria-labelledby="content-tab">
                                <?php include TEMPLATES_PATH . 'crud/post_profile_CRUD.inc.php'; ?>
                            </div>
                            <div class ="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                                <?php include TEMPLATES_PATH . 'user_contact_list.inc.php'; ?>
                            </div>
                            <div class ="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                <div class="row">
                                    <div class="col-md-12">   
                                        <?php if (Session::is_started()): ?> <!-- Quitar, comprobar permisos -->
                                        <div class="row pb-4">
                                            <div class="col-md-12">
                                                <button id="uploadNewImageBtn" name="uploadNewImageBtn" type="button" class="btn btn-primary gmd-1">
                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Subir nueva imágen
                                                </button>
                                            </div>   
                                        </div>
                                        <?php endif; ?>
                                        <?php
                                        $urlPager = "/users/profile/" . $user->get_user_name() . "/image_gallery/";
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
</div>

<?php
include TEMPLATES_PATH . 'scripts.inc.php';
include TEMPLATES_PATH . "footer.inc.php";
?>