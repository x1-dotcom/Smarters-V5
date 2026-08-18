#!/usr/bin/env sh
set -eu
BASE="${1:-http://127.0.0.1}"
fail(){ echo "FAIL: $*" >&2; exit 1; }
json_post(){ curl -fsS -H 'Content-Type: application/json' -d "$2" "$BASE/$1"; }

echo '[1/9] maintenance contract'
r=$(json_post api/index.php '{"action":"check-maintainencemode"}')
echo "$r" | grep -q '"result":"success"' || fail maintenance

echo '[2/9] ads contract'
r=$(json_post api/index.php '{"action":"get_advertisemnt_status"}')
echo "$r" | grep -q '"result":"success"' || fail ads

echo '[3/9] DNS fallback'
r=$(curl -fsS "$BASE/api/dns.php")
echo "$r" | grep -q '"status":true' || fail dns

echo '[4/9] report JSON'
r=$(json_post api/addreport.php '{"username":"smoke","macaddress":"00:00:00:00:00:00","section":"live","report_title":"smoke","stream_id":"1"}')
echo "$r" | grep -q '"result":"success"' || fail report

echo '[5/9] feedback form'
r=$(curl -fsS -X POST -d 'username=smoke&macaddress=00:00:00:00:00:00&feedback=contract-smoke' "$BASE/api/addclientfeedback.php")
echo "$r" | grep -q '"result":"success"' || fail feedback

echo '[6/9] intro'
c=$(curl -sS -o /dev/null -w '%{http_code}' "$BASE/api/intro.php")
[ "$c" = 302 ] || [ "$c" = 301 ] || fail "intro HTTP $c"

echo '[7/9] rate'
c=$(curl -sS -o /dev/null -w '%{http_code}' "$BASE/api/rate.php")
[ "$c" = 302 ] || [ "$c" = 301 ] || fail "rate HTTP $c"

echo '[8/9] update fail-closed for wrong package'
c=$(curl -sS -o /dev/null -w '%{http_code}' "$BASE/api/update.php?id=invalid.package")
[ "$c" = 404 ] || [ "$c" = 400 ] || [ "$c" = 204 ] || fail "update HTTP $c"

echo '[9/9] invalid action rejected'
c=$(curl -sS -o /dev/null -w '%{http_code}' -H 'Content-Type: application/json' -d '{"action":"not-real"}' "$BASE/api/index.php")
[ "$c" = 400 ] || fail "invalid action HTTP $c"

echo 'Contract smoke: PASS'
