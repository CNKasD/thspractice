<?php
require 'MyMongo.class.php';

$db = array(
    'host' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'dbname' => 'zhanghao',
    'dbtype' => 'mysql'
);
$mongo = new MyMongo('users');
$mongo->connect($db);
$id = '595b86c240ffa26b609db8c4';
// $updateData = array('username' => '插入数据', 'level' => 0);
// $res = $mongo->where('level', '2', '$gte');
$existQuery = array(
    '$or' => array(
        array('account' => 'admin'),
        array('username' => 'guest')
    )
    
);
$res = $mongo->query($existQuery);

var_dump($res);
