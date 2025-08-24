# Project Initiation Document (PID)

**Project Name:** nShell: Fully Configurable, Zero-Config Restricted Shell
**Date:** 2025-08-23
**Version:** 1.0
**Status:** Live Document

---

## 1. Full Business Case

**Justification:**
The project objective is to build **nShell**, a user-friendly, fully configurable restricted shell environment for Nextcloud, inspired by Home Assistant. The system must be **zero-config by default**, working immediately after installation with sensible, secure defaults. It provides a powerful tool for administrators while ensuring safety and control. Optional configuration files and a full UI are available for advanced administrators who need more granular control.

**Strategic Goals:**
- **Provide a Secure-by-Default Environment:** Default to a restricted shell (`rbash`) with a safe PATH and command whitelists to minimize risk.
- **Achieve Zero-Config Usability:** Ensure nShell is functional immediately after installation without requiring any manual configuration.
- **Offer Full Configurability:** Allow administrators to override all defaults, including shell selection, session limits, and security settings via a UI or optional config files.
- **Ensure Session Isolation:** Run each user shell session in a fully isolated process to prevent interference and enhance security.
- **Deliver a User-Friendly UI:** Provide a clean and intuitive Admin Panel for configuration and a functional terminal for users within the Nextcloud web interface.

**Business Benefits:**
- **Enhanced Security:** Reduces the risk of unauthorized server access and command execution through a restricted, auditable shell environment.
- **Improved Administrator Efficiency:** Simplifies server management tasks by providing a powerful shell directly within the Nextcloud UI, with safe defaults and optional power-user features.
- **High Flexibility and Control:** Caters to a wide range of administrative needs, from basic secure access to advanced, customized environments.
- **Clear Auditing and Compliance:** Provides detailed per-session logging of commands and output, ensuring full traceability for security and compliance purposes.

---

## 2. Core Requirements

### 2.1. Zero-Config Principle
- nShell must run immediately after installation with default settings.
- Default shell: `/bin/rbash`.
- Default session settings:
  - Idle timeout: 300s
  - Max session duration: 3600s
  - SSH restrictions enforced for users by default
  - Logging enabled for auditing
  - Default safe PATH with only allowed binaries
- All advanced options (shell overrides, allowed commands, SSH hosts, themes, prompt) are configurable **via UI or optional config files**.

### 2.2. Shell Management
- Default: `/bin/rbash`.
- Optional shells: `/bin/bash`, `/usr/bin/zsh`, `/usr/bin/fish`.
- UI must display **prominent warnings** when an unrestricted shell is chosen.
- Advanced admins can override defaults via optional configuration files.

### 2.3. Session Management
- Each shell session must run in an **isolated process**.
- Configurable options (UI + optional config):
  - Idle timeout (auto-kill inactive sessions)
  - Max session duration (auto-kill after total session time)
  - Logging of commands and outputs
  - Optional session banner for security instructions
- Sessions are user-isolated; no shared session data.

### 2.4. SSH Restrictions
- Admins can configure allowed SSH targets and credentials.
- **User Mode:**
  - Mandatory SSH target restrictions by default.
  - Admins can optionally disable restrictions for users, with clear warnings.
- SSH commands must pass through **wrapper scripts** if restrictions are enabled.

### 2.5. Environment & Appearance
- Prompt customization (PS1)
- Theme support (light/dark, colors)
- Command aliases and safe environment variables
- Optional preloaded shell configurations

### 2.6. UI Features
- Admin Panel:
  - Shell selection with warnings
  - Toggle SSH restrictions for users
  - Allowed commands and SSH hosts
  - Session timeout sliders
  - Logging toggle
  - Theme and prompt editor
  - Optional YAML/JSON advanced config editor
- User Terminal Page:
  - Shows restrictions and warnings
  - Optional SSH autocomplete for allowed hosts
  - Safe prompt and session info

### 2.7. Logging & Auditing
- Per-session logs of all commands and outputs
- Optional central audit log
- Configurable retention policy

### 2.8. Security Principles
- Default `rbash` provides secure baseline.
- SSH wrapper scripts enforce restrictions if enabled.
- Users cannot escape allowed commands or the configured PATH.
- UI warnings for dangerous configurations.
- Optional session isolation via chroot or containers.

### 2.9. Configuration Options
- Fully UI-configurable for common admins.
- Optional advanced configuration via YAML/JSON files.
- Options include:
  - Shell selection and warnings
  - SSH restrictions and allowed hosts
  - Idle timeout, max session duration
  - Command whitelists
  - Logging settings
  - Environment variables, PATH, prompt
  - Themes and aliases

---

