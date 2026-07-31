---
type: Domain
title: Calendar Domain
description: Public event calendar with FullCalendar integration, JSON API endpoints, and role-based event CRUD in FictionPlanet
tags: [domain, calendar, events, fullcalendar]
---

# Calendar Domain

The Calendar provides a public event display using **FullCalendar** (jQuery plugin) with full CRUD operations for events. Events have start/end datetimes, a title, and a color label.

## Key Source Files

| File | Role |
|------|------|
| `/controllers/Calendar.php` | Event CRUD controller — JSON API + form processing |
| `/models/CalendarEventModel.php` | Calendar event entity |
| `/models/dao/CalendarEventsDAO.php` | Event SQL queries (date-range, insert, update, delete) |
| `/static/js/main.js` | FullCalendar initialization and event handling |
| `/static/css/fullcalendar.min.css` | FullCalendar styles |

## Event Entity (`CalendarEventModel`)

- **id** (auto-increment)
- **start** (datetime), **end** (datetime)
- **title** (text), **color** (hex color string, e.g. `#3788d8`)

The database table `calendar_events` uses a simple flat schema with no user-ownership — events are public.

## Calendar Controller (`Calendar`)

All actions require `MDL_PUBLIC_CALENDAR` (module 4) permissions.

### JSON API

| Method | HTTP Verb | Description |
|--------|-----------|-------------|
| `view()` | POST with `start`/`end` | Returns events between two dates as JSON array |
| `create()` | POST with `submitNewEvent` | Creates a new event, redirects to home |
| `update()` | POST with event data | Updates an existing event |
| `delete()` | POST with event id | Deletes an event |

### `view()` — Event Fetching

1. Validates session and `MDL_PUBLIC_CALENDAR['r']` permission
2. Receives `start` and `end` POST parameters (ISO date strings) for the viewport range
3. Calls `CalendarEventsDAO::get_calendar_events_by_dates()` to query events in range
4. Returns JSON array with `id`, `start`, `end`, `title`, `color` per event
5. Titles are decoded with `html_entity_decode()` before JSON output

### `create()` — Event Creation

1. Validates session and `MDL_PUBLIC_CALENDAR['w']` permission
2. Validates CSRF token via `Session::verify_csrf()`
3. Sanitizes all inputs with `htmlentities()` and converts to `Y-m-d H:i:s` format
4. Creates a `CalendarEventModel` and calls `CalendarEventsDAO::insert_calendar_event()`
5. Redirects to home on success

### `update()` — Event Modification

1. Validates session and `MDL_PUBLIC_CALENDAR['u']` permission
2. Validates CSRF token
3. Updates via `CalendarEventsDAO::update_calendar_event()`

### `delete()` — Event Deletion

1. Validates session and `MDL_PUBLIC_CALENDAR['d']` permission
2. Validates CSRF token
3. Deletes via `CalendarEventsDAO::delete_calendar_event()`

## Frontend Integration

FullCalendar is initialized in `/views/home.php` which includes the calendar modal. The homepage includes:

- `templates/modals/calendar_modal.inc.php` — displays the calendar
- `templates/modals/new_event_calendar_modal.inc.php` — create/edit event form (only shown if user has write permission)

The main FullCalendar setup is in `/static/js/main.js`, which:
- Configures the calendar with `selectable: true`, `editable: false` (server-side CRUD)
- Fetches events via AJAX POST to `Calendar/view` with the visible date range
- Opens a modal for event creation on date click
- Handles event drag/resize via update API

## Permission Checks

All calendar methods check `$_SESSION['permissions'][MDL_PUBLIC_CALENDAR]` with:
- `['r']` for viewing events
- `['w']` for creating events
- `['u']` for updating events
- `['d']` for deleting events

The homepage always shows the calendar, but the create-event modal and calendar interaction controls are gated on write permission.

## Related Pages

- [Architecture Overview](/openwiki/architecture/overview.md) — permission system, module constants, Session CSRF
- [Configuration](/openwiki/operations/configuration.md) — `MDL_PUBLIC_CALENDAR` constant (value 4)
- [Testing & Security](/openwiki/testing-and-security.md) — CSRF token validation pattern