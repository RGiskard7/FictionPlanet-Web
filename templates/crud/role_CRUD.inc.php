<div>
    <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION['permissions'][MDL_ROLES]['w']): ?>
            <a name="insertRoleBtn" id="insertRoleBtn" href="#">
                <button type="button" class="btn btn-primary gmd-1">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Añadir nuevo rol
                </button>
            </a>
            <?php else: ?>
            <button type="button" class="btn btn-primary" disabled>
                <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Añadir nuevo rol
            </button>
            <?php endif; ?>
            <p></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" style="white-space: nowrap;">
                <table id="roleTable" class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ACCIONES</th>
                            <th>#</th>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot class="thead-dark">
                        <tr>
                            <th>ACCIONES</th>
                            <th>#</th>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>