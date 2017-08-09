<?php
/**
 * Created by PhpStorm.
 * User: ganl
 * Date: 2017/8/3
 * Time: 21:26
 */
error_reporting(0);

$url = $_GET['id'];
if($url && $url != ""){
//    var_dump( shell_exec('you-get -u ''.$url.' --json') );
//    $cmd = escapeshellcmd('you-get -u "'.$url.'" --json 2 > log.txt');
    setlocale(LC_CTYPE, 'en_US.UTF-8');
    putenv('LC_ALL=en_US.UTF-8');
    $cmd = ('you-get -u "'.$url.'" --json');
//    exec($cmd, $output, $ret);
    $output = shell_exec($cmd);
    if($output) {
        $info = json_decode($output, true);
        $data = array();
        switch ($info['site']){
            case '优酷 (Youku)':
                $types = array();
                foreach ($info['streams'] as $key => $stream){
                    $types[] = $key;
                }
                $xhcs = count($types)-1;
                $vtype = $types[$xhcs];

                $data['audio_lang'] = $info['audiolang'][0]['lang'];
                $data['clear'] = $info['streams'][$vtype]['video_profile'];
                $data['duration'] = 0;
                $data['title'] = $info['title'];
                $data['size'] = $info['streams'][$vtype]['size'];

                foreach ($info['streams'][$vtype]['pieces'][0]['segs'] as $k=>$value) {
                    $data['url'][$k]["downlink"] = $value['cdn_url'];
                    $data['url'][$k]["size"] = $value['size'];
                    $data['url'][$k]["ts"] = intval($value['total_milliseconds_video']/1E3);
                    $data['duration'] += $data['url'][$k]["ts"];
                }
                if(isset($_GET['p']) && $_GET['p'] == 'ck'){
                    getckxml($data);
                }else{
                    getcmpxml($data);
                }
                break;
            case 'QQ.com':
                $types = array();
                foreach ($info['streams'] as $key => $stream){
                    $types[] = $key;
                }
                $xhcs = count($types)-1;
                $vtype = $types[$xhcs];

                $data['audio_lang'] = $info['streams'][$vtype]['container'];
                $data['clear'] = $info['streams'][$vtype]['video_profile'];
                $data['duration'] = '';
                $data['title'] = $info['title'];
                $data['size'] = $info['streams'][$vtype]['size'];

                foreach ($info['streams'][$vtype]['src'] as $k => $value) {
                    $data['url'][$k]["downlink"] = $value;
                    $data['url'][$k]["size"] = '';
                    $data['url'][$k]["ts"] = '';
//                    $data['duration'] += $data['url'][$k]["ts"];
                }
                if(isset($_GET['p']) && $_GET['p'] == 'ck'){
                    getckxml($data);
                }else{
                    getcmpxml($data);
                }

                break;
        }
    }
}else{
    header('Location: http://www.austgl.com/b');
}


function getcmpxml($data){
    $merge = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    $merge .='<!--清晰度参数设置：hd=0为flv普清[1M以上宽带],hd=1为mp4高清[2M以上宽带],hd=2为超清[4M以上宽带],hd=3为1080P[8M以上宽带]-->'."\n";
    if ($data["clear"] != "") {
        $merge.='<!--当前清晰度：['.$data["clear"].']-->'."\n";
    }
    $merge.='<m starttype="0" label="ganl" type="flv" bytes="'.$data['size'].'" duration="'.$data["duration"].'" >'."\n";
    foreach ($data["url"] as $k => $value) {
        $merge.='<u duration="'.$value["ts"].'"  bytes="'.$value["size"].'" src="'.$value["downlink"].'" />'."\n";
    }
    $merge.='</m>';

    echo $merge;
}

function getckxml($data){
    $ckxml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    $ckxml .= "<ckplayer>\n";
    if ($data["qxurl"] != "") {
        $ckxml .= "  <flashvars>\n";
        $ckxml .= "{h->3}{a->".$data["qxurl"]."}{defa->".$data["defa"]."}{deft->".$data["deft"]."}{f->".$data["phpself"]."?id=[\$pat]}\n";
        $ckxml .= "  </flashvars>\n";
    }
    if ($data["title"] != "") {
        $ckxml .= "      <filename>\n";
        $ckxml .= "          <![CDATA[".$data["title"]."]]>\n";
        $ckxml .= "      </filename>\n";
    }
    if ($data["clear"] != "") {
        $ckxml .= "      <type>\n";
        $ckxml .= "          <![CDATA[".$data["clear"]."]]>\n";
        $ckxml .= "      </type>\n";
    }
    if ($data["createtime"] != "") {
        $ckxml .= "      <time>\n";
        $ckxml .= "          <![CDATA[".$data["createtime"]."]]>\n";
        $ckxml .= "      </time>\n";
    }
    foreach ($data["url"] as $k => $value) {
        $ckxml .= "  <video>\n";
        $ckxml .= "      <file>\n";
        $ckxml .= "          <![CDATA[".$value["downlink"]."]]>\n";
        $ckxml .= "      </file>\n";
        if ($value["size"] != "") {
            $ckxml .= "      <size>".$value["size"]."</size>\n";
            $ckxml .= "      <seconds>".$value["ts"]."</seconds>\n";
        }
        $ckxml .= "  </video>\n";
    }
    $ckxml .= "</ckplayer>";
    echo $ckxml;
}
