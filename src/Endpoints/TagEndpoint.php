<?php

namespace Winnerpicker\Instagram\Endpoints;

use Winnerpicker\Instagram\Contracts\EndpointContract;
use Winnerpicker\Instagram\Contracts\Endpoints\TagEndpointContract;
use Winnerpicker\Instagram\SingleEndpoint;
use Winnerpicker\Instagram\Entities\Tag;

class TagEndpoint extends SingleEndpoint implements TagEndpointContract, EndpointContract
{
    /**
     * @var string
     */
    protected $tagName;

    /**
     * Возвращает начальный URL эндпоинта.
     *
     * @return string
     */
    public function endpointUrl(): string
    {
        return '/v1/tags/'.$this->tagName;
    }

    /**
     * Загружает информацию о хэштеге.
     *
     * @param string $tagName
     *
     * @return \Winnerpicker\Instagram\Contracts\Entities\TagContract
     */
    public function getTag(string $tagName)
    {
        $this->tagName = $tagName;

        return new Tag($this->makeRequest());
    }
}
