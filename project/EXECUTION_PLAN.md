# Execution Plan

**Status:** Live Document

This document provides a detailed breakdown of the tasks required to fulfill the project's goals, as outlined in the [Project Initiation Document (PID)](./PID.md).

## Phase 1: Skeleton & Framework
**Goal:** Establish the project's foundational code structure, including the core backend classes and CLI wrappers.
**Status:** ✅ Done
**Associated Tasks:**
- `NS-FEAT-001`: Generate skeleton code for the CLI wrapper (`nshell.php`) and the core backend classes (`SessionManager.php`, `Logger.php`).

**Steps:**
- [x] Create `bin/nshell.php` with basic executable structure.
- [x] Create `lib/SessionManager.php` with class definition.
- [x] Create `lib/ShellLauncher.php` with class definition.
- [x] Create `lib/SSHWrapper.php` with class definition.
- [x] Create `lib/Logger.php` with class definition.
- [x] Create a `composer.json` with project metadata and dependencies for Nextcloud 31.
- [x] Create and integrate a manual PSR-4 autoloader (`lib/autoload.php`) due to environment constraints.

## Phase 2: Core Logic Implementation
**Goal:** Implement the core security features and business logic of the backend.
**Status:** ✅ Done
**Associated Tasks:**
- `NS-FEAT-002`: Implement the SSH wrapper script (`ssh-wrapper.sh`) and the core logic for restricting SSH commands.

**Steps:**
- [x] Implement the `Logger` to write to per-session and central audit logs.
- [x] Implement the `ShellLauncher` to spawn shell processes with a restricted environment.
- [x] Implement the `SessionManager` to track and terminate sessions.
- [x] Create the `bin/ssh-wrapper.sh` script with logic to validate hosts against a configuration.
- [x] Ensure the `ShellLauncher` correctly uses the `ssh-wrapper.sh` when launching a restricted shell.

## Phase 3: Frontend Development
**Goal:** Create the non-interactive frontend components, including the admin panel and the user terminal page.
**Status:** ✅ Done
**Associated Tasks:**
- `NS-FEAT-003`: Create frontend UI templates and JavaScript logic to render the admin panel and the xterm.js terminal.

**Steps:**
- [x] Create the HTML structure for the admin panel in `templates/admin.php`.
- [x] Add CSS in `css/admin.css` to style the panel.
- [x] Create the HTML structure for the terminal page in `templates/terminal.php`.
- [x] Add a placeholder for xterm.js and create `js/terminal.js`.
- [x] Add CSS in `css/terminal.css` to style the terminal.

## Phase 3.5: App Registration
**Goal:** Create the necessary files to make the app discoverable by a local Nextcloud instance for testing.
**Status:** ✅ Done
**Associated Tasks:**
- `NS-INFRA-001`: Create app manifest and entrypoint.

**Steps:**
- [x] Create the `appinfo/` directory.
- [x] Create `appinfo/info.xml` with app metadata.
- [x] Create `appinfo/app.php` with a basic Application class structure.

## Phase 4: Integration & Connection
**Goal:** Connect the frontend and backend to create a fully interactive application.
**Status:** ✅ Done
**Associated Tasks:**
- `NS-FEAT-004`: Connect the frontend UI to the backend using AJAX/WebSockets to create an interactive terminal session.

**Steps:**
- [x] Implemented a `TerminalController` to handle API requests.
- [x] Registered API routes in `appinfo/routes.php` and `appinfo/app.php`.
- [x] Updated `js/terminal.js` to create a session and handle I/O via AJAX.
- [x] The backend now receives input, but does not yet pipe it to the shell process (to be done in a later implementation step).
- [x] The frontend receives placeholder output from the backend.
- [x] Implement the AJAX endpoints for the admin panel to save configuration changes.
- [x] Update `js/admin.js` to call the save endpoints.

## Phase 5: Finalization & Documentation
**Goal:** Finalize the product, ensure it works out-of-the-box, and complete user-facing documentation.
**Status:** ✅ Done
**Associated Tasks:**
- `NS-FEAT-005`: Provide the default `rbash` environment, create final user documentation, and add zero-config examples.

**Steps:**
- [x] Implemented backend I/O piping in the `TerminalController`.
- [x] Implemented settings persistence in the `AdminController`.
- [x] Reviewed and confirmed user-facing documentation (`README.md`, `docs/`).
- [x] Performed a final verification test of the core functionality.
