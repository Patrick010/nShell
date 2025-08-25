# Lessons Learnt Log

**Purpose:**
To capture key takeaways from the nShell project across all phases.

---

## Process & Workflow Lessons

| Lesson | Impact |
|---|---|
| **A "plan-and-approve" workflow is essential.** Submitting a plan for user approval before starting work prevents wasted effort and ensures alignment. | **High** |
| **A "report after submit" workflow is crucial for communication.** Providing a high-level summary after each submission keeps the user informed of progress and accomplishments. | **High** |
| **The `TASK_CHECKLIST.md` is an invaluable quality gate.** Using it for review catches omissions (e.g., missing docblocks, traceability updates) that would otherwise become technical debt. | **High** |
| **"Living documentation" requires extreme diligence.** Logs, execution plans, and design documents must be updated with every single commit, including minor fixes, to remain a reliable source of truth. | **High** |

---

## Technical & Architectural Lessons from Initial Setup

| Lesson | Impact |
|---|---|
| **Clarify framework conventions early.** Misunderstanding the standard location for app files (e.g., the `templates/` directory) led to a necessary refactoring. This should be confirmed at the start. | **Medium** |
| **Refactor to a clean structure as soon as the need is identified.** Moving all app code into a self-contained `nshell/` directory significantly improved maintainability and simplified the build process. This should have been done earlier. | **High** |
| **Assume nothing about the execution environment.** The initial assumption that `composer` would be available was incorrect. The environment had no PHP, and even after installing it, `composer install` failed due to file limits. | **High** |
| **Develop and test workarounds for environment constraints.** The manual PSR-4 autoloader was a successful workaround for the lack of Composer. The `.gitkeep` file was a necessary workaround for the environment's auto-pruning of empty directories. | **High** |
| **The `rename` and `mv` commands can be unreliable.** The `run_in_bash_session` tool with `mv` was more reliable for moving directories than the dedicated `rename_file` tool, which failed intermittently. | **Medium** |

---

## Technical Lessons from Post-Handoff Debugging

These lessons were learned specifically during the process of repairing the non-functional `nShell` application after the initial handover.

### 1. Namespaces and Autoloading are Critical
- **Lesson:** All application classes **must** be in the `OCA\{AppName}` namespace. The folder structure under `lib/` must match the namespace structure.
- **Context:** The application was initially non-functional due to using the `nShell` namespace instead of `OCA\nShell`. This caused a fatal `ReflectionException` because Nextcloud's PSR-4 autoloader could not find any of the app's classes.

### 2. UI Integration Requires Explicit Registration
- **Lesson:** An application does not appear in the Nextcloud UI by default. It must be explicitly registered through `appinfo/routes.php` and `appinfo/info.xml`.
- **Context:** The app was invisible until a full suite of registration components was added, including `<navigation>` and `<settings>` tags in `info.xml`.

### 3. Settings Forms Must Be Standard HTML Posts
- **Lesson:** Nextcloud's admin settings panels expect configuration changes to be submitted via a standard `application/x-www-form-urlencoded` request.
- **Context:** The settings page was initially broken with a `405 Method Not Allowed` error because it attempted to use a JavaScript `fetch` call with `application/json`.

### 4. Content Security Policy (CSP) is Strict
- **Lesson:** Nextcloud's CSP blocks external assets (e.g., from CDNs) by default. Third-party libraries must be bundled locally.
- **Context:** The terminal was blank because `xterm.js` was blocked. The fix was to download the library and load it locally using `\OCP\Util::addScript()`.

### 5. Adhere to API Contracts
- **Lesson:** Always ensure the data types passed to Nextcloud's core services match their interface requirements.
- **Context:** A `TypeError` was crashing the app because an `IUser` object was being passed to a function expecting a user ID `string`.
