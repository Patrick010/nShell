# nShell

![nShell Logo](img/branding/logo.svg)

**nShell** is a **Nextcloud plugin** that provides a powerful, fully configurable restricted shell environment for administrators. Inspired by Home Assistant’s restricted shell, nShell makes server management safe, elegant, and appealing—directly from the Nextcloud web interface or CLI.

---

## Key Features

### Secure by Default
- Default shell: `rbash` (restricted Bash)
- User sessions are **fully isolated**
- Mandatory SSH restrictions for users (optional for admins)
- Optional containerized or chroot environments for extra isolation
- Command whitelist enforcement and PATH control

### Fully Configurable
- Change shell selection (bash, zsh, fish) with clear warnings
- Session management:
  - Idle timeout
  - Max session duration
  - Logging and audit
- Customize environment:
  - Safe PATH
  - Aliases
  - Prompt (`PS1`)
  - Themes (light/dark)
- Optional advanced YAML/JSON configuration for power users

### Nextcloud Web UI
- Admin panel for effortless configuration
- Toggle SSH restrictions and allowed commands
- Visual sliders for session timeouts
- Theme selector and prompt editor
- Optional inline advanced config editor
- Terminal page with:
  - SSH host autocomplete
  - Warning banners for restricted environments
  - Fully interactive xterm.js terminal

### Zero-Config
- Works immediately after installation—no editing required
- Default safe session and SSH restrictions for users
- Config files exist only for advanced administrators who want more control

### Auditing & Logging
- Per-session command and output logs
- Optional centralized audit logging
- Configurable retention policies
- Clear traceability for compliance and security

### Advanced Power Features
- Preloaded shell-specific configurations
- Session banners for warnings or guidance
- Optional wrapper scripts for commands like `ssh`, `scp`, `rsync`
- Optional themes for personalized experience
- Auto SSH target completion for user convenience

---

## Installation

1. Download the latest nShell Nextcloud plugin package:

```bash
wget https://example.com/nshell-latest.zip
```

2. Install via Nextcloud UI:
   - Go to **Apps → Install from file**
   - Upload `nshell-latest.zip`
   - Enable the app

3. Access nShell from the main navigation:
   - Open the **Terminal** page
   - Admins can configure settings from the **Admin Panel**

> nShell works immediately with **zero configuration**. The default shell is `rbash`, sessions are secure, and SSH restrictions are enabled for users.

---

## Configuration

- **UI Configuration:** Accessible from the Nextcloud admin panel for effortless adjustments.
- **Advanced Configuration:** Optional YAML/JSON file `config/config.yaml`:
  - Default shell selection
  - Allowed commands
  - SSH restrictions
  - Session timeouts
  - Logging and audit settings
  - Themes and prompts

---

## Security Notes

- Default shell: `rbash` (restricted Bash). Safe by default.
- Choosing unrestricted shells (bash, zsh, fish) displays a **prominent warning**.
- SSH restrictions are mandatory for users by default. Admins can override if necessary, but the UI shows clear warnings.
- All commands and sessions are isolated to protect your system.

---

## Why nShell?

nShell is **more than just a shell**. It’s a secure, flexible, and visually appealing Nextcloud plugin designed for modern administrators who want safety without sacrificing power. Zero-config by default, with advanced options at your fingertips—nShell makes managing your servers smarter, safer, and smoother.

---

## Documentation & Support

- Full documentation included in `docs/`
- Example `config.yaml` for zero-config and advanced setups
- Community support and issue tracking via [GitHub](https://github.com/Patrick010/nShell)
