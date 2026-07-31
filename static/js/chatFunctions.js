$(document).ready(function() {
    showUsersChatList();
     
    setInterval(function() {
        updateUserChatHistory();
        updateUnreadMessageCount();
        updateAllUnreadMessageCount();
    }, 1000);
           
    $(document).on('click', '.chat-contact', function(){
        var userId = $(this).data('touserid');
        var userName = $(this).find('.font-weight-bold').text();
        showUserChatHistory(userId, userName);
    });

    $(document).on('click', '.startChatButton', function(e){
        e.stopPropagation();
        var userId = $(this).data('touserid');
        var userName = $(this).data('tousername');
        showUserChatHistory(userId, userName);
    });	
    
    $(document).on('click', '.sendChatButton', function(){
        var userId = $(this).data('touserid');
        sendMessage(userId);
    });

    $(document).on('keypress', '.chatMessage', function(e){
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            var userId = $(this).data('touserid');
            sendMessage(userId);
        }
    });
    
    $(document).on('click', '#btnBackUserChatList', function() {
        showUsersChatList();
    });

    $('#chatSearchInput').on('keyup', function() {
        var val = $(this).val().toLowerCase();
        $('.chat-contact').each(function() {
            var name = $(this).find('.font-weight-bold').text().toLowerCase();
            $(this).toggle(name.indexOf(val) > -1);
        });
    });
});

function showUsersChatList() {
    $.ajax({
        url: BASE_URL + 'instant_messaging/show_user_chat_list',
        method: 'POST',
        data:{action: 'showUserChatList'},
        success:function(data){
            $('#chatWindowContainer').html(data);
        }
    });
}

function showUserChatHistory(userId, userName){
    $.ajax({
        url: BASE_URL + 'instant_messaging/show_user_chat_history',
        method: 'POST',
        data:{receiverUserId: userId, receiverUserName: userName, action: 'showUserChatHistory'},
        success:function(data){
            $('#chatWindowContainer').html(data);
            $('#unread_' + userId).html('');
            $('.chatHistoryWindow').animate({scrollTop: 20000000}, 'fast');
        }
    });
}

function sendMessage(userId) {
    var message = $.trim($('#chatMessage_' + userId).val());
    if (message !== '') {
        $.ajax({
            url: BASE_URL + 'instant_messaging/insert_chat',
            method: 'POST',
            data:{receiverUserId: userId, message: message, action: 'insertChat'},
            success:function(data) {
                $('.chatHistoryWindow').html(data);
                $('.chatHistoryWindow').animate({scrollTop: 20000000}, 'fast');
                $('#chatMessage_' + userId).val('');
            }
	});
    }
}

function updateUserChatHistory() {
    $('.chatHistoryWindow').each(function() { 
        var userId = $(this).data('touserid');
        if (!userId) return;
        var wasAtBottom = this.scrollHeight - this.scrollTop - this.clientHeight < 50;
        $.ajax({
            url: BASE_URL + 'instant_messaging/update_user_chat_history',
            method: 'POST',
            data:{receiverUserId: userId, action: 'updateUserChatHistory'},
            success:function(data) {
                $('.chatHistoryWindow[data-touserid=' + userId + ']').html(data);
                if (wasAtBottom) {
                    $('.chatHistoryWindow[data-touserid=' + userId + ']').animate({scrollTop: 20000000}, 'fast');
                }
            }
        });
    });
}

function updateUnreadMessageCount() {
    $('.contact').each(function() {
        var userId = $(this).data('touserid');
        if (!userId) return;
        $.ajax({
            url: BASE_URL + 'instant_messaging/update_unread_message',
            method: 'POST',
            data:{receiverUserId: userId, action: 'updateUnreadMessage'},
            success:function(data){
                $('#unread_' + userId).html(data);
            }
        });
    });
}

function updateAllUnreadMessageCount() {
    $.ajax({
        url: BASE_URL + 'instant_messaging/update_all_unread_message',
        method: 'POST',
        data:{action: 'updateAllUnreadMessage'},
        success:function(data){
            if (data > 0) {
                $('#allUnreadToggle').show().html(data);
                $('#allUnread').removeAttr('hidden').html(data);
            } else {
                $('#allUnreadToggle').hide();
                $('#allUnread').attr('hidden', true);
            }
        }
    });
}

var chatOpen = false;
function chatPanelToggler() {
    var body = document.getElementById("chatBody");
    if (!chatOpen) {
        body.classList.add("open");
        chatOpen = true;
        showUsersChatList();
    } else {
        body.classList.remove("open");
        chatOpen = false;
    }
}
