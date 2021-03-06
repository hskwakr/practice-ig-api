<?php

namespace Ig_Api;

use Exception;
use Ig_Api\Ig_Api_Query;
use Ig_Api\Http_Client;

/**
 * Class Ig_Api_Context
 */
class Ig_Api_Context
{
    private $access_token;
    private $http_client;
    private $query;

    public $fb_api_base = 'https://graph.facebook.com/v12.0';

    /**
     * @param $dependencies
     */
    public function __construct(Http_Client $http_client, string $token)
    {
        $this->http_client = $http_client;
        $this->access_token = $token;

        require_once 'Ig_Api_Query.php';
        $this->query = new Ig_Api_Query($this->fb_api_base, $token);
    }

    // For DEBUG
    public function printJson($json)
    {
        echo '<pre>';
        echo json_encode($json, JSON_PRETTY_PRINT);
        echo '</pre>';
    }

    public function sendRequest($query)
    {
        return $this->http_client->sendRequest($query);
    }

    public function getUserPagesId()
    {
        $response = $this->sendRequest($this->query->getUserPages());

        if (isset($response->error)) {
            $this->error(
                $response->error,
                'Failed to get user pages'
            );
        }

        return $response->data[0]->id;
    }

    public function getIgUserId($pageId)
    {
        $response = $this->sendRequest($this->query->getIgUser($pageId));

        if (isset($response->error)) {
            $this->error(
                $response->error,
                'Failed to get user id'
            );
        }

        return $response->instagram_business_account->id;
    }

    public function searchHashtagId($userId, $hashtag)
    {
        $response = $this->sendRequest($this->query->searchHashtag($userId, $hashtag));

        if (isset($response->error)) {
            $this->error(
                $response->error,
                'Failed to search hashtag id'
            );
        }

        return $response->data[0]->id;
    }

    public function getRecentMediasByHashtag($userId, $hashtagId)
    {
        $response = $this->sendRequest($this->query->getRecentMediasByHashtag($userId, $hashtagId));

        if (isset($response->error)) {
            $this->error(
                $response->error,
                'Failed to get recent medias by hashtag'
            );
        }

        return $response->data;
    }

    /**
     * Error handling
     * Throw exception with error message
     */
    private function error($error, $msg)
    {
        if (isset($error->message)) {
            throw new Exception(
                $msg . ': ' . $error->message
            );
        } else {
            throw new Exception($msg);
        }
    }
}
