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
    $url = $BaseURL.$machinesId."/info";
    $HEAD_Data = array(
        'X-Auth-Token:'.$AuthToken['userCode'],
        'Ocp-Apim-Subscription-Key:'.$SubscriptionKey
        );
    $POST_Data = array();
    $data = curl($url,$HEAD_Data,$POST_Data);
    $data = json_decode($data,true);
    $sql = "INSERT INTO [dbo].[Machine]
            (Id,
                ItemNumber,
                Name,
                Company,
                Site,
                Type,
                Model,
                Latitude,
                Longitude,
                TimeZone,
                LastContact,
                LastData) 
            VALUES
                ('".$data["machineItemNumber"]."',
                '".$data["machineId"]."',
                '".$data["machineName"]."',
                '".$data["machineCompany"]."',
                '".$data["machineSite"]."',
                '".$data["machineType"]."',
                '".$data["machineModel"]."',
                '".$data["machineLatitude"]."',
                '".$data["machineLongitude"]."',
                '".$data["machineTimeZone"]."',
                '".$data["machineLastContact"]."',
                '".$data["machineLastData"]."');";

        $sqlargs = array();
        require_once 'config/db_query.php'; 
        sqlQuery($sql,$sqlargs);
}
?>