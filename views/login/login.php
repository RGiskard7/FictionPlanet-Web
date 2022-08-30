<?php
$pageTitle = $data['pageTitle'];

include TEMPLATES_PATH . 'head.inc.php';
?>

<div id="main">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6">
                <div id="loginCard" class="card bg-white gmd-0">
                    <div class="card-header text-center">
                        <h2>Iniciar sesión</h2>
                    </div>
                    <div class="card-body">
                        <form rol="form" class="px-4 py-3" method="post" action="<?= LOGIN_SEO_URL; ?>">
                            <div class="form-group">
                                <input type="email" class="form-control shadow" id="emailLogin" name="emailLogin" placeholder="email@example.com" 
                                <?php
                                if (isset($data["validator"]) && isset($data["lastEmail"]) && !empty($data["lastEmail"])) {
                                    echo'value="' . $data['lastEmail'] . '"';
                                }
                                ?>
                                required autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control shadow" id="passwordLogIn" name="passwordLogin" placeholder="Contraseña" required>
                            </div>
                            <?php
                            if (isset($data["validator"])) {
                                $data['validator']->show_error();
                            }
                            ?>
                            <div class="form-group text-center mt-4 mb-0">
                                <button type="submit" name="submitLogin" class="form-control btn btn-primary gmd-1" style="font-size: 1.5em"><strong>Entrar</strong></button>
                            </div>

                            <hr class="featurette-divider mt-4 mb-4">
                            <div><p class="text-center">Actualmente solo existen cuentas de usuario a nivel interno.</p></div>
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



