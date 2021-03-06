<?php

namespace Winnerpicker\Instagram\Contracts\Endpoints;

interface RecentMediaEndpointContract
{
    /**
     * Уведомляет класс, что необходимо загружать медиа-объекты
     * со страницы авторизованного или переданного пользователя.
     *
     * @param $userId = 'self'
     *
     * @return \Winnerpicker\Instagram\Contracts\Endpoints\RecentMediaEndpointContract
     */
    public function fromUser($userId = 'self');

    /**
     * Уведомляет класс, что необходимо загружать медиа-объекты
     * по определенному хэштегу.
     *
     * @param string $tag
     *
     * @return \Winnerpicker\Instagram\Contracts\Endpoints\RecentMediaEndpointContract
     */
    public function fromTag(string $tag);

    /**
     * Уведомляет класс, что необходимо загружать медиа-объекты
     * из определенной локации.
     *
     * @param int $locationId
     *
     * @return \Winnerpicker\Instagram\Contracts\Endpoints\RecentMediaEndpointContract
     */
    public function fromLocation($locationId);
}
