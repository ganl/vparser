<?php
include_once(dirname(__FILE__)."/functions.php");
function _163Location($surl, $display = true){
	preg_match_all('/http:\/\/v.163.com\/.*\/.*\/(.*?).html/',$surl,$arr);
	$vid = $arr[1][0];
	$index = strlen($vid);
	// http://v.163.com/zixun/V8GAM9FF2/V9IOUQ263.html
	if($index > 9)
		$url = 'http://live.ws.126.net/movie/'.$vid[$index-2].'/'.$vid[$index-1].'/2_'.$vid.'.xml';
	else
		$url = 'http://xml.ws.126.net/video/'.$vid[$index-2].'/'.$vid[$index-1].'/0085_'.$vid.'.xml';
	$referer = 'http://v.163.com';// custom referer
	$content = get_content($url,$referer);// get contents of the remote page
	preg_match('~<useMp4>(\d+)</useMp4>~iUs',$content,$ismp4);// mp4 format
	if($ismp4 && $ismp4[1] > 0)	// mp4 list
		preg_match('~<mp4>(.*)</mp4>~iUs',$content,$vurl);
	else// flv list.
		preg_match('~<flv>(.*)</flv>~iUs',$content,$vurl);
	if($vurl){
	   if(preg_match_all("\.",$vurl[1],$arr)){
		if($display)
			echo '<a href="'.$vurl[1].'" target="_blank">视频地址</a>';
		else{
			$video['url'][0] = $vurl[1];
			$video['size'][0] = NULL;
			$video['duration'][0] = NULL;
			
			return $video;
		}
	   }else{
		$con = get_content($surl,$referer);
		 if(preg_match_all("/appsrc : \'(.*?)-list.m3u8\'/",$con,$arr)){
			$video['url'][0] = $arr[1][0].".flv";
                	$video['size'][0] = NULL;
                	$video['duration'][0] = NULL;
			return $video;
	  	 }else{
                      $apiurl = "http://api.flvxz.com/token/336e323892586c3a270a79bb2176be65/url/".strtr(base64_encode(preg_replace('/^(https?:)\/\//','$1##',$surl)),'+/','-_')."/xmlformat/cmpxml";
			$cont = get_content($apiurl);
			preg_match("/src=\"(.*?)\"/",$cont,$arr);
			$video['url'][0] = $arr[1];
                        $video['size'][0] = NULL;
                        $video['duration'][0] = NULL;
                        return $video;
                 }
	   }
	}
	else{
		if($display)
			echo '无法获取到您指定的视频资源，资源已被删除或者您提供的信息有误。';
		else
			return NULL;
	}
}
?>
