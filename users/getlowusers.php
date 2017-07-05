<?php
require_once '../vendor/autoload.php';
use Zhanghao\Practice\users\Users;

session_start();
$level = $_SESSION['level'];


$user = new Users();
//获取比自己级别低的用户信息
$lowInfo = $user->getLowUserInfo($level);  //此处level应该从session中获取
$res = array(
    'error' => 0,
    'data' => $lowInfo
);
echo json_encode($res);
return ;
?>
