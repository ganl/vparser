
function GetRequest() {
    var url = location.search;
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for (var i = 0; i < strs.length; i++) {
            theRequest[strs[i].split("=")[0]] = (strs[i].split("=")[1]);
        }
    }
    return theRequest;
}

function isPC() {
    var sUserAgent = navigator.userAgent.toLowerCase();
    var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
    var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
    var bIsMidp = sUserAgent.match(/midp/i) == "midp";
    var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
    var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
    var bIsAndroid = sUserAgent.match(/android/i) == "android";
    var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
    var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";

    if (!(bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM)) {
        return true;
    } else {
        return false;
    }
}

function ckplayer_status() {
    // console.log(arguments[0]);
}

function do_nothing(){

}


function loadedHandler(){
    if(CKobject.getObjectById('ck_player').getType()){//说明使用html5播放器
        CKobject.getObjectById('ck_player').addListener('play',playHandler);
        // CKobject.getObjectById('ck_player').addListener('pause',pauseHandler);
    }
    else{
        CKobject.getObjectById('ck_player').addListener('play','playHandler');
        // CKobject.getObjectById('ck_player').addListener('pause','pauseHandler');
    }

    CKobject.getObjectById('ck_player').addListener('time','timeHandler');

}

function playHandler(){
    setAdnone();
    if(frontHtime) {
        return;
    }
    if(firstTime){
        CKobject.getObjectById('ck_player').videoPause();
        CKobject._K_('austgl_ad').style.display='block';
        CKobject._K_('austgl_ad_area_start').style.display='block';
        firstTime = false;
        settime();
        if(CKobject.getObjectById('ck_player').getType()) {//html5
            // CKobject.getObjectById('ck_player').removeListener('play', playHandler);
            CKobject.getObjectById('ck_player').addListener('pause',pauseHandler);
        }else{
            // CKobject.getObjectById('ck_player').removeListener('play', 'playHandler');
            CKobject.getObjectById('ck_player').addListener('pause','pauseHandler');
        }

    }else{
        CKobject._K_('austgl_ad').style.display='none';
    }
}

function pauseHandler(){
    setAdnone();
    CKobject._K_('austgl_ad').style.display='block';
    CKobject._K_('austgl_ad_area_pause').style.display='block';
    CKobject._K_('austgl_ad').className='austgl_ad';
}

function playerstop(){
    setAdnone();
    CKobject._K_('austgl_ad').style.display='block';
    // setTimeend();
    // CKobject._K_('austgl_djs').innerHTML=15;
    CKobject._K_('austgl_daojs').style.display='none';
    CKobject._K_('austgl_ad_area_stop').className='austgl_ad_bg';
    CKobject._K_('austgl_ad_area_stop').style.display='block';
}

var frontTime=false;//前置广告倒计时是否在运行中
var frontHtime=false;//后置广告是否在进行中
var firstTime = true;

function settime(){//前置广告倒计时
    var nowT=parseInt(CKobject._K_('austgl_djs').innerHTML);
    if(nowT>0){
        frontTime=true;
        CKobject._K_('austgl_djs').innerHTML=nowT-1;
        setTimeout('settime()',1000)
    }
    else{
        frontTime=false;
        CKobject._K_('austgl_ad').style.display='none';
        CKobject._K_('austgl_daojs').style.display='none';
        CKobject.getObjectById('ck_player').videoPlay();
    }
}

function setTimeend(){//后置广告倒计时
    var nowT=parseInt(CKobject._K_('austgl_djs').innerHTML);
    if(nowT>0){
        CKobject._K_('austgl_djs').innerHTML=nowT-1;
        setTimeout('setTimeend()',1000)
    }
    else{
        CKobject._K_('austgl_ad').style.display='none';
    }
}
