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

foreach ($machines as $machinesId) {
    $url = $BaseURL.$machinesId."/serviceStatus?";
    $HEAD_Data = array(
        'X-Auth-Token:'.$AuthToken['userCode'],
        'Ocp-Apim-Subscription-Key:'.$SubscriptionKey
        );
    $POST_Data = array();
    $data = curl($url,$HEAD_Data,$POST_Data);
    $data = json_decode($data,true);
    foreach ($data as $rec) {
        echo "<b>Column:</b>ItemNumber <b>Value:</b>$machinesId<br>";
        foreach ($rec as $key => $value) {
            echo "<b>Column:</b>$key <b>Value:</b>$value<br>";
        }
        echo "<br>";
    }
    echo "<br>";
}
?>