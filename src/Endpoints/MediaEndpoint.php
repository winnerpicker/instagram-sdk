<?php

namespace Winnerpicker\Instagram\Endpoints;

use Winnerpicker\Instagram\Contracts\EndpointContract;
use Winnerpicker\Instagram\Contracts\Endpoints\MediaEndpointContract;
use Winnerpicker\Instagram\Media;
use Winnerpicker\Instagram\SingleEndpoint;

class MediaEndpoint extends SingleEndpoint implements MediaEndpointContract, EndpointContract
{
    /**
     * @var int
     */
    protected $mediaId;

    /**
     * Возвращает начальный URL эндпоинта.
     *
     * @return string
     */
    public function endpointUrl(): string
    {
        return '/v1/media/'.$this->mediaId;
    }

    /**
     * Возвращает медиа-объект по его ID.
     *
     * @param int $id
     *
     * @return \Winnerpicker\Instagram\Contracts\MediaContract
     */
    public function getById($id)
    {
        $this->mediaId = $id;

        $response = $this->makeRequest();

        return new Media(array_get($response, 'data', []));
    }
}
