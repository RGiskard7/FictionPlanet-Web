<?php
require_once realpath(dirname(__FILE__)) . "/../config.inc.php";

require_once CORE_PATH . "Connection.php";
require_once CORE_PATH . "Redirection.php";

require_once MODELS_PATH . "CalendarEventModel.php";
require_once DAO_PATH . "CalendarEventsDAO.php";

require_once LIBS_PATH . "Session.php";

if (!Session::is_started() || !$_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['r']) {
    http_response_code(403);
    exit;
}

// View: listar eventos (lectura, publico)
if (isset($_POST["action"]) && $_POST["action"] === "view") {
    header('Content-Type: application/json');

    $start = htmlentities($_POST['start'], ENT_QUOTES);
    $end = htmlentities($_POST["end"], ENT_QUOTES);

    Connection::open_connection();
    $result = CalendarEventsDAO::get_calendar_events_by_dates(Connection::get_connection(), $start, $end);
    Connection::close_connection();

    $events = array();
    if ($result) {
        foreach($result as $row) {
            $events[] = [
                'id' => $row->get_id(),
                'start' => $row->get_start(),
                'end' => $row->get_end(),
                'title' => html_entity_decode($row->get_title(), ENT_QUOTES, "UTF-8"),
                'color' => $row->get_color()
            ];
        }
    }

    echo json_encode($events);
    exit;
}

// Mutaciones requieren CSRF + permiso de escritura
if (!Session::verify_csrf()) {
    http_response_code(403);
    echo json_encode(['error' => 'Token de seguridad invalido']);
    exit;
}

// Create
if (isset($_POST["submitNewEvent"])) {
    if (!$_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['w']) {
        http_response_code(403);
        exit;
    }

    $start = date('Y-m-d H:i:s', strtotime(htmlentities($_POST['start'], ENT_QUOTES)));
    $end = date('Y-m-d H:i:s', strtotime(htmlentities($_POST["end"], ENT_QUOTES)));
    $title = htmlentities($_POST['title'], ENT_QUOTES);
    $color = htmlentities($_POST['color'], ENT_QUOTES);

    $objectCalendarEvents = new CalendarEventModel(0, $start, $end, $title, $color);

    Connection::open_connection();
    CalendarEventsDAO::insert_calendar_event(Connection::get_connection(), $objectCalendarEvents);
    Connection::close_connection();

    Redirection::redirect(BASE_URL);
    exit;
}

// Update
if (isset($_POST["submitUpdateEvent"])) {
    if (!$_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['u']) {
        http_response_code(403);
        exit;
    }

    $start = date('Y-m-d H:i:s', strtotime(htmlentities($_POST['start'], ENT_QUOTES)));
    $end = date('Y-m-d H:i:s', strtotime(htmlentities($_POST["end"], ENT_QUOTES)));
    $title = htmlentities($_POST['title'], ENT_QUOTES);
    $color = htmlentities($_POST['color'], ENT_QUOTES);

    $objectCalendarEvents = new CalendarEventModel($_POST["id"], $start, $end, $title, $color);

    Connection::open_connection();
    CalendarEventsDAO::update_calendar_event(Connection::get_connection(), $objectCalendarEvents);
    Connection::close_connection();

    Redirection::redirect(BASE_URL);
    exit;
}

// Delete
if (isset($_POST["submitDeleteEvent"])) {
    if (!$_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['d']) {
        http_response_code(403);
        exit;
    }

    Connection::open_connection();
    $objectCalendarEvents = CalendarEventsDAO::get_calendar_event_by_id(Connection::get_connection(), $_POST["id"]);
    if ($objectCalendarEvents) {
        CalendarEventsDAO::delete_calendar_event(Connection::get_connection(), $objectCalendarEvents);
    }
    Connection::close_connection();

    Redirection::redirect(BASE_URL);
    exit;
}
