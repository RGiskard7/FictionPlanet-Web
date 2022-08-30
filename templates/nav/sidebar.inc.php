<?php if (Session::is_started()): ?>    
<div id="optionSidebar" class="gmd-2">
    <div class="container p-0">
        <div class="row p-2 mb-3">
            <div class="col-md-12">
                <div class="border p-2">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <img src="<?php echo IMAGES_URL . "f2.png"; ?>" class="avatar img-circle img-thumbnail" alt="avatar" style="border:0; vertical-align: middle;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <strong>
                                <?php echo $_SESSION['loggedInUser']->get_first_name(); ?>&nbsp;<?php echo $_SESSION['loggedInUser']->get_last_name(); ?>
                            </strong></br>
                            <strong style="vertical-align: middle;">
                                <small><em><?php echo $_SESSION['loggedInUser']->get_user_name(); ?></em></small>
                            </strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <span class="badge badge-pill badge-secondary mt-2">
                                <?php
                                echo $_SESSION['role']->get_sp_name();
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-md-12">
                <a class="list-group-item list-group-item-action gmd-1" href="<?php echo PROFILE_SEO_URL . "/" . $_SESSION['loggedInUser']->get_user_name(); ?>" role="menuitem">
                    <i class="icon fa fa-home fa-fw" aria-hidden="true"></i> <!-- fa-fw para que se alineen verticalmente -->
                    <span>Área personal</span>
                </a>
                <?php if ($_SESSION['permissions'][MDL_POSTS]['r'] && $_SESSION['permissions'][MDL_POSTS]['w']): ?>
                <a class="createPostBtn list-group-item list-group-item-action gmd-1" href="<?php echo CREATE_POST_SEO_URL; ?>" role="menuitem">
                    <i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i>
                    <span>Crear publicación</span>
                </a>
                <?php endif; ?>
                <?php if ($_SESSION['permissions'][MDL_POSTS]['r']): ?>
                <a class="list-group-item list-group-item-action gmd-1" href="<?php echo POSTS_SEO_URL; ?>" role="menuitem">
                    <i class="icon fa fa-files-o fa-fw" aria-hidden="true"></i>
                    <span>Publicaciones</span>
                </a>
                <?php endif; ?>
                <?php if ($_SESSION['permissions'][MDL_USERS]['r']): ?>
                <a class="list-group-item list-group-item-action caret gmd-1" role="menuitem">
                    <i class="icon fa fa-users fa-fw" aria-hidden="true"></i>
                    <span>Usuarios</span>
                </a>
                <ul class="nested">
                    <?php if ($_SESSION['permissions'][MDL_USERS]['r']): ?>
                    <li><a href="<?php echo USERS_SEO_URL; ?>"><i class="icon fa fa-circle-o"></i>Usuarios</a></li>
                    <?php endif; ?>
                    <?php if ($_SESSION['permissions'][MDL_ROLES]['r']): ?>
                    <li><a href="<?php echo ROLES_SEO_URL; ?>"><i class="icon fa fa-circle-o"></i>Roles</a></li>
                    <?php endif; ?>
                </ul>
                <?php endif; ?>
                <a class="list-group-item list-group-item-action gmd-1" href="<?php echo APP_URL . 'logoutController.php'; ?>" 
                data-confirm="¿Desea cerrar sesión?" role="menuitem">
                    <i class="icon fa fa-sign-out fa-fw" aria-hidden="true"></i>
                    <span>Salir</span>
                </a>
            </div>
        </div>
    </div>        
</div>
<?php endif; ?>