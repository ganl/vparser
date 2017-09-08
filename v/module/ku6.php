<?php
include_once(dirname(__FILE__)."/functions.php");
function ku6Location($surl, $display = true){	//代理页是否显示
	preg_match_all('/http:\/\/v.ku6.com\/show\/(.*?)\.html/',$surl,$arr);
	$kID = $arr[1][0];
	$url = 'http://v.ku6.com/fetchVideo4Player/'.$kID.'.html';
	$referer = 'http://www.ku6.com';// custom referer
	$content = get_content($url,$referer);// get content
	if(stristr($content,'404 Not Found') || stristr($content,'"status":404')){
		if($display)
			echo '无法获取到您指定的视频资源，资源已被删除或者您提供的信息有误。';
		else
			return NULL;
	}
	else{
		$json = json_decode($content);
		$vurl = explode(',',$json->data->f);
		$duration = explode(',',$json->data->vtime);	
		for($i = 0; $i < count($vurl); $i++){
			if($display){// display
					echo '<a href="'.$vurl[$i].'" target="_blank">分段'.($i+1).'</a>';
			}
			else{// return
				$video['size'][$i] = NULL;
				$video['url'][$i] = $vurl[$i];
				if(count($vurl) > 1)
					$video['duration'][$i] = $duration[$i+1];
				else
					$video['duration'][$i] = $duration[$i];
			}
		}
		if(!$display)
			return $video;
	}
}
?>