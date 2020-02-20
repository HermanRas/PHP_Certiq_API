<?php
function curl($URL,$HEAD_Data,$POST_Data){

    if(count($POST_Data)>0){
        // Initiate curl POST CALL


    return "POST NOT SET";
        }else {
        // Initiate curl GET CALL
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
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $HEAD_Data);
        // Execute
        $Data=curl_exec($ch);
        // Closing
        curl_close($ch);
        return $Data;
        }
}

?>