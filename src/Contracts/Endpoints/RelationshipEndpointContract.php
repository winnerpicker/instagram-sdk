<?php

namespace Winnerpicker\Instagram\Contracts\Endpoints;

interface RelationshipEndpointContract
{
    /**
     * Получает статус взаимоотношений двух пользователей.
     *
     * @param int $userId
     *
     * @return \Winnerpicker\Instagram\Contracts\RelationshipStatusContract
     */
    public function getStatus(int $userId);
}
