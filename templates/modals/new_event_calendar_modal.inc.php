<div id="newEventCalendarModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">  
            <div class="modal-header pl-4 pr-4 pt-4">
                <h4 class="modal-title" id="myModalLabel">Nuevo Evento</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body pl-4 pr-4">
                <form id="formNewEventCalendar" class="form-horizontal" role="form" method="POST" action="/app/calendarEventsController.php?action=add">
                    <div class="form-group">
                        <label for="title" class="control-label">Título</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Titulo el evento">
                    </div>
                    <div class="form-group">
                        <label for="color" class="control-label">Color</label>
                        <select name="color" class="form-control" id="newColor">
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
                        <input type="text" name="start" class="form-control" id="newStart">
                    </div>
                    <div class="form-group">
                        <label for="end" class="control-label">Fecha y hora de finalización</label>
                        <input type="text" name="end" class="form-control" id="newEnd">
                    </div>
                </form>
            </div>
            <div class="modal-footer pl-4 pr-4 pb-4">
                <button class="btn btn-danger gmd-1" type="button" data-dismiss="modal">Salir</button>
                <button type="submit" name="submitNewEvent" class="btn btn-success gmd-1" form="formNewEventCalendar">Guardar</button>
            </div> 
        </div>
    </div>
</div>

