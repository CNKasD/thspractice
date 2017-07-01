<?php
	require_once '../vendor/autoload.php';
	
	$dirName = $argv[1];

    $res    = new Zhanghao\Practice\LoopDir($dirName);
    $result = $res->startDel();
    echo "当前文件夹所占空间为" . $result . "MB";


?>
