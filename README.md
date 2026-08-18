# X1 Smarters V5 Community

X1 Smarters V5 Community is the public compatibility/control-panel project for the Smarters V5/Titan Smart family used in the X1 ecosystem.

> Status: **Phase S1 — compatibility intake and clean community base**.

## What this repository is

This repository will contain the X1-owned community panel, installer, compatibility documentation and distributable protected/obfuscated community artifacts needed to control supported Smarters V5-compatible clients.

The project is being rebuilt around a clean contract instead of publishing the legacy panel unchanged.

## What we confirmed from the supplied test APK

- Android package: `com.titan.smart`
- Core application namespace present in the APK: `com.nst.iptvsmarterstvbox.*`
- Android TV launcher support is present.
- The APK includes native OpenVPN components for ARM/ARM64/x86/x86_64.
- The APK contains ExoPlayer/Media3-era playback components plus IJK native libraries.
- The APK contains remote/update, device, VPN, sports/content and TMDB-related code paths that are being mapped against the legacy panel.

## Community target

The Community edition is intended to provide a safe, installable baseline with:

- Portal/DNS management
- Remote branding hooks
- Maintenance mode
- Intro/video configuration
- Announcements/notes
- Ads where the client contract supports them
- Sports integration where the client contract supports it
- VPN profile distribution where the client contract supports it
- Update metadata
- Device visibility
- Feedback/report endpoints
- X1 branding and modern administration UI
- Audit logging and secure authentication

Only features verified against a real client will be marked as supported.

## Security policy

The legacy panel supplied for compatibility analysis is **not** published as-is. It contains unsafe patterns such as a default `admin/admin` account, plaintext passwords, direct SQL string concatenation, disabled TLS verification in one proxy endpoint, and unprotected/public data endpoints.

The X1 Community panel will instead use:

- `password_hash()` / `password_verify()`
- CSRF protection
- prepared statements
- secure session cookies
- server-side validation
- upload validation
- secrets outside the public repository/docroot
- no default credentials
- no IPTV, VPN or API secrets in Git
- audit logs for administrative changes

See [`docs/SECURITY_INTAKE.md`](docs/SECURITY_INTAKE.md).

## Compatibility work

The contract discovered from the supplied APK and old panel is tracked in:

[`docs/COMPATIBILITY_MATRIX.md`](docs/COMPATIBILITY_MATRIX.md)

Every row moves through:

`DISCOVERED → IMPLEMENTED → DEVICE_TESTED → GREEN`

A backend endpoint alone does **not** count as supported.

## Repository layout

```text
Smarters-V5/
├── README.md
├── NOTICE.md
├── SECURITY.md
├── docs/
│   ├── COMPATIBILITY_MATRIX.md
│   └── SECURITY_INTAKE.md
├── community/
│   └── README.md
└── .gitignore
```

The clean panel implementation and installer will be added under `community/` after the Phase S1 contract is closed.

## X1 Community

- Forum: https://forum.x1panel.space/
- Telegram: https://t.me/+XkuQS_QuD6g4Nzc0
- Discord: https://discord.gg/vSSw6jHmw

Copyright © 2026 X1Tech Solutions SA. All Rights Reserved.
