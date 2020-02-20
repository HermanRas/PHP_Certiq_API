<?php

include('config/db.php');
include('XAuthToken.php');

$machines = array(
    '8999185700',
    '8999123700',
    '8999123800',
    '8999247000',
    '8999208300'
);

//setup Start Parameters
$StartDate = new DateTime();
$StartDate = $StartDate->format('Y-m-19');
if(isset($_GET['StartDate'])){
    $StartDate = $_GET['StartDate'];   
};


//setup Stop Parameters
$StopDate = new DateTime();
$StopDate = $StopDate->format('Y-m-t');
if(isset($_GET['StartDate'])){
  $StartDate = $_GET['StartDate'];   
};

foreach ($machines as $machinesId) {
    $url = "https://api.epiroc.com/certiq/v2/machines/".$machinesId."/alarmHistory?start=$StartDate&end=$StopDate";
    $HEAD_Data = array(
        'X-Auth-Token:'.$AuthToken['userCode'],
        'Ocp-Apim-Subscription-Key:'.$SubscriptionKey
        );
    $POST_Data = array();
    $data = curl($url,$HEAD_Data,$POST_Data);
    $data = json_decode($data,true);
    foreach ($data['data'] as $rec) {
        echo "<b>Column:</b>ItemNumber <b>Value:</b>$machinesId<br>";
        foreach ($rec as $key => $value) {
            echo "<b>Column:</b>$key <b>Value:</b>$value<br>";
        }
        echo "<br>";
    }
    echo "<br>";
}
?>