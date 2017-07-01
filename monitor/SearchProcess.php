<?php
	require_once '../vendor/autoload.php';
	
    use Zhanghao\Practice\Monitor;

	$name = $_POST['name'];
    $monitor = new Monitor();
	$data = array(
		'data'  => $monitor->searchProcess($name),
		'error' => 0
	);

	echo json_encode($data);
	return ;

?>
