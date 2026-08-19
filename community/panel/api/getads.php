<?php
declare(strict_types=1); require __DIR__.'/_c.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
$r=[];$q=_a0()->query('SELECT title,url FROM ads WHERE enabled=1 ORDER BY sort_order,id');
while($x=$q->fetchArray(SQLITE3_ASSOC)){$r[]=['AdName'=>(string)$x['title'],'AdUrl'=>(string)$x['url']];}
echo json_encode($r,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
