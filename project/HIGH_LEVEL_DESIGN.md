# High-Level Design (HLD) – nShell

## 1. Objective
Build **nShell**, a user-friendly, fully configurable restricted shell environment inspired by Home Assistant. Default shell is `rbash`, but admins can optionally allow other shells (bash, zsh, fish) with a clear warning. The system must be **zero-config by default**: it should work immediately after installation with sensible defaults. Optional config files are available only for advanced admins.

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

## 3. Architecture Overview

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


---

## 4. File Structure

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
