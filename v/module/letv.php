<?php
include_once(dirname(__FILE__)."/functions.php");
function letvLocation($surl,$display = true){
	preg_match_all('/http:\/\/www.letv.com\/ptv\/vplay\/(.*?).html/',$surl,$arr);
	// $vID = $arr[1][0];
	$url = 'http://www.letv.com/v_xml/' . $arr[1][0] .'.xml';
	
	// custom referer
	$referer = 'http://www.letv.com';
	
	// get content
	$content = get_content($url,false,false,$referer);
	
	// Get the first url
	preg_match('~<playurl><!\[cdata\[(.*)\]\]></playurl>~iUs',$content,$playurl);
	
	if($playurl){
		// decode the json data
		$playjson = json_decode($playurl[1]);
		
		// get the video object
		$dispatch = get_object_vars($playjson->dispatch);
		
		// Ultra-clear format
		if(array_key_exists("1000", $dispatch))
			$vurl = $dispatch["1000"][0];
		// 720p format
		elseif(array_key_exists("720p", $dispatch))
			$vurl = $dispatch["720p"][0];
		// normal format
		else
			$vurl = $dispatch["350"][0];
		
		// get the duration value
		$duration = $playjson->duration;
		
		if($display)
			echo '<a href="' . $content->location . '" target="_blank">视频地址</a>';
		else{
			$video['size'][0] = NULL;
			$video['duration'][0] = $duration;
			$video['url'][0] = $vurl;
			
			return $video;
		}
	}
	// no resource got
	else{
		if($display)
			echo '<p class="info">无法获取到您指定的视频资源，资源已被删除或者您提供的信息有误。</p>';
		else
			return NULL;
	}
	
	// Done.
}
?>