<?php

namespace Winnerpicker\Instagram\Contracts\Endpoints;

interface MediaEndpointContract
{
    /**
     * Возвращает медиа-объект по его ID.
     *
     * @param int $id
     *
     * @return \Winnerpicker\Instagram\Contracts\MediaContract
     */
    public function getById($id);

    /**
     * Возвращает медиа-объект по его ключу.
     *
     * @param string $shortcode
     *
     * @return \Winnerpicker\Instagram\Contracts\MediaContract
     */
    public function getByShortcode(string $shortcode);
}
