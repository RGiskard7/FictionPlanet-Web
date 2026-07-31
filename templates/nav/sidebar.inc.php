<?php if (Session::is_started()): ?>    
<div id="optionSidebar" class="gmd-2">
    <div class="p-3">
        <div class="text-center mb-3 p-3 border-bottom">
            <?php $av = $_SESSION['loggedInUser']->get_avatar(); ?>
            <img src="<?= $av ? UPLOAD_IMG_GALLERY_URL . 'avatars/' . $av : IMAGES_URL . 'avatar_2x.png'; ?>" class="rounded-circle mb-2" width="60" height="60" alt="" style="border:3px solid #1877F2; padding:2px;object-fit:cover;">
            <div class="font-weight-bold"><?php echo h($_SESSION['loggedInUser']->get_first_name()); ?>&nbsp;<?php echo h($_SESSION['loggedInUser']->get_last_name()); ?></div>
            <small class="text-muted">@<?php echo h($_SESSION['loggedInUser']->get_user_name()); ?></small>
            <div><span class="badge badge-pill mt-1" style="background:#E7F3FF;color:#1877F2;"><?php echo h($_SESSION['role']->get_sp_name()); ?></span></div>
        </div>

        <a class="list-group-item list-group-item-action gmd-1 mb-1" href="<?php echo PROFILE_SEO_URL . "/" . h($_SESSION['loggedInUser']->get_user_name()); ?>">
            <i class="fa fa-user fa-fw"></i> Mi perfil
        </a>

        <?php if ($_SESSION['permissions'][MDL_POSTS]['r'] && $_SESSION['permissions'][MDL_POSTS]['w']): ?>
        <a class="list-group-item list-group-item-action gmd-1 mb-1" href="<?php echo CREATE_POST_SEO_URL; ?>">
            <i class="fa fa-plus-circle fa-fw"></i> Crear publicacion
        </a>
        <?php endif; ?>

        <?php if ($_SESSION['permissions'][MDL_POSTS]['r']): ?>
        <a class="list-group-item list-group-item-action gmd-1 mb-1" href="<?php echo POSTS_SEO_URL; ?>">
            <i class="fa fa-file-text fa-fw"></i> Publicaciones
        </a>
        <?php endif; ?>

        <?php if ($_SESSION['permissions'][MDL_USERS]['r'] || $_SESSION['permissions'][MDL_ROLES]['r']): ?>
        <a class="list-group-item list-group-item-action caret gmd-1 mb-1">
            <i class="fa fa-users fa-fw"></i> Administracion
        </a>
        <ul class="nested mb-0 pl-2" style="list-style:none;">
            <?php if ($_SESSION['permissions'][MDL_USERS]['r']): ?>
            <li><a href="<?php echo USERS_SEO_URL; ?>"><i class="fa fa-angle-right fa-fw"></i>Usuarios</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['permissions'][MDL_ROLES]['r']): ?>
            <li><a href="<?php echo ROLES_SEO_URL; ?>"><i class="fa fa-angle-right fa-fw"></i>Roles</a></li>
            <?php endif; ?>
        </ul>
        <?php endif; ?>

        <hr class="my-3">

        <a class="list-group-item list-group-item-action gmd-1" href="<?php echo LOGIN_SEO_URL . '/logout'; ?>" 
        data-confirm="Desea cerrar sesion?">
            <i class="fa fa-sign-out fa-fw"></i> Cerrar sesion
        </a>
    </div>
</div>
<?php endif; ?>
