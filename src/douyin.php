<?php

function get_curl_contents($url){
    if(!function_exists('curl_init')) die('php.ini未开启php_curl.dll');
    $cweb = curl_init();
    curl_setopt($cweb,CURLOPT_URL,$url);
    curl_setopt($cweb,CURLOPT_USERAGENT,"Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1");
    curl_setopt($cweb,CURLOPT_HEADER,0);
    curl_setopt($cweb, CURLOPT_HTTPHEADER, array(
    	'accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
    	// 'accept-encoding:gzip, deflate, br',
        'accept-language:zh-CN,zh;q=0.9',
        'cache-control:max-age=0',
        'upgrade-insecure-requests:1'
    	));
    curl_setopt($cweb,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($cweb, CURLOPT_FOLLOWLOCATION, 1); 
    // curl_setopt($cweb,CURLOPT_COOKIE,base64_decode("Il9feXN1aWQ9Ii50aW1lKCkuIjsi"));
    $cnt = curl_exec($cweb);
    curl_close($cweb);
    return $cnt;
}
$input = json_decode(file_get_contents('php://input', 'r'), true);
$url = $input['v_url']; // http://v.douyin.com/YroCHS/
if (empty($url)) {
	die(json_encode(array('code' => -200, 'msg' => '非法请求！！！')));
}

$content = get_curl_contents($url);

if (preg_match('/video_id\=([^"]+)/i', $content, $matches)) {
	parse_str(htmlspecialchars_decode($matches[0]));
	die(json_encode(array('code' => 0, 'vid' => $video_id, 'msg' => '')));
}

// 另一种：不模拟手机请求

/*
$(function(){
            require('web:component/reflow_video/index').create({
                hasData: 1,
                videoWidth: 720,
                videoHeight: 1280,
                playAddr: "https://aweme.snssdk.com/aweme/v1/playwm/?video_id=v0200fdc0000bhje4ngghl0k1an9fsl0&line=0",
                cover: "https://p3.pstatp.com/large/1a83f0004a73f042df2bd.jpg"

            });
        });
*/

echo json_encode(array('code' => -100, 'msg' => '链接无法识别！', 'url' => $url));
