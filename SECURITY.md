# Security Policy

Please do not publish production credentials, API keys, VPN credentials, IPTV credentials, signing keys, SSH keys or database files in issues, pull requests or commits.

For security-sensitive reports, contact the X1 project maintainers privately through the official X1 channels.

## Supported public code

Only the X1-owned Community implementation in this repository is intended for public deployment. Legacy compatibility material and third-party APKs are not redistributed here unless licensing/redistribution rights are explicitly established.

## Deployment baseline

A production deployment must use:

- HTTPS
- secure admin bootstrap (no default password)
- hashed passwords
- CSRF protection
- prepared statements
- secure sessions
- least-privilege filesystem permissions
- secrets outside the web root
- backups
- audit logging

Obfuscation is defense-in-depth for X1-owned distributable code; it does not replace the controls above.
