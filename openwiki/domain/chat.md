---
type: Domain
title: Instant Messaging (Chat) Domain
description: Real-time contact-based messaging system with read status tracking, conversation history, and polling-based updates in FictionPlanet
tags: [domain, chat, messaging, real-time]
---

# Instant Messaging (Chat) Domain

The Chat system provides real-time messaging between contacts. It uses a **polling-based** approach (periodic AJAX requests) rather than WebSockets or Server-Sent Events.

## Key Source Files

| File | Role |
|------|------|
| `/controllers/Instant_messaging.php` | Chat controller — all chat AJAX endpoints |
| `/models/ChatMessageModel.php` | Chat message entity |
| `/models/ContactModel.php` | Contact relationship entity |
| `/models/dao/ChatMessageDAO.php` | Message SQL queries |
| `/models/dao/ContactDAO.php` | Contact SQL queries |
| `/templates/chat_window.inc.php` | Chat message window template |
| `/templates/user_chat_list.inc.php` | Contact list for chat sidebar |
| `/templates/nav/chat_sidebar.inc.php` | Chat sidebar panel |
| `/static/js/chatFunctions.js` | Chat polling and UI logic |

## Chat Message Entity (`ChatMessageModel`)

- **id**, **sender_user_id**, **reciever_user_id** (FKs to users)
- **message** (text — note: `reciever` is a persistent typo in the DB column name)
- **timestamp** (auto-set to `current_timestamp()`)
- **status** (0 = unread, 1 = read)

## Chat Controller (`Instant_messaging`)

All actions are AJAX-only (check for `$_POST['action']` values) and require chat permissions via `check_chat_permissions()`.

### Actions

| Method | `$_POST['action']` | Description |
|--------|-------------------|-------------|
| `show_user_chat_list()` | `showUserChatList` | Load contact list for chat sidebar |
| `show_user_chat_history()` | `showUserChatHistory` | Load conversation with a contact |
| `update_user_chat_history()` | `updateUserChatHistory` | Refresh conversation (polling) |
| `insert_chat()` | `insertChat` | Send a new message |
| `get_unread_message_number()` | `getUnreadMessageNumber` | Get unread message count |
| `get_unread_messages()` | `getUnreadMessages` | Get unread message list |
| `mark_as_read()` | `markAsRead` | Mark messages as read |

### Chat Flow

1. **Contact List**: `show_user_chat_list()` loads the user's contacts from `ContactDAO` and renders the `user_chat_list.inc.php` template
2. **Open Conversation**: `show_user_chat_history()` loads the full conversation between two users via `ChatMessageDAO::get_chat_message()`, marks all messages as read, and renders the `chat_window.inc.php` template
3. **Send Message**: `insert_chat()` creates a `ChatMessageModel`, inserts via `ChatMessageDAO::insert_chat_message()`, and returns the updated conversation
4. **Polling**: `update_user_chat_history()` is called periodically by the client to refresh the conversation and mark new messages as read
5. **Notifications**: `get_unread_message_number()` and `get_unread_messages()` drive the unread badge in the chat sidebar

### Permission Check

`check_chat_permissions()` verifies `Session::is_started()` and `$_SESSION['permissions'][MDL_CHAT]['r']`.

## Chat UI

- **Chat Sidebar** (`nav/chat_sidebar.inc.php`): panel listing contacts with online status and unread counts
- **Contact List** (`user_chat_list.inc.php`): clickable contact entries
- **Chat Window** (`chat_window.inc.php`): message bubbles with timestamps
- **JavaScript** (`chatFunctions.js`): polling loop, message sending, conversation switching, unread notification polling

## Database Schema

The `chat_message` table has:
- `sender_user_id` → FK to `users(id)` (CASCADE)
- `reciever_user_id` → FK to `users(id)` (CASCADE)
- `status` tinyint: 0 = unread, 1 = read

## Related Pages

- [Architecture Overview](/openwiki/architecture/overview.md) — AJAX pattern, session management
- [Users & Auth](/openwiki/domain/users-and-auth.md) — contacts, friend requests, permissions
- [Configuration](/openwiki/operations/configuration.md) — module constants