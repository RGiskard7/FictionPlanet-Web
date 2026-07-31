        <nav id="topNavbar" class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: #1877F2;">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a id="navbarBrand" class="d-flex align-items-center" href="<?= BASE_URL; ?>">
                        <img src="<?= IMAGES_URL . "logo_gpt_2.png" ?>" height="28" alt="Logo" style="background:#fff;border-radius:6px;padding:3px;">
                        <span class="font-weight-bold ml-2 d-none d-md-inline text-white" style="font-size:1.1rem;">Fiction Planet</span>
                    </a>
                    <button id="navbarTogglerBtn" class="navbar-toggler ml-2" type="button" data-toggle="collapse" 
                            data-target="#navbarTogglerMenu" aria-controls="navbarTogglerMenu" aria-expanded="false">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div id="navbarTogglerMenu" class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a id="homeLink" class="nav-link nav-link-ico text-white" href="<?= BASE_URL; ?>">
                                <i class="fa fa-home"></i><span>Inicio</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="galleryLink" class="nav-link nav-link-ico text-white" href="<?= GALLERY_SEO_URL; ?>">
                                <i class="fa fa-image"></i><span>Galeria</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="aboutUsLink" class="nav-link nav-link-ico text-white" href="<?= CONTACT_SEO_URL; ?>">
                                <i class="fa fa-info-circle"></i><span>Info</span>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-divider d-none d-md-block"></div>
                    <div class="navbar-text">
                        <?php if (Session::is_started()): ?>
                            <a id="userNameRigth" class="nav-link text-white" href="<?= PROFILE_SEO_URL . "/" . h($_SESSION['loggedInUser']->get_user_name()); ?>">
                                <span><?= h($_SESSION['loggedInUser']->get_user_name()); ?></span>&nbsp;
                                <?php $av = $_SESSION['loggedInUser']->get_avatar(); ?>
                                <img src="<?= $av ? UPLOAD_IMG_GALLERY_URL . 'avatars/' . $av : IMAGES_URL . 'avatar_2x.png'; ?>" class="rounded-circle" width="32" height="32" style="object-fit:cover;border:2px solid rgba(255,255,255,0.5);" alt="">
                            </a>
                        <?php else: ?>
                            <a id="loginBtn" class="nav-link" href="<?= LOGIN_SEO_URL; ?>">
                                <button class="btn btn-outline-light" type="button" style="font-weight:600;border-radius:20px;font-size:0.875rem;padding:0.35rem 1.25rem;border-width:1.5px;">
                                    Iniciar sesion
                                </button>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>