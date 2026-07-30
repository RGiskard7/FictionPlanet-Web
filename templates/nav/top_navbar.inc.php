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
                    <?php if (Session::is_started()): ?>   
                        <button id="sidebarTogglerBtn" class="btn ml-1 d-none d-md-inline-flex" onclick="optionSidebarToggler()">
                            <i id="iconToggleSidebar" class="fa fa-angle-double-right text-white"></i>
                        </button>
                    <?php endif; ?>
                </div>
                <div id="navbarTogglerMenu" class="collapse navbar-collapse">
                    <ul class="navbar-nav mx-auto">
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
                    <div class="navbar-text">
                        <?php if (Session::is_started()): ?>
                            <a id="userNameRigth" class="nav-link text-white" href="<?= PROFILE_SEO_URL . "/" . h($_SESSION['loggedInUser']->get_user_name()); ?>">
                                <span><?= h($_SESSION['loggedInUser']->get_user_name()); ?></span>&nbsp;
                                <i class="fa fa-2x fa-user-circle"></i>
                            </a>
                        <?php else: ?>
                            <a id="loginBtn" class="nav-link" href="<?= LOGIN_SEO_URL; ?>">
                                <button class="btn btn-light" type="button" style="font-weight:600;border-radius:6px;font-size:0.9rem;">
                                    <i class="fa fa-sign-in mr-1"></i>Iniciar sesion
                                </button>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>