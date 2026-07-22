$(document).ready(function() {
    showUsersChatList();
    
    if (typeof(EventSource) !== "undefined") {
        var sseSource = new EventSource(BASE_URL + '/app/sseController.php');
        
        sseSource.addEventListener('unreadCount', function(e) {
            var count = parseInt(e.data);
            if (count > 0) {
                $('#allUnread, #allUnread2').removeAttr('hidden').html(count);
            } else {
                $('#allUnread, #allUnread2').attr('hidden', true);
            }
        });
        
        sseSource.addEventListener('chatUpdate', function(e) {
            var data = JSON.parse(e.data);
            var chatWindow = $('.chatHistoryWindow[data-touserid="' + data.receiverId + '"]');
            if (chatWindow.length) {
                var wasAtBottom = chatWindow.scrollTop() + chatWindow.innerHeight() >= chatWindow[0].scrollHeight - 50;
                chatWindow.html(data.html);
                if (wasAtBottom) {
                    chatWindow.animate({scrollTop: chatWindow[0].scrollHeight}, 'fast');
                }
            }
            if (data.unreadFrom) {
                $('#unread_' + data.receiverId).html(data.unreadFrom);
            }
        });
        
        sseSource.onerror = function() {
            console.log('SSE connection lost, reconnecting...');
        };
    } else {
        setInterval(function() {
            updateAllUnreadMessageCount();
        }, 3000);
    }
           
    $(document).on('click', '.startChatButton', function(){
        var receiverUserId = $(this).data('touserid');
        var receiverUserName = $(this).data('tousername');
        showUserChatHistory(receiverUserId, receiverUserName);
    });	
    
    $(document).on('click', '.sendChatButton', function(){
        var receiverUserId = $(this).data('touserid');
        sendMessage(receiverUserId);
    });
    
    $(document).on('click', '#btnBackUserChatList', function() {
        $.ajax({
            url: BASE_URL + '/instant_messaging/close_active_chat',
            method: 'POST',
            data: { action: 'closeActiveChat' }
        });
        showUsersChatList();
    });
});

function setActiveChat(receiverUserId) {
    $.ajax({
        url: BASE_URL + '/instant_messaging/set_active_chat',
        method: 'POST',
        data: { receiverUserId: receiverUserId, action: 'setActiveChat' }
    });
}

function showUsersChatList() {
    $.ajax({
        url: BASE_URL + '/instant_messaging/show_user_chat_list',
        method: 'POST',
        data:{action: 'showUserChatList'},
        success:function(data){
            $('#chatWindowContainer').html(data);
        }
    });
}

function showUserChatHistory(receiverUserId, receiverUserName){
    $.ajax({
        url: BASE_URL + '/instant_messaging/show_user_chat_history',
        method: 'POST',
        data:{receiverUserId: receiverUserId, receiverUserName: receiverUserName, action: 'showUserChatHistory'},
        success:function(data){
            $('#chatWindowContainer').html(data);
            $('#chatMessage_' + receiverUserId).emojioneArea({
                pickerPosition: 'top',
                toneStyle: 'bullet',
                inline: null,
                autocomplete: false
            });
            $('#unread_' + receiverUserId).html('');
            $('.chatHistoryWindow').animate({scrollTop: 20000000}, 'fast');
            
            setActiveChat(receiverUserId);
        }
    });
}

function sendMessage(receiverUserId) {
    var message = $.trim($('#chatMessage_' + receiverUserId).val());
    if (message !== '') {
        $.ajax({
            url: BASE_URL + '/instant_messaging/insert_chat',
            method: 'POST',
            data:{receiverUserId: receiverUserId, message: message, action: 'insertChat'},
            success:function(data) {
                $('.chatHistoryWindow').html(data);
                $('.chatHistoryWindow').animate({scrollTop: 20000000}, 'fast');
                
                var element = $('#chatMessage_' + receiverUserId).emojioneArea();
                element[0].emojioneArea.setText('');
            }
	});
    }
}

function updateAllUnreadMessageCount() {
    $.ajax({
        url: BASE_URL + '/instant_messaging/update_all_unread_message',
        method: 'POST',
        data:{action: 'updateAllUnreadMessage'},
        success:function(data){
            if (data > 0) {
                $('#allUnread').removeAttr('hidden');
                $('#allUnread').html(data);
                
                $('#allUnread2').removeAttr('hidden');
                $('#allUnread2').html(data);
            } else {
                $('#allUnread').attr('hidden', true);
                
                $('#allUnread2').attr('hidden', true);
            }		
        }
    });
}

var chatOpen = true;
function chatSidebarToggler() {
    var mediaQuery = window.matchMedia('(max-width: 768px)');
    if (chatOpen) {
        if (mediaQuery.matches) {
            document.getElementById("chatSidebar").style.width = "100%";
        } else {
            document.getElementById("chatSidebar").style.width = "447px";
        }
        document.getElementById("scroll").style.right = "465px";
        showUsersChatList(); 
        chatOpen = false;
    } else {
        document.getElementById("chatSidebar").style.width = "0px";
        document.getElementById("scroll").style.right = "20px";
        chatOpen = true;
    }
}
