<div id="calendarModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <?php if (Session::is_started() && $_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['u'] && $_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['d']): ?>            
            <div class="modal-header pl-4 pr-4 pt-4">
                <h4 class="modal-title" id="myModalLabel">Detalles del evento</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body pl-4 pr-4">
                <form id="formUpdateEventCalendar" class="form-horizontal" role="form" method="POST" action="<?= BASE_URL . 'calendar/update'; ?>">
                    <?= Session::csrf_input(); ?>
                    <div class="form-group">
                        <label for="title" class="control-label">Título</label>
                        <input type="text" name="title" class="form-control" id="modalTitle">
                    </div>
                    <div class="form-group">
                        <label for="color" class="control-label">Color</label>
                        <select name="color" class="form-control" id="color">
                            <option value="">--- Selecciona el color del evento ---</option>
                            <option style="color:#159E4A;" value="#159E4A">&#9724;Verde Matelab</option>
                            <option style="color:#FFD700;" value="#FFD700">&#9724;Amarillo</option>
                            <option style="color:#FF8C00;" value="#FF8C00">&#9724;Naranja</option>
                            <option style="color:#FF0000;" value="#FF0000">&#9724;Rojo</option>
                            <option style="color:#000;" value="#000">&#9724;Negro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start" class="control-label">Fecha y hora de inicio</label>
                        <input type="text" name="start" class="form-control" id="start">
                    </div>
                    <div class="form-group">
                        <label for="end" class="control-label">Fecha y hora de finalización</label>
                        <input type="text" name="end" class="form-control" id="end">
                    </div>
                    <input type="hidden" name="id" class="form-control" id="eventID">
                </form>
            </div>
            <div class="modal-footer pl-4 pr-4 pb-4">
                <?php if ($_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['d']): ?>
                <button type="submit" name="submitDeleteEvent" class="btn btn-danger gmd-1" 
                        data-confirm="¿Seguro que quieres eliminar este evento?" form="formUpdateEventCalendar">Eliminar</button>
                <?php endif; ?>
                <?php if ($_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['u']): ?>
                <button type="submit" name="submitUpdateEvent" class="btn btn-success gmd-1" form="formUpdateEventCalendar">Actualizar</button>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div class="modal-header pl-4 pr-4 pt-4">
                <h4 class="modal-title">Detalles del evento</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div id="modalBody" class="modal-body pl-4 pr-4 pb-4" style="word-wrap: break-word;">
                <h5 id="modalTitle" class="modal-title"></h5></br>
                <div id="modalWhen" style="margin-top:5px;"></div>
                <?php if (Session::is_started() && $_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['d']): ?>
                <form class="form-horizontal mt-4" role="form" method="POST" action="<?= BASE_URL . 'calendar/delete'; ?>">
                    <?= Session::csrf_input(); ?>
                    <input type="hidden" name="id" class="form-control" id="eventID2">
                    <button type="submit" name="submitDeleteEvent" class="btn btn-danger gmd-1 pull-right" 
                            data-confirm="¿Seguro que quieres eliminar este evento?">Eliminar</button>
                </form>
                <?php endif; ?>
            </div>
            <input type="hidden" id="eventID"/>
            <?php endif; ?>
        </div>
    </div>
</div>
