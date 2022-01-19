<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/src/Ig_Api.php';
require_once dirname(__DIR__) . '/src/Http_Client.php';

use PHPUnit\Framework\TestCase;

final class Ig_Api_Test extends TestCase
{
    private $api;
    private $stub;

    public function setUp(): void
    {
        // init stub for http client
        $this->stub = $this->createStub(Http_Client::class);

        // fake access token
        $token = 'this_is_fake_token';

        $this->api = new Ig_Api($token);
    }
}
