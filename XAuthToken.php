<?php

function xAuth(){
include('config/db.php');
include('_CURL.php');

// Setup Curl
$url = "https://api.epiroc.com/certiq/v2/authentication/login?username=$Username&password=$Password";
$HEAD_Data = array('Ocp-Apim-Subscription-Key:'.$SubscriptionKey);
$POST_Data = array();
$data = curl($url,$HEAD_Data,$POST_Data);
$data = json_decode($data,true);
return $data;
}

$AuthToken = xAuth();
// echo $AuthToken['userCode'];
?>