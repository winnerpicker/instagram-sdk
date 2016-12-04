<?php

namespace Winnerpicker\Instagram\Endpoints;

use Winnerpicker\Instagram\Contracts\Endpoints\FollowedByEndpointContract;
use Winnerpicker\Instagram\PaginationEndpoint;

class FollowedByEndpoint extends PaginationEndpoint implements FollowedByEndpointContract
{
    /**
     * Возвращает начальный URL эндпоинта.
     *
     * @return string
     */
    public function endpointUrl(): string
    {
        return 'https://api.instagram.com/v1/users/self/followed-by?access_token='.$this->api->token().'&count=100';
    }
}
