<?php
declare(strict_types=1);
require __DIR__.'/_c.php';
if(($_SERVER['REQUEST_METHOD']??'GET')!=='POST') _a1(['result'=>'error','message'=>'POST required'],405);
$ct=strtolower((string)($_SERVER['CONTENT_TYPE']??''));
$d=[];
if(str_contains($ct,'application/json')){ $j=json_decode(file_get_contents('php://input')?:'{}',true); if(is_array($j))$d=$j; }
else $d=$_POST;
$db=_a0();
$st=$db->prepare('INSERT INTO reports(username,macaddress,section,section_category,report_title,report_sub_title,report_cases,report_custom_message,stream_name,stream_id) VALUES(:u,:m,:s,:c,:t,:st,:ca,:cm,:sn,:si)');
foreach(['u'=>'username','m'=>'macaddress','s'=>'section','c'=>'section_category','t'=>'report_title','st'=>'report_sub_title','ca'=>'report_cases','cm'=>'report_custom_message','sn'=>'stream_name','si'=>'stream_id'] as $p=>$k)$st->bindValue(':'.$p,_a3($d[$k]??'',1000),SQLITE3_TEXT);
$st->execute();
_a6('report.created',['stream_hash'=>hash('sha256',_a3($d['stream_id']??'',160))]);
_a1(['result'=>'success','sc'=>_a2(),'message'=>'Report added successfully']);
