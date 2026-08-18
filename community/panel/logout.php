<?php
declare(strict_types=1);
require __DIR__.'/includes/bootstrap.php';
$u=x1_user();
if($u) x1_audit('auth.logout',['user_id'=>$u['id']??null]);
x1_logout();
header('Location: index.php');
exit;
