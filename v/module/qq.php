<?php
include_once(dirname(__FILE__)."/functions.php");
function qqLocation($surl, $display = true){
	if(preg_match_all('/qq.com/',$surl,$arr)){
		$content = getContents($surl);
		preg_match_all('/vid:"(.*?)",/',$content,$arr);
		$vid = $arr[1][0];
	}else{
		$vid = $surl;
	}
	$info_url = 'http://vv.video.qq.com/getinfo?defaultfmt=fhd&otype=json&platform=11&vids='.$vid;
	$referer = 'http://v.qq.com';// custom referer
	// get the remote page contents
	$content1 = get_content($info_url,$referer);
	// get the json strings
	preg_match('~QZOutputJson\s*=\s*(.*);~iUs',$content1,$info);
	// decode json data
	$json1 = json_decode($info[1]);
	// get the vi object which contains the video information
	$vi = $json1->vl->vi;
	// the total segmentations of the video files
	$fc = $vi[0]->cl->fc;
	// if the remote page returned ZERO segmentation of the video, we change it to this one
	// maybe we can get some in it
	if($fc === 0){
		// the video size and duration
		$fs = $vi[0]->fs;
		$td = $vi[0]->td;
		
		// remote video resource
		$vurl = 'http://vsrc.store.qq.com/'.$vid.'.flv?channel=vhot2&sdtfrom%3dv2&r%3d931&rfc=v0';
		
		// display
		if($display)
			echo '<a href="'.$vurl.'" target="_blank">视频地址</a>';
		// return
		else{
			$video['url'][0] = $vurl;
			$video['size'][0] = $fs;
			$video['duration'][0] = $td;
			
			return $video;
		}	
	}
	
	// if we can get one or more segmentations of the video, we handle it(them)
	// continue to get more information like file name, request key, etc.
	elseif($fc > 0){
		// get ui object, which contains the uri and host information
		$ui = $vi[0]->ul->ui;
		
		// vt value, that is required to the file server
		$vt = $ui[0]->vt;
		
		// base video url, it is the uri of the video resource
		$vurl = $ui[0]->url;
		
		// file name, it is required when we request for the key
		$fn = explode('.',$vi[0]->fn);
		
		// ci object, which contains the video segmentations information
		$ci = $vi[0]->cl->ci;
		
		// the keyid of the video segmentations, we will use it to get the key
		$keyid = explode('.',$ci[0]->keyid);
		
		$key_base_url = 'http://vv.video.qq.com/getkey?platform=11&otype=json&vid='.$vid.'&vt='.$vt;
		
		for($i = 0; $i < $fc; $i++){
			// the size and duration of the video
			$cd[$i] = $ci[$i]->cd;
			$cs[$i] = $ci[$i]->cs;
			
			// video file name
			$vname = $fn[0].'.'.$fn[1].'.'.($i+1).'.'.$fn[2];
			
			// key url
			$key_url = $key_base_url.'&format='.$keyid[1].'&filename='.$vname;
			
			// get key
			$content2 = get_content($key_url,false,false,$referer);
			
			// get the json strings
			preg_match('~QZOutputJson\s*=\s*(.*);~iUs',$content2,$get);
			
			// decode json data
			$json2 = json_decode($get[1]);
			
			// the key
			$key = $json2->key;
			
			// display
			if($display){
				if($i < 9)
					echo '<a href="'.$vurl.$vname.'?fmt=fhd&vkey='.$key.'" target="_blank">分段0'.($i+1).'</a>';
				else
					echo '<a href="'.$vurl.$vname.'?fmt=fhd&vkey='.$key.'" target="_blank">分段'.($i+1).'</a>';
			}
			// return
			else{
				$video['url'][$i] = $vurl.$vname.'?fmt=fhd&vkey='.$key;
				$video['size'][$i] = $cs[$i];
				$video['duration'][$i] = $cd[$i];
			}
		}
		
		if(!$display)
			return $video;
	}
	
	else{
		if($display)
			echo '无法获取到您指定的视频资源，资源已被删除或者您提供的信息有误。';
		else
			return NULL;
	}
	
	// Done.
}
?>