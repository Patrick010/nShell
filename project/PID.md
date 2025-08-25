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

## 2. Detailed Project Scope & Product Breakdown

### 2.1 In Scope
- [x] **Zero-Config Principle:** Works immediately after installation with `rbash`, session timeouts, and SSH restrictions enabled.
- [x] **Shell Management:** Default `rbash`, with optional `bash`, `zsh`, `fish` behind clear UI warnings.
- [x] **Session Management:** Isolated processes with configurable idle/max timeouts and logging.
- [x] **SSH Restrictions:** Wrapper scripts to enforce allowed SSH targets for non-admin users.
- [x] **Environment & Appearance:** Customizable prompt (PS1), themes (light/dark), and aliases.
- [x] **UI Features:** An Admin Panel for configuration and a User Terminal Page with an `xterm.js` terminal.
- [x] **Logging & Auditing:** Per-session logs and an optional central audit log.
- [x] **Advanced Configuration:** Optional YAML/JSON files for power users.
- [x] **Security Principles:** Default to `rbash`, use SSH wrappers, and restrict PATH.

### 2.2 Out of Scope (Current Phase)
- Advanced session isolation via containers (e.g., Docker). Only process-level and optional chroot isolation is planned.
- Support for shells beyond `rbash`, `bash`, `zsh`, and `fish`.
- Automated log analysis or alerting.

### 2.3 Main Products (Deliverables)
1.  **Backend Application:** Core PHP logic for session management, shell launching, and configuration parsing (`lib/`).
2.  **Frontend UI:** Admin panel and user terminal pages (`templates/`, `js/`, `css/`).
3.  **CLI Wrappers & Scripts:** Scripts to launch sessions and enforce SSH restrictions (`bin/`).
4.  **Configuration Files:** Default and example configuration files (`config/`).
5.  **Project & User Documentation:** A full set of project management documents and user guides.

### 2.4 Deferred Features
Deferred features are tracked in `FUTURE_ENHANCEMENTS.md` until they are promoted to an active roadmap phase.

---

## 3. Stage Plans (High-Level)
Based on the "Next Steps" outlined in the project brief:
- **Stage 1: Skeleton & Framework:** Generate skeleton code for the CLI wrapper, session manager, and logging framework.
- **Stage 2: Core Logic Implementation:** Implement SSH wrapper scripts and connect the backend logic.
- **Stage 3: Frontend Development:** Create frontend UI templates and JavaScript logic for the admin panel and terminal.
- **Stage 4: Integration & Connection:** Connect the UI to the backend via AJAX / WebSocket.
- **Stage 5: Finalization & Documentation:** Provide default `rbash` environment, add user documentation, and create zero-config examples.

---

## 4. Project Controls
(Standard controls as per template)
- **Reporting:** Progress tracked in `ACTIVITY.md`, `SESSION_LOG.md` and `CURRENT_STATE.md`.
- **Change Control:** All changes require proposal and approval.
- **Backlog Management:** Tasks generated from project documents and qualified before execution.
- **Quality Assurance:** Code reviews, testing, and continuous documentation updates are mandatory.

---

## 5. Risk, Issue, and Quality Registers

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

## 6. Project Organisation (Roles & Responsibilities)

- **Project Board / Project Executive:** [TBD]
- **Project Manager:** Project Manager
- **Senior Supplier / Lead Developer:** [TBD]

---

## 7. Communication Management Approach
- **Primary Method:** All communication via interactive session with the user.
- **Reporting:** Progress reported via `CURRENT_STATE.md` and `ACTIVITY.md`.
- **Direction:** User provides approvals, feedback, and new directives.

---

## 8. Configuration Management Approach

- **Source Code:** Managed in Git.
- **Documentation:** Markdown files versioned in Git alongside the code.
- **Project State:** Tracked in living documents (`ACTIVITY.md`, `CURRENT_STATE.md`, `PID.md`).

---

## 9. Tailoring Approach
This project adapts PRINCE2 principles by using a "living documents" approach, where core documents like the PID are continuously updated. It favors a flexible, iterative development process guided by user interaction, while maintaining formal documentation for clarity and control.

---

## Appendix / References
- `ROADMAP.md`
- `EXECUTION_PLAN.md`
- `TRACEABILITY_MATRIX.md`
- `PROJECT_REGISTRY.md`
- `logs/ACTIVITY.md`
- `logs/CURRENT_STATE.md`
