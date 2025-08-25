# Low-Level Design (LLD) – nShell

## 1. Purpose
This LLD describes the specific implementation details of the nShell components, based on the final single-entry-point architecture. This document targets **Nextcloud 31 and later**.

---

## 2. Controller Layer (`lib/Controller/`)

*   **`PageController.php`**
    *   **Purpose:** Acts as the single entry point for the application's UI, dispatching users to the correct view.
    *   **Dependencies:** `IUserSession`, `IGroupManager`, `ConfigService`, `SessionManager`.
    *   **`dispatch()` Method:**
        *   Checks if the current user is in the `admin` group.
        *   If admin, it fetches all groups from `IGroupManager`, gets the current settings from `ConfigService`, and returns a `TemplateResponse` for the `admin` template.
        *   If not admin, it gets the allowed group from `ConfigService`, checks if the user is a member, and returns a `TemplateResponse` for either the `terminal` or `not_allowed` template.
    *   **`saveSettings()` Method:**
        *   Handles POST requests from the admin form.
        *   Uses `ConfigService` to save the new allowed group.
        *   Returns a `JSONResponse` indicating success.
    *   **`createSession()` & `handleIO()` Methods:**
        *   Handle the backend API calls from the frontend JavaScript to manage the terminal session lifecycle.

---

## 3. Service Layer (`lib/Service/`)

*   **`ConfigService.php`**
    *   **Purpose:** To manage application settings.
    *   **Responsibilities:**
        *   Uses Nextcloud's `IConfig` service to get and set the `allowed_group` configuration value.

---

## 4. Backend Components (`lib/`)

*   **`SessionManager.php` & `ShellLauncher.php`**
    *   **Purpose:** These classes handle the creation, management, and termination of the underlying shell process.
    *   They are invoked by the `PageController`'s API methods.

---

## 5. Frontend Components

*   **`templates/admin.php`:** The template for the administrator view. Contains the `xterm.js` container for the admin's terminal and the HTML form for all application settings, including the group selection pulldown.
*   **`templates/terminal.php`:** The template for the restricted user terminal view. Contains the `xterm.js` container and includes the necessary JavaScript.
*   **`templates/not_allowed.php`:** A simple page to inform users they do not have permission to use the app.
*   **`js/terminal.js`:** The JavaScript for the user terminal. Handles creating the `xterm.js` instance and all communication with the backend session API.
*   **`js/admin.js`:** The JavaScript for the admin page. Handles the form submission for saving settings. It is included on the admin page alongside `terminal.js`.
*   **`img/app.svg`:** The application icon.

---

## 6. Nextcloud Integration (`appinfo/`)

*   **`info.xml`:** Defines app metadata and a single `<navigation>` entry pointing to `nshell.page.dispatch`.
*   **`routes.php`:** Defines a `GET /` route mapped to `page#dispatch`, and POST routes for the session and settings APIs.
*   **`app.php`:** Registers the `PageController` and its dependencies. It does not include any manual autoloader.
