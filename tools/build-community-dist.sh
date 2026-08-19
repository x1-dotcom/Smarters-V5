#!/usr/bin/env sh
set -eu
ROOT="$(CDPATH= cd -- "$(dirname -- "$0")/.." && pwd)"
SRC="$ROOT/community/panel"
OUT="$ROOT/build/community-panel"
ZIP="$ROOT/build/X1-Smarters-V5-Community.zip"
rm -rf "$OUT" "$ZIP"
mkdir -p "$OUT" "$ROOT/build"

# Public distribution: runtime only. Never ship local data, tests, installer state or secrets.
find "$SRC" -type f \
  ! -path '*/data/*' \
  ! -path '*/tests/*' \
  ! -name '*.sqlite' ! -name '*.db' ! -name '*.log' \
  | while IFS= read -r f; do
      rel=${f#"$SRC"/}; mkdir -p "$OUT/$(dirname "$rel")"
      case "$f" in
        *.php) php -w "$f" > "$OUT/$rel" ;;
        *) cp "$f" "$OUT/$rel" ;;
      esac
    done

# Installer schema is needed for first install; copy it explicitly after runtime filtering.
mkdir -p "$OUT/install"
cp "$SRC/install/schema.sql" "$OUT/install/schema.sql"
cp "$SRC/install/init.php" "$OUT/install/init.php"

# Guard against accidental secret/data publication.
if grep -RIE '(BEGIN (RSA|EC|OPENSSH) PRIVATE KEY|sk-[A-Za-z0-9]|password\s*=\s*["'"'][^"'"']+|api[_-]?key\s*=\s*["'"'][^"'"']+)' "$OUT" --exclude='*.md' >/dev/null 2>&1; then
  echo 'Refusing distribution: possible secret found.' >&2; exit 2
fi

( cd "$OUT" && zip -qr "$ZIP" . )
sha256sum "$ZIP" > "$ZIP.sha256"
echo "$ZIP"
cat "$ZIP.sha256"