## 3. Architecture & File Structure

### 3.1. Architecture Overview

       ┌───────────────────┐
       │   Web Frontend     │
       │-------------------│
       │ - Admin UI         │
       │ - User Terminal UI │
       └─────────┬─────────┘
                 │ WebSocket / AJAX
                 ▼
       ┌───────────────────┐
       │   Backend Daemon   │
       │-------------------│
       │ - Session manager  │
       │ - Shell launcher   │
       │ - SSH wrapper logic│
       │ - Timeout & logging│
       │ - Config parser    │
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

### 3.2. File Structure

nShell/
├── bin/
│ ├── nshell.php # CLI wrapper to launch shell sessions
│ ├── ssh-wrapper.sh # Optional SSH restriction wrapper
│ └── restricted-shell.sh # Script to start rbash with configured PATH
├── config/
│ ├── config.yaml # Optional advanced configuration
│ └── shells/ # Optional shell-specific configs
├── lib/
│ ├── SessionManager.php
│ ├── ShellLauncher.php
│ ├── SSHWrapper.php
│ └── Logger.php
├── templates/
│ ├── admin.php
│ ├── terminal.php
│ └── advanced-config.php
├── js/
│ ├── terminal.js
│ └── admin.js
├── css/
│ ├── terminal.css
│ └── admin.css
├── img/
│ └── branding/logo.svg
├── README.md
└── LICENSE

---

## 5. Stage Plans (High-Level)
Based on the "Next Steps" outlined in the project brief:
- **Stage 1: Skeleton & Framework:** Generate skeleton code for the CLI wrapper, session manager, and logging framework.
- **Stage 2: Core Logic Implementation:** Implement SSH wrapper scripts and connect the backend logic.
- **Stage 3: Frontend Development:** Create frontend UI templates and JavaScript logic for the admin panel and terminal.
- **Stage 4: Integration & Connection:** Connect the UI to the backend via AJAX / WebSocket.
- **Stage 5: Finalization & Documentation:** Provide default `rbash` environment, add user documentation, and create zero-config examples.

---

## 6. Project Controls
(Standard controls as per template)
- **Reporting:** Progress tracked in `ACTIVITY.md`, `SESSION_LOG.md` and `CURRENT_STATE.md`.
- **Change Control:** All changes require proposal and approval.
- **Backlog Management:** Tasks generated from project documents and qualified before execution.
- **Quality Assurance:** Code reviews, testing, and continuous documentation updates are mandatory.

---

## 7. Risk, Issue, and Quality Registers

- **Risk Register:**
  - *Risk:* Security vulnerabilities arising from improper shell configuration or escape vulnerabilities.
  - *Impact:* High. Could lead to unauthorized server access.
  - *Mitigation:* Default to most restrictive shell (`rbash`), enforce strict PATH, use wrapper scripts, and display prominent warnings in the UI for less secure configurations.
  - *Risk:* Complexity in ensuring robust session isolation.
  - *Impact:* Medium. Could lead to users impacting each other's sessions.
  - *Mitigation:* Run each shell in a separate, isolated process. Investigate `chroot` for additional security.

- **Issue Register:**
  - *No issues registered at project initiation.*

- **Quality Register:**
  - All code must be reviewed.
  - All documentation must be updated with every change.
  - Key project state documents (PID, CURRENT_STATE.md, etc.) must remain in sync.

---

## 8. Project Organisation (Roles & Responsibilities)

- **Project Board / Project Executive:** [TBD]
- **Project Manager:** Project Manager
- **Senior Supplier / Lead Developer:** [TBD]

---

## 9. Communication Management Approach
- **Primary Method:** All communication via interactive session with the user.
- **Reporting:** Progress reported via `CURRENT_STATE.md` and `ACTIVITY.md`.
- **Direction:** User provides approvals, feedback, and new directives.

---

## 10. Configuration Management Approach

- **Source Code:** Managed in Git.
- **Documentation:** Markdown files versioned in Git alongside the code.
- **Project State:** Tracked in living documents (`ACTIVITY.md`, `CURRENT_STATE.md`, `PID.md`).

---

## 11. Tailoring Approach
This project adapts PRINCE2 principles by using a "living documents" approach, where core documents like the PID are continuously updated. It favors a flexible, iterative development process guided by user interaction, while maintaining formal documentation for clarity and control.

---

## 12. Appendix / References
- `ROADMAP.md`
- `EXECUTION_PLAN.md`
- `TRACEABILITY_MATRIX.md`
- `PROJECT_REGISTRY.md`
- `logs/ACTIVITY.md`
- `logs/CURRENT_STATE.md`
