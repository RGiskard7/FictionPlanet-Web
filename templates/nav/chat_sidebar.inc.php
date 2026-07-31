<?php if (Session::is_started() && $_SESSION['permissions'][MDL_CHAT]['r']): ?>
<div id="chatPanel">
    <div id="chatToggle" onclick="chatPanelToggler()">
        <i class="fa fa-comments mr-2"></i>Chat <span id="allUnreadToggle" class="badge badge-danger ml-1" style="display:none;"></span>
    </div>
    <div id="chatBody">
        <div id="chatWindowContainer"></div>
    </div>
</div>
<?php endif; ?>
