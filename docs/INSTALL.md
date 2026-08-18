# X1 Smarters V5 Community — Installation

## Requirements

- PHP 8.1 or newer recommended
- PHP SQLite3 extension
- HTTPS for production use
- Web server with rewrite support (Apache `.htaccess` or equivalent nginx rules)
- write access for the PHP/web user to `community/panel/data/`

## Deploy

Copy the contents of `community/panel/` to the desired web root.

Example:

```text
/var/www/x1-smarters/
├── api/
├── assets/
├── data/
├── includes/
├── install/
├── index.php
├── setup.php
├── studio.php
└── logout.php
```

Do not expose backups, `.env` files, database files or secrets from the web root.

## First run

Open:

```text
https://YOUR-DOMAIN/setup.php
```

The first-run page creates the SQLite schema if needed and requires you to create the first administrator.

There is no default `admin/admin` account.

Password requirements in the current Community baseline:

- minimum 12 characters
- stored using PHP `password_hash()`
- checked using `password_verify()`

Once an administrator exists, `setup.php` redirects to the normal login instead of creating more users.

## Runtime data

Default database path:

```text
community/panel/data/x1.sqlite
```

You can override it with:

```text
X1_SMARTERS_DB=/secure/path/x1.sqlite
```

The database and all real runtime data must remain outside Git history.

## First configuration

After login:

1. Open **Portals / DNS** and configure the test portal(s).
2. Open **Runtime Config**.
3. Configure only the compatibility features you actually intend to test.
4. Keep Maintenance, Ads and VPN disabled unless actively validating those flows.
5. Do not publish real API/VPN credentials into Git or screenshots.

## Compatibility testing

The Community panel deliberately does not claim client compatibility from PHP syntax alone.

Required progression:

```text
DISCOVERED
→ IMPLEMENTED
→ ENDPOINT_TESTED
→ DEVICE_REQUEST_OBSERVED
→ VISIBLE_BEHAVIOUR_CONFIRMED
→ NEGATIVE_TEST_PASS
→ GREEN
```

Use `docs/COMPATIBILITY_MATRIX.md` as the status authority.

## Production hardening

Before any public deployment:

- enforce HTTPS
- restrict filesystem permissions
- disable PHP directory listing
- confirm `data/` is not web-readable
- use server-level rate limits where appropriate
- keep PHP and SQLite patched
- back up the SQLite database securely
- protect any future upload directory from script execution
- use separate test and production installations

## Public Community distribution

Only X1-owned source/artifacts belong in this repository.

Do not commit:

- the supplied Titan/Smarters APK
- the supplied legacy panel archive
- IPTV account credentials
- VPN credentials / private `.ovpn` profiles
- API keys
- signing keys / keystores
- production SQLite databases
