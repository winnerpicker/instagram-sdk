<?php

use Winnerpicker\Instagram\Endpoints\TagEndpoint;

class TagEndpointTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    function endpoint()
    {
        $response = $this->response();

        $api = EndpointTestHelper::apiMock(function ($api) use ($response) {
            $api->shouldReceive('request')
                ->with($response->get('url'))
                ->andReturn(EndpointTestHelper::toApiResponse($response->get('data')));
        });

        $endpoint = new TagEndpoint($api);

        $tag = $endpoint->getTag('test');

        $this->assertEquals(200, $tag->mediaCount());
        $this->assertEquals('test', $tag->name());
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    protected function response()
    {
        return collect([
            'url' => '/v1/tags/test',
            'data' => [
                'meta' => ['code' => 200],
                'data' => [
                    'media_count' => 200,
                    'name' => 'test',
                ],
            ],
        ]);
    }
}
