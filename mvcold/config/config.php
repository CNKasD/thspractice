<?php

//开启调试模式
$config['debug'] = true;

//数据库配置
$config['db'] = array(
	'host' => '127.0.0.1',
	'username' =>'root',
	'password' => '',
	'dbname' => 'zhanghao',
	'dbtype' => 'mongo',     //mysql 或 mongo
	);


// 默认控制器和操作名
$config['defaultController'] = 'Index';
$config['defaultAction'] = 'index';

return $config;