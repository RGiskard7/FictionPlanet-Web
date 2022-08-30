<div class="form-group text-center">
    <label class="checkbox-custom-1-label" for="postCheckbox"><h5>Usuario activo</h5></label>&nbsp;&nbsp;&nbsp;
    <input class="checkbox-custom-1" type="checkbox" id="checkboxNewUser" name="checkboxNewUser" value="1" checked>
</div>
<div class="form-group">
    <label class="form-label" for="roleNewUser">Rol del usuario:</label>
    <select class="form-control" Name='roleNewUser' id='roleNewUser'>  
        <option name="empty" value="0" <?php $validator->show_role(0) ?>>--- Selecciona el rol de usuario ---</option>        
        <?php foreach ($roleArray as $role): ?>
            <?php if ($role->get_id() != 1 || ($role->get_id() == 1 && $_SESSION['role']->get_id() == 1)): ?>
            <option name='<?php echo $role->get_name(); ?>' value='<?php echo $role->get_id(); ?>' <?php $validator->show_role($role->get_id()) ?>><?php echo $role->get_sp_name(); ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select> 
    <?php
    $validator->show_error_role();
    ?>
</div>
<div class="form-group">
    <label>Nombre de usuario</label>
    <input name="userNameNewUser" type="text" class="form-control" <?php $validator->show_user_name() ?>>
    <?php
    $validator->show_error_user_name();
    ?>
</div>
<div class="form-group">
    <label>Nombre completo</label>
    <input name="firstNameNewUser" type="text" class="form-control" <?php $validator->show_first_name() ?>>
    <?php
    $validator->show_error_first_name();
    ?>
</div>
<div class="form-group">
    <label>Apellidos</label>
    <input name="lastNameNewUser" type="text" class="form-control" <?php $validator->show_last_name() ?>>
    <?php
    $validator->show_error_last_name();
    ?>
</div>
<div class="form-group">
    <label>Email</label>
    <input name="emailNewUser" type="email" class="form-control" <?php $validator->show_email() ?> autocomplete="new-password">
    <?php
    $validator->show_error_email();
    ?>
</div>
<div class="form-group">
    <label>Contraseña</label>
    <input id="newPassword" name="password1NewUser" type="password" class="form-control" autocomplete="new-password">
    <?php
    $validator->show_error_password1();
    ?>
</div>
<div class="form-group">
    <label>Confirma la contraseña</label>
    <input id="confirmNewPassword" name="password2NewUser" type="password" class="form-control" autocomplete="new-password">
    <div id="feddbackNewPassword" class="invalid-feedback">
    </div>
    <?php
    $validator->show_error_password2();
    ?>
</div>
<div class="form-group">
    <label>Dirección</label>
    <input name="addressNewUser" type="text" class="form-control" <?php $validator->show_address() ?>>
    <?php
    $validator->show_error_address();
    ?>
</div>
<div class="form-group">
    <label>País</label>
    <input name="countryNewUser" type="text" class="form-control" <?php $validator->show_country() ?>>
    <?php
    $validator->show_error_country();
    ?>
</div>
<div class="form-group">
    <label>Número de teléfono</label>
    <input name="telephonNewUser" type="tel" class="form-control" <?php $validator->show_phone_number() ?>>
    <?php
    $validator->show_error_phone_number();
    ?>
</div>