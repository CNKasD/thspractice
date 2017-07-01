<?php
	require_once  "../vendor/autoload.php";

    $username = '';  //此处填写用户名
    $pwd      = '';  //此处填写密码

    $name     = new Zhanghao\Practice\GetGithubName($username,$pwd);
    echo 'github名称为' . $name->getName();


?>
