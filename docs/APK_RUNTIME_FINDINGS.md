# Titan Smart / Smarters V5 — runtime findings

Source under analysis: user-supplied `TitanSmartes.apk` used only to discover interoperability contracts. The APK itself is **not** redistributed by this repository.

## Confirmed package / family

- Package: `com.titan.smart`
- Internal namespace strings/classes: `com.nst.iptvsmarterstvbox.*`
- Android TV/Leanback-related code is present.
- Native OpenVPN support is present in the APK payload.
- Player stack contains ExoPlayer/Media3-era components plus IJK native libraries.

## Confirmed literal/API signals from DEX inspection

The following strings/classes are present in the supplied APK and are useful for compatibility mapping:

- `/player_api.php`
- `HitAPIToGetMaintenanceMode`
- `addreport`
- `addclientfeedback`
- `clientsReportRequest`
- `clientsFeedbackRequest`
- `Please Add Report`
- `Reported Successfully`
- `Please enter feedback`
- `FirebaseRegisterDeviceActivity`
- `BillingGetDevicesCallback`
- `BillingUpdateDevicesCallback`
- `getDevices`
- `device_player_id`
- `device_type`
- `device_model`
- `device_os`
- `Running on a TV Device`
- `Running on a non-TV Device`

These findings prove code paths/names exist in the APK. They do **not** by themselves prove the exact HTTP URL, request body or response schema used at runtime.

## Legacy panel corroboration

The supplied old panel contains public compatibility endpoints named:

- `api/dns.php`
- `api/intro.php`
- `api/note.php`
- `api/rate.php`
- `api/update.php`
- `api/vpn.php`
- `api/sport.php`
- `api/sports.php`

The legacy DNS endpoint has two response branches:

1. a POST branch gated by legacy parameter names (`m,k,sc,u,pw,r,av,dt,d,do`), and
2. a JSON fallback containing `ftg`, `status`, `su`, `sc`, `ndd`.

The old update endpoint redirects only when the query parameter `id` matches the configured package name.

The old VPN endpoint dynamically creates a ZIP of OVPN files. The Community implementation must never source VPN credentials from Git and must generate/download profiles only from server-side protected storage.

## Current Community compatibility policy

A feature is moved through:

`DISCOVERED → IMPLEMENTED → DEVICE_TESTED → GREEN`

A DEX string, matching PHP filename, successful lint or successful curl request is not enough for `GREEN`.

## Next dynamic tests

Capture the real request/response cycle of the supplied test APK against an instrumented Community deployment for:

1. DNS/portal discovery
2. maintenance mode
3. device registration
4. client report
5. client feedback
6. announcements/note
7. intro
8. update
9. VPN
10. sports

For every contract record HTTP method, path, content type, field names, response schema, device-visible result and negative/fail-closed behavior.
