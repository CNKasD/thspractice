<?php
require_once '../vendor/autoload.php';
use Zhanghao\Practice\users\Users;

$id = $_POST['id'];

$user = new Users();
$createResult = $user->delUser($id);  
$res = array(
    'error' => 0,
    'msg' => '删除成功'
);
echo json_encode($res);
return ;

?>
