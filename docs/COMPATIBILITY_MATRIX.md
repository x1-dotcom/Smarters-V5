# X1 Smarters V5 — Compatibility Matrix

This document records only behavior supported by evidence from the supplied `TitanSmartes.apk` and legacy `Panel.zip`.

## Client identity

| Item | Evidence | Status |
|---|---|---|
| Android package | `com.titan.smart` present in binary AndroidManifest | CONFIRMED |
| Core namespace | `com.nst.iptvsmarterstvbox.*` present throughout manifest/classes | CONFIRMED |
| Android TV launcher | `LEANBACK_LAUNCHER` present | CONFIRMED |
| VPN capability | OpenVPN binaries/native libraries bundled for ARM/ARM64/x86/x86_64 | CONFIRMED |
| Playback stacks | ExoPlayer-related classes + IJK native libraries present | CONFIRMED |
| TMDB hooks | `api.themoviedb.org/3/` and TMDB image endpoints present | CONFIRMED |

## Legacy contract discovered

| Feature | Legacy endpoint / behavior | APK evidence | New X1 target | Status |
|---|---|---|---|---|
| DNS / portals | `api/dns.php` returning status + comma-separated `su` URLs | Panel confirmed; APK contains Xtream/player API paths | versioned read-only config endpoint compatible with client contract | DISCOVERED |
| Player proxy | `api/player_api.php` scans configured DNS entries and redirects to active Xtream `player_api.php` | `/player_api.php` string present | avoid credential-logging; preserve only if client really requires proxy behavior | DISCOVERED |
| Sports | `api/sport.php` / `sports.php` renders a sports widget | sports code paths exist in APK | normalized X1 sports provider contract where possible | DISCOVERED |
| VPN | `api/vpn.php` creates and downloads `ovpn.zip` | bundled OpenVPN components confirmed | authenticated profile bundle delivery with safe credentials handling | DISCOVERED |
| Update | `api/update.php?id=<package>` redirects to configured APK URL | update activities/paths present | signed/versioned update metadata; no arbitrary redirects | DISCOVERED |
| Intro | `api/intro.php` redirects to intro media or blank MP4 | intro/media assets present in old panel | controlled intro asset endpoint | DISCOVERED |
| Notes / announcements | `api/note.php` intended to emit title/message/date JSON | notification/announcement activities present | validated JSON announcements API | DISCOVERED |
| Ads | `api/getads.php`, `adpage.php`, `adview.php`, `autoads.php` | ad SDK/code present | optional community ad contract; device-tested before GREEN | DISCOVERED |
| Rate | `api/rate.php` redirect | RateUs activity present | safe configured destination | DISCOVERED |
| Devices | old panel has `devices.php`; APK has extensive device registration code | confirmed | X1 device registry/view, no fake online state | DISCOVERED |
| Feedback / reports | `feedback.php`, `reports.php` | client paths not yet fully mapped | authenticated/sanitized feedback API if consumed | DISCOVERED |
| Maintenance | `maint.php`; APK includes maintenance panel activity | confirmed namespace/activity | signed/config-driven maintenance state | DISCOVERED |
| Branding/background/logo | legacy `Background/`, `logo/`, panel editors | branding assets/hooks require deeper mapping | X1-controlled asset serving with upload validation | DISCOVERED |

## Important findings from APK intake

The APK contains external/default endpoints and third-party service references including:

- `http://api-android.whmcssmarters.com/`
- `https://users.iptvsmarters.com/`
- `https://api.themoviedb.org/3/`
- OpenSubtitles API endpoints
- Google/Firebase/ads infrastructure

These references are evidence of embedded code paths only. They are **not** copied into the X1 panel as authorities and they are not evidence that every feature is active in this specific build.

## Verification rule

A row can be `GREEN` only after all applicable steps are proven:

`Panel/UI → X1 endpoint → real APK request → client-visible behavior → negative test`

No endpoint is marked supported merely because a similarly named PHP file existed in the legacy panel.

## Next intake tasks

1. Extract the precise request/response shape for DNS/config calls from the APK.
2. Determine the exact base URL selection/obfuscation mechanism used by this Titan build.
3. Map update request fields and package/version checks.
4. Map VPN bundle expectations, filenames and credential handling.
5. Map maintenance/announcement payloads.
6. Determine which ad endpoints are actually called in this build.
7. Map device registration and any identifiers sent by the client.
8. Build the clean X1 compatibility API only from proven contracts.
