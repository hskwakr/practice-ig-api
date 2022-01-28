<?php

declare(strict_types=1);

namespace Ig_Api;

require_once dirname(__DIR__) . '/src/Ig_Api/Ig_Api.php';
require_once dirname(__DIR__) . '/src/Ig_Api/Ig_Api_Context.php';

use PHPUnit\Framework\TestCase;
use Ig_Api\Ig_Api_Context;

final class Ig_Api_Test extends TestCase
{
    private $token;

    public function setUp(): void
    {
        // fake access token
        $this->token = 'this_is_fake_token';
    }

    public function testInit()
    {
        $pages_id = 'this_is_fake_pages_id';
        $user_id = 'this_is_fake_user_id';

        $ctx = $this->createMock(Ig_Api_Context::class);

        // set method return
        $ctx->method('getUserPagesId')->willReturn($pages_id);
        $ctx->method('getIgUserId')->willReturn($user_id);

        // init api
        $api = new Ig_Api($this->token);
        $api = $api->setContext($ctx);

        // assert
        $this->assertSame($pages_id, $api->init()->pages_id);
        $this->assertSame($user_id, $api->init()->user_id);
    }
}
