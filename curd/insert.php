<?php
require_once '../vendor/autoload.php';
header("Content-Type: text/html; charset=utf-8");

$storeType = $_POST['storeType'];
$stuid = $_POST['stuid'];
$name = $_POST['name'];
$subject = $_POST['subject'];
$score = $_POST['score'];

$curd = Zhanghao\Practice\Factory::createCurd($storeType);
$curd->insert($stuid, $name, $subject, $score);

$res = array(
    'error' => 0,
    'msg'   => '添加成功'
);

echo json_encode($res);
return ;