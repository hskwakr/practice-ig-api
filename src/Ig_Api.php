<?php

/**
 * Class Ig_Api
 */
class Ig_Api
{
    private $access_token;
    private $http_client;
    private $query;

    public $fb_api_base = 'https://graph.facebook.com/v12.0';

    /**
     * @param $dependencies
     */
    public function __construct($http_client, $token)
    {
        $this->http_client = $http_client;
        $this->access_token = $token;

        require_once('Ig_Api_Query.php');
        $this->query = new Ig_Api_Query($http_client, $token);
    }

    // For DEBUG
    public function printJson($json)
    {
        echo '<pre>';
        echo json_encode($json, JSON_PRETTY_PRINT);
        echo '</pre>';
    }

    private function sendRequest($query)
    {
        return $this->http_client->sendRequest($query);
    }
}
