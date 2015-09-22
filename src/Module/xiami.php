<?php
if(!defined('IN_PARSER')) {
	exit('Access Denied');
}

// http://www.xiami.com/song/playlist/id/3320521
// http://www.xiami.com/song/playlist/id/3320521/object_id/0/cat/json
// http://www.xiami.com/widget/xml-single/sid/3320521
// http://www.xiami.com/widget/json-single/sid/3320521

class Vparser_xiami{
	public function getVideoInfo(){

	}

	public function getDownloadById($vid){
		require_once VPARSER_ROOT.'/Common/function.php';
		$content = fetch('http://www.xiami.com/song/playlist/id/'.$vid.'/object_name/default/object_id/0/cat/json');
		$data = json_decode($content,true);
		$info = $data['data']['trackList'][0];
		$vUrl = array();
		$vUrl['src'] = $this->getSrc($info['location']);
		$vUrl['lrc'] = $info['lyric'];
		return $vUrl;
	}
	
	/**
	 * 
	 * @param string $url
	 * @return array
	 */
	public function getDownloadByUrl($url){
		preg_match_all('|http://\w+.xiami.com/song/(\d+)|', $url, $arr);
		$vid = $arr[1][0];
		return $this->getDownloadById($vid);
	}
	
	/**
	 * 来源于网路
	 * @param unknown $location
	 * @return mixed
	 */
	function getSrc($location){
	
		$sc_num31=substr($location,0,1);
		$sc_num32=substr($location,1,strlen($location));
		$sc_num33=floor(strlen($sc_num32)/$sc_num31);
		$sc_num1=strlen($sc_num32)%$sc_num31;
		$sc_arr=array();
		$sc_num2=0;
		while($sc_num2<$sc_num1){
			if($sc_arr[$sc_num2]==null){
				$sc_arr[$sc_num2]='';
			}
			$sc_arr[$sc_num2]=substr($sc_num32,($sc_num33+1)*$sc_num2,$sc_num33+1);
			$sc_num2++;
		}
		$sc_num2=$sc_num1;
		while($sc_num2<$sc_num31){
			$sc_arr[$sc_num2]=substr($sc_num32,$sc_num33*($sc_num2-$sc_num1)+($sc_num33+1)*$sc_num1,$sc_num33);
			$sc_num2++;
		}
		$sc_str4='';
		$sc_num2=0;
		while($sc_num2<strlen($sc_arr[0])){
			$sc_num3=0;
			while($sc_num3<count($sc_arr)){
				if($sc_num2>=strlen($sc_arr[$sc_num3])){
					break;
				}
				$sc_str4.=substr($sc_arr[$sc_num3],$sc_num2,1);
				$sc_num3++;
			}
			$sc_num2++;
		}
		$sc_str4=urldecode($sc_str4);
		$sc_str5='';
		$sc_num2=0;
		while($sc_num2<strlen($sc_str4)){
			if(substr($sc_str4,$sc_num2,1)=='^'){
				$sc_str5.="0";
			}else{
				$sc_str5.=substr($sc_str4,$sc_num2,1);
			}
			$sc_num2++;
		}
		$sc_str5=str_replace('+','',$sc_str5);
	
		return $sc_str5;
	}
	
}
