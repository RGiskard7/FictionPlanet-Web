<nav id="topNavbar" class="navbar navbar-expand-sm navbar-light gmd-0 fixed-top">
    <!--<div class="container-fluid">--><!-- Funciona mal al colapsarse en pantallas pequeñas -->
        <!-- El navbar-header y el boton navbarToggler es par que se colapse el menu en pantallas pequeñas y aparezca un boton toggler -->
        <div class="navbar-header"> 
            <?php if (Session::is_started()): ?>   
                <button id="sidebarTogglerBtn" class="btn btn-secondary gmd-1" onclick="optionSidebarToggler()">
                    <i id="iconToggleSidebar" class="fa fa-2x fa-angle-double-right"></i>
                </button>
            <?php endif; ?>
            <button id="navbarTogglerBtn" class="navbar-toggler btn btn-outline-secondary gmd-1" type="button" data-toggle="collapse" 
                    data-target="#navbarTogglerMenu" aria-controls="navbarTogglerMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <a id="navbarBrand" class="navbar-brand" href="<?= BASE_URL; ?>">
            <!--<img src="<?= IMAGES_URL . "logo10.jpeg" ?>" width="70" alt="Logo_fiction_planet">-->
            <img src="<?= IMAGES_URL . "logo_gpt_2.png" ?>" height="auto" width="45" alt="Logo_fiction_planet"> <!-- width="70"-->
        </a>

        <div id="navbarTogglerMenu" class="navbar-collapse collapse ml-2">
            <ul class="nav navbar-nav">
                <li class="nav-item topBarElement mr-4">
                    <a id="homeLink" class="nav-link" href="<?= BASE_URL; ?>">
                        <span>Inicio</span>
                    </a>
                </li>
                <li class="nav-item topBarElement mr-4">
                    <a id="galleryLink" class="nav-link" href="<?= GALLERY_SEO_URL; ?>">
                        <span>Galería</span>
                    </a>
                </li>
                <!--<li class="nav-item active">
                    <a class="nav-link" href="#">
                        Foro
                    </a>
                </li>-->
                <li class="nav-item topBarElement mr-4">
                    <a id="aboutUsLink" class="nav-link" href="<?= CONTACT_SEO_URL; ?>">
                        <span>Información</span>
                    </a>
                </li>
                <!--<li class="nav-item topBarElement mr-4">
                    <a class="nav-link" href="#">
                        <span>Portal de transparencia</span>
                    </a>
                </li>-->     
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <?php if (Session::is_started()): ?>
                <!--<li id="dropdownNotificationsBtn" class="nav-item dropdown mr-4">
                    <button class="btn btn-sm btn-lg rounded-lg" type="button"  
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent;">
                        <i class="fa fa-2x fa-bell-o" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownNotificationsBtn">
                        <a id="editProfileBtn" class="dropdown-item" href="#">Editar perfil</a>
                        <a id="changePasswordBtn" class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal">Cambiar contraseña</a>
                        <a class="dropdown-item" href="#">Desactivar cuenta</a>
                    </div>
                </li>-->
                <li id="userNameBtn" class="nav-item">
                    <a href="<?= PROFILE_SEO_URL . "/" . $_SESSION['loggedInUser']->get_user_name(); ?>" style="text-decoration: none;">
                        <span style="vertical-align: middle; text-decoration: none;"><?= $_SESSION['loggedInUser']->get_user_name(); ?></span>&nbsp; 
                        <i style="vertical-align: middle;" class="fa fa-2x fa-user-circle-o" aria-hidden="true"></i>
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a id="loginBtn" class="nav-link" href="<?= LOGIN_SEO_URL; ?>">
                        <button class="btn btn-outline-success gmd-1" type="button">
                            Iniciar sesión <span class="caret"></span>
                        </button>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    <!--</div>-->
</nav>