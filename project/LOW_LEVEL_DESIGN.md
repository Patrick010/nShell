# Low-Level Design (LLD) – nShell

## 1. Purpose
This LLD describes the specific implementation details of the nShell components, expanding on the High-Level Design. It details the responsibilities of each class and script in the system, reflecting the stateful architecture.

---

## 2. App Registration (`appinfo/`)
This section remains as-is. It defines the standard Nextcloud application manifest (`info.xml`) and bootstrap class (`app.php`). The `app.php` file will be updated to register the new services as described in the Dependency Injection section.

---

## 3. Database Layer (`lib/Db/`)

This new layer handles all database interactions for session persistence.

*   **`Migration/VersionYYYYMMDDXXXX.php`**
    *   **Purpose:** To create the `nshell_sessions` table in the Nextcloud database.
    *   **Responsibilities:** Implements `OCP\Migration\ISimpleMigration`, defining the schema for the `nshell_sessions` table with columns for `id`, `user_id`, `created_at`, and `last_activity`.

*   **`Session.php` (Entity)**
    *   **Purpose:** Represents a single record from the `nshell_sessions` table.
    *   **Extends:** `OCP\AppFramework\Db\Entity`
    *   **Properties:** Contains public properties that map to the table columns: `$id`, `$userId`, `$createdAt`, `$lastActivity`.

*   **`SessionMapper.php`**
    *   **Purpose:** Provides a data access layer for the `Session` entity.
    *   **Extends:** `OCP\AppFramework\Db\QBMapper`
    *   **Responsibilities:**
        *   `find(string $id)`: Retrieves a session entity from the database by its ID.
        *   `insert(Session $session)`: Saves a new session entity to the database.
        *   `delete(Session $session)`: Removes a session entity from the database.
        *   `findExpired(int $timeout)`: (Optional) Finds all sessions where `last_activity` is older than the timeout.

---

## 4. Core Backend Services (`lib/Service/`)

This layer contains the core business logic for managing sessions and processes.

*   **`SessionManager.php`**
    *   **Purpose:** To manage the lifecycle of session *records* in the database.
    *   **Responsibilities:**
        *   `create(string $userId)`: Creates a new `Session` entity, assigns a unique `nshell_` prefixed ID, saves it to the database via the `SessionMapper`, and returns the entity.
        *   `get(string $id)`: Retrieves a session record from the database.
        *   `delete(string $id)`: Deletes a session record from the database.
        *   `touch(string $id)`: (Optional) Updates the `last_activity` timestamp for a session.

*   **`ShellProcess.php`**
    *   **Purpose:** To encapsulate a single, live shell process.
    *   **Responsibilities:**
        *   Spawns a shell (e.g., `rbash`) using `proc_open`, attached to a pseudo-terminal (PTY) to allow for interactive state.
        *   Holds the process handle and the file descriptors for stdin, stdout, and stderr.
        *   Contains methods to write to the shell's stdin and read from its stdout/stderr.

*   **`ShellProcessManager.php`**
    *   **Purpose:** A singleton or long-running service that manages all active `ShellProcess` instances.
    *   **Responsibilities:**
        *   Maintains an in-memory map of `sessionId` to `ShellProcess` objects.
        *   `startProcess(string $sessionId)`: Creates a new `ShellProcess` instance and adds it to the map.
        *   `getProcess(string $sessionId)`: Retrieves an active `ShellProcess` from the map.
        *   `handleInput(string $sessionId, string $input)`: Forwards input to the correct shell process.
        *   `readOutput(string $sessionId)`: Reads any available output from a shell process.
        *   `stopProcess(string $sessionId)`: Terminates a shell process and removes it from the map.

---

## 5. Controller Layer (`lib/Controller/`)

The role of the controller layer is now limited to stateless session initiation and termination.

*   **`TerminalController.php`**
    *   **Responsibilities:**
        *   `start()`:
            1.  Calls `SessionManager->create()` to create a database record.
            2.  Communicates with the `ShellProcessManager` (e.g., via IPC or a local command) to start the associated shell process.
            3.  Returns a JSON response with the `{ "sessionId": "..." }`.
        *   `stop(string $sessionId)`:
            1.  Calls `SessionManager->delete()` to remove the database record.
            2.  Communicates with the `ShellProcessManager` to terminate the associated shell process.
            3.  Returns a success/failure response.
        *   The `handleIO` method is now obsolete and will be removed, as all I/O is handled by the WebSocket server.

---

## 6. Executable Scripts (`bin/`)

*   **`daemon.php`**
    *   **Purpose:** The long-running WebSocket server.
    *   **Responsibilities:**
        *   Listens for incoming WebSocket connections from the frontend.
        *   Upon connection, authenticates the user and the `sessionId`.
        *   Acts as a bridge, forwarding messages between the client's WebSocket and the `ShellProcessManager`.

---

## 7. Frontend Components (`js/`)

*   **`terminal.js`**
    *   **Purpose:** Client-side logic for the interactive terminal.
    *   **Responsibilities:**
        1.  On page load, makes an AJAX call to the `/start` endpoint to get a `sessionId`.
        2.  Uses the `sessionId` to establish a persistent WebSocket connection to the `daemon.php` server.
        3.  `onData` (user input): Sends the input data over the WebSocket.
        4.  `onmessage` (from WebSocket): Writes the received shell output to the `xterm.js` terminal.
        5.  On page unload or explicit disconnect, calls the `/stop` endpoint.
