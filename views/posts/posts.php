<?php
$pageTitle = $data['pageTitle'];

include TEMPLATES_PATH . 'head.inc.php';
?>

<div id="main">
    <div class="container">
        <div id="postsCard" class="card gmd-0 bg-white">
            <div class="card-header">
                <h5 class="mb-0"><i class="fa fa-file-text fa-fw mr-1"></i>Publicaciones</h5>
            </div>
            <div class="card-body p-4">
                <?php
                include TEMPLATES_PATH . 'crud/post_CRUD.inc.php';
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include TEMPLATES_PATH . 'scripts.inc.php';
include TEMPLATES_PATH . "footer.inc.php";
?>
