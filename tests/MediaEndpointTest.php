<?php

use Winnerpicker\Instagram\Endpoints\MediaEndpoint;

class MediaEndpointTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    function media_by_id()
    {
        $responses = $this->responses('1');

        $api = EndpointTestHelper::apiMock(function ($api) use ($responses) {
            $responses->each(function ($response) use ($api) {
                $api->shouldReceive('request')
                    ->with($response->get('url'))
                    ->andReturn(EndpointTestHelper::toApiResponse($response->get('data')));
            });
        });

        $endpoint = new MediaEndpoint($api);

        $image = $endpoint->getById(1);

        $this->assertEquals(1, $image->id());
        $this->assertEquals('https://example.org/1_2_3_n.jpg?ig_cache_key=test-cache-key', $image->lowResolutionUrl());
        $this->assertEquals('Test Image with tags #test #tag', $image->captionText());
        $this->assertEquals(2, $image->tagsCount());
        $this->assertEquals('https://www.instagram.com/shortcode', $image->link());
    }

    /** @test */
    function media_by_shortcode()
    {
        $responses = $this->responses('shortcode/shortcode');

        $api = EndpointTestHelper::apiMock(function ($api) use ($responses) {
            $responses->each(function ($response) use ($api) {
                $api->shouldReceive('request')
                    ->with($response->get('url'))
                    ->andReturn(EndpointTestHelper::toApiResponse($response->get('data')));
            });
        });

        $endpoint = new MediaEndpoint($api);

        $image = $endpoint->getByShortcode('shortcode');

        $this->assertEquals(1, $image->id());
        $this->assertEquals('https://example.org/1_2_3_n.jpg?ig_cache_key=test-cache-key', $image->lowResolutionUrl());
        $this->assertEquals('Test Image with tags #test #tag', $image->captionText());
        $this->assertEquals(2, $image->tagsCount());
        $this->assertEquals('https://www.instagram.com/shortcode', $image->link());
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    protected function responses($urlSuffix)
    {
        return collect([
            'image' => collect([
                'url' => '/v1/media/'.$urlSuffix,
                'data' => [
                    'meta' => ['code' => 200],
                    'data' => [
                        'tags' => ['test', 'tag'],
                        'type' => 'image',
                        'comments' => ['count' => 0],
                        'filter' => 'Normal',
                        'link' => 'https://www.instagram.com/shortcode',
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
