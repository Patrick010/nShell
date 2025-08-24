# Low-Level Design (LLD) – nShell

## 1. Purpose
This LLD describes the specific implementation details of the nShell components, as defined by the authoritative High-Level Design. It details the responsibilities of each class required to build the application. This document targets **Nextcloud 31 and later**.

---

## 2. Controller Layer (`lib/Controller/`)

This layer is responsible for handling the main application entry request and dispatching the correct view based on user role.

*   **`PageController.php` (New)**
    *   **Purpose:** To act as the single entry point for the application's UI.
    *   **Responsibilities:**
        *   Injects the `IUserSession` and `IGroupManager` to get information about the current user.
        *   Injects a new `ConfigService` to read application settings (e.g., the allowed group).
        *   Contains a single `dispatch()` method.
        *   The `dispatch()` method checks if the current user is in the `admin` group.
        *   If the user is an admin, it fetches all group names from `IGroupManager` and the current configuration, then returns a `TemplateResponse` for the `admin` template, passing the group list and config as parameters.
        *   If the user is not an admin, it checks if they are a member of the group defined in the app's settings. If they are, it returns a `TemplateResponse` for the `terminal` template. Otherwise, it returns an error or redirect.

---

## 3. Backend Components (`lib/`)

This directory contains the core PHP classes that drive the nShell backend.

*   **`SessionManager.php`**
    *   **Purpose:** To manage the lifecycle of user shell sessions.
    *   **Responsibilities:**
        *   Creates new shell sessions based on parameters passed from the controller (e.g., shell type, restrictions).
        *   Tracks and terminates sessions.

*   **`ShellLauncher.php`**
    *   **Purpose:** To prepare and launch the shell process.
    *   **Responsibilities:**
        *   Launches the shell process (e.g., `rbash`) with the correct environment variables and a restricted `PATH`.

*   **`ConfigService.php` (New)**
    *   **Purpose:** To manage application settings.
    *   **Responsibilities:**
        *   Provides methods to get and set configuration values, such as the allowed user group.
        *   Uses Nextcloud's `IConfig` service to store application values in the database, which is the standard, robust method.

*   **`Logger.php`:** Handles logging of session activity and errors.

---

## 4. Frontend Components

*   **`templates/terminal.php`:** The template for the restricted user terminal view. Contains the `xterm.js` container and includes the necessary JavaScript.
*   **`templates/admin.php`:** The template for the administrator view. Contains both the `xterm.js` container for the admin's terminal and the HTML form for all application settings, including the pulldown menu for group selection.
*   **`js/terminal.js`:** The JavaScript for the user terminal, responsible for creating the `xterm.js` instance and communicating with the backend API for session I/O.
*   **`js/admin.js`:** The JavaScript for the admin page. It will contain the logic for the admin's terminal *and* the logic to handle saving the settings form via an API call.
*   **`img/app.svg`:** The application icon.

---

## 5. Nextcloud Integration (`appinfo/`)

*   **`info.xml`:** Defines the app metadata and a single `<navigation>` entry pointing to the `page#dispatch` route. The `<settings>` entry is removed.
*   **`routes.php`:** Defines a single `GET /` route mapped to `page#dispatch` and a `POST /settings` route mapped to a new `saveSettings` method in the `PageController`.
*   **`app.php`:** Registers only the `PageController` and its dependencies (`ConfigService`, etc.).
