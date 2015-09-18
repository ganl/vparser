<?php

if(!defined('IN_PARSER')) {
	exit('Access Denied');
}

class Vparser_miaopai{
	public function getVideoInfo(){
	
	}
	
	public function getDownloadById($vid){
		require_once VPARSER_ROOT.'/Common/function.php';
		$data = fetch('http://api.miaopai.com/m/v2_channel.json?fillType=259&scid='.$vid.'&vend=miaopai');
		$info = json_decode($data,true); 
		//http://gslb.miaopai.com/stream/~7sCwx2y5qD53Ff~tcguUQ__.mp4?vend=miaopai&~7sCwx2y5qD53Ff~tcguUQ__.mp4?vend=sina
		$vUrl = $info['result']['stream']['base'];
		return $vUrl;
	}
	
	public function getDownloadByUrl($url){
		$vid = "";
		preg_match_all('|http://\w+.miaopai.com/show/(.*?).htm|', $url, $vidArr);
		if(count($vidArr[0])>=1){
			return $this->getDownloadById($vidArr[1][0]);
		}else{
			preg_match_all('|http://\w+.xiaokaxiu.com/v/(.*?).htm|', $url, $vidArr);
			if(count($vidArr)>1){
				return $this->getDownloadById($vidArr[1][0]);
			}
		}
	}
}
