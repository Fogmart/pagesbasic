<?php
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

if (!isset($_GET["notAtRivialVaRibLe"])){
    header("Location: http://$host$uri");
} else {
    if ($_GET["notAtRivialVaRibLe"] != "123ggrdpuNNheHH7ylzNhUkd90JbsJik"){
        header("Location: http://$host$uri");
    }
}


