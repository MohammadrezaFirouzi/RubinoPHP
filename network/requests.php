<?php

require_once('exception.php');



function getServer()
{
    return "https://rubino" . rand(3, 6) . ".iranlms.ir";
}

function request($data)
{

    $head = array(
        "Accept-Encoding: gzip",
        "Connection: Keep-Alive",
        "User-Agent: okhttp/3.12.1",
        "Referer: https://web.rubika.ir/",
        "Content-Type: application/json; charset=utf-8",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, getServer());
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $result = json_decode($response, true);

    if ($status == 200) {
        if($result['status_det'] == "OK"){
            return $result;
        }
        else{
            $exceptionsMapping = [
                "INVALID_AUTH" => new InvalidAuth(),
                "NOT_REGISTERED" => new NotRegistered(),
                "INVALID_INPUT" => new InvalidInput(),
                "TOO_REQUESTS" => new TooRequests(),
            ];
            
            if (array_key_exists($result["status_det"], $exceptionsMapping)) {
                throw $exceptionsMapping[$result["status_det"]];
            } else {
                throw new Exception("Unknown status detail.");
            }
        }
        
        
    } else {

        
    }
}
