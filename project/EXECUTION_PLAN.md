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

## Phase 4: Integration & Connection
**Goal:** Connect the frontend and backend to create a fully interactive application.
**Status:** ❌ Not Started
**Associated Tasks:**
- `NS-FEAT-004`: Connect the frontend UI to the backend using AJAX/WebSockets to create an interactive terminal session.

**Steps:**
- [ ] Implement a backend endpoint (e.g., using AJAX or a WebSocket) that the frontend can connect to for a shell session.
- [ ] Update `js/terminal.js` to send user input from `xterm.js` to the backend endpoint.
- [ ] Update the backend to receive user input and pipe it to the correct shell process.
- [ ] Pipe output (stdout/stderr) from the shell process back to the frontend.
- [ ] Update `js/terminal.js` to receive shell output and write it to the `xterm.js` display.
- [ ] Implement the AJAX endpoints for the admin panel to save configuration changes.
- [ ] Update `js/admin.js` to call the save endpoints.

## Phase 5: Finalization & Documentation
**Goal:** Finalize the product, ensure it works out-of-the-box, and complete user-facing documentation.
**Status:** ❌ Not Started
**Associated Tasks:**
- `NS-FEAT-005`: Provide the default `rbash` environment, create final user documentation, and add zero-config examples.

**Steps:**
- [ ] Thoroughly test the default, zero-config `rbash` environment.
- [ ] Create or update the user-facing documentation in the root `docs/` directory (`installation.md`, `configuration.md`, etc.).
- [ ] Add examples to the documentation for both zero-config and advanced setups.
- [ ] Perform a final review of all project documentation for consistency and accuracy.
