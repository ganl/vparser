<?php
if(!defined('IN_PARSER')) {
	exit('Access Denied');
}

class Vparser_cntv{
	public function getVideoInfo(){

	}

	public function getDownloadById($vid){
		require_once VPARSER_ROOT.'/Common/function.php';
		$contents = fetch('http://vdn.apps.cntv.cn/api/getHttpVideoInfo.do?pid='.$vid.'&idl=32&idlr=32&modifyed=false');
		$v = json_decode($contents,true);
		$vUrl = $v['video']['chapters'];
		return $vUrl;
	}
	
	/**
	 * 返回的是分段视频
	 * @param string $url
	 * @return array
	 */
	public function getDownloadByUrl($url){
		require_once VPARSER_ROOT.'/Common/function.php';
		$content = fetch($url);
		preg_match_all('/fo\.addVariable\(\"videoCenterId\"\,\"(.*?)\"\)\;/',$content,$arr);
		$contents = fetch('http://vdn.apps.cntv.cn/api/getHttpVideoInfo.do?pid='.$arr[1][0].'&idl=32&idlr=32&modifyed=false');
		$v = json_decode($contents,true);
		
// 		[video] => Array
// 		(
// 				[validChapterNum] => 2
// 				[lowChapters] => Array
// 				(
// 						[0] => Array
// 						(
// 								[image] => http://p4.img.cctvpic.com/fmspic/2015/09/19/cdaae8023379407eb547870805762508-180.jpg
// 								[url] => http://vod.cntv.lxdns.com/flash/mp4video45/TMS/2015/09/19/cdaae8023379407eb547870805762508_h264200000nero_aac16.mp4
// 								[duration] => 146
// 						)
		
// 				)
		
// 				[totalLength] => 146.00
// 				[chapters] => Array
// 				(
// 						[0] => Array
// 						(
// 								[image] => http://p4.img.cctvpic.com/fmspic/2015/09/19/cdaae8023379407eb547870805762508-180.jpg
// 								[url] => http://vod.cntv.lxdns.com/flash/mp4video45/TMS/2015/09/19/cdaae8023379407eb547870805762508_h264418000nero_aac32.mp4
// 								[duration] => 146
// 						)
		
// 				)
		
// 				[url] =>
// 		)
		
		$vUrl = $v['video']['chapters'];
		return $vUrl;
	}
}
