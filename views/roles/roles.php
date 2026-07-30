<?php
$pageTitle = $data['pageTitle'];

include TEMPLATES_PATH . 'head.inc.php';

include TEMPLATES_PATH . 'modals/new_role_modal.inc.php';
include TEMPLATES_PATH . 'modals/edit_role_modal.inc.php';
?>

<div id="modalDeclaration"></div>

<div id="main">
    <div class="container">
        <div id="rolesCard" class="card gmd-0 bg-white">
            <div class="card-header">
                <h5 class="mb-0"><i class="fa fa-id-card-o fa-fw mr-1"></i>Roles</h5>
            </div>
            <div class="card-body p-4">
                <?php
                include TEMPLATES_PATH . 'crud/role_CRUD.inc.php';
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include TEMPLATES_PATH . 'scripts.inc.php';
include TEMPLATES_PATH . "footer.inc.php";
?>
