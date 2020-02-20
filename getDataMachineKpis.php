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
$StopDate = $StopDate->format('Y-m-d');
if(isset($_GET['StartDate'])){
  $StartDate = $_GET['StartDate'];   
};

foreach ($machines as $machinesId) {
    $url = $BaseURL.$machinesId."/kpis/daily?start=$StartDate&end=$StopDate";
    $HEAD_Data = array(
        'X-Auth-Token:'.$AuthToken['userCode'],
        'Ocp-Apim-Subscription-Key:'.$SubscriptionKey
        );
    $POST_Data = array();
    $data = curl($url,$HEAD_Data,$POST_Data);
    $data = json_decode($data,true);
    foreach ($data as $rec) {
        $sql = "INSERT INTO [dbo].[KPIs]
                    (ItemNumber,
                    date,
                    dailyDrillHours,
                    dailyDrillMeters,
                    dailyDrillMetersPerEngineHour,
                    dailyDrillMetersPerDrillHour,
                    dailyDrillHoursPerEngineHour,
                    dailyDrillHoles,
                    dailyFuelLiters,
                    dailyFuelLitersPerHour,
                    dailyFuelCO2Emission,
                    dailyFuelLitersPerTonnes,
                    dailyFuelLitersPerMeter,
                    dailyLoadingTonnes,
                    dailyLoadingTonnesPerHour,
                    dailyLoadingNumberOfBuckets,
                    dailyLoadingTonnesPerBucket,
                    dailyLoadingNumberOfBoxes,
                    dailyLoadingTonnesPerBox,
                    dailyUtilizationAvailableHours,
                    dailyUtilizationWorkedHours,
                    dailyUtilizationDrillHours,
                    dailyUtilizationHydraulicPumpHours,
                    dailyUtilizationTrammingHours,
                    dailyUtilizationIdleHours,
                    dailyUtilizationEngineHours) 
                VALUES
                    ('".$machinesId."',
                    '".$rec["date"]."',
                    '".$rec["dailyDrillHours"]."',
                    '".$rec["dailyDrillMeters"]."',
                    '".$rec["dailyDrillMetersPerEngineHour"]."',
                    '".$rec["dailyDrillMetersPerDrillHour"]."',
                    '".$rec["dailyDrillHoursPerEngineHour"]."',
                    '".$rec["dailyDrillHoles"]."',
                    '".$rec["dailyFuelLiters"]."',
                    '".$rec["dailyFuelLitersPerHour"]."',
                    '".$rec["dailyFuelCO2Emission"]."',
                    '".$rec["dailyFuelLitersPerTonnes"]."',
                    '".$rec["dailyFuelLitersPerMeter"]."',
                    '".$rec["dailyLoadingTonnes"]."',
                    '".$rec["dailyLoadingTonnesPerHour"]."',
                    '".$rec["dailyLoadingNumberOfBuckets"]."',
                    '".$rec["dailyLoadingTonnesPerBucket"]."',
                    '".$rec["dailyLoadingNumberOfBoxes"]."',
                    '".$rec["dailyLoadingTonnesPerBox"]."',
                    '".$rec["dailyUtilizationAvailableHours"]."',
                    '".$rec["dailyUtilizationWorkedHours"]."',
                    '".$rec["dailyUtilizationDrillHours"]."',
                    '".$rec["dailyUtilizationHydraulicPumpHours"]."',
                    '".$rec["dailyUtilizationTrammingHours"]."',
                    '".$rec["dailyUtilizationIdleHours"]."',
                    '".$rec["dailyUtilizationEngineHours"]."');";

            $sqlargs = array();
            require_once 'config/db_query.php'; 
            sqlQuery($sql,$sqlargs);
    }
}
?>