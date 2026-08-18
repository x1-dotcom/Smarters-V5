# Titan Smart APK — Confirmed Compatibility Findings

Source used for analysis: user-supplied `TitanSmartes.apk` (not committed to this repository).

This document records only facts confirmed from the binary. It is **not** a claim of ownership over third-party application code.

## Confirmed application identity

- Android package: `com.titan.smart`
- Core namespace visible in bytecode: `com.nst.iptvsmarterstvbox.*`
- Android TV / Leanback application paths are present.

## Confirmed components

Binary inspection confirms code/resources for:

- Live TV / channel playback
- VOD / Series flows
- EPG
- parental-control flows
- announcements / maintenance
- device registration / identification
- update flows
- VPN / OpenVPN
- advertising-related flows
- ExoPlayer / Media3-era playback code
- IJK native playback libraries
- TMDB image/content integration paths
- OpenSubtitles integration paths

## Confirmed native VPN assets

The APK contains bundled OpenVPN executables for:

- `arm64-v8a`
- `armeabi-v7a`
- `x86`
- `x86_64`

Both PIE and non-PIE OpenVPN binaries are present.

## Confirmed string-level network findings

String extraction from the DEX files confirms references including:

- `/player_api.php`
- `player_api.php`
- `get-advertisement`
- `getMaintenancemode`
- `maintenance_mode`
- `https://api.opensubtitles.com/api/v1/download`
- `https://vip-api.opensubtitles.com/api/v1/download`
- `https://image.tmdb.org/t/p/w500/`
- `https://image.tmdb.org/t/p/w1280/`
- `http://api-android.whmcssmarters.com/`

The presence of a string does **not** prove that a given route is used by the supplied Titan build at runtime. Runtime capture/device E2E remains the authority for compatibility status.

## Security rule

The X1 Community panel does not attempt to intercept, spoof or replace unrelated third-party services simply because their URLs exist in the APK.

Compatibility endpoints are implemented only where the supplied legacy panel plus runtime behaviour establish an actual panel/client contract.

## Runtime verification rule

For every candidate compatibility feature:

`Binary discovery → legacy contract mapping → clean X1 endpoint → real device request → visible behaviour → negative test → GREEN`

Until the real-device portion is complete, status remains `IMPLEMENTED` or `PARTIAL`, never `GREEN`.
