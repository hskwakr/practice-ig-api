<?php

declare(strict_types=1);

namespace Ig_Api;

require_once dirname(__DIR__) . '/src/Ig_Api/Ig_Api.php';
require_once dirname(__DIR__) . '/src/Ig_Api/Http_Client.php';

use PHPUnit\Framework\TestCase;
use Ig_Api\Http_Client;

final class Ig_Api_Test extends TestCase
{
    public function setUp(): void
    {
    }

    public function testGetUserPagesId()
    {
        $expected = '105319938693739';

        // fake access token
        $token = 'this_is_fake_token';

        // fake response
        $response = json_decode(
            '{ "data" : [{ "id" : "' . $expected . '" }] }'
        );

        // fake http client
        $http = $this->createMock(Http_Client::class);
        $http->method('sendRequest')->willReturn($response);

        $api = new Ig_Api($http, $token);
        $this->assertSame($expected, $api->getUserPagesId());
    }
}
