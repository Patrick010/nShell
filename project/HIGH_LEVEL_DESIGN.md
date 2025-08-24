# High-Level Design (HLD) – nShell

**Status:** Live Document

## 1. Purpose
This document outlines the high-level architecture for the **nShell** project. It describes the major components, their interactions, and the overall design principles that will guide development.

## 2. Scope
The project's scope is to create a secure, configurable, restricted shell environment within Nextcloud. The architecture must support:
- A secure-by-default, zero-config user experience.
- Full configurability for administrators via a Web UI and optional config files.
- Isolated shell sessions for security.
- A clear separation between the backend logic and the frontend interface.

## 3. Architecture Overview

The nShell system is composed of four primary layers: a web-based frontend, a controller layer to handle API requests, a backend service layer for business logic, and the restricted shell environment itself.

       ┌───────────────────┐
       │   Web Frontend     │
       │-------------------│
       │ - Admin UI         │
       │ - User Terminal UI │
       └─────────┬─────────┘
                 │ AJAX
                 ▼
       ┌───────────────────┐
       │ Controller Layer   │
       │-------------------│
       │ - TerminalController│
       │ - AdminController   │
       └─────────┬─────────┘
                 │
                 ▼
       ┌───────────────────┐
       │  Backend Services  │
       │-------------------│
       │ - SessionManager   │
       │ - ShellLauncher    │
       │ - Logger           │
       └─────────┬─────────┘
                 │
                 ▼
       ┌───────────────────┐
       │ Restricted Shell   │
       │-------------------│
       │ - rbash (default)  │
       │ - Optional shells  │
       │ - Restricted PATH  │
       │ - Wrapped binaries │
       └───────────────────┘

**Component Breakdown:**

1.  **Web Frontend:** The user-facing interface, built within Nextcloud.
    *   **Admin UI:** Allows administrators to configure all aspects of nShell, from shell selection to session timeouts and security warnings.
    *   **User Terminal UI:** Provides the `xterm.js`-based interactive terminal for the user's shell session.

2.  **Backend Daemon:** The core of nShell, written in PHP. It runs on the server and manages all logic.
    *   **Session Manager:** Handles the lifecycle of shell sessions (creation, termination, isolation).
    *   **Shell Launcher:** Spawns the actual shell process (`rbash`, `bash`, etc.) with the correct environment, PATH, and restrictions.
    *   **SSH Wrapper Logic:** Intercepts and validates SSH commands against the allowed list.
    *   **Timeout & Logging:** Manages session timeouts and records all command activity to log files.
    *   **Config Parser:** Reads and applies settings from the optional `config.yaml` file.

3.  **Restricted Shell Environment:** The actual environment the user interacts with.
    *   **Shell:** Defaults to `rbash` for security, but can be configured to use other shells.
    *   **Restricted PATH:** The `PATH` environment variable is strictly controlled to only include whitelisted command directories.
    *   **Wrapped Binaries:** Commands like `ssh` are replaced with wrappers to enforce security policies.

### 3.1 Proposed File Structure

The repository root contains project-level documentation (`project/`, `templates/`) and the application source code, which is self-contained in the `nShell/` directory.

```
.
├── nShell/
│   ├── appinfo/
│   │   ├── app.php
│   │   └── info.xml
│   ├── bin/
│   ├── config/
│   ├── css/
│   ├── js/
│   ├── lib/
│   │   ├── Controller/
│   │   └── ...
│   └── templates/
│       ├── admin.php
│       └── terminal.php
├── project/
└── templates/
```

## 4. Non-Functional Requirements
- **Security:** High priority. System must be secure by default. Unrestricted shells or configurations must have clear warnings.
- **Performance:** Session startup should be fast. Terminal interaction should be responsive.
- **Usability:** The system must be zero-config and work immediately. The UI should be intuitive.
- **Extensibility:** The architecture should allow for future enhancements, such as new configurable options or shell types.

## 5. Documentation Governance
This project will follow a "living documentation" model. All code changes must be reflected in the relevant documentation (`PID.md`, `HLD.md`, `LLD.md`, etc.) in the same commit.

## 6. Deployment Model
- nShell is a Nextcloud plugin. It will be packaged as a standard Nextcloud app for installation.

## 7. Security Model
- **Default Secure:** The default shell is `rbash`, which is highly restricted.
- **SSH Wrapping:** SSH commands are passed through a wrapper script to enforce restrictions on allowed hosts.
- **PATH Control:** The `PATH` is minimal and controlled by the administrator.
- **UI Warnings:** The UI will display prominent warnings for any configuration that reduces security.
- **Session Isolation:** Each shell runs as a separate process owned by the user. Optional `chroot` can be used for further isolation.
- A more detailed breakdown is available in `SECURITY.md`.

## 8. Risks & Mitigations
- **Risk:** A user escapes the restricted shell environment.
  **Mitigation:** Use `rbash` by default. Carefully audit all allowed commands and shell configurations. Implement robust `chroot` jails as an optional layer.
- **Risk:** A configuration error exposes the system to vulnerabilities.
  **Mitigation:** Provide sensible, secure defaults for all options. Display clear warnings in the UI for potentially dangerous settings.

---

## 9. Future Vision
Future enhancements, such as advanced container-based session isolation or support for a wider range of shells, will be tracked in `FUTURE_ENHANCEMENTS.md`.
