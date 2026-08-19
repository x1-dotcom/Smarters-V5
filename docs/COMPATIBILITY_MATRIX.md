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

The legacy panel uses **`api/api.php` as the action dispatcher**. The clean X1 Community implementation keeps `api/index.php` as the single implementation authority and exposes `api/api.php` only as a compatibility alias, so the contract is preserved without maintaining two implementations.

Confirmed legacy actions in `Panel/api/api.php`:

- `check-maintainencemode`
- `get_advertisemnt_status`
- `add-device`
- `addreport`
- `addclientfeedback`
- `get-announcements`
- `get-ovpnzip`

| Feature | Legacy endpoint / behavior | APK evidence | New X1 target | Status |
|---|---|---|---|---|
| Main action dispatcher | `api/api.php` accepts JSON `{action: ...}` | maintenance/device/report strings found in APK | `api/api.php` compatibility alias → clean `api/index.php` authority | IMPLEMENTED / DEVICE TEST PENDING |
| DNS / portals | `api/dns.php` returning status + comma-separated `su` URLs; legacy POST form also returns plain CSV | Panel confirmed; APK contains Xtream/player API paths | clean `api/dns.php`, same two response shapes | IMPLEMENTED / DEVICE TEST PENDING |
| Maintenance | JSON action `check-maintainencemode` → `result, sc, maintenancemode, message, footercontent` | maintenance activity/path confirmed | clean dispatcher reads validated settings | IMPLEMENTED / DEVICE TEST PENDING |
| Advertisements status | JSON action `get_advertisemnt_status` → `add_status, add_viewable_rate, message` | ad code present | clean dispatcher, no third-party secret embedded | IMPLEMENTED / DEVICE TEST PENDING |
| Device registration | JSON action `add-device` with `deviceid`, `deviceusername`; success message `Details Updated Successfully` | APK contains device registration code/identifiers | upsert into X1 `devices`, hashed ID in audit | IMPLEMENTED / DEVICE TEST PENDING |
| Announcements | JSON action `get-announcements` with `deviceid`; returns `totalrecords`, `data`, per-item `seen` | announcement paths/classes present | clean announcement store + per-device view state | IMPLEMENTED / DEVICE TEST PENDING |
| Feedback / reports | dispatcher actions plus dedicated compatibility endpoints | `addreport`, `addclientfeedback`, report/feedback request names found | sanitized prepared inserts | IMPLEMENTED / DEVICE TEST PENDING |
| VPN metadata | JSON action `get-ovpnzip` → `vpnstatus`, `link` | bundled OpenVPN components confirmed | metadata points to controlled X1 bundle endpoint | IMPLEMENTED / DEVICE TEST PENDING |
| Player proxy | `api/player_api.php` scans configured DNS entries and redirects to active Xtream `player_api.php` | `/player_api.php` string present | avoid credential-logging; preserve only if client really requires proxy behavior | DISCOVERED |
| Sports | `api/sport.php` / `sports.php` renders a sports widget | sports code paths exist in APK | normalized X1 sports provider contract where possible | IMPLEMENTED / DEVICE TEST PENDING |
| Update | `api/update.php?id=<package>` redirects to configured APK URL | update activities/paths present | package allowlist + configured destination; wrong package fail-closed | IMPLEMENTED / DEVICE TEST PENDING |
| Intro | `api/intro.php` redirects to intro media or blank media | intro/media assets present in old panel | controlled intro asset endpoint | IMPLEMENTED / DEVICE TEST PENDING |
| Notes | `api/note.php` emits announcement/note data | notification/announcement activities present | validated JSON notes API | IMPLEMENTED / DEVICE TEST PENDING |
| Ads content | `api/getads.php`, `adpage.php`, `adview.php`, `autoads.php` | ad SDK/code present | optional community ad contract; device-tested before GREEN | DISCOVERED |
| Rate | `api/rate.php` redirect | RateUs activity present | safe configured destination | IMPLEMENTED / DEVICE TEST PENDING |
| Branding/background/logo | legacy `Background/`, `logo/`, panel editors | branding assets/hooks require deeper mapping | X1-controlled asset serving with upload validation | DISCOVERED |

## Device registration contract — confirmed from legacy source

Legacy request:

```json
{
  "action": "add-device",
  "deviceid": "<client-generated identifier>",
  "deviceusername": "<display username>"
}
```

Legacy success response shape:

```json
{
  "result": "success",
  "sc": "<32 hex chars>",
  "message": "Details Updated Successfully"
}
```

The X1 implementation preserves the response shape but does **not** trust the supplied values as authentication. Device presence in this Community compatibility layer is observational only; `last_seen_at` is updated by actual registration calls and the admin UI must not infer permanent online status from a historical row.

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

## Contract smoke coverage

`community/panel/tests/contract-smoke.sh` now exercises 12 server contracts including the exact legacy dispatcher path `api/api.php`, maintenance, ads, device registration, announcements, VPN metadata, DNS, reports, feedback, intro, rate, update fail-closed, and invalid-action rejection.

This is server-contract validation only. It does **not** replace the real APK E2E gate.

## Next intake tasks

1. Point the supplied Titan test APK at an isolated Community panel instance without touching production X1 systems.
2. Capture the real request URL/path and body for startup DNS/config.
3. Confirm whether the APK posts to `api/api.php` exactly or uses an alternate embedded base path.
4. Toggle Maintenance in the X1 UI and prove the client-visible maintenance screen.
5. Observe `add-device` from the APK and verify `last_seen_at`/username in the panel.
6. Map update request fields and package/version checks.
7. Map VPN bundle expectations, filenames and credential handling.
8. Determine which legacy ad endpoints are actually called in this build.
9. Keep every row below GREEN until real-device evidence exists.
