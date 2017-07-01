<?php
    require_once '../vendor/autoload.php';

    use Zhanghao\Practice\ReadXml;

    $keywords = $_GET['keywords'];
    $xml = new ReadXml('stocks.xml',$keywords);
    // $starttime = $xml->getMicrotime(); // 记录开始时间
    $data = $xml->xml2Array();
    
    $res = array(
        'error' => 0,
        'data'  => $data
        );
    echo json_encode($res);
    return ;

    // 记录结束时间
    // $endtime = $xml->getMicrotime();;
    // echo '运行时间:'.(float)(($endtime-$starttime)*1000).'ms<br>';  

?>