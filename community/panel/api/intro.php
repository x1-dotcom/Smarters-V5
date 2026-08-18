<?php
declare(strict_types=1);require __DIR__.'/_c.php';$u=_a5('intro_url');if($u===''){http_response_code(204);exit;}header('Location: '.$u,302);exit;
