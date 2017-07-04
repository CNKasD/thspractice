<?php
require_once '../vendor/autoload.php';

header("Content-Type: text/html; charset=utf-8");

$storeType = $_GET['storeType']; 
$searchKey = $_GET['input'];
$curd = Zhanghao\Practice\Factory::createCurd($storeType);
$data = $curd->search($searchKey);
$res = array(
	'error' => 0,
	'data'  => $data
	);
echo json_encode($res);
return ;