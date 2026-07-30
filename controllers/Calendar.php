<?php
require_once MODELS_PATH . "CalendarEventModel.php";
require_once DAO_PATH . "CalendarEventsDAO.php";

class Calendar extends Controller {

    public function calendar() {
        $this->view();
    }

    public function view() {
        if (!Session::is_started() || !($_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['r'] ?? 0)) {
            http_response_code(403);
            exit;
        }

        header('Content-Type: application/json');

        if (!isset($_POST['start']) || !isset($_POST['end'])) {
            echo json_encode([]);
            exit;
        }

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

    public function create() {
        if (!Session::is_started() || !($_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['w'] ?? 0)) {
            http_response_code(403);
            exit;
        }

        if (!Session::verify_csrf()) {
            http_response_code(403);
            echo json_encode(['error' => 'Token de seguridad invalido']);
            exit;
        }

        if (isset($_POST["submitNewEvent"])) {
            $start = date('Y-m-d H:i:s', strtotime(htmlentities($_POST['start'], ENT_QUOTES)));
            $end = date('Y-m-d H:i:s', strtotime(htmlentities($_POST["end"], ENT_QUOTES)));
            $title = htmlentities($_POST['title'], ENT_QUOTES);
            $color = htmlentities($_POST['color'], ENT_QUOTES);

            $objectCalendarEvents = new CalendarEventModel(0, $start, $end, $title, $color);

            Connection::open_connection();
            CalendarEventsDAO::insert_calendar_event(Connection::get_connection(), $objectCalendarEvents);
            Connection::close_connection();

            Redirection::redirect(BASE_URL);
        }
    }

    public function update() {
        if (!Session::is_started() || !($_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['u'] ?? 0)) {
            http_response_code(403);
            exit;
        }

        if (!Session::verify_csrf()) {
            http_response_code(403);
            echo json_encode(['error' => 'Token de seguridad invalido']);
            exit;
        }

        if (isset($_POST["submitUpdateEvent"])) {
            $start = date('Y-m-d H:i:s', strtotime(htmlentities($_POST['start'], ENT_QUOTES)));
            $end = date('Y-m-d H:i:s', strtotime(htmlentities($_POST["end"], ENT_QUOTES)));
            $title = htmlentities($_POST['title'], ENT_QUOTES);
            $color = htmlentities($_POST['color'], ENT_QUOTES);

            $objectCalendarEvents = new CalendarEventModel($_POST["id"], $start, $end, $title, $color);

            Connection::open_connection();
            CalendarEventsDAO::update_calendar_event(Connection::get_connection(), $objectCalendarEvents);
            Connection::close_connection();

            Redirection::redirect(BASE_URL);
        }
    }

    public function delete() {
        if (!Session::is_started() || !($_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['d'] ?? 0)) {
            http_response_code(403);
            exit;
        }

        if (!Session::verify_csrf()) {
            http_response_code(403);
            echo json_encode(['error' => 'Token de seguridad invalido']);
            exit;
        }

        if (isset($_POST["submitDeleteEvent"])) {
            Connection::open_connection();
            $objectCalendarEvents = CalendarEventsDAO::get_calendar_event_by_id(Connection::get_connection(), $_POST["id"]);
            if ($objectCalendarEvents) {
                CalendarEventsDAO::delete_calendar_event(Connection::get_connection(), $objectCalendarEvents);
            }
            Connection::close_connection();

            Redirection::redirect(BASE_URL);
        }
    }
}
