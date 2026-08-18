<?php
declare(strict_types=1);

const X1_SESSION_NAME = 'x1smarters_admin';
const X1_VERSION = '0.2.0-community';

function x1_root(): string { return dirname(__DIR__); }
function x1_db(): SQLite3 {
    static $db = null;
    if ($db instanceof SQLite3) return $db;
    $path = getenv('X1_SMARTERS_DB') ?: x1_root() . '/data/x1.sqlite';
    $db = new SQLite3($path, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
    $db->enableExceptions(true);
    $db->busyTimeout(5000);
    $db->exec('PRAGMA foreign_keys=ON');
    return $db;
}
function x1_boot_session(): void {
    if (session_status() === PHP_SESSION_ACTIVE) return;
    session_name(X1_SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
function x1_setting(string $key, string $default=''): string {
    $s=x1_db()->prepare('SELECT value FROM settings WHERE key=:k');
    $s->bindValue(':k',$key,SQLITE3_TEXT);
    $r=$s->execute()->fetchArray(SQLITE3_ASSOC);
    return $r ? (string)$r['value'] : $default;
}
function x1_set_setting(string $key, string $value): void {
    $s=x1_db()->prepare('INSERT INTO settings(key,value) VALUES(:k,:v) ON CONFLICT(key) DO UPDATE SET value=excluded.value');
    $s->bindValue(':k',$key,SQLITE3_TEXT); $s->bindValue(':v',$value,SQLITE3_TEXT); $s->execute();
}
function x1_count(string $table): int {
    $allowed=['users','portals','devices','reports','feedback','announcements','audit_log'];
    if (!in_array($table,$allowed,true)) return 0;
    $r=x1_db()->querySingle('SELECT COUNT(*) FROM '.$table);
    return (int)$r;
}
function x1_csrf(): string {
    x1_boot_session();
    if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(24));
    return (string)$_SESSION['csrf'];
}
function x1_verify_csrf(): void {
    x1_boot_session();
    $got=(string)($_POST['_csrf'] ?? '');
    if ($got === '' || !hash_equals((string)($_SESSION['csrf'] ?? ''),$got)) {
        http_response_code(419); exit('CSRF validation failed.');
    }
}
function x1_admin_exists(): bool { return x1_count('users') > 0; }
function x1_user(): ?array { x1_boot_session(); return isset($_SESSION['user']) && is_array($_SESSION['user']) ? $_SESSION['user'] : null; }
function x1_require_auth(): array {
    $u=x1_user();
    if (!$u) { header('Location: index.php'); exit; }
    return $u;
}
function x1_login(string $username,string $password): bool {
    $s=x1_db()->prepare('SELECT id,username,password_hash,role,active FROM users WHERE username=:u LIMIT 1');
    $s->bindValue(':u',$username,SQLITE3_TEXT);
    $r=$s->execute()->fetchArray(SQLITE3_ASSOC);
    if (!$r || (int)$r['active']!==1 || !password_verify($password,(string)$r['password_hash'])) return false;
    x1_boot_session(); session_regenerate_id(true);
    $_SESSION['user']=['id'=>(int)$r['id'],'username'=>(string)$r['username'],'role'=>(string)$r['role']];
    $q=x1_db()->prepare('UPDATE users SET last_login_at=datetime("now") WHERE id=:id'); $q->bindValue(':id',(int)$r['id'],SQLITE3_INTEGER); $q->execute();
    x1_audit('auth.login',['user_id'=>(int)$r['id']]);
    return true;
}
function x1_logout(): void { x1_boot_session(); $_SESSION=[]; if(ini_get('session.use_cookies')){ $p=session_get_cookie_params(); setcookie(session_name(),'',time()-42000,$p['path'],$p['domain']??'',(bool)$p['secure'],(bool)$p['httponly']); } session_destroy(); }
function x1_audit(string $action,array $meta=[]): void {
    $s=x1_db()->prepare('INSERT INTO audit_log(action,ip,meta_json,created_at) VALUES(:a,:i,:m,datetime("now"))');
    $s->bindValue(':a',$action,SQLITE3_TEXT); $s->bindValue(':i',(string)($_SERVER['REMOTE_ADDR']??''),SQLITE3_TEXT); $s->bindValue(':m',json_encode($meta,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),SQLITE3_TEXT); $s->execute();
}
function x1_e(string $v): string { return htmlspecialchars($v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8'); }
function x1_year(): string { return gmdate('Y'); }
function x1_flash(?string $set=null): ?string { x1_boot_session(); if($set!==null){$_SESSION['flash']=$set; return null;} $v=$_SESSION['flash']??null; unset($_SESSION['flash']); return is_string($v)?$v:null; }
