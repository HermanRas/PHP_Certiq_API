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
    $url = $BaseURL.$machinesId."/machineAccumulators";
    $HEAD_Data = array(
        'X-Auth-Token:'.$AuthToken['userCode'],
        'Ocp-Apim-Subscription-Key:'.$SubscriptionKey
        );
    $POST_Data = array();
    $data = curl($url,$HEAD_Data,$POST_Data);    
    $data = json_decode($data,true);

    foreach ($data as  $key => $rec) {
        // if Rec has Node
        if (count($rec['nodes'])!== 0){
            // Select Top 1000
            //   nodes.ID,
            //   nodes.nodeIndex,
            //   nodes.value,
            //   nodes.timeStamp
            // From
            //   nodes
            $sql = "INSERT INTO [dbo].[nodes]
                     (nodeIndex,
                      value,
                      timeStamp) 
                    VALUES
                     ('".$rec['nodes'][0]["nodeIndex"]."',
                     '".$rec['nodes'][0]["value"]."',
                     '".$rec['nodes'][0]["timeStamp"]."');";

            $sqlargs = array();
            require_once 'config/db_query.php'; 
            sqlQuery($sql,$sqlargs);

            // Get last Node ID for KPI
            $sql = "SELECT TOP 1 [MRPSolutionDB].[dbo].[nodes].ID 
                    FROM [MRPSolutionDB].[dbo].[nodes]
                    ORDER BY ID DESC";
            require_once 'config/db_query.php'; 
            $nodeID = sqlQuery($sql,$sqlargs);
            $nodeID = $nodeID[0][0]["ID"];
        }else{
            $nodeID = '';
        }
        
        //   CumulativeKPIs.Nodes,
        //   CumulativeKPIs.Description,
        //   CumulativeKPIs.value,
        //   CumulativeKPIs.MachineID,
        //   CumulativeKPIs.timeStamp
        // From
        //   CumulativeKPIs

        $sql = "INSERT INTO [dbo].[CumulativeKPIs]
                    (Nodes,
                    Description,
                    value,
                    MachineID,
                    timeStamp) 
                VALUES
                    ('". $nodeID ."',
                    '". $key ."',
                    '".$rec["totalValue"]."',
                    '".$machinesId."',
                    '".$rec ["timeStamp"]."');";

            $sqlargs = array();
            require_once 'config/db_query.php'; 
            sqlQuery($sql,$sqlargs);
    }
}
?>