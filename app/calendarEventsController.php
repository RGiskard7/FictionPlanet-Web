<?php
require_once realpath(dirname(__FILE__)) . "/../config.inc.php";

require_once CORE_PATH . "Connection.php";
require_once CORE_PATH . "Redirection.php";

require_once MODELS_PATH . "CalendarEventModel.php";
require_once DAO_PATH . "CalendarEventsDAO.php";

require_once LIBS_PATH . "Session.php";

if (isset($_POST["action"]) && $_POST["action"] === "view") {
    header('Content-Type: application/json');
    
    $start = htmlentities(addslashes($_POST['start']), ENT_QUOTES);
    $end = htmlentities(addslashes($_POST["end"]), ENT_QUOTES);

    Connection::open_connection();
    $result = CalendarEventsDAO::get_calendar_events_by_dates(Connection::get_connection(), $start, $end);
    Connection::close_connection();

    $events = array();

    foreach($result as $row) {
        $events[] = ['id' => $row->get_id(), 'start' => $row->get_start(), 'end' => $row->get_end(), 
            'title' => html_entity_decode($row->get_title(), ENT_QUOTES, "UTF-8"), 'color' => $row->get_color()];
    }
    
    $response = json_encode($events);

    echo $response;
    exit;
}
/*****************************************************************/
if (isset($_POST["submitNewEvent"])) {
    $start = date('Y-m-d H:i:s', strtotime(htmlentities(addslashes($_POST['start']), ENT_QUOTES)));
    $end = date('Y-m-d H:i:s', strtotime(htmlentities(addslashes($_POST["end"]), ENT_QUOTES)));
    $title = htmlentities(addslashes($_POST['title']), ENT_QUOTES);
    $color = htmlentities(addslashes($_POST['color']), ENT_QUOTES);

    $objectCalendarEvents = new CalendarEventModel(0, $start, $end, $title, $color);

    Connection::open_connection();
    CalendarEventsDAO::insert_calendar_event(Connection::get_connection(), $objectCalendarEvents);
    Connection::close_connection();

    Redirection::redirect($_SERVER['HTTP_REFERER']);
}
/*****************************************************************/
if (isset($_POST["submitUpdateEvent"])) {
    $start = date('Y-m-d H:i:s', strtotime(htmlentities(addslashes($_POST['start']), ENT_QUOTES)));
    $end = date('Y-m-d H:i:s', strtotime(htmlentities(addslashes($_POST["end"]), ENT_QUOTES)));
    $title = htmlentities(addslashes($_POST['title']), ENT_QUOTES);
    $color = htmlentities(addslashes($_POST['color']), ENT_QUOTES);
    
    $objectCalendarEvents = new CalendarEventModel($_POST["id"], $start, $end, $title, $color);

    echo $objectCalendarEvents->get_start();
    echo $objectCalendarEvents->get_end();
    
    Connection::open_connection();
    CalendarEventsDAO::update_calendar_event(Connection::get_connection(), $objectCalendarEvents);
    Connection::close_connection();

    Redirection::redirect($_SERVER['HTTP_REFERER']);
}
/*****************************************************************/
if (isset($_POST["submitDeleteEvent"])) {
    Connection::open_connection();
    $objectCalendarEvents = CalendarEventsDAO::get_calendar_event_by_id(Connection::get_connection(), $_POST["id"]);
    CalendarEventsDAO::delete_calendar_event(Connection::get_connection(), $objectCalendarEvents);
    Connection::close_connection();

    Redirection::redirect($_SERVER['HTTP_REFERER']);
}
?>

