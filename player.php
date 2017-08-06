<?php
/**
 * Created by PhpStorm.
 * User: ganl
 * Date: 2017/8/4
 * Time: 22:32
 */

/**
 * vparser/player.php?ad=0&url=http://img.ksbbs.com/asset/Mon_1703/d30e02a5626c066.mp4
 * vparser/player.php?ad=0&url=http://www.flashls.org/playlists/test_001/stream_1000k_48k_640x360.m3u8
 * vparser/player.php?ad=1&url=http://v.youku.com/v_show/id_XMjkzNDA5Nzk2OA==.html
 */

error_reporting(0);

$url = $_GET['url'];
$m3u8 = false;
$type = '';

if (preg_match("/\.m3u8/i", $url, $matches)) {
    $type = 'm3u8';
    $m3u8 = true;
}else if (preg_match("/\.mp4/i", $url, $matches)) {
    $type = 'mp4';
} else if(preg_match("/\.flv/i", $url, $matches)){
    $type = 'flv';
}else {
    $type = 'proxy';
}

$auto_play = 1;
$no_ad = false;
if(isset($_GET['auto']) && $_GET['auto'] == '0'){
    $auto_play = 0;
}
if(isset($_GET['ad']) && $_GET['ad'] == '0'){
    $no_ad = true;
}

$proxy = '/vparser/src/faker.php?p=ck&id=[$pat]';

?>

<!DOCTYPE html>
<html lang='zh-CN'>
<head>
    <meta charset="utf-8">
    <title>CMP/CK Video Player (austgl_cmp)</title>
</head>
<style>
html, body, #player_wrap{
        padding:0; margin:0; width:100%; height:100%; display:block; border:0; overflow:hidden;
    }
    body{
    background-color:#000;
    }
    .austgl_relative{position:relative;}
    .austgl_player{
    position: absolute;
    width: 100%;
    height: 100%;
}
    .austgl_ad_bg {
    position: absolute;
    z-index: 10;
        background-color: #000;
        width: 100%;
        height: 100%;
    }
    .austgl_ad {
    position: absolute;
    z-index: 10;
        height: 200px;
        width: 250px;
        margin-top: 60px;
        margin-left: 50%;
        margin-right: 50%;
        left: -100px;
    }
    #austgl_daojs {
        text-align: right;
        background-color: #000;
        padding-right: 20px;
        color: #FFF;
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .austgl_ad_area {
    height: 200px;
    width: 250px;
    margin-right: auto;
        margin-left: auto;
        background-color: #FFFFFF;
    }

</style>
<body>
<div id="player_wrap" class="austgl_relative">
    <div class="austgl_player" id="player"></div>
    <div id="austgl_ad" class="austgl_ad_bg" style="display: none">
        <div id="austgl_daojs">&#x8BF7;&#x7A0D;&#x7B49;&#xFF0C;&#x79BB;&#x5E7F;&#x544A;&#x7ED3;&#x675F;&#x8FD8;&#x6709;<span id="austgl_djs" style="color:#FFDD00">15</span>&#x79D2;</div>
        <div id="austgl_ad_area_start" class="austgl_ad_area" style="display: none">
            <?php
                echo  $austgl_cmp_play_ad;
            ?>
        </div>
        <div id="austgl_ad_area_pause" class="austgl_ad_area" style="display: none">
            <?php
            echo  $austgl_cmp_stop_ad;
            ?>
        </div>
        <div id="austgl_ad_area_stop" class="austgl_ad_area" style="display: none">
            <?php
            echo  $austgl_cmp_finish_ad;
            ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="./ckplayer/jquery.min.js"></script>
