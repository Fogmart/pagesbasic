<?php
require ('../access.php');

header('Access-Control-Allow-Origin: *');
header ("Content-Type: text/html; charset=UTF-8");
$file = file_get_contents('http://75.agentovs.net/php/index.php?act=getAll');
echo $file;
