<?php

use Psr\Log\LoggerInterface;
use Winnerpicker\Instagram\ApiProvider;
use Winnerpicker\Instagram\Endpoints\FollowedByEndpoint;
use Winnerpicker\Instagram\Endpoints\RelationshipEndpoint;
use Winnerpicker\Instagram\InstagramUser;

class InstagramEndpointsTest extends PHPUnit_Framework_TestCase
{
    /** @test*/
    function followed_by_endpoint()
    {
        $userId = 1;
        $user = new InstagramUser($userId, 'api-token');

        $responses = $this->paginationTestData();
        $firstResponse = $responses->get('first');
        $secondResponse = $responses->get('second');

        $api = Mockery::mock(ApiProvider::class.'[request]', [
            $user->token(),
            $this->loggerMock(),
        ]);

        $api->shouldReceive('request')
            ->with($firstResponse->get('url'), [], true)
            ->andReturn($firstResponse->get('data'));

        $api->shouldReceive('request')
            ->with($secondResponse->get('url'), [], true)
            ->andReturn($secondResponse->get('data'));

        $endpoint = new FollowedByEndpoint($api);
        $totalCount = 0;

        while ($endpoint->paginate()) {
            $totalCount += count($endpoint->response());
        }

        $this->assertEquals(5, $totalCount);
    }

    /** @test */
    function relationship_endpoint()
    {
        $userId = 1;
        $user = new InstagramUser($userId, 'api-token');
        $responses = $this->relationshipTestData();

        $api = Mockery::mock(ApiProvider::class.'[request]', [
            $user->token(),
            $this->loggerMock(),
        ]);

        $responses->each(function ($response) use ($api) {
            $api->shouldReceive('request')
                ->with($response->get('url'))
                ->andReturn($response->get('data'));
        });

        $endpoint = new RelationshipEndpoint($api);

        $first = $endpoint->getStatus('2');
        $second = $endpoint->getStatus('3');
        $third = $endpoint->getStatus('4');
        $fourth = $endpoint->getStatus('5');

        $this->assertFalse($first->following());
        $this->assertTrue($first->followedBy());

        $this->assertTrue($second->following());
        $this->assertFalse($second->followedBy());

        $this->assertTrue($third->following());
        $this->assertTrue($third->followedBy());

        $this->assertFalse($fourth->following());
        $this->assertFalse($fourth->followedBy());
    }

    public function loggerMock()
    {
        return Mockery::mock(LoggerInterface::class);
    }

    public function relationshipTestData()
    {
        return collect([
            'first' => collect([
                'url' => '/v1/users/2/relationship',
                'data' => [
                    'meta' => ['code' => 200],
                    'data' => [
                        'outgoing_status' => 'none',
                        'target_user_is_private' => false,
                        'incoming_status' => 'followed_by',
                    ],
                ],
            ]),
            'second' => collect([
                'url' => '/v1/users/3/relationship',
                'data' => [
                    'meta' => ['code' => 200],
                    'data' => [
                        'outgoing_status' => 'follows',
                        'target_user_is_private' => false,
                        'incoming_status' => 'none',
                    ],
                ],
            ]),
            'third' => collect([
                'url' => '/v1/users/4/relationship',
                'data' => [
                    'meta' => ['code' => 200],
                    'data' => [
                        'outgoing_status' => 'follows',
                        'target_user_is_private' => false,
                        'incoming_status' => 'followed_by',
                    ],
                ],
            ]),
            'fourth' => collect([
                'url' => '/v1/users/5/relationship',
                'data' => [
                    'meta' => ['code' => 200],
                    'data' => [
                        'outgoing_status' => 'none',
                        'target_user_is_private' => false,
                        'incoming_status' => 'none',
                    ],
                ],
            ]),
        ]);
    }

    public function paginationTestData()
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