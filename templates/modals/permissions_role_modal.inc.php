<div id="permissionsRoleModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="permissionsRoleModal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Permisos del rol de usuario <em><?= $role->get_sp_name(); ?></em></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= ROLES_SEO_URL . '/submit_permissions_role'; ?>" method="post" id="permissionForm" name="permissionForm">
                    <input type="hidden" id="rolePermissionsID" name="rolePermissionsID" value="<?= $role->get_id(); ?>" required>
                    <div class="table-responsive">
                        <table id="permissionTable" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Módulo</th>
                                    <th class="text-center">Ver</th>
                                    <th class="text-center">Crear</th>
                                    <th class="text-center">Actualizar</th>
                                    <th class="text-center">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $index = 1;
                                ?>
                                <?php foreach($modulesPermissions as $module): ?>
                                    <?php
                                    $rCheck = $module['r'] == 1 ? " checked " : "";
                                    $wCheck = $module['w'] == 1 ? " checked " : "";
                                    $uCheck = $module['u'] == 1 ? " checked " : "";
                                    $dCheck = $module['d'] == 1 ? " checked " : "";
                                    $moduleID = $module['module_id'];
                                    ?>
                                    <input type="hidden" name="<?= 'moduleID-' . $index; ?>" value="<?= $moduleID ?>" required>
                                    <tr>
                                        <td class='text-center'>
                                            <?= $index; ?>
                                        </td>
                                        <td>
                                            <?= $module["name_esp"]; ?>
                                        </td>
                                        <td class='text-center'>
                                            <label>
                                                <input class="checkbox-custom-1" type="checkbox" name="module-<?= $moduleID; ?>[]" value="r" <?= $rCheck ?>>
                                            </label>
                                        </td>
                                        <td class='text-center'>
                                            <label>
                                                <input class="checkbox-custom-1" type="checkbox" name="module-<?= $moduleID; ?>[]" value="w" <?= $wCheck ?>>
                                            </label>
                                        </td>
                                        <td class='text-center'>
                                            <label>
                                                <input class="checkbox-custom-1" type="checkbox" name="module-<?= $moduleID; ?>[]" value="u" <?= $uCheck ?>>
                                            </label>
                                        </td>
                                        <td class='text-center'>
                                            <label>
                                                <input class="checkbox-custom-1" type="checkbox" name="module-<?= $moduleID; ?>[]" value="d" <?= $dCheck ?>>
                                            </label>
                                        </td>
                                    </tr>
                                    <?php $index++ ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <input type="hidden" id="numModulesPermissions" name="numModulesPermissions" value="<?= $index - 1; ?>" required>
                    <div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger gmd-1" type="button" data-dismiss="modal"> Salir</button>
                <button type="submit" id="submitPermissionsRole" name="submitPermissionsRole" class="btn btn-success gmd-1" form="permissionForm">Guardar</button>
            </div>
        </div>
    </div>
</div>