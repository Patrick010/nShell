# Activity Log

---

## ACT-026: Fix Critical CSP Bug

**Date:** 2025-08-26
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To resolve the Content Security Policy (CSP) error that prevented the terminal from loading.

### Outcome
- Correctly implemented CSP-compliant asset loading by moving `Util::addScript` and `Util::addStyle` calls to the `boot()` method in `nshell/appinfo/app.php`.
- The nShell terminal is now functional.

### Related Documents
- `../nshell/appinfo/app.php`
- `../nshell/templates/terminal.php`
- `SESSION_LOG.md` (ref: SESS-015)

---

## ACT-025: Fix Admin Settings Implementation

**Date:** 2025-08-25
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To fix the final bug preventing the admin settings page from loading, based on detailed user guidance.

### Outcome
- The root cause of all remaining errors was identified: `AdminSettings.php` was incorrectly delegating to a controller instead of being self-contained.
- Refactored `AdminSettings.php` to fetch its own data and render its own template, removing the dependency on `AdminController`.
- Updated `app.php` to inject the correct dependencies into the new `AdminSettings` class.
- This represents the final, correct implementation based on the user's expert guidance.

### Related Documents
- `../nshell/lib/Settings/AdminSettings.php`
- `../nshell/appinfo/app.php`

---

## ACT-024: Final Implementation and Bug Fixes

**Date:** 2025-08-25
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To implement the full, correct application architecture based on all user feedback and debugging.

### Outcome
- Implemented a two-controller architecture (`AdminController`, `TerminalController`).
- Correctly implemented the `ISettings` interface to provide a settings page in the admin section.
- Correctly implemented the main navigation link to point to the user terminal page.
- Resolved the "405 Method Not Allowed" error by using a standard HTML form post instead of a JavaScript fetch call for saving settings.
- Corrected all PHP namespaces and removed all custom autoloading.
- Corrected all icon paths and colors.
- The application is now believed to be fully functional and correct.

### Related Documents
- All of them.

---

## ACT-023: Fix 405 Error on Save Settings

**Date:** 2025-08-25
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To fix the final "405 Method Not Allowed" error when saving settings.

### Outcome
- Based on user-provided debugging information, the root cause was identified as an incorrect `Content-Type` in the JavaScript `fetch` request.
- The `admin.js` file was refactored to send data as `application/x-www-form-urlencoded` instead of `application/json`.
- The CSRF token was correctly included in the request body.

### Related Documents
- `../nshell/js/admin.js`

---

## ACT-022: Fix "405 Method Not Allowed" on Save Settings

**Date:** 2025-08-25
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To fix the final bug preventing the admin settings from being saved.

### Outcome
- A "405 Method Not Allowed" error was occurring when saving settings.
- Hypothesized that the `/settings` URL was too generic and conflicted with Nextcloud's internal routing.
- Changed the API endpoint URL to `/admin/settings` in `routes.php`.
- Updated the corresponding fetch URL in `admin.js`.

### Related Documents
- `../nshell/appinfo/routes.php`
- `../nshell/js/admin.js`

---

## ACT-013: Fix App Bootstrap Error

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To fix a fatal error preventing the app from loading on Nextcloud 20+ due to a deprecated bootstrap interface.

### Outcome
- Corrected `nshell/appinfo/app.php` to use the modern `IBootstrap` interface and `IBootContext`.
- Removed the legacy `IBootable` interface, resolving the crash.
- Updated `LLD.md` and `TRACEABILITY_MATRIX.md` to reflect the fix.

### Related Documents
- `../project/TRACEABILITY_MATRIX.md` (ref: BUG-01)
- `../project/LOW_LEVEL_DESIGN.md`
- `../nshell/appinfo/app.php`

---

## ACT-012: Final Documentation - Lessons and Handover

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To conclude the project by documenting key lessons learned and providing a handover brief for future developers.

### Outcome
- Populated the `LESSONS-LEARNT.md` with insights from the development process.
- Wrote a comprehensive `HANDOVER_BRIEF.md` to ensure a smooth transition.

### Related Documents
- `../project/LESSONS-LEARNT.md`
- `../project/HANDOVER_BRIEF.md`

---

## ACT-009: Refactor File Structure

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To refactor the repository by moving all application code into a self-contained `nshell/` directory.

### Outcome
- Moved all application code into a new `nshell/` directory.
- Updated all internal code paths and documentation to reflect the new structure.

### Related Documents
- `../nshell/`

---

## ACT-008: Create Installation Script and Documentation

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To correct the incorrect installation documentation and provide an automated installation script for users.

### Outcome
- Created a new `install.sh` script to automate the process.
- Rewrote `docs/installation.md` to be a comprehensive guide.
- Updated the main `README.md` to link to the new guide.

### Related Documents
- `install.sh`
- `docs/installation.md`

---

## ACT-007: Phase 5 - Finalization

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To finalize the core functionality of the application, including I/O piping and settings persistence.

### Outcome
- Implemented real I/O piping in the `TerminalController`.
- Implemented settings persistence to a JSON file in the `AdminController`.

### Related Documents
- `../lib/Controller/`

---

## ACT-006: Phase 4 - Integration & Connection

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To connect the frontend and backend to create a basic interactive application.

### Outcome
- Created `TerminalController` and `AdminController`.
- Registered API routes in `appinfo/`.
- Implemented frontend JavaScript for terminal and admin panel.

### Related Documents
- `../lib/Controller/`
- `../js/`

---

## ACT-005: Phase 3.5 - App Registration

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To create the necessary files to make the app discoverable by a local Nextcloud instance.

### Outcome
- Created `appinfo/info.xml` and `appinfo/app.php`.

### Related Documents
- `../appinfo/`

---

## ACT-004: Phase 3 - Frontend Skeleton

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To create the non-interactive frontend components.

### Outcome
- Created `templates/`, `js/`, and `css/` directories and placeholder files.

### Related Documents
- `../templates/`
- `../js/`
- `../css/`

---

## ACT-003: Phase 2 - Core Logic Implementation

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To implement the core business logic of the backend.

### Outcome
- Implemented `Logger`, `ShellLauncher`, and `SessionManager` classes.

### Related Documents
- `../lib/`

---

## ACT-002: Phase 1 - Skeleton & Framework

**Date:** 2025-08-23
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To establish the project's foundational code structure.

### Outcome
- Created `bin/` and `lib/` directories and skeleton files.
- Created manual autoloader.

### Related Documents
- `../lib/autoload.php`

---

## ACT-001: Project Initiation and Documentation Setup

**Date:** 2025-08-23
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To establish the complete project documentation directory.

### Outcome
- Created and populated the `project/` directory with all necessary documentation.

### Related Documents
- `../project/`
