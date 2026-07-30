<?php
$pageTitle = $data['pageTitle'];

include TEMPLATES_PATH . 'head.inc.php';
?>

<div id="main">
    <div class="container">
        <div class="row justify-content-center" style="min-height: 60vh;">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="text-center mb-4">
                    <img src="<?= IMAGES_URL . "logo_gpt_2.png"; ?>" height="60" alt="Logo">
                    <h4 class="mt-2">Fiction Planet</h4>
                </div>
                <div id="loginCard" class="card bg-white gmd-0">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Iniciar sesion</h5>
                        <?php if (!empty($data['rate_limit'])): ?>
                            <div class="alert alert-warning"><?= h($data['rate_limit']) ?></div>
                        <?php endif; ?>
                        <form rol="form" method="post" action="<?= LOGIN_SEO_URL; ?>">
                            <?= Session::csrf_input(); ?>
                            <div class="form-group">
                                <input type="email" class="form-control" id="emailLogin" name="emailLogin" placeholder="Correo electronico"
                                <?php if (isset($data["validator"]) && isset($data["lastEmail"]) && !empty($data["lastEmail"])) {
                                    echo'value="' . $data['lastEmail'] . '"';
                                } ?>
                                required autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="passwordLogIn" name="passwordLogin" placeholder="Contrasena" required>
                            </div>
                            <?php if (isset($data["validator"])) { $data['validator']->show_error(); } ?>
                            <button type="submit" name="submitLogin" class="btn btn-primary btn-block gmd-1 mt-3" style="font-size:1.1rem;padding:0.625rem;">
                                <strong>Entrar</strong>
                            </button>
                            <hr class="mt-4 mb-4">
                            <p class="text-center text-muted small mb-0">Actualmente solo existen cuentas de usuario a nivel interno.</p>
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
