# X1 Smarters V5 Community

X1 Smarters V5 Community is the public compatibility/control-panel project for the Smarters V5 / Titan Smart family used in the X1 ecosystem.

> Status: **Phase S1 — clean community control plane implemented; device compatibility validation in progress**.

## What this repository is

This repository contains an X1-owned Community control plane, compatibility documentation and installable baseline for supported Smarters V5-compatible clients.

The legacy panel supplied for compatibility analysis is **not** redistributed or copied unchanged. The X1 implementation reproduces only the compatibility contracts required by clients, with a new secure administration layer.

## Confirmed from the supplied test APK

- Android package: `com.titan.smart`
- Core namespace present: `com.nst.iptvsmarterstvbox.*`
- Android TV launcher support
- Native OpenVPN components for ARM/ARM64/x86/x86_64
- ExoPlayer/Media3-era playback components plus IJK native libraries
- Remote/update, device, VPN, sports/content and TMDB-related code paths

## Community control plane

The new panel now includes:

- secure first-run administrator creation
- `password_hash()` / `password_verify()` authentication
- CSRF protection
- secure session cookies
- prepared SQLite statements
- audit trail
- modern responsive X1 UI
- dashboard using real database counters only
- Portal / DNS management
- runtime Maintenance configuration
- Advertisement / Note hooks
- Intro URL and Rate URL
- update package / APK URL
- VPN compatibility settings
- Sports feed hook
- observed Devices view
- Announcements
- Reports view
- Audit view
- automatic copyright year
- X1 Forum / Telegram / Discord links

## Compatibility API

Implemented clean-room compatibility endpoints currently include:

- `community/panel/api/dns.php`
- `community/panel/api/index.php`
- `community/panel/api/intro.php`
- `community/panel/api/note.php`
- `community/panel/api/rate.php`
- `community/panel/api/update.php`
- `community/panel/api/vpn.php`
- `community/panel/api/sport.php`
- `community/panel/api/sports.php`

The legacy contracts for maintenance, advertisements, devices, reports, feedback and announcements are mapped in the runtime layer/documentation as well.

**Important:** an endpoint existing does not make a feature GREEN. Each feature must still pass a real client test:

`Panel → X1 compatibility endpoint → real APK request → visible device behaviour → negative test → GREEN`

See [`docs/COMPATIBILITY_MATRIX.md`](docs/COMPATIBILITY_MATRIX.md).

## Installation

Requirements:

- PHP 8.1+ recommended
- PHP `SQLite3` extension
- writable `community/panel/data/` directory for the web/PHP user
- HTTPS in production

Basic flow:

1. Deploy `community/panel/` under your web root.
2. Ensure PHP SQLite3 is enabled.
3. Open `setup.php` in the browser.
4. Create the first administrator. There are **no default credentials**.
5. Sign in through `index.php`.
6. Configure Portals and Runtime settings.
7. Point a compatible test client at the installation only after validating the expected client contract.

The first-run setup page automatically disables itself after the first admin exists.

## Security policy

The old compatibility panel contained patterns we will not reproduce: default credentials, plaintext passwords, SQL concatenation, secrets bundled in files and disabled TLS verification in a proxy path.

The X1 Community version instead requires:

- password hashing
- CSRF on administrative writes
- prepared statements
- secure session cookie flags
- no default `admin/admin`
- no real IPTV/VPN/API secrets in Git
- no APK signing keys in Git
- no database files in Git
- audit logging
- server-side input validation

See [`docs/SECURITY_INTAKE.md`](docs/SECURITY_INTAKE.md) and [`SECURITY.md`](SECURITY.md).

## Repository layout

```text
Smarters-V5/
├── README.md
├── NOTICE.md
├── SECURITY.md
├── docs/
│   ├── COMPATIBILITY_MATRIX.md
│   ├── PHASE_S1_RUNTIME.md
│   └── SECURITY_INTAKE.md
└── community/
    ├── README.md
    └── panel/
        ├── api/
        ├── assets/
        ├── data/          # runtime, ignored by Git
        ├── includes/
        ├── install/
        ├── setup.php
        ├── index.php
        ├── studio.php
        └── logout.php
```

## Public distribution / protection

The public Community project may distribute protected/minified X1-owned runtime artifacts. Protection is intended to protect X1 implementation IP — not to conceal licensing bypasses or redistribute proprietary third-party source code.

The supplied Titan/Smarters APK and the legacy panel are analysis inputs and are not committed to this repository.

## X1 Community

- Forum: https://forum.x1panel.space/
- Telegram: https://t.me/+XkuQS_QuD6g4Nzc0
- Discord: https://discord.gg/vSSw6jHmw

Copyright © 2026 X1Tech Solutions SA. All Rights Reserved.
