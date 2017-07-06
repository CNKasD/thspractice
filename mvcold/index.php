<?php 
// 应用目录为当前目录
echo 'aaaaaa';
return ;
define('APP_PATH', __DIR__ . '/');


// 加载框架文件
require(APP_PATH . 'library/Core.php');

// 加载配置文件
$config = require(APP_PATH . 'config/config.php');

// 实例化框架类
(new Core($config))->run();
