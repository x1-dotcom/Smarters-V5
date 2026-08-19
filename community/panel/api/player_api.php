<?php
declare(strict_types=1); require __DIR__.'/_c.php';
$u=_a3($_POST['username']??$_GET['username']??'',256);$p=_a3($_POST['password']??$_GET['password']??'',256);
if($u===''||$p===''){http_response_code(400);exit;}
$q=_a0()->query('SELECT url FROM portals WHERE enabled=1 ORDER BY id');
while($r=$q->fetchArray(SQLITE3_ASSOC)){
  $b=rtrim((string)$r['url'],'/');
  if(!preg_match('~^https?://~i',$b))continue;
  $x=$b.'/player_api.php?'.http_build_query(['username'=>$u,'password'=>$p],'','&',PHP_QUERY_RFC3986);
  $c=curl_init($x);curl_setopt_array($c,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_FOLLOWLOCATION=>false,CURLOPT_CONNECTTIMEOUT=>3,CURLOPT_TIMEOUT=>5,CURLOPT_SSL_VERIFYPEER=>true,CURLOPT_SSL_VERIFYHOST=>2,CURLOPT_HTTPHEADER=>['Accept: application/json']]);
  $raw=curl_exec($c);$code=(int)curl_getinfo($c,CURLINFO_RESPONSE_CODE);curl_close($c);
  if($raw===false||$code<200||$code>=300)continue;
  $j=json_decode((string)$raw,true);$i=is_array($j)?($j['user_info']??null):null;
  if(is_array($i)&&(int)($i['auth']??0)!==0&&strcasecmp((string)($i['status']??''),'Active')===0){header('Cache-Control: no-store');header('Location: '.$x, true, 302);exit;}
}
http_response_code(401);header('Content-Type: application/json; charset=utf-8');header('Cache-Control: no-store');echo '{"user_info":{"auth":0}}';
