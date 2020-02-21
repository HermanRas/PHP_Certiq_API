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
$StartDate = $StartDate->format('Y-m-1');
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
    $url = $BaseURL.$machinesId."/alarmHistory?start=$StartDate&end=$StopDate";
    $HEAD_Data = array(
        'X-Auth-Token:'.$AuthToken['userCode'],
        'Ocp-Apim-Subscription-Key:'.$SubscriptionKey
        );
    $POST_Data = array();
    $data = curl($url,$HEAD_Data,$POST_Data);
    $data = json_decode($data,true);
    foreach ($data['data'] as $rec) {
        $sql = "INSERT INTO [dbo].[AlarmStatusHistory]
                (ItemNumber,
                AlarmId,
                Name,
                Description,
                NodeIndex,
                Level,
                Time,
                Value,
                AcknowledgedBy) 
            VALUES
                ('".$machinesId."',
                '".$rec["alarmId"]."',
                '".$rec["alarmName"]."',
                '".$rec["alarmDescription"]."',
                '".$rec["alarmNodeIndex"]."',
                '".$rec["alarmLevel"]."',
                '".$rec["alarmTime"]."',
                '".$rec["alarmValue"]."',
                '".$rec["alarmAcknowledgedBy"]."');";

        $sqlargs = array();
        require_once 'config/db_query.php'; 
        sqlQuery($sql,$sqlargs);
    }
}
?>