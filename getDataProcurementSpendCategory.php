<?php
function get_data($context,$fromDate,$toDate,$returnJsonOrObj) {
    
        $url = "https://app.gsi-insite.com/insite/procurement-spend-category?token=15a14e55f14315a3edf9962b3d5e23eb2&".
                        "context=$context&".
                        "start-date=$fromDate&".
                        "end-date=$toDate"; - //"1+Jul+2017"

        //  Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //enable debug
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_URL,$url);
        // Execute
        $jason_Data=curl_exec($ch);
        // Closing
        curl_close($ch);
        var_dump($jason_Data);
        $obj_Data = json_decode($jason_Data);
        
        if ($returnJsonOrObj == "OBJ"){ 
            return $obj_Data;
            }else{
            return $jason_Data;    
            }
        }
?>