#!/bin/bash

# nShell Installer Script
#
# This script automates the download and installation of the nShell Nextcloud app.

set -e # Exit immediately if a command exits with a non-zero status.

# --- Configuration (can be overridden by environment variables) ---
NC_PATH=${NC_PATH:-"/var/www/nextcloud"}
HTTP_USER=${HTTP_USER:-"www-data"}
RELEASE_URL=${RELEASE_URL:-"https://github.com/Patrick010/nShell/archive/refs/tags/v1.0.0.tar.gz"} # Example URL
APP_ID="nshell"

# --- Helper Functions ---
print_info() {
    echo "[INFO] $1"
}

print_error() {
    echo "[ERROR] $1" >&2
    exit 1
}

# --- Pre-flight Checks ---
print_info "Starting nShell installation..."

if ! command -v curl &> /dev/null; then
    print_error "'curl' is not installed. Please install it to continue."
fi
if ! command -v tar &> /dev/null; then
    print_error "'tar' is not installed. Please install it to continue."
fi
if [[ ! -d "$NC_PATH" ]]; then
    print_error "Nextcloud path not found at '$NC_PATH'. Please set NC_PATH correctly."
fi
if [[ ! -f "$NC_PATH/occ" ]]; then
    print_error "occ command not found at '$NC_PATH/occ'. Is this the correct Nextcloud root?"
fi

# --- Installation ---
TMP_DIR=$(mktemp -d)
ARCHIVE_PATH="$TMP_DIR/nshell.tar.gz"
EXTRACT_PATH="$TMP_DIR/extract"

print_info "Downloading nShell from $RELEASE_URL..."
if ! curl -L "$RELEASE_URL" -o "$ARCHIVE_PATH"; then
    print_error "Failed to download the release archive."
fi

print_info "Extracting archive..."
mkdir -p "$EXTRACT_PATH"
if ! tar -xzf "$ARCHIVE_PATH" -C "$EXTRACT_PATH" --strip-components=1; then
    print_error "Failed to extract the archive."
fi

APPS_DIR="$NC_PATH/apps"
TARGET_DIR="$APPS_DIR/$APP_ID"

print_info "Installing app to $TARGET_DIR..."
if [ -d "$TARGET_DIR" ]; then
    print_info "Existing nShell directory found. Removing it first."
    rm -rf "$TARGET_DIR"
fi
mv "$EXTRACT_PATH" "$TARGET_DIR"

print_info "Enabling app via occ..."
if ! sudo -u "$HTTP_USER" php "$NC_PATH/occ" app:enable "$APP_ID"; then
    print_error "Failed to enable the nShell app via occ. Check permissions and Nextcloud logs."
fi

# --- Cleanup ---
rm -rf "$TMP_DIR"

print_info "nShell installation completed successfully!"
