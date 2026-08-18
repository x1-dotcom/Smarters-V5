<?php
declare(strict_types=1);
function _a0(): SQLite3 {
static $db = null;
if ($db instanceof SQLite3) return $db;
$root = dirname(__DIR__);
$path = getenv('X1_SMARTERS_DB') ?: $root . '/data/x1.sqlite';
$db = new SQLite3($path, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
$db->enableExceptions(true);
$db->busyTimeout(5000);
$db->exec('PRAGMA foreign_keys=ON');
return $db;
}
function _a1(array $v, int $status=200): never {
http_response_code($status);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
echo json_encode($v, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
exit;
}
function _a2(): string { return bin2hex(random_bytes(16)); }
function _a3(mixed $v, int $max=512): string { return mb_substr(trim((string)$v), 0, $max); }
function _a4(): string {
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$scheme = $https ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$dir = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'] ?? '/api/index.php')), '/');
return $scheme.'://'.$host.$dir;
}
function _a5(string $key, string $default=''): string {
$st=_a0()->prepare('SELECT value FROM settings WHERE key=:k');
$st->bindValue(':k',$key,SQLITE3_TEXT);
$r=$st->execute()->fetchArray(SQLITE3_ASSOC);
return $r ? (string)$r['value'] : $default;
}
function _a6(string $action, array $meta=[]): void {
$st=_a0()->prepare('INSERT INTO audit_log(action,ip,meta_json,created_at) VALUES(:a,:i,:m,datetime("now"))');
$st->bindValue(':a',$action,SQLITE3_TEXT);
$st->bindValue(':i',$_SERVER['REMOTE_ADDR'] ?? '',SQLITE3_TEXT);
$st->bindValue(':m',json_encode($meta,JSON_UNESCAPED_SLASHES),SQLITE3_TEXT);
$st->execute();
}
