<?php
declare(strict_types=1);require __DIR__.'/_c.php';$id=_a3($_GET['id']??'',200);$pkg=_a5('update_package','com.titan.smart');$url=_a5('update_url');if($id!==''&&hash_equals($pkg,$id)&&$url!==''){header('Location: '.$url,302);exit;}http_response_code(404);header('Content-Type:text/plain; charset=utf-8');echo 'No update available';
