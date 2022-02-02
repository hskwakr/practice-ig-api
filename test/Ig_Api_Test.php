<?php

declare(strict_types=1);

namespace Ig_Api;

require_once dirname(__DIR__) . '/src/Ig_Api/Ig_Api.php';
require_once dirname(__DIR__) . '/src/Ig_Api/Ig_Api_Context.php';

use Exception;
use PHPUnit\Framework\TestCase;
use Ig_Api\Ig_Api_Context;

final class Ig_Api_Test extends TestCase
{
    private $token;
    private $ctx;

    public function setUp(): void
    {
        // fake access token
        $this->token = 'this_is_fake_token';

        // mock
        $this->ctx = $this->createMock(Ig_Api_Context::class);
    }

    public function testInit()
    {
        $pages_id = 'this_is_fake_pages_id';
        $user_id = 'this_is_fake_user_id';

        // set method return
        $this->ctx
             ->method('getUserPagesId')
             ->willReturn($pages_id);

        $this->ctx
             ->method('getIgUserId')
             ->willReturn($user_id);

        // init api
        $api = new Ig_Api($this->token);
        $api = $api->setContext($this->ctx);

        // assert
        $this->assertSame(
            $pages_id,
            $api->init()
                ->pages_id
        );
        $this->assertSame(
            $user_id,
            $api->init()
                ->user_id
        );
    }

    public function testSearchHashtag()
    {
        $name = 'this_is_fake_name';
        $hashtag_id = 'this_is_fake_hashtag_id';
        $recent_medias = json_decode(
            '[{'
            . '"media_type" : "this_is_fake_type",'
            . '"media_url" : "this_is_fake_url",'
            . '"permalink" : "this_is_fake_permalink",'
            . '"id" : "this_is_fake_id"'
            . '}]'
        );

        // set method return
        $this->ctx
             ->method('searchHashtagId')
             ->willReturn($hashtag_id);

        $this->ctx
             ->method('getRecentMediasByHashtag')
             ->willReturn($recent_medias);

        // init api
        $api = new Ig_Api($this->token);
        $api = $api->setContext($this->ctx);

        // assert
        $this->assertSame(
            $hashtag_id,
            $api->init()
                ->searchHashtag($name)
                ->hashtag_id
        );

        $this->assertEquals(
            $recent_medias,
            $api->init()
                ->searchHashtag($name)
                ->recent_medias
        );
    }

    public function testInit_ErrorHandling_PagesId()
    {
        $this->ctx
             ->method('getIgUserId')
             ->will($this->throwException(new Exception()));

        // init api
        $api = new Ig_Api($this->token);
        $api = $api->setContext($this->ctx);

        // assert
        $this->expectException(Exception::class);
        $api->init();
    }

    public function testInit_ErrorHandling_UserId()
    {
        $this->ctx
             ->method('getIgUserId')
             ->will($this->throwException(new Exception()));

        // init api
        $api = new Ig_Api($this->token);
        $api = $api->setContext($this->ctx);

        // assert
        $this->expectException(Exception::class);
        $api->init();
    }

    public function testSearchHashtag_ErrorHandling_Init()
    {
        $name = 'this_is_fake_name';

        $this->ctx
             ->method('getIgUserId')
             ->will($this->throwException(new Exception()));

        // init api
        $api = new Ig_Api($this->token);
        $api = $api->setContext($this->ctx);

        // assert
        $this->expectException(Exception::class);
        $api->init()->searchHashtag($name);
    }

    public function testSearchHashtag_ErrorHandling_HashtagId()
    {
        $name = 'this_is_fake_name';
        $this->ctx
             ->method('searchHashtagId')
             ->will($this->throwException(new Exception()));

        // init api
        $api = new Ig_Api($this->token);
        $api = $api->setContext($this->ctx);

        // assert
        $this->expectException(Exception::class);
        $api->init()->searchHashtag($name);
    }

    public function testSearchHashtag_ErrorHandling_Medias()
    {
        $name = 'this_is_fake_name';
        $this->ctx
             ->method('getRecentMediasByHashtag')
             ->will($this->throwException(new Exception()));

        // init api
        $api = new Ig_Api($this->token);
        $api = $api->setContext($this->ctx);

        // assert
        $this->expectException(Exception::class);
        $api->init()->searchHashtag($name);
    }
}
