<?php
include_once(dirname(__FILE__)."/functions.php");
function ifeng_change_url($url){
	$host = 'http://ips.ifeng.com/';
	$new = str_replace('http://', $host, $url);
	return $new;
}
function ifengLocation($surl, $display = true){
	if(preg_match_all('/shtml#(.*?)/',$surl,$arr)){
		$vid = $arr[1][0];
	}else{
		preg_match_all('/[0-9]+\/(.*?)\.shtml/',$surl,$arr);
		$vid = $arr[1][0];
	// http://v.ifeng.com/ent/mingxing/2014001/01e94970-5c6d-4135-afd4-4b1251f42aa7.shtml
	}
	$index = strlen($vid);	// Get the length of the $vid.
	$url = 'http://v.ifeng.com/video_info_new/'.$vid[$index-2].'/'.$vid[$index-2].$vid[$index-1].'/'.$vid.'.xml';
	$referer = 'http://v.ifeng.com';// custom referer
	$content = get_content($url,$referer);	// get remote page contents
	preg_match_all('~\<parts\s*(.*)\s*\/>~iUs',$content,$parts);	// Get the resource list.
	if(count($parts[1]) == 0){
		preg_match('~VideoPlayUrl\s*=\s*"(.*)"~iUs',$content,$playurl);
		if($playurl){
			preg_match('~Duration="(\d+)"~iUs',$content,$duration);
			
			if($display)
				echo '<a href="'.$playurl[1].'" target="_blank">视频地址</a>';
			else{
				$video['size'][0] = NULL;
				$video['url'][0] = ifeng_change_url($playurl[1]);
				$video['duration'][0] = $duration[1];
				
				return $video;
			}
		}
		else{
			if($display)
				echo '无法获取到您指定的视频资源，资源已被删除或者您提供的信息有误。';
			else
				return NULL;
		}
	}
	else{
		for($i = 0; $i < count($parts[1]); $i++){
			preg_match('~playurl="(.*)"~iUs',$parts[1][$i],$playurl);
			preg_match('~duration="(\d+)"~iUs',$parts[1][$i],$duration);
			if($display){
				if($i < 9)
					echo '<a href="'.$playurl[1].'" target="_blank">分段0'.($i+1).'</a>';
				else
					echo '<a href="'.$playurl[1].'" target="_blank">分段'.($i+1).'</a>';
			}
			else{
				$video['size'][$i] = NULL;
				$video['url'][$i] = ifeng_change_url($playurl[1]);
				$video['duration'][$i] = $duration[1];
			}
		}
		if(!$display)
			return $video;
	}
}
?>