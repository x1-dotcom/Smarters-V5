# Community Implementation

This directory will hold the clean X1 Community panel and installer.

## Build order

1. Secure bootstrap/authentication.
2. SQLite migrations and audit log.
3. DNS/portal compatibility endpoint.
4. Branding/intro/maintenance/announcement contracts.
5. Device registry and feedback/reporting only where the APK is confirmed to consume them.
6. Sports/VPN/update contracts after exact APK request/response mapping.
7. Physical-device E2E tests.
8. Public distributable protected/obfuscated build.

## Green rule

A feature is not `GREEN` until a real compatible APK has consumed the X1 endpoint and produced the expected visible behavior.

## Public distribution

The public repository will not contain production credentials or the original third-party APK/panel source. X1-owned distribution artifacts may be obfuscated/minified after the clean implementation passes the compatibility matrix.
