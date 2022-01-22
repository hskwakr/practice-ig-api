<?php

namespace Ig_Api;

/**
 * Class Http_Client
 */
class Http_Client
{
    public function sendRequest($query)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $query);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }
}
