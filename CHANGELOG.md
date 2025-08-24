# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Fixed
- Corrected a fatal error on Nextcloud 20+ caused by the application using a deprecated bootstrap interface (`IBootable`). The app is now compatible with the modern `IBootstrap` standard.
