---
type: Reference
title: Testing & Security
description: PHPUnit test suite, CSRF protection, login rate limiting, input sanitization, and error handling in FictionPlanet
tags: [testing, security, phpunit, csrf, rate-limiting]
---

# Testing & Security

FictionPlanet includes a modest PHPUnit test suite and several security layers embedded across the codebase. There is no CI/CD pipeline — tests must be run manually.

## Test Suite

### Test Files

| Test | Source File | What It Tests |
|------|-------------|---------------|
| `LoginValidatorTest` | `/tests/LoginValidatorTest.php` | Login credential validation (valid, invalid email, wrong password, inactive user) |
| `NewUserValidatorTest` | `/tests/NewUserValidatorTest.php` | User registration validation (all required fields, uniqueness, password match) |
| `SessionTest` | `/tests/SessionTest.php` | Session start detection, login/logout lifecycle |
| `UserModelTest` | `/tests/UserModelTest.php` | UserModel getters/setters |

### Test Bootstrap

`/tests/bootstrap.php` configures a hardcoded test environment:
- Sets all core path and URL constants
- Loads all models, DAOs, core libraries, and validators
- Uses a separate database `fictionplanetdb_test` (must be created before running tests)
- Enables `APP_DEBUG=true`

### Running Tests

```bash
# Run all tests
composer test

# Run only unit tests
composer test:unit
```

Or directly with PHPUnit:

```bash
vendor/bin/phpunit
```

### Coverage

Code coverage is configured in `/phpunit.xml.dist` for:
- `/libs/` (core libraries)
- `/models/` (entity classes and DAOs)
- `/controllers/`

**Note**: The test suite requires a live MySQL/MariaDB database (`fictionplanetdb_test`) with the same schema as the main application. Tests are integration-level — they query a real database.

## Security Measures

### CSRF Protection

CSRF tokens are managed in `/libs/Session.php`:

```php
// Generate a 64-character hex token
Session::csrf_token();

// Hidden input field for forms
Session::csrf_input();  // <input type="hidden" name="csrf_token" value="...">

// Meta tag for AJAX requests
Session::csrf_meta();   // <meta name="csrf-token" content="...">

// Verify token (from POST or X-CSRF-Token header)
Session::verify_csrf(); // returns bool
```

Every mutation controller action validates the CSRF token before processing:

```php
if (!Session::verify_csrf()) {
    // Token validation failed
    http_response_code(403);
    echo json_encode(['error' => 'Token de seguridad invalido']);
    exit;
}
```

Controllers using CSRF validation: `Login`, `Users`, `Posts`, `Calendar`, `Image_gallery`, `Instant_messaging`.

### Login Rate Limiting

Implemented directly in `/controllers/Login.php`:

- Tracks login attempts in `$_SESSION['login_attempts']` (count + first attempt timestamp)
- After **5 failed attempts** within a **60-second window**, further attempts are blocked
- Blocked users see: *"Demasiados intentos. Espere X segundos."*
- The counter resets when 60 seconds have elapsed since the first failed attempt
- Successful login clears the counter

```php
$attempts = $_SESSION['login_attempts'] ?? ['count' => 0, 'first_at' => $now];
if ($attempts['count'] >= 5 && ($now - $attempts['first_at']) < 60) {
    // Block and show wait time
}
```

### Input Sanitization

All user input is sanitized with `htmlentities()` with `ENT_QUOTES` flag before use:

```php
$email = trim(htmlentities($_POST['emailLogin'], ENT_QUOTES));
```

The `h()` helper function in `/config.inc.php` provides a shorthand:

```php
function h($s) {
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}
```

### Password Hashing

Passwords are hashed with `password_hash()` (bcrypt, default cost) and verified with `password_verify()`:

```php
// Registration
password_hash($validator->get_password(), PASSWORD_DEFAULT)

// Login
password_verify($password, $user->get_password())
```

### Error Handling

`/libs/core/AppException.php` provides a custom exception handler registered in `/index.php`:

- **APP_DEBUG=true**: Shows error message in HTML `<pre>` tags (development mode)
- **APP_DEBUG=false**: Shows generic "internal server error" page (production mode)
- All errors are logged to `/php-error.log` regardless of debug mode
- Error reporting is set to `E_ALL`, but `display_errors` is disabled

### Session Security

- `Session::log_in()` stores user object, ID, username, role, and permissions in `$_SESSION`
- `Session::log_out()` unsets all session variables and calls `session_destroy()`
- Sessions are plain PHP sessions (no custom handler, no HTTPS enforcement, no session timeout)

> **Known Gaps**: Session fixation protection, HTTPS-only cookies, and session timeouts are not implemented. Consider adding `session_regenerate_id()` on login, `setcookie_params()` with secure/httponly flags, and a session TTL check.

## Related Pages

- [Architecture Overview](/openwiki/architecture/overview.md) — AppException, Session library, permission system
- [Users & Authentication Domain](/openwiki/domain/users-and-auth.md) — login flow, registration validation
- [Configuration](/openwiki/operations/configuration.md) — APP_DEBUG, error log path