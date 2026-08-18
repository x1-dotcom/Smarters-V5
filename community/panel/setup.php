<?php
declare(strict_types=1);
require __DIR__.'/includes/bootstrap.php';
if (!file_exists(__DIR__.'/data/x1.sqlite')) {
    @mkdir(__DIR__.'/data',0750,true);
    $db=x1_db();
    $sql=file_get_contents(__DIR__.'/install/schema.sql');
    $db->exec($sql);
    @chmod(__DIR__.'/data/x1.sqlite',0640);
}
if (x1_admin_exists()) { header('Location: index.php'); exit; }
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    x1_verify_csrf();
    $u=trim((string)($_POST['username']??''));
    $p=(string)($_POST['password']??'');
    $p2=(string)($_POST['password2']??'');
    if (!preg_match('/^[A-Za-z0-9_.-]{3,40}$/',$u)) $error='Choose a valid username (3–40 characters).';
    elseif (strlen($p)<12) $error='Use a password with at least 12 characters.';
    elseif ($p!==$p2) $error='Passwords do not match.';
    else {
        $s=x1_db()->prepare('INSERT INTO users(username,password_hash,role,active) VALUES(:u,:p,"admin",1)');
        $s->bindValue(':u',$u,SQLITE3_TEXT); $s->bindValue(':p',password_hash($p,PASSWORD_DEFAULT),SQLITE3_TEXT); $s->execute();
        x1_audit('setup.admin_created',['username'=>$u]);
        x1_flash('Administrator created. Sign in to continue.');
        header('Location: index.php'); exit;
    }
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Setup · X1 Smarters Community</title><link rel="stylesheet" href="assets/app.css"></head><body class="login"><main class="login-shell"><section class="login-art"><div class="brand"><div class="brandmark"><svg viewBox="0 0 32 32" fill="none"><path d="M5 6l8 10-8 10h6l5-6 5 6h6l-8-10 8-10h-6l-5 6-5-6H5z" fill="currentColor"/></svg></div><span>X1 SMARTERS</span></div><div><div class="eyebrow">Community Control Plane</div><h1 class="hero-title">First-run<br>setup.</h1><p class="hero-copy">Create the first administrator locally. No default username. No default password. No credentials are committed to Git.</p><div class="chips"><span class="chip">SQLite</span><span class="chip">CSRF</span><span class="chip">Password hashing</span><span class="chip">Audit trail</span></div></div><div class="tiny">Copyright © <?=x1_year()?> X1Tech Solutions SA. All Rights Reserved.</div></section><section class="login-form"><div class="eyebrow">Secure bootstrap</div><h2>Create administrator</h2><p class="muted">This page disables itself after the first account is created.</p><?php if($error):?><div class="alert"><?=x1_e($error)?></div><?php endif;?><form method="post"><input type="hidden" name="_csrf" value="<?=x1_e(x1_csrf())?>"><div class="field"><label>Username</label><input class="input" name="username" autocomplete="username" required></div><div class="field"><label>Password</label><input class="input" type="password" name="password" autocomplete="new-password" required></div><div class="field"><label>Confirm password</label><input class="input" type="password" name="password2" autocomplete="new-password" required></div><button class="btn btn-primary" type="submit">Create secure admin</button></form></section></main></body></html>