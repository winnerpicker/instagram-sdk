<?php

use Winnerpicker\Instagram\Endpoints\FollowedByEndpoint;

class FollowedByEndpointTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    function endpoint()
    {
        $responses = $this->responses();

        $api = EndpointTestHelper::apiMock(function ($api) use ($responses) {
            $firstResponse = $responses->get('first');
            $secondResponse = $responses->get('second');

            $api->shouldReceive('request')
                ->with($firstResponse->get('url'), [], true)
                ->andReturn(EndpointTestHelper::toApiResponse($firstResponse->get('data')));

            $api->shouldReceive('request')
                ->with($secondResponse->get('url'), [], true)
                ->andReturn(EndpointTestHelper::toApiResponse($secondResponse->get('data')));
        });

        $endpoint = new FollowedByEndpoint($api);
        $totalCount = 0;

        while ($endpoint->paginate()) {
            $totalCount += count($endpoint->response());
        }

        $this->assertEquals(5, $totalCount);
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    protected function responses()
    {
        return collect([
            'first' => collect([
                'url' => 'https://api.instagram.com/v1/users/self/followed-by?access_token=api-token&count=100',
                'data' => [
                    'pagination' => [
                        'next_url' => 'https://api.instagram.com/v1/users/self/followed-by?access_token=api-token&count=100&cursor=test-cursor',
                        'next_cursor' => 'test-cursor',
                    ],
                    'meta' => ['code' => 200],
                    'data' => [
                        [
                            'id' => 1,
                            'username' => 'user1',
                        ],
                        [
                            'id' => 2,
                            'username' => 'user2',
                        ],
                        [
                            'id' => 3,
                            'username' => 'user3',
                        ],
                    ],
                ],
            ]),

            'second' => collect([
                'url' => 'https://api.instagram.com/v1/users/self/followed-by?access_token=api-token&count=100&cursor=test-cursor',
                'data' => [
                    'pagination' => [],
                    'meta' => ['code' => 200],
                    'data' => [
                        [
                            'id' => 4,
                            'username' => 'user4',
                        ],
                        [
                            'id' => 5,
                            'username' => 'user5',
                        ],
                    ],
                ],
            ]),
        ]);
    }
}
