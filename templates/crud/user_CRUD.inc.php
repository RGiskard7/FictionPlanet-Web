<div class="row">
    <div class="col-md-12">
        <?php if ($_SESSION['permissions'][MDL_USERS]['w']): ?>
        <a name="createUserBtn" id="createUserBtn" href='<?php echo CREATE_USER_SEO_URL; ?>'>
            <button type="button" class="btn btn-primary gmd-1">
                <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;&nbsp;Añadir nuevo usuario
            </button>
        </a>
        <?php else: ?>
        <button type="button" class="btn btn-primary" disabled>
            <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;&nbsp;Añadir nuevo usuario
        </button>
        <?php endif; ?>
        <p></p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive" style="white-space: nowrap;">
            <table id="userTable" class="table table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ACCIONES</th>
                        <th>#</th>
                        <th>Id</th>
                        <th>Nombre de usuario</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Contraseña</th>
                        <th>Direccion</th>
                        <th>País</th>
                        <th>Número de teléfono</th>
                        <th>Rol de usuario</th>
                        <th>Fecha registro</th>
                        <th>Fecha última actualización</th>
                        <th>Fecha último acceso</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody> 
                </tbody>
                <tfoot class="thead-dark">
                    <tr>
                        <th>ACCIONES</th>
                        <th>#</th>
                        <th>Id</th>
                        <th>Nombre de usuario</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Contraseña</th>
                        <th>Direccion</th>
                        <th>País</th>
                        <th>Número de teléfono</th>
                        <th>Rol de usuario</th>
                        <th>Fecha registro</th>
                        <th>Fecha última actualización</th>
                        <th>Fecha último acceso</th>
                        <th>Estado</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>