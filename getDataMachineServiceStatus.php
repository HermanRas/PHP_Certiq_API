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
        $sql = "INSERT INTO [dbo].[ServiceStatus]
                    (ItemNumber,
                    Id,
                    Accumulator,
                    Interval,
                    Description,
                    Type,
                    NodeIndex,
                    PredictedDate,
                    hoursLeftToService,
                    Status) 
                VALUES
                    ('".$machinesId."',
                    '".$rec["serviceId"]."',
                    '".$rec["serviceAccumulator"]."',
                    '".$rec["serviceInterval"]."',
                    '".$rec["serviceDescription"]."',
                    '".$rec["serviceType"]."',
                    '".$rec["serviceNodeIndex"]."',
                    '".$rec["servicePredictedDate"]."',
                    '".$rec["hoursLeftToService"]."',
                    '".$rec["serviceStatus"]."');";

            $sqlargs = array();
            require_once 'config/db_query.php'; 
            sqlQuery($sql,$sqlargs);
    }
}
?>