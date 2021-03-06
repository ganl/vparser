<?php
error_reporting(E_ALL);
require_once './src/vparser.php';

echo '<pre>';

//---------------------------------------------------------------------------------------------------------------------------------
//$yyt = Vparser::load(Vparser::MODULE_YINYUETAI);
//http://v.yinyuetai.com/video/2371147?f=SY-MKDT-MVSB-1
// $videoById = $yyt->getDownloadById('2371147');
// var_dump($videoById);
// array(4) {
//   [0]=>
//   string(102) "http://hc.yinyuetai.com/uploads/videos/common/9166014FCEBFCEA915CF057B69935D8D.flv?sc=3978e1db4d5620fc"
//   [1]=>
//   string(102) "http://hd.yinyuetai.com/uploads/videos/common/F90F014FCECC8DD005C7199B9A39C3B9.flv?sc=c1570bf96e0b008f"
//   [2]=>
//   string(102) "http://he.yinyuetai.com/uploads/videos/common/2ED3014FCECC8DC9EC5F8AA6F34DE3CF.flv?sc=eac990c48387b2f5"
//   [3]=>
//   string(102) "http://sh.yinyuetai.com/uploads/videos/common/0CF3014FCECC8DC1BE690EEACA9D4849.mp4?sc=97f6b23a9ea874b5"
// }

// $videoByUrl = $yyt->getDownloadByUrl("http://v.yinyuetai.com/video/2372393?f=SY-MKDT-MVSB-1");
// var_dump($videoByUrl);
// array(3) {
// 	[0]=>
// 	string(102) "http://hc.yinyuetai.com/uploads/videos/common/BA60014FD658FD88DA07218ED1BCC4D6.flv?sc=1eaa8461b1951dd7"
// 	[1]=>
// 	string(102) "http://hd.yinyuetai.com/uploads/videos/common/BB6F014FD67AC43AFC68237328A12951.flv?sc=2ff024c235b8c09f"
// 	[2]=>
// 	string(102) "http://he.yinyuetai.com/uploads/videos/common/0764014FD67AC434D0A85DF7E07486FE.flv?sc=503c9cf46f4b95cf"
// }


//---------------------------------------------------------------------------------------------------------------------------------
// http://v.xiaokaxiu.com/v/2H1eK2UCug-T-NcG9KN2rA__.html
//$miaopai = Vparser::load(Vparser::MODULE_MIAOPAI);

// $videoById = $miaopai->getDownloadById("2H1eK2UCug-T-NcG9KN2rA__");
// var_dump($videoById);
// string(73) "http://gslb.miaopai.com/stream/2H1eK2UCug-T-NcG9KN2rA__.mp4?vend=miaopai&"

// $videoById = $miaopai->getDownloadByUrl("http://v.xiaokaxiu.com/v/2H1eK2UCug-T-NcG9KN2rA__.html");
// var_dump($videoById);
// string(73) "http://gslb.miaopai.com/stream/2H1eK2UCug-T-NcG9KN2rA__.mp4?vend=miaopai&"


// $videoById = $miaopai->getDownloadByUrl("http://www.miaopai.com/show/~7sCwx2y5qD53Ff~tcguUQ__.htm");
// var_dump($videoById);
// string(73) "http://gslb.miaopai.com/stream/~7sCwx2y5qD53Ff~tcguUQ__.mp4?vend=miaopai&"


//---------------------------------------------------------------------------------------------------------------------------------
//http://news.cntv.cn/2015/09/19/VIDE1442661656471755.shtml

//$cntv = Vparser::load(Vparser::MODULE_CNTV);
// $videoByUrl = $cntv->getDownloadByUrl("http://news.cntv.cn/2015/09/19/VIDE1442661656471755.shtml");
// var_dump($videoByUrl);
// array(1) {
// 	[0]=>
// 	array(3) {
// 		["image"]=>
// 		string(84) "http://p4.img.cctvpic.com/fmspic/2015/09/19/cdaae8023379407eb547870805762508-180.jpg"
// 		["url"]=>
// 		string(115) "http://vod.cntv.lxdns.com/flash/mp4video45/TMS/2015/09/19/cdaae8023379407eb547870805762508_h264418000nero_aac32.mp4"
// 		["duration"]=>
// 		string(3) "146"
// 	}
// }


//http://news.cntv.cn/2015/09/20/VIDE1442722138330797.shtml ----> cdaae8023379407eb547870805762508
// $videoById = $cntv->getDownloadById("cdaae8023379407eb547870805762508");
// var_dump($videoById);
// array(1) {
// 	[0]=>
// 	array(3) {
// 		["image"]=>
// 				string(84) "http://p4.img.cctvpic.com/fmspic/2015/09/19/cdaae8023379407eb547870805762508-180.jpg"
// 		["url"]=>
// 				string(115) "http://vod.cntv.lxdns.com/flash/mp4video45/TMS/2015/09/19/cdaae8023379407eb547870805762508_h264418000nero_aac32.mp4"
// 		["duration"]=>
// 				string(3) "146"
// 	}
// }

//--------------------------------------------------------------------------------------------------------------
// http://www.xiami.com/song/1774621640
// http://www.xiami.com/song/1773346501

//$xiami = Vparser::load(Vparser::MODULE_XIAMI);
//$musicById = $xiami->getDownloadById("1773346501");
//var_dump($musicById);
// array(2) {
// 	["src"]=>
// 		string(129) "http://m5.file.xiami.com/778/778/1602302708/1773346501_15566694_l.mp3?auth_key=9509549247dea67702424bafdc5a93f4-1442966400-0-null"
// 	["lyric"]=>
// 		string(58) "http://img.xiami.net/lyric/1/1773346501_14056804704181.lrc"
// }

//$musicByUrl = $xiami->getDownloadByUrl("http://www.xiami.com/song/1774621640");
//var_dump($musicByUrl);
// array(2) {
// 	["src"]=>
// 		string(129) "http://m5.file.xiami.com/21/2021/2100181568/1774621640_58823620_l.mp3?auth_key=c90ba4ea5841282ed91326c84e71c404-1442966400-0-null"
// 	["lrc"]=>
// 		string(60) "http://img.xiami.net/lyric/40/1774621640_1442846272_3935.lrc"
// }

