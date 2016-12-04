<?php

use Psr\Log\LoggerInterface;
use Winnerpicker\Instagram\ApiProvider;
use Winnerpicker\Instagram\InstagramUser;

class EndpointTestHelper
{
    public static function fakeUser()
    {
        return new InstagramUser(1, 'api-token');
    }

    public static function loggerMock()
    {
        return Mockery::mock(LoggerInterface::class);
    }

    public static function apiMock($mockMethods = null, $callback = null)
    {
        if ($mockMethods instanceof Closure) {
            $callback = $mockMethods;
            $mockMethods = null;
        }

        if (is_null($mockMethods)) {
            $mockMethods = ['request'];
        }

        $mock = Mockery::mock(ApiProvider::class.'['.implode(',', $mockMethods).']', [
            static::fakeUser()->token(),
            static::loggerMock(),
        ]);

        $callback($mock);

        return $mock;
    }
}
