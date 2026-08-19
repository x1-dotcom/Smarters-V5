#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")"
OUT="X1_SMARTERS_PANEL_v1.3_PUBLIC_CLEAN_OBFUSCATED.tar.bz2"
cat "$OUT.part00" "$OUT.part01" "$OUT.part02" > "$OUT"
echo "64ed75e560dc752080d65a19fb69c9c40178a915c6cf3995a69df3609997178b  $OUT" | sha256sum -c -
echo "Created: $OUT"
