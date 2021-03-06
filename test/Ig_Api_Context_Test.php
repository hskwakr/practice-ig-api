<?php

declare(strict_types=1);

namespace Ig_Api;

require_once dirname(__DIR__) . '/src/Ig_Api/Ig_Api_Context.php';
require_once dirname(__DIR__) . '/src/Ig_Api/Http_Client.php';

use Exception;
use PHPUnit\Framework\TestCase;
use Ig_Api\Http_Client;

final class Ig_Api_Context_Test extends TestCase
{
    private $token;
    private $http;

    public function setUp(): void
    {
        // fake access token
        $this->token = 'this_is_fake_token';

        // fake http client
        $this->http = $this->createMock(Http_Client::class);
    }

    public function testGetUserPagesId()
    {
        $expected = 'this_is_fake_id';

        // fake response
        $response = json_decode(
            '{ "data" : [{ "id" : "'
            . $expected
            . '" }] }'
        );

        // set method return
        $this->http->method('sendRequest')->willReturn($response);

        // init api
        $api = new Ig_Api_Context($this->http, $this->token);

        // assert
        $this->assertSame($expected, $api->getUserPagesId());
    }

    public function testGetUserPagesId_ErrorHandling()
    {
        // fake response
        $response = json_decode(
            '{ "error" : { "message" : "something wrong" } }'
        );

        // set method return
        $this->http->method('sendRequest')->willReturn($response);

        // init api
        $api = new Ig_Api_Context($this->http, $this->token);

        // assert
        $this->expectException(Exception::class);
        $api->getUserPagesId();
    }

    public function testGetIgUserId()
    {
        $expected = 'this_is_fake_user_id';
        $pages_id = 'this_is_fake_pages_id';

        // fake response
        $response = json_decode(
            '{ "instagram_business_account" : { "id" : "'
            . $expected
            . '" } }'
        );

        // set method return
        $this->http->method('sendRequest')->willReturn($response);

        // init api
        $api = new Ig_Api_Context($this->http, $this->token);

        // assert
        $this->assertSame($expected, $api->getIgUserId($pages_id));
    }

    public function testGetIgUserId_ErrorHandling()
    {
        $pages_id = 'this_is_fake_pages_id';

        // fake response
        $response = json_decode(
            '{ "error" : { "message" : "something wrong" } }'
        );

        // set method return
        $this->http->method('sendRequest')->willReturn($response);

        // init api
        $api = new Ig_Api_Context($this->http, $this->token);

        // assert
        $this->expectException(Exception::class);
        $api->getIgUserId($pages_id);
    }

    public function testSearchHashtagId()
    {
        $expected = 'this_is_fake_hashtag_id';
        $user_id = 'this_is_fake_user_id';
        $hashtag = 'this_is_fake_hashtag';

        // fake response
        $response = json_decode(
            '{ "data" : [{ "id" : "'
            . $expected
            . '" }] }'
        );

        // set method return
        $this->http->method('sendRequest')->willReturn($response);

        // init api
        $api = new Ig_Api_Context($this->http, $this->token);

        // assert
        $this->assertSame($expected, $api->searchHashtagId($user_id, $hashtag));
    }

    public function testSearchHashtagId_ErrorHandling()
    {
        $user_id = 'this_is_fake_user_id';
        $hashtag = 'this_is_fake_hashtag';

        // fake response
        $response = json_decode(
            '{ "error" : { "message" : "something wrong" } }'
        );

        // set method return
        $this->http->method('sendRequest')->willReturn($response);

        // init api
        $api = new Ig_Api_Context($this->http, $this->token);

        // assert
        $this->expectException(Exception::class);
        $api->searchHashtagId($user_id, $hashtag);
    }

    public function testGetRecentMediasByHashtag()
    {
        $user_id = 'this_is_fake_user_id';
        $hashtag_id = 'this_is_fake_hashtag_id';

        $expected = json_decode(
            '{ "data" : [{'
            . '"media_type" : "this_is_fake_type",'
            . '"media_url" : "this_is_fake_url",'
            . '"permalink" : "this_is_fake_permalink",'
            . '"id" : "this_is_fake_id"'
            . '}] }'
        );

        // fake response
        $response = json_decode(
            '{ "data" : [{'
            . '"media_type": "' . $expected->data[0]->media_type . '",'
            . '"media_url": "' . $expected->data[0]->media_url . '",'
            . '"permalink": "' . $expected->data[0]->permalink . '",'
            . '"id": "' . $expected->data[0]->id . '"'
            . '}] }'
        );

        // set method return
        $this->http->method('sendRequest')->willReturn($response);

        // init api
        $api = new Ig_Api_Context($this->http, $this->token);

        // assert
        $this->assertEquals($expected->data, $api->getRecentMediasByHashtag($user_id, $hashtag_id));
    }

    public function testGetRecentMediasByHashtag_ErrorHandling()
    {
        $user_id = 'this_is_fake_user_id';
        $hashtag_id = 'this_is_fake_hashtag_id';

        // fake response
        $response = json_decode(
            '{ "error" : { "message" : "something wrong" } }'
        );

        // set method return
        $this->http->method('sendRequest')->willReturn($response);

        // init api
        $api = new Ig_Api_Context($this->http, $this->token);

        // assert
        $this->expectException(Exception::class);
        $api->getRecentMediasByHashtag($user_id, $hashtag_id);
    }
}
