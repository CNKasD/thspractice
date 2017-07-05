<?php
namespace Zhanghao\Practice;
require 'mongo/CurdFactory.php';

$col = CurdFactory::createCurd('col');


$document = array(
	'title' => 'MongoDB',
	'description' => 'database',
	'likes' => 100,
	'url' => 'http://www.baidu.com',
	'by' => 'me'
);
$col->getInfo('a');
// $col->insert($document);
// echo '数据插入成功';
?>
