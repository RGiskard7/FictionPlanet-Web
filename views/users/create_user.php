<?php
$pageTitle = $data['pageTitle'];
$roleArray = $data['roleArray'];

include TEMPLATES_PATH . 'head.inc.php';
?>

<div id="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div id="createUserCard" class="card gmd-0 bg-white">
                    <div class="card-header text-center">
                        <a href="<?php echo USERS_SEO_URL; ?>">
                            <button class="btn btn-outline-secondary float-left mt-2 mr-2 mb-2 gmd-1">
                                <i class="icon fa fa-arrow-left"></i>
                            </button>
                        </a>
                        <h3 class="mr-5">Nuevo usuario</h3>
                    </div>
                    <div class="card-body">									
                        <form rol="form" method="post" action="<?php echo CREATE_USER_SEO_URL; ?>" name="formNewUser">
                            <?php
                            if (isset($data['validator'])) {
                                $validator = $data['validator'];
                                include_once TEMPLATES_PATH . "create_user_validated.inc.php";
                            } else {
                                include_once TEMPLATES_PATH . "create_user_empty.inc.php";
                            }
                            ?>
                            <br>
                            <div class="text-center">
                                <a href="<?php echo CREATE_USER_SEO_URL; ?>" name="resetNewUser" data-confirm="¿Seguro que quiere borrar todo?">
                                    <button class="btn btn-danger gmd-1">Borrar todo</button>
                                </a>
                                <button class="btn btn-success gmd-1" type="submit" name="submitNewUser">Enviar</button>
                            </div>
                        </form>
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
