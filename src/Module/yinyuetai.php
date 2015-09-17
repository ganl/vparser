<?php

if(!defined('IN_PARSER')) {
	exit('Access Denied');
}

class Vparser_yinyuetai{
	
	public function getVideoInfo(){
		
	}
	
	public function getDownloadById($vid){
		require_once VPARSER_ROOT.'/Common/function.php';
		$data = fetch('http://www.yinyuetai.com/insite/get-video-info?videoId='.$vid.'&flex=true');
		preg_match_all('|(http://[a-z]{2}.yinyuetai.com/uploads/videos/common/[^&]+)&br=|', $data, $vUrl);
		$vUrl = $vUrl[1];
		
		return $vUrl;
	}
	
	public function getDownloadByUrl($url){
		$vid = "";
		preg_match_all('|http://\w+.yinyuetai.com/video/(\d+)|', $url, $vidArr);
		if(count($vidArr)>1){
			return $this->getDownloadById($vidArr[1][0]);
		}
		
	}
}

