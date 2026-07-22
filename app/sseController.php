<?php
require_once realpath(dirname(__FILE__)) . "/../config.inc.php";
require_once CORE_PATH . "Connection.php";
require_once LIBS_PATH . "Session.php";
require_once MODELS_PATH . "ChatMessageModel.php";
require_once DAO_PATH . "ChatMessageDAO.php";

if (!Session::is_started()) {
    http_response_code(403);
    exit;
}

$userId = $_SESSION['idUser'];

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no');

ob_implicit_flush(true);
ob_end_flush();

$lastUnreadCount = -1;
$lastMessages = array();

while (true) {
    Connection::open_connection();
    
    $allUnreadCount = ChatMessageDAO::get_all_unread_message_count(Connection::get_connection(), $userId);
    
    if ($allUnreadCount != $lastUnreadCount) {
        $lastUnreadCount = $allUnreadCount;
        echo "event: unreadCount\n";
        echo "data: " . ($allUnreadCount ?: 0) . "\n\n";
    }
    
    $activeReceiverId = $_SESSION['sse_active_chat'] ?? 0;
    if ($activeReceiverId > 0) {
        $unreadFrom = ChatMessageDAO::get_unread_message_count(
            Connection::get_connection(), $activeReceiverId, $userId
        );
        
        $cacheKey = $activeReceiverId . '_' . $unreadFrom;
        if (!isset($lastMessages[$cacheKey]) || $lastMessages[$cacheKey] != $unreadFrom) {
            $lastMessages[$cacheKey] = $unreadFrom;
            
            $conversation = ChatMessageDAO::get_chat_message(
                Connection::get_connection(), $userId, $activeReceiverId
            );
            
            $html = '<ul class="list-unstyled">';
            if ($conversation && !empty($conversation)) {
                foreach ($conversation as $msg) {
                    $cls = $msg->getSenderUserId() == $userId ? 'sent' : 'replies';
                    $html .= '<li class="' . $cls . '">';
                    $html .= '<p>' . str_replace(chr(10), "<br>", $msg->getMessage());
                    $html .= '<br><font size=1><small><em>' . $msg->getTimestamp() . '</em></small></font></p></li>';
                }
            }
            $html .= '</ul>';
            
            echo "event: chatUpdate\n";
            echo "data: " . json_encode([
                'receiverId' => $activeReceiverId,
                'html' => $html,
                'unreadFrom' => $unreadFrom
            ]) . "\n\n";
        }
    }
    
    Connection::close_connection();
    
    if (connection_aborted()) {
        break;
    }
    
    sleep(2);
}
