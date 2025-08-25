# Project Initiation Document (PID)

**Project Name:** nShell: Fully Configurable, Zero-Config Restricted Shell
**Date:** 2025-08-25
**Version:** 1.1
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
- **Admin UI:** An interface for administrators that includes a terminal view and forms to configure all application settings.
- **User Terminal UI:** A restricted terminal-only interface for non-admin users.
- Access is controlled by a single dispatch controller based on user role (admin vs. group member).

### 2.7. Logging & Auditing
- Per-session logs of all commands and outputs
- Optional central audit log
- Configurable retention policy

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
       │ - Config service   │
       └─────────┬─────────┘
                 │
                 ▼
       ┌───────────────────┐
       │ Restricted Shell   │
       │-------------------│
       │ - rbash (default)  │
       │ - Optional shells  │
       └───────────────────┘

### 3.2. File Structure
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

---

## 4. Project Controls
- **Reporting:** Progress tracked in `ACTIVITY.md`, `SESSION_LOG.md` and `CURRENT_STATE.md`.
- **Quality Assurance:** Code reviews, testing, and continuous documentation updates are mandatory.
