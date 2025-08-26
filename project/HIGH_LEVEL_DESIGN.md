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

To achieve stateful, persistent sessions, the nShell architecture is composed of five primary components: the Web Frontend, a standard Nextcloud PHP Backend for session initiation, a persistent Database for session tracking, a long-running WebSocket Server for real-time communication, and a Shell Process Manager to handle the live shell processes.

       ┌───────────────────┐      ┌────────────────────┐
       │   Web Frontend     │──────│   WebSocket Server  │
       │  (xterm.js)        │ WebSocket  (bin/daemon.php)   │
       └─────────┬─────────┘      └──────────┬─────────┘
                 │ AJAX (for /start)         │ IPC
                 │                           │
                 ▼                           ▼
       ┌───────────────────┐      ┌────────────────────┐
       │  Nextcloud Backend  │      │ ShellProcessManager  │
       │  (PHP Controllers)  │      │ (Manages PTYs)     │
       └─────────┬─────────┘      └──────────┬─────────┘
                 │                           │
                 ▼                           ▼
       ┌───────────────────┐      ┌────────────────────┐
       │     Database       │      │  Restricted Shell  │
       │ (nshell_sessions)  │      │ (rbash, per user)  │
       └───────────────────┘      └────────────────────┘

**Component Breakdown:**

1.  **Web Frontend:** The user-facing `xterm.js` terminal. It initiates the session via an AJAX call to the Nextcloud Backend, then establishes a persistent WebSocket connection to the WebSocket Server for all subsequent I/O.

2.  **Nextcloud Backend (PHP):** The standard Nextcloud app backend. Its role is limited to stateless operations.
    *   **Controllers:** Handle requests to start and stop sessions.
    *   **SessionManager Service:** Interacts with the database to create, retrieve, and delete session records. It does *not* manage the live shell process.
    *   **Admin UI:** Provides the interface for administrators to configure nShell.

3.  **Database:** A dedicated database table (`nshell_sessions`) that persistently stores session information (session ID, user ID, timestamps). This allows session information to survive across different requests and processes.

4.  **WebSocket Server (Daemon):** A long-running process (e.g., `bin/daemon.php`) that manages the real-time communication bridge.
    *   It accepts WebSocket connections from the frontend.
    *   It communicates with the `ShellProcessManager` (e.g., via IPC) to route input and output to the correct shell process for a given session ID.

5.  **ShellProcessManager & ShellProcess:** A backend service responsible for the lifecycle of the actual, stateful shell processes.
    *   It spawns a new restricted shell in a pseudo-terminal (PTY) for each new session.
    *   It keeps track of the live processes, mapping them to session IDs.
    *   It handles all I/O, writing user input to the shell's PTY and reading the output.
    *   It terminates shell processes when sessions are closed.

6.  **Restricted Shell Environment:** The actual, isolated shell environment (`rbash`) that the user interacts with, running as a dedicated process on the server.

### 3.1 Proposed File Structure

The repository root contains project-level documentation (`project/`, `templates/`) and the application source code, which is self-contained in the `nshell/` directory.

```
.
├── nshell/
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
