<?php

namespace Winnerpicker\Instagram\Contracts\Endpoints;

interface TagEndpointContract
{
    /**
     * Загружает информацию о хэштеге.
     *
     * @param string $tagName
     *
     * @return \Winnerpicker\Instagram\Contracts\TagContract
     */
    public function getTag(string $tagName);
}
