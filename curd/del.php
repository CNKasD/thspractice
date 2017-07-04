<?php
require_once '../vendor/autoload.php';
header("Content-Type: text/html; charset=utf-8");

$storeType = $_POST['storeType'];
$id = $_POST['id'];
$curd = Zhanghao\Practice\Factory::createCurd($storeType);
$curd->del($id);
$res = array(
    'error' => 0,
    'msg'   => '删除成功'
);

echo json_encode($res);
return ;