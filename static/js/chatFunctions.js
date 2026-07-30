$(document).ready(function() {
    showUsersChatList();
     
    setInterval(function() {
        updateUserChatHistory();
        updateUnreadMessageCount();
        updateAllUnreadMessageCount();
    }, 1000);
           
    $(document).on('click', '.startChatButton', function(){
        var recieverUserId = $(this).data('touserid');
        var recieverUserName = $(this).data('tousername');
        showUserChatHistory(recieverUserId, recieverUserName);
    });	
    
    $(document).on('click', '.sendChatButton', function(){
        var recieverUserId = $(this).data('touserid');
        sendMessage(recieverUserId);
    });
    
    $(document).on('click', '#btnBackUserChatList', function() {
        showUsersChatList();
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

function showUserChatHistory(recieverUserId, recieverUserName){
    $.ajax({
        url: BASE_URL + 'instant_messaging/show_user_chat_history',
        method: 'POST',
        data:{receiverUserId: recieverUserId, receiverUserName: recieverUserName, action: 'showUserChatHistory'},
        success:function(data){
            $('#chatWindowContainer').html(data);
            $('#chatMessage_' + recieverUserId).emojioneArea({
                pickerPosition: 'top',
                toneStyle: 'bullet',
                inline: null,
                autocomplete: false
            });
            $('#unread_' + recieverUserId).html('');
            $('.chatHistoryWindow').animate({scrollTop: 20000000}, 'fast');
        }
    });
}

function sendMessage(recieverUserId) {
    var message = $.trim($('#chatMessage_' + recieverUserId).val());
    if (message !== '') {
        $.ajax({
            url: BASE_URL + 'instant_messaging/insert_chat',
            method: 'POST',
            data:{receiverUserId: recieverUserId, message: message, action: 'insertChat'},
            success:function(data) {
                $('.chatHistoryWindow').html(data);
                $('.chatHistoryWindow').animate({scrollTop: 20000000}, 'fast');
                
                var element = $('#chatMessage_' + recieverUserId).emojioneArea();
                element[0].emojioneArea.setText('');
            }
	});
    }
}

function isElementVisible(elem) {
    var $elem = $(elem);
    var $window = $(window);

    var docViewTop = $window.scrollTop();
    var docViewBottom = docViewTop + $window.height();

    var elemTop = $elem.offset().top;
    var elemBottom = elemTop + $elem.height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

function updateUserChatHistory() {
    // each itera sobre elementos de una clase, si el elemento no esta en el doom
    $('.chatHistoryWindow').each(function() { 
        //console.log("chatHistory visible");
        var recieverUserId = $(this).data('touserid');
        $.ajax({
            url: BASE_URL + 'instant_messaging/update_user_chat_history',
            method: 'POST',
            data:{receiverUserId: recieverUserId, action: 'updateUserChatHistory'},
            success:function(data) {
                $('.chatHistoryWindow').html(data);
                
                if (isElementVisible($('.chatHistoryWindow ul li:last'))) {
                    $('.chatHistoryWindow').animate({scrollTop: 20000000}, 'fast');
                }
            }
        });
    });
    //console.log("fuera del for");
}

function updateUnreadMessageCount() {
    $('.contact').each(function() {
        var recieverUserId = $(this).data('touserid');
        $.ajax({
            url: BASE_URL + 'instant_messaging/update_unread_message',
            method: 'POST',
            data:{receiverUserId:recieverUserId, action: 'updateUnreadMessage'},
            success:function(data){
                $('#unread_' + recieverUserId).html(data);					
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
        // Al cerrar el menu desplegable del chat, se cierra el chat abierto
        showUsersChatList(); 
        chatOpen = false;
    } else {
        document.getElementById("chatSidebar").style.width = "0px"; // 85px
        document.getElementById("scroll").style.right = "20px";
        chatOpen = true;
    }
}