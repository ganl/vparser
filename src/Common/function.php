<?php

if(!defined('IN_PARSER')) {
	exit('Access Denied');
}

function fetch($url){
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Connection:keep-alive',
		'User-Agent:'.$_SERVER["HTTP_USER_AGENT"],
	));
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}