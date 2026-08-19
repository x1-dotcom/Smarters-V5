#!/usr/bin/env sh
set -eu
BASE="${1:-http://127.0.0.1}"
fail(){ echo "FAIL: $*" >&2; exit 1; }
json_post(){ curl -fsS -H 'Content-Type: application/json' -d "$2" "$BASE/$1"; }

echo '[1/14] maintenance via legacy dispatcher'
r=$(json_post api/api.php '{"action":"check-maintainencemode"}')
echo "$r" | grep -q '"result":"success"' || fail maintenance

echo '[2/14] ads status via legacy dispatcher'
r=$(json_post api/api.php '{"action":"get_advertisemnt_status"}')
echo "$r" | grep -q '"result":"success"' || fail ads

echo '[3/14] device registration via legacy dispatcher'
r=$(json_post api/api.php '{"action":"add-device","deviceid":"SMOKE-DEVICE-01","deviceusername":"smoke"}')
echo "$r" | grep -q '"Details Updated Successfully"' || fail device

echo '[4/14] announcements via legacy dispatcher'
r=$(json_post api/api.php '{"action":"get-announcements","deviceid":"SMOKE-DEVICE-01"}')
echo "$r" | grep -q '"result":"success"' || fail announcements

echo '[5/14] VPN metadata via legacy dispatcher'
r=$(json_post api/api.php '{"action":"get-ovpnzip"}')
echo "$r" | grep -q '"result":"success"' || fail vpn_metadata

echo '[6/14] DNS fallback'
r=$(curl -fsS "$BASE/api/dns.php")
echo "$r" | grep -q '"status":true' || fail dns

echo '[7/14] advertisement list contract'
r=$(curl -fsS "$BASE/api/getads.php")
echo "$r" | grep -Eq '^\[' || fail ad_list

echo '[8/14] report JSON'
r=$(json_post api/addreport.php '{"username":"smoke","macaddress":"00:00:00:00:00:00","section":"live","report_title":"smoke","stream_id":"1"}')
echo "$r" | grep -q '"result":"success"' || fail report

echo '[9/14] feedback form'
r=$(curl -fsS -X POST -d 'username=smoke&macaddress=00:00:00:00:00:00&feedback=contract-smoke' "$BASE/api/addclientfeedback.php")
echo "$r" | grep -q '"result":"success"' || fail feedback

echo '[10/14] intro'
c=$(curl -sS -o /dev/null -w '%{http_code}' "$BASE/api/intro.php")
[ "$c" = 302 ] || [ "$c" = 301 ] || fail "intro HTTP $c"

echo '[11/14] rate'
c=$(curl -sS -o /dev/null -w '%{http_code}' "$BASE/api/rate.php")
[ "$c" = 302 ] || [ "$c" = 301 ] || fail "rate HTTP $c"

echo '[12/14] update fail-closed for wrong package'
c=$(curl -sS -o /dev/null -w '%{http_code}' "$BASE/api/update.php?id=invalid.package")
[ "$c" = 404 ] || [ "$c" = 400 ] || [ "$c" = 204 ] || fail "update HTTP $c"

echo '[13/14] player API refuses missing credentials'
c=$(curl -sS -o /dev/null -w '%{http_code}' "$BASE/api/player_api.php")
[ "$c" = 400 ] || fail "player_api HTTP $c"

echo '[14/14] invalid action rejected'
c=$(curl -sS -o /dev/null -w '%{http_code}' -H 'Content-Type: application/json' -d '{"action":"not-real"}' "$BASE/api/api.php")
[ "$c" = 400 ] || fail "invalid action HTTP $c"

echo 'Contract smoke: PASS'
