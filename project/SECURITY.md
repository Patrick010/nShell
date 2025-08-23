# nShell Security

**Date:** 2025-08-23
**Status:** Live Document

## 1. Security Philosophy
The nShell plugin is designed with a "secure by default" philosophy. The primary goal is to provide powerful shell access without compromising server security. Our approach is to provide a highly restricted baseline out-of-the-box, while giving administrators explicit control and clear warnings for any configuration changes that could increase risk.

## 2. Implemented Security Features

This section describes the core security model for nShell.

### 2.1. Default Restricted Shell
The cornerstone of nShell's security is the default use of `rbash` (restricted Bash).
- **Mechanism:** By default, all user sessions are launched into `rbash`.
- **Restrictions:** `rbash` prevents users from:
    - Changing directories with `cd`.
    - Modifying `PATH`, `SHELL`, `ENV`, or `BASH_ENV`.
    - Redirecting output.
    - Executing commands containing a `/`.
- **Configuration:** Administrators can allow other, unrestricted shells (`bash`, `zsh`), but the UI provides a **prominent warning** about the security implications of doing so.

### 2.2. PATH Control and Command Whitelisting
The environment for shell sessions is tightly controlled.
- **Mechanism:** The `PATH` environment variable is explicitly set by the `ShellLauncher` and does not include directories with dangerous commands.
- **Configuration:** Administrators can define the safe `PATH` and a specific list of allowed commands in the `config.yaml` file.

### 2.3. SSH Restrictions via Wrapper Scripts
To control remote access, SSH commands are intercepted.
- **Mechanism:** The `PATH` for the restricted shell points to a `ssh-wrapper.sh` script instead of the real `ssh` binary.
- **Logic:** The wrapper script validates the user's intended destination against a whitelist of allowed SSH targets. If the target is not on the list, the command is blocked.
- **Configuration:** SSH restrictions are mandatory for regular users by default but can be disabled by an administrator, again with clear UI warnings.

### 2.4. Session Isolation
Each user's shell session is isolated to prevent interference.
- **Mechanism:** Each shell is launched in a separate, distinct process owned by the user.
- **Future Enhancement:** Optional session isolation via `chroot` is planned to provide an even stronger security boundary.

### 2.5. UI Warnings for Dangerous Configurations
The administrator UI is designed to guide towards secure setups.
- **Mechanism:** Any configuration choice that deviates from the secure defaults (e.g., choosing an unrestricted shell, disabling SSH restrictions) will trigger a clear and understandable warning banner in the admin panel.

## 3. Security Roadmap (Future Enhancements)
For full details, see the [`FUTURE_ENHANCEMENTS.md`](./FUTURE_ENHANCEMENTS.md) document.

- **Container-Based Isolation:** For maximum security, future versions may offer the ability to run each shell session inside a dedicated, ephemeral container (e.g., using Docker).
- **Fine-Grained Command Permissions:** A more advanced system could allow administrators to define not just allowed commands, but also the specific arguments allowed for each command.
- **Two-Factor Authentication (2FA) for Shell Access:** Requiring 2FA before a shell session can be initiated.
