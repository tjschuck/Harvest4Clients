<?php
function getData($url)
{
    global $credentials;
    $headers = array(
        "Content-type: application/xml",
        "Accept: application/xml",
        "Authorization: Basic " . base64_encode($credentials)
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_USERAGENT, "JKWD site");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '0');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function firstOfMonth() {
    return date("Ymd", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
}

function lastOfMonth() {
    return date("Ymd", strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
}

function __($key)
{
    global $lang;
    if(key_exists($key, $lang))
    {
        return $lang[$key];
    }
    else
    {
        return $key;
    }
}