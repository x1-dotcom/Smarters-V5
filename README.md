<p align="center">
  <img src="./assets/x1-smarters-hero.svg" alt="X1 Smarters Panel" width="100%" />
</p>

<p align="center">
  <strong>PUBLIC · COMMUNITY · SELF-HOSTED</strong><br>
  Runtime configuration and application-management tooling for compatible Smarters-family builds.
</p>

<p align="center">
  <a href="https://x1panel.space"><strong>WEBSITE</strong></a>
  &nbsp;·&nbsp;
  <a href="https://forum.x1panel.space"><strong>FORUM</strong></a>
  &nbsp;·&nbsp;
  <a href="https://discord.gg/vSSw6jHmw"><strong>DISCORD</strong></a>
  &nbsp;·&nbsp;
  <a href="https://t.me/+XkuQS_QuD6g4Nzc0"><strong>TELEGRAM</strong></a>
</p>

---

## X1 Smarters Panel v1.3

**X1 Smarters Panel is a self-hosted control surface for managing compatible application builds from one place.**

> **Free means functional.**
> The public X1 release is intended to be useful as released.

It brings together device visibility, runtime configuration, branding, pairing, service integrations, APK handling, diagnostics and administrative controls.

---

<p align="center">
  <img src="./assets/x1-smarters-flow.svg" alt="X1 Smarters runtime control loop" width="100%" />
</p>

## What it controls

- Device registry, rules, profiles and bulk actions
- Runtime/application configuration
- APK Contract Lab and APK Lab
- Android Validation workflow
- DNS Handshake Lab
- TV / mobile pairing
- Branding controls
- VPN configuration
- Sports integrations
- Advertising controls
- Announcements, reports and feedback
- APK upload, version history and rollback
- Backup / restore and Migration Assistant
- Diagnostics, health checks, alerts and notifications
- Owner / Admin / Operator / Read Only roles
- TOTP 2FA
- Telegram notifications and secure bot commands
- Discord, signed HTTPS webhooks and email integrations

The administration interface supports **English and Portuguese**.

---

## Operating model

`DEFINE` → `DELIVER` → `PAIR` → `VALIDATE` → `OPERATE`

The goal is not merely to send configuration. The goal is to close the loop between desired configuration and observed application behavior.

---

<p align="center">
  <img src="./assets/x1-smarters-boundary.svg" alt="X1 Smarters capability boundary" width="100%" />
</p>

## Runtime truth / compatibility

A configuration existing in the panel does **not** prove that every historical, third-party or modified application build consumes it correctly.

The panel can prove what it stores and delivers. Real Android behavior must be validated against the exact client build and device.

**Panel state** → what the server is configured to provide  
**Runtime proof** → what the real application actually does

Use Android Validation before treating a feature as production-proven.

---

## Requirements

- PHP 8.1+
- OpenSSL
- Apache or Nginx
- writable `data/`, `uploads/` and `backups/`
- HTTPS recommended
- PHP cURL recommended for external integrations
- PHP ZipArchive for ZIP migration
- PHP SQLite3 for legacy SQLite extraction

---

## Public package

The public PHP build is conservatively minified/obfuscated. It does not rely on `eval`, encoded runtime loaders or unpackers as a security boundary.

GitHub stores the binary package in three parts under `release/`.

### Linux / macOS

```bash
cd release
chmod +x assemble-linux-macos.sh
./assemble-linux-macos.sh
```

### Windows

```text
release\assemble-windows.cmd
```

The resulting archive is:

`X1_SMARTERS_PANEL_v1.3_PUBLIC_CLEAN_OBFUSCATED.tar.bz2`

Published SHA-256:

`64ed75e560dc752080d65a19fb69c9c40178a915c6cf3995a69df3609997178b`

---

## Installation / Quick Start

1. Assemble and extract the public package.
2. Ensure `data/`, `uploads/` and `backups/` are writable.
3. Open `install.php`.
4. Create the Owner account.
5. Open Diagnostics.
6. Configure the compatible application contract and services.
7. Validate the exact Android build before production use.

Main application endpoint:

`api/api.php`

Logo and intro media are intentionally not bundled in the lightweight public archive. Upload them from **Branding** after installation.

---

## Security / responsibility boundary

Keep production credentials, signing material, private keys, customer information and installation-specific secrets out of public repositories and support reports. Use HTTPS, strong unique administrator credentials, TOTP where appropriate and the minimum filesystem permissions required by the deployment.

---

## Related X1 systems

- [X1 GitHub](https://github.com/x1-dotcom)
- [X1 Panel XCIPTV](https://github.com/x1-dotcom/X1-Panel-XCIPTV)
- [X1 TiviMate Community](https://github.com/x1-dotcom/x1tivimate)

---

## Community

- Forum — https://forum.x1panel.space
- Discord — https://discord.gg/vSSw6jHmw
- Telegram — https://t.me/+XkuQS_QuD6g4Nzc0

---

<p align="center">
  <strong>CONFIGURE THE EXPERIENCE. DELIVER THE STATE. VALIDATE THE BUILD.</strong><br><br>
  <strong>X1 // SOFTWARE · SYSTEMS · OPERATIONS</strong><br><br>
  PUBLIC SOFTWARE. PRIVATE ENGINEERING. ONE X1 IDENTITY.<br><br>
  <strong>© X1Tech Solutions SA · All Rights Reserved</strong>
</p>
