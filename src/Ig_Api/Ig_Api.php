<?php

namespace Ig_Api;

require_once 'Ig_Api_Context.php';
require_once 'Http_Client.php';
use Ig_Api\Ig_Api_Context;
use Ig_Api\Http_Client;

/**
 * Class Ig_Api
 */
class Ig_Api
{
    // instagram api context
    private $ctx;

    // error massage from api
    public $error;
    // user pages id for facebook pages
    public $pages_id;
    // user id for instagram business account
    public $user_id;
    // hashtag id in instagram
    public $hashtag_id;
    // recent medias that has specific hashtag in instagram
    public $recent_medias;

    public function __construct(string $token)
    {
        $http = new Http_Client();
        $this->ctx = new Ig_Api_Context($http, $token);
    }

    /**
     * Set a context of instagram api.
     * This function is for test mostly.
     * This function should be called before calling any methods.
     *
     * @return a instance of this class
     */
    public function setContext($ctx)
    {
        $this->ctx = $ctx;
        return $this;
    }

    /**
     * Init facebook graph api.
     *
     * @return a instance of this class
     */
    public function init()
    {
        // Ignore error
        if (!empty($this->error)) {
            $this->error = null;
        }

        // Get user pages id for facebook pages
        $this->pages_id = $this->ctx
                               ->getUserPagesId();
        // error handling
        if (isset($this->pages_id->error)) {
            $this->error = $this->pages_id->error;
            return $this;
        }

        // Get user id for instagram business account
        $this->user_id = $this->ctx
                              ->getIgUserId($this->pages_id);
        // error handling
        if (isset($this->user_id->error)) {
            $this->error = $this->user_id->error;
            return $this;
        }

        return $this;
    }

    /**
     * Search recent medias by a name of hashtag in instagram.
     * And store the result of medias in array.
     *
     * @return a instance of this class
     */
    public function searchHashtag(string $name)
    {
        // if it has already error, return
        if (!empty($this->error)) {
            return $this;
        }

        // Get hashtag id in instagram by hashtag name
        $this->hashtag_id =
            $this->ctx
                 ->searchHashtagId($this->user_id, $name);
        // error handling
        if (isset($this->hashtag_id->error)) {
            $this->error = $this->hashtag_id->error;
            return $this;
        }

        // Get recent medias that has specific hashtag in instagram
        $this->recent_medias =
            $this->ctx
                 ->getRecentMediasByHashtag(
                     $this->user_id,
                     $this->hashtag_id
                 );
        // error handling
        if (isset($this->recent_medias->error)) {
            $this->error = $this->recent_medias->error;
            return $this;
        }

        return $this;
    }
}
