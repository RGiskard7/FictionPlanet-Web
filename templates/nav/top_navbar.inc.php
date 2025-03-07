        <nav id="topNavbar" class="navbar navbar-expand-md navbar-light gmd-0 fixed-top">
            <div class="container-fluid"><!-- Funciona mal al colapsarse en pantallas pequeñas -->
                <!-- El navbar-header y el boton navbarToggler es par que se colapse el menu en pantallas pequeñas y aparezca un boton toggler -->
                <div class="navbar-header">
                                        
                    <a id="navbarBrand" class="navbar-brand" href="<?= BASE_URL; ?>">
                        <img src="<?= IMAGES_URL . "logo_gpt_2.png" ?>" height="auto" width="45" alt="Logo_fiction_planet">
                    </a>
                    
                    <button id="navbarTogglerBtn" class="navbar-toggler btn btn-outline-secondary gmd-1" type="button" data-toggle="collapse" 
                            data-target="#navbarTogglerMenu" aria-controls="navbarTogglerMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <?php if (Session::is_started()): ?>   
                        <button id="sidebarTogglerBtn" class="btn btn-secondary gmd-1" onclick="optionSidebarToggler()">
                            <i id="iconToggleSidebar" class="fa fa-angle-double-right"></i>
                        </button>
                    <?php endif; ?>

                </div>

                <div id="navbarTogglerMenu" class="collapse navbar-collapse"> <!-- justify-content-center ml-2-->
                    <ul class="nav navbar-nav"> <!--mx-auto-->
                        <li class="nav-item topBarElement mr-4">
                            <a id="homeLink" class="position-nabvar-item nav-link " href="<?= BASE_URL; ?>">
                                <i class="fa fa-home"></i>
                                <span>Inicio</span>
                            </a>
                        </li>
                        <li class="nav-item topBarElement mr-4">
                            <a id="galleryLink" class="position-nabvar-item nav-link" href="<?= GALLERY_SEO_URL; ?>">
                                <i class="fa fa-image"></i>
                                <span>Galería</span>
                            </a>
                        </li>
                        <!--<li class="nav-item active">
                            <a class="nav-link" href="#">
                                Foro
                            </a>
                        </li>-->
                        <li class="nav-item topBarElement">
                            <a id="aboutUsLink" class=" position-nabvar-item nav-link" href="<?= CONTACT_SEO_URL; ?>">
                                <i class="fa fa-info-circle "></i>
                                <span>Información</span>
                            </a>
                        </li>
                        <!--<li class="nav-item topBarElement mr-4">
                            <a class="nav-link" href="#">
                                <span>Portal de transparencia</span>
                            </a>
                        </li>--> 
                    </ul>
                    <!--<div class="my-2 my-lg-0">-->
                    <!--<div class="align-self-end">-->
                    <div class="navbar-text">
                        <?php if (Session::is_started()): ?>
                            <a  id="userNameRigth" class="nav-link" href="<?= PROFILE_SEO_URL . "/" . $_SESSION['loggedInUser']->get_user_name(); ?>">
                                <span style="vertical-align: middle;"><?= $_SESSION['loggedInUser']->get_user_name(); ?></span>&nbsp; 
                                <i style="vertical-align: middle;" class="fa fa-2x fa-user-circle-o" aria-hidden="true"></i>
                            </a>
                        <?php else: ?>
                            <a id="loginBtn" class="nav-link" href="<?= LOGIN_SEO_URL; ?>">
                                <button class="btn btn-outline-success gmd-1" type="button">
                                    Iniciar sesión <span class="caret"></span>
                                </button>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>

            </div>
        </nav>