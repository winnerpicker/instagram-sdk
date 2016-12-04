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
    protected $tag;

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
                $baseUrl .= 'users/self';
                break;
            case 'tag':
                $baseUrl .= 'tags/'.$this->tag;
                break;
        }

        $baseUrl .= '/media/recent?access_token='.$this->api->token().'&count=100';

        return $baseUrl;
    }

    /**
     * Уведомляет класс, что необходимо загружать медиа-объекты
     * со страницы авторизованного пользователя.
     *
     * @return \Winnerpicker\Instagram\Contracts\Endpoints\RecentMediaEndpointContract
     */
    public function fromUser()
    {
        $this->loadFrom = 'user';

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

        return $this;
    }
}
