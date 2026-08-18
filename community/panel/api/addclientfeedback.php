<?php
declare(strict_types=1);
require __DIR__.'/_c.php';
if(($_SERVER['REQUEST_METHOD']??'GET')!=='POST') _a1(['result'=>'error','message'=>'POST required'],405);
$ct=strtolower((string)($_SERVER['CONTENT_TYPE']??''));
$d=[];
if(str_contains($ct,'application/json')){ $j=json_decode(file_get_contents('php://input')?:'{}',true); if(is_array($j))$d=$j; }
else $d=$_POST;
$fb=_a3($d['feedback']??$d['feedback_content']??'',4000);
if($fb==='') _a1(['result'=>'error','message'=>'Feedback required'],422);
$st=_a0()->prepare('INSERT INTO feedback(username,macaddress,feedback_content) VALUES(:u,:m,:f)');
$st->bindValue(':u',_a3($d['username']??'',160),SQLITE3_TEXT);
$st->bindValue(':m',_a3($d['macaddress']??'',160),SQLITE3_TEXT);
$st->bindValue(':f',$fb,SQLITE3_TEXT);
$st->execute();
_a6('feedback.created');
_a1(['result'=>'success','sc'=>_a2(),'message'=>'Feedback sent successfully!']);
