<?php
require_once '../vendor/autoload.php';
use Zhanghao\Practice\users\Users;

session_start();
$url = $_SESSION['url'];
$account = $_POST['account'];
$pwd = $_POST['pwd'];

$user = new Users();
//登录
$info = $user->login($account,$pwd);
if ($info) {
//     var_dump($info);
    $_SESSION['account'] = $info['account'];
    $_SESSION['id'] = $info['id'];
    $_SESSION['username'] = $info['username'];
    $_SESSION['level'] = $info['level'];
    
    $res = array(
        'error' => 0,
        'url'   => $url
    );
    
    echo json_encode($res);
    return ;
} else {
    $res = array(
        'error' => 40201,
        'msg'   => '用户名或密码错误'
    );

    echo json_encode($res);
//     return ;
}
?>
