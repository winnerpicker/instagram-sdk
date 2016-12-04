<?php

use Winnerpicker\Instagram\Endpoints\RelationshipEndpoint;

class RelationshipEndpointTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    function endpoint()
    {
        $responses = $this->responses();

        $api = EndpointTestHelper::apiMock(function ($api) use ($responses) {
            $responses->each(function ($response) use ($api) {
                $api->shouldReceive('request')
                    ->with($response->get('url'))
                    ->andReturn($response->get('data'));
            });
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

    protected function tearDown()
    {
        Mockery::close();
    }

    protected function responses()
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
}
