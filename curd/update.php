<?php
require_once '../vendor/autoload.php';
header("Content-Type: text/html; charset=utf-8");
$storeType = $_POST['storeType'];
$stuid   = $_POST['stuid'];
$name    = $_POST['name'];
$subject = $_POST['subject'];
$score   = $_POST['score'];
$id      = $_POST['id'];

$curd = Zhanghao\Practice\Factory::createCurd($storeType);
$curd->update($id, $stuid, $name, $subject, $score);
$res = array(
    'error' => 0,
    'msg'   => '修改成功'
);

echo json_encode($res);
return ;