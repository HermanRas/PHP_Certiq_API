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
    $url = $BaseURL.$machinesId."/alarmStatus";
    $HEAD_Data = array(
        'X-Auth-Token:'.$AuthToken['userCode'],
        'Ocp-Apim-Subscription-Key:'.$SubscriptionKey
        );
    $POST_Data = array();
    $data = curl($url,$HEAD_Data,$POST_Data);
    $data = json_decode($data,true);

    foreach ($data as $rec) {
    $sql = "INSERT INTO [dbo].[AlarmStatus]
            (   ItemNumber,
                Id,
                Name,
                Description,
                NodeIndex,
                Level,
                Time,
                Value) 
        VALUES
            ('".$machinesId."',
            '".$rec["alarmId"]."',
            '".$rec["alarmName"]."',
            '".$rec["alarmDescription"]."',
            '".$rec["alarmNodeIndex"]."',
            '".$rec["alarmLevel"]."',
            '".$rec["alarmTime"]."',
            '".$rec["alarmValue"]."');";

        $sqlargs = array();
        require_once 'config/db_query.php'; 
        sqlQuery($sql,$sqlargs);
    }
}
?>