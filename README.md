# nShell

![nShell Logo](img/branding/logo.svg)

**nShell** is a **Nextcloud plugin** that provides a powerful, fully configurable restricted shell environment for administrators. nShell makes server management safe, elegant, and appealing—directly from the Nextcloud web interface or CLI.

---

## Project Status

**Note:** This application was recently repaired from a non-functional state (see `project/HANDOVER_BRIEF.md` for details). The core functionality of providing a web terminal to an authorized user group is now stable. However, many of the advanced features described in this README are from the original design and are not yet implemented.

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

We provide an automated installation script for ease of use. For detailed instructions on using the script, as well as manual installation steps, please see the full **[Installation Guide](./docs/installation.md)**.

---

## Architecture & Running the Daemon

**Important:** nShell uses a persistent WebSocket server to provide a stateful, real-time terminal experience. This server is a separate process that you must run in the background.

To start the daemon, run the following command from your Nextcloud root directory:

```bash
php nshell/bin/daemon.php
```

This will start the WebSocket server. For production use, you should run this as a persistent background service using a tool like `systemd` or `supervisor`.

*Note: The WebSocket URL is currently hardcoded in `nshell/js/terminal.js` to point to `ws://127.0.0.1:8080`. This will be made configurable in the future.*

### Quick Start with `install.sh`

1. Download the installation script from the project repository:
   ```bash
   wget https://<your_repo_url>/raw/branch/main/nshell/install.sh
   ```
2. Make it executable:
   ```bash
   chmod +x install.sh
   ```
3. Run the script (you will likely need `sudo`):
   ```bash
   # Example for a standard Ubuntu/Debian server
   sudo NC_PATH="/var/www/nextcloud" ./install.sh
   ```

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
