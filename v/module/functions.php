<?php
function getContents($url) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        @ $data = curl_exec($ch);
        curl_close($ch);
        return $data;
}
function get_content($url,$refer) {
        if (function_exists('file_get_contents')) {
                $data = file_get_contents($url);
        } else {
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                $c = curl_init();
                $timeout = 30;
                curl_setopt($c, CURLOPT_URL, $url);
                curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($c, CURLOPT_CONNECTTIMEOUT, $timeout);
				curl_setopt ($c, CURLOPT_REFERER,$refer); 
                curl_setopt($c, CURLOPT_USERAGENT, $user_agent);
                $data = curl_exec($c);
                curl_close($c);
        }
        return $data;
}
?>