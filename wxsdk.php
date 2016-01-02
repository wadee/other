<?php
//js-sdk开关
$applyapi=true;

//夏菲的公众号
$appId = 'wxf0fd8358f3ec6f04';
$appsecret = '2f22f81e6e860d1b9ca4a354f12b8ee3';
$timestamp = time();
$jsapi_ticket="aaaaaaaaaaaaaaaaaaaaa";
$nonceStr="bbbbbbbbbbbbbbb";
$url="ccccccccccccccc";
$signature="dddddddddddddddd";

//本地测试时可以先关闭js-sdk的调用，减少错误输出
if($applyapi==true)
{
$timestamp = time();
$jsapi_ticket = make_ticket($appId,$appsecret);
$nonceStr = make_nonceStr();
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$signature = make_signature($nonceStr,$timestamp,$jsapi_ticket,$url);
}

function make_nonceStr()
{
	$codeSet = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	for ($i = 0; $i<16; $i++) {
		$codes[$i] = $codeSet[mt_rand(0, strlen($codeSet)-1)];
	}
	$nonceStr = implode($codes);
	return $nonceStr;
}

function make_signature($nonceStr,$timestamp,$jsapi_ticket,$url)
{
	$tmpArr = array(
	'noncestr' => $nonceStr,
	'timestamp' => $timestamp,
	'jsapi_ticket' => $jsapi_ticket,
	'url' => $url
	);
	ksort($tmpArr, SORT_STRING);
	$string1 = http_build_query( $tmpArr );
	$string1 = urldecode( $string1 );
	$signature = sha1( $string1 );
	return $signature;
}

function make_ticket($appId,$appsecret)
{
	// access_token 应该全局存储与更新，以下代码以写入到文件中做示例
	$data = json_decode(file_get_contents("./apptoken/access_token.json"));

	if ($data->expire_time < time()) {
		$TOKEN_URL="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appsecret;
		$json = file_get_contents($TOKEN_URL);
		$result = json_decode($json,true);
		$access_token = $result['access_token'];
		if ($access_token) {
			$data->expire_time = time() + 7000;
			$data->access_token = $access_token;
			$fp = fopen("./apptoken/access_token.json", "w");
			fwrite($fp, json_encode($data));
			fclose($fp);
		}
	}else{
		$access_token = $data->access_token;
	}

	// jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
	$data = json_decode(file_get_contents("./apptoken/jsapi_ticket.json"));
	if ($data->expire_time < time()) {
		$ticket_URL="https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
		$json = file_get_contents($ticket_URL);
		$result = json_decode($json,true);
		$ticket = $result['ticket'];
		if ($ticket) {
			$data->expire_time = time() + 7000;
			$data->jsapi_ticket = $ticket;
			$fp = fopen("./apptoken/jsapi_ticket.json", "w");
			fwrite($fp, json_encode($data));
			fclose($fp);
		}
	}else{
		$ticket = $data->jsapi_ticket;
	}

	return $ticket;
}

?>
