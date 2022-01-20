<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/src/Ig_Api_Query.php';
require_once dirname(__DIR__) . '/src/Http_Client.php';

use PHPUnit\Framework\TestCase;

final class Ig_Api_Query_Test extends TestCase
{
    public function setUp(): void
    {
    }

    public function testGetUserPages()
    {
        // fake http
        $http = $this->createStub(Http_Client::class);
        // fake access token
        $token = 'this_is_fake_token';

        $api = new Ig_Api_Query($http, $token);

        $expected = 'https://graph.facebook.com/v12.0/me/accounts?access_token=' . $token;

        $this->assertSame($expected, $api->getUserPages());
    }

    public function testGetIgUser()
    {
        // fake http
        $http = $this->createStub(Http_Client::class);
        // fake access token
        $token = 'this_is_fake_token';
        // fake page id
        $page_id = 'this_is_feke_page_id';

        $api = new Ig_Api_Query($http, $token);

        $expected = 'https://graph.facebook.com/v12.0/' . $page_id . '?access_token=' . $token . '&fields=instagram_business_account';

        $this->assertSame($expected, $api->getIgUser($page_id));
    }

    public function testSearchHashtag()
    {
        // fake http
        $http = $this->createStub(Http_Client::class);
        // fake access token
        $token = 'this_is_fake_token';
        // fake user id
        $user_id = 'this_is_fake_user_id';
        // fake hashtag
        $hashtag = 'this_is_fake_hashtag';

        $api = new Ig_Api_Query($http, $token);

        $expected = 'https://graph.facebook.com/v12.0/ig_hashtag_search?access_token=' . $token . '&user_id=' . $user_id . '&q=' . $hashtag;

        $this->assertSame($expected, $api->searchHashtag($user_id, $hashtag));
    }

    public function testGetRecentMediasByHashtag()
    {
        // fake http
        $http = $this->createStub(Http_Client::class);
        // fake access token
        $token = 'this_is_fake_token';
        // fake user id
        $user_id = 'this_is_fake_user_id';
        // fake hashtag
        $hashtag_id = 'this_is_fake_hashtag_id';

        $api = new Ig_Api_Query($http, $token);

        $expected = 'https://graph.facebook.com/v12.0/' . $hashtag_id . '/recent_media?access_token=' . $token . '&user_id=' . $user_id . '&fields=media_type,media_url,permalink';

        $this->assertSame($expected, $api->getRecentMediasByHashtag($user_id, $hashtag_id));
    }
}
