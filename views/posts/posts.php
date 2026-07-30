<?php
$pageTitle = $data['pageTitle'];

include TEMPLATES_PATH . 'head.inc.php';
?>

<div id="main">
    <div class="container">
        <div id="postsCard" class="card gmd-0 bg-white">
            <div class="card-header">
                <h3><i class="icon fa fa-files-o fa-fw" aria-hidden="true"></i> PUBLICACIONES</h3>
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
