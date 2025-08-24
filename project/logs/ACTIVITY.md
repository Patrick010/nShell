# Activity Log

---

## ACT-019: Fix App Icon Path Issue

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To fix a `RuntimeException` caused by a missing application icon.

### Outcome
- Created a placeholder SVG icon at `nshell/img/app.svg`.
- Updated `info.xml` to reference the new icon. This resolves the "image not found" error during UI rendering.
- Updated `LOW_LEVEL_DESIGN.md` to document the new `img/` directory.

### Related Documents
- `../nshell/img/app.svg`
- `../nshell/appinfo/info.xml`
- `../project/LOW_LEVEL_DESIGN.md`

---

## ACT-018: Fix ISettings Interface Implementation

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To fix a fatal PHP error caused by an incorrect implementation of the `ISettings` interface.

### Outcome
- Renamed the method `getPanel()` to the required `getForm()` in the `AdminSettings` class.
- Updated `LOW_LEVEL_DESIGN.md` to reflect the correct method name.

### Related Documents
- `../nshell/lib/Settings/AdminSettings.php`
- `../project/LOW_LEVEL_DESIGN.md`

---

## ACT-017: Implement Settings Page UI Integration

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To correctly implement the UI integration for the admin settings page, placing it in the "Administration" section as requested.

### Outcome
- Created a new `AdminSection` class to define a new settings section.
- Created a new `AdminSettings` class to render the admin panel within the new section.
- Registered the new classes as services in `app.php`.
- Updated `info.xml` to use the new settings classes, creating the link in the admin UI.
- Updated `LOW_LEVEL_DESIGN.md` to document the new `Settings` layer.

### Related Documents
- `../nshell/lib/Settings/`
- `../nshell/appinfo/app.php`
- `../nshell/appinfo/info.xml`
- `../project/LOW_LEVEL_DESIGN.md`

---

## ACT-016: Implement Frontend Routing

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To make the application visible and usable by implementing the necessary frontend routes and UI integration points.

### Outcome
- Added `index()` methods to `TerminalController` and `AdminController` to render the frontend pages.
- Added new `GET` routes to `routes.php` to expose the new controller methods.
- Added a `<navigation>` entry to `info.xml` to add the application to the Nextcloud top navigation bar.
- Updated `LOW_LEVEL_DESIGN.md` to reflect the new frontend routing implementation.

### Related Documents
- `../nshell/appinfo/info.xml`
- `../nshell/appinfo/routes.php`
- `../nshell/lib/Controller/`
- `../project/LOW_LEVEL_DESIGN.md`

---

## ACT-015: Correct Autoloader Include Syntax

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To fix a fatal PHP error caused by an incorrect placement of a `require_once` statement in the application's bootstrap file.

### Outcome
- Moved the `require_once __DIR__ . '/../lib/autoload.php';` statement in `nshell/appinfo/app.php` to after the `use` statements. This resolves the "Namespace declaration statement has to be the very first statement" error.

### Related Documents
- `../nshell/appinfo/app.php`

---

## ACT-014: Fix Namespace and Autoloader Issues

**Date:** 2025-08-24
**Status:** ✅ Done
**Assignee:** Jules

### Objective
To fix a fatal error caused by incorrect namespacing and autoloader configuration, and to improve project documentation for clarity.

### Outcome
- Corrected the PHP namespace in all classes under `nshell/lib/` to use the `OCA\nShell` prefix required by Nextcloud.
- Updated the manual autoloader (`nshell/lib/autoload.php`) to correctly load the new namespace.
- Fixed a fatal error in `nshell/appinfo/app.php` by moving the `require_once` for the autoloader to after the `namespace` declaration.
- Updated the `registerService` calls in `nshell/appinfo/app.php` to use the correct class names.
- Updated `project/ONBOARDING.md`, `templates/ONBOARDING.md`, and `project/HANDOVER_BRIEF.md` to improve clarity on project policies and history.

### Related Documents
- `../nshell/appinfo/app.php`
- `../nshell/lib/`
- `../project/ONBOARDING.md`
- `../templates/ONBOARDING.md`
- `../project/HANDOVER_BRIEF.md`

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
