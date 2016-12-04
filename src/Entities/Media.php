<?php

namespace Winnerpicker\Instagram\Entities;

use Winnerpicker\Instagram\Contracts\Entities\MediaContract;

class Media implements MediaContract
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращает ID медиа-объекта.
     *
     * @return string
     */
    public function id()
    {
        return array_get($this->data, 'id');
    }

    /**
     * Возвращает URL медиа-объекта.
     *
     * @return string
     */
    public function link(): string
    {
        return array_get($this->data, 'link', '');
    }

    /**
     * Возвращает URL изображения средних размеров.
     *
     * @return string
     */
    public function lowResolutionUrl(): string
    {
        return array_get($this->data, 'images.low_resolution.url');
    }

    /**
     * Возвращает авторский комментарий (описание) к медиа-объекту.
     *
     * @return string
     */
    public function captionText(): string
    {
        return array_get($this->data, 'caption.text');
    }

    /**
     * Возвращает количество хэштегов, прикрепленных к данному медиа-объекту.
     *
     * @return int
     */
    public function tagsCount(): int
    {
        return count(array_get($this->data, 'tags', []));
    }
}
