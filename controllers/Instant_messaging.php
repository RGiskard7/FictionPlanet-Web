<?php
require_once realpath(dirname(__FILE__)) . "/../config.inc.php";

require_once CORE_PATH . "Connection.php";
require_once CORE_PATH . "Redirection.php";

require_once MODELS_PATH . "ChatMessageModel.php";
require_once MODELS_PATH . "UserModel.php";
require_once MODELS_PATH . "ContactModel.php";

require_once DAO_PATH . "UserDAO.php";
require_once DAO_PATH . "ChatMessageDAO.php";
require_once DAO_PATH . "ContactDAO.php";

require_once LIBS_PATH . "Session.php";

class Instant_messaging extends Controller {
    
    public function show_user_chat_list() {
        if ($this->check_chat_permissions()) {
            if (isset($_POST['action']) && $_POST['action'] === 'showUserChatList') {
                $usersChatList = array();
                
                Connection::open_connection();
                $contactObjectsArray = ContactDAO::get_all_contact_by_user_id(Connection::get_connection(), $_SESSION['idUser']);
                foreach ($contactObjectsArray as $contactObject) {
                    $usersChatList[] = UserDAO::get_user_by_id(Connection::get_connection(), $contactObject->get_contact_id());
                }
                //$usersChatList = UserDAO::get_all_user_other_than(Connection::get_connection(), $_SESSION['idUser']);
                Connection::close_connection();

                ob_start(); // Abrir buffer
                include TEMPLATES_PATH . 'user_chat_list.inc.php';
                $output = ob_get_contents();
                ob_end_clean(); // Carrar buffer

                echo $output;
            }
        }
        exit;
    }
    // Devuelve el historial del chat entre dos usuarios
    public function show_user_chat_history() {
        if ($this->check_chat_permissions()) {
            if (isset($_POST['action']) && $_POST['action'] === 'showUserChatHistory') {
                $senderUserId = $_SESSION['idUser'];
                $receiverUserId = $_POST['recieverUserId'];
                $recieverUserName = $_POST['recieverUserName'];

                Connection::open_connection();
                $conversation = ChatMessageDAO::get_chat_message(Connection::get_connection(), $senderUserId, $receiverUserId);
                Connection::close_connection();

                ob_start(); // Abrir buffer
                include TEMPLATES_PATH . 'chat_window.inc.php';
                $output = ob_get_contents();
                ob_end_clean(); // Carrar buffer

                Connection::open_connection();
                ChatMessageDAO::set_status_chat_message(Connection::get_connection(), $senderUserId, $receiverUserId, 0, 1); //Cambiar a visto
                Connection::close_connection();

                echo $output;
            }
        }
        exit;
    }
    
    public function update_user_chat_history() {
        if ($this->check_chat_permissions()) {
            if(isset($_POST['action']) && $_POST['action'] === 'updateUserChatHistory') {
                $conversation = $this->get_chat_history($_SESSION['idUser'], $_POST['recieverUserId']); //Refresh

                Connection::open_connection();
                ChatMessageDAO::set_status_chat_message(Connection::get_connection(), $_SESSION['idUser'], $_POST['recieverUserId'], 0, 1); //Cambiar a visto
                Connection::close_connection();

                echo $conversation;
            }
        }
        exit;
    }
    
    public function insert_chat() {
        if ($this->check_chat_permissions()) {
            if (isset($_POST['action']) && $_POST['action'] === 'insertChat') {
                $objectChatMessage = new ChatMessageModel(0, $_SESSION['idUser'], $_POST['recieverUserId'], $_POST['message'], 0, 0);

                Connection::open_connection();
                $result = ChatMessageDAO::insert_chat_message(Connection::get_connection(), $objectChatMessage);
                Connection::close_connection();

                if (isset($result) && !empty($result)) {
                    $conversation = $this->get_chat_history($_SESSION['idUser'], $_POST['recieverUserId']);
                } else {
                    $conversation = 'Error';
                }

                echo $conversation;
            }
        }
        exit;
    }
    
    public function update_unread_message() {
        if ($this->check_chat_permissions()) {
            if (isset($_POST['action']) && $_POST['action'] === 'updateUnreadMessage') {
                Connection::open_connection();
                $unreadMessage = ChatMessageDAO::get_unread_message_count(Connection::get_connection(), $_POST['recieverUserId'], $_SESSION['idUser']);
                Connection::close_connection();

                echo $unreadMessage;
            }
        }
        exit;
    }
    
    public function update_all_unread_message() {
        if ($this->check_chat_permissions()) {
            if (isset($_POST['action']) && $_POST['action'] === 'updateAllUnreadMessage') {
                Connection::open_connection();
                $allUnreadMessage = ChatMessageDAO::get_all_unread_message_count(Connection::get_connection(), $_SESSION['idUser']);
                Connection::close_connection();

                echo $allUnreadMessage;
            }
        }
        exit;
    }
    
    private function get_chat_history($senderUserId, $receiverUserId) {
        Connection::open_connection();
        $conversation = ChatMessageDAO::get_chat_message(Connection::get_connection(), $senderUserId, $receiverUserId);
        Connection::close_connection();

        $output = '<ul class="list-unstyled">';

        if (isset($conversation) && !empty($conversation)) {
            foreach($conversation as $message) {
                if ($message->getSenderUserId() == $senderUserId) {
                    $output .= '<li class="sent">';
                } else {
                    $output .= '<li class="replies">';
                }

                $output .= '<p>' . str_replace(chr(10),"<br>",$message->getMessage()) . '<br><font size=1>'
                        . '<small><em>' .$message->getTimestamp(). '</em></small></font></p></li>';
            }
        } else {
            $output .= "<li>Chat vaío</li>";
        }

        $output .= '</ul>';

        return $output;
    }
    
    private function check_chat_permissions() {
        if (Session::is_started() && $_SESSION['permissions'][MDL_CHAT]['r'] 
                && $_SESSION['permissions'][MDL_CHAT]['w'] && $_SESSION['permissions'][MDL_CHAT]['u'] 
                && $_SESSION['permissions'][MDL_CHAT]['d']) {
            return true;
        }
        return false;
    }
}
?>

