<div class="row">
    <div class="col-3">
        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" data-toggle="pill" href="#contacts2" role="tab" aria-selected="true">Contactos</a>
            <a class="nav-link" data-toggle="pill" href="#friendRequests" role="tab" aria-selected="false">Solicitudes</a>
            <a class="nav-link" data-toggle="pill" href="#allUsers" role="tab" aria-selected="false">Todos los usuarios</a>
        </div>
    </div>
    <div class="col-9">
        <div class="tab-content">
            <div class="tab-pane show active" id="contacts2" role="tabpanel">
                <div class="table-responsive" style="white-space: nowrap;">
                    <table id="userContactsTable" class="table table-hover table-striped">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="friendRequests" role="tabpanel">
                <table id="friendRequestsTable" class="table table-hover table-striped">
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="allUsers" role="tabpanel">
                <div class="table-responsive" style="white-space: nowrap;">
                    <table id="allUserTable" class="table table-hover table-striped">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>