<?php

namespace Winnerpicker\Instagram\Endpoints;

use Winnerpicker\Instagram\Contracts\EndpointContract;
use Winnerpicker\Instagram\Contracts\Endpoints\MediaEndpointContract;
use Winnerpicker\Instagram\Entities\Media;
use Winnerpicker\Instagram\SingleEndpoint;

class MediaEndpoint extends SingleEndpoint implements MediaEndpointContract, EndpointContract
{
    /**
     * @var string
     */
    protected $loadFrom = 'id';

    /**
     * @var int
     */
    protected $mediaId;

    /**
     * @var string
     */
    protected $shortcode;

    /**
     * Возвращает начальный URL эндпоинта.
     *
     * @return string
     */
    public function endpointUrl(): string
    {
        switch ($this->loadFrom) {
            case 'id':
                return '/v1/media/'.$this->mediaId;
            case 'shortcode':
                return '/v1/media/shortcode/'.$this->shortcode;
        }
    }

    /**
     * Возвращает медиа-объект по его ID.
     *
     * @param int $id
     *
     * @return \Winnerpicker\Instagram\Contracts\Entities\MediaContract
     */
    public function getById($id)
    {
        $this->loadFrom = 'id';
        $this->mediaId = $id;

        return new Media($this->makeRequest());
    }

    /**
     * Возвращает медиа-объект по его ключу.
     *
     * @param string $shortcode
     *
     * @return \Winnerpicker\Instagram\Contracts\Entities\MediaContract
     */
    public function getByShortcode(string $shortcode)
    {
        $this->loadFrom = 'shortcode';
        $this->shortcode = $shortcode;

        return new Media($this->makeRequest());
    }
}
