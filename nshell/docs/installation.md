# Installation Guide

This guide provides instructions for installing the nShell application on your Nextcloud server. We recommend using the automated installation script, but manual instructions are also provided.

## Method 1: Automated Installation (Recommended)

The easiest way to install nShell is by using the provided installation script. This script will download the latest release from GitHub, place it in your Nextcloud apps directory, and enable it.

### Prerequisites
- `curl` or `wget`
- `tar`
- `sudo` access (to run `occ` as the web server user)
- The path to your Nextcloud installation.

### Running the Script
1.  Download the installation script from the root of the nShell repository:
    ```bash
    wget https://<your_repo_url>/install.sh
    ```
2.  Make the script executable:
    ```bash
    chmod +x install.sh
    ```
3.  Run the script. You may need to set the `NC_PATH` environment variable if your Nextcloud installation is not in the default `/var/www/nextcloud` location.

    ```bash
    # Example for a standard Ubuntu/Debian server:
    sudo NC_PATH="/var/www/nextcloud" HTTP_USER="www-data" ./install.sh
    ```

### Script Configuration
You can configure the script using environment variables:
- `NC_PATH`: The absolute path to your Nextcloud root directory. (Default: `/var/www/nextcloud`)
- `HTTP_USER`: The user that your web server runs as. (Default: `www-data`)
- `RELEASE_URL`: The URL to the nShell release `.tar.gz` file. (Default: points to the latest v1.0.0 tag)

---

## Method 2: Manual Installation

If you prefer to install the app manually, follow these steps.

### 1. Build the App Package
First, you need a packaged version of the app (`nshell.tar.gz`). You can either download a pre-packaged release from the GitHub releases page or build it from source.

To build from source, run this command from the root of the repository:
```bash
tar -czvf nshell.tar.gz nshell/
```

### 2. Copy to Server
Transfer the `nshell.tar.gz` archive to your Nextcloud server.

### 3. Extract into Apps Directory
Extract the archive into your Nextcloud `apps` directory.

```bash
# Example path
NC_APPS_DIR="/var/www/nextcloud/apps"

# Extract the archive
tar -xzf nshell.tar.gz -C "$NC_APPS_DIR"
```
### 4. Set Permissions
Ensure the new `nshell` directory and its contents are owned by your web server user.

```bash
# Example for Debian/Ubuntu
HTTP_USER="www-data"
chown -R "$HTTP_USER":"$HTTP_USER" /var/www/nextcloud/apps/nshell
```

### 5. Enable the App with `occ`
Finally, use Nextcloud's `occ` command-line tool to enable the app. You must run this command as your web server user.

```bash
# Example for Debian/Ubuntu
NC_PATH="/var/www/nextcloud"
HTTP_USER="www-data"

sudo -u "$HTTP_USER" php "$NC_PATH/occ" app:enable nshell
```

The nShell app should now be installed and enabled.
