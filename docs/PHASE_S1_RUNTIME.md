# Phase S1 — Community compatibility runtime

## Implemented

Public Community runtime now contains a clean-room compatibility layer for the observed Smarters/Titan legacy contract. It does not contain the supplied legacy panel source or APK source.

Current endpoints:

- `api/dns.php` — enabled portal list, including the observed legacy POST/plain-text branch and JSON fallback.
- `api/index.php` actions: `check-maintainencemode`, `get_advertisemnt_status`, `get-ovpnzip`, `add-device`, `addreport`, `addclientfeedback`, `get-announcements`.
- `api/intro.php` — configured intro redirect, otherwise 204.
- `api/note.php` — announcements response.
- `api/rate.php` — rating URL redirect.
- `api/update.php` — package-scoped update redirect; default package `com.titan.smart`.
- `api/vpn.php` — serves a configured local `data/ovpn.zip` only while VPN is enabled.
- `api/sport.php` / `api/sports.php` — configured sports endpoint redirect.

## Security changes versus the supplied legacy panel

- No default `admin/admin` account.
- No plaintext admin password database.
- No hard-coded third-party API keys.
- No bundled OVPN credentials.
- No TLS verification bypass proxy.
- SQLite files and logs are denied from direct web access.
- SQL writes use prepared statements.
- Device audit records store a SHA-256 device hash in audit metadata rather than duplicating the raw identifier.
- Invalid actions fail closed.

## Public distribution policy

Only the minimized Community distribution is published. Development source, supplied APK, supplied legacy panel, databases, keys, customer data, VPN profiles and commercial X1 integration code are not part of this public repository.

## Validation performed

All published PHP files were syntax-checked with PHP 8.4 (`php -l`) before publication.

Runtime SQLite E2E has not yet been declared GREEN in this environment because the available local PHP CLI does not have the `SQLite3` extension loaded. This is explicitly not counted as a functional test.

## Next gate

1. Install the Community runtime on a PHP host with `ext-sqlite3`.
2. Initialize `install/schema.sql`/`install/init.php`.
3. Point the physical Titan/Smarters test APK at the compatibility base URL.
4. Capture actual requests and compare them with the documented contract.
5. Mark each feature `GREEN`, `PARTIAL`, `BROKEN`, or `MISSING` individually.
6. Only after runtime compatibility is proven, add the new X1 admin UI on top of the same authority/database.
