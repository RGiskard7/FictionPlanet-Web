<div class="row">
    <div class="col-md-12 mb-3">
        <?php if ($_SESSION['permissions'][MDL_POSTS]['w']): ?>
        <a name="insertPostBtn" id="insertPostBtn" href="<?php echo CREATE_POST_SEO_URL; ?>">
            <button type="button" class="createPostBtn btn btn-primary gmd-1">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Crear nueva publicacion
            </button>
        </a>
        <?php else: ?>
        <button type="button" class="btn btn-primary" disabled>
            <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Crear nueva publicacion
        </button>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive" style="white-space: nowrap;">
            <table id="postTableProfile" class="table table-hover table-striped">
                <thead class="thead-ligth">
                    <tr>
                        <th>ACCIONES</th>
                        <th>#</th>
                        <th>Id</th>
                        <th>Estado</th>
                        <th>Título</th>
                        <th>Creación</th>
                        <th>Última actualización</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot class="thead-light">
                    <tr>
                        <th>ACCIONES</th>
                        <th>#</th>
                        <th>Id</th>
                        <th>Estado</th>
                        <th>Título</th>
                        <th>Creación</th>
                        <th>Última actualización</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>