<div id="editProfileModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="editProfileModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="userNameEditProfile"><strong>Nombre de usuario <strong style="color: red;">*</strong></strong></label>
                        <input id="userNameEditProfile" name="userNameEditProfile" type="text" class="form-control">
                        <input id="currentUserNameEditProfile" name="currentUserNameEditProfile" type="hidden" class="form-control">
                        <div id="feddbackUserNameEditProfile" class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label><strong>Nombre completo <strong style="color: red;">*</strong></strong></label>
                        <input id="firstNameEditProfile" name="firstNameEditProfile" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label><strong>Apellidos <strong style="color: red;">*</strong></strong></label>
                        <input id="lastNameEditProfile" name="lastNameEditProfile" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label><strong>Email <strong style="color: red;">*</strong></strong></label>
                        <input id="emailEditProfile" name="emailEditProfile" type="email" class="form-control">
                        <input id="currentEmailEditProfile" name="currentEmailEditProfile" type="hidden" class="form-control">
                        <div id="feddbackEmailEditProfile" class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label><strong>Dirección <strong style="color: red;">*</strong></strong></label>
                        <input id="addressEditProfile" name="addressEditProfile" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label><strong>País <strong style="color: red;">*</strong></strong></label>
                        <input id="countryEditProfile" name="countryEditProfile" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label><strong>Número de teléfono</strong></label>
                        <input id="telephonEditProfile" name="telephonEditProfile" type="tel" class="form-control">
                    </div>
                    <div><span>Los campos marcados con asterisco (<strong style="color: red;">*</strong>) son obligatorios.</span></div></br>
                    <div id="editProfileAlert" role='alert'></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger gmd-1" type="button" data-dismiss="modal">Salir</button>
                <button type="submit" id="submitEditProfile" name="submitEditProfile" class="btn btn-success gmd-1">Guardar</button>
            </div>
        </div>
    </div>
</div>

