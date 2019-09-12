<?php
if (!isset($_GET["id"])){
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri");
}
