# Project Backlog

**Date:** 2025-08-23
**Status:** Live Document

## 1. Purpose

This document serves as the tactical backlog for the nShell project. It contains a list of clearly defined, approved tasks for future implementation. The process for managing this backlog is defined in the `PID.md`.

---

## 2. Backlog Items

All new tasks added to this backlog should conform to this structure.

### High Priority

-   **Task ID:** `NS-FEAT-001`
-   **Source:** `PID.md` (Stage 1)
-   **Priority:** HIGH
-   **Dependencies:** None
-   **Description:** Generate skeleton code for the CLI wrapper (`nshell.php`) and the core backend classes (`SessionManager.php`, `Logger.php`).
-   **Acceptance Criteria:**
    -   `[ ]` `bin/nshell.php` exists and can be executed.
    -   `[ ]` `lib/SessionManager.php` and `lib/Logger.php` exist with class definitions.
    -   `[ ]` Basic autoloader is set up.
-   **Estimated Effort:** Medium

-   **Task ID:** `NS-FEAT-002`
-   **Source:** `PID.md` (Stage 2)
-   **Priority:** HIGH
-   **Dependencies:** `NS-FEAT-001`
-   **Description:** Implement the SSH wrapper script (`ssh-wrapper.sh`) and the core logic for restricting SSH commands.
-   **Acceptance Criteria:**
    -   `[ ]` `bin/ssh-wrapper.sh` can block or allow SSH commands based on a config file.
    -   `[ ]` The `ShellLauncher` uses the wrapper when appropriate.
-   **Estimated Effort:** Medium

-   **Task ID:** `NS-FEAT-003`
-   **Source:** `PID.md` (Stage 3)
-   **Priority:** HIGH
-   **Dependencies:** None
-   **Description:** Create the frontend UI templates (`admin.php`, `terminal.php`) and the basic JavaScript logic to render the admin panel and the xterm.js terminal.
-   **Acceptance Criteria:**
    -   `[ ]` The admin page renders with form fields for configuration.
    -   `[ ]` The terminal page renders an empty, non-interactive terminal.
-   **Estimated Effort:** Large

-   **Task ID:** `NS-FEAT-004`
-   **Source:** `PID.md` (Stage 4)
-   **Priority:** HIGH
-   **Dependencies:** `NS-FEAT-001`, `NS-FEAT-003`
-   **Description:** Connect the frontend UI to the backend using AJAX/WebSockets to create an interactive terminal session.
-   **Acceptance Criteria:**
    -   `[ ]` Keystrokes in the UI are sent to the backend shell process.
    -   `[ ]` Output from the shell process is displayed in the UI terminal.
    -   `[ ]` Admin panel changes can be saved.
-   **Estimated Effort:** Large

-   **Task ID:** `NS-FEAT-005`
-   **Source:** `PID.md` (Stage 5)
-   **Priority:** HIGH
-   **Dependencies:** All other features.
-   **Description:** Provide the default `rbash` environment, create final user documentation, and add zero-config examples.
-   **Acceptance Criteria:**
    -   `[ ]` The plugin works out-of-the-box in a secure `rbash` environment.
    -   `[ ]` User-facing documentation in `docs/` is complete.
-   **Estimated Effort:** Medium

### Medium Priority
*No items.*

### Low Priority
*No items.*
