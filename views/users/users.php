<?php
$pageTitle = $data['pageTitle'];
$roleArray = $data['roleArray'];

include TEMPLATES_PATH . 'head.inc.php';

include TEMPLATES_PATH . 'modals/user_modal.inc.php';
include TEMPLATES_PATH . 'modals/edit_user_modal.inc.php';
?>

<div id="main">
    <div class="container">
        <div id="usersCard" class="card gmd-0 bg-white">
            <div class="card-header">
                <h5 class="mb-0"><i class="fa fa-users fa-fw mr-1"></i>Usuarios</h5>
            </div>
            <div class="card-body p-4">
                <?php
                include TEMPLATES_PATH . 'crud/user_CRUD.inc.php';
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include TEMPLATES_PATH . 'scripts.inc.php';
include TEMPLATES_PATH . "footer.inc.php";
?>

