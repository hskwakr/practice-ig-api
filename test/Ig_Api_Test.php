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
}
