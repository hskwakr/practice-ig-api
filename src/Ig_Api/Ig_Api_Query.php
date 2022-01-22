<?php

namespace Ig_Api;

/**
 * Class Ig_Api_Query
 */
class Ig_Api_Query
{
    private $access_token;
    private $fb_api_base;

    /**
     * @param $dependencies
     */
    public function __construct($api_base, $token)
    {
        $this->fb_api_base = $api_base;
        $this->access_token = $token;
    }

    public function getUserPages()
    {
        $endpoint = '/me/accounts?';
        $options =
        'access_token=' . $this->access_token;

        $query = $this->fb_api_base . $endpoint . $options;
        return $query;
    }

    public function getIgUser($pageId)
    {
        $endpoint = '/' . $pageId . '?';
        $options =
        'access_token=' . $this->access_token .
        '&fields=instagram_business_account';

        $query = $this->fb_api_base . $endpoint . $options;
        return $query;
    }

    public function searchHashtag($userId, $hashtag)
    {
        $endpoint = '/ig_hashtag_search?';
        $options =
        'access_token=' . $this->access_token .
        '&user_id=' . $userId .
        '&q=' . $hashtag;

        $query = $this->fb_api_base . $endpoint . $options;
        return $query;
    }

    public function getRecentMediasByHashtag($userId, $hashtagId)
    {
        $endpoint = '/' . $hashtagId . '/recent_media?';
        $options =
        'access_token=' . $this->access_token .
        '&user_id=' . $userId .
        '&fields=media_type,media_url,permalink';

        $query = $this->fb_api_base . $endpoint . $options;
        return $query;
    }
}
