<?php
	require_once '../vendor/autoload.php';
	
    use Zhanghao\Practice\Monitor;

    $monitor = new Monitor();
    $data['top']   = $monitor->getTop();
    $data['df'] = $monitor->getDf();
    $data['mysql'] = $monitor->getMysql();
    $data['time']  = date('H:i:s',time()); 
	echo json_encode($data);



?>