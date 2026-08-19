# Public Community Distribution

The public Community release is built from the clean X1 implementation; the supplied legacy panel and Titan APK are analysis inputs only and are never included in releases.

## Build

```sh
./tools/build-community-dist.sh
```

Produces:

- `build/X1-Smarters-V5-Community.zip`
- `build/X1-Smarters-V5-Community.zip.sha256`

PHP is stripped/minified with `php -w`, development tests/data are excluded, and a simple secret scan runs before the ZIP is created.

## Important protection note

Minification is **not cryptographic source protection**. Because this repository is public and development source has already been committed to its Git history, deleting or minifying files later does not make earlier revisions secret.

For stronger IP protection, the correct release architecture is:

1. private source repository;
2. CI builds a protected/minified Community artifact;
3. public repository contains documentation + release artifact only;
4. no proprietary third-party APK/source is published;
5. no secrets are embedded in either repository or ZIP.

Until the source/public repository split is made, describe the current release as **minified/protected distribution**, not as impossible-to-recover source obfuscation.
