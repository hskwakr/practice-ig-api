<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/src/Ig_Api_Query.php';

use PHPUnit\Framework\TestCase;

final class Ig_Api_Query_Test extends TestCase
{
    private $api_base_url;
    private $token;
    private $query;

    public function setUp(): void
    {
        // fake api base url
        $this->api_base_url = 'this_is_fake_api_base_url';
        // fake access token
        $this->token = 'this_is_fake_token';

        $this->query = new Ig_Api_Query($this->api_base_url, $this->token);
    }

    public function testGetUserPages()
    {
        $expected = $this->api_base_url . '/me/accounts?access_token=' . $this->token;

        $this->assertSame($expected, $this->query->getUserPages());
    }

    public function testGetIgUser()
    {
        // fake page id
        $page_id = 'this_is_feke_page_id';

        $expected = $this->api_base_url . '/' . $page_id . '?access_token=' . $this->token . '&fields=instagram_business_account';

        $this->assertSame($expected, $this->query->getIgUser($page_id));
    }

    public function testSearchHashtag()
    {
        // fake user id
        $user_id = 'this_is_fake_user_id';
        // fake hashtag
        $hashtag = 'this_is_fake_hashtag';

        $expected = $this->api_base_url . '/ig_hashtag_search?access_token=' . $this->token . '&user_id=' . $user_id . '&q=' . $hashtag;

        $this->assertSame($expected, $this->query->searchHashtag($user_id, $hashtag));
    }

    public function testGetRecentMediasByHashtag()
    {
        // fake user id
        $user_id = 'this_is_fake_user_id';
        // fake hashtag
        $hashtag_id = 'this_is_fake_hashtag_id';

        $expected = $this->api_base_url . '/' . $hashtag_id . '/recent_media?access_token=' . $this->token . '&user_id=' . $user_id . '&fields=media_type,media_url,permalink';

        $this->assertSame($expected, $this->query->getRecentMediasByHashtag($user_id, $hashtag_id));
    }
}
