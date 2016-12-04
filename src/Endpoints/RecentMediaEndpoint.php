<?php

namespace Winnerpicker\Instagram\Endpoints;

use Winnerpicker\Instagram\Contracts\EndpointContract;
use Winnerpicker\Instagram\Contracts\Endpoints\RecentMediaEndpointContract;
use Winnerpicker\Instagram\PaginationEndpoint;

class RecentMediaEndpoint extends PaginationEndpoint implements RecentMediaEndpointContract, EndpointContract
{
    /**
     * @var string
     */
    protected $loadFrom = 'user';

    /**
     * @var string
     */
    protected $userId = 'self';

    /**
     * @var string
     */
    protected $tag;

    /**
     * @var int
     */
    protected $locationId;

    /**
     * Возвращает начальный URL эндпоинта.
     *
     * @return string
     */
    public function endpointUrl(): string
    {
        $baseUrl = 'https://api.instagram.com/v1/';

        switch ($this->loadFrom) {
            case 'user':
                $baseUrl .= 'users/'.$this->userId;
                break;
            case 'tag':
                $baseUrl .= 'tags/'.$this->tag;
                break;
            case 'location':
                $baseUrl .= 'locations/'.$this->locationId;
                break;
        }

        $baseUrl .= '/media/recent?access_token='.$this->api->token().'&count=100';

        return $baseUrl;
    }

    /**
     * Уведомляет класс, что необходимо загружать медиа-объекты
     * со страницы авторизованного или переданного пользователя.
     *
     * @param $userId = 'self'
     *
     * @return \Winnerpicker\Instagram\Contracts\Endpoints\RecentMediaEndpointContract
     */
    public function fromUser($userId = 'self')
    {
        $this->loadFrom = 'user';
        $this->userId = $userId;
        $this->url = $this->endpointUrl();

        return $this;
    }

    /**
     * Уведомляет класс, что необходимо загружать медиа-объекты
     * по определенному хэштегу.
     *
     * @param string $tag
     *
     * @return \Winnerpicker\Instagram\Contracts\Endpoints\RecentMediaEndpointContract
     */
    public function fromTag(string $tag)
    {
        $this->loadFrom = 'tag';
        $this->tag = $tag;
        $this->url = $this->endpointUrl();

        return $this;
    }

    /**
     * Уведомляет класс, что необходимо загружать медиа-объекты
     * из определенной локации.
     *
     * @param int $locationId
     *
     * @return \Winnerpicker\Instagram\Contracts\Endpoints\RecentMediaEndpointContract
     */
    public function fromLocation($locationId)
    {
        $this->loadFrom = 'location';
        $this->locationId = $locationId;
        $this->url = $this->endpointUrl();

        return $this;
    }
}
