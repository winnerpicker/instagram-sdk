<?php

namespace Winnerpicker\Instagram\Endpoints;

use Winnerpicker\Instagram\Contracts\EndpointContract;
use Winnerpicker\Instagram\Contracts\Endpoints\RelationshipEndpointContract;
use Winnerpicker\Instagram\Entities\Relationship;
use Winnerpicker\Instagram\SingleEndpoint;

class RelationshipEndpoint extends SingleEndpoint implements RelationshipEndpointContract, EndpointContract
{
    /**
     * @var int
     */
    protected $userId;

    /**
     * Возвращает начальный URL эндпоинта.
     *
     * @return string
     */
    public function endpointUrl(): string
    {
        return '/v1/users/'.$this->userId.'/relationship';
    }

    /**
     * Получает статус взаимоотношений двух пользователей.
     *
     * @param int $userId
     *
     * @return \Winnerpicker\Instagram\Contracts\Entities\RelationshipContract
     */
    public function getStatus(int $userId)
    {
        $this->userId = $userId;

        $responseData = $this->makeRequest();

        return new Relationship($responseData);
    }
}
