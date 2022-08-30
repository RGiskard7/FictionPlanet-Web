
<div id="editRoleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">  
            <div class="modal-header pl-4 pr-4 pt-4">
                <h4 class="modal-title">Editar rol de usuario</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body pl-4 pr-4">
                <form id="formEditRole" name="formEditRole" class="form-horizontal" role="form" method="POST">
                    <div class="form-group">
                        <input id="editRoleID" name="editRoleID" type="hidden" class="form-control">
                        <input class="form-control" id="editRoleTitle" name="editRoleTitle" placeholder="Título del rol. (255 carácteres max.)" type="text">
                        <div id="feddbackEditRoleName" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="editRoleDescription" id="editRoleDescription" placeholder="Descripción del nuevo rol de usuario."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer pl-4 pr-4 pb-4">
                <button class="btn btn-danger gmd-1" type="button" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="submitEditRole" id="submitEditRole" class="btn btn-success gmd-1" form="formEditRole">Guardar</button>
            </div> 
        </div>
    </div>
</div>

