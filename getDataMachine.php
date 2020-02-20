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
    $url = "https://api.epiroc.com/certiq/v2/machines/".$machinesId."/info";
    $HEAD_Data = array(
        'X-Auth-Token:'.$AuthToken['userCode'],
        'Ocp-Apim-Subscription-Key:'.$SubscriptionKey
        );
    $POST_Data = array();
    $data = curl($url,$HEAD_Data,$POST_Data);
    $data = json_decode($data,true);
    foreach ($data as $key => $value) {
        echo "<b>Column:</b>$key <b>Value:</b>$value<br>";
    }
    echo "<br>";
}



// let
//     Source = Json.Document(Web.Contents(Text.Combine({"https://api.epiroc.com/certiq/v2/machines/",MachineItemNumber1,"/info"}), [Headers=[#"X-Auth-Token"=XAuthToken, #"Ocp-Apim-Subscription-Key"="8a4c60ba0294482e9b088507aca92ebd"]])),
//     #"Converted to Table" = Record.ToTable(Source),
//     #"Transposed Table" = Table.Transpose(#"Converted to Table"),
//     #"Promoted Headers" = Table.PromoteHeaders(#"Transposed Table", [PromoteAllScalars=true]),
//     #"Changed Type" = Table.TransformColumnTypes(#"Promoted Headers",{{"machineItemNumber", Int64.Type}, {"machineId", Int64.Type}, {"machineName", type text}, {"machineCompany", type text}, {"machineSite", type text}, {"machineType", type text}, {"machineModel", type text}, {"machineLatitude", type number}, {"machineLongitude", type number}, {"machineTimeZone", type text}, {"machineLastContact", type datetime}, {"machineLastData", type datetime}})
// in
//     #"Changed Type"

// let
//     Source = Json.Document(Web.Contents(Text.Combine({"https://api.epiroc.com/certiq/v2/machines/",MachineItemNumber1,"/alarmStatus"}), [Headers=[#"X-Auth-Token"=XAuthToken, #"Ocp-Apim-Subscription-Key"="8a4c60ba0294482e9b088507aca92ebd"]])),
//     #"Converted to Table" = Table.FromList(Source, Splitter.SplitByNothing(), null, null, ExtraValues.Error),
//     #"Expanded Column1" = Table.ExpandRecordColumn(#"Converted to Table", "Column1", {"alarmId", "alarmName", "alarmDescription", "alarmNodeIndex", "alarmLevel", "alarmTime", "alarmValue"}, {"alarmId", "alarmName", "alarmDescription", "alarmNodeIndex", "alarmLevel", "alarmTime", "alarmValue"}),
//     #"Changed Type" = Table.TransformColumnTypes(#"Expanded Column1",{{"alarmTime", type datetime}}),
//     #"Added Custom" = Table.AddColumn(#"Changed Type", "MachineItemNumber", each MachineItemNumber1)
// in
//     #"Added Custom"
?>