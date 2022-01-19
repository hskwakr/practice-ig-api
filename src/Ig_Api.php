<?php

/**
 * Class Ig_Api
 */
class Ig_Api
{
    private $access_token;
    private $http_client;

    public $fb_api_base = 'https://graph.facebook.com/v12.0';

    /**
     * @param $dependencies
     */
    public function __construct($http_client, $token)
    {
        $this->http_client = $http_client;
        $this->access_token = $token;
    }

    // For DEBUG
    public function printJson($json)
    {
        echo '<pre>';
        echo json_encode($json, JSON_PRETTY_PRINT);
        echo '</pre>';
    }

    /**
     * Initialize instagram api and get the id of instagram account.
     */
    public function init()
    {
        // get the user's pages
        $userPages = getUserPages();
        //printJson($userPages);

        // capture the page id
        $pageId = $userPages->data[0]->id;
        //echo $pageId;

        // get the page's instagram business account
        $igUser = getIgUser($pageId);
        //printJson($igUser);

        // capture the connected ig user id
        $igUserId = $igUser->instagram_business_account->id;
        //echo $igUserId;
    }

    private function sendRequest($query)
    {
        return $this->http_client->sendRequest($query);
    }

    private function getUserPages()
    {
        $endpoint = '/me/accounts?';
        $options =
        'access_token=' . $this->access_token;

        $query = $this->fb_api_base . $endpoint . $options;
        //echo $query;
        return sendRequest($query);
    }

    private function getIgUser($pageId)
    {
        $endpoint = '/' . $pageId . '?';
        $options =
        'access_token=' . $this->access_token .
        '&fields=instagram_business_account';

        $query = $this->fb_api_base . $endpoint . $options;
        //echo $query;
        return sendRequest($query);
    }

    private function getIgMedia($userId)
    {
        $endpoint = '/' . $userId . '/media?';
        $options =
        'access_token=' . $this->access_token;

        $query = $this->fb_api_base . $endpoint . $options;
        //echo $query;
        return sendRequest($query);
    }


    private function searchHashtag($userId, $hashtag)
    {
        $endpoint = '/ig_hashtag_search?';
        $options =
        'access_token=' . $this->access_token .
        '&user_id=' . $userId .
        '&q=' . $hashtag;

        $query = $this->fb_api_base . $endpoint . $options;
        //echo $query;
        return sendRequest($query);
    }

    private function getRecentMediasByHashtag($userId, $hashtagId)
    {
        $endpoint = '/' . $hashtagId . '/recent_media?';
        $options =
        'access_token=' . $this->access_token .
        '&user_id=' . $userId .
        '&fields=media_type,media_url,permalink';

        $query = $this->fb_api_base . $endpoint . $options;
        //echo $query;
        return sendRequest($query);
    }
}
