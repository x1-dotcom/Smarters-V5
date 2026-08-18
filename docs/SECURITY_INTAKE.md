# Security Intake — Legacy Smarters Panel

The supplied legacy panel is used only as a compatibility reference. It is **not** suitable for direct public deployment.

## Confirmed issues

### Default credentials

The login flow creates a first user automatically as:

- username: `admin`
- password: `admin`

This is unacceptable for a public distribution.

### Plaintext passwords

The `users` table stores passwords directly as text and compares them directly to form input.

X1 replacement requirement:

- `password_hash()` at creation/change time
- `password_verify()` at login
- forced first-admin setup
- no shipped universal password

### SQL injection risk

The login query concatenates `$_POST["username"]` directly into SQL.

X1 replacement requirement:

- prepared statements everywhere for user input
- explicit type/length validation

### Password input rendered as text

The legacy login page uses `type="text"` for the password field.

X1 replacement requirement: `type="password"` and secure browser/session policy.

### Weak/implicit endpoint authorization

Several legacy API endpoints are simple public PHP files and rely on obscurity or client knowledge rather than an explicit authenticated API contract.

X1 replacement requirement:

- public read endpoints only where protocol compatibility truly requires public access
- signed/device-scoped requests for sensitive configuration
- admin endpoints always authenticated + authorized

### TLS verification disabled

`api/player_api.php` disables both certificate and hostname verification while proxying to configured servers.

X1 replacement requirement:

- TLS verification enabled
- explicit compatibility escape hatch only if absolutely required and never as the default

### Credential exposure in URLs

The old `player_api.php` proxy constructs an upstream URL containing username/password query parameters.

This may be unavoidable when speaking Xtream-compatible upstream APIs, but X1 must never log these full URLs and should not proxy them unless the client contract truly requires it.

### Unsafe dynamic ZIP generation

`api/vpn.php` builds `ovpn.zip` dynamically from the whole VPN directory and serves it without an evident per-device/customer authorization check.

X1 replacement requirement:

- explicit approved profile manifest
- tenant/device authorization
- controlled filenames
- no traversal
- no accidental inclusion of secrets unrelated to the requesting client

### Update redirect trust

The old update endpoint redirects clients to a configured URL based primarily on package ID.

X1 replacement requirement:

- validated package identity
- version metadata
- SHA-256
- signed release metadata where the client contract can support it
- allowlisted artifact location

### Error handling / production hygiene

The legacy source includes disabled error reporting, stale files, duplicate DNS handlers, error logs inside web content directories and unprofessional error responses.

X1 replacement requirement:

- structured errors
- sanitized logs outside public assets
- no stack traces/secrets to clients
- remove dead/duplicate endpoints only after consumer audit

## Secrets policy for this public repository

Never commit:

- IPTV usernames/passwords
- VPN usernames/passwords
- bot tokens
- TMDB/API provider keys
- private signing keys
- X1 SaaS credentials
- server SSH keys
- production database files
- `.env` secrets

The Community release will contain templates/examples only.

## Obfuscation

Public distributable artifacts may be obfuscated/minified to protect X1-owned implementation details. Obfuscation is **not** a substitute for authentication, authorization, cryptography or secret management.
