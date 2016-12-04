<?php

use Psr\Log\LoggerInterface;
use Winnerpicker\Instagram\Api\ApiProvider;
use Winnerpicker\Instagram\Api\ApiResponse;
use Winnerpicker\Instagram\Entities\User;

class EndpointTestHelper
{
    public static function fakeUser()
    {
        return new User(1, 'api-token');
    }

    public static function loggerMock()
    {
        return Mockery::mock(LoggerInterface::class);
    }

    public static function toApiResponse(array $data, int $rateLimit = 5000, int $rateLimitRemaining = 5000)
    {
        $response = new ApiResponse($rateLimit, $rateLimitRemaining);

        return $response->setResponseData($data);
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