<script type="text/javascript" src="./ckplayer/main.js"></script>
<script type="text/javascript" src="./ckplayer/ckplayer.js"></script>
<script type="text/javascript">
    jQuery(function () {

        var flashvars = GetRequest();
//        console.log(flashvars);
//        console.log(window.top.document.title);
//        console.log(window.top.location.href);
        //http://movie.ks.js.cn/flv/other/1_0.mp4

//        if (typeof flashvars.f === 'string') {
//            flashvars.f = flashvars.encode !== 'true' ? encodeURIComponent(flashvars.f) : flashvars.f;
//        } else {
//            flashvars.f = '';
//        }

        //判断是否为m3u8
//        if (flashvars.type === 'm3u8' || flashvars.f.toLocaleLowerCase().lastIndexOf('.m3u8') === flashvars.f.length - 5) {
//            flashvars.m = true;
//        } else {
//            flashvars.m = false;
//        }

        show_player(flashvars);
    });


    var isNumber=false;


    function timeHandler(t){
        if(t>20 && isNumber){
            CKobject.getObjectById('ck_player').videoPause();//暂停播放
            //CKobject.getObjectById('ck_player').removeListener('time','timeHandler');
//            isNumber=false;
            parent.showDialog('&#x53EA;&#x80FD;&#x8BD5;&#x770B;20s&#xFF0C;&#x8BF7;&#x767B;&#x5F55;&#xFF01;', 'notice', "&#x672A;&#x767B;&#x5F55;", jump2login);
        }
    }

    function jump2login() {
        parent.window.location.href='http://www.austgl.com/b/';
    }

    function show_player(flashvar) {
        var flashvars = {
            f: '',
            a: '',//调用时的参数，只有当s>0的时候有效
            s: '0',//调用方式，0=普通方法（f=视频地址），1=网址形式,2=xml形式，3=swf形式(s>0时f=网址，配合a来完成对地址的组装)
            c: '0',//是否读取文本配置,0不是，1是
            x: '',//调用配置文件路径，只有在c=1时使用。默认为空调用的是ckplayer.xml
            i: '',//初始图片地址
            u: '',//暂停时如果是图片的话，加个链接地址
            //l:'http://www.ckplayer.com/down/adv6.1_1.swf|http://www.ckplayer.com/down/adv6.1_2.swf',//前置广告，swf/图片/视频，多个用竖线隔开，图片和视频要加链接地址
            r: '',//前置广告的链接地址，多个用竖线隔开，没有的留空
            //t:'10|10',//视频开始前播放swf/图片时的时间，多个用竖线隔开
            y: '',//这里是使用网址形式调用广告地址时使用，前提是要设置l的值为空
            //z: 'http://www.ckplayer.com/down/buffer.swf',//缓冲广告，只能放一个，swf格式
            e: '0',//视频结束后的动作，0是调用js函数，1是循环播放，2是暂停播放并且不调用广告，3是调用视频推荐列表的插件，4是清除视频流并调用js功能和1差不多，5是暂停播放并且调用暂停广告
            v: '80',//默认音量，0-100之间
            p: '2',//视频默认0是暂停，1是播放，2是不加载视频
            h: '0',//播放http视频流时采用何种拖动方法，=0不使用任意拖动，=1是使用按关键帧，=2是按时间点，=3是自动判断按什么(如果视频格式是.mp4就按关键帧，.flv就按关键时间)，=4也是自动判断(只要包含字符mp4就按mp4来，只要包含字符flv就按flv来)
            q: '',//视频流拖动时参考函数，默认是start
            m: '',//让该参数为一个链接地址时，单击播放器将跳转到该地址
            o: '',//当p=2时，可以设置视频的时间，单位，秒
            w: '',//当p=2时，可以设置视频的总字节数
            g: '',//视频直接g秒开始播放
            j: '',//跳过片尾功能，j>0则从播放多少时间后跳到结束，<0则总总时间-该值的绝对值时跳到结束
            //k: '30|60',//提示点时间，如 30|60鼠标经过进度栏30秒，60秒会提示n指定的相应的文字
            //n: '这是提示点的功能，如果不需要删除k和n的值|提示点测试60秒',//提示点文字，跟k配合使用，如 提示点1|提示点2
            wh: '',//宽高比，可以自己定义视频的宽高或宽高比如：wh:'4:3',或wh:'1080:720'
            lv: '0',//是否是直播流，=1则锁定进度栏
            <?php if(!$no_ad){?>
            loaded: 'loadedHandler',//当播放器加载完成后发送该js函数loaded
            //调用播放器的所有参数列表结束
            <?php }?>
            //以下为自定义的播放器参数用来在插件里引用的
            my_url: encodeURIComponent(window.top.location.href),//本页面地址
            my_title:encodeURIComponent(window.top.document.title)
            //调用自定义播放器参数结束

        };

        //以下是m3u8的播放设置
        <?php if ($m3u8) { ?>
            flashvars.f = '/vparser/ckplayer/m3u8.swf'; //插件路径
            flashvars.a = decodeURIComponent('<?php echo $url;?>');
            flashvars.s = 4;
        <?php } else {?>
            flashvars.f = decodeURIComponent('<?php echo $url;?>');
        <?php }?>

        flashvars.p = '<?php echo $auto_play;?>';
//        flashvars.i = flashvar.i;
//        flashvars.my_pic = flashvar.my_pic;

        <?php if($type == 'proxy'){?>
            flashvars.s = 2;
            flashvars.f = '<?php echo $proxy;?>';
            flashvars.a = decodeURIComponent('<?php echo $url;?>');
        <?php }?>
//        console.log(flashvars);
        var params={bgcolor:"#FFF",allowFullScreen:true,allowScriptAccess:"always",wmode:"transparent"};
        <?php if ($m3u8) { ?>
            var video=[flashvars.a];
            CKobject.embed("ckplayer/ckplayer.swf", "player", "ck_player", "100%", "100%", false, flashvars, video, params);
        <?php } else {?>
            var video=[flashvars.f+"->video/mp4"];
            CKobject.embed("ckplayer/ckplayer.swf", "player","ck_player","100%","100%",false,flashvars,video, params);
        <?php }?>
    }
    function closelights(){parent.showDialog("&#x6682;&#x4E0D;&#x652F;&#x6301;&#x5F00;&#x5173;&#x706F;", "error");}
    function openlights(){parent.showDialog("&#x6682;&#x4E0D;&#x652F;&#x6301;&#x5F00;&#x5173;&#x706F;", "error");}

    function setAdnone() {
        jQuery('.austgl_ad_area').css('display', 'none');
    }



</script>
</body>
</html>