<div id="newRoleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">  
            <div class="modal-header pl-4 pr-4 pt-4">
                <h4 class="modal-title">Nuevo rol de usuario</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body pl-4 pr-4">
                <form id="formNewRole" class="form-horizontal" role="form" method="POST">
                    <div class="form-group">
                        <input class="form-control" id="roleTitle" name="roleTitle" placeholder="Título del rol. (255 carácteres max.)" type="text">
                        <div id="feddbackNewRoleName" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="roleDescription" id="roleDescription" placeholder="Descripción del nuevo rol de usuario."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer pl-4 pr-4 pb-4">
                <button class="btn btn-danger gmd-1" type="button" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="submitNewRole" id="submitNewRole" class="btn btn-success gmd-1" form="formNewRole" disabled>Guardar</button>
            </div> 
        </div>
    </div>
</div>
