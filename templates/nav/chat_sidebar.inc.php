<?php if (Session::is_started()): ?>    
<div id="chatSidebar" class="gmd-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-default" onclick="chatSidebarToggler()">
                    <i class="fa fa-2x fa-angle-double-right" aria-hidden="true"></i>
                    <span id="allUnread2" class="badge badge-danger gmd-2 mb-2" hidden></span>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="chatWindowContainer"></div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>