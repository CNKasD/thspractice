<?php
require_once '../vendor/autoload.php';
use Zhanghao\Practice\users\Users;

session_start();
$level = $_SESSION['level']+1;
$account = $_POST['account'];
$pwd = $_POST['pwd'];
$username = $_POST['username'];

$user = new Users();
//获取比自己级别低的用户信息
$createResult = $user->createLowUser($account, $pwd, $username, "$level");  //此处level应该从session中获取
if ($createResult == 2) {
    $res = array(
        'error' => 40202,
        'msg' => '用户名或账号已被占用'
    );
    echo json_encode($res);
    return ;
}
$res = array(
    'error' => 0,
    'msg' => '添加成功'
);
echo json_encode($res);
return ;

?>
