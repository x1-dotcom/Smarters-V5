<?php
declare(strict_types=1); require __DIR__.'/_c.php';
$q=_a0()->query('SELECT url FROM portals WHERE enabled=1 ORDER BY id'); $u=[];
while($r=$q->fetchArray(SQLITE3_ASSOC)){$v=rtrim((string)$r['url'],'/'); if($v!=='')$u[]=$v;}
$csv=implode(',',$u);
if(isset($_POST['m'],$_POST['k'],$_POST['sc'],$_POST['u'],$_POST['pw'],$_POST['r'],$_POST['av'],$_POST['dt'],$_POST['d'],$_POST['do'])){header('Content-Type:text/plain; charset=utf-8');echo $csv;exit;}
_a1(['ftg'=>true,'status'=>true,'su'=>$csv,'sc'=>'','ndd'=>'']);
