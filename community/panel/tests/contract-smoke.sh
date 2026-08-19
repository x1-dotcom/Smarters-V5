#!/usr/bin/env sh
set -eu
BASE="${1:-http://127.0.0.1}"
fail(){ echo "FAIL: $*" >&2; exit 1; }
json_post(){ curl -fsS -H 'Content-Type: application/json' -d "$2" "$BASE/$1"; }

echo '[1/12] maintenance via legacy dispatcher'
r=$(json_post api/api.php '{"action":"check-maintainencemode"}')
echo "$r" | grep -q '"result":"success"' || fail maintenance

echo '[2/12] ads via legacy dispatcher'
r=$(json_post api/api.php '{"action":"get_advertisemnt_status"}')
echo "$r" | grep -q '"result":"success"' || fail ads

echo '[3/12] device registration via legacy dispatcher'
r=$(json_post api/api.php '{"action":"add-device","deviceid":"SMOKE-DEVICE-01","deviceusername":"smoke"}')
echo "$r" | grep -q '"Details Updated Successfully"' || fail device

echo '[4/12] announcements via legacy dispatcher'
r=$(json_post api/api.php '{"action":"get-announcements","deviceid":"SMOKE-DEVICE-01"}')
echo "$r" | grep -q '"result":"success"' || fail announcements

echo '[5/12] VPN metadata via legacy dispatcher'
r=$(json_post api/api.php '{"action":"get-ovpnzip"}')
echo "$r" | grep -q '"result":"success"' || fail vpn_metadata

echo '[6/12] DNS fallback'
r=$(curl -fsS "$BASE/api/dns.php")
echo "$r" | grep -q '"status":true' || fail dns

echo '[7/12] report JSON'
r=$(json_post api/addreport.php '{"username":"smoke","macaddress":"00:00:00:00:00:00","section":"live","report_title":"smoke","stream_id":"1"}')
echo "$r" | grep -q '"result":"success"' || fail report

echo '[8/12] feedback form'
r=$(curl -fsS -X POST -d 'username=smoke&macaddress=00:00:00:00:00:00&feedback=contract-smoke' "$BASE/api/addclientfeedback.php")
echo "$r" | grep -q '"result":"success"' || fail feedback

echo '[9/12] intro'
c=$(curl -sS -o /dev/null -w '%{http_code}' "$BASE/api/intro.php")
[ "$c" = 302 ] || [ "$c" = 301 ] || fail "intro HTTP $c"

echo '[10/12] rate'
c=$(curl -sS -o /dev/null -w '%{http_code}' "$BASE/api/rate.php")
[ "$c" = 302 ] || [ "$c" = 301 ] || fail "rate HTTP $c"

echo '[11/12] update fail-closed for wrong package'
c=$(curl -sS -o /dev/null -w '%{http_code}' "$BASE/api/update.php?id=invalid.package")
[ "$c" = 404 ] || [ "$c" = 400 ] || [ "$c" = 204 ] || fail "update HTTP $c"

echo '[12/12] invalid action rejected'
c=$(curl -sS -o /dev/null -w '%{http_code}' -H 'Content-Type: application/json' -d '{"action":"not-real"}' "$BASE/api/api.php")
[ "$c" = 400 ] || fail "invalid action HTTP $c"

echo 'Contract smoke: PASS'
