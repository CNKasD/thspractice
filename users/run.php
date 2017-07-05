<?php
namespace Zhanghao\Practice;
require 'users/Users.php';
require 'authority.php';
use Zhanghao\Practice\authority\Authority;

session_start();

$user = new Users();

//创建低级用户
$createResult = $user->createLowUser('guest', '123', 'guest2', 2);
$Authority = new Authority();
if ($Authority->judgeAuthority())

if ($createResult == 2) {
    $res = array(
        'error' => 40202,
        'msg' => '用户名或账号已被占用'
    );
    echo json_encode($res);
    return ;
}

//登录
// $info = $user->login('admin','123456');
// if ($info) {
// //     print_r ($info);   
// //     $_SESSION['account'] = $info['account'];
// //     $_SESSION['id'] = $info['id'];
// //     $_SESSION['username'] = $info['username'];
// //     $_SESSION['level'] = $info['level'];
    
// } else {
//     $res = array(
//         'error' => 40201,
//         'msg'   => '用户名或密码错误'
//     );
    
//     echo json_encode($res);
// //     return ;
// }

//获取比自己级别低的用户信息
// $lowInfo = $user->getLowUserInfo($info['level']);  //此处level应该从session中获取
// var_dump($lowInfo);

?>
