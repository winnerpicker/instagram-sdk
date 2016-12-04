<?php

use Winnerpicker\Instagram\Endpoints\RecentMediaEndpoint;

class RecentMediaEndpointTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    function recent_self_user_media()
    {
        $responses = $this->responses('users/self');

        $api = EndpointTestHelper::apiMock(function ($api) use ($responses) {
            $responses->each(function ($response) use ($api) {
                $api->shouldReceive('request')
                    ->with($response->get('url'), [], true)
                    ->andReturn(EndpointTestHelper::toApiResponse($response->get('data')));
            });
        });

        $endpoint = new RecentMediaEndpoint($api);

        $totalCount = 0;

        while ($endpoint->paginate()) {
            $totalCount += count($endpoint->response());
        }

        $this->assertEquals(5, $totalCount);
    }

    /** @test */
    function recent_other_user_media()
    {
        $responses = $this->responses('users/1');

        $api = EndpointTestHelper::apiMock(function ($api) use ($responses) {
            $responses->each(function ($response) use ($api) {
                $api->shouldReceive('request')
                    ->with($response->get('url'), [], true)
                    ->andReturn(EndpointTestHelper::toApiResponse($response->get('data')));
            });
        });

        $endpoint = new RecentMediaEndpoint($api);
        $endpoint->fromUser(1);

        $totalCount = 0;

        while ($endpoint->paginate()) {
            $totalCount += count($endpoint->response());
        }

        $this->assertEquals(5, $totalCount);
    }

    /** @test */
    function recent_tag_media()
    {
        $responses = $this->responses('tags/test');

        $api = EndpointTestHelper::apiMock(function ($api) use ($responses) {
            $responses->each(function ($response) use ($api) {
                $api->shouldReceive('request')
                    ->with($response->get('url'), [], true)
                    ->andReturn(EndpointTestHelper::toApiResponse($response->get('data')));
            });
        });

        $endpoint = new RecentMediaEndpoint($api);
        $endpoint->fromTag('test');

        $totalCount = 0;

        while ($endpoint->paginate()) {
            $totalCount += count($endpoint->response());
        }

        $this->assertEquals(5, $totalCount);
    }

    /** @test */
    function recent_location_media()
    {
        $responses = $this->responses('locations/location-id');

        $api = EndpointTestHelper::apiMock(function ($api) use ($responses) {
            $responses->each(function ($response) use ($api) {
                $api->shouldReceive('request')
                    ->with($response->get('url'), [], true)
                    ->andReturn(EndpointTestHelper::toApiResponse($response->get('data')));
            });
        });

        $endpoint = new RecentMediaEndpoint($api);
        $endpoint->fromLocation('location-id');

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

    protected function responses($urlSource)
    {
        return collect([
            'first' => collect([
                'url' => 'https://api.instagram.com/v1/'.$urlSource.'/media/recent?access_token=api-token&count=100',
                'data' => [
                    'pagination' => [
                        'next_url' => 'https://api.instagram.com/v1/'.$urlSource.'/media/recent?access_token=api-token&count=100&cursor=test-cursor',
                        'next_cursor' => 'test-cursor',
                    ],
                    'meta' => ['code' => 200],
                    'data' => [
                        [
                            'tags' => ['test', 'tag'],
                            'type' => 'image',
                            'id' => 1,
                        ],
                        [
                            'tags' => ['test', 'tag'],
                            'type' => 'image',
                            'id' => 2,
                        ],
                    ],
                ],
            ]),
            'second' => collect([
                'url' => 'https://api.instagram.com/v1/'.$urlSource.'/media/recent?access_token=api-token&count=100&cursor=test-cursor',
                'data' => [
                    'pagination' => [],
                    'meta' => ['code' => 200],
                    'data' => [
                        [
                            'tags' => ['test', 'tag'],
                            'type' => 'image',
                            'id' => 3,
                        ],
                        [
                            'tags' => ['test', 'tag'],
                            'type' => 'image',
                            'id' => 4,
                        ],
                        [
                            'tags' => ['test', 'tag'],
                            'type' => 'image',
                            'id' => 5,
                        ],
                    ],
                ],
            ]),
        ]);
    }
}
