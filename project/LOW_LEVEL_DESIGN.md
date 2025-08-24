# Low-Level Design (LLD) – nShell

## 1. Purpose
This LLD describes the specific implementation details of the nShell components, expanding on the High-Level Design. It details the responsibilities of each class and script in the system.

---

## 2. App Registration (`appinfo/`)

This directory contains the files required for Nextcloud to recognize and load the application.

*   **`info.xml`**
    *   **Purpose:** The application manifest.
    *   **Content:** An XML file containing essential metadata about the app, including its unique ID (`nshell`), public name, version, author, and dependencies on the Nextcloud server and PHP versions.

*   **`app.php`**
    *   **Purpose:** The main application entrypoint and bootstrap class.
    *   **Responsibilities:**
        *   Contains the `Application` class which extends Nextcloud's base app class.
        *   The `register()` method will be used in future phases to register navigation links, API routes, and other services with the Nextcloud framework.
        *   The `boot()` method can be used for any logic that needs to run when the app is enabled.

---

## 3. Core Backend Components (`lib/`)

This directory contains the core PHP classes that drive the nShell backend.

*   **`SessionManager.php`**
    *   **Purpose:** To manage the lifecycle of user shell sessions.
    *   **Responsibilities:**
        *   Create new shell sessions, ensuring each runs in an isolated process.
        *   Track active sessions (e.g., by process ID).
        *   Enforce session duration limits (idle timeout, max session duration).
        *   Terminate sessions cleanly when they expire or are closed by the user.
        *   Handle session state, including environment variables and current working directory.

*   **`ShellLauncher.php`**
    *   **Purpose:** To prepare and launch the shell process itself.
    *   **Responsibilities:**
        *   Determine which shell binary to execute (`rbash`, `bash`, etc.) based on configuration.
        *   Construct the secure environment for the shell, including a restricted `PATH`.
        *   Apply any shell-specific configurations (e.g., from `config/shells/`).
        *   Use `proc_open` or a similar PHP function to spawn the shell process with pipes for stdin, stdout, and stderr.
        *   Return the process handle and pipes to the `SessionManager`.

*   **`SSHWrapper.php`**
    *   **Purpose:** To provide logic for the `ssh-wrapper.sh` script. While the script itself is a shell script, this class may hold the configuration and validation logic.
    *   **Responsibilities:**
        *   Load the list of allowed SSH targets from the configuration.
        *   Validate if a user's requested SSH command is permitted.
        *   This class might not be directly used at runtime but could be used by an admin interface to generate the wrapper script or its configuration.

*   **`Logger.php`**
    *   **Purpose:** To handle all logging for nShell.
    *   **Responsibilities:**
        *   Provide methods for logging different levels (INFO, WARN, ERROR).
        *   Log all commands executed in a user's session to a per-session log file.
        *   Optionally write to a central audit log.
        *   Handle log rotation and retention policies as defined in the configuration.

---

## 4. Executable Scripts (`bin/`)

These are the executable scripts that are either called by the backend or used directly.

*   **`nshell.php`**
    *   **Purpose:** A CLI entrypoint for launching and managing shell sessions.
    *   **Functionality:** Could be used for debugging or for environments where the web UI is not available. It would likely use the `lib/` components to perform its tasks.

*   **`ssh-wrapper.sh`**
    *   **Purpose:** To enforce SSH restrictions. This script acts as a replacement for the real `ssh` binary within the restricted `PATH`.
    *   **Logic:**
        1.  Receives the arguments intended for the `ssh` command.
        2.  Parses the destination host from the arguments.
        3.  Checks the destination against a pre-configured list of allowed hosts.
        4.  If allowed, it executes the real `ssh` with the given arguments.
        5.  If not allowed, it prints an error message and exits.

*   **`restricted-shell.sh`**
    *   **Purpose:** A bootstrap script to set up the `rbash` environment.
    *   **Logic:**
        1.  Sets or exports a minimal, safe `PATH`.
        2.  Potentially sets other environment variables (e.g., `PS1` for the prompt).
        3.  Executes `rbash`, replacing the script's process with the shell.

---

## 5. Configuration (`config/`)

*   **`config.yaml`**
    *   **Purpose:** The central, optional file for advanced configuration.
    *   **Structure:** A YAML file containing key-value pairs for all configurable aspects of nShell, such as:
        *   `default_shell: /bin/rbash`
        *   `allowed_shells: [/bin/bash, /usr/bin/zsh]`
        *   `session_timeout_idle: 300`
        *   `ssh_allowed_hosts: ['server1.example.com']`
        *   `log_path: /var/log/nshell/`

*   **`shells/` directory**
    *   **Purpose:** To hold shell-specific startup files (e.g., `.bashrc`, `.zshrc`).
    *   **Usage:** If a user selects `zsh`, the `ShellLauncher` can be configured to source the `config/shells/zshrc` file upon startup.

---

## 6. Frontend Components (`templates/`, `js/`, `css/`)

*   **`templates/admin.php` & `templates/terminal.php`**
    *   **Purpose:** Server-side PHP templates for rendering the HTML structure of the admin panel and the user terminal page.

*   **`js/admin.js` & `js/terminal.js`**
    *   **Purpose:** Client-side JavaScript for interactivity.
    *   **`admin.js`:** Handles form submissions for configuration changes, making AJAX calls to the backend.
    *   **`terminal.js`:**
        1.  Initializes the `xterm.js` terminal instance.
        2.  Establishes a WebSocket or uses AJAX polling to communicate with the backend shell process.
        3.  Sends user input (keystrokes) to the backend.
        4.  Receives shell output from the backend and writes it to the terminal.

*   **`css/admin.css` & `css/terminal.css`**
    *   **Purpose:** Stylesheets for the admin panel and terminal, including theme support (light/dark).

---

## 7. Ongoing Maintenance
All development tasks must follow the [Task Execution Checklist](./TASK_CHECKLIST.md)
