<?php
/**
 * Created by PhpStorm.
 * User: ganl
 * Date: 2017/8/3
 * Time: 21:26
 */

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
        echo $output;
    }
}else{
    header('Location: http://www.austgl.com/b');
}

