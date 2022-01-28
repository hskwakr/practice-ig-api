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

    // user pages id for facebook pages
    public $pages_id;
    // user id for instagram business account
    public $user_id;

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
        $this->pages_id = $this->ctx->getUserPagesId();
        $this->user_id = $this->ctx->getIgUserId($this->pages_id);

        return $this;
    }
}
