# nShell Stateful Session Implementation Plan

**Goal:** Implement fully stateful, persistent shell sessions for nShell in Nextcloud. Each session must maintain its shell state, survive across PHP requests, and support multiple users securely.

---

## 1. Database-backed Session Manager

### 1.1. Migration
- **Path:** `apps/nshell/lib/Migration/VersionYYYYMMDDXXXX.php`
- **Table:** `nshell_sessions`
- **Columns:**
    - `id` (string, 64, PK) — session ID (nshell_XXXX)
    - `user_id` (string, 64, not null)
    - `created_at` (datetime, not null)
    - `last_activity` (datetime, optional) — for idle timeout tracking

### 1.2. Entity
- **Path:** `lib/Db/Session.php`
- **Namespace:** `OCA\nShell\Db`
- **Properties:** `$id`, `$userId`, `$createdAt`, `$lastActivity`
- **Extends:** `OCP\AppFramework\Db\Entity`

### 1.3. Mapper
- **Path:** `lib/Db/SessionMapper.php`
- **Namespace:** `OCA\nShell\Db`
- **Extends:** `OCP\AppFramework\Db\QBMapper`
- **Methods:** `find()`, `insert()`, `delete()`

### 1.4. SessionManager Service
- **Path:** `lib/Service/SessionManager.php`
- **Namespace:** `OCA\nShell\Service`
- **Constructor:** Injects `SessionMapper`
- **Methods:** `create()`, `get()`, `delete()`, `touch()` (optional)

### 1.5. DI Registration
- Register `SessionMapper` and `SessionManager` in `lib/AppInfo/Application.php`.

---

## 2. Persistent Shell Process Management

### 2.1. ShellProcess Class
- **Path:** `lib/Service/ShellProcess.php`
- **Namespace:** `OCA\nShell\Service`
- **Responsibilities:** Spawn shell attached to a pseudo-terminal, maintain file descriptor handles, track PID.

### 2.2. ShellProcessManager
- **Path:** `lib/Service/ShellProcessManager.php`
- **Responsibilities:** Map session IDs to live shell processes, start/stop/manage processes, handle I/O.

---

## 3. WebSocket Bridge (or alternative stateful connection)

### 3.1. WebSocket Server / Daemon
- **Path:** `bin/daemon.php` (or similar)
- **Responsibilities:** Accept connections, associate with session ID, forward I/O between frontend and `ShellProcessManager`.

### 3.2. Controller Updates
- **/start:** Creates DB session and starts the shell process via `ShellProcessManager`.
- **/exec:** (To be deprecated/removed in favor of WebSocket) Handles command execution.
- **/stop:** Deletes DB session and terminates the shell process.

---

## 4. Frontend Updates
- Fetch session ID from `/start`.
- Establish WebSocket connection.
- Send commands and display output via WebSocket messages.
- Implement idle warnings and auto-disconnect.

---

## 5. Cleanup and Security
- Implement idle session timeout to terminate backend processes.
- Implement max session lifetime (optional).
- Ensure shell processes run under a restricted user context.
- Enforce strict user isolation.

---

## Outcome
- The "Session not found" error is resolved.
- The terminal becomes fully stateful, with session state (like current directory) persisting.
- Sessions are secure, manageable, and support multiple users.
