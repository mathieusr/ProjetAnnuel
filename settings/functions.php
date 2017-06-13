<?php
function randowkey($lenght){
    $key = "AZERTYUIOPQSDFGHJKLMWXCVBNazertyuiopqsdfghjklmwxcvbn123456789_";
    $key = str_repeat($key,$lenght);
    $key = str_shuffle($key);
    $key = substr($key,0,$lenght);
    return $key;


}
function sendmail($to,$subject,$message,$from = 'Loup de paris'){
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: '.$from.' '. "\r\n";
    mail($to,$subject,$message,$headers);
}