<?php
$pageTitle = $data['pageTitle'];
$userName = $data['user']->get_user_name();

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
                                <h2 id="profileUsername"><?= $userName; ?></h2>
                                <span class="badge badge-pill badge-danger mb-1">Perfil suspendido</span>
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

