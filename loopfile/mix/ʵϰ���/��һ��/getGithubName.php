<?
header("Content-Type: text/html; charset=utf-8");
$username = "zhanghao2mail@gmail.com";
$pwd = "kasdgithub123";

//获取动态token
$loginUrl = "https://github.com/login";
$loginCookie = tempnam('./temp','cookie');
$getToken = HttpsRequest($loginUrl, NULL, $loginCookie, NULL);
// 正则匹配token
preg_match("/name=\"authenticity_token\"\stype=\"hidden\"\svalue=\".{88}/", $getToken,$match);
$authenticity_token = str_replace('name="authenticity_token" type="hidden" value="', '', $match[0]);

//准备提交post数据
$submitUrl = "https://github.com/session";
//填充post数据
$postData = "commit=Sign+in&utf8=%E2%9C%93&authenticity_token=" . urlencode($authenticity_token) . "&login=". $username ."&password=" . $pwd;
$submitCookie = tempnam('./temp','cookie');
HttpsRequest($submitUrl, $postData, $submitCookie, $loginCookie);

//登录个人中心页面获取用户名称
$infoUrl = "https://github.com/settings/profile";
$getName = HttpsRequest($infoUrl, NULL, $submitCookie, $submitCookie);
//正则匹配用户名
preg_match('/Signed\sin\sas\s<strong\sclass=\"css-truncate-target\">(.*)<\/strong>/', $getName,$match);
echo '用户名称为' . $match[1];

/**
 * 发送https请求
 * @param unknown $url         目标url
 * @param unknown $postData    POST数据，可以为空
 * @param unknown $saveCookie  保存cookie文件的路径 
 * @param unknown $useCookie   使用的cookie文件路径
 * @return mixed  $data        响应正文
 */
function HttpsRequest($url, $postData, $saveCookie, $useCookie){
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);// 不严格校验
    curl_setopt ($ch, CURLOPT_HEADER, FALSE );  // 不返回响应头
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'); 
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1 );
    if ($postData){
        curl_setopt ($ch, CURLOPT_POST, 1 );
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $postData);
    }
    curl_setopt($ch, CURLOPT_COOKIEJAR, $saveCookie);
    if ($useCookie){
        curl_setopt($ch, CURLOPT_COOKIEFILE, $useCookie);
    }
    $data = curl_exec ($ch );
    curl_close ($ch );
    return $data;
}
?>