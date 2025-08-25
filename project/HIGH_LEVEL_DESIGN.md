# High-Level Design (HLD) – nShell

## 1. Objective
Build **nShell**, a user-friendly, fully configurable restricted shell environment for Nextcloud. The application provides two distinct views: a full-featured Admin UI for administrators and a restricted User Terminal UI for designated non-admin users. The system is designed to be zero-config by default, using `rbash` for security.

---

## 2. Core Requirements

*   **Single Entry Point:** The application uses a single navigation link. A dispatch controller routes users to the appropriate view based on their role.
*   **Role-Based Views:**
    *   **Admins:** See the `Admin UI`, which includes a terminal and all application settings.
    *   **Users:** See the `User Terminal UI`, which is a restricted terminal-only view.
*   **Group-Based Access:** Access for non-admin users is restricted to members of a specific group, which is configurable in the `Admin UI`.
*   **Secure Defaults:** The default shell for users is `rbash`. All security features are on by default.

---

## 3. Architecture Overview

       ┌───────────────────┐
       │   Web Frontend     │
       │  (Single App Icon) │
       └─────────┬─────────┘
                 │
                 ▼
       ┌───────────────────┐
       │  PageController    │
       │   (dispatch)       │
       └─────────┬─────────┘
      ┌──────────┴──────────┐
      │                     │
      ▼                     ▼
┌───────────┐         ┌───────────┐
│ Admin UI  │         │ User UI   │
│(terminal +│         │(terminal  │
│ settings) │         │ only)     │
└───────────┘         └───────────┘
      │                     │
      └──────────┬──────────┘
                 │
                 ▼
       ┌───────────────────┐
       │  Backend Services  │
       │-------------------│
       │ - SessionManager   │
       │ - ShellLauncher    │
       │ - ConfigService    │
       └───────────────────┘

---

## 4. File Structure
nShell/
├── appinfo/
├── bin/
├── css/
├── img/
├── js/
├── lib/
│ ├── Controller/
│ │ └── PageController.php
│ ├── Service/
│ │ └── ConfigService.php
│ ├── SessionManager.php
│ └── ShellLauncher.php
└── templates/
    ├── admin.php
    ├── terminal.php
    └── not_allowed.php
