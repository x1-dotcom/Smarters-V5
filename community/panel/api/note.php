<?php
declare(strict_types=1);require __DIR__.'/_c.php';$rows=[];$q=_a0()->query('SELECT title,message,created_on FROM announcements ORDER BY created_on DESC,id DESC');while($r=$q->fetchArray(SQLITE3_ASSOC))$rows[]=$r;_a1(['status'=>true,'response'=>$rows]);
