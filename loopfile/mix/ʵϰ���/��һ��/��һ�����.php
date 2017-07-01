<?

$username = "zhanghao2mail@gmail.com";
$pwd = "kasdgithub123";

//获取动态的token
$url = "https://github.com/login";
$ch = curl_init();
$cookie_file = tempnam('./temp','cookie');
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//不严格校验
//设置header
curl_setopt($ch, CURLOPT_HEADER, FALSE);
//设置浏览器
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0');
//要求结果为字符串且输出到屏幕上
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
//运行curl
$getToken = curl_exec($ch);
//返回结果
if($getToken){
    curl_close($ch);
    //获取authenticity_token
    preg_match("/name=\"authenticity_token\"\stype=\"hidden\"\svalue=\".{88}/", $getToken,$match);
    $authenticity_token = str_replace('name="authenticity_token" type="hidden" value="', '', $match[0]);
} else {
    $error = curl_errno($ch);
    curl_close($ch);
    echo "连接出错";
}
//调试用，查看cookie文件
echo file_get_contents($cookie_file);
//填充post数据
$postData = "commit=Sign+in&utf8=%E2%9C%93&authenticity_token=" . urlencode($authenticity_token) . "&login=". $username ."&password=" . $pwd;

//发送post数据进行登录
$submitUrl = "https://github.com/session";
$cookie_file2 = tempnam('./temp','cookie');
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $submitUrl);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//不严格校验
curl_setopt ($ch, CURLOPT_HEADER, TRUE );  //返回响应头
//设置浏览器
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0');
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt ($ch, CURLOPT_POST, 1 );
curl_setopt ($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file2);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);

$return = curl_exec ($ch );
//调试用，查看返回数据包
echo $return;
curl_close ($ch );
//调试用，查看cookie
echo file_get_contents($cookie_file2);   

//进入个人中心页面获取用户名
$infoUrl = "https://github.com/settings/profile";
$cookie_file3 = tempnam('./temp','cookie');
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $infoUrl);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//不严格校验
curl_setopt ($ch, CURLOPT_HEADER, TRUE );  //返回响应头
//设置浏览器
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0');
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file2);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file2);
$getName = curl_exec ($ch );
//调试用
echo $getName;
echo file_get_contents($cookie_file2);
$getName = file_get_contents('./new.html');
echo preg_match('/Signed\sin\sas\s<strong\sclass=\"css-truncate-target\">(.*)<\/strong>/', $getName,$match);
var_dump($match);

?>