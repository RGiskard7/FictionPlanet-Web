<div id="changePasswordModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="changePasswordModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <input id="currentPassword" class="form-control" name="currentPassword" type="password" class="form-control" placeholder="Contraseña actual">
                        <div id="feddbackCurrentPassword" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group"><span id="passwordType"></span>
                        <input id="newPassword" class="form-control" name="newPassword" type="password" class="form-control" placeholder="Nueva contraseña">
                    </div>
                    <div class="form-group">
                        <input id="confirmNewPassword" class="form-control" name="confirmNewPassword" type="password" class="form-control" placeholder="Confirmar nueva contraseña">
                        <div id="feddbackNewPassword" class="invalid-feedback">
                        </div>
                    </div>
                    <div id="passwordChangeAlert" role='alert'>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submitChangePassword" name="submitChangePassword" class="btn btn-success gmd-1">Guardar</button>
            </div>
        </div>
    </div>
</div>