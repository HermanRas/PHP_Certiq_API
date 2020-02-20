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
$StartDate = $StartDate->format('2018-m-1');
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
    $url = $BaseURL.$machinesId."/serviceHistory?start=$StartDate&end=$StopDate";
    $HEAD_Data = array(
        'X-Auth-Token:'.$AuthToken['userCode'],
        'Ocp-Apim-Subscription-Key:'.$SubscriptionKey
        );
    $POST_Data = array();
    $data = curl($url,$HEAD_Data,$POST_Data);
    $data = json_decode($data,true);
    foreach ($data['data'] as $rec) {
        $sql = "INSERT INTO [dbo].[ServiceHistory]
                    (ItemNumber,
                    Id,
                    Accumulator,
                    Interval,
                    Description,
                    Type,
                    NodeIndex,
                    ReportedDate,
                    Status) 
                VALUES
                    ('".$machinesId."',
                    '".$rec["serviceId"]."',
                    '".$rec["serviceAccumulator"]."',
                    '".$rec["serviceInterval"]."',
                    '".$rec["serviceDescription"]."',
                    '".$rec["serviceType"]."',
                    '".$rec["serviceNodeIndex"]."',
                    '".$rec["serviceReportedDate"]."',
                    '".$rec["serviceStatus"]."');";

            $sqlargs = array();
            require_once 'config/db_query.php'; 
            sqlQuery($sql,$sqlargs);
    }
}
?>