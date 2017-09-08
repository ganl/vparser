<?php
/*
*此需要merge分段合并插件配合使用
*如，窃听风云3 http://www.iqiyi.com/v_19rrifwg4k.html视频vid为bec1dfc6ce75451697c9eb5c510156a4
*用法:mergeqiyi.php?id=http://www.iqiyi.com/v_19rrifwg4k.html
*用法:mergeqiyi.php?vid=bec1dfc6ce75451697c9eb5c510156a4
*/
error_reporting(0);
header("content-type:text/xml;charset=UTF-8");
if(isset($_GET['vid'])){
  echo qiyivid($_GET['vid']);
}elseif(isset($_GET['id'])){
$content = getStr($_GET['id']);
  preg_match('|data-player-videoid="(\w+)"|',$content,$vid);
//var_dump($vid);
	if(preg_match('|data-player-tvid="(\w+)"|',$content,$tvid)){
//		echo 1;
//		var_dump($tvid);
		echo qiyivid($vid[1],$tvid);
	}else{
	//echo 3;
		echo qiyivid($vid[1]);
	}
}else{
 exit;
}
function qiyivid($vid,$tvid=null){
    $url='http://dispatcher.video.qiyi.com/mini/crumb/'.$vid;
if($tvid !=null){
	//echo 2;
//var_dump($tvid);
}else{
    preg_match('|"tvid":([0-9]+),"videoName":"([^"]+)",|',getStr($url),$tvid);
}

    $content =getStr('http://cache.video.qiyi.com/vd/'.$tvid[1].'/'.$vid.'/');
   //$content =getStr('http://cache.video.qiyi.com/vd/0/'.$vid.'/');
    $obj=json_decode($content);
    $fs=$obj->tkl[0]->vs[0]->fs;
    $mu=$obj->tkl[0]->vs[0]->mu;
    $m="$obj->dm$mu";
    $m=simplexml_load_file( $m,'SimpleXMLElement',LIBXML_NOCDATA);
    $x='<m starttype="0" label="'.$tvid[2].'" type="flv" bytes="'.$m->flv->filesize.'" duration="'.$m->flv->duration.'" lrc="">'."\n";
    foreach($fs as $k => $v){
        $key=getKey($v->l);
        $bj=json_decode(getStr('http://data.video.qiyi.com/'.$key.'/videos'.$v->l));
         preg_match('|key=(\w+)&uuid|',$bj->l,$k2);
        $x.='<u bytes="'.$v->b.'" duration="'.($v->d/1000).'" src="'.$obj->du.''.$v->l.'?key='.$k2[1].'"/>'."\n";
     //$x.='<u bytes="'.$v->b.'" duration="'.($v->d/1000).'" src="'.$bj->l.'"/>'."\n";
    //$x.='<u bytes="'.$v->b.'" duration="'.($v->d/1000).'" src="http://wgdcnccdn.inter.qiyi.com/videos'.$v->l.'"/>'."\n";
        }
     $x.='</m>';
    return $x;
}
function getKey($id){
  $url='http://data.video.qiyi.com/t?tn='.rand();
  $url=json_decode(getStr($url));
  $_loc_3= ")(*&^flash@#$%a";
  $_loc_4= floor(($url->t)/ (10 * 60));
  $str=strripos($id,'/');
  $str=substr($id,$str+1,32);
  return MD5($_loc_4.$_loc_3.$str);
}
function getStr($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
        curl_setopt($ch, CURLOPT_ENCODING,'');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0');
       @$data = curl_exec($ch);
       curl_close($ch);
      return $data;
}
?>