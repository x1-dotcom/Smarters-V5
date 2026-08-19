@echo off
setlocal
cd /d %~dp0
set OUT=X1_SMARTERS_PANEL_v1.3_PUBLIC_CLEAN_OBFUSCATED.tar.bz2
copy /b "%OUT%.part00"+"%OUT%.part01"+"%OUT%.part02" "%OUT%" >nul
certutil -hashfile "%OUT%" SHA256
echo Expected SHA-256:
echo 64ed75e560dc752080d65a19fb69c9c40178a915c6cf3995a69df3609997178b
echo Created: %OUT%
endlocal
