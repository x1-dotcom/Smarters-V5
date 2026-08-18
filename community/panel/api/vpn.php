<?php
declare(strict_types=1);require __DIR__.'/_c.php';$file=dirname(__DIR__).'/data/ovpn.zip';if(_a5('vpn_status','off')!=='on'||!is_file($file)){http_response_code(404);exit;}header('Content-Type: application/zip');header('Content-Length: '.filesize($file));header('Content-Disposition: attachment; filename="x1-vpn.zip"');readfile($file);
