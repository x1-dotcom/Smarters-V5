# X1 Smarters Panel v1.3

Self-hosted application management panel for compatible Smarters builds.

## Highlights

- English / Portuguese administration
- Device registry, rules, profiles and bulk actions
- APK Contract Lab, APK Lab and Android Validation
- DNS Handshake Lab
- TV/mobile pairing
- Branding, VPN, Sports and Advertising
- Announcements, reports and feedback
- APK upload, history and rollback
- Backup / restore and Migration Assistant
- Diagnostics, Health Checks, alerts and notifications
- Owner / Admin / Operator / Read Only roles
- TOTP 2FA
- Telegram notifications and secure bot commands
- Discord, signed HTTPS webhooks and email integrations

## Requirements

- PHP 8.1+
- OpenSSL
- Apache or Nginx
- writable `data/`, `uploads/` and `backups/`
- HTTPS recommended
- PHP cURL recommended for external integrations
- PHP ZipArchive for ZIP migration
- PHP SQLite3 for legacy SQLite extraction

## Public package

The public PHP build is conservatively minified/obfuscated. No `eval`, encoded runtime loader or unpacker is used.

GitHub stores the binary package in three parts under `release/`.

### Linux / macOS

```bash
cd release
chmod +x assemble-linux-macos.sh
./assemble-linux-macos.sh
```

### Windows

Run:

```text
release\assemble-windows.cmd
```

The resulting archive is:

`X1_SMARTERS_PANEL_v1.3_PUBLIC_CLEAN_OBFUSCATED.tar.bz2`

SHA-256:

`64ed75e560dc752080d65a19fb69c9c40178a915c6cf3995a69df3609997178b`

## Installation

1. Assemble and extract the public package.
2. Ensure `data/`, `uploads/` and `backups/` are writable.
3. Open `install.php`.
4. Create the Owner account.
5. Open Diagnostics.
6. Configure the Smarters contract and services.
7. Validate the exact Android build before production use.

Main application endpoint: `api/api.php`

Logo and intro media are intentionally not bundled in the lightweight public archive. Upload them from **Branding** after installation.

## Compatibility note

Different application builds can implement remote configuration differently. Server-side delivery does not by itself prove visual Android behavior. Use Android Validation for real-device PASS / FAIL / N/A testing.

## Community

- Telegram: https://t.me/+XkuQS_QuD6g4Nzc0
- Forum: https://forum.x1panel.space
- Discord: https://discord.gg/vSSw6jHmw

Copyright © 2026 X1Tech Solutions SA. All Rights Reserved.
