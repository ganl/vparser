<?php
include_once(dirname(__FILE__)."/functions.php");
function _56Location($surl, $display = true){
	if(preg_match_all('/_vid-(.*?).html/',$surl,$arr)){
		$vid = $arr[1][0];
	}else{
		$content = getContents($surl);
		preg_match_all('/_oFlv_o = (.*?);/',$content,$arr);
		$json = json_decode($arr[1][0]);
		$vid = isset($json->id) ? $json->id : $json->EnId;
	}
	$url = 'http://vxml.56.com/json/'.$vid.'/';
	$referer = 'http://www.56.com';	// custom referer
	$content = get_content($url,$referer);// get contents

	if(stristr($content,'"status":"-404"')){
		if($display)
			echo '无法获取到您指定的视频资源，资源已被删除或者您提供的信息有误。';
		else
			return NULL;
	}
	else{
		$json = json_decode($content);
		$rfiles = $json->info->rfiles;
		$hd = $json->info->hd;
		$detail = $rfiles[$hd];
		if($display)
			echo '<a href="' . $detail->url . '" target="_blank">视频地址</a>';
		else{
			$video['size'][0] = $detail->filesize;
			$video['duration'][0] = round($detail->totaltime / 1000,3);
			$video['url'][0] = $detail->url;
			return $video;
		}
	}
}
?>