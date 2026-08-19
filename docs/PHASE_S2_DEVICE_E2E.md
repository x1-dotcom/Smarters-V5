# Phase S2 — Titan/Smarters Real Device E2E

Status starts at `PENDING`. Nothing in this document is GREEN until observed on a real test client.

## Goal

Prove the clean Community panel against the supplied Titan/Smarters test APK without touching production X1 services.

## Isolated test topology

`Titan test device/emulator → isolated HTTPS Community panel → configured test portal`

Use a disposable/test IPTV line. Do not reuse production admin credentials, bot tokens, SaaS keys or VPN secrets.

## Gate 1 — startup contract

Capture server access log while cold-starting the APK.

Record exact:

- host/base URL;
- path (`dns.php`, `api.php`, alternate path);
- method;
- content type;
- request field names;
- response status;
- client behavior.

Do not log raw IPTV passwords. Redact query/body credentials before storing evidence.

## Gate 2 — DNS / portal

1. Add exactly one test portal in Studio.
2. Start APK from clean app data.
3. Confirm real request reaches the Community panel.
4. Confirm the APK resolves the configured portal.
5. Negative: disable/remove portal and confirm clean failure, no crash.

## Gate 3 — Maintenance

1. Set maintenance OFF and prove normal startup.
2. Set maintenance ON with unique title/body.
3. Restart/refresh APK.
4. Capture visible maintenance UI.
5. Set OFF and confirm recovery.

Expected action contract: `check-maintainencemode`.

## Gate 4 — Device registration

Observe a real `add-device` call from the APK.

Verify in DB/UI:

- `device_id` created/upserted;
- `device_username` matches actual request;
- `last_seen_at` changes on second request;
- audit contains hash only, not raw ID where configured.

Negative: empty `deviceid` → 422 and no row.

## Gate 5 — Announcements

Create a unique announcement. Prove the APK requests `get-announcements`, renders it if this build supports the surface, and a second fetch marks/returns `seen` consistently.

## Gate 6 — Ads

Test status and list independently:

- `get_advertisemnt_status`;
- `getads.php` / `adpage.php` if requested by the client.

Use a local HTTPS test image URL. No hard-coded TMDB/API key.

## Gate 7 — Intro / Rate

Set controlled HTTPS destinations and observe whether the APK actually opens/fetches each endpoint. Reject unsupported schemes.

## Gate 8 — Update

Use package `com.titan.smart` only.

First prove wrong package fails closed. Then test a controlled update URL only if Android signing/version requirements are satisfied. Do not call update GREEN because a redirect works; install behavior must be observed.

## Gate 9 — VPN

Observe exact APK expectation for `get-ovpnzip` and `vpn.php` before changing the bundle contract. Use disposable VPN credentials. Never commit `.ovpn` credentials to Git.

## Gate 10 — Player API resolver

Only execute if traffic proves the APK needs the legacy `player_api.php` resolver.

Requirements:

- configured portal allowlist only;
- TLS verification ON;
- no credential logging;
- no arbitrary upstream URL;
- timeout/fail closed;
- invalid line → 401/no redirect;
- valid disposable line → redirect to the matched configured portal.

## Evidence matrix

For each feature record:

`Feature | Request captured | Response captured | Visible APK effect | Negative test | Evidence | Status`

Allowed statuses: `GREEN | PARTIAL | BROKEN | BLOCKED_EXTERNAL`.

## Stop condition

Phase S2 ends only when the exact startup/base-URL mechanism is known and DNS + Maintenance + Device Registration have been proven end-to-end. Remaining features may continue in S3; do not inflate them to GREEN from static analysis alone.
