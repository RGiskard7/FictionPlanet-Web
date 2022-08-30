<div id="editUserModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="editUserModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificar datos del usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div id="selectUserStatus" class="form-group">
                        <label class="form-label" for="statusEditUser"><strong>Estado <strong style="color: red;">*</strong></strong></label>
                        <select class="form-control" Name='statusEditUser' id='statusEditUser'>  
                            <option name="empty" value="-1">--- Selecciona el estado de usuario ---</option>
                            <option name="active" value="1">Activo</option>
                            <option name="inactive" value="0">Inactivo</option>
                        </select>
                    </div>
                    <div id="selectUserRol" class="form-group">
                        <label class="form-label" for="roleEditUser"><strong>Rol del usuario <strong style="color: red;">*</strong></strong></label>
                        <select class="form-control" Name='roleEditUser' id='roleEditUser'>  
                            <option name="empty" value="0">--- Selecciona el rol de usuario ---</option>
                            <?php foreach ($roleArray as $role): ?>
                                <option name='<?php echo $role->get_name();?>' value='<?php echo $role->get_id(); ?>'><?php echo $role->get_sp_name(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input id="loggedInUserId" name="loggedInUserId" type="hidden" class="form-control" value="<?php echo $_SESSION["idUser"]; ?>">
                        <input id="idEditUser" name="idEditUser" type="hidden" class="form-control">
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
                        <label><strong>Nueva contraseña </strong></label>&nbsp;<span id="passwordType"></span>
                        <input id="newPassword" class="form-control" name="newPassword" type="password" class="form-control" autocomplete="new-password">
                        <!-- Evitar que el campo se autocomplete por el navegador si hay contraseña guardada -->
                    </div>
                    <div class="form-group">
                        <label><strong>Confirmar nueva contraseña </strong></label>
                        <input id="confirmNewPassword" class="form-control" name="confirmNewPassword" type="password" class="form-control" autocomplete="new-password">
                        <div id="feddbackNewPassword" class="invalid-feedback"></div>
                    </div>
                    <div id="passwordChangeAlert" role='alert'></div>

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
                <button type="submit" id="submitEditUser" name="submitEditUser" class="btn btn-success gmd-1">Guardar</button>
            </div>
        </div>
    </div>
</div>
