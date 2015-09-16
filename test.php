<?php
error_reporting(E_ALL);
require_once './src/vparser.php';

$yyt = Vparser::load(Vparser::MODULE_YINYUETAI);

//http://v.yinyuetai.com/video/2371147?f=SY-MKDT-MVSB-1
$video = $yyt->getDownloadById('2371147');
echo '<pre>';
var_dump($video);
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