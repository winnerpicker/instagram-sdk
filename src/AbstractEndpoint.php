<?php

namespace Winnerpicker\Instagram;

use Winnerpicker\Instagram\Contracts\Api\ApiProviderContract;

abstract class AbstractEndpoint
{
    /**
     * @var \Winnerpicker\Instagram\Contracts\Api\ApiProviderContract
     */
    protected $api;

    /**
     * @var array
     */
    protected $response;

    /**
     * @var string
     */
    protected $url;

    /**
     * @param \Winnerpicker\Instagram\Contracts\Api\ApiProviderContract $api
     */
    public function __construct(ApiProviderContract $api)
    {
        $this->api = $api;
        $this->url = $this->endpointUrl();
    }
}
