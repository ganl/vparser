<?php
$vtype = isset($_GET["type"]) ? $_GET["type"] : 'youku';
$vid = isset($_GET["vid"]) ? $_GET["vid"] : '';
if($vtype == "" || $vid == "")
	die('parameter Error!');
switch($vtype){
	case "youku":
		include_once(dirname(__FILE__)."/module/youku.php");
		$video = youkuXml($vid,false);
		break;
	case "tudou":
		include_once(dirname(__FILE__)."/module/tudou.php");
		$video = tudouXml($vid,false);
		break;
	case "ku6":
		include_once(dirname(__FILE__)."/module/ku6.php");
		$video = ku6Location($vid,false);
		break;
	case "56":
		include_once(dirname(__FILE__)."/module/56.php");
		$video = _56Location($vid,false);
		break;
	case "letv":
		include_once(dirname(__FILE__)."/module/letv.php");
		$video = letvLocation($vid,false);
		break;
	case "qq":
		include_once(dirname(__FILE__)."/module/qq.php");
		$video = qqLocation($vid,false);
		break;
	case "ifeng":
		include_once(dirname(__FILE__)."/module/ifeng.php");
		$video = ifengLocation($vid,false);
		break;
	case "163":
		include_once(dirname(__FILE__)."/module/163.php");
		$video = _163Location($vid,false);
		break;
	default:
		die("Parameter error!");
}
if(!empty($video)){
	header('Content-type:text/xml; charset=utf-8');
	// $xml = NULL;
	// echo $vid;
	// echo "<pre>";
	// print_r($video);
	$v = $video['url'][0];
	header("location:$v");
}
else
	die('Request error! Code: RESOURCES_ERR');
?>