<?php

use Winnerpicker\Instagram\Endpoints\MediaEndpoint;

class MediaEndpointTest extends PHPUnit_Framework_TestCase
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

        $endpoint = new MediaEndpoint($api);

        $image = $endpoint->getById(1);

        $this->assertEquals(1, $image->id());
        $this->assertEquals('https://example.org/1_2_3_n.jpg?ig_cache_key=test-cache-key', $image->lowResolutionUrl());
        $this->assertEquals('Test Image with tags #test #tag', $image->captionText());
        $this->assertEquals(2, $image->tagsCount());
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    protected function responses()
    {
        return collect([
            'image' => collect([
                'url' => '/v1/media/1',
                'data' => [
                    'meta' => ['code' => 200],
                    'data' => [
                        'tags' => ['test', 'tag'],
                        'type' => 'image',
                        'comments' => ['count' => 0],
                        'filter' => 'Normal',
                        'likes' => ['count' => 1],
                        'images' => [
                            'low_resolution' => [
                                'url' => 'https://example.org/1_2_3_n.jpg?ig_cache_key=test-cache-key',
                                'width' => 320,
                                'height' => 320,
                            ],
                            'thumbnail' => [
                                'url' => 'https://example.org/4_5_6_n.jpg?ig_cache_key=test-cache-key',
                                'width' => 150,
                                'height' => 150,
                            ],
                            'standard_resolution' => [
                                'url' => 'https://example.org/7_8_9_n.jpg?ig_cache_key=test-cache-key',
                                'width' => 640,
                                'height' => 640,
                            ],
                        ],
                        'users_in_photo' => [],
                        'caption' => [
                            'created_time' => 1,
                            'text' => 'Test Image with tags #test #tag',
                            'from' => [
                                'username' => 'user1',
                                'id' => 1,
                            ],
                        ],
                        'id' => 1,
                        'user' => [
                            'username' => 'user1',
                            'id' => 1,
                        ],
                    ],
                ],
            ]),
        ]);
    }
}
