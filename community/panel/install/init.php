<?php
declare(strict_types=1);
$root=dirname(__DIR__); @mkdir($root.'/data',0750,true);
$db=new SQLite3($root.'/data/x1.sqlite',SQLITE3_OPEN_READWRITE|SQLITE3_OPEN_CREATE);
$db->enableExceptions(true); $db->busyTimeout(5000);
$sql=file_get_contents(__DIR__.'/schema.sql'); $db->exec($sql);
@chmod($root.'/data/x1.sqlite',0640);
echo "X1 Smarters Community database initialized.\n";
