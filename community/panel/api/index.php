<?php
declare(strict_types=1); require __DIR__.'/_c.php';
if(($_SERVER['REQUEST_METHOD']??'GET')!=='POST') _a1(['result'=>'error','message'=>'POST required'],405);
$raw=file_get_contents('php://input'); $d=json_decode($raw?:'{}',true); if(!is_array($d)) _a1(['result'=>'error','message'=>'Invalid JSON'],400);
$a=_a3($d['action']??'',64); $db=_a0();
switch($a){
case 'check-maintainencemode': _a1(['result'=>'success','sc'=>_a2(),'maintenancemode'=>_a5('maintenance_mode','off'),'message'=>_a5('maintenance_title'),'footercontent'=>_a5('maintenance_body')]);
case 'get_advertisemnt_status': _a1(['result'=>'success','sc'=>_a2(),'add_status'=>_a5('advertisement_status','off'),'add_viewable_rate'=>_a5('advertisement_viewable_rate'),'message'=>_a5('advertisement_message')]);
case 'get-ovpnzip': _a1(['result'=>'success','sc'=>_a2(),'message'=>'Data retrieved successfully','vpnstatus'=>_a5('vpn_status','off'),'link'=>_a4().'/vpn.php']);
case 'add-device':
$id=_a3($d['deviceid']??'',160); if($id==='') _a1(['result'=>'error','message'=>'Invalid device'],422); $un=_a3($d['deviceusername']??'',160);
$st=$db->prepare('INSERT INTO devices(device_id,device_username,last_seen_at) VALUES(:d,:u,datetime("now")) ON CONFLICT(device_id) DO UPDATE SET device_username=excluded.device_username,last_seen_at=datetime("now")'); $st->bindValue(':d',$id);$st->bindValue(':u',$un);$st->execute(); _a6('device.seen',['device_hash'=>hash('sha256',$id)]); _a1(['result'=>'success','sc'=>_a2(),'message'=>'Details Updated Successfully']);
case 'addreport':
$st=$db->prepare('INSERT INTO reports(username,macaddress,section,section_category,report_title,report_sub_title,report_cases,report_custom_message,stream_name,stream_id) VALUES(:u,:m,:s,:c,:t,:st,:ca,:cm,:sn,:si)'); foreach(['u'=>'username','m'=>'macaddress','s'=>'section','c'=>'section_category','t'=>'report_title','st'=>'report_sub_title','ca'=>'report_cases','cm'=>'report_custom_message','sn'=>'stream_name','si'=>'stream_id'] as $p=>$k)$st->bindValue(':'.$p,_a3($d[$k]??'',1000)); $st->execute(); _a1(['result'=>'success','sc'=>_a2(),'message'=>'Report added successfully']);
case 'addclientfeedback':
$fb=_a3($d['feedback']??'',4000); if($fb==='')_a1(['result'=>'error','message'=>'Feedback required'],422); $st=$db->prepare('INSERT INTO feedback(username,macaddress,feedback_content) VALUES(:u,:m,:f)');$st->bindValue(':u',_a3($d['username']??'',160));$st->bindValue(':m',_a3($d['macaddress']??'',160));$st->bindValue(':f',$fb);$st->execute();_a1(['result'=>'success','message'=>'Feedback sent successfully!']);
case 'get-announcements':
$dev=_a3($d['deviceid']??'',160);$rows=[];$q=$db->query('SELECT id,title,message,created_on FROM announcements ORDER BY created_on DESC,id DESC');while($r=$q->fetchArray(SQLITE3_ASSOC)){ $seen=0;if($dev!==''){ $s=$db->prepare('SELECT 1 FROM announcement_views WHERE announcement_id=:a AND device_id=:d');$s->bindValue(':a',(int)$r['id'],SQLITE3_INTEGER);$s->bindValue(':d',$dev);$seen=(bool)$s->execute()->fetchArray()?1:0;if(!$seen){$i=$db->prepare('INSERT OR IGNORE INTO announcement_views(announcement_id,device_id) VALUES(:a,:d)');$i->bindValue(':a',(int)$r['id'],SQLITE3_INTEGER);$i->bindValue(':d',$dev);$i->execute();}}$r['seen']=$seen;$rows[]=$r;} _a1(['result'=>'success','sc'=>_a2(),'message'=>$rows?'Announcements fetched':'No announcements','totalrecords'=>count($rows),'data'=>$rows]);
default: _a1(['result'=>'error','message'=>'Invalid action'],400);
}
