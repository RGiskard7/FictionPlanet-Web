<?php if (Session::is_started()): ?>    
<div id="chatSidebar">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
        <h6 class="mb-0 font-weight-bold">Chats</h6>
        <button class="btn btn-sm btn-light rounded-circle" onclick="chatSidebarToggler()" style="width:32px;height:32px;padding:0;">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <div class="p-2">
        <span id="allUnread2" class="badge badge-danger gmd-2 mb-2" hidden></span>
        <div id="chatWindowContainer"></div>
    </div>
</div>
<?php endif; ?>