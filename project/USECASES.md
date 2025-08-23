# nShell – User-Driven Use Cases

This document captures realistic user scenarios that nShell should support. These use cases cover the core interactions for both administrators setting up the environment and end-users interacting with the shell.

---

## 1. Administrator: Initial Secure Setup
**Scenario:**
An administrator wants to provide shell access to their users for the first time. Their primary concern is security. They want to enable the nShell plugin and ensure it works immediately with safe, restricted defaults without any complex configuration.

**Requirements:**
- Upon installation and activation, nShell must be **active and secure by default**.
- The default shell must be `rbash` to limit user capabilities.
- Default session timeouts (e.g., 5-minute idle, 1-hour max) must be pre-configured.
- SSH commands must be restricted by default.
- A user should be able to log in and use the terminal immediately under these safe restrictions.

---

## 2. Administrator: Loosening Restrictions for a Power User
**Scenario:**
An administrator has a trusted "power user" who needs more capabilities than the default restricted shell provides. The admin wants to grant this user access to the `bash` shell and allow them to SSH to a specific development server.

**Requirements:**
- The Admin UI must provide a clear way to select a different shell (`bash`).
- The UI must display a **prominent warning** about the security risks of using an unrestricted shell.
- The administrator must be able to add a specific hostname (e.g., `dev.example.com`) to an SSH whitelist.
- The changes must apply only to the intended user or group. (Note: Per-user policies may be a future enhancement; initially, this may apply globally).

---

## 3. Administrator: Auditing User Activity
**Scenario:**
An administrator suspects a user may have been running inappropriate commands. They need to review a log of all commands executed by that user during their recent sessions.

**Requirements:**
- The system must generate per-session logs of all commands and their output.
- These logs must be stored in a predictable location on the server.
- The logs should be clearly associated with the user and session time.
- The logging must be enabled by default and be difficult for a non-admin user to disable or tamper with.

---

## 4. End-User: Basic Server Management
**Scenario:**
A user needs to perform a simple task on the server, such as checking disk space (`df -h`), viewing running processes (`ps aux`), or editing a file in their home directory with `vim`.

**Requirements:**
- The user can open the Terminal page in the Nextcloud UI.
- The `xterm.js` terminal must be fully interactive and responsive.
- The user can run basic, non-destructive commands that are whitelisted by the administrator.
- The session should automatically time out if the user leaves the page open and inactive.

---

## 5. End-User: Using a Custom Environment
**Scenario:**
A user who has been granted `zsh` access wants their custom aliases and prompt to be loaded every time they open the terminal.

**Requirements:**
- The system must support loading shell-specific startup files (e.g., `.zshrc`).
- The administrator must be able to place a pre-configured `.zshrc` file in the `config/shells/` directory.
- When a `zsh` session starts, it should automatically source this configuration file.

---

## 6. Administrator: Customizing the Look and Feel
**Scenario:**
An administrator wants the nShell terminal to match their organization's branding. They want to change the terminal's color scheme and customize the shell prompt (`PS1`).

**Requirements:**
- The Admin UI must provide options for selecting a theme (e.g., light, dark, solarized).
- The Admin UI must provide a text input field to define a custom `PS1` prompt string.
- These appearance settings should apply to all new user sessions.
